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
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\InstructorController;


Route::get('/', function () {
    return view('main');
});

Route::get('/main', function () {
    return view('main');
});

Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/main', [MainController::class, 'index'])->name('main');
Route::get('/', [MainController::class, 'index'])->name('main');

Route::get('/course/{id}', [CourseController::class, 'show'])->name('course.show');
Route::get('/course/{id}/enroll', [EnrollmentController::class, 'create'])->name('enroll.show');

Route::post('/enrollment', [EnrollmentController::class, 'store'])->name('enrollment.store');
Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::put('/user/update', [UserController::class, 'update'])->name('user.update');
Route::post('/course/{id}', [OpinionsController::class, 'store'])->name('opinions.store');

Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    Route::resource('users', UserController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('instructors', InstructorController::class);
    Route::resource('lessons', LessonController::class);
    Route::resource('enrollments', EnrollmentController::class);
    Route::resource('opinions', OpinionsController::class)->only(['index', 'edit', 'update', 'destroy']);
    Route::resource('payments', PaymentController::class);

    
    Route::get('opinions/create-by-admin', [OpinionsController::class, 'createForAdmin'])->name('opinions.createForAdmin');
    Route::post('opinions/store-by-admin', [OpinionsController::class, 'storeForAdmin'])->name('opinions.storeForAdmin');
    Route::get('/courses', [CourseController::class, 'adminIndex'])->name('courses.index');
});
