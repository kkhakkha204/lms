<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseReview;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CourseReviewController extends Controller
{
    /**
     * Hiển thị form review cho khóa học
     */
    public function create($courseSlug)
    {
        $course = Course::where('slug', $courseSlug)
            ->where('status', 'published')
            ->firstOrFail();

        // Kiểm tra đăng nhập
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để đánh giá khóa học.');
        }

        $userId = Auth::id();

        // Kiểm tra đã đăng ký khóa học chưa
        $enrollment = Enrollment::where('student_id', $userId)
            ->where('course_id', $course->id)
            ->where('status', 'active')
            ->first();

        if (!$enrollment) {
            return redirect()->route('student.courses.show', $courseSlug)
                ->with('error', 'Bạn cần đăng ký khóa học này trước khi có thể đánh giá.');
        }

        // Kiểm tra đã review chưa
        $existingReview = CourseReview::where('student_id', $userId)
            ->where('course_id', $course->id)
            ->first();

        if ($existingReview) {
            return redirect()->route('student.courses.show', $courseSlug)
                ->with('info', 'Bạn đã đánh giá khóa học này rồi. Bạn có thể chỉnh sửa đánh giá của mình.');
        }

        return view('student.reviews.create', compact('course'));
    }

    /**
     * Lưu review mới
     */
    public function store(Request $request, $courseSlug)
    {
        $course = Course::where('slug', $courseSlug)->firstOrFail();
        $userId = Auth::id();

        // Validate
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ], [
            'rating.required' => 'Vui lòng chọn số sao đánh giá.',
            'rating.min' => 'Đánh giá tối thiểu là 1 sao.',
            'rating.max' => 'Đánh giá tối đa là 5 sao.',
            'review.max' => 'Nội dung đánh giá không được vượt quá 1000 ký tự.',
        ]);

        // Kiểm tra đã đăng ký khóa học
        $enrollment = Enrollment::where('student_id', $userId)
            ->where('course_id', $course->id)
            ->where('status', 'active')
            ->first();

        if (!$enrollment) {
            return back()->with('error', 'Bạn cần đăng ký khóa học này trước khi có thể đánh giá.');
        }

        // Kiểm tra đã review chưa
        $existingReview = CourseReview::where('student_id', $userId)
            ->where('course_id', $course->id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'Bạn đã đánh giá khóa học này rồi.');
        }

        try {
            DB::beginTransaction();

            // Tạo review
            CourseReview::create([
                'student_id' => $userId,
                'course_id' => $course->id,
                'rating' => $request->rating,
                'review' => $request->review,
                'is_approved' => true, // Auto approve, có thể thay đổi logic này
            ]);

            // Cập nhật rating và reviews_count cho khóa học
            $this->updateCourseRating($course->id);

            DB::commit();

            return redirect()->route('student.courses.show', $courseSlug)
                ->with('success', 'Cảm ơn bạn đã đánh giá khóa học! Đánh giá của bạn đã được ghi nhận.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra khi lưu đánh giá. Vui lòng thử lại.');
        }
    }

    /**
     * Hiển thị form chỉnh sửa review
     */
    public function edit($courseSlug)
    {
        $course = Course::where('slug', $courseSlug)->firstOrFail();
        $userId = Auth::id();

        $review = CourseReview::where('student_id', $userId)
            ->where('course_id', $course->id)
            ->firstOrFail();

        return view('student.reviews.edit', compact('course', 'review'));
    }

    /**
     * Cập nhật review
     */
    public function update(Request $request, $courseSlug)
    {
        $course = Course::where('slug', $courseSlug)->firstOrFail();
        $userId = Auth::id();

        $review = CourseReview::where('student_id', $userId)
            ->where('course_id', $course->id)
            ->firstOrFail();

        // Validate
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ], [
            'rating.required' => 'Vui lòng chọn số sao đánh giá.',
            'rating.min' => 'Đánh giá tối thiểu là 1 sao.',
            'rating.max' => 'Đánh giá tối đa là 5 sao.',
            'review.max' => 'Nội dung đánh giá không được vượt quá 1000 ký tự.',
        ]);

        try {
            DB::beginTransaction();

            // Cập nhật review
            $review->update([
                'rating' => $request->rating,
                'review' => $request->review,
            ]);

            // Cập nhật lại rating cho khóa học
            $this->updateCourseRating($course->id);

            DB::commit();

            return redirect()->route('student.courses.show', $courseSlug)
                ->with('success', 'Đánh giá của bạn đã được cập nhật.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra khi cập nhật đánh giá. Vui lòng thử lại.');
        }
    }

    /**
     * Xóa review
     */
    public function destroy($courseSlug)
    {
        $course = Course::where('slug', $courseSlug)->firstOrFail();
        $userId = Auth::id();

        $review = CourseReview::where('student_id', $userId)
            ->where('course_id', $course->id)
            ->firstOrFail();

        try {
            DB::beginTransaction();

            $review->delete();

            // Cập nhật lại rating cho khóa học
            $this->updateCourseRating($course->id);

            DB::commit();

            return redirect()->route('student.courses.show', $courseSlug)
                ->with('success', 'Đánh giá của bạn đã được xóa.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra khi xóa đánh giá. Vui lòng thử lại.');
        }
    }

    /**
     * Lấy danh sách reviews với phân trang (AJAX)
     */
    public function getReviews(Request $request, $courseSlug)
    {
        $course = Course::where('slug', $courseSlug)->firstOrFail();

        $reviews = CourseReview::with('student')
            ->where('course_id', $course->id)
            ->where('is_approved', true)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'reviews' => $reviews->items(),
                'pagination' => [
                    'current_page' => $reviews->currentPage(),
                    'last_page' => $reviews->lastPage(),
                    'per_page' => $reviews->perPage(),
                    'total' => $reviews->total(),
                ]
            ]);
        }

        return view('student.reviews.list', compact('reviews', 'course'));
    }

    /**
     * Kiểm tra user có thể review không
     */
    public function canReview($courseSlug)
    {
        if (!Auth::check()) {
            return response()->json(['can_review' => false, 'reason' => 'not_logged_in']);
        }

        $course = Course::where('slug', $courseSlug)->first();
        if (!$course) {
            return response()->json(['can_review' => false, 'reason' => 'course_not_found']);
        }

        $userId = Auth::id();

        // Kiểm tra đã đăng ký khóa học
        $enrollment = Enrollment::where('student_id', $userId)
            ->where('course_id', $course->id)
            ->where('status', 'active')
            ->exists();

        if (!$enrollment) {
            return response()->json(['can_review' => false, 'reason' => 'not_enrolled']);
        }

        // Kiểm tra đã review chưa
        $hasReviewed = CourseReview::where('student_id', $userId)
            ->where('course_id', $course->id)
            ->exists();

        if ($hasReviewed) {
            return response()->json(['can_review' => false, 'reason' => 'already_reviewed']);
        }

        return response()->json(['can_review' => true]);
    }

    /**
     * Cập nhật rating trung bình cho khóa học
     */
    private function updateCourseRating($courseId)
    {
        $stats = CourseReview::where('course_id', $courseId)
            ->where('is_approved', true)
            ->selectRaw('AVG(rating) as avg_rating, COUNT(*) as total_reviews')
            ->first();

        Course::where('id', $courseId)->update([
            'rating' => $stats->avg_rating ? round($stats->avg_rating, 2) : 0,
            'reviews_count' => $stats->total_reviews ?? 0,
        ]);
    }

    /**
     * Lấy thống kê rating breakdown cho khóa học
     */
    public function getRatingBreakdown($courseSlug)
    {
        $course = Course::where('slug', $courseSlug)->firstOrFail();

        $breakdown = CourseReview::where('course_id', $course->id)
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

        return response()->json([
            'breakdown' => $ratingBreakdown,
            'total_reviews' => $totalReviews,
            'average_rating' => $course->rating
        ]);
    }
}
