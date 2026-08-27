<?php

namespace App\Services\Api;

use App\Models\ApiToken;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TokenService
{
    public function issue(User $user): array
    {
        $accessToken = Str::random(80);
        $refreshToken = Str::random(100);

        ApiToken::create([
            'user_id' => $user->id,
            'access_token_hash' => hash('sha256', $accessToken),
            'refresh_token_hash' => hash('sha256', $refreshToken),
            'access_expires_at' => now()->addHour(),
            'refresh_expires_at' => now()->addDays(30),
        ]);

        return $this->payload($accessToken, $refreshToken);
    }

    public function refresh(string $plainRefreshToken): array
    {
        return DB::transaction(function () use ($plainRefreshToken): array {
            $token = ApiToken::where('refresh_token_hash', hash('sha256', $plainRefreshToken))
                ->lockForUpdate()
                ->first();

            if (!$token || !$token->isRefreshValid() || $token->user->status !== 'active') {
                throw new \InvalidArgumentException('Invalid refresh token.');
            }

            $token->update(['revoked_at' => now()]);
            return $this->issue($token->user);
        });
    }

    public function revoke(ApiToken $token): void
    {
        $token->update(['revoked_at' => now()]);
    }

    private function payload(string $accessToken, string $refreshToken): array
    {
        return [
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
            'token_type' => 'Bearer',
            'expires_in' => 3600,
        ];
    }
}
