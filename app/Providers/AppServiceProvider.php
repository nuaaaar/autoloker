<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;
use LogicException;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $response = static function (Request $request, array $headers) {
            $message = 'Terlalu banyak permintaan. Silakan coba kembali nanti.';

            return $request->is('api/*')
                ? response()->json(['status' => false, 'message' => $message], 429, $headers)
                : response($message, 429, $headers);
        };

        RateLimiter::for('password-reset-request', static fn (Request $request) => Limit::perMinute(5)
            ->by('password-reset-request:'.$request->ip())
            ->response($response));

        RateLimiter::for('password-reset-submit', static fn (Request $request) => Limit::perMinute(10)
            ->by('password-reset-submit:'.$request->ip())
            ->response($response));

        ResetPassword::createUrlUsing(static function (User $user, string $token): string {
            $origin = (string) config('app.url');
            $parts = parse_url($origin);
            $secure = is_array($parts) && ($parts['scheme'] ?? null) === 'https';
            $localHttp = app()->environment(['local', 'testing']) && is_array($parts) && ($parts['scheme'] ?? null) === 'http';

            if (! is_array($parts) || empty($parts['host']) || isset($parts['user']) || isset($parts['pass'])
                || isset($parts['query']) || isset($parts['fragment']) || (! $secure && ! $localHttp)) {
                throw new LogicException('Invalid password reset origin configuration.');
            }

            return rtrim($origin, '/').route('password.reset', [
                'token' => $token,
                'email' => $user->getEmailForPasswordReset(),
            ], false);
        });
    }
}
