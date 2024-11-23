<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\meetingController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [BusinessController::class, 'home'])->name('home');
Route::get('/upload', [BusinessController::class, 'uploadPage'])->name('uploadpage');
Route::post('/upload', [BusinessController::class, 'upload'])->name('business.upload');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/checkEmail', [AuthController::class, "checkEmail"])->name('checkEmail');

Route::post('/login-process', [AuthController::class, "loginProcess"])->name('loginProcess');

Route::get('/register', [AuthController::class, 'register'])->name('register');

Route::post('/register-process', [AuthController::class, "registerProcess"])->name('registerProcess');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/manage/{id}', [BusinessController::class, 'manage'])->name('manageBusiness');

Route::get('/business/{id}', [BusinessController::class, 'viewBusinessDetail'])->name('business.show');

Route::post('/business/{id}/buy', [BusinessController::class, 'buy'])->name('business.buy');

Route::post('/add-meeting', [BusinessController::class, 'addMeeting'])->name('addMeeting');


Route::get('/profile', [AuthController::class, 'profile'])->name('profile');

Route::get('/investments', [BusinessController::class, 'detailProfile'])->name('investments');