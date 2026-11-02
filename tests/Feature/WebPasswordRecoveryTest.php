<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class WebPasswordRecoveryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['queue.default' => 'database', 'mail.default' => 'array']);
        Notification::fake();
    }

    public function test_known_and_unknown_addresses_have_identical_browser_outcomes_before_mail_processing(): void
    {
        $user = User::factory()->create();
        $password = $user->password;

        foreach ([$user->email, 'missing@example.com'] as $email) {
            $response = $this->from('/login')->post('/forgot-password', ['email' => $email]);
            $response->assertRedirect('/login')->assertSessionHas('show_forgot_modal', true)
                ->assertSessionHas('forgot_success', 'Jika alamat email terdaftar, kami akan mengirimkan tautan untuk mengatur ulang kata sandi.');
        }

        $this->assertSame($password, $user->fresh()->password);
        $this->assertDatabaseCount('password_reset_tokens', 0);
        $this->assertDatabaseCount('jobs', 2);

        $this->artisan('queue:work', ['connection' => 'database', '--queue' => 'default', '--once' => true])->assertExitCode(0);
        $this->artisan('queue:work', ['connection' => 'database', '--queue' => 'default', '--once' => true])->assertExitCode(0);
        Notification::assertSentTo($user, ResetPassword::class);
        $this->assertDatabaseCount('jobs', 0);
    }
}
