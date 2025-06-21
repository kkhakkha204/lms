<?php

namespace App\Observers;

use App\Models\CourseReview;
use App\Models\Course;
use App\Notifications\CourseReviewNotification;
use App\Notifications\ReviewApprovedNotification;
use Illuminate\Support\Facades\Log;

class CourseReviewObserver
{
    /**
     * Handle the CourseReview "created" event.
     */
    public function created(CourseReview $courseReview): void
    {
        try {
            // Update course rating and review count
            $this->updateCourseRating($courseReview->course_id);

            // Notify instructor about new review
            $instructor = $courseReview->course->instructor;
            if ($instructor) {
                $instructor->notify(new CourseReviewNotification($courseReview, 'new_review'));
            }

            Log::info('New course review created', [
                'review_id' => $courseReview->id,
                'course_id' => $courseReview->course_id,
                'student_id' => $courseReview->student_id,
                'rating' => $courseReview->rating
            ]);

        } catch (\Exception $e) {
            Log::error('Error handling course review creation', [
                'review_id' => $courseReview->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Handle the CourseReview "updated" event.
     */
    public function updated(CourseReview $courseReview): void
    {
        try {
            // Update course rating and review count
            $this->updateCourseRating($courseReview->course_id);

            // If review was approved, notify student
            if ($courseReview->wasChanged('is_approved') && $courseReview->is_approved) {
                $courseReview->student->notify(new ReviewApprovedNotification($courseReview));
            }

            // If rating or content changed, notify instructor
            if ($courseReview->wasChanged(['rating', 'review'])) {
                $instructor = $courseReview->course->instructor;
                if ($instructor) {
                    $instructor->notify(new CourseReviewNotification($courseReview, 'review_updated'));
                }
            }

            Log::info('Course review updated', [
                'review_id' => $courseReview->id,
                'changes' => $courseReview->getChanges()
            ]);

        } catch (\Exception $e) {
            Log::error('Error handling course review update', [
                'review_id' => $courseReview->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Handle the CourseReview "deleted" event.
     */
    public function deleted(CourseReview $courseReview): void
    {
        try {
            // Update course rating and review count
            $this->updateCourseRating($courseReview->course_id);

            // Notify instructor about deleted review
            $instructor = $courseReview->course->instructor;
            if ($instructor) {
                $instructor->notify(new CourseReviewNotification($courseReview, 'review_deleted'));
            }

            Log::info('Course review deleted', [
                'review_id' => $courseReview->id,
                'course_id' => $courseReview->course_id,
                'student_id' => $courseReview->student_id
            ]);

        } catch (\Exception $e) {
            Log::error('Error handling course review deletion', [
                'review_id' => $courseReview->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Handle the CourseReview "restored" event.
     */
    public function restored(CourseReview $courseReview): void
    {
        try {
            // Update course rating and review count
            $this->updateCourseRating($courseReview->course_id);

            Log::info('Course review restored', [
                'review_id' => $courseReview->id
            ]);

        } catch (\Exception $e) {
            Log::error('Error handling course review restoration', [
                'review_id' => $courseReview->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Handle the CourseReview "force deleted" event.
     */
    public function forceDeleted(CourseReview $courseReview): void
    {
        try {
            // Update course rating and review count
            $this->updateCourseRating($courseReview->course_id);

            Log::info('Course review force deleted', [
                'review_id' => $courseReview->id
            ]);

        } catch (\Exception $e) {
            Log::error('Error handling course review force deletion', [
                'review_id' => $courseReview->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Update course rating and reviews count
     */
    private function updateCourseRating(int $courseId): void
    {
        $stats = CourseReview::where('course_id', $courseId)
            ->where('is_approved', true)
            ->selectRaw('AVG(rating) as avg_rating, COUNT(*) as total_reviews')
            ->first();

        Course::where('id', $courseId)->update([
            'rating' => $stats->avg_rating ? round($stats->avg_rating, 2) : 0,
            'reviews_count' => $stats->total_reviews ?? 0,
        ]);

        Log::debug('Course rating updated', [
            'course_id' => $courseId,
            'new_rating' => $stats->avg_rating ? round($stats->avg_rating, 2) : 0,
            'total_reviews' => $stats->total_reviews ?? 0
        ]);
    }
}
