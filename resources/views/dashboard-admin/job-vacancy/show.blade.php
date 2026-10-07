@extends('layouts.dashboard-admin')

@section('title', 'Detail')

@section('css')
    <style>
        /* =========================================================
           THEME VARIABLES
           ========================================================= */

        :root,
        [data-bs-theme="light"] {
            --job-page-title: #182338;

            --job-card-bg: #ffffff;
            --job-card-border: #e2e8f0;
            --job-card-shadow: 0 4px 14px rgba(20, 34, 55, .05);

            --job-icon-bg: #152040;
            --job-icon-color: #ffffff;

            --job-secondary-text: #6c757d;
            --job-muted-text: #71809a;

            --job-status-bg: #edf4f0;
            --job-status-text: #356b54;

            --job-summary-bg: #ffd54a;
            --job-summary-icon-bg: #152040;
            --job-summary-icon-color: #ffffff;
            --job-summary-small: #555555;
            --job-summary-title: #152040;

            --job-table-text: #6c757d;
            --job-table-heading: #152040;
            --job-table-divider: #ececec;

            --job-salary-bg: #152040;
            --job-salary-text: #ffffff;

            --job-check-icon: #ffc107;
            --job-check-text: #ffffff;

            --job-certificate-bg: #152040;
            --job-certificate-text: #ffffff;
            --job-certificate-hover-bg: #ffc107;
            --job-certificate-hover-text: #152040;
        }

        [data-bs-theme="dark"] {
            --job-page-title: #f1f5f9;

            --job-card-bg: #151d2a;
            --job-card-border: #2b3852;
            --job-card-shadow: 0 4px 14px rgba(0, 0, 0, .20);

            --job-icon-bg: #202d50;
            --job-icon-color: #ffffff;

            --job-secondary-text: #91a0bc;
            --job-muted-text: #8fa0bc;

            --job-status-bg: #1d3a2d;
            --job-status-text: #8bc4a5;

            --job-summary-bg: #3a3218;
            --job-summary-icon-bg: #f6b000;
            --job-summary-icon-color: #111827;
            --job-summary-small: #b8c3d4;
            --job-summary-title: #f6c84c;

            --job-table-text: #91a0bc;
            --job-table-heading: #e7edf5;
            --job-table-divider: #2b3852;

            --job-salary-bg: #202d50;
            --job-salary-text: #ffffff;

            --job-check-icon: #f6b000;
            --job-check-text: #e7edf5;

            --job-certificate-bg: #202d50;
            --job-certificate-text: #ffffff;
            --job-certificate-hover-bg: #f6b000;
            --job-certificate-hover-text: #111827;
        }


        /* =========================================================
           PAGE TITLE
           ========================================================= */

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--job-page-title);
        }


        /* =========================================================
           JOB HEADER
           ========================================================= */

        .job-header-card {
            border-radius: 18px;
            background: var(--job-card-bg);
            border-color: var(--job-card-border) !important;
            box-shadow: var(--job-card-shadow);
        }

        .job-icon {
            width: 90px;
            height: 90px;
            border-radius: 18px;
            background: var(--job-icon-bg);
            color: var(--job-icon-color);
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 34px;
        }

        .job-location,
        .job-period {
            color: var(--job-secondary-text);
            font-size: 15px;
        }


        /* =========================================================
           STATUS
           ========================================================= */

        .badge-status {
            font-size: 14px;
            padding: 12px 20px;
            border-radius: 30px;
            background: var(--job-status-bg);
            color: var(--job-status-text);
        }


        /* =========================================================
           SUMMARY CARD
           ========================================================= */

        .summary-card {
            background: var(--job-summary-bg);
            border-radius: 15px;
            padding: 22px;
            display: flex;
            align-items: center;
            transition: .3s;
            height: 100%;
        }

        .summary-card:hover {
            transform: translateY(-4px);
        }

        .summary-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--job-summary-icon-bg);
            color: var(--job-summary-icon-color);
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 22px;
            margin-right: 18px;
            flex-shrink: 0;
        }

        .summary-card small {
            display: block;
            color: var(--job-summary-small);
            font-weight: 600;
        }

        .summary-card h4 {
            margin: 3px 0 0;
            font-size: 19px;
            font-weight: 700;
            color: var(--job-summary-title);
        }


        /* =========================================================
           DETAIL CARD
           ========================================================= */

        .detail-card {
            border-radius: 16px;
            background: var(--job-card-bg);
            border-color: var(--job-card-border) !important;
            box-shadow: var(--job-card-shadow);
        }

        .detail-card .card-header {
            padding: 18px 22px;
            background: transparent;
            border-bottom-color: var(--job-card-border);
        }

        .detail-card .card-header h5 {
            font-size: 18px;
            font-weight: 700;
            color: var(--job-page-title);
        }

        .detail-card .card-body {
            line-height: 1.8;
        }


        /* =========================================================
           DETAIL TABLE
           ========================================================= */

        .detail-table {
            margin-bottom: 0;
        }

        .detail-table td {
            color: var(--job-table-text);
            padding: 12px 6px;
            vertical-align: top;
            font-weight: 500;
        }

        .detail-table th {
            color: var(--job-table-heading);
            padding: 12px 6px;
            font-weight: 600;
        }

        .detail-table tr:not(:last-child) {
            border-bottom: 1px dashed var(--job-table-divider);
        }


        /* =========================================================
           SALARY
           ========================================================= */

        .salary-text {
            color: var(--job-salary-text);
            font-size: 30px;
            font-weight: 700;
        }


        /* =========================================================
           CHECK ITEM
           ========================================================= */

        .check-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 14px;
        }

        .check-item i {
            color: var(--job-check-icon);
            font-size: 18px;
            margin-right: 12px;
            margin-top: 3px;
        }

        .check-item span {
            color: var(--job-check-text);
            line-height: 1.7;
        }


        /* =========================================================
           CERTIFICATE
           ========================================================= */

        .certificate-badge {
            display: inline-block;
            background: var(--job-certificate-bg);
            color: var(--job-certificate-text);
            padding: 10px 18px;
            border-radius: 30px;
            margin: 6px;
            font-size: 14px;
            font-weight: 600;
            transition: .3s;
        }

        .certificate-badge:hover {
            background: var(--job-certificate-hover-bg);
            color: var(--job-certificate-hover-text);
        }
    </style>
