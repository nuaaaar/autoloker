<style>
    /* ===============================
    UPLOAD LOGO
    ================================= */

    .upload-photo{

        width:200px;
        height:200px;

        border:2px dashed #33415c;
        border-radius:18px;

        overflow:hidden;

        cursor:pointer;

        position:relative;

        background:#10182b;

        display:block;

        transition:.3s;

    }

    .upload-photo:hover{

        border-color:#f7b003;

        transform:translateY(-2px);

        box-shadow:0 10px 30px rgba(247,176,3,.12);

    }

    .upload-placeholder{

        width:100%;
        height:100%;

        display:flex;

        flex-direction:column;

        justify-content:center;

        align-items:center;

        text-align:center;

        color:#8fa0bc;

        background:#151d33;

        transition:.3s;

    }

    .upload-placeholder i{

        color:#f7b003;

    }

    .upload-placeholder div{

        font-size:13px;

        font-weight:600;

        color:#ffffff;

        margin-top:4px;

    }

    .upload-placeholder small{

        margin-top:4px;

        font-size:11px;

        color:#8fa0bc;

    }

    .upload-preview{

        width:100%;

        height:100%;

        position:relative;

        background:#ffffff;

    }

    .upload-preview img{

        width:100%;

        height:100%;

        object-fit:contain;

        padding:16px;

        background:#ffffff;

    }

    .preview-overlay{

        position:absolute;

        inset:0;

        background:rgba(8,13,28,.82);

        display:flex;

        flex-direction:column;

        justify-content:center;

        align-items:center;

        gap:6px;

        color:#ffffff;

        opacity:0;

        transition:.25s;

    }

    .preview-overlay span{

        font-size:12px;

        font-weight:600;

    }

    .upload-preview:hover .preview-overlay{

        opacity:1;

    }

    .upload-file-info{

        padding:12px 16px;

        background:#1b2440;

        border:1px solid #304061;

        border-radius:12px;

    }

    .upload-info{

        margin:0;
        padding-left:18px;

        color:#8fa0bc;

        font-size:12px;

        line-height:1.9;

    }

    .upload-info li{

        margin-bottom:2px;

    }

    @media(max-width:991px){

        .upload-photo{

            width:170px;
            height:170px;

            margin:auto;

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