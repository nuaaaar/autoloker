<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileReady
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {

            return redirect()
                ->route('login')
                ->with('swal', [

                    'icon'  => 'error',
                    'title' => 'Akses Ditolak',
                    'text'  => 'Silakan login terlebih dahulu.'

                ]);

        }


        /*
        |--------------------------------------------------------------------------
        | AMBIL PROFILE
        |--------------------------------------------------------------------------
        */

        $profile = match ($user->role) {

            'bujp'    => $user->user_bujp->bujp,

            'company' => $user->user_company->company,

            default   => null,

        };


        /*
        |--------------------------------------------------------------------------
        | PROFILE TIDAK DITEMUKAN
        |--------------------------------------------------------------------------
        */

        if (!$profile) {

            return redirect()
                ->route('dashboard-user.profile.index')
                ->with('swal', [

                    'icon'  => 'error',
                    'title' => 'Profil Tidak Ditemukan',
                    'text'  => 'Data profil Anda tidak ditemukan, coba lagi nanti.'

                ]);

        }


        /*
        |--------------------------------------------------------------------------
        | CEK KELENGKAPAN PROFILE
        |--------------------------------------------------------------------------
        */

        $progress = $profile->profileProgress();


        if ($progress['progress'] < 100) {

            return redirect()
                ->route('dashboard-user.profile.index')
                ->with('swal', [

                    'icon'  => 'warning',
                    'title' => 'Profil Belum Lengkap',
                    'text'  => 'Silakan lengkapi profil Anda terlebih dahulu sebelum mengakses fitur ini.'

                ]);

        }


        /*
        |--------------------------------------------------------------------------
        | CEK STATUS VERIFIKASI
        |--------------------------------------------------------------------------
        */

        if (!$profile->is_verified) {

            return redirect()
                ->route('dashboard-user.profile.index')
                ->with('swal', [

                    'icon'  => 'warning',
                    'title' => 'Profil Belum Terverifikasi',
                    'text'  => 'Profil Anda sudah lengkap, namun masih menunggu proses verifikasi administrator.'

                ]);

        }


        /*
        |--------------------------------------------------------------------------
        | PROFILE SIAP
        |--------------------------------------------------------------------------
        */

        return $next($request);
    }
}