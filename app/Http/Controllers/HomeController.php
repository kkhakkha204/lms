<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Hiển thị trang chủ
     */
    public function index()
    {
        // Lấy 5 khóa học nổi bật (nhiều học viên nhất)
        $featuredCourses = Course::with(['category', 'instructor'])
            ->where('status', 'published')
            ->orderBy('enrolled_count', 'desc')
            ->orderBy('rating', 'desc')
            ->limit(5)
            ->get();

        return view('home', compact('featuredCourses'));
    }
}
