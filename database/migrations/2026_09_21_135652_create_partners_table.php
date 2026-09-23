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
        Schema::create('partners', function (Blueprint $table) {
            $table->id();

            $table->uuid('uuid')->unique();

            /*
            |--------------------------------------------------------------------------
            | INFORMASI PARTNER
            |--------------------------------------------------------------------------
            */

            $table->string('name');

            $table->text('description')->nullable();

            $table->string('logo')->nullable();

            $table->text('address')->nullable();

            $table->string('website')->nullable();

            $table->string('phone', 50)->nullable();


            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_active')->default(true);


            /*
            |--------------------------------------------------------------------------
            | URUTAN
            |--------------------------------------------------------------------------
            */

            $table->integer('order')->default(0);


            $table->timestamps();

            $table->softDeletes();

            $table->index('is_active');

            $table->index('order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
