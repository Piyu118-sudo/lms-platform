<?php

namespace App\Http\Controllers\Student;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $courses = $user->enrolledCourses()
            ->withCount('lessons')
            ->with('lessons')
            ->get()
            ->map(function ($course) use ($user) {

                // For now set 0 until we build completion system
                $completedLessons = 0;

                $progress = $course->lessons_count > 0
                    ? round(($completedLessons / $course->lessons_count) * 100)
                    : 0;

                return [
                    'id' => $course->id,
                    'title' => $course->title,
                    'thumbnail' => $course->thumbnail,
                    'lessons_count' => $course->lessons_count,
                    'progress' => $progress,
                ];
            });

        return Inertia::render('Student/Dashboard', [
            'courses' => $courses
        ]);
    }
}

