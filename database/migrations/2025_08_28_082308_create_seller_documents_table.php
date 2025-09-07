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
        Schema::create('seller_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seller_id');
            $table->string('document_type');
            $table->string('document_path');
            $table->string('verification_status', 50)->default('pending');
            $table->text('admin_comments')->nullable();
            $table->longText('ai_verification_result')->nullable();
            $table->unsignedBigInteger('expert_reviewer_id')->nullable();
            $table->timestamp('uploaded_at')->useCurrent();
            $table->timestamp('verified_at')->nullable();
            $table->date('expiry_date')->nullable();
            $table->boolean('is_mandatory')->default(false);
            $table->timestamps();

            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('cascade');
            $table->foreign('expert_reviewer_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_documents');
    }
};
