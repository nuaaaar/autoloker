<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('token_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('idr_per_token')->default(10000);
            $table->unsignedInteger('job_post_tokens')->default(4);
            $table->unsignedInteger('job_post_days')->default(14);
            $table->unsignedInteger('training_post_tokens')->default(4);
            $table->unsignedInteger('training_post_days')->default(30);
            $table->timestamps();
        });

        Schema::create('token_wallets', function (Blueprint $table) {
            $table->id();
            $table->string('owner_type', 20);
            $table->unsignedBigInteger('owner_id');
            $table->unsignedBigInteger('balance')->default(0);
            $table->timestamps();
            $table->unique(['owner_type', 'owner_id']);
        });

        Schema::create('token_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('token_wallet_id')->constrained()->restrictOnDelete();
            $table->bigInteger('amount');
            $table->unsignedBigInteger('balance_after');
            $table->string('kind', 40);
            $table->string('event_key')->unique();
            $table->string('subject_type')->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->timestamps();
        });

        Schema::table('user_order_manuals', function (Blueprint $table) {
            $table->foreignId('token_wallet_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedInteger('token_quantity')->nullable();
            $table->unsignedInteger('idr_per_token')->nullable();
            $table->unsignedBigInteger('master_subscription_id')->nullable()->change();
        });

        foreach (['job_vacancies', 'trainings'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dateTime('published_at')->nullable();
                $table->dateTime('publication_expires_at')->nullable()->index();
                $table->unsignedInteger('publication_token_cost')->default(0);
                $table->unsignedInteger('publication_cycle')->default(0);
            });
        }

        DB::table('token_settings')->insert([
            'id' => 1,
            'idr_per_token' => 10000,
            'job_post_tokens' => 4,
            'job_post_days' => 14,
            'training_post_tokens' => 4,
            'training_post_days' => 30,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $cutoverAt = now();
        foreach (['job_vacancies' => 14, 'trainings' => 30] as $tableName => $defaultDays) {
            DB::table($tableName)->where('status', 'submitted')->update(['status' => 'draft']);
            DB::table($tableName)->where('status', 'published')->orderBy('id')->chunkById(200, function ($posts) use ($tableName, $defaultDays, $cutoverAt) {
                foreach ($posts as $post) {
                    $expiresAt = $post->end_date
                        ? Carbon::parse($post->end_date)->endOfDay()
                        : $cutoverAt->copy()->addDays($defaultDays);

                    DB::table($tableName)->where('id', $post->id)->update([
                        'published_at' => $post->created_at ?? $cutoverAt,
                        'publication_expires_at' => $expiresAt,
                        'publication_token_cost' => 0,
                        'publication_cycle' => 0,
                    ]);
                }
            });
        }

        if (Schema::hasTable('user_subscriptions')) {
            DB::table('user_subscriptions')->where('status', 'active')->update(['status' => 'expired']);
        }

        DB::table('user_order_manuals')
            ->whereNotNull('master_subscription_id')
            ->whereIn('status', ['pending_payment', 'verification', 'rejected'])
            ->orderBy('id')
            ->chunkById(200, function ($orders) {
                foreach ($orders as $order) {
                    $notes = trim(($order->notes ? $order->notes."\n" : '')
                        .'Cancelled during token billing cutover; payment evidence retained for manual review.');

                    DB::table('user_order_manuals')->where('id', $order->id)->update([
                        'status' => 'cancelled',
                        'notes' => $notes,
                    ]);
                }
            });

        if (Schema::hasTable('master_notifications')) {
            DB::table('master_notifications')
                ->whereIn('code', ['order_subscription_approved', 'order_subscription_rejected', 'job_vacancy_rejected', 'training_rejected'])
                ->update(['is_active' => false]);

            DB::table('master_notifications')
                ->whereIn('code', ['job_vacancy_published', 'training_published'])
                ->update([
                    'title_template' => DB::raw("REPLACE(title_template, 'disetujui', 'dipublikasikan')"),
                    'message_template' => DB::raw("REPLACE(REPLACE(message_template, 'telah disetujui dan dipublikasikan', 'telah dipublikasikan'), 'admin', '')"),
                ]);

            $templates = [
                ['order_token_approved', 'Pembayaran token disetujui', 'Pembelian :tokens token telah disetujui.', 'autoloker://token-orders/:order_uuid'],
                ['order_token_rejected', 'Pembayaran token ditolak', 'Pembelian token ditolak. Alasan: :reason.', 'autoloker://token-orders/:order_uuid'],
            ];

            foreach ($templates as [$code, $title, $message, $route]) {
                DB::table('master_notifications')->updateOrInsert(
                    ['code' => $code],
                    [
                        'uuid' => (string) Str::uuid(),
                        'name' => $title,
                        'category' => 'token',
                        'title_template' => $title,
                        'message_template' => $message,
                        'flutter_route' => $route,
                        'is_active' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }

    public function down(): void
    {
        throw new RuntimeException('Token billing cutover cannot be automatically rolled back. Restore a coordinated database backup and reconcile token and subscription history manually.');
    }
};
