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
        Schema::create('seller_stores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seller_id');
            $table->string('store_name');
            $table->text('store_description')->nullable();
            $table->text('store_address');
            $table->string('store_logo')->nullable();
            $table->string('store_banner')->nullable();
            $table->string('store_phone')->nullable();
            $table->string('store_email')->nullable();
            $table->json('store_timings')->nullable();
            $table->json('store_categories')->nullable();
            $table->string('store_slug')->unique()->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->decimal('rating', 3, 2)->default(0);
            $table->integer('total_reviews')->default(0);
            $table->integer('total_products')->default(0);
            $table->integer('total_sales')->default(0);
            $table->json('store_policies')->nullable();
            $table->json('social_links')->nullable();
            $table->json('meta_data')->nullable();
            $table->timestamps();
            
            // Foreign key constraint
            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('cascade');
            
            // Indexes
            $table->index('store_slug');
            $table->index('is_active');
            $table->index('is_featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_stores');
    }
};