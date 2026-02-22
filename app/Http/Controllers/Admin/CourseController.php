<?php

namespace App\Http\Controllers\Admin;

use App\Models\Course;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('instructor', 'category')
            ->latest()
            ->get();

        return Inertia::render('Admin/Courses/Index', [
            'courses' => $courses
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request
                ->file('thumbnail')
                ->store('courses', 'public');
        }

        Course::create($validated);

        return redirect()
            ->back()
            ->with('success', 'Course created successfully');
    }

    public function update(Request $request, string $id)
    {
        $course = Course::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {

            // Delete old image
            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }

            $validated['thumbnail'] = $request
                ->file('thumbnail')
                ->store('courses', 'public');
        }

        $course->update($validated);

        return redirect()
            ->back()
            ->with('success', 'Course updated successfully');
    }

    public function destroy(string $id)
    {
        $course = Course::findOrFail($id);

        if ($course->thumbnail) {
            Storage::disk('public')->delete($course->thumbnail);
        }

        $course->delete();

        return back()->with('success', 'Course deleted successfully');
    }

    public function publish(Course $course)
    {
        $course->update([
            'is_published' => true,
            'published_at' => now(),
        ]);

        return back();
    }
}
