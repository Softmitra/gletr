<?php

namespace App\Repositories\Interfaces;

use App\Models\Seller;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface SellerProductRepositoryInterface
{
    /**
     * Get seller products with pagination
     */
    public function getSellerProducts(int $sellerId, array $filters = [], int $perPage = 15): LengthAwarePaginator;

    /**
     * Get seller product by ID
     */
    public function getSellerProduct(int $sellerId, int $productId): ?object;

    /**
     * Create new product for seller
     */
    public function createProduct(int $sellerId, array $data): ?object;

    /**
     * Update seller product
     */
    public function updateProduct(int $sellerId, int $productId, array $data): bool;

    /**
     * Delete seller product
     */
    public function deleteProduct(int $sellerId, int $productId): bool;

    /**
     * Get product statistics for seller
     */
    public function getProductStats(int $sellerId): array;

    /**
     * Toggle product status
     */
    public function toggleProductStatus(int $sellerId, int $productId): bool;

    /**
     * Get products by status
     */
    public function getProductsByStatus(int $sellerId, string $status, int $perPage = 15): LengthAwarePaginator;

    /**
     * Search seller products
     */
    public function searchProducts(int $sellerId, string $query, int $perPage = 15): LengthAwarePaginator;

    /**
     * Bulk update products
     */
    public function bulkUpdateProducts(int $sellerId, array $productIds, array $data): int;
}
