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
        Schema::create('cleaning_service_certificates', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable();
            $table->foreignId('cleaning_service_id')->nullable();
            $table->string('title')->nullable();
            $table->string('publisher')->nullable();
            $table->string('certificate_number')->nullable();
            $table->string('category')->nullable();
            $table->date('publish_date')->nullable();
            $table->date('expired_date')->nullable();
            $table->string('file')->nullable();
            $table->boolean('is_badge')->default(0);
            $table->timestamps();

            $table->foreign('cleaning_service_id')->references('id')->on('cleaning_services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cleaning_service_certificates');
    }
};
