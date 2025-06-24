<?php

// app/Models/ChatbotConversation.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChatbotConversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'user_id',
        'session_id',
        'status',
        'message_count',
        'last_activity'
    ];

    protected $casts = [
        'last_activity' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ChatbotMessage::class, 'conversation_id');
    }

    public function latestMessage()
    {
        return $this->hasOne(ChatbotMessage::class, 'conversation_id')->latest();
    }

    public function recommendations(): HasMany
    {
        return $this->hasManyThrough(
            ChatbotCourseRecommendation::class,
            ChatbotMessage::class,
            'conversation_id',
            'message_id',
            'id',
            'id'
        );
    }

    public function markAsActive()
    {
        $this->update([
            'status' => 'active',
            'last_activity' => now()
        ]);
    }

    public function incrementMessageCount()
    {
        $this->increment('message_count');
        $this->markAsActive();
    }
}
