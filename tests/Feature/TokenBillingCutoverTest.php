<?php

namespace Tests\Feature;

use App\Models\JobVacancy;
use App\Models\MasterSubscription;
use App\Models\Training;
use App\Models\User;
use App\Models\UserOrderManual;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tests\TestCase;

class TokenBillingCutoverTest extends TestCase
{
    public function test_cutover_preserves_payment_evidence_and_legacy_publication_deadlines(): void
    {
        $originalConnection = config('database.default');
        $database = tempnam(sys_get_temp_dir(), 'autoloker-cutover-');
        config([
            'database.connections.billing_cutover' => [
                ...config('database.connections.sqlite'),
                'url' => null,
                'database' => $database,
            ],
            'database.default' => 'billing_cutover',
        ]);
        $this->travelTo(now()->startOfSecond());

        try {
            $cutover = database_path('migrations/2026_11_07_000001_create_token_billing_tables.php');
            $legacy = array_values(array_filter(
                glob(database_path('migrations/*.php')),
                fn (string $path): bool => $path !== $cutover,
            ));
            $this->artisan('migrate', ['--database' => 'billing_cutover', '--path' => $legacy, '--realpath' => true])
                ->assertSuccessful();

            $user = User::create([
                'name' => 'Legacy Employer', 'email' => 'legacy-cutover@example.test',
                'password' => 'password', 'role' => 'company', 'status' => 'active',
            ]);
            $plan = MasterSubscription::create(['name' => 'Legacy Plan', 'role' => 'client', 'price' => '49000.50']);
            $orders = [];
            foreach (['pending_payment', 'verification', 'rejected', 'approved'] as $status) {
                $orders[$status] = UserOrderManual::create([
                    'user_id' => $user->id, 'master_subscription_id' => $plan->id,
                    'role' => 'client', 'order_number' => 'LEGACY-'.$status,
                    'price' => '49000.50', 'status' => $status,
                    'file' => 'legacy-proof.pdf', 'notes' => 'Existing payment note',
                    'rejected_reason' => $status === 'rejected' ? 'Need clearer proof' : null,
                ]);
            }
            $subscriptionId = DB::table('user_subscriptions')->insertGetId([
                'uuid' => (string) Str::uuid(), 'user_id' => $user->id,
                'master_subscription_id' => $plan->id, 'role' => 'client',
                'subscription_name' => 'Legacy Plan', 'price' => '49000.50',
                'started_at' => now()->subDay(), 'expired_at' => now()->addMonth(),
                'status' => 'active',
            ]);
            $deadline = now()->addDays(12)->toDateString();
            $published = JobVacancy::create(['status' => 'published', 'end_date' => $deadline]);
            $submitted = JobVacancy::create(['status' => 'submitted']);
            $trainingStart = now()->addDays(3)->toDateString();
            $trainingEnd = now()->addDays(5)->toDateString();
            $training = Training::create([
                'status' => 'published', 'start_date' => $trainingStart,
                'end_date' => $trainingEnd, 'duration_day' => 3,
            ]);
            $undated = JobVacancy::create(['status' => 'published', 'end_date' => null]);

            $this->artisan('migrate', ['--database' => 'billing_cutover', '--path' => [$cutover], '--realpath' => true])
                ->assertSuccessful();

            foreach (['pending_payment', 'verification', 'rejected'] as $status) {
                $order = $orders[$status]->fresh();
                $this->assertSame('cancelled', $order->status);
                $this->assertSame('legacy-proof.pdf', $order->file);
                $this->assertSame('49000.50', $order->price);
                $this->assertStringContainsString('Existing payment note', $order->notes);
            }
            $this->assertSame('Need clearer proof', $orders['rejected']->fresh()->rejected_reason);
            $this->assertSame('approved', $orders['approved']->fresh()->status);
            $this->assertDatabaseHas('user_subscriptions', ['id' => $subscriptionId, 'status' => 'expired']);
            $this->assertSame('draft', $submitted->fresh()->status);
            $this->assertSame($deadline.' 23:59:59', $published->fresh()->publication_expires_at->toDateTimeString());
            $this->assertSame(now()->addDays(14)->toDateTimeString(), $undated->fresh()->publication_expires_at->toDateTimeString());
            $this->assertSame(0, $published->fresh()->publication_token_cost);
            $this->assertSame($trainingStart, (string) $training->fresh()->start_date);
            $this->assertSame($trainingEnd, (string) $training->fresh()->end_date);
            $this->assertSame(3, (int) $training->fresh()->duration_day);
            $this->assertDatabaseCount('token_transactions', 0);
        } finally {
            DB::purge('billing_cutover');
            config(['database.default' => $originalConnection]);
            if (is_file($database)) {
                unlink($database);
            }
        }
    }
}
