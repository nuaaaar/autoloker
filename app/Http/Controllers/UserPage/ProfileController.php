<?php

namespace App\Http\Controllers\UserPage;

use App\Models\CleaningServiceCertificate;
use App\Models\CleaningServiceHistory;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;
use Laravolt\Indonesia\Models\City;
use App\Http\Controllers\Controller;
use App\Models\SecurityCertificate;
use App\Models\UserCleaningService;
use App\Models\MasterPlacement;
use App\Models\SecurityHistory;
use App\Models\MasterAbility;
use App\Models\CleaningService;
use Illuminate\Http\Request;
use App\Models\Security;
use App\Models\User;
use Storage;
use Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Tentukan Profile Berdasarkan Role
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'satpam') {

            $profile = Security::find(
                $user->user_security->security->id
            );

            if (!$profile) {
                return redirect()
                    ->route('user-page.home')
                    ->with('swal', [
                        'icon'  => 'error',
                        'title' => 'Error',
                        'text'  => 'Data Diri tidak ditemukan, coba lagi nanti.'
                    ]);
            }

            $data['security'] = $profile;

            $data['profile_progress'] = $profile->profileProgress();

            $data['security_certificates'] = SecurityCertificate::where(
                'security_id',
                $profile->id
            )
                ->orderBy('expired_date', 'asc')
                ->get();

            $data['security_histories'] = SecurityHistory::where(
                'security_id',
                $profile->id
            )
                ->orderBy('start_date', 'desc')
                ->get();

        } elseif ($user->role === 'cs') {

            $profile = CleaningService::find(
                $user->user_cleaning_service->cleaning_service->id
            );

            if (!$profile) {
                return redirect()
                    ->route('user-page.home')
                    ->with('swal', [
                        'icon'  => 'error',
                        'title' => 'Error',
                        'text'  => 'Data Diri tidak ditemukan, coba lagi nanti.'
                    ]);
            }

            $data['security'] = $profile;

            $data['profile_progress'] = $profile->profileProgress();

            $data['security_certificates'] = CleaningServiceCertificate::where(
                'cleaning_service_id',
                $profile->id
            )
                ->orderBy('expired_date', 'asc')
                ->get();

            $data['security_histories'] = CleaningServiceHistory::where(
                'cleaning_service_id',
                $profile->id
            )
                ->orderBy('start_date', 'desc')
                ->get();

        } else {

            return redirect()
                ->route('user-page.home')
                ->with('swal', [
                    'icon'  => 'error',
                    'title' => 'Error',
                    'text'  => 'Role tidak valid.'
                ]);
        }

        return view('user-page.profile.index', $data);
    }


    public function editPersonalData($id)
    {
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Tentukan Model Berdasarkan Role
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'satpam') {

            $profile = Security::where('uuid', $id)->first();

        } elseif ($user->role === 'cs') {

            $profile = CleaningService::where('uuid', $id)->first();

        } else {

            return redirect()
                ->route('user-page.home')
                ->with('swal', [
                    'icon'  => 'error',
                    'title' => 'Error',
                    'text'  => 'Role tidak valid.'
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Cek Data
        |--------------------------------------------------------------------------
        */

        if (!$profile) {
            return redirect()
                ->route('user-page.home')
                ->with('swal', [
                    'icon'  => 'error',
                    'title' => 'Error',
                    'text'  => 'Data Diri tidak ditemukan, coba lagi nanti.'
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Data Wilayah
        |--------------------------------------------------------------------------
        */

        $data['data'] = $profile;

        $data['province'] = Province::where(
            'name',
            $profile->province
        )->first();

        $data['city'] = City::where(
            'name',
            $profile->city
        )->first();

        $data['district'] = District::where(
            'name',
            $profile->district
        )
            ->where('city_code', $data['city']?->code)
            ->first();

        $data['village'] = Village::where(
            'name',
            $profile->village
        )
            ->where('district_code', $data['district']?->code)
            ->first();

        return view('user-page.profile.edit', $data);
    }


    public function updatePersonalData($id, Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);

        // /*
        // |--------------------------------------------------------------------------
        // | Update Role
        // |--------------------------------------------------------------------------
        // */

        // $user->update([
        //     'role' => $request->role
        // ]);

        /*
        |--------------------------------------------------------------------------
        | Tentukan Model Berdasarkan Role
        |--------------------------------------------------------------------------
        */

        if ($request->role === 'satpam') {

            $profile = Security::where('uuid', $id)->first();

            if (!$profile) {
                return redirect()
                    ->route('user-page.home')
                    ->with('swal', [
                        'icon'  => 'error',
                        'title' => 'Error',
                        'text'   => 'Data profil satpam tidak ditemukan.'
                    ]);
            }

        } elseif ($request->role === 'cs') {

            /*
            |--------------------------------------------------------------------------
            | Cari UserCleaningService
            |--------------------------------------------------------------------------
            | Relasi berdasarkan user_id.
            | Ketika register pertama kali, record ini mungkin belum ada.
            */
            $userCleaningService = UserCleaningService::where('user_id', auth()->id())
                ->first();

            /*
            |--------------------------------------------------------------------------
            | Jika belum ada, buat UserCleaningService
            |--------------------------------------------------------------------------
            */
            if (!$userCleaningService) {
                $userCleaningService = UserCleaningService::create([
                    'uuid'    => (string) \Illuminate\Support\Str::uuid(),
                    'user_id' => auth()->id(),
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Cari CleaningService
            |--------------------------------------------------------------------------
            */
            $profile = CleaningService::where(
                'user_cleaning_service_id',
                $userCleaningService->id
            )->first();

            /*
            |--------------------------------------------------------------------------
            | Jika CleaningService belum ada, buat data awal
            |--------------------------------------------------------------------------
            */
            if (!$profile) {
                $profile = CleaningService::create([
                    'uuid'                    => (string) \Illuminate\Support\Str::uuid(),
                    'user_cleaning_service_id' => $userCleaningService->id,
                    'name'                    => auth()->user()->name ?? null,
                    'email'                   => auth()->user()->email ?? null,
                ]);
            }

        } else {

            return redirect()
                ->route('user-page.home')
                ->with('swal', [
                    'icon'  => 'error',
                    'title' => 'Error',
                    'text'   => 'Role tidak valid.'
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Cek Data Profile
        |--------------------------------------------------------------------------
        */

        if (!$profile) {
            return redirect()
                ->route('user-page.home')
                ->with('swal', [
                    'icon'  => 'error',
                    'title' => 'Error',
                    'text'  => 'Data Diri tidak ditemukan, coba lagi nanti.'
                ]);
        }

        $data = [];

        /*
        |--------------------------------------------------------------------------
        | Upload Foto
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('formal_photo')) {

            if (
                $profile->formal_photo &&
                Storage::disk('public')->exists($profile->formal_photo)
            ) {
                Storage::disk('public')->delete(
                    $profile->formal_photo
                );
            }

            $data['formal_photo'] = $request
                ->file('formal_photo')
                ->store('formal-photo', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Data Wilayah
        |--------------------------------------------------------------------------
        */

        $province = Province::where(
            'code',
            $request->province
        )->first();

        $city = City::where(
            'code',
            $request->city
        )->first();

        $district = District::where(
            'code',
            $request->district
        )->first();

        $village = Village::where(
            'code',
            $request->village
        )->first();

        /*
        |--------------------------------------------------------------------------
        | Data Profile
        |--------------------------------------------------------------------------
        */

        $data['name'] = $request->name;
        $data['birth_place'] = $request->birth_place;
        $data['birth_date'] = $request->birth_date;
        $data['gender'] = $request->gender;
        $data['address'] = $request->address;
        $data['phone_number'] = $request->phone_number;
        $data['email'] = $request->email;
        $data['ktp_number'] = $request->ktp_number;
        $data['registration_number'] = $request->registration_number;
        $data['work_experience'] = $request->work_experience;
        $data['height'] = $request->height;
        $data['width'] = $request->width;

        $data['is_out_of_town_agree'] =
            $request->boolean('is_out_of_town_agree');

        $data['is_shift_agree'] =
            $request->boolean('is_shift_agree');

        $data['ability'] = $request->ability;
        $data['placements'] = $request->placements;
        $data['self_description'] = $request->self_description;
        $data['additional_notes'] = $request->additional_notes;
        $data['work_status'] = $request->work_status;
        $data['company_name'] = $request->company_name;
        $data['position'] = $request->position;

        $data['province'] = $province->name ?? '';
        $data['city'] = $city->name ?? '';
        $data['district'] = $district->name ?? '';
        $data['village'] = $village->name ?? '';

        $data['sim'] = is_array($request->sim)
            ? implode(',', $request->sim)
            : $request->sim;

        /*
        |--------------------------------------------------------------------------
        | Update Profile
        |--------------------------------------------------------------------------
        */

        $profile->update($data);

        return redirect()
            ->back()
            ->with('swal', [
                'icon'  => 'success',
                'title' => 'Berhasil',
                'text'  => 'Berhasil Mengubah data diri.'
            ]);
    }

    public function getAbilities($category)
    {
        $category = match ($category) {
            'security' => 'security',
            'cs' => 'cs',
            default => null,
        };

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Role tidak valid.',
            ], 422);
        }

        $abilities = MasterAbility::where('category', $category)
            ->orderBy('title')
            ->get([
                'id',
                'title',
                'category',
            ]);

        return response()->json([
            'success' => true,
            'data' => $abilities,
        ]);
    }

    public function getPlacements($category)
    {
        $category = match ($category) {
            'security' => 'security',
            'cs' => 'cs',
            default => null,
        };

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Role tidak valid.',
            ], 422);
        }

        $palcements = MasterPlacement::where('category', $category)
            ->orderBy('title')
            ->get([
                'id',
                'title',
                'category',
            ]);

        return response()->json([
            'success' => true,
            'data' => $palcements,
        ]);
    }

    public function changeRole(Request $request)
    {
        $request->validate([
            'role' => [
                'required',
                'in:satpam,cs',
            ],
        ]);

        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | CEK JIKA ROLE SAMA
        |--------------------------------------------------------------------------
        */
        if ($user->role === $request->role) {
            return redirect()
                ->back()
                ->with('swal', [
                    'icon'  => 'info',
                    'title' => 'Role Aktif',
                    'text'  => 'Role Anda sudah menggunakan ' .
                        ($request->role === 'satpam'
                            ? 'Satpam'
                            : 'Cleaning Service') . '.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE ROLE USER
        |--------------------------------------------------------------------------
        */
        $user->role = $request->role;
        $user->save();

        /*
        |--------------------------------------------------------------------------
        | JIKA ROLE CLEANING SERVICE
        |--------------------------------------------------------------------------
        |
        | Alur:
        |
        | User
        |   ↓
        | UserCleaningService
        |   ↓
        | CleaningService
        |
        */
        if ($request->role === 'cs') {

            /*
            |--------------------------------------------------------------------------
            | 1. CARI / BUAT USER CLEANING SERVICE
            |--------------------------------------------------------------------------
            */
            $userCleaningService = UserCleaningService::firstOrCreate(
                [
                    'user_id' => $user->id,
                ],
            );

            /*
            |--------------------------------------------------------------------------
            | 2. CARI / BUAT CLEANING SERVICE
            |--------------------------------------------------------------------------
            */
            CleaningService::firstOrCreate(
                [
                    'user_cleaning_service_id' => $userCleaningService->id,
                ],
                [
                    'name'  => $user->name,
                    'email' => $user->email,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | JIKA ROLE SATPAM
        |--------------------------------------------------------------------------
        |
        | Bagian ini tetap menggunakan struktur Security yang sekarang.
        |
        */
        if ($request->role === 'satpam') {

            Security::firstOrCreate(
                [
                    'uuid' => $user->uuid,
                ],
                [
                    'name'  => $user->name,
                    'email' => $user->email,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */
        return redirect()
            ->back()
            ->with('swal', [
                'icon'  => 'success',
                'title' => 'Berhasil',
                'text'  => 'Role berhasil diubah menjadi ' .
                    ($request->role === 'satpam'
                        ? 'Satpam'
                        : 'Cleaning Service') . '.',
            ]);
    }

}
