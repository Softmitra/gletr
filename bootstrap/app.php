<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders([
        App\Providers\RepositoryServiceProvider::class,
    ])
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')
                ->group(base_path('routes/admin.php'));
            
            Route::middleware('web')
                ->prefix('seller')
                ->group(base_path('routes/seller.php'));
            
            Route::middleware('web')
                ->group(base_path('routes/customer.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Register role-based middleware
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'admin.auth' => \App\Http\Middleware\AdminAuth::class,
            'seller' => \App\Http\Middleware\SellerMiddleware::class,
            'seller.auth' => \App\Http\Middleware\SellerAuth::class,
            'seller.verified' => \App\Http\Middleware\EnsureSellerVerified::class,
            'customer' => \App\Http\Middleware\CustomerMiddleware::class,
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'permission' => \App\Http\Middleware\PermissionMiddleware::class,
            'session.security' => \App\Http\Middleware\SessionSecurity::class,
            'admin.logs' => \App\Http\Middleware\AdminLogAccess::class,
            'user.activity' => \App\Http\Middleware\UserActivityMiddleware::class,

        ]);
        
        // Apply session security to all authenticated routes
        $middleware->appendToGroup('web', \App\Http\Middleware\SessionSecurity::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
