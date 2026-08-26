<?php

namespace App\Http\Controllers\UserPage;

use App\Http\Controllers\Controller;
use App\Models\SecurityCertificate;
use Illuminate\Http\Request;
use Storage;
use Carbon;
use Auth;

class SecurityCertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $request->validate([
            'title' => 'required|max:255',
            'publisher' => 'required|max:255',
            'certificate_number' => 'required|max:255',
            'category' => 'required|max:255',
            'publish_date' => 'required|date',
            'expired_date' => 'required|date|after_or_equal:publish_date',
            'file' => 'nullable|mimes:pdf,jpg,jpeg,png|max:10240'
        ]);

        $data = new SecurityCertificate();
        $data->security_id = Auth::user()->user_security->security->id;
        $data->title = $request->title;
        $data->publisher = $request->publisher;
        $data->certificate_number = $request->certificate_number;
        $data->category = $request->category;
        $data->publish_date = $request->publish_date;
        $data->expired_date = $request->expired_date;

        if ($request->hasFile('file')) {

            $file = $request->file('file');

            $filename = time().'_'.$file->getClientOriginalName();

            $file->move(public_path('uploads/certificate'), $filename);

            $data->file = 'uploads/certificate/'.$filename;

        }

        $data->save();

        return response()->json([
            'status' => true,
            'message' => 'Sertifikat berhasil ditambahkan.',
            'data' => [
                'uuid' => $data->uuid,
                'title' => $data->title,
                'publisher' => $data->publisher,
                'certificate_number' => $data->certificate_number,
                'category' => $data->category,
                'publish_date' => Carbon\Carbon::parse($data->publish_date)->format('d M Y'),
                'expired_date' => Carbon\Carbon::parse($data->expired_date)->format('d M Y'),
                'file' => $data->file,
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(SecurityCertificate $securityCertificate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SecurityCertificate $securityCertificate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        $request->validate([
            'title'=>'required',
            'publisher'=>'required',
            'certificate_number'=>'required',
            'category'=>'required',
            'publish_date'=>'required',
            'expired_date'=>'required',
        ]);

        $certificate = SecurityCertificate::where('uuid',$uuid)->firstOrFail();

        $data = $request->except('file');

        if($request->hasFile('file')){

            if($certificate->file && Storage::disk('public')->exists($certificate->file)){
                Storage::disk('public')->delete($certificate->file);
            }

            $data['file'] = $request->file('file')
                ->store('certificate','public');
        }

        $certificate->update($data);

        return response()->json([
            'success'=>true,
            'message'=>'Sertifikat berhasil diperbarui.',
            'data'=>$certificate->fresh()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        $certificate = SecurityCertificate::where('uuid',$uuid)->firstOrFail();

        // hapus file
        if($certificate->file && Storage::disk('public')->exists($certificate->file)){
            Storage::disk('public')->delete($certificate->file);
        }

        $certificate->delete();

        return response()->json([
            'status' => true,
            'message' => 'Sertifikat berhasil dihapus.'
        ]);
    }

    public function badge($uuid)
    {
        $certificate = SecurityCertificate::where('uuid',$uuid)
            ->where('security_id', auth()->user()->user_security->security->id)
            ->firstOrFail();

        if($certificate->is_badge){

            $certificate->update([
                'is_badge'=> 0
            ]);

        }else{

            SecurityCertificate::where('security_id',$certificate->security_id)
                ->update([
                    'is_badge'=> 0
                ]);

            $certificate->update([
                'is_badge'=> 1
            ]);

        }

        return response()->json([
            'success'=>true,
            'is_badge'=>$certificate->fresh()->is_badge,
            'uuid'=>$certificate->uuid,
            'data' => $certificate
        ]);
    }
}
