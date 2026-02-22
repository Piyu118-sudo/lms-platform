<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillabel = [
        'rating',
        'comment',
        'user_id',
        'course_id',
    ];
    public function User():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function Course():BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

}
