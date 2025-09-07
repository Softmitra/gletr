<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'date_of_birth',
        'gender',
        'profile_picture',
        'bio',
        'website',
        'social_links',
        'preferences',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'social_links' => 'array',
        'preferences' => 'array',
    ];

    /**
     * Get the user that owns the profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the profile picture URL.
     */
    public function getProfilePictureUrlAttribute()
    {
        if ($this->profile_picture) {
            return asset('storage/' . $this->profile_picture);
        }
        
        // Return default avatar
        return asset('images/default-avatar.svg');
    }

    /**
     * Get the user's age.
     */
    public function getAgeAttribute()
    {
        if ($this->date_of_birth) {
            return $this->date_of_birth->age;
        }
        return null;
    }

    /**
     * Get formatted phone number.
     */
    public function getFormattedPhoneAttribute()
    {
        if (!$this->phone) {
            return null;
        }
        
        // Basic phone formatting (you can enhance this)
        return preg_replace('/(\d{3})(\d{3})(\d{4})/', '($1) $2-$3', $this->phone);
    }

    /**
     * Get social media links.
     */
    public function getSocialLinksAttribute($value)
    {
        $links = json_decode($value, true) ?: [];
        
        return array_merge([
            'facebook' => null,
            'twitter' => null,
            'instagram' => null,
            'linkedin' => null,
        ], $links);
    }

    /**
     * Get user preferences.
     */
    public function getPreferencesAttribute($value)
    {
        $preferences = json_decode($value, true) ?: [];
        
        return array_merge([
            'notifications' => true,
            'marketing' => false,
            'newsletter' => false,
        ], $preferences);
    }

    /**
     * Check if profile is complete.
     */
    public function getIsCompleteAttribute()
    {
        return !empty($this->phone) && !empty($this->date_of_birth) && !empty($this->gender);
    }

    /**
     * Get profile completion percentage.
     */
    public function getCompletionPercentageAttribute()
    {
        $fields = ['phone', 'date_of_birth', 'gender', 'bio', 'website'];
        $completed = 0;
        
        foreach ($fields as $field) {
            if (!empty($this->$field)) {
                $completed++;
            }
        }
        
        return round(($completed / count($fields)) * 100);
    }
}
