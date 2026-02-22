<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\Category;
use App\Models\Lesson;
use App\Models\Enrollment;
use App\Models\Review;

class Course extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'thumbnail',
        'price',
        'level',
        'category_id',
        'instructor_id',
        'is_published',
        'published_at',
    ];

    // Instructor relationship
    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    // Category relationship
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Lessons relationship
    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class)
            ->orderBy('order');
    }

    // Enrollment records
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    // Students (many-to-many)
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'enrollments')
            ->withPivot('progress', 'enrolled_at', 'completed_at')
            ->withTimestamps();
    }

    // Reviews
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    // Thumbnail accessor
    public function getThumbnailAttribute($value)
    {
        return $value ? asset('storage/' . $value) : null;
    }
}


