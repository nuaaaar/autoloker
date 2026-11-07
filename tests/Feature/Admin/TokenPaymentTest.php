<?php

namespace Tests\Feature\Admin;

use App\Models\Company;
use App\Models\MasterSubscription;
use App\Models\TokenTransaction;
use App\Models\User;
use App\Models\UserCompany;
use App\Models\UserOrderManual;
use App\Services\TokenBillingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class TokenPaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_employer_cannot_approve_its_own_transfer(): void
    {
        [$employer, $order, $wallet] = $this->payment();
        $this->actingAs($employer)->postJson(route('dashboard-admin.payment.approve', $order->uuid))
            ->assertForbidden();

        $this->assertSame('verification', $order->fresh()->status);
        $this->assertSame(0, $wallet->fresh()->balance);
        $this->assertDatabaseCount('token_transactions', 0);
    }

    public function test_repeating_admin_approval_does_not_credit_the_wallet_twice(): void
    {
        Queue::fake();
        [, $order, $wallet] = $this->payment();
        $admin = $this->user('admin', 'approver@example.test');
        $this->actingAs($admin);

        $this->postJson(route('dashboard-admin.payment.approve', $order->uuid))->assertOk();
        $this->postJson(route('dashboard-admin.payment.approve', $order->uuid))->assertOk();

        $this->assertSame(8, $wallet->fresh()->balance);
        $this->assertSame('approved', $order->fresh()->status);
        $this->assertSame((string) $admin->id, (string) $order->fresh()->verified_by);
        $this->assertSame(1, TokenTransaction::where('token_wallet_id', $wallet->id)->count());
    }

    public function test_old_subscription_order_cannot_be_approved_as_a_token_purchase(): void
    {
        [$employer, $order, $wallet] = $this->payment();
        $plan = MasterSubscription::create(['name' => 'Historical Plan', 'role' => 'client']);
        $order->update([
            'master_subscription_id' => $plan->id,
            'token_wallet_id' => null,
            'token_quantity' => null,
            'idr_per_token' => null,
        ]);
        $this->actingAs($this->user('admin', 'legacy-approver@example.test'))
            ->postJson(route('dashboard-admin.payment.approve', $order->uuid))
            ->assertUnprocessable();

        $this->assertSame('verification', $order->fresh()->status);
        $this->assertNull($order->fresh()->verified_by);
        $this->assertSame(0, $wallet->fresh()->balance);
        $this->assertDatabaseCount('token_transactions', 0);
        $this->assertDatabaseMissing('user_subscriptions', ['user_id' => $employer->id]);
    }

    private function payment(): array
    {
        $employer = $this->user('company', 'payer@example.test');
        $profile = UserCompany::create(['user_id' => $employer->id]);
        $company = Company::create(['user_company_id' => $profile->id, 'company_name' => 'Paying Employer']);
        $wallet = app(TokenBillingService::class)->walletFor(['column' => 'company_id', 'id' => $company->id]);
        $order = UserOrderManual::create([
            'user_id' => $employer->id, 'role' => 'client', 'order_number' => 'TOKEN-APPROVAL',
            'token_wallet_id' => $wallet->id, 'token_quantity' => 8, 'idr_per_token' => 10000,
            'price' => 80000, 'status' => 'verification', 'expired_at' => null,
        ]);

        return [$employer, $order, $wallet];
    }

    private function user(string $role, string $email): User
    {
        return User::create([
            'name' => $role, 'email' => $email, 'password' => 'password',
            'role' => $role, 'status' => 'active',
        ]);
    }
}
