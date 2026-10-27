@extends('layouts.dashboard-user')

@section('title', 'Detail')

@section('css')
    
<style>
    /* =========================================================
       THEME VARIABLES - LIGHT MODE
    ========================================================= */
    :root {
        --job-page-bg: #f7f8fa;
        --job-surface: #ffffff;
        --job-surface-soft: #f8fafc;
        --job-surface-hover: #f1f5f9;

        --job-border: #e2e8f0;
        --job-border-strong: #cbd5e1;

        --job-title: #182338;
        --job-text: #475569;
        --job-muted: #64748b;

        --job-icon-bg: #eef2f7;
        --job-icon-color: #152040;

        --job-summary-bg: #fff4d6;
        --job-summary-border: #f4d77c;
        --job-summary-title: #182338;
        --job-summary-text: #64748b;

        --job-accent: #e8a801;
        --job-accent-hover: #f2b600;
        --job-accent-soft: rgba(232, 168, 1, .12);

        --job-table-border: #e2e8f0;
        --job-table-label: #64748b;
        --job-table-value: #182338;

        --job-certificate-bg: #eef2f7;
        --job-certificate-text: #152040;

        --job-shadow: 0 8px 25px rgba(15, 23, 42, .06);
    }

    /* =========================================================
       DARK MODE
    ========================================================= */
    [data-bs-theme="dark"],
    .dark-layout,
    .dark-mode,
    [data-theme="dark"] {
        --job-page-bg: #0b1020;
        --job-surface: #11192c;
        --job-surface-soft: #0d1426;
        --job-surface-hover: #1b2942;

        --job-border: rgba(255, 255, 255, .08);
        --job-border-strong: rgba(255, 255, 255, .15);

        --job-title: #ffffff;
        --job-text: #cbd5e1;
        --job-muted: #95a2bd;

        --job-icon-bg: #152040;
        --job-icon-color: #ffffff;

        --job-summary-bg: #1b2438;
        --job-summary-border: rgba(255, 213, 74, .25);
        --job-summary-title: #ffffff;
        --job-summary-text: #b7c2d6;

        --job-accent: #ffc107;
        --job-accent-hover: #ffd04a;
        --job-accent-soft: rgba(255, 193, 7, .12);

        --job-table-border: rgba(255, 255, 255, .10);
        --job-table-label: #a5b1c7;
        --job-table-value: #ffffff;

        --job-certificate-bg: #152040;
        --job-certificate-text: #ffffff;

        --job-shadow: 0 8px 25px rgba(0, 0, 0, .16);
    }

    /* =========================================================
       PAGE TITLE
    ========================================================= */
    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: var(--job-title);
    }

    /* =========================================================
       HEADER CARD
    ========================================================= */
    .job-header-card {
        border-radius: 18px;
        background: var(--job-surface);
        border: 1px solid var(--job-border);
        box-shadow: var(--job-shadow);
        color: var(--job-text);
    }

    /* =========================================================
       JOB ICON / LOGO
    ========================================================= */
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
        overflow: hidden;
        flex-shrink: 0;
        border: 1px solid var(--job-border);
        transition: background .25s ease;
    }

    .job-icon img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        transition: transform .3s ease;
    }

    .job-icon:hover img {
        transform: scale(1.08);
    }

    /* =========================================================
       LOCATION & PERIOD
    ========================================================= */
    .job-location,
    .job-period {
        color: var(--job-muted);
        font-size: 15px;
    }

    /* =========================================================
       STATUS BADGE
    ========================================================= */
    .badge-status {
        font-size: 14px;
        padding: 12px 20px;
        border-radius: 30px;
    }

    /* =========================================================
       SUMMARY CARD
    ========================================================= */
    .summary-card {
        background: var(--job-summary-bg);
        border: 1px solid var(--job-summary-border);
        border-radius: 15px;
        padding: 22px;
        display: flex;
        align-items: center;
        transition: transform .3s ease, box-shadow .3s ease;
        height: 100%;
        box-shadow: var(--job-shadow);
    }

    .summary-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(15, 23, 42, .10);
    }

    .summary-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: var(--job-icon-bg);
        color: var(--job-icon-color);
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 22px;
        margin-right: 18px;
        flex-shrink: 0;
    }

    .summary-card small {
        display: block;
        color: var(--job-summary-text);
        font-weight: 600;
    }

    .summary-card h4 {
        margin: 3px 0 0;
        font-size: 19px;
        font-weight: 700;
        color: var(--job-summary-title);
        overflow-wrap: anywhere;
    }

    /* =========================================================
       DETAIL CARD
    ========================================================= */
    .detail-card {
        border-radius: 16px;
        background: var(--job-surface);
        border: 1px solid var(--job-border);
        color: var(--job-text);
        box-shadow: var(--job-shadow);
        overflow: hidden;
    }

    .detail-card .card-header {
        padding: 18px 22px;
        background: var(--job-surface);
        border-bottom: 1px solid var(--job-border);
    }

    .detail-card .card-header h5 {
        font-size: 18px;
        font-weight: 700;
        color: var(--job-title);
        margin-bottom: 0;
    }

    .detail-card .card-body {
        line-height: 1.8;
        color: var(--job-text);
        background: var(--job-surface);
    }

    /* =========================================================
       DETAIL TABLE
    ========================================================= */
    .detail-table {
        margin-bottom: 0;
        background: transparent;
        --bs-table-bg: transparent;
        --bs-table-color: var(--job-text);
        --bs-table-border-color: var(--job-table-border);
    }

    .detail-table td {
        color: var(--job-table-label);
        padding: 12px 6px;
        vertical-align: top;
        font-weight: 500;
    }

    .detail-table th {
        color: var(--job-table-value);
        padding: 12px 6px;
        font-weight: 600;
    }

    .detail-table tr:not(:last-child) {
        border-bottom: 1px dashed var(--job-table-border);
    }

    /* =========================================================
       SALARY
    ========================================================= */
    .salary-text {
        color: var(--job-title);
        font-size: 30px;
        font-weight: 700;
    }

    /* =========================================================
       REQUIREMENTS / CHECKLIST
    ========================================================= */
    .check-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 14px;
    }

    .check-item i {
        color: var(--job-accent);
        font-size: 18px;
        margin-right: 12px;
        margin-top: 3px;
        flex-shrink: 0;
    }

    .check-item span {
        color: var(--job-text);
        line-height: 1.7;
    }

    /* =========================================================
       CERTIFICATE BADGE
    ========================================================= */
    .certificate-badge {
        display: inline-block;
        background: var(--job-certificate-bg);
        color: var(--job-certificate-text);
        border: 1px solid var(--job-border);
        padding: 10px 18px;
        border-radius: 30px;
        margin: 6px;
        font-size: 14px;
        font-weight: 600;
        transition: background .25s ease, color .25s ease;
    }

    .certificate-badge:hover {
        background: var(--job-accent);
        border-color: var(--job-accent);
        color: #152040;
    }

    /* =========================================================
       RESPONSIVE
    ========================================================= */
    @media (max-width: 768px) {
        .page-title {
            font-size: 23px;
        }

        .job-icon {
            width: 70px;
            height: 70px;
            border-radius: 14px;
            font-size: 28px;
        }

        .summary-card {
            padding: 16px;
        }

        .summary-icon {
            width: 48px;
            height: 48px;
            font-size: 19px;
            margin-right: 12px;
        }

        .summary-card h4 {
            font-size: 17px;
        }

        .detail-card .card-header {
            padding: 16px;
        }

        .salary-text {
            font-size: 25px;
        }
    }
