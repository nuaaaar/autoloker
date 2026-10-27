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
        Schema::table('master_category_certificates', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_id')
                ->nullable()
                ->after('id');

            $table->boolean('is_tuk')
                ->default(false)
                ->after('parent_id');

            $table->unsignedInteger('level')
                ->default(1)
                ->after('is_tuk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_category_certificates', function (Blueprint $table) {
            $table->dropColumn([
                'parent_id',
                'is_tuk',
                'level',
            ]);
        });
    }
};
