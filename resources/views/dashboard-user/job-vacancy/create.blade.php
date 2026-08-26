@extends('layouts.dashboard-user')

@section('title', 'Tambah')

@section('css')
    <style>
        /* ==============================
        STEP WRAPPER
        ================================= */

        .vacancy-step-wrapper{

            display:flex;
            align-items:center;
            gap:12px;

            padding:20px 24px;

            border-top:1px solid rgba(255,255,255,.05);
            border-bottom:1px solid rgba(255,255,255,.05);

            overflow-x:auto;
            overflow-y:hidden;

            white-space:nowrap;

            scrollbar-width:none;

        }

        .vacancy-step-wrapper::-webkit-scrollbar{

            display:none;

        }


        /* ==============================
        STEP BUTTON
        ================================= */

        .vacancy-step{

            display:flex;
            align-items:center;
            justify-content:center;
            gap:10px;

            min-width:max-content;

            height:52px;

            padding:0 22px;

            border-radius:14px;

            cursor:pointer;

            transition:.25s;

            color:#94A3B8;

            border:1px solid transparent;

            font-size:15px;

            font-weight:600;

        }

        .vacancy-step i{

            font-size:18px;

            color:inherit;

        }

        .vacancy-step:hover{

            background:#182338;

            color:#fff;

        }


        /* ==============================
        ACTIVE
        ================================= */

        .vacancy-step.active{

            background:rgba(232,168,1,.12);

            border:1px solid rgba(232,168,1,.45);

            color:#E8A801;

        }

        .vacancy-step.active i{

            color:#E8A801;

        }


        /* ==============================
        BODY
        ================================= */

        .vacancy-section{

            animation:fadeSection .25s ease;

        }

        @keyframes fadeSection{

            from{

                opacity:0;
                transform:translateY(8px);

            }

            to{

                opacity:1;
                transform:translateY(0);

            }

        }


        /* ==============================
        FOOTER
        ================================= */

        .card-footer{

            border-top:1px solid rgba(255,255,255,.05);

            background:#121C33;

        }


        /* ==============================
        BUTTON
        ================================= */

        #btnBack,
        #btnDraft,
        #btnNext,
        #btnSubmit{

            min-width:170px;

            height:48px;

            border-radius:12px;

            font-weight:600;

        }

        #btnDraft{

            background:#1B2438;

            color:#fff;

            border:1px solid rgba(255,255,255,.08);

        }

        #btnDraft:hover{

            background:#24314C;

        }

        #btnNext,
        #btnSubmit{

            background:#E8A801;

            border:none;

            color:#121212;

        }

        #btnNext:hover,
        #btnSubmit:hover{

            background:#F2B600;

        }

        @media(max-width:768px){

            .vacancy-step{

                padding:0 16px;

                height:46px;

                font-size:14px;

            }

            .vacancy-step i{

                font-size:16px;

            }

            #btnBack,
            #btnDraft,
            #btnNext,
            #btnSubmit{

                min-width:auto;

                flex:1;

            }

            .card-footer{

                display:flex;

                gap:10px;

                flex-wrap:wrap;

            }

        }

        .job-builder{

            background:#11192c;

            border:1px solid rgba(255,255,255,.06);

            border-radius:16px;

            padding:24px;

        }

        .builder-header{

            display:flex;

            justify-content:space-between;

            align-items:center;

            margin-bottom:20px;

        }

        .builder-title{

            color:#fff;

            font-size:18px;

            font-weight:700;

            margin-bottom:4px;

        }

        .builder-subtitle{

            color:#8c98b3;

            font-size:13px;

        }

        .builder-input{

            margin-bottom:20px;

        }

        .builder-input .input-group{

            background:#0b1020;

            border-radius:12px;

            overflow:hidden;

            border:1px solid rgba(255,255,255,.07);

        }

        .builder-input .input-group-text{

            background:#0b1020;

            border:none;

            color:#8fa7c6;

        }

        .builder-input input{

            background:#0b1020;

            border:none;

            color:#fff;

            height:54px;

        }

        .builder-input input:focus{

            background:#0b1020;

            color:#fff;

            box-shadow:none;

        }

        .builder-input .btn{

            border-radius:0;

            padding:0 24px;

            font-weight:600;

        }

        .builder-list{

            display:flex;

            flex-direction:column;

            gap:14px;

        }

        .builder-item{

            display:flex;

            align-items:center;

            justify-content:space-between;

            background:#0b1020;

            border:1px solid rgba(255,255,255,.05);

            border-radius:14px;

            padding:16px 18px;

            transition:.25s;

        }

        .builder-item:hover{

            border-color:#c7932b;

        }

        .builder-left{

            display:flex;

            align-items:center;

            gap:15px;

        }

        .builder-number{

            width:34px;

            height:34px;

            border-radius:50%;

            background:rgba(199,147,43,.15);

            border:1px solid rgba(199,147,43,.4);

            color:#f5b942;

            display:flex;

            align-items:center;

            justify-content:center;

            font-weight:700;

            flex-shrink:0;

        }

        .builder-text{

            color:#fff;

            font-size:15px;

            line-height:1.5;

        }

        .builder-action{

            display:flex;

            gap:8px;

        }

        .builder-action button{

            width:38px;

            height:38px;

            border:none;

            border-radius:10px;

            background:#18243d;

            color:#8fa7c6;

            transition:.25s;

        }

        .builder-action button:hover{

            background:#c7932b;

            color:#fff;

        }

        .builder-empty{

            text-align:center;

            padding:50px 20px;

            border:2px dashed rgba(255,255,255,.08);

            border-radius:14px;

            color:#73819d;

        }

        .builder-empty h6{

            color:#fff;

            margin-top:10px;

        }

        @media(max-width:768px){

            .builder-item{

                flex-direction:column;

                align-items:flex-start;

                gap:15px;

            }

            .builder-action{

                width:100%;

                justify-content:flex-end;

            }

        }

        .section-card{

            padding:30px;

        }

        .section-title{

            color:#fff;

            font-size:24px;

            font-weight:700;

        }

        .section-subtitle{

            color:#95a2bd;

            margin-top:5px;

            margin-bottom:35px;

        }

        .option-group{

            display:flex;

            gap:15px;

            flex-wrap:wrap;

        }

        .option-card{

            min-width:140px;

            height:52px;

            border-radius:14px;

            border:1px solid rgba(255,255,255,.08);

            background:#0b1020;

            color:#93a3be;

            display:flex;

            justify-content:center;

            align-items:center;

            cursor:pointer;

            transition:.25s;

            font-size:15px;

            font-weight:600;

        }

        .option-card input{

            display:none;

        }

        .option-card:hover{

            border-color:#d39c32;

            color:#fff;

        }

        .option-card.active{

            background:rgba(211,156,50,.15);

            color:#ffc24c;

            border-color:#d39c32;

        }

        .certificate-group,
        .competency-scheme-group {

            display: flex;

            flex-wrap: wrap;

            gap: 10px;

        }

        .certificate-item,
        .competency-scheme-item {

            padding: 14px 22px;

            border: 1px solid rgba(255,255,255,.10);

            border-radius: 14px;

            background: #0d1426;

            color: #97a5bf;

            cursor: pointer;

            transition: .25s;

            font-weight: 600;

            display: flex;

            align-items: center;

            gap: 10px;

            user-select: none;

        }


        .certificate-item i,
        .competency-scheme-item i {

            font-size: 15px;

        }


        .certificate-item:hover,
        .competency-scheme-item:hover {

            border-color: #d6a13b;

            color: #fff;

        }


        .certificate-item.active,
        .competency-scheme-item.active {

            background: rgba(214,161,59,.12);

            border-color: #d6a13b;

            color: #ffc84d;

            box-shadow: 0 0 15px rgba(214,161,59,.20);

        }

        .invalid-feedback{

            display:block;

            margin-top:6px;

            font-size:13px;

        }

        .is-invalid{

            border-color:#dc3545 !important;

        }

        
    </style>
