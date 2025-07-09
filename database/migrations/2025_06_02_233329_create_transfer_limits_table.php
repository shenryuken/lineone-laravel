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
        Schema::create('transfer_limits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->bigInteger('daily_limit')->default(500000); // 5000 MYR in cents
            $table->bigInteger('monthly_limit')->default(5000000); // 50000 MYR in cents
            $table->bigInteger('single_transfer_limit')->default(100000); // 1000 MYR in cents
            $table->bigInteger('daily_used')->default(0);
            $table->bigInteger('monthly_used')->default(0);
            $table->date('daily_reset_date')->default(now()->toDateString());
            $table->date('monthly_reset_date')->default(now()->startOfMonth()->toDateString());
            $table->boolean('is_verified')->default(false);
            $table->timestamps();

            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_limits');
    }
};
