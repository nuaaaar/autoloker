<?php

namespace Tests\Feature\Api;

use App\Models\MasterSubscription;
use App\Models\User;
use App\Models\UserOrderManual;
use App\Services\Api\TokenService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UserOrderManualProofUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_an_order_when_no_pending_order_exists(): void
    {
        $user = $this->createUser('New Order User', 'new-order@example.com', '081234567894', 'new-order-google-id');
        $subscription = $this->createSubscription();
        $token = app(TokenService::class)->issue($user)['access_token'];

        $this->withToken($token)
            ->postJson('/api/user-order-manuals', ['subscription_uuid' => $subscription->uuid])
            ->assertCreated()
            ->assertJsonPath('status', true)
            ->assertJsonPath('data.user_order_manual.status', 'pending_payment')
            ->assertJsonPath('data.user_order_manual.subscription.uuid', $subscription->uuid);

        $this->assertDatabaseCount('user_order_manuals', 1);
    }

    public function test_pending_order_blocks_a_second_order_for_a_different_plan(): void
    {
        $user = $this->createUser('Pending User', 'pending@example.com', '081234567894', 'pending-google-id');
        $firstSubscription = $this->createSubscription();
        $secondSubscription = $this->createSubscription('professional', 'Professional');
        $token = app(TokenService::class)->issue($user)['access_token'];

        $firstOrder = $this->withToken($token)
            ->postJson('/api/user-order-manuals', ['subscription_uuid' => $firstSubscription->uuid])
            ->assertCreated();
        $firstOrderUuid = $firstOrder->json('data.user_order_manual.uuid');

        $this->withToken($token)
            ->postJson('/api/user-order-manuals', ['subscription_uuid' => $secondSubscription->uuid])
            ->assertStatus(409)
            ->assertJsonPath('status', false)
            ->assertJsonPath('code', 'pending_payment_order_exists')
            ->assertJsonPath('message', 'You already have an order waiting for payment.')
            ->assertJsonPath('data.user_order_manual.uuid', $firstOrderUuid)
            ->assertJsonPath('data.user_order_manual.status', 'pending_payment')
            ->assertJsonPath('data.user_order_manual.subscription.uuid', $firstSubscription->uuid);

        $this->assertDatabaseCount('user_order_manuals', 1);
        $this->assertDatabaseHas('user_order_manuals', [
            'uuid' => $firstOrderUuid,
            'user_id' => $user->id,
            'master_subscription_id' => $firstSubscription->id,
            'status' => 'pending_payment',
        ]);
        $this->assertDatabaseMissing('user_order_manuals', [
            'user_id' => $user->id,
            'master_subscription_id' => $secondSubscription->id,
        ]);
    }

    public function test_another_users_pending_order_does_not_block_creation(): void
    {
        $existingOwner = $this->createUser('Existing Owner', 'existing-owner@example.com', '081234567894', 'existing-owner-google-id');
        $newOwner = $this->createUser('New Owner', 'new-owner@example.com', '081234567895', 'new-owner-google-id');
        $subscription = $this->createSubscription();
        $existingOwnerToken = app(TokenService::class)->issue($existingOwner)['access_token'];
        $newOwnerToken = app(TokenService::class)->issue($newOwner)['access_token'];

        $this->withToken($existingOwnerToken)
            ->postJson('/api/user-order-manuals', ['subscription_uuid' => $subscription->uuid])
            ->assertCreated();

        $this->withToken($newOwnerToken)
            ->postJson('/api/user-order-manuals', ['subscription_uuid' => $subscription->uuid])
            ->assertCreated()
            ->assertJsonPath('data.user_order_manual.user_id', $newOwner->id)
            ->assertJsonPath('data.user_order_manual.status', 'pending_payment');

        $this->assertDatabaseCount('user_order_manuals', 2);
        $this->assertDatabaseHas('user_order_manuals', [
            'user_id' => $existingOwner->id,
            'status' => 'pending_payment',
        ]);
        $this->assertDatabaseHas('user_order_manuals', [
            'user_id' => $newOwner->id,
            'status' => 'pending_payment',
        ]);
    }

    public function test_non_pending_order_statuses_do_not_block_creation(): void
    {
        $user = $this->createUser('Status User', 'status@example.com', '081234567894', 'status-google-id');
        $subscription = $this->createSubscription();
        $token = app(TokenService::class)->issue($user)['access_token'];

        $order = $this->withToken($token)
            ->postJson('/api/user-order-manuals', ['subscription_uuid' => $subscription->uuid])
            ->assertCreated();
        $orderUuid = $order->json('data.user_order_manual.uuid');

        foreach (['verification', 'approved', 'rejected'] as $status) {
            UserOrderManual::query()->where('uuid', $orderUuid)->update(['status' => $status]);

            $order = $this->withToken($token)
                ->postJson('/api/user-order-manuals', ['subscription_uuid' => $subscription->uuid])
                ->assertCreated()
                ->assertJsonPath('data.user_order_manual.status', 'pending_payment');

            $orderUuid = $order->json('data.user_order_manual.uuid');
        }

        $this->assertDatabaseCount('user_order_manuals', 4);
        foreach (['verification', 'approved', 'rejected'] as $status) {
            $this->assertDatabaseHas('user_order_manuals', [
                'user_id' => $user->id,
                'status' => $status,
            ]);
        }
        $this->assertDatabaseHas('user_order_manuals', [
            'uuid' => $orderUuid,
            'status' => 'pending_payment',
        ]);
    }

    public function test_authenticated_owner_can_create_an_order_and_upload_payment_proof(): void
    {
        $user = $this->createUser('Payment User', 'payment@example.com', '081234567890', 'payment-google-id');
        $subscription = $this->createSubscription();
        $token = app(TokenService::class)->issue($user)['access_token'];

        $created = $this->withToken($token)
            ->postJson('/api/user-order-manuals', ['subscription_uuid' => $subscription->uuid])
            ->assertCreated()
            ->assertJsonPath('data.user_order_manual.status', 'pending_payment')
            ->assertJsonPath('data.user_order_manual.price', '99000.00');

        $orderUuid = $created->json('data.user_order_manual.uuid');
        $storedPath = null;

        try {
            $response = $this->withToken($token)->post(
                "/api/user-order-manuals/{$orderUuid}/upload-proof",
                [
                    'payment_method' => 'BCA',
                    'payment_account' => '99887766',
                    'payment_date' => '2026-09-21',
                    'payment_proof' => UploadedFile::fake()->create('transfer.pdf', 10, 'application/pdf'),
                ],
                ['Accept' => 'application/json'],
            );

            $response->assertOk()
                ->assertJsonPath('status', true)
                ->assertJsonPath('data.user_order_manual.status', 'verification')
                ->assertJsonPath('data.user_order_manual.payment_method', 'BCA')
                ->assertJsonPath('data.user_order_manual.payment_account', '99887766');

            $order = UserOrderManual::query()->where('uuid', $orderUuid)->firstOrFail();
            $storedPath = public_path('uploads/payment/'.$order->file);
            $this->assertSame('verification', $order->status);
            $this->assertSame('2026-09-21', $order->payment_date->toDateString());
            $this->assertFileExists($storedPath);
        } finally {
            if ($storedPath !== null && is_file($storedPath)) {
                unlink($storedPath);
            }
        }
    }

    public function test_rejected_order_can_receive_new_proof_and_clears_rejection_reason(): void
    {
        $user = $this->createUser('Retry User', 'retry@example.com', '081234567891', 'retry-google-id');
        $subscription = $this->createSubscription();
        $token = app(TokenService::class)->issue($user)['access_token'];
        $created = $this->withToken($token)
            ->postJson('/api/user-order-manuals', ['subscription_uuid' => $subscription->uuid])
            ->assertCreated();
        $orderUuid = $created->json('data.user_order_manual.uuid');
        UserOrderManual::query()->where('uuid', $orderUuid)->update([
            'status' => 'rejected',
            'rejected_reason' => 'Bukti tidak terbaca',
        ]);
        $storedPath = null;

        try {
            $this->withToken($token)->post(
                "/api/user-order-manuals/{$orderUuid}/upload-proof",
                [
                    'payment_method' => 'BCA',
                    'payment_date' => '2026-09-21',
                    'payment_proof' => UploadedFile::fake()->create('replacement.pdf', 10, 'application/pdf'),
                ],
                ['Accept' => 'application/json'],
            )->assertOk()
                ->assertJsonPath('data.user_order_manual.status', 'verification')
                ->assertJsonPath('data.user_order_manual.rejected_reason', null);

            $order = UserOrderManual::query()->where('uuid', $orderUuid)->firstOrFail();
            $storedPath = public_path('uploads/payment/'.$order->file);
            $this->assertSame('verification', $order->status);
            $this->assertNull($order->rejected_reason);
            $this->assertFileExists($storedPath);
        } finally {
            if ($storedPath !== null && is_file($storedPath)) {
                unlink($storedPath);
            }
        }
    }

    public function test_proof_upload_is_owner_scoped_and_rejects_invalid_file_types(): void
    {
        $owner = $this->createUser('Order Owner', 'owner@example.com', '081234567892', 'owner-google-id');
        $other = $this->createUser('Other User', 'other-payment@example.com', '081234567893', 'other-payment-google-id');
        $subscription = $this->createSubscription();
        $ownerToken = app(TokenService::class)->issue($owner)['access_token'];
        $otherToken = app(TokenService::class)->issue($other)['access_token'];
        $created = $this->withToken($ownerToken)
            ->postJson('/api/user-order-manuals', ['subscription_uuid' => $subscription->uuid])
            ->assertCreated();
        $orderUuid = $created->json('data.user_order_manual.uuid');
        $endpoint = "/api/user-order-manuals/{$orderUuid}/upload-proof";

        $this->withToken($otherToken)->post($endpoint, [
            'payment_method' => 'BCA',
            'payment_date' => '2026-09-21',
            'payment_proof' => UploadedFile::fake()->create('transfer.pdf', 10, 'application/pdf'),
        ], ['Accept' => 'application/json'])->assertNotFound();

        $this->withToken($ownerToken)->post($endpoint, [
            'payment_method' => 'BCA',
            'payment_date' => '2026-09-21',
            'payment_proof' => UploadedFile::fake()->create('proof.txt', 1, 'text/plain'),
        ], ['Accept' => 'application/json'])->assertUnprocessable();

        $this->assertDatabaseHas('user_order_manuals', [
            'uuid' => $orderUuid,
            'status' => 'pending_payment',
            'file' => null,
        ]);
    }

    public function test_order_detail_is_owner_scoped_and_returns_latest_payment_status_for_polling(): void
    {
        $owner = $this->createUser('Detail Owner', 'detail-owner@example.com', '081234567895', 'detail-owner-google-id');
        $other = $this->createUser('Other Detail User', 'other-detail@example.com', '081234567896', 'other-detail-google-id');
        $subscription = $this->createSubscription();
        $ownerToken = app(TokenService::class)->issue($owner)['access_token'];
        $otherToken = app(TokenService::class)->issue($other)['access_token'];
        $created = $this->withToken($ownerToken)
            ->postJson('/api/user-order-manuals', ['subscription_uuid' => $subscription->uuid])
            ->assertCreated();
        $orderUuid = $created->json('data.user_order_manual.uuid');
        $endpoint = "/api/user-order-manuals/{$orderUuid}";

        $this->withToken($ownerToken)->getJson($endpoint)
            ->assertOk()
            ->assertJsonPath('data.user_order_manual.uuid', $orderUuid)
            ->assertJsonPath('data.user_order_manual.status', 'pending_payment')
            ->assertJsonPath('data.user_order_manual.subscription.name', 'Premium')
            ->assertHeader('Cache-Control', 'no-store, private');

        UserOrderManual::query()->where('uuid', $orderUuid)->update([
            'status' => 'approved',
            'notes' => 'Payment verified.',
        ]);

        $this->withToken($ownerToken)->getJson($endpoint)
            ->assertOk()
            ->assertJsonPath('data.user_order_manual.status', 'approved')
            ->assertJsonPath('data.user_order_manual.notes', 'Payment verified.')
            ->assertHeader('Cache-Control', 'no-store, private');

        $this->withToken($otherToken)->getJson($endpoint)->assertNotFound();
    }

    private function createUser(string $name, string $email, string $phone, string $googleId): User
    {
        return User::create([
            'name' => $name,
            'email' => $email,
            'phone_number' => $phone,
            'google_id' => $googleId,
            'password' => 'password',
            'role' => 'satpam',
            'status' => 'active',
        ]);
    }

    private function createSubscription(string $slug = 'premium', string $name = 'Premium'): MasterSubscription
    {
        return MasterSubscription::create([
            'name' => $name,
            'slug' => $slug,
            'role' => 'security',
            'price' => 99000,
            'duration' => 30,
            'duration_type' => 'day',
            'description' => 'Premium security plan',
            'features' => ['job_vacancy' => ['enabled' => true, 'limit' => 1]],
            'is_active' => true,
            'sort_order' => 1,
        ]);
    }
}
