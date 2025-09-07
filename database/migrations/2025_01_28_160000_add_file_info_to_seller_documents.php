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
        Schema::table('seller_documents', function (Blueprint $table) {
            $table->string('original_filename')->nullable()->after('document_path');
            $table->unsignedBigInteger('file_size')->nullable()->after('original_filename');
            $table->string('mime_type')->nullable()->after('file_size');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seller_documents', function (Blueprint $table) {
            $table->dropColumn(['original_filename', 'file_size', 'mime_type']);
        });
    }
};