@endsection

@section('breadcrumb')
    <h1
        class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
        Lowongan Saya</h1>
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
            <a href="{{ route('dashboard-user.job-vacancy.index') }}" class="text-muted text-hover-primary">Lowongan Saya</a>
        </li>
        <!--end::Item-->
        <!--end::Item-->
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-500 w-5px h-2px"></span>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <a href="javascript:;" class="text-muted text-hover-primary ms-2">Tambah</a>
        <!--end::Item-->
    </ul>
    <!--end::Breadcrumb-->
@endsection

@section('content')
<div class="card shadow-sm border-0">

    <!-- Card Header -->

    <div class="card-header border-0 py-6">

        <div>

            <h2 class="fw-bold mb-1">
                Tambah Lowongan Baru
            </h2>

            <div class="text-muted">
                Isi semua bagian lalu submit.
            </div>

        </div>

    </div>

    <!-- Card Body -->

    <div class="card-body p-0">

        <!-- Step Navigation -->

        <div class="vacancy-step-wrapper">

            <div class="vacancy-step active" data-step="0">

                <i class="ki-duotone ki-document fs-4"></i>

                <span>Info Dasar</span>

            </div>

            <div class="vacancy-step" data-step="1">

                <i class="ki-duotone ki-geolocation fs-4"></i>

                <span>Lokasi</span>

            </div>

            <div class="vacancy-step" data-step="2">

                <i class="ki-duotone ki-time fs-4"></i>

                <span>Sistem Kerja</span>

            </div>

            <div class="vacancy-step" data-step="3">

                <i class="ki-duotone ki-dollar fs-4"></i>

                <span>Gaji</span>

            </div>

            <div class="vacancy-step" data-step="4">

                <i class="ki-duotone ki-files fs-4"></i>

                <span>Persyaratan</span>

            </div>

            <div class="vacancy-step" data-step="5">

                <i class="ki-duotone ki-shield-tick fs-4"></i>

                <span>Sertifikasi</span>

            </div>

        </div>

        <!-- FORM -->

        <form id="formCreateJobVacancy">

            @csrf

            <div class="p-10">

                <!-- ========================= -->

                <section id="step0" class="vacancy-section">

                    <div class="row">

                        <!-- Posisi -->
                        <div class="col-md-12 mb-7">

                            <label class="form-label required">
                                Posisi Pekerjaan
                            </label>

                            <select
                                name="position"
                                id="position"
                                class="form-select form-control-dark">

                                <option value="">
                                    Pilih Posisi Pekerjaan
                                </option>

                                @foreach($positions as $position)

                                    <option
                                        value="{{ $position->title }}"
                                        data-uuid="{{ $position->uuid }}">

                                        {{ $position->title }}

                                    </option>

                                @endforeach

                            </select>

                            <small class="text-muted">
                                Pilih posisi pekerjaan yang tersedia.
                            </small>

                        </div>

                        <div class="col-md-12 mb-7">

                            <label class="form-label fw-semibold">
                                Status Lowongan
                            </label>

                            <div class="form-check form-switch">

                                <input
                                    type="checkbox"
                                    class="form-check-input"
                                    name="is_urgent"
                                    id="is_urgent"
                                    value="1"
                                >

                                <label class="form-check-label" for="is_urgent">
                                    Tandai sebagai Lowongan Urgent
                                </label>

                            </div>

                            <div class="form-text">
                                Lowongan urgent akan ditampilkan dengan tanda khusus agar lebih mudah diperhatikan pencari kerja.
                            </div>

                        </div>


                        <!-- Deskripsi -->

                        <div class="col-md-12 mb-7">

                            <label class="form-label required">
                                Deskripsi Pekerjaan
                            </label>

                            <textarea
                                name="description_work"
                                id="description_work"
                                rows="6"
                                class="form-control form-control-dark"
                                placeholder="Jelaskan gambaran umum pekerjaan, lingkungan kerja, target pekerjaan, dan informasi penting lainnya."></textarea>

                            <small class="text-muted">
                                Minimal 50 karakter.
                            </small>

                        </div>


                        <!-- Tanggung Jawab -->

                        <div class="col-md-12 mb-7">

                            <div class="job-builder">

                                <!-- Header -->
                                <div class="builder-header">

                                    <div>

                                        <h5 class="builder-title">
                                            Tanggung Jawab
                                            <span class="text-danger">*</span>
                                        </h5>

                                        <div class="builder-subtitle">
                                            Tambahkan satu per satu tanggung jawab pekerjaan.
                                        </div>

                                    </div>

                                </div>

                                <!-- Input -->
                                <div class="builder-input">

                                    <div class="input-group">

                                        <span class="input-group-text">
                                            <i class="ki-duotone ki-notepad-edit fs-3"></i>
                                        </span>

                                        <input
                                            type="text"
                                            id="responsibilityInput"
                                            class="form-control"
                                            placeholder="Contoh : Melaksanakan patroli rutin">

                                        <button
                                            type="button"
                                            id="btnAddResponsibility"
                                            class="btn btn-warning">

                                            <i class="ki-duotone ki-plus fs-3"></i>

                                            Tambah

                                        </button>

                                    </div>

                                </div>

                                <!-- List -->

                                <div
                                    class="builder-list"
                                    id="responsibilityList">

                                    <div class="builder-empty">

                                        <i class="ki-duotone ki-note-2 fs-2x mb-3"></i>

                                        <h6>

                                            Belum ada tanggung jawab

                                        </h6>

                                        <small>

                                            Tambahkan tanggung jawab pertama.

                                        </small>

                                    </div>

                                </div>

                                <!-- Hidden JSON -->

                                <input
                                    type="hidden"
                                    name="responsibility"
                                    id="responsibilityJson">

                            </div>

                        </div>


                        <!-- Benefit -->

                        <div class="col-md-12 mb-7">

                            <div class="job-builder mt-10">

                                <div class="builder-header">

                                    <div>

                                        <h5 class="builder-title">

                                            Fasilitas & Benefit

                                        </h5>

                                        <div class="builder-subtitle">

                                            Tambahkan benefit yang akan diterima kandidat.

                                        </div>

                                    </div>

                                </div>

                                <div class="builder-input">

                                    <div class="input-group">

                                        <span class="input-group-text">

                                            <i class="ki-duotone ki-gift fs-3"></i>

                                        </span>

                                        <input
                                            type="text"
                                            id="facilityInput"
                                            class="form-control"
                                            placeholder="Contoh : BPJS Kesehatan">

                                        <button
                                            type="button"
                                            id="btnAddFacility"
                                            class="btn btn-warning">

                                            <i class="ki-duotone ki-plus fs-3"></i>

                                            Tambah

                                        </button>

                                    </div>

                                </div>

                                <div
                                    class="builder-list"
                                    id="facilityList">

                                    <div class="builder-empty">

                                        <i class="ki-duotone ki-gift fs-2x mb-3"></i>

                                        <h6>

                                            Belum ada benefit

                                        </h6>

                                        <small>

                                            Tambahkan benefit pertama.

                                        </small>

                                    </div>

                                </div>

                                <input
                                    type="hidden"
                                    name="facility"
                                    id="facilityJson">

                            </div>

                        </div>


                        <div class="row">

                            <!-- Kuota -->

                            <div class="col-md-8 mb-7">

                                <label class="form-label required">
                                    Kuota
                                </label>

                                <div class="input-icon">

                                    <input
                                        type="number"
                                        min="1"
                                        name="kuota"
                                        class="form-control form-control-dark"
                                        placeholder="Jumlah">

                                </div>

                            </div>


                            <!-- Status -->

                            {{-- <div class="col-md-4 mb-7">

                                <label class="form-label required">
                                    Status
                                </label>

                                <select
                                    name="status"
                                    class="form-select form-select-dark">

                                    <option value="draft">
                                        Draft
                                    </option>

                                    <option value="submitted">
                                        Ajukan Review
                                    </option>

                                </select>

                            </div> --}}


                            <!-- Total Dilihat -->

                            <div class="col-md-4 mb-7">

                                <label class="form-label">
                                    Total Dilihat
                                </label>

                                <input
                                    type="text"
                                    class="form-control form-control-dark"
                                    value="0 Kali"
                                    disabled>

                                <small class="text-muted">
                                    Akan bertambah otomatis setelah dipublikasikan.
                                </small>

                            </div>

                        </div>


                        <div class="row">

                            <!-- Mulai -->

                            <div class="col-md-6 mb-7">

                                <label class="form-label required">
                                    Tanggal Dibuka
                                </label>

                                <div class="input-icon">

                                    <input
                                        type="date"
                                        name="start_date"
                                        class="form-control form-control-dark">

                                </div>

                            </div>


                            <!-- Tutup -->

                            <div class="col-md-6 mb-7">

                                <label class="form-label required">
                                    Tanggal Ditutup
                                </label>

                                <div class="input-icon">

                                    <input
                                        type="date"
                                        name="end_date"
                                        class="form-control form-control-dark">

                                </div>

                            </div>

                        </div>


                        <!-- Info -->

                        <div class="col-12">

                            <div class="alert alert-warning d-flex">

                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>

                                </i>

                                <div>

                                    <div class="fw-bold mb-1">
                                        Tips Membuat Lowongan Menarik
                                    </div>

                                    <ul class="mb-0 ps-5">

                                        <li>Gunakan nama posisi yang jelas.</li>

                                        <li>Jelaskan tanggung jawab secara rinci.</li>

                                        <li>Tuliskan benefit yang diterima kandidat.</li>

                                        <li>Pastikan tanggal penutupan sesuai kebutuhan.</li>

                                    </ul>

                                </div>

                            </div>

                        </div>

                    </div>

                </section>

                <!-- ========================= -->

                <section id="step1"
                    class="vacancy-section d-none">

                    <!-- LOKASI -->
                    <div class="row">

                        <div class="col-md-6 mb-5">

                            <label class="form-label required">
                                Provinsi
                            </label>

                            <select
                                class="form-select auto-input"
                                id="province"
                                name="province">

                                <option value="">
                                    Pilih Provinsi..
                                </option>

                                @foreach(\Laravolt\Indonesia\Models\Province::orderBy('name')->get() as $data_province)
                                    @if(Auth::user()->role == 'company')
                                        @php
                                            $province = \Laravolt\Indonesia\Models\Province::where('name', Auth::user()->user_company->company->province)->first();
                                            $city      = \Laravolt\Indonesia\Models\City::where('name', Auth::user()->user_company->company->city)->first();
                                            $district = \Laravolt\Indonesia\Models\District::where('name', Auth::user()->user_company->company->district)
                                                ->where('city_code', $city?->code)
                                                ->first();
                                            $village = \Laravolt\Indonesia\Models\Village::where('name', Auth::user()->user_company->company->village)
                                            ->where('district_code', $district?->code)
                                            ->first();
                                            $address = Auth::user()->user_company->company->address;
                                        @endphp
                                        <option
                                            value="{{ $data_province->code }}"
                                            {{ old('province', $province->code ?? '')== $data_province->code ? 'selected':'' }}>

                                            {{ $data_province->name }}

                                        </option>
                                    @else
                                        @php
                                            $province = \Laravolt\Indonesia\Models\Province::where('name', Auth::user()->user_bujp->bujp->province)->first();
                                            $city      = \Laravolt\Indonesia\Models\City::where('name', Auth::user()->user_bujp->bujp->city)->first();
                                            $district = \Laravolt\Indonesia\Models\District::where('name', Auth::user()->user_bujp->bujp->district)
                                                ->where('city_code', $city?->code)
                                                ->first();
                                            $village = \Laravolt\Indonesia\Models\Village::where('name', Auth::user()->user_bujp->bujp->village)
                                            ->where('district_code', $district?->code)
                                            ->first();
                                            $address = Auth::user()->user_bujp->bujp->address;
                                        @endphp
                                        <option
                                            value="{{ $data_province->code }}"
                                            {{ old('province', $province->code ?? '')== $data_province->code ? 'selected':'' }}>

                                            {{ $data_province->name }}

                                        </option>
                                    @endif

                                @endforeach

                            </select>

                        </div>

                        <div class="col-md-6 mb-5">

                            <label class="form-label required">

                                Kota / Kabupaten

                            </label>

                            <select
                                class="form-select auto-input"
                                id="city"
                                name="city"
                                disabled>

                                <option value="">
                                    Pilih Provinsi terlebih dahulu
                                </option>

                            </select>

                        </div>

                        {{-- <div class="col-md-6 mb-5">

                            <label class="form-label required">

                                Kecamatan

                            </label>

                            <select
                                class="form-select auto-input"
                                id="district"
                                name="district"
                                disabled>

                                <option value="">
                                    Pilih Kota/Kabupaten terlebih dahulu
                                </option>

                            </select>

                        </div>

                        <div class="col-md-6 mb-5">

                            <label class="form-label required">

                                Kelurahan

                            </label>

                            <select
                                class="form-select auto-input"
                                id="village"
                                name="village"
                                disabled>

                                <option value="">
                                    Pilih Kecamatan terlebih dahulu
                                </option>

                            </select>

                        </div> --}}

                        <div class="col-md-12 mb-7">

                            <label class="form-label required">
                                Alamat Lengkap Penempatan
                            </label>

                            <textarea
                                name="address"
                                rows="6"
                                class="form-control form-control-dark"
                                placeholder="isi alamat..">{{ $address }}</textarea>

                            <small class="text-muted">
                                Alamat sekarang mengikuti alamat profil
                            </small>

                        </div>

                    </div>

                </section>

                <!-- ========================= -->

                <section id="step2"
                    class="vacancy-section d-none">

                    <!-- SISTEM KERJA -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="">

                                <label class="form-label required">
                                    Jenis Pekerjaan
                                </label>

                                <div class="option-group">

                                    <label class="option-card active">

                                        <input
                                            type="radio"
                                            name="working_type"
                                            value="permanent"
                                            checked>

                                        Tetap

                                    </label>

                                    <label class="option-card">

                                        <input
                                            type="radio"
                                            name="working_type"
                                            value="contract">

                                        Kontrak

                                    </label>

                                    <label class="option-card">

                                        <input
                                            type="radio"
                                            name="working_type"
                                            value="internship">

                                        Magang

                                    </label>

                                    <label class="option-card">

                                        <input
                                            type="radio"
                                            name="working_type"
                                            value="freelance">

                                        Freelance

                                    </label>

                                </div>

                            </div>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label required mt-8">

                                Sistem Kerja

                            </label>

                            <div class="option-group">

                                <label class="option-card active">

                                    <input
                                        type="radio"
                                        name="working_system"
                                        value="shift"
                                        checked>

                                    Shift

                                </label>

                                <label class="option-card">

                                    <input
                                        type="radio"
                                        name="working_system"
                                        value="non-shift">

                                    Non Shift

                                </label>

                            </div>
                        </div>
                    </div>

                </section>

                <!-- ========================= -->

                <section id="step3"
                    class="vacancy-section d-none">

                    <!-- GAJI -->
                    <div class="row">

                        <!-- Tampilkan Gaji -->

                        <div class="col-lg-12 mb-8">

                            <div class="form-check form-switch form-check-custom form-check-solid">

                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="is_show_fee"
                                    name="is_show_fee"
                                    value="1"
                                    checked>

                                <label
                                    class="form-check-label fw-semibold ms-3"
                                    for="is_show_fee">

                                    Tampilkan informasi gaji kepada pelamar

                                </label>

                            </div>

                            <small class="text-muted ms-12">
                                Nominal gaji akan terlihat pada halaman lowongan.
                            </small>

                        </div>



                        <!-- Tipe Gaji -->

                        <div class="col-lg-12 mb-8">

                            <label class="form-label required">

                                Tipe Gaji

                            </label>

                            <div class="option-group">

                                <label class="option-card active">

                                    <input
                                        type="radio"
                                        name="fee_type"
                                        value="monthly"
                                        checked>

                                    Bulanan

                                </label>

                                <label class="option-card">

                                    <input
                                        type="radio"
                                        name="fee_type"
                                        value="daily">

                                    Harian

                                </label>

                            </div>

                        </div>



                        <!-- Minimum -->

                        <div class="col-lg-6 mb-8">

                            <label class="form-label required">

                                Gaji Minimum (Rp)

                            </label>

                            <input
                                type="text"
                                class="form-control money"
                                id="min_price"
                                name="min_price"
                                placeholder="Contoh : 4.000.000">

                        </div>



                        <!-- Maksimum -->

                        <div class="col-lg-6 mb-8">

                            <label class="form-label required">

                                Gaji Maksimum (Rp)

                            </label>

                            <input
                                type="text"
                                class="form-control money"
                                id="max_price"
                                name="max_price"
                                placeholder="Contoh : 6.000.000">

                        </div>

                    </div>

                </section>

                <!-- ========================= -->

                <section id="step4"
                    class="vacancy-section d-none">


                    <!-- PERSYARATAN -->
                    <div class="row">


                        <!-- =========================================================
                            JENIS KELAMIN
                        ========================================================== -->

                        <div class="col-lg-12 mb-8">

                            <label class="form-label">
                                Jenis Kelamin
                            </label>

                            <div class="option-group">

                                <label class="option-card active">

                                    <input
                                        type="radio"
                                        name="gender"
                                        value=""
                                        checked>

                                    Semua

                                </label>


                                <label class="option-card">

                                    <input
                                        type="radio"
                                        name="gender"
                                        value="laki-laki">

                                    Laki-laki

                                </label>


                                <label class="option-card">

                                    <input
                                        type="radio"
                                        name="gender"
                                        value="perempuan">

                                    Perempuan

                                </label>

                            </div>

                        </div>


                        <!-- =========================================================
                            USIA
                        ========================================================== -->

                        <div class="col-lg-6 mb-8">

                            <label class="form-label">

                                Usia Minimum

                            </label>

                            <input
                                type="number"
                                class="form-control"
                                name="min_age"
                                placeholder="18"
                                min="17"
                                max="100">

                        </div>


                        <div class="col-lg-6 mb-8">

                            <label class="form-label">

                                Usia Maksimum

                            </label>

                            <input
                                type="number"
                                class="form-control"
                                name="max_age"
                                placeholder="45"
                                min="17"
                                max="100">

                        </div>


                        <!-- =========================================================
                            TINGGI BADAN
                        ========================================================== -->

                        <div class="col-lg-6 mb-8">

                            <label class="form-label">

                                Tinggi Badan Minimum

                                <span class="text-muted">
                                    (cm)
                                </span>

                            </label>

                            <input
                                type="number"
                                class="form-control"
                                name="min_height"
                                placeholder="165"
                                min="100"
                                max="250">

                        </div>


                        <div class="col-lg-6 mb-8">

                            <label class="form-label">

                                Tinggi Badan Maksimum

                                <span class="text-muted">
                                    (cm)
                                </span>

                            </label>

                            <input
                                type="number"
                                class="form-control"
                                name="max_height"
                                placeholder="190"
                                min="100"
                                max="250">

                        </div>


                        <!-- =========================================================
                            BERAT BADAN
                        ========================================================== -->

                        <div class="col-lg-6 mb-8">

                            <label class="form-label">

                                Berat Badan Minimum

                                <span class="text-muted">
                                    (kg)
                                </span>

                            </label>

                            <input
                                type="number"
                                class="form-control"
                                name="min_weight"
                                placeholder="55"
                                min="20"
                                max="300">

                        </div>


                        <div class="col-lg-6 mb-8">

                            <label class="form-label">

                                Berat Badan Maksimum

                                <span class="text-muted">
                                    (kg)
                                </span>

                            </label>

                            <input
                                type="number"
                                class="form-control"
                                name="max_weight"
                                placeholder="90"
                                min="20"
                                max="300">

                        </div>


                        <!-- =========================================================
                            PENDIDIKAN
                        ========================================================== -->

                        <div class="col-lg-6 mb-8">

                            <label class="form-label">

                                Pendidikan Minimum

                            </label>

                            <select
                                class="form-select"
                                name="last_education">

                                <option value="">
                                    Tidak ditentukan
                                </option>

                                <option value="SD">
                                    SD
                                </option>

                                <option value="SMP">
                                    SMP
                                </option>

                                <option value="SMA / SMK">
                                    SMA / SMK
                                </option>

                                <option value="D1">
                                    D1
                                </option>

                                <option value="D2">
                                    D2
                                </option>

                                <option value="D3">
                                    D3
                                </option>

                                <option value="D4">
                                    D4
                                </option>

                                <option value="S1">
                                    S1
                                </option>

                                <option value="S2">
                                    S2
                                </option>

                                <option value="S3">
                                    S3
                                </option>

                            </select>

                        </div>


                        <!-- =========================================================
                            PENGALAMAN
                        ========================================================== -->

                        <div class="col-lg-6 mb-8">

                            <label class="form-label">

                                Pengalaman Minimum (Tahun)

                            </label>

                            <input
                                type="number"
                                class="form-control"
                                name="min_experience"
                                placeholder="0"
                                min="0">

                        </div>


                    </div>

                </section>

                <!-- ========================= -->

                <section id="step5"
                    class="vacancy-section d-none">

                    <!-- SERTIFIKASI -->
                    <div class="row">

                        <div class="col-lg-12">

                            <label class="form-label required">

                                Sertifikasi Wajib

                            </label>

                            <div class="text-muted mb-5">

                                Pilih sertifikat yang wajib dimiliki pelamar.

                            </div>

                            <div class="certificate-group">
                                @php
                                    $master_certificates = \App\Models\MasterCertificate::all();
                                @endphp

                                @foreach ($master_certificates as $certificate)
                                    <div class="certificate-item" data-value="{{ $certificate->title }}">

                                        <i class="fas fa-shield-alt"></i>

                                        {{ $certificate->title }}

                                    </div>
                                @endforeach

                            </div>

                            <input
                                type="hidden"
                                id="certificate_json"
                                name="certificate">

                        </div>

                    </div>

                    {{-- =====================================================
                        KOMPETENSI SKEMA
                    ====================================================== --}}

                    <div class="row mt-10">

                        <div class="col-lg-12">

                            <label class="form-label required">
                                Kompetensi Skema
                            </label>

                            <div class="text-muted mb-5">
                                Pilih kompetensi skema yang wajib dimiliki pelamar.
                            </div>

                            <div class="competency-scheme-group">

                                @php
                                    $master_competency_schemes =
                                        \App\Models\MasterCompetencyScheme::all();
                                @endphp

                                @foreach ($master_competency_schemes as $scheme)

                                    <div
                                        class="competency-scheme-item"
                                        data-value="{{ $scheme->title }}"
                                    >

                                        <i class="fas fa-award"></i>

                                        {{ $scheme->title }}

                                    </div>

                                @endforeach

                            </div>

                            <input
                                type="hidden"
                                id="competency_scheme_json"
                                name="competency_scheme"
                            >

                        </div>

                    </div>

                </section>

            </div>

        </form>

    </div>

    <!-- Footer -->

    <div class="card-footer d-flex justify-content-between align-items-center py-6">

        <button
            type="button"
            id="btnCancel"
            class="btn btn-light"
            data-url="{{ route('dashboard-user.job-vacancy.index') }}">

            <i class="fas fa-times me-2"></i>

            Batal

        </button>

        <div class="ms-auto">

            <button
                type="button"
                id="btnDraft"
                class="btn btn-light-warning me-3">

                <i class="fas fa-save me-2"></i>

                Simpan Draft

            </button>

            <button
                type="button"
                id="btnNext"
                class="btn btn-warning">

                Selanjutnya

                <i class="fas fa-arrow-right ms-2"></i>

            </button>

            <button
                type="submit"
                id="btnSubmit"
                class="btn btn-warning d-none">

                <i class="fas fa-paper-plane me-2"></i>

                Submit Lowongan

            </button>

        </div>

    </div>

