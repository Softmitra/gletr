<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Services\PricingService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private PricingService $pricingService
    ) {}

    /**
     * Display products listing
     */
    public function index(Request $request): View
    {
        $filters = $request->only([
            'category_id', 'metal_type', 'purity', 'price_min', 'price_max', 
            'sort_by', 'sort_order', 'per_page'
        ]);
        
        $products = $this->productRepository->findWithFilters($filters);
        
        // Get filter options
        $categories = Category::where('is_active', true)
            ->whereNull('parent_id')
            ->with('children')
            ->get();
        
        $metalTypes = ['gold', 'silver', 'platinum', 'diamond'];
        $purities = ['24k', '22k', '18k', '14k', '925', '950'];

        return view('web.products.index', compact('products', 'categories', 'metalTypes', 'purities', 'filters'));
    }

    /**
     * Display single product
     */
    public function show(Product $product): View
    {
        // Load product with all relationships
        $product = $this->productRepository->findWithRelations($product->id, [
            'category', 'seller', 'variants.inventory', 'media', 'reviews.user'
        ]);

        if (!$product || $product->status !== 'live') {
            abort(404);
        }

        // Get pricing breakdown for main variant
        $mainVariant = $product->variants->first();
        $priceBreakdown = null;
        if ($mainVariant) {
            $priceBreakdown = $this->pricingService->getPriceBreakdown($mainVariant);
        }

        // Get related products
        $relatedProducts = $this->productRepository->getRelatedProducts($product, 4);

        return view('web.products.show', compact('product', 'priceBreakdown', 'relatedProducts'));
    }

    /**
     * Display products by category
     */
    public function category(Category $category, Request $request): View
    {
        $filters = $request->only([
            'metal_type', 'purity', 'price_min', 'price_max', 
            'sort_by', 'sort_order', 'per_page'
        ]);
        
        $filters['category_id'] = $category->id;
        
        $products = $this->productRepository->findWithFilters($filters);
        
        // Get filter options specific to this category
        $metalTypes = ['gold', 'silver', 'platinum', 'diamond'];
        $purities = ['24k', '22k', '18k', '14k', '925', '950'];

        return view('web.products.category', compact('category', 'products', 'metalTypes', 'purities', 'filters'));
    }

    /**
     * Get product variants via AJAX
     */
    public function variants(Product $product): \Illuminate\Http\JsonResponse
    {
        $variants = $product->variants()
            ->with('inventory')
            ->get()
            ->map(function ($variant) {
                $priceBreakdown = $this->pricingService->calculateVariantPricing($variant);
                
                return [
                    'id' => $variant->id,
                    'sku' => $variant->sku,
                    'size' => $variant->size,
                    'net_metal_weight' => $variant->net_metal_weight,
                    'gross_weight' => $variant->gross_weight,
                    'price' => $priceBreakdown['final_price'],
                    'mrp' => $variant->mrp,
                    'in_stock' => $variant->inventory ? $variant->inventory->quantity > 0 : false,
                    'stock_quantity' => $variant->inventory ? $variant->inventory->quantity : 0,
                    'price_breakdown' => $priceBreakdown
                ];
            });

        return response()->json($variants);
    }

    /**
     * Quick view product via AJAX
     */
    public function quickView(Product $product): \Illuminate\Http\JsonResponse
    {
        $product = $this->productRepository->findWithRelations($product->id, [
            'seller', 'variants.inventory', 'media'
        ]);

        if (!$product || $product->status !== 'live') {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $mainVariant = $product->variants->first();
        $priceBreakdown = null;
        if ($mainVariant) {
            $priceBreakdown = $this->pricingService->getPriceBreakdown($mainVariant);
        }

        return response()->json([
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'metal_type' => $product->metal_type,
                'purity' => $product->purity,
                'hallmark_no' => $product->hallmark_no,
                'seller' => [
                    'name' => $product->seller->name,
                    'id' => $product->seller->id
                ],
                'images' => $product->getMedia('images')->map(function ($media) {
                    return [
                        'original' => $media->getUrl(),
                        'thumb' => $media->getUrl('thumb'),
                        'medium' => $media->getUrl('medium')
                    ];
                }),
                'variants' => $product->variants->map(function ($variant) {
                    return [
                        'id' => $variant->id,
                        'size' => $variant->size,
                        'price' => $this->pricingService->calculateVariantPricing($variant)['final_price'],
                        'in_stock' => $variant->inventory ? $variant->inventory->quantity > 0 : false
                    ];
                }),
                'price_breakdown' => $priceBreakdown
            ]
        ]);
    }
}
