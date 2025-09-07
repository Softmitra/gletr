<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class LogTestController extends Controller
{
    /**
     * Generate test log entries for demonstration
     */
    public function generateTestLogs()
    {
        // Generate various log levels for testing
        Log::info('Admin panel accessed', [
            'user_id' => auth()->id(),
            'user_email' => auth()->user()->email,
            'timestamp' => now(),
            'ip_address' => request()->ip(),
        ]);

        Log::warning('High value order detected', [
            'order_id' => 'ORD-2024-001',
            'amount' => 250000,
            'currency' => 'INR',
            'customer_id' => 123,
        ]);

        Log::error('Payment gateway timeout', [
            'gateway' => 'razorpay',
            'transaction_id' => 'TXN-' . uniqid(),
            'error_code' => 'GATEWAY_TIMEOUT',
            'retry_count' => 3,
        ]);

        Log::debug('Database query performance', [
            'query' => 'SELECT * FROM products WHERE status = ?',
            'execution_time' => '45ms',
            'rows_affected' => 150,
        ]);

        Log::notice('New seller registration', [
            'seller_name' => 'Golden Jewelry Store',
            'email' => 'contact@goldenjewelry.com',
            'phone' => '+91-9876543210',
            'status' => 'pending_verification',
        ]);

        return response()->json([
            'message' => 'Test log entries generated successfully',
            'entries' => 5,
            'timestamp' => now()->format('Y-m-d H:i:s'),
        ]);
    }
}
