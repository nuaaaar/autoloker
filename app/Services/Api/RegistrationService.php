<?php

namespace App\Services\Api;

use App\Models\Company;
use App\Models\Security;
use App\Models\User;
use App\Models\UserCompany;
use App\Models\UserSecurity;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class RegistrationService
{
    public function __construct(private readonly RoleSwitchService $roles) {}

    public function register(array $data): User
    {
        return DB::transaction(function () use ($data): User {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone_number' => $data['phone_number'] ?? null,
                'google_id' => '',
                'password' => Hash::make($data['password']),
                'role' => $this->databaseRole($data['role']),
                'status' => 'active',
            ]);

            match ($data['role']) {
                'security' => $this->createSecurity($user, $data),
                'cs' => $this->roles->switch($user, 'cs'),
                'company' => $this->createCompany($user, $data),
            };

            return $user;
        });
    }

    public function registerGoogle(array $identity, string $role): User
    {
        return DB::transaction(function () use ($identity, $role): User {
            if (User::where('email', $identity['email'])->exists()) {
                throw ValidationException::withMessages(['email' => 'Email sudah terdaftar. Silakan login menggunakan akun tersebut.']);
            }
            if (User::where('google_id', $identity['google_id'])->exists()) {
                throw ValidationException::withMessages(['id_token' => 'Akun Google sudah terdaftar. Silakan login.']);
            }

            $user = User::create([
                'name' => $identity['name'],
                'email' => $identity['email'],
                'phone_number' => null,
                'google_id' => $identity['google_id'],
                'avatar' => $identity['avatar'],
                'password' => Hash::make(Str::random(32)),
                'has_local_password' => false,
                'email_verified_at' => now(),
                'role' => $this->databaseRole($role),
                'status' => 'active',
            ]);

            match ($role) {
                'security' => $this->createSecurity($user, ['phone_number' => null]),
                'cs' => $this->roles->switch($user, 'cs'),
                'company' => $this->createCompany($user, ['name' => $identity['name']]),
            };

            return $user;
        });
    }

    private function databaseRole(string $role): string
    {
        return $role === 'security' ? 'satpam' : $role;
    }

    private function createSecurity(User $user, array $data): void
    {
        $userSecurity = UserSecurity::create([
            'user_id' => $user->id,
        ]);

        Security::create([
            'user_security_id' => $userSecurity->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone_number' => $data['phone_number'] ?? null,
        ]);
    }

    private function createCompany(User $user, array $data): void
    {
        $userCompany = UserCompany::create([
            'user_id' => $user->id,
        ]);

        Company::create([
            'user_company_id' => $userCompany->id,
            'company_name' => $data['name'],
            'email' => $user->email,
            'nib' => $data['nib'] ?? null,
        ]);
    }
}
