<?php

use App\Http\Controllers\Customer\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Customer Routes
|--------------------------------------------------------------------------
|
| These routes are for customer users and are protected by customer middleware
|
*/

Route::middleware(['auth', 'customer'])->prefix('customer')->name('customer.')->group(function () {
    
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    
    // Orders Management
    Route::get('/orders', [DashboardController::class, 'orders'])->name('orders.index');
    Route::get('/orders/{order}', function () {
        return view('customer.orders.show');
    })->name('orders.show');
    
    // Reviews Management
    Route::get('/reviews', [DashboardController::class, 'reviews'])->name('reviews.index');
    Route::post('/reviews', function () {
        return redirect()->back()->with('success', 'Review submitted successfully');
    })->name('reviews.store');
    
    // Profile Management
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile.edit');
    Route::patch('/profile', function () {
        return redirect()->back()->with('success', 'Profile updated successfully');
    })->name('profile.update');
    
    // Wishlist
    Route::get('/wishlist', [DashboardController::class, 'wishlist'])->name('wishlist.index');
    Route::post('/wishlist/{product}', function () {
        return redirect()->back()->with('success', 'Added to wishlist');
    })->name('wishlist.add');
    Route::delete('/wishlist/{product}', function () {
        return redirect()->back()->with('success', 'Removed from wishlist');
    })->name('wishlist.remove');
    
    // Address Management (placeholder)
    Route::get('/addresses', function () {
        return view('customer.addresses.index');
    })->name('addresses.index');
    
});
