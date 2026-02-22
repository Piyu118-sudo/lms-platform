<?php

namespace App\Http\Controllers\Student;

use App\Models\Course;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    public function show(Course $course)
    {
        $user = Auth::user();

        // Check enrollment
        if (!$user->enrolledCourses()
            ->where('course_id', $course->id)
            ->exists()) {
            abort(403);
        }

        $course->load(['lessons' => function ($query) {
            $query->orderBy('order');
        }]);

        // Default to first lesson
        $currentLesson = $course->lessons->first();

        return Inertia::render('Student/CoursePlayer', [
            'course' => $course,
            'currentLesson' => $currentLesson,
        ]);
        $completedLessonIds = $user->completedLessons()->pluck('lesson_id')->toArray();
    }

}

