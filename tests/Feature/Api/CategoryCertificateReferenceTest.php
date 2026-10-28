<?php

namespace Tests\Feature\Api;

use App\Models\MasterCategoryCertificate;
use App\Models\MasterPosition;
use App\Services\Api\TokenService;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryCertificateReferenceTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_certificates_expose_active_hierarchy_and_filter_by_audience(): void
    {
        $token = app(TokenService::class)->issue($this->companyUser())['access_token'];
        $root = $this->master('Security root', 'security', 1, null, true);
        $child = $this->master('Security child', 'security', 2, $root->id, true);
        $cs = $this->master('Cleaning root', 'cs', 1, null, false);
        $deleted = $this->master('Deleted root', 'security', 1, null, false);
        $deleted->delete();

        $all = $this->withToken($token)->getJson('/api/masters/category-certificates')->assertOk();
        $this->assertSame(['Cleaning root', 'Security child', 'Security root'], array_column($all->json('data'), 'title'));
        $all->assertJsonPath('data.1.id', (int) $child->id)
            ->assertJsonPath('data.1.category', 'security')
            ->assertJsonPath('data.1.parent_id', (int) $root->id)
            ->assertJsonPath('data.1.is_tuk', true)
            ->assertJsonPath('data.1.level', 2)
            ->assertJsonPath('data.2.title', 'Security root');

        $this->withToken($token)->getJson('/api/masters/category-certificates?category=security')
            ->assertOk()->assertJsonCount(2, 'data');
        $this->withToken($token)->getJson('/api/masters/category-certificates?category=cs')
            ->assertOk()->assertJsonCount(1, 'data')->assertJsonPath('data.0.id', (int) $cs->id);
        $this->withToken($token)->getJson('/api/masters/category-certificates?category=empty')
            ->assertUnprocessable()->assertJsonValidationErrors('category');
    }

    public function test_empty_results_authentication_and_other_reference_endpoint_are_unchanged(): void
    {
        $this->getJson('/api/masters/category-certificates')->assertUnauthorized();
        $token = app(TokenService::class)->issue($this->companyUser())['access_token'];
        $this->withToken($token)->getJson('/api/masters/category-certificates?category=cs')
            ->assertOk()->assertExactJson(['status' => true, 'data' => []]);

        $position = MasterPosition::create(['title' => 'Position title']);
        $this->withToken($token)->getJson('/api/masters/positions')
            ->assertOk()->assertExactJson(['status' => true, 'data' => [['title' => $position->title]]]);
    }

    private function master(string $title, string $category, int $level, ?int $parentId, bool $isTuk): MasterCategoryCertificate
    {
        return MasterCategoryCertificate::create([
            'title' => $title,
            'category' => $category,
            'level' => $level,
            'parent_id' => $parentId,
            'is_tuk' => $isTuk,
            'status' => 'active',
        ]);
    }

    private function companyUser(): User
    {
        return User::create([
            'name' => 'Reference Company',
            'email' => 'reference-company@example.test',
            'password' => 'password',
            'role' => 'company',
            'status' => 'active',
        ]);
    }
}
