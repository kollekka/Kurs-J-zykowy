<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\UserController;
use App\http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/main', function () {
    return view('main');
})->middleware('auth');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/main', [MainController::class, 'index'])->name('main');

Route::get('/course/{id}', [CourseController::class, 'show'])->name('course.show');
Route::get('/course/{id}/enroll', [EnrollmentController::class, 'create'])->name('enroll.show');

Route::post('/enrollment', [EnrollmentController::class, 'store'])->name('enrollment.store');
Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');

Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/add-instructor', [AdminController::class, 'addInstructor'])->name('admin.addInstructor');
    Route::post('/admin/add-course', [AdminController::class, 'addCourse'])->name('admin.addCourse');
});