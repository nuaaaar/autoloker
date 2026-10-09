<?php

namespace App\Services\Api;

use App\Models\Company;
use App\Models\Security;
use App\Models\User;
use App\Models\UserCompany;
use App\Models\UserSecurity;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegistrationService
{
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
                'company' => $this->createCompany($user, $data),
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
            'phone_number' => $data['phone_number'],
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
