<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_session_id',
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
     * Get the user that performed the activity.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the session associated with this activity.
     */
    public function session(): BelongsTo
    {
        return $this->belongsTo(UserSession::class, 'user_session_id');
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
     * Scope to get activities by resource type.
     */
    public function scopeByResource($query, $resourceType)
    {
        return $query->where('resource_type', $resourceType);
    }

    /**
     * Scope to get activities by action.
     */
    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Get activity icon based on type.
     */
    public function getActivityIconAttribute()
    {
        return match($this->activity_type) {
            'login' => 'fas fa-sign-in-alt text-success',
            'logout' => 'fas fa-sign-out-alt text-danger',
            'page_view' => 'fas fa-eye text-info',
            'action' => 'fas fa-cog text-warning',
            'error' => 'fas fa-exclamation-triangle text-danger',
            'security' => 'fas fa-shield-alt text-warning',
            default => 'fas fa-circle text-secondary'
        };
    }

    /**
     * Get activity color based on type.
     */
    public function getActivityColorAttribute()
    {
        return match($this->activity_type) {
            'login' => 'success',
            'logout' => 'danger',
            'page_view' => 'info',
            'action' => 'warning',
            'error' => 'danger',
            'security' => 'warning',
            default => 'secondary'
        };
    }

    /**
     * Get formatted response time.
     */
    public function getFormattedResponseTimeAttribute()
    {
        if (!$this->response_time) {
            return 'N/A';
        }

        if ($this->response_time < 1000) {
            return $this->response_time . 'ms';
        } else {
            return round($this->response_time / 1000, 2) . 's';
        }
    }

    /**
     * Get status code color.
     */
    public function getStatusCodeColorAttribute()
    {
        if (!$this->status_code) {
            return 'secondary';
        }

        return match(true) {
            $this->status_code >= 200 && $this->status_code < 300 => 'success',
            $this->status_code >= 300 && $this->status_code < 400 => 'info',
            $this->status_code >= 400 && $this->status_code < 500 => 'warning',
            $this->status_code >= 500 => 'danger',
            default => 'secondary'
        };
    }

    /**
     * Get resource name if available.
     */
    public function getResourceNameAttribute()
    {
        if (!$this->resource_type || !$this->resource_id) {
            return null;
        }

        try {
            $modelClass = 'App\\Models\\' . ucfirst($this->resource_type);
            if (class_exists($modelClass)) {
                $resource = $modelClass::find($this->resource_id);
                return $resource ? $resource->name ?? $resource->title ?? $resource->id : null;
            }
        } catch (\Exception $e) {
            return null;
        }

        return null;
    }

    /**
     * Get human-readable description.
     */
    public function getHumanDescriptionAttribute()
    {
        if ($this->description) {
            return $this->description;
        }

        $action = $this->action ?? 'performed';
        $resource = $this->resource_type ?? 'action';
        
        return ucfirst($action) . ' ' . $resource;
    }

    /**
     * Check if activity is recent (within last hour).
     */
    public function isRecent()
    {
        return $this->created_at->diffInMinutes(now()) < 60;
    }

    /**
     * Check if activity is today.
     */
    public function isToday()
    {
        return $this->created_at->isToday();
    }

    /**
     * Check if activity is this week.
     */
    public function isThisWeek()
    {
        return $this->created_at->isThisWeek();
    }
}
