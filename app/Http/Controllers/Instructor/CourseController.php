<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Http\Requests\UpdateCourseRequest;

class CourseController extends Controller
{
    public function index()
    {
        return Inertia::render('Instructor/Courses/Index', [
            'courses' => auth()->user()
                ->courses()
                ->withCount('lessons')
                ->select(
                    'id',
                    'title',
                    'slug',
                    'description',
                    'price',
                    'level',
                    'is_published',
                    'created_at'
                )
                ->latest()
                ->get()
        ]);
    }

    public function create()
    {
        return Inertia::render('Instructor/Courses/Create', [
            'categories' => Category::select('id', 'name')->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'level' => 'required|in:beginner,intermediate,advanced',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['instructor_id'] = auth()->id();
        $validated['is_published'] = false;

        Course::create($validated);

        return redirect()
            ->route('instructor.courses.index')
            ->with('success', 'Course created successfully.');
    }

    public function show(Course $course)
    {
        $this->authorize('view', $course);

        return Inertia::render('Instructor/Courses/Show', [
            'course' => $course
        ]);
    }

    public function edit(Course $course)
    {
        $this->authorize('update', $course);
        $course->load('lessons');

        return Inertia::render('Instructor/Courses/Edit', [
            'course' => $course
        ]);
    }

    public function update(UpdateCourseRequest $request, Course $course)
    {
        $this->authorize('update', $course);

        $course->update($request->validated());

        return back()->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $this->authorize('delete', $course);

        $course->delete();

        return back()->with('success', 'Course deleted successfully.');
    }
}

