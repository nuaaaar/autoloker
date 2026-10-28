<?php

namespace Tests\Feature\Admin;

use App\Models\MasterCategoryCertificate;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MasterCategoryCertificateTest extends TestCase
{
    use RefreshDatabase;

    public function test_tuk_is_inherited_from_parent_and_can_be_removed_when_reparented(): void
    {
        $this->actingAs($this->admin());

        foreach (['security', 'cs'] as $category) {
            $parent = MasterCategoryCertificate::create([
                'title' => "{$category} TUK parent",
                'category' => $category,
                'level' => 1,
                'is_tuk' => true,
            ]);
            $falseParent = MasterCategoryCertificate::create([
                'title' => "{$category} non-TUK parent",
                'category' => $category,
                'level' => 1,
                'is_tuk' => false,
            ]);

            foreach ([[], ['is_tuk' => 0]] as $input) {
                $this->post(route('dashboard-admin.master.category-certificate.category.store', $category), [
                    'title' => "{$category} inherited " . count(MasterCategoryCertificate::all()),
                    'parent_id' => $parent->id,
                    ...$input,
                ])->assertOk()
                    ->assertJsonPath('status', true)
                    ->assertJsonPath('data.is_tuk', true)
                    ->assertJsonPath('data.level', 2);

                $child = MasterCategoryCertificate::query()->latest('id')->firstOrFail();
                $this->assertTrue((bool) $child->is_tuk);
                $this->put(route('dashboard-admin.master.category-certificate.category.update', [$category, $child->uuid]), [
                    'title' => $child->title,
                    'parent_id' => $parent->id,
                    'is_tuk' => 0,
                ])->assertOk()->assertJsonPath('data.is_tuk', true);
                $this->assertTrue((bool) $child->fresh()->is_tuk);
            }

            $legacy = MasterCategoryCertificate::create([
                'title' => "{$category} legacy child",
                'category' => $category,
                'parent_id' => $parent->id,
                'level' => 2,
                'is_tuk' => false,
            ]);
            $this->put(route('dashboard-admin.master.category-certificate.category.update', [$category, $legacy->uuid]), [
                'title' => $legacy->title,
                'parent_id' => $parent->id,
            ])->assertOk();
            $this->assertTrue((bool) $legacy->fresh()->is_tuk);

            $this->put(route('dashboard-admin.master.category-certificate.category.update', [$category, $legacy->uuid]), [
                'title' => $legacy->title,
                'parent_id' => $falseParent->id,
                'is_tuk' => 0,
            ])->assertOk();
            $this->assertFalse((bool) $legacy->fresh()->is_tuk);

            $this->post(route('dashboard-admin.master.category-certificate.category.store', $category), [
                'title' => "{$category} manual true",
                'is_tuk' => 1,
            ])->assertOk()->assertJsonPath('data.is_tuk', true);
        }
    }

    public function test_web_category_level_is_derived_from_parent_for_both_categories(): void
    {
        $this->actingAs($this->admin());

        foreach (['security', 'cs'] as $category) {
            $this->post(route('dashboard-admin.master.category-certificate.category.store', $category), [
                'title' => "{$category} root",
            ])->assertOk()->assertJsonPath('status', true);
            $root = MasterCategoryCertificate::query()->where('category', $category)->latest('id')->firstOrFail();
            $this->assertNull($root->parent_id);
            $this->assertSame(1, (int) $root->level);

            $this->post(route('dashboard-admin.master.category-certificate.category.store', $category), [
                'title' => "{$category} child",
                'parent_id' => $root->id,
                'is_tuk' => 1,
            ])->assertOk()->assertJsonPath('status', true);
            $child = MasterCategoryCertificate::query()->where('category', $category)->latest('id')->firstOrFail();
            $this->assertSame($root->id, $child->parent_id);
            $this->assertSame(2, (int) $child->level);
            $this->assertTrue((bool) $child->is_tuk);

            $this->put(route('dashboard-admin.master.category-certificate.category.update', [$category, $child->uuid]), [
                'title' => "{$category} child",
            ])->assertOk();
            $this->assertNull($child->fresh()->parent_id);
            $this->assertSame(1, (int) $child->fresh()->level);

            $newRoot = MasterCategoryCertificate::create(['title' => "{$category} second root", 'category' => $category, 'level' => 1]);
            $this->put(route('dashboard-admin.master.category-certificate.category.update', [$category, $child->uuid]), [
                'title' => "{$category} child",
                'parent_id' => $newRoot->id,
            ])->assertOk();
            $this->assertSame($newRoot->id, $child->fresh()->parent_id);
            $this->assertSame(2, (int) $child->fresh()->level);
        }
    }
    public function test_index_passes_parent_tuk_metadata(): void
    {
        $admin = $this->admin();
        MasterCategoryCertificate::create([
            'title' => 'TUK parent',
            'category' => 'security',
            'level' => 1,
            'is_tuk' => true,
        ]);

        $this->actingAs($admin)
            ->get(route('dashboard-admin.master.category-certificate.category.index', 'security'))
            ->assertOk()
            ->assertViewHas('parentCertificates', function ($parents) {
                return (bool) $parents->firstWhere('title', 'TUK parent')?->is_tuk;
            });
    }


    public function test_web_category_rejects_cross_category_and_self_parent(): void
    {
        $this->actingAs($this->admin());
        $security = MasterCategoryCertificate::create(['title' => 'Security root', 'category' => 'security', 'level' => 1]);
        $cs = MasterCategoryCertificate::create(['title' => 'CS root', 'category' => 'cs', 'level' => 1]);

        $this->post(route('dashboard-admin.master.category-certificate.category.store', 'security'), [
            'title' => 'Invalid child', 'parent_id' => $cs->id,
        ])->assertSessionHasErrors('parent_id');

        $this->put(route('dashboard-admin.master.category-certificate.category.update', ['security', $security->uuid]), [
            'title' => 'Security root', 'parent_id' => $security->id,
        ])->assertSessionHasErrors('parent_id');

        $this->assertNull($security->fresh()->parent_id);
        $this->assertSame(1, (int) $security->fresh()->level);
    }

    private function admin(): User
    {
        return User::create([
            'name' => 'Admin',
            'email' => 'category-admin@example.test',
            'google_id' => null,
            'password' => 'password',
            'role' => 'admin',
            'status' => 'active',
        ]);
    }
}
