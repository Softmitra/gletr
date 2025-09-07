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
        // Update seller_documents table - change enum to string (if it exists as enum)
        if (Schema::hasTable('seller_documents')) {
            // Update existing records to use new status values
            DB::table('seller_documents')
                ->where('verification_status', 'manually_verified')
                ->update(['verification_status' => 'verified']);
                
            DB::table('seller_documents')
                ->where('verification_status', 'ai_verified')
                ->update(['verification_status' => 'verified']);
        }
        
        // Update sellers table verification_status values if needed
        if (Schema::hasTable('sellers')) {
            DB::table('sellers')
                ->where('verification_status', 'documents_verified')
                ->update(['verification_status' => 'verified']);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to old values if needed
        if (Schema::hasTable('seller_documents')) {
            DB::table('seller_documents')
                ->where('verification_status', 'verified')
                ->update(['verification_status' => 'manually_verified']);
        }
        
        if (Schema::hasTable('sellers')) {
            DB::table('sellers')
                ->where('verification_status', 'verified')
                ->update(['verification_status' => 'documents_verified']);
        }
    }
};
