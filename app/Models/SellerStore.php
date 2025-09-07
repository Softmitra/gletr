<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class SellerStore extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'store_name',
        'store_description',
        'store_address',
        'store_logo',
        'store_banner',
        'store_phone',
        'store_email',
        'store_timings',
        'store_categories',
        'store_slug',
        'is_featured',
        'is_active',
        'rating',
        'total_reviews',
        'total_products',
        'total_sales',
        'store_policies',
        'social_links',
        'meta_data',
    ];

    protected $casts = [
        'store_timings' => 'array',
        'store_categories' => 'array',
        'store_policies' => 'array',
        'social_links' => 'array',
        'meta_data' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'rating' => 'decimal:2',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($store) {
            if (empty($store->store_slug)) {
                $store->store_slug = static::generateUniqueSlug($store->store_name);
            }
        });

        static::updating(function ($store) {
            if ($store->isDirty('store_name') && !$store->isDirty('store_slug')) {
                $store->store_slug = static::generateUniqueSlug($store->store_name);
            }
        });
    }

    /**
     * Generate unique slug for store
     */
    protected static function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $count = static::where('store_slug', 'LIKE', "{$slug}%")->count();
        
        return $count ? "{$slug}-{$count}" : $slug;
    }

    /**
     * Get the seller that owns the store.
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    /**
     * Get store logo URL
     */
    public function getLogoUrlAttribute()
    {
        return $this->store_logo 
            ? asset('storage/' . $this->store_logo) 
            : asset('images/default-store-logo.png');
    }

    /**
     * Get store banner URL
     */
    public function getBannerUrlAttribute()
    {
        return $this->store_banner 
            ? asset('storage/' . $this->store_banner) 
            : asset('images/default-store-banner.jpg');
    }

    /**
     * Scope for active stores
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for featured stores
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}