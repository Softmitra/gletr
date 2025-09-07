<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Events\OrderPlaced;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;

class OrderService
{
    public function __construct(
        private OrderRepositoryInterface $orderRepository,
        private PricingService $pricingService,
        private PaymentService $paymentService,
        private InventoryService $inventoryService
    ) {}

    /**
     * Create order from cart
     */
    public function createOrderFromCart(Cart $cart, array $shippingData, array $billingData): Order
    {
        DB::beginTransaction();
        try {
            // Validate cart and calculate totals
            $this->validateCart($cart);
            $totals = $this->calculateOrderTotals($cart);

            // Create order
            $order = $this->orderRepository->create([
                'user_id' => $cart->user_id,
                'order_number' => $this->generateOrderNumber(),
                'status' => 'pending',
                'payment_status' => 'pending',
                'subtotal' => $totals['subtotal'],
                'tax_total' => $totals['tax_total'],
                'shipping_total' => $totals['shipping_total'],
                'discount_total' => $totals['discount_total'],
                'grand_total' => $totals['grand_total'],
                'currency' => 'INR',
                'shipping_address' => $shippingData,
                'billing_address' => $billingData,
                'placed_at' => now(),
            ]);

            // Create order items
            $this->createOrderItems($order, $cart);

            // Reserve inventory
            $this->inventoryService->reserveInventoryForOrder($order);

            // Clear cart
            $cart->items()->delete();

            // Fire order placed event
            event(new OrderPlaced($order));

            DB::commit();
            return $order;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Calculate order totals
     */
    public function calculateOrderTotals(Cart $cart): array
    {
        $subtotal = 0;
        $taxTotal = 0;
        $shippingTotal = 0;
        $discountTotal = 0;

        foreach ($cart->items as $item) {
            $itemTotal = $item->price * $item->quantity;
            $subtotal += $itemTotal;

            // Calculate tax for each item
            $taxTotal += $this->calculateItemTax($item);
        }

        // Calculate shipping (can be per seller or combined)
        $shippingTotal = $this->calculateShippingCost($cart);

        // Apply discounts if any
        if ($cart->coupon_id) {
            $discountTotal = $this->calculateDiscount($cart, $subtotal);
        }

        $grandTotal = $subtotal + $taxTotal + $shippingTotal - $discountTotal;

        return [
            'subtotal' => round($subtotal, 2),
            'tax_total' => round($taxTotal, 2),
            'shipping_total' => round($shippingTotal, 2),
            'discount_total' => round($discountTotal, 2),
            'grand_total' => round($grandTotal, 2),
        ];
    }

    /**
     * Create order items from cart items
     */
    private function createOrderItems(Order $order, Cart $cart): void
    {
        foreach ($cart->items as $cartItem) {
            $variant = $cartItem->productVariant;
            $pricing = $this->pricingService->calculateVariantPricing($variant);

            OrderItem::create([
                'order_id' => $order->id,
                'product_variant_id' => $cartItem->product_variant_id,
                'seller_id' => $variant->product->seller_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->price,
                'tax' => $this->calculateItemTax($cartItem),
                'discount' => 0, // Individual item discounts
                'product_name' => $variant->product->name,
                'product_sku' => $variant->sku,
                'product_details' => json_encode([
                    'metal_type' => $variant->product->metal_type,
                    'purity' => $variant->product->purity,
                    'weight' => $variant->net_metal_weight,
                    'size' => $variant->size,
                ]),
            ]);
        }
    }

    /**
     * Generate unique order number
     */
    private function generateOrderNumber(): string
    {
        do {
            $orderNumber = 'GLT-' . date('Y') . '-' . str_pad(random_int(1, 999999), 6, '0', STR_PAD_LEFT);
        } while (Order::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }

    /**
     * Validate cart before creating order
     */
    private function validateCart(Cart $cart): void
    {
        if ($cart->items->isEmpty()) {
            throw new Exception('Cart is empty');
        }

        foreach ($cart->items as $item) {
            if (!$item->productVariant) {
                throw new Exception('Invalid product variant in cart');
            }

            if (!$this->inventoryService->isInStock($item->productVariant, $item->quantity)) {
                throw new Exception("Insufficient stock for {$item->productVariant->product->name}");
            }
        }
    }

    /**
     * Calculate tax for cart item
     */
    private function calculateItemTax($cartItem): float
    {
        $itemTotal = $cartItem->price * $cartItem->quantity;
        return $itemTotal * 0.03; // 3% GST - adjust as needed
    }

    /**
     * Calculate shipping cost
     */
    private function calculateShippingCost(Cart $cart): float
    {
        // Group items by seller for shipping calculation
        $sellerItems = $cart->items->groupBy(function ($item) {
            return $item->productVariant->product->seller_id;
        });

        $totalShipping = 0;
        foreach ($sellerItems as $sellerId => $items) {
            // Basic shipping calculation - can be enhanced with shipping service
            $weight = $items->sum(function ($item) {
                return $item->productVariant->gross_weight * $item->quantity;
            });
            
            $shippingCost = $this->calculateShippingBySeller($sellerId, $weight);
            $totalShipping += $shippingCost;
        }

        return $totalShipping;
    }

    /**
     * Calculate shipping by seller
     */
    private function calculateShippingBySeller(int $sellerId, float $weight): float
    {
        // Basic calculation - can be enhanced with courier APIs
        $baseRate = 50; // Base shipping rate
        $perGramRate = 2; // Per gram rate
        
        return $baseRate + ($weight * $perGramRate);
    }

    /**
     * Calculate discount
     */
    private function calculateDiscount(Cart $cart, float $subtotal): float
    {
        // Implement coupon/discount logic here
        // This is a placeholder
        return 0;
    }

    /**
     * Update order status
     */
    public function updateOrderStatus(Order $order, string $status, ?string $notes = null): Order
    {
        return $this->orderRepository->update($order, [
            'status' => $status,
            'status_notes' => $notes,
            'updated_at' => now(),
        ]);
    }

    /**
     * Cancel order
     */
    public function cancelOrder(Order $order, string $reason): Order
    {
        DB::beginTransaction();
        try {
            // Release reserved inventory
            $this->inventoryService->releaseReservedInventory($order);

            // Update order status
            $order = $this->updateOrderStatus($order, 'cancelled', $reason);

            // Process refund if payment was made
            if ($order->payment_status === 'paid') {
                $this->paymentService->processRefund($order);
            }

            DB::commit();
            return $order;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Get orders by user
     */
    public function getUserOrders(User $user, array $filters = [])
    {
        return $this->orderRepository->findByUser($user, $filters);
    }

    /**
     * Get orders by seller
     */
    public function getSellerOrders(int $sellerId, array $filters = [])
    {
        return $this->orderRepository->findBySeller($sellerId, $filters);
    }

    /**
     * Confirm order (after payment)
     */
    public function confirmOrder(Order $order): Order
    {
        return $this->updateOrderStatus($order, 'confirmed');
    }

    /**
     * Mark order as shipped
     */
    public function markAsShipped(Order $order, array $shippingData): Order
    {
        return $this->orderRepository->update($order, [
            'status' => 'shipped',
            'shipped_at' => now(),
            'tracking_number' => $shippingData['tracking_number'] ?? null,
            'courier_name' => $shippingData['courier_name'] ?? null,
        ]);
    }

    /**
     * Mark order as delivered
     */
    public function markAsDelivered(Order $order): Order
    {
        return $this->orderRepository->update($order, [
            'status' => 'delivered',
            'delivered_at' => now(),
        ]);
    }
}
