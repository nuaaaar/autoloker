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
        Schema::create('master_subscriptions', function (Blueprint $table) {
            $table->id();

            $table->string('uuid')->nullable();

            /*
            |--------------------------------------------------------------------------
            | BASIC
            |--------------------------------------------------------------------------
            */

            $table->string('name')->nullable();

            $table->string('slug')->nullable();

            /*
            |--------------------------------------------------------------------------
            | ROLE
            |--------------------------------------------------------------------------
            */

            $table->enum('role', [
                'security',
                'bujp',
                'client'
            ])->nullable();

            /*
            |--------------------------------------------------------------------------
            | PRICE
            |--------------------------------------------------------------------------
            */

            $table->decimal('price', 15, 2)->default(0);

            $table->integer('duration')->default(30);

            $table->enum('duration_type', [
                'day',
                'month',
                'year'
            ])->default('month');

            /*
            |--------------------------------------------------------------------------
            | DESCRIPTION
            |--------------------------------------------------------------------------
            */

            $table->text('description')->nullable();

            /*
            |--------------------------------------------------------------------------
            | FEATURES / LIMITS
            |--------------------------------------------------------------------------
            |
            | Semua aturan subscription disimpan dalam JSON.
            |
            */

            $table->json('features')->nullable();

            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_active')->default(1);

            $table->integer('sort_order')->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->index('role');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_subscriptions');
    }
};
