<?php

use App\Http\Controllers\Auth\SellerAuthController;
use App\Http\Controllers\Seller\SessionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Seller Routes (Simplified for Testing)
|--------------------------------------------------------------------------
|
| Essential seller routes for testing session management
|
*/

// Seller Authentication Routes (Guest only)
Route::middleware('guest:seller')->group(function () {
    Route::get('/login', [SellerAuthController::class, 'showLoginForm'])->name('seller.login');
    Route::post('/login', [SellerAuthController::class, 'login'])->name('seller.login.post');
});

// Seller Authenticated Routes
Route::middleware(['auth:seller', 'seller'])->group(function () {
    
    // Logout
    Route::post('/logout', [SellerAuthController::class, 'logout'])->name('seller.logout');
    
    // Dashboard
    Route::get('/dashboard', [SellerAuthController::class, 'dashboard'])->name('seller.dashboard');
    Route::get('/', [SellerAuthController::class, 'dashboard'])->name('seller.home');
    
    // Verification Status
    Route::prefix('verification')->name('seller.verification.')->group(function () {
        Route::get('/status', [SellerAuthController::class, 'verificationStatus'])->name('status');
    });
    
    // Session Management
    Route::prefix('sessions')->name('seller.sessions.')->group(function () {
        Route::get('/', [SessionController::class, 'index'])->name('index');
        Route::delete('/{sessionId}', [SessionController::class, 'destroy'])->name('destroy');
        Route::post('/terminate-all', [SessionController::class, 'terminateAll'])->name('terminate-all');
        Route::get('/activity', [SessionController::class, 'activity'])->name('activity');
    });
});
