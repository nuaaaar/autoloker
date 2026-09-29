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

    private function createSubscription(): MasterSubscription
    {
        return MasterSubscription::create([
            'name' => 'Premium',
            'slug' => 'premium',
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
