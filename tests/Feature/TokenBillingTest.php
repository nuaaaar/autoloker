<?php

namespace Tests\Feature;

use App\Models\BUJP;
use App\Models\Company;
use App\Models\JobVacancy;
use App\Models\TokenSetting;
use App\Models\TokenTransaction;
use App\Models\TokenWallet;
use App\Models\Training;
use App\Models\User;
use App\Models\UserBUJP;
use App\Models\UserCompany;
use App\Models\UserOrderManual;
use App\Services\TokenBillingService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class TokenBillingTest extends TestCase
{
    use RefreshDatabase;

    private function employer(): array
    {
        $user = User::create([
            'name' => 'Employer',
            'email' => 'employer@example.test',
            'password' => 'secret',
            'google_id' => 'employer-google',
            'role' => 'company',
            'status' => 'active',
        ]);
        $profile = UserCompany::create(['user_id' => $user->id]);
        $company = Company::create([
            'user_company_id' => $profile->id,
            'company_name' => 'Example',
        ]);

        return [$user, $company];
    }

    public function test_insufficient_balance_does_not_publish_or_create_a_debit(): void
    {
        [, $company] = $this->employer();
        $post = JobVacancy::create([
            'company_id' => $company->id,
            'position' => 'Cleaner',
            'status' => 'draft',
        ]);

        try {
            app(TokenBillingService::class)->publish($post);
            $this->fail('Publishing without token balance must fail.');
        } catch (ValidationException) {
            $this->assertSame('draft', $post->fresh()->status);
            $this->assertDatabaseCount('token_transactions', 0);
        }
    }

    public function test_publication_retry_charges_once_and_keeps_policy_snapshot(): void
    {
        [, $company] = $this->employer();
        $wallet = TokenWallet::create([
            'owner_type' => 'company',
            'owner_id' => $company->id,
            'balance' => 8,
        ]);
        $post = JobVacancy::create([
            'company_id' => $company->id,
            'position' => 'Cleaner',
            'status' => 'draft',
        ]);
        $service = app(TokenBillingService::class);

        $service->publish($post);
        TokenSetting::current()->update([
            'job_post_tokens' => 7,
            'job_post_days' => 2,
        ]);
        $service->publish($post->fresh());

        $this->assertSame(4, $wallet->fresh()->balance);
        $this->assertSame(1, TokenTransaction::where('token_wallet_id', $wallet->id)->count());
        $this->assertSame(4, $post->fresh()->publication_token_cost);
        $this->assertSame(1, $post->fresh()->publication_cycle);
    }

    public function test_token_order_requires_verification_and_credits_once(): void
    {
        [$user, $company] = $this->employer();
        $wallet = app(TokenBillingService::class)->walletFor([
            'column' => 'company_id',
            'id' => $company->id,
        ]);
        $order = UserOrderManual::create([
            'uuid' => (string) Str::uuid(),
            'user_id' => $user->id,
            'master_subscription_id' => null,
            'token_wallet_id' => $wallet->id,
            'token_quantity' => 9,
            'idr_per_token' => 10000,
            'role' => 'company',
            'order_number' => 'TOKEN-001',
            'price' => 90000,
            'status' => 'verification',
            'expired_at' => null,
        ]);
        $service = app(TokenBillingService::class);

        $service->creditOrder($order);
        $service->creditOrder($order->fresh());

        $this->assertSame(9, $wallet->fresh()->balance);
        $this->assertSame('approved', $order->fresh()->status);
        $this->assertSame(1, TokenTransaction::where('event_key', 'order:'.$order->id)->count());
    }

    public function test_non_employer_role_cannot_use_a_retained_organization_profile(): void
    {
        [$user] = $this->employer();
        $user->update(['role' => 'satpam']);

        $this->expectException(AuthorizationException::class);
        app(TokenBillingService::class)->ownerFor($user->fresh());
    }

    public function test_closed_training_cannot_be_republished_with_a_future_start_date(): void
    {
        [, $company] = $this->employer();
        TokenWallet::create([
            'owner_type' => 'company',
            'owner_id' => $company->id,
            'balance' => 20,
        ]);
        $training = Training::create([
            'company_id' => $company->id,
            'title' => 'Completed course',
            'status' => 'closed',
            'start_date' => now()->addMonth()->toDateString(),
        ]);

        $this->expectException(ValidationException::class);
        app(TokenBillingService::class)->publish($training);
    }

    public function test_bujp_and_company_with_the_same_numeric_id_do_not_share_a_balance(): void
    {
        [, $company] = $this->employer();
        $user = User::create([
            'name' => 'Legacy BUJP',
            'email' => 'bujp-token@example.test',
            'password' => 'password',
            'role' => 'bujp',
            'status' => 'active',
        ]);
        $profile = UserBUJP::create(['user_id' => $user->id]);
        $bujp = BUJP::create([
            'id' => $company->id,
            'user_b_u_j_p_id' => $profile->id,
            'company_name' => 'Legacy BUJP',
        ]);
        $billing = app(TokenBillingService::class);
        $companyWallet = $billing->walletFor(['column' => 'company_id', 'id' => $company->id]);
        $companyWallet->update(['balance' => 8]);
        $bujpWallet = $billing->walletFor($billing->ownerFor($user));
        $bujpWallet->update(['balance' => 4]);
        $post = JobVacancy::create([
            'b_u_j_p_id' => $bujp->id,
            'position' => 'Petugas BUJP',
            'status' => 'draft',
        ]);

        $billing->publish($post);

        $this->assertSame(8, $companyWallet->fresh()->balance);
        $this->assertSame(0, $bujpWallet->fresh()->balance);
        $this->assertDatabaseHas('token_transactions', [
            'token_wallet_id' => $bujpWallet->id,
            'amount' => -4,
        ]);
    }
}
