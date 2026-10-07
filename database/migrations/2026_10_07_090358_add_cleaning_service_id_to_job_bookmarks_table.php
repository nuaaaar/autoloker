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
        Schema::table('job_bookmarks', function (Blueprint $table) {
            $table->foreignId('cleaning_service_id')
                ->nullable()
                ->after('security_id')
                ->constrained('cleaning_services')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_bookmarks', function (Blueprint $table) {
            $table->dropForeign([
                'cleaning_service_id',
            ]);

            $table->dropColumn(
                'cleaning_service_id'
            );
        });
    }
};
