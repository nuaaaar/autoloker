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

        .certificate-group{

            display:flex;

            flex-wrap:wrap;

            gap:14px;

        }

        .certificate-item{

            padding:14px 22px;

            border:1px solid rgba(255,255,255,.10);

            border-radius:14px;

            background:#0d1426;

            color:#97a5bf;

            cursor:pointer;

            transition:.25s;

            font-weight:600;

            display:flex;

            align-items:center;

            gap:10px;

            user-select:none;

        }

        .certificate-item i{

            font-size:15px;

        }

        .certificate-item:hover{

            border-color:#d6a13b;

            color:#fff;

        }

        .certificate-item.active{

            background:rgba(214,161,59,.12);

            border-color:#d6a13b;

            color:#ffc84d;

            box-shadow:0 0 15px rgba(214,161,59,.20);

        }

        .invalid-feedback{

            display:block;

            margin-top:6px;

            font-size:13px;

        }

        .is-invalid{

            border-color:#dc3545 !important;

        }

        .tag-wrapper{
            display:flex;
            flex-wrap:wrap;
            gap:10px;
            margin-top:20px;
        }

        .tag-item{
            display:flex;
            align-items:center;
            background:#FFF8E1;
            border:1px solid #FFD54F;
            color:#795548;
            border-radius:50px;
            padding:8px 14px;
            font-size:13px;
            font-weight:600;
        }

        .tag-item i{
            cursor:pointer;
            margin-left:8px;
            color:#dc3545;
        }

        .poster-upload-card {
            width: 100%;
        }

        .poster-upload-area {
            min-height: 260px;
            border: 2px dashed rgba(255, 255, 255, .15);
            border-radius: 14px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            padding: 30px;
            text-align: center;
            transition: .2s;
            background: rgba(255, 255, 255, .02);
        }

        .poster-upload-area:hover {
            border-color: #f7b003;
            background: rgba(247, 176, 3, .05);
        }

        .poster-upload-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(247, 176, 3, .12);
            color: #f7b003;
            margin-bottom: 15px;
        }

        .poster-preview {
            position: relative;
            max-width: 400px;
            margin-bottom: 15px;
        }

        .poster-preview img {
            width: 100%;
            max-height: 500px;
            object-fit: contain;
            border-radius: 14px;
            border: 1px solid rgba(255, 255, 255, .1);
            background: rgba(0, 0, 0, .15);
            display: block;
        }

        .poster-remove {
            position: absolute;
            top: 10px;
            right: 10px;
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
            <a href="{{ route('dashboard-user.training.index') }}" class="text-muted text-hover-primary">Pelatihan Saya</a>
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
                Tambah Pelatihan Baru
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

            <!-- STEP 1 -->
            <div class="vacancy-step active" data-step="0">

                <div class="step-number">
                    <i class="ki-duotone ki-book-open fs-3">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>

                <div class="step-text">
                    <strong>Info Dasar</strong>
                </div>

            </div>

            <!-- STEP 2 -->
            <div class="vacancy-step" data-step="1">

                <div class="step-number">
                    <i class="ki-duotone ki-geolocation fs-3">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>

                <div class="step-text">
                    <strong>Jadwal & Lokasi</strong>
                </div>

            </div>

            <!-- STEP 3 -->
            <div class="vacancy-step" data-step="2">

                <div class="step-number">
                    <i class="ki-duotone ki-notepad-edit fs-3">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i>
                </div>

                <div class="step-text">
                    <strong>Materi & Persyaratan</strong>
                </div>

            </div>

            <!-- STEP 4 -->
            <div class="vacancy-step" data-step="3">

                <div class="step-number">
                    <i class="ki-duotone ki-shield-tick fs-3">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>

                <div class="step-text">
                    <strong>Sertifikasi</strong>
                </div>

            </div>

            <!-- STEP 5 -->
            <div class="vacancy-step" data-step="4">

                <div class="step-number">
                    <i class="ki-duotone ki-paper-plane fs-3">
                    </i>
                </div>

                <div class="step-text">
                    <strong>Publikasi</strong>
                </div>

            </div>

        </div>

        <!-- FORM -->

        <form id="formCreateTraining" enctype="multipart/form-data">

            @csrf

            <div class="p-10">

                <!-- ========================= -->

                <section id="step0" class="vacancy-section">

                    <div class="row">

                        <div class="col-md-12 mb-7">

                            <label class="form-label required">
                                Poster Pelatihan
                            </label>

                            <div class="poster-upload-card">

                                {{-- Preview --}}
                                <div
                                    id="posterPreview"
                                    class="poster-preview d-none">

                                    <img
                                        id="posterPreviewImage"
                                        src=""
                                        alt="Preview Poster">

                                    <button
                                        type="button"
                                        id="btnRemovePoster"
                                        class="btn btn-sm btn-danger poster-remove">

                                        <i class="ki-duotone ki-trash fs-4">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                        </i>

                                        Hapus

                                    </button>

                                </div>


                                {{-- Upload --}}
                                <label
                                    for="posterInput"
                                    id="posterUploadArea"
                                    class="poster-upload-area">

                                    <div class="poster-upload-icon">

                                        <i class="ki-duotone ki-picture fs-2x">

                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>

                                        </i>

                                    </div>

                                    <div class="fw-bold fs-5 mb-2">
                                        Upload Poster Pelatihan
                                    </div>

                                    <div class="text-muted fs-7 mb-1">
                                        Klik untuk memilih poster
                                    </div>

                                    <div class="badge badge-light-warning fs-7 mt-1">

                                        <i class="ki-duotone ki-information-2 fs-5 me-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>

                                        <strong>Tips:</strong>
                                        Gunakan poster dengan rasio <strong>3:4</strong>,
                                        ukuran minimal <strong>750 × 1000 px</strong>,
                                        format <strong>JPG/JPEG/PNG</strong>,
                                        dan ukuran maksimal <strong>5 MB</strong>.

                                    </div>

                                </label>


                                <input
                                    type="file"
                                    id="posterInput"
                                    name="poster"
                                    class="d-none"
                                    accept="image/jpeg,image/png,image/jpg">

                            </div>

                            <div
                                id="posterError"
                                class="text-danger fs-7 mt-2 d-none">
                            </div>

                        </div>

                        <div class="col-md-12 mb-7">

                            <label class="form-label required">
                                Judul Pelatihan
                            </label>

                            <input
                                type="text"
                                class="form-control form-control-dark"
                                name="title"
                                placeholder="Contoh : Pelatihan Gada Pratama Angkatan 12">

                            <small class="text-muted">
                                Judul yang akan ditampilkan kepada peserta.
                            </small>

                        </div>

                        <div class="col-md-6 mb-7">

                            <label class="form-label required">
                                Penyelenggara
                            </label>

                            @php
                                $provider = '';

                                if (Auth::user()->role === 'bujp') {

                                    $provider = Auth::user()->user_bujp?->bujp?->company_name;

                                } elseif (Auth::user()->role === 'company') {

                                    $provider = Auth::user()->user_company?->company?->company_name;

                                }
                            @endphp

                            <input
                                type="text"
                                class="form-control form-control-dark"
                                name="provider"
                                placeholder="Contoh : PT ABC Training Center"
                                value="{{ $provider }}" readonly>

                        </div>

                        <div class="col-md-6 mb-7">

                            <label class="form-label">
                                Instruktur
                            </label>

                            <input
                                type="text"
                                class="form-control form-control-dark"
                                name="instructor"
                                placeholder="Contoh : AKBP (Purn.) Budi Santoso">

                        </div>

                        <div class="col-md-6 mb-7">

                            <label class="form-label required">
                                Kategori Pelatihan
                            </label>

                            <select
                                class="form-select form-select-dark"
                                name="category">
                                @php
                                    $masterCategoryCertificates = \App\Models\MasterCategoryCertificate::all();
                                @endphp
                                <option value="">Pilih Kategori</option>
                                @foreach($masterCategoryCertificates as $certificate)
                                    <option value="{{ $certificate->title }}">{{ $certificate->title }}</option>
                                @endforeach

                            </select>

                        </div>

                        <div class="col-md-6 mb-7">

                            <label class="form-label required">
                                Level
                            </label>

                            <select
                                class="form-select form-select-dark"
                                name="level">

                                <option value="">Pilih Level</option>
                                <option>Dasar</option>
                                <option>Menengah</option>
                                <option>Lanjutan</option>
                                <option>Profesional</option>

                            </select>

                        </div>

                        <!-- Biaya Pelatihan -->
                        <div class="col-md-12 mb-7">

                            <label class="form-label required">
                                Biaya Pelatihan
                            </label>

                            <div class="option-group">

                                <label class="option-card active">

                                    <input
                                        type="radio"
                                        name="is_free"
                                        value="1"
                                        checked>

                                    Gratis

                                </label>

                                <label class="option-card">

                                    <input
                                        type="radio"
                                        name="is_free"
                                        value="0">

                                    Berbayar

                                </label>

                            </div>

                            <small class="text-muted">
                                Tentukan apakah peserta perlu membayar untuk mengikuti pelatihan.
                            </small>

                        </div>

                        <div
                            class="col-md-6 mb-7 d-none"
                            id="priceWrapper">

                            <label class="form-label required">
                                Biaya Pelatihan (Rp)
                            </label>

                            <input
                                type="text"
                                class="form-control money"
                                name="price"
                                placeholder="Contoh : 500.000">

                            <small class="text-muted">
                                Kosongkan apabila pelatihan gratis.
                            </small>

                        </div>

                        <div class="col-md-12 mb-7">

                            <label class="form-label required">
                                Deskripsi Pelatihan
                            </label>

                            <textarea
                                rows="6"
                                class="form-control form-control-dark"
                                name="description"
                                placeholder="Jelaskan tujuan, manfaat, materi utama, target peserta, serta informasi penting mengenai pelatihan."></textarea>

                        </div>

                        <div class="col-md-12 mb-7">

                            <div class="job-builder">

                                <div class="builder-header">

                                    <div>

                                        <h5 class="builder-title">

                                            Tag Pelatihan

                                        </h5>

                                        <div class="builder-subtitle">

                                            Tambahkan kata kunci agar pelatihan lebih mudah ditemukan.

                                        </div>

                                    </div>

                                </div>

                                <div class="builder-input">

                                    <div class="input-group">

                                        <span class="input-group-text">

                                            <i class="ki-duotone ki-tag fs-3"></i>

                                        </span>

                                        <input
                                            type="text"
                                            id="tagInput"
                                            class="form-control"
                                            placeholder="Contoh : Satpam">

                                        <button
                                            type="button"
                                            id="btnAddTag"
                                            class="btn btn-warning">

                                            <i class="ki-duotone ki-plus fs-3"></i>

                                            Tambah

                                        </button>

                                    </div>

                                </div>

                                <div
                                    class="builder-list"
                                    id="tagList">

                                    <div class="builder-empty">

                                        <i class="ki-duotone ki-tag fs-2x mb-3"></i>

                                        <h6>

                                            Belum ada tag

                                        </h6>

                                        <small>

                                            Tambahkan tag pertama.

                                        </small>

                                    </div>

                                </div>

                                <input
                                    type="hidden"
                                    id="tagJson"
                                    name="tags">

                            </div>

                        </div>

                        <div class="col-md-8 mb-7">

                            <label class="form-label required">
                                Kuota Peserta
                            </label>

                            <input
                                type="number"
                                min="1"
                                class="form-control form-control-dark"
                                name="quota"
                                placeholder="30">

                        </div>

                        {{-- <div class="col-md-4 mb-7">

                            <label class="form-label required">
                                Status
                            </label>

                            <select
                                class="form-select form-select-dark"
                                name="status">

                                <option value="draft">Draft</option>
                                <option value="submitted">Ajukan Review</option>

                            </select>

                        </div> --}}

                        <div class="col-md-4 mb-7">

                            <label class="form-label">
                                Total Dilihat
                            </label>

                            <input
                                class="form-control form-control-dark"
                                value="0 Kali"
                                disabled>

                            <small class="text-muted">
                                Akan bertambah otomatis setelah dipublikasikan.
                            </small>

                        </div>

                        <div class="alert alert-warning">

                            <div class="fw-bold mb-2">
                                Tips Membuat Pelatihan Menarik
                            </div>

                            <ul class="mb-0 ps-5">

                                <li>Gunakan judul pelatihan yang jelas dan spesifik.</li>

                                <li>Tuliskan manfaat yang akan diperoleh peserta.</li>

                                <li>Pilih kategori dan level yang sesuai.</li>

                                <li>Tambahkan tag agar pelatihan mudah ditemukan.</li>

                                <li>Pastikan kuota peserta sesuai kapasitas pelatihan.</li>

                            </ul>

                        </div>

                    </div>

                </section>

                <!-- ========================= -->

                <section id="step1"
                    class="vacancy-section d-none">

                    <!-- LOKASI -->
                    <div class="row">

                        <div class="col-lg-12 mb-8">

                            <label class="form-label">

                                Mode Pelatihan

                            </label>

                            <div class="option-group">

                                <label class="option-card active">

                                    <input
                                        type="radio"
                                        name="training_mode"
                                        value="offline"
                                        checked>

                                    Offline

                                </label>

                                <label class="option-card">

                                    <input
                                        type="radio"
                                        name="training_mode"
                                        value="online">

                                    Online

                                </label>

                                <label class="option-card">

                                    <input
                                        type="radio"
                                        name="training_mode"
                                        value="hybrid">

                                    Hybrid

                                </label>

                            </div>

                        </div>

                        <div class="col-md-6 mb-7">

                            <label class="form-label required">

                                Tanggal Mulai

                            </label>

                            <input
                                type="date"
                                class="form-control form-control-dark"
                                name="start_date">

                        </div>

                        <div class="col-md-6 mb-7">

                            <label class="form-label required">

                                Tanggal Selesai

                            </label>

                            <input
                                type="date"
                                class="form-control form-control-dark"
                                name="end_date">

                        </div>

                        <div class="col-md-6 mb-7">

                            <label class="form-label">

                                Durasi (Hari)

                            </label>

                            <input
                                type="number"
                                min="1"
                                class="form-control form-control-dark"
                                name="duration_day"
                                placeholder="3">

                        </div>

                        <div class="col-md-6 mb-7">

                            <label class="form-label">

                                Total JP (Jam Pelajaran)

                            </label>

                            <input
                                type="number"
                                min="1"
                                class="form-control form-control-dark"
                                name="total_jp"
                                placeholder="40">

                        </div>

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

                        <div class="col-md-12 mb-7">

                            <label class="form-label">

                                Link Google Maps

                            </label>

                            <input
                                type="url"
                                class="form-control form-control-dark"
                                name="google_map"
                                placeholder="https://maps.google.com/...">

                            <small class="text-muted">

                                Memudahkan peserta menuju lokasi pelatihan.

                            </small>

                        </div>

                        <div
                            class="col-md-12 mb-7 meeting-wrapper d-none">

                            <label class="form-label">

                                Link Meeting

                            </label>

                            <input
                                type="url"
                                class="form-control form-control-dark"
                                name="meeting_url"
                                placeholder="https://zoom.us/...">

                            <small class="text-muted">

                                Zoom, Google Meet, Microsoft Teams, dll.

                            </small>

                        </div>

                    </div>

                </section>

                <!-- ========================= -->

                <section id="step2"
                    class="vacancy-section d-none">

                    <!-- SISTEM KERJA -->
                    <div class="row">
                        <div class="col-md-12 mb-7">

                            <div class="job-builder">

                                <div class="builder-header">

                                    <div>

                                        <h5 class="builder-title">

                                            Materi / Silabus Pelatihan
                                            <span class="text-danger">*</span>

                                        </h5>

                                        <div class="builder-subtitle">

                                            Tambahkan materi yang akan dipelajari peserta.

                                        </div>

                                    </div>

                                </div>

                                <div class="builder-input">

                                    <div class="input-group">

                                        <span class="input-group-text">

                                            <i class="ki-duotone ki-book fs-3"></i>

                                        </span>

                                        <input
                                            type="text"
                                            id="syllabusInput"
                                            class="form-control"
                                            placeholder="Contoh : Dasar-dasar Gada Pratama">

                                        <button
                                            type="button"
                                            id="btnAddSyllabus"
                                            class="btn btn-warning">

                                            <i class="ki-duotone ki-plus fs-3"></i>

                                            Tambah

                                        </button>

                                    </div>

                                </div>

                                <div
                                    class="builder-list"
                                    id="syllabusList">

                                    <div class="builder-empty">

                                        <i class="ki-duotone ki-book fs-2x mb-3"></i>

                                        <h6>

                                            Belum ada materi

                                        </h6>

                                        <small>

                                            Tambahkan materi pertama.

                                        </small>

                                    </div>

                                </div>

                                <input
                                    type="hidden"
                                    name="syllabus"
                                    id="syllabusJson">

                            </div>

                        </div>

                        <div class="col-md-12 mb-7">

                            <div class="job-builder mt-10">

                                <div class="builder-header">

                                    <div>

                                        <h5 class="builder-title">

                                            Persyaratan Peserta

                                        </h5>

                                        <div class="builder-subtitle">

                                            Tambahkan persyaratan yang harus dipenuhi peserta.

                                        </div>

                                    </div>

                                </div>

                                <div class="builder-input">

                                    <div class="input-group">

                                        <span class="input-group-text">

                                            <i class="ki-duotone ki-security-user fs-3"></i>

                                        </span>

                                        <input
                                            type="text"
                                            id="requirementInput"
                                            class="form-control"
                                            placeholder="Contoh : Minimal usia 18 tahun">

                                        <button
                                            type="button"
                                            id="btnAddRequirement"
                                            class="btn btn-warning">

                                            <i class="ki-duotone ki-plus fs-3"></i>

                                            Tambah

                                        </button>

                                    </div>

                                </div>

                                <div
                                    class="builder-list"
                                    id="requirementList">

                                    <div class="builder-empty">

                                        <i class="ki-duotone ki-security-user fs-2x mb-3"></i>

                                        <h6>

                                            Belum ada persyaratan

                                        </h6>

                                        <small>

                                            Tambahkan persyaratan pertama.

                                        </small>

                                    </div>

                                </div>

                                <input
                                    type="hidden"
                                    name="requirements"
                                    id="requirementJson">

                            </div>

                        </div>
                    </div>

                </section>

                <!-- ========================= -->

                <section id="step3"
                    class="vacancy-section d-none">

                    <div class="row">

                        <!-- Menghasilkan Sertifikat -->

                        <div class="col-lg-12 mb-8">

                            <label class="form-label required">
                                Apakah pelatihan ini menghasilkan sertifikat?
                            </label>

                            <div class="option-group">

                                <label class="option-card active">

                                    <input
                                        type="radio"
                                        name="is_certificate"
                                        value="1"
                                        checked>

                                    Ya

                                </label>

                                <label class="option-card">

                                    <input
                                        type="radio"
                                        name="is_certificate"
                                        value="0">

                                    Tidak

                                </label>

                            </div>

                        </div>



                        <!-- Informasi Sertifikat -->

                        <div id="certificateArea">

                            <div class="col-lg-12 mb-7">

                                <label class="form-label required">
                                    Nama Sertifikat
                                </label>

                                <input
                                    type="text"
                                    name="certificate_name"
                                    class="form-control"
                                    placeholder="Contoh : Sertifikat Gada Pratama">

                            </div>

                            <div class="col-lg-6 mb-7">

                                <label class="form-label">
                                    Masa Berlaku Sertifikat
                                </label>

                                <select
                                    class="form-select"
                                    name="certificate_validity">

                                    <option value="">Tidak Ditentukan</option>

                                    <option value="Seumur Hidup">
                                        Seumur Hidup
                                    </option>

                                    <option value="1 Tahun">
                                        1 Tahun
                                    </option>

                                    <option value="2 Tahun">
                                        2 Tahun
                                    </option>

                                    <option value="3 Tahun">
                                        3 Tahun
                                    </option>

                                    <option value="5 Tahun">
                                        5 Tahun
                                    </option>

                                </select>

                            </div>

                        </div>



                        <!-- Sertifikasi Prasyarat -->

                        {{-- <div class="col-lg-12 mt-8">

                            <label class="form-label">

                                Sertifikasi yang Harus Dimiliki Peserta

                            </label>

                            <div class="text-muted mb-5">

                                Kosongkan apabila pelatihan ini dapat diikuti oleh semua peserta.

                            </div>

                            <div class="certificate-group">

                                @php
                                    $masterCertificates = \App\Models\MasterCertificate::all();
                                @endphp

                                @foreach($masterCertificates as $certificate)

                                    <div
                                        class="certificate-item"
                                        data-value="{{ $certificate->title }}">

                                        <i class="fas fa-certificate"></i>

                                        {{ $certificate->title }}

                                    </div>

                                @endforeach

                            </div>

                            <input
                                type="hidden"
                                name="certificate_requirement"
                                id="certificateRequirementJson">

                        </div> --}}



                        <!-- Informasi -->

                        {{-- <div class="col-lg-12 mt-8">

                            <div class="alert alert-light-info">

                                <strong>Informasi</strong>

                                <ul class="mb-0 mt-2">

                                    <li>Pilih <b>Tidak</b> apabila pelatihan hanya memberikan surat kehadiran.</li>

                                    <li>Nama sertifikat akan ditampilkan pada halaman detail pelatihan.</li>

                                    <li>Sertifikasi prasyarat bersifat opsional.</li>

                                </ul>

                            </div>

                        </div> --}}

                    </div>

                </section>

                <!-- ========================= -->

                <section id="step4"
                    class="vacancy-section d-none">

                    <div class="row">

                        <!-- Status -->

                        {{-- <div class="col-lg-6 mb-8">

                            <label class="form-label required">
                                Status Publikasi
                            </label>

                            <select
                                name="status"
                                class="form-select">

                                <option value="draft">
                                    Simpan sebagai Draft
                                </option>

                                <option value="submitted">
                                    Ajukan untuk Dipublikasikan
                                </option>

                            </select>

                            <small class="text-muted">
                                Draft dapat diedit kembali kapan saja. Pengajuan akan direview oleh Admin.
                            </small>

                        </div> --}}


                        <!-- Total Dilihat -->

                        <div class="col-lg-12 mb-8">

                            <label class="form-label">
                                Total Dilihat
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                value="0 Kali"
                                disabled>

                            <small class="text-muted">
                                Akan bertambah setelah pelatihan dipublikasikan.
                            </small>

                        </div>



                        <!-- Ringkasan -->

                        <div class="col-lg-12">

                            <div class="card border border-dashed border-primary">

                                <div class="card-header">

                                    <h4 class="card-title">

                                        Ringkasan Pelatihan

                                    </h4>

                                </div>

                                <div class="card-body">

                                    <div class="row">

                                        <div class="col-md-6 mb-4">

                                            <strong>Judul Pelatihan</strong>

                                            <div id="summaryTitle"
                                                class="text-muted">

                                                -

                                            </div>

                                        </div>

                                        <div class="col-md-6 mb-4">

                                            <strong>Penyelenggara</strong>

                                            <div id="summaryProvider"
                                                class="text-muted">

                                                -

                                            </div>

                                        </div>

                                        <div class="col-md-6 mb-4">

                                            <strong>Lokasi</strong>

                                            <div id="summaryLocation"
                                                class="text-muted">

                                                -

                                            </div>

                                        </div>

                                        <div class="col-md-6 mb-4">

                                            <strong>Periode</strong>

                                            <div id="summaryPeriod"
                                                class="text-muted">

                                                -

                                            </div>

                                        </div>

                                        <div class="col-md-6 mb-4">

                                            <strong>Kuota</strong>

                                            <div id="summaryQuota"
                                                class="text-muted">

                                                -

                                            </div>

                                        </div>

                                        <div class="col-md-6 mb-4">

                                            <strong>Sertifikat</strong>

                                            <div id="summaryCertificate"
                                                class="text-muted">

                                                -

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>



                        <!-- Checklist -->

                        <div class="col-lg-12 mt-8">

                            <div class="form-check form-check-custom form-check-solid">

                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="confirmTraining">

                                <label
                                    class="form-check-label ms-3"
                                    for="confirmTraining">

                                    Saya memastikan seluruh informasi pelatihan yang saya isi sudah benar dan dapat dipublikasikan.

                                </label>

                            </div>

                        </div>



                        <!-- Tips -->

                        <div class="col-lg-12 mt-8">

                            <div class="alert alert-warning">

                                <h5 class="mb-3">

                                    Tips Sebelum Submit

                                </h5>

                                <ul class="mb-0">

                                    <li>Pastikan jadwal pelatihan sudah benar.</li>

                                    <li>Pastikan alamat atau meeting link dapat diakses.</li>

                                    <li>Pastikan kuota peserta sesuai.</li>

                                    <li>Pastikan materi dan persyaratan sudah lengkap.</li>

                                    <li>Pastikan informasi sertifikat sudah sesuai.</li>

                                </ul>

                            </div>

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
            data-url="{{ route('dashboard-user.training.index') }}">

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

        /*====================================
        =              TAGS                  =
        ====================================*/

        let tagItems = [];

        // Load data edit
        try{
            tagItems = JSON.parse($("#tagJson").val()) || [];
        }catch(e){
            tagItems = [];
        }

        renderTag();

        /* Tambah */

        $("#btnAddTag").click(function(){

            let value = $("#tagInput").val().trim();

            if(value === ""){
                return;
            }

            // Hindari tag duplikat
            if(tagItems.includes(value)){
                Swal.fire({
                    icon:"warning",
                    title:"Tag sudah ada",
                    text:"Silakan masukkan tag yang berbeda."
                });
                return;
            }

            tagItems.push(value);

            $("#tagInput").val("");

            renderTag();

        });

        /* Enter */

        $("#tagInput").keypress(function(e){

            if(e.which == 13){

                e.preventDefault();

                $("#btnAddTag").click();

            }

        });


        /* Render */

        function renderTag(){

            let html = "";

            if(tagItems.length == 0){

                html = `
                    <div class="builder-empty">

                        <i class="ki-duotone ki-tag fs-2x mb-3"></i>

                        <h6>Belum ada tag</h6>

                        <small>Tambahkan tag pertama.</small>

                    </div>
                `;

            }else{

                html += `<div class="tag-wrapper">`;

                $.each(tagItems,function(i,item){

                    html += `
                        <div class="tag-item">

                            <span>${item}</span>

                            <i
                                class="ki-duotone ki-cross fs-6"
                                onclick="deleteTag(${i})">

                            </i>

                        </div>
                    `;

                });

                html += `</div>`;

            }

            $("#tagList").html(html);

            $("#tagJson").val(JSON.stringify(tagItems));

        }


        /* Hapus */

        function deleteTag(index){

            Swal.fire({

                title:"Hapus tag?",
                text:"Tag akan dihapus.",

                icon:"warning",

                showCancelButton:true,

                confirmButtonText:"Ya",

                cancelButtonText:"Batal"

            }).then((result)=>{

                if(result.isConfirmed){

                    tagItems.splice(index,1);

                    renderTag();

                }

            });

        }


        /* Edit */

        function editTag(index){

            let value = prompt("Edit Tag", tagItems[index]);

            if(value === null){
                return;
            }

            value = value.trim();

            if(value === ""){
                return;
            }

            tagItems[index] = value;

            renderTag();

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

        function toggleTrainingMode(){

            let mode = $("input[name='training_mode']:checked").val();

            if(mode=="offline"){

                $(".location-wrapper").removeClass("d-none");

                $(".meeting-wrapper").addClass("d-none");

            }

            else if(mode=="online"){

                $(".location-wrapper").addClass("d-none");

                $(".meeting-wrapper").removeClass("d-none");

            }

            else{

                $(".location-wrapper").removeClass("d-none");

                $(".meeting-wrapper").removeClass("d-none");

            }

        }

        $("input[name='training_mode']").click(function(){

            toggleTrainingMode();

        });

        toggleTrainingMode();

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

        /*=========================================
        =            SYLLABUS BUILDER             =
        =========================================*/

        let syllabusItems = [];

        try{
            syllabusItems = JSON.parse($("#syllabusJson").val()) || [];
        }catch(e){
            syllabusItems = [];
        }

        renderSyllabus();

        $("#btnAddSyllabus").click(function(){

            let value = $("#syllabusInput").val().trim();

            if(value == "") return;

            syllabusItems.push(value);

            $("#syllabusInput").val("");

            renderSyllabus();

        });

        $("#syllabusInput").keypress(function(e){

            if(e.which == 13){

                e.preventDefault();

                $("#btnAddSyllabus").click();

            }

        });

        function renderSyllabus(){

            let html = "";

            if(syllabusItems.length == 0){

                html = `
                    <div class="builder-empty">
                        <i class="ki-duotone ki-book-open fs-2x mb-3"></i>
                        <h6>Belum ada materi</h6>
                        <small>Tambahkan materi pertama.</small>
                    </div>
                `;

            }else{

                $.each(syllabusItems,function(i,item){

                    html += `
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

                                <button type="button" onclick="moveSyllabusUp(${i})">↑</button>

                                <button type="button" onclick="moveSyllabusDown(${i})">↓</button>

                                <button type="button" onclick="editSyllabus(${i})">
                                    <i class="ki-duotone ki-pencil"></i>
                                </button>

                                <button type="button" onclick="deleteSyllabus(${i})">
                                    <i class="ki-duotone ki-trash"></i>
                                </button>

                            </div>

                        </div>
                    `;

                });

            }

            $("#syllabusList").html(html);

            $("#syllabusJson").val(JSON.stringify(syllabusItems));

        }

        function deleteSyllabus(index){

            syllabusItems.splice(index,1);

            renderSyllabus();

        }

        function editSyllabus(index){

            $("#syllabusInput").val(syllabusItems[index]);

            syllabusItems.splice(index,1);

            renderSyllabus();

        }

        function moveSyllabusUp(index){

            if(index==0) return;

            [syllabusItems[index-1],syllabusItems[index]] =
            [syllabusItems[index],syllabusItems[index-1]];

            renderSyllabus();

        }

        function moveSyllabusDown(index){

            if(index==syllabusItems.length-1) return;

            [syllabusItems[index+1],syllabusItems[index]] =
            [syllabusItems[index],syllabusItems[index+1]];

            renderSyllabus();

        }

        /*=========================================
        =         REQUIREMENT BUILDER            =
        =========================================*/

        let requirementItems = [];

        try{
            requirementItems = JSON.parse($("#requirementJson").val()) || [];
        }catch(e){
            requirementItems = [];
        }

        renderRequirement();

        $("#btnAddRequirement").click(function(){

            let value = $("#requirementInput").val().trim();

            if(value == "") return;

            requirementItems.push(value);

            $("#requirementInput").val("");

            renderRequirement();

        });

        $("#requirementInput").keypress(function(e){

            if(e.which == 13){

                e.preventDefault();

                $("#btnAddRequirement").click();

            }

        });

        function renderRequirement(){

            let html = "";

            if(requirementItems.length == 0){

                html = `
                    <div class="builder-empty">
                        <i class="ki-duotone ki-security-user fs-2x mb-3"></i>
                        <h6>Belum ada persyaratan</h6>
                        <small>Tambahkan persyaratan pertama.</small>
                    </div>
                `;

            }else{

                $.each(requirementItems,function(i,item){

                    html += `
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

                                <button type="button" onclick="moveRequirementUp(${i})">↑</button>

                                <button type="button" onclick="moveRequirementDown(${i})">↓</button>

                                <button type="button" onclick="editRequirement(${i})">
                                    <i class="ki-duotone ki-pencil"></i>
                                </button>

                                <button type="button" onclick="deleteRequirement(${i})">
                                    <i class="ki-duotone ki-trash"></i>
                                </button>

                            </div>

                        </div>
                    `;

                });

            }

            $("#requirementList").html(html);

            $("#requirementJson").val(JSON.stringify(requirementItems));

        }

        function deleteRequirement(index){

            requirementItems.splice(index,1);

            renderRequirement();

        }

        function editRequirement(index){

            $("#requirementInput").val(requirementItems[index]);

            requirementItems.splice(index,1);

            renderRequirement();

        }

        function moveRequirementUp(index){

            if(index==0) return;

            [requirementItems[index-1],requirementItems[index]] =
            [requirementItems[index],requirementItems[index-1]];

            renderRequirement();

        }

        function moveRequirementDown(index){

            if(index==requirementItems.length-1) return;

            [requirementItems[index+1],requirementItems[index]] =
            [requirementItems[index],requirementItems[index+1]];

            renderRequirement();

        }

        $('input[name="is_certificate"]').click(function(){

            if($(this).val() == "1"){

                $("#certificateArea").slideDown();

            }else{

                $("#certificateArea").slideUp();

                $("input[name='certificate_name']").val("");

                $("select[name='certificate_validity']").val("");

            }

        }).trigger("change");

        $(".money").on("keyup",function(){

            let angka=$(this).val().replace(/\D/g,'');

            angka=angka.replace(/\B(?=(\d{3})+(?!\d))/g,".");

            $(this).val(angka);

        });

        function generateCertificateJSON(){

            let certificate=[];

            $(".certificate-item.active").each(function(){

                certificate.push($(this).data("value"));

            });

            $("#certificate_json").val(JSON.stringify(certificate));

        }

        $(".certificate-item").click(function(){

            $(this).toggleClass("active");

            generateCertificateJSON();

        });

        generateCertificateJSON();

        function loadSummary(){

            $("#summaryTitle").text($("input[name='title']").val() || "-");

            $("#summaryProvider").text($("input[name='provider']").val() || "-");

            $("#summaryQuota").text($("input[name='quota']").val() || "-");

            $("#summaryLocation").text(
                [
                    $("#city option:selected").text(),
                    $("#province option:selected").text()
                ].filter(x => x && !x.includes("Pilih")).join(", ") || "-"
            );

            let start = $("input[name='start_date']").val();
            let end   = $("input[name='end_date']").val();

            if(start && end){
                $("#summaryPeriod").text(start + " s/d " + end);
            }else{
                $("#summaryPeriod").text("-");
            }

            if($("input[name='is_certificate']:checked").val() == "1"){
                $("#summaryCertificate").text(
                    $("input[name='certificate_name']").val() || "Ya"
                );
            }else{
                $("#summaryCertificate").text("Tidak Ada");
            }

        }

        $(document).on("keyup change", `
            input[name='title'],
            input[name='provider'],
            input[name='quota'],
            input[name='certificate_name'],
            input[name='start_date'],
            input[name='end_date'],
            input[name='is_certificate'],
            #province,
            #city
        `, function () {

            loadSummary();

        });

        $("input[name=is_free]").click(function(){

            if($(this).val() == "0"){

                $("#priceWrapper").removeClass("d-none");

            }else{

                $("#priceWrapper").addClass("d-none");

                $("input[name=price]").val("");

            }

        });

        // Jalankan saat halaman pertama kali dibuka
        $("input[name=is_free]:checked").trigger("change");

        function showStep(step){

            $(".vacancy-section").addClass("d-none");

            $("#step" + step).removeClass("d-none");

            $(".vacancy-step").removeClass("active");

            $(".vacancy-step[data-step='"+step+"']").addClass("active");

            if(step == 4){

                loadSummary();

            }

        }

        $(function () {

            //-----------------------------------------
            // Publish
            //-----------------------------------------

            $("#formCreateTraining").submit(function(e){

                e.preventDefault();

                submitTraining("submitted");

            });


            //-----------------------------------------
            // Draft
            //-----------------------------------------

            $("#btnDraft").click(function(){

                submitTraining("draft");

            });

            $("#btnSubmit").click(function(){

                submitTraining("submitted");

            });


            //-----------------------------------------
            // Function Submit
            //-----------------------------------------

            function submitTraining(status){

                if(status=="submitted" && !$("#confirmTraining").is(":checked")){

                    Swal.fire({
                        icon:"warning",
                        title:"Konfirmasi",
                        text:"Silakan centang konfirmasi terlebih dahulu."
                    });

                    return;
                }

                let formData = new FormData($("#formCreateTraining")[0]);

                formData.set("status", status);

                $("#btnSubmit").prop("disabled", true);
                $("#btnDraft").prop("disabled", true);

                $.ajax({

                    url: "{{ route('dashboard-user.training.store') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,

                    success: function(response){

                        Swal.fire({

                            icon: "success",

                            title: "Berhasil",

                            text: response.message,

                            confirmButtonColor: "#d6a13b"

                        }).then(function(){

                            window.location.href = "{{ route('dashboard-user.training.index') }}";

                        });

                    },

                    error: function(xhr){

                        $(".is-invalid").removeClass("is-invalid");
                        $(".invalid-feedback").remove();

                        if(xhr.status === 422){

                            let errors = xhr.responseJSON.errors;

                            let html = "";

                            $.each(errors, function(key, value){

                                html += "• " + value[0] + "<br>";

                                let input = $("[name='"+key+"']");

                                if(input.length){

                                    input.addClass("is-invalid");

                                    if(input.next(".invalid-feedback").length === 0){

                                        input.after(
                                            `<div class="invalid-feedback">${value[0]}</div>`
                                        );

                                    }

                                }

                            });

                            Swal.fire({

                                icon: "warning",

                                title: "Validasi Gagal",

                                html: html,

                                confirmButtonColor: "#d6a13b"

                            });

                        }else{

                            console.log(xhr);

                            Swal.fire({

                                icon: "error",

                                title: "Terjadi Kesalahan",

                                text: "Silakan coba beberapa saat lagi.",

                                confirmButtonColor: "#d6a13b"

                            });

                        }

                    },

                    complete: function(){

                        $("#btnSubmit").prop("disabled", false);
                        $("#btnDraft").prop("disabled", false);

                    }

                });

            }

        });

        $(document).ready(function () {

            $('#posterInput').on('change', function () {

                const file = this.files[0];

                $('#posterError').addClass('d-none').text('');

                if (!file) {
                    return;
                }

                /*
                |--------------------------------------------------------------------------
                | VALIDASI FORMAT
                |--------------------------------------------------------------------------
                */

                const allowedTypes = [
                    'image/jpeg',
                    'image/jpg',
                    'image/png'
                ];

                if (!allowedTypes.includes(file.type)) {

                    $('#posterError')
                        .removeClass('d-none')
                        .text('Format poster harus JPG, JPEG, atau PNG.');

                    $(this).val('');

                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | VALIDASI SIZE
                |--------------------------------------------------------------------------
                */

                const maxSize = 5 * 1024 * 1024;

                if (file.size > maxSize) {

                    $('#posterError')
                        .removeClass('d-none')
                        .text('Ukuran poster maksimal 5 MB.');

                    $(this).val('');

                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | PREVIEW
                |--------------------------------------------------------------------------
                */

                const reader = new FileReader();

                reader.onload = function (e) {

                    $('#posterPreviewImage')
                        .attr('src', e.target.result);

                    $('#posterPreview')
                        .removeClass('d-none');

                    $('#posterUploadArea')
                        .addClass('d-none');

                };

                reader.readAsDataURL(file);

            });


            /*
            |--------------------------------------------------------------------------
            | REMOVE POSTER
            |--------------------------------------------------------------------------
            */

            $('#btnRemovePoster').on('click', function () {

                $('#posterInput').val('');

                $('#posterPreviewImage')
                    .attr('src', '');

                $('#posterPreview')
                    .addClass('d-none');

                $('#posterUploadArea')
                    .removeClass('d-none');

                $('#posterError')
                    .addClass('d-none')
                    .text('');

            });

        });
    </script>
@endsection