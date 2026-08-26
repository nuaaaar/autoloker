<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BUJP;
use App\Models\UserBUJP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RegisterBUJPController extends Controller
{
    public function registerBUJP(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'name' => [
                'required',
                'string',
                'max:150'
            ],

            'email' => [
                'required',
                'email:rfc,dns',
                'unique:users,email',
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
                'digits_between:13,16'
            ],

            'sio_number' => [
                'required',
                'string',
                'max:100'
            ],

            'sio_expired_date' => [
                'required',
                'date',
                'after:today'
            ],

            'sio_file' => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:5120'
            ],

            'agree' => [
                'accepted'
            ]

        ], [

            'name.required' => 'Nama BUJP wajib diisi.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',

            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sama.',
            'password.regex' => 'Password harus mengandung huruf besar, huruf kecil dan angka.',

            'sio_number.required' => 'Nomor SIO wajib diisi.',

            'sio_expired_date.required' => 'Tanggal berlaku wajib diisi.',
            'sio_expired_date.after' => 'Masa berlaku SIO sudah habis.',

            'sio_file.mimes' => 'File harus PDF/JPG/PNG.',
            'sio_file.max' => 'Ukuran file maksimal 5 MB.',

            'agree.accepted' => 'Anda harus menyetujui syarat & ketentuan.'

        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
                'message' => 'Validasi gagal.'
            ],422);

        }

        /*
        |---------------------------------------------------------
        | HARUS SALAH SATU
        |---------------------------------------------------------
        */

        if (!$request->hasFile('sio_file')) {

            return response()->json([
                'status'=>false,
                'message'=>'Upload file SIO.'
            ],422);

        }

        DB::beginTransaction();

        try {

            $path = null;

            if($request->hasFile('sio_file')){

                $path = $request->file('sio_file')
                    ->store('sio-file','public');

            }

            $user = User::create([

                'role' => 'bujp',

                'status' => 'active',

                'password' => Hash::make($request['password']),

                'name' => $request->name,

                'email' => strtolower($request->email),

            ]);

            $bujp = UserBUJP::create([
                'user_id' => $user->id,
            ]);

            BUJP::create([
                'user_b_u_j_p_id' => $bujp->id,

                'company_name' => $request->name,

                'email' => strtolower($request->email),

                'nib' => $request->nib,

                'sio_number' => $request->sio_number,

                'sio_expired_date' => $request->sio_expired_date,

                'sio_file' => $path,
            ]);

            Auth::login($user);

            $request->session()->regenerate();

            DB::commit();

            return response()->json([
                'status'=>true,
                'message'=>'Registrasi berhasil.',
                'redirect'=>route('dashboard-user.index')
            ]);

        } catch (\Throwable $e) {

            DB::rollBack();

            if(isset($path)){
                Storage::disk('public')->delete($path);
            }

            return response()->json([
                'status'=>false,
                'message'=>config('app.debug')
                    ? $e->getMessage()
                    : 'Terjadi kesalahan.'
            ],500);

        }
    }
}
