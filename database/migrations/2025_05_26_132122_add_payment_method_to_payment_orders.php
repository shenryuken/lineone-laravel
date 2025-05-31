<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payment_orders', function (Blueprint $table) {
            $table->string('payment_method')->nullable()->after('status');
            $table->string('callback_url')->nullable()->after('cancel_url');
            $table->string('merchant_reference')->nullable()->after('merchant_order_id');
            
            // Add indexes for better performance
            $table->index(['merchant_api_key_id', 'payment_method']);
            $table->index(['status', 'payment_method']);
        });
    }

    public function down(): void
    {
        Schema::table('payment_orders', function (Blueprint $table) {
            $table->dropIndex(['merchant_api_key_id', 'payment_method']);
            $table->dropIndex(['status', 'payment_method']);
            $table->dropColumn(['payment_method', 'callback_url', 'merchant_reference']);
        });
    }
};
