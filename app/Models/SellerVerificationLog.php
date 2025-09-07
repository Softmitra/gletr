<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SellerVerificationLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'user_id',
        'action',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the seller that owns the log
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    /**
     * Get the user who performed the action
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get formatted action name
     */
    public function getFormattedActionAttribute(): string
    {
        return match($this->action) {
            'document_verified' => 'Document Verified',
            'seller_approved' => 'Seller Approved',
            'seller_rejected' => 'Seller Rejected',
            'reviewer_assigned' => 'Reviewer Assigned',
            'document_uploaded' => 'Document Uploaded',
            'verification_requested' => 'Verification Requested',
            default => ucfirst(str_replace('_', ' ', $this->action))
        };
    }

    /**
     * Get action icon
     */
    public function getActionIconAttribute(): string
    {
        return match($this->action) {
            'document_verified' => 'fas fa-file-check',
            'seller_approved' => 'fas fa-check-circle',
            'seller_rejected' => 'fas fa-times-circle',
            'reviewer_assigned' => 'fas fa-user-plus',
            'document_uploaded' => 'fas fa-upload',
            'verification_requested' => 'fas fa-clock',
            default => 'fas fa-info-circle'
        };
    }

    /**
     * Get action color
     */
    public function getActionColorAttribute(): string
    {
        return match($this->action) {
            'document_verified' => 'success',
            'seller_approved' => 'success',
            'seller_rejected' => 'danger',
            'reviewer_assigned' => 'info',
            'document_uploaded' => 'primary',
            'verification_requested' => 'warning',
            default => 'secondary'
        };
    }

    /**
     * Scope for recent logs
     */
    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Scope for specific action
     */
    public function scopeAction($query, string $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Scope for specific seller
     */
    public function scopeForSeller($query, int $sellerId)
    {
        return $query->where('seller_id', $sellerId);
    }

    /**
     * Scope for specific user
     */
    public function scopeByUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }
}
