<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseReview;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    /**
     * Display a listing of the reviews.
     */
    public function index(Request $request)
    {
        $query = CourseReview::with(['student', 'course.category'])
            ->orderBy('created_at', 'desc');

        // Filter by course
        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        // Filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'approved') {
                $query->where('is_approved', true);
            } elseif ($request->status === 'pending') {
                $query->where('is_approved', false);
            }
        }

        // Search by student name or review content
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('student', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', '%' . $search . '%');
                })->orWhere('review', 'like', '%' . $search . '%');
            });
        }

        $reviews = $query->paginate(15);
        $courses = Course::select('id', 'title')->orderBy('title')->get();

        return view('admin.reviews.index', compact('reviews', 'courses'));
    }

    /**
     * Show the specified review details.
     */
    public function show(CourseReview $review): JsonResponse
    {
        $review->load(['student', 'course']);

        return response()->json([
            'success' => true,
            'review' => [
                'id' => $review->id,
                'student_name' => $review->student->name,
                'student_email' => $review->student->email,
                'student_avatar' => $review->student->avatar_url,
                'course_title' => $review->course->title,
                'course_thumbnail' => $review->course->thumbnail_url,
                'rating' => $review->rating,
                'review' => $review->review,
                'is_approved' => $review->is_approved,
                'created_at' => $review->created_at->format('d/m/Y H:i'),
                'updated_at' => $review->updated_at->format('d/m/Y H:i'),
            ]
        ]);
    }

    /**
     * Toggle review approval status.
     */
    public function toggleApproval(CourseReview $review): JsonResponse
    {
        try {
            $wasApproved = $review->is_approved;

            $review->update([
                'is_approved' => !$review->is_approved
            ]);

            // Log review approval for tracking
            if (!$wasApproved && $review->is_approved) {
                Log::info('Review approved', [
                    'review_id' => $review->id,
                    'student_name' => $review->student->name,
                    'course_title' => $review->course->title,
                    'rating' => $review->rating
                ]);

                // Có thể thêm logic gửi email đơn giản ở đây nếu cần
                // Mail::to($review->student->email)->send(new ReviewApprovedMail($review));
            }

            // Update course rating and reviews count
            $this->updateCourseRating($review->course_id);

            return response()->json([
                'success' => true,
                'message' => $review->is_approved
                    ? 'Review đã được duyệt thành công!'
                    : 'Review đã được ẩn thành công!',
                'is_approved' => $review->is_approved
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to toggle review approval', [
                'review_id' => $review->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật trạng thái review!'
            ], 500);
        }
    }

    /**
     * Remove the specified review from storage.
     */
    public function destroy(CourseReview $review): JsonResponse
    {
        try {
            $courseId = $review->course_id;
            $review->delete();

            // Update course rating and reviews count
            $this->updateCourseRating($courseId);

            return response()->json([
                'success' => true,
                'message' => 'Review đã được xóa thành công!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa review!'
            ], 500);
        }
    }

    /**
     * Bulk actions for reviews.
     */
    public function bulkAction(Request $request): JsonResponse
    {
        $request->validate([
            'action' => 'required|in:approve,reject,delete',
            'review_ids' => 'required|array',
            'review_ids.*' => 'exists:course_reviews,id'
        ]);

        try {
            $reviewIds = $request->review_ids;
            $courseIds = [];

            switch ($request->action) {
                case 'approve':
                    $reviews = CourseReview::whereIn('id', $reviewIds)->get();
                    $courseIds = $reviews->pluck('course_id')->unique()->toArray();

                    // Update and log approvals
                    $approvedCount = 0;
                    foreach ($reviews as $review) {
                        $wasApproved = $review->is_approved;
                        $review->update(['is_approved' => true]);

                        // Log if review was just approved
                        if (!$wasApproved) {
                            $approvedCount++;
                            Log::info('Review bulk approved', [
                                'review_id' => $review->id,
                                'student_name' => $review->student->name,
                                'course_title' => $review->course->title,
                                'rating' => $review->rating
                            ]);
                        }
                    }

                    $message = 'Đã duyệt ' . $approvedCount . ' review thành công!';
                    break;

                case 'reject':
                    $courseIds = CourseReview::whereIn('id', $reviewIds)
                        ->pluck('course_id')
                        ->unique()
                        ->toArray();

                    CourseReview::whereIn('id', $reviewIds)
                        ->update(['is_approved' => false]);

                    $message = 'Đã ẩn ' . count($reviewIds) . ' review thành công!';
                    break;

                case 'delete':
                    $courseIds = CourseReview::whereIn('id', $reviewIds)
                        ->pluck('course_id')
                        ->unique()
                        ->toArray();

                    CourseReview::whereIn('id', $reviewIds)->delete();

                    $message = 'Đã xóa ' . count($reviewIds) . ' review thành công!';
                    break;
            }

            // Update course ratings for affected courses
            foreach ($courseIds as $courseId) {
                $this->updateCourseRating($courseId);
            }

            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi thực hiện hành động!'
            ], 500);
        }
    }

    /**
     * Update course rating and reviews count.
     */
    private function updateCourseRating($courseId)
    {
        $course = Course::find($courseId);
        if (!$course) return;

        $approvedReviews = CourseReview::where('course_id', $courseId)
            ->where('is_approved', true);

        $averageRating = $approvedReviews->avg('rating') ?: 0;
        $reviewsCount = $approvedReviews->count();

        $course->update([
            'rating' => round($averageRating, 2),
            'reviews_count' => $reviewsCount
        ]);
    }
}
