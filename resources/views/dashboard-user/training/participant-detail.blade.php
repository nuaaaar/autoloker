@extends('layouts.dashboard-user')

@section('title', 'Detail Peserta')

@section('breadcrumb')
    <h1
        class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
        Pelatihan Saya</h1>
    <!--end::Title-->
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
        <!--begin::Item-->
        <li class="breadcrumb-item text-muted">
            <a href="javascript:;" class="text-muted text-hover-primary">Beranda</a>
        </li>
        <!--end::Item-->
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-500 w-5px h-2px"></span>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item text-muted">
            <a href="{{ route('dashboard-user.training.index') }}" class="text-muted text-hover-primary">Pelatihan Saya</a>
        </li>
        <!--end::Item-->
        <!--end::Item-->
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-500 w-5px h-2px"></span>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <a href="{{ route(
                        'dashboard-user.training.participants',
                        $training->uuid
                    ) }}" class="text-muted text-hover-primary ms-2">Lihat Peserta</a>
        <!--end::Item-->
        <!--end::Item-->
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-500 w-5px h-2px"></span>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <a href="javascript:;" class="text-muted text-hover-primary ms-2">Detail</a>
        <!--end::Item-->
    </ul>
    <!--end::Breadcrumb-->
@endsection

@section('content')

<div class="container-xxl">

    @php

        $security = $application->security;


        $trainingOwner =
            $training->bujp->company_name
            ?? $training->company->company_name
            ?? '-';


        $statusClass = [
            'pending' => 'warning',
            'approved' => 'success',
            'rejected' => 'danger',
        ][$application->status] ?? 'secondary';


        $statusLabel = [
            'pending' => 'Menunggu Persetujuan',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
        ][$application->status] ?? ucfirst(
            $application->status
        );


        $photo = null;

        if ($security && $security->formal_photo) {

            $photo = $security->formal_photo;

            if (
                !preg_match(
                    '/^https?:\/\//',
                    $photo
                )
            ) {

                if (
                    substr($photo, 0, 8) !== 'storage/'
                ) {

                    $photo = 'storage/' . ltrim(
                        $photo,
                        '/'
                    );

                }

                $photo = asset($photo);

            }

        }

    @endphp


    {{-- =========================================================
         HEADER
    ========================================================== --}}

    <div class="d-flex align-items-center justify-content-between mb-4">

        <div>

        </div>

        <a href="{{ route(
                        'dashboard-user.training.participants',
                        $training->uuid
                    ) }}"
        class="btn btn-light">

            <i class="fas fa-arrow-left me-2"></i>

            Kembali

        </a>

    </div>


    <div class="row g-5">


        {{-- =====================================================
             LEFT
        ====================================================== --}}

        <div class="col-lg-8">


            {{-- =================================================
                 PROFILE
            ================================================== --}}

            <div class="card mb-5">

                <div class="card-header">

                    <div class="card-title">

                        <h3 class="fw-bold mb-0">
                            Profil Peserta
                        </h3>

                    </div>

                </div>


                <div class="card-body">

                    <div class="d-flex align-items-center mb-8">

                        <div class="symbol symbol-100px me-5">

                            @if($photo)

                                <img
                                    src="{{ $photo }}"
                                    alt="{{ $security->name ?? 'Peserta' }}"
                                    class="object-fit-cover"
                                >

                            @else

                                <div class="symbol-label bg-light-primary">

                                    <i class="fas fa-user text-primary fs-2x"></i>

                                </div>

                            @endif

                        </div>


                        <div>

                            <h2 class="fw-bold mb-2">

                                {{ $security->name ?? '-' }}

                            </h2>


                            <div class="text-muted fs-7 mb-1">

                                <i class="fas fa-envelope me-2"></i>

                                {{ $security->email ?? '-' }}

                            </div>


                            <div class="text-muted fs-7">

                                <i class="fas fa-phone me-2"></i>

                                {{ $security->phone_number ?? '-' }}

                            </div>

                        </div>

                    </div>


                    {{-- PROFILE PROGRESS --}}

                    @if($profileProgress)

                        <div class="mb-8">

                            <div class="d-flex justify-content-between mb-2">

                                <span class="fw-semibold fs-7">

                                    Kelengkapan Profil

                                </span>

                                <span class="fw-bold fs-7">

                                    {{ $profileProgress['progress'] }}%

                                </span>

                            </div>


                            <div class="progress h-7px">

                                <div
                                    class="progress-bar"
                                    role="progressbar"
                                    style="width: {{ $profileProgress['progress'] }}%;"
                                ></div>

                            </div>

                            <div class="text-muted fs-8 mt-2">

                                {{ $profileProgress['completed'] }}
                                dari
                                {{ $profileProgress['total'] }}
                                data terisi

                            </div>

                        </div>

                    @endif


                    {{-- DATA PRIBADI --}}

                    <h5 class="fw-bold mb-5">

                        Data Pribadi

                    </h5>


                    <div class="row g-5 mb-8">

                        <div class="col-md-6">

                            <label class="text-muted fs-8">
                                Nama Lengkap
                            </label>

                            <div class="fw-semibold fs-7">

                                {{ $security->name ?? '-' }}

                            </div>

                        </div>


                        <div class="col-md-6">

                            <label class="text-muted fs-8">
                                Nomor KTP
                            </label>

                            <div class="fw-semibold fs-7">

                                {{ $security->ktp_number ?? '-' }}

                            </div>

                        </div>


                        <div class="col-md-6">

                            <label class="text-muted fs-8">
                                Nomor Registrasi
                            </label>

                            <div class="fw-semibold fs-7">

                                {{ $security->registration_number ?? '-' }}

                            </div>

                        </div>


                        <div class="col-md-6">

                            <label class="text-muted fs-8">
                                Status Satpam
                            </label>

                            <div class="fw-semibold fs-7">

                                {{ $security->work_status ?? '-' }}

                            </div>

                        </div>


                        <div class="col-md-6">

                            <label class="text-muted fs-8">
                                Tempat Lahir
                            </label>

                            <div class="fw-semibold fs-7">

                                {{ $security->birth_place ?? '-' }}

                            </div>

                        </div>


                        <div class="col-md-6">

                            <label class="text-muted fs-8">
                                Tanggal Lahir
                            </label>

                            <div class="fw-semibold fs-7">

                                @if($security?->birth_date)

                                    {{ \Carbon\Carbon::parse(
                                        $security->birth_date
                                    )->format('d M Y') }}

                                @else

                                    -

                                @endif

                            </div>

                        </div>


                        <div class="col-md-6">

                            <label class="text-muted fs-8">
                                Jenis Kelamin
                            </label>

                            <div class="fw-semibold fs-7">

                                {{ $security->gender ?? '-' }}

                            </div>

                        </div>


                        <div class="col-md-6">

                            <label class="text-muted fs-8">
                                Email
                            </label>

                            <div class="fw-semibold fs-7">

                                {{ $security->email ?? '-' }}

                            </div>

                        </div>

                    </div>


                    {{-- ALAMAT --}}

                    <h5 class="fw-bold mb-5">

                        Alamat

                    </h5>


                    <div class="row g-5 mb-8">

                        <div class="col-md-6">

                            <label class="text-muted fs-8">
                                Provinsi
                            </label>

                            <div class="fw-semibold fs-7">

                                {{ $security->province ?? '-' }}

                            </div>

                        </div>


                        <div class="col-md-6">

                            <label class="text-muted fs-8">
                                Kota
                            </label>

                            <div class="fw-semibold fs-7">

                                {{ $security->city ?? '-' }}

                            </div>

                        </div>


                        <div class="col-md-6">

                            <label class="text-muted fs-8">
                                Kecamatan
                            </label>

                            <div class="fw-semibold fs-7">

                                {{ $security->district ?? '-' }}

                            </div>

                        </div>


                        <div class="col-md-6">

                            <label class="text-muted fs-8">
                                Kelurahan
                            </label>

                            <div class="fw-semibold fs-7">

                                {{ $security->village ?? '-' }}

                            </div>

                        </div>


                        <div class="col-12">

                            <label class="text-muted fs-8">
                                Alamat Lengkap
                            </label>

                            <div class="fw-semibold fs-7">

                                {{ $security->address ?? '-' }}

                            </div>

                        </div>

                    </div>


                    {{-- DATA PEKERJAAN --}}

                    <h5 class="fw-bold mb-5">

                        Data Pekerjaan

                    </h5>


                    <div class="row g-5 mb-8">

                        <div class="col-md-6">

                            <label class="text-muted fs-8">
                                Pengalaman Kerja
                            </label>

                            <div class="fw-semibold fs-7">

                                {!! nl2br(
                                    e($security->work_experience ?? '-')
                                ) !!}

                            </div>

                        </div>


                        <div class="col-md-3">

                            <label class="text-muted fs-8">
                                Tinggi Badan
                            </label>

                            <div class="fw-semibold fs-7">

                                {{ $security->height ?? '-' }}

                                @if($security?->height)
                                    cm
                                @endif

                            </div>

                        </div>


                        <div class="col-md-3">

                            <label class="text-muted fs-8">
                                Berat Badan
                            </label>

                            <div class="fw-semibold fs-7">

                                {{ $security->width ?? '-' }}

                                @if($security?->width)
                                    kg
                                @endif

                            </div>

                        </div>


                        <div class="col-12">

                            <label class="text-muted fs-8">
                                Kemampuan
                            </label>

                            <div class="fw-semibold fs-7">

                                {!! nl2br(
                                    e($security->ability ?? '-')
                                ) !!}

                            </div>

                        </div>

                    </div>


                    {{-- KESEDIAAN --}}

                    <h5 class="fw-bold mb-5">

                        Kesediaan Kerja

                    </h5>


                    <div class="row g-5">

                        <div class="col-md-6">

                            <label class="text-muted fs-8">
                                Dinas Luar Kota
                            </label>

                            <div>

                                @if($security?->is_out_of_town_agree === null)

                                    <span class="badge badge-light-secondary">
                                        Belum Diisi
                                    </span>

                                @elseif($security->is_out_of_town_agree)

                                    <span class="badge badge-light-success">
                                        <i class="fas fa-check me-1"></i>
                                        Bersedia
                                    </span>

                                @else

                                    <span class="badge badge-light-danger">
                                        <i class="fas fa-times me-1"></i>
                                        Tidak Bersedia
                                    </span>

                                @endif

                            </div>

                        </div>


                        <div class="col-md-6">

                            <label class="text-muted fs-8">
                                Kerja Shift
                            </label>

                            <div>

                                @if($security?->is_shift_agree === null)

                                    <span class="badge badge-light-secondary">
                                        Belum Diisi
                                    </span>

                                @elseif($security->is_shift_agree)

                                    <span class="badge badge-light-success">
                                        <i class="fas fa-check me-1"></i>
                                        Bersedia
                                    </span>

                                @else

                                    <span class="badge badge-light-danger">
                                        <i class="fas fa-times me-1"></i>
                                        Tidak Bersedia
                                    </span>

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- =====================================================
             RIGHT
        ====================================================== --}}

        <div class="col-lg-4">


            {{-- =================================================
                 STATUS
            ================================================== --}}

            <div class="card mb-5">

                <div class="card-header">

                    <div class="card-title">

                        <h4 class="fw-bold mb-0">
                            Status Peserta
                        </h4>

                    </div>

                </div>


                <div class="card-body">

                    <div class="text-center mb-6">

                        <span
                            id="participantStatusBadge"
                            class="badge badge-light-{{ $statusClass }} px-5 py-3 fs-7"
                        >

                            {{ $statusLabel }}

                        </span>

                    </div>


                    {{-- PENDING --}}

                    @if($application->status === 'pending')

                        <button
                            type="button"
                            id="btnApprove"
                            class="btn btn-success w-100 mb-3"
                            onclick="approveParticipant()"
                        >

                            <i class="fas fa-check me-2"></i>

                            Setujui Peserta

                        </button>


                        <button
                            type="button"
                            id="btnReject"
                            class="btn btn-danger w-100"
                            onclick="rejectParticipant()"
                        >

                            <i class="fas fa-times me-2"></i>

                            Tolak Peserta

                        </button>

                    @else

                        <button
                            type="button"
                            id="btnRollback"
                            class="btn btn-warning w-100"
                            onclick="rollbackParticipant()"
                        >

                            <i class="fas fa-undo me-2"></i>

                            Kembalikan ke Pending

                        </button>

                    @endif

                </div>

            </div>


            {{-- =================================================
                 TRAINING
            ================================================== --}}

            <div class="card mb-5">

                <div class="card-header">

                    <div class="card-title">

                        <h4 class="fw-bold mb-0">
                            Informasi Pelatihan
                        </h4>

                    </div>

                </div>


                <div class="card-body">

                    <div class="mb-5">

                        <div class="text-muted fs-8 mb-1">
                            Nama Pelatihan
                        </div>

                        <div class="fw-bold fs-7">

                            {{ $training->title ?? '-' }}

                        </div>

                    </div>


                    <div class="mb-5">

                        <div class="text-muted fs-8 mb-1">
                            Penyelenggara
                        </div>

                        <div class="fw-semibold fs-7">

                            {{ $training->provider ?? '-' }}

                        </div>

                    </div>


                    <div class="mb-5">

                        <div class="text-muted fs-8 mb-1">
                            Jadwal
                        </div>

                        <div class="fw-semibold fs-7">

                            @if($training->start_date)

                                {{ \Carbon\Carbon::parse(
                                    $training->start_date
                                )->format('d M Y') }}

                            @else

                                -

                            @endif


                            <span class="mx-1">
                                -
                            </span>


                            @if($training->end_date)

                                {{ \Carbon\Carbon::parse(
                                    $training->end_date
                                )->format('d M Y') }}

                            @endif

                        </div>

                    </div>


                    <div class="mb-5">

                        <div class="text-muted fs-8 mb-1">
                            Mode
                        </div>

                        <div class="fw-semibold fs-7">

                            {{ ucfirst(
                                $training->training_mode ?? '-'
                            ) }}

                        </div>

                    </div>


                    <div>

                        <div class="text-muted fs-8 mb-1">
                            Kuota
                        </div>

                        <div class="fw-semibold fs-7">

                            {{ $training->registered ?? 0 }}

                            /

                            {{ $training->quota ?: '∞' }}

                        </div>

                    </div>

                </div>

            </div>


            {{-- =================================================
                 APPLICATION
            ================================================== --}}

            <div class="card">

                <div class="card-header">

                    <div class="card-title">

                        <h4 class="fw-bold mb-0">
                            Informasi Pendaftaran
                        </h4>

                    </div>

                </div>


                <div class="card-body">

                    <div class="mb-5">

                        <div class="text-muted fs-8 mb-1">
                            Tanggal Daftar
                        </div>

                        <div class="fw-semibold fs-7">

                            {{ optional(
                                $application->created_at
                            )->format('d M Y H:i') }}

                        </div>

                    </div>


                    <div>

                        <div class="text-muted fs-8 mb-1">
                            Status
                        </div>

                        <div>

                            <span
                                class="badge badge-light-{{ $statusClass }}"
                            >

                                {{ $statusLabel }}

                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection


