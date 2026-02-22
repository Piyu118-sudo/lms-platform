<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lesson extends Mode
{
    protected $fillable = [
      'id',
      'course_id',
      'title',
      'content(markdown or text)',
      'video_url',
      'duration',
      'order',
      'is_preview',
      'timestamps',
    ];
    public function Course():BelongsTo
    {
        return $this->belongsTo(Course::class);
    }


}

