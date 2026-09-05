@extends('layouts.user-page')

@section('title', 'Pelatihan Saya')

@section('style')

    <style>

    /* =========================================================
    FIX METRONIC SCROLL
    ========================================================= */

    #kt_app_wrapper {
        min-height: 100vh;
    }

    #kt_app_main {
        min-height: 0;
    }

    #kt_app_main > .d-flex.flex-column.flex-column-fluid {
        min-height: 0;
    }

    #kt_app_main .flex-column-fluid {
        min-height: 0;
    }

    html,
    body {
        min-height: 100%;
    }


    /* =========================================================
    BREADCRUMB
    ========================================================= */

    .network-breadcrumb {
        display: flex;
        align-items: center;
        gap: 2px;

        font-size: 11px;
        font-weight: 500;

        margin-bottom: 28px;
    }

    .network-breadcrumb a {
        display: flex;
        align-items: center;
        gap: 6px;

        color: #7d8aa5;

        text-decoration: none;

        transition: .25s;
    }

    .network-breadcrumb a:hover {
        color: #e8a401;
    }

    .network-breadcrumb a i {
        font-size: 11px;
    }

    .network-breadcrumb .active {
        color: #f4f6fb;
        font-weight: 600;
    }

    .network-breadcrumb .text-muted {
        color: #5b6985 !important;
    }


    /* =========================================================
    TRAINING PAGE
    ========================================================= */

    .training-page {

        width: 100%;

        max-width: 672px;

        margin: 0 auto;

        padding-bottom: 60px;

    }


    /* =========================================================
    HEADER
    ========================================================= */

    .training-header {

        display: flex;

        align-items: flex-start;

        justify-content: space-between;

        margin-bottom: 22px;

    }

    .training-header-left h2 {

        margin: 0;

        color: #e8edf7;

        font-size: 18px;

        font-weight: 700;

        line-height: 1.3;

    }

    .training-header-left p {

        margin: 5px 0 0;

        color: #8291aa;

        font-size: 12px;

    }


    /* =========================================================
    SEARCH BUTTON
    ========================================================= */

    .btn-search-training {

        display: inline-flex;

        align-items: center;

        justify-content: center;

        gap: 7px;

        height: 34px;

        padding: 0 13px;

        border-radius: 8px;

        border: 1px solid #e8a401;

        background: #e8a401;

        color: #111827;

        font-size: 11px;

        font-weight: 700;

        text-decoration: none;

        box-shadow:
            0 4px 12px rgba(232, 164, 1, .12);

        transition: .2s;

    }

    .btn-search-training:hover {

        background: #f3b21a;

        color: #111827;

    }

    .btn-search-training i {

        font-size: 13px;

    }


    /* =========================================================
    STATISTICS
    ========================================================= */

    .training-stats {

        display: grid;

        grid-template-columns:
            repeat(4, 1fr);

        gap: 8px;

        margin-bottom: 17px;

    }

    .training-stat {

        height: 74px;

        display: flex;

        flex-direction: column;

        align-items: center;

        justify-content: center;

        background: #0d172b;

        border: 1px solid #1d2a42;

        border-radius: 12px;

    }

    .training-stat-number {

        font-size: 21px;

        line-height: 1;

        font-weight: 700;

        color: #e7edf8;

        margin-bottom: 7px;

    }

    .training-stat-label {

        color: #8190a9;

        font-size: 10px;

        font-weight: 500;

        letter-spacing: .2px;

        text-transform: uppercase;

    }


    /* =========================================================
    STATISTIC COLORS
    ========================================================= */

    .stat-ongoing
    .training-stat-number {

        color: #4ea1ff;

    }

    .stat-completed
    .training-stat-number {

        color: #00d89a;

    }

    .stat-certificate
    .training-stat-number {

        color: #ffb400;

    }


    /* =========================================================
    FILTER
    ========================================================= */

    .training-filter {

        display: flex;

        align-items: center;

        gap: 7px;

        overflow-x: auto;

        padding-bottom: 3px;

        margin-bottom: 20px;

        scrollbar-width: none;

    }

    .training-filter::-webkit-scrollbar {

        display: none;

    }

    .training-filter button {

        flex-shrink: 0;

        height: 32px;

        padding: 0 12px;

        border-radius: 17px;

        border: 1px solid #1d2a42;

        background: transparent;

        color: #8190a9;

        font-size: 10px;

        font-weight: 600;

        cursor: pointer;

        transition: .2s;

    }

    .training-filter button:hover {

        border-color: #e8a401;

        color: #e8a401;

    }

    .training-filter button.active {

        color: #e8a401;

        border-color: #e8a401;

        background: rgba(232, 164, 1, .06);

    }


    /* =========================================================
    TRAINING CARD
    ========================================================= */

    .training-card {

        position: relative;

        min-height: 140px;

        margin-bottom: 12px;

        padding: 16px 16px 14px;

        background: #0d172b;

        border: 1px solid #1d2a42;

        border-radius: 13px;

        transition:
            border-color .2s,
            transform .2s;

    }

    .training-card:hover {

        border-color: #2b3b59;

    }


    /* =========================================================
    CARD STATUS BORDER
    ========================================================= */

    .training-card-completed {

        border-color:
            rgba(0, 216, 154, .35);

    }

    .training-card-cancelled {

        border-color:
            rgba(255, 98, 108, .30);

    }


    /* =========================================================
    CARD CONTENT
    ========================================================= */

    .training-card-top {

        display: flex;

        align-items: flex-start;

        gap: 12px;

    }

    .training-content {

        flex: 1;

        min-width: 0;

    }


    /* =========================================================
    TITLE ROW
    ========================================================= */

    .training-title-row {

        display: flex;

        align-items: flex-start;

        justify-content: space-between;

        gap: 15px;

    }

    .training-title-wrapper {

        min-width: 0;

    }


    /* =========================================================
    TYPE ROW
    ========================================================= */

    .training-type-row {

        display: flex;

        align-items: center;

        gap: 8px;

        margin-bottom: 4px;

    }

    .training-category {

        display: inline-flex;

        align-items: center;

        height: 22px;

        padding: 0 9px;

        border-radius: 999px;

        color: #00d89a;

        background: rgba(0, 216, 154, .07);

        border: 1px solid rgba(0, 216, 154, .35);

        font-size: 9px;

        font-weight: 700;

    }

    .training-mode {

        color: #00d89a;

        font-size: 10px;

        font-weight: 600;

    }


    /* =========================================================
    TITLE
    ========================================================= */

    .training-title {

        margin: 0;

        color: #e5ebf5;

        font-size: 14px;

        line-height: 1.35;

        font-weight: 700;

    }

    .training-provider {

        margin-top: 2px;

        color: #8190a9;

        font-size: 11px;

        line-height: 1.4;

    }


    /* =========================================================
    STATUS
    ========================================================= */

    .training-status {

        flex-shrink: 0;

    }

    .training-status-badge {

        display: inline-flex;

        align-items: center;

        justify-content: center;

        min-height: 25px;

        padding: 0 9px;

        border-radius: 13px;

        font-size: 9px;

        font-weight: 600;

        white-space: nowrap;

    }


    /* =========================================================
    ONGOING
    ========================================================= */

    .training-status-ongoing {

        color: #4ea1ff;

        border: 1px solid
            rgba(78, 161, 255, .45);

        background:
            rgba(78, 161, 255, .06);

    }


    /* =========================================================
    UPCOMING
    ========================================================= */

    .training-status-upcoming {

        color: #ffb400;

        border: 1px solid
            rgba(255, 180, 0, .40);

        background:
            rgba(255, 180, 0, .06);

    }


    /* =========================================================
    COMPLETED
    ========================================================= */

    .training-status-completed {

        color: #35d39a;

        border: 1px solid
            rgba(53, 211, 154, .40);

        background:
            rgba(53, 211, 154, .06);

    }


    /* =========================================================
    CANCELLED
    ========================================================= */

    .training-status-cancelled {

        color: #ff6565;

        border: 1px solid
            rgba(255, 101, 101, .35);

        background:
            rgba(255, 101, 101, .05);

    }


    /* =========================================================
    META
    ========================================================= */

    .training-meta {

        display: flex;

        align-items: center;

        flex-wrap: wrap;

        gap: 8px;

        margin-top: 8px;

    }

    .training-meta-item {

        display: inline-flex;

        align-items: center;

        gap: 4px;

        color: #8190a9;

        font-size: 10px;

        line-height: 1.4;

    }

    .training-meta-item i {

        font-size: 11px;

    }


    /* =========================================================
    PROGRESS
    ========================================================= */

    .training-progress-wrapper {

        margin-top: 13px;

    }

    .training-progress-header {

        display: flex;

        align-items: center;

        justify-content: space-between;

        margin-bottom: 7px;

        color: #8190a9;

        font-size: 10px;

    }

    .training-progress-header strong {

        color: #4ea1ff;

        font-size: 10px;

        font-weight: 700;

    }

    .training-progress {

        width: 100%;

        height: 8px;

        overflow: hidden;

        border-radius: 999px;

        background: #1d2a42;

    }

    .training-progress-bar {

        height: 100%;

        border-radius: inherit;

        background: #4ea1ff;

        transition: width .3s ease;

    }


    /* =========================================================
    UPCOMING NOTICE
    ========================================================= */

    .training-upcoming-notice {

        display: flex;

        align-items: center;

        gap: 8px;

        min-height: 34px;

        margin-top: 12px;

        padding: 0 12px;

        border-radius: 9px;

        border: 1px solid
            rgba(232, 164, 1, .40);

        background:
            rgba(232, 164, 1, .07);

        color: #ffb400;

        font-size: 11px;

        font-weight: 600;

    }

    .training-upcoming-notice i {

        font-size: 14px;

    }


    /* =========================================================
    COMPLETED NOTICE
    ========================================================= */

    .training-completed-notice {

        display: flex;

        align-items: center;

        gap: 7px;

        margin-top: 12px;

        color: #35d39a;

        font-size: 10px;

        font-weight: 600;

    }

    .training-completed-notice i {

        font-size: 13px;

    }


    /* =========================================================
    BOTTOM
    ========================================================= */

    .training-bottom {

        display: flex;

        align-items: center;

        justify-content: space-between;

        margin-top: 14px;

    }

    .training-registered {

        color: #71819b;

        font-size: 10px;

    }


    /* =========================================================
    DETAIL BUTTON
    ========================================================= */

    .btn-training-detail {

        display: inline-flex;

        align-items: center;

        justify-content: center;

        height: 30px;

        min-width: 90px;

        padding: 0 12px;

        border: 1px solid #25344d;

        border-radius: 8px;

        background: transparent;

        color: #8291aa;

        font-size: 10px;

        font-weight: 600;

        text-decoration: none;

        transition: .2s;

    }

    .btn-training-detail:hover {

        color: #e8a401;

        border-color: #e8a401;

    }


    /* =========================================================
    EMPTY
    ========================================================= */

    .training-empty {

        text-align: center;

        padding: 45px 20px;

    }

    .training-empty-icon {

        width: 45px;

        height: 45px;

        margin: 0 auto 12px;

        display: flex;

        align-items: center;

        justify-content: center;

        border-radius: 50%;

        background: #17243c;

        border: 1px solid #293954;

    }

    .training-empty-icon i {

        color: #8090aa;

        font-size: 18px;

    }

    .training-empty h5 {

        margin: 0 0 6px;

        color: #e5ebf5;

        font-size: 14px;

        font-weight: 700;

    }

    .training-empty-text {

        color: #8190a9;

        font-size: 11px;

    }


    /* =========================================================
    LOADING
    ========================================================= */

    .training-loading-text {

        color: #71819b;

        font-size: 10px;

    }


    /* =========================================================
    LIGHT MODE
    ========================================================= */

    [data-bs-theme="light"] .network-breadcrumb a {

        color: #64748b;

    }

    [data-bs-theme="light"] .network-breadcrumb a:hover {

        color: #e8a401;

    }

    [data-bs-theme="light"] .network-breadcrumb .active {

        color: #1e293b;

    }

    [data-bs-theme="light"] .network-breadcrumb .text-muted {

        color: #94a3b8 !important;

    }


    /* =========================================================
    HEADER LIGHT
    ========================================================= */

    [data-bs-theme="light"]
    .training-header-left h2 {

        color: #1e293b;

    }

    [data-bs-theme="light"]
    .training-header-left p {

        color: #64748b;

    }


    /* =========================================================
    STATISTIC LIGHT
    ========================================================= */

    [data-bs-theme="light"]
    .training-stat {

        background: #ffffff;

        border-color: #e2e8f0;

    }

    [data-bs-theme="light"]
    .training-stat-number {

        color: #1e293b;

    }

    [data-bs-theme="light"]
    .training-stat-label {

        color: #64748b;

    }

    [data-bs-theme="light"]
    .stat-ongoing
    .training-stat-number {

        color: #3b82f6;

    }

    [data-bs-theme="light"]
    .stat-completed
    .training-stat-number {

        color: #00a878;

    }

    [data-bs-theme="light"]
    .stat-certificate
    .training-stat-number {

        color: #d18f00;

    }


    /* =========================================================
    FILTER LIGHT
    ========================================================= */

    [data-bs-theme="light"]
    .training-filter button {

        border-color: #e2e8f0;

        color: #64748b;

    }

    [data-bs-theme="light"]
    .training-filter button:hover {

        border-color: #e8a401;

        color: #e8a401;

    }

    [data-bs-theme="light"]
    .training-filter button.active {

        color: #d18f00;

        border-color: #e8a401;

        background:
            rgba(232, 164, 1, .08);

    }


    /* =========================================================
    CARD LIGHT
    ========================================================= */

    [data-bs-theme="light"]
    .training-card {

        background: #ffffff;

        border-color: #e2e8f0;

    }

    [data-bs-theme="light"]
    .training-card:hover {

        border-color: #cbd5e1;

    }

    [data-bs-theme="light"]
    .training-card-completed {

        border-color:
            rgba(0, 168, 120, .35);

    }

    [data-bs-theme="light"]
    .training-card-cancelled {

        border-color:
            rgba(239, 68, 68, .30);

    }


    /* =========================================================
    CONTENT LIGHT
    ========================================================= */

    [data-bs-theme="light"]
    .training-title {

        color: #1e293b;

    }

    [data-bs-theme="light"]
    .training-provider {

        color: #64748b;

    }

    [data-bs-theme="light"]
    .training-meta-item {

        color: #64748b;

    }

    [data-bs-theme="light"]
    .training-progress-header {

        color: #64748b;

    }

    [data-bs-theme="light"]
    .training-progress {

        background: #e2e8f0;

    }

    [data-bs-theme="light"]
    .training-registered {

        color: #94a3b8;

    }


    /* =========================================================
    DETAIL BUTTON LIGHT
    ========================================================= */

    [data-bs-theme="light"]
    .btn-training-detail {

        border-color: #e2e8f0;

        color: #64748b;

    }

    [data-bs-theme="light"]
    .btn-training-detail:hover {

        color: #d18f00;

        border-color: #e8a401;

    }


    /* =========================================================
    CATEGORY LIGHT
    ========================================================= */

    [data-bs-theme="light"]
    .training-category {

        color: #059669;

        border-color:
            rgba(5, 150, 105, .30);

        background:
            rgba(5, 150, 105, .07);

    }

    [data-bs-theme="light"]
    .training-mode {

        color: #059669;

    }


    /* =========================================================
    EMPTY LIGHT
    ========================================================= */

    [data-bs-theme="light"]
    .training-empty-icon {

        background: #f1f5f9;

        border-color: #e2e8f0;

    }

    [data-bs-theme="light"]
    .training-empty-icon i {

        color: #94a3b8;

    }

    [data-bs-theme="light"]
    .training-empty h5 {

        color: #1e293b;

    }

    [data-bs-theme="light"]
    .training-empty-text {

        color: #64748b;

    }


    /* =========================================================
    RESPONSIVE
    ========================================================= */

    @media (max-width: 768px) {

        .training-page {

            max-width: 100%;

            padding:
                0 15px 40px;

        }


        .training-header {

            gap: 15px;

        }


        .training-header-left h2 {

            font-size: 16px;

        }


        .training-stats {

            grid-template-columns:
                repeat(2, 1fr);

        }


        .training-card {

            padding: 14px;

        }


        .training-title {

            font-size: 13px;

        }

    }


    @media (max-width: 480px) {

        .training-header {

            display: block;

        }


        .btn-search-training {

            margin-top: 12px;

        }


        .training-title-row {

            display: block;

        }


        .training-status {

            margin-top: 7px;

        }


        .training-bottom {

            gap: 10px;

        }


        .training-meta {

            align-items: flex-start;

        }

    }

    </style>

