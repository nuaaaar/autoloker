<style>
    .btn-save.saved {
        border-color: #198754;
        color: #198754;
    }

    .btn-save.saved:hover {
        border-color: #198754;
        color: #198754;
    }

    /* =========================================================
    JOB FILTER CARD
    ========================================================= */

    .job-filter-card {
        border: 1px solid #2c344d;
        border-radius: 12px;
        background: #151a2d;
        color: #f5f7fa;
    }


    /* =========================================================
    SEARCH
    ========================================================= */

    .job-search {
        position: relative;
        width: 100%;
        background: none !important;
        padding: 0px !important;
    }

    .job-search i {
        position: absolute;

        left: 14px;
        top: 50%;

        transform: translateY(-50%);

        color: #8f98ae;

        pointer-events: none;
    }

    .job-search input {
        width: 100%;

        height: 42px;

        padding: 0 14px 0 42px;

        border: 1px solid #2c344d;

        border-radius: 8px;

        background: #1d2338;

        color: #f5f7fa;

        font-size: 12px;
        font-weight: 500;

        outline: none;

        transition: all .2s ease;
    }

    .job-search input::placeholder {
        color: #7f889f;
    }

    .job-search input:hover {
        border-color: #3b4561;
    }

    .job-search input:focus {
        border-color: #e8a401;

        box-shadow:
            0 0 0 2px rgba(232, 164, 1, .08);
    }


    /* =========================================================
    FILTER ROW
    ========================================================= */

    .job-filter-row {
        display: flex;

        align-items: center;

        gap: 10px;

        width: 100%;
    }


    /* =========================================================
    FILTER DROPDOWN
    ========================================================= */

    .job-filter-dropdown {
        flex: 1;

        min-width: 0;
    }

    .job-filter-select {
        width: 100%;

        height: 38px;

        padding: 0 32px 0 12px;

        border: 1px solid #2c344d;

        border-radius: 8px;

        background-color: #1d2338;

        color: #c8cedc;

        font-size: 12px;

        font-weight: 500;

        outline: none;

        cursor: pointer;

        transition: all .2s ease;
    }

    .job-filter-select:hover {
        border-color: #3b4561;

        color: #ffffff;
    }

    .job-filter-select:focus {
        border-color: #e8a401;

        box-shadow:
            0 0 0 2px rgba(232, 164, 1, .08);
    }


    /* option */
    .job-filter-select option {
        background: #1d2338;
        color: #f5f7fa;
    }


    /* =========================================================
    MORE FILTER
    ========================================================= */

    .btn-more-filter {
        height: 38px;

        padding: 0 14px;

        display: flex;

        align-items: center;

        justify-content: center;

        gap: 6px;

        border: 1px solid #2c344d;

        border-radius: 8px;

        background: #1d2338;

        color: #c8cedc;

        font-size: 12px;

        font-weight: 600;

        white-space: nowrap;

        cursor: pointer;

        transition: all .2s ease;
    }

    .btn-more-filter i {
        font-size: 14px;
    }

    .btn-more-filter:hover {
        background: #252d45;

        border-color: #e8a401;

        color: #e8a401;
    }


    /* =========================================================
    MODAL
    ========================================================= */

    .job-filter-modal {
        border: 1px solid #2c344d;

        border-radius: 12px;

        overflow: hidden;

        background: #151a2d;

        color: #f5f7fa;

        box-shadow:
            0 20px 60px rgba(0, 0, 0, .45);
    }


    /* =========================================================
    MODAL HEADER
    ========================================================= */

    .job-filter-modal .modal-header {
        padding: 20px 22px;

        border-bottom: 1px solid #2c344d;

        background: #151a2d;
    }

    .job-filter-modal-title {
        margin: 0;

        font-size: 16px;

        font-weight: 700;

        color: #ffffff;
    }

    .job-filter-modal-subtitle {
        margin-top: 4px;

        font-size: 11px;

        color: #8f98ae;

        line-height: 1.5;
    }


    /* close button */

    .job-filter-modal .btn-close {
        filter: invert(1);

        opacity: .6;
    }

    .job-filter-modal .btn-close:hover {
        opacity: 1;
    }


    /* =========================================================
    MODAL BODY
    ========================================================= */

    .job-filter-modal .modal-body {
        padding: 20px 22px;

        max-height: 65vh;

        overflow-y: auto;

        background: #151a2d;
    }


    /* scrollbar */

    .job-filter-modal .modal-body::-webkit-scrollbar {
        width: 5px;
    }

    .job-filter-modal .modal-body::-webkit-scrollbar-track {
        background: #151a2d;
    }

    .job-filter-modal .modal-body::-webkit-scrollbar-thumb {
        background: #343d57;

        border-radius: 10px;
    }


    /* =========================================================
    FORM GROUP
    ========================================================= */

    .filter-form-group {
        margin-bottom: 17px;
    }

    .filter-form-group:last-child {
        margin-bottom: 0;
    }

    .filter-form-group label {
        display: block;

        margin-bottom: 7px;

        font-size: 11px;

        font-weight: 600;

        color: #aeb6c8;
    }


    /* =========================================================
    MODAL SELECT
    ========================================================= */

    .filter-form-control {
        width: 100%;

        height: 38px;

        padding: 0 12px;

        border: 1px solid #2c344d;

        border-radius: 7px;

        background: #1d2338;

        color: #f5f7fa;

        font-size: 12px;

        outline: none;

        cursor: pointer;

        transition: all .2s ease;
    }

    .filter-form-control:hover {
        border-color: #3b4561;
    }

    .filter-form-control:focus {
        border-color: #e8a401;

        box-shadow:
            0 0 0 2px rgba(232, 164, 1, .08);
    }

    .filter-form-control option {
        background: #1d2338;

        color: #f5f7fa;
    }


    /* =========================================================
    MODAL FOOTER
    ========================================================= */

    .job-filter-modal .modal-footer {
        padding: 14px 22px;

        border-top: 1px solid #2c344d;

        background: #151a2d;

        display: flex;

        align-items: center;

        justify-content: space-between;
    }


    /* =========================================================
    RESET
    ========================================================= */

    .btn-filter-reset {
        height: 36px;

        padding: 0 16px;

        border: 1px solid transparent;

        border-radius: 7px;

        background: transparent;

        color: #8f98ae;

        font-size: 12px;

        font-weight: 600;

        cursor: pointer;

        transition: all .2s ease;
    }

    .btn-filter-reset:hover {
        background: #1d2338;

        color: #ffffff;
    }


    /* =========================================================
    APPLY
    ========================================================= */

    .btn-filter-apply {
        height: 36px;

        padding: 0 18px;

        border: 1px solid #e8a401;

        border-radius: 7px;

        background: #e8a401;

        color: #151a2d;

        font-size: 12px;

        font-weight: 700;

        cursor: pointer;

        transition: all .2s ease;
    }

    .btn-filter-apply:hover {
        background: #f2b313;

        border-color: #f2b313;
    }


    /* =========================================================
    MOBILE
    ========================================================= */

    @media (max-width: 767px) {

        .job-filter-row {
            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 8px;
        }

        .job-filter-dropdown {
            width: 100%;
        }

        .job-filter-select {
            font-size: 11px;

            height: 37px;
        }

        .btn-more-filter {
            width: 100%;

            height: 37px;

            font-size: 11px;
        }

    }


    /* =========================================================
    TABLET
    ========================================================= */

    @media (min-width: 768px) and (max-width: 991px) {

        .job-filter-row {
            flex-wrap: wrap;
        }

        .job-filter-dropdown {
            flex: 1 1 calc(50% - 10px);
        }

        .btn-more-filter {
            flex: 1 1 calc(50% - 10px);
        }

    }

    .job-filter-select.filter-active {
        border-color: #e8a401;

        background: rgba(232, 164, 1, .08);

        color: #e8a401;
    }
