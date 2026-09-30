<?php

namespace Tests\Feature\Api;

use App\Models\MasterSubscription;
use App\Models\User;
use App\Models\UserOrderManual;
use App\Services\Api\TokenService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tests\TestCase;
use Throwable;

class UserOrderManualConcurrencyTest extends TestCase
{
    use RefreshDatabase;

    protected array $connectionsToTransact = [];

    public function test_concurrent_creates_leave_only_one_pending_order(): void
    {
        if (DB::connection()->getDriverName() !== 'mysql') {
            $this->markTestSkipped('Concurrent order creation requires MySQL row locks.');
        }

        if (! function_exists('pcntl_fork') || ! function_exists('stream_socket_pair')) {
            $this->markTestSkipped('Concurrent order creation requires process and socket support.');
        }

        $user = null;
        $subscription = null;
        $workers = [];

        try {
            $identifier = str_replace('-', '', (string) Str::uuid());
            $user = User::create([
                'name' => 'Concurrent Order User',
                'email' => "order-concurrency-{$identifier}@example.com",
                'phone_number' => '08'.substr($identifier, 0, 10),
                'google_id' => "order-concurrency-{$identifier}",
                'password' => 'password',
                'role' => 'satpam',
                'status' => 'active',
            ]);
            $subscription = MasterSubscription::create([
                'name' => 'Concurrent Plan',
                'slug' => 'concurrent-plan',
                'role' => 'security',
                'price' => 99000,
                'duration' => 30,
                'duration_type' => 'day',
                'description' => 'Concurrent order test plan',
                'features' => ['job_vacancy' => ['enabled' => true, 'limit' => 1]],
                'is_active' => true,
                'sort_order' => 1,
            ]);
            $token = app(TokenService::class)->issue($user)['access_token'];

            for ($index = 0; $index < 2; $index++) {
                $sockets = stream_socket_pair(STREAM_PF_UNIX, STREAM_SOCK_STREAM, 0);
                if ($sockets === false) {
                    throw new \RuntimeException('Unable to create worker synchronization sockets.');
                }

                $pid = pcntl_fork();
                if ($pid === -1) {
                    fclose($sockets[0]);
                    fclose($sockets[1]);
                    throw new \RuntimeException('Unable to start a concurrent order worker.');
                }

                if ($pid === 0) {
                    fclose($sockets[0]);
                    $exitCode = 0;

                    try {
                        if (fread($sockets[1], 1) !== 'g') {
                            throw new \RuntimeException('Worker did not receive the start signal.');
                        }

                        DB::purge();
                        $response = $this->withToken($token)->postJson('/api/user-order-manuals', [
                            'subscription_uuid' => $subscription->uuid,
                        ]);

                        fwrite($sockets[1], json_encode([
                            'status' => $response->getStatusCode(),
                            'body' => $response->json(),
                        ], JSON_THROW_ON_ERROR));
                    } catch (Throwable $exception) {
                        $exitCode = 1;
                        fwrite($sockets[1], json_encode([
                            'exception' => $exception::class,
                            'message' => $exception->getMessage(),
                        ], JSON_THROW_ON_ERROR));
                    }

                    fclose($sockets[1]);
                    exit($exitCode);
                }

                fclose($sockets[1]);
                $workers[] = ['pid' => $pid, 'socket' => $sockets[0]];
            }

            foreach ($workers as $worker) {
                fwrite($worker['socket'], 'g');
            }

            $responses = [];
            $workerExitCodes = [];
            foreach ($workers as $worker) {
                stream_set_timeout($worker['socket'], 30);
                $output = stream_get_contents($worker['socket']);
                fclose($worker['socket']);

                pcntl_waitpid($worker['pid'], $status);
                $workerExitCodes[] = pcntl_wifexited($status) ? pcntl_wexitstatus($status) : 1;
                $responses[] = json_decode($output, true, 512, JSON_THROW_ON_ERROR);
            }

            $this->assertSame([0, 0], $workerExitCodes, json_encode($responses, JSON_THROW_ON_ERROR));
            $statuses = array_column($responses, 'status');
            sort($statuses);
            $this->assertSame([201, 409], $statuses, json_encode($responses, JSON_THROW_ON_ERROR));

            $pendingOrder = UserOrderManual::query()
                ->where('user_id', $user->getKey())
                ->where('status', 'pending_payment')
                ->firstOrFail();
            $this->assertSame(1, UserOrderManual::query()->where('user_id', $user->getKey())->count());

            $conflict = collect($responses)->firstWhere('status', 409);
            $this->assertSame('pending_payment_order_exists', $conflict['body']['code']);
            $this->assertSame($pendingOrder->uuid, $conflict['body']['data']['user_order_manual']['uuid']);
        } finally {
            foreach ($workers as $worker) {
                if (is_resource($worker['socket'])) {
                    fclose($worker['socket']);
                }
            }

            if ($user !== null) {
                DB::table('user_order_manuals')->where('user_id', $user->getKey())->delete();
                DB::table('api_tokens')->where('user_id', $user->getKey())->delete();
                DB::table('users')->where('id', $user->getKey())->delete();
            }

            if ($subscription !== null) {
                DB::table('master_subscriptions')->where('id', $subscription->getKey())->delete();
            }
        }
    }
}
