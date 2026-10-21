<?php

namespace Tests\Feature\Api;

use App\Services\Api\AccountDeletionFileService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Exceptions\HttpResponseException;
use Tests\TestCase;

class AccountDeletionFileCleanupTest extends TestCase
{
    use RefreshDatabase;

    public function test_normalizes_supported_upload_paths_and_rejects_traversal(): void
    {
        $files = app(AccountDeletionFileService::class);
        $this->assertSame(['location' => 'public_disk', 'path' => 'formal-photo/profile.jpg'], $files->normalize('storage/formal-photo/profile.jpg', 'public_asset'));
        $this->assertSame(['location' => 'web_upload', 'path' => 'uploads/certificate/award.pdf'], $files->normalize('uploads/certificate/award.pdf', 'certificate'));
        $this->assertSame(['location' => 'web_upload', 'path' => 'uploads/payment/proof.png'], $files->normalize('proof.png', 'payment'));
        $this->assertNull($files->normalize('https://accounts.google.com/avatar', 'public_asset'));
        try {
            $files->normalize('formal-photo/../../outside', 'public_asset');
            $this->fail('Traversal path was accepted.');
        } catch (HttpResponseException $exception) {
            $this->assertSame(409, $exception->getResponse()->getStatusCode());
        }
    }

    public function test_purge_removes_only_the_manifest_file(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('formal-photo/target.jpg', 'target');
        Storage::disk('public')->put('company-logo/target.jpg', 'preserve');
        $id = DB::table('account_deletion_files')->insertGetId(['location' => 'public_disk', 'path' => 'formal-photo/target.jpg', 'created_at' => now(), 'updated_at' => now()]);

        $this->assertTrue(app(AccountDeletionFileService::class)->purge([$id]));
        Storage::disk('public')->assertMissing('formal-photo/target.jpg');
        Storage::disk('public')->assertExists('company-logo/target.jpg');
        $this->assertDatabaseMissing('account_deletion_files', ['id' => $id]);
        $this->assertTrue(app(AccountDeletionFileService::class)->purge([]));
        $this->artisan('accounts:purge-deletion-files')->assertExitCode(0);
    }
}
