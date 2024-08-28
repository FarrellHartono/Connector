<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [AuthController::class, 'home'])->name('home');

Route::get('/login', [AuthController::class, 'login'])->name('login');

Route::post('/login-process', [AuthController::class, "loginProcess"])->name('loginProcess');
