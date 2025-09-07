<?php

namespace App\Services\Interfaces;

interface SellerProductServiceInterface
{
    /**
     * Get product listing data
     */
    public function getProductListing(int $sellerId, array $filters = [], int $perPage = 15): array;

    /**
     * Get product dashboard data
     */
    public function getProductDashboard(int $sellerId): array;

    /**
     * Get product for editing
     */
    public function getProductForEdit(int $sellerId, int $productId): array;

    /**
     * Create new product
     */
    public function createProduct(int $sellerId, array $data): array;

    /**
     * Update product
     */
    public function updateProduct(int $sellerId, int $productId, array $data): bool;

    /**
     * Delete product
     */
    public function deleteProduct(int $sellerId, int $productId): bool;

    /**
     * Toggle product status
     */
    public function toggleProductStatus(int $sellerId, int $productId): bool;

    /**
     * Get product statistics
     */
    public function getProductStatistics(int $sellerId): array;

    /**
     * Search products
     */
    public function searchProducts(int $sellerId, string $query, int $perPage = 15): array;

    /**
     * Bulk actions on products
     */
    public function bulkAction(int $sellerId, string $action, array $productIds): array;

    /**
     * Get product import template
     */
    public function getImportTemplate(): array;

    /**
     * Import products from file
     */
    public function importProducts(int $sellerId, $file): array;

    /**
     * Export products
     */
    public function exportProducts(int $sellerId, array $filters = []): array;
}
