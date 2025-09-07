<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoleManagementController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\UserProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| These routes are for admin users only and are protected by admin middleware
|
*/

// Admin login redirect (for convenience) - REMOVED TO PREVENT REDIRECT LOOP
// The actual admin login route is now handled in routes/auth.php

Route::middleware(['admin', 'user.activity'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    
    // Users Management
    Route::prefix('users')->name('users.')->group(function () {
    Route::get('/', [UserManagementController::class, 'index'])->name('index');
    Route::get('/{user}', [UserManagementController::class, 'show'])->name('show');
    Route::get('/{user}/sessions', [UserManagementController::class, 'sessions'])->name('sessions');
    Route::get('/{user}/activities', [UserManagementController::class, 'activities'])->name('activities');
    
    // User actions
    Route::post('/{user}/suspend', [UserManagementController::class, 'suspend'])->name('suspend');
    Route::post('/{user}/activate', [UserManagementController::class, 'activate'])->name('activate');
    Route::post('/{user}/ban', [UserManagementController::class, 'ban'])->name('ban');
    Route::post('/{user}/reset-password', [UserManagementController::class, 'resetPassword'])->name('reset-password');
    Route::post('/{user}/terminate-all-sessions', [UserManagementController::class, 'terminateAllSessions'])->name('terminate-all-sessions');
    
    // Session management
    Route::delete('/sessions/{session}', [UserManagementController::class, 'terminateSession'])->name('terminate-session');
    
    // Charts and exports
    Route::get('/{user}/activity-chart', [UserManagementController::class, 'activityChart'])->name('activity-chart');
    Route::get('/{user}/export', [UserManagementController::class, 'export'])->name('export');
    
    // Bulk actions
    Route::post('/bulk-action', [UserManagementController::class, 'bulkAction'])->name('bulk-action');
});

// Global user sessions and activities routes (for menu items)
Route::get('/users/sessions', [UserManagementController::class, 'allSessions'])->name('users.all-sessions');
Route::get('/users/activities', [UserManagementController::class, 'allActivities'])->name('users.all-activities');

// User Profile Management
Route::prefix('user-profiles')->name('user-profiles.')->group(function () {
    Route::get('/', [UserProfileController::class, 'index'])->name('index');
    Route::get('/create', [UserProfileController::class, 'create'])->name('create');
    Route::post('/', [UserProfileController::class, 'store'])->name('store');
    Route::get('/{user}', [UserProfileController::class, 'show'])->name('show');
    Route::get('/{user}/edit', [UserProfileController::class, 'edit'])->name('edit');
    Route::put('/{user}', [UserProfileController::class, 'update'])->name('update');
    Route::delete('/{user}', [UserProfileController::class, 'destroy'])->name('destroy');
    Route::put('/{user}/password', [UserProfileController::class, 'updatePassword'])->name('update-password');
    Route::post('/{user}/toggle-status', [UserProfileController::class, 'toggleStatus'])->name('toggle-status');
    Route::post('/bulk-action', [UserProfileController::class, 'bulkAction'])->name('bulk-action');
});

// Customer Management
Route::prefix('customers')->name('customers.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('index');
    Route::get('/{customer}', [\App\Http\Controllers\Admin\CustomerController::class, 'show'])->name('show');
    Route::get('/{customer}/edit', [\App\Http\Controllers\Admin\CustomerController::class, 'edit'])->name('edit');
    Route::put('/{customer}', [\App\Http\Controllers\Admin\CustomerController::class, 'update'])->name('update');
    Route::delete('/{customer}', [\App\Http\Controllers\Admin\CustomerController::class, 'destroy'])->name('destroy');
    Route::post('/{customer}/toggle-status', [\App\Http\Controllers\Admin\CustomerController::class, 'toggleStatus'])->name('toggle-status');
    Route::post('/{customer}/reset-password', [\App\Http\Controllers\Admin\CustomerController::class, 'resetPassword'])->name('reset-password');
    Route::post('/bulk-action', [\App\Http\Controllers\Admin\CustomerController::class, 'bulkAction'])->name('bulk-action');
    Route::get('/{customer}/orders', [\App\Http\Controllers\Admin\CustomerController::class, 'orders'])->name('orders');
    Route::get('/{customer}/reviews', [\App\Http\Controllers\Admin\CustomerController::class, 'reviews'])->name('reviews');
});

// Customer Reviews Management
Route::prefix('customer-reviews')->name('customer-reviews.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\CustomerReviewController::class, 'index'])->name('index');
    Route::get('/{review}', [\App\Http\Controllers\Admin\CustomerReviewController::class, 'show'])->name('show');
    Route::put('/{review}/approve', [\App\Http\Controllers\Admin\CustomerReviewController::class, 'approve'])->name('approve');
    Route::put('/{review}/reject', [\App\Http\Controllers\Admin\CustomerReviewController::class, 'reject'])->name('reject');
    Route::delete('/{review}', [\App\Http\Controllers\Admin\CustomerReviewController::class, 'destroy'])->name('destroy');
    Route::post('/bulk-action', [\App\Http\Controllers\Admin\CustomerReviewController::class, 'bulkAction'])->name('bulk-action');
});
    
    // Sellers Management
    Route::get('/sellers', [DashboardController::class, 'sellers'])->name('sellers.index');
    Route::get('/sellers/create', [DashboardController::class, 'createSeller'])->name('sellers.create');
    Route::post('/sellers', [DashboardController::class, 'storeSeller'])->name('sellers.store');
    Route::get('/sellers/{seller}', [DashboardController::class, 'showSeller'])->name('sellers.show');
    Route::get('/sellers/{seller}/edit', [DashboardController::class, 'editSeller'])->name('sellers.edit');
    Route::put('/sellers/{seller}', [DashboardController::class, 'updateSeller'])->name('sellers.update');
    Route::delete('/sellers/{seller}', [DashboardController::class, 'destroySeller'])->name('sellers.destroy');
    Route::post('/sellers/{seller}/suspend', [DashboardController::class, 'suspendSeller'])->name('sellers.suspend');
    Route::post('/sellers/{seller}/activate', [DashboardController::class, 'activateSeller'])->name('sellers.activate');
    Route::post('/sellers/{seller}/approve', [DashboardController::class, 'approveSeller'])->name('sellers.approve');
    Route::post('/sellers/bulk-action', [DashboardController::class, 'bulkActionSellers'])->name('sellers.bulk-action');
    
    // Seller-specific management routes
    Route::get('/sellers/{seller}/products', [DashboardController::class, 'sellerProducts'])->name('sellers.products');
    Route::get('/sellers/{seller}/orders', [DashboardController::class, 'sellerOrders'])->name('sellers.orders');
    Route::get('/sellers/{seller}/team', [DashboardController::class, 'sellerTeam'])->name('sellers.team');
    Route::get('/sellers/{seller}/analytics', [DashboardController::class, 'sellerAnalytics'])->name('sellers.analytics');
    Route::get('/sellers/{seller}/payments', [DashboardController::class, 'sellerPayments'])->name('sellers.payments');
    Route::get('/sellers/{seller}/reviews', [DashboardController::class, 'sellerReviews'])->name('sellers.reviews');
    Route::get('/sellers/{seller}/settings', [DashboardController::class, 'sellerSettings'])->name('sellers.settings');
    
    // Products Management
    Route::get('/products', [DashboardController::class, 'products'])->name('products.index');
    
    // Categories Management (placeholder)
    Route::get('/categories', function () {
        return view('admin.categories.index');
    })->name('categories.index');
    
    // Orders Management (placeholder)
    Route::get('/orders', function () {
        return view('admin.orders.index');
    })->name('orders.index');
    
    // Business Setup Management
    Route::prefix('business')->name('business.')->group(function () {
        // Main business setup page
        Route::get('/setup', [\App\Http\Controllers\Admin\BusinessSetupController::class, 'index'])->name('setup');
        
        // Individual tab pages
        Route::get('/setup/general', [\App\Http\Controllers\Admin\BusinessSetupController::class, 'general'])->name('setup.general');
        Route::get('/setup/website-setup', [\App\Http\Controllers\Admin\BusinessSetupController::class, 'websiteSetup'])->name('setup.website-setup');
        Route::get('/setup/sellers', [\App\Http\Controllers\Admin\BusinessSetupController::class, 'sellers'])->name('setup.sellers');
        Route::get('/setup/commission-setup', [\App\Http\Controllers\Admin\BusinessSetupController::class, 'commissionSetup'])->name('setup.commission-setup');
        
        // AJAX endpoints for loading tab content
        Route::get('/setup/ajax/{tab}', [\App\Http\Controllers\Admin\BusinessSetupController::class, 'loadTabContent'])->name('setup.ajax');
        
        // Individual tab pages
        Route::get('/setup/email-settings', [\App\Http\Controllers\Admin\BusinessSetupController::class, 'emailSettings'])->name('setup.email-settings');
        
        // Update endpoints
        Route::put('/setup/general', [\App\Http\Controllers\Admin\BusinessSetupController::class, 'updateGeneral'])->name('setup.general.update');
        Route::put('/setup/website-setup', [\App\Http\Controllers\Admin\BusinessSetupController::class, 'updateWebsiteSetup'])->name('setup.website-setup.update');
        Route::put('/setup/sellers', [\App\Http\Controllers\Admin\BusinessSetupController::class, 'updateSellers'])->name('setup.sellers.update');
        Route::put('/setup/commission-setup', [\App\Http\Controllers\Admin\BusinessSetupController::class, 'updateCommissionSetup'])->name('setup.commission-setup.update');
        Route::put('/setup/email-settings', [\App\Http\Controllers\Admin\BusinessSetupController::class, 'updateEmailSettings'])->name('setup.email-settings.update');
        
        // Email configuration AJAX endpoints
        Route::post('/setup/email-settings/toggle', [\App\Http\Controllers\Admin\BusinessSetupController::class, 'toggleEmailConfig'])->name('setup.email-settings.toggle');
        Route::post('/setup/email-settings/initialize', [\App\Http\Controllers\Admin\BusinessSetupController::class, 'initializeEmailConfigs'])->name('setup.email-settings.initialize');
        Route::post('/setup/email-settings/test', [\App\Http\Controllers\Admin\BusinessSetupController::class, 'testEmailConfig'])->name('setup.email-settings.test');
        Route::get('/setup/email-settings/preview', [\App\Http\Controllers\Admin\BusinessSetupController::class, 'previewEmailTemplate'])->name('setup.email-settings.preview');
    });

    // Document Requirements API Routes
    Route::prefix('document-requirements')->name('document-requirements.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\DocumentRequirementController::class, 'index'])->name('index');
        Route::post('/', [\App\Http\Controllers\Admin\DocumentRequirementController::class, 'store'])->name('store');
        Route::get('/{documentRequirement}', [\App\Http\Controllers\Admin\DocumentRequirementController::class, 'show'])->name('show');
        Route::put('/{documentRequirement}', [\App\Http\Controllers\Admin\DocumentRequirementController::class, 'update'])->name('update');
        Route::delete('/{documentRequirement}', [\App\Http\Controllers\Admin\DocumentRequirementController::class, 'destroy'])->name('destroy');
        Route::get('/document-types', [\App\Http\Controllers\Admin\DocumentRequirementController::class, 'getDocumentTypes'])->name('document-types');
        Route::get('/seller-types', [\App\Http\Controllers\Admin\DocumentRequirementController::class, 'getSellerTypes'])->name('seller-types');
    });

    // Settings Management
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('index');
        Route::put('/', [\App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('update');
        Route::get('/file-storage', [\App\Http\Controllers\Admin\SettingsController::class, 'fileStorage'])->name('file-storage');
        Route::put('/file-storage', [\App\Http\Controllers\Admin\SettingsController::class, 'updateFileStorage'])->name('file-storage.update');
        Route::post('/test-s3', [\App\Http\Controllers\Admin\SettingsController::class, 'testS3Connection'])->name('test-s3');
        Route::get('/reset', [\App\Http\Controllers\Admin\SettingsController::class, 'reset'])->name('reset');
        Route::get('/export', [\App\Http\Controllers\Admin\SettingsController::class, 'export'])->name('export');
        Route::post('/import', [\App\Http\Controllers\Admin\SettingsController::class, 'import'])->name('import');
    });
    
    // Analytics (placeholder)
    Route::get('/analytics', function () {
        return view('admin.analytics.index');
    })->name('analytics.index');
    
    // System Logs - Custom Log Viewer
    Route::get('/logs', [\App\Http\Controllers\Admin\CustomLogViewerController::class, 'index'])
        ->middleware('admin.logs')
        ->name('logs.index');
    
    Route::get('/logs/download', [\App\Http\Controllers\Admin\CustomLogViewerController::class, 'download'])
        ->middleware('admin.logs')
        ->name('logs.download');
    
    Route::delete('/logs/delete', [\App\Http\Controllers\Admin\CustomLogViewerController::class, 'delete'])
        ->middleware('admin.logs')
        ->name('logs.delete');
    
    Route::delete('/logs/clear', [\App\Http\Controllers\Admin\CustomLogViewerController::class, 'clear'])
        ->middleware('admin.logs')
        ->name('logs.clear');
    
    // Generate test logs (for demonstration)
    Route::post('/logs/generate-test', [\App\Http\Controllers\Admin\LogTestController::class, 'generateTestLogs'])
        ->middleware('admin.logs')
        ->name('logs.generate-test');
    
    // Seller Verification Management
    Route::prefix('seller-verification')->name('seller-verification.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\SellerVerificationController::class, 'index'])->name('index');
        Route::get('/{seller}', [\App\Http\Controllers\Admin\SellerVerificationController::class, 'show'])->name('show');
        Route::post('/{seller}/verify-document', [\App\Http\Controllers\Admin\SellerVerificationController::class, 'verifyDocument'])->name('verify-document');
        Route::post('/{seller}/approve', [\App\Http\Controllers\Admin\SellerVerificationController::class, 'approveSeller'])->name('approve');
        Route::post('/{seller}/reject', [\App\Http\Controllers\Admin\SellerVerificationController::class, 'rejectSeller'])->name('reject');
        Route::post('/{seller}/assign-reviewer', [\App\Http\Controllers\Admin\SellerVerificationController::class, 'assignReviewer'])->name('assign-reviewer');
        Route::get('/stats/data', [\App\Http\Controllers\Admin\SellerVerificationController::class, 'getStats'])->name('stats');
        Route::get('/{seller}/document/{documentId}/download', [\App\Http\Controllers\Admin\SellerVerificationController::class, 'downloadDocument'])->name('download-document');
    });

    // Seller Session Management
    Route::prefix('seller-sessions')->name('seller-sessions.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\SellerSessionController::class, 'index'])->name('index');
        Route::get('/analytics', [\App\Http\Controllers\Admin\SellerSessionController::class, 'analytics'])->name('analytics');
        Route::get('/{session}', [\App\Http\Controllers\Admin\SellerSessionController::class, 'show'])->name('show');
        Route::post('/{session}/terminate', [\App\Http\Controllers\Admin\SellerSessionController::class, 'terminate'])->name('terminate');
        Route::post('/seller/{seller}/terminate-all', [\App\Http\Controllers\Admin\SellerSessionController::class, 'terminateAllForSeller'])->name('terminate-all-for-seller');
    });

    // Seller Activity Management
    Route::prefix('seller-activities')->name('seller-activities.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\SellerActivityController::class, 'index'])->name('index');
        Route::get('/analytics', [\App\Http\Controllers\Admin\SellerActivityController::class, 'analytics'])->name('analytics');
        Route::get('/{activity}', [\App\Http\Controllers\Admin\SellerActivityController::class, 'show'])->name('show');
        Route::get('/seller/{seller}', [\App\Http\Controllers\Admin\SellerActivityController::class, 'sellerActivities'])->name('seller');
    });

    // Role & Permission Management
    Route::prefix('roles')->name('roles.')->group(function () {
        Route::get('/', [RoleManagementController::class, 'index'])->name('index');
        Route::get('/create', [RoleManagementController::class, 'create'])->name('create');
        Route::post('/', [RoleManagementController::class, 'store'])->name('store');
        
        // User role management (must come before {role} routes)
        Route::get('/users', [RoleManagementController::class, 'users'])->name('users');
        Route::post('/users/assign', [RoleManagementController::class, 'assignRole'])->name('users.assign');
        Route::post('/users/remove', [RoleManagementController::class, 'removeRole'])->name('users.remove');
        Route::post('/users/bulk', [RoleManagementController::class, 'bulkAssign'])->name('users.bulk');
        Route::get('/users/search', [RoleManagementController::class, 'searchUsers'])->name('users.search');
        
        // Role-specific routes (must come after specific routes)
        Route::get('/{role}', [RoleManagementController::class, 'show'])->name('show');
        Route::get('/{role}/edit', [RoleManagementController::class, 'edit'])->name('edit');
        Route::put('/{role}', [RoleManagementController::class, 'update'])->name('update');
        Route::delete('/{role}', [RoleManagementController::class, 'destroy'])->name('destroy');
        Route::get('/{role}/permissions', [RoleManagementController::class, 'getRolePermissions'])->name('permissions');
    });
    
});
