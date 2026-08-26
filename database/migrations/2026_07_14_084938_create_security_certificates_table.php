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
        Schema::create('security_certificates', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable();
            $table->foreignId('security_id')->nullable();
            $table->string('title')->nullable();
            $table->string('publisher')->nullable();
            $table->string('certificate_number')->nullable();
            $table->string('category')->nullable();
            $table->date('publish_date')->nullable();
            $table->date('expired_date')->nullable();
            $table->string('file')->nullable();
            $table->boolean('is_badge')->default(0);
            $table->timestamps();

            $table->foreign('security_id')->references('id')->on('securities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('security_certificates');
    }
};
