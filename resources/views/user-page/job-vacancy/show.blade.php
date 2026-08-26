@extends('layouts.user-page')

@section('title', 'Detail Lowongan')

@section('style')
    <style>
        .job-detail-wrapper {
            max-width: 760px;
            margin: 0 auto;
            padding: 25px 0 60px;
        }


        /* ============================= */
        /* BACK */
        /* ============================= */

        .job-back {
            display: inline-flex;
            align-items: center;
            gap: 7px;

            color: #8c99b5;
            font-size: 12px;
            font-weight: 500;

            text-decoration: none;

            margin-bottom: 14px;
        }

        .job-back:hover {
            color: #ffb000;
        }



        /* ============================= */
        /* CARD */
        /* ============================= */

        .job-detail-card {
            background: #101a32;
            border: 1px solid #202d4a;

            border-radius: 15px;

            padding: 20px;

            margin-bottom: 14px;
        }



        /* ============================= */
        /* HEADER */
        /* ============================= */

        .job-header-card {
            border-top: 4px solid #f5a900;
        }


        .job-header {
            display: flex;
            gap: 15px;
        }


        .job-company-icon {
            width: 48px;
            height: 48px;

            flex-shrink: 0;

            border-radius: 11px;

            background: #162542;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #ffb000;
            font-size: 22px;
        }


        .job-header-content {
            flex: 1;
        }


        .job-title-row {
            display: flex;
            align-items: center;
            gap: 8px;

            flex-wrap: wrap;
        }


        .job-title-row h1 {
            margin: 0;

            color: #f4f6fb;

            font-size: 18px;
            font-weight: 700;
        }


        .job-company-name {
            margin-top: 3px;

            color: #7785a2;

            font-size: 12px;
        }


        .job-meta {
            display: flex;
            flex-wrap: wrap;

            gap: 14px;

            margin-top: 8px;
        }


        .job-meta span {
            display: inline-flex;
            align-items: center;
            gap: 5px;

            color: #8290ac;

            font-size: 11px;
        }


        .job-meta i {
            font-size: 14px;
        }



        /* ============================= */
        /* SUMMARY */
        /* ============================= */

        .job-summary {
            display: grid;

            grid-template-columns: repeat(3, 1fr);

            border-top: 1px solid #202d4a;
            border-bottom: 1px solid #202d4a;

            margin-top: 18px;
        }


        .summary-item {
            padding: 13px 12px;

            border-right: 1px solid #202d4a;

            text-align: center;
        }


        .summary-item:last-child {
            border-right: 0;
        }


        .summary-item span {
            display: block;

            color: #71809c;

            font-size: 10px;
        }


        .summary-item strong {
            display: block;

            margin-top: 4px;

            color: #ffb000;

            font-size: 13px;
        }


        .summary-item small {
            color: #8996ad;
            font-size: 9px;
        }



        /* ============================= */
        /* ACTION */
        /* ============================= */

        .job-header-action {
            display: flex;
            gap: 10px;

            margin-top: 15px;
        }


        .btn-job-apply {
            flex: 1;

            border: 0;

            border-radius: 9px;

            background: #ffb000;

            color: #101010;

            font-size: 12px;
            font-weight: 700;

            padding: 11px 18px;

            cursor: pointer;
        }


        .btn-job-apply:hover {
            background: #ffc333;
        }


        .btn-job-save {
            min-width: 90px;

            border: 1px solid #2d3a58;

            border-radius: 9px;

            background: transparent;

            color: #8d99b2;

            font-size: 12px;

            cursor: pointer;
        }


        .btn-job-save:hover {
            border-color: #ffb000;
            color: #ffb000;
        }



        /* ============================= */
        /* DETAIL TITLE */
        /* ============================= */

        .detail-title {
            margin-bottom: 12px;

            color: #8291ad;

            font-size: 10px;
            font-weight: 700;

            letter-spacing: .6px;
        }


        .detail-text {
            color: #8794ad;

            font-size: 11px;

            line-height: 1.7;
        }



        /* ============================= */
        /* TAGS */
        /* ============================= */

        .job-tags {
            display: flex;
            flex-wrap: wrap;

            gap: 7px;
        }


        .job-tag {
            display: inline-flex;

            align-items: center;

            gap: 5px;

            padding: 5px 9px;

            border-radius: 6px;

            border: 1px solid #33415f;

            background: #141f39;

            color: #9ba7bd;

            font-size: 10px;
        }


        .tag-primary {
            color: #ffb000;
            border-color: #72551b;
        }


        .tag-certificate {
            color: #ffb000;
            border-color: #72551b;
        }


        .certificate-note {
            margin-top: 10px;

            color: #72809a;

            font-size: 10px;
        }



        /* ============================= */
        /* LIST */
        /* ============================= */

        .detail-list {
            display: flex;
            flex-direction: column;

            gap: 9px;
        }


        .detail-list-item {
            display: flex;
            align-items: flex-start;

            gap: 8px;

            color: #a1acc0;

            font-size: 11px;

            line-height: 1.5;
        }


        .number-icon,
        .facility-icon {
            width: 17px;
            height: 17px;

            flex-shrink: 0;

            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #17233c;

            color: #75839e;

            font-size: 10px;
        }



        /* ============================= */
        /* REQUIREMENT */
        /* ============================= */

        .requirement-grid {
            display: grid;

            grid-template-columns: repeat(2, 1fr);

            gap: 14px 30px;
        }


        .requirement-grid small {
            display: block;

            color: #64728d;

            font-size: 9px;

            margin-bottom: 3px;
        }


        .requirement-grid strong {
            display: block;

            color: #d9deea;

            font-size: 11px;
        }


        .requirement-divider {
            height: 1px;

            background: #202d4a;

            margin: 15px 0;
        }



        /* ============================= */
        /* STATISTICS */
        /* ============================= */

        .job-statistics {
            display: grid;

            grid-template-columns: repeat(3, 1fr);
        }


        .job-statistics > div {
            text-align: center;

            border-right: 1px solid #202d4a;
        }


        .job-statistics > div:last-child {
            border-right: 0;
        }


        .job-statistics strong {
            display: block;

            color: #e4e8f1;

            font-size: 18px;
        }


        .job-statistics span {
            display: block;

            margin-top: 3px;

            color: #71809a;

            font-size: 9px;
        }



        /* ============================= */
        /* COMPANY */
        /* ============================= */

        .company-detail {
            display: flex;

            align-items: center;

            gap: 12px;
        }


        .company-detail-icon {
            width: 40px;
            height: 40px;

            border-radius: 9px;

            background: #16233d;

            display: flex;

            align-items: center;
            justify-content: center;

            color: #7e8da8;

            font-size: 19px;
        }


        .company-detail strong {
            display: block;

            color: #dce1eb;

            font-size: 12px;
        }


        .company-detail span {
            display: block;

            margin-top: 2px;

            color: #6f7d98;

            font-size: 10px;
        }


        .company-location {
            margin-top: 12px;

            color: #7c89a2;

            font-size: 10px;
        }



        /* ============================= */
        /* FOOTER CTA */
        /* ============================= */

        .job-apply-footer {
            display: flex;

            align-items: center;
            justify-content: space-between;

            gap: 20px;
        }


        .job-apply-footer strong {
            display: block;

            color: #dce2ed;

            font-size: 12px;
        }


        .job-apply-footer span {
            display: block;

            margin-top: 4px;

            color: #74819b;

            font-size: 10px;
        }


        .job-apply-footer b {
            color: #ffb000;
        }



        /* ============================= */
        /* RESPONSIVE */
        /* ============================= */

        @media (max-width: 768px) {

            .job-detail-wrapper {
                padding: 15px 12px 40px;
            }


            .job-detail-card {
                padding: 16px;
            }


            .job-title-row h1 {
                font-size: 16px;
            }


            .job-summary {
                grid-template-columns: repeat(2, 1fr);
            }


            .summary-item:nth-child(2) {
                border-right: 0;
            }


            .summary-item:last-child {
                grid-column: 1 / -1;

                border-top: 1px solid #202d4a;
            }


            .requirement-grid {
                grid-template-columns: 1fr 1fr;
            }


            .job-apply-footer {
                flex-direction: column;
                align-items: stretch;
            }


            .job-apply-footer .btn-job-apply {
                width: 100%;
            }

        }


        @media (max-width: 480px) {

            .job-header {
                align-items: flex-start;
            }


            .job-company-icon {
                width: 42px;
                height: 42px;
            }


            .job-meta {
                gap: 8px;
            }


            .job-header-action {
                flex-direction: column;
            }


            .btn-job-save {
                min-height: 38px;
            }

        }
    </style>

    <style>
        .network-breadcrumb{
            display:flex;
            align-items:center;
            gap:2px;
            font-size: 11px;
            font-weight:500;
            margin-bottom:28px;
        }

        .network-breadcrumb a{
            display:flex;
            align-items:center;
            gap:6px;
            color:#7d8aa5;
            text-decoration:none;
            transition:.25s;
        }

        .network-breadcrumb a:hover{
            color:#e8a401;
        }

        .network-breadcrumb a i{
            font-size: 11px;
        }

        .network-breadcrumb .active{
            color:#f4f6fb;
            font-weight:600;
        }

        .network-breadcrumb .text-muted{
            color:#5b6985 !important;
        }
    </style>

    <style>
        .btn-job-save.saved {
            color: #198754;
            border-color: #198754;
        }

        .btn-job-save.saved:hover {
            color: #fff;
            background-color: #198754;
        }
    </style>
