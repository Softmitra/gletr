<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\SellerOrderServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OrderController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        private SellerOrderServiceInterface $orderService
    ) {}

    /**
     * Display order listing
     */
    public function index(Request $request): View
    {
        $sellerId = Auth::guard('seller')->id();
        $filters = $request->only(['status', 'date_from', 'date_to', 'search', 'sort']);
        $perPage = $request->get('per_page', 15);

        $data = $this->orderService->getOrderListing($sellerId, $filters, $perPage);

        return view('seller.orders.index', $data);
    }

    /**
     * Show order details
     */
    public function show(int $orderId)
    {
        try {
            $sellerId = Auth::guard('seller')->id();
            $data = $this->orderService->getOrderDetails($sellerId, $orderId);

            return view('seller.orders.show', $data);
        } catch (\Exception $e) {
            return redirect()->route('seller.orders.index')
                ->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, int $orderId): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled,refunded',
            'note' => 'nullable|string|max:500',
        ]);

        try {
            $sellerId = Auth::guard('seller')->id();
            
            $this->orderService->updateOrderStatus(
                $sellerId,
                $orderId,
                $request->status,
                $request->note ?? ''
            );

            return back()->with('success', 'Order status updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Process order fulfillment
     */
    public function fulfillment(Request $request, int $orderId): RedirectResponse
    {
        $request->validate([
            'tracking_number' => 'nullable|string|max:100',
            'carrier' => 'nullable|string|max:50',
            'shipping_method' => 'nullable|string|max:50',
            'estimated_delivery' => 'nullable|date',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            $sellerId = Auth::guard('seller')->id();
            
            $this->orderService->processOrderFulfillment($sellerId, $orderId, $request->all());

            return back()->with('success', 'Order fulfillment updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Handle bulk actions
     */
    public function bulkAction(Request $request): RedirectResponse
    {
        $request->validate([
            'action' => 'required|in:mark_processing,mark_shipped,mark_delivered',
            'order_ids' => 'required|array|min:1',
            'order_ids.*' => 'integer',
        ]);

        try {
            $sellerId = Auth::guard('seller')->id();
            
            $result = $this->orderService->bulkAction(
                $sellerId,
                $request->action,
                $request->order_ids
            );

            return back()->with('success', $result['message']);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Generate order invoice
     */
    public function invoice(int $orderId)
    {
        try {
            $sellerId = Auth::guard('seller')->id();
            
            $result = $this->orderService->generateOrderInvoice($sellerId, $orderId);

            if ($result['file_path']) {
                return response()->download($result['file_path']);
            } else {
                return back()->with('info', $result['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Generate shipping label
     */
    public function shippingLabel(int $orderId)
    {
        try {
            $sellerId = Auth::guard('seller')->id();
            
            $result = $this->orderService->generateShippingLabel($sellerId, $orderId);

            if ($result['file_path']) {
                return response()->download($result['file_path']);
            } else {
                return back()->with('info', $result['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Add order note
     */
    public function addNote(Request $request, int $orderId): RedirectResponse
    {
        $request->validate([
            'note' => 'required|string|max:500',
        ]);

        try {
            $sellerId = Auth::guard('seller')->id();
            
            $this->orderService->addOrderNote($sellerId, $orderId, $request->note);

            return back()->with('success', 'Note added successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Export orders
     */
    public function export(Request $request)
    {
        try {
            $sellerId = Auth::guard('seller')->id();
            $filters = $request->only(['status', 'date_from', 'date_to', 'search']);
            
            $result = $this->orderService->exportOrders($sellerId, $filters);

            if ($result['file_path']) {
                return response()->download($result['file_path']);
            } else {
                return back()->with('info', $result['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Get order analytics (AJAX)
     */
    public function analytics(Request $request)
    {
        try {
            $sellerId = Auth::guard('seller')->id();
            $dateRange = $request->only(['date_from', 'date_to']);
            
            $analytics = $this->orderService->getOrderAnalytics($sellerId, $dateRange);

            return response()->json([
                'success' => true,
                'data' => $analytics
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get order metrics (AJAX)
     */
    public function metrics(Request $request)
    {
        try {
            $sellerId = Auth::guard('seller')->id();
            $metrics = $this->orderService->calculateOrderMetrics($sellerId);

            return response()->json([
                'success' => true,
                'data' => $metrics
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get orders requiring attention (AJAX)
     */
    public function requiresAttention(Request $request)
    {
        try {
            $sellerId = Auth::guard('seller')->id();
            $orders = $this->orderService->getOrdersRequiringAttention($sellerId);

            return response()->json([
                'success' => true,
                'data' => $orders
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Process refund
     */
    public function refund(Request $request, int $orderId): RedirectResponse
    {
        $request->validate([
            'refund_amount' => 'required|numeric|min:0',
            'refund_reason' => 'required|string|max:500',
        ]);

        try {
            $sellerId = Auth::guard('seller')->id();
            
            $result = $this->orderService->processOrderRefund($sellerId, $orderId, $request->all());

            if ($result['success']) {
                return back()->with('success', 'Refund processed successfully.');
            } else {
                return back()->with('info', $result['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Handle return request
     */
    public function handleReturn(Request $request, int $orderId): RedirectResponse
    {
        $request->validate([
            'return_action' => 'required|in:approve,reject',
            'return_reason' => 'nullable|string|max:500',
        ]);

        try {
            $sellerId = Auth::guard('seller')->id();
            
            $result = $this->orderService->handleOrderReturn($sellerId, $orderId, $request->all());

            if ($result['success']) {
                return back()->with('success', 'Return request processed successfully.');
            } else {
                return back()->with('info', $result['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
