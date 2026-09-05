<style>

    /* =========================================================
    SEARCH CARD
    ========================================================= */

    .training-search-card {

        background: #121c33;

        border: 1px solid #2a3550;

        border-radius: 22px;

    }


    /* =========================================================
    SEARCH TITLE
    ========================================================= */

    .training-title {

        color: #fff;

        font-size: 14px;

        font-weight: 700;

    }


    .training-subtitle {

        color: #90a0be;

        font-size: 10px;

        margin-top: 4px;

    }


    /* =========================================================
    SEARCH
    ========================================================= */

    .training-search {

        background: #1d2747;

        border-radius: 10px;

        height: 34px;

        display: flex;

        align-items: center;

        padding: 0 22px;

    }


    .training-search i {

        color: #90a0be;

        margin-right: 14px;

    }


    .training-search input {

        background: none;

        border: none;

        outline: none;

        width: 100%;

        color: #fff;

        font-size: 14px;

    }


    .training-search input::placeholder {

        color: #7f8fb1;

    }


    /* =========================================================
    CARD
    ========================================================= */

    .training-card {

        background: #121c33;

        border: 1px solid #2a3550;

        border-radius: 24px;

    }


    .training-card .card-body {

        padding: 16px 16px !important;

    }


    /* =========================================================
    TRAINING NAME
    ========================================================= */

    .training-name {

        color: #fff;

        font-size: 14px;

        font-weight: 700;

        line-height: 1.4;

    }


    /* =========================================================
    PROVIDER
    ========================================================= */

    .training-provider {

        color: #91a0bc;

        font-size: 10px;

    }


    /* =========================================================
    BADGE
    ========================================================= */

    .training-badge {

        padding: 3px 8px;

        border-radius: 999px;

        font-size: 9.5px;

        font-weight: 700;

        line-height: 1.2;

    }


    .badge-green {

        background: rgba(0, 220, 150, .12);

        color: #18e0a5;

        border: 1px solid rgba(0, 220, 150, .35);

    }


    .badge-blue {

        background: rgba(69, 140, 255, .12);

        color: #5da2ff;

        border: 1px solid rgba(69, 140, 255, .35);

    }


    .badge-yellow {

        background: rgba(246, 176, 0, .12);

        color: #f6b000;

        border: 1px solid rgba(246, 176, 0, .35);

    }


    /* =========================================================
    INFO
    ========================================================= */

    .training-info {

        display: flex;

        gap: 26px;

        flex-wrap: wrap;

        color: #8f9fbc;

        font-size: 11px;

    }


    .training-info span {

        display: flex;

        align-items: center;

        gap: 8px;

    }


    .training-info i {

        color: #90a0be;

    }


    /* =========================================================
    QUOTA
    ========================================================= */

    .training-quota {

        color: #8e9dba;

        font-size: 10px;

    }


    .training-quota strong {

        color: #c8d0df;

        font-weight: 700;

    }


    /* =========================================================
    PRICE
    ========================================================= */

    .training-price {

        color: #f6b000;

        font-weight: 700;

        font-size: 10px;

    }


    /* =========================================================
    PROGRESS
    ========================================================= */

    .training-progress {

        height: 8px;

        background: #2a3550;

        border-radius: 999px;

        overflow: hidden;

    }


    .training-progress .progress-bar {

        background: #b6842b;

        border-radius: 999px;

        height: 100%;

        transition: width .3s ease;

    }


    /* =========================================================
    BUTTON
    ========================================================= */

    .btn-training-register {

        height: 34px;

        min-height: 34px;

        display: flex;

        align-items: center;

        justify-content: center;

        width: 100%;

        background: #1d2747;

        border: none;

        border-radius: 10px;

        color: #95a4bf;

        font-size: 12px;

        font-weight: 700;

        text-decoration: none;

        padding: 0 12px;

        transition: .25s;

        box-sizing: border-box;

    }


    .btn-training-register:hover {

        background: #24315a;

        color: #fff;

        text-decoration: none;

    }


    .btn-training-register:focus {

        background: #24315a;

        color: #fff;

        outline: none;

        box-shadow: none;

    }


    .btn-training-register i {

        flex-shrink: 0;

    }


    /* =========================================================
    EMPTY
    ========================================================= */

    .training-empty {

        min-height: 180px;

        display: flex;

        align-items: center;

        justify-content: center;

        flex-direction: column;

        text-align: center;

        color: #8f9fbc;

        font-size: 11px;

    }


    .training-empty i {

        font-size: 32px;

        margin-bottom: 12px;

        color: #667593;

    }


    /* =========================================================
    RESPONSIVE
    ========================================================= */

    @media (max-width: 768px) {


        .training-title {

            font-size: 14px;

        }


        .training-subtitle {

            font-size: 11px;

        }


        .training-name {

            font-size: 14px;

        }


        .training-provider {

            font-size: 11px;

        }


        .training-info {

            gap: 14px;

            font-size: 11px;

        }


        .training-price {

            font-size: 12px;

            margin-top: 8px;

        }


        /*
        |--------------------------------------------------------------------------
        | BUTTON MOBILE
        |--------------------------------------------------------------------------
        */

        .btn-training-register {

            font-size: 12px;

            height: 50px;

            min-height: 50px;

            border-radius: 10px;

        }


        .training-search {

            height: 34px;

        }


        .training-search input {

            font-size: 12px;

        }

    }


    /* =========================================================
    LIGHT MODE
    ========================================================= */

    [data-bs-theme="light"] .training-search-card{
        background:#ffffff;
        border-color:#e2e8f0;
    }

    [data-bs-theme="light"] .training-title{
        color:#1e293b;
    }

    [data-bs-theme="light"] .training-subtitle{
        color:#64748b;
    }

    [data-bs-theme="light"] .training-search{
        background:#f8fafc;
    }

    [data-bs-theme="light"] .training-search i{
        color:#64748b;
    }

    [data-bs-theme="light"] .training-search input{
        color:#1e293b;
    }

    [data-bs-theme="light"] .training-search input::placeholder{
        color:#94a3b8;
    }

    [data-bs-theme="light"] .training-card{
        background:#ffffff;
        border-color:#e2e8f0;
    }

    [data-bs-theme="light"] .training-name{
        color:#1e293b;
    }

    [data-bs-theme="light"] .training-provider{
        color:#64748b;
    }


    /* BADGE */

    [data-bs-theme="light"] .badge-green{
        background:rgba(16,212,140,.08);
        color:#0b9f6a;
        border-color:rgba(16,212,140,.30);
    }

    [data-bs-theme="light"] .badge-blue{
        background:rgba(42,134,255,.08);
        color:#2878c7;
        border-color:rgba(42,134,255,.30);
    }

    [data-bs-theme="light"] .badge-yellow{
        background:rgba(232,164,1,.10);
        color:#c98d00;
        border-color:rgba(232,164,1,.35);
    }


    /* INFO */

    [data-bs-theme="light"] .training-info{
        color:#64748b;
    }

    [data-bs-theme="light"] .training-info i{
        color:#64748b;
    }


    /* QUOTA */

    [data-bs-theme="light"] .training-quota{
        color:#64748b;
    }

    [data-bs-theme="light"] .training-quota strong{
        color:#334155;
    }


    /* PRICE */

    [data-bs-theme="light"] .training-price{
        color:#d18f00;
    }


    /* PROGRESS */

    [data-bs-theme="light"] .training-progress{
        background:#e2e8f0;
    }

    [data-bs-theme="light"] .training-progress .progress-bar{
        background:#d39b19;
    }


    /* BUTTON */

    [data-bs-theme="light"] .btn-training-register{
        background:#f8fafc;
        color:#64748b;
    }

    [data-bs-theme="light"] .btn-training-register:hover{
        background:#f1f5f9;
        color:#1e293b;
    }

    [data-bs-theme="light"] .btn-training-register:focus{
        background:#f1f5f9;
        color:#1e293b;
    }


    /* EMPTY */

    [data-bs-theme="light"] .training-empty{
        color:#64748b;
    }

    [data-bs-theme="light"] .training-empty i{
        color:#94a3b8;
    }

