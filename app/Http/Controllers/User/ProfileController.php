<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Storage;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;
use Laravolt\Indonesia\Models\City;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\BUJP;
use Auth;

class ProfileController extends Controller
{
    public function index()
    {
        if(Auth::user()->role == 'company')
        {
            $data['profile'] = Company::find(Auth::user()->user_company->company->id);
        } elseif(Auth::user()->role == 'bujp') {
            $data['profile'] = BUJP::find(Auth::user()->user_bujp->bujp->id);
        } else {
            return redirect()->route('login');
        }

        return view('dashboard-user.profile.index', $data);
    }

    public function editPersonalData()
    {
        if(Auth::user()->role == 'company')
        {
            $data['data'] = Company::where('id', Auth::user()->user_company->company->id)->first();
        } elseif(Auth::user()->role == 'bujp') {
            $data['data'] = BUJP::where('id', Auth::user()->user_bujp->bujp->id)->first();
        } else {
            return redirect()->route('login');
        }

        $data['province'] = Province::where('name', $data['data']->province)->first();
        $data['city']      = City::where('name', $data['data']->city)->first();
        $data['district'] = District::where('name', $data['data']->district)
            ->where('city_code', $data['city']?->code)
            ->first();

        $data['village'] = Village::where('name', $data['data']->village)
            ->where('district_code', $data['district']?->code)
            ->first();

        if (!$data['data']) {
            return redirect()->route('dashboard-user.index')
            ->with('swal', [
                'icon'  => 'error',
                'title' => 'Error',
                'text'  => 'Data Diri tidak ditemukan, coba lagi nanti.'
            ]);
        }

        return view('dashboard-user.profile.edit', $data);
    }

    public function updatePersonalData($id, Request $request)
    {
        if(Auth::user()->role == 'company')
        {
            $company = Company::where('uuid', $id)->first();
        } else {
            $company = BUJP::where('uuid', $id)->first();
        }

        if (!$company) {
            return redirect()->route('dashboard-user.index')
                ->with('swal', [
                    'icon'  => 'error',
                    'title' => 'Error',
                    'text'  => 'Profil perusahaan tidak ditemukan.'
                ]);

        }

        $request->validate([
            'company_name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
        ]);

        $data = [];

        /*
        |--------------------------------------------------------------------------
        | Upload Logo
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('logo')) {

            if (
                $company->logo &&
                Storage::disk('public')->exists($company->logo)
            ) {

                Storage::disk('public')->delete($company->logo);

            }

            $data['logo'] = $request
                ->file('logo')
                ->store('company-logo', 'public');

        }

        /*
        |--------------------------------------------------------------------------
        | Wilayah Indonesia
        |--------------------------------------------------------------------------
        */

        $province = Province::where('code', $request->province)->first();
        $city = City::where('code', $request->city)->first();
        $district = District::where('code', $request->district)->first();
        $village = Village::where('code', $request->village)->first();

        /*
        |--------------------------------------------------------------------------
        | Data Perusahaan
        |--------------------------------------------------------------------------
        */

        $data['company_name'] = $request->company_name;
        $data['industry'] = $request->industry;
        $data['description'] = $request->description;

        $data['npwp'] = $request->npwp;
        $data['nib'] = $request->nib;
        $data['business_license'] = $request->business_license;

        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['website'] = $request->website;

        $data['province'] = $province->name ?? '';
        $data['city'] = $city->name ?? '';
        $data['district'] = $district->name ?? '';
        $data['village'] = $village->name ?? '';

        $data['postal_code'] = $request->postal_code;
        $data['address'] = $request->address;

        $data['instagram'] = $request->instagram;
        $data['facebook'] = $request->facebook;
        $data['linkedin'] = $request->linkedin;
        $data['youtube'] = $request->youtube;

        if(Auth::user()->role == 'bujp')
        {
            $data['sio_number'] = $request->sio_number;
            $data['sio_expired_date'] = $request->sio_expired_date;

            if ($request->hasFile('sio_file')) {

                if (
                    $company->sio_file &&
                    Storage::disk('public')->exists($company->sio_file)
                ) {

                    Storage::disk('public')->delete($company->sio_file);

                }

                $data['sio_file'] = $request
                    ->file('sio_file')
                    ->store('sio-file', 'public');

            }
        }

        $company->update($data);

        return redirect()->back()->with('swal', [
            'icon'  => 'success',
            'title' => 'Berhasil',
            'text'  => 'Profil perusahaan berhasil diperbarui.'
        ]);
    }
}
;