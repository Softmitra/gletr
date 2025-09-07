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
        Schema::create('user_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_session_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('activity_type'); // login, logout, page_view, action, etc.
            $table->string('action')->nullable(); // create, update, delete, view, etc.
            $table->string('resource_type')->nullable(); // user, product, order, etc.
            $table->unsignedBigInteger('resource_id')->nullable(); // ID of the resource
            $table->text('description')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('url')->nullable();
            $table->string('method')->nullable(); // GET, POST, PUT, DELETE
            $table->json('request_data')->nullable(); // Request data (sanitized)
            $table->json('response_data')->nullable(); // Response data (sanitized)
            $table->integer('response_time')->nullable(); // Response time in milliseconds
            $table->integer('status_code')->nullable(); // HTTP status code
            $table->text('error_message')->nullable(); // Error message if any
            $table->json('metadata')->nullable(); // Additional metadata
            $table->timestamps();
            
            $table->index(['user_id', 'created_at']);
            $table->index(['activity_type', 'created_at']);
            $table->index(['resource_type', 'resource_id']);
            $table->index('user_session_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_activities');
    }
};
