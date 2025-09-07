<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories.
     */
    public function index()
    {
        $categories = Category::whereNull('parent_id')
            ->with(['children' => function ($query) {
                $query->where('is_active', true);
            }])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('web.categories.index', compact('categories'));
    }

    /**
     * Display the specified category.
     */
    public function show(Category $category)
    {
        // Get subcategories if this is a parent category
        if ($category->parent_id === null) {
            $subcategories = Category::where('parent_id', $category->id)
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get();

            return view('web.categories.show', compact('category', 'subcategories'));
        }

        // Get products for this category
        $products = Product::where('category_id', $category->id)
            ->where('status', 'active')
            ->with(['seller', 'variants'])
            ->paginate(12);

        return view('web.categories.show', compact('category', 'products'));
    }

    /**
     * Get products by category for AJAX requests.
     */
    public function products(Category $category)
    {
        $products = Product::where('category_id', $category->id)
            ->where('status', 'active')
            ->with(['seller', 'variants'])
            ->paginate(12);

        return response()->json($products);
    }
}
