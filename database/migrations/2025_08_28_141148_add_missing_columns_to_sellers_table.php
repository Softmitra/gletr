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
        Schema::table('sellers', function (Blueprint $table) {
            // Add missing columns that the Seller model expects
            $table->string('f_name')->nullable()->after('name');
            $table->string('l_name')->nullable()->after('f_name');
            $table->string('country_code')->nullable()->after('phone');
            $table->string('image')->nullable()->after('description');
            $table->string('password')->nullable()->after('image');
            $table->decimal('free_delivery_over_amount', 10, 2)->nullable()->after('commission_rate');
            $table->string('ifsc_code')->nullable()->after('free_delivery_over_amount');
            $table->string('bank_name')->nullable()->after('ifsc_code');
            $table->string('branch')->nullable()->after('bank_name');
            $table->string('account_no')->nullable()->after('branch');
            $table->string('holder_name')->nullable()->after('account_no');
            $table->string('auth_token')->nullable()->after('holder_name');
            $table->decimal('sales_commission_percentage', 5, 2)->nullable()->after('auth_token');
            $table->string('gst')->nullable()->after('sales_commission_percentage');
            $table->string('gst_number')->nullable()->after('gst');
            $table->string('pan_number')->nullable()->after('gst_number');
            $table->string('address_line_1')->nullable()->after('pan_number');
            $table->string('address_line_2')->nullable()->after('address_line_1');
            $table->string('pincode')->nullable()->after('address_line_2');
            $table->string('area')->nullable()->after('pincode');
            $table->string('city')->nullable()->after('area');
            $table->string('state')->nullable()->after('city');
            $table->string('country')->nullable()->after('state');
            $table->string('cm_firebase_token')->nullable()->after('country');
            $table->integer('pos_status')->default(0)->after('cm_firebase_token');
            $table->decimal('minimum_order_amount', 10, 2)->nullable()->after('pos_status');
            $table->integer('stock_limit')->nullable()->after('minimum_order_amount');
            $table->boolean('free_delivery_status')->default(false)->after('stock_limit');
            $table->string('app_language')->default('en')->after('free_delivery_status');
            $table->string('business_type')->nullable()->after('app_language');
            $table->string('verification_stage')->nullable()->after('business_type');
            $table->string('verification_status')->nullable()->after('verification_stage');
            $table->string('kyc_status')->nullable()->after('verification_status');
            $table->unsignedBigInteger('expert_reviewer_id')->nullable()->after('kyc_status');
            $table->text('verification_notes')->nullable()->after('expert_reviewer_id');
            $table->timestamp('verification_completed_at')->nullable()->after('verification_notes');
            
            // Add foreign key for expert_reviewer_id
            $table->foreign('expert_reviewer_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            // Drop the columns in reverse order
            $table->dropForeign(['expert_reviewer_id']);
            $table->dropColumn([
                'f_name', 'l_name', 'country_code', 'image', 'password',
                'free_delivery_over_amount', 'ifsc_code', 'bank_name', 'branch',
                'account_no', 'holder_name', 'auth_token', 'sales_commission_percentage',
                'gst', 'gst_number', 'pan_number', 'address_line_1', 'address_line_2',
                'pincode', 'area', 'city', 'state', 'country', 'cm_firebase_token',
                'pos_status', 'minimum_order_amount', 'stock_limit', 'free_delivery_status',
                'app_language', 'business_type', 'verification_stage', 'verification_status',
                'kyc_status', 'expert_reviewer_id', 'verification_notes', 'verification_completed_at'
            ]);
        });
    }
};
