@extends('layouts.dashboard-user')

@section('title', 'Profil Perusahaan')

@section('css')
    <style>
        .company-wrapper{

            background:#11192d;

            border:1px solid rgba(255,255,255,.06);

            border-radius:20px;

            overflow:hidden;

        }

        .company-cover{

            height:170px;

            background:linear-gradient(135deg,#f7b003,#1c2848);

        }

        .company-header{

            display:flex;

            gap:25px;

            padding:0 24px 24px;

            margin-top:-55px;

        }

        .company-logo{

            width:110px;

            height:110px;

            object-fit:cover;

            border-radius:18px;

            background:#fff;

            border:4px solid #11192d;

        }

        .company-name{

            color:#fff;

            font-size:22px;

            font-weight:700;

            margin-top:55px;

        }

        .company-industry{

            color:#f7b003;

            font-size:13px;

            margin-top:4px;

        }

        .company-location{

            color:#91a0bc;

            font-size:12px;

            margin-top:6px;

        }

        .company-title{

            padding:14px 24px;

            font-size:14px;

            font-weight:700;

            color:#fff;

            border-bottom:1px solid rgba(255,255,255,.05);

        }

        .company-body{

            padding:24px;

            color:#9ca9c5;

            font-size:13px;

            line-height:1.8;

        }

        .company-item{

            margin-bottom:18px;

        }

        .company-item:last-child{

            margin-bottom:0;

        }

        .table-dark{

            --bs-table-bg:transparent;

        }

        .table-dark td{

            color:#9ca9c5;

            border-color:rgba(255,255,255,.05);

        }

        .company-edit-btn{

            width:100%;

            border-radius:12px;

            font-size:11px;

            font-weight:600;

            padding: 5px 16px;

            transition:.25s;

        }

        .company-edit-btn:hover{

            transform:translateY(-2px);

            box-shadow:0 8px 20px rgba(247,176,3,.25);

        }

        .company-empty{

            display:inline-flex;
            align-items:center;
            gap:6px;

            color:#90a0be;

            font-size:12px;

            font-style:italic;

        }

        .company-empty i{

            color:#f7b003;

        }

        .company-empty-badge{

            display:inline-block;

            margin-left:8px;

            padding:3px 8px;

            border-radius:999px;

            background:rgba(247,176,3,.12);

            border:1px solid rgba(247,176,3,.35);

            color:#f7b003;

            font-size:10px;

            font-weight:600;

        }

        .company-social-disabled{

            opacity:.45;

            pointer-events:none;

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