@endsection

@section('breadcrumb')
    <h1
        class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
        Manajemen Lowongan</h1>
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
            <a href="{{ route('dashboard-user.job-vacancy.index') }}" class="text-muted text-hover-primary">Manajemen Lowongan</a>
        </li>
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
    <div class="container-fluid">

        <!-- Breadcrumb -->
        <div class="d-flex align-items-center justify-content-between mb-4">

            <div>

                @if($data->status == 'submitted')

                <button
                    type="button"
                    class="btn btn-danger me-2"
                    data-bs-toggle="modal"
                    data-bs-target="#rejectModal">

                    <i class="fas fa-times-circle me-2"></i>

                    Tolak Lowongan

                </button>

                <button
                    type="button"
                    class="btn btn-success"
                    data-bs-toggle="modal"
                    data-bs-target="#publishModal">

                    <i class="fas fa-check-circle me-2"></i>

                    Terbitkan Lowongan

                </button>

                @endif

            </div>

            <button
                type="button"
                class="btn btn-light"
                onclick="window.history.back()">

                <i class="fas fa-arrow-left me-2"></i>

                Kembali

            </button>

        </div>

        <!-- Hero Card -->

        @php
            $companyName = '-';

            if ($data->bujp) {
                $companyName = $data->bujp->company_name;
            } elseif ($data->company) {
                $companyName = $data->company->company_name;
            }
        @endphp

        <div class="card border-0 shadow-sm job-header-card">

            <div class="card-body">

                <div class="row align-items-center">

                    <div class="col-lg-8">

                        <div class="d-flex align-items-center">

                            <div class="job-icon">
                                <i class="fas fa-briefcase"></i>
                            </div>

                            <div class="ms-4">

                                <h2 class="mb-2">
                                    {{ $data->position }}
                                </h2>

                                {{-- COMPANY --}}
                                <div class="d-flex align-items-center mb-2">

                                    <i class="fas fa-building text-primary me-2"></i>

                                    <span class="fw-semibold fs-6 text-gray-700">
                                        {{ $companyName }}
                                    </span>

                                </div>

                                {{-- CATEGORY --}}
                                <div class="mb-2">

                                    @if ($data->category === 'security')

                                        <span class="badge job-category-badge job-category-security">
                                            <i class="fas fa-shield-alt me-1"></i>
                                            Satpam
                                        </span>

                                    @elseif ($data->category === 'cs')

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

                                {{-- LOCATION & PERIOD --}}
                                <div class="d-flex flex-wrap">

                                    <span class="job-location">

                                        <i class="fas fa-map-marker-alt me-1"></i>

                                        {{ $data->city }},
                                        {{ $data->province }}

                                    </span>

                                    <span class="mx-3 text-muted">
                                        |
                                    </span>

                                    <span class="job-period">

                                        <i class="fas fa-calendar-alt me-1"></i>

                                        {{ \Carbon\Carbon::parse($data->start_date)->format('d M Y') }}

                                        -

                                        {{ \Carbon\Carbon::parse($data->end_date)->format('d M Y') }}

                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- STATUS --}}
                    <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">

                        @switch($data->status)

                            @case('draft')

                                <span class="badge badge-status badge-secondary">
                                    Draft
                                </span>

                            @break

                            @case('submitted')

                                <span class="badge badge-status badge-warning">
                                    Menunggu Persetujuan
                                </span>

                            @break

                            @case('published')

                                <span class="badge badge-status badge-success">
                                    Dipublikasikan
                                </span>

                            @break

                            @case('closed')

                                <span class="badge badge-status badge-dark">
                                    Ditutup
                                </span>

                            @break

                            @case('rejected')

                                <span class="badge badge-status badge-danger">
                                    Ditolak
                                </span>

                            @break

                        @endswitch

                    </div>

                </div>

            </div>

        </div>


        @if($data->status=='rejected')

            <div class="alert alert-danger mt-4">

                <strong>

                    Alasan Penolakan

                </strong>

                <hr>

                {{ $data->reason_rejected }}

            </div>

        @endif



        <!-- Summary -->

        <div class="row mt-4">

            <div class="col-lg-3 col-md-6 mb-3">

                <div class="summary-card">

                    <div class="summary-icon">

                        <i class="fas fa-users"></i>

                    </div>

                    <div>

                        <small>Kuota</small>

                        <h4>

                            {{ number_format($data->kuota) }}

                            Orang

                        </h4>

                    </div>

                </div>

            </div>


            <div class="col-lg-3 col-md-6 mb-3">

                <div class="summary-card">

                    <div class="summary-icon">

                        <i class="fas fa-pencil"></i>

                    </div>

                    <div>

                        <small>Pelamar</small>

                        <h4>

                            0 Orang

                        </h4>

                    </div>

                </div>

            </div>


            <div class="col-lg-3 col-md-6 mb-3">

                <div class="summary-card">

                    <div class="summary-icon">

                        <i class="fas fa-bookmark"></i>

                    </div>

                    <div>

                        <small>Disimpan</small>

                        <h4>

                            0 Kali

                        </h4>

                    </div>

                </div>

            </div>


            <div class="col-lg-3 col-md-6 mb-3">

                <div class="summary-card">

                    <div class="summary-icon">

                        <i class="fas fa-eye"></i>

                    </div>

                    <div>

                        <small>Dilihat</small>

                        <h4>

                            {{ number_format($data->total_clicked ?? 0) }}

                            Kali

                        </h4>

                    </div>

                </div>

            </div>

        </div>

        <div class="row mt-4">

            <!-- Informasi Dasar -->
            <div class="col-lg-6 mb-4">

                <div class="card border-0 shadow-sm detail-card">

                    <div class="card-header  border-0">

                        <h5 class="mb-0">
                            <i class="fas fa-circle-info text-warning me-2"></i>
                            Informasi Dasar
                        </h5>

                    </div>

                    <div class="card-body">

                        <table class="table table-borderless detail-table">

                            <tr>
                                <td width="40%">Posisi</td>
                                <th>{{ $data->position ?? '-' }}</th>
                            </tr>

                            <tr>
                                <td>Status</td>
                                <th>

                                    @switch($data->status)

                                        @case('draft')
                                            <span class="badge bg-secondary">Draft</span>
                                        @break

                                        @case('submitted')
                                            <span class="badge bg-warning">Submitted</span>
                                        @break

                                        @case('published')
                                            <span class="badge bg-success">Published</span>
                                        @break

                                        @case('closed')
                                            <span class="badge bg-dark">Closed</span>
                                        @break

                                        @case('rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                        @break

                                    @endswitch

                                </th>
                            </tr>

                            <tr>
                                <td>Jenis Pekerjaan</td>
                                <th>{{ ucfirst($data->working_type) }}</th>
                            </tr>

                            <tr>
                                <td>Sistem Kerja</td>
                                <th>{{ ucfirst($data->working_system) }}</th>
                            </tr>

                            <tr>
                                <td>Kuota</td>
                                <th>{{ number_format($data->kuota) }} Orang</th>
                            </tr>

                            <tr>
                                <td>Periode Lowongan</td>
                                <th>

                                    {{ \Carbon\Carbon::parse($data->start_date)->format('d M Y') }}

                                    -

                                    {{ \Carbon\Carbon::parse($data->end_date)->format('d M Y') }}

                                </th>
                            </tr>

                            <tr>

                                <td>Jumlah Dilihat</td>

                                <th>

                                    {{ number_format($data->total_clicked ?? 0) }}

                                    Kali

                                </th>

                            </tr>

                        </table>

                    </div>

                </div>

            </div>

            <!-- Lokasi Penempatan -->

            <div class="col-lg-6 mb-4">

                <div class="card border-0 shadow-sm detail-card">

                    <div class="card-header  border-0">

                        <h5 class="mb-0">

                            <i class="fas fa-location-dot text-warning me-2"></i>

                            Lokasi Penempatan

                        </h5>

                    </div>

                    <div class="card-body">

                        <table class="table table-borderless detail-table">

                            <tr>

                                <td width="40%">Provinsi</td>

                                <th>{{ $data->province ?? '-' }}</th>

                            </tr>

                            <tr>

                                <td>Kota / Kabupaten</td>

                                <th>{{ $data->city ?? '-' }}</th>

                            </tr>

                            {{-- <tr>

                                <td>Kecamatan</td>

                                <th>{{ $data->district ?? '-' }}</th>

                            </tr>

                            <tr>

                                <td>Kelurahan</td>

                                <th>{{ $data->village ?? '-' }}</th>

                            </tr> --}}

                            <tr>

                                <td>Alamat Lengkap</td>

                                <th>

                                    {{ $data->address ?? '-' }}

                                </th>

                            </tr>

                        </table>

                    </div>

                </div>

            </div>

        </div>

        <div class="row">

            <!-- Deskripsi Pekerjaan -->
            <div class="col-lg-12 mb-4">

                <div class="card border-0 shadow-sm detail-card">

                    <div class="card-header  border-0">

                        <h5 class="mb-0">
                            <i class="fas fa-file-lines text-warning me-2"></i>
                            Deskripsi Pekerjaan
                        </h5>

                    </div>

                    <div class="card-body">

                        {!! nl2br(e($data->description_work)) !!}

                    </div>

                </div>

            </div>



            <!-- Persyaratan -->

            <div class="col-lg-5 mb-4">

                <div class="card border-0 shadow-sm detail-card">

                    <div class="card-header  border-0">

                        <h5 class="mb-0">

                            <i class="fas fa-user-check text-warning me-2"></i>

                            Persyaratan Pelamar

                        </h5>

                    </div>


                    <div class="card-body">

                        <table class="table table-borderless detail-table mb-0">


                            {{-- JENIS KELAMIN --}}
                            <tr>

                                <td width="45%">
                                    Jenis Kelamin
                                </td>

                                <th>
                                    {{ $data->gender ?? 'Semua Gender' }}
                                </th>

                            </tr>


                            {{-- USIA --}}
                            <tr>

                                <td>
                                    Usia
                                </td>

                                <th>

                                    @if($data->min_age || $data->max_age)

                                        {{ $data->min_age ?? '-' }}

                                        -

                                        {{ $data->max_age ?? '-' }}

                                        Tahun

                                    @else

                                        Tidak ditentukan

                                    @endif

                                </th>

                            </tr>


                            {{-- TINGGI BADAN --}}
                            <tr>

                                <td>
                                    Tinggi Badan
                                </td>

                                <th>

                                    @if($data->min_height || $data->max_height)

                                        {{ $data->min_height ?? '-' }}

                                        -

                                        {{ $data->max_height ?? '-' }}

                                        cm

                                    @else

                                        Tidak ditentukan

                                    @endif

                                </th>

                            </tr>


                            {{-- BERAT BADAN --}}
                            <tr>

                                <td>
                                    Berat Badan
                                </td>

                                <th>

                                    @if($data->min_weight || $data->max_weight)

                                        {{ $data->min_weight ?? '-' }}

                                        -

                                        {{ $data->max_weight ?? '-' }}

                                        kg

                                    @else

                                        Tidak ditentukan

                                    @endif

                                </th>

                            </tr>


                            {{-- PENDIDIKAN --}}
                            <tr>

                                <td>
                                    Pendidikan
                                </td>

                                <th>
                                    {{ $data->last_education ?? 'Tidak ditentukan' }}
                                </th>

                            </tr>


                            {{-- PENGALAMAN --}}
                            <tr>

                                <td>
                                    Minimal Pengalaman
                                </td>

                                <th>

                                    {{ $data->min_experience ?? 0 }}

                                    Tahun

                                </th>

                            </tr>


                        </table>

                    </div>

                </div>

            </div>



            <!-- Gaji -->

            <div class="col-lg-7 mb-4">

                <div class="card border-0 shadow-sm detail-card">

                    <div class="card-header  border-0">

                        <h5 class="mb-0">

                            <i class="fas fa-wallet text-warning me-2"></i>

                            Informasi Gaji

                        </h5>

                    </div>

                    <div class="card-body">

                        @if($data->is_show_fee)

                            <h3 class="salary-text">

                                Rp {{ number_format($data->min_price,0,',','.') }}

                                -

                                Rp {{ number_format($data->max_price,0,',','.') }}

                            </h3>

                            <span class="badge bg-warning text-dark mt-2">

                                {{ ucfirst($data->fee_type) }}

                            </span>

                        @else

                            <div class="alert alert-warning mb-0">

                                Nominal gaji tidak ditampilkan oleh perusahaan.

                            </div>

                        @endif

                    </div>

                </div>

            </div>



            <!-- Tanggung Jawab -->

            <div class="col-lg-6 mb-4">

                <div class="card border-0 shadow-sm detail-card">

                    <div class="card-header  border-0">

                        <h5 class="mb-0">

                            <i class="fas fa-list-check text-warning me-2"></i>

                            Tanggung Jawab

                        </h5>

                    </div>

                    <div class="card-body">

                        @php

                            $responsibilities = json_decode($data->responsibility,true) ?? [];

                        @endphp

                        @forelse($responsibilities as $item)

                            <div class="check-item">

                                <i class="fas fa-check-circle"></i>

                                <p>{{ $item }}</p>

                            </div>

                        @empty

                            <p class="text-muted">

                                Tidak ada data.

                            </p>

                        @endforelse

                    </div>

                </div>

            </div>



            <!-- Benefit -->

            <div class="col-lg-6 mb-4">

                <div class="card border-0 shadow-sm detail-card">

                    <div class="card-header  border-0">

                        <h5 class="mb-0">

                            <i class="fas fa-gift text-warning me-2"></i>

                            Fasilitas & Benefit

                        </h5>

                    </div>

                    <div class="card-body">

                        @php

                            $facilities = json_decode($data->facility,true) ?? [];

                        @endphp

                        @forelse($facilities as $item)

                            <div class="check-item">

                                <i class="fas fa-check-circle"></i>

                                <p>{{ $item }}</p>

                            </div>

                        @empty

                            <p class="text-muted">

                                Tidak ada data.

                            </p>

                        @endforelse

                    </div>

                </div>

            </div>



            <!-- Sertifikasi -->

            <div class="col-lg-12 mb-4">

                <div class="card border-0 shadow-sm detail-card">

                    <div class="card-header  border-0">

                        <h5 class="mb-0">

                            <i class="fas fa-certificate text-warning me-2"></i>

                            Sertifikasi yang Dibutuhkan

                        </h5>

                    </div>

                    <div class="card-body">

                        @php

                            $certificates = json_decode($data->certificate,true) ?? [];

                        @endphp

                        @forelse($certificates as $certificate)

                            <span class="certificate-badge">

                                {{ $certificate }}

                            </span>

                        @empty

                            <span class="text-muted">

                                Tidak ada sertifikasi khusus.

                            </span>

                        @endforelse

                    </div>

                </div>

            </div>

            <!-- Kompetensi Skema -->

            <div class="col-lg-12 mb-4">

                <div class="card border-0 shadow-sm detail-card">

                    <div class="card-header  border-0">

                        <h5 class="mb-0">

                            <i class="fas fa-award text-warning me-2"></i>

                            Uji Kompetensi Skema yang Dibutuhkan

                        </h5>

                    </div>


                    <div class="card-body">

                        @php

                            $competencySchemes = json_decode(
                                $data->competency_scheme,
                                true
                            ) ?? [];

                        @endphp


                        @forelse($competencySchemes as $scheme)

                            <span class="certificate-badge">

                                {{ $scheme }}

                            </span>

                        @empty

                            <span class="text-muted">

                                Tidak ada uji kompetensi skema khusus.

                            </span>

                        @endforelse

                    </div>

                </div>

            </div>

        </div>
    </div>

    <div class="modal fade" id="publishModal" tabindex="-1">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">

                        Terbitkan Lowongan

                    </h5>

                    <button
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body text-center">

                    <i class="fas fa-check-circle text-success fs-3x mb-5"></i>

                    <h4>

                        Yakin ingin menerbitkan lowongan ini?

                    </h4>

                    <p class="text-muted mb-0">

                        Setelah diterbitkan, lowongan akan langsung tampil kepada seluruh pelamar.

                    </p>

                </div>

                <div class="modal-footer">

                    <button
                        class="btn btn-light"
                        data-bs-dismiss="modal">

                        Batal

                    </button>

                    <button
                        class="btn btn-success"
                        id="btnConfirmPublish">

                        Ya, Terbitkan

                    </button>

                </div>

            </div>

        </div>

    </div>

    <div class="modal fade" id="rejectModal" tabindex="-1">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">

                        Tolak Lowongan

                    </h5>

                    <button
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="alert alert-warning">

                        Berikan alasan penolakan agar BUJP / Company dapat memperbaiki lowongan.

                    </div>

                    <label class="form-label required">

                        Alasan Penolakan

                    </label>

                    <textarea
                        class="form-control"
                        id="reasonRejected"
                        rows="5"
                        placeholder="Tuliskan alasan penolakan..."></textarea>

                    <div
                        class="invalid-feedback"
                        id="reasonError">
                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        class="btn btn-light"
                        data-bs-dismiss="modal">

                        Batal

                    </button>

                    <button
                        class="btn btn-danger"
                        id="btnConfirmReject">

                        Tolak Lowongan

                    </button>

                </div>

            </div>

        </div>

    </div>
@endsection

@section('js')
    <script>
        // Publish

        $("#btnConfirmPublish").click(function(){

            $.ajax({

                url: "/dashboard-admin/job-vacancy/{{ $data->uuid }}/publish",

                type:"POST",

                data:{
                    _token:$('meta[name="csrf-token"]').attr("content")
                },

                success:function(res){

                    Swal.fire({

                        icon:"success",

                        title:"Berhasil",

                        text:res.message

                    }).then(function(){

                        location.reload();

                    });

                }

            });

        });



        // Reject

        $("#btnConfirmReject").click(function(){

            $("#reasonRejected").removeClass("is-invalid");

            $("#reasonError").html("");

            let reason = $("#reasonRejected").val();

            if(reason.trim()==""){

                $("#reasonRejected").addClass("is-invalid");

                $("#reasonError").html("Alasan penolakan wajib diisi.");

                return;

            }

            $.ajax({

                url:"/dashboard-admin/job-vacancy/{{ $data->uuid }}/reject",

                type:"POST",

                data:{

                    _token:$('meta[name="csrf-token"]').attr("content"),

                    reason_rejected:reason

                },

                success:function(res){

                    Swal.fire({

                        icon:"success",

                        title:"Berhasil",

                        text:res.message

                    }).then(function(){

                        location.reload();

                    });

                }

            });

        });
    </script>
@endsection