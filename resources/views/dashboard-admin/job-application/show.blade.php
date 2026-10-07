@extends('layouts.dashboard-admin')

@section('content')

    @php
        /*
        |--------------------------------------------------------------------------
        | APPLICANT
        |--------------------------------------------------------------------------
        | security = Security / Satpam
        | cs       = Cleaning Service
        |--------------------------------------------------------------------------
        */
        $applicant = $job->category === 'cs'
            ? $application->cleaning_service
            : $application->security;
    @endphp

    <div class="container-fluid py-5">

        {{-- BACK --}}
        <div class="d-flex align-items-center justify-content-between mb-4">

            <div></div>

            <a
                href="javascript:history.back()"
                class="btn btn-light"
            >
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


                        {{-- CATEGORY --}}
                        <div class="mt-3">

                            @if($job->category === 'security')

                                <span class="badge job-category-badge job-category-security">

                                    <i class="fas fa-shield-alt me-1"></i>

                                    Satpam

                                </span>

                            @elseif($job->category === 'cs')

                                <span class="badge job-category-badge job-category-cs">

                                    <i class="fas fa-broom me-1"></i>

                                    Cleaning Service

                                </span>

                            @else

                                <span class="badge job-category-badge job-category-default">

                                    <i class="fas fa-question-circle me-1"></i>

                                    -

                                </span>

                            @endif

                        </div>

                    </div>


                    {{-- STATUS --}}
                    <div>

                        @switch(strtolower($application->status))

                            @case('applied')

                                <span class="badge badge-light-primary fs-6 px-4 py-3">

                                    <i class="fas fa-paper-plane me-2"></i>

                                    Applied

                                </span>

                            @break


                            @case('reviewed')

                                <span class="badge badge-light-warning fs-6 px-4 py-3">

                                    <i class="fas fa-eye me-2"></i>

                                    Reviewed

                                </span>

                            @break


                            @case('shortlisted')

                                <span class="badge badge-light-success fs-6 px-4 py-3">

                                    <i class="fas fa-user-check me-2"></i>

                                    Shortlisted

                                </span>

                            @break


                            @case('rejected')

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


                            {{-- FOTO --}}
                            <div class="symbol symbol-100px symbol-circle me-5 overflow-hidden">

                                @if($applicant?->formal_photo)

                                    <img
                                        src="{{ asset('storage/' . $applicant->formal_photo) }}"
                                        alt="{{ $applicant?->name }}"
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


                            {{-- IDENTITAS --}}
                            <div>

                                <h2 class="fw-bold mb-2">

                                    {{ $applicant?->name ?? '-' }}

                                </h2>


                                <div class="text-muted mb-2">

                                    <i class="fas fa-envelope me-2"></i>

                                    {{ $applicant?->email ?? '-' }}

                                </div>


                                <div class="text-muted">

                                    <i class="fas fa-phone me-2"></i>

                                    {{ $applicant?->phone ?? '-' }}

                                </div>

                            </div>

                        </div>


                        <div class="separator mb-7"></div>


                        {{-- BIODATA --}}
                        <div class="row g-6">


                            {{-- NAMA --}}
                            <div class="col-md-6">

                                <div class="text-muted fs-7 mb-1">
                                    Nama Lengkap
                                </div>

                                <div class="fw-bold">
                                    {{ $applicant?->name ?? '-' }}
                                </div>

                            </div>


                            {{-- EMAIL --}}
                            <div class="col-md-6">

                                <div class="text-muted fs-7 mb-1">
                                    Email
                                </div>

                                <div class="fw-bold">
                                    {{ $applicant?->email ?? '-' }}
                                </div>

                            </div>


                            {{-- KTP --}}
                            <div class="col-md-6">

                                <div class="text-muted fs-7 mb-1">
                                    Nomor KTP
                                </div>

                                <div class="fw-bold">
                                    {{ $applicant?->ktp_number ?? '-' }}
                                </div>

                            </div>


                            {{-- PHONE --}}
                            <div class="col-md-6">

                                <div class="text-muted fs-7 mb-1">
                                    Nomor Telepon
                                </div>

                                <div class="fw-bold">
                                    {{ $applicant?->phone ?? '-' }}
                                </div>

                            </div>


                            {{-- CATEGORY --}}
                            <div class="col-md-6">

                                <div class="text-muted fs-7 mb-1">
                                    Kategori
                                </div>

                                <div class="fw-bold">

                                    @if($job->category === 'security')

                                        <span class="badge job-category-badge job-category-security">

                                            <i class="fas fa-shield-alt me-1"></i>

                                            Satpam

                                        </span>

                                    @elseif($job->category === 'cs')

                                        <span class="badge job-category-badge job-category-cs">

                                            <i class="fas fa-broom me-1"></i>

                                            Cleaning Service

                                        </span>

                                    @else

                                        -

                                    @endif

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


                        {{-- JOB HEADER --}}
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


                        {{-- JOB INFORMATION --}}
                        <div class="row g-6">


                            {{-- CATEGORY --}}
                            <div class="col-md-4">

                                <div class="text-muted fs-7">
                                    Kategori
                                </div>

                                <div class="fw-bold mt-1">

                                    @if($job->category === 'security')

                                        <span class="badge job-category-badge job-category-security">

                                            <i class="fas fa-shield-alt me-1"></i>

                                            Satpam

                                        </span>

                                    @elseif($job->category === 'cs')

                                        <span class="badge job-category-badge job-category-cs">

                                            <i class="fas fa-broom me-1"></i>

                                            Cleaning Service

                                        </span>

                                    @else

                                        -

                                    @endif

                                </div>

                            </div>


                            {{-- JENIS PEKERJAAN --}}
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


                            {{-- SISTEM KERJA --}}
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


                            {{-- KUOTA --}}
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


            </div>


            {{-- =====================================================
                RIGHT
            ====================================================== --}}
            <div class="col-xl-4">


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


                        {{-- ID --}}
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


                        {{-- TANGGAL --}}
                        <div class="mb-5">

                            <div class="text-muted fs-7">
                                Tanggal Melamar
                            </div>

                            <div class="fw-bold">

                                {{ $application->created_at
                                    ? $application->created_at->translatedFormat('d F Y H:i')
                                    : '-' }}

                            </div>

                        </div>


                        {{-- POSISI --}}
                        <div class="mb-5">

                            <div class="text-muted fs-7">
                                Posisi
                            </div>

                            <div class="fw-bold">

                                {{ $job->position ?? '-' }}

                            </div>

                        </div>


                        {{-- CATEGORY --}}
                        <div>

                            <div class="text-muted fs-7">
                                Kategori
                            </div>

                            <div class="fw-bold mt-1">

                                @if($job->category === 'security')

                                    <span class="badge job-category-badge job-category-security">

                                        <i class="fas fa-shield-alt me-1"></i>

                                        Satpam

                                    </span>

                                @elseif($job->category === 'cs')

                                    <span class="badge job-category-badge job-category-cs">

                                        <i class="fas fa-broom me-1"></i>

                                        Cleaning Service

                                    </span>

                                @else

                                    -

                                @endif

                            </div>

                        </div>

                    </div>

                </div>


            </div>

        </div>

    </div>

@endsection


@section('css')

<style>

    .job-category-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 10px;
        border-radius: 7px;
        font-size: 11px;
        font-weight: 700;
        line-height: 1;
    }

    .job-category-security {
        background: #edf5ff;
        color: #4d86cc;
    }

    .job-category-cs {
        background: #edf4f0;
        color: #3b765c;
    }

    .job-category-default {
        background: #f1f3f5;
        color: #6c757d;
    }

</style>

@endsection


@section('js')

<script>

</script>

@endsection