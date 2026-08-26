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
        Schema::table('job_vacancies', function (Blueprint $table) {
            if (! Schema::hasColumn('job_vacancies', 'min_height')) {
                $table->unsignedSmallInteger('min_height')
                    ->nullable()
                    ->after('max_age');
            }

            if (! Schema::hasColumn('job_vacancies', 'max_height')) {
                $table->unsignedSmallInteger('max_height')
                    ->nullable()
                    ->after('min_height');
            }

            if (! Schema::hasColumn('job_vacancies', 'min_weight')) {
                $table->unsignedSmallInteger('min_weight')
                    ->nullable()
                    ->after('max_height');
            }

            if (! Schema::hasColumn('job_vacancies', 'max_weight')) {
                $table->unsignedSmallInteger('max_weight')
                    ->nullable()
                    ->after('min_weight');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_vacancies', function (Blueprint $table) {
            $table->dropColumn([
                'min_height',
                'max_height',
                'min_weight',
                'max_weight',
            ]);
        });
    }
};
