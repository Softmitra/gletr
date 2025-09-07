<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\MetalRateSnapshot;
use Illuminate\Support\Facades\Cache;

class PricingService
{
    /**
     * Calculate pricing for a product
     */
    public function calculateProductPricing(Product $product): array
    {
        $pricing = [];
        
        // Get current metal rate
        $metalRate = $this->getCurrentMetalRate($product->metal_type, $product->purity);
        
        foreach ($product->variants as $variant) {
            $pricing[$variant->id] = $this->calculateVariantPricing($variant, $metalRate);
        }
        
        return $pricing;
    }

    /**
     * Calculate pricing for a product variant
     */
    public function calculateVariantPricing(ProductVariant $variant, ?float $metalRate = null): array
    {
        if (!$metalRate) {
            $metalRate = $this->getCurrentMetalRate(
                $variant->product->metal_type, 
                $variant->product->purity
            );
        }

        // Base metal value calculation
        $baseMetalValue = $variant->net_metal_weight * $metalRate;
        
        // Wastage calculation
        $wastageAmount = $baseMetalValue * ($variant->wastage_pct / 100);
        
        // Making charges calculation
        $makingCharges = $this->calculateMakingCharges($variant);
        
        // Stone value calculation
        $stoneValue = $this->calculateStoneValue($variant);
        
        // Subtotal before taxes and discounts
        $subtotal = $baseMetalValue + $wastageAmount + $makingCharges + $stoneValue;
        
        // Tax calculation (GST)
        $taxAmount = $this->calculateTax($subtotal, $variant->tax_class_id);
        
        // Final price
        $finalPrice = $subtotal + $taxAmount;
        
        return [
            'base_metal_value' => round($baseMetalValue, 2),
            'wastage_amount' => round($wastageAmount, 2),
            'making_charges' => round($makingCharges, 2),
            'stone_value' => round($stoneValue, 2),
            'subtotal' => round($subtotal, 2),
            'tax_amount' => round($taxAmount, 2),
            'final_price' => round($finalPrice, 2),
            'metal_rate_used' => $metalRate,
            'calculation_date' => now()
        ];
    }

    /**
     * Calculate making charges based on type
     */
    private function calculateMakingCharges(ProductVariant $variant): float
    {
        return match ($variant->making_charge_type) {
            'fixed' => $variant->making_charge_value,
            'per_gram' => $variant->net_metal_weight * $variant->making_charge_value,
            default => 0
        };
    }

    /**
     * Calculate stone value from stone details JSON
     */
    private function calculateStoneValue(ProductVariant $variant): float
    {
        if (!$variant->stone_details) {
            return 0;
        }

        $stoneDetails = is_string($variant->stone_details) 
            ? json_decode($variant->stone_details, true) 
            : $variant->stone_details;

        if (!is_array($stoneDetails)) {
            return 0;
        }

        $totalValue = 0;
        foreach ($stoneDetails as $stone) {
            if (isset($stone['value']) && is_numeric($stone['value'])) {
                $totalValue += (float) $stone['value'];
            } elseif (isset($stone['carat_weight'], $stone['price_per_carat'])) {
                $totalValue += (float) $stone['carat_weight'] * (float) $stone['price_per_carat'];
            }
        }

        return $totalValue;
    }

    /**
     * Calculate tax amount
     */
    private function calculateTax(float $amount, ?int $taxClassId = null): float
    {
        // Default GST rate for jewelry (adjust as per requirements)
        $taxRate = 0.03; // 3% GST
        
        // You can implement tax class logic here
        // if ($taxClassId) {
        //     $taxRate = TaxClass::find($taxClassId)->rate ?? $taxRate;
        // }
        
        return $amount * $taxRate;
    }

    /**
     * Get current metal rate from cache or database
     */
    private function getCurrentMetalRate(string $metalType, string $purity): float
    {
        $cacheKey = "metal_rate_{$metalType}_{$purity}";
        
        return Cache::remember($cacheKey, 3600, function () use ($metalType, $purity) {
            // Try to get the latest rate from database
            $snapshot = MetalRateSnapshot::where('metal', $metalType)
                ->where('purity', $purity)
                ->latest('captured_at')
                ->first();
            
            if ($snapshot) {
                return $snapshot->rate_per_gram;
            }
            
            // Fallback rates (you should implement proper rate management)
            $fallbackRates = [
                'gold_24k' => 6500,
                'gold_22k' => 6000,
                'gold_18k' => 4875,
                'silver_925' => 85,
                'platinum_950' => 3500,
            ];
            
            $key = strtolower($metalType . '_' . $purity);
            return $fallbackRates[$key] ?? 1000;
        });
    }

    /**
     * Create or update metal rate snapshot
     */
    public function updateMetalRate(string $metal, string $purity, float $rate): MetalRateSnapshot
    {
        $snapshot = MetalRateSnapshot::create([
            'metal' => $metal,
            'purity' => $purity,
            'rate_per_gram' => $rate,
            'captured_at' => now()
        ]);

        // Clear cache
        Cache::forget("metal_rate_{$metal}_{$purity}");

        return $snapshot;
    }

    /**
     * Get price breakdown for display
     */
    public function getPriceBreakdown(ProductVariant $variant): array
    {
        $pricing = $this->calculateVariantPricing($variant);
        
        return [
            'breakdown' => [
                [
                    'label' => 'Base Metal Value',
                    'amount' => $pricing['base_metal_value'],
                    'description' => "Weight: {$variant->net_metal_weight}g × Rate: ₹{$pricing['metal_rate_used']}/g"
                ],
                [
                    'label' => 'Wastage',
                    'amount' => $pricing['wastage_amount'],
                    'description' => "Wastage: {$variant->wastage_pct}%"
                ],
                [
                    'label' => 'Making Charges',
                    'amount' => $pricing['making_charges'],
                    'description' => ucfirst($variant->making_charge_type) . " charges"
                ],
                [
                    'label' => 'Stone Value',
                    'amount' => $pricing['stone_value'],
                    'description' => 'Precious stones and gems'
                ],
                [
                    'label' => 'Tax (GST)',
                    'amount' => $pricing['tax_amount'],
                    'description' => 'Goods and Services Tax'
                ]
            ],
            'subtotal' => $pricing['subtotal'],
            'total' => $pricing['final_price']
        ];
    }
}
