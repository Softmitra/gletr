<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\Seller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display seller dashboard
     */
    public function index()
    {
        $seller = $this->getCurrentSeller();
        
        if (!$seller) {
            return redirect()->route('seller.profile.create')
                ->with('message', 'Please complete your seller profile first.');
        }

        $stats = [
            'total_products' => Product::where('seller_id', $seller->id)->count(),
            'active_products' => Product::where('seller_id', $seller->id)->where('status', 'active')->count(),
            'total_orders' => Order::whereHas('items.product', function($q) use ($seller) {
                $q->where('seller_id', $seller->id);
            })->count(),
            'pending_orders' => Order::whereHas('items.product', function($q) use ($seller) {
                $q->where('seller_id', $seller->id);
            })->where('status', 'pending')->count(),
        ];

        $recent_products = Product::where('seller_id', $seller->id)->latest()->take(5)->get();
        
        return view('seller.dashboard', compact('stats', 'recent_products', 'seller'));
    }

    /**
     * Display seller products
     */
    public function products()
    {
        $seller = $this->getCurrentSeller();
        $products = Product::where('seller_id', $seller->id)->with('category')->paginate(20);
        
        return view('seller.products.index', compact('products'));
    }

    /**
     * Display seller orders
     */
    public function orders()
    {
        $seller = $this->getCurrentSeller();
        $orders = Order::whereHas('items.product', function($q) use ($seller) {
            $q->where('seller_id', $seller->id);
        })->with(['user', 'items.product'])->paginate(20);
        
        return view('seller.orders.index', compact('orders'));
    }

    /**
     * Get current authenticated seller
     */
    private function getCurrentSeller()
    {
        return Seller::where('email', auth()->user()->email)->first();
    }
}