</style>

{{-- ========================================================= --}}
{{-- SEARCH --}}
{{-- ========================================================= --}}

<div class="card training-search-card mb-5">

    <div class="card-body">

        <h3 class="training-title">
            Katalog Pelatihan
        </h3>

        <div class="training-subtitle">

            Pelatihan resmi dari BNSP, Asosiasi,
            dan BUJP terpercaya

        </div>

        <div class="training-search mt-4">

            <i class="ki-duotone ki-magnifier fs-5">

                <span class="path1"></span>
                <span class="path2"></span>

            </i>

            <input
                type="text"
                id="trainingSearch"
                placeholder="Cari pelatihan..."
                autocomplete="off"
            >

        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- TRAINING LIST --}}
{{-- ========================================================= --}}

<div id="trainingListWrapper">

    <div id="trainingList">

        <div class="text-center py-5">

            <span class="spinner-border"></span>

        </div>

    </div>


    {{-- ===================================================== --}}
    {{-- LOADING --}}
    {{-- ===================================================== --}}

    <div
        id="trainingLoading"
        class="text-center py-4 d-none"
    >

        <div class="spinner-border spinner-border-sm text-warning"></div>

        <span class="ms-2">
            Memuat pelatihan...
        </span>

    </div>


    {{-- ===================================================== --}}
    {{-- END --}}
    {{-- ===================================================== --}}

    <div
        id="trainingEnd"
        class="text-center py-4 d-none"
    >

        Semua pelatihan sudah ditampilkan.

    </div>

</div>