@extends('layouts.dashboard-admin')

@section('title', 'Detail Partner')


@section('css')

    <style>

        .partner-logo {
            width: 90px;
            height: 90px;
            object-fit: contain;
            border-radius: 12px;
            border: 1px solid var(--bs-border-color);
            padding: 8px;
            background-color: var(--bs-body-bg);
        }

        .partner-logo-placeholder {
            width: 90px;
            height: 90px;
            border-radius: 12px;
            border: 1px solid var(--bs-border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: var(--bs-secondary-color);
            background-color: var(--bs-tertiary-bg);
        }


        /* ============================================================
        INFORMATION
        ============================================================ */

        .info-label {
            font-size: 12px;
            color: var(--bs-secondary-color);
            margin-bottom: 3px;
        }

        .info-value {
            font-size: 14px;
            font-weight: 500;
            color: var(--bs-body-color);
        }

        .info-value a {
            color: var(--bs-primary);
            text-decoration: none;
        }

        .info-value a:hover {
            text-decoration: underline;
        }


        /* ============================================================
        STAT CARD
        ============================================================ */

        .stat-card {
            border: 1px solid var(--bs-border-color);
            border-radius: 10px;
            padding: 18px;
            height: 100%;
            background-color: var(--bs-body-bg);
        }

        .stat-title {
            font-size: 12px;
            color: var(--bs-secondary-color);
            margin-bottom: 5px;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: var(--bs-body-color);
        }


        /* ============================================================
        SECURITY PHOTO
        ============================================================ */

        .security-photo {
            width: 55px;
            height: 55px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid var(--bs-border-color);
        }

        .security-photo-placeholder {
            width: 55px;
            height: 55px;
            border-radius: 8px;
            background-color: var(--bs-tertiary-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--bs-secondary-color);
            font-size: 20px;
        }


        /* ============================================================
        SECURITY CARD
        ============================================================ */

        .security-card {
            border: 1px solid var(--bs-border-color);
            border-radius: 10px;
            padding: 15px;
            height: 100%;
            background-color: var(--bs-body-bg);
        }

        .security-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--bs-body-color);
        }

        .security-meta {
            font-size: 12px;
            color: var(--bs-secondary-color);
        }


        /* ============================================================
        HR
        ============================================================ */

        .security-card hr {
            border-color: var(--bs-border-color);
            opacity: 1;
        }


        /* ============================================================
        CARD HEADER
        ============================================================ */

        .card-title {
            color: var(--bs-body-color);
        }


        /* ============================================================
        RESPONSIVE
        ============================================================ */

        @media (max-width: 767px) {

            .partner-logo,
            .partner-logo-placeholder {
                width: 70px;
                height: 70px;
            }

            .stat-value {
                font-size: 20px;
            }

            .security-card {
                padding: 13px;
            }

        }

    </style>

@endsection


@section('breadcrumb')

    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">

        Detail Partner

    </h1>


    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">

        <li class="breadcrumb-item text-muted">

            <a
                href="javascript:;"
                class="text-muted text-hover-primary">

                Beranda

            </a>

        </li>


        <li class="breadcrumb-item">

            <span class="bullet bg-gray-500 w-5px h-2px"></span>

        </li>


        <li class="breadcrumb-item text-muted">

            Management User

        </li>


        <li class="breadcrumb-item">

            <span class="bullet bg-gray-500 w-5px h-2px"></span>

        </li>


        <li class="breadcrumb-item text-muted">

            Partner

        </li>


        <li class="breadcrumb-item">

            <span class="bullet bg-gray-500 w-5px h-2px"></span>

        </li>


        <li class="breadcrumb-item text-muted">

            Detail

        </li>

    </ul>

@endsection



@section('content')


{{-- ============================================================
   HEADER
============================================================ --}}

<div class="d-flex align-items-center justify-content-between mb-4">

        <div>

        </div>

        <a href="{{ route('dashboard-admin.management-user.partner.index') }}"
        class="btn btn-light">

            <i class="fas fa-arrow-left me-2"></i>

            Kembali

        </a>

</div>

