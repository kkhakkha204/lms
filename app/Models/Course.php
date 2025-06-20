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
    // Thêm các scopes này vào Course Model

    /**
     * Scope để lấy các khóa học đã published
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope để lấy các khóa học miễn phí
     */
    public function scopeFree($query)
    {
        return $query->where('is_free', true);
    }

    /**
     * Scope để lấy các khóa học có phí
     */
    public function scopePaid($query)
    {
        return $query->where('is_free', false);
    }

    /**
     * Accessor để lấy URL thumbnail
     */
    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail ? asset('storage/' . $this->thumbnail) : null;
    }

    /**
     * Accessor để lấy giá hiển thị (ưu tiên discount_price)
     */
    public function getDisplayPriceAttribute()
    {
        if ($this->is_free) {
            return 0;
        }

        return $this->discount_price ?: $this->price;
    }

    /**
     * Accessor để kiểm tra có giảm giá không
     */
    public function getHasDiscountAttribute()
    {
        return $this->discount_price && $this->discount_price < $this->price;
    }

    /**
     * Accessor để tính phần trăm giảm giá
     */
    public function getDiscountPercentageAttribute()
    {
        if (!$this->has_discount) {
            return 0;
        }

        return round((($this->price - $this->discount_price) / $this->price) * 100);
    }

    /**
     * Tính tổng thời lượng khóa học từ các bài học
     */
    public function getTotalDurationAttribute()
    {
        return $this->lessons()->sum('video_duration') ?: $this->duration_hours;
    }

    /**
     * Tính tổng số bài học
     */
    public function getTotalLessonsAttribute()
    {
        return $this->lessons()->count();
    }

    /**
     * Tính tổng số quiz
     */
    public function getTotalQuizzesAttribute()
    {
        return $this->quizzes()->count();
    }
}
