<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusinessController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [BusinessController::class, 'home'])->name('home');
Route::get('/upload', [BusinessController::class, 'uploadPage'])->name('uploadpage');
Route::post('/upload', [BusinessController::class, 'upload'])->name('business.upload');

Route::get('/login', [AuthController::class, 'login'])->name('login');

Route::post('/login-process', [AuthController::class, "loginProcess"])->name('loginProcess');

Route::get('/manage', [BusinessController::class, 'manage'])->name('manageBusiness');