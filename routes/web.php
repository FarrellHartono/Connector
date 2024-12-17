<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApprovalFundController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\meetingController;

Route::middleware(['user.access'])->group(function () {
    Route::get('/upload', [BusinessController::class, 'uploadPage'])->name('uploadpage');
    Route::post('/upload', [BusinessController::class, 'upload'])->name('business.upload');
    Route::get('/manage/{id}', [BusinessController::class, 'manage'])->name('manageBusiness');
    Route::put('/manage/{id}',[BusinessController::class,'updateBusiness'])->name('business.update');
    Route::get('/business/{id}', [BusinessController::class, 'viewBusinessDetail'])->name('business.show');
    Route::post('/business/{id}/transactions', [BusinessController::class, 'transaction'])->name('business.transaction');
    Route::get('/business/{id}/transactions/approve', [ApprovalFundController::class, 'approvalView'])->name('business.transactions.view');
    Route::post('/transactions/approve/{investmentId}', [ApprovalFundController::class, 'approveTransaction'])->name('transaction.approve');
    Route::delete('/transactions/decline/{investmentId}', [ApprovalFundController::class, 'declineTransaction'])->name('transaction.decline');
    Route::post('/businesses/{id}/comments', [CommentController::class, 'storeComment'])->name('business.storeComment');
    Route::put('/comments/{comment}', [CommentController::class, 'updateComment'])->name('business.updateComment');
    Route::delete('/comments/{comment}', [CommentController::class, 'deleteComment'])->name('business.deleteComment');
    Route::post('/businesses/{business}/comments/{comment}/reply', [CommentController::class, 'reply'])->name('business.reply');
    Route::put('/businesses/comments/reply/{reply}', [CommentController::class, 'updateReply'])->name('business.updateReply');
    Route::delete('/businesses/comments/reply/{reply}', [CommentController::class, 'deleteReply'])->name('business.deleteReply');
    Route::post('/add-meeting', [BusinessController::class, 'addMeeting'])->name('addMeeting');
    Route::get('/listBusiness',[BusinessController::class,'listBusiness'])->name('listBusiness');
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::get('/investments', [BusinessController::class, 'detailProfile'])->name('investments');
});


// Route::get('/', function () {
//     return view('welcome');
// })->name('welcome');
Route::get('/',[BusinessController::class,'welcome'])->name('welcome');

Route::get('/home', [BusinessController::class, 'home'])->name('home');

// Authentication routes
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/checkEmail', [AuthController::class, "checkEmail"])->name('checkEmail');
Route::post('/login-process', [AuthController::class, "loginProcess"])->name('loginProcess');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register-process', [AuthController::class, "registerProcess"])->name('registerProcess');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['admin.access'])->group(function () {
    Route::get('/admin/businesses', [AdminController::class, 'adminApprovalView'])->name('admin.businesses');
    Route::post('/admin/businesses/{id}/approve', [AdminController::class, 'approve'])->name('admin.businesses.approve');
    Route::post('/admin/businesses/{id}/decline', [AdminController::class, 'decline'])->name('admin.businesses.decline');
    Route::delete('/admin/businesses/{id}/delete', [AdminController::class, 'delete'])->name('admin.businesses.delete');
});
