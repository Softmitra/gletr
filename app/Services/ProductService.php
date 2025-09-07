<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Seller;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Exception;

class ProductService
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private PricingService $pricingService,
        private MediaService $mediaService
    ) {}

    /**
     * Create a new product for a seller
     */
    public function createProduct(array $data, Seller $seller): Product
    {
        DB::beginTransaction();
        try {
            $product = $this->productRepository->create([
                'seller_id' => $seller->id,
                'name' => $data['name'],
                'description' => $data['description'],
                'category_id' => $data['category_id'],
                'metal_type' => $data['metal_type'],
                'purity' => $data['purity'],
                'hallmark_no' => $data['hallmark_no'] ?? null,
                'certificate_no' => $data['certificate_no'] ?? null,
                'status' => 'draft',
                'warranty_policy' => $data['warranty_policy'] ?? null,
                'care_instructions' => $data['care_instructions'] ?? null,
            ]);
            
            // Attach images if provided
            if (isset($data['images']) && !empty($data['images'])) {
                $this->mediaService->attachImages($product, $data['images']);
            }
            
            // Calculate initial pricing
            $this->pricingService->calculateProductPricing($product);
            
            DB::commit();
            return $product;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Update product information
     */
    public function updateProduct(Product $product, array $data): Product
    {
        DB::beginTransaction();
        try {
            $product = $this->productRepository->update($product, $data);
            
            // Update images if provided
            if (isset($data['images'])) {
                $this->mediaService->updateImages($product, $data['images']);
            }
            
            // Recalculate pricing if pricing-related fields changed
            if (isset($data['metal_type']) || isset($data['purity']) || isset($data['making_charges'])) {
                $this->pricingService->calculateProductPricing($product);
            }
            
            DB::commit();
            return $product;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Get products with filters
     */
    public function getFilteredProducts(array $filters): LengthAwarePaginator
    {
        return $this->productRepository->findWithFilters($filters);
    }

    /**
     * Get products by seller
     */
    public function getSellerProducts(Seller $seller): Collection
    {
        return $this->productRepository->findBySeller($seller);
    }

    /**
     * Submit product for approval
     */
    public function submitForApproval(Product $product): bool
    {
        if ($product->status !== 'draft') {
            throw new Exception('Only draft products can be submitted for approval');
        }

        return $this->productRepository->update($product, ['status' => 'pending']);
    }

    /**
     * Approve product (Admin only)
     */
    public function approveProduct(Product $product, ?string $notes = null): bool
    {
        return $this->productRepository->update($product, [
            'status' => 'live',
            'approved_at' => now(),
            'qa_notes' => $notes
        ]);
    }

    /**
     * Reject product (Admin only)
     */
    public function rejectProduct(Product $product, string $reason): bool
    {
        return $this->productRepository->update($product, [
            'status' => 'rejected',
            'qa_notes' => $reason
        ]);
    }
}
