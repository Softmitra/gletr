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
        Schema::table('sellers', function (Blueprint $table) {
            $table->text('business_description')->nullable()->after('business_name');
            $table->json('store_settings')->nullable()->after('verification_status');
            $table->json('store_branding')->nullable()->after('store_settings');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            $table->dropColumn(['business_description', 'store_settings', 'store_branding']);
        });
    }
};
