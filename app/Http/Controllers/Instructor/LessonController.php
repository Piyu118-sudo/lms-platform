<?php

namespace App\Http\Controllers\Instructor;

use App\Models\Course;
use App\Models\Lesson;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function create(Course $course)
    {
        $this->authorize('update', $course);

        return Inertia::render('Instructor/Lesson/Create', [
            'course' => $course
        ]);
    }

    public function store(Request $request, Course $course)
    {
        $this->authorize('update', $course);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'video_url' => 'nullable|string',
            'duration' => 'nullable|integer',
            'is_published' => 'boolean',
        ]);

        $validated['course_id'] = $course->id;
        $validated['order'] = $course->lessons()->count() + 1;

        Lesson::create($validated);

        return redirect()
            ->route('instructor.courses.edit', $course->id)
            ->with('success', 'Lesson created successfully.');
    }

    public function destroy(Lesson $lesson)
    {
        $this->authorize('update', $lesson->course);

        $courseId = $lesson->course_id;

        $lesson->delete();

        return redirect()
            ->route('instructor.courses.edit', $courseId)
            ->with('success', 'Lesson deleted successfully.');
    }

    public function show(Lesson $lesson)
    {
        $user = Auth::user();

        if (!$user->enrolledCourses()
            ->where('course_id', $lesson->course_id)
            ->exists()) {
            abort(403);
        }

        return Inertia::render('Student/Lessons/Show', [
            'lesson' => $lesson
        ]);
    }
}

