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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            /*
            |--------------------------------------------------------------------------
            | USER PENERIMA NOTIFIKASI
            |--------------------------------------------------------------------------
            */

            $table->unsignedBigInteger('user_id');

            /*
            |--------------------------------------------------------------------------
            | MASTER NOTIFICATION
            |--------------------------------------------------------------------------
            */

            $table->unsignedBigInteger('notification_id')->nullable();

            /*
            |--------------------------------------------------------------------------
            | NOTIFICATION DATA
            |--------------------------------------------------------------------------
            */

            $table->string('title');

            $table->text('description')->nullable();

            $table->string('url')->nullable();

            $table->string('type')->nullable();

            /*
            |--------------------------------------------------------------------------
            | STATUS BACA
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_read')->default(false);

            $table->timestamp('read_at')->nullable();

            /*
            |--------------------------------------------------------------------------
            | TIMESTAMPS
            |--------------------------------------------------------------------------
            */

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | INDEX
            |--------------------------------------------------------------------------
            */

            $table->index('user_id');

            $table->index('notification_id');

            $table->index('type');

            $table->index('is_read');

            /*
            |--------------------------------------------------------------------------
            | FOREIGN KEY
            |--------------------------------------------------------------------------
            */

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('notification_id')
                ->references('id')
                ->on('master_notifications')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
