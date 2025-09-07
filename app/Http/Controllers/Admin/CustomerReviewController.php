<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
class CustomerReviewController extends Controller
{

    /**
     * Display a listing of customer reviews
     */
    public function index(Request $request)
    {


        $query = Review::with(['user', 'product', 'order']);

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('comment', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', '%' . $search . '%')
                               ->orWhere('email', 'like', '%' . $search . '%');
                  })
                  ->orWhereHas('product', function($productQuery) use ($search) {
                      $productQuery->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        // Status filter
        if ($request->has('status') && !empty($request->status)) {
            switch ($request->status) {
                case 'pending':
                    $query->where('status', 'pending');
                    break;
                case 'approved':
                    $query->where('status', 'approved');
                    break;
                case 'rejected':
                    $query->where('status', 'rejected');
                    break;
            }
        }

        // Rating filter
        if ($request->has('rating') && !empty($request->rating)) {
            $query->where('rating', $request->rating);
        }

        // Date range filter
        if ($request->has('date_from') && !empty($request->date_from)) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && !empty($request->date_to)) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $reviews = $query->orderBy('created_at', 'desc')
                        ->paginate(15)
                        ->appends($request->query());

        // Statistics
        $stats = [
            'total' => Review::count(),
            'pending' => Review::where('status', 'pending')->count(),
            'approved' => Review::where('status', 'approved')->count(),
            'rejected' => Review::where('status', 'rejected')->count(),
            'average_rating' => Review::where('status', 'approved')->avg('rating') ?? 0,
            'new_this_week' => Review::whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])->count(),
        ];

        return view('admin.customer-reviews.index', compact('reviews', 'stats'));
    }

    /**
     * Display the specified review
     */
    public function show(Review $review)
    {


        $review->load(['user.profile', 'product', 'order.items']);

        return view('admin.customer-reviews.show', compact('review'));
    }

    /**
     * Approve a review
     */
    public function approve(Request $request, Review $review)
    {


        $review->update(['status' => 'approved']);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Review approved successfully.'
            ]);
        }

        return redirect()->back()->with('success', 'Review approved successfully.');
    }

    /**
     * Reject a review
     */
    public function reject(Request $request, Review $review)
    {


        $request->validate([
            'rejection_reason' => ['nullable', 'string', 'max:500'],
        ]);

        $review->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Review rejected successfully.'
            ]);
        }

        return redirect()->back()->with('success', 'Review rejected successfully.');
    }

    /**
     * Remove the specified review
     */
    public function destroy(Review $review)
    {


        $review->delete();

        return redirect()->route('admin.customer-reviews.index')
                        ->with('success', 'Review deleted successfully.');
    }

    /**
     * Bulk actions for reviews
     */
    public function bulkAction(Request $request)
    {


        $request->validate([
            'action' => ['required', 'string', 'in:approve,reject,delete'],
            'reviews' => ['required', 'array', 'min:1'],
            'reviews.*' => ['exists:reviews,id'],
        ]);

        $reviews = Review::whereIn('id', $request->reviews)->get();
        $count = 0;

        switch ($request->action) {
            case 'approve':
                foreach ($reviews as $review) {
                    $review->update(['status' => 'approved']);
                    $count++;
                }
                $message = "{$count} reviews approved successfully.";
                break;

            case 'reject':
                foreach ($reviews as $review) {
                    $review->update(['status' => 'rejected']);
                    $count++;
                }
                $message = "{$count} reviews rejected successfully.";
                break;

            case 'delete':
                foreach ($reviews as $review) {
                    $review->delete();
                    $count++;
                }
                $message = "{$count} reviews deleted successfully.";
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
}
