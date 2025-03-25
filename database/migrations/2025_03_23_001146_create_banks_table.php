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
        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable(); // Bank code
            $table->string('swift_code')->nullable(); // For international banks
            $table->enum('type', ['local', 'international']);
            $table->string('country_code', 3); // ISO country code
            $table->string('country_name');
            $table->json('supported_currencies'); // Array of currency codes
            $table->text('description')->nullable();
            $table->string('logo_path')->nullable();
            $table->boolean('is_active')->default(true);
            $table->json('metadata')->nullable(); // For additional fields
            $table->timestamps();

            // Add unique constraint for bank code within a country
            $table->unique(['code', 'country_code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banks');
    }
};