</style>

<style>
    /*
    |--------------------------------------------------------------------------
    | FIX METRONIC SCROLL
    |--------------------------------------------------------------------------
    */

    #kt_app_wrapper {
        min-height: 100vh;
    }

    #kt_app_main {
        min-height: 0;
    }

    #kt_app_main > .d-flex.flex-column.flex-column-fluid {
        min-height: 0;
    }


    /*
    |--------------------------------------------------------------------------
    | CONTENT BOLEH MEMANJANG
    |--------------------------------------------------------------------------
    */

    #kt_app_main .flex-column-fluid {
        min-height: 0;
    }


    /*
    |--------------------------------------------------------------------------
    | JOB LIST
    |--------------------------------------------------------------------------
    */

    #jobList {
        width: 100%;
    }


    /*
    |--------------------------------------------------------------------------
    | PASTIKAN CONTENT TIDAK TERKUNCI
    |--------------------------------------------------------------------------
    */

    html,
    body {
        min-height: 100%;
    }
</style>

<!-- Search -->
<div class="card job-filter-card mb-4">

    <div class="card-body p-4">

        {{-- ===================================================== --}}
        {{-- SEARCH --}}
        {{-- ===================================================== --}}

        <div class="job-search">

            <i class="ki-duotone ki-magnifier fs-4">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>

            <input
                type="text"
                id="jobSearch"
                placeholder="Cari lowongan, perusahaan, lokasi..."
                autocomplete="off"
            >

        </div>


        {{-- ===================================================== --}}
        {{-- FILTER UTAMA --}}
        {{-- ===================================================== --}}

        <div class="mt-4 job-filter-row">


            {{-- =============================================== --}}
            {{-- LOKASI --}}
            {{-- =============================================== --}}

            <div class="job-filter-dropdown">

                <select
                    id="filterLocation"
                    class="job-filter-select">

                    <option value="">
                        Lokasi
                    </option>

                    @foreach(\Laravolt\Indonesia\Models\Province::orderBy('name')->get() as $data_province)

                        <option
                            value="{{ $data_province->name }}">

                            {{ $data_province->name }}

                        </option>

                    @endforeach

                </select>

            </div>


            {{-- =============================================== --}}
            {{-- JENIS PEKERJAAN --}}
            {{-- =============================================== --}}

            <div class="job-filter-dropdown">

                <select
                    id="filterWorkingType"
                    class="job-filter-select">

                    <option value="">
                        Jenis Pekerjaan
                    </option>

                    <option value="permanent">
                        Tetap
                    </option>

                    <option value="contract">
                        Kontrak
                    </option>

                    <option value="intenrship">
                        Internship
                    </option>

                    <option value="freelance">
                        Freelance
                    </option>

                </select>

            </div>


            {{-- =============================================== --}}
            {{-- SISTEM KERJA --}}
            {{-- =============================================== --}}

            <div class="job-filter-dropdown">

                <select
                    id="filterWorkingSystem"
                    class="job-filter-select">

                    <option value="">
                        Sistem Kerja
                    </option>

                    <option value="shift">
                        Shift
                    </option>

                    <option value="non-shift">
                        Non-Shift
                    </option>

                </select>

            </div>


            {{-- =============================================== --}}
            {{-- SERTIFIKAT --}}
            {{-- =============================================== --}}

            <div class="job-filter-dropdown">

                <select
                    id="filterCertificate"
                    class="job-filter-select">

                    <option value="">
                        Sertifikat
                    </option>

                    @foreach(\App\Models\MasterCertificate::orderBy('title')->get() as $certificate)
                        <option
                            value="{{ $certificate->title }}">

                            {{ $certificate->title }}

                        </option>
                    @endforeach

                </select>

            </div>


            {{-- =============================================== --}}
            {{-- FILTER LAINNYA --}}
            {{-- =============================================== --}}

            <button
                type="button"
                class="btn-more-filter"
                data-bs-toggle="modal"
                data-bs-target="#jobFilterModal">

                <i class="ki-duotone ki-setting-4">

                    <span class="path1"></span>
                    <span class="path2"></span>

                </i>

                <span>
                    Filter
                </span>

            </button>

        </div>

    </div>

