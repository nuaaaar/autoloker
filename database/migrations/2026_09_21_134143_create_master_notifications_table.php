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
        Schema::create('master_notifications', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            /*
            |--------------------------------------------------------------------------
            | IDENTITAS NOTIFIKASI
            |--------------------------------------------------------------------------
            */

            $table->string('code')->unique();

            $table->string('name');

            $table->string('category')->nullable();

            $table->text('description')->nullable();


            /*
            |--------------------------------------------------------------------------
            | TEMPLATE
            |--------------------------------------------------------------------------
            */

            $table->string('title_template');

            $table->text('message_template');

            /*
            | Template khusus email
            */

            $table->string('email_subject')->nullable();

            $table->longText('email_template')->nullable();


            /*
            |--------------------------------------------------------------------------
            | ROUTING
            |--------------------------------------------------------------------------
            */

            /*
            | Route Laravel / Dashboard
            | Contoh:
            | user-page.job-vacancy.show
            */

            $table->string('dashboard_route')->nullable();

            /*
            | Route Flutter
            | Contoh:
            | job_vacancy_detail
            */

            $table->string('flutter_route')->nullable();


            /*
            |--------------------------------------------------------------------------
            | CHANNEL
            |--------------------------------------------------------------------------
            */

            $table->boolean('web_enabled')->default(true);

            $table->boolean('mobile_enabled')->default(true);

            $table->boolean('email_enabled')->default(false);

            $table->boolean('push_enabled')->default(false);


            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->softDeletes();

            $table->index('category');

            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_notifications');
    }
};
