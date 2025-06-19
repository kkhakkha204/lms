<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'category_id',
        'instructor_id',
        'title',
        'slug',
        'description',
        'short_description',
        'thumbnail',
        'preview_video',
        'price',
        'discount_price',
        'is_free',
        'level',
        'status',
        'language',
        'duration_hours',
        'meta_title',
        'meta_description',
        'tags',
        'enrolled_count',
        'rating',
        'reviews_count',
        'views_count',
        'published_at',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'is_free' => 'boolean',
        'rating' => 'decimal:2',
        'tags' => 'array', // JSON field
        'published_at' => 'datetime',
        'level' => 'string',
        'status' => 'string',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'course_id');
    }
    public function sections()
    {
        return $this->hasMany(CourseSection::class);
    }
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function reviews()
    {
        return $this->hasMany(CourseReview::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
