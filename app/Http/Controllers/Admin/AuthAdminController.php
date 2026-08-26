<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class AuthAdminController extends Controller
{
    public function signInAdmin(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt([
            'email'    => $request->email,
            'password' => $request->password
        ], $request->filled('remember'))) {

            return back()
            ->with('swal', [
                'icon'  => 'warning',
                'title' => 'Gagal login',
                'text'  => 'Email / Password salah.'
            ]);
        }

        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Tolak Role User
        |--------------------------------------------------------------------------
        */

        if (in_array($user->role, ['satpam', 'bujp', 'company'])) {

            Auth::logout();

            return back()
            ->with('swal', [
                'icon'  => 'warning',
                'title' => 'Gagal login',
                'text'  => 'Email / Password salah.'
            ]);
        }

        $request->session()->regenerate();

        return redirect()->route('dashboard-admin.index');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json([
            'status'   => true,
            'message'  => 'Berhasil logout.',
            'redirect' => route('lgn-admn')
        ]);
    }
}
