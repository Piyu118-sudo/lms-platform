<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Category extends Model
{
    protected $fillable = [
        'id',
        'name',
        'slug',
        'timestamps',
    ];
    public function Courses():HasMany
    {
        return $this->hasMany(Course::class);
    }
}
