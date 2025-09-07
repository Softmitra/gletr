<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the homepage
     */
    public function index(): View
    {
        try {
            // For now, return empty collections until Product model is implemented
            $featuredProducts = collect();
            $topSellingProducts = collect();
            
            // Get main categories if Category model exists
            $categories = collect();
            if (class_exists(Category::class)) {
                $categories = Category::whereNull('parent_id')
                    ->where('is_active', true)
                    ->with('children')
                    ->orderBy('sort_order')
                    ->limit(6)
                    ->get();
            }
        } catch (\Exception $e) {
            // If there's any error, return empty collections
            $featuredProducts = collect();
            $topSellingProducts = collect();
            $categories = collect();
        }

        return view('web.home', compact('featuredProducts', 'topSellingProducts', 'categories'));
    }

    /**
     * Search products
     */
    public function search(Request $request): View
    {
        $query = $request->input('q', '');
        $filters = $request->only(['category_id', 'metal_type', 'purity', 'price_min', 'price_max', 'sort_by']);
        
        // For now, return empty collection until Product repository is implemented
        $products = collect();
        
        return view('web.search', compact('products', 'query', 'filters'));
    }
}
