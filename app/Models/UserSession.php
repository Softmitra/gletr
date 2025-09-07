<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'ip_address',
        'user_agent',
        'device_type',
        'browser',
        'platform',
        'location',
        'login_at',
        'last_activity_at',
        'logout_at',
        'is_active',
        'logout_reason',
        'session_data',
    ];

    protected $casts = [
        'login_at' => 'datetime',
        'last_activity_at' => 'datetime',
        'logout_at' => 'datetime',
        'is_active' => 'boolean',
        'session_data' => 'array',
    ];

    /**
     * Get the user that owns the session.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the activities for this session.
     */
    public function activities(): HasMany
    {
        return $this->hasMany(UserActivity::class);
    }

    /**
     * Scope to get active sessions.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get inactive sessions.
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    /**
     * Get session duration in seconds.
     */
    public function getDurationAttribute()
    {
        $endTime = $this->logout_at ?? now();
        return $this->login_at->diffInSeconds($endTime);
    }

    /**
     * Get formatted session duration.
     */
    public function getFormattedDurationAttribute()
    {
        $duration = $this->duration;
        
        if ($duration < 60) {
            return $duration . ' seconds';
        } elseif ($duration < 3600) {
            return floor($duration / 60) . ' minutes';
        } else {
            $hours = floor($duration / 3600);
            $minutes = floor(($duration % 3600) / 60);
            return $hours . 'h ' . $minutes . 'm';
        }
    }

    /**
     * Get device icon based on device type.
     */
    public function getDeviceIconAttribute()
    {
        return match($this->device_type) {
            'mobile' => 'fas fa-mobile-alt',
            'tablet' => 'fas fa-tablet-alt',
            'desktop' => 'fas fa-desktop',
            default => 'fas fa-question-circle'
        };
    }

    /**
     * Get browser icon.
     */
    public function getBrowserIconAttribute()
    {
        $browser = strtolower($this->browser ?? '');
        
        return match(true) {
            str_contains($browser, 'chrome') => 'fab fa-chrome',
            str_contains($browser, 'firefox') => 'fab fa-firefox-browser',
            str_contains($browser, 'safari') => 'fab fa-safari',
            str_contains($browser, 'edge') => 'fab fa-edge',
            str_contains($browser, 'opera') => 'fab fa-opera',
            default => 'fas fa-globe'
        };
    }

    /**
     * Get platform icon.
     */
    public function getPlatformIconAttribute()
    {
        $platform = strtolower($this->platform ?? '');
        
        return match(true) {
            str_contains($platform, 'windows') => 'fab fa-windows',
            str_contains($platform, 'mac') => 'fab fa-apple',
            str_contains($platform, 'linux') => 'fab fa-linux',
            str_contains($platform, 'android') => 'fab fa-android',
            str_contains($platform, 'ios') => 'fab fa-apple',
            default => 'fas fa-desktop'
        };
    }

    /**
     * Check if session is expired (inactive for more than 24 hours).
     */
    public function isExpired()
    {
        return $this->last_activity_at && $this->last_activity_at->diffInHours(now()) > 24;
    }

    /**
     * Mark session as inactive.
     */
    public function markInactive($reason = 'timeout')
    {
        $this->update([
            'is_active' => false,
            'logout_at' => now(),
            'logout_reason' => $reason,
        ]);
    }

    /**
     * Update last activity.
     */
    public function updateActivity()
    {
        $this->update(['last_activity_at' => now()]);
    }
}
