<?php

namespace App\Services\Interfaces;

interface SellerOrderServiceInterface
{
    /**
     * Get order listing data
     */
    public function getOrderListing(int $sellerId, array $filters = [], int $perPage = 15): array;

    /**
     * Get order dashboard data
     */
    public function getOrderDashboard(int $sellerId): array;

    /**
     * Get order details for viewing
     */
    public function getOrderDetails(int $sellerId, int $orderId): array;

    /**
     * Update order status
     */
    public function updateOrderStatus(int $sellerId, int $orderId, string $status, string $note = ''): bool;

    /**
     * Process order fulfillment
     */
    public function processOrderFulfillment(int $sellerId, int $orderId, array $fulfillmentData): bool;

    /**
     * Get order statistics
     */
    public function getOrderStatistics(int $sellerId): array;

    /**
     * Search orders
     */
    public function searchOrders(int $sellerId, string $query, int $perPage = 15): array;

    /**
     * Bulk actions on orders
     */
    public function bulkAction(int $sellerId, string $action, array $orderIds): array;

    /**
     * Generate order invoice
     */
    public function generateOrderInvoice(int $sellerId, int $orderId): array;

    /**
     * Generate shipping label
     */
    public function generateShippingLabel(int $sellerId, int $orderId): array;

    /**
     * Update order tracking
     */
    public function updateOrderTracking(int $sellerId, int $orderId, array $trackingData): bool;

    /**
     * Process order refund
     */
    public function processOrderRefund(int $sellerId, int $orderId, array $refundData): array;

    /**
     * Handle order return
     */
    public function handleOrderReturn(int $sellerId, int $orderId, array $returnData): array;

    /**
     * Get order analytics
     */
    public function getOrderAnalytics(int $sellerId, array $dateRange = []): array;

    /**
     * Export orders
     */
    public function exportOrders(int $sellerId, array $filters = []): array;

    /**
     * Get orders requiring attention
     */
    public function getOrdersRequiringAttention(int $sellerId): array;

    /**
     * Add order note
     */
    public function addOrderNote(int $sellerId, int $orderId, string $note): bool;

    /**
     * Get order timeline
     */
    public function getOrderTimeline(int $sellerId, int $orderId): array;

    /**
     * Calculate order metrics
     */
    public function calculateOrderMetrics(int $sellerId): array;
}
