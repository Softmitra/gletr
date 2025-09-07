<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Remove duplicate reviewer assignment logs
        // Keep only the latest assignment for each seller-reviewer combination
        $duplicates = DB::select("
            SELECT id, seller_id, user_id, action, data, created_at,
                   ROW_NUMBER() OVER (
                       PARTITION BY seller_id, JSON_EXTRACT(data, '$.reviewer_id'), action 
                       ORDER BY created_at DESC
                   ) as row_num
            FROM seller_verification_logs 
            WHERE action = 'reviewer_assigned'
        ");

        // Delete duplicates (keep only the most recent one)
        $idsToDelete = [];
        foreach ($duplicates as $log) {
            if ($log->row_num > 1) {
                $idsToDelete[] = $log->id;
            }
        }

        if (!empty($idsToDelete)) {
            DB::table('seller_verification_logs')
                ->whereIn('id', $idsToDelete)
                ->delete();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Cannot reverse this operation as we've deleted duplicate data
    }
};
