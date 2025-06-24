<?php
// app/Models/ChatbotMessage.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChatbotMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'sender',
        'message',
        'metadata',
        'response_time',
        'is_helpful'
    ];

    protected $casts = [
        'metadata' => 'array',
        'response_time' => 'decimal:3',
        'is_helpful' => 'boolean'
    ];

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(ChatbotConversation::class, 'conversation_id');
    }

    public function recommendations(): HasMany
    {
        return $this->hasMany(ChatbotCourseRecommendation::class, 'message_id');
    }

    public function scopeByUser($query, $userId)
    {
        return $query->whereHas('conversation', function($q) use ($userId) {
            $q->where('user_id', $userId);
        });
    }

    public function scopeBySender($query, $sender)
    {
        return $query->where('sender', $sender);
    }

    public function addRecommendation($courseId, $rank = 1, $reason = null)
    {
        return $this->recommendations()->create([
            'course_id' => $courseId,
            'recommendation_rank' => $rank,
            'recommendation_reason' => $reason
        ]);
    }
}

