<?php

namespace App\Models;


use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasMany;


class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     *
     */

    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    // Instructor courses
    public function Courses():HasMany

    {
        return $this->hasMany(Course::class,'instructor');
    }
    public function Enrollments():hasMany
    {
        return $this->hasMany(Enrollment::class);
    }
    public function Enrolledcourses():BelongsToMany
    {
        return $this->belongdToMany(Course::class,'enrollments')->withPivot('progress','completed_at','enrolled_at')->withTimestamps();
    }
    public function Reviews():HasMany
    {
        return $this->hasMany(Review::class);
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_confirmed_at' => 'datetime',
        ];
    }
}
