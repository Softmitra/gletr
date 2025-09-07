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
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip', 45)->nullable();
            $table->text('last_login_user_agent')->nullable();
            $table->enum('status', ['active', 'inactive', 'suspended', 'banned'])->default('active');
            $table->timestamp('suspended_at')->nullable();
            $table->text('suspension_reason')->nullable();
            $table->timestamp('banned_at')->nullable();
            $table->text('ban_reason')->nullable();
            $table->integer('login_attempts')->default(0);
            $table->timestamp('locked_until')->nullable();
            $table->json('preferences')->nullable(); // User preferences
            $table->string('timezone')->default('Asia/Kolkata');
            $table->string('locale')->default('en');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'last_login_at',
                'last_login_ip',
                'last_login_user_agent',
                'status',
                'suspended_at',
                'suspension_reason',
                'banned_at',
                'ban_reason',
                'login_attempts',
                'locked_until',
                'preferences',
                'timezone',
                'locale'
            ]);
        });
    }
};
