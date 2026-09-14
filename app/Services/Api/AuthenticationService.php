<?php

namespace App\Services\Api;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class AuthenticationService
{
    public function __construct(private readonly TokenService $tokens) {}

    public function login(array $data): array
    {
        $key = 'api-login:'.strtolower($data['identifier']).'|'.$this->requestIp();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            throw ValidationException::withMessages(['identifier' => 'Too many login attempts.']);
        }

        $user = User::where(function ($query) use ($data) {
            $query->where('email', $data['identifier'])
                ->orWhere('phone_number', $data['identifier']);
        })->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            RateLimiter::hit($key, 60);
            throw ValidationException::withMessages(['identifier' => 'Invalid credentials.']);
        }

        RateLimiter::clear($key);

        if ($user->status !== 'active') {
            throw ValidationException::withMessages(['identifier' => 'Account is inactive.']);
        }

        $expectedRole = $data['role'] === 'security' ? 'satpam' : $data['role'];
        if ($user->role !== $expectedRole) {
            throw ValidationException::withMessages(['role' => 'Account role does not match.']);
        }

        return [
            'tokens' => $this->tokens->issue($user),
            'user' => $this->userData($user),
        ];
    }

    public function changePassword(User $user, array $data): void
    {
        if ($user->has_local_password && ! Hash::check($data['current_password'], $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'Current password is incorrect.',
            ]);
        }

        $user->update([
            'password' => Hash::make($data['password']),
            'has_local_password' => true,
        ]);
    }

    public function userData(User $user): array
    {
        $profile = match ($user->role) {
            'satpam' => $user->user_security?->security,
            'company' => $user->user_company?->company,
            'bujp' => $user->user_bujp?->bujp,
            default => null,
        };

        $profileData = null;
        if ($profile) {
            $profileData = [
                'type' => $user->role === 'satpam' ? 'security' : $user->role,
                'id' => $profile->id,
                'uuid' => $profile->uuid,
                'profile_completion' => $profile->profileProgress(),
                'is_verified' => $user->role === 'satpam' ? null : (bool) $profile->is_verified,
                'is_active' => $user->role === 'satpam' ? $user->status === 'active' : (bool) $profile->is_active,
            ];
        }

        $verified = $profileData && $profileData['is_verified'] !== false;
        $complete = $profileData && $profileData['profile_completion']['progress'] === 100;

        return [
            'id' => $user->id,
            'uuid' => $user->uuid,
            'role' => $user->role,
            'name' => $user->name,
            'email' => $user->email,
            'phone_number' => $user->phone_number,
            'avatar' => $user->avatar,
            'status' => $user->status,
            'email_verified' => $user->email_verified_at !== null,
            'has_local_password' => (bool) $user->has_local_password,
            'profile' => $profileData,
            'capabilities' => [
                'profile_complete' => (bool) $complete,
                'profile_verified' => (bool) $verified,
                'can_access_protected_features' => (bool) ($complete && $verified && ($profileData['is_active'] ?? false)),
            ],
        ];
    }

    private function requestIp(): string
    {
        return app('request')->ip() ?? 'unknown';
    }
}
