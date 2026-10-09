<?php

namespace App\Services\Api;

use App\Models\CleaningService;
use App\Models\Security;
use App\Models\User;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Single source of truth for the applicant profile that backs the active role.
 *
 * Feed filters, application lookups, ownership checks, and quota accounting all
 * derive the applicant category, foreign key, and profile id from this
 * resolver so role rules never fork per controller.
 */
class ApplicantProfileResolver
{
    /**
     * @return array{role: string, category: string, column: string, profile: Security|CleaningService, profile_id: int}
     */
    public function resolve(User $user): array
    {
        $profile = match ($user->role) {
            'satpam' => [
                'category' => 'security',
                'column' => 'security_id',
                'profile' => $user->user_security?->security,
            ],
            'cs' => [
                'category' => 'cs',
                'column' => 'cleaning_service_id',
                'profile' => $user->user_cleaning_service?->cleaning_service,
            ],
            default => null,
        };

        if ($profile === null || $profile['profile'] === null) {
            throw new NotFoundHttpException('Profil '.$this->label($user->role).' tidak ditemukan.');
        }

        return [
            'role' => $user->role,
            'category' => $profile['category'],
            'column' => $profile['column'],
            'profile' => $profile['profile'],
            'profile_id' => $profile['profile']->getKey(),
        ];
    }

    /**
     * Profile completion gate shared by job and training applications.
     *
     * @return array{progress: int, completed: int, total: int, missing: list<string>}
     */
    public function completion(User $user): array
    {
        return $this->resolve($user)['profile']->profileProgress();
    }

    private function label(?string $role): string
    {
        return $role === 'cs' ? 'cleaning service' : 'satpam';
    }
}
