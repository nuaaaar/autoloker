<?php

namespace Tests\Feature\Admin;

use App\Models\Company;
use App\Models\JobVacancy;
use App\Models\TokenSetting;
use App\Models\User;
use App\Services\TokenBillingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TokenSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_cannot_read_or_change_billing_rules(): void
    {
        $settings = TokenSetting::current();
        $original = $settings->getAttributes();
        $this->actingAs($this->user('company'));

        $this->get(route('dashboard-admin.token-settings.index'))->assertForbidden();
        $this->putJson(route('dashboard-admin.token-settings.update'), $this->rules())
            ->assertForbidden();

        $this->assertSame($original, $settings->fresh()->getAttributes());
    }

    public function test_invalid_rule_does_not_partially_change_other_costs(): void
    {
        $settings = TokenSetting::current();
        $original = $settings->getAttributes();
        $this->actingAs($this->user('admin'));

        $this->put(route('dashboard-admin.token-settings.update'), [
            ...$this->rules(), 'training_post_days' => 0,
        ])->assertRedirect()->assertSessionHasErrors('training_post_days');

        $this->assertSame($original, $settings->fresh()->getAttributes());
    }

    public function test_admin_updates_one_rule_and_the_next_publication_uses_it(): void
    {
        $this->travelTo(now()->startOfSecond());
        $this->actingAs($this->user('admin'));
        $this->putJson(route('dashboard-admin.token-settings.update'), $this->rules())
            ->assertOk();

        $company = Company::create(['company_name' => 'Configured Employer']);
        $billing = app(TokenBillingService::class);
        $wallet = $billing->walletFor(['column' => 'company_id', 'id' => $company->id]);
        $wallet->update(['balance' => 8]);
        $vacancy = JobVacancy::create(['company_id' => $company->id, 'status' => 'draft']);

        $published = $billing->publish($vacancy);

        $this->assertSame(5, $wallet->fresh()->balance);
        $this->assertSame(3, $published->publication_token_cost);
        $this->assertTrue($published->publication_expires_at->equalTo(now()->addDays(7)));
        $this->assertDatabaseCount('token_settings', 1);
    }

    private function rules(): array
    {
        return [
            'idr_per_token' => 12500,
            'job_post_tokens' => 3,
            'job_post_days' => 7,
            'training_post_tokens' => 6,
            'training_post_days' => 45,
        ];
    }

    private function user(string $role): User
    {
        return User::create([
            'name' => $role,
            'email' => $role.'-token-settings@example.test',
            'password' => 'password',
            'role' => $role,
            'status' => 'active',
        ]);
    }
}
