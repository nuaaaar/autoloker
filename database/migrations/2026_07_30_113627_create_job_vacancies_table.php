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
        Schema::create('job_vacancies', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable();
            $table->foreignId('b_u_j_p_id')->nullable();
            $table->foreignId('company_id')->nullable();
            $table->string('position')->nullable();
            $table->text('description_work')->nullable();
            $table->text('responsibility')->nullable();
            $table->text('facility')->nullable();
            $table->integer('kuota')->nullable();
            $table->enum('status', ['draft', 'rejected', 'submitted', 'published', 'closed'])->default('draft');
            $table->text('reason_rejected')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->string('village')->nullable();
            $table->text('address')->nullable();
            $table->enum('working_type', ['permanent', 'contract', 'intenrship', 'freelance'])->default('contract');
            $table->enum('working_system', ['shift', 'non-shift'])->default('non-shift');
            $table->boolean('is_show_fee')->default(1);
            $table->enum('fee_type', ['daily', 'monthly'])->default('monthly');
            $table->string('min_price')->nullable();
            $table->string('max_price')->nullable();
            $table->enum('gender', ['laki-laki', 'perempuan'])->nullable();
            $table->string('min_age')->nullable();
            $table->string('max_age')->nullable();
            $table->decimal('min_height', 5, 2)->nullable();
            $table->decimal('max_height', 5, 2)->nullable();
            $table->decimal('min_weight', 5, 2)->nullable();
            $table->decimal('max_weight', 5, 2)->nullable();
            $table->string('last_education')->nullable();
            $table->string('min_experience')->nullable();
            $table->string('certificate')->nullable();
            $table->string('competency_scheme')->nullable();
            $table->boolean('is_urgent')->default(1);
            $table->string('total_clicked')->nullable();
            $table->timestamps();

            $table->foreign('b_u_j_p_id')->references('id')->on('b_u_j_p_s')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_vacancies');
    }
};
