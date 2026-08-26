<style>
    

    .profile-badge-card{

        background:#11192d;
        border:1px solid rgba(255,255,255,.08);
        border-radius:22px;
        overflow:hidden;
        color:#fff;

    }

    /* HEADER */

    .profile-badge-header{

        padding: 9px 11px;

        display:flex;

        justify-content:space-between;

        align-items:center;

        border-bottom:1px solid rgba(255,255,255,.05);

    }

    .badge-icon{

        width:42px;

        height:42px;

        border-radius:14px;

        background:#192341;

        display:flex;

        align-items:center;

        justify-content:center;

        border:1px solid rgba(232,164,0,.35);

    }

    .badge-title{

        font-size:14px;

        font-weight:700;

        line-height:1.2;

    }

    .badge-subtitle{

        font-size:11px;

        color:#8b99b6;

        margin-top:2px;

    }

    .badge-counter{

        min-width:54px;

        text-align:center;

        padding: 6px 8px;

        background:#1d2a4c;

        border-radius:30px;

        color:#b5c3e2;

        font-size: 10px;

        font-weight:700;

    }

    /* BODY */

    .profile-badge-body{

        margin:18px;

        padding:12px 24px;

        border-radius:20px;

        background:#1b2548;

        border:1px solid rgba(255,255,255,.06);

    }

    .badge-label{

        font-size: 9.5px;

        letter-spacing:1px;

        color:#8090ae;

        font-weight:700;

        margin-bottom:16px;

    }

    .profile-badge-list{

        display:flex;

        gap:12px;

        flex-wrap:wrap;

    }

    .profile-badge-item{

        display:flex;

        align-items:center;

        padding:5px 12px;

        border-radius:14px;

        background:#131d38;

        border:1px solid rgba(232,164,0,.35);

        font-size:11px;

        font-weight:600;

        position:relative;

    }

    .profile-badge-item i{

        font-size:15px;

    }

    .badge-dot{

        width:8px;

        height:8px;

        border-radius:50%;

        background:#ff5d72;

        margin-left:10px;

    }

    .btn-add-badge{

        border:2px dashed rgba(255,255,255,.12);

        background:transparent;

        color:#5d6986;

        border-radius:14px;

        padding: 8px 12px;

        font-size: 11px;

        font-weight:600;

        transition:.25s;

    }

    .btn-add-badge:hover{

        cursor: not-allowed;

    }

    /* FOOTER */

    .profile-badge-footer{

        padding:0 24px 20px;

        color:#90a0bf;

        font-size: 11px;

    }

    .profile-badge-footer b{

        color:#fff;

    }

    .btn-add-certificate{

        background:#e8a400;

        color:#111;

        border:none;

        border-radius: 12px !important;

        padding:10px 22px;

        font-size: 11px !important;

        font-weight:700;

        transition:.25s;

    }

    .btn-add-certificate:hover{

        background:#f2b600;

        transform:translateY(-2px);

    }

    .certificate-wrapper{

        background:#11192d;

        border:1px solid rgba(255,255,255,.06);

        border-radius:22px;

        overflow: visible;

    }


    .certificate-header{

        padding:12px 24px;

        display:flex;

        justify-content:space-between;

        align-items:center;

        border-bottom:1px solid rgba(255,255,255,.05);

    }


    .certificate-heading{

        color:#fff;

        font-size: 14px;

        font-weight:700;

        margin:0;

    }


    .certificate-subtitle{

        margin-top:4px;

        color:#90a0be;

        font-size:11px;

    }


    .certificate-body{

        padding:0;

    }


    .certificate-card{

        display:flex;

        gap:18px;

        padding: 12px 24px;

        border-bottom:1px solid rgba(255,255,255,.05);

        transition:.25s;

    }


    .certificate-card:last-child{

        border-bottom:none;

    }


    .certificate-card:hover{

        background:#18213a;

    }


    .certificate-icon{

        width:36px;

        height:36px;

        border-radius:50%;

        background:rgba(232,164,0,.18);

        border:1px solid rgba(232,164,0,.5);

        display:flex;

        justify-content:center;

        align-items:center;

        flex-shrink:0;

        color:#e8a400;

        transition:.25s ease;

    }

    .certificate-icon i{

        font-size:14px;

    }

    /* Belum dijadikan badge */
    .certificate-icon.empty{

        background:transparent;

        border:1px solid transparent;

        color:rgba(255,255,255,.35);

    }

    .certificate-icon.empty i{

        opacity:.7;

    }


    .certificate-content{

        flex:1;

    }


    .certificate-top{

        display:flex;

        justify-content:space-between;

    }


    .certificate-title{

        font-size:12px;

        font-weight:700;

        color:#fff;

    }


    .certificate-instansi{

        margin-top:3px;

        color:#95a6c4;

        font-size:10px;

    }


    .certificate-badge{

        display:inline-block;

        margin-left:4px;

        background:rgba(232,164,0,.15);

        border:1px solid rgba(232,164,0,.45);

        color:#e8a400;

        padding: 2px 8px;

        border-radius:20px;

        font-size: 9.5px;

    }


    .certificate-status{

        padding: 2px 14px;

        border-radius:30px;

        font-size: 10px;

        height: 50%;

    }


    .certificate-status.expired{

        background:rgba(255,60,60,.12);

        color:#ff6666;

        border:1px solid rgba(255,80,80,.45);

    }

    .certificate-status.active{

        background:rgba(79, 255, 60, 0.12);

        color:#66ff78;

        border:1px solid rgba(80, 255, 95, 0.45);

    }


    .certificate-detail{

        margin-top:10px;

        display:flex;

        gap:15px;

        flex-wrap:wrap;

    }


    .certificate-number{

        padding: 4px 8px;

        border-radius:8px;

        background:#243152;

        color:#90a4d4;

        font-size: 9.5px;

    }


    .certificate-date{

        color:#9cabca;

        font-size:12px;

    }


    .certificate-category{

        margin-top:8px;

        display:inline-block;

        padding:4px 8px;

        border-radius:20px;

        background:#1e2d58;

        color:#92a7d9;

        font-size: 9.5px;

    }


    .certificate-menu{

        width:38px;

        height:38px;

        border:none;

        border-radius:10px;

        background:transparent;

        color:#8c9ab5;

    }


    .certificate-menu:hover{

        background:#263454;

        color:#fff;

    }

    .certificate-menu{

        width:38px;
        height:38px;

        border:none;

        background:transparent;

        border-radius:10px;

        color:#8d9ab5;

        transition:.2s;

    }

    .certificate-menu:hover{

        background:#263454;

        color:#fff;

    }

    .certificate-dropdown{

        /* width:240px; */

        background:#18233b;

        border:1px solid rgba(255,255,255,.08);

        border-radius:16px;

        overflow:hidden;

        padding:8px;

        box-shadow:0 12px 30px rgba(0,0,0,.35);

    }

    .certificate-dropdown .dropdown-item{

        display:flex;

        align-items:center;

        gap:8px;

        color:#d6dceb;

        font-size: 9.5px;

        font-weight:500;

        border-radius:10px;

        padding:6px 7px;

        transition:.2s;

    }

    .certificate-dropdown .dropdown-item:hover{

        background:#23314f;

        color:#fff;

    }

    .certificate-dropdown .dropdown-divider{

        border-color:rgba(255,255,255,.08);

    }

    .certificate-dropdown .text-danger{

        color:#ff6d6d !important;

    }

    .certificate-dropdown .text-danger:hover{

        background:rgba(255,0,0,.08);

    }

    .certificate-modal{

        background:#10182d;

        border:1px solid rgba(255,255,255,.08);

        border-radius:24px;

        color:#fff;

    }

    .certificate-modal-header{

        display:flex;

        justify-content:space-between;

        align-items:center;

        padding: 14px;

        border-bottom:1px solid rgba(255,255,255,.06);

    }

    .certificate-modal-icon{

        width: 34px;

        height:34px;

        border-radius:15px;

        border:1px solid rgba(211,155,25,.35);

        display:flex;

        justify-content:center;

        align-items:center;

        margin-right:10px;

    }

    .certificate-close{

        width:24px;

        height:24px;

        border:none;

        border-radius:50%;

        background:#1b274b;

        color:#8ea0c7;

    }

    .certificate-modal-body{

        padding:18px;

    }

    .form-label-dark{

        font-size:11px;

        font-weight:600;

        margin-bottom:8px;

    }

    .input-dark{

        background:#1d284d;

        border:1px solid rgba(255,255,255,.06);

        border-radius:9px;

        display:flex;

        align-items:center;

        padding:0 16px;

    }

    .input-dark i{

        color:#8ea0c7;

        margin-right:10px;

    }

    .input-dark input{

        background:none;

        border:none;

        color:#fff;

        height:36px;

        font-size: 11px;

    }

    .input-dark input:focus{

        box-shadow:none;

    }

    .input-select-dark,
    .input-date-dark{

        background:#1d284d;

        border:1px solid rgba(255,255,255,.06);

        color:#fff;

        border-radius:9px;

        height:36px;

        font-size: 11px;

    }

    .certificate-upload{

        border:2px dashed rgba(255,255,255,.12);

        border-radius:10px;

        padding: 8px 16px;

        display:flex;

        align-items:center;

        cursor:pointer;

        transition:.25s;

    }

    .certificate-upload:hover{

        border-color:#d39b19;

    }

    .certificate-upload i{

        margin-right:18px;

        color:#8ea0c7;

    }

    .certificate-upload.has-file{
        border-style:solid;
        border-color:#1bc47d;
        background:rgba(27,196,125,.08);
    }

    .certificate-upload.has-file .upload-icon{
        color:#1bc47d;
    }

    .upload-title{
        font-size:13px;
    }

    .upload-subtitle{
        font-size:11px;
        color:#94a3b8;
    }

    .upload-overlay{

        position:absolute;
        inset:0;

        background:rgba(0,0,0,.55);

        color:#fff;

        display:flex;
        align-items:center;
        justify-content:center;

        font-size:13px;
        font-weight:600;

        opacity:0;

        transition:.25s;

        pointer-events:none;

    }

    .certificate-upload.has-file:hover .upload-overlay{

        opacity:1;

    }

    .certificate-upload.has-file:hover{

        border-color:#ffc107;

    }

    .upload-icon i{

        transition:.25s;

    }

    .certificate-modal-footer{

        padding: 16px;

        border-top:1px solid rgba(255,255,255,.06);

        display:flex;

        justify-content:flex-end;

        gap:14px;

    }

    .btn-cancel-certificate{

        width:50%;

        height:34px;

        border-radius:9px;

        background:transparent;

        border:1px solid rgba(255,255,255,.08);

        color:#c8d3ef;

    }

    .btn-save-certificate{

        width:50%;

        height:34px;

        border:none;

        border-radius:9px;

        background:#e8a401;

        color:#fff;

        font-weight:600;

    }

    .form-control:focus {
        background: none;
    }

    .delete-modal{

        background:#11192d;
        border:1px solid rgba(255,255,255,.06);
        border-radius:22px;
        overflow:hidden;
        color:#fff;

    }

    .delete-modal-body{

        padding:34px 32px 20px;
        text-align:center;

    }

    .delete-icon{

        width:32px;
        height:32px;
        margin:auto;
        margin-bottom:22px;

        border-radius:50%;

        display:flex;
        align-items:center;
        justify-content:center;

        background:rgba(255,65,65,.10);
        border:1px solid rgba(255,80,80,.45);

    }

    .delete-icon i{

        color:#ff5b5b;

    }

    .delete-title{

        font-size:14px;
        font-weight:700;
        color:#fff;
        margin-bottom:10px;

    }

    .delete-description{

        font-size:11px;
        line-height:1.6;
        color:#8d9bb7;
        max-width:430px;
        margin:auto;

    }

    .delete-modal-footer{

        display:flex;
        gap:18px;

        padding:12px 16px;

    }

    .btn-delete-cancel{

        flex:1;

        height:30px;

        border-radius:9px;

        background:transparent;

        border:1px solid rgba(255,255,255,.08);

        color:#9fb0cb;

        font-size:12px;

        font-weight:700;

        transition:.25s;

    }

    .btn-delete-cancel:hover{

        background:#1a2440;
        color:#fff;

    }

    .btn-delete-confirm{

        flex:1;

        height:30px;

        border:none;

        border-radius:9px;

        background:#ff2d38;

        color:#fff;

        font-size:12px;

        font-weight:700;

        transition:.25s;

    }

    .btn-delete-confirm:hover{

        background:#ff1b28;

    }

    @media(max-width:768px){

        .delete-modal-body{

            padding:28px 20px 18px;

        }

        .delete-title{

            font-size:22px;

        }

        .delete-description{

            font-size:14px;

        }

        .delete-modal-footer{

            padding:18px 20px 24px;

            gap:12px;

        }

        .btn-delete-cancel,
        .btn-delete-confirm{

            height:50px;
            font-size:16px;

        }

    }

    .certificate-empty{

        padding:50px 30px;

        display:flex;
        flex-direction:column;
        align-items:center;
        justify-content:center;

        text-align:center;

        border:2px dashed rgba(247,176,3,.25);

        border-radius:18px;

        background:#11192d;

    }

    .certificate-empty-icon{

        width: 32px;
        height: 32px;

        display:flex;
        align-items:center;
        justify-content:center;

        border-radius:50%;

        background:rgba(247,176,3,.08);

        margin-bottom:18px;

    }

    .certificate-empty-title{

        color:#fff;

        font-size:16px;

        font-weight:700;

    }

    .certificate-empty-text{

        max-width:480px;

        margin-top:10px;

        color:#8fa0bc;

        font-size:12px;

        line-height:1.8;

    }
