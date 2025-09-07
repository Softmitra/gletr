<?php

use App\Http\Controllers\Auth\SellerAuthController;
use App\Http\Controllers\Auth\SellerLogoutController;
// use App\Http\Controllers\Seller\DashboardController;
use App\Http\Controllers\Seller\ProfileController;
use App\Http\Controllers\Seller\StoreController;
use App\Http\Controllers\Seller\ProductController;
use App\Http\Controllers\Seller\OrderController;
// use App\Http\Controllers\Seller\AnalyticsController;
use App\Http\Controllers\Seller\SessionController;
use App\Http\Controllers\Seller\VerificationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Seller Routes
|--------------------------------------------------------------------------
|
| These routes are for seller users and are protected by seller middleware
|
*/

// Note: Seller login routes are handled in routes/web.php to avoid conflicts

// Seller Authenticated Routes
Route::middleware(['seller.auth'])->group(function () {
    
    // Logout
    Route::post('/logout', SellerLogoutController::class)->name('seller.logout');
    
    // Dashboard
    Route::get('/dashboard', [SellerAuthController::class, 'dashboard'])->name('seller.dashboard');
    Route::get('/', [SellerAuthController::class, 'dashboard'])->name('seller.home');
    
    // Verification Status
    Route::prefix('verification')->name('seller.verification.')->group(function () {
        Route::get('/', [VerificationController::class, 'index'])->name('status');
        Route::get('/documents', [VerificationController::class, 'documents'])->name('documents');
        Route::get('/documents/{document}/download', [VerificationController::class, 'downloadDocument'])->name('documents.download');
        Route::get('/documents/{document}/resubmit', [VerificationController::class, 'resubmitDocument'])->name('documents.resubmit');
        Route::post('/documents/{document}/resubmit', [VerificationController::class, 'storeResubmission'])->name('documents.resubmit.store');
    });
    
    // Profile Management
    Route::prefix('profile')->name('seller.profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/update', [ProfileController::class, 'update'])->name('update');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
        Route::post('/avatar', [ProfileController::class, 'updateAvatar'])->name('avatar.update');
        Route::get('/business', [ProfileController::class, 'editBusiness'])->name('business.edit');
        Route::put('/business', [ProfileController::class, 'updateBusiness'])->name('business.update');
        Route::get('/contact', [ProfileController::class, 'editContact'])->name('contact.edit');
        Route::put('/contact', [ProfileController::class, 'updateContact'])->name('contact.update');
        Route::get('/settings', [ProfileController::class, 'settings'])->name('settings');
        Route::get('/activity', [ProfileController::class, 'activity'])->name('activity');
    });
    
    // Store Management
    Route::prefix('store')->name('seller.store.')->group(function () {
        Route::get('/', [StoreController::class, 'show'])->name('show');
        Route::get('/edit', [StoreController::class, 'edit'])->name('edit');
        Route::put('/update', [StoreController::class, 'update'])->name('update');
        Route::get('/settings', [StoreController::class, 'settings'])->name('settings');
        Route::put('/settings', [StoreController::class, 'updateSettings'])->name('settings.update');
        Route::get('/branding', [StoreController::class, 'branding'])->name('branding');
        Route::put('/branding', [StoreController::class, 'updateBranding'])->name('branding.update');
    });

    // Product Management
    Route::prefix('products')->name('seller.products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/{product}', [ProductController::class, 'show'])->name('show');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
        Route::post('/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('toggle-status');
        
        // Bulk actions
        Route::post('/bulk-action', [ProductController::class, 'bulkAction'])->name('bulk-action');
        
        // Import/Export
        Route::get('/import', [ProductController::class, 'importForm'])->name('import');
        Route::post('/import', [ProductController::class, 'import'])->name('import.post');
        Route::get('/export', [ProductController::class, 'export'])->name('export');
        
        // AJAX endpoints
        Route::get('/performance', [ProductController::class, 'getPerformance'])->name('performance');
    });

    // Order Management
    Route::prefix('orders')->name('seller.orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        Route::put('/{order}/status', [OrderController::class, 'updateStatus'])->name('update-status');
        Route::post('/{order}/fulfillment', [OrderController::class, 'fulfillment'])->name('fulfillment');
        Route::post('/{order}/refund', [OrderController::class, 'refund'])->name('refund');
        Route::post('/{order}/return', [OrderController::class, 'handleReturn'])->name('handle-return');
        Route::post('/{order}/note', [OrderController::class, 'addNote'])->name('add-note');
        Route::get('/{order}/invoice', [OrderController::class, 'invoice'])->name('invoice');
        Route::get('/{order}/shipping-label', [OrderController::class, 'shippingLabel'])->name('shipping-label');
        
        // Bulk actions
        Route::post('/bulk-action', [OrderController::class, 'bulkAction'])->name('bulk-action');
        
        // Export
        Route::get('/export', [OrderController::class, 'export'])->name('export');
        
        // AJAX endpoints
        Route::get('/analytics', [OrderController::class, 'analytics'])->name('analytics');
        Route::get('/metrics', [OrderController::class, 'metrics'])->name('metrics');
        Route::get('/requires-attention', [OrderController::class, 'requiresAttention'])->name('requires-attention');
    });

    // TODO: Uncomment when controllers are created
    /*
    
    // Analytics & Reports
    Route::prefix('analytics')->name('seller.analytics.')->group(function () {
        Route::get('/', [AnalyticsController::class, 'index'])->name('index');
        Route::get('/sales', [AnalyticsController::class, 'sales'])->name('sales');
        Route::get('/products', [AnalyticsController::class, 'products'])->name('products');
        Route::get('/customers', [AnalyticsController::class, 'customers'])->name('customers');
        Route::get('/inventory', [AnalyticsController::class, 'inventory'])->name('inventory');
        Route::get('/financial', [AnalyticsController::class, 'financial'])->name('financial');
        
        // Export reports
        Route::get('/export/{type}', [AnalyticsController::class, 'export'])->name('export');
    });
    */
    
    // Session Management
    Route::prefix('sessions')->name('seller.sessions.')->group(function () {
        Route::get('/', [SessionController::class, 'index'])->name('index');
        Route::delete('/{sessionId}', [SessionController::class, 'destroy'])->name('destroy');
        Route::post('/terminate-all', [SessionController::class, 'terminateAll'])->name('terminate-all');
        Route::get('/activity', [SessionController::class, 'activity'])->name('activity');
    });
    
    // Settings
    Route::prefix('settings')->name('seller.settings.')->group(function () {
        Route::get('/', [ProfileController::class, 'settings'])->name('index');
        // TODO: Implement these when needed
        // Route::put('/notifications', [ProfileController::class, 'updateNotifications'])->name('notifications');
        // Route::put('/preferences', [ProfileController::class, 'updatePreferences'])->name('preferences');
        // Route::get('/security', [ProfileController::class, 'security'])->name('security');
        // Route::put('/security', [ProfileController::class, 'updateSecurity'])->name('security.update');
    });

    // TODO: Uncomment when controllers are created
    /*
    
    // API Routes for AJAX calls
    Route::prefix('api')->name('seller.api.')->group(function () {
        Route::get('/stats', [DashboardController::class, 'getStats'])->name('stats');
        Route::get('/recent-orders', [OrderController::class, 'getRecentOrders'])->name('recent-orders');
        Route::get('/product-performance', [ProductController::class, 'getPerformance'])->name('product-performance');
        Route::get('/notifications', [DashboardController::class, 'getNotifications'])->name('notifications');
        Route::post('/notifications/{id}/read', [DashboardController::class, 'markNotificationRead'])->name('notifications.read');
    });
    */
});