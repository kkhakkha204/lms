<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\CourseReview;

class ReviewApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $review;

    /**
     * Create a new notification instance.
     */
    public function __construct(CourseReview $review)
    {
        $this->review = $review;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
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
        return (new MailMessage)
            ->subject('Đánh giá của bạn đã được duyệt')
            ->greeting('Xin chào ' . $notifiable->name . '!')
            ->line('Đánh giá của bạn cho khóa học "' . $this->review->course->title . '" đã được duyệt và hiển thị công khai.')
            ->line('Cảm ơn bạn đã chia sẻ trải nghiệm học tập với cộng đồng!')
            ->action('Xem khóa học', url('/courses/' . $this->review->course->slug))
            ->line('Chúc bạn có những trải nghiệm học tập tuyệt vời!');
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'review_approved',
            'title' => 'Đánh giá được duyệt',
            'message' => 'Đánh giá của bạn cho khóa học "' . $this->review->course->title . '" đã được duyệt.',
            'course_id' => $this->review->course_id,
            'course_title' => $this->review->course->title,
            'review_id' => $this->review->id,
            'rating' => $this->review->rating,
        ];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'review_approved',
            'course_id' => $this->review->course_id,
            'course_title' => $this->review->course->title,
            'review_id' => $this->review->id,
        ];
    }
}
