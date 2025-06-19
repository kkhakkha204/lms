<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index(Request $request)
    {
        // Lấy bộ lọc thời gian từ request (mặc định là 'month')
        $filter = $request->query('filter', 'month');

        // Xác định khoảng thời gian
        $startDate = now()->startOfDay();
        if ($filter === 'day') {
            $startDate = now()->startOfDay();
        } elseif ($filter === 'week') {
            $startDate = now()->startOfWeek();
        } elseif ($filter === 'month') {
            $startDate = now()->startOfMonth();
        }

        // Thống kê doanh thu
        $revenueData = Payment::select(
            DB::raw('DATE(paid_at) as date'),
            DB::raw('SUM(final_amount) as total_revenue')
        )
            ->where('status', 'completed')
            ->where('paid_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => $item->date,
                    'total_revenue' => $item->total_revenue,
                ];
            });

        // Top 5 khóa học bán chạy
        $topCourses = Course::select(
            'courses.id',
            'courses.title',
            'courses.thumbnail',
            DB::raw('COUNT(enrollments.id) as enrollment_count')
        )
            ->leftJoin('enrollments', 'courses.id', '=', 'enrollments.course_id')
            ->where('enrollments.status', 'active')
            ->groupBy('courses.id', 'courses.title', 'courses.thumbnail')
            ->orderByDesc('enrollment_count')
            ->take(5)
            ->get();

        return view('admin.statistics', compact('revenueData', 'topCourses', 'filter'));
    }
}