</style>

<div class="certificate-wrapper">

    <!-- Header -->
    <div class="certificate-header">

        <div>

            <h4 class="certificate-heading">
                Daftar Sertifikat
            </h4>

            <div class="certificate-subtitle">

                <span id="certificateCount">
                    {{ count($security_certificates) }}
                </span>

                Sertifikat • Aktifkan
                <span class="text-warning">★</span>
                sebagai badge profil

            </div>

        </div>

        <button type="button" class="btn-add-certificate btnCreate py-2" data-bs-toggle="modal"
            data-bs-target="#certificateModal">

            <i class="ki-duotone ki-plus fs-9 me-2"></i>

            Tambah

        </button>

    </div>


    <!-- Body -->

    <div class="certificate-body">


        <!-- CARD -->

        @forelse($security_certificates as $security_certificate)

            <div class="certificate-card" 
                data-uuid="{{ $security_certificate->uuid }}"
                data-title="{{ $security_certificate->title }}"
                data-publisher="{{ $security_certificate->publisher }}"
                data-category="{{ $security_certificate->category }}"
                data-publish="{{ $security_certificate->publish }}"
                data-expired="{{ $security_certificate->expired_date }}"
                data-number="{{ $security_certificate->certificate_number }}"
                data-file="{{ $security_certificate->file }}"
            >

                <div class="certificate-icon {{ $security_certificate->is_badge == 0 ? 'empty' : '' }}">

                    <i class="ki-duotone ki-star"></i>

                </div>

                <div class="certificate-content">

                    <div class="certificate-top">

                        <div>

                            <div class="certificate-title">

                                {{ $security_certificate->title }}

                                @if($security_certificate->is_badge)
                                    <span class="certificate-badge">

                                        ★ BADGE

                                    </span>
                                @endif

                            </div>

                            <div class="certificate-instansi">

                                {{ $security_certificate->publisher }}

                            </div>

                        </div>

                        @php
                            $today = \Carbon\Carbon::today();
                            $statusCertificate = 'expired';

                            $publishDate = \Carbon\Carbon::parse($security_certificate->publish_date);
                            $expiredDate = \Carbon\Carbon::parse($security_certificate->expired_date);

                            if ($today->between($publishDate, $expiredDate)) {
                                $statusCertificate = 'active';
                            }
                        @endphp
                        <span class="certificate-status {{ $statusCertificate }}">

                            {{ $statusCertificate == 'expired' ? 'Kadaluarsa' : 'Aktif' }}

                        </span>

                    </div>


                    <div class="certificate-detail">

                        <span class="certificate-number">

                            {{ $security_certificate->certificate_number }}

                        </span>

                        <span class="certificate-date">

                            {{ date('d F Y', strtotime($security_certificate->publish_date)) }} →
                            <span class="text-danger">

                                {{ date('d F Y', strtotime($security_certificate->expired_date)) }}

                            </span>

                        </span>

                    </div>


                    <span class="certificate-category">

                        {{ $security_certificate->category }}

                    </span>

                </div>

                <div class="dropup">

                    <button
                        class="certificate-menu"
                        type="button"
                        data-bs-toggle="dropdown"
                        data-bs-auto-close="static">

                        <i class="ki-duotone ki-dots-horizontal fs-4"></i>

                    </button>

                    <ul class="dropdown-menu dropdown-menu-end certificate-dropdown">

                        <a
                            class="dropdown-item btnBadge"
                            href="javascript:;"
                            data-uuid="{{ $security_certificate->uuid }}">

                            <i class="ki-duotone {{ $security_certificate->is_badge ? 'ki-star text-warning' : 'ki-star' }} me-3"></i>

                            <span>

                                {{ $security_certificate->is_badge ? 'Nonaktifkan Badge Profil' : 'Jadikan Badge Profil' }}

                            </span>

                        </a>

                        <li>

                            <a class="dropdown-item btnEdit"
                                href="javascript:;"
                                data-uuid="{{ $security_certificate->uuid }}">

                                <i class="ki-duotone ki-notepad-edit me-3"></i>

                                Edit

                            </a>

                        </li>

                        <li>

                            <a class="dropdown-item" href="{{ $security_certificate->file }}" target="_blank">

                                <i class="ki-duotone ki-file-sheet me-3"></i>

                                Lihat Dokumen

                            </a>

                        </li>

                        <li><hr class="dropdown-divider"></li>

                        <li>

                            <a class="dropdown-item text-danger btnDelete"
                                href="javascript:;"
                                data-uuid="{{ $security_certificate->uuid }}">

                                <i class="ki-duotone ki-trash text-danger me-3"></i>

                                Hapus

                            </a>

                        </li>

                    </ul>

                </div>

            </div>

            @empty

            <div class="certificate-empty">

                <div class="certificate-empty-icon">

                    <i class="ki-duotone ki-award fs-6 text-warning">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>

                </div>

                <div class="certificate-empty-title">

                    Belum Ada Sertifikasi

                </div>

                <div class="certificate-empty-text">

                    Tambahkan sertifikat pelatihan, lisensi, atau kompetensi
                    yang Anda miliki agar profil lebih dipercaya oleh
                    perusahaan maupun BUJP.

                </div>

            </div>

        @endforelse

    </div>

