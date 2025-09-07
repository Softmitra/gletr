<?php

namespace App\Providers;

use App\Contracts\SellerSessionRepositoryInterface;
use App\Contracts\SellerSessionServiceInterface;
use App\Repositories\Interfaces\SellerAuthRepositoryInterface;
use App\Repositories\Interfaces\SellerStoreRepositoryInterface;
use App\Repositories\SellerSessionRepository;
use App\Repositories\SellerAuthRepository;
use App\Repositories\SellerStoreRepository;
use App\Services\SellerSessionService;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Bind Seller Session Repository Interface to Implementation
        $this->app->bind(
            SellerSessionRepositoryInterface::class,
            SellerSessionRepository::class
        );

        // Bind Seller Session Service Interface to Implementation
        $this->app->bind(
            SellerSessionServiceInterface::class,
            SellerSessionService::class
        );

        // Bind Seller Auth Repository Interface to Implementation
        $this->app->bind(
            SellerAuthRepositoryInterface::class,
            SellerAuthRepository::class
        );

        // Bind Seller Store Repository Interface to Implementation
        $this->app->bind(
            SellerStoreRepositoryInterface::class,
            SellerStoreRepository::class
        );

        // Bind Seller Profile Repository Interface to Implementation
        $this->app->bind(
            \App\Repositories\Interfaces\SellerProfileRepositoryInterface::class,
            \App\Repositories\SellerProfileRepository::class
        );

        // Bind Seller Profile Service Interface to Implementation
        $this->app->bind(
            \App\Services\Interfaces\SellerProfileServiceInterface::class,
            \App\Services\SellerProfileService::class
        );

        // Bind Seller Store Management Repository Interface to Implementation
        $this->app->bind(
            \App\Repositories\Interfaces\SellerStoreManagementRepositoryInterface::class,
            \App\Repositories\SellerStoreManagementRepository::class
        );

        // Bind Seller Store Service Interface to Implementation
        $this->app->bind(
            \App\Services\Interfaces\SellerStoreServiceInterface::class,
            \App\Services\SellerStoreService::class
        );

        // Bind Seller Product Repository Interface to Implementation
        $this->app->bind(
            \App\Repositories\Interfaces\SellerProductRepositoryInterface::class,
            \App\Repositories\SellerProductRepository::class
        );

        // Bind Seller Product Service Interface to Implementation
        $this->app->bind(
            \App\Services\Interfaces\SellerProductServiceInterface::class,
            \App\Services\SellerProductService::class
        );

        // Bind Seller Order Repository Interface to Implementation
        $this->app->bind(
            \App\Repositories\Interfaces\SellerOrderRepositoryInterface::class,
            \App\Repositories\SellerOrderRepository::class
        );

        // Bind Seller Order Service Interface to Implementation
        $this->app->bind(
            \App\Services\Interfaces\SellerOrderServiceInterface::class,
            \App\Services\SellerOrderService::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}