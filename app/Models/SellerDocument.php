<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use App\Constants\DocumentStatus;

class SellerDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'document_type',
        'document_path',
        'original_filename',
        'file_size',
        'file_type',
        'mime_type',
        'verification_status',
        'admin_comments',
        'rejection_reason',
        'verified_by',
        'ai_verification_result',
        'expert_reviewer_id',
        'uploaded_at',
        'verified_at',
        'expiry_date',
        'is_mandatory',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
        'uploaded_at' => 'datetime',
        'expiry_date' => 'date',
        'is_mandatory' => 'boolean',
    ];

    /**
     * Get the seller that owns the document
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    /**
     * Get the expert reviewer who verified the document
     */
    public function expertReviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'expert_reviewer_id');
    }

    /**
     * Get the full URL for the document file
     */
    public function getFileUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->document_path);
    }

 

    /**
     * Check if document is approved (verified)
     */
    public function isApproved(): bool
    {
        return DocumentStatus::isVerified($this->verification_status);
    }

    /**
     * Check if document is rejected
     */
    public function isRejected(): bool
    {
        return DocumentStatus::isRejected($this->verification_status);
    }

    /**
     * Check if document is pending
     */
    public function isPending(): bool
    {
        return DocumentStatus::isPending($this->verification_status);
    }

    /**
     * Check if document is expired
     */
    public function isExpired(): bool
    {
        return DocumentStatus::isExpired($this->verification_status);
    }

    /**
     * Approve the document
     */
    public function approve(int $userId, string $notes = null): bool
    {
        return $this->update([
            'verification_status' => DocumentStatus::VERIFIED,
            'admin_comments' => $notes,
            'expert_reviewer_id' => $userId,
            'verified_at' => now(),
        ]);
    }

    /**
     * Reject the document
     */
    public function reject(int $userId, string $notes = null): bool
    {
        return $this->update([
            'verification_status' => DocumentStatus::REJECTED,
            'admin_comments' => $notes,
            'expert_reviewer_id' => $userId,
            'verified_at' => now(),
        ]);
    }

    /**
     * Get status badge class for UI
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return DocumentStatus::getBadgeClass($this->verification_status);
    }

    /**
     * Get formatted file size
     */
    public function getFormattedFileSizeAttribute(): string
    {
        if (!$this->file_size) {
            return 'Unknown';
        }
        
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Get file extension from filename or mime type
     */
    public function getFileExtensionAttribute(): string
    {
        if ($this->original_filename) {
            return strtoupper(pathinfo($this->original_filename, PATHINFO_EXTENSION));
        }
        
        if ($this->file_type) {
            return strtoupper($this->file_type);
        }
        
        if ($this->mime_type) {
            $mimeMap = [
                'image/jpeg' => 'JPG',
                'image/png' => 'PNG',
                'image/gif' => 'GIF',
                'application/pdf' => 'PDF',
                'application/msword' => 'DOC',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'DOCX',
            ];
            
            return $mimeMap[$this->mime_type] ?? 'FILE';
        }
        
        return 'FILE';
    }

    /**
     * Get status display text
     */
    public function getStatusDisplayAttribute(): string
    {
        return DocumentStatus::getDisplayName($this->verification_status);
    }
}