</div>

<div class="modal fade" id="certificateModal" tabindex="-1">

    <div class="modal-dialog modal-md modal-dialog-centered">

        <div class="modal-content certificate-modal">

            <!-- Header -->

            <div class="certificate-modal-header">

                <div class="d-flex align-items-center">

                    <div class="certificate-modal-icon">

                        <i class="ki-duotone ki-award fs-3 text-warning"></i>

                    </div>

                    <div>

                        <h5 class="mb-0" id="certificateModalTitle">
                            Tambah Sertifikasi
                        </h5>

                        <small class="text-muted" id="certificateModalSubtitle">
                            Lengkapi informasi sertifikat
                        </small>

                    </div>

                </div>

                <button
                    class="certificate-close"
                    data-bs-dismiss="modal">

                    <i class="ki-duotone ki-cross fs-8"></i>

                </button>

            </div>

            <form id="formCertificate" method="POST" action="{{ route('user-page.profile.certificate.store') }}" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="uuid" id="certificateUuid">

                <div class="certificate-modal-body">

                    <!-- Nama -->

                    <div class="mb-4">

                        <label class="form-label-dark">

                            Nama Sertifikat
                            <span class="text-danger">*</span>

                        </label>

                        <div class="input-dark">

                            <i class="ki-duotone ki-award"></i>

                            <input
                                type="text"
                                name="title"
                                class="form-control"
                                placeholder="cth: Satpam Gada Pratama"
                                required
                                >

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-4">

                            <label class="form-label-dark">

                                Penerbit
                                <span class="text-danger">*</span>

                            </label>

                            <div class="input-dark">

                                <i class="ki-duotone ki-office-bag"></i>

                                <input
                                    class="form-control"
                                    name="publisher"
                                    placeholder="BNSP / Polri"
                                    required
                                    >

                            </div>

                        </div>

                        <div class="col-md-6 mb-4">

                            <label class="form-label-dark">

                                No. Sertifikat
                                <span class="text-danger">*</span>

                            </label>

                            <div class="input-dark">

                                <i class="ki-duotone ki-devices"></i>

                                <input
                                    type="text"
                                    name="certificate_number"
                                    class="form-control"
                                    placeholder="BNSP-XXX-0000"
                                    required
                                    >

                            </div>

                        </div>

                    </div>

                    <div class="mb-4">

                        <label class="form-label-dark">

                            Kategori
                            <span class="text-danger">*</span>

                        </label>

                        <select name="category" class="form-select input-select-dark" required>

                            <option>Pilih kategori...</option>

                            @php
                                $master_category_certificates = \App\Models\MasterCategoryCertificate::orderBy('title')->get();
                            @endphp

                            @foreach($master_category_certificates as $certificate)

                                <option value="{{ $certificate->title }}">{{ $certificate->title }}</option>

                            @endforeach

                        </select>

                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-4">

                            <label class="form-label-dark">

                                Tanggal Terbit
                                <span class="text-danger">*</span>

                            </label>

                            <input
                                type="date"
                                name="publish_date"
                                class="form-control input-date-dark"
                                required
                                >

                        </div>

                        <div class="col-md-6 mb-4">

                            <label class="form-label-dark">

                                Masa Berlaku s/d
                                <span class="text-danger">*</span>

                            </label>

                            <input
                                type="date"
                                name="expired_date"
                                class="form-control input-date-dark"
                                required
                                >

                        </div>

                    </div>

                    <!-- Upload -->

                    <div>

                        <label class="form-label-dark">
                            Upload Dokumen
                            <span class="text-muted">(Opsional)</span>
                        </label>

                        <label class="certificate-upload" id="uploadArea">

                            <input
                                type="file"
                                id="certificateFile"
                                name="file"
                                accept=".pdf,.jpg,.jpeg,.png"
                                hidden>

                            <div class="upload-icon">
                                <i class="ki-duotone ki-file-up fs-2"></i>
                            </div>

                            <div class="upload-info">

                                <div class="upload-title fw-semibold">
                                    Drag & Drop atau klik untuk memilih
                                </div>

                                <small class="upload-subtitle">
                                    PDF, JPG, PNG • Maks 10 MB
                                </small>

                                <div class="upload-overlay">
                                    <i class="ki-duotone ki-arrows-circle me-2"></i>
                                    Ganti File
                                </div>

                            </div>

                        </label>

                    </div>

                </div>

                <div class="certificate-modal-footer">

                    <button
                        class="btn-cancel-certificate"
                        data-bs-dismiss="modal"
                        type="button">

                        Batal

                    </button>

                    <button
                        class="btn-save-certificate"
                        type="button"
                        id="btnSaveCertificate">

                        Tambahkan

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<div class="modal fade" id="deleteCertificateModal" tabindex="-1">

    <div class="modal-dialog modal-sm modal-dialog-centered">

        <div class="modal-content delete-modal">

            <div class="delete-modal-body">

                <div class="delete-icon">

                    <i class="ki-duotone ki-cross fs-6 text-danger">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>

                </div>

                <h4 class="delete-title">
                    Hapus Sertifikat?
                </h4>

                <p class="delete-description">

                    Data sertifikat ini akan dihapus permanen dan
                    tidak bisa dikembalikan.

                </p>

                <input type="hidden" id="deleteCertificateUuid">

            </div>

            <div class="delete-modal-footer">

                <button
                    type="button"
                    class="btn-delete-cancel"
                    data-bs-dismiss="modal">

                    Batal

                </button>

                <button
                    type="button"
                    class="btn-delete-confirm"
                    id="btnDeleteCertificate">

                    Hapus

                </button>

            </div>

        </div>

    </div>

</div>