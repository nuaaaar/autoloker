<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Services\Api\TokenService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AccountDeletionTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_cascades_all_worker_profiles_and_exclusive_files(): void
    {
        \Illuminate\Support\Facades\Storage::fake('public');
        \Illuminate\Support\Facades\Storage::disk('public')->put('formal-photo/security.jpg', 'security');
        \Illuminate\Support\Facades\Storage::disk('public')->put('formal-photo/cleaning.jpg', 'cleaning');
        \Illuminate\Support\Facades\Storage::disk('public')->put('certificate/security.pdf', 'security certificate');
        \Illuminate\Support\Facades\Storage::disk('public')->put('certificate/cleaning.pdf', 'cleaning certificate');

        $user = $this->user('satpam', 'dual-profile@example.com');
        $securityBridge = DB::table('user_securities')->insertGetId(['user_id' => $user->id, 'created_at' => now(), 'updated_at' => now()]);
        $security = DB::table('securities')->insertGetId(['user_security_id' => $securityBridge, 'name' => 'Worker', 'formal_photo' => 'formal-photo/security.jpg', 'created_at' => now(), 'updated_at' => now()]);
        $cleaningBridge = DB::table('user_cleaning_services')->insertGetId(['user_id' => $user->id, 'created_at' => now(), 'updated_at' => now()]);
        $cleaning = DB::table('cleaning_services')->insertGetId(['user_cleaning_service_id' => $cleaningBridge, 'name' => 'Worker', 'formal_photo' => 'formal-photo/cleaning.jpg', 'created_at' => now(), 'updated_at' => now()]);
        DB::table('security_certificates')->insert(['security_id' => $security, 'file' => 'certificate/security.pdf', 'created_at' => now(), 'updated_at' => now()]);
        DB::table('cleaning_service_certificates')->insert(['cleaning_service_id' => $cleaning, 'file' => 'certificate/cleaning.pdf', 'created_at' => now(), 'updated_at' => now()]);
        $token = app(TokenService::class)->issue($user)['access_token'];

        $this->withToken($token)->deleteJson('/api/account', ['confirm_delete' => true])->assertOk();

        $this->assertDatabaseMissing('user_securities', ['id' => $securityBridge]);
        $this->assertDatabaseMissing('securities', ['id' => $security]);
        $this->assertDatabaseMissing('user_cleaning_services', ['id' => $cleaningBridge]);
        $this->assertDatabaseMissing('cleaning_services', ['id' => $cleaning]);
        $this->assertDatabaseCount('account_deletion_files', 0);
        \Illuminate\Support\Facades\Storage::disk('public')->assertMissing('formal-photo/security.jpg');
        \Illuminate\Support\Facades\Storage::disk('public')->assertMissing('formal-photo/cleaning.jpg');
        \Illuminate\Support\Facades\Storage::disk('public')->assertMissing('certificate/security.pdf');
        \Illuminate\Support\Facades\Storage::disk('public')->assertMissing('certificate/cleaning.pdf');
    }

    public function test_confirmed_delete_removes_account_credentials_and_respects_other_account(): void
    {
        $user = $this->user('satpam', 'delete-target@example.com');
        $other = $this->user('cs', 'delete-other@example.com');
        $tokens = app(TokenService::class);
        $access = $tokens->issue($user);
        $second = $tokens->issue($user);
        $otherAccess = $tokens->issue($other);
        DB::table('sessions')->insert(['id' => 'target-session', 'user_id' => $user->id, 'payload' => '', 'last_activity' => 1]);
        DB::table('password_reset_tokens')->insert(['email' => $user->email, 'token' => 'reset']);

        $this->withToken($access['access_token'])->deleteJson('/api/account', ['confirm_delete' => true])
            ->assertOk()
            ->assertExactJson(['status' => true, 'message' => 'Akun dan data terkait berhasil dihapus.', 'data' => ['files_pending' => false]]);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
        $this->assertDatabaseMissing('api_tokens', ['user_id' => $user->id]);
        $this->assertDatabaseMissing('sessions', ['id' => 'target-session']);
        $this->assertDatabaseMissing('password_reset_tokens', ['email' => $user->email]);
        $this->withToken($otherAccess['access_token'])->getJson('/api/me')->assertOk();
        $this->withToken($access['access_token'])->deleteJson('/api/account', ['confirm_delete' => true])->assertUnauthorized();
        $this->withToken($second['access_token'])->getJson('/api/me')->assertUnauthorized();
        $this->postJson('/api/refresh-token', ['refresh_token' => $access['refresh_token']])->assertUnauthorized();
        $this->postJson('/api/refresh-token', ['refresh_token' => $second['refresh_token']])->assertUnauthorized();
    }

    public function test_invalid_confirmation_and_disallowed_role_do_not_delete_data(): void
    {
        $user = $this->user('company', 'delete-company@example.com');
        $token = app(TokenService::class)->issue($user)['access_token'];
        foreach ([[], ['confirm_delete' => false], ['confirm_delete' => 'true'], ['confirm_delete' => 1]] as $payload) {
            $this->withToken($token)->deleteJson('/api/account', $payload)->assertUnprocessable();
            $this->assertDatabaseHas('users', ['id' => $user->id]);
        }
        $admin = $this->user('admin', 'delete-admin@example.com');
        $adminToken = app(TokenService::class)->issue($admin)['access_token'];
        $this->withToken($adminToken)->deleteJson('/api/account', ['confirm_delete' => true])->assertForbidden();
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_organization_deletion_removes_owned_content_but_keeps_applicants(): void
    {
        $companyUser = $this->user('company', 'company-content@example.com');
        $bridge = DB::table('user_companies')->insertGetId(['user_id' => $companyUser->id, 'created_at' => now(), 'updated_at' => now()]);
        $company = DB::table('companies')->insertGetId(['user_company_id' => $bridge, 'company_name' => 'Owned Company', 'created_at' => now(), 'updated_at' => now()]);
        $job = DB::table('job_vacancies')->insertGetId(['company_id' => $company, 'position' => 'Owned job', 'created_at' => now(), 'updated_at' => now()]);
        $training = DB::table('trainings')->insertGetId(['company_id' => $company, 'title' => 'Owned training', 'created_at' => now(), 'updated_at' => now()]);

        $worker = $this->user('satpam', 'applicant@example.com');
        $workerBridge = DB::table('user_securities')->insertGetId(['user_id' => $worker->id, 'created_at' => now(), 'updated_at' => now()]);
        $security = DB::table('securities')->insertGetId(['user_security_id' => $workerBridge, 'name' => 'Applicant', 'created_at' => now(), 'updated_at' => now()]);
        DB::table('job_applications')->insert(['job_vacancy_id' => $job, 'security_id' => $security, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('training_applications')->insert(['training_id' => $training, 'security_id' => $security, 'created_at' => now(), 'updated_at' => now()]);
        $token = app(TokenService::class)->issue($companyUser)['access_token'];

        $this->withToken($token)->deleteJson('/api/account', ['confirm_delete' => true])->assertOk();

        $this->assertDatabaseMissing('companies', ['id' => $company]);
        $this->assertDatabaseMissing('job_vacancies', ['id' => $job]);
        $this->assertDatabaseMissing('trainings', ['id' => $training]);
        $this->assertDatabaseMissing('job_applications', ['job_vacancy_id' => $job]);
        $this->assertDatabaseMissing('training_applications', ['training_id' => $training]);
        $this->assertDatabaseHas('users', ['id' => $worker->id]);
        $this->assertDatabaseHas('securities', ['id' => $security]);
    }

    public function test_shared_file_conflict_preserves_account_and_physical_file(): void
    {
        \Illuminate\Support\Facades\Storage::fake('public');
        \Illuminate\Support\Facades\Storage::disk('public')->put('company-logo/shared.jpg', 'shared');
        $user = $this->user('company', 'shared-file-target@example.com');
        $user->update(['avatar' => 'company-logo/shared.jpg']);
        $other = $this->user('cs', 'shared-file-owner@example.com');
        $other->update(['avatar' => 'company-logo/shared.jpg']);
        $token = app(TokenService::class)->issue($user)['access_token'];

        $this->withToken($token)->deleteJson('/api/account', ['confirm_delete' => true])
            ->assertStatus(409)
            ->assertExactJson(['status' => false, 'message' => 'Akun tidak dapat dihapus karena ada data atau berkas yang dipakai bersama akun lain.']);

        $this->assertDatabaseHas('users', ['id' => $user->id]);
        $this->assertDatabaseCount('account_deletion_files', 0);
        \Illuminate\Support\Facades\Storage::disk('public')->assertExists('company-logo/shared.jpg');
    }

    public function test_storage_delete_failure_returns_202_after_account_credentials_are_removed(): void
    {
        $disk = \Illuminate\Support\Facades\Storage::fake('public');
        $disk->put('formal-photo/pending.jpg', 'pending');
        $user = $this->user('satpam', 'pending-cleanup@example.com');
        $user->update(['avatar' => 'formal-photo/pending.jpg']);
        $token = app(TokenService::class)->issue($user)['access_token'];
        $failingDisk = \Mockery::mock($disk)->makePartial();
        $attempt = 0;
        $failingDisk->shouldReceive('exists')->andReturnUsing(function ($path) use ($disk, &$attempt) {
            return $attempt === 0 ? true : $disk->exists($path);
        });
        $failingDisk->shouldReceive('delete')->andReturnUsing(function ($path) use ($disk, &$attempt) {
            if ($attempt++ === 0) return false;
            return $disk->delete($path);
        });
        \Illuminate\Support\Facades\Storage::shouldReceive('disk')->with('public')->andReturn($failingDisk);

        $this->withToken($token)->deleteJson('/api/account', ['confirm_delete' => true])
            ->assertStatus(202)
            ->assertExactJson(['status' => true, 'message' => 'Akun telah dihapus. Penghapusan berkas terkait masih diproses.', 'data' => ['files_pending' => true]]);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
        $this->assertDatabaseCount('api_tokens', 0);
        $this->assertDatabaseCount('account_deletion_files', 1);
        $this->artisan('accounts:purge-deletion-files')->assertExitCode(0);
        $this->assertDatabaseCount('account_deletion_files', 0);
        $disk->assertMissing('formal-photo/pending.jpg');
    }

    private function user(string $role, string $email): User
    {
        return User::create(['name' => $role, 'email' => $email, 'google_id' => '', 'password' => 'secret', 'role' => $role, 'status' => 'active']);
    }
}
