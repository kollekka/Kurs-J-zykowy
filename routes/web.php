<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;

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