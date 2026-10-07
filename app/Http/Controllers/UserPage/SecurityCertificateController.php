<?php

namespace App\Http\Controllers\UserPage;

use App\Http\Controllers\Controller;
use App\Models\SecurityCertificate;
use App\Models\CleaningServiceCertificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class SecurityCertificateController extends Controller
{
    /**
     * Mendapatkan profile berdasarkan role user.
     *
     * satpam = Security
     * cs     = CleaningService
     */
    private function getProfile()
    {
        $user = Auth::user();

        if ($user->role === 'satpam') {

            return $user->user_security?->security;

        }

        if ($user->role === 'cs') {

            return $user->user_cleaning_service?->cleaning_service;

        }

        abort(403, 'Role tidak valid.');
    }


    /**
     * Mendapatkan model sertifikat berdasarkan role.
     *
     * satpam = SecurityCertificate
     * cs     = CleaningServiceCertificate
     */
    private function getCertificateModel()
    {
        if (Auth::user()->role === 'satpam') {

            return SecurityCertificate::class;

        }

        if (Auth::user()->role === 'cs') {

            return CleaningServiceCertificate::class;

        }

        abort(403, 'Role tidak valid.');
    }

    /**
     * Store a newly created certificate.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'publisher' => 'required|max:255',
            'certificate_number' => 'required|max:255',
            'category' => 'nullable|max:255',
            'publish_date' => 'required|date',
            'expired_date' => 'required|date|after_or_equal:publish_date',
            'file' => 'nullable|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Profile
        |--------------------------------------------------------------------------
        */

        $profile = $this->getProfile();

        if (!$profile) {

            return response()->json([
                'status' => false,
                'message' => 'Data profile belum tersedia.',
            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | Model
        |--------------------------------------------------------------------------
        */

        $model = $this->getCertificateModel();

        $data = new $model();


        /*
        |--------------------------------------------------------------------------
        | Relasi Profile
        |--------------------------------------------------------------------------
        */

        if (Auth::user()->role === 'satpam') {

            $data->security_id = $profile->id;

        } else {

            $data->cleaning_service_id = $profile->id;

        }


        /*
        |--------------------------------------------------------------------------
        | Data Certificate
        |--------------------------------------------------------------------------
        */

        $data->title = $request->title;

        $data->publisher = $request->publisher;

        $data->certificate_number = $request->certificate_number;


        /*
        |--------------------------------------------------------------------------
        | Category
        |--------------------------------------------------------------------------
        |
        | Category TIDAK mengikuti request.
        |
        | satpam = security
        | cs     = cs
        |
        */

        $data->category = $request->category;


        $data->publish_date = $request->publish_date;

        $data->expired_date = $request->expired_date;


        /*
        |--------------------------------------------------------------------------
        | Upload File
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('file')) {

            $file = $request->file('file');

            $filename = time()
                . '_'
                . $file->getClientOriginalName();

            $file->move(
                public_path('uploads/certificate'),
                $filename
            );

            $data->file = 'uploads/certificate/' . $filename;
        }


        /*
        |--------------------------------------------------------------------------
        | Save
        |--------------------------------------------------------------------------
        */

        $data->save();


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'status' => true,

            'message' => 'Sertifikat berhasil ditambahkan.',

            'data' => [
                'uuid' => $data->uuid,

                'title' => $data->title,

                'publisher' => $data->publisher,

                'certificate_number' => $data->certificate_number,

                'category' => $data->category,

                'publish_date' => Carbon::parse(
                    $data->publish_date
                )->format('d M Y'),

                'expired_date' => Carbon::parse(
                    $data->expired_date
                )->format('d M Y'),

                'file' => $data->file,
            ],
        ]);
    }


    /**
     * Update certificate.
     */
    public function update(Request $request, $uuid)
    {
        $request->validate([
            'title' => 'required|max:255',

            'publisher' => 'required|max:255',

            'certificate_number' => 'required|max:255',

            'category' => 'nullable|max:255',

            'publish_date' => 'required|date',

            'expired_date' => 'required|date|after_or_equal:publish_date',

            'file' => 'nullable|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Profile
        |--------------------------------------------------------------------------
        */

        $profile = $this->getProfile();

        if (!$profile) {

            return response()->json([
                'success' => false,
                'message' => 'Data profile belum tersedia.',
            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | Model
        |--------------------------------------------------------------------------
        */

        $model = $this->getCertificateModel();


        /*
        |--------------------------------------------------------------------------
        | Ambil Certificate Berdasarkan Role
        |--------------------------------------------------------------------------
        */

        if (Auth::user()->role === 'satpam') {

            $certificate = $model::where('uuid', $uuid)
                ->where('security_id', $profile->id)
                ->firstOrFail();

        } else {

            $certificate = $model::where('uuid', $uuid)
                ->where('cleaning_service_id', $profile->id)
                ->firstOrFail();

        }


        /*
        |--------------------------------------------------------------------------
        | Data Update
        |--------------------------------------------------------------------------
        */

        $data = $request->except([
            'file',
            'category',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Category
        |--------------------------------------------------------------------------
        */

        $data['category'] = $request->category;


        /*
        |--------------------------------------------------------------------------
        | Upload File Baru
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('file')) {

            if (
                $certificate->file &&
                Storage::disk('public')->exists(
                    $certificate->file
                )
            ) {

                Storage::disk('public')->delete(
                    $certificate->file
                );

            }


            $data['file'] = $request
                ->file('file')
                ->store(
                    'certificate',
                    'public'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Update
        |--------------------------------------------------------------------------
        */

        $certificate->update($data);


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => true,

            'message' => 'Sertifikat berhasil diperbarui.',

            'data' => $certificate->fresh(),
        ]);
    }


    /**
     * Delete certificate.
     */
    public function destroy($uuid)
    {
        /*
        |--------------------------------------------------------------------------
        | Profile
        |--------------------------------------------------------------------------
        */

        $profile = $this->getProfile();

        if (!$profile) {

            return response()->json([
                'status' => false,
                'message' => 'Data profile belum tersedia.',
            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | Model
        |--------------------------------------------------------------------------
        */

        $model = $this->getCertificateModel();


        /*
        |--------------------------------------------------------------------------
        | Ambil Certificate Berdasarkan Role
        |--------------------------------------------------------------------------
        */

        if (Auth::user()->role === 'satpam') {

            $certificate = $model::where('uuid', $uuid)
                ->where('security_id', $profile->id)
                ->firstOrFail();

        } else {

            $certificate = $model::where('uuid', $uuid)
                ->where('cleaning_service_id', $profile->id)
                ->firstOrFail();

        }


        /*
        |--------------------------------------------------------------------------
        | Hapus File
        |--------------------------------------------------------------------------
        */

        if (
            $certificate->file &&
            Storage::disk('public')->exists(
                $certificate->file
            )
        ) {

            Storage::disk('public')->delete(
                $certificate->file
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Delete
        |--------------------------------------------------------------------------
        */

        $certificate->delete();


        return response()->json([
            'status' => true,
            'message' => 'Sertifikat berhasil dihapus.',
        ]);
    }


    /**
     * Toggle badge certificate.
     */
    public function badge($uuid)
    {
        /*
        |--------------------------------------------------------------------------
        | Profile
        |--------------------------------------------------------------------------
        */

        $profile = $this->getProfile();

        if (!$profile) {

            return response()->json([
                'success' => false,
                'message' => 'Data profile belum tersedia.',
            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | Model
        |--------------------------------------------------------------------------
        */

        $model = $this->getCertificateModel();


        /*
        |--------------------------------------------------------------------------
        | Ambil Certificate
        |--------------------------------------------------------------------------
        */

        if (Auth::user()->role === 'satpam') {

            $certificate = $model::where('uuid', $uuid)
                ->where('security_id', $profile->id)
                ->firstOrFail();

            $ownerColumn = 'security_id';

        } else {

            $certificate = $model::where('uuid', $uuid)
                ->where('cleaning_service_id', $profile->id)
                ->firstOrFail();

            $ownerColumn = 'cleaning_service_id';

        }


        /*
        |--------------------------------------------------------------------------
        | Toggle Badge
        |--------------------------------------------------------------------------
        */

        if ($certificate->is_badge) {

            /*
            |--------------------------------------------------------------------------
            | Matikan badge
            |--------------------------------------------------------------------------
            */

            $certificate->update([
                'is_badge' => 0,
            ]);

        } else {

            /*
            |--------------------------------------------------------------------------
            | Matikan badge certificate lain
            |--------------------------------------------------------------------------
            */

            $model::where(
                $ownerColumn,
                $profile->id
            )->update([
                'is_badge' => 0,
            ]);


            /*
            |--------------------------------------------------------------------------
            | Jadikan certificate ini sebagai badge
            |--------------------------------------------------------------------------
            */

            $certificate->update([
                'is_badge' => 1,
            ]);

        }


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => true,

            'is_badge' => $certificate
                ->fresh()
                ->is_badge,

            'uuid' => $certificate->uuid,

            'data' => $certificate->fresh(),
        ]);
    }
}