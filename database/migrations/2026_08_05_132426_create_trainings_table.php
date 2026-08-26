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
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable();
            $table->foreignId('b_u_j_p_id')->nullable();
            $table->foreignId('company_id')->nullable();

            $table->string('title')->nullable();
            $table->string('provider')->nullable();
            $table->string('instructor')->nullable();
            $table->string('category')->nullable();
            $table->string('level')->nullable();
            $table->string('price')->nullable();
            $table->string('is_free')->nullable();
            $table->text('description')->nullable();
            $table->string('quota')->nullable();
            $table->string('registered')->nullable();
            $table->text('tags')->nullable();

            $table->string('training_mode')->nullable();
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->string('village')->nullable();
            $table->text('address')->nullable();
            $table->string('google_map')->nullable();
            $table->string('meeting_url')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('duration_day')->nullable();
            $table->string('total_jp')->nullable();

            $table->boolean('is_certificate')->default(0);
            $table->string('certificate_name')->nullable();
            $table->string('certificate_validity')->nullable();

            $table->text('syllabus')->nullable();
            $table->text('requirements')->nullable();

            $table->enum('status', ['draft', 'rejected', 'submitted', 'published', 'closed', 'running', 'cancelled'])->default('draft');
            $table->text('reason_rejected')->nullable();

            $table->string('total_clicked')->nullable();
            $table->text('poster')->nullable();
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
        Schema::dropIfExists('trainings');
    }
};
