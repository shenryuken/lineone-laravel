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
        Schema::create('merchant_api_keys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name'); // API key name/description
            $table->string('api_key', 64)->unique();
            $table->string('secret_key', 64);
            $table->boolean('is_active')->default(true);
            $table->string('webhook_url')->nullable();
            $table->json('allowed_domains')->nullable(); // Allowed domains for CORS
            $table->decimal('daily_limit', 15, 2)->default(10000.00); // Daily transaction limit
            $table->decimal('per_transaction_limit', 15, 2)->default(1000.00); // Per transaction limit
            $table->timestamp('last_used_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchant_api_keys');
    }
};
