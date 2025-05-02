<?php

use App\Http\Controllers\LessonController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\UserController;
use App\http\Controllers\AdminController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\OpinionsController;    

Route::get('/', function () {
    return view('welcome');
});

Route::get('/main', function () {
    return view('main');
})->middleware('auth');

Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/main', [MainController::class, 'index'])->name('main');

Route::get('/course/{id}', [CourseController::class, 'show'])->name('course.show');
Route::get('/course/{id}/enroll', [EnrollmentController::class, 'create'])->name('enroll.show');

Route::post('/enrollment', [EnrollmentController::class, 'store'])->name('enrollment.store');
Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::put('/user/update', [UserController::class, 'update'])->name('user.update');
Route::post('/course/{id}', [OpinionsController::class, 'store'])->name('opinions.store');

Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/add-instructor', [AdminController::class, 'addInstructor'])->name('admin.addInstructor');
    Route::post('/admin/add-course', [AdminController::class, 'addCourse'])->name('admin.addCourse');
    Route::delete('/admin/instructors/{id}', [AdminController::class, 'deleteInstructor'])->name('admin.deleteInstructor');
    Route::delete('/admin/courses/{id}', [AdminController::class, 'deleteCourse'])->name('admin.deleteCourse');
    Route::get('/admin/instructors/{id}/edit', [AdminController::class, 'editInstructor'])->name('admin.editInstructor');
    Route::get('/admin/courses/{id}/edit', [AdminController::class, 'editCourse'])->name('admin.editCourse');
    Route::put('/admin/instructors/{id}', [AdminController::class, 'updateInstructor'])->name('admin.updateInstructor');
    Route::put('/admin/courses/{id}', [AdminController::class, 'updateCourse'])->name('admin.updateCourse');
    Route::post('/admin/add-lesson', [LessonController::class, 'store'])->name('admin.addLesson');
    Route::get('/admin/lessons/{id}/edit', [AdminController::class, 'editLesson'])->name('admin.editLesson');
    Route::put('/admin/lessons/{id}', [AdminController::class, 'updateLesson'])->name('admin.updateLesson');
});