</style>

@endsection

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
            <a href="{{ route('dashboard-user.job-vacancy.index') }}" class="text-muted text-hover-primary">Pelatihan Saya</a>
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

        <div class="d-flex align-items-center justify-content-between mb-4">

            <div>

            </div>

            <a href="{{ route('dashboard-user.training.index') }}"
            class="btn btn-light">

                <i class="fas fa-arrow-left me-2"></i>

                Kembali

            </a>

        </div>

        <!-- Hero Card -->
        <div class="card border-0 shadow-sm job-header-card">

            <div class="card-body">

                <div class="row align-items-center">

                    <!-- Informasi -->
                    <div class="col-lg-8">

                        <div class="d-flex align-items-center">

                            @if($data->poster)

                                <div
                                    class="job-icon p-0 overflow-hidden"
                                    style="cursor:pointer;"
                                    data-bs-toggle="modal"
                                    data-bs-target="#posterModal">

                                    <img
                                        src="{{ asset('storage/' . $data->poster) }}"
                                        alt="{{ $data->title }}"
                                        style="
                                            width:100%;
                                            height:100%;
                                            object-fit:cover;
                                        ">

                                </div>

                            @else

                                <div class="job-icon">

                                    <i class="fas fa-graduation-cap"></i>

                                </div>

                            @endif

                            <div class="ms-4">

                                <h2 class="mb-2">

                                    {{ $data->title }}

                                    @if($data->is_certificate)

                                        <div class="mt-3">

                                            <span class="badge bg-warning text-dark fs-7 px-4 py-2">

                                                <i class="fas fa-certificate me-2"></i>

                                                Bersertifikat

                                            </span>

                                        </div>

                                    @endif

                                </h2>

                                <div class="text-muted fw-semibold mb-3">

                                    <i class="fas fa-building me-2"></i>

                                    {{ $data->provider }}

                                </div>

                                <div class="d-flex flex-wrap align-items-center">

                                    <span class="job-location">

                                        <i class="fas fa-layer-group me-1"></i>

                                        {{ ucfirst($data->category) }}

                                    </span>

                                    <span class="mx-3 text-muted">|</span>

                                    <span class="job-location">

                                        <i class="fas fa-signal me-1"></i>

                                        {{ ucfirst($data->level) }}

                                    </span>

                                    <span class="mx-3 text-muted">|</span>

                                    <span class="job-location">

                                        <i class="fas fa-calendar-alt me-1"></i>

                                        {{ \Carbon\Carbon::parse($data->start_date)->format('d M Y') }}

                                        -

                                        {{ \Carbon\Carbon::parse($data->end_date)->format('d M Y') }}

                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- Status -->
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

                            @case('running')

                                <span class="badge badge-status badge-primary">

                                    Sedang Berlangsung

                                </span>

                            @break

                            @case('closed')

                                <span class="badge badge-status badge-danger">

                                    Ditutup

                                </span>

                            @break

                            @case('cancelled')

                                <span class="badge badge-status badge-danger">

                                    Dibatalkan

                                </span>

                            @break

                            @case('rejected')

                                <span class="badge badge-status badge-danger">

                                    Ditolak

                                </span>

                            @break

                        @endswitch


                        <div class="mt-4">

                            @if($data->is_free)

                                <span class="badge bg-success fs-6 px-5 py-3">

                                    <i class="fas fa-gift me-2"></i>

                                    GRATIS

                                </span>

                            @else

                                <div class="salary-text">

                                    Rp {{ number_format((int)$data->price,0,',','.') }}

                                </div>

                                <small class="text-muted">

                                    Biaya Pelatihan

                                </small>

                            @endif

                        </div>

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

            <!-- Kuota -->
            <div class="col-lg-3 col-md-6 mb-3">

                <div class="summary-card">

                    <div class="summary-icon">

                        <i class="fas fa-users"></i>

                    </div>

                    <div>

                        <small>Kuota Peserta</small>

                        <h4>

                            {{ number_format($data->quota ?? 0) }}

                            Orang

                        </h4>

                    </div>

                </div>

            </div>

            <!-- Terdaftar -->
            <div class="col-lg-3 col-md-6 mb-3">

                <div class="summary-card">

                    <div class="summary-icon">

                        <i class="fas fa-user-check"></i>

                    </div>

                    <div>

                        <small>Peserta Terdaftar</small>

                        <h4>

                            {{ number_format($data->registered ?? 0) }}

                            Orang

                        </h4>

                    </div>

                </div>

            </div>

            <!-- Dilihat -->
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

            <div class="col-lg-3 col-md-6 mb-3">

                <div class="summary-card">

                    <div class="summary-icon">

                        @switch($data->training_mode)

                            @case('online')
                                <i class="fas fa-video"></i>
                            @break

                            @case('offline')
                                <i class="fas fa-map-marker-alt"></i>
                            @break

                            @default
                                <i class="fas fa-laptop-house"></i>
                        @endswitch

                    </div>

                    <div>

                        <small>Mode Pelatihan</small>

                        <h4>

                            {{ ucfirst($data->training_mode) }}

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
                                <td width="40%">Judul</td>
                                <th>{{ $data->title }}</th>
                            </tr>

                            <tr>
                                <td>Penyelenggara</td>
                                <th>{{ $data->provider }}</th>
                            </tr>

                            <tr>
                                <td>Instruktur</td>
                                <th>{{ $data->instructor ?: '-' }}</th>
                            </tr>

                            <tr>
                                <td>Kategori</td>
                                <th>{{ ucfirst($data->category) }}</th>
                            </tr>

                            <tr>
                                <td>Level</td>
                                <th>{{ ucfirst($data->level) }}</th>
                            </tr>

                            <tr>
                                <td>Biaya</td>

                                <th>

                                    @if($data->is_free)

                                        <span class="badge bg-success">
                                            Gratis
                                        </span>

                                    @else

                                        Rp {{ number_format($data->price,0,',','.') }}

                                    @endif

                                </th>

                            </tr>

                            <tr>
                                <td>Status</td>

                                <th>

                                    @switch($data->status)

                                        @case('draft')
                                            <span class="badge bg-secondary">Draft</span>
                                        @break

                                        @case('submitted')
                                            <span class="badge bg-warning">Menunggu Review</span>
                                        @break

                                        @case('published')
                                            <span class="badge bg-success">Dipublikasikan</span>
                                        @break

                                        @case('running')
                                            <span class="badge bg-primary">Berlangsung</span>
                                        @break

                                        @case('closed')
                                            <span class="badge bg-danger">Ditutup</span>
                                        @break

                                        @case('cancelled')
                                            <span class="badge bg-danger">Dibatalkan</span>
                                        @break

                                        @case('rejected')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @break

                                    @endswitch

                                </th>

                            </tr>

                        </table>

                    </div>

                </div>

            </div>


            <!-- Jadwal -->

            <div class="col-lg-6 mb-4">

                <div class="card border-0 shadow-sm detail-card">

                    <div class="card-header  border-0">

                        <h5 class="mb-0">

                            <i class="fas fa-calendar-alt text-warning me-2"></i>

                            Jadwal Pelatihan

                        </h5>

                    </div>

                    <div class="card-body">

                        <table class="table table-borderless detail-table">

                            <tr>
                                <td width="40%">Tanggal Mulai</td>

                                <th>

                                    {{ \Carbon\Carbon::parse($data->start_date)->format('d M Y') }}

                                </th>

                            </tr>

                            <tr>
                                <td>Tanggal Selesai</td>

                                <th>

                                    {{ \Carbon\Carbon::parse($data->end_date)->format('d M Y') }}

                                </th>

                            </tr>

                            <tr>
                                <td>Durasi</td>

                                <th>

                                    {{ $data->duration_day }}

                                    Hari

                                </th>

                            </tr>

                            <tr>
                                <td>Total JP</td>

                                <th>

                                    {{ $data->total_jp }}

                                    JP

                                </th>

                            </tr>

                            <tr>
                                <td>Mode</td>

                                <th>

                                    {{ ucfirst($data->training_mode) }}

                                </th>

                            </tr>

                        </table>

                    </div>

                </div>

            </div>

        </div>

        <div class="row">

            <div class="col-lg-12 mb-4">

                <div class="card border-0 shadow-sm detail-card">

                    <div class="card-header  border-0">

                        <h5>

                            <i class="fas fa-map-marker-alt text-warning me-2"></i>

                            Lokasi Pelatihan

                        </h5>

                    </div>

                    <div class="card-body">

                        @if($data->training_mode != 'online')

                            <table class="table table-borderless detail-table">

                                <tr>
                                    <td width="25%">Provinsi</td>
                                    <th>{{ $data->province }}</th>
                                </tr>

                                <tr>
                                    <td>Kota</td>
                                    <th>{{ $data->city }}</th>
                                </tr>

                                {{-- <tr>
                                    <td>Kecamatan</td>
                                    <th>{{ $data->district }}</th>
                                </tr>

                                <tr>
                                    <td>Kelurahan</td>
                                    <th>{{ $data->village }}</th>
                                </tr> --}}

                                <tr>
                                    <td>Alamat</td>
                                    <th>{{ $data->address }}</th>
                                </tr>

                                @if($data->google_map)

                                <tr>
                                    <td>Google Maps</td>

                                    <th>

                                        <a href="{{ $data->google_map }}" target="_blank">

                                            Lihat Lokasi

                                        </a>

                                    </th>

                                </tr>

                                @endif

                            </table>

                        @endif


                        @if($data->training_mode != 'offline')

                            <hr>

                            <h6>

                                Meeting Online

                            </h6>

                            <a href="{{ $data->meeting_url }}"

                                target="_blank"

                                class="btn btn-warning">

                                <i class="fas fa-video me-2"></i>

                                Gabung Meeting

                            </a>

                        @endif

                    </div>

                </div>

            </div>

        </div>

        <div class="card border-0 shadow-sm detail-card mb-4">

            <div class="card-header  border-0">

                <h5>

                    <i class="fas fa-file-alt text-warning me-2"></i>

                    Deskripsi Pelatihan

                </h5>

            </div>

            <div class="card-body">

                {!! nl2br(e($data->description)) !!}

            </div>

        </div>

        <div class="row">

            <div class="col-lg-6 mb-4">

                <div class="card border-0 shadow-sm detail-card">

                    <div class="card-header  border-0">

                        <h5>

                            <i class="fas fa-book text-warning me-2"></i>

                            Materi Pelatihan

                        </h5>

                    </div>

                    <div class="card-body">

                        @foreach(json_decode($data->syllabus,true) ?? [] as $item)

                            <div class="check-item">

                                <i class="fas fa-check-circle"></i>

                                <span>{{ $item }}</span>

                            </div>

                        @endforeach

                    </div>

                </div>

            </div>

            <div class="col-lg-6 mb-4">

                <div class="card border-0 shadow-sm detail-card">

                    <div class="card-header  border-0">

                        <h5>

                            <i class="fas fa-list-check text-warning me-2"></i>

                            Persyaratan Peserta

                        </h5>

                    </div>

                    <div class="card-body">

                        @foreach(json_decode($data->requirements,true) ?? [] as $item)

                            <div class="check-item">

                                <i class="fas fa-check-circle"></i>

                                <span>{{ $item }}</span>

                            </div>

                        @endforeach

                    </div>

                </div>

            </div>

        </div>

        <div class="row">

            <div class="col-lg-6 mb-4">

                <div class="card border-0 shadow-sm detail-card">

                    <div class="card-header  border-0">

                        <h5>

                            <i class="fas fa-certificate text-warning me-2"></i>

                            Sertifikat

                        </h5>

                    </div>

                    <div class="card-body">

                        @if($data->is_certificate)

                            <table class="table table-borderless detail-table">

                                <tr>

                                    <td width="35%">

                                        Nama Sertifikat

                                    </td>

                                    <th>

                                        {{ $data->certificate_name }}

                                    </th>

                                </tr>

                                <tr>

                                    <td>

                                        Masa Berlaku

                                    </td>

                                    <th>

                                        {{ $data->certificate_validity ?: '-' }}

                                    </th>

                                </tr>

                            </table>

                        @else

                            <div class="alert alert-warning mb-0">

                                Pelatihan ini tidak menyediakan sertifikat.

                            </div>

                        @endif

                    </div>

                </div>

            </div>

            <div class="col-lg-6 mb-4">

                <div class="card border-0 shadow-sm detail-card">

                    <div class="card-header  border-0">

                        <h5>

                            <i class="fas fa-tags text-warning me-2"></i>

                            Tag

                        </h5>

                    </div>

                    <div class="card-body">

                        @foreach(json_decode($data->tags,true) ?? [] as $tag)

                            <span class="certificate-badge">

                                #{{ $tag }}

                            </span>

                        @endforeach

                    </div>

                </div>

            </div>

        </div>

    </div>

    @if($data->poster)

        <div
            class="modal fade"
            id="posterModal"
            tabindex="-1"
            aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content border-0 bg-transparent shadow-none">

                    <div class="modal-body text-center p-0">

                        <img
                            src="{{ asset('storage/' . $data->poster) }}"
                            alt="{{ $data->title }}"
                            class="img-fluid rounded-4 shadow"
                            style="max-height:90vh;">

                    </div>

                </div>

            </div>

        </div>

    @endif
@endsection

@section('js')
    
@endsection