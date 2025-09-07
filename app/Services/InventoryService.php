<?php

namespace App\Services;

use App\Models\Order;
use App\Models\ProductVariant;

class InventoryService
{
    /**
     * Check if product variant is in stock
     */
    public function isInStock(ProductVariant $variant, int $quantity = 1): bool
    {
        return $variant->inventory && $variant->inventory->quantity >= $quantity;
    }

    /**
     * Reserve inventory for order
     */
    public function reserveInventoryForOrder(Order $order): void
    {
        foreach ($order->items as $item) {
            $this->reserveInventory($item->productVariant, $item->quantity);
        }
    }

    /**
     * Reserve inventory for variant
     */
    public function reserveInventory(ProductVariant $variant, int $quantity): void
    {
        if ($variant->inventory) {
            $variant->inventory->decrement('quantity', $quantity);
            $variant->inventory->increment('reserved_quantity', $quantity);
        }
    }

    /**
     * Release reserved inventory
     */
    public function releaseReservedInventory(Order $order): void
    {
        foreach ($order->items as $item) {
            if ($item->productVariant->inventory) {
                $item->productVariant->inventory->increment('quantity', $item->quantity);
                $item->productVariant->inventory->decrement('reserved_quantity', $item->quantity);
            }
        }
    }
}
