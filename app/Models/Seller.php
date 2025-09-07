<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\SellerStore;
use App\Models\SellerVerificationLog;
use App\Models\SellerSession;
use App\Models\SellerActivity;
use App\Models\SellerDocument;
use App\Models\Order;
use App\Models\OrderItem;
use App\Notifications\SellerVerificationApproved;
use App\Notifications\SellerVerificationRejected;
use App\Notifications\SellerDocumentStatusUpdated;
use App\Notifications\SellerRegistrationReceived;

class Seller extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        // Basic Information
        'name',
        'email',
        'phone',
        'seller_type_id',
        
        // Address Information (using existing fields)
        'pincode',
        'address_line_1',
        'address_line_2',
        'area',
        'city',
        'state',
        'country',
        
        // Store Information (will add these)
        'business_name', // existing field
        
        // Bank Information (using existing fields)
        'bank_name',
        'holder_name',
        'account_no',
        'ifsc_code',
        'branch',
        
        // Status and Verification
        'is_verified',
        'status',
        'verification_status',
        
        // Legacy fields (keeping for compatibility)
        'f_name',
        'l_name',
        'country_code',
        'free_delivery_over_amount',
        'image',
        'password',
        'auth_token',
        'sales_commission_percentage',
        'gst',
        'gst_number',
        'pan_number',
        'cm_firebase_token',
        'pos_status',
        'minimum_order_amount',
        'stock_limit',
        'free_delivery_status',
        'app_language',
        'business_type',
        'verification_stage',
        'kyc_status',
        'expert_reviewer_id',
        'verification_notes',
        'verification_completed_at',
        'last_login_at',
        'login_count',
        'password',
        'email_verified_at',
        'remember_token',
    ];

    protected $casts = [
        'id' => 'integer',
        'f_name' => 'string',
        'l_name' => 'string',
        'country_code' => 'string',
        'orders_count' => 'integer',
        'product_count' => 'integer',
        'pos_status' => 'integer',
        'is_verified' => 'boolean',
        'is_active' => 'boolean',
        'documents' => 'array',
        'last_login_at' => 'datetime',
        'login_count' => 'integer',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function scopeApproved($query)
    {
        return $query->where(['status' => 'approved']);
    }

    public function orders()
    {
        return Order::whereHas('items.product', function($query) {
            $query->where('seller_id', $this->id);
        });
    }

    public function getOrdersCountAttribute()
    {
        return $this->orders()->count();
    }

    public function product(): HasMany
    {
        return $this->hasMany(Product::class, 'seller_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'seller_id');
    }

    /**
     * Get seller documents
     */
    public function sellerDocuments(): HasMany
    {
        return $this->hasMany(SellerDocument::class, 'seller_id');
    }

    /**
     * Get expert reviewer
     */
    public function expertReviewer()
    {
        return $this->belongsTo(User::class, 'expert_reviewer_id');
    }

    /**
     * Get team members
     */
    public function teamMembers(): HasMany
    {
        return $this->hasMany(SellerTeamMember::class);
    }

    /**
     * Get active team members
     */
    public function activeTeamMembers(): HasMany
    {
        return $this->hasMany(SellerTeamMember::class)->where('status', 'active');
    }

    /**
     * Get seller type relationship
     */
    public function sellerType(): BelongsTo
    {
        return $this->belongsTo(SellerType::class);
    }

    /**
     * Get verification logs for this seller
     */
    public function verificationLogs(): HasMany
    {
        return $this->hasMany(SellerVerificationLog::class);
    }

    /**
     * Get sessions for this seller
     */
    public function sessions(): HasMany
    {
        return $this->hasMany(SellerSession::class);
    }

    /**
     * Get active sessions for this seller
     */
    public function activeSessions(): HasMany
    {
        return $this->hasMany(SellerSession::class)->where('is_active', true);
    }

    /**
     * Get activities for this seller
     */
    public function activities(): HasMany
    {
        return $this->hasMany(SellerActivity::class);
    }

    /**
     * Check if seller has pending verification
     */
    public function isPendingVerification(): bool
    {
        return $this->verification_status === 'pending';
    }

    /**
     * Check if seller documents are verified
     */
    public function hasDocumentsVerified(): bool
    {
        return $this->verification_status === 'documents_verified';
    }

    /**
     * Check if seller is fully verified
     */
    public function isFullyVerified(): bool
    {
        return $this->verification_status === 'verified' && $this->is_verified === true;
    }

    /**
     * Check if seller verification is rejected
     */
    public function isVerificationRejected(): bool
    {
        return $this->verification_status === 'rejected';
    }

    /**
     * Get all documents for verification
     */
    public function getDocumentsForVerification(): array
    {
        return $this->documents ?? [];
    }

    /**
     * Get pending documents (not yet verified)
     */
    public function getPendingDocuments(): array
    {
        $documents = $this->getDocumentsForVerification();
        return array_filter($documents, function($doc) {
            return !isset($doc['verification_status']) || $doc['verification_status'] === 'pending';
        });
    }

    /**
     * Get approved documents
     */
    public function getApprovedDocuments(): array
    {
        $documents = $this->getDocumentsForVerification();
        return array_filter($documents, function($doc) {
            return isset($doc['verification_status']) && $doc['verification_status'] === 'approved';
        });
    }

    /**
     * Get rejected documents
     */
    public function getRejectedDocuments(): array
    {
        $documents = $this->getDocumentsForVerification();
        return array_filter($documents, function($doc) {
            return isset($doc['verification_status']) && $doc['verification_status'] === 'rejected';
        });
    }

    /**
     * Check if all documents are approved
     */
    public function areAllDocumentsApproved(): bool
    {
        // Use the seller_documents table instead of the legacy documents JSON field
        $documents = $this->sellerDocuments;
        if ($documents->isEmpty()) {
            return false;
        }

        foreach ($documents as $document) {
            if (!$document->isApproved()) {
                return false;
            }
        }
        return true;
    }

    /**
     * Check if any document is rejected
     */
    public function hasRejectedDocuments(): bool
    {
        // Use the seller_documents table instead of the legacy documents JSON field
        $documents = $this->sellerDocuments;
        
        foreach ($documents as $document) {
            if ($document->isRejected()) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get verification progress percentage
     */
    public function getVerificationProgress(): int
    {
        $documents = $this->getDocumentsForVerification();
        if (empty($documents)) {
            return 0;
        }

        $approvedCount = count($this->getApprovedDocuments());
        return round(($approvedCount / count($documents)) * 100);
    }

    /**
     * Update verification status based on document status
     */
    public function updateVerificationStatus(): void
    {
        if ($this->hasRejectedDocuments()) {
            $this->update(['verification_status' => 'rejected']);
        } elseif ($this->areAllDocumentsApproved()) {
            $this->update(['verification_status' => 'documents_verified']);
        } else {
            $this->update(['verification_status' => 'pending']);
        }
    }

    /**
     * Approve seller verification
     */
    public function approveVerification(int $reviewerId, string $comments = null): bool
    {
        if (!$this->areAllDocumentsApproved()) {
            return false;
        }

        $this->update([
            'verification_status' => 'verified',
            'status' => 'active',
            'is_verified' => true,
            'verification_completed_at' => now(),
            'expert_reviewer_id' => $reviewerId,
            'verification_notes' => $comments,
        ]);

        // Log the approval
        $this->logVerificationActivity('seller_approved', $reviewerId, [
            'comments' => $comments,
        ]);

        return true;
    }

    /**
     * Reject seller verification
     */
    public function rejectVerification(int $reviewerId, string $reason): bool
    {
        $this->update([
            'verification_status' => 'rejected',
            'status' => 'suspended',
            'expert_reviewer_id' => $reviewerId,
            'verification_notes' => $reason,
        ]);

        // Log the rejection
        $this->logVerificationActivity('seller_rejected', $reviewerId, [
            'reason' => $reason,
        ]);

        return true;
    }

    /**
     * Assign expert reviewer
     */
    public function assignReviewer(int $reviewerId, int $assignedBy): bool
    {
        // Check if the same reviewer is already assigned
        if ($this->expert_reviewer_id == $reviewerId) {
            return false; // No change needed
        }

        $oldReviewerId = $this->expert_reviewer_id;
        $this->update(['expert_reviewer_id' => $reviewerId]);

        // Log the assignment only if it's a new assignment or change
        $this->logVerificationActivity('reviewer_assigned', $assignedBy, [
            'reviewer_id' => $reviewerId,
            'previous_reviewer_id' => $oldReviewerId,
        ]);

        return true;
    }

    /**
     * Log verification activity
     */
    public function logVerificationActivity(string $action, int $userId, array $data = []): void
    {
        SellerVerificationLog::create([
            'seller_id' => $this->id,
            'user_id' => $userId,
            'action' => $action,
            'data' => $data,
        ]);
    }

    /**
     * Send registration received notification
     */
    public function sendRegistrationReceivedNotification(): void
    {
        $this->notify(new SellerRegistrationReceived($this));
    }

    /**
     * Send document status update notification
     */
    public function sendDocumentStatusNotification(string $documentName, string $status, string $comments = null): void
    {
        $this->notify(new SellerDocumentStatusUpdated($this, $documentName, $status, $comments));
    }

    /**
     * Send verification approved notification
     */
    public function sendVerificationApprovedNotification(string $comments = null): void
    {
        $this->notify(new SellerVerificationApproved($this, $comments));
    }

    /**
     * Send verification rejected notification
     */
    public function sendVerificationRejectedNotification(string $reason): void
    {
        $this->notify(new SellerVerificationRejected($this, $reason));
    }

    /**
     * Get user relationship
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the store for the seller.
     */
    public function store(): HasOne
    {
        return $this->hasOne(SellerStore::class);
    }

    /**
     * Get business type display name
     */
    public function getBusinessTypeDisplayAttribute(): string
    {
        // Use relationship if seller_type_id is set
        if ($this->seller_type_id && $this->relationLoaded('sellerType') && $this->sellerType) {
            return $this->sellerType->name;
        }
        
        // Fallback to business_type field
        if ($this->business_type) {
            $types = DocumentRequirement::SELLER_TYPES;
            return $types[$this->business_type] ?? ucfirst(str_replace('_', ' ', $this->business_type));
        }
        
        return 'Unknown';
    }

    protected static function boot(): void
    {
        parent::boot();
        // Add any boot logic here if needed
    }
}
