<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
class CustomerController extends Controller
{

    /**
     * Display a listing of customers
     */
    public function index(Request $request)
    {
        $query = User::whereHas('roles', function($q) {
            $q->where('name', 'customer');
        })->with(['profile', 'roles']);

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhereHas('profile', function($profileQuery) use ($search) {
                      $profileQuery->where('phone', 'like', '%' . $search . '%');
                  });
            });
        }

        // Status filter
        if ($request->has('status') && !empty($request->status)) {
            switch ($request->status) {
                case 'active':
                    $query->where('status', 'active');
                    break;
                case 'inactive':
                    $query->where('status', 'inactive');
                    break;
                case 'suspended':
                    $query->where('status', 'suspended');
                    break;
                case 'banned':
                    $query->where('status', 'banned');
                    break;
            }
        }

        // Date range filter
        if ($request->has('date_from') && !empty($request->date_from)) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && !empty($request->date_to)) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $customers = $query->orderBy('created_at', 'desc')
                          ->paginate(15)
                          ->appends($request->query());

        // Statistics
        $stats = [
            'total' => User::whereHas('roles', function($q) { $q->where('name', 'customer'); })->count(),
            'active' => User::whereHas('roles', function($q) { $q->where('name', 'customer'); })->where('status', 'active')->count(),
            'inactive' => User::whereHas('roles', function($q) { $q->where('name', 'customer'); })->where('status', 'inactive')->count(),
            'suspended' => User::whereHas('roles', function($q) { $q->where('name', 'customer'); })->where('status', 'suspended')->count(),
            'banned' => User::whereHas('roles', function($q) { $q->where('name', 'customer'); })->where('status', 'banned')->count(),
            'new_this_month' => User::whereHas('roles', function($q) { $q->where('name', 'customer'); })->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count(),
        ];

        return view('admin.customers.index', compact('customers', 'stats'));
    }

    /**
     * Display the specified customer
     */
    public function show(User $customer)
    {
        // Ensure the user is a customer
        if (!$customer->hasRole('customer')) {
            abort(404, 'Customer not found');
        }

        $customer->load(['profile', 'addresses', 'roles', 'sessions' => function($query) {
            $query->latest()->take(10);
        }, 'activities' => function($query) {
            $query->latest()->take(20);
        }]);

        // Get customer statistics
        $stats = [
            'total_orders' => $customer->orders()->count() ?? 0,
            'total_reviews' => $customer->reviews()->count() ?? 0,
            'total_spent' => $customer->orders()->sum('grand_total') ?? 0,
            'last_login' => $customer->last_login_at,
            'login_count' => $customer->sessions()->count(),
            'active_sessions' => $customer->sessions()->where('is_active', true)->count(),
        ];

        return view('admin.customers.show', compact('customer', 'stats'));
    }

    /**
     * Show the form for editing the specified customer
     */
    public function edit(User $customer)
    {
        // Ensure the user is a customer
        if (!$customer->hasRole('customer')) {
            abort(404, 'Customer not found');
        }

        $customer->load(['profile', 'addresses', 'roles']);

        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update the specified customer
     */
    public function update(Request $request, User $customer)
    {
        // Ensure the user is a customer
        if (!$customer->hasRole('customer')) {
            abort(404, 'Customer not found');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($customer->id)],
            'status' => ['required', 'string', 'in:active,inactive,suspended,banned'],
            'phone' => ['nullable', 'string', 'max:20'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'gender' => ['nullable', 'string', 'in:male,female,other'],
        ]);

        // Update user basic info
        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
        ]);

        // Update or create profile
        if ($customer->profile) {
            $customer->profile->update([
                'phone' => $request->phone,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
            ]);
        } else {
            UserProfile::create([
                'user_id' => $customer->id,
                'phone' => $request->phone,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
            ]);
        }

        return redirect()->route('admin.customers.show', $customer)
                        ->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified customer
     */
    public function destroy(User $customer)
    {
        // Ensure the user is a customer
        if (!$customer->hasRole('customer')) {
            abort(404, 'Customer not found');
        }

        // Delete profile picture if exists
        if ($customer->profile && $customer->profile->profile_picture) {
            $fileStorage = new \App\Utils\FileStorage();
            $fileStorage->delete($customer->profile->profile_picture);
        }

        $customer->delete();

        return redirect()->route('admin.customers.index')
                        ->with('success', 'Customer deleted successfully.');
    }

    /**
     * Toggle customer status
     */
    public function toggleStatus(Request $request, User $customer)
    {
        // Ensure the user is a customer
        if (!$customer->hasRole('customer')) {
            abort(404, 'Customer not found');
        }

        $newStatus = $customer->status === 'active' ? 'inactive' : 'active';

        $customer->update(['status' => $newStatus]);

        $message = $newStatus === 'active' ? 'Customer activated successfully.' : 'Customer deactivated successfully.';

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'status' => $newStatus
            ]);
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Reset customer password
     */
    public function resetPassword(Request $request, User $customer)
    {
        // Ensure the user is a customer
        if (!$customer->hasRole('customer')) {
            abort(404, 'Customer not found');
        }

        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $customer->update([
            'password' => Hash::make($request->password)
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Password reset successfully.'
            ]);
        }

        return redirect()->back()->with('success', 'Password reset successfully.');
    }

    /**
     * Bulk actions for customers
     */
    public function bulkAction(Request $request)
    {


        $request->validate([
            'action' => ['required', 'string', 'in:activate,deactivate,suspend,ban,delete'],
            'customers' => ['required', 'array', 'min:1'],
            'customers.*' => ['exists:users,id'],
        ]);

        $customers = User::whereIn('id', $request->customers)
                        ->whereHas('roles', function($q) {
                            $q->where('name', 'customer');
                        })
                        ->get();

        $count = 0;

        switch ($request->action) {
            case 'activate':
                foreach ($customers as $customer) {
                    $customer->update(['status' => 'active']);
                    $count++;
                }
                $message = "{$count} customers activated successfully.";
                break;

            case 'deactivate':
                foreach ($customers as $customer) {
                    $customer->update(['status' => 'inactive']);
                    $count++;
                }
                $message = "{$count} customers deactivated successfully.";
                break;

            case 'suspend':
                foreach ($customers as $customer) {
                    $customer->update(['status' => 'suspended']);
                    $count++;
                }
                $message = "{$count} customers suspended successfully.";
                break;

            case 'ban':
                foreach ($customers as $customer) {
                    $customer->update(['status' => 'banned']);
                    $count++;
                }
                $message = "{$count} customers banned successfully.";
                break;

            case 'delete':
                // Delete profile pictures first
                $fileStorage = new \App\Utils\FileStorage();
                foreach ($customers as $customer) {
                    if ($customer->profile && $customer->profile->profile_picture) {
                        $fileStorage->delete($customer->profile->profile_picture);
                    }
                    $customer->delete();
                    $count++;
                }
                $message = "{$count} customers deleted successfully.";
                break;
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Show customer orders
     */
    public function orders(User $customer)
    {
        // Ensure the user is a customer
        if (!$customer->hasRole('customer')) {
            abort(404, 'Customer not found');
        }

        $orders = $customer->orders()
                          ->with(['items.product', 'payment'])
                          ->latest()
                          ->paginate(15);

        return view('admin.customers.orders', compact('customer', 'orders'));
    }

    /**
     * Show customer reviews
     */
    public function reviews(User $customer)
    {
        // Ensure the user is a customer
        if (!$customer->hasRole('customer')) {
            abort(404, 'Customer not found');
        }

        $reviews = $customer->reviews()
                           ->with(['product', 'order'])
                           ->latest()
                           ->paginate(15);

        return view('admin.customers.reviews', compact('customer', 'reviews'));
    }
}
