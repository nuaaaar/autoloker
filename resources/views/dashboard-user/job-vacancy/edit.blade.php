@extends('layouts.dashboard-user')

@section('title', 'Edit')

@section('css')
    <style>
        /* =========================================================
        THEME VARIABLES
        ========================================================= */

        :root,
        [data-bs-theme="light"] {
            --vacancy-bg: #ffffff;
            --vacancy-surface: #ffffff;
            --vacancy-surface-soft: #f8fafc;

            --vacancy-text: #182338;
            --vacancy-text-secondary: #64748b;
            --vacancy-text-muted: #94a3b8;

            --vacancy-border: #e2e8f0;
            --vacancy-border-soft: rgba(15, 23, 42, .07);

            --vacancy-step-bg: #f8fafc;
            --vacancy-step-text: #64748b;
            --vacancy-step-hover: #eef2f7;

            --vacancy-gold: #e8a801;
            --vacancy-gold-hover: #f2b600;
            --vacancy-gold-text: #111827;
            --vacancy-gold-soft: rgba(232, 168, 1, .10);
            --vacancy-gold-border: rgba(232, 168, 1, .40);

            --vacancy-footer-bg: #f8fafc;

            --builder-bg: #ffffff;
            --builder-input-bg: #f8fafc;
            --builder-item-bg: #f8fafc;
            --builder-action-bg: #eef2f7;

            --builder-text: #182338;
            --builder-text-secondary: #64748b;
            --builder-text-muted: #94a3b8;

            --builder-border: #e2e8f0;
            --builder-border-soft: rgba(15, 23, 42, .07);

            --builder-gold: #c7932b;
            --builder-gold-light: #f5b942;
            --builder-gold-soft: rgba(199, 147, 43, .10);

            --option-bg: #f8fafc;
            --option-text: #64748b;
            --option-border: #e2e8f0;

            --certificate-bg: #f8fafc;
            --certificate-text: #64748b;
            --certificate-border: #e2e8f0;

            --danger: #dc3545;
        }


        [data-bs-theme="dark"] {
            --vacancy-bg: #11192c;
            --vacancy-surface: #11192c;
            --vacancy-surface-soft: #0b1020;

            --vacancy-text: #ffffff;
            --vacancy-text-secondary: #95a2bd;
            --vacancy-text-muted: #73819d;

            --vacancy-border: rgba(255, 255, 255, .06);
            --vacancy-border-soft: rgba(255, 255, 255, .05);

            --vacancy-step-bg: #182338;
            --vacancy-step-text: #94a3b8;
            --vacancy-step-hover: #182338;

            --vacancy-gold: #e8a801;
            --vacancy-gold-hover: #f2b600;
            --vacancy-gold-text: #121212;
            --vacancy-gold-soft: rgba(232, 168, 1, .12);
            --vacancy-gold-border: rgba(232, 168, 1, .45);

            --vacancy-footer-bg: #121c33;

            --builder-bg: #11192c;
            --builder-input-bg: #0b1020;
            --builder-item-bg: #0b1020;
            --builder-action-bg: #18243d;

            --builder-text: #ffffff;
            --builder-text-secondary: #8c98b3;
            --builder-text-muted: #73819d;

            --builder-border: rgba(255, 255, 255, .06);
            --builder-border-soft: rgba(255, 255, 255, .05);

            --builder-gold: #c7932b;
            --builder-gold-light: #f5b942;
            --builder-gold-soft: rgba(199, 147, 43, .15);

            --option-bg: #0b1020;
            --option-text: #93a3be;
            --option-border: rgba(255, 255, 255, .08);

            --certificate-bg: #0d1426;
            --certificate-text: #97a5bf;
            --certificate-border: rgba(255, 255, 255, .10);

            --danger: #dc3545;
        }


        /* =========================================================
        STEP WRAPPER
        ========================================================= */

        .vacancy-step-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 20px 24px;

            border-top: 1px solid var(--vacancy-border-soft);
            border-bottom: 1px solid var(--vacancy-border-soft);

            background: var(--vacancy-surface);

            overflow-x: auto;
            overflow-y: hidden;
            white-space: nowrap;

            scrollbar-width: none;
        }

        .vacancy-step-wrapper::-webkit-scrollbar {
            display: none;
        }


        /* =========================================================
        STEP BUTTON
        ========================================================= */

        .vacancy-step {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;

            min-width: max-content;
            height: 52px;
            padding: 0 22px;

            border-radius: 14px;
            border: 1px solid transparent;

            cursor: pointer;
            transition: .25s;

            color: var(--vacancy-step-text);
            background: transparent;

            font-size: 15px;
            font-weight: 600;
        }

        .vacancy-step i {
            font-size: 18px;
            color: inherit;
        }

        .vacancy-step:hover {
            background: var(--vacancy-step-hover);
            color: var(--vacancy-text);
        }


        /* =========================================================
        ACTIVE STEP
        ========================================================= */

        .vacancy-step.active {
            background: var(--vacancy-gold-soft);
            border-color: var(--vacancy-gold-border);
            color: var(--vacancy-gold);
        }

        .vacancy-step.active i {
            color: var(--vacancy-gold);
        }


        /* =========================================================
        BODY
        ========================================================= */

        .vacancy-section {
            animation: fadeSection .25s ease;
        }

        @keyframes fadeSection {
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }


        /* =========================================================
        FOOTER
        ========================================================= */

        .card-footer {
            border-top: 1px solid var(--vacancy-border-soft);
            background: var(--vacancy-footer-bg);
        }


        /* =========================================================
        BUTTON
        ========================================================= */

        #btnBack,
        #btnDraft,
        #btnNext,
        #btnSubmit {
            min-width: 170px;
            height: 48px;
            border-radius: 12px;
            font-weight: 600;
        }


        /* Draft */

        #btnDraft {
            background: var(--builder-action-bg);
            color: var(--vacancy-text);
            border: 1px solid var(--vacancy-border);
        }

        #btnDraft:hover {
            background: var(--vacancy-step-hover);
        }


        /* Next / Submit */

        #btnNext,
        #btnSubmit {
            background: var(--vacancy-gold);
            border: none;
            color: var(--vacancy-gold-text);
        }

        #btnNext:hover,
        #btnSubmit:hover {
            background: var(--vacancy-gold-hover);
        }


        /* =========================================================
        JOB BUILDER
        ========================================================= */

        .job-builder {
            background: var(--builder-bg);
            border: 1px solid var(--builder-border);
            border-radius: 16px;
            padding: 24px;
        }


        /* =========================================================
        BUILDER HEADER
        ========================================================= */

        .builder-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .builder-title {
            color: var(--builder-text);
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .builder-subtitle {
            color: var(--builder-text-secondary);
            font-size: 13px;
        }


        /* =========================================================
        BUILDER INPUT
        ========================================================= */

        .builder-input {
            margin-bottom: 20px;
        }

        .builder-input .input-group {
            background: var(--builder-input-bg);
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid var(--builder-border);
        }

        .builder-input .input-group-text {
            background: var(--builder-input-bg);
            border: none;
            color: var(--builder-text-secondary);
        }

        .builder-input input {
            background: var(--builder-input-bg);
            border: none;
            color: var(--builder-text);
            height: 54px;
        }

        .builder-input input::placeholder {
            color: var(--builder-text-muted);
        }

        .builder-input input:focus {
            background: var(--builder-input-bg);
            color: var(--builder-text);
            box-shadow: none;
        }

        .builder-input .btn {
            border-radius: 0;
            padding: 0 24px;
            font-weight: 600;
        }


        /* =========================================================
        BUILDER LIST
        ========================================================= */

        .builder-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }


        /* =========================================================
        BUILDER ITEM
        ========================================================= */

        .builder-item {
            display: flex;
            align-items: center;
            justify-content: space-between;

            background: var(--builder-item-bg);
            border: 1px solid var(--builder-border-soft);
            border-radius: 14px;

            padding: 16px 18px;
            transition: .25s;
        }

        .builder-item:hover {
            border-color: var(--builder-gold);
        }


        /* =========================================================
        BUILDER LEFT
        ========================================================= */

        .builder-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }


        /* =========================================================
        BUILDER NUMBER
        ========================================================= */

        .builder-number {
            width: 34px;
            height: 34px;

            border-radius: 50%;

            background: var(--builder-gold-soft);
            border: 1px solid rgba(199, 147, 43, .40);

            color: var(--builder-gold-light);

            display: flex;
            align-items: center;
            justify-content: center;

            font-weight: 700;
            flex-shrink: 0;
        }


        /* =========================================================
        BUILDER TEXT
        ========================================================= */

        .builder-text {
            color: var(--builder-text);
            font-size: 15px;
            line-height: 1.5;
        }


        /* =========================================================
        BUILDER ACTION
        ========================================================= */

        .builder-action {
            display: flex;
            gap: 8px;
        }

        .builder-action button {
            width: 38px;
            height: 38px;

            border: none;
            border-radius: 10px;

            background: var(--builder-action-bg);
            color: var(--builder-text-secondary);

            transition: .25s;
        }

        .builder-action button:hover {
            background: var(--builder-gold);
            color: #fff;
        }


        /* =========================================================
        BUILDER EMPTY
        ========================================================= */

        .builder-empty {
            text-align: center;
            padding: 50px 20px;

            border: 2px dashed var(--builder-border);
            border-radius: 14px;

            color: var(--builder-text-muted);
        }

        .builder-empty h6 {
            color: var(--builder-text);
            margin-top: 10px;
        }


        /* =========================================================
        SECTION CARD
        ========================================================= */

        .section-card {
            padding: 30px;
        }

        .section-title {
            color: var(--vacancy-text);
            font-size: 24px;
            font-weight: 700;
        }

        .section-subtitle {
            color: var(--vacancy-text-secondary);
            margin-top: 5px;
            margin-bottom: 35px;
        }


        /* =========================================================
        OPTION GROUP
        ========================================================= */

        .option-group {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }


        /* =========================================================
        OPTION CARD
        ========================================================= */

        .option-card {
            min-width: 140px;
            height: 52px;

            border-radius: 14px;
            border: 1px solid var(--option-border);

            background: var(--option-bg);
            color: var(--option-text);

            display: flex;
            justify-content: center;
            align-items: center;

            cursor: pointer;
            transition: .25s;

            font-size: 15px;
            font-weight: 600;
        }

        .option-card input {
            display: none;
        }

        .option-card:hover {
            border-color: var(--builder-gold);
            color: var(--vacancy-text);
        }

        .option-card.active {
            background: var(--builder-gold-soft);
            color: var(--builder-gold-light);
            border-color: var(--builder-gold);
        }


        /* =========================================================
        CERTIFICATE / COMPETENCY SCHEME
        ========================================================= */

        .certificate-group,
        .competency-scheme-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }


        /* =========================================================
        CERTIFICATE ITEM
        ========================================================= */

        .certificate-item,
        .competency-scheme-item {
            padding: 14px 22px;

            border: 1px solid var(--certificate-border);
            border-radius: 14px;

            background: var(--certificate-bg);
            color: var(--certificate-text);

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
            color: var(--vacancy-text);
        }

        .certificate-item.active,
        .competency-scheme-item.active {
            background: rgba(214, 161, 59, .12);
            border-color: #d6a13b;
            color: #ffc84d;
            box-shadow: 0 0 15px rgba(214, 161, 59, .12);
        }


        /* =========================================================
        VALIDATION
        ========================================================= */

        .invalid-feedback {
            display: block;
            margin-top: 6px;
            font-size: 13px;
            color: var(--danger);
        }

        .is-invalid {
            border-color: var(--danger) !important;
        }


        /* =========================================================
        RESPONSIVE
        ========================================================= */

        @media (max-width: 768px) {

            .vacancy-step {
                padding: 0 16px;
                height: 46px;
                font-size: 14px;
            }

            .vacancy-step i {
                font-size: 16px;
            }

            #btnBack,
            #btnDraft,
            #btnNext,
            #btnSubmit {
                min-width: auto;
                flex: 1;
            }

            .card-footer {
                display: flex;
                gap: 10px;
                flex-wrap: wrap;
            }


            .builder-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .builder-action {
                width: 100%;
                justify-content: flex-end;
            }


            .section-card {
                padding: 20px;
            }

            .section-title {
                font-size: 21px;
            }

            .section-subtitle {
                margin-bottom: 25px;
            }


            .option-card {
                min-width: 120px;
                flex: 1;
            }


            .certificate-item,
            .competency-scheme-item {
                padding: 12px 16px;
            }
        }
    </style>
