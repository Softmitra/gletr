<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    use InteractsWithMedia;
    
    protected $fillable = [
        'name',
        'description',
        'sku',
        'seller_id',
        'category_id',
        'status',
        'is_featured',
        'metal_type',
        'purity',
        'weight',
        'weight_unit',
        'views',
        'sales_count',
        'tags',
        'attributes'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'tags' => 'array',
        'attributes' => 'array',
        'weight' => 'decimal:3',
        'views' => 'integer',
        'sales_count' => 'integer'
    ];

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp'])
            ->singleFile();
            
        $this->addMediaCollection('gallery')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }
    
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(300)
            ->sharpen(10);
            
        $this->addMediaConversion('preview')
            ->width(800)
            ->height(600)
            ->quality(90);
    }
}
