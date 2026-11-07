<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\TokenTransaction;
use App\Models\Training;
use App\Models\User;
use App\Models\UserCompany;
use App\Services\TokenBillingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TokenBillingWebTest extends TestCase
{
    use RefreshDatabase;

    public function test_native_job_publish_and_close_preserve_balance_and_applicants(): void
    {
        $this->travelTo(now()->startOfSecond());
        [$owner, $company, $wallet] = $this->employer('web-publisher@example.test');
        $job = JobVacancy::create([
            'company_id' => $company->id, 'position' => 'Petugas Kebersihan',
            'category' => 'cs', 'status' => 'draft', 'description_work' => 'Membersihkan area kerja.',
            'responsibility' => json_encode(['Membersihkan area']), 'facility' => json_encode(['Transportasi']),
            'province' => 'Jawa Barat', 'city' => 'Bandung', 'address' => 'Alamat perusahaan',
            'kuota' => 5,
        ]);
        $this->actingAs($owner);

        $this->post(route('dashboard-user.job-vacancy.publish', $job->uuid))
            ->assertRedirect(route('dashboard-user.job-vacancy.show', $job->uuid));
        $this->post(route('dashboard-user.job-vacancy.publish', $job->uuid))->assertRedirect();

        $this->assertSame(4, $wallet->fresh()->balance);
        $this->assertTrue($job->fresh()->isCurrentlyPublished());
        $this->assertSame(1, TokenTransaction::where('token_wallet_id', $wallet->id)->count());
        $application = JobApplication::create(['job_vacancy_id' => $job->id, 'status' => 'applied']);
        $this->from(route('dashboard-user.job-vacancy.show', $job->uuid))
            ->post(route('dashboard-user.job-vacancy.close-publication', $job->uuid))
            ->assertRedirect(route('dashboard-user.job-vacancy.show', $job->uuid));

        $this->assertSame('applied', $application->fresh()->status);
        $this->assertFalse($job->fresh()->isCurrentlyPublished());
        $this->assertSame(4, $wallet->fresh()->balance);
    }

    public function test_closing_training_ad_does_not_complete_or_cancel_the_activity(): void
    {
        [$owner, $company, $wallet] = $this->employer('web-training-publisher@example.test');
        $start = now()->addDays(45)->toDateString();
        $end = now()->addDays(47)->toDateString();
        $training = Training::create([
            'company_id' => $company->id, 'title' => 'Pelatihan Keamanan',
            'status' => 'draft', 'start_date' => $start, 'end_date' => $end, 'duration_day' => 3,
        ]);
        $this->actingAs($owner)
            ->post(route('dashboard-user.training.publish', $training->uuid))
            ->assertRedirect(route('dashboard-user.training.show', $training->uuid));
        $this->from(route('dashboard-user.training.show', $training->uuid))
            ->post(route('dashboard-user.training.close-publication', $training->uuid))
            ->assertRedirect(route('dashboard-user.training.show', $training->uuid));

        $this->assertSame('published', $training->fresh()->status);
        $this->assertSame($start, $training->fresh()->start_date);
        $this->assertSame($end, $training->fresh()->end_date);
        $this->assertSame(3, (int) $training->fresh()->duration_day);
        $this->assertFalse($training->fresh()->isCurrentlyPublished());
        $this->assertSame(4, $wallet->fresh()->balance);
    }

    public function test_another_organization_cannot_publish_or_close_a_listing(): void
    {
        [, $company, $wallet] = $this->employer('listing-owner@example.test');
        [$other] = $this->employer('other-publisher@example.test');
        $job = JobVacancy::create(['company_id' => $company->id, 'position' => 'Owned listing', 'status' => 'draft']);
        $this->actingAs($other);

        $this->postJson(route('dashboard-user.job-vacancy.publish', $job->uuid))->assertNotFound();
        $this->postJson(route('dashboard-user.job-vacancy.close-publication', $job->uuid))->assertNotFound();
        $this->assertSame('draft', $job->fresh()->status);
        $this->assertSame(8, $wallet->fresh()->balance);
        $this->assertDatabaseCount('token_transactions', 0);
    }

    private function employer(string $email): array
    {
        $user = User::create([
            'name' => 'Web Employer', 'email' => $email, 'password' => 'password',
            'role' => 'company', 'status' => 'active',
        ]);
        $profile = UserCompany::create(['user_id' => $user->id]);
        $company = Company::create([
            'user_company_id' => $profile->id, 'company_name' => 'Web Employer',
            'industry' => 'Jasa', 'description' => 'Perusahaan pengujian',
            'npwp' => '0123456789', 'nib' => '0123456789', 'email' => $email,
            'phone' => '081234567890', 'province' => 'Jawa Barat', 'city' => 'Bandung',
            'district' => 'Coblong', 'village' => 'Dago', 'postal_code' => '40135',
            'address' => 'Alamat perusahaan', 'is_verified' => true,
        ]);
        $wallet = app(TokenBillingService::class)->walletFor(['column' => 'company_id', 'id' => $company->id]);
        $wallet->update(['balance' => 8]);

        return [$user, $company, $wallet];
    }
}
