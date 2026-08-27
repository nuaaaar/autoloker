<?php

namespace App\Services\Api;

use App\Models\BUJP;
use App\Models\Company;
use App\Models\Security;
use App\Models\User;
use App\Models\UserBUJP;
use App\Models\UserCompany;
use App\Models\UserSecurity;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class RegistrationService
{
    public function register(array $data): User
    {
        $storedPath = null;

        try {
            return DB::transaction(function () use ($data, &$storedPath): User {
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
                    'bujp' => $this->createBujp($user, $data, $storedPath),
                };

                return $user;
            });
        } catch (\Throwable $exception) {
            if ($storedPath !== null) {
                Storage::disk('public')->delete($storedPath);
            }

            throw $exception;
        }
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

    private function createBujp(User $user, array $data, ?string &$storedPath): void
    {
        /** @var UploadedFile $file */
        $file = $data['sio_file'];
        $storedPath = $file->store('sio-file', 'public');

        $userBujp = UserBUJP::create([
            'user_id' => $user->id,
        ]);

        BUJP::create([
            'user_b_u_j_p_id' => $userBujp->id,
            'company_name' => $data['name'],
            'email' => $user->email,
            'nib' => $data['nib'] ?? null,
            'sio_number' => $data['sio_number'],
            'sio_expired_date' => $data['sio_expired_date'],
            'sio_file' => $storedPath,
        ]);
    }
}
