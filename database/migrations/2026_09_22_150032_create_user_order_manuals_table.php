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
        Schema::create('user_order_manuals', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();


            /*
            |--------------------------------------------------------------------------
            | USER & SUBSCRIPTION
            |--------------------------------------------------------------------------
            */

            $table->unsignedBigInteger('user_id');

            $table->unsignedBigInteger('master_subscription_id');


            /*
            |--------------------------------------------------------------------------
            | ORDER
            |--------------------------------------------------------------------------
            */

            $table->string('role', 30);

            $table->string('order_number', 50)->unique();

            $table->decimal('price', 15, 2);


            /*
            |--------------------------------------------------------------------------
            | PAYMENT
            |--------------------------------------------------------------------------
            */

            $table->string('payment_method', 50)->nullable();

            $table->string('payment_account')->nullable();

            $table->dateTime('payment_date')->nullable();

            $table->string('file')->nullable();


            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

            $table->string('status', 30)
                ->default('pending_payment');


            /*
            |--------------------------------------------------------------------------
            | NOTES
            |--------------------------------------------------------------------------
            */

            $table->text('notes')->nullable();

            $table->text('rejected_reason')->nullable();


            /*
            |--------------------------------------------------------------------------
            | VERIFICATION
            |--------------------------------------------------------------------------
            */

            $table->string('verified_by')->nullable();

            $table->timestamp('verified_at')->nullable();


            /*
            |--------------------------------------------------------------------------
            | EXPIRATION
            |--------------------------------------------------------------------------
            */

            $table->timestamp('expired_at')->nullable();


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

            $table->index('master_subscription_id');

            $table->index('role');

            $table->index('status');

            $table->index('verified_by');


            /*
            |--------------------------------------------------------------------------
            | FOREIGN KEY
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
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_order_manuals');
    }
};
