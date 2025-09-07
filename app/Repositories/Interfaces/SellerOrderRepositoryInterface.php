<?php

namespace App\Repositories\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface SellerOrderRepositoryInterface
{
    /**
     * Get seller orders with pagination
     */
    public function getSellerOrders(int $sellerId, array $filters = [], int $perPage = 15): LengthAwarePaginator;

    /**
     * Get seller order by ID
     */
    public function getSellerOrder(int $sellerId, int $orderId): ?object;

    /**
     * Update order status
     */
    public function updateOrderStatus(int $sellerId, int $orderId, string $status): bool;

    /**
     * Get order statistics for seller
     */
    public function getOrderStats(int $sellerId): array;

    /**
     * Get orders by status
     */
    public function getOrdersByStatus(int $sellerId, string $status, int $perPage = 15): LengthAwarePaginator;

    /**
     * Search seller orders
     */
    public function searchOrders(int $sellerId, string $query, int $perPage = 15): LengthAwarePaginator;

    /**
     * Get recent orders
     */
    public function getRecentOrders(int $sellerId, int $limit = 10): array;

    /**
     * Get order items for specific order
     */
    public function getOrderItems(int $sellerId, int $orderId): array;

    /**
     * Update order tracking information
     */
    public function updateOrderTracking(int $sellerId, int $orderId, array $trackingData): bool;

    /**
     * Get orders requiring action
     */
    public function getOrdersRequiringAction(int $sellerId): array;

    /**
     * Get order revenue data
     */
    public function getOrderRevenue(int $sellerId, array $dateRange = []): array;

    /**
     * Bulk update order status
     */
    public function bulkUpdateOrderStatus(int $sellerId, array $orderIds, string $status): int;

    /**
     * Get order fulfillment data
     */
    public function getOrderFulfillmentData(int $sellerId, int $orderId): array;

    /**
     * Add order note
     */
    public function addOrderNote(int $sellerId, int $orderId, string $note): bool;

    /**
     * Get order timeline/history
     */
    public function getOrderTimeline(int $sellerId, int $orderId): array;
}
