<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApprovalFundController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\meetingController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;

Route::middleware(['user.access'])->group(function () {
    Route::get('/upload', [BusinessController::class, 'uploadPage'])->name('uploadpage');
    Route::post('/upload', [BusinessController::class, 'upload'])->name('business.upload');
    Route::get('/manage/{id}', [BusinessController::class, 'manage'])->name('manageBusiness');
    Route::put('/manage/{id}',[BusinessController::class,'updateBusiness'])->name('business.update');
    Route::get('/business/{id}', [BusinessController::class, 'viewBusinessDetail'])->name('business.show');
    Route::post('/business/{id}/transactions', [BusinessController::class, 'transaction'])->name('business.transaction');
    Route::get('/business/{id}/transactions/approve', [ApprovalFundController::class, 'approvalView'])->name('business.approve.view');

    Route::get('/business/{id}/checkout', [BusinessController::class, 'checkout'])->name('business.checkout');

    Route::post('/transactions/approve/{investmentId}', [ApprovalFundController::class, 'approveTransaction'])->name('transaction.approve');
    Route::delete('/transactions/decline/{investmentId}', [ApprovalFundController::class, 'declineTransaction'])->name('transaction.decline');
    Route::post('/businesses/{id}/comments', [CommentController::class, 'storeComment'])->name('business.storeComment');
    Route::put('/comments/{comment}', [CommentController::class, 'updateComment'])->name('business.updateComment');
    Route::delete('/comments/{comment}', [CommentController::class, 'deleteComment'])->name('business.deleteComment');
    Route::post('/businesses/{business}/comments/{comment}/reply', [CommentController::class, 'reply'])->name('business.reply');
    Route::put('/businesses/comments/reply/{reply}', [CommentController::class, 'updateReply'])->name('business.updateReply');
    Route::delete('/businesses/comments/reply/{reply}', [CommentController::class, 'deleteReply'])->name('business.deleteReply');

    Route::get('/listBusiness',[BusinessController::class,'listBusiness'])->name('listBusiness');
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::get('/investments', [BusinessController::class, 'detailProfile'])->name('investments');

    Route::get('/add-meeting', [MeetingController::class, 'addMeeting'])->name('addMeeting');
    Route::get('/getRegisteredMeetings', [MeetingController::class, "getRegisteredMeetings"])->name('getRegisteredMeetings');
    Route::get('/registerMeeting', [MeetingController::class, "registerMeeting"])->name('registerMeeting');
    Route::get('/editMeeting', [MeetingController::class, "editMeeting"])->name('editMeeting');
    Route::get('/getMeetingData', [MeetingController::class, "getMeetingData"])->name('getMeetingData');
    Route::get('/deleteMeeting', [MeetingController::class, "deleteMeeting"])->name('deleteMeeting');
    Route::get('/check-title',[BusinessController::class,'checkTitle']);
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

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {
    $user = User::findOrFail($id);
    $email = session('user_email');
    if (!hash_equals((string) $hash, sha1($email))) {
        return redirect('/login')->with('error', 'Invalid verification link.');
    }

    if ($user->hasVerifiedEmail()) {
        return redirect('/login')->with('message', 'Your email is already verified. Please log in.');
    }

    $user->markEmailAsVerified();

    event(new Verified($user));

    return redirect('/login')->with('message', 'Your email has been verified. Please log in.');
})->middleware(['signed'])->name('verification.verify');


Route::post('/email/verification-notification', function (Request $request) {
    $user = $request->user();

        $email = session('user_email');
        if ($email) {
            $user = User::where('email', $email)->first();

            if ($user) {
                $user->sendEmailVerificationNotification();
                return back()->with('message', 'Verification link sent!');
            }
            return back()->withErrors(['message' => 'User not found']);
        }
})->middleware(['throttle:6,1'])->name('verification.send');


Route::get('/test-email', function () {
    Mail::raw('This is a test email sent using Google App Password.', function ($message) {
        $message->to('christofer2002wibowo@gmail.com') // Replace with the recipient email
                ->subject('Test Email');
    });

    return 'Email sent successfully!';

    Route::get('/test', function () {
    return view('test');
    });
});
