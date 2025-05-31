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
        Schema::table('merchant_api_keys', function (Blueprint $table) {
            $table->enum('mode', ['test', 'live'])->default('test')->after('secret_key');
            $table->text('description')->nullable()->after('name');
            $table->json('permissions')->nullable()->after('allowed_domains'); // Future: granular permissions
            $table->timestamp('expires_at')->nullable()->after('last_used_at');
        });
    }

    public function down(): void
    {
        Schema::table('merchant_api_keys', function (Blueprint $table) {
            $table->dropColumn(['mode', 'description', 'permissions', 'expires_at']);
        });
    }
};
