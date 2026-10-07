@extends('layouts.dashboard-user')

@section('title', 'Profil Perusahaan')

@section('css')
    <style>
        /* =========================================================
        THEME VARIABLES
        ========================================================= */

        :root,
        [data-bs-theme="light"] {
            --company-bg: #ffffff;
            --company-surface: #ffffff;
            --company-surface-soft: #f8fafc;

            --company-text: #182338;
            --company-text-secondary: #64748b;
            --company-text-muted: #94a3b8;

            --company-border: #e2e8f0;
            --company-border-soft: rgba(15, 23, 42, .07);

            --company-gold: #f7b003;
            --company-gold-hover: #ffc928;
            --company-gold-soft: rgba(247, 176, 3, .10);
            --company-gold-border: rgba(247, 176, 3, .35);

            --company-logo-border: #ffffff;

            --company-cover-start: #f7b003;
            --company-cover-end: #dfe6f1;

            --company-table-text: #64748b;
            --company-table-border: #e5e7eb;

            --company-empty: #64748b;

            --company-shadow: 0 6px 20px rgba(15, 23, 42, .06);
        }


        [data-bs-theme="dark"] {
            --company-bg: #11192d;
            --company-surface: #11192d;
            --company-surface-soft: #18233d;

            --company-text: #ffffff;
            --company-text-secondary: #91a0bc;
            --company-text-muted: #73819d;

            --company-border: rgba(255, 255, 255, .06);
            --company-border-soft: rgba(255, 255, 255, .05);

            --company-gold: #f7b003;
            --company-gold-hover: #ffc928;
            --company-gold-soft: rgba(247, 176, 3, .12);
            --company-gold-border: rgba(247, 176, 3, .35);

            --company-logo-border: #11192d;

            --company-cover-start: #f7b003;
            --company-cover-end: #1c2848;

            --company-table-text: #9ca9c5;
            --company-table-border: rgba(255, 255, 255, .05);

            --company-empty: #90a0be;

            --company-shadow: 0 6px 20px rgba(0, 0, 0, .18);
        }


        /* =========================================================
        COMPANY WRAPPER
        ========================================================= */

        .company-wrapper {
            background: var(--company-surface);

            border: 1px solid var(--company-border);
            border-radius: 20px;

            overflow: hidden;

            box-shadow: var(--company-shadow);
        }


        /* =========================================================
        COMPANY COVER
        ========================================================= */

        .company-cover {
            height: 170px;

            background: linear-gradient(
                135deg,
                var(--company-cover-start),
                var(--company-cover-end)
            );
        }


        /* =========================================================
        COMPANY HEADER
        ========================================================= */

        .company-header {
            display: flex;
            gap: 25px;

            padding: 0 24px 24px;

            margin-top: -55px;
        }


        /* =========================================================
        COMPANY LOGO
        ========================================================= */

        .company-logo {
            width: 110px;
            height: 110px;

            object-fit: cover;

            border-radius: 18px;

            background: #fff;

            border: 4px solid var(--company-logo-border);

            box-shadow: 0 4px 12px rgba(15, 23, 42, .12);
        }


        /* =========================================================
        COMPANY NAME
        ========================================================= */

        .company-name {
            color: var(--company-text);

            font-size: 22px;
            font-weight: 700;

            margin-top: 55px;
        }


        /* =========================================================
        COMPANY INDUSTRY
        ========================================================= */

        .company-industry {
            color: var(--company-gold);

            font-size: 13px;

            margin-top: 4px;
        }


        /* =========================================================
        COMPANY LOCATION
        ========================================================= */

        .company-location {
            color: var(--company-text-secondary);

            font-size: 12px;

            margin-top: 6px;
        }


        /* =========================================================
        COMPANY TITLE
        ========================================================= */

        .company-title {
            padding: 14px 24px;

            font-size: 14px;
            font-weight: 700;

            color: var(--company-text);

            border-bottom: 1px solid var(--company-border-soft);

            background: transparent;
        }


        /* =========================================================
        COMPANY BODY
        ========================================================= */

        .company-body {
            padding: 24px;

            color: var(--company-text-secondary);

            font-size: 13px;

            line-height: 1.8;
        }


        /* =========================================================
        COMPANY ITEM
        ========================================================= */

        .company-item {
            margin-bottom: 18px;
        }

        .company-item:last-child {
            margin-bottom: 0;
        }


        /* =========================================================
        TABLE
        ========================================================= */

        .company-wrapper .table-dark {
            --bs-table-bg: transparent;
            --bs-table-color: var(--company-table-text);
        }


        .company-wrapper .table-dark td {
            color: var(--company-table-text);

            border-color: var(--company-table-border);

            background: transparent;
        }


        .company-wrapper .table-dark th {
            color: var(--company-text);

            border-color: var(--company-table-border);

            background: transparent;
        }


        /* =========================================================
        EDIT BUTTON
        ========================================================= */

        .company-edit-btn {
            width: 100%;

            border-radius: 12px;

            font-size: 11px;
            font-weight: 600;

            padding: 5px 16px;

            transition: .25s;
        }


        .company-edit-btn:hover {
            transform: translateY(-2px);

            box-shadow: 0 8px 20px rgba(247, 176, 3, .25);
        }


        /* =========================================================
        EMPTY STATE
        ========================================================= */

        .company-empty {
            display: inline-flex;

            align-items: center;

            gap: 6px;

            color: var(--company-empty);

            font-size: 12px;

            font-style: italic;
        }


        .company-empty i {
            color: var(--company-gold);
        }


        /* =========================================================
        EMPTY BADGE
        ========================================================= */

        .company-empty-badge {
            display: inline-block;

            margin-left: 8px;

            padding: 3px 8px;

            border-radius: 999px;

            background: var(--company-gold-soft);

            border: 1px solid var(--company-gold-border);

            color: var(--company-gold);

            font-size: 10px;

            font-weight: 600;
        }


        /* =========================================================
        SOCIAL DISABLED
        ========================================================= */

        .company-social-disabled {
            opacity: .45;

            pointer-events: none;
        }


        /* =========================================================
        RESPONSIVE
        ========================================================= */

        @media (max-width: 768px) {

            .company-cover {
                height: 140px;
            }

            .company-header {
                gap: 16px;

                padding: 0 18px 20px;

                margin-top: -45px;
            }

            .company-logo {
                width: 85px;
                height: 85px;

                border-radius: 15px;
            }

            .company-name {
                font-size: 19px;

                margin-top: 45px;
            }

            .company-industry {
                font-size: 12px;
            }

            .company-location {
                font-size: 11px;
            }

            .company-title {
                padding: 13px 18px;
            }

            .company-body {
                padding: 18px;
            }
        }
    </style>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
