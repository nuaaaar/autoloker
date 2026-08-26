@extends('layouts.dashboard-admin')

@section('title', 'Detail Satpam')

@section('css')
    <style>
        /* =====================================================
            COMPANY HEADER
        ===================================================== */

        .company-wrapper{
            background:#131c31;
            border-radius:18px;
            overflow:hidden;
            border:1px solid #273452;
        }

        .company-cover{
            height:180px;
            background:linear-gradient(135deg,#f7b003 0%,#d89300 100%);
        }

        .company-header{
            position:relative;
            padding:30px;
            display:flex;
            align-items:flex-end;
            gap:25px;
            margin-top:-75px;
        }

        .company-logo{
            width:150px;
            height:150px;
            border-radius:20px;
            background:#fff;
            object-fit:contain;
            border:6px solid #131c31;
            box-shadow:0 12px 35px rgba(0,0,0,.35);
        }

        .company-name{
            font-size:30px;
            font-weight:700;
            color:#fff;
        }

        .company-industry{
            color:#f7b003;
            margin-top:8px;
            font-size:16px;
        }

        .company-location{
            color:#bfc8d8;
            margin-top:10px;
            font-size:15px;
        }


        /* =====================================================
            SUMMARY CARD
        ===================================================== */

        .summary-card{

            background:linear-gradient(135deg,#f7b003,#ffca43);
            border-radius:18px;
            padding:22px;
            display:flex;
            align-items:center;
            gap:18px;
            min-height:110px;
            box-shadow:0 10px 25px rgba(0,0,0,.18);

        }

        .summary-icon{

            width:65px;
            height:65px;
            border-radius:50%;
            background:rgba(255,255,255,.25);

            display:flex;
            align-items:center;
            justify-content:center;

            color:#3d2b00;

        }

        .summary-title{

            font-size:13px;
            font-weight:600;
            color:#5b4300;

        }

        .summary-value{

            margin-top:5px;
            font-size:20px;
            font-weight:700;
            color:#2c1f00;

        }


        /* =====================================================
            SECTION
        ===================================================== */

        .company-title{

            padding:18px 25px;
            background:#1b2742;
            color:#fff;
            font-weight:700;
            border-bottom:1px solid #2d3d60;

        }

        .company-body{

            padding:28px;

        }

        .company-label{

            display:block;
            margin-bottom:8px;
            font-size:13px;
            color:#8fa0bc;
            text-transform:uppercase;
            letter-spacing:.5px;

        }

        .company-value{

            background:#1c2641;
            border:1px solid #2b3959;
            border-radius:12px;
            padding:14px 16px;
            color:#fff;
            min-height:52px;
            display:flex;
            align-items:center;

        }

        .company-description{

            background:#1c2641;
            border:1px solid #2b3959;
            border-radius:12px;
            padding:20px;
            color:#d8deea;
            line-height:1.8;
            min-height:140px;

        }


        /* =====================================================
            EMPTY STATE
        ===================================================== */

        .empty-state-small{

            display:flex;
            align-items:center;

            padding:18px;

            border-radius:12px;

            background:#172033;

            border:1px dashed #394866;

            color:#8fa0bc;

        }


        /* =====================================================
            RESPONSIVE
        ===================================================== */

        @media(max-width:991px){

            .company-header{

                flex-direction:column;
                align-items:center;
                text-align:center;

            }

            .company-logo{

                width:120px;
                height:120px;

            }

            .company-name{

                font-size:24px;

            }

            .summary-card{

                min-height:auto;

            }

        }

        .company-item{

            padding:15px 18px;

            border-radius:12px;

            background:#18233c;

            border:1px solid #293758;

            color:#fff;

        }

        .company-item strong{

            display:block;

            color:#f7b003;

            margin-bottom:6px;

        }

        .company-empty{

            color:#8b97b3;

            font-style:italic;

        }

        .social-item{

            display:flex;

            align-items:center;

            gap:15px;

            padding:15px;

            border-radius:12px;

            background:#18233c;

            border:1px solid #293758;

            margin-bottom:15px;

        }

        .social-item i{

            font-size:22px;

            color:#f7b003;

            width:25px;

        }

        .social-item a{

            color:#fff;

            text-decoration:none;

        }

        .social-item a:hover{

            color:#f7b003;

        }

        .social-item span{

            color:#8fa0bc;

        }

        .progress{

            background:#263350;
            border-radius:30px;
            overflow:hidden;

        }

        .progress-bar{

            border-radius:30px;

        }

        .company-body .btn{

            min-width:180px;

        }
    </style>
@endsection

@section('breadcrumb')
    <h1
        class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
        Detail BUJP</h1>
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
        <li class="breadcrumb-item text-muted"><a href="{{ route('dashboard-admin.management-user.bujp.index') }}" class="text-muted text-hover-primary">BUJP</a></li>
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

            <!-- ==========================================
            HEADER COMPANY
            =========================================== -->

            <div class="company-wrapper mb-5">

                <div class="company-cover"></div>

                <div class="company-header">

                    <img
                        src="{{ $profile->logo ? Storage::url($profile->logo) : asset('assets/media/avatars/blank.png') }}"
                        class="company-logo">

                    <div class="flex-grow-1">

                        <div class="d-flex justify-content-between align-items-start flex-wrap">

                            <div>

                                <div class="company-name">

                                    {{ $profile->company_name ?: 'Nama BUJP Belum Diisi' }}

                                    @if($profile->is_verified)

                                        <span class="badge bg-success ms-2">

                                            Terverifikasi

                                        </span>

                                    @endif

                                </div>

                                <div class="company-industry">

                                    {{ $profile->industry ?: 'Bidang usaha belum diisi' }}

                                </div>

                                <div class="company-location">

                                    <i class="ki-duotone ki-geolocation me-1"></i>

                                    {{ $profile->city ?: '-' }},
                                    {{ $profile->province ?: '-' }}

                                </div>

                                <div class="mt-4">

                                    @if($profile->is_active)

                                        <span class="badge bg-success me-2">

                                            Akun Aktif

                                        </span>

                                    @else

                                        <span class="badge bg-danger me-2">

                                            Nonaktif

                                        </span>

                                    @endif

                                    @if($profile->sio_expired_date)

                                        @if(\Carbon\Carbon::parse($profile->sio_expired_date)->isFuture())

                                            <span class="badge bg-warning text-dark">

                                                SIO Aktif

                                            </span>

                                        @else

                                            <span class="badge bg-danger">

                                                SIO Kadaluarsa

                                            </span>

                                        @endif

                                    @endif

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- ==========================================
            SUMMARY
            =========================================== -->

            <div class="row g-5 mb-5">

                <div class="col-xl-3 col-md-6">

                    <div class="summary-card">

                        <div class="summary-icon">

                            <i class="ki-duotone ki-shield-tick fs-1"></i>

                        </div>

                        <div>

                            <div class="summary-title">

                                Status Akun

                            </div>

                            <div class="summary-value">

                                {{ $profile->is_active ? 'Aktif' : 'Nonaktif' }}

                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-xl-3 col-md-6">

                    <div class="summary-card">

                        <div class="summary-icon">

                            <i class="ki-duotone ki-abstract-26 fs-1"></i>

                        </div>

                        <div>

                            <div class="summary-title">

                                Status Verifikasi

                            </div>

                            <div class="summary-value">

                                {{ $profile->is_verified ? 'Terverifikasi' : 'Belum Verifikasi' }}

                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-xl-3 col-md-6">

                    <div class="summary-card">

                        <div class="summary-icon">

                            <i class="ki-duotone ki-security-user fs-1"></i>

                        </div>

                        <div>

                            <div class="summary-title">

                                Legalitas

                            </div>

                            <div class="summary-value">

                                {{ ($profile->nib && $profile->npwp && $profile->business_license) ? 'Lengkap' : 'Belum Lengkap' }}

                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-xl-3 col-md-6">

                    <div class="summary-card">

                        <div class="summary-icon">

                            <i class="ki-duotone ki-document fs-1"></i>

                        </div>

                        <div>

                            <div class="summary-title">

                                Dokumen SIO

                            </div>

                            <div class="summary-value">

                                {{ $profile->sio_file ? 'Tersedia' : 'Belum Upload' }}

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- ==========================================
            INFORMASI PERUSAHAAN
            =========================================== -->

            <div class="company-wrapper mb-5">

                <div class="company-title">

                    Informasi Perusahaan

                </div>

                <div class="company-body">

                    <div class="row">

                        <div class="col-md-6 mb-5">

                            <label class="company-label">

                                Nama Perusahaan

                            </label>

                            <div class="company-value">

                                {{ $profile->company_name ?: '-' }}

                            </div>

                        </div>

                        <div class="col-md-6 mb-5">

                            <label class="company-label">

                                Bidang Usaha

                            </label>

                            <div class="company-value">

                                {{ $profile->industry ?: '-' }}

                            </div>

                        </div>

                        <div class="col-md-12">

                            <label class="company-label">

                                Deskripsi Perusahaan

                            </label>

                            <div class="company-description">

                                @if($profile->description)

                                    {!! nl2br(e($profile->description)) !!}

                                @else

                                    <div class="empty-state-small">

                                        <i class="ki-duotone ki-information-2 fs-2 text-warning me-2"></i>

                                        Perusahaan belum menambahkan deskripsi.

                                    </div>

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="row">

        <!-- ==========================================
            LEGALIAS
        =========================================== -->

        <div class="col-xl-6 mb-5">

            <div class="company-wrapper h-100">

                <div class="company-title">

                    Legalitas Perusahaan

                </div>

                <div class="company-body">

                    <div class="company-item">

                        <strong>Nomor Induk Berusaha (NIB)</strong>

                        <br>

                        @if($profile->nib)

                            {{ $profile->nib }}

                        @else

                            <span class="company-empty">

                                Belum mengisi NIB

                            </span>

                        @endif

                    </div>

                    <div class="company-item mt-5">

                        <strong>NPWP</strong>

                        <br>

                        @if($profile->npwp)

                            {{ $profile->npwp }}

                        @else

                            <span class="company-empty">

                                Belum mengisi NPWP

                            </span>

                        @endif

                    </div>

                    <div class="company-item mt-5">

                        <strong>Nomor Izin Usaha / SIUP</strong>

                        <br>

                        @if($profile->business_license)

                            {{ $profile->business_license }}

                        @else

                            <span class="company-empty">

                                Belum mengisi SIUP

                            </span>

                        @endif

                    </div>

                    <div class="company-item mt-5">

                        <strong>Nomor Surat Izin Operasional (SIO)</strong>

                        <br>

                        @if($profile->sio_number)

                            {{ $profile->sio_number }}

                        @else

                            <span class="company-empty">

                                Belum mengisi nomor SIO

                            </span>

                        @endif

                    </div>

                    <div class="company-item mt-5">

                        <strong>Masa Berlaku SIO</strong>

                        <br>

                        @if($profile->sio_expired_date)

                            @php

                                $expired = \Carbon\Carbon::parse($profile->sio_expired_date);

                            @endphp

                            {{ $expired->translatedFormat('d F Y') }}

                            @if($expired->isPast())

                                <span class="badge bg-danger ms-2">

                                    Kadaluarsa

                                </span>

                            @else

                                <span class="badge bg-success ms-2">

                                    Aktif

                                </span>

                            @endif

                        @else

                            <span class="company-empty">

                                Belum diisi

                            </span>

                        @endif

                    </div>

                    <div class="company-item mt-5">

                        <strong>Dokumen SIO</strong>

                        <br>

                        @if($profile->sio_file)

                            <a
                                href="{{ Storage::url($profile->sio_file) }}"
                                target="_blank"
                                class="btn btn-warning btn-sm mt-2">

                                <i class="ki-duotone ki-document fs-5 me-2"></i>

                                Lihat Dokumen

                            </a>

                        @else

                            <span class="company-empty">

                                Dokumen belum diunggah

                            </span>

                        @endif

                    </div>

                </div>

            </div>

        </div>



        <!-- ==========================================
            KONTAK
        =========================================== -->

        <div class="col-xl-6 mb-5">

            <div class="company-wrapper h-100">

                <div class="company-title">

                    Informasi Kontak

                </div>

                <div class="company-body">

                    <div class="company-item">

                        <strong>Email</strong>

                        <br>

                        {{ $profile->email ?: '-' }}

                    </div>

                    <div class="company-item mt-5">

                        <strong>Nomor Telepon</strong>

                        <br>

                        {{ $profile->phone ?: '-' }}

                    </div>

                    <div class="company-item mt-5">

                        <strong>Website</strong>

                        <br>

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

        </div>



        <!-- ==========================================
            ALAMAT
        =========================================== -->

        <div class="col-xl-6 mb-5">

            <div class="company-wrapper h-100">

                <div class="company-title">

                    Alamat Perusahaan

                </div>

                <div class="company-body">

                    <div class="company-item">

                        <strong>Provinsi</strong>

                        <br>

                        {{ $profile->province ?: '-' }}

                    </div>

                    <div class="company-item mt-5">

                        <strong>Kabupaten / Kota</strong>

                        <br>

                        {{ $profile->city ?: '-' }}

                    </div>

                    <div class="company-item mt-5">

                        <strong>Kecamatan</strong>

                        <br>

                        {{ $profile->district ?: '-' }}

                    </div>

                    <div class="company-item mt-5">

                        <strong>Kelurahan</strong>

                        <br>

                        {{ $profile->village ?: '-' }}

                    </div>

                    <div class="company-item mt-5">

                        <strong>Kode Pos</strong>

                        <br>

                        {{ $profile->postal_code ?: '-' }}

                    </div>

                    <div class="company-item mt-5">

                        <strong>Alamat Lengkap</strong>

                        <br>

                        {!! nl2br(e($profile->address ?: '-')) !!}

                    </div>

                </div>

            </div>

        </div>



        <!-- ==========================================
            MEDIA SOSIAL
        =========================================== -->

        <div class="col-xl-6 mb-5">

            <div class="company-wrapper h-100">

                <div class="company-title">

                    Media Sosial

                </div>

                <div class="company-body">

                    <div class="social-item">

                        <i class="bi bi-instagram"></i>

                        @if($profile->instagram)

                            <a href="{{ $profile->instagram }}" target="_blank">

                                Instagram

                            </a>

                        @else

                            <span>Belum ditambahkan</span>

                        @endif

                    </div>

                    <div class="social-item">

                        <i class="bi bi-facebook"></i>

                        @if($profile->facebook)

                            <a href="{{ $profile->facebook }}" target="_blank">

                                Facebook

                            </a>

                        @else

                            <span>Belum ditambahkan</span>

                        @endif

                    </div>

                    <div class="social-item">

                        <i class="bi bi-linkedin"></i>

                        @if($profile->linkedin)

                            <a href="{{ $profile->linkedin }}" target="_blank">

                                LinkedIn

                            </a>

                        @else

                            <span>Belum ditambahkan</span>

                        @endif

                    </div>

                    <div class="social-item">

                        <i class="bi bi-youtube"></i>

                        @if($profile->youtube)

                            <a href="{{ $profile->youtube }}" target="_blank">

                                Youtube

                            </a>

                        @else

                            <span>Belum ditambahkan</span>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="row">

        <!-- =======================================================
            STATUS AKUN
        ======================================================== -->

        <div class="col-xl-6 mb-5">

            <div class="company-wrapper h-100">

                <div class="company-title">

                    Status Akun

                </div>

                <div class="company-body">

                    <div class="company-item">

                        <strong>Status Akun</strong>

                        <br>

                        @if($profile->is_active)

                            <span class="badge bg-success">

                                Aktif

                            </span>

                        @else

                            <span class="badge bg-danger">

                                Nonaktif

                            </span>

                        @endif

                    </div>

                    <div class="company-item mt-5">

                        <strong>Status Verifikasi</strong>

                        <br>

                        @if($profile->is_verified)

                            <span class="badge bg-success">

                                Sudah Diverifikasi

                            </span>

                        @else

                            <span class="badge bg-warning text-dark">

                                Belum Diverifikasi

                            </span>

                        @endif

                    </div>

                    <div class="company-item mt-5">

                        <strong>Kelengkapan Profil</strong>

                        <br>

                        @php

                            $fields = [

                                $profile->company_name,
                                $profile->industry,
                                $profile->logo,
                                $profile->description,
                                $profile->npwp,
                                $profile->nib,
                                $profile->business_license,
                                $profile->sio_number,
                                $profile->sio_file,
                                $profile->email,
                                $profile->phone,
                                $profile->province,
                                $profile->city,
                                $profile->district,
                                $profile->village,
                                $profile->postal_code,
                                $profile->address,

                            ];

                            $filled = collect($fields)->filter()->count();

                            $percent = round(($filled / count($fields))*100);

                        @endphp

                        <div class="progress mt-2 mb-2" style="height:8px;">

                            <div
                                class="progress-bar bg-warning"
                                style="width:{{ $percent }}%">

                            </div>

                        </div>

                        <strong>

                            {{ $percent }}%

                        </strong>

                    </div>

                </div>

            </div>

        </div>


        <!-- =======================================================
            DOKUMEN
        ======================================================== -->

        <div class="col-xl-6 mb-5">

            <div class="company-wrapper h-100">

                <div class="company-title">

                    Dokumen Perusahaan

                </div>

                <div class="company-body">

                    <div class="company-item">

                        <strong>Logo Perusahaan</strong>

                        <br><br>

                        @if($profile->logo)

                            <img
                                src="{{ Storage::url($profile->logo) }}"
                                style="width:90px;height:90px;border-radius:12px;background:#fff;padding:8px;object-fit:contain;">

                        @else

                            <span class="company-empty">

                                Belum Upload Logo

                            </span>

                        @endif

                    </div>


                    <div class="company-item mt-5">

                        <strong>Dokumen SIO</strong>

                        <br><br>

                        @if($profile->sio_file)

                            <a
                                href="{{ Storage::url($profile->sio_file) }}"
                                target="_blank"
                                class="btn btn-warning">

                                <i class="ki-duotone ki-document me-2"></i>

                                Lihat Dokumen

                            </a>

                        @else

                            <span class="company-empty">

                                Dokumen belum tersedia

                            </span>

                        @endif

                    </div>

                </div>

            </div>

        </div>
@endsection

@section('js')
    
@endsection