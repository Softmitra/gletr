<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('seller_documents', function (Blueprint $table) {
            // Add missing fields if they don't exist
            if (!Schema::hasColumn('seller_documents', 'file_type')) {
                $table->string('file_type')->nullable()->after('file_size');
            }
            
            if (!Schema::hasColumn('seller_documents', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable()->after('admin_comments');
            }
            
            if (!Schema::hasColumn('seller_documents', 'verified_by')) {
                $table->string('verified_by')->nullable()->after('rejection_reason');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seller_documents', function (Blueprint $table) {
            $table->dropColumn(['file_type', 'rejection_reason', 'verified_by']);
        });
    }
};