<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index(Request $request)
    {
        // Lấy bộ lọc thời gian từ request (mặc định là 'day')
        $filter = $request->query('filter', 'day');

        // Xác định khoảng thời gian và format ngày cho chart
        $startDate = now()->startOfDay();
        $dateFormat = '%Y-%m-%d'; // Mặc định format ngày

        if ($filter === 'day') {
            $startDate = now()->subDays(7)->startOfDay(); // 7 ngày gần nhất
            $dateFormat = '%Y-%m-%d';
        } elseif ($filter === 'week') {
            $startDate = now()->subWeeks(8)->startOfWeek(); // 8 tuần gần nhất
            $dateFormat = '%Y-%u'; // Year-Week format
        } elseif ($filter === 'month') {
            $startDate = now()->subMonths(12)->startOfMonth(); // 12 tháng gần nhất
            $dateFormat = '%Y-%m';
        }

        // Thống kê doanh thu với format phù hợp
        $revenueQuery = Payment::select(
            DB::raw("DATE_FORMAT(paid_at, '{$dateFormat}') as date"),
            DB::raw('SUM(final_amount) as total_revenue')
        )
            ->where('status', 'completed')
            ->where('paid_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date');

        $revenueData = $revenueQuery->get()->map(function ($item) use ($filter) {
            $formattedDate = $item->date;

            // Format hiển thị theo bộ lọc
            if ($filter === 'week') {
                // Convert year-week to readable format
                $year = substr($item->date, 0, 4);
                $week = substr($item->date, -2);
                $formattedDate = "Tuần {$week}/{$year}";
            } elseif ($filter === 'month') {
                // Convert year-month to readable format
                $formattedDate = date('m/Y', strtotime($item->date . '-01'));
            } else {
                // Day format
                $formattedDate = date('d/m', strtotime($item->date));
            }

            return [
                'date' => $formattedDate,
                'total_revenue' => $item->total_revenue,
            ];
        });

        // Top 5 khóa học bán chạy - FIX: Bao gồm tất cả các trường cần thiết
        $topCourses = Course::select(
            'courses.id',
            'courses.title',
            'courses.thumbnail',
            'courses.price',           // Thêm trường price
            'courses.discount_price',  // Thêm trường discount_price
            'courses.is_free',         // Thêm trường is_free
            'courses.category_id',     // Thêm trường category_id
            DB::raw('COUNT(enrollments.id) as enrollment_count')
        )
            ->leftJoin('enrollments', 'courses.id', '=', 'enrollments.course_id')
            ->leftJoin('categories', 'courses.category_id', '=', 'categories.id') // Join với bảng categories
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
            ->with('category') // Eager load relationship
            ->get();

        // Thống kê bổ sung
        $additionalStats = [
            'total_students' => User::where('role', 'student')->count(),
            'total_courses' => Course::where('status', 'published')->count(),

        ];

        return view('admin.statistics', compact('revenueData', 'topCourses', 'filter', 'additionalStats'));
    }


}
