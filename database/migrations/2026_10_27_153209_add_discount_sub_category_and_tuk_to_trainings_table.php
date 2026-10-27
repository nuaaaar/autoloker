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
        Schema::table('trainings', function (Blueprint $table) {
            $table->decimal('discount', 15, 2)->default(0)->after('price');
            $table->string('sub_category')->nullable()->after('discount');
            $table->string('tuk')->nullable()->after('sub_category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->dropColumn([
                'discount',
                'sub_category',
                'tuk',
            ]);
        });
    }
};
