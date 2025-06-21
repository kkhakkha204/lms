<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_id',
        'paid_amount',
        'status',
        'enrolled_at',
        'expires_at',
        'completed_at',
        'progress_percentage',
        'lessons_completed',
        'quizzes_completed',
        'average_quiz_score',
    ];

    protected $casts = [
        'paid_amount' => 'decimal:2',
        'status' => 'string',
        'enrolled_at' => 'datetime',
        'expires_at' => 'datetime',
        'completed_at' => 'datetime',
        'progress_percentage' => 'integer',
        'lessons_completed' => 'integer',
        'quizzes_completed' => 'integer',
        'average_quiz_score' => 'decimal:2',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function progress()
    {
        return $this->hasMany(StudentProgress::class, 'course_id', 'course_id')
            ->where('student_id', $this->student_id);
    }
    public function certificate()
    {
        return $this->hasOne(Certificate::class);
    }
}
