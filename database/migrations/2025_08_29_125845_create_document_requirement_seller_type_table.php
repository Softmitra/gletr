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
        Schema::create('document_requirement_seller_type', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_requirement_id')->constrained()->onDelete('cascade');
            $table->foreignId('seller_type_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            // Ensure unique combinations
            $table->unique(['document_requirement_id', 'seller_type_id'], 'doc_req_seller_type_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_requirement_seller_type');
    }
};
