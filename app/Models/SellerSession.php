<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Jenssegers\Agent\Agent;

class SellerSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'session_id',
        'ip_address',
        'user_agent',
        'device_type',
        'browser',
        'platform',
        'location',
        'login_at',
        'last_activity',
        'logout_at',
        'is_active',
    ];

    protected $casts = [
        'login_at' => 'datetime',
        'last_activity' => 'datetime',
        'logout_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Get the seller that owns the session
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    /**
     * Create a new session record
     */
    public static function createSession($seller, $request)
    {
        $agent = new Agent();
        $agent->setUserAgent($request->userAgent());

        return self::create([
            'seller_id' => $seller->id,
            'session_id' => $request->session()->getId(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'device_type' => $agent->isMobile() ? 'mobile' : ($agent->isTablet() ? 'tablet' : 'desktop'),
            'browser' => $agent->browser(),
            'platform' => $agent->platform(),
            'location' => self::getLocationFromIP($request->ip()),
            'login_at' => now(),
            'last_activity' => now(),
            'is_active' => true,
        ]);
    }

    /**
     * Update session activity
     */
    public function updateActivity()
    {
        $this->update(['last_activity' => now()]);
    }

    /**
     * Mark session as logged out
     */
    public function markAsLoggedOut()
    {
        $this->update([
            'logout_at' => now(),
            'is_active' => false,
        ]);
    }

    /**
     * Get device icon
     */
    public function getDeviceIconAttribute(): string
    {
        return match($this->device_type) {
            'mobile' => 'fas fa-mobile-alt',
            'tablet' => 'fas fa-tablet-alt',
            'desktop' => 'fas fa-desktop',
            default => 'fas fa-question-circle'
        };
    }

    /**
     * Get browser icon
     */
    public function getBrowserIconAttribute(): string
    {
        $browser = strtolower($this->browser ?? '');
        
        return match(true) {
            str_contains($browser, 'chrome') => 'fab fa-chrome',
            str_contains($browser, 'firefox') => 'fab fa-firefox',
            str_contains($browser, 'safari') => 'fab fa-safari',
            str_contains($browser, 'edge') => 'fab fa-edge',
            str_contains($browser, 'opera') => 'fab fa-opera',
            default => 'fas fa-globe'
        };
    }

    /**
     * Get platform icon
     */
    public function getPlatformIconAttribute(): string
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
     * Check if session is current
     */
    public function isCurrentSession(): bool
    {
        return $this->session_id === session()->getId();
    }

    /**
     * Get session duration
     */
    public function getDurationAttribute(): string
    {
        if ($this->logout_at) {
            return $this->login_at->diffForHumans($this->logout_at, true);
        }
        
        return $this->login_at->diffForHumans(now(), true);
    }

    /**
     * Scope for active sessions
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for inactive sessions
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    /**
     * Scope for recent sessions
     */
    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('login_at', '>=', now()->subDays($days));
    }

    /**
     * Get location from IP address (basic implementation)
     */
    private static function getLocationFromIP($ip): ?string
    {
        // For localhost/private IPs
        if ($ip === '127.0.0.1' || $ip === '::1' || str_starts_with($ip, '192.168.') || str_starts_with($ip, '10.')) {
            return 'Local Network';
        }

        // TODO: Implement actual IP geolocation service
        // You can integrate with services like:
        // - ipapi.co
        // - ipgeolocation.io
        // - MaxMind GeoIP
        
        return null;
    }
}
