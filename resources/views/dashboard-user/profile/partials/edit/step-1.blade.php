<style>
    /* =========================================================
       UPLOAD LOGO - THEME VARIABLES
       ========================================================= */

    :root,
    [data-bs-theme="light"] {
        --upload-photo-bg: #f8fafc;
        --upload-photo-border: #cbd5e1;

        --upload-placeholder-bg: #f1f5f9;
        --upload-placeholder-text: #71809a;
        --upload-placeholder-title: #182338;

        --upload-gold: #e8a801;
        --upload-gold-hover: #d99b00;

        --upload-preview-bg: #ffffff;
        --upload-preview-image-bg: #ffffff;

        --upload-overlay: rgba(8, 13, 28, .78);

        --upload-info-bg: #f8fafc;
        --upload-info-border: #dce3eb;
        --upload-info-text: #71809a;

        --upload-shadow: rgba(232, 168, 1, .12);
    }

    [data-bs-theme="dark"] {
        --upload-photo-bg: #10182b;
        --upload-photo-border: #33415c;

        --upload-placeholder-bg: #151d33;
        --upload-placeholder-text: #8fa0bc;
        --upload-placeholder-title: #ffffff;

        --upload-gold: #f7b003;
        --upload-gold-hover: #f7b003;

        --upload-preview-bg: #ffffff;
        --upload-preview-image-bg: #ffffff;

        --upload-overlay: rgba(8, 13, 28, .82);

        --upload-info-bg: #1b2440;
        --upload-info-border: #304061;
        --upload-info-text: #8fa0bc;

        --upload-shadow: rgba(247, 176, 3, .12);
    }


    /* =========================================================
       UPLOAD LOGO
       ========================================================= */

    .upload-photo {
        width: 200px;
        height: 200px;
        border: 2px dashed var(--upload-photo-border);
        border-radius: 18px;
        overflow: hidden;
        cursor: pointer;
        position: relative;
        background: var(--upload-photo-bg);
        display: block;
        transition: .3s;
    }

    .upload-photo:hover {
        border-color: var(--upload-gold);
        transform: translateY(-2px);
        box-shadow: 0 10px 30px var(--upload-shadow);
    }


    /* =========================================================
       PLACEHOLDER
       ========================================================= */

    .upload-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        color: var(--upload-placeholder-text);
        background: var(--upload-placeholder-bg);
        transition: .3s;
    }

    .upload-placeholder i {
        color: var(--upload-gold);
    }

    .upload-placeholder div {
        font-size: 13px;
        font-weight: 600;
        color: var(--upload-placeholder-title);
        margin-top: 4px;
    }

    .upload-placeholder small {
        margin-top: 4px;
        font-size: 11px;
        color: var(--upload-placeholder-text);
    }


    /* =========================================================
       PREVIEW
       ========================================================= */

    .upload-preview {
        width: 100%;
        height: 100%;
        position: relative;
        background: var(--upload-preview-bg);
    }

    .upload-preview img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 16px;
        background: var(--upload-preview-image-bg);
    }


    /* =========================================================
       PREVIEW OVERLAY
       ========================================================= */

    .preview-overlay {
        position: absolute;
        inset: 0;
        background: var(--upload-overlay);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 6px;
        color: #ffffff;
        opacity: 0;
        transition: .25s;
    }

    .preview-overlay span {
        font-size: 12px;
        font-weight: 600;
    }

    .upload-preview:hover .preview-overlay {
        opacity: 1;
    }


    /* =========================================================
       FILE INFO
       ========================================================= */

    .upload-file-info {
        padding: 12px 16px;
        background: var(--upload-info-bg);
        border: 1px solid var(--upload-info-border);
        border-radius: 12px;
    }


    /* =========================================================
       UPLOAD INFO
       ========================================================= */

    .upload-info {
        margin: 0;
        padding-left: 18px;
        color: var(--upload-info-text);
        font-size: 12px;
        line-height: 1.9;
    }

    .upload-info li {
        margin-bottom: 2px;
    }


    /* =========================================================
       RESPONSIVE
       ========================================================= */

    @media (max-width: 991px) {
        .upload-photo {
            width: 170px;
            height: 170px;
            margin: auto;
        }
    }
</style>

