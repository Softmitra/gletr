<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class DocumentRequirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_type',
        'document_name',
        'is_mandatory',
        'applicable_seller_types',
        'description',
        'validation_rules',
        'is_active'
    ];

    protected $casts = [
        'applicable_seller_types' => 'array',
        'validation_rules' => 'array',
        'is_mandatory' => 'boolean',
        'is_active' => 'boolean'
    ];

    // Seller types for jewelry business
    const SELLER_TYPES = [
        'gold_dealer' => 'Gold Dealer',
        'diamond_dealer' => 'Diamond Dealer',
        'general_jewelry' => 'General Jewelry',
        'artisan_craftsman' => 'Artisan/Craftsman',
        'platinum_dealer' => 'Platinum Dealer',
        'silver_dealer' => 'Silver Dealer',
        'gemstone_dealer' => 'Gemstone Dealer',
        'watch_dealer' => 'Watch Dealer',
        'antique_jewelry' => 'Antique Jewelry',
        'costume_jewelry' => 'Costume Jewelry'
    ];

    // Document types
    const DOCUMENT_TYPES = [
        'business_license' => 'Business License',
        'gst_certificate' => 'GST Certificate',
        'bis_hallmark_license' => 'BIS Hallmark License',
        'gold_dealer_license' => 'Gold Dealer License',
        'diamond_certification' => 'Diamond Certification',
        'import_export_license' => 'Import Export License',
        'gemological_certificates' => 'Gemological Certificates',
        'identity_proof' => 'Identity Proof',
        'address_proof' => 'Address Proof',
        'bank_documents' => 'Bank Documents',
        'tax_clearance' => 'Tax Clearance Certificate',
        'insurance_certificate' => 'Insurance Certificate',
        'quality_certification' => 'Quality Certification',
        'trade_license' => 'Trade License',
        'partnership_deed' => 'Partnership Deed',
        'company_registration' => 'Company Registration'
    ];

    /**
     * Get seller types as array
     */
    public function getSellerTypesArrayAttribute(): array
    {
        return $this->applicable_seller_types ?? [];
    }

    /**
     * Get document type display name
     */
    public function getDocumentTypeDisplayAttribute(): string
    {
        return self::DOCUMENT_TYPES[$this->document_type] ?? ucfirst(str_replace('_', ' ', $this->document_type));
    }

    /**
     * Get seller types display names
     */
    public function getSellerTypesDisplayAttribute(): array
    {
        $types = [];
        foreach ($this->applicable_seller_types ?? [] as $type) {
            $types[] = self::SELLER_TYPES[$type] ?? ucfirst(str_replace('_', ' ', $type));
        }
        return $types;
    }

    /**
     * Get applicable seller types from database
     */
    public function sellerTypes(): BelongsToMany
    {
        return $this->belongsToMany(SellerType::class, 'document_requirement_seller_type');
    }

    /**
     * Get seller types from the applicable_seller_types column as SellerType models
     */
    public function getSellerTypeModelsAttribute()
    {
        if (empty($this->applicable_seller_types)) {
            return collect();
        }

        return SellerType::whereIn('slug', $this->applicable_seller_types)->get();
    }
}
