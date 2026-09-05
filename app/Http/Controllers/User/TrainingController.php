<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Validator;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;
use Laravolt\Indonesia\Models\City;
use App\Http\Resources\MasterResource;
use App\Http\Controllers\Controller;
use App\Models\TrainingApplication;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Training;
use Carbon\Carbon;
use Auth;

class TrainingController extends Controller
{
    public function statistic()
    {
        /*
        |--------------------------------------------------------------------------
        | GET BUJP
        |--------------------------------------------------------------------------
        */

        $user = Auth::user();

        $bujp = $user->user_bujp->bujp;

        $bujpId = $bujp->id;


        /*
        |--------------------------------------------------------------------------
        | BASE QUERY TRAINING
        |--------------------------------------------------------------------------
        */

        $trainingQuery = Training::query()
            ->where('b_u_j_p_id', $bujpId);


        /*
        |--------------------------------------------------------------------------
        | STATISTIK TRAINING
        |--------------------------------------------------------------------------
        */

        $totalTrainings = (clone $trainingQuery)
            ->count();

        $totalPublished = (clone $trainingQuery)
            ->where('status', 'published')
            ->count();

        $totalDraft = (clone $trainingQuery)
            ->where('status', 'draft')
            ->count();

        $totalClosed = (clone $trainingQuery)
            ->where('status', 'closed')
            ->count();

        $totalRejected = (clone $trainingQuery)
            ->where('status', 'rejected')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | ID TRAINING
        |--------------------------------------------------------------------------
        */

        $trainingIds = (clone $trainingQuery)
            ->pluck('id');


        /*
        |--------------------------------------------------------------------------
        | BASE QUERY PENDAFTAR
        |--------------------------------------------------------------------------
        */

        $registrationQuery = TrainingApplication::query()
            ->whereIn('training_id', $trainingIds);


        /*
        |--------------------------------------------------------------------------
        | TOTAL PENDAFTAR
        |--------------------------------------------------------------------------
        */

        $totalRegistrations = (clone $registrationQuery)
            ->count();


        /*
        |--------------------------------------------------------------------------
        | PESERTA DITERIMA
        |--------------------------------------------------------------------------
        */

        $totalAccepted = (clone $registrationQuery)
            ->where('status', 'approved')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | PESERTA DITOLAK
        |--------------------------------------------------------------------------
        */

        $totalRejectedRegistrations = (clone $registrationQuery)
            ->where('status', 'rejected')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | STATUS PESERTA
        |--------------------------------------------------------------------------
        */

        $pendingRegistrations = (clone $registrationQuery)
            ->where('status', 'pending')
            ->count();

        $approvedRegistrations = (clone $registrationQuery)
            ->where('status', 'approved')
            ->count();

        $rejectedRegistrations = (clone $registrationQuery)
            ->where('status', 'rejected')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | DATA DOUGHNUT CHART
        |--------------------------------------------------------------------------
        */

        $statusChart = [
            [
                'label' => 'Pending',
                'total' => $pendingRegistrations,
            ],
            [
                'label' => 'Approved',
                'total' => $approvedRegistrations,
            ],
            [
                'label' => 'Rejected',
                'total' => $rejectedRegistrations,
            ],
        ];


        /*
        |--------------------------------------------------------------------------
        | TREND 6 BULAN
        |--------------------------------------------------------------------------
        */

        $months = [];

        for ($i = 5; $i >= 0; $i--) {

            $date = Carbon::now()
                ->subMonths($i);

            $months[] = [
                'key' => $date->format('Y-m'),
                'label' => $date->translatedFormat('M Y'),
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | TREND TRAINING
        |--------------------------------------------------------------------------
        */

        $trainingTrend = [];

        foreach ($months as $month) {

            $date = Carbon::createFromFormat(
                'Y-m',
                $month['key']
            );

            $trainingTrend[] = [
                'label' => $month['label'],

                'total' => (clone $trainingQuery)
                    ->whereYear(
                        'created_at',
                        $date->year
                    )
                    ->whereMonth(
                        'created_at',
                        $date->month
                    )
                    ->count(),
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | TREND PENDAFTAR
        |--------------------------------------------------------------------------
        */

        $registrationTrend = [];

        foreach ($months as $month) {

            $date = Carbon::createFromFormat(
                'Y-m',
                $month['key']
            );

            $registrationTrend[] = [
                'label' => $month['label'],

                'total' => (clone $registrationQuery)
                    ->whereYear(
                        'created_at',
                        $date->year
                    )
                    ->whereMonth(
                        'created_at',
                        $date->month
                    )
                    ->count(),
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | TOP 5 TRAINING
        |--------------------------------------------------------------------------
        */

        $topTrainings = (clone $trainingQuery)
            ->withCount('applications')
            ->orderByDesc('applications_count')
            ->limit(5)
            ->get([
                'id',
                'title',
                'status',
            ]);


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'dashboard-user.training.statistic',
            compact(
                'bujp',
                'totalTrainings',
                'totalPublished',
                'totalDraft',
                'totalClosed',
                'totalRejected',
                'totalRegistrations',
                'totalAccepted',
                'totalRejectedRegistrations',
                'trainingTrend',
                'registrationTrend',
                'statusChart',
                'topTrainings'
            )
        );
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | DATA TABLE
        |--------------------------------------------------------------------------
        */

        if ($request->ajax()) {

            $searchValue = $request->input('search.value');

            $orderColumn = $request->input('order.0.column') ?? 0;

            $orderSort = $request->input('order.0.dir') ?? 'asc';

            $orderValue = $request->input(
                'columns.' . $orderColumn . '.data'
            ) ?? 'id';


            /*
            |--------------------------------------------------------------------------
            | STATUS FILTER
            |--------------------------------------------------------------------------
            */

            $status = $request->input('status');


            /*
            |--------------------------------------------------------------------------
            | QUERY TRAINING
            |--------------------------------------------------------------------------
            */

            $data = Training::query()

                /*
                |--------------------------------------------------------------------------
                | OWNER
                |--------------------------------------------------------------------------
                */

                ->where(function ($q) {

                    if (Auth::user()->role == 'bujp') {

                        $q->where(
                            'b_u_j_p_id',
                            Auth::user()->user_bujp->bujp->id
                        );

                    } else {

                        $q->where(
                            'company_id',
                            Auth::user()->user_company->company->id
                        );

                    }

                })


                /*
                |--------------------------------------------------------------------------
                | FILTER STATUS
                |--------------------------------------------------------------------------
                */

                ->when(
                    $status && $status !== 'all',
                    function ($q) use ($status) {

                        $q->where('status', $status);

                    }
                )


                /*
                |--------------------------------------------------------------------------
                | SEARCH
                |--------------------------------------------------------------------------
                */

                ->when(
                    $searchValue,
                    function ($q) use ($searchValue) {

                        $q->where(function ($query) use ($searchValue) {

                            $query->where(
                                'title',
                                'like',
                                "%{$searchValue}%"
                            )

                            ->orWhere(
                                'provider',
                                'like',
                                "%{$searchValue}%"
                            )

                            ->orWhere(
                                'category',
                                'like',
                                "%{$searchValue}%"
                            )

                            ->orWhere(
                                'level',
                                'like',
                                "%{$searchValue}%"
                            )

                            ->orWhere(
                                'province',
                                'like',
                                "%{$searchValue}%"
                            )

                            ->orWhere(
                                'city',
                                'like',
                                "%{$searchValue}%"
                            )

                            ->orWhere(
                                'training_mode',
                                'like',
                                "%{$searchValue}%"
                            )

                            ->orWhere(
                                'certificate_name',
                                'like',
                                "%{$searchValue}%"
                            )

                            ->orWhere(
                                'status',
                                'like',
                                "%{$searchValue}%"
                            );

                        });

                    }
                )


                /*
                |--------------------------------------------------------------------------
                | SORTING
                |--------------------------------------------------------------------------
                */

                ->orderBy(
                    $orderValue,
                    $orderSort
                )


                /*
                |--------------------------------------------------------------------------
                | PAGINATION
                |--------------------------------------------------------------------------
                */

                ->paginate(
                    $request->length ?? 10
                );


            return new MasterResource(
                true,
                '00',
                'List Data',
                $data
            );

        }


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'dashboard-user.training.index'
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard-user.training.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            /*
            |--------------------------------------------------------------------------
            | BASIC
            |--------------------------------------------------------------------------
            */

            'poster'                => 'required|image|mimes:jpg,jpeg,png|max:5120',

            'title'                 => 'required|max:255',
            'provider'              => 'required|max:255',
            'category'              => 'required',
            'level'                 => 'required',

            'description'           => 'required',

            'quota'                 => 'required|integer|min:1',

            /*
            |--------------------------------------------------------------------------
            | TRAINING MODE
            |--------------------------------------------------------------------------
            */

            'training_mode'         => 'required',

            'province'              => 'required_if:training_mode,offline,hybrid',
            'city'                  => 'required_if:training_mode,offline,hybrid',

            // 'district'          => 'required_if:training_mode,offline,hybrid',
            // 'village'           => 'required_if:training_mode,offline,hybrid',

            'address'               => 'required_if:training_mode,offline,hybrid',

            'meeting_url'           => 'required_if:training_mode,online,hybrid',

            /*
            |--------------------------------------------------------------------------
            | DATE
            |--------------------------------------------------------------------------
            */

            'start_date'            => 'required|date',
            'end_date'              => 'required|date|after_or_equal:start_date',

            /*
            |--------------------------------------------------------------------------
            | DURATION
            |--------------------------------------------------------------------------
            */

            'duration_day'          => 'required|integer|min:1',
            'total_jp'              => 'required|integer|min:1',

            /*
            |--------------------------------------------------------------------------
            | JSON
            |--------------------------------------------------------------------------
            */

            'syllabus'              => 'required|json',
            'requirements'          => 'required|json',
            'tags'                  => 'nullable|json',

            /*
            |--------------------------------------------------------------------------
            | CERTIFICATE
            |--------------------------------------------------------------------------
            */

            'certificate_name'      => 'required_if:is_certificate,1',

        ], [

            /*
            |--------------------------------------------------------------------------
            | POSTER
            |--------------------------------------------------------------------------
            */

            'poster.required'       => 'Poster pelatihan wajib diupload.',
            'poster.image'          => 'File poster harus berupa gambar.',
            'poster.mimes'          => 'Poster harus berformat JPG, JPEG, atau PNG.',
            'poster.max'            => 'Ukuran poster maksimal 5 MB.',

            /*
            |--------------------------------------------------------------------------
            | BASIC
            |--------------------------------------------------------------------------
            */

            'title.required'                    => 'Judul pelatihan wajib diisi.',
            'title.max'                         => 'Judul pelatihan maksimal 255 karakter.',

            'provider.required'                 => 'Nama penyelenggara wajib diisi.',
            'provider.max'                      => 'Nama penyelenggara maksimal 255 karakter.',

            'category.required'                 => 'Kategori pelatihan wajib dipilih.',
            'level.required'                    => 'Level pelatihan wajib dipilih.',

            'description.required'              => 'Deskripsi pelatihan wajib diisi.',

            'quota.required'                    => 'Kuota peserta wajib diisi.',
            'quota.integer'                     => 'Kuota peserta harus berupa angka.',
            'quota.min'                         => 'Kuota peserta minimal 1 orang.',

            /*
            |--------------------------------------------------------------------------
            | LOCATION
            |--------------------------------------------------------------------------
            */

            'province.required_if'              => 'Provinsi wajib dipilih.',
            'city.required_if'                  => 'Kota/Kabupaten wajib dipilih.',

            // 'district.required_if'          => 'Kecamatan wajib dipilih.',
            // 'village.required_if'           => 'Kelurahan wajib dipilih.',

            'address.required_if'               => 'Alamat pelatihan wajib diisi.',

            /*
            |--------------------------------------------------------------------------
            | ONLINE
            |--------------------------------------------------------------------------
            */

            'meeting_url.required_if'           => 'Link meeting wajib diisi untuk pelatihan online atau hybrid.',
            'meeting_url.url'                   => 'Format link meeting tidak valid.',

            /*
            |--------------------------------------------------------------------------
            | DATE
            |--------------------------------------------------------------------------
            */

            'start_date.required'               => 'Tanggal mulai pelatihan wajib diisi.',
            'start_date.date'                   => 'Format tanggal mulai tidak valid.',

            'end_date.required'                 => 'Tanggal selesai pelatihan wajib diisi.',
            'end_date.date'                     => 'Format tanggal selesai tidak valid.',
            'end_date.after_or_equal'           => 'Tanggal selesai tidak boleh lebih awal dari tanggal mulai.',

            /*
            |--------------------------------------------------------------------------
            | DURATION
            |--------------------------------------------------------------------------
            */

            'duration_day.required'             => 'Durasi pelatihan wajib diisi.',
            'duration_day.integer'              => 'Durasi pelatihan harus berupa angka.',
            'duration_day.min'                  => 'Durasi pelatihan minimal 1 hari.',

            'total_jp.required'                 => 'Jumlah Jam Pelajaran (JP) wajib diisi.',
            'total_jp.integer'                  => 'Jumlah Jam Pelajaran (JP) harus berupa angka.',
            'total_jp.min'                      => 'Jumlah Jam Pelajaran (JP) minimal 1.',

            /*
            |--------------------------------------------------------------------------
            | JSON
            |--------------------------------------------------------------------------
            */

            'syllabus.required'                 => 'Materi pelatihan wajib diisi.',
            'syllabus.json'                     => 'Format materi pelatihan tidak valid.',

            'requirements.required'             => 'Persyaratan peserta wajib diisi.',
            'requirements.json'                 => 'Format persyaratan peserta tidak valid.',

            'tags.json'                         => 'Format tag pelatihan tidak valid.',

            /*
            |--------------------------------------------------------------------------
            | CERTIFICATE
            |--------------------------------------------------------------------------
            */

            'certificate_name.required_if'      => 'Nama sertifikat wajib diisi apabila pelatihan menyediakan sertifikat.',

        ]);


        /*
        |--------------------------------------------------------------------------
        | VALIDATION ERROR
        |--------------------------------------------------------------------------
        */

        if ($validator->fails()) {

            return response()->json([
                'status'  => false,
                'message' => 'Validasi gagal.',
                'errors'  => $validator->errors()
            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | OWNER
        |--------------------------------------------------------------------------
        */

        $bujpId = null;
        $companyId = null;

        if (auth()->user()->role == 'bujp') {

            $bujpId = auth()->user()
                ->user_bujp
                ->bujp
                ->id;

        } else {

            $companyId = auth()->user()
                ->user_company
                ->company
                ->id;

        }


        /*
        |--------------------------------------------------------------------------
        | LOCATION
        |--------------------------------------------------------------------------
        */

        $province = Province::whereCode($request->province)->first();

        $city = City::whereCode($request->city)->first();

        $district = District::whereCode($request->district)->first();

        $village = Village::whereCode($request->village)->first();


        /*
        |--------------------------------------------------------------------------
        | UPLOAD POSTER
        |--------------------------------------------------------------------------
        */

        $posterPath = null;

        if ($request->hasFile('poster')) {

            $posterPath = $request
                ->file('poster')
                ->store('training/posters', 'public');

        }


        /*
        |--------------------------------------------------------------------------
        | PRICE
        |--------------------------------------------------------------------------
        */

        $price = null;

        if (!$request->boolean('is_free')) {

            $price = str_replace(
                '.',
                '',
                $request->price
            );

        }


        /*
        |--------------------------------------------------------------------------
        | STATUS
        |--------------------------------------------------------------------------
        */

        $status = ($request->status === 'submitted')
            ? 'published'
            : ($request->status ?? 'draft');


        /*
        |--------------------------------------------------------------------------
        | CREATE TRAINING
        |--------------------------------------------------------------------------
        */

        $training = Training::create([

            /*
            |--------------------------------------------------------------------------
            | OWNER
            |--------------------------------------------------------------------------
            */

            'b_u_j_p_id'            => $bujpId,
            'company_id'            => $companyId,

            /*
            |--------------------------------------------------------------------------
            | POSTER
            |--------------------------------------------------------------------------
            */

            'poster'                => $posterPath,

            /*
            |--------------------------------------------------------------------------
            | BASIC
            |--------------------------------------------------------------------------
            */

            'title'                 => $request->title,
            'provider'              => $request->provider,
            'instructor'            => $request->instructor,

            'category'              => $request->category,
            'level'                 => $request->level,

            /*
            |--------------------------------------------------------------------------
            | PRICE
            |--------------------------------------------------------------------------
            */

            'price'                 => $price,
            'is_free'               => $request->boolean('is_free'),

            /*
            |--------------------------------------------------------------------------
            | DESCRIPTION
            |--------------------------------------------------------------------------
            */

            'description'           => $request->description,

            /*
            |--------------------------------------------------------------------------
            | QUOTA
            |--------------------------------------------------------------------------
            */

            'quota'                 => $request->quota,
            'registered'            => 0,

            /*
            |--------------------------------------------------------------------------
            | TAG
            |--------------------------------------------------------------------------
            */

            'tags'                  => $request->tags,

            /*
            |--------------------------------------------------------------------------
            | TRAINING MODE
            |--------------------------------------------------------------------------
            */

            'training_mode'         => $request->training_mode,

            /*
            |--------------------------------------------------------------------------
            | LOCATION
            |--------------------------------------------------------------------------
            */

            'province'              => $province?->name,
            'city'                  => $city?->name,
            'district'              => $district?->name,
            'village'               => $village?->name,

            'address'               => $request->address,

            'google_map'            => $request->google_map,

            'meeting_url'           => $request->meeting_url,

            /*
            |--------------------------------------------------------------------------
            | DATE
            |--------------------------------------------------------------------------
            */

            'start_date'            => $request->start_date,
            'end_date'              => $request->end_date,

            /*
            |--------------------------------------------------------------------------
            | DURATION
            |--------------------------------------------------------------------------
            */

            'duration_day'          => $request->duration_day,
            'total_jp'              => $request->total_jp,

            /*
            |--------------------------------------------------------------------------
            | CERTIFICATE
            |--------------------------------------------------------------------------
            */

            'is_certificate'        => $request->boolean('is_certificate'),

            'certificate_name'      => $request->certificate_name,

            'certificate_validity'  => $request->certificate_validity,

            /*
            |--------------------------------------------------------------------------
            | CONTENT
            |--------------------------------------------------------------------------
            */

            'syllabus'              => $request->syllabus,

            'requirements'          => $request->requirements,

            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

            'status'                => $status,

            /*
            |--------------------------------------------------------------------------
            | STATISTIC
            |--------------------------------------------------------------------------
            */

            'total_clicked'         => 0,

        ]);


        /*
        |--------------------------------------------------------------------------
        | RESPONSE
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'status'  => true,

            'message' => 'Pelatihan berhasil disimpan.',

            'data'    => [

                'id'     => $training->id,

                'poster' => $posterPath,

            ]

        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data['data'] = Training::where('uuid', $id)->first();

        return view('dashboard-user.training.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['data'] = Training::where('uuid', $id)->first();

        return view('dashboard-user.training.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        $training = Training::where('uuid', $uuid)->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $validator = Validator::make($request->all(), [

            'title'                 => 'required|max:255',
            'provider'              => 'required|max:255',
            'category'              => 'required',
            'level'                 => 'required',

            'description'           => 'required',

            'quota'                 => 'required|integer|min:1',

            'training_mode'         => 'required',

            'province'              => 'required_if:training_mode,offline,hybrid',
            'city'                  => 'required_if:training_mode,offline,hybrid',

            // 'district'           => 'required_if:training_mode,offline,hybrid',
            // 'village'            => 'required_if:training_mode,offline,hybrid',

            'address'               => 'required_if:training_mode,offline,hybrid',

            'meeting_url'           => 'required_if:training_mode,online,hybrid',

            'start_date'            => 'required|date',

            'end_date'              => 'required|date|after_or_equal:start_date',

            'duration_day'          => 'required|integer|min:1',

            'total_jp'              => 'required|integer|min:1',

            'syllabus'              => 'required|json',

            'requirements'          => 'required|json',

            'tags'                  => 'nullable|json',

            'certificate_name'      => 'required_if:is_certificate,1',

            /*
            |--------------------------------------------------------------------------
            | POSTER
            |--------------------------------------------------------------------------
            |
            | nullable karena pada edit poster tidak wajib diganti.
            |
            */

            'poster'                => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',

        ], [

            'title.required'                    => 'Judul pelatihan wajib diisi.',
            'title.max'                         => 'Judul pelatihan maksimal 255 karakter.',

            'provider.required'                 => 'Nama penyelenggara wajib diisi.',
            'provider.max'                      => 'Nama penyelenggara maksimal 255 karakter.',

            'category.required'                 => 'Kategori pelatihan wajib dipilih.',

            'level.required'                    => 'Level pelatihan wajib dipilih.',

            'description.required'              => 'Deskripsi pelatihan wajib diisi.',

            'quota.required'                    => 'Kuota peserta wajib diisi.',
            'quota.integer'                     => 'Kuota peserta harus berupa angka.',
            'quota.min'                         => 'Kuota peserta minimal 1 orang.',

            'province.required_if'              => 'Provinsi wajib dipilih.',
            'city.required_if'                  => 'Kota/Kabupaten wajib dipilih.',

            // 'district.required_if'           => 'Kecamatan wajib dipilih.',
            // 'village.required_if'            => 'Kelurahan wajib dipilih.',

            'address.required_if'               => 'Alamat pelatihan wajib diisi.',

            'meeting_url.required_if'           => 'Link meeting wajib diisi untuk pelatihan online atau hybrid.',
            'meeting_url.url'                   => 'Format link meeting tidak valid.',

            'start_date.required'               => 'Tanggal mulai pelatihan wajib diisi.',
            'start_date.date'                   => 'Format tanggal mulai tidak valid.',

            'end_date.required'                 => 'Tanggal selesai pelatihan wajib diisi.',
            'end_date.date'                     => 'Format tanggal selesai tidak valid.',
            'end_date.after_or_equal'           => 'Tanggal selesai tidak boleh lebih awal dari tanggal mulai.',

            'duration_day.required'              => 'Durasi pelatihan wajib diisi.',
            'duration_day.integer'               => 'Durasi pelatihan harus berupa angka.',
            'duration_day.min'                   => 'Durasi pelatihan minimal 1 hari.',

            'total_jp.required'                  => 'Jumlah Jam Pelajaran (JP) wajib diisi.',
            'total_jp.integer'                   => 'Jumlah Jam Pelajaran (JP) harus berupa angka.',
            'total_jp.min'                       => 'Jumlah Jam Pelajaran (JP) minimal 1.',

            'syllabus.required'                  => 'Materi pelatihan wajib diisi.',
            'syllabus.json'                      => 'Format materi pelatihan tidak valid.',

            'requirements.required'              => 'Persyaratan peserta wajib diisi.',
            'requirements.json'                 => 'Format persyaratan peserta tidak valid.',

            'tags.json'                          => 'Format tag pelatihan tidak valid.',

            'certificate_name.required_if'       => 'Nama sertifikat wajib diisi apabila pelatihan menyediakan sertifikat.',

            /*
            |--------------------------------------------------------------------------
            | POSTER MESSAGE
            |--------------------------------------------------------------------------
            */

            'poster.image'                       => 'File poster harus berupa gambar.',
            'poster.mimes'                       => 'Poster hanya boleh berformat JPG, JPEG, PNG, atau WEBP.',
            'poster.max'                         => 'Ukuran poster maksimal 5 MB.',

        ]);


        /*
        |--------------------------------------------------------------------------
        | VALIDATION FAILED
        |--------------------------------------------------------------------------
        */

        if ($validator->fails()) {

            return response()->json([

                'status'  => false,

                'message' => 'Validasi gagal.',

                'errors'  => $validator->errors()

            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | LOCATION
        |--------------------------------------------------------------------------
        */

        $province = Province::whereCode($request->province)->first();

        $city = City::whereCode($request->city)->first();

        $district = District::whereCode($request->district)->first();

        $village = Village::whereCode($request->village)->first();


        /*
        |--------------------------------------------------------------------------
        | POSTER
        |--------------------------------------------------------------------------
        */

        $poster = $training->poster;


        /*
        | Jika user upload poster baru
        */

        if ($request->hasFile('poster')) {

            /*
            |--------------------------------------------------------------------------
            | HAPUS POSTER LAMA
            |--------------------------------------------------------------------------
            */

            if ($training->poster) {

                $oldPoster = public_path(
                    'storage/' . $training->poster
                );

                if (file_exists($oldPoster)) {

                    unlink($oldPoster);

                }

            }


            /*
            |--------------------------------------------------------------------------
            | SIMPAN POSTER BARU
            |--------------------------------------------------------------------------
            */

            $file = $request->file('poster');

            $filename = 'training-' .
                $training->uuid .
                '-' .
                time() .
                '.' .
                $file->getClientOriginalExtension();


            $file->move(
                public_path('storage/trainings/posters'),
                $filename
            );


            $poster = 'trainings/posters/' . $filename;

        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE TRAINING
        |--------------------------------------------------------------------------
        */

        $training->update([

            'title'                 => $request->title,

            'provider'              => $request->provider,

            'instructor'            => $request->instructor,

            'category'              => $request->category,

            'level'                 => $request->level,

            'price'                 => $request->boolean('is_free')
                                        ? 0
                                        : (int) str_replace('.', '', $request->price),

            'is_free'               => $request->boolean('is_free'),

            'description'           => $request->description,

            'quota'                 => $request->quota,

            'tags'                  => $request->tags,

            'training_mode'         => $request->training_mode,

            'province'              => $province?->name,

            'city'                  => $city?->name,

            'district'              => $district?->name,

            'village'               => $village?->name,

            'address'               => $request->address,

            'google_map'            => $request->google_map,

            'meeting_url'           => $request->meeting_url,

            'start_date'            => $request->start_date,

            'end_date'              => $request->end_date,

            'duration_day'          => $request->duration_day,

            'total_jp'              => $request->total_jp,

            'is_certificate'        => $request->boolean('is_certificate'),

            'certificate_name'      => $request->certificate_name,

            'certificate_validity'  => $request->certificate_validity,

            'certificate_requirement' => $request->certificate_requirement,

            'syllabus'              => $request->syllabus,

            'requirements'          => $request->requirements,

            /*
            |--------------------------------------------------------------------------
            | POSTER
            |--------------------------------------------------------------------------
            */

            'poster'                => $poster,

            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

            'status' => $request->status === 'submitted'
                ? 'published'
                : ($request->status ?? $training->status),

        ]);


        /*
        |--------------------------------------------------------------------------
        | RESPONSE
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'status'  => true,

            'message' => 'Pelatihan berhasil diperbarui.'

        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Training::where('uuid', $id)->first();
        
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

    public function start($uuid)
    {
        $data = Training::where('uuid', $uuid)->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | HANYA PUBLISHED YANG BISA START
        |--------------------------------------------------------------------------
        */

        if ($data->status !== 'published') {

            return response()->json([
                'success' => false,
                'message' => 'Pelatihan hanya dapat dimulai jika statusnya published.'
            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | CEK PESERTA APPROVED
        |--------------------------------------------------------------------------
        */

        $totalApproved = TrainingApplication::where(
            'training_id',
            $data->id
        )
        ->where('status', 'approved')
        ->count();


        if ($totalApproved <= 0) {

            return response()->json([
                'success' => false,
                'message' => 'Pelatihan belum dapat dimulai karena belum ada peserta yang disetujui.'
            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | START TRAINING
        |--------------------------------------------------------------------------
        */

        $data->update([
            'status' => 'running'
        ]);


        return response()->json([
            'success' => true,
            'message' => 'Pelatihan berhasil dimulai.'
        ]);
    }

    public function cancel($uuid)
    {
        $data = Training::where('uuid', $uuid)->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | HANYA PUBLISHED YANG BISA DI-CANCEL
        |--------------------------------------------------------------------------
        */

        if ($data->status !== 'published') {

            return response()->json([
                'success' => false,
                'message' => 'Pelatihan hanya dapat dibatalkan jika statusnya published.'
            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | CEK PESERTA
        |--------------------------------------------------------------------------
        |
        | Jika masih ada pendaftar dengan status:
        | - pending
        | - approved
        |
        | maka pelatihan tidak boleh dibatalkan.
        |
        */

        $hasApplication = TrainingApplication::where(
            'training_id',
            $data->id
        )
        ->whereIn('status', [
            'pending',
            'approved'
        ])
        ->exists();


        if ($hasApplication) {

            return response()->json([
                'success' => false,
                'message' => 'Pelatihan tidak dapat dibatalkan karena sudah terdapat peserta yang mendaftar.'
            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | CANCEL TRAINING
        |--------------------------------------------------------------------------
        */

        $data->update([
            'status' => 'cancelled'
        ]);


        return response()->json([
            'success' => true,
            'message' => 'Pelatihan berhasil dibatalkan.'
        ]);
    }

    public function close($uuid)
    {
        $data = Training::where('uuid', $uuid)->firstOrFail();

        if ($data->status !== 'running') {
            return response()->json([
                'success' => false,
                'message' => 'Pelatihan hanya dapat diselesaikan jika sedang berjalan.'
            ], 422);
        }

        $data->update([
            'status' => 'closed'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pelatihan berhasil diselesaikan.'
        ]);
    }
}
