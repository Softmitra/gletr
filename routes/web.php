<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\SellerPromotionController;
use App\Http\Controllers\Auth\SellerRegistrationController;
use App\Http\Controllers\Auth\SellerLoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Public Routes
Route::get('/products', function() { return view('pages.products'); })->name('products.index');
Route::get('/products/search', function() { return view('pages.products'); })->name('products.search');
Route::get('/products/{product}', function() { return view('pages.product-detail'); })->name('products.show');
Route::get('/categories', function() { return view('pages.products'); })->name('categories.index');
Route::get('/categories/{category}', function() { return view('pages.products'); })->name('categories.show');

// New Static Pages
Route::get('/home', function() { return view('pages.home'); })->name('home.static');
Route::get('/cart', function() { return view('pages.cart'); })->name('cart');
Route::get('/checkout', function() { return view('pages.checkout'); })->name('checkout');

// Category Pages
Route::get('/rings', function() { return view('pages.products'); })->name('rings');
Route::get('/necklaces', function() { return view('pages.products'); })->name('necklaces');
Route::get('/earrings', function() { return view('pages.products'); })->name('earrings');
Route::get('/bracelets', function() { return view('pages.products'); })->name('bracelets');
Route::get('/gold', function() { return view('pages.products'); })->name('gold');
Route::get('/silver', function() { return view('pages.products'); })->name('silver');
Route::get('/diamond', function() { return view('pages.products'); })->name('diamond');
Route::get('/platinum', function() { return view('pages.products'); })->name('platinum');

// Seller Routes
Route::get('/become-seller', [SellerPromotionController::class, 'index'])->name('seller.promotion');
Route::get('/seller/register', [SellerRegistrationController::class, 'create'])->name('seller.register');
Route::post('/seller/register', [SellerRegistrationController::class, 'store'])
    ->middleware('throttle:2,1'); // 2 seller registration attempts per minute
Route::get('/seller/document-requirements', [SellerRegistrationController::class, 'getDocumentRequirements'])->name('seller.document-requirements');

// Seller Registration Validation Routes
Route::post('/seller/check-email', [SellerRegistrationController::class, 'checkEmail'])->name('seller.check-email');
Route::post('/seller/check-phone', [SellerRegistrationController::class, 'checkPhone'])->name('seller.check-phone');
Route::post('/seller/check-pan', [SellerRegistrationController::class, 'checkPan'])->name('seller.check-pan');
Route::post('/seller/check-gst', [SellerRegistrationController::class, 'checkGst'])->name('seller.check-gst');

// Seller Authentication Routes
Route::get('/seller/login', [SellerLoginController::class, 'create'])->name('seller.login');
Route::post('/seller/login', [SellerLoginController::class, 'store'])->name('seller.login.store');
Route::post('/seller/logout', [SellerLoginController::class, 'destroy'])->name('seller.logout');
Route::get('/seller/registration-success', function() { 
    return view('auth.seller-registration-success'); 
})->name('seller.registration.success');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Seller routes
Route::middleware(['auth'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', function () {
        return view('seller.dashboard');
    })->name('dashboard');
    
    // Store management routes
    Route::get('/store', [App\Http\Controllers\Seller\StoreController::class, 'show'])->name('store.show');
    Route::get('/store/create', [App\Http\Controllers\Seller\StoreController::class, 'create'])->name('store.create');
    Route::post('/store', [App\Http\Controllers\Seller\StoreController::class, 'store'])->name('store.store');
    Route::get('/store/edit', [App\Http\Controllers\Seller\StoreController::class, 'edit'])->name('store.edit');
    Route::put('/store', [App\Http\Controllers\Seller\StoreController::class, 'update'])->name('store.update');
});

// Public store route
Route::get('/store/{slug}', [App\Http\Controllers\Seller\StoreController::class, 'publicShow'])->name('store.public');

// Two-Factor Authentication Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/two-factor/setup', [\App\Http\Controllers\Auth\TwoFactorController::class, 'show'])->name('two-factor.setup');
    Route::post('/two-factor/enable', [\App\Http\Controllers\Auth\TwoFactorController::class, 'enable'])->name('two-factor.enable');
    Route::get('/two-factor/recovery-codes', [\App\Http\Controllers\Auth\TwoFactorController::class, 'recoveryCodes'])->name('two-factor.recovery-codes');
    Route::post('/two-factor/recovery-codes', [\App\Http\Controllers\Auth\TwoFactorController::class, 'regenerateRecoveryCodes'])->name('two-factor.recovery-codes.regenerate');
    Route::delete('/two-factor/disable', [\App\Http\Controllers\Auth\TwoFactorController::class, 'disable'])->name('two-factor.disable');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/two-factor/challenge', [\App\Http\Controllers\Auth\TwoFactorController::class, 'challenge'])->name('two-factor.challenge');
    Route::post('/two-factor/challenge', [\App\Http\Controllers\Auth\TwoFactorController::class, 'verify'])->name('two-factor.verify');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
