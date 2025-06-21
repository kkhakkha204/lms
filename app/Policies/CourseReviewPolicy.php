<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Course;
use App\Models\CourseReview;
use App\Models\Enrollment;

class CourseReviewPolicy
{
    /**
     * Determine whether the user can view any reviews.
     */
    public function viewAny(User $user): bool
    {
        return true; // Anyone can view reviews
    }

    /**
     * Determine whether the user can view the review.
     */
    public function view(User $user, CourseReview $courseReview): bool
    {
        return $courseReview->is_approved || $courseReview->student_id === $user->id;
    }

    /**
     * Determine whether the user can create reviews for this course.
     */
    public function create(User $user, Course $course): bool
    {
        // User must be enrolled in the course
        $isEnrolled = Enrollment::where('student_id', $user->id)
            ->where('course_id', $course->id)
            ->where('status', 'active')
            ->exists();

        if (!$isEnrolled) {
            return false;
        }

        // User cannot have already reviewed this course
        $hasReviewed = CourseReview::where('student_id', $user->id)
            ->where('course_id', $course->id)
            ->exists();

        return !$hasReviewed;
    }

    /**
     * Determine whether the user can update the review.
     */
    public function update(User $user, CourseReview $courseReview): bool
    {
        return $courseReview->student_id === $user->id;
    }

    /**
     * Determine whether the user can delete the review.
     */
    public function delete(User $user, CourseReview $courseReview): bool
    {
        return $courseReview->student_id === $user->id;
    }

    /**
     * Determine whether the user can restore the review.
     */
    public function restore(User $user, CourseReview $courseReview): bool
    {
        return $courseReview->student_id === $user->id;
    }

    /**
     * Determine whether the user can permanently delete the review.
     */
    public function forceDelete(User $user, CourseReview $courseReview): bool
    {
        return $user->role === 'admin' || $courseReview->student_id === $user->id;
    }

    /**
     * Determine whether the user can approve/disapprove reviews.
     */
    public function moderate(User $user): bool
    {
        return in_array($user->role, ['admin', 'instructor']);
    }

    /**
     * Determine whether the user can approve this specific review.
     */
    public function approve(User $user, CourseReview $courseReview): bool
    {
        // Admin can approve any review
        if ($user->role === 'admin') {
            return true;
        }

        // Instructor can only approve reviews for their own courses
        if ($user->role === 'instructor') {
            return $courseReview->course->instructor_id === $user->id;
        }

        return false;
    }
}
