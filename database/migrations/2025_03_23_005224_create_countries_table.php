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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('code', 3)->unique(); // ISO 3166-1 alpha-3 code
            $table->string('code_alpha2', 2)->unique(); // ISO 3166-1 alpha-2 code
            $table->string('name');
            $table->string('currency_code', 3)->nullable(); // ISO 4217 currency code
            $table->string('currency_name')->nullable();
            $table->string('currency_symbol', 10)->nullable();
            $table->string('phone_code', 10)->nullable(); // Country calling code
            $table->string('flag_path')->nullable(); // Path to flag image
            $table->string('region')->nullable(); // Continent/region
            $table->boolean('is_active')->default(true);
            $table->json('metadata')->nullable(); // Additional information
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
