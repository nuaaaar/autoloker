<?php

namespace App\Http\Controllers\UserPage;

use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;
use Laravolt\Indonesia\Models\City;
use App\Http\Controllers\Controller;
use App\Models\SecurityCertificate;
use App\Models\SecurityHistory;
use Illuminate\Http\Request;
use App\Models\Security;
use Storage;
use Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $data['security'] = Security::find(Auth::user()->user_security->security->id);
        $data['profile_progress'] = $data['security']->profileProgress();
        $data['security_certificates'] = SecurityCertificate::where('security_id', $data['security']->id)->orderBy('expired_date', 'asc')->get();
        $data['security_histories'] = SecurityHistory::where('security_id', $data['security']->id)->orderBy('start_date', 'desc')->get();

        return view('user-page.profile.index', $data);
    }

    public function editPersonalData($id)
    {
        $data['data'] = Security::where('uuid', $id)->first();

        $data['province'] = Province::where('name', $data['data']->province)->first();
        $data['city']      = City::where('name', $data['data']->city)->first();
        $data['district'] = District::where('name', $data['data']->district)
            ->where('city_code', $data['city']?->code)
            ->first();

        $data['village'] = Village::where('name', $data['data']->village)
            ->where('district_code', $data['district']?->code)
            ->first();

        if (!$data['data']) {
            return redirect()->route('user-page.home')
            ->with('swal', [
                'icon'  => 'error',
                'title' => 'Error',
                'text'  => 'Data Diri tidak ditemukan, coba lagi nanti.'
            ]);
        }

        return view('user-page.profile.edit', $data);
    }

    public function updatePersonalData($id, Request $request)
    {
        $security = Security::where('uuid', $id)->first();
        if (!$security) {
            return redirect()->route('user-page.home')
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

            if ($security->formal_photo &&
                Storage::disk('public')->exists($security->formal_photo)) {

                Storage::disk('public')->delete($security->formal_photo);

            }

            $data['formal_photo'] = $request
                ->file('formal_photo')
                ->store('formal-photo', 'public');
        }

        $province = Province::where('code', $request->province)->first();
        $city = City::where('code', $request->city)->first();
        $district = District::where('code', $request->district)->first();
        $village = Village::where('code', $request->village)->first();

        /*
        |--------------------------------------------------------------------------
        | Data
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

        $data['is_out_of_town_agree'] = $request->boolean('is_out_of_town_agree');
        $data['is_shift_agree'] = $request->boolean('is_shift_agree');

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

        $security->update($data);

        return redirect()
            ->back()
            ->with('swal', [
                'icon'  => 'success',
                'title' => 'Berhasil',
                'text'  => 'Berhasil Mengubah data diri.'
            ]);;
    }
}
