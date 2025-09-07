<?php

namespace App\Services;

use App\Repositories\Interfaces\SellerProductRepositoryInterface;
use App\Services\Interfaces\SellerProductServiceInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SellerProductService implements SellerProductServiceInterface
{
    public function __construct(
        private SellerProductRepositoryInterface $productRepository
    ) {}

    /**
     * Get product listing data
     */
    public function getProductListing(int $sellerId, array $filters = [], int $perPage = 15): array
    {
        $products = $this->productRepository->getSellerProducts($sellerId, $filters, $perPage);
        $stats = $this->productRepository->getProductStats($sellerId);

        return [
            'products' => $products,
            'stats' => $stats,
            'filters' => $filters,
        ];
    }

    /**
     * Get product dashboard data
     */
    public function getProductDashboard(int $sellerId): array
    {
        $stats = $this->productRepository->getProductStats($sellerId);
        $recentProducts = $this->productRepository->getSellerProducts($sellerId, [], 5);

        return [
            'stats' => $stats,
            'recent_products' => $recentProducts,
            'quick_stats' => [
                'total_products' => $stats['total_products'],
                'active_products' => $stats['active_products'],
                'draft_products' => $stats['draft_products'],
                'out_of_stock' => $stats['out_of_stock'],
            ],
        ];
    }

    /**
     * Get product for editing
     */
    public function getProductForEdit(int $sellerId, int $productId): array
    {
        $product = $this->productRepository->getSellerProduct($sellerId, $productId);
        
        if (!$product) {
            throw new \Exception('Product not found or access denied');
        }

        return [
            'product' => $product,
            'categories' => [], // TODO: Implement when Category model is available
            'attributes' => [], // TODO: Implement when ProductAttribute model is available
        ];
    }

    /**
     * Create new product
     */
    public function createProduct(int $sellerId, array $data): array
    {
        // Validate product data
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'sku' => 'nullable|string|max:100',
            'category_id' => 'nullable|integer',
            'status' => 'required|in:active,inactive,draft',
            'stock_quantity' => 'required|integer|min:0',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        try {
            $product = $this->productRepository->createProduct($sellerId, $validator->validated());

            Log::info('Product created', [
                'seller_id' => $sellerId,
                'product_id' => $product->id ?? null,
                'product_name' => $data['name']
            ]);

            return [
                'success' => true,
                'product' => $product,
                'message' => 'Product created successfully'
            ];
        } catch (\Exception $e) {
            Log::error('Failed to create product', [
                'seller_id' => $sellerId,
                'error' => $e->getMessage()
            ]);

            throw new \Exception('Failed to create product: ' . $e->getMessage());
        }
    }

    /**
     * Update product
     */
    public function updateProduct(int $sellerId, int $productId, array $data): bool
    {
        // Validate product data
        $validator = Validator::make($data, [
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric|min:0',
            'sku' => 'nullable|string|max:100',
            'category_id' => 'nullable|integer',
            'status' => 'sometimes|in:active,inactive,draft',
            'stock_quantity' => 'sometimes|integer|min:0',
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        $updated = $this->productRepository->updateProduct($sellerId, $productId, $validator->validated());

        if ($updated) {
            Log::info('Product updated', [
                'seller_id' => $sellerId,
                'product_id' => $productId,
                'updated_fields' => array_keys($validator->validated())
            ]);
        }

        return $updated;
    }

    /**
     * Delete product
     */
    public function deleteProduct(int $sellerId, int $productId): bool
    {
        $deleted = $this->productRepository->deleteProduct($sellerId, $productId);

        if ($deleted) {
            Log::info('Product deleted', [
                'seller_id' => $sellerId,
                'product_id' => $productId
            ]);
        }

        return $deleted;
    }

    /**
     * Toggle product status
     */
    public function toggleProductStatus(int $sellerId, int $productId): bool
    {
        $toggled = $this->productRepository->toggleProductStatus($sellerId, $productId);

        if ($toggled) {
            Log::info('Product status toggled', [
                'seller_id' => $sellerId,
                'product_id' => $productId
            ]);
        }

        return $toggled;
    }

    /**
     * Get product statistics
     */
    public function getProductStatistics(int $sellerId): array
    {
        return $this->productRepository->getProductStats($sellerId);
    }

    /**
     * Search products
     */
    public function searchProducts(int $sellerId, string $query, int $perPage = 15): array
    {
        $products = $this->productRepository->searchProducts($sellerId, $query, $perPage);

        return [
            'products' => $products,
            'query' => $query,
            'total' => $products->total(),
        ];
    }

    /**
     * Bulk actions on products
     */
    public function bulkAction(int $sellerId, string $action, array $productIds): array
    {
        if (empty($productIds)) {
            throw new \Exception('No products selected');
        }

        $result = ['success' => 0, 'failed' => 0, 'message' => ''];

        switch ($action) {
            case 'activate':
                $updated = $this->productRepository->bulkUpdateProducts($sellerId, $productIds, ['status' => 'active']);
                $result['success'] = $updated;
                $result['message'] = "{$updated} products activated successfully";
                break;

            case 'deactivate':
                $updated = $this->productRepository->bulkUpdateProducts($sellerId, $productIds, ['status' => 'inactive']);
                $result['success'] = $updated;
                $result['message'] = "{$updated} products deactivated successfully";
                break;

            case 'delete':
                foreach ($productIds as $productId) {
                    if ($this->productRepository->deleteProduct($sellerId, $productId)) {
                        $result['success']++;
                    } else {
                        $result['failed']++;
                    }
                }
                $result['message'] = "{$result['success']} products deleted successfully";
                break;

            default:
                throw new \Exception('Invalid bulk action');
        }

        Log::info('Bulk action performed', [
            'seller_id' => $sellerId,
            'action' => $action,
            'product_count' => count($productIds),
            'result' => $result
        ]);

        return $result;
    }

    /**
     * Get product import template
     */
    public function getImportTemplate(): array
    {
        return [
            'headers' => [
                'name', 'description', 'price', 'sku', 'category', 
                'stock_quantity', 'status', 'weight', 'dimensions'
            ],
            'sample_data' => [
                [
                    'name' => 'Sample Product',
                    'description' => 'Product description here',
                    'price' => '99.99',
                    'sku' => 'SKU001',
                    'category' => 'Electronics',
                    'stock_quantity' => '10',
                    'status' => 'active',
                    'weight' => '0.5',
                    'dimensions' => '10x10x5'
                ]
            ]
        ];
    }

    /**
     * Import products from file
     */
    public function importProducts(int $sellerId, $file): array
    {
        // TODO: Implement CSV/Excel import functionality
        return [
            'success' => 0,
            'failed' => 0,
            'errors' => [],
            'message' => 'Import functionality will be implemented soon'
        ];
    }

    /**
     * Export products
     */
    public function exportProducts(int $sellerId, array $filters = []): array
    {
        // TODO: Implement CSV/Excel export functionality
        return [
            'file_path' => null,
            'message' => 'Export functionality will be implemented soon'
        ];
    }
}
