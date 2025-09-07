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
        // Fix the verification_status column to allow all DocumentStatus values
        Schema::table('seller_documents', function (Blueprint $table) {
            // Change verification_status to a longer string to accommodate all values
            $table->string('verification_status', 100)->default('pending')->change();
        });
        
        // Ensure all existing data uses correct values
        DB::table('seller_documents')
            ->whereIn('verification_status', ['approved', 'manually_verified', 'ai_verified'])
            ->update(['verification_status' => 'verified']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seller_documents', function (Blueprint $table) {
            $table->string('verification_status', 50)->default('pending')->change();
        });
    }
};