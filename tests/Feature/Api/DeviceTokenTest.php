<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\UserDeviceToken;
use App\Services\Api\TokenService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeviceTokenTest extends TestCase
{
    use RefreshDatabase;

    private const REGISTERED_MESSAGE = 'Token perangkat berhasil didaftarkan.';
    private const REMOVED_MESSAGE = 'Token perangkat berhasil dihapus.';

    public function test_authenticated_account_registers_multiple_distinct_tokens(): void
    {
        $user = $this->account('multi@example.com');
        $token = $this->accessToken($user);

        $this->withToken($token)
            ->postJson('/api/device-tokens', ['fcm_token' => 'test-token-a'])
            ->assertOk()
            ->assertJsonPath('status', true)
            ->assertJsonPath('message', self::REGISTERED_MESSAGE);

        $this->withToken($token)
            ->postJson('/api/device-tokens', ['fcm_token' => 'test-token-b'])
            ->assertOk()
            ->assertJsonPath('status', true)
            ->assertJsonPath('message', self::REGISTERED_MESSAGE);

        $this->assertSame(2, UserDeviceToken::where('user_id', $user->id)->count());

        $stored = UserDeviceToken::where('fcm_token_hash', hash('sha256', 'test-token-a'))->sole();
        $this->assertSame($user->id, $stored->user_id);
        $this->assertSame('test-token-a', $stored->fcm_token);
    }

    public function test_repeated_registration_keeps_a_single_row_for_the_token(): void
    {
        $user = $this->account('repeat@example.com');
        $token = $this->accessToken($user);

        foreach ([1, 2] as $attempt) {
            $this->withToken($token)
                ->postJson('/api/device-tokens', ['fcm_token' => 'test-token-a'])
                ->assertOk()
                ->assertJsonPath('status', true);
        }

        $this->assertSame(1, UserDeviceToken::where('fcm_token_hash', hash('sha256', 'test-token-a'))->count());
        $this->assertSame(1, UserDeviceToken::where('user_id', $user->id)->count());
    }

    public function test_registration_without_platform_defaults_to_mobile(): void
    {
        $user = $this->account('platform-default@example.com');

        $this->withToken($this->accessToken($user))
            ->postJson('/api/device-tokens', ['fcm_token' => 'test-token-a'])
            ->assertOk()
            ->assertJsonPath('message', self::REGISTERED_MESSAGE);

        $stored = UserDeviceToken::sole();

        $this->assertSame($user->id, $stored->user_id);
        $this->assertSame('mobile', $stored->platform);
    }

    public function test_registration_stores_the_web_platform(): void
    {
        $user = $this->account('platform-web@example.com');

        $this->withToken($this->accessToken($user))
            ->postJson('/api/device-tokens', ['fcm_token' => 'test-token-a', 'platform' => 'web'])
            ->assertOk()
            ->assertJsonPath('message', self::REGISTERED_MESSAGE);

        $stored = UserDeviceToken::sole();

        $this->assertSame($user->id, $stored->user_id);
        $this->assertSame('web', $stored->platform);
    }

    public function test_invalid_platform_value_is_rejected_without_writes(): void
    {
        $user = $this->account('platform-invalid@example.com');

        $this->withToken($this->accessToken($user))
            ->postJson('/api/device-tokens', ['fcm_token' => 'test-token-a', 'platform' => 'desktop'])
            ->assertStatus(422)
            ->assertJsonPath('status', false);

        $this->assertSame(0, UserDeviceToken::where('user_id', $user->id)->count());
    }


    public function test_same_token_registered_by_a_second_account_transfers_ownership(): void
    {
        $first = $this->account('first@example.com');
        $second = $this->account('second@example.com');

        $this->withToken($this->accessToken($first))
            ->postJson('/api/device-tokens', ['fcm_token' => 'test-token-a'])
            ->assertOk();

        $this->withToken($this->accessToken($second))
            ->postJson('/api/device-tokens', ['fcm_token' => 'test-token-a'])
            ->assertOk()
            ->assertJsonPath('message', self::REGISTERED_MESSAGE);

        $rows = UserDeviceToken::where('fcm_token_hash', hash('sha256', 'test-token-a'))->get();

        $this->assertCount(1, $rows);
        $this->assertSame($second->id, $rows->first()->user_id);
        $this->assertSame(0, UserDeviceToken::where('user_id', $first->id)->count());
    }

    public function test_unregister_is_scoped_to_the_authenticated_owner(): void
    {
        $owner = $this->account('owner@example.com');
        $other = $this->account('other@example.com');
        $token = 'test-token-a';

        $this->withToken($this->accessToken($owner))
            ->postJson('/api/device-tokens', ['fcm_token' => $token])
            ->assertOk();

        $this->withToken($this->accessToken($other))
            ->postJson('/api/device-tokens/unregister', ['fcm_token' => $token])
            ->assertOk()
            ->assertJsonPath('status', true)
            ->assertJsonPath('message', self::REMOVED_MESSAGE);

        $stored = UserDeviceToken::where('fcm_token_hash', hash('sha256', $token))->sole();
        $this->assertSame($owner->id, $stored->user_id);

        $this->withToken($this->accessToken($owner))
            ->postJson('/api/device-tokens/unregister', ['fcm_token' => $token])
            ->assertOk()
            ->assertJsonPath('status', true)
            ->assertJsonPath('message', self::REMOVED_MESSAGE);

        $this->assertSame(0, UserDeviceToken::count());

        $this->withToken($this->accessToken($owner))
            ->postJson('/api/device-tokens/unregister', ['fcm_token' => $token])
            ->assertOk()
            ->assertJsonPath('status', true)
            ->assertJsonPath('message', self::REMOVED_MESSAGE);

        $this->assertSame(0, UserDeviceToken::count());
    }

    public function test_unregister_removes_only_the_requested_device(): void
    {
        $user = $this->account('twodevices@example.com');
        $token = $this->accessToken($user);

        foreach (['test-token-a', 'test-token-b'] as $deviceToken) {
            $this->withToken($token)
                ->postJson('/api/device-tokens', ['fcm_token' => $deviceToken])
                ->assertOk();
        }

        $this->withToken($token)
            ->postJson('/api/device-tokens/unregister', ['fcm_token' => 'test-token-a'])
            ->assertOk();

        $remaining = UserDeviceToken::where('user_id', $user->id)->get();

        $this->assertCount(1, $remaining);
        $this->assertSame('test-token-b', $remaining->first()->fcm_token);
    }

    public function test_invalid_tokens_are_rejected_without_writes(): void
    {
        $user = $this->account('invalid@example.com');
        $token = $this->accessToken($user);

        $rejected = [
            ['payload' => [], 'error' => ['The fcm token field is required.']],
            ['payload' => ['fcm_token' => ''], 'error' => ['The fcm token field is required.']],
            ['payload' => ['fcm_token' => 12345], 'error' => ['The fcm token field must be a string.']],
            ['payload' => ['fcm_token' => ['nested']], 'error' => ['The fcm token field must be a string.']],
            ['payload' => ['fcm_token' => str_repeat('a', 4097)], 'error' => ['The fcm token field must not be greater than 4096 characters.']],
        ];

        foreach ($rejected as ['payload' => $payload, 'error' => $error]) {
            $this->withToken($token)
                ->postJson('/api/device-tokens', $payload)
                ->assertStatus(422)
                ->assertJsonPath('status', false)
                ->assertJsonPath('errors.fcm_token', $error);

            $this->withToken($token)
                ->postJson('/api/device-tokens/unregister', $payload)
                ->assertStatus(422)
                ->assertJsonPath('status', false)
                ->assertJsonPath('errors.fcm_token', $error);
        }

        $this->assertSame(0, UserDeviceToken::count());
    }

    public function test_token_at_the_size_limit_is_accepted_verbatim(): void
    {
        $user = $this->account('boundary@example.com');
        $boundaryToken = str_repeat('a', 4096);

        $this->withToken($this->accessToken($user))
            ->postJson('/api/device-tokens', ['fcm_token' => $boundaryToken])
            ->assertOk()
            ->assertJsonPath('message', self::REGISTERED_MESSAGE);

        $stored = UserDeviceToken::sole();

        $this->assertSame($boundaryToken, $stored->fcm_token);
        $this->assertSame(hash('sha256', $boundaryToken), $stored->fcm_token_hash);
    }

    public function test_device_token_endpoints_require_authentication(): void
    {
        $this->postJson('/api/device-tokens', ['fcm_token' => 'test-token-a'])
            ->assertUnauthorized()
            ->assertJsonPath('status', false);

        $this->postJson('/api/device-tokens/unregister', ['fcm_token' => 'test-token-a'])
            ->assertUnauthorized()
            ->assertJsonPath('status', false);

        $this->assertSame(0, UserDeviceToken::count());
    }

    public function test_responses_never_expose_the_token_or_its_digest(): void
    {
        $user = $this->account('leak@example.com');
        $token = $this->accessToken($user);

        $register = $this->withToken($token)
            ->postJson('/api/device-tokens', ['fcm_token' => 'test-token-a'])
            ->assertOk();

        $this->assertStringNotContainsString('test-token-a', $register->getContent());
        $this->assertStringNotContainsString(hash('sha256', 'test-token-a'), $register->getContent());

        $unregister = $this->withToken($token)
            ->postJson('/api/device-tokens/unregister', ['fcm_token' => 'test-token-a'])
            ->assertOk();

        $this->assertStringNotContainsString('test-token-a', $unregister->getContent());
        $this->assertStringNotContainsString(hash('sha256', 'test-token-a'), $unregister->getContent());
    }

    public function test_deleting_a_user_cascades_its_device_tokens(): void
    {
        $user = $this->account('cascade@example.com');
        $token = $this->accessToken($user);

        $this->withToken($token)
            ->postJson('/api/device-tokens', ['fcm_token' => 'test-token-a'])
            ->assertOk();

        $this->assertSame(1, UserDeviceToken::count());

        $user->delete();

        $this->assertSame(0, UserDeviceToken::count());
    }

    private function account(string $email): User
    {
        return User::create([
            'name' => 'device user',
            'email' => $email,
            'google_id' => '',
            'password' => 'password',
            'role' => 'security',
            'status' => 'active',
        ]);
    }

    private function accessToken(User $user): string
    {
        return app(TokenService::class)->issue($user)['access_token'];
    }
}
