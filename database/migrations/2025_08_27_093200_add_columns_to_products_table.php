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
        Schema::table('products', function (Blueprint $table) {
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('sku')->unique();
            $table->foreignId('seller_id')->nullable()->constrained('sellers');
            $table->foreignId('category_id')->nullable()->constrained('categories');
            $table->string('status')->default('draft'); // draft, live, inactive
            $table->boolean('is_featured')->default(false);
            $table->string('metal_type')->nullable(); // gold, silver, platinum, diamond
            $table->string('purity')->nullable(); // 24k, 22k, 18k, 14k, 925, 950
            $table->decimal('weight', 10, 3)->nullable();
            $table->string('weight_unit')->default('grams');
            $table->integer('views')->default(0);
            $table->integer('sales_count')->default(0);
            $table->json('tags')->nullable();
            $table->json('attributes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
};
