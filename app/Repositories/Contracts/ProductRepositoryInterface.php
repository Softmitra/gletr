<?php

namespace App\Repositories\Contracts;

use App\Models\Product;
use App\Models\Seller;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{
    /**
     * Find products by seller
     */
    public function findBySeller(Seller $seller): Collection;

    /**
     * Find products with filters and pagination
     */
    public function findWithFilters(array $filters): LengthAwarePaginator;

    /**
     * Find products by category
     */
    public function findByCategory(Category $category): Collection;

    /**
     * Find product by ID with relationships
     */
    public function findWithRelations(int $id, array $relations = []): ?Product;

    /**
     * Create a new product
     */
    public function create(array $data): Product;

    /**
     * Update product
     */
    public function update(Product $product, array $data): Product;

    /**
     * Delete product
     */
    public function delete(Product $product): bool;

    /**
     * Find products by status
     */
    public function findByStatus(string $status): Collection;

    /**
     * Search products by text
     */
    public function search(string $query, array $filters = []): LengthAwarePaginator;

    /**
     * Get featured products
     */
    public function getFeaturedProducts(int $limit = 10): Collection;

    /**
     * Get products with low stock
     */
    public function getLowStockProducts(Seller $seller, int $threshold = 5): Collection;

    /**
     * Get related products
     */
    public function getRelatedProducts(Product $product, int $limit = 4): Collection;

    /**
     * Update product status
     */
    public function updateStatus(Product $product, string $status): bool;

    /**
     * Get products by price range
     */
    public function getByPriceRange(float $minPrice, float $maxPrice): Collection;

    /**
     * Get top selling products
     */
    public function getTopSellingProducts(int $limit = 10): Collection;
}
