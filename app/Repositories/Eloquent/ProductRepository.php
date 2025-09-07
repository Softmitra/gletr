<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Models\Seller;
use App\Models\Category;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * Find products by seller
     */
    public function findBySeller(Seller $seller): Collection
    {
        return Product::where('seller_id', $seller->id)
            ->with(['category', 'variants', 'media'])
            ->get();
    }

    /**
     * Find products with filters and pagination
     */
    public function findWithFilters(array $filters): LengthAwarePaginator
    {
        $query = Product::query()
            ->with(['category', 'seller', 'variants', 'media'])
            ->where('status', 'live');

        // Filter by category
        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        // Filter by metal type
        if (!empty($filters['metal_type'])) {
            $query->where('metal_type', $filters['metal_type']);
        }

        // Filter by purity
        if (!empty($filters['purity'])) {
            $query->where('purity', $filters['purity']);
        }

        // Filter by price range (using variants)
        if (!empty($filters['price_min']) || !empty($filters['price_max'])) {
            $query->whereHas('variants', function ($q) use ($filters) {
                if (!empty($filters['price_min'])) {
                    $q->where('sale_price', '>=', $filters['price_min']);
                }
                if (!empty($filters['price_max'])) {
                    $q->where('sale_price', '<=', $filters['price_max']);
                }
            });
        }

        // Filter by seller
        if (!empty($filters['seller_id'])) {
            $query->where('seller_id', $filters['seller_id']);
        }

        // Search by name or description
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('description', 'like', '%' . $filters['search'] . '%');
            });
        }

        // Sort options
        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortOrder = $filters['sort_order'] ?? 'desc';
        
        switch ($sortBy) {
            case 'price_low':
                $query->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
                      ->orderBy('product_variants.sale_price', 'asc');
                break;
            case 'price_high':
                $query->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
                      ->orderBy('product_variants.sale_price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', $sortOrder);
                break;
            default:
                $query->orderBy($sortBy, $sortOrder);
                break;
        }

        $perPage = $filters['per_page'] ?? 20;
        return $query->paginate($perPage);
    }

    /**
     * Find products by category
     */
    public function findByCategory(Category $category): Collection
    {
        return Product::where('category_id', $category->id)
            ->where('status', 'live')
            ->with(['seller', 'variants', 'media'])
            ->get();
    }

    /**
     * Find product by ID with relationships
     */
    public function findWithRelations(int $id, array $relations = []): ?Product
    {
        $defaultRelations = ['category', 'seller', 'variants', 'media', 'reviews'];
        $relations = !empty($relations) ? $relations : $defaultRelations;

        return Product::with($relations)->find($id);
    }

    /**
     * Create a new product
     */
    public function create(array $data): Product
    {
        return Product::create($data);
    }

    /**
     * Update product
     */
    public function update(Product $product, array $data): Product
    {
        $product->update($data);
        return $product->fresh();
    }

    /**
     * Delete product
     */
    public function delete(Product $product): bool
    {
        return $product->delete();
    }

    /**
     * Find products by status
     */
    public function findByStatus(string $status): Collection
    {
        return Product::where('status', $status)
            ->with(['category', 'seller', 'variants'])
            ->get();
    }

    /**
     * Search products by text
     */
    public function search(string $query, array $filters = []): LengthAwarePaginator
    {
        $searchQuery = Product::query()
            ->where('status', 'live')
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                  ->orWhere('description', 'like', '%' . $query . '%')
                  ->orWhere('hallmark_no', 'like', '%' . $query . '%')
                  ->orWhere('certificate_no', 'like', '%' . $query . '%');
            })
            ->with(['category', 'seller', 'variants', 'media']);

        // Apply additional filters
        if (!empty($filters)) {
            $searchQuery = $this->applyFilters($searchQuery, $filters);
        }

        return $searchQuery->paginate($filters['per_page'] ?? 20);
    }

    /**
     * Get featured products
     */
    public function getFeaturedProducts(int $limit = 10): Collection
    {
        return Product::where('status', 'live')
            ->where('is_featured', true)
            ->with(['seller', 'variants', 'media'])
            ->limit($limit)
            ->get();
    }

    /**
     * Get products with low stock
     */
    public function getLowStockProducts(Seller $seller, int $threshold = 5): Collection
    {
        return Product::where('seller_id', $seller->id)
            ->whereHas('variants', function ($q) use ($threshold) {
                $q->whereHas('inventory', function ($inv) use ($threshold) {
                    $inv->where('quantity', '<=', $threshold);
                });
            })
            ->with(['variants.inventory'])
            ->get();
    }

    /**
     * Get related products
     */
    public function getRelatedProducts(Product $product, int $limit = 4): Collection
    {
        return Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'live')
            ->where('metal_type', $product->metal_type)
            ->with(['seller', 'variants', 'media'])
            ->limit($limit)
            ->get();
    }

    /**
     * Update product status
     */
    public function updateStatus(Product $product, string $status): bool
    {
        return $product->update(['status' => $status]);
    }

    /**
     * Get products by price range
     */
    public function getByPriceRange(float $minPrice, float $maxPrice): Collection
    {
        return Product::whereHas('variants', function ($q) use ($minPrice, $maxPrice) {
            $q->whereBetween('sale_price', [$minPrice, $maxPrice]);
        })
        ->where('status', 'live')
        ->with(['seller', 'variants', 'media'])
        ->get();
    }

    /**
     * Get top selling products
     */
    public function getTopSellingProducts(int $limit = 10): Collection
    {
        return Product::select('products.*', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->leftJoin('order_items', 'product_variants.id', '=', 'order_items.product_variant_id')
            ->leftJoin('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('products.status', 'live')
            ->where('orders.status', 'delivered')
            ->groupBy('products.id')
            ->orderBy('total_sold', 'desc')
            ->with(['seller', 'variants', 'media'])
            ->limit($limit)
            ->get();
    }

    /**
     * Apply filters to query
     */
    private function applyFilters($query, array $filters)
    {
        foreach ($filters as $key => $value) {
            if (empty($value)) continue;

            switch ($key) {
                case 'category_id':
                    $query->where('category_id', $value);
                    break;
                case 'metal_type':
                    $query->where('metal_type', $value);
                    break;
                case 'purity':
                    $query->where('purity', $value);
                    break;
                case 'seller_id':
                    $query->where('seller_id', $value);
                    break;
            }
        }

        return $query;
    }
}