@endsection

@section('breadcrumb')
    <h1
        class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
        Lowongan Anda</h1>
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
            <a href="{{ route('dashboard-user.job-vacancy.index') }}" class="text-muted text-hover-primary">Lowongan Anda</a>
        </li>
        <!--end::Item-->
        <!--end::Item-->
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-500 w-5px h-2px"></span>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <a href="javascript:;" class="text-muted text-hover-primary ms-2">Edit</a>
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
                Edit Lowongan
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

            <fieldset @disabled($data->isCurrentlyPublished())>
            @csrf
            @method('PUT')

            <div class="p-10">

                <!-- ========================= -->

                <section id="step0" class="vacancy-section">

                    <div class="row">

                        {{-- KATEGORI LOWONGAN --}}
                        <div class="col-md-12 mb-7">

                            <label class="form-label required">
                                Lowongan Untuk
                            </label>

                            <select
                                name="category"
                                id="category"
                                class="form-select form-control-dark"
                                required>

                                <option value="">Pilih Kategori Lowongan</option>

                                <option
                                    value="security"
                                    {{ old('category', $data->category) == 'security' ? 'selected' : '' }}>
                                    Satpam
                                </option>

                                <option
                                    value="cs"
                                    {{ old('category', $data->category) == 'cs' ? 'selected' : '' }}>
                                    Cleaning Service
                                </option>

                            </select>

                            <small class="text-muted">
                                Pilih kategori lowongan terlebih dahulu.
                            </small>

                        </div>

                        {{-- POSISI PEKERJAAN --}}
                        <div class="col-md-12 mb-7">

                            <label class="form-label required">
                                Posisi Pekerjaan
                            </label>

                            <select
                                name="position"
                                id="position"
                                class="form-select form-control-dark"
                                disabled>

                                <option value="">
                                    Memuat posisi pekerjaan...
                                </option>

                            </select>

                            <small class="text-muted">
                                Pilih posisi pekerjaan yang tersedia.
                            </small>

                        </div>



                        <!-- Status Urgent -->

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
                                    {{ old('is_urgent', $data->is_urgent) ? 'checked' : '' }}
                                >

                                <label class="form-check-label" for="is_urgent">
                                    Tandai sebagai Lowongan Urgent
                                </label>

                            </div>

                            <div class="form-text">
                                Lowongan urgent akan ditampilkan dengan tanda khusus agar lebih mudah
                                diperhatikan pencari kerja.
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
                                placeholder="Jelaskan gambaran umum pekerjaan">{{ old('description_work', $data->description_work) }}</textarea>

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
                                            placeholder="Contoh : Melaksanakan patroli rutin"
                                        >

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
                                    id="responsibilityJson"
                                    value="{{ old('responsibility', $data->responsibility) }}">

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
                                    id="facilityJson"
                                    value="{{ old('facility',$data->facility) }}">

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
                                        value="{{ old('kuota',$data->kuota) }}"
                                        class="form-control form-control-dark"
                                        placeholder="Jumlah">

                                </div>

                            </div>




                            <!-- Total Dilihat -->

                            <div class="col-md-4 mb-7">

                                <label class="form-label">
                                    Total Dilihat
                                </label>

                                <input
                                type="text"
                                class="form-control form-control-dark"
                                value="{{ number_format($data->total_clicked ?? 0) }} Kali"
                                disabled>

                                <small class="text-muted">
                                    Akan bertambah otomatis setelah dipublikasikan.
                                </small>

                            </div>

                        </div>


                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-warning" role="note">
                                    @if($data->isCurrentlyPublished())
                                        Lowongan ini sedang tayang sampai {{ $data->publication_expires_at->format('d M Y H:i') }}. Edit dinonaktifkan selama tayang.
                                    @else
                                        Publikasi atau publikasi ulang memerlukan {{ number_format($settings->job_post_tokens, 0, ',', '.') }} token dan tayang selama {{ number_format($settings->job_post_days, 0, ',', '.') }} hari.
                                    @endif
                                </div>
                            </div>
                        </div>


                        <!-- Info -->

                        <div class="col-12">

                            <div class="alert alert-primary d-flex">

                                <i class="fas fa-info-circle me-3 fs-2"></i>

                                <div>

                                    <div class="fw-bold">

                                        Perubahan Lowongan

                                    </div>

                                    <div>

                                        Setelah perubahan disimpan, status lowongan akan mengikuti status yang dipilih. Apabila diajukan kembali, lowongan akan menunggu proses review Admin.

                                    </div>

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
                                            $province = \Laravolt\Indonesia\Models\Province::where('name', $data->province)->first();
                                            $city      = \Laravolt\Indonesia\Models\City::where('name', $data->city)->first();
                                            $district = \Laravolt\Indonesia\Models\District::where('name', $data->district)
                                                ->where('city_code', $city?->code)
                                                ->first();
                                            $village = \Laravolt\Indonesia\Models\Village::where('name', $data->village)
                                            ->where('district_code', $district?->code)
                                            ->first();
                                            $address = $data->address;
                                        @endphp
                                        <option
                                            value="{{ $data_province->code }}"
                                            {{ old('province', $province->code ?? '')== $data_province->code ? 'selected':'' }}>

                                            {{ $data_province->name }}

                                        </option>
                                    @else
                                        @php
                                            $province = \Laravolt\Indonesia\Models\Province::where('name',$data->province)->first();
                                            $city      = \Laravolt\Indonesia\Models\City::where('name', $data->city)->first();
                                            $district = \Laravolt\Indonesia\Models\District::where('name', $data->district)
                                                ->where('city_code', $city?->code)
                                                ->first();
                                            $village = \Laravolt\Indonesia\Models\Village::where('name',$data->village)
                                            ->where('district_code', $district?->code)
                                            ->first();
                                            $address = $data->address;
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

                        <div class="col-md-6 mb-5">

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

                        </div>

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

                        <div class="row">

                            <!-- Jenis Pekerjaan -->

                            <div class="col-md-12">

                                <label class="form-label required">

                                    Jenis Pekerjaan

                                </label>

                                <div class="option-group">

                                    <label class="option-card {{ old('working_type',$data->working_type)=='permanent' ? 'active' : '' }}">

                                        <input
                                            type="radio"
                                            name="working_type"
                                            value="permanent"
                                            {{ old('working_type',$data->working_type)=='permanent' ? 'checked' : '' }}>

                                        Tetap

                                    </label>

                                    <label class="option-card {{ old('working_type',$data->working_type)=='contract' ? 'active' : '' }}">

                                        <input
                                            type="radio"
                                            name="working_type"
                                            value="contract"
                                            {{ old('working_type',$data->working_type)=='contract' ? 'checked' : '' }}>

                                        Kontrak

                                    </label>

                                    <label class="option-card {{ old('working_type',$data->working_type)=='internship' ? 'active' : '' }}">

                                        <input
                                            type="radio"
                                            name="working_type"
                                            value="internship"
                                            {{ old('working_type',$data->working_type)=='internship' ? 'checked' : '' }}>

                                        Magang

                                    </label>

                                    <label class="option-card {{ old('working_type',$data->working_type)=='freelance' ? 'active' : '' }}">

                                        <input
                                            type="radio"
                                            name="working_type"
                                            value="freelance"
                                            {{ old('working_type',$data->working_type)=='freelance' ? 'checked' : '' }}>

                                        Freelance

                                    </label>

                                </div>

                            </div>


                            <!-- Sistem Kerja -->

                            <div class="col-md-12">

                                <label class="form-label required mt-8">

                                    Sistem Kerja

                                </label>

                                <div class="option-group">

                                    <label class="option-card {{ old('working_system',$data->working_system)=='shift' ? 'active' : '' }}">

                                        <input
                                            type="radio"
                                            name="working_system"
                                            value="shift"
                                            {{ old('working_system',$data->working_system)=='shift' ? 'checked' : '' }}>

                                        Shift

                                    </label>

                                    <label class="option-card {{ old('working_system',$data->working_system)=='non-shift' ? 'active' : '' }}">

                                        <input
                                            type="radio"
                                            name="working_system"
                                            value="non-shift"
                                            {{ old('working_system',$data->working_system)=='non-shift' ? 'checked' : '' }}>

                                        Non Shift

                                    </label>
                                    <label class="option-card {{ old('working_system', $data->working_system) == 'reliever' ? 'active' : '' }}">

                                        <input
                                            type="radio"
                                            name="working_system"
                                            value="reliever"
                                            {{ old('working_system', $data->working_system) == 'reliever' ? 'checked' : '' }}>

                                        Reliever

                                    </label>

                                </div>

                            </div>

                        </div>

                    </section>

                <!-- ========================= -->

                <section id="step3"
                    class="vacancy-section d-none">

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
                                    {{ old('is_show_fee',$data->is_show_fee) ? 'checked' : '' }}>

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

                                <label class="option-card {{ old('fee_type',$data->fee_type)=='monthly' ? 'active' : '' }}">

                                    <input
                                        type="radio"
                                        name="fee_type"
                                        value="monthly"
                                        {{ old('fee_type',$data->fee_type)=='monthly' ? 'checked' : '' }}>

                                    Bulanan

                                </label>

                                <label class="option-card {{ old('fee_type',$data->fee_type)=='daily' ? 'active' : '' }}">

                                    <input
                                        type="radio"
                                        name="fee_type"
                                        value="daily"
                                        {{ old('fee_type',$data->fee_type)=='daily' ? 'checked' : '' }}>

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
                                value="{{ old('min_price',$data->min_price) }}"
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
                                value="{{ old('max_price', $data->max_price) }}"
                                placeholder="Contoh : 6.000.000">

                        </div>

                    </div>

                </section>

                <!-- ========================= -->

                <section id="step4"
                    class="vacancy-section d-none">


                    <div class="row">


                        <!-- =========================================================
                            JENIS KELAMIN
                        ========================================================== -->

                        <div class="col-lg-12 mb-8">

                            <label class="form-label">
                                Jenis Kelamin
                            </label>

                            <div class="option-group">


                                <label class="option-card {{ old('gender', $data->gender) == '' ? 'active' : '' }}">

                                    <input
                                        type="radio"
                                        name="gender"
                                        value=""
                                        {{ old('gender', $data->gender) == '' ? 'checked' : '' }}>

                                    Semua

                                </label>


                                <label class="option-card {{ old('gender', $data->gender) == 'laki-laki' ? 'active' : '' }}">

                                    <input
                                        type="radio"
                                        name="gender"
                                        value="laki-laki"
                                        {{ old('gender', $data->gender) == 'laki-laki' ? 'checked' : '' }}>

                                    Laki-laki

                                </label>


                                <label class="option-card {{ old('gender', $data->gender) == 'perempuan' ? 'active' : '' }}">

                                    <input
                                        type="radio"
                                        name="gender"
                                        value="perempuan"
                                        {{ old('gender', $data->gender) == 'perempuan' ? 'checked' : '' }}>

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
                                value="{{ old('min_age', $data->min_age) }}"
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
                                value="{{ old('max_age', $data->max_age) }}"
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
                                value="{{ old('min_height', $data->min_height) }}"
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
                                value="{{ old('max_height', $data->max_height) }}"
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
                                value="{{ old('min_weight', $data->min_weight) }}"
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
                                value="{{ old('max_weight', $data->max_weight) }}"
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


                                <option
                                    value=""
                                    {{ old('last_education', $data->last_education) == '' ? 'selected' : '' }}>

                                    Tidak ditentukan

                                </option>


                                <option
                                    value="SD"
                                    {{ old('last_education', $data->last_education) == 'SD' ? 'selected' : '' }}>

                                    SD

                                </option>


                                <option
                                    value="SMP"
                                    {{ old('last_education', $data->last_education) == 'SMP' ? 'selected' : '' }}>

                                    SMP

                                </option>


                                <option
                                    value="SMA / SMK"
                                    {{ old('last_education', $data->last_education) == 'SMA / SMK' ? 'selected' : '' }}>

                                    SMA / SMK

                                </option>


                                <option
                                    value="D1"
                                    {{ old('last_education', $data->last_education) == 'D1' ? 'selected' : '' }}>

                                    D1

                                </option>


                                <option
                                    value="D2"
                                    {{ old('last_education', $data->last_education) == 'D2' ? 'selected' : '' }}>

                                    D2

                                </option>


                                <option
                                    value="D3"
                                    {{ old('last_education', $data->last_education) == 'D3' ? 'selected' : '' }}>

                                    D3

                                </option>


                                <option
                                    value="D4"
                                    {{ old('last_education', $data->last_education) == 'D4' ? 'selected' : '' }}>

                                    D4

                                </option>


                                <option
                                    value="S1"
                                    {{ old('last_education', $data->last_education) == 'S1' ? 'selected' : '' }}>

                                    S1

                                </option>


                                <option
                                    value="S2"
                                    {{ old('last_education', $data->last_education) == 'S2' ? 'selected' : '' }}>

                                    S2

                                </option>


                                <option
                                    value="S3"
                                    {{ old('last_education', $data->last_education) == 'S3' ? 'selected' : '' }}>

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
                                value="{{ old('min_experience', $data->min_experience) }}"
                                placeholder="0"
                                min="0">

                        </div>


                    </div>

                </section>

                <!-- ========================= -->

                <section id="step5" class="vacancy-section d-none">

                    <div class="row">

                        {{-- SERTIFIKASI WAJIB --}}
                        <div class="col-lg-12 mb-8">

                            <label class="form-label required">
                                Sertifikasi Wajib
                            </label>

                            <div class="text-muted mb-5">
                                Pilih sertifikat yang wajib dimiliki pelamar.
                            </div>

                            <div class="certificate-group">
                                <div class="text-muted">
                                    Memuat sertifikat berdasarkan kategori lowongan...
                                </div>
                            </div>

                            <input
                                type="hidden"
                                id="certificate_json"
                                name="certificate"
                                value="{{ old('certificate', $data->certificate) }}">

                        </div>

                        {{-- KOMPETENSI SKEMA --}}
                        <div class="col-lg-12 mt-8" id="competencySchemeSection">

                            <label class="form-label required">
                                Kompetensi Skema
                            </label>

                            <div class="text-muted mb-5">
                                Pilih kompetensi skema yang wajib dimiliki pelamar.
                            </div>

                            <div class="competency-scheme-group">
                                <div class="text-muted">
                                    Memuat kompetensi skema...
                                </div>
                            </div>

                            <input
                                type="hidden"
                                id="competency_scheme_json"
                                name="competency_scheme"
                                value="{{ old('competency_scheme', $data->competency_scheme) }}">

                        </div>

                    </div>

                </section>

            </div>

            </fieldset>
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

        @if($data->isCurrentlyPublished())
            <form method="POST" action="{{ route('dashboard-user.job-vacancy.close-publication', $data->uuid) }}">
                @csrf
                <button type="submit" class="btn btn-outline-secondary">Hentikan masa tayang</button>
            </form>
        @else
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
                type="button"
                id="btnSubmit"
                class="btn btn-warning d-none">

                <i class="fas fa-paper-plane me-2"></i>

                Terbitkan lowongan

            </button>

        </div>
        @endif

    </div>

