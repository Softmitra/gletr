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
        Schema::create('seller_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained()->onDelete('cascade');
            $table->foreignId('seller_session_id')->nullable()->constrained()->onDelete('set null');
            $table->string('activity_type'); // login, logout, page_view, action
            $table->string('action')->nullable(); // create, update, delete, view, etc.
            $table->string('resource_type')->nullable(); // product, order, profile, etc.
            $table->string('resource_id')->nullable();
            $table->text('description')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->text('url')->nullable();
            $table->string('method', 10)->nullable(); // GET, POST, PUT, DELETE
            $table->json('request_data')->nullable();
            $table->json('response_data')->nullable();
            $table->integer('response_time')->nullable(); // in milliseconds
            $table->integer('status_code')->nullable();
            $table->text('error_message')->nullable();
            $table->json('metadata')->nullable(); // Additional context data
            $table->timestamps();

            // Indexes for better performance
            $table->index(['seller_id', 'created_at']);
            $table->index(['activity_type', 'created_at']);
            $table->index(['resource_type', 'created_at']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_activities');
    }
};