<div class="row mb-5">

    <div class="col-lg-12">

        <div class="card">

            <div class="card-body">

                <div class="d-flex align-items-center flex-wrap gap-4">


                    {{-- LOGO --}}

                    <div>

                        @if($partner->logo)

                            <img
                                src="{{ asset('storage/' . $partner->logo) }}"
                                class="partner-logo"
                                alt="{{ $partner->name }}">

                        @else

                            <div class="partner-logo-placeholder">

                                <i class="fas fa-handshake"></i>

                            </div>

                        @endif

                    </div>


                    {{-- PARTNER INFO --}}

                    <div class="flex-grow-1">

                        <div class="d-flex align-items-center gap-2 flex-wrap">

                            <h2 class="mb-1 fs-4 fw-bold">

                                {{ $partner->name }}

                            </h2>


                            @if($partner->is_active)

                                <span class="badge badge-light-success">

                                    Aktif

                                </span>

                            @else

                                <span class="badge badge-light-danger">

                                    Tidak Aktif

                                </span>

                            @endif

                        </div>


                        @if($partner->description)

                            <div class="text-muted fs-7">

                                {{ $partner->description }}

                            </div>

                        @endif

                    </div>


                </div>

            </div>

        </div>

    </div>

</div>



{{-- ============================================================
   STATISTIK
============================================================ --}}

<div class="row g-4 mb-5">


    {{-- TOTAL SECURITY --}}

    <div class="col-md-4">

        <div class="stat-card">

            <div class="stat-title">

                Total Security

            </div>

            <div class="stat-value">

                {{ number_format($totalSecurity) }}

            </div>

            <div class="text-muted fs-8">

                Security terhubung dengan partner

            </div>

        </div>

    </div>


    {{-- STATUS PARTNER --}}

    <div class="col-md-4">

        <div class="stat-card">

            <div class="stat-title">

                Status Partner

            </div>

            <div class="stat-value fs-5 mt-2">

                @if($partner->is_active)

                    <span class="badge badge-light-success">

                        Aktif

                    </span>

                @else

                    <span class="badge badge-light-danger">

                        Tidak Aktif

                    </span>

                @endif

            </div>

            <div class="text-muted fs-8 mt-2">

                Status kerja sama partner

            </div>

        </div>

    </div>


    {{-- URUTAN --}}

    <div class="col-md-4">

        <div class="stat-card">

            <div class="stat-title">

                Urutan

            </div>

            <div class="stat-value">

                {{ $partner->order ?? 0 }}

            </div>

            <div class="text-muted fs-8">

                Urutan tampilan partner

            </div>

        </div>

    </div>

</div>



{{-- ============================================================
   INFORMASI PARTNER
============================================================ --}}

<div class="row mb-5">

    <div class="col-lg-12">

        <div class="card">

            <div class="card-header">

                <h5 class="card-title mb-0">

                    Informasi Partner

                </h5>

            </div>


            <div class="card-body">

                <div class="row g-5">


                    {{-- NAMA --}}

                    <div class="col-md-6">

                        <div class="info-label">

                            Nama Partner

                        </div>

                        <div class="info-value">

                            {{ $partner->name ?: '-' }}

                        </div>

                    </div>


                    {{-- TELEPON --}}

                    <div class="col-md-6">

                        <div class="info-label">

                            Nomor Telepon

                        </div>

                        <div class="info-value">

                            {{ $partner->phone ?: '-' }}

                        </div>

                    </div>


                    {{-- WEBSITE --}}

                    <div class="col-md-6">

                        <div class="info-label">

                            Website

                        </div>

                        <div class="info-value">

                            @if($partner->website)

                                <a
                                    href="{{ $partner->website }}"
                                    target="_blank"
                                    rel="noopener noreferrer">

                                    {{ $partner->website }}

                                </a>

                            @else

                                -

                            @endif

                        </div>

                    </div>


                    {{-- ALAMAT --}}

                    <div class="col-md-6">

                        <div class="info-label">

                            Alamat

                        </div>

                        <div class="info-value">

                            {{ $partner->address ?: '-' }}

                        </div>

                    </div>


                    {{-- DESKRIPSI --}}

                    <div class="col-12">

                        <div class="info-label">

                            Deskripsi

                        </div>

                        <div class="info-value">

                            {{ $partner->description ?: '-' }}

                        </div>

                    </div>


                </div>

            </div>

        </div>

    </div>

</div>



{{-- ============================================================
   LIST SECURITY
============================================================ --}}

