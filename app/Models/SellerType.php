<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SellerType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'document_requirements',
        'status',
        'sort_order'
    ];

    protected $casts = [
        'document_requirements' => 'array',
        'status' => 'boolean'
    ];

    /**
     * Get document requirements as array
     */
    public function getDocumentRequirementsArrayAttribute(): array
    {
        return $this->document_requirements ?? [];
    }

    /**
     * Scope for active seller types
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Scope for ordered seller types
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    /**
     * Get document requirements that apply to this seller type
     */
    public function documentRequirements(): BelongsToMany
    {
        return $this->belongsToMany(DocumentRequirement::class, 'document_requirement_seller_type');
    }

    /**
     * Get sellers of this type
     */
    public function sellers()
    {
        return $this->hasMany(Seller::class, 'seller_type_id');
    }
}
