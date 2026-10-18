<?php

namespace Tests\Feature\Api;

use App\Models\BUJP;
use App\Models\Company;
use App\Models\Security;
use App\Models\Training;
use App\Models\User;
use App\Models\UserSecurity;
use App\Services\Api\TokenService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrainingListingTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_includes_company_and_bujp_logo_urls(): void
    {
        config(['filesystems.disks.public.url' => 'https://assets.example.test/storage']);
        $token = $this->token();
        $company = Company::create(['company_name' => 'Training Company', 'logo' => 'company-logo/training.png']);
        $bujp = BUJP::create(['company_name' => 'Training BUJP', 'logo' => 'company-logo/bujp.png']);

        $trainings = [
            Training::create($this->trainingAttributes(['title' => 'Company Logo', 'company_id' => $company->id, 'category_role' => 'security'])),
            Training::create($this->trainingAttributes(['title' => 'BUJP Logo', 'b_u_j_p_id' => $bujp->id, 'category_role' => 'security'])),
            Training::create($this->trainingAttributes(['title' => 'No Logo', 'company_id' => Company::create(['company_name' => 'No Logo', 'logo' => null])->id, 'category_role' => 'security'])),
            Training::create($this->trainingAttributes(['title' => 'Empty Logo', 'company_id' => Company::create(['company_name' => 'Empty Logo', 'logo' => ''])->id, 'category_role' => 'security'])),
            Training::create($this->trainingAttributes(['title' => 'No Owner', 'category_role' => 'security'])),
            Training::create($this->trainingAttributes(['title' => 'Both Owners', 'company_id' => $company->id, 'b_u_j_p_id' => $bujp->id, 'category_role' => 'security'])),
        ];

        $response = $this->withToken($token)->getJson('/api/trainings');
        $response->assertOk();
        $secondPage = $this->withToken($token)->getJson('/api/trainings?page=2');
        $secondPage->assertOk();
        $items = collect(array_merge($response->json('data.trainings'), $secondPage->json('data.trainings')))->keyBy('title');
        $this->assertSame('https://assets.example.test/storage/company-logo/training.png', $items['Company Logo']['company']['logo']);
        $this->assertSame('https://assets.example.test/storage/company-logo/bujp.png', $items['BUJP Logo']['bujp']['logo']);
        $this->assertArrayHasKey('logo', $items['No Logo']['company']);
        $this->assertNull($items['No Logo']['company']['logo']);
        $this->assertNull($items['Empty Logo']['company']['logo']);
        $this->assertNull($items['No Owner']['company']);
        $this->assertNull($items['No Owner']['bujp']);
        $this->assertSame('https://assets.example.test/storage/company-logo/training.png', $items['Both Owners']['company']['logo']);
        $this->assertSame('https://assets.example.test/storage/company-logo/bujp.png', $items['Both Owners']['bujp']['logo']);
        $this->assertCount(6, $trainings);
    }

    public function test_search_paginates_filtered_results_and_preserves_next_page_url(): void
    {
        config(['filesystems.disks.public.url' => 'https://assets.example.test/storage']);
        $token = $this->token();
        $company = Company::create(['company_name' => 'Pagination Company', 'logo' => 'company-logo/page.png']);
        $created = [];
        foreach (range(1, 6) as $number) {
            $created[] = Training::create($this->trainingAttributes([
                'title' => "Pagination Training {$number}", 'company_id' => $company->id,
            ]));
        }
        Training::create($this->trainingAttributes(['title' => 'Draft Pagination', 'status' => 'draft']));
        Training::create($this->trainingAttributes(['title' => 'Other Audience', 'category_role' => 'cs']));

        $response = $this->withToken($token)->getJson('/api/trainings?search=Pagination');
        $response->assertOk()
            ->assertJsonPath('data.pagination.per_page', 5)
            ->assertJsonPath('data.pagination.total', 6)
            ->assertJsonPath('data.pagination.has_more', true)
            ->assertJsonCount(5, 'data.trainings');
        $first = $response->json('data.trainings');
        $this->assertSame('Pagination Training 6', $first[0]['title']);
        $this->assertSame('https://assets.example.test/storage/company-logo/page.png', $first[0]['company']['logo']);
        $nextUrl = $response->json('data.pagination.next_page_url');
        $this->assertStringContainsString('search=Pagination', $nextUrl);

        $secondResponse = $this->withToken($token)->getJson($nextUrl);
        $secondResponse->assertOk()
            ->assertJsonPath('data.pagination.current_page', 2)
            ->assertJsonPath('data.pagination.has_more', false)
            ->assertJsonPath('data.pagination.next_page_url', null)
            ->assertJsonCount(1, 'data.trainings');
        $second = $secondResponse->json('data.trainings');
        $this->assertSame('Pagination Training 1', $second[0]['title']);
        $this->assertSame('https://assets.example.test/storage/company-logo/page.png', $second[0]['company']['logo']);
        $uuids = array_merge(array_column($first, 'uuid'), array_column($second, 'uuid'));
        $this->assertCount(6, array_unique($uuids));
        $this->assertCount(6, $created);

        $this->withToken($token)->getJson('/api/trainings?search=No%20matching%20training')
            ->assertOk()
            ->assertJsonCount(0, 'data.trainings')
            ->assertJsonPath('data.pagination.total', 0)
            ->assertJsonPath('data.pagination.has_more', false)
            ->assertJsonPath('data.pagination.next_page_url', null);
    }

    private function token(): string
    {
        $user = User::create([
            'name' => 'Training List User', 'email' => 'training-list@example.com',
            'google_id' => null, 'password' => 'password', 'role' => 'satpam', 'status' => 'active',
        ]);
        $userSecurity = UserSecurity::create(['user_id' => $user->id]);
        Security::create(['user_security_id' => $userSecurity->id, 'name' => 'Training List User']);

        return app(TokenService::class)->issue($user)['access_token'];
    }

    private function trainingAttributes(array $overrides = []): array
    {
        return array_merge([
            'title' => 'Security Training', 'provider' => 'Training Provider',
            'category_role' => 'security', 'status' => 'published', 'quota' => 10,
            'start_date' => now()->addDays(7)->toDateString(),
        ], $overrides);
    }
}
