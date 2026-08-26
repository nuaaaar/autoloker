@extends('layouts.dashboard-admin')

@section('title', 'Detail Satpam')

@section('css')
    <style>
        .security-cover{

            height:190px;

            background:linear-gradient(135deg,#1d2b64,#0b1120,#f7b000);

            border-radius:.75rem .75rem 0 0;

        }

        .security-photo-wrapper{

            margin-top:-70px;

            position:relative;

        }

        .security-photo{

            width:160px;

            height:160px;

            object-fit:cover;

            border-radius:18px;

            border:6px solid #fff;

            box-shadow:0 10px 25px rgba(0,0,0,.15);

        }

        .security-online{

            width:20px;

            height:20px;

            border-radius:50%;

            background:#50cd89;

            border:3px solid #fff;

            position:absolute;

            bottom:18px;

            right:60px;

        }

        .summary-card{
            position: relative;
            overflow: hidden;
            border-radius: 18px;
            padding: 24px;
            background: linear-gradient(135deg,#f7b003 0%,#ffca3a 100%);
            color: #1a1a1a;
            box-shadow: 0 10px 30px rgba(247,176,3,.25);
        }

        .summary-card::after{
            content:'';
            position:absolute;
            right:-30px;
            top:-30px;
            width:120px;
            height:120px;
            border-radius:50%;
            background:rgba(255,255,255,.18);
        }

        .summary-title{
            font-size:13px;
            font-weight:600;
            opacity:.8;
            text-transform:uppercase;
            letter-spacing:1px;
        }

        .summary-value{
            font-size:32px;
            font-weight:800;
            line-height:1;
            margin-top:8px;
        }

        .summary-icon{
            width:60px;
            height:60px;
            border-radius:16px;
            background:rgba(255,255,255,.25);
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:28px;
        }

        .summary-footer{
            margin-top:18px;
            font-size:13px;
            font-weight:600;
            opacity:.85;
        }

        /* ===========================
        DETAIL PROFILE
        =========================== */

        .detail-list{
            display:flex;
            flex-direction:column;
        }

        .detail-item{
            display:flex;
            justify-content:space-between;
            align-items:flex-start;
            gap:25px;
            padding:18px 24px;
            border-bottom:1px solid rgba(255,255,255,.06);
        }

        .detail-item:last-child{
            border-bottom:none;
        }

        .detail-label{
            width:240px;
            flex-shrink:0;
            color:#8ea0be;
            font-size:13px;
            font-weight:600;
        }

        .detail-value{
            flex:1;
            text-align:right;
            color:#fff;
            font-size:14px;
            font-weight:500;
            word-break:break-word;
        }

        .detail-value.empty{
            color:#6f7d97;
            font-style:italic;
        }

        .detail-value .badge{
            font-size:11px;
            padding:7px 12px;
            border-radius:20px;
        }

        .detail-value .badge-success{
            background:#198754;
        }

        .detail-value .badge-danger{
            background:#dc3545;
        }

        .detail-value .badge-warning{
            background:#f6b000;
            color:#111;
        }

        .detail-value .badge-info{
            background:#0dcaf0;
            color:#111;
        }

        /* hover */

        .detail-item:hover{
            background:rgba(255,255,255,.025);
        }

        /* responsive */

        @media(max-width:768px){

            .detail-item{
                flex-direction:column;
                gap:8px;
                padding:15px 18px;
            }

            .detail-label{
                width:100%;
            }

            .detail-value{
                width:100%;
                text-align:left;
            }

        }

        .certificate-admin-card,
        .history-admin-card{

            display:flex;
            gap:20px;

            padding:22px;

            border:1px solid rgba(255,255,255,.06);

            border-radius:16px;

            background:#172238;

            margin-bottom:20px;

            transition:.3s;

        }

        .certificate-admin-card:hover,
        .history-admin-card:hover{

            border-color:#f6b000;

            transform:translateY(-2px);

        }

        .certificate-admin-icon,
        .history-admin-icon{

            width:70px;
            height:70px;

            border-radius:16px;

            background:#222f4d;

            display:flex;

            justify-content:center;

            align-items:center;

            flex-shrink:0;

        }

        .certificate-admin-content,
        .history-admin-content{

            flex:1;

        }

        .empty-state{

            text-align:center;

            padding:60px 20px;

        }

        .empty-state h5{

            margin-bottom:10px;

        }

        .empty-state p{

            max-width:450px;

            margin:auto;

        }

        @media(max-width:768px){

            .certificate-admin-card,
            .history-admin-card{

                flex-direction:column;

            }

            .certificate-admin-icon,
            .history-admin-icon{

                width:60px;
                height:60px;

            }

        }
    </style>
@endsection

@section('breadcrumb')
    <h1
        class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
        Detail Satpam</h1>
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
        <li class="breadcrumb-item text-muted"><a href="{{ route('dashboard-admin.management-user.security.index') }}" class="text-muted text-hover-primary">Satpam</a></li>
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
    <div class="row">

        <div class="col-xl-12">

            <div class="card border-0 shadow-sm mb-8">

                <!-- Cover -->

                <div class="security-cover"></div>

                <div class="card-body pt-0">

                    <div class="row">

                        <!-- FOTO -->

                        <div class="col-xl-3 text-center">

                            <div class="security-photo-wrapper">

                                <img
                                    src="{{ $security->formal_photo ? Storage::url($security->formal_photo) : asset('assets/media/avatars/blank.png') }}"
                                    class="security-photo">

                                @if($security->email)

                                    <span class="security-online"></span>

                                @endif

                            </div>

                        </div>

                        <!-- PROFILE -->

                        <div class="col-xl-6">

                            <div class="pt-12">

                                <h2 class="fw-bold text-dark mb-2">

                                    {{ $security->name ?: 'Nama Belum Diisi' }}

                                </h2>

                                <div class="fs-5 text-muted mb-3">

                                    {{ $security->position ?: 'Belum memiliki jabatan' }}

                                    @if($security->company_name)

                                        • {{ $security->company_name }}

                                    @endif

                                </div>

                                <div class="d-flex flex-wrap gap-5">

                                    <div>

                                        <i class="ki-duotone ki-geolocation fs-4 text-primary me-2"></i>

                                        {{ $security->province ?: 'Provinsi belum diisi' }}, {{ $security->city ?: 'Kota belum diisi' }}

                                    </div>

                                    <div>

                                        <i class="ki-duotone ki-calendar fs-4 text-success me-2"></i>

                                        @if($security->birth_date)

                                            {{ date('d F Y',strtotime($security->birth_date)) }}

                                        @else

                                            Tanggal lahir belum diisi

                                        @endif

                                    </div>

                                </div>

                                <div class="mt-6">

                                    @if($security->work_status)

                                        <span class="badge badge-light-success fs-7">

                                            {{ ucfirst($security->work_status) }}

                                        </span>

                                    @else

                                        <span class="badge badge-light-secondary">

                                            Status Kerja Belum Diisi

                                        </span>

                                    @endif

                                </div>

                            </div>

                        </div>

                        <!-- ACTION -->

                        <div class="col-xl-3">

                            <div class="pt-12 text-end">

                                <a href="mailto:{{ $security->email }}"
                                    class="btn btn-warning w-100 mb-3">

                                    <i class="ki-duotone ki-sms fs-4 me-2"></i>

                                    Hubungi

                                </a>

                                <a href="tel:{{ $security->phone_number }}"
                                    class="btn btn-light-primary w-100">

                                    <i class="ki-duotone ki-phone fs-4 me-2"></i>

                                    Telepon

                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="row g-5 mb-8">

        <!-- Progress Profile -->
        <div class="col-xl-3 col-md-6">

            <div class="card h-100 border-0 shadow-sm"
                style="background:linear-gradient(135deg,#ffca2c,#f6b000);border-radius:18px;">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="text-dark opacity-75 fw-semibold">
                                Progress Profil
                            </div>

                            <h2 class="fw-bold text-dark mt-2 mb-0">
                                {{ $profileProgress['progress'] }}%
                            </h2>

                        </div>

                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                            style="width:60px;height:60px;background:rgba(255,255,255,.35);">

                            <i class="ki-duotone ki-profile-circle fs-1 text-dark"></i>

                        </div>

                    </div>

                    <div class="progress mt-5"
                        style="height:8px;background:rgba(255,255,255,.35);">

                        <div class="progress-bar bg-dark"
                            style="width:{{ $profileProgress['progress'] }}%"></div>

                    </div>

                </div>

            </div>

        </div>

        <!-- Sertifikat -->
        <div class="col-xl-3 col-md-6">

            <div class="card h-100 border-0 shadow-sm"
                style="background:#18233d;border-radius:18px;">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <div class="text-gray-500">
                                Sertifikat
                            </div>

                            <h2 class="text-warning fw-bold mt-2 mb-0">
                                {{ $security->certificates->count() }}
                            </h2>

                        </div>

                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                            style="width:60px;height:60px;background:#263555;">

                            <i class="ki-duotone ki-award fs-1 text-warning"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- Riwayat -->
        <div class="col-xl-3 col-md-6">

            <div class="card h-100 border-0 shadow-sm"
                style="background:#18233d;border-radius:18px;">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <div class="text-gray-500">
                                Riwayat Penugasan
                            </div>

                            <h2 class="text-warning fw-bold mt-2 mb-0">
                                {{ $security->histories->count() }}
                            </h2>

                        </div>

                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                            style="width:60px;height:60px;background:#263555;">

                            <i class="ki-duotone ki-briefcase fs-1 text-warning"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- Pengalaman -->
        <div class="col-xl-3 col-md-6">

            <div class="card h-100 border-0 shadow-sm"
                style="background:#18233d;border-radius:18px;">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <div class="text-gray-500">
                                Pengalaman
                            </div>

                            <h2 class="text-warning fw-bold mt-2 mb-0">
                                {{ $security->work_experience ?: '-' }}
                            </h2>

                        </div>

                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                            style="width:60px;height:60px;background:#263555;">

                            <i class="ki-duotone ki-time fs-1 text-warning"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- =========================================
    INFORMASI PRIBADI
    ========================================= -->
    <div class="company-wrapper mb-5">

        <div class="company-title">
            Informasi Pribadi
        </div>

        <div class="detail-list">

            <div class="detail-item">
                <div class="detail-label">Nama Lengkap</div>
                <div class="detail-value {{ empty($security->name) ? 'empty' : '' }}">
                    {{ $security->name ?: 'Belum diisi' }}
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Tempat Lahir</div>
                <div class="detail-value {{ empty($security->birth_place) ? 'empty' : '' }}">
                    {{ $security->birth_place ?: 'Belum diisi' }}
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Tanggal Lahir</div>
                <div class="detail-value {{ empty($security->birth_date) ? 'empty' : '' }}">
                    {{ $security->birth_date ? date('d F Y',strtotime($security->birth_date)) : 'Belum diisi' }}
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Jenis Kelamin</div>
                <div class="detail-value">

                    @if($security->gender)

                        <span class="badge bg-info">

                            {{ ucfirst($security->gender) }}

                        </span>

                    @else

                        <span class="detail-value empty">
                            Belum diisi
                        </span>

                    @endif

                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Nomor Registrasi</div>
                <div class="detail-value {{ empty($security->registration_number) ? 'empty' : '' }}">
                    {{ $security->registration_number ?: 'Belum diisi' }}
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Nomor KTP</div>
                <div class="detail-value {{ empty($security->ktp_number) ? 'empty' : '' }}">
                    {{ $security->ktp_number ?: 'Belum diisi' }}
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Email</div>
                <div class="detail-value {{ empty($security->email) ? 'empty' : '' }}">
                    {{ $security->email ?: 'Belum diisi' }}
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Nomor Telepon</div>
                <div class="detail-value {{ empty($security->phone_number) ? 'empty' : '' }}">
                    {{ $security->phone_number ?: 'Belum diisi' }}
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Alamat</div>
                <div class="detail-value {{ empty($security->address) ? 'empty' : '' }}">
                    {{ $security->address ?: 'Belum diisi' }}
                </div>
            </div>

        </div>

    </div>



    <!-- =========================================
    DATA PROFESIONAL
    ========================================= -->
    <div class="company-wrapper mb-5">

        <div class="company-title">
            Data Profesional
        </div>

        <div class="detail-list">

            <div class="detail-item">
                <div class="detail-label">Pengalaman Kerja</div>
                <div class="detail-value {{ empty($security->work_experience) ? 'empty' : '' }}">
                    {{ $security->work_experience ?: 'Belum diisi' }}
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Status Pekerjaan</div>
                <div class="detail-value {{ empty($security->work_status) ? 'empty' : '' }}">
                    {{ $security->work_status ?: 'Belum diisi' }}
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Perusahaan Terakhir</div>
                <div class="detail-value {{ empty($security->company_name) ? 'empty' : '' }}">
                    {{ $security->company_name ?: 'Belum diisi' }}
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Posisi</div>
                <div class="detail-value {{ empty($security->position) ? 'empty' : '' }}">
                    {{ $security->position ?: 'Belum diisi' }}
                </div>
            </div>

        </div>

    </div>



    <!-- =========================================
    INFORMASI FISIK
    ========================================= -->
    <div class="company-wrapper mb-5">

        <div class="company-title">
            Informasi Fisik
        </div>

        <div class="detail-list">

            <div class="detail-item">
                <div class="detail-label">Tinggi Badan</div>
                <div class="detail-value {{ empty($security->height) ? 'empty' : '' }}">
                    {{ $security->height ? $security->height.' cm' : 'Belum diisi' }}
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Berat Badan</div>
                <div class="detail-value {{ empty($security->width) ? 'empty' : '' }}">
                    {{ $security->width ? $security->width.' kg' : 'Belum diisi' }}
                </div>
            </div>

        </div>

    </div>



    <!-- =========================================
    PENEMPATAN
    ========================================= -->
    <div class="company-wrapper mb-5">

        <div class="company-title">
            Preferensi Penempatan
        </div>

        <div class="detail-list">

            <div class="detail-item">

                <div class="detail-label">
                    Bersedia Ditempatkan di Luar Kota
                </div>

                <div class="detail-value">

                    @if($security->is_out_of_town_agree)

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

            <div class="detail-item">

                <div class="detail-label">
                    Bersedia Kerja Shift
                </div>

                <div class="detail-value">

                    @if($security->is_shift_agree)

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

            <div class="detail-item">

                <div class="detail-label">
                    SIM
                </div>

                <div class="detail-value">

                    @if($security->sim)

                        @foreach(explode(',',$security->sim) as $sim)

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

            <div class="detail-item">

                <div class="detail-label">
                    Lokasi Penempatan
                </div>

                <div class="detail-value">

                    @if($security->placements)

                        @foreach(explode(',',$security->placements) as $placement)

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



    <!-- =========================================
    KEAHLIAN
    ========================================= -->
    <div class="company-wrapper mb-5">

        <div class="company-title">

            Keahlian

        </div>

        <div class="company-body">

            @if($security->ability)

                @foreach(explode(',',$security->ability) as $ability)

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



    <!-- =========================================
    DESKRIPSI
    ========================================= -->
    <div class="company-wrapper mb-5">

        <div class="company-title">

            Tentang Security

        </div>

        <div class="company-body">

            @if($security->self_description)

                {{ $security->self_description }}

            @else

                <div class="company-empty">

                    Belum menambahkan deskripsi diri.

                </div>

            @endif

        </div>

    </div>



    <!-- =========================================
    CATATAN
    ========================================= -->
    <div class="company-wrapper">

        <div class="company-title">

            Catatan Tambahan

        </div>

        <div class="company-body">

            @if($security->additional_note)

                {{ $security->additional_note }}

            @else

                <div class="company-empty">

                    Tidak ada catatan tambahan.

                </div>

            @endif

        </div>

    </div>

    <!-- =======================================================
    RIWAYAT SERTIFIKASI
    ======================================================= -->

    <div class="company-wrapper mb-5 mt-5">

        <div class="company-title d-flex justify-content-between align-items-center mb-3">

            <span>
                Riwayat Sertifikasi
            </span>

            <span class="badge bg-warning text-dark">

                {{ $security->certificates->count() }} Sertifikat

            </span>

        </div>

        <div class="company-body">

            @forelse($security->certificates as $certificate)

                @php

                    $expired = \Carbon\Carbon::parse($certificate->expired_date)->isPast();

                @endphp

                <div class="certificate-admin-card">

                    <div class="certificate-admin-icon">

                        <i class="ki-duotone ki-shield-tick fs-2 text-warning">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>

                    </div>

                    <div class="certificate-admin-content">

                        <div class="d-flex justify-content-between align-items-center mb-2">

                            <h5 class="mb-0 text-white">

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
                            <strong class="text-white">

                                {{ $certificate->certificate_number }}

                            </strong>

                        </div>

                        <div class="text-muted small mb-3">

                            Berlaku

                            {{ date('d M Y',strtotime($certificate->publish_date)) }}

                            -

                            {{ date('d M Y',strtotime($certificate->expired_date)) }}

                        </div>

                        <div>

                            <span class="badge bg-primary">

                                {{ $certificate->category }}

                            </span>

                            @if($certificate->file)

                                <a
                                    href="{{ Storage::url($certificate->file) }}"
                                    target="_blank"
                                    class="btn btn-sm btn-light-warning ms-2">

                                    <i class="ki-duotone ki-file-sheet me-1"></i>

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

                    <h5 class="text-white">

                        Belum Memiliki Sertifikasi

                    </h5>

                    <p class="text-muted mb-0">

                        Security ini belum menambahkan sertifikat pelatihan maupun lisensi keamanan.

                    </p>

                </div>

            @endforelse

        </div>

    </div>



    <!-- =======================================================
    RIWAYAT PENUGASAN
    ======================================================= -->

    <div class="company-wrapper">

        <div class="company-title d-flex justify-content-between align-items-center mb-3">

            <span>

                Riwayat Penugasan

            </span>

            <span class="badge bg-warning text-dark">

                {{ $security->histories->count() }} Riwayat

            </span>

        </div>

        <div class="company-body">

            @forelse($security->histories as $history)

                <div class="history-admin-card">

                    <div class="history-admin-icon">

                        <i class="ki-duotone ki-briefcase fs-2 text-warning">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>

                    </div>

                    <div class="history-admin-content">

                        <div class="d-flex justify-content-between">

                            <h5 class="text-white mb-1">

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

                        <div class="small text-muted mt-2">

                            <i class="ki-duotone ki-geolocation me-1"></i>

                            {{ $history->location }}

                        </div>

                        <div class="small text-muted">

                            {{ date('d M Y',strtotime($history->start_date)) }}

                            -

                            {{ $history->is_current ? 'Sekarang' : date('d M Y',strtotime($history->end_date)) }}

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

                    <h5 class="text-white">

                        Belum Ada Riwayat Penugasan

                    </h5>

                    <p class="text-muted mb-0">

                        Security ini belum mengisi pengalaman kerja atau riwayat penugasan.

                    </p>

                </div>

            @endforelse

        </div>

    </div>
@endsection

@section('js')
    
@endsection