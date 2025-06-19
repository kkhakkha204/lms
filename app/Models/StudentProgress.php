<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_id',
        'lesson_id',
        'quiz_id',
        'type',
        'status',
        'video_watched_seconds',
        'lesson_completed',
        'quiz_score',
        'quiz_attempts',
        'quiz_passed',
        'quiz_answers',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'type' => 'string',
        'status' => 'string',
        'video_watched_seconds' => 'integer',
        'lesson_completed' => 'boolean',
        'quiz_score' => 'decimal:2',
        'quiz_attempts' => 'integer',
        'quiz_passed' => 'boolean',
        'quiz_answers' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
