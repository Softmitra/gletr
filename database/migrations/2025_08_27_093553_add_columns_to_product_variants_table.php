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
        Schema::table('product_variants', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained('products');
            $table->string('sku')->unique();
            $table->string('size')->nullable();
            $table->decimal('net_metal_weight', 10, 3)->nullable();
            $table->decimal('gross_weight', 10, 3)->nullable();
            $table->decimal('stone_weight', 10, 3)->nullable();
            $table->decimal('making_charges', 10, 2)->default(0);
            $table->decimal('stone_charges', 10, 2)->default(0);
            $table->decimal('other_charges', 10, 2)->default(0);
            $table->decimal('mrp', 10, 2);
            $table->decimal('sale_price', 10, 2);
            $table->boolean('is_active')->default(true);
            $table->json('attributes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            //
        });
    }
};
