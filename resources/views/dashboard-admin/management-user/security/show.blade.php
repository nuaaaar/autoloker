@extends('layouts.dashboard-admin')

@section('title', 'Detail User')

@section('css')
    <style>
        /* =========================================================
        THEME VARIABLES
        ========================================================= */

        :root,
        [data-bs-theme="light"] {

            /* PROFILE */
            --security-cover-start: #1d2b64;
            --security-cover-mid: #304a8a;
            --security-cover-end: #f7b000;

            --security-photo-border: #ffffff;

            /* GENERAL */
            --security-text: #182338;
            --security-text-secondary: #64748b;
            --security-text-muted: #94a3b8;

            /* DETAIL */
            --detail-border: rgba(15, 23, 42, .08);
            --detail-hover: rgba(15, 23, 42, .025);

            --detail-label: #64748b;
            --detail-value: #182338;
            --detail-empty: #94a3b8;

            /* CARD */
            --admin-card-bg: #ffffff;
            --admin-card-border: #e2e8f0;
            --admin-card-hover-border: #f6b000;

            --admin-icon-bg: #f1f5f9;
            --admin-icon-color: #475569;

            /* SUMMARY */
            --summary-text: #1a1a1a;
            --summary-shadow: rgba(247, 176, 3, .25);

            /* BADGES */
            --badge-success: #198754;
            --badge-danger: #dc3545;
            --badge-warning: #f6b000;
            --badge-info: #0dcaf0;

            /* EMPTY STATE */
            --empty-title: #182338;
            --empty-text: #64748b;
        }


        [data-bs-theme="dark"] {

            /* PROFILE */
            --security-cover-start: #1d2b64;
            --security-cover-mid: #0b1120;
            --security-cover-end: #f7b000;

            --security-photo-border: #172238;

            /* GENERAL */
            --security-text: #ffffff;
            --security-text-secondary: #9ca3af;
            --security-text-muted: #6f7d97;

            /* DETAIL */
            --detail-border: rgba(255, 255, 255, .06);
            --detail-hover: rgba(255, 255, 255, .025);

            --detail-label: #8ea0be;
            --detail-value: #ffffff;
            --detail-empty: #6f7d97;

            /* CARD */
            --admin-card-bg: #172238;
            --admin-card-border: rgba(255, 255, 255, .06);
            --admin-card-hover-border: #f6b000;

            --admin-icon-bg: #222f4d;
            --admin-icon-color: #cbd5e1;

            /* SUMMARY */
            --summary-text: #1a1a1a;
            --summary-shadow: rgba(247, 176, 3, .25);

            /* BADGES */
            --badge-success: #198754;
            --badge-danger: #dc3545;
            --badge-warning: #f6b000;
            --badge-info: #0dcaf0;

            /* EMPTY STATE */
            --empty-title: #ffffff;
            --empty-text: #9ca3af;
        }


        /* =========================================================
        SECURITY COVER
        ========================================================= */

        .security-cover {
            height: 190px;

            background: linear-gradient(
                135deg,
                var(--security-cover-start),
                var(--security-cover-mid),
                var(--security-cover-end)
            );

            border-radius: .75rem .75rem 0 0;
        }


        /* =========================================================
        SECURITY PHOTO
        ========================================================= */

        .security-photo-wrapper {
            margin-top: -70px;
            position: relative;
        }


        .security-photo {
            width: 160px;
            height: 160px;

            object-fit: cover;

            border-radius: 18px;

            border: 6px solid var(--security-photo-border);

            box-shadow: 0 10px 25px rgba(0, 0, 0, .15);
        }


        .security-online {
            width: 20px;
            height: 20px;

            border-radius: 50%;

            background: #50cd89;

            border: 3px solid var(--security-photo-border);

            position: absolute;

            bottom: 18px;
            right: 60px;
        }


        /* =========================================================
        SUMMARY CARD
        ========================================================= */

        .summary-card {
            position: relative;

            overflow: hidden;

            border-radius: 18px;

            padding: 24px;

            background: linear-gradient(
                135deg,
                #f7b003 0%,
                #ffca3a 100%
            );

            color: var(--summary-text);

            box-shadow:
                0 10px 30px var(--summary-shadow);
        }


        .summary-card::after {
            content: '';

            position: absolute;

            right: -30px;
            top: -30px;

            width: 120px;
            height: 120px;

            border-radius: 50%;

            background: rgba(255, 255, 255, .18);
        }


        .summary-title {
            font-size: 13px;

            font-weight: 600;

            opacity: .8;

            text-transform: uppercase;

            letter-spacing: 1px;
        }


        .summary-value {
            font-size: 32px;

            font-weight: 800;

            line-height: 1;

            margin-top: 8px;
        }


        .summary-icon {
            width: 60px;
            height: 60px;

            border-radius: 16px;

            background: rgba(255, 255, 255, .25);

            display: flex;

            align-items: center;
            justify-content: center;

            font-size: 28px;
        }


        .summary-footer {
            margin-top: 18px;

            font-size: 13px;

            font-weight: 600;

            opacity: .85;
        }


        /* =========================================================
        DETAIL PROFILE
        ========================================================= */

        .detail-list {
            display: flex;

            flex-direction: column;
        }


        .detail-item {
            display: flex;

            justify-content: space-between;
            align-items: flex-start;

            gap: 25px;

            padding: 18px 24px;

            border-bottom: 1px solid var(--detail-border);

            transition: background .2s ease;
        }


        .detail-item:last-child {
            border-bottom: none;
        }


        .detail-item:hover {
            background: var(--detail-hover);
        }


        .detail-label {
            width: 240px;

            flex-shrink: 0;

            color: var(--detail-label);

            font-size: 13px;

            font-weight: 600;
        }


        .detail-value {
            flex: 1;

            text-align: right;

            color: var(--detail-value);

            font-size: 14px;

            font-weight: 500;

            word-break: break-word;
        }


        .detail-value.empty {
            color: var(--detail-empty);

            font-style: italic;
        }


        /* =========================================================
        DETAIL BADGES
        ========================================================= */

        .detail-value .badge {
            font-size: 11px;

            padding: 7px 12px;

            border-radius: 20px;
        }


        .detail-value .badge-success {
            background: var(--badge-success);
            color: #fff;
        }


        .detail-value .badge-danger {
            background: var(--badge-danger);
            color: #fff;
        }


        .detail-value .badge-warning {
            background: var(--badge-warning);
            color: #111;
        }


        .detail-value .badge-info {
            background: var(--badge-info);
            color: #111;
        }


        /* =========================================================
        CERTIFICATE & HISTORY CARD
        ========================================================= */

        .certificate-admin-card,
        .history-admin-card {
            display: flex;

            gap: 20px;

            padding: 22px;

            border: 1px solid var(--admin-card-border);

            border-radius: 16px;

            background: var(--admin-card-bg);

            margin-bottom: 20px;

            transition:
                .3s ease,
                border-color .3s ease,
                transform .3s ease;
        }


        .certificate-admin-card:hover,
        .history-admin-card:hover {
            border-color: var(--admin-card-hover-border);

            transform: translateY(-2px);
        }


        /* =========================================================
        CERTIFICATE / HISTORY ICON
        ========================================================= */

        .certificate-admin-icon,
        .history-admin-icon {
            width: 70px;
            height: 70px;

            border-radius: 16px;

            background: var(--admin-icon-bg);

            color: var(--admin-icon-color);

            display: flex;

            justify-content: center;
            align-items: center;

            flex-shrink: 0;
        }


        /* =========================================================
        CONTENT
        ========================================================= */

        .certificate-admin-content,
        .history-admin-content {
            flex: 1;
        }


        /* =========================================================
        EMPTY STATE
        ========================================================= */

        .empty-state {
            text-align: center;

            padding: 60px 20px;
        }


        .empty-state h5 {
            margin-bottom: 10px;

            color: var(--empty-title);
        }


        .empty-state p {
            max-width: 450px;

            margin: auto;

            color: var(--empty-text);
        }


        /* =========================================================
        RESPONSIVE
        ========================================================= */

        @media (max-width: 768px) {

            .detail-item {
                flex-direction: column;

                gap: 8px;

                padding: 15px 18px;
            }


            .detail-label {
                width: 100%;
            }


            .detail-value {
                width: 100%;

                text-align: left;
            }


            .certificate-admin-card,
            .history-admin-card {
                flex-direction: column;
            }


            .certificate-admin-icon,
            .history-admin-icon {
                width: 60px;
                height: 60px;
            }

        }
    </style>

    <style>

        /* =========================================================
        SECURITY SUMMARY VARIABLES
        ========================================================= */

        :root,
        [data-bs-theme="light"] {

            --security-summary-bg: #ffffff;
            --security-summary-border: #e2e8f0;

            --security-summary-label: #64748b;
            --security-summary-value: #f6a900;

            --security-summary-icon-bg: #fff4d6;
            --security-summary-icon-color: #f6a900;

            --security-summary-shadow:
                0 8px 25px rgba(15, 23, 42, .07);

            /* Progress */
            --security-progress-bg:
                rgba(15, 23, 42, .08);

            --security-progress-fill:
                #182338;

            /* Progress card */
            --security-progress-card-start:
                #ffca2c;

            --security-progress-card-end:
                #f6b000;

            --security-progress-text:
                #1a1a1a;

            --security-progress-icon-bg:
                rgba(255, 255, 255, .35);

            --security-progress-track:
                rgba(255, 255, 255, .35);

            --security-progress-fill-color:
                #182338;
        }


        [data-bs-theme="dark"] {

            --security-summary-bg: #18233d;
            --security-summary-border: #263555;

            --security-summary-label: #8ea0be;
            --security-summary-value: #f7b000;

            --security-summary-icon-bg: #263555;
            --security-summary-icon-color: #f7b000;

            --security-summary-shadow:
                0 10px 30px rgba(0, 0, 0, .25);

            /* Progress */
            --security-progress-bg:
                rgba(255, 255, 255, .12);

            --security-progress-fill:
                #ffffff;

            /* Progress card */
            --security-progress-card-start:
                #ffca2c;

            --security-progress-card-end:
                #f6b000;

            --security-progress-text:
                #1a1a1a;

            --security-progress-icon-bg:
                rgba(255, 255, 255, .35);

            --security-progress-track:
                rgba(255, 255, 255, .35);

            --security-progress-fill-color:
                #182338;
        }


        /* =========================================================
        SUMMARY CARD
        ========================================================= */

        .security-summary-card {

            background: var(--security-summary-bg);

            border: 1px solid var(--security-summary-border) !important;

            border-radius: 18px;

            box-shadow: var(--security-summary-shadow) !important;

            transition:
                transform .25s ease,
                box-shadow .25s ease,
                border-color .25s ease;
        }


        .security-summary-card:hover {

            transform: translateY(-3px);

            border-color: rgba(247, 176, 0, .5) !important;

            box-shadow:
                0 14px 30px rgba(15, 23, 42, .12) !important;
        }


        [data-bs-theme="dark"] .security-summary-card:hover {

            box-shadow:
                0 14px 30px rgba(0, 0, 0, .35) !important;
        }


        /* =========================================================
        SUMMARY LABEL
        ========================================================= */

        .security-summary-label {

            color: var(--security-summary-label);

            font-size: 13px;

            font-weight: 600;
        }


        /* =========================================================
        SUMMARY VALUE
        ========================================================= */

        .security-summary-value {

            color: var(--security-summary-value);

            font-weight: 700;
        }


        /* =========================================================
        SUMMARY ICON
        ========================================================= */

        .security-summary-icon {

            width: 60px;
            height: 60px;

            border-radius: 50%;

            background: var(--security-summary-icon-bg);

            color: var(--security-summary-icon-color);

            display: flex;

            align-items: center;

            justify-content: center;

            flex-shrink: 0;
        }


        /* =========================================================
        PROGRESS CARD
        ========================================================= */

        .security-progress-card {

            background:
                linear-gradient(
                    135deg,
                    var(--security-progress-card-start),
                    var(--security-progress-card-end)
                ) !important;

            border: none !important;

            color: var(--security-progress-text);
        }


        .security-progress-card .security-summary-label {

            color: var(--security-progress-text);

            opacity: .75;
        }


        .security-progress-card .security-summary-value {

            color: var(--security-progress-text);
        }


        .security-progress-card .security-summary-icon {

            background: var(--security-progress-icon-bg);

            color: var(--security-progress-text);
        }


        /* =========================================================
        PROFILE PROGRESS
        ========================================================= */

        .security-profile-progress {

            height: 8px;

            background: var(--security-progress-track);

            border-radius: 10px;

            overflow: hidden;
        }


        .security-profile-progress .progress-bar {

            background: var(--security-progress-fill-color);

            border-radius: 10px;

            transition: width .5s ease;
        }


        /* =========================================================
        DARK MODE PROGRESS CARD
        ========================================================= */

        [data-bs-theme="dark"] .security-progress-card {

            box-shadow:
                0 10px 30px rgba(247, 176, 3, .20) !important;
        }


        /* =========================================================
        RESPONSIVE
        ========================================================= */

        @media (max-width: 768px) {

            .security-summary-icon {

                width: 52px;
                height: 52px;

            }

            .security-summary-value {

                font-size: 24px;

            }

        }

    </style>
