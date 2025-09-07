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
        Schema::create('email_configurations', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'customer' or 'seller'
            $table->string('event'); // 'registration', 'order_placed', 'order_confirmed', etc.
            $table->boolean('is_enabled')->default(true);
            $table->string('subject');
            $table->text('template_path')->nullable();
            $table->json('variables')->nullable(); // Available template variables
            $table->text('description')->nullable();
            $table->timestamps();

            // Unique constraint to prevent duplicate type-event combinations
            $table->unique(['type', 'event']);
            
            // Indexes for better performance
            $table->index(['type', 'is_enabled']);
            $table->index('event');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_configurations');
    }
};
