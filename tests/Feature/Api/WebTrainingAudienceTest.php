<?php

namespace Tests\Feature\Api;

use App\Models\Company;
use App\Models\Training;
use App\Models\User;
use App\Models\UserCompany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class WebTrainingAudienceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedLocations();
    }

    public function test_web_training_created_for_cs_audience_is_persisted_with_cs_category_role(): void
    {
        Storage::fake('public');
        $user = $this->companyAccount('web-cs-training@example.com');

        $this->actingAs($user)
            ->post(route('dashboard-user.training.store'), $this->payload(['category_role' => 'cs']))
            ->assertOk()
            ->assertJsonPath('status', true);

        $training = Training::query()->latest('id')->firstOrFail();

        $this->assertSame('cs', $training->category_role);
        $this->assertSame('Kebersihan Gedung', $training->category);
        $this->assertSame($user->user_company->company->id, $training->company_id);
    }

    public function test_web_training_defaults_audience_to_security_when_requested(): void
    {
        Storage::fake('public');
        $user = $this->companyAccount('web-security-training@example.com');

        $this->actingAs($user)
            ->post(route('dashboard-user.training.store'), $this->payload(['category_role' => 'security']))
            ->assertOk();

        $this->assertSame('security', Training::query()->latest('id')->firstOrFail()->category_role);
    }

    public function test_web_training_requires_an_audience(): void
    {
        Storage::fake('public');
        $user = $this->companyAccount('web-missing-audience@example.com');

        $payload = $this->payload();
        unset($payload['category_role']);

        $this->actingAs($user)
            ->post(route('dashboard-user.training.store'), $payload)
            ->assertStatus(422)
            ->assertJsonPath('status', false)
            ->assertJsonValidationErrors('category_role');

        $this->assertSame(0, Training::query()->count());
    }

    public function test_web_training_update_cannot_change_the_audience(): void
    {
        Storage::fake('public');
        $user = $this->companyAccount('web-audience-lock@example.com');

        $this->actingAs($user)
            ->post(route('dashboard-user.training.store'), $this->payload(['category_role' => 'cs']))
            ->assertOk();

        $training = Training::query()->latest('id')->firstOrFail();

        $this->actingAs($user)
            ->patch(route('dashboard-user.training.update', $training->uuid), $this->payload([
                'category_role' => 'security',
                'title' => 'Pelatihan Kebersihan Diperbarui',
            ]));

        $this->assertSame('cs', $training->fresh()->category_role);
    }

    /** @return array<string, mixed> */
    private function payload(array $overrides = []): array
    {
        return array_merge([
            'poster' => UploadedFile::fake()->image('poster.jpg'),
            'title' => 'Pelatihan Kebersihan Gedung',
            'provider' => 'Penyelenggara Bersih',
            'category' => 'Kebersihan Gedung',
            'category_role' => 'cs',
            'level' => 'Dasar',
            'description' => 'Pelatihan dasar kebersihan gedung.',
            'quota' => 20,
            'training_mode' => 'offline',
            'province' => '64',
            'city' => '6471',
            'address' => 'Jalan Bersih 1',
            'start_date' => '2026-11-10',
            'end_date' => '2026-11-12',
            'duration_day' => 3,
            'total_jp' => 24,
            'syllabus' => json_encode(['Teknik mengepel']),
            'requirements' => json_encode(['Sehat jasmani']),
            'status' => 'draft',
        ], $overrides);
    }

    private function companyAccount(string $email): User
    {
        $user = User::create([
            'name' => 'Web Company',
            'email' => $email,
            'google_id' => null,
            'password' => 'password',
            'role' => 'company',
            'status' => 'active',
        ]);
        $userCompany = UserCompany::create(['user_id' => $user->id]);
        Company::create([
            'user_company_id' => $userCompany->id,
            'company_name' => 'Web Company',
            'industry' => 'Jasa Keamanan',
            'description' => 'Perusahaan penyedia jasa.',
            'npwp' => '01.234.567.8-901.000',
            'nib' => 'NIB-000123',
            'email' => $email,
            'phone' => '081234567890',
            'province' => 'KALIMANTAN TIMUR',
            'city' => 'BALIKPAPAN',
            'district' => 'Balikpapan Kota',
            'village' => 'Damai',
            'postal_code' => '76114',
            'address' => 'Jalan Perusahaan 1',
            'is_verified' => true,
        ]);

        return $user;
    }

    private function seedLocations(): void
    {
        $timestamp = now();

        DB::table('indonesia_provinces')->insert([
            'code' => '64',
            'name' => 'KALIMANTAN TIMUR',
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);
        DB::table('indonesia_cities')->insert([
            'code' => '6471',
            'province_code' => '64',
            'name' => 'BALIKPAPAN',
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);
    }
}
