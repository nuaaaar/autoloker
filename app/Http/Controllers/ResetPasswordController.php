<?php

namespace App\Http\Controllers;

use App\Models\ApiToken;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request, $token)
    {
        $email = $request->query('email');

        if (! is_string($email) || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->route('login')->with([
                'forgot_error' => 'Link reset password tidak valid atau sudah kedaluwarsa.',
                'show_forgot_modal' => true,
            ]);
        }

        return view('auth.passwords.reset', compact('token', 'email'));
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = null;
        $status = DB::transaction(function () use ($request, &$user) {
            User::query()->where('email', $request->input('email'))->lockForUpdate()->first();

            return Password::broker('users')->reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function (User $resetUser, string $password) use (&$user): void {
                    $resetUser->forceFill([
                        'password' => Hash::make($password),
                        'remember_token' => Str::random(60),
                        'has_local_password' => true,
                    ])->save();

                    ApiToken::query()->where('user_id', $resetUser->id)->whereNull('revoked_at')->update([
                        'revoked_at' => now(),
                    ]);

                    $sessionConnection = config('session.connection') ?: config('database.default');
                    DB::connection($sessionConnection)->table(config('session.table'))
                        ->where('user_id', $resetUser->id)->delete();

                    $user = $resetUser;
                }
            );
        });

        if ($status === Password::PASSWORD_RESET) {
            event(new PasswordReset($user));

            return redirect()
                ->route('login')
                ->with('status', 'Password berhasil diperbarui. Silakan login kembali.');
        }

        return back()->withErrors([
            'email' => 'Link reset password tidak valid atau sudah kedaluwarsa.',
        ]);
    }
}