@endsection

@section('content')

<div class="container-xxl">

    <div class="network-breadcrumb mb-4">

        <a href="javascript:;">
            <i class="ki-duotone ki-home-2">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
            <span>Beranda</span>
        </a>

        <span class="mx-2 text-muted">›</span>

        <span class="active">
            Detail Lowongan
        </span>

    </div>

        <div class="row g-4">

            <!-- Sidebar Kiri (Desktop Only) -->
            <div class="d-none d-lg-block col-lg-2">
                
            </div>

            <!-- Content (Selalu Tampil) -->
            <div class="col-12 col-lg-8">
                <div class="job-detail-wrapper">

                    {{-- BACK --}}
                    <a href="{{ route('user-page.home') }}" class="job-back">
                        <i class="ki-duotone ki-arrow-left"></i>
                        Kembali ke Lowongan
                    </a>


                    {{-- ===================================== --}}
                    {{-- HEADER LOWONGAN --}}
                    {{-- ===================================== --}}

                    <div class="job-detail-card job-header-card">

                        <div class="job-header">

                            <div class="job-company-icon">
                                <i class="ki-duotone ki-briefcase"></i>
                            </div>

                            <div class="job-header-content">

                                <div class="job-title-row">

                                    <h1>
                                        {{ $job->position ?? '-' }}
                                    </h1>

                                    @if($job->is_urgent ?? false)

                                        <span class="badge-urgent">
                                            ⚡ URGENT
                                        </span>

                                    @endif

                                </div>

                                <div class="job-company-name">

                                    {{ $job->bujp?->company_name
                                        ?? $job->company?->company_name
                                        ?? '-' }}

                                </div>

                                <div class="job-meta">

                                    @if($job->city)

                                        <span>
                                            <i class="ki-duotone ki-geolocation"></i>
                                            {{ $job->city }}
                                        </span>

                                    @endif

                                    <span>
                                        <i class="ki-duotone ki-time"></i>

                                        {{ $job->working_system == 'shift'
                                            ? 'Shift'
                                            : 'Non-Shift' }}

                                    </span>

                                    @if($job->updated_at)

                                        <span>
                                            <i class="ki-duotone ki-calendar"></i>
                                            Diposting
                                            {{ $job->updated_at->diffForHumans() }}
                                        </span>

                                    @endif

                                </div>

                            </div>

                        </div>


                        {{-- SUMMARY --}}

                        <div class="job-summary">

                            <div class="summary-item">

                                <span>Gaji</span>

                                @if($job->is_show_fee)

                                    <strong>
                                        Rp {{ number_format((float)$job->min_price, 0, ',', '.') }}

                                        @if($job->max_price)
                                            – Rp {{ number_format((float)$job->max_price, 0, ',', '.') }}
                                        @endif

                                        <small>
                                            /{{ $job->fee_type == 'monthly' ? 'bulan' : 'hari' }}
                                        </small>
                                    </strong>

                                @else

                                    <strong class="text-muted">
                                        Tidak dicantumkan
                                    </strong>

                                @endif

                            </div>


                            <div class="summary-item">

                                <span>Pelamar</span>

                                <strong>
                                    {{ $job->applications_count ?? 0 }}
                                </strong>

                            </div>


                            @if($job->end_date)

                                <div class="summary-item">

                                    <span>Deadline</span>

                                    <strong>

                                        {{ \Carbon\Carbon::parse($job->end_date)
                                            ->translatedFormat('d M Y') }}

                                    </strong>

                                </div>

                            @endif

                        </div>


                        {{-- ACTION --}}

                        <div class="job-header-action">

                            @if($applicationStatus === 'shortlisted')

                                <button
                                    type="button"
                                    class="btn btn-success flex-grow-1"
                                    disabled>

                                    <i class="ki-duotone ki-check me-1"></i>
                                    Anda Terpilih

                                </button>


                            @elseif($applicationStatus === 'rejected')

                                <button
                                    type="button"
                                    class="btn btn-danger flex-grow-1"
                                    disabled>

                                    <i class="ki-duotone ki-cross me-1"></i>
                                    Lamaran Ditolak

                                </button>


                            @elseif($applicationStatus === 'reviewed')

                                <button
                                    type="button"
                                    class="btn btn-warning flex-grow-1"
                                    disabled>

                                    <i class="ki-duotone ki-time me-1"></i>
                                    Sedang Direview

                                </button>


                            @elseif($applicationStatus === 'applied')

                                <button
                                    type="button"
                                    class="btn-apply flex-grow-1 job-apply-btn"
                                    data-job-uuid="{{ $job->uuid }}"
                                    onclick="cancelApplyJob(this, '{{ $job->uuid }}')">

                                    <i class="ki-duotone ki-check me-1"></i>
                                    Sudah Dilamar

                                </button>


                            @else

                                <button
                                    type="button"
                                    class="btn-apply flex-grow-1 job-apply-btn"
                                    data-job-uuid="{{ $job->uuid }}"
                                    onclick="applyJob(this, '{{ $job->uuid }}')">

                                    Lamar Sekarang

                                </button>

                            @endif

                            <button
                                type="button"
                                class="btn-job-save {{ $job->is_bookmarked ? 'saved' : '' }}"
                                onclick="saveJob(this, '{{ $job->uuid }}')">

                                @if($job->is_bookmarked)

                                    <i class="ki-duotone ki-check"></i>
                                    Tersimpan

                                @else

                                    <i class="ki-duotone ki-bookmark"></i>
                                    Simpan

                                @endif

                            </button>

                        </div>

                    </div>



                    {{-- ===================================== --}}
                    {{-- TENTANG PEKERJAAN --}}
                    {{-- ===================================== --}}

                    @if($job->description_work)

                        <div class="job-detail-card">

                            <div class="detail-title">
                                TENTANG PEKERJAAN
                            </div>

                            <div class="detail-description">

                                {!! nl2br(e($job->description_work)) !!}

                            </div>

                        </div>

                    @endif

                    {{-- ===================================== --}}
                    {{-- LOKASI KERJA --}}
                    {{-- ===================================== --}}

                    @if(
                        $job->province ||
                        $job->city ||
                        $job->district ||
                        $job->village ||
                        $job->address
                    )

                        <div class="job-detail-card">

                            <div class="detail-title">
                                LOKASI KERJA
                            </div>

                            <div class="detail-list">

                                @if($job->province || $job->city)

                                    <div class="detail-list-item">

                                        <span class="number-icon">
                                            <i class="ki-duotone ki-geolocation"></i>
                                        </span>

                                        <span>

                                            {{ $job->city }}

                                            @if($job->province)
                                                , {{ $job->province }}
                                            @endif

                                        </span>

                                    </div>

                                @endif


                                @if($job->district || $job->village)

                                    {{-- <div class="detail-list-item">

                                        <span class="number-icon">
                                            <i class="ki-duotone ki-geolocation"></i>
                                        </span>

                                        <span>

                                            @if($job->village)
                                                {{ $job->village }}
                                            @endif

                                            @if($job->district)
                                                @if($job->village), @endif
                                                {{ $job->district }}
                                            @endif

                                        </span>

                                    </div> --}}

                                @endif


                                @if($job->address)

                                    <div class="detail-list-item">

                                        <span class="number-icon">
                                            <i class="ki-duotone ki-map"></i>
                                        </span>

                                        <span>
                                            {{ $job->address }}
                                        </span>

                                    </div>

                                @endif

                            </div>

                        </div>

                    @endif

                    {{-- ===================================== --}}
                    {{-- SISTEM KERJA --}}
                    {{-- ===================================== --}}

                    <div class="job-detail-card">

                        <div class="detail-title">
                            SISTEM KERJA
                        </div>

                        <div class="job-tags">

                            {{-- Tipe pekerjaan --}}
                            <span class="job-tag tag-primary">

                                {{ match($job->working_type) {

                                    'permanent' => 'Tetap',

                                    'contract' => 'Kontrak',

                                    'intenrship' => 'Internship',

                                    'freelance' => 'Freelance',

                                    default => '-'

                                } }}

                            </span>


                            {{-- Sistem kerja --}}
                            <span class="job-tag">

                                {{ $job->working_system === 'shift'
                                    ? 'Shift'
                                    : 'Non-Shift' }}

                            </span>

                        </div>


                        {{-- PERIODE KERJA --}}
                        @if($job->start_date || $job->end_date)

                            <div class="detail-info-row mt-3">

                                <span class="detail-info-label">
                                    Periode
                                </span>

                                <span class="detail-info-value">

                                    @if($job->start_date)

                                        {{ \Carbon\Carbon::parse($job->start_date)
                                            ->translatedFormat('d M Y') }}

                                    @else

                                        -

                                    @endif

                                    <span class="text-muted mx-1">
                                        s/d
                                    </span>

                                    @if($job->end_date)

                                        {{ \Carbon\Carbon::parse($job->end_date)
                                            ->translatedFormat('d M Y') }}

                                    @else

                                        -

                                    @endif

                                </span>

                            </div>

                        @endif

                    </div>

                    {{-- ===================================== --}}
                    {{-- TANGGUNG JAWAB --}}
                    {{-- ===================================== --}}

                    @if($job->responsibility)

                        @php
                            $responsibilities = json_decode($job->responsibility, true);
                        @endphp

                        @if(is_array($responsibilities) && count($responsibilities))

                            <div class="job-detail-card">

                                <div class="detail-title">
                                    TANGGUNG JAWAB
                                </div>

                                <div class="detail-list">

                                    @foreach($responsibilities as $item)

                                        @if(is_string($item) && trim($item))

                                            <div class="detail-list-item">

                                                <span class="number-icon">
                                                    <i class="ki-duotone ki-check"></i>
                                                </span>

                                                <span>
                                                    {{ trim($item) }}
                                                </span>

                                            </div>

                                        @endif

                                    @endforeach

                                </div>

                            </div>

                        @endif

                    @endif



                    {{-- ===================================== --}}
                    {{-- SERTIFIKASI --}}
                    {{-- ===================================== --}}

                    @php

                        $certificates = [];

                        if ($job->certificate) {

                            $decoded = json_decode($job->certificate, true);

                            $certificates = is_array($decoded)
                                ? $decoded
                                : [$job->certificate];

                        }

                    @endphp


                    {{-- ===================================== --}}
                    {{-- KOMPETENSI SKEMA --}}
                    {{-- ===================================== --}}

                    @php

                        $competencySchemes = [];

                        if ($job->competency_scheme) {

                            $decoded = json_decode($job->competency_scheme, true);

                            $competencySchemes = is_array($decoded)
                                ? $decoded
                                : [$job->competency_scheme];

                        }

                    @endphp

                    {{-- ===================================== --}}
                    {{-- PERSYARATAN PELAMAR --}}
                    {{-- ===================================== --}}

                    @if(
                        $job->gender ||
                        $job->min_age ||
                        $job->max_age ||
                        $job->last_education ||
                        $job->min_experience ||
                        $job->certificate
                    )

                        <div class="job-detail-card">


                            <div class="detail-title">
                                PERSYARATAN PELAMAR
                            </div>


                            <div class="requirement-grid">


                                {{-- =========================================================
                                    JENIS KELAMIN
                                ========================================================== --}}

                                @if($job->gender)

                                    <div class="requirement-item">

                                        <span class="requirement-label">
                                            JENIS KELAMIN
                                        </span>

                                        <strong>

                                            {{ $job->gender === 'laki-laki'
                                                ? 'Laki-laki'
                                                : 'Perempuan' }}

                                        </strong>

                                    </div>

                                @endif



                                {{-- =========================================================
                                    USIA
                                ========================================================== --}}

                                @if($job->min_age || $job->max_age)

                                    <div class="requirement-item">

                                        <span class="requirement-label">
                                            USIA
                                        </span>

                                        <strong>

                                            @if($job->min_age)
                                                {{ $job->min_age }}
                                            @endif

                                            @if($job->min_age && $job->max_age)
                                                –
                                            @endif

                                            @if($job->max_age)
                                                {{ $job->max_age }}
                                            @endif

                                            tahun

                                        </strong>

                                    </div>

                                @endif



                                {{-- =========================================================
                                    TINGGI BADAN
                                ========================================================== --}}

                                @if($job->min_height || $job->max_height)

                                    <div class="requirement-item">

                                        <span class="requirement-label">
                                            TINGGI BADAN
                                        </span>

                                        <strong>

                                            @if($job->min_height)
                                                {{ $job->min_height }}
                                            @endif

                                            @if($job->min_height && $job->max_height)
                                                –
                                            @endif

                                            @if($job->max_height)
                                                {{ $job->max_height }}
                                            @endif

                                            cm

                                        </strong>

                                    </div>

                                @endif



                                {{-- =========================================================
                                    BERAT BADAN
                                ========================================================== --}}

                                @if($job->min_weight || $job->max_weight)

                                    <div class="requirement-item">

                                        <span class="requirement-label">
                                            BERAT BADAN
                                        </span>

                                        <strong>

                                            @if($job->min_weight)
                                                {{ $job->min_weight }}
                                            @endif

                                            @if($job->min_weight && $job->max_weight)
                                                –
                                            @endif

                                            @if($job->max_weight)
                                                {{ $job->max_weight }}
                                            @endif

                                            kg

                                        </strong>

                                    </div>

                                @endif



                                {{-- =========================================================
                                    PENDIDIKAN
                                ========================================================== --}}

                                @if($job->last_education)

                                    <div class="requirement-item">

                                        <span class="requirement-label">
                                            PENDIDIKAN
                                        </span>

                                        <strong>
                                            {{ $job->last_education }}
                                        </strong>

                                    </div>

                                @endif



                                {{-- =========================================================
                                    PENGALAMAN
                                ========================================================== --}}

                                @if($job->min_experience)

                                    <div class="requirement-item">

                                        <span class="requirement-label">
                                            PENGALAMAN
                                        </span>

                                        <strong>
                                            Min. {{ $job->min_experience }} Tahun
                                        </strong>

                                    </div>

                                @endif


                            </div>



                            {{-- =============================================================
                                SERTIFIKAT
                            ============================================================= --}}

                            @if($job->certificate)

                                @php

                                    $certificates = json_decode(
                                        $job->certificate,
                                        true
                                    );

                                    if (!is_array($certificates)) {

                                        $certificates = [
                                            $job->certificate
                                        ];

                                    }

                                @endphp


                                @if(count($certificates))

                                    <div class="requirement-certificates mt-4">


                                        <div class="requirement-label mb-2">

                                            SERTIFIKAT YANG DIBUTUHKAN

                                        </div>


                                        <div class="job-tags">


                                            @foreach($certificates as $certificate)

                                                <span class="job-tag">

                                                    <i class="ki-duotone ki-shield-tick text-warning fs-7 me-1"></i>

                                                    {{ $certificate }}

                                                </span>

                                            @endforeach


                                        </div>

                                    </div>

                                @endif

                            @endif

                            {{-- =============================================================
                                SERTIFIKAT
                            ============================================================= --}}

                            @if($job->certificate)

                                @php

                                    $certificates = json_decode(
                                        $job->certificate,
                                        true
                                    );

                                    if (!is_array($certificates)) {

                                        $certificates = [
                                            $job->certificate
                                        ];

                                    }

                                @endphp


                                @if(count($competencySchemes))

                                    <div class="requirement-certificates mt-4">


                                        <div class="requirement-label mb-2">

                                            UJI KOMPETENSI SKEMA YANG DIBUTUHKAN

                                        </div>


                                        <div class="job-tags">


                                            @foreach($competencySchemes as $scheme)

                                                <span class="job-tag">

                                                    <i class="ki-duotone ki-shield-tick text-warning fs-7 me-1"></i>

                                                    {{ $scheme }}

                                                </span>

                                            @endforeach


                                        </div>

                                    </div>

                                @endif

                            @endif


                        </div>

                    @endif



                    {{-- ===================================== --}}
                    {{-- FASILITAS --}}
                    {{-- ===================================== --}}

                    @if($job->facility)

                        @php
                            $facilities = json_decode($job->facility, true);

                            // Kompatibel dengan data lama yang masih berupa text per baris
                            if (!is_array($facilities)) {
                                $facilities = preg_split(
                                    '/\r\n|\r|\n/',
                                    $job->facility
                                );
                            }
                        @endphp

                        @if(count($facilities))

                            <div class="job-detail-card">

                                <div class="detail-title">
                                    FASILITAS & TUNJANGAN
                                </div>

                                <div class="detail-list">

                                    @foreach($facilities as $item)

                                        @if(is_string($item) && trim($item))

                                            <div class="detail-list-item">

                                                <span class="facility-icon">
                                                    <i class="ki-duotone ki-check"></i>
                                                </span>

                                                <span>
                                                    {{ trim($item) }}
                                                </span>

                                            </div>

                                        @endif

                                    @endforeach

                                </div>

                            </div>

                        @endif

                    @endif

                    {{-- ===================================== --}}
                    {{-- STATISTIK --}}
                    {{-- ===================================== --}}

                    <div class="job-detail-card">

                        <div class="detail-title">
                            STATISTIK LOWONGAN
                        </div>

                        <div class="job-statistics">

                            <div>
                                <strong>
                                    {{ $job->total_clicked ?? 0 }}
                                </strong>

                                <span>DILIHAT</span>
                            </div>


                            <div>
                                <strong>
                                    {{ $job->applications_count ?? 0 }}
                                </strong>

                                <span>PELAMAR</span>
                            </div>


                            <div>
                                <strong>
                                    {{ count($job->bookmarks) }}
                                </strong>

                                <span>DISIMPAN</span>
                            </div>

                        </div>

                    </div>



                    {{-- ===================================== --}}
                    {{-- PERUSAHAAN --}}
                    {{-- ===================================== --}}

                    <div class="job-detail-card">

                        <div class="detail-title">
                            TENTANG PERUSAHAAN
                        </div>


                        <div class="company-detail">

                            <div class="company-detail-icon">

                                <i class="ki-duotone ki-office-bag"></i>

                            </div>


                            <div>

                                <strong>

                                    {{ $job->bujp?->company_name
                                        ?? $job->company?->company_name
                                        ?? '-' }}

                                </strong>

                                <span>
                                    Penyelenggara Lowongan
                                </span>

                            </div>

                        </div>


                        @if($job->city)

                            <div class="company-location">

                                <i class="ki-duotone ki-geolocation"></i>

                                {{ $job->city }}

                            </div>

                        @endif

                    </div>

                    {{-- ===================================== --}}
                    {{-- BOTTOM CTA --}}
                    {{-- ===================================== --}}

                    <div class="job-detail-card job-apply-footer">

                        <div>

                            <strong>
                                Tertarik dengan posisi ini?
                            </strong>

                            @if($job->end_date)

                                <span>

                                    Deadline:

                                    <b>
                                        {{ \Carbon\Carbon::parse($job->end_date)
                                            ->translatedFormat('d M Y') }}
                                    </b>

                                </span>

                            @endif

                        </div>


                        @if($applicationStatus === 'shortlisted')

                            <button
                                type="button"
                                class="btn btn-success flex-grow-1"
                                disabled>

                                <i class="ki-duotone ki-check me-1"></i>
                                Anda Terpilih

                            </button>


                        @elseif($applicationStatus === 'rejected')

                            <button
                                type="button"
                                class="btn btn-danger flex-grow-1"
                                disabled>

                                <i class="ki-duotone ki-cross me-1"></i>
                                Lamaran Ditolak

                            </button>


                        @elseif($applicationStatus === 'reviewed')

                            <button
                                type="button"
                                class="btn btn-warning flex-grow-1"
                                disabled>

                                <i class="ki-duotone ki-time me-1"></i>
                                Sedang Direview

                            </button>


                        @elseif($applicationStatus === 'applied')

                            <button
                                type="button"
                                class="btn-apply flex-grow-1 job-apply-btn"
                                data-job-uuid="{{ $job->uuid }}"
                                onclick="cancelApplyJob(this, '{{ $job->uuid }}')">

                                <i class="ki-duotone ki-check me-1"></i>
                                Sudah Dilamar

                            </button>


                        @else

                            <button
                                type="button"
                                class="btn-apply flex-grow-1 job-apply-btn"
                                data-job-uuid="{{ $job->uuid }}"
                                onclick="applyJob(this, '{{ $job->uuid }}')">

                                Lamar Sekarang

                            </button>

                        @endif

                    </div>

                </div>
            </div>

            <!-- Sidebar Kanan (Desktop Only) -->
            <div class="d-none d-lg-block col-lg-2">

            </div>

        </div>
