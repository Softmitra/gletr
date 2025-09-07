<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    /**
     * Format date according to Indian format
     */
    public static function formatDate($date, $format = null)
    {
        if (!$date) return '';
        
        $format = $format ?: config('gletr.locale.date_format');
        
        return Carbon::parse($date)->format($format);
    }
    
    /**
     * Format time according to Indian format
     */
    public static function formatTime($time, $format = null)
    {
        if (!$time) return '';
        
        $format = $format ?: config('gletr.locale.time_format');
        
        return Carbon::parse($time)->format($format);
    }
    
    /**
     * Format datetime according to Indian format
     */
    public static function formatDateTime($datetime, $format = null)
    {
        if (!$datetime) return '';
        
        $format = $format ?: config('gletr.locale.datetime_format');
        
        return Carbon::parse($datetime)->format($format);
    }
    
    /**
     * Get human readable time difference
     */
    public static function diffForHumans($date)
    {
        if (!$date) return '';
        
        return Carbon::parse($date)->diffForHumans();
    }
    
    /**
     * Get current date in Indian timezone
     */
    public static function now($format = null)
    {
        $format = $format ?: config('gletr.locale.datetime_format');
        
        return Carbon::now(config('gletr.locale.timezone'))->format($format);
    }
    
    /**
     * Get today's date in Indian format
     */
    public static function today($format = null)
    {
        $format = $format ?: config('gletr.locale.date_format');
        
        return Carbon::today(config('gletr.locale.timezone'))->format($format);
    }
}
