<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\UserSecurity;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\UserCompany;
use App\Models\UserBUJP;
use App\Models\Security;
use App\Models\Company;
use App\Models\BUJP;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'role'     => 'required|in:satpam,company',
            'email'    => 'required',
            'password' => 'required',
        ]);

        $login = trim($request->email);

        // Cari berdasarkan email ATAU nomor HP
        $user = User::where('email', $login)
                    ->orWhere('phone_number', $login)
                    ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {

            return response()->json([
                'status'  => false,
                'message' => 'Email/No. WhatsApp atau password salah.',
            ], 422);

        }

        // Cek role
        $allowedRoles = [
            'satpam' => ['satpam'],
            'company' => ['company', 'bujp'],
        ];

        if (!in_array($user->role, $allowedRoles[$request->role])) {

            return response()->json([
                'status'  => false,
                'message' => 'Akun tidak sesuai dengan jenis login yang dipilih.',
            ], 422);

        }

        Auth::login($user);

        $request->session()->regenerate();

        $redirect = route('user-page.home');

        if (Auth::user()->role == 'satpam') {

            $redirect = route('user-page.home');

        } elseif (in_array(Auth::user()->role, ['bujp', 'company'])) {

            $redirect = route('dashboard-user.index');

        }

        return response()->json([
            'status'   => true,
            'message'  => 'Login berhasil.',
            'redirect' => $redirect,
        ]);
    }

    public function redirectGoogle(Request $request)
    {
        session([
            'google_login_role' => $request->role,
            'google_login_action' => $request->action,
        ]);

        return Socialite::driver('google')->redirect();
    }

    public function callbackGoogle()
    {
        try {

            $role   = session('google_login_role');
            $action = session('google_login_action');

            $googleUser = Socialite::driver('google')->user();

            $user = User::where('google_id', '!=', null)->where('email', $googleUser->email)->first();

            /**
             * =====================================
             * REGISTER GOOGLE
             * =====================================
             */
            if ($action == 'register') {

                $user = User::where('email', $googleUser->email)->first();

                if ($user) {

                    session()->forget([
                        'google_login_role',
                        'google_login_action'
                    ]);

                    return redirect()
                        ->route('login')
                        ->with('swal', [
                            'icon'  => 'warning',
                            'title' => 'Email Sudah Terdaftar',
                            'text'  => 'Silakan login menggunakan akun tersebut.'
                        ]);

                }

                $user = User::create([

                    'name'          => $googleUser->name,
                    'email'         => $googleUser->email,
                    'google_id'     => $googleUser->id,
                    'avatar'        => $googleUser->avatar,
                    'password'      => Hash::make(Str::random(20)),
                    'role'          => $role,
                    'status'        => 'active',
                    'email_verified_at' => date('Y-m-d H:i:s')

                ]);

                Auth::login($user);

                request()->session()->regenerate();

                session()->forget([
                    'google_login_role',
                    'google_login_action'
                ]);

                // Company diarahkan ke lengkapi profil
                if ($role == 'company') {

                    $userCompany = UserCompany::create([
                        'user_id' => $user->id
                    ]);

                    Company::create([
                        'user_company_id' => $userCompany->id
                    ]);

                    return redirect()->route('dashboard-user.index');

                } elseif($role == 'satpam') {

                    $userSecurity = UserSecurity::create([
                        'user_id' => $user->id
                    ]);

                    Security::create([
                        'user_security_id' => $userSecurity->id
                    ]);
                    
                    // Satpam diarahkan ke lengkapi profil
                    // return redirect()->route('security.complete-profile');

                    return redirect()->route('user-page.home');
                } elseif($role == 'bujp') {

                    $userBUJP = UserBUJP::create([
                        'user_id' => $user->id
                    ]);

                    BUJP::create([
                        'user_b_u_j_p_id' => $userBUJP->id
                    ]);

                    return redirect()->route('dashboard-user.index');
                }


            }

            /**
             * =====================================
             * LOGIN GOOGLE
             * =====================================
             */

            if (!$user) {

                session()->forget([
                    'google_login_role',
                    'google_login_action'
                ]);

                return redirect()
                    ->route('login')
                    ->with('swal', [
                        'icon'  => 'warning',
                        'title' => 'Akun Belum Terdaftar',
                        'text'  => 'Email Google Anda belum terdaftar.'
                    ]);

            }

            $allowedRoles = [
                'satpam' => ['satpam'],
                'company' => ['company', 'bujp'],
            ];

            if (!in_array($user->role, $allowedRoles[$role])) {

                session()->forget([
                    'google_login_role',
                    'google_login_action'
                ]);

                return redirect()
                    ->route('login')
                    ->with('swal', [
                        'icon'  => 'error',
                        'title' => 'Role Tidak Sesuai',
                        'text'  => $role === 'company'
                            ? 'Akun Google ini bukan akun Perusahaan/BUJP.'
                            : 'Akun Google ini bukan akun Satpam.'
                    ]);

            }

            if (empty($user->google_id)) {

                $user->update([
                    'google_id' => $googleUser->id,
                    'avatar'    => $googleUser->avatar
                ]);

            }

            Auth::login($user);

            request()->session()->regenerate();

            session()->forget([
                'google_login_role',
                'google_login_action'
            ]);

            if (Auth::user()->role == 'satpam') {

                return redirect()->route('user-page.home');

            } elseif (in_array(Auth::user()->role, ['bujp', 'company'])) {

                return redirect()->route('dashboard-user.index');

            }

        } catch (\Exception $e) {

            session()->forget([
                'google_login_role',
                'google_login_action'
            ]);

            return redirect()
                ->route('login')
                ->with('swal', [
                    'icon'  => 'error',
                    'title' => 'Google Gagal',
                    'text'  => 'Terjadi kesalahan saat autentikasi Google.'
                ]);

        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json([
            'status'   => true,
            'message'  => 'Berhasil logout.',
            'redirect' => route('login')
        ]);
    }
}