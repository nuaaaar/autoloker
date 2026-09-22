<?php

namespace Tests\Feature\Api;

use App\Models\Security;
use App\Models\Training;
use App\Models\TrainingApplication;
use App\Models\User;
use App\Models\UserSecurity;
use App\Services\Api\TokenService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrainingApplicationTest extends TestCase
{
    use RefreshDatabase;

    public function test_security_can_apply_once_to_a_published_training(): void
    {
        [$user, $security] = $this->securityAccount('training-applicant@example.com');
        $training = Training::create($this->trainingAttributes(['quota' => 1]));
        $token = app(TokenService::class)->issue($user)['access_token'];

        $this->withToken($token)
            ->postJson("/api/trainings/{$training->uuid}/apply")
            ->assertCreated()
            ->assertJsonPath('status', true)
            ->assertJsonPath('data.training_application.training_id', $training->id)
            ->assertJsonPath('data.training_application.status', 'pending');

        $this->assertDatabaseHas('training_applications', [
            'security_id' => $security->id,
            'training_id' => $training->id,
            'status' => 'pending',
        ]);

        $this->withToken($token)
            ->postJson("/api/trainings/{$training->uuid}/apply")
            ->assertUnprocessable()
            ->assertJsonPath('status', false)
            ->assertJsonPath('message', 'Your training application is awaiting approval.');
    }

    public function test_application_is_rejected_when_approved_quota_is_full(): void
    {
        [$user] = $this->securityAccount('training-quota-applicant@example.com');
        [, $approvedSecurity] = $this->securityAccount('training-approved@example.com');
        $training = Training::create($this->trainingAttributes(['quota' => 1]));

        TrainingApplication::create([
            'security_id' => $approvedSecurity->id,
            'training_id' => $training->id,
            'status' => 'approved',
        ]);

        $token = app(TokenService::class)->issue($user)['access_token'];

        $this->withToken($token)
            ->postJson("/api/trainings/{$training->uuid}/apply")
            ->assertUnprocessable()
            ->assertJsonPath('status', false)
            ->assertJsonPath('message', 'The training quota is full.');
    }

    /** @return array{0: User, 1: Security} */
    private function securityAccount(string $email): array
    {
        $user = User::create([
            'name' => 'API Security',
            'email' => $email,
            'google_id' => null,
            'password' => 'password',
            'role' => 'satpam',
            'status' => 'active',
        ]);
        $userSecurity = UserSecurity::create(['user_id' => $user->id]);
        $security = Security::create([
            'user_security_id' => $userSecurity->id,
            'name' => 'API Security',
        ]);

        return [$user, $security];
    }

    private function trainingAttributes(array $overrides = []): array
    {
        return array_merge([
            'title' => 'Security Training',
            'provider' => 'Training Provider',
            'status' => 'published',
            'quota' => 10,
            'start_date' => now()->addDays(7)->toDateString(),
        ], $overrides);
    }
}
