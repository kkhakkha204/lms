<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use App\Models\Enrollment;
use App\Models\CourseReview;
use App\Models\Certificate;
use App\Models\StudentProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * Dashboard học viên - Khóa học đã đăng ký với thống kê chi tiết
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Lấy tất cả enrollments với thông tin course và instructor
        $enrollments = Enrollment::with([
            'course' => function ($query) {
                $query->select('id', 'title', 'slug', 'thumbnail', 'instructor_id');
            },
            'course.instructor:id,name',
            'certificate:id,student_id,course_id,enrollment_id,certificate_code,final_score,issued_at'
        ])
            ->where('student_id', $user->id)
            ->where('status', 'active')
            ->orderBy('enrolled_at', 'desc')
            ->get();

        // Tính toán tổng số lessons cho mỗi course
        foreach ($enrollments as $enrollment) {
            $totalLessons = DB::table('lessons')
                ->where('course_id', $enrollment->course_id)
                ->where('is_active', true)
                ->count();

            $enrollment->course->total_lessons = $totalLessons;
        }

        // Thống kê tổng quan
        $stats = [
            'total_courses' => $enrollments->count(),
            'completed_courses' => $enrollments->where('progress_percentage', 100)->count(),
            'in_progress_courses' => $enrollments->where('progress_percentage', '>', 0)
                ->where('progress_percentage', '<', 100)->count(),
            'not_started_courses' => $enrollments->where('progress_percentage', 0)->count(),
        ];

        // Thống kê reviews
        $reviewStats = [
            'total_reviews' => CourseReview::where('student_id', $user->id)->count(),
            'pending_reviews' => $this->getPendingReviewsCount($user->id),
        ];

        // Thống kê certificates
        $certificateStats = [
            'total_certificates' => Certificate::where('student_id', $user->id)
                ->where('status', 'active')
                ->count(),
            'recent_certificates' => Certificate::where('student_id', $user->id)
                ->where('status', 'active')
                ->with('course:id,title')
                ->orderBy('issued_at', 'desc')
                ->limit(3)
                ->get()
        ];

        return view('student.dashboard', compact(
            'enrollments',
            'stats',
            'reviewStats',
            'certificateStats'
        ));
    }

    /**
     * Trang chủ học viên - Danh sách tất cả khóa học
     */
    public function index(Request $request)
    {
        $query = Course::with(['category', 'instructor'])
            ->where('status', 'published');

        // Lọc theo danh mục
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Lọc theo mức độ
        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        // Lọc theo giá
        if ($request->filled('price_type')) {
            switch ($request->price_type) {
                case 'free':
                    $query->where('is_free', true);
                    break;
                case 'paid':
                    $query->where('is_free', false);
                    break;
            }
        }

        // Tìm kiếm theo từ khóa
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        // Sắp xếp
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->orderBy('enrolled_count', 'desc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            case 'latest':
            default:
                $query->orderBy('published_at', 'desc');
                break;
        }

        $courses = $query->paginate(12);
        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('student.courses.index', compact('courses', 'categories'));
    }

    /**
     * Chi tiết khóa học
     */
    public function showCourse($slug)
    {
        $course = Course::with([
            'category',
            'instructor',
            'sections' => function ($query) {
                $query->where('is_active', true)->orderBy('sort_order');
            },
            'sections.lessons' => function ($query) {
                $query->where('is_active', true)->orderBy('sort_order');
            },
            'sections.quizzes' => function ($query) {
                $query->where('is_active', true)->orderBy('sort_order');
            },
            'reviews' => function ($query) {
                $query->with('student')
                    ->where('is_approved', true)
                    ->orderBy('created_at', 'desc')
                    ->limit(5);
            }
        ])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Kiểm tra xem user đã đăng ký khóa học này chưa
        $isEnrolled = false;
        $userReview = null;
        $canReview = false;
        $enrollment = null;

        if (Auth::check()) {
            $userId = Auth::id();

            // Lấy thông tin enrollment
            $enrollment = Enrollment::where('student_id', $userId)
                ->where('course_id', $course->id)
                ->where('status', 'active')
                ->first();

            $isEnrolled = (bool) $enrollment;

            // Lấy review của user hiện tại (nếu có)
            $userReview = CourseReview::where('student_id', $userId)
                ->where('course_id', $course->id)
                ->first();

            // Kiểm tra có thể review không
            $canReview = $isEnrolled && !$userReview;
        }

        // Tính tổng số bài học và quiz
        $totalLessons = $course->sections->sum(function ($section) {
            return $section->lessons->where('is_active', true)->count();
        });

        $totalQuizzes = $course->sections->sum(function ($section) {
            return $section->quizzes->where('is_active', true)->count();
        });

        // Lấy khóa học liên quan (cùng danh mục)
        $relatedCourses = Course::with(['category', 'instructor'])
            ->where('category_id', $course->category_id)
            ->where('id', '!=', $course->id)
            ->where('status', 'published')
            ->limit(4)
            ->get();

        // Tính rating breakdown để hiển thị
        $ratingBreakdown = $this->calculateRatingBreakdown($course->id);

        return view('student.courses.show', compact(
            'course',
            'isEnrolled',
            'enrollment',
            'totalLessons',
            'totalQuizzes',
            'relatedCourses',
            'userReview',
            'canReview',
            'ratingBreakdown'
        ));
    }

    /**
     * Trang học tập - Xem bài học
     */
    public function learn($courseSlug, $lessonSlug = null)
    {
        $course = Course::with([
            'sections.lessons' => function ($query) {
                $query->where('is_active', true)->orderBy('sort_order');
            },
            'sections.quizzes' => function ($query) {
                $query->where('is_active', true)->orderBy('sort_order');
            }
        ])
            ->where('slug', $courseSlug)
            ->firstOrFail();

        // Kiểm tra quyền truy cập
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để học khóa học này.');
        }

        $enrollment = Enrollment::where('student_id', Auth::id())
            ->where('course_id', $course->id)
            ->where('status', 'active')
            ->first();

        if (!$enrollment) {
            return redirect()->route('student.courses.show', $courseSlug)
                ->with('error', 'Bạn chưa đăng ký khóa học này.');
        }

        // Lấy bài học hiện tại
        $currentLesson = null;
        if ($lessonSlug) {
            $currentLesson = $course->lessons()
                ->where('slug', $lessonSlug)
                ->where('is_active', true)
                ->first();
        }

        // Nếu không có bài học được chỉ định, lấy bài học đầu tiên
        if (!$currentLesson) {
            $currentLesson = $course->sections()
                ->with(['lessons' => function ($query) {
                    $query->where('is_active', true)->orderBy('sort_order');
                }])
                ->orderBy('sort_order')
                ->first()
                ?->lessons
                ?->first();
        }

        // Kiểm tra xem user đã review khóa học này chưa
        $userReview = CourseReview::where('student_id', Auth::id())
            ->where('course_id', $course->id)
            ->first();

        $canReview = !$userReview;

        return view('student.learn.index', compact('course', 'currentLesson', 'enrollment', 'userReview', 'canReview'));
    }

    /**
     * Danh sách khóa học theo danh mục
     */
    public function coursesByCategory($categorySlug)
    {
        $category = Category::where('slug', $categorySlug)
            ->where('is_active', true)
            ->firstOrFail();

        $courses = Course::with(['instructor'])
            ->where('category_id', $category->id)
            ->where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        return view('student.courses.category', compact('category', 'courses'));
    }

    /**
     * API: Lấy thống kê dashboard cho AJAX
     */
    public function getDashboardStats()
    {
        $user = Auth::user();

        $enrollments = Enrollment::where('student_id', $user->id)
            ->where('status', 'active')
            ->get();

        $stats = [
            'total_courses' => $enrollments->count(),
            'completed_courses' => $enrollments->where('progress_percentage', 100)->count(),
            'in_progress_courses' => $enrollments->where('progress_percentage', '>', 0)
                ->where('progress_percentage', '<', 100)->count(),
            'not_started_courses' => $enrollments->where('progress_percentage', 0)->count(),
            'total_certificates' => Certificate::where('student_id', $user->id)
                ->where('status', 'active')
                ->count(),
            'total_reviews' => CourseReview::where('student_id', $user->id)->count(),
            'pending_reviews' => $this->getPendingReviewsCount($user->id),
        ];

        return response()->json($stats);
    }

    /**
     * API: Lấy danh sách khóa học với filter
     */
    public function getEnrollments(Request $request)
    {
        $user = Auth::user();
        $filter = $request->get('filter', 'all'); // all, completed, in-progress, not-started

        $query = Enrollment::with([
            'course' => function ($q) {
                $q->select('id', 'title', 'slug', 'thumbnail', 'instructor_id');
            },
            'course.instructor:id,name',
            'certificate:id,student_id,course_id,certificate_code'
        ])
            ->where('student_id', $user->id)
            ->where('status', 'active');

        // Apply filters
        switch ($filter) {
            case 'completed':
                $query->where('progress_percentage', 100);
                break;
            case 'in-progress':
                $query->where('progress_percentage', '>', 0)
                    ->where('progress_percentage', '<', 100);
                break;
            case 'not-started':
                $query->where('progress_percentage', 0);
                break;
        }

        $enrollments = $query->orderBy('enrolled_at', 'desc')->get();

        // Add total lessons count for each course
        foreach ($enrollments as $enrollment) {
            $totalLessons = DB::table('lessons')
                ->where('course_id', $enrollment->course_id)
                ->where('is_active', true)
                ->count();

            $enrollment->course->total_lessons = $totalLessons;
        }

        return response()->json($enrollments);
    }

    /**
     * API: Lấy tiến độ học tập chi tiết
     */
    public function getLearningProgress($courseSlug)
    {
        $course = Course::where('slug', $courseSlug)->firstOrFail();
        $user = Auth::user();

        // Kiểm tra enrollment
        $enrollment = Enrollment::where('student_id', $user->id)
            ->where('course_id', $course->id)
            ->where('status', 'active')
            ->first();

        if (!$enrollment) {
            return response()->json(['error' => 'Not enrolled'], 403);
        }

        // Lấy chi tiết progress
        $progress = StudentProgress::where('student_id', $user->id)
            ->where('course_id', $course->id)
            ->with(['lesson:id,title,slug', 'quiz:id,title'])
            ->get();

        $data = [
            'enrollment' => $enrollment,
            'progress' => $progress,
            'lessons_completed' => $progress->where('type', 'lesson')->where('lesson_completed', true)->count(),
            'quizzes_completed' => $progress->where('type', 'quiz')->where('quiz_passed', true)->count(),
            'average_quiz_score' => $progress->where('type', 'quiz')->where('quiz_passed', true)->avg('quiz_score') ?: 0,
        ];

        return response()->json($data);
    }

    /**
     * Tính rating breakdown cho khóa học
     */
    private function calculateRatingBreakdown($courseId)
    {
        $breakdown = CourseReview::where('course_id', $courseId)
            ->where('is_approved', true)
            ->selectRaw('rating, COUNT(*) as count')
            ->groupBy('rating')
            ->orderBy('rating', 'desc')
            ->get()
            ->pluck('count', 'rating')
            ->toArray();

        $totalReviews = array_sum($breakdown);

        // Tạo breakdown với phần trăm
        $ratingBreakdown = [];
        for ($i = 5; $i >= 1; $i--) {
            $count = $breakdown[$i] ?? 0;
            $percentage = $totalReviews > 0 ? round(($count / $totalReviews) * 100, 1) : 0;

            $ratingBreakdown[$i] = [
                'count' => $count,
                'percentage' => $percentage
            ];
        }

        return $ratingBreakdown;
    }

    /**
     * Đếm số khóa học chưa review
     */
    private function getPendingReviewsCount($userId)
    {
        // Lấy danh sách khóa học đã enroll
        $enrolledCourseIds = Enrollment::where('student_id', $userId)
            ->where('status', 'active')
            ->pluck('course_id');

        // Lấy danh sách khóa học đã review
        $reviewedCourseIds = CourseReview::where('student_id', $userId)
            ->pluck('course_id');

        // Đếm khóa học chưa review
        return $enrolledCourseIds->diff($reviewedCourseIds)->count();
    }

    /**
     * Tính learning streak (chuỗi học tập)
     */
    private function calculateLearningStreak($userId)
    {
        // Lấy các ngày có hoạt động học tập gần đây
        $recentProgress = StudentProgress::where('student_id', $userId)
            ->where('completed_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(completed_at) as date')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->pluck('date')
            ->toArray();

        if (empty($recentProgress)) {
            return 0;
        }

        $streak = 0;
        $currentDate = now()->format('Y-m-d');

        // Kiểm tra từ hôm nay trở về trước
        for ($i = 0; $i < 30; $i++) {
            $checkDate = now()->subDays($i)->format('Y-m-d');

            if (in_array($checkDate, $recentProgress)) {
                $streak++;
            } else {
                // Nếu không học trong ngày hiện tại thì dừng
                if ($i === 0) {
                    break;
                }
                // Nếu không học trong ngày trước đó thì cũng dừng
                break;
            }
        }

        return $streak;
    }
}
