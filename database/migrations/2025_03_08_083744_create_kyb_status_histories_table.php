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
        Schema::create('kyb_status_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kyb_id')->constrained('kybs')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users');
            $table->string('status');
            $table->text('comment')->nullable();
            $table->boolean('is_note')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kyb_status_histories');
    }
};