<div class="wizard-page active" id="step1">

    <div class="profile-form-card">

        <!-- Header -->

        <div class="form-header mb-8">

            <div class="header-icon">

                <i class="ki-duotone ki-home fs-2 text-warning"></i>

            </div>

            <div>

                <div class="step-label">

                    LANGKAH 1 DARI 4

                </div>

                <h2 class="step-title">

                    Profil Perusahaan

                </h2>

                <div class="step-description">

                    Informasi dasar perusahaan.

                </div>

            </div>

        </div>

        <!-- Upload -->

        <div class="upload-card mb-8">

            <div class="row align-items-center">

                <div class="col-lg-4">

                    <label class="upload-photo">

                        <input
                            type="file"
                            id="photoInput"
                            name="logo"
                            accept=".jpg,.jpeg,.png,.svg,.webp"
                            hidden>

                        @if($data->logo)

                            <div class="upload-preview">

                                <img
                                    id="previewImage"
                                    src="{{ asset('storage/'.$data->logo) }}">

                                <div class="preview-overlay">

                                    <i class="ki-duotone ki-camera fs-2"></i>

                                    <span>Ganti Logo</span>

                                </div>

                            </div>

                        @else

                            <div class="upload-placeholder">

                                <i class="ki-duotone ki-picture fs-1 mb-3"></i>

                                <div>Logo Perusahaan</div>

                                <small>Rasio 1:1</small>

                            </div>

                            <div class="upload-preview d-none">

                                <img id="previewImage">

                                <div class="preview-overlay">

                                    <i class="ki-duotone ki-camera fs-2"></i>

                                    <span>Ganti Logo</span>

                                </div>

                            </div>

                        @endif

                    </label>

                </div>

                <div class="col-lg-8">

                    <h5 class="text-white mb-3">
                        Logo Perusahaan
                    </h5>

                    <p class="text-gray-500 mb-3">
                        Unggah logo resmi perusahaan dengan kualitas yang baik agar tampil optimal pada profil perusahaan dan lowongan kerja.
                    </p>

                    <ul class="upload-info mb-3">

                        <li>Format JPG, PNG, WEBP atau SVG</li>

                        <li>Ukuran maksimal 2 MB</li>

                        <li>Disarankan rasio 1 : 1 (persegi)</li>

                        <li>Resolusi minimal 512 × 512 px</li>

                        <li>Latar belakang transparan lebih disarankan (PNG/SVG)</li>

                    </ul>

                    <div class="upload-file-info d-none">

                        <div class="fw-semibold text-warning" id="fileName"></div>

                        <small class="text-muted" id="fileSize"></small>

                    </div>

                </div>

            </div>

        </div>

        <!-- Form -->

        <div class="row">

            <div class="col-12 mb-5">

                <label class="form-label required">

                    Nama Perusahaan

                </label>

                <div class="input-icon">

                    <i class="ki-duotone ki-home"></i>

                    <input type="text" name="company_name" value="{{ $data->company_name }}" class="form-control auto-input"

                           placeholder="Nama Perusahaan">
                </div>

            </div>

            <div class="col-md-12 mb-5">

                <label class="form-label required">
                    Bidang Usaha
                </label>

                <select class="form-select auto-input" name="industry">
                    @php
                        $master_industries = \App\Models\MasterIndustry::orderBy('title')->get();
                    @endphp
                    <option value="">Pilih bidang usaha..</option>
                    @foreach($master_industries as $industry)
                        <option value="{{ $industry->title }}" {{ $data->industry == $industry->title ? 'selected' : '' }}>{{ $industry->title }}</option>
                    @endforeach

                </select>

            </div>

            <div class="col-12 mb-5">

                <label class="form-label required">

                    Deskripsi Perusahaan

                </label>

                <textarea name="description" class="form-control auto-input"
                placeholder="Deskripsi perusahaan"          
                rows="3">{{ $data->description }}</textarea>

            </div>

        </div>

    </div>

    <div class="wizard-footer">

        <div class="row g-3">

            <div class="col-12 col-md-3">
                <a href="{{ route('dashboard-user.profile.index') }}">
                    <button class="btn btn-profile-secondary w-100 btn-prev-step" type="button">

                        <i class="ki-duotone ki-left me-2"></i>

                        Kembali

                    </button>
                </a>

            </div>

            <div class="col-12 col-md-9">

                <button class="btn-next-step" data-next="2" type="button">

                    Lanjut : Kontak & Alamat

                    <i class="ki-duotone ki-right ms-2"></i>

                </button>

            </div>

        </div>

    </div>

</div>