</div>    

<div class="modal fade" id="cancelModal" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header border-0">

                <h5 class="modal-title">

                    Batalkan Perubahan Lowongan?

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

                    Perubahan yang belum disimpan akan <b>hilang</b> apabila keluar dari halaman ini.

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

        /*==============================================================
        | RESPONSIBILITY - EDIT
        ==============================================================*/

        let responsibilityItems = [];
        let facilityItems = [];

        // Muat fasilitas/benefit yang sudah tersimpan.
        $(document).ready(function () {

            let oldFacility = $("#facilityJson").val();

            if (oldFacility) {
                try {
                    let parsedFacility = JSON.parse(oldFacility);
                    facilityItems = Array.isArray(parsedFacility) ? parsedFacility : [];
                } catch (error) {
                    console.error("Gagal membaca facility:", error);
                    facilityItems = [];
                }
            }

            renderFacility();

        });


        /*
        |--------------------------------------------------------------------------
        | LOAD DATA DARI DATABASE
        |--------------------------------------------------------------------------
        */

        $(document).ready(function () {

            let oldResponsibility = $("#responsibilityJson").val();

            /*
            |--------------------------------------------------------------------------
            | Decode JSON dari database
            |--------------------------------------------------------------------------
            */

            if (oldResponsibility) {

                try {

                    let parsed = JSON.parse(oldResponsibility);

                    /*
                    | Pastikan hasilnya array
                    */

                    if (Array.isArray(parsed)) {

                        responsibilityItems = parsed;

                    } else {

                        responsibilityItems = [];

                    }

                } catch (error) {

                    console.error(
                        "Gagal membaca responsibility:",
                        error
                    );

                    responsibilityItems = [];

                }

            }


            /*
            |--------------------------------------------------------------------------
            | Render pertama kali
            |--------------------------------------------------------------------------
            */

            renderResponsibility();


            /*
            |--------------------------------------------------------------------------
            | TAMBAH RESPONSIBILITY
            |--------------------------------------------------------------------------
            */

            $("#btnAddResponsibility").on(
                "click",
                function () {

                    let value = $("#responsibilityInput")
                        .val()
                        .trim();


                    if (value === "") {

                        Swal.fire({
                            icon: "warning",
                            title: "Perhatian",
                            text: "Tanggung jawab belum diisi."
                        });

                        return;

                    }


                    /*
                    | Tambahkan ke array
                    */

                    responsibilityItems.push(value);


                    /*
                    | Kosongkan input
                    */

                    $("#responsibilityInput")
                        .val("")
                        .focus();


                    /*
                    | Render ulang
                    */

                    renderResponsibility();

                }
            );


            /*
            |--------------------------------------------------------------------------
            | ENTER UNTUK TAMBAH
            |--------------------------------------------------------------------------
            */

            $("#responsibilityInput").on(
                "keypress",
                function (e) {

                    if (e.which === 13) {

                        e.preventDefault();

                        $("#btnAddResponsibility")
                            .trigger("click");

                    }

                }
            );

        });


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
            | Jika kosong
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
            | Jika ada data
            |--------------------------------------------------------------------------
            */

            else {

                $.each(
                    responsibilityItems,
                    function (i, item) {

                        /*
                        |--------------------------------------------------------------------------
                        | Escape HTML
                        |--------------------------------------------------------------------------
                        */

                        let safeItem = $("<div>")
                            .text(item)
                            .html();


                        html += `

                            <div class="builder-item">

                                <div class="builder-left">

                                    <div class="builder-number">

                                        ${i + 1}

                                    </div>


                                    <div class="builder-text">

                                        ${safeItem}

                                    </div>

                                </div>


                                <div class="builder-action">

                                    <button
                                        type="button"
                                        onclick="moveResponsibilityUp(${i})"
                                        title="Naik">

                                        ↑

                                    </button>


                                    <button
                                        type="button"
                                        onclick="moveResponsibilityDown(${i})"
                                        title="Turun">

                                        ↓

                                    </button>


                                    <button
                                        type="button"
                                        onclick="editResponsibility(${i})"
                                        title="Edit">

                                        <i class="ki-duotone ki-pencil"></i>

                                    </button>


                                    <button
                                        type="button"
                                        onclick="deleteResponsibility(${i})"
                                        title="Hapus">

                                        <i class="ki-duotone ki-trash"></i>

                                    </button>

                                </div>

                            </div>

                        `;

                    }
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Masukkan HTML
            |--------------------------------------------------------------------------
            */

            $("#responsibilityList")
                .html(html);


            /*
            |--------------------------------------------------------------------------
            | Update hidden JSON
            |--------------------------------------------------------------------------
            */

            $("#responsibilityJson")
                .val(
                    JSON.stringify(responsibilityItems)
                );

        }


        /*
        |--------------------------------------------------------------------------
        | EDIT ITEM
        |--------------------------------------------------------------------------
        */

        function editResponsibility(index)
        {

            let current =
                responsibilityItems[index];


            let text =
                prompt(
                    "Edit Tanggung Jawab",
                    current
                );


            /*
            |--------------------------------------------------------------------------
            | Cancel
            |--------------------------------------------------------------------------
            */

            if (text === null) {

                return;

            }


            text = text.trim();


            /*
            |--------------------------------------------------------------------------
            | Validasi kosong
            |--------------------------------------------------------------------------
            */

            if (text === "") {

                Swal.fire({
                    icon: "warning",
                    title: "Perhatian",
                    text: "Tanggung jawab tidak boleh kosong."
                });

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | Update
            |--------------------------------------------------------------------------
            */

            responsibilityItems[index] =
                text;


            renderResponsibility();

        }


        /*
        |--------------------------------------------------------------------------
        | DELETE
        |--------------------------------------------------------------------------
        */

        function deleteResponsibility(index)
        {

            Swal.fire({

                icon: "warning",

                title: "Hapus tanggung jawab?",

                text: "Tanggung jawab ini akan dihapus.",

                showCancelButton: true,

                confirmButtonText: "Ya, Hapus",

                cancelButtonText: "Batal",

                confirmButtonColor: "#dc3545"

            }).then(function (result) {

                if (!result.isConfirmed) {

                    return;

                }


                responsibilityItems.splice(
                    index,
                    1
                );


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

            if (index <= 0) {

                return;

            }


            let temp =
                responsibilityItems[index - 1];


            responsibilityItems[index - 1] =
                responsibilityItems[index];


            responsibilityItems[index] =
                temp;


            renderResponsibility();

        }


        /*
        |--------------------------------------------------------------------------
        | MOVE DOWN
        |--------------------------------------------------------------------------
        */

        function moveResponsibilityDown(index)
        {

            if (
                index >=
                responsibilityItems.length - 1
            ) {

                return;

            }


            let temp =
                responsibilityItems[index + 1];


            responsibilityItems[index + 1] =
                responsibilityItems[index];


            responsibilityItems[index] =
                temp;


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
                if (!district) {
                    $("#village").prop("disabled", true).html('<option value="">Pilih kecamatan terlebih dahulu</option>');
                    return;
                }

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

            let show = $(this).is(":checked");

            $("#min_price").prop("readonly", !show);
            $("#max_price").prop("readonly", !show);

            $(".fee-wrapper").toggleClass("opacity-50", !show);

        });

        $(".money").on("keyup",function(){

            let angka=$(this).val().replace(/\D/g,'');

            angka=angka.replace(/\B(?=(\d{3})+(?!\d))/g,".");

            $(this).val(angka);

        });

        /*
            |--------------------------------------------------------------------------
            | CERTIFICATE
            |--------------------------------------------------------------------------
            */

            function generateCertificateJSON() {

                let certificate = [];

                $(".certificate-item[data-type='certificate'].active")
                    .each(function () {

                        certificate.push(
                            $(this).data("value")
                        );

                    });

                $("#certificate_json").val(
                    JSON.stringify(certificate)
                );

            }


            /*
            |--------------------------------------------------------------------------
            | COMPETENCY SCHEME
            |--------------------------------------------------------------------------
            */

            function generateCompetencySchemeJSON() {

                let competencyScheme = [];

                $(".certificate-item[data-type='competency'].active")
                    .each(function () {

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
            | CLICK CERTIFICATE
            |--------------------------------------------------------------------------
            */

            $(document).on(
                "click",
                ".certificate-item[data-type='certificate']",
                function () {

                    $(this).toggleClass("active");

                    generateCertificateJSON();

                }
            );


            /*
            |--------------------------------------------------------------------------
            | CLICK COMPETENCY
            |--------------------------------------------------------------------------
            */

            $(document).on(
                "click",
                ".certificate-item[data-type='competency']",
                function () {

                    $(this).toggleClass("active");

                    generateCompetencySchemeJSON();

                }
            );


            /*
            |--------------------------------------------------------------------------
            | INITIALIZE
            |--------------------------------------------------------------------------
            */

            generateCertificateJSON();

            generateCompetencySchemeJSON();

        $(function () {

            //-----------------------------------------
            // Publish
            //-----------------------------------------

            $("#formCreateJobVacancy").submit(function(e){

                e.preventDefault();

                submitJob("publish");

            });


            //-----------------------------------------
            // Draft
            //-----------------------------------------

            $("#btnDraft").click(function(){

                submitJob("save_draft");

            });

            $("#btnSubmit").click(function(){

                submitJob("publish");

            });


            //-----------------------------------------
            // Function Submit
            //-----------------------------------------

            function submitJob(status){

                let formData = new FormData($("#formCreateJobVacancy")[0]);

                formData.append("workflow_action", status);

                $("#btnSubmit").prop("disabled",true);
                $("#btnDraft").prop("disabled",true);

                $.ajax({

                    url: "{{ route('dashboard-user.job-vacancy.update', $data->uuid) }}",
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

        /* ==========================================================
           FEE VISIBILITY
        ========================================================== */

        function toggleFee() {

            let show = $("#is_show_fee").is(":checked");

            $("#min_price").prop("readonly", !show);
            $("#max_price").prop("readonly", !show);

            $(".fee-wrapper").toggleClass("opacity-50", !show);

        }

        toggleFee();

        $("#is_show_fee").on("change", toggleFee);


        /* ==========================================================
           OPTION CARD
        ========================================================== */

        $(document).on("change", 'input[type="radio"]', function () {

            const name = $(this).attr("name");

            $('input[name="' + name + '"]')
                .closest(".option-card")
                .removeClass("active");

            $(this)
                .closest(".option-card")
                .addClass("active");

        });


        /* ==========================================================
           FORMAT GAJI
        ========================================================== */

        $(document).on("keyup", ".money", function () {

            let angka = $(this).val().replace(/\D/g, "");
            angka = angka.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            $(this).val(angka);

        });


        /* ==========================================================
           JSON HELPERS
        ========================================================== */

        function parseJsonArray(value) {

            if (!value) return [];

            try {
                let parsed = JSON.parse(value);
                return Array.isArray(parsed) ? parsed : [];
            } catch (error) {
                return [];
            }

        }

        let selectedCertificates = parseJsonArray($("#certificate_json").val());
        let selectedCompetencySchemes = parseJsonArray($("#competency_scheme_json").val());


        function updateCertificateJSON() {
            $("#certificate_json").val(JSON.stringify(selectedCertificates));
        }

        function updateCompetencySchemeJSON() {
            $("#competency_scheme_json").val(JSON.stringify(selectedCompetencySchemes));
        }


        /* ==========================================================
           CERTIFICATE / COMPETENCY CLICK
        ========================================================== */

        $(document).on("click", ".certificate-item[data-type='certificate']", function () {

            let value = String($(this).data("value"));

            if (selectedCertificates.includes(value)) {
                selectedCertificates = selectedCertificates.filter(item => item !== value);
            } else {
                selectedCertificates.push(value);
            }

            $(this).toggleClass("active", selectedCertificates.includes(value));
            updateCertificateJSON();

        });

        $(document).on("click", ".competency-scheme-item", function () {

            let value = String($(this).data("value"));

            if (selectedCompetencySchemes.includes(value)) {
                selectedCompetencySchemes = selectedCompetencySchemes.filter(item => item !== value);
            } else {
                selectedCompetencySchemes.push(value);
            }

            $(this).toggleClass("active", selectedCompetencySchemes.includes(value));
            updateCompetencySchemeJSON();

        });


        /* ==========================================================
           CATEGORY / MASTER DATA
        ========================================================== */

        function escapeHtml(value) {

            if (value === null || value === undefined) return "";

            return $("<div>").text(value).html();

        }

        function toggleCompetencyScheme(category) {

            if (category === "cs") {
                $("#competencySchemeSection").addClass("d-none");
                selectedCompetencySchemes = [];
                updateCompetencySchemeJSON();
            } else {
                $("#competencySchemeSection").removeClass("d-none");
            }

        }

        function loadCategoryMasterData(category, selectedPosition, preserveSelections) {

            toggleCompetencyScheme(category);

            $("#position")
                .prop("disabled", true)
                .html('<option value="">Memuat posisi pekerjaan...</option>');

            $(".certificate-group").html('<div class="text-muted">Memuat sertifikat...</div>');
            $(".competency-scheme-group").html('<div class="text-muted">Memuat kompetensi skema...</div>');

            if (!category) {
                $("#position").html('<option value="">Pilih kategori lowongan terlebih dahulu</option>');
                $(".certificate-group").html('<div class="text-muted">Pilih kategori lowongan terlebih dahulu.</div>');
                $(".competency-scheme-group").html('<div class="text-muted">Pilih kategori lowongan terlebih dahulu.</div>');
                return;
            }

            $.ajax({
                url: "{{ route('dashboard-user.job-vacancy.master-data') }}",
                type: "GET",
                data: { category: category },

                success: function (response) {

                    let positionHtml = '<option value="">Pilih Posisi Pekerjaan</option>';

                    if (response.positions && response.positions.length) {
                        $.each(response.positions, function (index, position) {
                            positionHtml += `
                                <option value="${escapeHtml(position.title)}"
                                    data-uuid="${escapeHtml(position.uuid)}">
                                    ${escapeHtml(position.title)}
                                </option>
                            `;
                        });
                    } else {
                        positionHtml = '<option value="">Belum ada posisi untuk kategori ini</option>';
                    }

                    $("#position").html(positionHtml).prop("disabled", false);

                    if (selectedPosition) {
                        if ($("#position option").filter(function () {
                            return $(this).val() === selectedPosition;
                        }).length === 0) {
                            $("#position").append(
                                new Option(selectedPosition, selectedPosition, true, true)
                            );
                        }

                        $("#position").val(selectedPosition);
                    }

                    let certificateHtml = "";
                    if (response.master_certificates && response.master_certificates.length) {
                        $.each(response.master_certificates, function (index, certificate) {
                            let value = String(certificate.title);
                            let active = preserveSelections && selectedCertificates.includes(value) ? "active" : "";
                            certificateHtml += `
                                <div class="certificate-item ${active}"
                                    data-type="certificate"
                                    data-value="${escapeHtml(value)}">
                                    <i class="fas fa-shield-alt"></i>
                                    ${escapeHtml(value)}
                                </div>
                            `;
                        });
                    } else {
                        certificateHtml = '<div class="text-muted">Belum ada sertifikat untuk kategori ini.</div>';
                    }
                    $(".certificate-group").html(certificateHtml);

                    let competencyHtml = "";
                    if (response.master_competency_schemes && response.master_competency_schemes.length) {
                        $.each(response.master_competency_schemes, function (index, scheme) {
                            let value = String(scheme.title);
                            let active = preserveSelections && selectedCompetencySchemes.includes(value) ? "active" : "";
                            competencyHtml += `
                                <div class="competency-scheme-item ${active}"
                                    data-value="${escapeHtml(value)}">
                                    <i class="fas fa-award"></i>
                                    ${escapeHtml(value)}
                                </div>
                            `;
                        });
                    } else {
                        competencyHtml = '<div class="text-muted">Belum ada kompetensi skema untuk kategori ini.</div>';
                    }
                    $(".competency-scheme-group").html(competencyHtml);

                    if (category === "cs") {
                        selectedCompetencySchemes = [];
                    }

                    updateCertificateJSON();
                    updateCompetencySchemeJSON();

                },

                error: function (xhr) {
                    console.error("Master Data Error:", xhr.responseText);
                    $("#position").prop("disabled", true).html('<option value="">Gagal memuat posisi</option>');
                    $(".certificate-group").html('<div class="text-danger">Gagal memuat sertifikat.</div>');
                    $(".competency-scheme-group").html('<div class="text-danger">Gagal memuat kompetensi skema.</div>');
                }
            });

        }

        // Ketika kategori diganti manual, reset pilihan sertifikat dan posisi.
        $("#category").on("change", function () {

            selectedCertificates = [];
            selectedCompetencySchemes = [];
            updateCertificateJSON();
            updateCompetencySchemeJSON();

            loadCategoryMasterData($(this).val(), "", false);

        });


        /* ==========================================================
           POSITION MASTER DETAIL
        ========================================================== */

        $("#position").on("change", function () {

            let uuid = $(this).find(":selected").data("uuid");
            if (!uuid) return;

            $("#description_work").val("Memuat deskripsi pekerjaan...");
            $(this).prop("disabled", true);

            $.ajax({
                url: "{{ url('dashboard-user/job-vacancy/position') }}/" + uuid,
                type: "GET",
                data: { category: $("#category").val() },

                success: function (response) {

                    if (!response.status) return;

                    let data = response.data || {};
                    $("#description_work").val(data.description || "");

                    let responsibilities = data.responsibility || [];
                    if (!Array.isArray(responsibilities)) {
                        try { responsibilities = JSON.parse(responsibilities); }
                        catch (error) { responsibilities = []; }
                    }

                    responsibilityItems = [];
                    responsibilities.forEach(function (item) {
                        if (item !== null && item !== undefined && String(item).trim() !== "") {
                            responsibilityItems.push(String(item));
                        }
                    });

                    renderResponsibility();

                },

                error: function (xhr) {
                    console.error("Position Detail Error:", xhr.responseText);
                },

                complete: function () {
                    $("#position").prop("disabled", false);
                }
            });

        });


        /* ==========================================================
           INITIALIZE EDIT DATA
        ========================================================== */

        let initialCategory = @json(old('category', $data->category));
        let initialPosition = @json(old('position', $data->position));

        loadCategoryMasterData(initialCategory, initialPosition, true);

        updateCertificateJSON();
        updateCompetencySchemeJSON();

    </script>
@endsection
