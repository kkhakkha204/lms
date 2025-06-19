<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'section_id',
        'title',
        'slug',
        'content',
        'summary',
        'video_url',
        'video_duration',
        'video_size',
        'type',
        'is_preview',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_preview' => 'boolean',
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

    public function materials()
    {
        return $this->hasMany(LessonMaterial::class);
    }

    public function progress()
    {
        return $this->hasMany(StudentProgress::class);
    }
}
