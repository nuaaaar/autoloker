<style>
    /* =========================================================
       BADGE
       ========================================================= */

    .badge-active{
        padding:4px 10px;
        border-radius:20px;
        background:#16a34a20;
        color:#22c55e;
        font-size:11px;
        font-weight:600;
        border:1px solid #22c55e55;
    }

    .badge-expired{
        padding:4px 10px;
        border-radius:20px;
        background:#ef444420;
        color:#ef4444;
        border:1px solid #ef444455;
        font-size:11px;
    }

    .badge-warning{
        padding:4px 10px;
        border-radius:20px;
        background:#e8a40120;
        color:#e8a401;
        border:1px solid #e8a40155;
        font-size:11px;
    }

    .badge-complete{
        padding:4px 10px;
        border-radius:20px;
        background:#2563eb20;
        color:#60a5fa;
        border:1px solid #60a5fa55;
        font-size:11px;
    }


    /* =========================================================
       CERTIFICATE CARD
       ========================================================= */

    .certificate-filter-card {
        background:#121c32;
        border:1px solid #25324a;
        border-radius:18px;
        margin-bottom:22px;
        transition:.25s;
    }

    .certificate-card {
        background:#121c32;
        border:1px solid #25324a;
        border-radius:18px;
        margin-bottom:22px;
        transition:.25s;
    }


    /* =========================================================
       LIGHT MODE
       ========================================================= */

    [data-bs-theme="light"] .certificate-filter-card,
    [data-bs-theme="light"] .certificate-card {
        background:#ffffff !important;
        border:1px solid #e5e7eb !important;
    }


    /* =========================================================
       BADGE - LIGHT MODE
       ========================================================= */

    [data-bs-theme="light"] .badge-active {
        background:rgba(22, 163, 74, .08) !important;
        color:#15803d !important;
        border-color:rgba(21, 128, 61, .25) !important;
    }

    [data-bs-theme="light"] .badge-expired {
        background:rgba(239, 68, 68, .08) !important;
        color:#dc2626 !important;
        border-color:rgba(220, 38, 38, .25) !important;
    }

    [data-bs-theme="light"] .badge-warning {
        background:rgba(232, 164, 1, .08) !important;
        color:#c28500 !important;
        border-color:rgba(194, 133, 0, .25) !important;
    }

    [data-bs-theme="light"] .badge-complete {
        background:rgba(37, 99, 235, .08) !important;
        color:#2563eb !important;
        border-color:rgba(37, 99, 235, .25) !important;
    }

</style>

<div class="card certificate-filter-card mb-4">
    <div class="card-body p-4">

        <div class="job-search">

            <i class="ki-duotone ki-magnifier fs-4">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>

            <input type="text"
                placeholder="Cari sertifikasi, pelatihan, penerbit...">

        </div>

        <div class="mt-4 d-flex flex-wrap gap-2">

            <button class="btn-filter active">
                Semua
            </button>

            <button class="btn-filter">
                Sertifikasi
            </button>

            <button class="btn-filter">
                Pelatihan
            </button>

            <button class="btn-filter">
                Hampir Expired
            </button>

            <button class="btn-filter">
                BNSP
            </button>

        </div>

    </div>
</div>

<div class="card certificate-card mb-4">

    <div class="card-body p-4">

        <div class="d-flex justify-content-between">

            <div class="flex-grow-1">

                <div class="d-flex align-items-center gap-2">

                    <h5 class="certificate-title mb-0">

                        Sertifikasi Gada Pratama

                    </h5>

                    <span class="badge-active">

                        Aktif

                    </span>

                </div>

                <div class="company-name">

                    LSP Sekuriti Indonesia

                </div>

                <div class="job-info mt-2">

                    <span>

                        <i class="ki-duotone ki-calendar"></i>

                        Terbit : 15 Januari 2025

                    </span>

                    <span>

                        <i class="ki-duotone ki-calendar-8"></i>

                        Berlaku s/d : 15 Januari 2028

                    </span>

                </div>

                <div class="mt-2">

                    <span class="badge-license">

                        <i class="ki-duotone ki-shield-tick text-warning"></i>

                        BNSP

                    </span>

                </div>

                <div class="apply-info mt-2">

                    Nomor Sertifikat :
                    BNSP-2025-001245

                </div>

            </div>

            <div class="certificate-icon">

                <i class="ki-duotone ki-shield-tick fs-1 text-warning"></i>

            </div>

        </div>

        <hr class="job-divider">

        <div class="d-flex gap-3">

            <button class="btn-apply flex-grow-1">

                Lihat Sertifikat

            </button>

            <button class="btn-save">

                Download

            </button>

        </div>

    </div>

</div>

<div class="card certificate-card mb-4">

    <div class="card-body p-4">

        <div class="d-flex justify-content-between">

            <div class="flex-grow-1">

                <div class="d-flex align-items-center gap-2">

                    <h5 class="certificate-title mb-0">

                        Pelatihan CCTV Monitoring

                    </h5>

                    <span class="badge-complete">

                        Selesai

                    </span>

                </div>

                <div class="company-name">

                    PT Tekno Putra Perkasa

                </div>

                <div class="job-info mt-2">

                    <span>

                        <i class="ki-duotone ki-calendar"></i>

                        10 Juni 2025

                    </span>

                    <span>

                        <i class="ki-duotone ki-time"></i>

                        16 Jam Pelatihan

                    </span>

                </div>

                <div class="apply-info mt-2">

                    Nilai Kelulusan : 92 / 100

                </div>

            </div>

            <div class="certificate-icon">

                <i class="ki-duotone ki-book-open fs-1 text-primary"></i>

            </div>

        </div>

        <hr class="job-divider">

        <div class="d-flex gap-3">

            <button class="btn-apply flex-grow-1">

                Lihat Detail

            </button>

            <button class="btn-save">

                Sertifikat

            </button>

        </div>

    </div>

</div>