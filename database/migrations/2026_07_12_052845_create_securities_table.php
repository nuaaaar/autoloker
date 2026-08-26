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
        Schema::create('securities', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable();
            $table->foreignId('user_security_id')->nullable();
            $table->string('formal_photo')->nullable();
            $table->string('name')->nullable();
            $table->string('birth_place')->nullable();
            $table->string('birth_date')->nullable();
            $table->enum('gender', ['laki-laki', 'perempuan'])->nullable();
            $table->text('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->string('ktp_number')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('work_experience')->nullable();
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->string('village')->nullable();
            $table->string('height')->nullable();
            $table->string('width')->nullable();
            $table->boolean('is_out_of_town_agree')->default(0)->nullable();
            $table->boolean('is_shift_agree')->default(0)->nullable();
            $table->text('ability')->nullable();
            $table->text('placements')->nullable();
            $table->text('self_description')->nullable(); 
            $table->text('additional_note')->nullable(); 
            $table->text('work_status')->nullable(); 
            $table->text('company_name')->nullable(); 
            $table->text('position')->nullable(); 
            $table->text('sim')->nullable(); 
            $table->timestamps();

            $table->foreign('user_security_id')->references('id')->on('user_securities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('securities');
    }
};
