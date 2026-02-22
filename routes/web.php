<?php

use App\Http\Controllers\Instructor\LessonController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student\EnrollmentController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/instructor/courses',[CourseController::class,'store'])->name('courses.store');

});

Route::middleware(['auth','role:admin'])->prefix('admin')->group(function (){
    Route::resource('course',AdminCourseController::class);
    Route::prefix('instructor')->name('instructor.')->middleware(['role:instructor'])->group(function(){
        Route::get('/course/{course}/lessons/create',[LessonController::class,'create'])->name('lessons.create');
        Route::post('/course/{course}/lessons',[LessonController::class,'store'])->name('lessons.store');
        Route::delete('/lesson/{lesson',[LessonController::class,'destroy'])->name('lessons.destroy');
    });
});
Route::middleware(['auth'])->get('/dahboard',[DashboardController::class,'index'])->name('student.dashboard');
Route::middleware(['auth'])->get('/student/courses/{course}',[CourseController::class,'show'])->name('student.course.show');
Route::middleware(['auth'])->get('/student/lessons/{lesson}',[LessonController::class,'show'])->name('student.lesson.show');
Route::middleware(['auth','role:instructor'])->prefix('instructor')->group(function () {
    Route::resource('course',InstructorCourseController::class);
});
Route::middleware(['auth','role:student'])->prefix('student')->group(function () {
    Route::post('enroll/{course}',[EnrollmentController::class,'store']);
});

require __DIR__.'/auth.php';
