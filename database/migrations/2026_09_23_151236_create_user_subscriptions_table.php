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
        Schema::create('user_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->unsignedBigInteger('user_id');

            $table->unsignedBigInteger('master_subscription_id');

            $table->unsignedBigInteger('user_order_manual_id')->nullable();

            $table->string('role', 30);

            /*
            |--------------------------------------------------------------------------
            | Snapshot Paket
            |--------------------------------------------------------------------------
            | Disimpan agar histori subscription tidak berubah ketika
            | master subscription diedit di kemudian hari.
            */
            $table->string('subscription_name');

            $table->decimal('price', 15, 2)->default(0);

            /*
            |--------------------------------------------------------------------------
            | Periode Subscription
            |--------------------------------------------------------------------------
            */
            $table->dateTime('started_at')->nullable();
            $table->dateTime('expired_at')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            | pending   = belum aktif
            | active    = sedang aktif
            | expired   = sudah habis
            | cancelled = dibatalkan
            */
            $table->string('status', 30)->default('pending');

            /*
            |--------------------------------------------------------------------------
            | Snapshot Limit
            |--------------------------------------------------------------------------
            | Contoh:
            | {
            |     "max_daftar_lamaran": 1,
            |     "max_daftar_pelatihan": 2
            | }
            */
            $table->json('limits')->nullable();

            $table->text('notes')->nullable();

            $table->dateTime('cancelled_at')->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Index
            |--------------------------------------------------------------------------
            */
            $table->index('user_id');
            $table->index('master_subscription_id');
            $table->index('user_order_manual_id');
            $table->index('role');
            $table->index('status');
            $table->index('expired_at');

            /*
            |--------------------------------------------------------------------------
            | Foreign Key
            |--------------------------------------------------------------------------
            */
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('master_subscription_id')
                ->references('id')
                ->on('master_subscriptions')
                ->onDelete('restrict');

            $table->foreign('user_order_manual_id')
                ->references('id')
                ->on('user_order_manuals')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_subscriptions');
    }
};
