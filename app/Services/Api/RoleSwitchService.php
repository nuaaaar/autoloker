<?php

namespace App\Services\Api;

use App\Models\CleaningService;
use App\Models\Security;
use App\Models\User;
use App\Models\UserCleaningService;
use App\Models\UserSecurity;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Switches a worker account between the Security and Cleaning Service roles.
 *
 * The inactive profile is only detached from the active role; its rows, files,
 * certificates, histories, and applications stay untouched so switching back
 * restores everything.
 */
class RoleSwitchService
{
    public const ROLES = ['security', 'cs'];

    private const DATABASE_ROLES = [
        'security' => 'satpam',
        'cs' => 'cs',
    ];

    /**
     * @return array{role: string, profile: array}
     */
    public function switch(User $user, string $role): array
    {
        $targetRole = self::DATABASE_ROLES[$role] ?? null;

        if ($targetRole === null) {
            throw ValidationException::withMessages([
                'role' => 'Role harus security atau cs.',
            ]);
        }

        if (! in_array($user->role, ['satpam', 'cs'], true)) {
            throw new AccessDeniedHttpException(
                'Hanya akun security atau cleaning service yang dapat mengganti role.',
            );
        }

        DB::transaction(function () use ($user, $targetRole): void {
            $this->ensureProfile($user, $targetRole);

            if ($user->role !== $targetRole) {
                $user->forceFill(['role' => $targetRole])->save();
            }
        });

        $user->refresh();
        $profile = $targetRole === 'satpam'
            ? $user->user_security?->security
            : $user->user_cleaning_service?->cleaning_service;

        if ($profile === null) {
            throw new NotFoundHttpException('Profil tidak ditemukan.');
        }

        return [
            'role' => $role,
            'profile' => $targetRole === 'satpam'
                ? app(ProfileService::class)->showSecurity($profile)
                : app(ProfileService::class)->showCleaning($profile),
        ];
    }

    private function ensureProfile(User $user, string $databaseRole): void
    {
        if ($databaseRole === 'satpam') {
            $relationship = $user->user_security()->first()
                ?? UserSecurity::create(['user_id' => $user->id]);

            if (! $relationship->security()->exists()) {
                Security::create([
                    'user_security_id' => $relationship->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone_number' => $user->phone_number,
                ]);
            }

            return;
        }

        $relationship = $user->user_cleaning_service()->first()
            ?? UserCleaningService::create(['user_id' => $user->id]);

        if (! $relationship->cleaning_service()->exists()) {
            CleaningService::create([
                'user_cleaning_service_id' => $relationship->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone_number' => $user->phone_number,
            ]);
        }
    }
}
