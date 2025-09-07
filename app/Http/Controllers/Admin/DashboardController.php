<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Seller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_sellers' => Seller::count(),
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'pending_sellers' => Seller::where('status', 'pending')->count(),
            'active_sellers' => Seller::where('status', 'active')->count(),
        ];

        $recent_users = User::latest()->take(5)->get();
        $recent_sellers = Seller::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_users', 'recent_sellers'));
    }

    /**
     * Display users management
     */
    public function users()
    {
        $users = User::with('roles')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Display sellers management
     */
    public function sellers(Request $request)
    {
        // Build query with filters
        $query = Seller::query();
        
        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('f_name', 'like', "%{$search}%")
                  ->orWhere('l_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('gst_number', 'like', "%{$search}%")
                  ->orWhere('pan_number', 'like', "%{$search}%");
            });
        }
        
        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Verification status filter
        if ($request->filled('verification_status')) {
            $query->where('verification_status', $request->verification_status);
        }
        
        // Business type filter
        if ($request->filled('business_type')) {
            $query->where('business_type', $request->business_type);
        }
        
        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $sellers = $query->paginate(20);
        
        // Calculate statistics
        $stats = [
            'total_sellers' => Seller::count(),
            'active_sellers' => Seller::where('status', 'active')->count(),
            'pending_sellers' => Seller::where('status', 'pending')->count(),
            'suspended_sellers' => Seller::where('status', 'suspended')->count(),
            'verified_sellers' => Seller::where('verification_status', 'verified')->count(),
            'new_sellers_today' => Seller::whereDate('created_at', today())->count(),
        ];
        
        return view('admin.sellers.index', compact('sellers', 'stats'));
    }

    /**
     * Display products management
     */
    public function products()
    {
        $products = Product::with(['seller', 'category'])->paginate(20);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new seller
     */
    public function createSeller()
    {
        return view('admin.sellers.create');
    }

    /**
     * Store a newly created seller
     */
    public function storeSeller(Request $request)
    {
        $validatedData = $request->validate([
            'f_name' => 'required|string|max:255',
            'l_name' => 'required|string|max:255',
            'email' => 'required|email|unique:sellers,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'country_code' => 'nullable|string|max:10',
            'business_name' => 'nullable|string|max:255',
            'business_type' => 'nullable|in:individual,partnership,company,llp',
            'gst_number' => 'nullable|string|max:15',
            'pan_number' => 'nullable|string|max:10',
            'sales_commission_percentage' => 'nullable|numeric|min:0|max:100',
            'minimum_order_amount' => 'nullable|numeric|min:0',
            'free_delivery_over_amount' => 'nullable|numeric|min:0',
            'free_delivery_status' => 'nullable|boolean',
            'pos_status' => 'nullable|boolean',
            'address_line_1' => 'nullable|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'area' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'pincode' => 'nullable|string|max:10',
        ]);

        // Hash password
        $validatedData['password'] = bcrypt($validatedData['password']);
        
        // Convert checkbox values
        $validatedData['free_delivery_status'] = $request->has('free_delivery_status') ? 1 : 0;
        $validatedData['pos_status'] = $request->has('pos_status') ? 1 : 0;
        
        // Set default values
        $validatedData['status'] = 'active';
        $validatedData['verification_status'] = 'pending';

        $seller = Seller::create($validatedData);

        return redirect()->route('admin.sellers.show', $seller)->with('success', 'Seller created successfully');
    }

    /**
     * Display the specified seller
     */
    public function showSeller(Seller $seller)
    {
        return view('admin.sellers.show', compact('seller'));
    }

    /**
     * Show the form for editing the specified seller
     */
    public function editSeller(Seller $seller)
    {
        return view('admin.sellers.edit', compact('seller'));
    }

    /**
     * Update the specified seller
     */
    public function updateSeller(Request $request, Seller $seller)
    {
        $validatedData = $request->validate([
            'f_name' => 'required|string|max:255',
            'l_name' => 'required|string|max:255',
            'email' => 'required|email|unique:sellers,email,' . $seller->id,
            'phone' => 'nullable|string|max:20',
            'country_code' => 'nullable|string|max:10',
            'business_name' => 'nullable|string|max:255',
            'business_type' => 'nullable|in:individual,partnership,company,llp',
            'gst_number' => 'nullable|string|max:15',
            'pan_number' => 'nullable|string|max:10',
            'status' => 'required|in:active,inactive,suspended',
            'verification_status' => 'required|in:pending,verified,rejected',
            'sales_commission_percentage' => 'nullable|numeric|min:0|max:100',
            'minimum_order_amount' => 'nullable|numeric|min:0',
            'free_delivery_over_amount' => 'nullable|numeric|min:0',
            'free_delivery_status' => 'nullable|boolean',
            'pos_status' => 'nullable|boolean',
            'address_line_1' => 'nullable|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'area' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'pincode' => 'nullable|string|max:10',
            'bank_name' => 'nullable|string|max:255',
            'branch' => 'nullable|string|max:255',
            'ifsc_code' => 'nullable|string|max:11',
            'account_no' => 'nullable|string|max:20',
            'holder_name' => 'nullable|string|max:255',
            'verification_notes' => 'nullable|string',
        ]);

        // Convert checkbox values
        $validatedData['free_delivery_status'] = $request->has('free_delivery_status') ? 1 : 0;
        $validatedData['pos_status'] = $request->has('pos_status') ? 1 : 0;

        // Set verification completed timestamp if status changed to verified
        if ($validatedData['verification_status'] === 'verified' && $seller->verification_status !== 'verified') {
            $validatedData['verification_completed_at'] = now();
        }

        $seller->update($validatedData);

        return redirect()->route('admin.sellers.show', $seller)->with('success', 'Seller updated successfully');
    }

    /**
     * Remove the specified seller
     */
    public function destroySeller(Seller $seller)
    {
        $seller->delete();
        return redirect()->route('admin.sellers.index')->with('success', 'Seller deleted successfully');
    }

    /**
     * Suspend a seller
     */
    public function suspendSeller(Seller $seller)
    {
        $seller->update(['status' => 'suspended']);
        return response()->json(['success' => true]);
    }

    /**
     * Activate a seller
     */
    public function activateSeller(Seller $seller)
    {
        $seller->update(['status' => 'active']);
        return response()->json(['success' => true]);
    }

    /**
     * Approve a seller
     */
    public function approveSeller(Seller $seller)
    {
        $seller->update([
            'status' => 'active',
            'verification_status' => 'verified',
            'is_verified' => true,
            'verification_completed_at' => now()
        ]);
        return response()->json(['success' => true, 'message' => 'Seller approved successfully']);
    }

    /**
     * Perform bulk actions on sellers
     */
    public function bulkActionSellers(Request $request)
    {
        $action = $request->action;
        $sellerIds = $request->sellers;

        switch ($action) {
            case 'activate':
                Seller::whereIn('id', $sellerIds)->update(['status' => 'active']);
                break;
            case 'suspend':
                Seller::whereIn('id', $sellerIds)->update(['status' => 'suspended']);
                break;
            case 'approve':
                Seller::whereIn('id', $sellerIds)->update([
                    'status' => 'active',
                    'verification_status' => 'verified',
                    'is_verified' => true,
                    'verification_completed_at' => now()
                ]);
                break;
            case 'delete':
                Seller::whereIn('id', $sellerIds)->delete();
                break;
        }

        return response()->json(['success' => true]);
    }

    /**
     * Show seller products
     */
    public function sellerProducts(Seller $seller)
    {
        $products = $seller->product()->with(['category'])->paginate(15);
        return view('admin.sellers.products', compact('seller', 'products'));
    }

    /**
     * Show seller orders
     */
    public function sellerOrders(Seller $seller)
    {
        $orders = $seller->orders()->with(['user', 'items'])->paginate(15);
        return view('admin.sellers.orders', compact('seller', 'orders'));
    }

    /**
     * Show seller team
     */
    public function sellerTeam(Seller $seller)
    {
        $teamMembers = $seller->teamMembers()->paginate(15);
        return view('admin.sellers.team', compact('seller', 'teamMembers'));
    }

    /**
     * Show seller analytics
     */
    public function sellerAnalytics(Seller $seller)
    {
        // Calculate analytics data
        $analytics = [
            'total_products' => $seller->product()->count(),
            'active_products' => $seller->product()->where('status', 'active')->count(),
            'total_orders' => $seller->orders_count,
            'total_revenue' => $seller->orders()->sum('grand_total') ?? 0,
            'avg_order_value' => $seller->orders_count > 0 ? ($seller->orders()->sum('grand_total') / $seller->orders_count) : 0,
        ];
        
        return view('admin.sellers.analytics', compact('seller', 'analytics'));
    }

    /**
     * Show seller payments
     */
    public function sellerPayments(Seller $seller)
    {
        // Get payments related to seller's orders
        $payments = collect(); // Placeholder - implement based on your payment structure
        return view('admin.sellers.payments', compact('seller', 'payments'));
    }

    /**
     * Show seller reviews
     */
    public function sellerReviews(Seller $seller)
    {
        // Get reviews for seller's products
        $reviews = collect(); // Placeholder - implement based on your review structure
        return view('admin.sellers.reviews', compact('seller', 'reviews'));
    }

    /**
     * Show seller settings
     */
    public function sellerSettings(Seller $seller)
    {
        return view('admin.sellers.settings', compact('seller'));
    }
}
