<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    public function index(Request $request)
    {
        // Lấy bộ lọc thời gian từ request
        $filter = $request->query('filter', 'day');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        // Xử lý date range
        if ($startDate && $endDate) {
            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();
        } else {
            // Default date ranges
            if ($filter === 'day') {
                $startDate = now()->startOfDay();
                $endDate = now()->endOfDay();
            } elseif ($filter === 'week') {
                $startDate = now()->startOfWeek();
                $endDate = now()->endOfWeek();
            } elseif ($filter === 'month') {
                $startDate = now()->startOfMonth();
                $endDate = now()->endOfMonth();
            } else {
                $startDate = now()->subDays(7)->startOfDay();
                $endDate = now()->endOfDay();
            }
        }

        // Xác định format dựa trên khoảng thời gian
        $daysDiff = $startDate->diffInDays($endDate);

        if ($daysDiff == 0) {
            // Nếu cùng ngày, hiển thị theo giờ
            $revenueData = $this->getHourlyRevenue($startDate, $endDate);
        } elseif ($daysDiff <= 31) {
            // Nếu <= 31 ngày, hiển thị theo ngày
            $revenueData = $this->getDailyRevenue($startDate, $endDate);
        } elseif ($daysDiff <= 365) {
            // Nếu <= 365 ngày, hiển thị theo tuần
            $revenueData = $this->getWeeklyRevenue($startDate, $endDate);
        } else {
            // Nếu > 365 ngày, hiển thị theo tháng
            $revenueData = $this->getMonthlyRevenue($startDate, $endDate);
        }

        // Top 5 khóa học bán chạy trong khoảng thời gian
        $topCourses = $this->getTopCourses($startDate, $endDate);

        // Top 5 khách hàng mua nhiều nhất
        $topCustomers = $this->getTopCustomers($startDate, $endDate);

        // Thống kê tổng quan
        $totalRevenue = Payment::where('status', 'completed')
            ->whereBetween('paid_at', [$startDate, $endDate])
            ->sum('final_amount');

        $totalOrders = Payment::where('status', 'completed')
            ->whereBetween('paid_at', [$startDate, $endDate])
            ->count();

        $totalStudents = Enrollment::whereBetween('enrolled_at', [$startDate, $endDate])
            ->distinct('student_id')
            ->count();

        $additionalStats = [
            'total_revenue' => $totalRevenue,
            'total_orders' => $totalOrders,
            'total_students' => $totalStudents,
            'average_order' => $totalOrders > 0 ? $totalRevenue / $totalOrders : 0,
        ];

        return view('admin.statistics', compact(
            'revenueData',
            'topCourses',
            'topCustomers',
            'filter',
            'additionalStats',
            'startDate',
            'endDate'
        ));
    }

    private function getHourlyRevenue($startDate, $endDate)
    {
        $revenues = Payment::select(
            DB::raw("HOUR(paid_at) as hour"),
            DB::raw('SUM(final_amount) as total_revenue')
        )
            ->where('status', 'completed')
            ->whereBetween('paid_at', [$startDate, $endDate])
            ->groupBy('hour')
            ->orderBy('hour')
            ->get()
            ->keyBy('hour');

        $result = [];
        for ($hour = 0; $hour < 24; $hour++) {
            $result[] = [
                'date' => sprintf('%02d:00', $hour),
                'total_revenue' => $revenues->get($hour)->total_revenue ?? 0,
            ];
        }

        return collect($result);
    }

    private function getDailyRevenue($startDate, $endDate)
    {
        $revenues = Payment::select(
            DB::raw("DATE(paid_at) as date"),
            DB::raw('SUM(final_amount) as total_revenue')
        )
            ->where('status', 'completed')
            ->whereBetween('paid_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $result = [];
        $current = $startDate->copy();

        while ($current->lte($endDate)) {
            $dateKey = $current->format('Y-m-d');
            $result[] = [
                'date' => $current->format('d/m'),
                'total_revenue' => $revenues->get($dateKey)->total_revenue ?? 0,
            ];
            $current->addDay();
        }

        return collect($result);
    }

    private function getWeeklyRevenue($startDate, $endDate)
    {
        $revenues = Payment::select(
            DB::raw("YEARWEEK(paid_at, 1) as week"),
            DB::raw('SUM(final_amount) as total_revenue')
        )
            ->where('status', 'completed')
            ->whereBetween('paid_at', [$startDate, $endDate])
            ->groupBy('week')
            ->orderBy('week')
            ->get()
            ->keyBy('week');

        $result = [];
        $current = $startDate->copy()->startOfWeek();

        while ($current->lt($endDate)) {
            $weekKey = $current->format('oW');
            $result[] = [
                'date' => 'Tuần ' . $current->format('W/Y'),
                'total_revenue' => $revenues->get($weekKey)->total_revenue ?? 0,
            ];
            $current->addWeek();
        }

        return collect($result);
    }

    private function getMonthlyRevenue($startDate, $endDate)
    {
        $revenues = Payment::select(
            DB::raw("DATE_FORMAT(paid_at, '%Y-%m') as month"),
            DB::raw('SUM(final_amount) as total_revenue')
        )
            ->where('status', 'completed')
            ->whereBetween('paid_at', [$startDate, $endDate])
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        $result = [];
        $current = $startDate->copy()->startOfMonth();

        while ($current->lt($endDate)) {
            $monthKey = $current->format('Y-m');
            $result[] = [
                'date' => $current->format('m/Y'),
                'total_revenue' => $revenues->get($monthKey)->total_revenue ?? 0,
            ];
            $current->addMonth();
        }

        return collect($result);
    }

    private function getTopCourses($startDate, $endDate)
    {
        return Course::select(
            'courses.id',
            'courses.title',
            'courses.thumbnail',
            'courses.price',
            'courses.discount_price',
            'courses.is_free',
            'courses.category_id',
            DB::raw('COUNT(enrollments.id) as enrollment_count'),
            DB::raw('SUM(payments.final_amount) as total_revenue')
        )
            ->leftJoin('enrollments', 'courses.id', '=', 'enrollments.course_id')
            ->leftJoin('payments', function($join) use ($startDate, $endDate) {
                $join->on('courses.id', '=', 'payments.course_id')
                    ->where('payments.status', 'completed')
                    ->whereBetween('payments.paid_at', [$startDate, $endDate]);
            })
            ->whereBetween('enrollments.enrolled_at', [$startDate, $endDate])
            ->where('enrollments.status', 'active')
            ->groupBy(
                'courses.id',
                'courses.title',
                'courses.thumbnail',
                'courses.price',
                'courses.discount_price',
                'courses.is_free',
                'courses.category_id'
            )
            ->orderByDesc('enrollment_count')
            ->take(5)
            ->with('category')
            ->get();
    }

    private function getTopCustomers($startDate, $endDate)
    {
        return User::select(
            'users.id',
            'users.name',
            'users.email',
            'users.avatar',
            DB::raw('COUNT(payments.id) as total_orders'),
            DB::raw('SUM(payments.final_amount) as total_spent'),
            DB::raw('COUNT(DISTINCT payments.course_id) as courses_purchased')
        )
            ->join('payments', 'users.id', '=', 'payments.student_id')
            ->where('payments.status', 'completed')
            ->whereBetween('payments.paid_at', [$startDate, $endDate])
            ->groupBy('users.id', 'users.name', 'users.email', 'users.avatar')
            ->orderByDesc('total_spent')
            ->take(10)
            ->get();
    }
}
