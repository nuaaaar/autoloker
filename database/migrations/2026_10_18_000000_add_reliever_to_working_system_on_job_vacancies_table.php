<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public $withinTransaction = false;

    public function up(): void
    {
        Schema::table('job_vacancies', function (Blueprint $table) {
            $table->enum('working_system', ['shift', 'non-shift', 'reliever'])->default('non-shift')->change();
        });
    }

    public function down(): void
    {
        if (DB::table('job_vacancies')->where('working_system', 'reliever')->exists()) {
            throw new RuntimeException('Cannot remove reliever from job_vacancies.working_system while reliever vacancies exist.');
        }

        Schema::table('job_vacancies', function (Blueprint $table) {
            $table->enum('working_system', ['shift', 'non-shift'])->default('non-shift')->change();
        });
    }
};