</div>

@endsection

@section('js')
    <script>
        function saveJob(button, uuid)
        {
            let $button = $(button);

            if ($button.data('loading')) {
                return;
            }

            $button.data('loading', true);

            let originalHtml = $button.html();

            $button.prop('disabled', true);

            $button.html(`
                <span class="spinner-border spinner-border-sm me-1"></span>
                Memproses...
            `);

            let url = `/user-page/job-vacancy/${uuid}/bookmark`;

            url = url.replace(':uuid', uuid);

            $.ajax({

                url: url,

                type: 'POST',

                dataType: 'json',

                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },

                success: function(response) {

                    console.log('Bookmark:', response);

                    if (response.saved) {

                        $button
                            .addClass('saved')
                            .html(`
                                <i class="ki-duotone ki-check"></i>
                                Tersimpan
                            `);

                    } else {

                        $button
                            .removeClass('saved')
                            .html(`
                                <i class="ki-duotone ki-bookmark"></i>
                                Simpan
                            `);
                    }

                },

                error: function(xhr) {

                    console.log('STATUS:', xhr.status);
                    console.log('RESPONSE:', xhr.responseText);

                    $button.html(originalHtml);

                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Tidak dapat mengubah bookmark.'
                    });

                },

                complete: function() {

                    $button
                        .prop('disabled', false)
                        .data('loading', false);

                }

            });
        }

        function applyJob(button, uuid)
        {
            Swal.fire({
                title: 'Lamar Lowongan?',
                text: 'Apakah Anda yakin ingin melamar lowongan ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Lamar',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {

                if (!result.isConfirmed) {
                    return;
                }

                /*
                |--------------------------------------------------------------------------
                | Ambil SEMUA tombol lowongan ini
                |--------------------------------------------------------------------------
                */

                const $buttons = $('.job-apply-btn[data-job-uuid="' + uuid + '"]');

                $buttons.prop('disabled', true);

                $.ajax({

                    url: `/user-page/job-vacancy/${uuid}/apply`,

                    type: "POST",

                    data: {
                        _token: "{{ csrf_token() }}",
                    },

                    success: function(response) {

                        if (response.success) {

                            /*
                            |--------------------------------------------------------------------------
                            | UPDATE SEMUA TOMBOL
                            |--------------------------------------------------------------------------
                            */

                            $buttons.each(function() {

                                $(this)
                                    .html(
                                        '<i class="ki-duotone ki-check me-1"></i> Sudah Dilamar'
                                    )
                                    .attr(
                                        'onclick',
                                        `cancelApplyJob(this, '${uuid}')`
                                    );

                            });


                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Lamaran berhasil dikirim.',
                                timer: 1500,
                                showConfirmButton: false
                            });

                        }

                    },

                    error: function(xhr) {

                        console.log(xhr.responseText);

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: xhr.responseJSON?.message
                                ?? 'Terjadi kesalahan saat mengirim lamaran.'
                        });

                    },

                    complete: function() {

                        $buttons.prop('disabled', false);

                    }

                });

            });
        }

        function cancelApplyJob(button, uuid)
        {
            Swal.fire({
                title: 'Batalkan Lamaran?',
                text: 'Apakah Anda yakin ingin membatalkan lamaran pada lowongan ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Batalkan',
                cancelButtonText: 'Tidak',
                reverseButtons: true
            }).then((result) => {

                if (!result.isConfirmed) {
                    return;
                }

                /*
                |--------------------------------------------------------------------------
                | Ambil SEMUA tombol lowongan ini
                |--------------------------------------------------------------------------
                */

                const $buttons = $('.job-apply-btn[data-job-uuid="' + uuid + '"]');

                $buttons.prop('disabled', true);

                $.ajax({

                    url: `/user-page/job-vacancy/${uuid}/cancel-apply`,

                    type: "DELETE",

                    data: {
                        _token: "{{ csrf_token() }}"
                    },

                    success: function(response) {

                        if (response.success) {

                            /*
                            |--------------------------------------------------------------------------
                            | UPDATE SEMUA TOMBOL
                            |--------------------------------------------------------------------------
                            */

                            $buttons.each(function() {

                                $(this)
                                    .html('Lamar Sekarang')
                                    .attr(
                                        'onclick',
                                        `applyJob(this, '${uuid}')`
                                    );

                            });


                            Swal.fire({
                                icon: 'success',
                                title: 'Lamaran Dibatalkan',
                                text: 'Lamaran Anda berhasil dibatalkan.',
                                timer: 1500,
                                showConfirmButton: false
                            });

                        }

                    },

                    error: function(xhr) {

                        console.log(xhr.responseText);

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: xhr.responseJSON?.message
                                ?? 'Terjadi kesalahan saat membatalkan lamaran.'
                        });

                    },

                    complete: function() {

                        $buttons.prop('disabled', false);

                    }

                });

            });
        }
    </script>
@endsection