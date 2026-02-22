<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function store(Course $course)
    {
        $user = auth()->user();

        // Check if already enrolled
        if ($course->students()->where('user_id', $user->id)->exists()) {
            return back()->with('error', 'You are already enrolled in this course.');
        }

        $course->students()->attach($user->id, [
            'progress' => 0,
            'enrolled_at' => now(),
        ]);

        return back()->with('success', 'Successfully enrolled in this course.');
    }
}