</div>

{{-- ============================================================= --}}
{{-- MODAL FILTER LANJUTAN --}}
{{-- ============================================================= --}}

<div class="modal fade"
    id="jobFilterModal"
    tabindex="-1"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content job-filter-modal">

            <div class="modal-header">

                <h5 class="modal-title">
                    Filter Lowongan
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>


            <div class="modal-body">


                {{-- ============================================= --}}
                {{-- RENTANG GAJI --}}
                {{-- ============================================= --}}

                <div class="mb-4">

                    <label class="job-filter-label">
                        Gaji Minimum
                    </label>

                    <select
                        id="modalMinSalary"
                        class="form-select job-modal-select">

                        <option value="">
                            Semua
                        </option>

                        <option value="3000000">
                            Rp 3 Juta+
                        </option>

                        <option value="5000000">
                            Rp 5 Juta+
                        </option>

                        <option value="7000000">
                            Rp 7 Juta+
                        </option>

                        <option value="10000000">
                            Rp 10 Juta+
                        </option>

                    </select>

                </div>


                {{-- ============================================= --}}
                {{-- URGENT --}}
                {{-- ============================================= --}}

                <div class="mb-4">

                    <label class="job-filter-label">
                        Status Lowongan
                    </label>

                    <select
                        id="modalUrgent"
                        class="form-select job-modal-select">

                        <option value="">
                            Semua Lowongan
                        </option>

                        <option value="1">
                            Urgent
                        </option>

                        <option value="0">
                            Non-Urgent
                        </option>

                    </select>

                </div>


                {{-- ============================================= --}}
                {{-- PENGALAMAN --}}
                {{-- ============================================= --}}

                <div class="mb-4">

                    <label class="job-filter-label">
                        Pengalaman
                    </label>

                    <select
                        id="modalExperience"
                        class="form-select job-modal-select">

                        <option value="">
                            Semua Pengalaman
                        </option>

                        <option value="0">
                            Tanpa Pengalaman
                        </option>

                        <option value="1">
                            Minimal 1 Tahun
                        </option>

                        <option value="2">
                            Minimal 2 Tahun
                        </option>

                        <option value="3">
                            Minimal 3 Tahun
                        </option>

                        <option value="5">
                            Minimal 5 Tahun
                        </option>

                    </select>

                </div>


                {{-- ============================================= --}}
                {{-- GENDER --}}
                {{-- ============================================= --}}

                <div class="mb-4">

                    <label class="job-filter-label">
                        Jenis Kelamin
                    </label>

                    <select
                        id="modalGender"
                        class="form-select job-modal-select">

                        <option value="">
                            Semua
                        </option>

                        <option value="laki-laki">
                            Laki-laki
                        </option>

                        <option value="perempuan">
                            Perempuan
                        </option>

                    </select>

                </div>


            </div>


            <div class="modal-footer">

                <button
                    type="button"
                    id="btnResetJobFilter"
                    class="btn btn-light">

                    Reset

                </button>


                <button
                    type="button"
                    id="btnApplyJobFilter"
                    class="btn btn-warning">

                    Terapkan Filter

                </button>

            </div>

        </div>

    </div>

</div>

<div id="jobListWrapper">
    <div id="jobList">
        <div class="text-center py-5">

            <span class="spinner-border"></span>

        </div>
        {{-- AJAX job list masuk di sini --}}
    </div>

    <div
        id="jobLoading"
        class="text-center py-4 d-none"
    >
        <div class="spinner-border spinner-border-sm text-warning"></div>
        <span class="ms-2 apply-info">
            Memuat lowongan...
        </span>
    </div>

    <div
        id="jobEnd"
        class="text-center py-4 d-none"
    >
        <span class="apply-info">
            Semua lowongan sudah ditampilkan.
        </span>
    </div>
</div>
