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
            $table->boolean('has_expiration')->default(true)->after('id_number');
            // Make id_expiration_date nullable
            $table->date('id_expiration_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kycs', function (Blueprint $table) {
            $table->dropColumn('has_expiration');
            // Make id_expiration_date required again
            $table->date('id_expiration_date')->nullable(false)->change();
        });
    }
};