@endsection

@section('content')

    <div class="container-xxl">

        {{-- =========================================================
            BREADCRUMB
        ========================================================== --}}

        <div class="network-breadcrumb mb-4">

            <a href="javascript:;">

                <i class="ki-duotone ki-home-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>

                <span>Beranda</span>

            </a>

            <span class="mx-2 text-muted">›</span>

            <span class="active">
                Pelatihan Saya
            </span>

        </div>


        <div class="row g-4">

            {{-- =====================================================
                SIDEBAR KIRI
            ====================================================== --}}

            <div class="d-none d-lg-block col-lg-2">
            </div>


            {{-- =====================================================
                CONTENT
            ====================================================== --}}

            <div class="col-12 col-lg-8">

                <div class="training-page">


                    {{-- =================================================
                        HEADER
                    ================================================== --}}

                    <div class="training-header">

                        <div class="training-header-left">

                            <h2>
                                Pelatihan Saya
                            </h2>

                            <p>
                                {{ $totalOngoing ?? 0 }} sedang berjalan ·
                                {{ $totalCompleted ?? 0 }} selesai ·
                                {{ $totalCertificates ?? 0 }} sertifikat diterima
                            </p>

                        </div>


                        <a
                            href="{{ route('user-page.training.index') }}"
                            class="btn-search-training">

                            <i class="ki-duotone ki-teacher">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>

                            Cari Pelatihan

                        </a>

                    </div>


                    {{-- =================================================
                        STATISTIC
                    ================================================== --}}

                    <div class="training-stats">


                        {{-- TOTAL --}}

                        <div class="training-stat">

                            <div class="training-stat-number">
                                {{ $totalTrainings ?? 0 }}
                            </div>

                            <div class="training-stat-label">
                                Total
                            </div>

                        </div>


                        {{-- BERLANGSUNG --}}

                        <div class="training-stat stat-ongoing">

                            <div class="training-stat-number">
                                {{ $totalOngoing ?? 0 }}
                            </div>

                            <div class="training-stat-label">
                                Berlangsung
                            </div>

                        </div>


                        {{-- SELESAI --}}

                        <div class="training-stat stat-completed">

                            <div class="training-stat-number">
                                {{ $totalCompleted ?? 0 }}
                            </div>

                            <div class="training-stat-label">
                                Selesai
                            </div>

                        </div>


                        {{-- SERTIFIKAT --}}

                        <div class="training-stat stat-certificate">

                            <div class="training-stat-number">
                                {{ $totalCertificates ?? 0 }}
                            </div>

                            <div class="training-stat-label">
                                Sertifikat
                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                        FILTER
                    ================================================== --}}

                    <div class="training-filter">


                        {{-- SEMUA --}}

                        <button
                            type="button"
                            class="active"
                            data-status="">

                            Semua

                            @if(($totalTrainings ?? 0) > 0)
                                {{ $totalTrainings }}
                            @endif

                        </button>


                        {{-- BERLANGSUNG --}}

                        <button
                            type="button"
                            data-status="ongoing">

                            Berlangsung

                            @if(($totalOngoing ?? 0) > 0)
                                {{ $totalOngoing }}
                            @endif

                        </button>


                        {{-- AKAN DATANG --}}

                        <button
                            type="button"
                            data-status="upcoming">

                            Akan Datang

                            @if(($totalUpcoming ?? 0) > 0)
                                {{ $totalUpcoming }}
                            @endif

                        </button>


                        {{-- SELESAI --}}

                        <button
                            type="button"
                            data-status="completed">

                            Selesai

                            @if(($totalCompleted ?? 0) > 0)
                                {{ $totalCompleted }}
                            @endif

                        </button>


                        {{-- DIBATALKAN --}}

                        <button
                            type="button"
                            data-status="cancelled">

                            Dibatalkan

                            @if(($totalCancelled ?? 0) > 0)
                                {{ $totalCancelled }}
                            @endif

                        </button>

                    </div>


                    {{-- =================================================
                        TRAINING LIST
                    ================================================== --}}

                    <div
                        id="trainingList"
                        class="training-list">

                        {{-- AJAX DATA MASUK DI SINI --}}

                    </div>


                    {{-- =================================================
                        LOADING
                    ================================================== --}}

                    <div
                        id="trainingLoading"
                        class="text-center py-4 d-none">

                        <div class="spinner-border spinner-border-sm text-warning">
                        </div>

                        <div class="mt-2 training-loading-text">
                            Memuat pelatihan...
                        </div>

                    </div>


                    {{-- =================================================
                        END
                    ================================================== --}}

                    <div
                        id="trainingEnd"
                        class="text-center py-4 d-none">

                        <div class="training-loading-text">
                            Semua pelatihan sudah ditampilkan.
                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                SIDEBAR KANAN
            ====================================================== --}}

            <div class="d-none d-lg-block col-lg-2">
            </div>

        </div>

    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function () {

            let currentStatus = '';
            let currentPage = 1;
            let loading = false;
            let hasMore = true;


            /*
            |--------------------------------------------------------------------------
            | LOAD TRAINING
            |--------------------------------------------------------------------------
            */

            function loadTrainings(status = '', page = 1, append = false) {

                if (loading) {
                    return;
                }

                if (!append) {
                    currentPage = 1;
                    hasMore = true;
                }

                if (!hasMore && append) {
                    return;
                }

                loading = true;

                $('#trainingLoading').removeClass('d-none');
                $('#trainingEnd').addClass('d-none');


                $.ajax({

                    url: "{{ route('user-page.training.my-list') }}",

                    type: "GET",

                    data: {
                        status: status,
                        page: page
                    },

                    success: function (response) {

                        /*
                        |--------------------------------------------------------------------------
                        | APPEND / REPLACE
                        |--------------------------------------------------------------------------
                        */

                        if (append) {

                            $('#trainingList').append(response.html);

                        } else {

                            $('#trainingList').html(response.html);

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | PAGINATION
                        |--------------------------------------------------------------------------
                        */

                        currentPage = response.current_page ?? page;

                        hasMore = response.has_more ?? false;


                        /*
                        |--------------------------------------------------------------------------
                        | END
                        |--------------------------------------------------------------------------
                        */

                        if (!hasMore) {

                            $('#trainingEnd')
                                .removeClass('d-none');

                        }

                    },

                    error: function (xhr) {

                        console.error(xhr);

                        $('#trainingList').html(`
                            <div class="training-empty">
                                <div class="training-empty-icon">
                                    <i class="ki-duotone ki-information-5">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                </div>

                                <div class="training-empty-title">
                                    Gagal memuat pelatihan
                                </div>

                                <div class="training-empty-text">
                                    Terjadi kesalahan saat mengambil data.
                                    Silakan coba lagi.
                                </div>

                                <button
                                    type="button"
                                    class="btn btn-sm btn-warning mt-3"
                                    id="btnRetryTraining">

                                    Coba Lagi

                                </button>
                            </div>
                        `);

                    },

                    complete: function () {

                        loading = false;

                        $('#trainingLoading').addClass('d-none');

                    }

                });

            }


            /*
            |--------------------------------------------------------------------------
            | FILTER
            |--------------------------------------------------------------------------
            */

            $('.training-filter button').on('click', function () {

                const button = $(this);

                currentStatus = button.data('status') || '';

                /*
                |--------------------------------------------------------------------------
                | ACTIVE
                |--------------------------------------------------------------------------
                */

                $('.training-filter button')
                    .removeClass('active');

                button.addClass('active');


                /*
                |--------------------------------------------------------------------------
                | RESET LIST
                |--------------------------------------------------------------------------
                */

                $('#trainingList').empty();

                $('#trainingEnd').addClass('d-none');


                /*
                |--------------------------------------------------------------------------
                | LOAD
                |--------------------------------------------------------------------------
                */

                loadTrainings(
                    currentStatus,
                    1,
                    false
                );

            });


            /*
            |--------------------------------------------------------------------------
            | INFINITE SCROLL
            |--------------------------------------------------------------------------
            */

            $(window).on('scroll', function () {

                if (loading || !hasMore) {
                    return;
                }


                const scrollPosition =
                    $(window).scrollTop() +
                    $(window).height();

                const documentHeight =
                    $(document).height();


                /*
                | Mulai load ketika 300px sebelum bottom
                */

                if (
                    scrollPosition >=
                    documentHeight - 300
                ) {

                    loadTrainings(
                        currentStatus,
                        currentPage + 1,
                        true
                    );

                }

            });


            /*
            |--------------------------------------------------------------------------
            | RETRY
            |--------------------------------------------------------------------------
            */

            $(document).on(
                'click',
                '#btnRetryTraining',
                function () {

                    loadTrainings(
                        currentStatus,
                        currentPage,
                        false
                    );

                }
            );


            /*
            |--------------------------------------------------------------------------
            | INITIAL LOAD
            |--------------------------------------------------------------------------
            */

            loadTrainings(
                '',
                1,
                false
            );

        });
    </script>
@endsection