</div>    

<div class="modal fade" id="cancelModal" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header border-0">

                <h5 class="modal-title">

                    Batalkan Pembuatan Lowongan?

                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body text-center">

                <div class="mb-5">

                    <i class="fas fa-triangle-exclamation text-warning"
                        style="font-size:70px;"></i>

                </div>

                <h4 class="fw-bold mb-3">

                    Perubahan Belum Disimpan

                </h4>

                <p class="text-muted mb-0">

                    Semua data yang sudah Anda isi akan <b>hilang</b> apabila keluar dari halaman ini.

                    <br><br>

                    Apakah Anda yakin ingin membatalkan proses penambahan lowongan?

                </p>

            </div>

            <div class="modal-footer border-0">

                <button
                    type="button"
                    class="btn btn-light"
                    data-bs-dismiss="modal">

                    Lanjut Mengisi

                </button>

                <button
                    type="button"
                    id="btnConfirmCancel"
                    class="btn btn-danger">

                    Ya, Batalkan

                </button>

            </div>

        </div>

    </div>

</div>
@endsection

@section('js')
    <script>
        $("#btnCancel").on("click", function () {

            $("#cancelModal").modal("show");

        });

        $("#btnConfirmCancel").on("click", function () {

            let url = $("#btnCancel").data("url");

            window.location.href = url;

        });

        $(function(){

            let current = 0;

            let total = $(".vacancy-section").length;

            showStep(current);

            function showStep(index){

                $(".vacancy-section")
                    .addClass("d-none");

                $("#step"+index)
                    .removeClass("d-none");

                $(".vacancy-step")
                    .removeClass("active");

                $('.vacancy-step[data-step="'+index+'"]')
                    .addClass("active");

                // tombol next

                if(index==total-1){

                    $("#btnNext").addClass("d-none");

                    $("#btnSubmit").removeClass("d-none");

                }else{

                    $("#btnNext").removeClass("d-none");

                    $("#btnSubmit").addClass("d-none");

                }

            }

            $(".vacancy-step").click(function(){

                current = $(this).data("step");

                showStep(current);

            });

            $("#btnNext").click(function(){

                if(current<total-1){

                    current++;

                    showStep(current);

                }

            });

            // $("#btnBack").click(function(){

            //     if(current>0){

            //         current--;

            //         showStep(current);

            //     }

            // });

        });

        let responsibilityItems = [];
        let facilityItems = [];


        /*
        |--------------------------------------------------------------------------
        | DOCUMENT READY
        |--------------------------------------------------------------------------
        */

        $(document).ready(function () {


            /*
            |--------------------------------------------------------------------------
            | POSITION
            |--------------------------------------------------------------------------
            */

            $("#position").on("change", function () {

                let uuid = $(this)
                    .find(":selected")
                    .data("uuid");


                /*
                |--------------------------------------------------------------------------
                | RESET DATA LAMA
                |--------------------------------------------------------------------------
                */

                $("#description_work").val("");

                responsibilityItems = [];

                renderResponsibility();


                /*
                |--------------------------------------------------------------------------
                | JIKA POSITION KOSONG
                |--------------------------------------------------------------------------
                */

                if (!uuid) {

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | LOADING
                |--------------------------------------------------------------------------
                */

                $("#description_work")
                    .val("Memuat deskripsi pekerjaan...");


                $("#position")
                    .prop("disabled", true);


                /*
                |--------------------------------------------------------------------------
                | AJAX
                |--------------------------------------------------------------------------
                */

                $.ajax({

                    url:
                        "{{ url('dashboard-user/job-vacancy/position') }}/" + uuid,

                    type: "GET",

                    success: function (response) {


                        if (!response.status) {

                            return;

                        }


                        let data = response.data;


                        /*
                        |--------------------------------------------------------------------------
                        | DESCRIPTION
                        |--------------------------------------------------------------------------
                        */

                        $("#description_work")
                            .val(
                                data.description ?? ""
                            );


                        /*
                        |--------------------------------------------------------------------------
                        | RESPONSIBILITY DARI MASTER
                        |--------------------------------------------------------------------------
                        */

                        responsibilityItems = [];


                        let responsibilities =
                            data.responsibility ?? [];


                        /*
                        |--------------------------------------------------------------------------
                        | PASTIKAN ARRAY
                        |--------------------------------------------------------------------------
                        */

                        if (!Array.isArray(responsibilities)) {

                            /*
                            |--------------------------------------------------------------------------
                            | JIKA DATA MASIH BERUPA JSON STRING
                            |--------------------------------------------------------------------------
                            */

                            try {

                                responsibilities =
                                    JSON.parse(responsibilities);

                            } catch (e) {

                                responsibilities = [];

                            }

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | MASUKKAN KE ARRAY
                        |--------------------------------------------------------------------------
                        */

                        responsibilities.forEach(function (item) {

                            if (
                                item !== null &&
                                item !== undefined &&
                                String(item).trim() !== ""
                            ) {

                                responsibilityItems.push(
                                    String(item).trim()
                                );

                            }

                        });


                        /*
                        |--------------------------------------------------------------------------
                        | RENDER
                        |--------------------------------------------------------------------------
                        */

                        renderResponsibility();

                    },


                    /*
                    |--------------------------------------------------------------------------
                    | ERROR
                    |--------------------------------------------------------------------------
                    */

                    error: function (xhr) {

                        console.error(
                            "Position AJAX Error:",
                            xhr.responseText
                        );


                        Swal.fire({

                            icon: "error",

                            title: "Gagal",

                            text:
                                xhr.responseJSON?.message ??
                                "Gagal mengambil data posisi."

                        });


                        $("#description_work")
                            .val("");


                        responsibilityItems = [];

                        renderResponsibility();

                    },


                    /*
                    |--------------------------------------------------------------------------
                    | COMPLETE
                    |--------------------------------------------------------------------------
                    */

                    complete: function () {

                        $("#position")
                            .prop("disabled", false);

                    }

                });

            });



            /*
            |--------------------------------------------------------------------------
            | ADD RESPONSIBILITY
            |--------------------------------------------------------------------------
            */

            $("#btnAddResponsibility").on(
                "click",
                function () {

                    addResponsibility();

                }
            );



            /*
            |--------------------------------------------------------------------------
            | ENTER RESPONSIBILITY
            |--------------------------------------------------------------------------
            */

            $("#responsibilityInput").on(
                "keypress",
                function (e) {

                    if (e.which === 13) {

                        e.preventDefault();

                        addResponsibility();

                    }

                }
            );

        });



        /*
        |--------------------------------------------------------------------------
        | ADD RESPONSIBILITY
        |--------------------------------------------------------------------------
        |
        | Bisa dipanggil:
        |
        | addResponsibility()
        |
        | untuk input manual.
        |
        */

        function addResponsibility(value = null)
        {

            /*
            |--------------------------------------------------------------------------
            | JIKA VALUE TIDAK DIKIRIM
            |--------------------------------------------------------------------------
            */

            if (value === null) {

                value = $("#responsibilityInput")
                    .val()
                    .trim();

            } else {

                value = String(value).trim();

            }


            /*
            |--------------------------------------------------------------------------
            | VALIDASI
            |--------------------------------------------------------------------------
            */

            if (value === "") {

                Swal.fire({

                    icon: "warning",

                    title: "Perhatian",

                    text:
                        "Tanggung jawab belum diisi."

                });

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | TAMBAHKAN KE ARRAY
            |--------------------------------------------------------------------------
            */

            responsibilityItems.push(value);


            /*
            |--------------------------------------------------------------------------
            | KOSONGKAN INPUT MANUAL
            |--------------------------------------------------------------------------
            */

            $("#responsibilityInput")
                .val("")
                .focus();


            /*
            |--------------------------------------------------------------------------
            | RENDER
            |--------------------------------------------------------------------------
            */

            renderResponsibility();

        }



        /*
        |--------------------------------------------------------------------------
        | RENDER RESPONSIBILITY
        |--------------------------------------------------------------------------
        */

        function renderResponsibility()
        {

            let html = "";


            /*
            |--------------------------------------------------------------------------
            | EMPTY
            |--------------------------------------------------------------------------
            */

            if (responsibilityItems.length === 0) {

                html = `

                    <div class="builder-empty">

                        <i class="ki-duotone ki-note-2 fs-2x mb-3"></i>

                        <h6>
                            Belum ada tanggung jawab
                        </h6>

                        <small>
                            Tambahkan tanggung jawab pertama.
                        </small>

                    </div>

                `;

            }


            /*
            |--------------------------------------------------------------------------
            | LIST
            |--------------------------------------------------------------------------
            */

            else {

                $.each(
                    responsibilityItems,
                    function (i, item) {


                        /*
                        |--------------------------------------------------------------------------
                        | ESCAPE HTML
                        |--------------------------------------------------------------------------
                        */

                        let safeItem =
                            $("<div>")
                                .text(item)
                                .html();


                        html += `

                            <div
                                class="builder-item d-flex align-items-center justify-content-between mb-2">


                                <!-- LEFT -->

                                <div
                                    class="builder-left d-flex align-items-center">


                                    <div
                                        class="builder-number me-3">


                                        <span>

                                            ${i + 1}

                                        </span>


                                    </div>


                                    <div
                                        class="builder-text">


                                        ${safeItem}


                                    </div>


                                </div>



                                <!-- ACTION -->

                                <div
                                    class="builder-action d-flex gap-1">


                                    <!-- UP -->

                                    <button
                                        type="button"
                                        class="btn btn-sm btn-light"
                                        onclick="moveResponsibilityUp(${i})"
                                        title="Naik">


                                        ↑


                                    </button>



                                    <!-- DOWN -->

                                    <button
                                        type="button"
                                        class="btn btn-sm btn-light"
                                        onclick="moveResponsibilityDown(${i})"
                                        title="Turun">


                                        ↓


                                    </button>



                                    <!-- EDIT -->

                                    <button
                                        type="button"
                                        class="btn btn-sm btn-light-warning"
                                        onclick="editResponsibility(${i})"
                                        title="Edit">


                                        <i
                                            class="ki-duotone ki-pencil fs-4">
                                        </i>


                                    </button>



                                    <!-- DELETE -->

                                    <button
                                        type="button"
                                        class="btn btn-sm btn-light-danger"
                                        onclick="deleteResponsibility(${i})"
                                        title="Hapus">


                                        <i
                                            class="ki-duotone ki-trash fs-4">
                                        </i>


                                    </button>


                                </div>

                            </div>

                        `;

                    }
                );

            }


            /*
            |--------------------------------------------------------------------------
            | RENDER HTML
            |--------------------------------------------------------------------------
            */

            $("#responsibilityList")
                .html(html);


            /*
            |--------------------------------------------------------------------------
            | UPDATE HIDDEN JSON
            |--------------------------------------------------------------------------
            */

            $("#responsibilityJson")
                .val(
                    JSON.stringify(
                        responsibilityItems
                    )
                );

        }



        /*
        |--------------------------------------------------------------------------
        | EDIT RESPONSIBILITY
        |--------------------------------------------------------------------------
        */

        function editResponsibility(index)
        {

            /*
            |--------------------------------------------------------------------------
            | CEK INDEX
            |--------------------------------------------------------------------------
            */

            if (
                responsibilityItems[index] === undefined
            ) {

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | PROMPT
            |--------------------------------------------------------------------------
            */

            let text = prompt(
                "Edit Tanggung Jawab",
                responsibilityItems[index]
            );


            /*
            |--------------------------------------------------------------------------
            | CANCEL
            |--------------------------------------------------------------------------
            */

            if (text === null) {

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | TRIM
            |--------------------------------------------------------------------------
            */

            text = text.trim();


            /*
            |--------------------------------------------------------------------------
            | EMPTY
            |--------------------------------------------------------------------------
            */

            if (text === "") {

                Swal.fire({

                    icon: "warning",

                    title: "Perhatian",

                    text:
                        "Tanggung jawab tidak boleh kosong."

                });

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | UPDATE
            |--------------------------------------------------------------------------
            */

            responsibilityItems[index] = text;


            /*
            |--------------------------------------------------------------------------
            | RENDER
            |--------------------------------------------------------------------------
            */

            renderResponsibility();

        }



        /*
        |--------------------------------------------------------------------------
        | DELETE RESPONSIBILITY
        |--------------------------------------------------------------------------
        */

        function deleteResponsibility(index)
        {

            /*
            |--------------------------------------------------------------------------
            | CEK INDEX
            |--------------------------------------------------------------------------
            */

            if (
                responsibilityItems[index] === undefined
            ) {

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | CONFIRM
            |--------------------------------------------------------------------------
            */

            Swal.fire({

                icon: "warning",

                title: "Hapus Tanggung Jawab?",

                text:
                    "Data tanggung jawab ini akan dihapus.",

                showCancelButton: true,

                confirmButtonText: "Ya, Hapus",

                cancelButtonText: "Batal",

                confirmButtonColor: "#d33"

            }).then(function (result) {


                if (!result.isConfirmed) {

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | DELETE ARRAY
                |--------------------------------------------------------------------------
                */

                responsibilityItems.splice(
                    index,
                    1
                );


                /*
                |--------------------------------------------------------------------------
                | RENDER
                |--------------------------------------------------------------------------
                */

                renderResponsibility();

            });

        }



        /*
        |--------------------------------------------------------------------------
        | MOVE UP
        |--------------------------------------------------------------------------
        */

        function moveResponsibilityUp(index)
        {

            /*
            |--------------------------------------------------------------------------
            | INDEX 0 TIDAK BISA NAIK
            |--------------------------------------------------------------------------
            */

            if (index <= 0) {

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | SWAP
            |--------------------------------------------------------------------------
            */

            let temp =
                responsibilityItems[index - 1];


            responsibilityItems[index - 1] =
                responsibilityItems[index];


            responsibilityItems[index] =
                temp;


            /*
            |--------------------------------------------------------------------------
            | RENDER
            |--------------------------------------------------------------------------
            */

            renderResponsibility();

        }



        /*
        |--------------------------------------------------------------------------
        | MOVE DOWN
        |--------------------------------------------------------------------------
        */

        function moveResponsibilityDown(index)
        {

            /*
            |--------------------------------------------------------------------------
            | INDEX TERAKHIR TIDAK BISA TURUN
            |--------------------------------------------------------------------------
            */

            if (
                index >=
                responsibilityItems.length - 1
            ) {

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | SWAP
            |--------------------------------------------------------------------------
            */

            let temp =
                responsibilityItems[index + 1];


            responsibilityItems[index + 1] =
                responsibilityItems[index];


            responsibilityItems[index] =
                temp;


            /*
            |--------------------------------------------------------------------------
            | RENDER
            |--------------------------------------------------------------------------
            */

            renderResponsibility();

        }

        /*====================================
        =              FACILITY              =
        ====================================*/

        $("#btnAddFacility").click(function(){

            let value=$("#facilityInput").val().trim();

            if(value=="") return;

            facilityItems.push(value);

            $("#facilityInput").val("");

            renderFacility();

        });


        $("#facilityInput").keypress(function(e){

            if(e.which==13){

                e.preventDefault();

                $("#btnAddFacility").click();

            }

        });


        function renderFacility(){

            let html="";

            if(facilityItems.length==0){

                html=`
                    <div class="builder-empty">

                        <i class="ki-duotone ki-gift fs-2x mb-3"></i>

                        <h6>Belum ada benefit</h6>

                        <small>Tambahkan benefit pertama.</small>

                    </div>
                `;

            }else{

                $.each(facilityItems,function(i,item){

                    html+=`

                    <div class="builder-item">

                        <div class="builder-left">

                            <div class="builder-number">

                                ${i+1}

                            </div>

                            <div class="builder-text">

                                ${item}

                            </div>

                        </div>

                        <div class="builder-action">

                            <button
                                type="button"
                                onclick="moveFacilityUp(${i})">

                                ↑

                            </button>

                            <button
                                type="button"
                                onclick="moveFacilityDown(${i})">

                                ↓

                            </button>

                            <button
                                type="button"
                                onclick="editFacility(${i})">

                                <i class="ki-duotone ki-pencil"></i>

                            </button>

                            <button
                                type="button"
                                onclick="deleteFacility(${i})">

                                <i class="ki-duotone ki-trash"></i>

                            </button>

                        </div>

                    </div>

                    `;

                });

            }

            $("#facilityList").html(html);

            $("#facilityJson").val(JSON.stringify(facilityItems));

        }


        /* Edit */

        function editFacility(index){

            let text=prompt("Edit Benefit",facilityItems[index]);

            if(text==null) return;

            text=text.trim();

            if(text=="") return;

            facilityItems[index]=text;

            renderFacility();

        }

        /* Delete */

        function deleteFacility(index){

            if(!confirm("Hapus item ini?")) return;

            facilityItems.splice(index,1);

            renderFacility();

        }

        /* Up */

        function moveFacilityUp(index){

            if(index==0) return;

            [facilityItems[index-1],facilityItems[index]]=[facilityItems[index],facilityItems[index-1]];

            renderFacility();

        }

        /* Down */

        function moveFacilityDown(index){

            if(index==facilityItems.length-1) return;

            [facilityItems[index+1],facilityItems[index]]=[facilityItems[index],facilityItems[index+1]];

            renderFacility();

        }

        $(document).ready(function(){

            function loadCities(province, selected=""){

                $("#city")
                    .prop("disabled", true)
                    .html('<option>Memuat...</option>');

                $.get("/location/cities/"+province,function(res){

                    let html='<option value="">Pilih Kota/Kabupaten</option>';

                    $.each(res,function(i,item){

                        html+=`
                            <option
                                value="${item.code}"
                                ${selected==item.code?'selected':''}>
                                ${item.name}
                            </option>
                        `;

                    });

                    $("#city")
                        .html(html)
                        .prop("disabled", false);

                });

            }


            function loadDistricts(city, selected=""){

                $("#district")
                    .prop("disabled", true)
                    .html('<option>Memuat...</option>');

                $.get("/location/districts/"+city,function(res){

                    let html='<option value="">Pilih Kecamatan</option>';

                    $.each(res,function(i,item){

                        html+=`
                            <option
                                value="${item.code}"
                                ${selected==item.code?'selected':''}>
                                ${item.name}
                            </option>
                        `;

                    });

                    $("#district")
                        .html(html)
                        .prop("disabled", false);

                });

            }


            function loadVillages(district, selected=""){

                $("#village")
                    .prop("disabled", true)
                    .html('<option>Memuat...</option>');

                $.get("/location/villages/"+district,function(res){

                    let html='<option value="">Pilih Kelurahan</option>';

                    $.each(res,function(i,item){

                        html+=`
                            <option
                                value="${item.code}"
                                ${selected==item.code?'selected':''}>
                                ${item.name}
                            </option>
                        `;

                    });

                    $("#village")
                        .html(html)
                        .prop("disabled", false);

                });

            }


            $("#province").change(function(){

                let province = $(this).val();

                $("#city").prop("disabled", true);
                $("#district").prop("disabled", true);
                $("#village").prop("disabled", true);

                $("#district").html(
                    '<option value="">Pilih Kota/Kabupaten terlebih dahulu</option>'
                );

                $("#village").html(
                    '<option value="">Pilih Kecamatan terlebih dahulu</option>'
                );

                if(province==""){

                    $("#city").html(
                        '<option value="">Pilih Provinsi terlebih dahulu</option>'
                    );

                    return;
                }

                loadCities(province);

            });


            $("#city").change(function(){

                let city=$(this).val();

                $("#district").prop("disabled",true);
                $("#village").prop("disabled",true);

                $("#village").html(
                    '<option value="">Pilih Kecamatan terlebih dahulu</option>'
                );

                if(city==""){

                    $("#district").html(
                        '<option value="">Pilih Kota/Kabupaten terlebih dahulu</option>'
                    );

                    return;
                }

                loadDistricts(city);

            });


            $("#district").change(function(){

                let district=$(this).val();

                $("#village").prop("disabled",true);

                if(district==""){

                    $("#village").html(
                        '<option value="">Pilih Kecamatan terlebih dahulu</option>'
                    );

                    return;
                }

                loadVillages(district);

            });

            let province="{{ old('province', $province->code ?? '') }}";
            let city="{{ old('city', $city->code ?? '') }}";
            let district="{{ old('district', $district->code ?? '') }}";
            let village="{{ old('village', $village->code ?? '') }}";

            if(province!=""){
                loadCities(province,city);

                setTimeout(function(){

                    loadDistricts(city,district);

                },300);

                setTimeout(function(){

                    loadVillages(district,village);

                },600);

            }
        });

        $(".option-card").click(function(){

            let name = $(this).find("input").attr("name");

            $(".option-card input[name='"+name+"']")
                .closest(".option-card")
                .removeClass("active");

            $(this)
                .addClass("active");

            $(this)
                .find("input")
                .prop("checked", true);

        });

        $("#is_show_fee").change(function(){

            // let show=$(this).is(":checked");

            $("#min_price").prop("readonly", !checked);
            $("#max_price").prop("readonly", !checked);

            $(".fee-wrapper").toggleClass("opacity-50", !checked);

        });

        $(".money").on("keyup",function(){

            let angka=$(this).val().replace(/\D/g,'');

            angka=angka.replace(/\B(?=(\d{3})+(?!\d))/g,".");

            $(this).val(angka);

        });

        function generateCertificateJSON()
        {
            let certificate = [];

            $(".certificate-item.active").each(function () {

                certificate.push(
                    $(this).data("value")
                );

            });

            $("#certificate_json").val(
                JSON.stringify(certificate)
            );
        }


        function generateCompetencySchemeJSON()
        {
            let competencyScheme = [];

            $(".competency-scheme-item.active").each(function () {

                competencyScheme.push(
                    $(this).data("value")
                );

            });

            $("#competency_scheme_json").val(
                JSON.stringify(competencyScheme)
            );
        }


        /*
        |--------------------------------------------------------------------------
        | CERTIFICATE
        |--------------------------------------------------------------------------
        */

        $(document).on(
            "click",
            ".certificate-item",
            function () {

                $(this).toggleClass("active");

                generateCertificateJSON();

            }
        );


        /*
        |--------------------------------------------------------------------------
        | COMPETENCY SCHEME
        |--------------------------------------------------------------------------
        */

        $(document).on(
            "click",
            ".competency-scheme-item",
            function () {

                $(this).toggleClass("active");

                generateCompetencySchemeJSON();

            }
        );


        /*
        |--------------------------------------------------------------------------
        | INITIAL
        |--------------------------------------------------------------------------
        */

        generateCertificateJSON();

        generateCompetencySchemeJSON();

        // $(".certificate-item").click(function(){

        //     $(this).toggleClass("active");

        //     generateCertificateJSON();

        // });

        // generateCertificateJSON();

        $(function () {

            //-----------------------------------------
            // Publish
            //-----------------------------------------

            $("#formCreateJobVacancy").submit(function(e){

                console.log(1);

                e.preventDefault();

                submitJob("submitted");

            });


            //-----------------------------------------
            // Draft
            //-----------------------------------------

            $("#btnDraft").click(function(){

                submitJob("draft");

            });

            $("#btnSubmit").click(function(){

                submitJob("submitted");

            });


            //-----------------------------------------
            // Function Submit
            //-----------------------------------------

            function submitJob(status){

                let formData = new FormData($("#formCreateJobVacancy")[0]);

                formData.append("status",status);

                $("#btnSubmit").prop("disabled",true);
                $("#btnDraft").prop("disabled",true);

                $.ajax({

                    url: "{{ route('dashboard-user.job-vacancy.store') }}",
                    type:"POST",
                    data:formData,
                    processData:false,
                    contentType:false,

                    success:function(response){

                        Swal.fire({

                            icon:'success',

                            title:'Berhasil',

                            text:response.message,

                            confirmButtonColor:"#d6a13b"

                        }).then(()=>{

                            window.location.href="{{ route('dashboard-user.job-vacancy.index') }}";

                        });

                    },

                    error:function(xhr){

                        $("#btnSubmit").prop("disabled",false);
                        $("#btnDraft").prop("disabled",false);

                        $(".is-invalid").removeClass("is-invalid");
                        $(".invalid-feedback").remove();

                        if(xhr.status===422){

                            let errors = xhr.responseJSON.errors;

                            let html = "";

                            $.each(errors,function(key,value){

                                html += "• " + value[0] + "<br>";

                            });

                            Swal.fire({

                                icon:'warning',

                                title:'Validasi Gagal',

                                html:html,

                                confirmButtonColor:"#d6a13b"

                            });

                        }

                        else{

                            console.log(xhr);

                            Swal.fire({

                                icon:'error',

                                title:'Terjadi Kesalahan',

                                text:'Silakan coba beberapa saat lagi.',

                                confirmButtonColor:"#d6a13b"

                            });

                        }

                    },

                    complete:function(){

                        $("#btnSubmit").prop("disabled",false);
                        $("#btnDraft").prop("disabled",false);

                    }

                });

            }

        });
    </script>
@endsection