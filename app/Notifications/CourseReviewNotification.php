<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\CourseReview;

class CourseReviewNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $review;
    protected $type;

    /**
     * Create a new notification instance.
     *
     * @param CourseReview $review
     * @param string $type (new_review, review_updated, review_deleted)
     */
    public function __construct(CourseReview $review, string $type = 'new_review')
    {
        $this->review = $review;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $course = $this->review->course;
        $student = $this->review->student;

        switch ($this->type) {
            case 'new_review':
                return (new MailMessage)
                    ->subject('Đánh giá mới cho khóa học: ' . $course->title)
                    ->greeting('Xin chào ' . $notifiable->name . '!')
                    ->line('Bạn có một đánh giá mới cho khóa học của mình.')
                    ->line('**Khóa học:** ' . $course->title)
                    ->line('**Học viên:** ' . $student->name)
                    ->line('**Đánh giá:** ' . $this->review->rating . '/5 sao')
                    ->when($this->review->review, function ($message) {
                        return $message->line('**Nhận xét:** ' . $this->review->review);
                    })
                    ->action('Xem đánh giá', route('student.courses.show', $course->slug))
                    ->line('Cảm ơn bạn đã tạo ra những khóa học chất lượng!');

            case 'review_updated':
                return (new MailMessage)
                    ->subject('Đánh giá đã được cập nhật: ' . $course->title)
                    ->greeting('Xin chào ' . $notifiable->name . '!')
                    ->line('Một đánh giá cho khóa học của bạn đã được cập nhật.')
                    ->line('**Khóa học:** ' . $course->title)
                    ->line('**Học viên:** ' . $student->name)
                    ->line('**Đánh giá mới:** ' . $this->review->rating . '/5 sao')
                    ->action('Xem đánh giá', route('student.courses.show', $course->slug));

            case 'review_deleted':
                return (new MailMessage)
                    ->subject('Đánh giá đã được xóa: ' . $course->title)
                    ->greeting('Xin chào ' . $notifiable->name . '!')
                    ->line('Một đánh giá cho khóa học của bạn đã được xóa.')
                    ->line('**Khóa học:** ' . $course->title)
                    ->line('**Học viên:** ' . $student->name)
                    ->action('Xem khóa học', route('student.courses.show', $course->slug));

            default:
                return (new MailMessage)
                    ->subject('Thông báo về đánh giá khóa học')
                    ->line('Bạn có thông báo mới về đánh giá khóa học.');
        }
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => $this->type,
            'review_id' => $this->review->id,
            'course_id' => $this->review->course_id,
            'course_title' => $this->review->course->title,
            'course_slug' => $this->review->course->slug,
            'student_name' => $this->review->student->name,
            'rating' => $this->review->rating,
            'review_content' => $this->review->review,
            'message' => $this->getNotificationMessage(),
        ];
    }

    /**
     * Get notification message based on type.
     */
    private function getNotificationMessage(): string
    {
        switch ($this->type) {
            case 'new_review':
                return $this->review->student->name . ' đã đánh giá ' . $this->review->rating . ' sao cho khóa học "' . $this->review->course->title . '"';

            case 'review_updated':
                return $this->review->student->name . ' đã cập nhật đánh giá cho khóa học "' . $this->review->course->title . '"';

            case 'review_deleted':
                return $this->review->student->name . ' đã xóa đánh giá cho khóa học "' . $this->review->course->title . '"';

            default:
                return 'Bạn có thông báo mới về đánh giá khóa học';
        }
    }
}

// Notification cho student khi review được approved
class ReviewApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $review;

    public function __construct(CourseReview $review)
    {
        $this->review = $review;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Đánh giá của bạn đã được duyệt')
            ->greeting('Xin chào ' . $notifiable->name . '!')
            ->line('Đánh giá của bạn cho khóa học "' . $this->review->course->title . '" đã được duyệt và hiển thị công khai.')
            ->line('Cảm ơn bạn đã dành thời gian để đánh giá và chia sẻ trải nghiệm!')
            ->action('Xem đánh giá', route('student.courses.show', $this->review->course->slug))
            ->line('Chúng tôi rất trân trọng ý kiến đóng góp của bạn.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'review_approved',
            'review_id' => $this->review->id,
            'course_title' => $this->review->course->title,
            'course_slug' => $this->review->course->slug,
            'message' => 'Đánh giá của bạn cho khóa học "' . $this->review->course->title . '" đã được duyệt',
        ];
    }
}
