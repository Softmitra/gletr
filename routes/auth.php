<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\OtpVerificationController;
use App\Http\Controllers\Auth\SellerVerificationController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store'])
        ->middleware('throttle:3,1'); // 3 registration attempts per minute

    Route::get('admin/login', [AuthenticatedSessionController::class, 'create'])
        ->name('admin.login');

    Route::post('admin/login', [AuthenticatedSessionController::class, 'store'])
        ->name('admin.login.store')
        ->middleware('throttle:5,1'); // 5 attempts per minute

    // Default login route - redirect to admin login
    Route::get('login', function () {
        return redirect()->route('admin.login');
    })->name('login');
    
    // Handle POST to default login route - redirect to admin login POST
    Route::post('login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('throttle:5,1');
    


    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email')
        ->middleware('throttle:3,1'); // 3 password reset attempts per minute

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');

    // OTP Email Verification Routes
    Route::get('verify-email-otp', [OtpVerificationController::class, 'showVerificationForm'])
        ->name('seller.verify-email');
    
    Route::post('verify-email-otp', [OtpVerificationController::class, 'verifyOtp'])
        ->name('seller.verify-email.store')
        ->middleware('throttle:5,1'); // 5 attempts per minute
    
    Route::post('resend-otp', [OtpVerificationController::class, 'resendOtp'])
        ->name('seller.resend-otp')
        ->middleware('throttle:3,1'); // 3 resend attempts per minute
    
    Route::get('otp-status', [OtpVerificationController::class, 'checkOtpStatus'])
        ->name('seller.otp-status');

    // Verification Recovery Routes
    Route::get('verification-recovery', [SellerVerificationController::class, 'showRecoveryForm'])
        ->name('seller.verification.recovery');
    
    Route::post('verification-recovery', [SellerVerificationController::class, 'handleRecovery'])
        ->name('seller.verification.recovery.store')
        ->middleware('throttle:5,1'); // 5 attempts per minute
    
    Route::post('verification-status', [SellerVerificationController::class, 'checkVerificationStatus'])
        ->name('seller.verification.status')
        ->middleware('throttle:10,1'); // 10 status checks per minute
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', LogoutController::class)
        ->name('logout');
});
