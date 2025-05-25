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
        Schema::create('payment_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id', 32)->unique(); // Public order ID
            $table->foreignId('merchant_api_key_id')->constrained('merchant_api_keys')->onDelete('cascade');
            $table->decimal('amount', 15, 2);
            $table->string('currency', 3)->default('MYR');
            $table->string('description');
            $table->string('customer_email');
            $table->string('customer_name')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('merchant_order_id')->nullable(); // Merchant's internal order ID
            $table->string('return_url')->nullable(); // Where to redirect after payment
            $table->string('cancel_url')->nullable(); // Where to redirect if cancelled
            $table->enum('status', ['pending', 'paid', 'failed', 'expired', 'cancelled'])->default('pending');
            $table->foreignId('transaction_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamp('expires_at');
            $table->timestamp('paid_at')->nullable();
            $table->json('metadata')->nullable(); // Additional data from merchant
            $table->timestamps();
            
            $table->index(['merchant_api_key_id', 'status']);
            $table->index(['order_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_orders');
    }
};
