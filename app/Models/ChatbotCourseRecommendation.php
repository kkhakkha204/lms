<?php
// app/Models/ChatbotCourseRecommendation.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatbotCourseRecommendation extends Model
{
    use HasFactory;

    protected $fillable = [
        'message_id',
        'course_id',
        'recommendation_rank',
        'recommendation_reason',
        'clicked',
        'clicked_at'
    ];

    protected $casts = [
        'clicked' => 'boolean',
        'clicked_at' => 'datetime'
    ];

    public function message(): BelongsTo
    {
        return $this->belongsTo(ChatbotMessage::class, 'message_id');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function markAsClicked()
    {
        $this->update([
            'clicked' => true,
            'clicked_at' => now()
        ]);
    }

    public function scopeClicked($query, $clicked = true)
    {
        return $query->where('clicked', $clicked);
    }

    public function scopeByRank($query, $rank)
    {
        return $query->where('recommendation_rank', $rank);
    }
}
