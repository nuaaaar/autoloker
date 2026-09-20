@extends('layouts.dashboard-user')

@section('breadcrumb')
    <h1
        class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
        Lowongan Saya</h1>
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
            <a href="{{ route('dashboard-user.job-vacancy.index') }}" class="text-muted text-hover-primary">Lowongan Saya</a>
        </li>
        <!--end::Item-->
        <!--end::Item-->
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-500 w-5px h-2px"></span>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <a href="{{ route('dashboard-user.job-application.index',$job->uuid) }}" class="text-muted text-hover-primary ms-2">Lihat Pelamar</a>
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

<div class="container-fluid py-5">

    <div class="d-flex align-items-center justify-content-between mb-4">

            <div>

            </div>

            <a href="{{ route('dashboard-user.job-application.index',$job->uuid) }}"
            class="btn btn-light">

                <i class="fas fa-arrow-left me-2"></i>

                Kembali

            </a>

        </div>

    {{-- =========================================================
        HEADER
    ========================================================== --}}

    <div class="card mb-5">

        <div class="card-body">

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-4">

                <div>

                    <div class="d-flex align-items-center gap-3 mb-2">

                        <h2 class="mb-0 fw-bold">
                            Detail Pelamar
                        </h2>

                    </div>


                    <div class="text-muted">

                        {{ $job->position ?? '-' }}

                        <span class="mx-2">
                            •
                        </span>

                        {{ $job->bujp?->company_name
                            ?? $job->company?->company_name
                            ?? '-' }}

                    </div>

                </div>


                {{-- STATUS --}}

                <div>

                    @switch($application->status)

                        @case('APPLIED')

                            <span class="badge badge-light-primary fs-6 px-4 py-3">

                                <i class="fas fa-paper-plane me-2"></i>

                                Applied

                            </span>

                            @break


                        @case('REVIEWED')

                            <span class="badge badge-light-warning fs-6 px-4 py-3">

                                <i class="fas fa-eye me-2"></i>

                                Reviewed

                            </span>

                            @break


                        @case('SHORTLISTED')

                            <span class="badge badge-light-success fs-6 px-4 py-3">

                                <i class="fas fa-user-check me-2"></i>

                                Shortlisted

                            </span>

                            @break


                        @case('REJECTED')

                            <span class="badge badge-light-danger fs-6 px-4 py-3">

                                <i class="fas fa-times-circle me-2"></i>

                                Rejected

                            </span>

                            @break


                        @default

                            <span class="badge badge-light-secondary fs-6 px-4 py-3">

                                {{ $application->status ?? '-' }}

                            </span>

                    @endswitch

                </div>

            </div>

        </div>

    </div>



    {{-- =========================================================
        CONTENT
    ========================================================== --}}

    <div class="row g-5">


        {{-- =====================================================
            LEFT
        ====================================================== --}}

        <div class="col-xl-8">


            {{-- =================================================
                PROFIL PELAMAR
            ================================================== --}}

            <div class="card mb-5">

                <div class="card-header">

                    <div class="card-title">

                        <h3 class="fw-bold m-0">
                            Data Pelamar
                        </h3>

                    </div>

                </div>


                <div class="card-body">


                    {{-- PROFILE HEADER --}}

                    <div class="d-flex align-items-center mb-8">


                        <div class="symbol symbol-100px symbol-circle me-5 overflow-hidden">

                            @if($application->security?->formal_photo)

                                <img
                                    src="{{ asset(
                                        'storage/' .
                                        $application->security->formal_photo
                                    ) }}"
                                    alt="{{ $application->security?->name }}"
                                    style="
                                        width:100px;
                                        height:100px;
                                        object-fit:cover;
                                    "
                                >

                            @else

                                <div class="symbol-label bg-light-primary">

                                    <i class="fas fa-user text-primary fs-2x"></i>

                                </div>

                            @endif

                        </div>


                        <div>

                            <h2 class="fw-bold mb-2">

                                {{ $application->security?->name ?? '-' }}

                            </h2>


                            <div class="text-muted mb-2">

                                <i class="fas fa-envelope me-2"></i>

                                {{ $application->security?->email ?? '-' }}

                            </div>


                            <div class="text-muted">

                                <i class="fas fa-phone me-2"></i>

                                {{ $application->security?->phone ?? '-' }}

                            </div>

                        </div>

                    </div>


                    <div class="separator mb-7"></div>


                    {{-- BIODATA --}}

                    <div class="row g-6">


                        <div class="col-md-6">

                            <div class="text-muted fs-7 mb-1">
                                Nama Lengkap
                            </div>

                            <div class="fw-bold">
                                {{ $application->security?->name ?? '-' }}
                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="text-muted fs-7 mb-1">
                                Email
                            </div>

                            <div class="fw-bold">
                                {{ $application->security?->email ?? '-' }}
                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="text-muted fs-7 mb-1">
                                Nomor KTP
                            </div>

                            <div class="fw-bold">
                                {{ $application->security?->ktp_number ?? '-' }}
                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="text-muted fs-7 mb-1">
                                Nomor Telepon
                            </div>

                            <div class="fw-bold">
                                {{ $application->security?->phone ?? '-' }}
                            </div>

                        </div>


                    </div>

                </div>

            </div>



            {{-- =================================================
                LOWONGAN
            ================================================== --}}

            <div class="card mb-5">

                <div class="card-header">

                    <div class="card-title">

                        <h3 class="fw-bold m-0">
                            Lowongan yang Dilamar
                        </h3>

                    </div>

                </div>


                <div class="card-body">


                    <div class="d-flex align-items-center">


                        <div class="symbol symbol-50px me-4">

                            <div class="symbol-label bg-light-primary">

                                <i class="fas fa-briefcase text-primary fs-3"></i>

                            </div>

                        </div>


                        <div>

                            <h4 class="fw-bold mb-1">

                                {{ $job->position ?? '-' }}

                            </h4>


                            <div class="text-muted">

                                {{ $job->city ?? '-' }}

                                @if($job->province)

                                    <span class="mx-1">
                                        •
                                    </span>

                                    {{ $job->province }}

                                @endif

                            </div>

                        </div>

                    </div>


                    <div class="separator my-6"></div>


                    <div class="row g-6">


                        <div class="col-md-4">

                            <div class="text-muted fs-7">
                                Jenis Pekerjaan
                            </div>

                            <div class="fw-bold mt-1">

                                @switch($job->working_type)

                                    @case('permanent')
                                        Tetap
                                        @break

                                    @case('contract')
                                        Kontrak
                                        @break

                                    @case('internship')
                                        Internship
                                        @break

                                    @case('freelance')
                                        Freelance
                                        @break

                                    @default
                                        -

                                @endswitch

                            </div>

                        </div>


                        <div class="col-md-4">

                            <div class="text-muted fs-7">
                                Sistem Kerja
                            </div>

                            <div class="fw-bold mt-1">

                                {{ $job->working_system == 'shift'
                                    ? 'Shift'
                                    : 'Non-Shift' }}

                            </div>

                        </div>


                        <div class="col-md-4">

                            <div class="text-muted fs-7">
                                Kuota
                            </div>

                            <div class="fw-bold mt-1">

                                {{ $job->kuota ?? '-' }}

                                Orang

                            </div>

                        </div>


                    </div>

                </div>

            </div>



            {{-- =================================================
                DOKUMEN
            ================================================== --}}

            {{-- <div class="card mb-5">

                <div class="card-header">

                    <div class="card-title">

                        <h3 class="fw-bold m-0">
                            Dokumen Lamaran
                        </h3>

                    </div>

                </div>


                <div class="card-body">


                    @if($application->document)

                        <div class="border rounded p-5">


                            <div class="d-flex justify-content-between align-items-center">


                                <div class="d-flex align-items-center">


                                    <div class="symbol symbol-50px me-4">

                                        <div class="symbol-label bg-light-danger">

                                            <i class="fas fa-file-pdf text-danger fs-2"></i>

                                        </div>

                                    </div>


                                    <div>

                                        <div class="fw-bold">
                                            Dokumen Lamaran
                                        </div>

                                        <div class="text-muted fs-7">
                                            Dokumen yang dikirim oleh pelamar
                                        </div>

                                    </div>

                                </div>


                                <a
                                    href="{{ asset(
                                        'storage/' .
                                        $application->document
                                    ) }}"
                                    target="_blank"
                                    class="btn btn-light-primary"
                                >

                                    <i class="fas fa-external-link-alt me-2"></i>

                                    Lihat Dokumen

                                </a>

                            </div>

                        </div>


                    @else

                        <div class="text-center py-8">

                            <i class="fas fa-file-slash fs-3x text-muted mb-4"></i>

                            <div class="fw-bold">
                                Tidak ada dokumen
                            </div>

                            <div class="text-muted fs-7">
                                Pelamar tidak mengunggah dokumen.
                            </div>

                        </div>

                    @endif

                </div>

            </div> --}}


        </div>



        {{-- =====================================================
            RIGHT
        ====================================================== --}}

        <div class="col-xl-4">


            {{-- =================================================
                STATUS
            ================================================== --}}
            @if($job->status == 'published')
                <div class="card mb-5">

                    <div class="card-header">

                        <div class="card-title">

                            <h3 class="fw-bold m-0">
                                Status Lamaran
                            </h3>

                        </div>

                    </div>


                    <div class="card-body">


                        <div class="mb-5">

                            <label class="form-label fw-semibold">

                                Status

                            </label>


                            <select
                                id="applicationStatus"
                                class="form-select"
                            >

                                <option
                                    value="applied"
                                    @selected(
                                        $application->status === 'applied'
                                    )
                                >
                                    Applied
                                </option>


                                <option
                                    value="reviewed"
                                    @selected(
                                        $application->status === 'reviewed'
                                    )
                                >
                                    Reviewed
                                </option>


                                <option
                                    value="shortlisted"
                                    @selected(
                                        $application->status === 'shortlisted'
                                    )
                                >
                                    Shortlisted
                                </option>


                                <option
                                    value="rejected"
                                    @selected(
                                        $application->status === 'rejected'
                                    )
                                >
                                    Rejected
                                </option>

                            </select>

                        </div>


                        <button
                            type="button"
                            id="btnUpdateStatus"
                            class="btn btn-primary w-100"
                        >

                            <i class="fas fa-save me-2"></i>

                            Simpan Status

                        </button>

                    </div>

                </div>
            @endif



            {{-- =================================================
                INFORMASI LAMARAN
            ================================================== --}}

            <div class="card mb-5">

                <div class="card-header">

                    <div class="card-title">

                        <h3 class="fw-bold m-0">
                            Informasi Lamaran
                        </h3>

                    </div>

                </div>


                <div class="card-body">


                    <div class="mb-5">

                        <div class="text-muted fs-7">
                            ID Lamaran
                        </div>

                        <div class="fw-bold">

                            #{{ str_pad(
                                $application->id,
                                6,
                                '0',
                                STR_PAD_LEFT
                            ) }}

                        </div>

                    </div>


                    <div class="mb-5">

                        <div class="text-muted fs-7">
                            Tanggal Melamar
                        </div>

                        <div class="fw-bold">

                            {{ $application->created_at
                                ? $application->created_at
                                    ->translatedFormat('d F Y H:i')
                                : '-' }}

                        </div>

                    </div>


                    <div>

                        <div class="text-muted fs-7">
                            Posisi
                        </div>

                        <div class="fw-bold">

                            {{ $job->position ?? '-' }}

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

    $(document).on(
        'click',
        '#btnUpdateStatus',
        function () {

            const button = $(this);

            const status =
                $('#applicationStatus').val();


            Swal.fire({

                title: 'Ubah Status Pelamar?',

                text: 'Status pelamar akan diperbarui.',

                icon: 'question',

                showCancelButton: true,

                confirmButtonText: 'Ya, Simpan',

                cancelButtonText: 'Batal'

            }).then(function(result) {

                if (!result.isConfirmed) {

                    return;

                }


                button
                    .prop('disabled', true)
                    .addClass('disabled');


                $.ajax({

                    url: "{{ route(
                        'dashboard-user.job-application.status',
                        [
                            'uuid' => $job->uuid,
                            'application' => $application->id
                        ]
                    ) }}",

                    type: "POST",

                    data: {

                        _token:
                            "{{ csrf_token() }}",

                        status: status

                    },


                    success: function(response) {

                        if (!response.success) {

                            Swal.fire({

                                icon: 'error',

                                title: 'Gagal',

                                text:
                                    response.message ??
                                    'Gagal memperbarui status.'

                            });

                            return;

                        }


                        Swal.fire({

                            icon: 'success',

                            title: 'Berhasil',

                            text:
                                response.message ??
                                'Status berhasil diperbarui.',

                            timer: 1500,

                            showConfirmButton: false

                        });


                        /*
                        |--------------------------------------------------------------------------
                        | UPDATE BADGE HEADER
                        |--------------------------------------------------------------------------
                        */

                        setTimeout(function() {

                            location.reload();

                        }, 1500);

                    },


                    error: function(xhr) {

                        console.error(
                            xhr.responseText
                        );


                        Swal.fire({

                            icon: 'error',

                            title: 'Gagal',

                            text:
                                xhr.responseJSON?.message ??
                                'Terjadi kesalahan.'

                        });

                    },


                    complete: function() {

                        button
                            .prop('disabled', false)
                            .removeClass('disabled');

                    }

                });

            });

        }

    );

</script>

@endsection