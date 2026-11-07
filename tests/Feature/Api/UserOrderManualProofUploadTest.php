<?php

namespace Tests\Feature\Api;

use App\Models\Company;
use App\Models\User;
use App\Models\UserCompany;
use App\Models\UserOrderManual;
use App\Services\Api\TokenService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UserOrderManualProofUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_company_can_create_token_order_and_pending_order_conflicts_until_expiry(): void
    {
        [$user, $company] = $this->companyAccount('order@example.com', 'Order Company');
        $token = app(TokenService::class)->issue($user)['access_token'];

        $created = $this->withToken($token)->postJson('/api/user-order-manuals', ['token_quantity' => 5])
            ->assertCreated()->assertJsonPath('data.user_order_manual.status', 'pending_payment')
            ->assertJsonPath('data.user_order_manual.token_quantity', 5)
            ->assertJsonPath('data.user_order_manual.idr_per_token', 10000)
            ->assertJsonPath('data.user_order_manual.price', 50000);
        $uuid = $created->json('data.user_order_manual.uuid');

        $this->withToken($token)->postJson('/api/user-order-manuals', ['token_quantity' => 2])
            ->assertStatus(409)->assertJsonPath('data.user_order_manual.uuid', $uuid);
        $order = UserOrderManual::where('uuid', $uuid)->firstOrFail();
        $this->assertSame($company->id, $order->tokenWallet->owner_id);
        $this->assertSame(5, $order->token_quantity);

        $order->update(['expired_at' => now()->subSecond()]);
        $this->withToken($token)->postJson('/api/user-order-manuals', ['token_quantity' => 2])->assertCreated();
        $this->assertDatabaseCount('user_order_manuals', 2);
    }

    public function test_proof_upload_preserves_payment_details_and_does_not_credit_wallet(): void
    {
        [$user] = $this->companyAccount('proof@example.com', 'Proof Company');
        $token = app(TokenService::class)->issue($user)['access_token'];
        $uuid = $this->withToken($token)->postJson('/api/user-order-manuals', ['token_quantity' => 3])
            ->assertCreated()->json('data.user_order_manual.uuid');
        $path = null;

        try {
            $this->withToken($token)->post("/api/user-order-manuals/{$uuid}/upload-proof", [
                'payment_method' => 'BCA', 'payment_account' => '99887766', 'payment_date' => '2026-09-21',
                'payment_proof' => UploadedFile::fake()->create('transfer.pdf', 10, 'application/pdf'),
            ], ['Accept' => 'application/json'])->assertOk()
                ->assertJsonPath('data.user_order_manual.status', 'verification')
                ->assertJsonPath('data.user_order_manual.payment_method', 'BCA');

            $order = UserOrderManual::where('uuid', $uuid)->firstOrFail();
            $path = public_path('uploads/payment/'.$order->file);
            $this->assertSame('2026-09-21', $order->payment_date->toDateString());
            $this->assertSame(0, $order->tokenWallet->fresh()->balance);
            $this->assertFileExists($path);
        } finally {
            if ($path !== null && is_file($path)) unlink($path);
        }
    }

    public function test_proof_upload_rejects_invalid_mime_and_expired_order(): void
    {
        $this->travelTo(now()->startOfSecond());
        [$user] = $this->companyAccount('invalid-proof@example.com', 'Invalid Proof Company');
        $token = app(TokenService::class)->issue($user)['access_token'];
        $uuid = $this->withToken($token)->postJson('/api/user-order-manuals', ['token_quantity' => 1])
            ->assertCreated()->json('data.user_order_manual.uuid');
        $proof = ['payment_method' => 'BCA', 'payment_date' => '2026-09-21', 'payment_proof' => UploadedFile::fake()->create('proof.txt', 1, 'text/plain')];
        $this->withToken($token)->post("/api/user-order-manuals/{$uuid}/upload-proof", $proof, ['Accept' => 'application/json'])->assertUnprocessable();
        UserOrderManual::where('uuid', $uuid)->update(['expired_at' => now()]);
        $this->withToken($token)->post("/api/user-order-manuals/{$uuid}/upload-proof", [
            'payment_method' => 'BCA', 'payment_date' => '2026-09-21', 'payment_proof' => UploadedFile::fake()->create('transfer.pdf', 10, 'application/pdf'),
        ], ['Accept' => 'application/json'])->assertNotFound();
    }

    public function test_order_access_and_cancellation_are_scoped_to_organization(): void
    {
        [$owner, $company] = $this->companyAccount('owner@example.com', 'Owner Company');
        [$other] = $this->companyAccount('other-org@example.com', 'Other Company');
        $ownerToken = app(TokenService::class)->issue($owner)['access_token'];
        $otherToken = app(TokenService::class)->issue($other)['access_token'];
        $uuid = $this->withToken($ownerToken)->postJson('/api/user-order-manuals', ['token_quantity' => 1])
            ->assertCreated()->json('data.user_order_manual.uuid');

        $this->withToken($otherToken)->getJson("/api/user-order-manuals/{$uuid}")->assertNotFound();
        $this->withToken($otherToken)->postJson("/api/user-order-manuals/{$uuid}/cancel")->assertNotFound();
        $this->withToken($otherToken)->post("/api/user-order-manuals/{$uuid}/upload-proof", [
            'payment_method' => 'BCA', 'payment_date' => '2026-09-21',
            'payment_proof' => UploadedFile::fake()->create('transfer.pdf', 10, 'application/pdf'),
        ], ['Accept' => 'application/json'])->assertNotFound();
        $this->withToken($ownerToken)->postJson("/api/user-order-manuals/{$uuid}/cancel")->assertOk()
            ->assertJsonPath('data.user_order_manual.status', 'cancelled');
    }

    public function test_only_pending_orders_can_be_cancelled(): void
    {
        [$user] = $this->companyAccount('cancel@example.com', 'Cancel Company');
        $token = app(TokenService::class)->issue($user)['access_token'];
        $uuid = $this->withToken($token)->postJson('/api/user-order-manuals', ['token_quantity' => 1])
            ->assertCreated()->json('data.user_order_manual.uuid');
        UserOrderManual::where('uuid', $uuid)->update(['status' => 'verification']);
        $this->withToken($token)->postJson("/api/user-order-manuals/{$uuid}/cancel")
            ->assertStatus(409)->assertJsonPath('code', 'manual_order_not_cancellable');
        $this->assertDatabaseHas('user_order_manuals', ['uuid' => $uuid, 'status' => 'verification']);
    }

    /** @return array{0: User, 1: Company} */
    private function companyAccount(string $email, string $name): array
    {
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'google_id' => str_replace(['@', '.'], '-', $email),
            'password' => 'password',
            'role' => 'company',
            'status' => 'active',
        ]);
        $link = UserCompany::create(['user_id' => $user->id]);
        $company = Company::create(['user_company_id' => $link->id, 'company_name' => $name]);
        return [$user, $company];
    }
}
