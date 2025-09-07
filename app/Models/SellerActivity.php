<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SellerActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'seller_session_id',
        'activity_type',
        'action',
        'resource_type',
        'resource_id',
        'description',
        'ip_address',
        'user_agent',
        'url',
        'method',
        'request_data',
        'response_data',
        'response_time',
        'status_code',
        'error_message',
        'metadata',
    ];

    protected $casts = [
        'request_data' => 'array',
        'response_data' => 'array',
        'metadata' => 'array',
    ];

    /**
     * Get the seller that performed the activity.
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    /**
     * Get the session associated with this activity.
     */
    public function session(): BelongsTo
    {
        return $this->belongsTo(SellerSession::class, 'seller_session_id');
    }

    /**
     * Scope to get login activities.
     */
    public function scopeLogins($query)
    {
        return $query->where('activity_type', 'login');
    }

    /**
     * Scope to get logout activities.
     */
    public function scopeLogouts($query)
    {
        return $query->where('activity_type', 'logout');
    }

    /**
     * Scope to get page view activities.
     */
    public function scopePageViews($query)
    {
        return $query->where('activity_type', 'page_view');
    }

    /**
     * Scope to get action activities.
     */
    public function scopeActions($query)
    {
        return $query->where('activity_type', 'action');
    }

    /**
     * Scope to get product activities.
     */
    public function scopeProductActivities($query)
    {
        return $query->where('resource_type', 'product');
    }

    /**
     * Scope to get order activities.
     */
    public function scopeOrderActivities($query)
    {
        return $query->where('resource_type', 'order');
    }

    /**
     * Scope to get activities by resource type.
     */
    public function scopeByResource($query, $resourceType)
    {
        return $query->where('resource_type', $resourceType);
    }

    /**
     * Scope to get activities by type.
     */
    public function scopeByType($query, $type)
    {
        return $query->where('activity_type', $type);
    }

    /**
     * Get formatted activity description
     */
    public function getFormattedDescriptionAttribute()
    {
        return $this->description ?: $this->generateDescription();
    }

    /**
     * Generate activity description based on type and action
     */
    private function generateDescription()
    {
        switch ($this->activity_type) {
            case 'login':
                return 'Seller logged in';
            case 'logout':
                return 'Seller logged out';
            case 'page_view':
                return "Viewed page: {$this->url}";
            case 'action':
                return $this->action ? ucfirst($this->action) . ' action performed' : 'Action performed';
            default:
                return 'Activity performed';
        }
    }
}
