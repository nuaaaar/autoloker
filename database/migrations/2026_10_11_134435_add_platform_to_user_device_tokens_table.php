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
        Schema::table('user_device_tokens', function (Blueprint $table) {
            $table->enum('platform', ['mobile', 'web'])->default('mobile')->after('fcm_token_hash');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_device_tokens', function (Blueprint $table) {
            $table->dropColumn('platform');
        });
    }
};
