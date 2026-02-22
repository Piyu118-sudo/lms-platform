<?php

namespace App\Http\Controllers\Student;

use App\Models\Lesson;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class LessonController extends Controller
{
    public function show(Lesson $lesson)
    {
        $user = Auth::user();

        // Check enrollment
        if (!$user->enrolledCourses()
            ->where('course_id', $lesson->course_id)
            ->exists()) {
            abort(403);
        }

        // Load course + ordered lessons
        $lesson->load(['course.lessons' => function ($query) {
            $query->orderBy('order');
        }]);

        // Get completed lesson IDs
        $completedLessonIds = $user->completedLessons()
            ->pluck('lesson_id')
            ->toArray();

        return Inertia::render('Student/CoursePlayer', [
            'course' => $lesson->course,
            'currentLesson' => $lesson,
            'completedLessonIds' => $completedLessonIds,
        ]);
    }
}

