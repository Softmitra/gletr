<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_variant_id',
        'product_name',
        'variant_sku',
        'quantity',
        'unit_price',
        'total_price',
        'product_details',
    ];

    protected $casts = [
        'product_details' => 'array',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function productVariant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }

    /**
     * Get the product through the product variant
     */
    public function product(): HasOneThrough
    {
        return $this->hasOneThrough(
            Product::class,
            ProductVariant::class,
            'id', // Foreign key on ProductVariant table
            'id', // Foreign key on Product table
            'product_variant_id', // Local key on OrderItem table
            'product_id' // Local key on ProductVariant table
        );
    }
}