@endsection

@section('content')
    <!--begin::Title-->
    <h1
        class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
        Profil Perusahaan</h1>
    <!--end::Title-->
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1 mb-3">
        <!--begin::Item-->
        <li class="breadcrumb-item text-muted">
            <a href="javascript:;" class="text-muted text-hover-primary">Beranda</a>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-500 w-5px h-2px"></span>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item text-muted">Profil Perusahaan</li>
        <!--end::Item-->
    </ul>
    <!--end::Breadcrumb-->

    <div class="row">

        <!-- LEFT -->
        <div class="col-lg-8">

            <!-- HEADER -->
            <div class="company-wrapper mb-5">

                <div class="company-cover"></div>

                <div class="company-header">

                    <img
                        src="{{ $profile->logo ? Storage::url($profile->logo) : asset('/assets/media/avatars/blank.png') }}"
                        class="company-logo">

                    <div class="flex-grow-1">

                        <div class="company-name">

                            {{ $profile->company_name ?: 'Perusahaan Belum Memiliki Nama' }}

                            @if($profile->is_verified)

                                <span class="badge bg-success ms-2">
                                    Terverifikasi
                                </span>

                            @endif

                        </div>

                        <div class="company-industry">

                            @if($profile->industry)

                                {{ $profile->industry }}

                            @else

                                <span class="company-empty">

                                    <i class="ki-duotone ki-information-2"></i>

                                    Belum memilih bidang usaha

                                </span>

                            @endif

                        </div>

                        <div class="company-location">

                            @if($profile->city || $profile->province)

                                <i class="ki-duotone ki-geolocation me-1"></i>

                                {{ $profile->city }}{{ $profile->city && $profile->province ? ',' : '' }}
                                {{ $profile->province }}

                            @else

                                <span class="company-empty">

                                    <i class="ki-duotone ki-geolocation"></i>

                                    Lokasi belum diisi

                                </span>

                            @endif

                        </div>

                        <a href="{{ route('dashboard-user.profile.edit-personal-data') }}"
                            class="btn btn-warning company-edit-btn mt-4">

                            <i class="ki-duotone ki-notepad-edit me-2"></i>

                            Edit Profil Perusahaan

                        </a>

                    </div>

                </div>

            </div>

            <!-- TENTANG -->

            <div class="company-wrapper mb-5">

                <div class="company-title">

                    Tentang Perusahaan

                </div>

                <div class="company-body">

                    @if($profile->description)

                        {{ $profile->description }}

                    @else

                        <div class="company-empty">

                            <i class="ki-duotone ki-document"></i>

                            Perusahaan belum menambahkan deskripsi.

                        </div>

                    @endif

                </div>

            </div>

            <!-- ALAMAT -->

            <div class="company-wrapper">

                <div class="company-title">

                    Alamat

                </div>

                <div class="company-body">

                    <table class="table table-borderless table-dark align-middle mb-0">

                        <tr>

                            <td width="180">
                                Alamat
                            </td>

                            <td>

                                @if($profile->address)

                                    {{ $profile->address }}

                                @else

                                    <span class="company-empty">

                                        Belum melengkapi alamat

                                    </span>

                                @endif

                            </td>

                        </tr>

                        <tr>

                            <td>
                                Kelurahan
                            </td>

                            <td>

                                @if($profile->village)

                                    {{ $profile->village }}

                                @else

                                    <span class="company-empty">

                                        Belum melengkapi kelurahan

                                    </span>

                                @endif

                            </td>

                        </tr>

                        <tr>

                            <td>
                                Kecamatan
                            </td>

                            <td>

                                @if($profile->district)

                                    {{ $profile->district }}

                                @else

                                    <span class="company-empty">

                                        Belum melengkapi kecamatan

                                    </span>

                                @endif

                            </td>

                        </tr>

                        <tr>

                            <td>
                                Kota
                            </td>

                            <td>

                                @if($profile->city)

                                    {{ $profile->city }}

                                @else

                                    <span class="company-empty">

                                        Belum melengkapi kota

                                    </span>

                                @endif

                            </td>

                        </tr>

                        <tr>

                            <td>
                                Provinsi
                            </td>

                            <td>

                                @if($profile->province)

                                    {{ $profile->province }}

                                @else

                                    <span class="company-empty">

                                        Belum melengkapi provinsi

                                    </span>

                                @endif

                            </td>

                        </tr>

                        <tr>

                            <td>
                                Kode Pos
                            </td>

                            <td>

                                @if($profile->postal_code)

                                    {{ $profile->postal_code }}

                                @else

                                    <span class="company-empty">

                                        Belum melengkapi kode pos

                                    </span>

                                @endif

                            </td>

                        </tr>

                    </table>

                </div>

            </div>

        </div>


        <!-- RIGHT -->

        <div class="col-lg-4">

            <!-- KONTAK -->

            <div class="company-wrapper mb-5">

                <div class="company-title">

                    Informasi Kontak

                </div>

                <div class="company-body">

                    <div class="company-item">

                        <i class="ki-duotone ki-sms fs-3 text-warning"></i>

                        {!! $profile->email
                            ? e($profile->email)
                            : '<span class="company-empty">Belum menambahkan email</span>' !!}

                    </div>

                    <div class="company-item">

                        <i class="ki-duotone ki-phone fs-3 text-warning"></i>

                        {!! $profile->phone
                            ? e($profile->phone)
                            : '<span class="company-empty">Belum menambahkan nomor telepon</span>' !!}

                    </div>

                    <div class="company-item">

                        <i class="ki-duotone ki-global fs-3 text-warning"></i>

                        @if($profile->website)

                            <a href="{{ $profile->website }}"
                            target="_blank">

                                {{ $profile->website }}

                            </a>

                        @else

                            <span class="company-empty">

                                Belum memiliki website

                            </span>

                        @endif

                    </div>

                </div>

            </div>

            <!-- LEGITAS -->

            <div class="company-wrapper mb-5">

                <div class="company-title">
                    Legalitas
                </div>

                <div class="company-body">

                    {{-- NIB --}}
                    <div class="company-item">

                        <strong>Nomor Induk Berusaha (NIB)</strong>
                        <br>

                        @if($profile->nib)

                            {{ $profile->nib }}

                        @else

                            <span class="company-empty">
                                Belum melengkapi NIB
                            </span>

                            <span class="company-empty-badge">
                                Belum Diisi
                            </span>

                        @endif

                    </div>

                    <hr>

                    {{-- NPWP --}}
                    <div class="company-item">

                        <strong>NPWP</strong>
                        <br>

                        @if($profile->npwp)

                            {{ $profile->npwp }}

                        @else

                            <span class="company-empty">
                                Belum melengkapi NPWP
                            </span>

                            <span class="company-empty-badge">
                                Belum Diisi
                            </span>

                        @endif

                    </div>

                    <hr>

                    {{-- SIUP --}}
                    <div class="company-item">

                        <strong>Nomor Izin Usaha / SIUP</strong>
                        <br>

                        @if($profile->siup)

                            {{ $profile->siup }}

                        @else

                            <span class="company-empty">
                                Belum melengkapi SIUP
                            </span>

                            <span class="company-empty-badge">
                                Belum Diisi
                            </span>

                        @endif

                    </div>
                    
                    @if(Auth::user()->role == 'bujp')
                        <hr>

                        {{-- Nomor SIO --}}
                        <div class="company-item">

                            <strong>Nomor Surat Izin Operasional</strong>
                            <br>

                            @if($profile->sio_number)

                                {{ $profile->sio_number }}

                            @else

                                <span class="company-empty">
                                    Belum melengkapi nomor SIO
                                </span>

                                <span class="company-empty-badge">
                                    Belum Diisi
                                </span>

                            @endif

                        </div>

                        <hr>

                        {{-- Masa Berlaku --}}
                        <div class="company-item">

                            <strong>Masa Berlaku SIO</strong>
                            <br>

                            @if($profile->sio_expired_date)

                                {{ \Carbon\Carbon::parse($profile->sio_expired_date)->translatedFormat('d F Y') }}

                                @if(\Carbon\Carbon::parse($profile->sio_expired_date)->isPast())

                                    <span class="badge bg-danger ms-2">
                                        Kedaluwarsa
                                    </span>

                                @else

                                    <span class="badge bg-success ms-2">
                                        Aktif
                                    </span>

                                @endif

                            @else

                                <span class="company-empty">
                                    Belum mengisi masa berlaku SIO
                                </span>

                                <span class="company-empty-badge">
                                    Belum Diisi
                                </span>

                            @endif

                        </div>

                        <hr>

                        {{-- Dokumen --}}
                        <div class="company-item">

                            <strong>Dokumen Surat Izin Operasional</strong>
                            <br>

                            @if($profile->sio_file)

                                <a href="{{ Storage::url($profile->sio_file) }}"
                                target="_blank"
                                class="btn btn-sm btn-warning mt-2">

                                    <i class="ki-duotone ki-document fs-6 me-1"></i>

                                    Lihat Dokumen

                                </a>

                            @else

                                <span class="company-empty">
                                    Dokumen SIO belum diunggah
                                </span>

                                <span class="company-empty-badge">
                                    Belum Diisi
                                </span>

                            @endif

                        </div>
                    @endif

                </div>

            </div>

            <!-- STATUS -->

            <div class="company-wrapper mb-5">

                <div class="company-title">

                    Status

                </div>

                <div class="company-body">

                    <div class="mb-3">

                        Status Akun

                        <br>

                        @if($profile->is_active)

                            <span class="badge bg-success">

                                Aktif

                            </span>

                        @else

                            <span class="badge bg-danger">

                                Tidak Aktif

                            </span>

                        @endif

                    </div>

                    <div>

                        Status Verifikasi

                        <br>

                        @if($profile->is_verified)

                            <span class="badge bg-success">

                                Terverifikasi

                            </span>

                        @else

                            <span class="badge bg-warning text-dark">

                                Belum Diverifikasi

                            </span>

                        @endif

                    </div>

                </div>

            </div>

            <!-- SOSIAL MEDIA -->

            <div class="company-wrapper">

                <div class="company-title">

                    Media Sosial

                </div>

                <div class="company-body text-center">

                    <a href="{{ $profile->instagram }}"
                        class="btn btn-icon btn-dark me-2 {{ !$profile->instagram ? 'company-social-disabled' : '' }}"
                        @if($profile->instagram)
                            target="_blank"
                        @endif>

                        <i class="bi bi-instagram"></i>

                    </a>

                    <a href="{{ $profile->facebook }}"
                        class="btn btn-icon btn-dark me-2 {{ !$profile->facebook ? 'company-social-disabled' : '' }}"
                        @if($profile->facebook)
                            target="_blank"
                        @endif>

                        <i class="bi bi-facebook"></i>

                    </a>

                    <a href="{{ $profile->linkedin }}"
                        class="btn btn-icon btn-dark me-2 {{ !$profile->linkedin ? 'company-social-disabled' : '' }}"
                        @if($profile->linkedin)
                            target="_blank"
                        @endif>

                        <i class="bi bi-linkedin"></i>

                    </a>

                    <a href="{{ $profile->youtube }}"
                        class="btn btn-icon btn-dark {{ !$profile->youtube ? 'company-social-disabled' : '' }}"
                        @if($profile->youtube)
                            target="_blank"
                        @endif>

                        <i class="bi bi-youtube"></i>

                    </a>

                </div>

            </div>

        </div>

    </div>
@endsection

@section('js')
    
@endsection