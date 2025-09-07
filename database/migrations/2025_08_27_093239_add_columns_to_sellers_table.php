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
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('business_name');
            $table->text('description')->nullable();
            $table->string('status')->default('pending'); // pending, active, suspended
            $table->boolean('is_verified')->default(false);
            $table->decimal('commission_rate', 5, 2)->default(10.00);
            $table->json('address')->nullable();
            $table->json('bank_details')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            //
        });
    }
};
