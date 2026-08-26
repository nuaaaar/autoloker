<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\UserCompany;
use App\Models\Company;
use App\Models\User;

class RegisterCompanyController extends Controller
{
    public function registerCompany(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'name' => [
                'required',
                'string',
                'min:3',
                'max:150'
            ],

            'email' => [
                'required',
                'email:rfc,dns',
                'max:100',
                'unique:users,email'
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'max:50',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
            ],

            'nib' => [
                'nullable',
                'unique:user_companies,nib'
            ],

            'agree' => [
                'accepted'
            ]

        ], [

            'name.required' => 'Nama perusahaan wajib diisi.',

            'email.required' => 'Email perusahaan wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',

            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sama.',
            'password.regex' => 'Password harus mengandung huruf besar, huruf kecil dan angka.',

            'nib.digits' => 'NIB harus terdiri dari 13 digit.',
            'nib.unique' => 'NIB sudah terdaftar.',

            'agree.accepted' => 'Anda harus menyetujui syarat dan ketentuan.'

        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
                'message' => 'Validasi gagal.'
            ], 422);

        }

        DB::beginTransaction();

        try {

            $data = $validator->validated();

            $user = User::create([

                'name' => $data['name'],

                'email' => strtolower($data['email']),

                'password' => Hash::make($data['password']),

                'role' => 'company',

                'status' => 'active',

            ]);

            $userCompany = UserCompany::create([
                'user_id' => $user->id,
            ]);

            Company::create([
                'user_company_id' => $userCompany->id,
                'company_name' => $data['name'],
                'nib' => $data['nib'],
                'email' => strtolower($data['email']),
            ]);

            DB::commit();

            Auth::login($user);

            $request->session()->regenerate();

            return response()->json([
                'status'   => true,
                'message'  => 'Pendaftaran perusahaan berhasil.',
                'redirect' => route('dashboard-user.index')
            ]);

        } catch (\Throwable $e) {

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => config('app.debug')
                    ? $e->getMessage()
                    : 'Terjadi kesalahan saat proses pendaftaran.'
            ], 500);

        }
    }
}
