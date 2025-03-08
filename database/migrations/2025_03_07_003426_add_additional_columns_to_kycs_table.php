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
        Schema::table('kycs', function (Blueprint $table) {
            $table->text('additional_info_requested')->nullable();
            $table->timestamp('additional_info_requested_at')->nullable();
            $table->unsignedBigInteger('additional_info_requested_by')->nullable();
            $table->text('additional_info_response')->nullable();
            $table->timestamp('additional_info_responded_at')->nullable();
            $table->json('additional_documents')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kycs', function (Blueprint $table) {
            $table->dropColumn('additional_info_requested');
            $table->dropColumn('additional_info_requested_at');
            $table->dropColumn('additional_info_requested_by');
            $table->dropColumn('additional_info_response');
            $table->dropColumn('additional_info_responded_at');
            $table->dropColumn('additional_documents');
        });
    }
};
