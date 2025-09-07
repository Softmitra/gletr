<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Repository bindings will be added here when Product repository is implemented
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set the default redirect path for authentication
        if (!defined('HOME')) {
            define('HOME', '/admin');
        }
        
        // Configure authentication redirects for different guards
        $this->configureAuthenticationRedirects();
    }
    
    /**
     * Configure authentication redirects for different guards
     */
    private function configureAuthenticationRedirects(): void
    {
        // Configure default redirect paths for different authentication scenarios
        
        // For admin authentication failures, redirect to admin login
        $this->app['auth']->viaRequest('admin', function ($request) {
            // This will be handled by middleware
            return null;
        });
        
        // Set up proper redirect handling for unauthenticated requests
        $this->app->bind('Illuminate\Auth\Middleware\Authenticate', function ($app) {
            return new class extends \Illuminate\Auth\Middleware\Authenticate {
                protected function redirectTo($request)
                {
                    if (!$request->expectsJson()) {
                        // Check if this is an admin route
                        if ($request->is('admin/*')) {
                            return route('admin.login');
                        }
                        
                        // Check if this is a seller route
                        if ($request->is('seller/*')) {
                            return route('seller.login');
                        }
                        
                        // Default to admin login for other authenticated routes
                        return route('admin.login');
                    }
                }
            };
        });
    }
}
