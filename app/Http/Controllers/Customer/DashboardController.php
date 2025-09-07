<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Review;
use App\Models\Cart;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display customer dashboard
     */
    public function index()
    {
        $user = auth()->user();
        
        $stats = [
            'total_orders' => Order::where('user_id', $user->id)->count(),
            'pending_orders' => Order::where('user_id', $user->id)->where('status', 'pending')->count(),
            'completed_orders' => Order::where('user_id', $user->id)->where('status', 'completed')->count(),
            'total_reviews' => Review::where('user_id', $user->id)->count(),
        ];

        $recent_orders = Order::where('user_id', $user->id)
            ->with(['items.product'])
            ->latest()
            ->take(5)
            ->get();
        
        return view('customer.dashboard', compact('stats', 'recent_orders'));
    }

    /**
     * Display customer orders
     */
    public function orders()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with(['items.product', 'items.variant'])
            ->paginate(20);
        
        return view('customer.orders.index', compact('orders'));
    }

    /**
     * Display customer reviews
     */
    public function reviews()
    {
        $reviews = Review::where('user_id', auth()->id())
            ->with('product')
            ->paginate(20);
        
        return view('customer.reviews.index', compact('reviews'));
    }

    /**
     * Display customer profile
     */
    public function profile()
    {
        $user = auth()->user();
        return view('customer.profile.edit', compact('user'));
    }

    /**
     * Display customer wishlist
     */
    public function wishlist()
    {
        // This will be implemented when wishlist functionality is added
        return view('customer.wishlist.index');
    }
}
