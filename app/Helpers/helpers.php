<?php

use App\Helpers\CurrencyHelper;
use App\Helpers\DateHelper;

if (!function_exists('currency')) {
    /**
     * Format amount to currency
     */
    function currency($amount, $showSymbol = true)
    {
        return CurrencyHelper::format($amount, $showSymbol);
    }
}

if (!function_exists('currency_indian')) {
    /**
     * Format amount in Indian numbering system
     */
    function currency_indian($amount, $showSymbol = true)
    {
        return CurrencyHelper::formatIndian($amount, $showSymbol);
    }
}

if (!function_exists('currency_symbol')) {
    /**
     * Get currency symbol
     */
    function currency_symbol()
    {
        return CurrencyHelper::symbol();
    }
}

if (!function_exists('format_date')) {
    /**
     * Format date according to Indian format
     */
    function format_date($date, $format = null)
    {
        return DateHelper::formatDate($date, $format);
    }
}

if (!function_exists('format_time')) {
    /**
     * Format time according to Indian format
     */
    function format_time($time, $format = null)
    {
        return DateHelper::formatTime($time, $format);
    }
}

if (!function_exists('format_datetime')) {
    /**
     * Format datetime according to Indian format
     */
    function format_datetime($datetime, $format = null)
    {
        return DateHelper::formatDateTime($datetime, $format);
    }
}

if (!function_exists('time_ago')) {
    /**
     * Get human readable time difference
     */
    function time_ago($date)
    {
        return DateHelper::diffForHumans($date);
    }
}

if (!function_exists('now_indian')) {
    /**
     * Get current date/time in Indian timezone
     */
    function now_indian($format = null)
    {
        return DateHelper::now($format);
    }
}

if (!function_exists('today_indian')) {
    /**
     * Get today's date in Indian format
     */
    function today_indian($format = null)
    {
        return DateHelper::today($format);
    }
}
