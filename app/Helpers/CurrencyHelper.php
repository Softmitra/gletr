<?php

namespace App\Helpers;

class CurrencyHelper
{
    /**
     * Format amount to INR currency
     */
    public static function format($amount, $showSymbol = true)
    {
        $currency = config('gletr.currency');
        
        $formatted = number_format(
            $amount,
            $currency['decimal_places'],
            $currency['decimal_separator'],
            $currency['thousands_separator']
        );
        
        if ($showSymbol) {
            if ($currency['symbol_position'] === 'before') {
                return $currency['symbol'] . $formatted;
            } else {
                return $formatted . $currency['symbol'];
            }
        }
        
        return $formatted;
    }
    
    /**
     * Format amount in Indian numbering system (Lakhs, Crores)
     */
    public static function formatIndian($amount, $showSymbol = true)
    {
        $currency = config('gletr.currency');
        
        if ($amount >= 10000000) { // 1 Crore
            $formatted = number_format($amount / 10000000, 2) . ' Cr';
        } elseif ($amount >= 100000) { // 1 Lakh
            $formatted = number_format($amount / 100000, 2) . ' L';
        } elseif ($amount >= 1000) { // 1 Thousand
            $formatted = number_format($amount / 1000, 1) . 'K';
        } else {
            $formatted = number_format($amount, 0);
        }
        
        if ($showSymbol) {
            return $currency['symbol'] . $formatted;
        }
        
        return $formatted;
    }
    
    /**
     * Get currency symbol
     */
    public static function symbol()
    {
        return config('gletr.currency.symbol');
    }
    
    /**
     * Get currency code
     */
    public static function code()
    {
        return config('gletr.currency.code');
    }
}
