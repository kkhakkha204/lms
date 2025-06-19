<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'color',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
    protected $dates = [
        'deleted_at'
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    // Accessors
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    public function getStatusLabelAttribute()
    {
        return $this->is_active ? 'Kích hoạt' : 'Tắt';
    }

    public function getStatusColorAttribute()
    {
        return $this->is_active ? 'green' : 'red';
    }

    // Mutators
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = trim($value);
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = $value ? trim($value) : null;
    }

    // Boot method for auto-generating sort_order
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (is_null($category->sort_order)) {
                $category->sort_order = static::max('sort_order') + 1;
            }
        });

        static::deleted(function ($category) {
            // Reorder remaining categories
            static::where('sort_order', '>', $category->sort_order)
                ->decrement('sort_order');
        });
    }

    // Helper methods
    public function toggleStatus()
    {
        $this->update(['is_active' => !$this->is_active]);
        return $this;
    }

    public function moveUp()
    {
        if ($this->sort_order > 1) {
            $previousCategory = static::where('sort_order', $this->sort_order - 1)->first();
            if ($previousCategory) {
                $previousCategory->update(['sort_order' => $this->sort_order]);
                $this->update(['sort_order' => $this->sort_order - 1]);
            }
        }
        return $this;
    }

    public function moveDown()
    {
        $nextCategory = static::where('sort_order', $this->sort_order + 1)->first();
        if ($nextCategory) {
            $nextCategory->update(['sort_order' => $this->sort_order]);
            $this->update(['sort_order' => $this->sort_order + 1]);
        }
        return $this;
    }

    public function moveTo($newOrder)
    {
        $oldOrder = $this->sort_order;

        if ($newOrder == $oldOrder) {
            return $this;
        }

        if ($newOrder < $oldOrder) {
            // Moving up - increment sort_order for items between new and old position
            static::whereBetween('sort_order', [$newOrder, $oldOrder - 1])
                ->increment('sort_order');
        } else {
            // Moving down - decrement sort_order for items between old and new position
            static::whereBetween('sort_order', [$oldOrder + 1, $newOrder])
                ->decrement('sort_order');
        }

        $this->update(['sort_order' => $newOrder]);
        return $this;
    }

    // Relationships (if needed for future features)
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
