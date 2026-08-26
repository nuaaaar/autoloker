<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Security;
use App\Models\UserSecurity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterSecurityController extends Controller
{
    public function registerSecurity(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'name' => [
                'required',
                'string',
                'min:3',
                'max:100'
            ],

            'email' => [
                'required',
                'email:rfc,dns',
                'max:100',
                'unique:users,email'
            ],

            'phone_number' => [
                'required',
                'digits_between:10,15',
                'unique:users,phone_number'
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'max:50',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
            ],

            'agree' => [
                'accepted'
            ]

        ], [

            'name.required' => 'Nama lengkap wajib diisi.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',

            'phone_number.required' => 'Nomor WhatsApp wajib diisi.',
            'phone_number.unique' => 'Nomor WhatsApp sudah terdaftar.',

            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sama.',
            'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, dan angka.',

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

            $phone = preg_replace('/[^0-9]/', '', $data['phone_number']);

            if (str_starts_with($phone, '0')) {
                $phone = '62' . substr($phone, 1);
            }

            $user = User::create([

                'name' => $data['name'],

                'email' => strtolower($data['email']),

                'phone_number' => $phone,

                'password' => Hash::make($data['password']),

                'role' => 'satpam',

                'status' => 'active',

            ]);

            $userSecurity = UserSecurity::create([
                'user_id' => $user->id,
            ]);

            Security::create([
                'user_security_id' => $userSecurity->id,
                'phone_number' => $user->phone_number,
                'email' => $user->email,
                'name' => $user->name
            ]);

            // Login otomatis
            Auth::login($user);

            $request->session()->regenerate();

            DB::commit();

            return response()->json([
                'status'   => true,
                'message'  => 'Pendaftaran berhasil.',
                'redirect' => route('user-page.home')
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Pendaftaran berhasil. Silakan lakukan verifikasi akun Anda.'
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
