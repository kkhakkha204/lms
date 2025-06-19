<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'section_id',
        'title',
        'description',
        'instructions',
        'time_limit',
        'max_attempts',
        'passing_score',
        'show_results',
        'shuffle_questions',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'passing_score' => 'decimal:2',
        'show_results' => 'boolean',
        'shuffle_questions' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function section()
    {
        return $this->belongsTo(CourseSection::class);
    }

    public function questions()
    {
        return $this->hasMany(QuizQuestion::class);
    }
    public function progress()
    {
        return $this->hasMany(StudentProgress::class);
    }
}
