<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'postal_code',
        'country',
        'is_default',
        'phone',
        'label',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    /**
     * Get the user that owns the address.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the full address as a string.
     */
    public function getFullAddressAttribute()
    {
        $parts = [
            $this->address_line_1,
            $this->address_line_2,
            $this->city,
            $this->state,
            $this->postal_code,
            $this->country,
        ];

        return implode(', ', array_filter($parts));
    }

    /**
     * Get formatted address for display.
     */
    public function getFormattedAddressAttribute()
    {
        $lines = [];
        
        if ($this->label) {
            $lines[] = "<strong>{$this->label}</strong>";
        }
        
        $lines[] = $this->address_line_1;
        
        if ($this->address_line_2) {
            $lines[] = $this->address_line_2;
        }
        
        $lines[] = "{$this->city}, {$this->state} {$this->postal_code}";
        $lines[] = $this->country;
        
        if ($this->phone) {
            $lines[] = "Phone: {$this->phone}";
        }
        
        return implode('<br>', $lines);
    }

    /**
     * Scope to get billing addresses.
     */
    public function scopeBilling($query)
    {
        return $query->where('type', 'billing');
    }

    /**
     * Scope to get shipping addresses.
     */
    public function scopeShipping($query)
    {
        return $query->where('type', 'shipping');
    }

    /**
     * Scope to get default addresses.
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    /**
     * Get address type badge color.
     */
    public function getTypeColorAttribute()
    {
        return $this->type === 'billing' ? 'primary' : 'success';
    }

    /**
     * Get address type icon.
     */
    public function getTypeIconAttribute()
    {
        return $this->type === 'billing' ? 'fas fa-credit-card' : 'fas fa-shipping-fast';
    }
}
