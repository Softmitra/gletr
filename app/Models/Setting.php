<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'category',
        'group',
        'label',
        'description',
        'is_public',
        'is_required',
        'options',
        'validation_rules',
        'sort_order',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'is_required' => 'boolean',
        'options' => 'array',
    ];

    /**
     * Get setting value with proper type casting
     */
    public function getTypedValueAttribute()
    {
        $value = $this->value;

        switch ($this->type) {
            case 'boolean':
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
            case 'integer':
                return (int) $value;
            case 'float':
                return (float) $value;
            case 'json':
            case 'array':
                return json_decode($value, true);
            default:
                return $value;
        }
    }

    /**
     * Set setting value with proper type handling
     */
    public function setTypedValueAttribute($value)
    {
        switch ($this->type) {
            case 'boolean':
                $this->value = $value ? '1' : '0';
                break;
            case 'integer':
                $this->value = (string) (int) $value;
                break;
            case 'float':
                $this->value = (string) (float) $value;
                break;
            case 'json':
            case 'array':
                $this->value = is_string($value) ? $value : json_encode($value);
                break;
            default:
                $this->value = (string) $value;
        }
    }

    /**
     * Get setting by key
     */
    public static function getByKey(string $key, $default = null)
    {
        $cacheKey = "setting_{$key}";
        
        return Cache::remember($cacheKey, 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->typed_value : $default;
        });
    }

    /**
     * Set setting by key
     */
    public static function setByKey(string $key, $value, string $type = 'string'): bool
    {
        $setting = static::firstOrNew(['key' => $key]);
        
        if (!$setting->exists) {
            $setting->type = $type;
            $setting->label = ucwords(str_replace('_', ' ', $key));
            $setting->category = 'general';
        }
        
        $setting->typed_value = $value;
        $result = $setting->save();
        
        if ($result) {
            Cache::forget("setting_{$key}");
        }
        
        return $result;
    }

    /**
     * Get settings by category
     */
    public static function getByCategory(string $category): \Illuminate\Database\Eloquent\Collection
    {
        return static::where('category', $category)
            ->orderBy('sort_order')
            ->orderBy('label')
            ->get();
    }

    /**
     * Get settings by group
     */
    public static function getByGroup(string $group): \Illuminate\Database\Eloquent\Collection
    {
        return static::where('group', $group)
            ->orderBy('sort_order')
            ->orderBy('label')
            ->get();
    }

    /**
     * Get all settings as key-value pairs
     */
    public static function getAllAsArray(): array
    {
        return static::all()->pluck('typed_value', 'key')->toArray();
    }

    /**
     * Get public settings
     */
    public static function getPublicSettings(): array
    {
        return static::where('is_public', true)
            ->get()
            ->pluck('typed_value', 'key')
            ->toArray();
    }

    /**
     * Clear settings cache
     */
    public static function clearCache(): void
    {
        $settings = static::all();
        foreach ($settings as $setting) {
            Cache::forget("setting_{$setting->key}");
        }
    }

    /**
     * Boot method to clear cache on model events
     */
    protected static function boot()
    {
        parent::boot();

        static::saved(function ($setting) {
            Cache::forget("setting_{$setting->key}");
        });

        static::deleted(function ($setting) {
            Cache::forget("setting_{$setting->key}");
        });
    }
}
