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
        Schema::create('b_u_j_p_s', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable();
            $table->foreignId('user_b_u_j_p_id')->nullable();
            $table->string('company_name')->nullable();
            $table->string('industry')->nullable();
            $table->text('logo')->nullable();
            $table->text('description')->nullable();
            $table->string('npwp')->nullable();
            $table->string('nib')->nullable();
            $table->string('business_license')->nullable();
            $table->string('sio_number')->nullable();
            $table->date('sio_expired_date')->nullable();
            $table->string('sio_file')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->string('village')->nullable();
            $table->string('postal_code')->nullable();
            $table->text('address')->nullable();
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('youtube')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('user_b_u_j_p_id')->references('id')->on('user_b_u_j_p_s')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('b_u_j_p_s');
    }
};
