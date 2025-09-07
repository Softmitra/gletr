<?php

namespace App\Repositories\Contracts;

use App\Models\Order;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

interface OrderRepositoryInterface
{
    /**
     * Create a new order
     */
    public function create(array $data): Order;

    /**
     * Update order
     */
    public function update(Order $order, array $data): Order;

    /**
     * Find orders by user
     */
    public function findByUser(User $user, array $filters = []): LengthAwarePaginator;

    /**
     * Find orders by seller
     */
    public function findBySeller(int $sellerId, array $filters = []): LengthAwarePaginator;

    /**
     * Find order by order number
     */
    public function findByOrderNumber(string $orderNumber): ?Order;
}
