<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use App\Http\Resources\MasterResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $searchValue = $request->input('search.value');
            $orderColumn = $request->input('order.0.column') ?? 0;
            $orderSort = $request->input('order.0.dir') ?? 'asc';
            $orderValue  = $request->input('columns.' . $orderColumn . '.data') ?? 'id';
            //get data
            $data = User::where('role', 'admin')->when($searchValue, function($q) use($searchValue) {
                $q->orWhere('name', 'like', '%' . $searchValue . '%');
                $q->orWhere('email', 'like', '%' . $searchValue . '%');
            })
            ->orderBy($orderValue, $orderSort)->paginate($request->length ?? 10);

            //return with Api Resource
            return new MasterResource(true, '00', 'List Data', $data);
        }

        return view('dashboard-admin.management-user.admin.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[a-z]/',      // Huruf kecil
                'regex:/[A-Z]/',      // Huruf besar
                'regex:/[0-9]/',      // Angka
                'regex:/[@$!%*#?&]/', // Simbol
            ],

        ], [

            // Nama
            'name.required' => 'Nama wajib diisi.',
            'name.max' => 'Nama maksimal 255 karakter.',

            // Email
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'email.max' => 'Email maksimal 255 karakter.',

            // Password
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'password.min' => 'Password minimal terdiri dari 8 karakter.',

            'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan simbol.',

        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);

        }

        User::create([
            'role' => 'admin',
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'status' => 'active'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil ditambahkan.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        $user = User::where('uuid', $uuid)->firstOrFail();

        $validator = Validator::make($request->all(), [

            'name' => 'required|max:255',

            'email' => 'required|email|max:255|unique:users,email,'.$user->id,

            'password' => 'nullable|confirmed|min:8',

        ], [

            'name.required' => 'Nama wajib diisi.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',

            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'password.min' => 'Password minimal 8 karakter.',

        ]);

        /*
        |--------------------------------------------------------------------------
        | Validasi Password
        |--------------------------------------------------------------------------
        */

        $validator->after(function($validator) use ($request){

            if(!$request->filled('password')){
                return;
            }

            $password=$request->password;

            if(!preg_match('/[a-z]/',$password)){
                $validator->errors()->add('password','Password harus memiliki huruf kecil.');
            }

            if(!preg_match('/[A-Z]/',$password)){
                $validator->errors()->add('password','Password harus memiliki huruf besar.');
            }

            if(!preg_match('/[0-9]/',$password)){
                $validator->errors()->add('password','Password harus memiliki angka.');
            }

            if(!preg_match('/[@$!%*#?&]/',$password)){
                $validator->errors()->add('password','Password harus memiliki simbol.');
            }

        });

        if($validator->fails()){

            return response()->json([

                'status'=>false,

                'errors'=>$validator->errors()

            ],422);

        }

        $user->name = $request->name;

        $user->email = $request->email;

        if($request->filled('password')){

            $user->password = Hash::make($request->password);

        }

        $user->save();

        return response()->json([

            'status'=>true,

            'message'=>'Data admin berhasil diperbarui.'

        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = User::where('uuid', $id)->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        $data->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus.'
        ]);
    }
}