<div class="row">

    <div class="col-lg-12">

        <div class="card">

            <div class="card-header">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <h5 class="card-title mb-1">

                            Security Terdaftar

                        </h5>

                        <span class="text-muted fs-7">

                            Daftar security yang terhubung dengan partner ini

                        </span>

                        <span class="badge badge-light-primary">
    
                            {{ $totalSecurity }} Security
    
                        </span>
                    </div>


                </div>

            </div>


            <div class="card-body">


                @if($securities->count() > 0)

                    <div class="row g-4">

                        @foreach($securities as $security)

                            <div class="col-xl-4 col-md-6">

                                <div class="security-card">

                                    <div class="d-flex align-items-center">


                                        {{-- FOTO --}}

                                        <div class="me-3">

                                            @if($security->formal_photo)

                                                <img
                                                    src="{{ asset('storage/' . $security->formal_photo) }}"
                                                    class="security-photo"
                                                    alt="{{ $security->name }}">

                                            @else

                                                <div class="security-photo-placeholder">

                                                    <i class="fas fa-user"></i>

                                                </div>

                                            @endif

                                        </div>


                                        {{-- DATA --}}

                                        <div class="flex-grow-1">

                                            <div class="security-name">

                                                {{ $security->name ?: 'Nama belum diisi' }}

                                            </div>


                                            <div class="security-meta">

                                                {{ $security->registration_number ?: '-' }}

                                            </div>


                                            @if($security->phone_number)

                                                <div class="security-meta">

                                                    {{ $security->phone_number }}

                                                </div>

                                            @endif

                                        </div>


                                        {{-- DETAIL --}}

                                        <div>

                                            @if($security->uuid)

                                                <a
                                                    href="{{ route('dashboard-admin.management-user.security.show', $security->uuid) }}"
                                                    class="btn btn-sm btn-light-primary"
                                                    data-bs-toggle="tooltip"
                                                    title="Detail Security">

                                                    <i class="fas fa-eye"></i>

                                                </a>

                                            @endif

                                        </div>

                                    </div>


                                    <hr>


                                    {{-- DETAIL RINGKAS --}}

                                    <div class="row g-3">


                                        {{-- GENDER --}}

                                        <div class="col-6">

                                            <div class="info-label">

                                                Jenis Kelamin

                                            </div>

                                            <div class="security-meta">

                                                {{ $security->gender ?: '-' }}

                                            </div>

                                        </div>


                                        {{-- LOKASI --}}

                                        <div class="col-6">

                                            <div class="info-label">

                                                Lokasi

                                            </div>

                                            <div class="security-meta">

                                                @if($security->city)

                                                    {{ $security->city }}

                                                @elseif($security->province)

                                                    {{ $security->province }}

                                                @else

                                                    -

                                                @endif

                                            </div>

                                        </div>


                                        {{-- SERTIFIKAT --}}

                                        <div class="col-6">

                                            <div class="info-label">

                                                Sertifikat

                                            </div>

                                            <div class="security-meta">

                                                @if(isset($security->certificates))

                                                    {{ $security->certificates->count() }}

                                                @else

                                                    0

                                                @endif

                                                Sertifikat

                                            </div>

                                        </div>


                                        {{-- RIWAYAT KERJA --}}

                                        <div class="col-6">

                                            <div class="info-label">

                                                Riwayat Kerja

                                            </div>

                                            <div class="security-meta">

                                                {{ $security->histories->count() }}

                                                Riwayat

                                            </div>

                                        </div>


                                    </div>


                                    {{-- STATUS KESEDIAAN --}}

                                    <div class="mt-3">

                                        @if($security->is_shift_agree)

                                            <span class="badge badge-light-primary me-1">

                                                Siap Shift

                                            </span>

                                        @endif


                                        @if($security->is_out_of_town_agree)

                                            <span class="badge badge-light-info">

                                                Siap Luar Kota

                                            </span>

                                        @endif

                                    </div>

                                </div>

                            </div>

                        @endforeach

                    </div>

                @else

                    {{-- EMPTY --}}

                    <div class="text-center py-10">

                        <div class="mb-4">

                            <i
                                class="fas fa-users"
                                style="
                                    font-size:50px;
                                    color:#a1a5b7;
                                ">
                            </i>

                        </div>

                        <h5 class="fw-bold">

                            Belum Ada Security

                        </h5>

                        <div class="text-muted fs-7">

                            Belum ada security yang terhubung dengan partner ini.

                        </div>

                    </div>

                @endif

            </div>

        </div>

    </div>

</div>

@endsection



@section('js')

<script>

    $(document).ready(function () {

        $('[data-bs-toggle="tooltip"]').tooltip();

    });

</script>

@endsection