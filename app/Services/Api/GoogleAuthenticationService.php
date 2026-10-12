<?php

namespace App\Services\Api;

use App\Models\User;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\GoogleProvider;

class GoogleAuthenticationService
{
    public function __construct(
        private readonly AuthenticationService $authentication,
        private readonly RegistrationService $registration,
    ) {}

    public function login(array $data): array
    {
        $identity = $this->verify($data['id_token']);
        $users = User::where('google_id', $identity['google_id'])->limit(2)->get();

        if ($users->isEmpty()) {
            throw ValidationException::withMessages(['id_token' => 'Akun Google belum terdaftar.']);
        }
        if ($users->count() !== 1) {
            throw ValidationException::withMessages(['id_token' => 'Akun Google tidak dapat digunakan untuk login.']);
        }

        return DB::transaction(fn (): array => $this->authentication->authenticate($users->first(), $data['role'], 'id_token'));
    }

    public function register(array $data): array
    {
        $identity = $this->verify($data['id_token']);

        try {
            return DB::transaction(function () use ($identity, $data): array {
                $user = $this->registration->registerGoogle($identity, $data['role']);

                return $this->authentication->authenticate($user, $data['role'], 'id_token');
            });
        } catch (UniqueConstraintViolationException $exception) {
            if (User::where('email', $identity['email'])->exists()) {
                throw ValidationException::withMessages(['email' => 'Email sudah terdaftar. Silakan login menggunakan akun tersebut.']);
            }

            throw $exception;
        }
    }

    private function verify(string $idToken): array
    {
        $clientId = config('services.google.client_id');
        if (! is_string($clientId) || $clientId === '') {
            abort(503);
        }

        if (strlen($idToken) < 101 || strlen($idToken) > 8192 || ! preg_match('/^[A-Za-z0-9_-]+\.[A-Za-z0-9_-]+\.[A-Za-z0-9_-]+$/D', $idToken)) {
            throw ValidationException::withMessages(['id_token' => 'Token Google tidak dapat diverifikasi.']);
        }

        $provider = Socialite::buildProvider(GoogleProvider::class, [
            'client_id' => $clientId,
            'client_secret' => '',
            'redirect' => '',
            'guzzle' => ['connect_timeout' => 5, 'timeout' => 10],
        ])->stateless();

        try {
            $googleUser = $provider->userFromToken($idToken);
        } catch (\Exception) {
            throw ValidationException::withMessages(['id_token' => 'Token Google tidak dapat diverifikasi.']);
        }

        $claims = $googleUser->getRaw();
        if (! is_numeric($claims['exp'] ?? null) || (float) $claims['exp'] <= time()
            || ! is_string($claims['sub'] ?? null) || $claims['sub'] === '' || strlen($claims['sub']) > 255
            || ! is_string($claims['email'] ?? null) || strlen($claims['email']) > 255
            || ! filter_var($claims['email'], FILTER_VALIDATE_EMAIL)
            || ($claims['email_verified'] ?? null) !== true) {
            throw ValidationException::withMessages(['id_token' => 'Token Google tidak dapat diverifikasi.']);
        }

        $email = Str::lower($claims['email']);
        $name = trim(is_string($claims['name'] ?? null) ? $claims['name'] : '');
        $picture = $claims['picture'] ?? null;

        return [
            'google_id' => $claims['sub'],
            'email' => $email,
            'name' => Str::limit($name !== '' ? $name : $email, 255, ''),
            'avatar' => is_string($picture) && $picture !== '' && strlen($picture) <= 255 ? $picture : null,
        ];
    }
}