@section('js')

<script>

    const participantUrl = "{{ route('dashboard-user.training.participant.detail',[$training->uuid,$application->uuid]) }}";


    const approveUrl = "{{ route('dashboard-user.training.participant.approve',[$training->uuid,$application->uuid]) }}";


    const rejectUrl = "{{ route('dashboard-user.training.participant.reject',[$training->uuid,$application->uuid]) }}";


    const rollbackUrl = "{{ route('dashboard-user.training.participant.rollback',[$training->uuid,$application->uuid]) }}";


    /*
    |--------------------------------------------------------------------------
    | CSRF
    |--------------------------------------------------------------------------
    */

    function csrfToken()
    {
        return $('meta[name="csrf-token"]').attr('content');
    }


    /*
    |--------------------------------------------------------------------------
    | APPROVE
    |--------------------------------------------------------------------------
    */

    function approveParticipant()
    {

        Swal.fire({

            title: 'Setujui Peserta?',

            text: 'Peserta akan didaftarkan sebagai peserta resmi pelatihan.',

            icon: 'question',

            showCancelButton: true,

            confirmButtonText: 'Ya, Setujui',

            cancelButtonText: 'Batal',

            reverseButtons: true

        }).then(function(result) {

            if (!result.isConfirmed) {
                return;
            }


            $('#btnApprove')
                .prop('disabled', true);


            $.ajax({

                url: approveUrl,

                type: 'POST',

                data: {

                    _token: csrfToken()

                },

                success: function(response) {

                    if (response.success) {

                        Swal.fire({

                            icon: 'success',

                            title: 'Berhasil',

                            text: response.message,

                            timer: 1500,

                            showConfirmButton: false

                        }).then(function() {

                            window.location.reload();

                        });

                    }

                },

                error: function(xhr) {

                    $('#btnApprove')
                        .prop('disabled', false);


                    let message =
                        'Gagal menyetujui peserta.';


                    if (
                        xhr.responseJSON &&
                        xhr.responseJSON.message
                    ) {

                        message =
                            xhr.responseJSON.message;

                    }


                    Swal.fire({

                        icon: 'error',

                        title: 'Tidak Dapat Menyetujui',

                        text: message

                    });

                }

            });

        });

    }


    /*
    |--------------------------------------------------------------------------
    | REJECT
    |--------------------------------------------------------------------------
    */

    function rejectParticipant()
    {

        Swal.fire({

            title: 'Tolak Peserta?',

            text: 'Peserta akan dipindahkan ke status ditolak.',

            icon: 'warning',

            showCancelButton: true,

            confirmButtonText: 'Ya, Tolak',

            cancelButtonText: 'Batal',

            confirmButtonColor: '#d33',

            reverseButtons: true

        }).then(function(result) {

            if (!result.isConfirmed) {
                return;
            }


            $('#btnReject')
                .prop('disabled', true);


            $.ajax({

                url: rejectUrl,

                type: 'POST',

                data: {

                    _token: csrfToken()

                },

                success: function(response) {

                    if (response.success) {

                        Swal.fire({

                            icon: 'success',

                            title: 'Berhasil',

                            text: response.message,

                            timer: 1500,

                            showConfirmButton: false

                        }).then(function() {

                            window.location.reload();

                        });

                    }

                },

                error: function(xhr) {

                    $('#btnReject')
                        .prop('disabled', false);


                    let message =
                        'Gagal menolak peserta.';


                    if (
                        xhr.responseJSON &&
                        xhr.responseJSON.message
                    ) {

                        message =
                            xhr.responseJSON.message;

                    }


                    Swal.fire({

                        icon: 'error',

                        title: 'Gagal',

                        text: message

                    });

                }

            });

        });

    }


    /*
    |--------------------------------------------------------------------------
    | ROLLBACK
    |--------------------------------------------------------------------------
    */

    function rollbackParticipant()
    {

        Swal.fire({

            title: 'Kembalikan Status?',

            text: 'Status peserta akan dikembalikan menjadi Menunggu Persetujuan.',

            icon: 'question',

            showCancelButton: true,

            confirmButtonText: 'Ya, Kembalikan',

            cancelButtonText: 'Batal',

            reverseButtons: true

        }).then(function(result) {

            if (!result.isConfirmed) {
                return;
            }


            $('#btnRollback')
                .prop('disabled', true);


            $.ajax({

                url: rollbackUrl,

                type: 'POST',

                data: {

                    _token: csrfToken()

                },

                success: function(response) {

                    if (response.success) {

                        Swal.fire({

                            icon: 'success',

                            title: 'Berhasil',

                            text: response.message,

                            timer: 1500,

                            showConfirmButton: false

                        }).then(function() {

                            window.location.reload();

                        });

                    }

                },

                error: function(xhr) {

                    $('#btnRollback')
                        .prop('disabled', false);


                    let message =
                        'Gagal mengembalikan status peserta.';


                    if (
                        xhr.responseJSON &&
                        xhr.responseJSON.message
                    ) {

                        message =
                            xhr.responseJSON.message;

                    }


                    Swal.fire({

                        icon: 'error',

                        title: 'Gagal',

                        text: message

                    });

                }

            });

        });

    }

</script>

@endsection