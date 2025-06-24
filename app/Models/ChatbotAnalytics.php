<?php
// app/Models/ChatbotAnalytics.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatbotAnalytics extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'total_conversations',
        'total_messages',
        'unique_users',
        'course_recommendations',
        'course_clicks',
        'avg_response_time',
        'user_satisfaction',
        'popular_questions',
        'recommended_courses'
    ];

    protected $casts = [
        'date' => 'date',
        'avg_response_time' => 'decimal:3',
        'user_satisfaction' => 'decimal:2',
        'popular_questions' => 'array',
        'recommended_courses' => 'array'
    ];

    public static function updateDailyStats($date = null)
    {
        $date = $date ?? now()->toDateString();

        $conversations = ChatbotConversation::whereDate('created_at', $date)->count();
        $messages = ChatbotMessage::whereDate('created_at', $date)->count();
        $uniqueUsers = ChatbotConversation::whereDate('created_at', $date)
            ->whereNotNull('user_id')
            ->distinct('user_id')
            ->count();

        $recommendations = ChatbotCourseRecommendation::whereDate('created_at', $date)->count();
        $clicks = ChatbotCourseRecommendation::whereDate('created_at', $date)
            ->where('clicked', true)
            ->count();

        $avgResponseTime = ChatbotMessage::whereDate('created_at', $date)
            ->where('sender', 'bot')
            ->whereNotNull('response_time')
            ->avg('response_time') ?? 0;

        $satisfaction = ChatbotMessage::whereDate('created_at', $date)
            ->whereNotNull('is_helpful')
            ->avg('is_helpful') ?? 0;

        return self::updateOrCreate(
            ['date' => $date],
            [
                'total_conversations' => $conversations,
                'total_messages' => $messages,
                'unique_users' => $uniqueUsers,
                'course_recommendations' => $recommendations,
                'course_clicks' => $clicks,
                'avg_response_time' => $avgResponseTime,
                'user_satisfaction' => $satisfaction * 100
            ]
        );
    }
}