@endsection

@section('breadcrumb')
    <h1
        class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
        Detail User</h1>
    <!--end::Title-->
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
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
        <li class="breadcrumb-item text-muted">Manajemen User</li>
        <!--begin::Item-->
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-500 w-5px h-2px"></span>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item text-muted"><a href="{{ route('dashboard-admin.management-user.security.index') }}" class="text-muted text-hover-primary">User</a></li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-500 w-5px h-2px"></span>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item text-muted">Detail</li>
        <!--end::Item-->
    </ul>
    <!--end::Breadcrumb-->
@endsection

@section('content')

    @php
        /*
        |--------------------------------------------------------------------------
        | PROFILE AKTIF
        |--------------------------------------------------------------------------
        |
        | Default:
        | ?profile=security
        |
        | Cleaning Service:
        | ?profile=cleaning_service
        |
        */

        $activeProfile = request('profile', 'security');

        if ($activeProfile === 'cleaning_service') {

            $profile = $cleaningService;
            $profileProgress = $profileProgressCleaningService;
            $profileType = 'Cleaning Service';

        } else {

            $activeProfile = 'security';
            $profile = $security;
            $profileProgress = $profileProgressSecurity;
            $profileType = 'Security';

        }
    @endphp


    {{-- =========================================================
        PROFILE HEADER
    ========================================================== --}}
    <div class="row">

        <div class="col-xl-12">

            <div class="card border-0 shadow-sm mb-8">

                {{-- Cover --}}
                <div class="security-cover"></div>

                <div class="card-body pt-0">

                    <div class="row">

                        {{-- =================================================
                            FOTO
                        ================================================== --}}
                        <div class="col-xl-3 text-center">

                            <div class="security-photo-wrapper">

                                <img
                                    src="{{ $profile?->formal_photo
                                        ? Storage::url($profile->formal_photo)
                                        : asset('assets/media/avatars/blank.png') }}"
                                    class="security-photo"
                                    alt="{{ $profile?->name ?: 'Profile' }}">

                                @if($profile?->email)

                                    <span class="security-online"></span>

                                @endif

                            </div>

                        </div>


                        {{-- =================================================
                            PROFILE
                        ================================================== --}}
                        <div class="col-xl-6">

                            <div class="pt-12">

                                <h2 class="fw-bold text-dark mb-2">

                                    {{ $profile?->name ?: 'Nama Belum Diisi' }}

                                </h2>


                                <div class="fs-5 text-muted mb-3">

                                    {{ $profile?->position ?: 'Belum memiliki jabatan' }}

                                    @if($profile?->company_name)

                                        • {{ $profile->company_name }}

                                    @endif

                                </div>


                                <div class="d-flex flex-wrap gap-5">

                                    {{-- LOKASI --}}
                                    <div>

                                        <i class="ki-duotone ki-geolocation fs-4 text-primary me-2">

                                            <span class="path1"></span>
                                            <span class="path2"></span>

                                        </i>

                                        {{ $profile?->province ?: 'Provinsi belum diisi' }},
                                        {{ $profile?->city ?: 'Kota belum diisi' }}

                                    </div>


                                    {{-- TANGGAL LAHIR --}}
                                    <div>

                                        <i class="ki-duotone ki-calendar fs-4 text-success me-2">

                                            <span class="path1"></span>
                                            <span class="path2"></span>

                                        </i>

                                        @if($profile?->birth_date)

                                            {{ date('d F Y', strtotime($profile->birth_date)) }}

                                        @else

                                            Tanggal lahir belum diisi

                                        @endif

                                    </div>

                                </div>


                                {{-- STATUS KERJA --}}
                                <div class="mt-6">

                                    @if($profile?->work_status)

                                        <span class="badge badge-light-success fs-7">

                                            {{ ucfirst($profile->work_status) }}

                                        </span>

                                    @else

                                        <span class="badge badge-light-secondary">

                                            Status Kerja Belum Diisi

                                        </span>

                                    @endif

                                </div>

                            </div>

                        </div>


                        {{-- =================================================
                            ACTION
                        ================================================== --}}
                        <div class="col-xl-3">

                            <div class="pt-12 text-end">

                                @if($profile)

                                    @if($profile->email)

                                        <a
                                            href="mailto:{{ $profile->email }}"
                                            class="btn btn-warning w-100 mb-3">

                                            <i class="ki-duotone ki-sms fs-4 me-2">

                                                <span class="path1"></span>
                                                <span class="path2"></span>

                                            </i>

                                            Hubungi

                                        </a>

                                    @endif


                                    @if($profile->phone_number)

                                        <a
                                            href="tel:{{ $profile->phone_number }}"
                                            class="btn btn-light-primary w-100">

                                            <i class="ki-duotone ki-phone fs-4 me-2">

                                                <span class="path1"></span>
                                                <span class="path2"></span>

                                            </i>

                                            Telepon

                                        </a>

                                    @endif

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>



    {{-- =========================================================
        PROFILE TABS
    ========================================================== --}}
    <div class="row mb-6">

        <div class="col-xl-12">

            <div class="card border-0 shadow-sm">

                <div class="card-body py-3">

                    <div class="d-flex flex-wrap align-items-center gap-2">


                        {{-- =================================================
                            TAB SECURITY
                        ================================================== --}}
                        <a
                            href="{{ request()->url() }}?profile=security"
                            class="btn {{ $activeProfile === 'security' ? 'btn-warning' : 'btn-light' }}">

                            <i class="ki-duotone ki-shield-tick fs-4 me-2">

                                <span class="path1"></span>
                                <span class="path2"></span>

                            </i>

                            Security


                            @if($security)

                                <span class="badge badge-light-success ms-2">

                                    Aktif

                                </span>

                            @else

                                <span class="badge badge-light-danger ms-2">

                                    Tidak Ada

                                </span>

                            @endif

                        </a>


                        {{-- =================================================
                            TAB CLEANING SERVICE
                        ================================================== --}}
                        <a
                            href="{{ request()->url() }}?profile=cleaning_service"
                            class="btn {{ $activeProfile === 'cleaning_service' ? 'btn-warning' : 'btn-light' }}">

                            <i class="ki-duotone ki-brush fs-4 me-2">

                                <span class="path1"></span>
                                <span class="path2"></span>

                            </i>

                            Cleaning Service


                            @if($cleaningService)

                                <span class="badge badge-light-success ms-2">

                                    Aktif

                                </span>

                            @else

                                <span class="badge badge-light-danger ms-2">

                                    Tidak Ada

                                </span>

                            @endif

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>



    {{-- =========================================================
        PROFILE TIDAK TERSEDIA
    ========================================================== --}}
    @if(!$profile)

        <div class="card border-0 shadow-sm">

            <div class="card-body py-15 text-center">

                @if($activeProfile === 'cleaning_service')

                    <i class="ki-duotone ki-brush fs-4x text-warning mb-5">

                        <span class="path1"></span>
                        <span class="path2"></span>

                    </i>


                    <h3 class="fw-bold text-dark mb-3">

                        Tidak Memiliki Profile Cleaning Service

                    </h3>


                    <p class="text-muted mb-0">

                        User ini belum memiliki profile sebagai Cleaning Service.

                    </p>

                @else

                    <i class="ki-duotone ki-shield-tick fs-4x text-warning mb-5">

                        <span class="path1"></span>
                        <span class="path2"></span>

                    </i>


                    <h3 class="fw-bold text-dark mb-3">

                        Tidak Memiliki Profile Security

                    </h3>


                    <p class="text-muted mb-0">

                        User ini belum memiliki profile sebagai Security.

                    </p>

                @endif

            </div>

        </div>


    @else


        {{-- =========================================================
            SUMMARY
        ========================================================== --}}
        <div class="row g-5 mb-8">


            {{-- =====================================================
                PROGRESS PROFILE
            ====================================================== --}}
            <div class="col-xl-3 col-md-6">

                <div class="card h-100 border-0 shadow-sm security-summary-card security-progress-card">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-start">

                            <div>

                                <div class="security-summary-label">

                                    Progress Profil

                                </div>


                                <h2 class="security-summary-value mt-2 mb-0">

                                    {{ $profileProgress['progress'] ?? 0 }}%

                                </h2>

                            </div>


                            <div class="security-summary-icon">

                                <i class="ki-duotone ki-profile-circle fs-1">

                                    <span class="path1"></span>
                                    <span class="path2"></span>

                                </i>

                            </div>

                        </div>


                        <div class="progress security-profile-progress mt-5">

                            <div
                                class="progress-bar"
                                style="width:{{ $profileProgress['progress'] ?? 0 }}%">

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                SERTIFIKAT
            ====================================================== --}}
            <div class="col-xl-3 col-md-6">

                <div class="card h-100 border-0 shadow-sm security-summary-card">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <div class="security-summary-label">

                                    Sertifikat

                                </div>


                                <h2 class="security-summary-value mt-2 mb-0">

                                    {{ $profile->certificates->count() }}

                                </h2>

                            </div>


                            <div class="security-summary-icon">

                                <i class="ki-duotone ki-award fs-1">

                                    <span class="path1"></span>
                                    <span class="path2"></span>

                                </i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                RIWAYAT
            ====================================================== --}}
            <div class="col-xl-3 col-md-6">

                <div class="card h-100 border-0 shadow-sm security-summary-card">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <div class="security-summary-label">

                                    Riwayat Penugasan

                                </div>


                                <h2 class="security-summary-value mt-2 mb-0">

                                    {{ $profile->histories->count() }}

                                </h2>

                            </div>


                            <div class="security-summary-icon">

                                <i class="ki-duotone ki-briefcase fs-1">

                                    <span class="path1"></span>
                                    <span class="path2"></span>

                                </i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                PENGALAMAN
            ====================================================== --}}
            <div class="col-xl-3 col-md-6">

                <div class="card h-100 border-0 shadow-sm security-summary-card">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <div class="security-summary-label">

                                    Pengalaman

                                </div>


                                <h2 class="security-summary-value mt-2 mb-0">

                                    {{ $profile->work_experience ?: '-' }}

                                </h2>

                            </div>


                            <div class="security-summary-icon">

                                <i class="ki-duotone ki-time fs-1">

                                    <span class="path1"></span>
                                    <span class="path2"></span>

                                </i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        {{-- =========================================================
            INFORMASI PRIBADI
        ========================================================== --}}
        <div class="company-wrapper mb-5">

            <div class="company-title">

                Informasi Pribadi

            </div>


            <div class="detail-list">


                {{-- NAMA --}}
                <div class="detail-item">

                    <div class="detail-label">

                        Nama Lengkap

                    </div>


                    <div class="detail-value {{ empty($profile->name) ? 'empty' : '' }}">

                        {{ $profile->name ?: 'Belum diisi' }}

                    </div>

                </div>


                {{-- TEMPAT LAHIR --}}
                <div class="detail-item">

                    <div class="detail-label">

                        Tempat Lahir

                    </div>


                    <div class="detail-value {{ empty($profile->birth_place) ? 'empty' : '' }}">

                        {{ $profile->birth_place ?: 'Belum diisi' }}

                    </div>

                </div>


                {{-- TANGGAL LAHIR --}}
                <div class="detail-item">

                    <div class="detail-label">

                        Tanggal Lahir

                    </div>


                    <div class="detail-value {{ empty($profile->birth_date) ? 'empty' : '' }}">

                        {{ $profile->birth_date
                            ? date('d F Y', strtotime($profile->birth_date))
                            : 'Belum diisi' }}

                    </div>

                </div>


                {{-- JENIS KELAMIN --}}
                <div class="detail-item">

                    <div class="detail-label">

                        Jenis Kelamin

                    </div>


                    <div class="detail-value">

                        @if($profile->gender)

                            <span class="badge bg-info">

                                {{ ucfirst($profile->gender) }}

                            </span>

                        @else

                            <span class="detail-value empty">

                                Belum diisi

                            </span>

                        @endif

                    </div>

                </div>


                {{-- NOMOR REGISTRASI --}}
                <div class="detail-item">

                    <div class="detail-label">

                        Nomor Registrasi

                    </div>


                    <div class="detail-value {{ empty($profile->registration_number) ? 'empty' : '' }}">

                        {{ $profile->registration_number ?: 'Belum diisi' }}

                    </div>

                </div>


                {{-- NOMOR KTP --}}
                <div class="detail-item">

                    <div class="detail-label">

                        Nomor KTP

                    </div>


                    <div class="detail-value {{ empty($profile->ktp_number) ? 'empty' : '' }}">

                        {{ $profile->ktp_number ?: 'Belum diisi' }}

                    </div>

                </div>


                {{-- EMAIL --}}
                <div class="detail-item">

                    <div class="detail-label">

                        Email

                    </div>


                    <div class="detail-value {{ empty($profile->email) ? 'empty' : '' }}">

                        {{ $profile->email ?: 'Belum diisi' }}

                    </div>

                </div>


                {{-- NOMOR TELEPON --}}
                <div class="detail-item">

                    <div class="detail-label">

                        Nomor Telepon

                    </div>


                    <div class="detail-value {{ empty($profile->phone_number) ? 'empty' : '' }}">

                        {{ $profile->phone_number ?: 'Belum diisi' }}

                    </div>

                </div>


                {{-- ALAMAT --}}
                <div class="detail-item">

                    <div class="detail-label">

                        Alamat

                    </div>


                    <div class="detail-value {{ empty($profile->address) ? 'empty' : '' }}">

                        {{ $profile->address ?: 'Belum diisi' }}

                    </div>

                </div>

            </div>

        </div>



        {{-- =========================================================
            DATA PROFESIONAL
        ========================================================== --}}
        <div class="company-wrapper mb-5">

            <div class="company-title">

                Data Profesional

            </div>


            <div class="detail-list">


                {{-- PENGALAMAN KERJA --}}
                <div class="detail-item">

                    <div class="detail-label">

                        Pengalaman Kerja

                    </div>


                    <div class="detail-value {{ empty($profile->work_experience) ? 'empty' : '' }}">

                        {{ $profile->work_experience ?: 'Belum diisi' }}

                    </div>

                </div>


                {{-- STATUS PEKERJAAN --}}
                <div class="detail-item">

                    <div class="detail-label">

                        Status Pekerjaan

                    </div>


                    <div class="detail-value {{ empty($profile->work_status) ? 'empty' : '' }}">

                        {{ $profile->work_status ?: 'Belum diisi' }}

                    </div>

                </div>


                {{-- PERUSAHAAN --}}
                <div class="detail-item">

                    <div class="detail-label">

                        Perusahaan Terakhir

                    </div>


                    <div class="detail-value {{ empty($profile->company_name) ? 'empty' : '' }}">

                        {{ $profile->company_name ?: 'Belum diisi' }}

                    </div>

                </div>


                {{-- POSISI --}}
                <div class="detail-item">

                    <div class="detail-label">

                        Posisi

                    </div>


                    <div class="detail-value {{ empty($profile->position) ? 'empty' : '' }}">

                        {{ $profile->position ?: 'Belum diisi' }}

                    </div>

                </div>

            </div>

        </div>



        {{-- =========================================================
            INFORMASI FISIK
        ========================================================== --}}
        <div class="company-wrapper mb-5">

            <div class="company-title">

                Informasi Fisik

            </div>


            <div class="detail-list">


                {{-- TINGGI --}}
                <div class="detail-item">

                    <div class="detail-label">

                        Tinggi Badan

                    </div>


                    <div class="detail-value {{ empty($profile->height) ? 'empty' : '' }}">

                        {{ $profile->height
                            ? $profile->height . ' cm'
                            : 'Belum diisi' }}

                    </div>

                </div>


                {{-- BERAT --}}
                <div class="detail-item">

                    <div class="detail-label">

                        Berat Badan

                    </div>


                    <div class="detail-value {{ empty($profile->width) ? 'empty' : '' }}">

                        {{ $profile->width
                            ? $profile->width . ' kg'
                            : 'Belum diisi' }}

                    </div>

                </div>

            </div>

        </div>



        {{-- =========================================================
            PREFERENSI PENEMPATAN
        ========================================================== --}}
        <div class="company-wrapper mb-5">

            <div class="company-title">

                Preferensi Penempatan

            </div>


            <div class="detail-list">


                {{-- LUAR KOTA --}}
                <div class="detail-item">

                    <div class="detail-label">

                        Bersedia Ditempatkan di Luar Kota

                    </div>


                    <div class="detail-value">

                        @if($profile->is_out_of_town_agree)

                            <span class="badge bg-success">

                                Bersedia

                            </span>

                        @else

                            <span class="badge bg-danger">

                                Tidak Bersedia

                            </span>

                        @endif

                    </div>

                </div>


                {{-- SHIFT --}}
                <div class="detail-item">

                    <div class="detail-label">

                        Bersedia Kerja Shift

                    </div>


                    <div class="detail-value">

                        @if($profile->is_shift_agree)

                            <span class="badge bg-success">

                                Bersedia

                            </span>

                        @else

                            <span class="badge bg-danger">

                                Tidak Bersedia

                            </span>

                        @endif

                    </div>

                </div>


                {{-- SIM --}}
                <div class="detail-item">

                    <div class="detail-label">

                        SIM

                    </div>


                    <div class="detail-value">

                        @if($profile->sim)

                            @foreach(explode(',', $profile->sim) as $sim)

                                <span class="badge bg-warning text-dark me-1">

                                    {{ trim($sim) }}

                                </span>

                            @endforeach

                        @else

                            <span class="detail-value empty">

                                Belum diisi

                            </span>

                        @endif

                    </div>

                </div>


                {{-- LOKASI PENEMPATAN --}}
                <div class="detail-item">

                    <div class="detail-label">

                        Lokasi Penempatan

                    </div>


                    <div class="detail-value">

                        @if($profile->placements)

                            @foreach(explode(',', $profile->placements) as $placement)

                                <span class="badge bg-primary me-1">

                                    {{ trim($placement) }}

                                </span>

                            @endforeach

                        @else

                            <span class="detail-value empty">

                                Belum diisi

                            </span>

                        @endif

                    </div>

                </div>

            </div>

        </div>



        {{-- =========================================================
            KEAHLIAN
        ========================================================== --}}
        <div class="company-wrapper mb-5">

            <div class="company-title">

                Keahlian

            </div>


            <div class="company-body">

                @if($profile->ability)

                    @foreach(explode(',', $profile->ability) as $ability)

                        <span class="badge bg-warning text-dark me-2 mb-2">

                            {{ trim($ability) }}

                        </span>

                    @endforeach

                @else

                    <div class="company-empty">

                        Belum menambahkan keahlian.

                    </div>

                @endif

            </div>

        </div>



        {{-- =========================================================
            DESKRIPSI
        ========================================================== --}}
        <div class="company-wrapper mb-5">

            <div class="company-title">

                Tentang {{ $profileType }}

            </div>


            <div class="company-body">

                @if($profile->self_description)

                    {{ $profile->self_description }}

                @else

                    <div class="company-empty">

                        Belum menambahkan deskripsi diri.

                    </div>

                @endif

            </div>

        </div>



        {{-- =========================================================
            CATATAN TAMBAHAN
        ========================================================== --}}
        <div class="company-wrapper">

            <div class="company-title">

                Catatan Tambahan

            </div>


            <div class="company-body">

                @if($profile->additional_note)

                    {{ $profile->additional_note }}

                @else

                    <div class="company-empty">

                        Tidak ada catatan tambahan.

                    </div>

                @endif

            </div>

        </div>



        {{-- =========================================================
            RIWAYAT SERTIFIKASI
        ========================================================== --}}
        <div class="company-wrapper mb-5 mt-5">

            <div class="company-title d-flex justify-content-between align-items-center mb-3">

                <span>

                    Riwayat Sertifikasi

                </span>


                <span class="badge bg-warning text-dark">

                    {{ $profile->certificates->count() }}

                    Sertifikat

                </span>

            </div>


            <div class="company-body">

                @forelse($profile->certificates as $certificate)

                    @php

                        $expired = $certificate->expired_date
                            ? \Carbon\Carbon::parse($certificate->expired_date)->isPast()
                            : false;

                    @endphp


                    <div class="certificate-admin-card">


                        {{-- ICON --}}
                        <div class="certificate-admin-icon">

                            <i class="ki-duotone ki-shield-tick fs-2 text-warning">

                                <span class="path1"></span>
                                <span class="path2"></span>

                            </i>

                        </div>


                        {{-- CONTENT --}}
                        <div class="certificate-admin-content">

                            <div class="d-flex justify-content-between align-items-center mb-2">

                                <h5 class="mb-0">

                                    {{ $certificate->title }}

                                </h5>


                                @if($expired)

                                    <span class="badge bg-danger">

                                        Kadaluarsa

                                    </span>

                                @else

                                    <span class="badge bg-success">

                                        Aktif

                                    </span>

                                @endif

                            </div>


                            <div class="text-warning mb-2">

                                {{ $certificate->publisher }}

                            </div>


                            <div class="text-muted small mb-2">

                                Nomor Sertifikat :

                                <strong class="">

                                    {{ $certificate->certificate_number }}

                                </strong>

                            </div>


                            <div class="text-muted small mb-3">

                                Berlaku

                                @if($certificate->publish_date)

                                    {{ date('d M Y', strtotime($certificate->publish_date)) }}

                                @else

                                    -

                                @endif


                                -


                                @if($certificate->expired_date)

                                    {{ date('d M Y', strtotime($certificate->expired_date)) }}

                                @else

                                    -

                                @endif

                            </div>


                            <div>

                                @if($certificate->category)

                                    <span class="badge bg-primary">

                                        {{ $certificate->category }}

                                    </span>

                                @endif


                                @if($certificate->file)

                                    <a
                                        href="{{ Storage::url($certificate->file) }}"
                                        target="_blank"
                                        class="btn btn-sm btn-light-warning ms-2">

                                        <i class="ki-duotone ki-file-sheet me-1">

                                            <span class="path1"></span>
                                            <span class="path2"></span>

                                        </i>

                                        Lihat Dokumen

                                    </a>

                                @endif

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="empty-state">

                        <i class="ki-duotone ki-shield-search fs-4x text-warning mb-4">

                            <span class="path1"></span>
                            <span class="path2"></span>

                        </i>


                        <h5 class="">

                            Belum Memiliki Sertifikasi

                        </h5>


                        <p class="text-muted mb-0">

                            {{ $profileType }}
                            ini belum menambahkan sertifikat
                            pelatihan maupun lisensi.

                        </p>

                    </div>

                @endforelse

            </div>

        </div>



        {{-- =========================================================
            RIWAYAT PENUGASAN
        ========================================================== --}}
        <div class="company-wrapper">

            <div class="company-title d-flex justify-content-between align-items-center mb-3">

                <span>

                    Riwayat Penugasan

                </span>


                <span class="badge bg-warning text-dark">

                    {{ $profile->histories->count() }}

                    Riwayat

                </span>

            </div>


            <div class="company-body">

                @forelse($profile->histories as $history)

                    <div class="history-admin-card">


                        {{-- ICON --}}
                        <div class="history-admin-icon">

                            <i class="ki-duotone ki-briefcase fs-2 text-warning">

                                <span class="path1"></span>
                                <span class="path2"></span>

                            </i>

                        </div>


                        {{-- CONTENT --}}
                        <div class="history-admin-content">

                            <div class="d-flex justify-content-between">

                                <h5 class=" mb-1">

                                    {{ $history->position }}

                                </h5>


                                @if($history->is_current)

                                    <span class="badge bg-success">

                                        Saat Ini

                                    </span>

                                @endif

                            </div>


                            <div class="text-warning">

                                {{ $history->company_name }}

                            </div>


                            @if($history->location)

                                <div class="small text-muted mt-2">

                                    <i class="ki-duotone ki-geolocation me-1">

                                        <span class="path1"></span>
                                        <span class="path2"></span>

                                    </i>

                                    {{ $history->location }}

                                </div>

                            @endif


                            <div class="small text-muted">

                                @if($history->start_date)

                                    {{ date('d M Y', strtotime($history->start_date)) }}

                                @else

                                    -

                                @endif


                                -


                                @if($history->is_current)

                                    Sekarang

                                @elseif($history->end_date)

                                    {{ date('d M Y', strtotime($history->end_date)) }}

                                @else

                                    -

                                @endif

                            </div>


                            @if($history->category)

                                <div class="mt-2">

                                    <span class="badge bg-primary">

                                        {{ $history->category }}

                                    </span>

                                </div>

                            @endif


                            @if($history->description)

                                <div class="mt-3 text-light">

                                    {{ $history->description }}

                                </div>

                            @endif

                        </div>

                    </div>

                @empty

                    <div class="empty-state">

                        <i class="ki-duotone ki-briefcase fs-4x text-warning mb-4">

                            <span class="path1"></span>
                            <span class="path2"></span>

                        </i>


                        <h5 class="">

                            Belum Ada Riwayat Penugasan

                        </h5>


                        <p class="text-muted mb-0">

                            {{ $profileType }}
                            ini belum mengisi pengalaman kerja
                            atau riwayat penugasan.

                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    @endif

@endsection

@section('js')
    
@endsection