<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'last_login_at',
        'last_login_ip',
        'last_login_user_agent',
        'status',
        'suspended_at',
        'suspension_reason',
        'banned_at',
        'ban_reason',
        'login_attempts',
        'locked_until',
        'preferences',
        'timezone',
        'locale',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
            'suspended_at' => 'datetime',
            'banned_at' => 'datetime',
            'locked_until' => 'datetime',
            'preferences' => 'array',
        ];
    }

    /**
     * Get the user's sessions.
     */
    public function sessions(): HasMany
    {
        return $this->hasMany(UserSession::class);
    }

    /**
     * Get the user's activities.
     */
    public function activities(): HasMany
    {
        return $this->hasMany(UserActivity::class);
    }

    /**
     * Get the user's active sessions.
     */
    public function activeSessions(): HasMany
    {
        return $this->hasMany(UserSession::class)->active();
    }

    /**
     * Get the user's recent activities.
     */
    public function recentActivities($limit = 10): HasMany
    {
        return $this->hasMany(UserActivity::class)->latest()->limit($limit);
    }

    /**
     * Get the profile for the user.
     */
    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    /**
     * Get the addresses for the user.
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(UserAddress::class);
    }

    /**
     * Get the orders for the user.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the reviews for the user.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Check if user is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if user is suspended.
     */
    public function isSuspended(): bool
    {
        return $this->status === 'suspended';
    }

    /**
     * Check if user is banned.
     */
    public function isBanned(): bool
    {
        return $this->status === 'banned';
    }

    /**
     * Check if user is locked.
     */
    public function isLocked(): bool
    {
        return $this->locked_until && $this->locked_until->isFuture();
    }

    /**
     * Get user status badge color.
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'active' => 'success',
            'inactive' => 'secondary',
            'suspended' => 'warning',
            'banned' => 'danger',
            default => 'secondary'
        };
    }

    /**
     * Get user status icon.
     */
    public function getStatusIconAttribute(): string
    {
        return match($this->status) {
            'active' => 'fas fa-check-circle',
            'inactive' => 'fas fa-circle',
            'suspended' => 'fas fa-pause-circle',
            'banned' => 'fas fa-ban',
            default => 'fas fa-question-circle'
        };
    }

    /**
     * Update last login information.
     */
    public function updateLastLogin($ipAddress = null, $userAgent = null): void
    {
        $this->update([
            'last_login_at' => now(),
            'last_login_ip' => $ipAddress,
            'last_login_user_agent' => $userAgent,
            'login_attempts' => 0,
            'locked_until' => null,
        ]);
    }

    /**
     * Increment login attempts.
     */
    public function incrementLoginAttempts(): void
    {
        $this->increment('login_attempts');
        
        // Lock account after 5 failed attempts for 30 minutes
        if ($this->login_attempts >= 5) {
            $this->update(['locked_until' => now()->addMinutes(30)]);
        }
    }

    /**
     * Suspend user.
     */
    public function suspend($reason = null): void
    {
        $this->update([
            'status' => 'suspended',
            'suspended_at' => now(),
            'suspension_reason' => $reason,
        ]);
    }

    /**
     * Activate user.
     */
    public function activate(): void
    {
        $this->update([
            'status' => 'active',
            'suspended_at' => null,
            'suspension_reason' => null,
            'banned_at' => null,
            'ban_reason' => null,
        ]);
    }

    /**
     * Ban user.
     */
    public function ban($reason = null): void
    {
        $this->update([
            'status' => 'banned',
            'banned_at' => now(),
            'ban_reason' => $reason,
        ]);
    }

    /**
     * Get user's total session count.
     */
    public function getTotalSessionsAttribute(): int
    {
        return $this->sessions()->count();
    }

    /**
     * Get user's total activity count.
     */
    public function getTotalActivitiesAttribute(): int
    {
        return $this->activities()->count();
    }

    /**
     * Get user's last activity.
     */
    public function getLastActivityAttribute()
    {
        return $this->activities()->latest()->first();
    }

    /**
     * Get user's login count.
     */
    public function getLoginCountAttribute(): int
    {
        return $this->activities()->logins()->count();
    }

    /**
     * Get user's last login session.
     */
    public function getLastLoginSessionAttribute()
    {
        return $this->sessions()->latest('login_at')->first();
    }
}
