@extends('layouts.user-page')

@section('title', 'Hasil Lamaran Saya')

@section('style')
    <style>
        .network-breadcrumb{
            display:flex;
            align-items:center;
            gap:2px;
            font-size: 11px;
            font-weight:500;
            margin-bottom:28px;
        }

        .network-breadcrumb a{
            display:flex;
            align-items:center;
            gap:6px;
            color:#7d8aa5;
            text-decoration:none;
            transition:.25s;
        }

        .network-breadcrumb a:hover{
            color:#e8a401;
        }

        .network-breadcrumb a i{
            font-size: 11px;
        }

        .network-breadcrumb .active{
            color:#f4f6fb;
            font-weight:600;
        }

        .network-breadcrumb .text-muted{
            color:#5b6985 !important;
        }
    </style>
    
    <style>
        /* =========================================================
        HASIL LAMARAN
        ========================================================= */

        .application-page {
            width: 100%;
            max-width: 672px;
            margin: 0 auto;
            padding-bottom: 60px;
        }

        /* HEADER */
        .application-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 22px;
        }

        .application-header-left h2 {
            margin: 0;
            color: #e8edf7;
            font-size: 18px;
            font-weight: 700;
            line-height: 1.3;
        }

        .application-header-left p {
            margin: 5px 0 0;
            color: #8291aa;
            font-size: 12px;
        }

        .btn-search-job {
            display: inline-flex;
            align-items: center;
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
            box-shadow: 0 4px 12px rgba(232, 164, 1, .12);
            transition: .2s;
        }

        .btn-search-job:hover {
            background: #f3b21a;
            color: #111827;
        }

        /* =========================================================
        STATISTIC
        ========================================================= */

        .application-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
            margin-bottom: 17px;
        }

        .application-stat {
            height: 74px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;

            background: #0d172b;
            border: 1px solid #1d2a42;
            border-radius: 12px;
        }

        .application-stat-number {
            font-size: 21px;
            line-height: 1;
            font-weight: 700;
            color: #e7edf8;
            margin-bottom: 7px;
        }

        .application-stat-label {
            color: #8190a9;
            font-size: 10px;
            font-weight: 500;
            letter-spacing: .2px;
            text-transform: uppercase;
        }

        .stat-active .application-stat-number {
            color: #4ea1ff;
        }

        .stat-accepted .application-stat-number {
            color: #00d89a;
        }

        .stat-rejected .application-stat-number {
            color: #ff626c;
        }

        /* =========================================================
        FILTER
        ========================================================= */

        .application-filter {
            display: flex;
            align-items: center;
            gap: 7px;
            overflow-x: auto;
            padding-bottom: 3px;
            margin-bottom: 20px;
            scrollbar-width: none;
        }

        .application-filter::-webkit-scrollbar {
            display: none;
        }

        .application-filter button {
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

        .application-filter button:hover {
            border-color: #e8a401;
            color: #e8a401;
        }

        .application-filter button.active {
            color: #e8a401;
            border-color: #e8a401;
            background: rgba(232, 164, 1, .06);
        }

        /* =========================================================
        APPLICATION CARD
        ========================================================= */

        .application-card {
            position: relative;
            min-height: 140px;
            margin-bottom: 12px;
            padding: 16px 16px 14px;

            background: #0d172b;
            border: 1px solid #1d2a42;
            border-radius: 13px;

            transition: border-color .2s, transform .2s;
        }

        .application-card:hover {
            border-color: #2b3b59;
        }

        .application-card.accepted {
            border-color: rgba(0, 216, 154, .55);
        }

        .application-card.interview {
            border-color: rgba(232, 164, 1, .45);
        }

        .application-card.rejected {
            border-color: rgba(255, 98, 108, .35);
        }

        .application-card-top {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        /* Avatar */
        .company-avatar {
            width: 38px;
            height: 38px;
            flex: 0 0 38px;

            border-radius: 50%;
            overflow: hidden;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #17243c;
            border: 1px solid #293954;
        }

        .company-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .company-avatar i {
            color: #8090aa;
            font-size: 16px;
        }

        /* Content */
        .application-content {
            flex: 1;
            min-width: 0;
        }

        .application-title-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 10px;
        }

        .application-title {
            margin: 0;
            color: #e5ebf5;
            font-size: 14px;
            line-height: 1.35;
            font-weight: 700;
        }

        .application-company {
            margin-top: 2px;
            color: #8190a9;
            font-size: 11px;
            line-height: 1.4;
        }

        .application-meta {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 8px;
        }

        .application-salary {
            color: #edf2fa;
            font-size: 12px;
            font-weight: 700;
        }

        .application-badge {
            display: inline-flex;
            align-items: center;
            height: 21px;
            padding: 0 7px;

            border-radius: 4px;
            border: 1px solid #25344d;

            color: #8b9bb4;
            font-size: 9px;
            font-weight: 500;
        }

        .application-location {
            display: inline-flex;
            align-items: center;
            gap: 4px;

            color: #8190a9;
            font-size: 10px;
        }

        .application-location i {
            font-size: 11px;
        }

        /* Status */
        .application-status {
            flex-shrink: 0;

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

        .status-accepted {
            color: #00d89a;
            border: 1px solid rgba(0, 216, 154, .45);
            background: rgba(0, 216, 154, .06);
        }

        .status-interview {
            color: #e8a401;
            border: 1px solid rgba(232, 164, 1, .45);
            background: rgba(232, 164, 1, .06);
        }

        .status-process {
            color: #4ea1ff;
            border: 1px solid rgba(78, 161, 255, .45);
            background: rgba(78, 161, 255, .06);
        }

        .status-review {
            color: #8291aa;
            border: 1px solid #26354e;
            background: rgba(130, 145, 170, .05);
        }

        .status-rejected {
            color: #ff626c;
            border: 1px solid rgba(255, 98, 108, .4);
            background: rgba(255, 98, 108, .05);
        }

        .status-cancelled {
            color: #8291aa;
            border: 1px solid #26354e;
            background: rgba(130, 145, 170, .05);
        }

        /* Bottom */
        .application-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;

            margin-top: 14px;
        }

        .application-date {
            color: #71819b;
            font-size: 10px;
        }

        .btn-detail {
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

        .btn-detail:hover {
            color: #e8a401;
            border-color: #e8a401;
        }

        .application-title-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 15px;
        }


        .application-status {
            flex-shrink: 0;
        }


        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            padding: 4px 10px;

            border-radius: 999px;

            font-size: 10px;
            font-weight: 700;

            white-space: nowrap;
        }


        /* =====================================================
        APPLIED
        ===================================================== */

        .status-applied {

            color: #ffb400;

            background: rgba(255, 180, 0, .10);

            border: 1px solid rgba(255, 180, 0, .30);

        }


        /* =====================================================
        REVIEWED
        ===================================================== */

        .status-reviewed {

            color: #5aa9ff;

            background: rgba(90, 169, 255, .10);

            border: 1px solid rgba(90, 169, 255, .30);

        }


        /* =====================================================
        SHORTLISTED
        ===================================================== */

        .status-shortlisted {

            color: #35d39a;

            background: rgba(53, 211, 154, .10);

            border: 1px solid rgba(53, 211, 154, .30);

        }


        /* =====================================================
        REJECTED
        ===================================================== */

        .status-rejected {

            color: #ff6565;

            background: rgba(255, 101, 101, .10);

            border: 1px solid rgba(255, 101, 101, .30);

        }

        /* =========================================================
        RESPONSIVE
        ========================================================= */

        @media (max-width: 768px) {

            .application-page {
                max-width: 100%;
                padding: 0 15px 40px;
            }

            .application-header {
                gap: 15px;
            }

            .application-header-left h2 {
                font-size: 16px;
            }

            .application-stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .application-card {
                padding: 14px;
            }

            .application-title {
                font-size: 13px;
            }

            .application-bottom {
                padding-left: 0;
            }
        }

        @media (max-width: 480px) {

            .application-header {
                display: block;
            }

            .btn-search-job {
                margin-top: 12px;
            }

            .application-title-row {
                display: block;
            }

            .application-status {
                margin-top: 7px;
            }

            .application-bottom {
                gap: 10px;
            }
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
@endsection

@section('content')
    <div class="container-xxl">

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
                Hasil Lamaran Saya
            </span>

        </div>

        <div class="row g-4">

            <!-- Sidebar Kiri (Desktop Only) -->
            <div class="d-none d-lg-block col-lg-2">
                
            </div>

            <!-- Content (Selalu Tampil) -->
            <div class="col-12 col-lg-8">

                <div class="application-page">

                    {{-- =====================================================
                        HEADER
                    ====================================================== --}}

                    <div class="application-header">

                        <div class="application-header-left">

                            <h2>
                                Hasil Lamaran Saya
                            </h2>

                            <p>
                                {{ $totalApplications ?? 0 }} lamaran ·
                                {{ $totalActive ?? 0 }} aktif ·
                                {{ $totalShortlisted ?? 0 }} terpilih
                            </p>

                        </div>


                        <a href="{{ route('user-page.job-vacancy.index') }}"
                        class="btn-search-job">

                            <i class="ki-duotone ki-briefcase"></i>

                            Cari Lowongan

                        </a>

                    </div>

                    {{-- =====================================================
                        STATISTIC
                    ====================================================== --}}

                    <div class="application-stats">

                        {{-- TOTAL --}}
                        <div class="application-stat">

                            <div class="application-stat-number">
                                {{ $totalApplications ?? 0 }}
                            </div>

                            <div class="application-stat-label">
                                Total
                            </div>

                        </div>


                        {{-- AKTIF --}}
                        <div class="application-stat stat-active">

                            <div class="application-stat-number">
                                {{ $totalActive ?? 0 }}
                            </div>

                            <div class="application-stat-label">
                                Aktif
                            </div>

                        </div>


                        {{-- TERPILIH --}}
                        <div class="application-stat stat-accepted">

                            <div class="application-stat-number">
                                {{ $totalShortlisted ?? 0 }}
                            </div>

                            <div class="application-stat-label">
                                Terpilih
                            </div>

                        </div>


                        {{-- TIDAK LOLOS --}}
                        <div class="application-stat stat-rejected">

                            <div class="application-stat-number">
                                {{ $totalRejected ?? 0 }}
                            </div>

                            <div class="application-stat-label">
                                Tidak Lolos
                            </div>

                        </div>

                    </div>


                    {{-- =====================================================
                        FILTER STATUS
                    ====================================================== --}}

                    <div class="application-filter">

                        {{-- SEMUA --}}

                        <button
                            type="button"
                            class="active"
                            data-status="">

                            Semua

                            @if(($totalApplications ?? 0) > 0)
                                {{ $totalApplications }}
                            @endif

                        </button>


                        {{-- APPLIED --}}

                        <button
                            type="button"
                            data-status="applied">

                            Menunggu

                            @if(($totalApplied ?? 0) > 0)
                                {{ $totalApplied }}
                            @endif

                        </button>


                        {{-- REVIEWED --}}

                        <button
                            type="button"
                            data-status="reviewed">

                            Diproses

                            @if(($totalReviewed ?? 0) > 0)
                                {{ $totalReviewed }}
                            @endif

                        </button>


                        {{-- SHORTLISTED --}}

                        <button
                            type="button"
                            data-status="shortlisted">

                            Terpilih

                            @if(($totalShortlisted ?? 0) > 0)
                                {{ $totalShortlisted }}
                            @endif

                        </button>


                        {{-- REJECTED --}}

                        <button
                            type="button"
                            data-status="rejected">

                            Tidak Lolos

                            @if(($totalRejected ?? 0) > 0)
                                {{ $totalRejected }}
                            @endif

                        </button>

                    </div>

                    {{-- =====================================================
                        APPLICATION LIST
                    ====================================================== --}}

                    <div
                        id="applicationList"
                        class="application-list">

                        {{-- AJAX DATA MASUK DI SINI --}}

                    </div>


                    {{-- =====================================================
                        LOADING
                    ====================================================== --}}

                    <div
                        id="applicationLoading"
                        class="text-center py-4 d-none">

                        <div
                            class="spinner-border spinner-border-sm text-warning">
                        </div>

                        <div class="mt-2 application-loading-text">
                            Memuat lamaran...
                        </div>

                    </div>


                    {{-- =====================================================
                        END
                    ====================================================== --}}

                    <div
                        id="applicationEnd"
                        class="text-center py-4 d-none">

                        <div class="application-loading-text">
                            Semua lamaran sudah ditampilkan.
                        </div>

                    </div>

                </div>

            </div>

            <!-- Sidebar Kanan (Desktop Only) -->
            <div class="d-none d-lg-block col-lg-2">

            </div>

        </div>
    </div>
@endsection

@section('js')
    <script>

        let currentApplicationRequest = null;

        let currentApplicationPage = 1;

        let isLoadingApplications = false;

        let hasMoreApplications = true;


        /*
        |--------------------------------------------------------------------------
        | LOAD APPLICATIONS
        |--------------------------------------------------------------------------
        */

        function loadApplications(
            page = 1,
            reset = true,
            updateUrl = true
        ) {

            /*
            |--------------------------------------------------------------------------
            | CEGAH REQUEST GANDA
            |--------------------------------------------------------------------------
            */

            if (isLoadingApplications) {
                return;
            }


            /*
            |--------------------------------------------------------------------------
            | CEK MASIH ADA DATA
            |--------------------------------------------------------------------------
            */

            if (!reset && !hasMoreApplications) {
                return;
            }


            /*
            |--------------------------------------------------------------------------
            | PARAMETER
            |--------------------------------------------------------------------------
            */

            const params = {

                status:
                    $('.application-filter button.active').data('status') || '',

                search:
                    $('#applicationSearch').val() || '',

                sort:
                    $('#applicationSort').val() || 'latest',

                page: page

            };


            /*
            |--------------------------------------------------------------------------
            | ABORT REQUEST SEBELUMNYA
            |--------------------------------------------------------------------------
            */

            if (currentApplicationRequest) {
                currentApplicationRequest.abort();
            }


            isLoadingApplications = true;


            /*
            |--------------------------------------------------------------------------
            | LOADING
            |--------------------------------------------------------------------------
            */

            $('#applicationLoading').removeClass('d-none');


            /*
            |--------------------------------------------------------------------------
            | AJAX
            |--------------------------------------------------------------------------
            */

            currentApplicationRequest = $.ajax({

                url: "{{ route('user-page.job-vacancy.my-list') }}",

                type: "GET",

                data: params,

                dataType: "json",


                /*
                |--------------------------------------------------------------------------
                | SUCCESS
                |--------------------------------------------------------------------------
                */

                success: function(response) {

                    /*
                    |--------------------------------------------------------------------------
                    | VALIDASI RESPONSE
                    |--------------------------------------------------------------------------
                    */

                    if (!response || !response.success) {
                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | RESET LIST
                    |--------------------------------------------------------------------------
                    */

                    if (reset) {

                        $('#applicationList').html(
                            response.html
                        );

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | APPEND LIST
                    |--------------------------------------------------------------------------
                    */

                    else {

                        $('#applicationList').append(
                            response.html
                        );

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | CURRENT PAGE
                    |--------------------------------------------------------------------------
                    */

                    currentApplicationPage =
                        parseInt(
                            response.current_page,
                            10
                        ) || page;


                    /*
                    |--------------------------------------------------------------------------
                    | HAS MORE
                    |--------------------------------------------------------------------------
                    */

                    hasMoreApplications =
                        Boolean(response.has_more);


                    /*
                    |--------------------------------------------------------------------------
                    | END OF DATA
                    |--------------------------------------------------------------------------
                    */

                    if (hasMoreApplications) {

                        $('#applicationEnd')
                            .addClass('d-none');

                    } else {

                        $('#applicationEnd')
                            .removeClass('d-none');

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | UPDATE URL
                    |--------------------------------------------------------------------------
                    */

                    if (
                        updateUrl &&
                        reset
                    ) {

                        const url = new URL(
                            window.location.href
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | STATUS
                        |--------------------------------------------------------------------------
                        */

                        if (params.status) {

                            url.searchParams.set(
                                'status',
                                params.status
                            );

                        } else {

                            url.searchParams.delete(
                                'status'
                            );

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | SEARCH
                        |--------------------------------------------------------------------------
                        */

                        if (params.search) {

                            url.searchParams.set(
                                'search',
                                params.search
                            );

                        } else {

                            url.searchParams.delete(
                                'search'
                            );

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | SORT
                        |--------------------------------------------------------------------------
                        */

                        if (
                            params.sort &&
                            params.sort !== 'latest'
                        ) {

                            url.searchParams.set(
                                'sort',
                                params.sort
                            );

                        } else {

                            url.searchParams.delete(
                                'sort'
                            );

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | PAGE TIDAK DISIMPAN
                        |--------------------------------------------------------------------------
                        */

                        url.searchParams.delete(
                            'page'
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | UPDATE BROWSER URL
                        |--------------------------------------------------------------------------
                        */

                        window.history.pushState(
                            {},
                            '',
                            url
                        );

                    }

                },


                /*
                |--------------------------------------------------------------------------
                | ERROR
                |--------------------------------------------------------------------------
                */

                error: function(
                    xhr,
                    status,
                    error
                ) {

                    /*
                    |--------------------------------------------------------------------------
                    | REQUEST DIABORT
                    |--------------------------------------------------------------------------
                    */

                    if (status === 'abort') {
                        return;
                    }


                    console.error(
                        'Load applications error:',
                        error
                    );


                    console.error(
                        xhr.responseText
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | ERROR MESSAGE
                    |--------------------------------------------------------------------------
                    */

                    if (reset) {

                        $('#applicationList').html(`

                            <div class="text-center py-5">

                                <div class="text-danger mb-2">
                                    Gagal memuat lamaran
                                </div>

                                <div class="text-muted">
                                    Silakan coba lagi.
                                </div>

                            </div>

                        `);

                    }

                },


                /*
                |--------------------------------------------------------------------------
                | COMPLETE
                |--------------------------------------------------------------------------
                */

                complete: function() {

                    isLoadingApplications = false;

                    currentApplicationRequest = null;

                    $('#applicationLoading')
                        .addClass('d-none');

                }

            });

        }


        /*
        |--------------------------------------------------------------------------
        | INTERSECTION OBSERVER
        |--------------------------------------------------------------------------
        |
        | Tidak bergantung kepada scroll Metronic.
        |
        */

        let applicationObserver = null;


        function initApplicationObserver()
        {

            /*
            |--------------------------------------------------------------------------
            | HAPUS OBSERVER LAMA
            |--------------------------------------------------------------------------
            */

            if (applicationObserver) {

                applicationObserver.disconnect();

            }


            /*
            |--------------------------------------------------------------------------
            | TARGET
            |--------------------------------------------------------------------------
            */

            const target =
                document.getElementById(
                    'applicationEnd'
                );


            if (!target) {

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | OBSERVER
            |--------------------------------------------------------------------------
            */

            applicationObserver =
                new IntersectionObserver(

                    function(entries) {

                        const entry =
                            entries[0];


                        if (
                            entry.isIntersecting &&
                            !isLoadingApplications &&
                            hasMoreApplications
                        ) {

                            loadApplications(
                                currentApplicationPage + 1,
                                false,
                                false
                            );

                        }

                    },

                    {

                        root: null,

                        rootMargin:
                            '500px 0px',

                        threshold: 0

                    }

                );


            applicationObserver.observe(
                target
            );

        }


        /*
        |--------------------------------------------------------------------------
        | STATUS FILTER
        |--------------------------------------------------------------------------
        */

        $(document).on(
            'click',
            '.application-filter button',
            function() {

                /*
                |--------------------------------------------------------------------------
                | ACTIVE
                |--------------------------------------------------------------------------
                */

                $('.application-filter button')
                    .removeClass('active');


                $(this)
                    .addClass('active');


                /*
                |--------------------------------------------------------------------------
                | RESET
                |--------------------------------------------------------------------------
                */

                currentApplicationPage = 1;

                hasMoreApplications = true;


                /*
                |--------------------------------------------------------------------------
                | LOAD
                |--------------------------------------------------------------------------
                */

                loadApplications(
                    1,
                    true,
                    true
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        $('#applicationSearch').on(
            'input',
            function() {

                clearTimeout(
                    applicationFilterTimer
                );


                applicationFilterTimer =
                    setTimeout(
                        function() {

                            currentApplicationPage =
                                1;

                            hasMoreApplications =
                                true;


                            loadApplications(
                                1,
                                true,
                                true
                            );

                        },
                        400
                    );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | SORT
        |--------------------------------------------------------------------------
        */

        $('#applicationSort').on(
            'change',
            function() {

                currentApplicationPage =
                    1;

                hasMoreApplications =
                    true;


                loadApplications(
                    1,
                    true,
                    true
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | BROWSER BACK / FORWARD
        |--------------------------------------------------------------------------
        */

        window.addEventListener(
            'popstate',
            function() {

                const params =
                    new URLSearchParams(
                        window.location.search
                    );


                /*
                |--------------------------------------------------------------------------
                | SEARCH
                |--------------------------------------------------------------------------
                */

                $('#applicationSearch')
                    .val(
                        params.get('search') || ''
                    );


                /*
                |--------------------------------------------------------------------------
                | SORT
                |--------------------------------------------------------------------------
                */

                $('#applicationSort')
                    .val(
                        params.get('sort') || 'latest'
                    );


                /*
                |--------------------------------------------------------------------------
                | STATUS
                |--------------------------------------------------------------------------
                */

                const status =
                    params.get('status') || '';


                $('.application-filter button')
                    .removeClass('active');


                $('.application-filter button')
                    .filter(
                        function() {

                            return (
                                $(this)
                                    .data('status') === status
                            );

                        }
                    )
                    .addClass('active');


                /*
                |--------------------------------------------------------------------------
                | LOAD
                |--------------------------------------------------------------------------
                */

                currentApplicationPage =
                    1;

                hasMoreApplications =
                    true;


                loadApplications(
                    1,
                    true,
                    false
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | INITIAL LOAD
        |--------------------------------------------------------------------------
        */

        $(document).ready(
            function() {

                const params =
                    new URLSearchParams(
                        window.location.search
                    );


                /*
                |--------------------------------------------------------------------------
                | SEARCH
                |--------------------------------------------------------------------------
                */

                $('#applicationSearch')
                    .val(
                        params.get('search') || ''
                    );


                /*
                |--------------------------------------------------------------------------
                | SORT
                |--------------------------------------------------------------------------
                */

                $('#applicationSort')
                    .val(
                        params.get('sort') || 'latest'
                    );


                /*
                |--------------------------------------------------------------------------
                | STATUS
                |--------------------------------------------------------------------------
                */

                const status =
                    params.get('status') || '';


                $('.application-filter button')
                    .removeClass('active');


                $('.application-filter button')
                    .filter(
                        function() {

                            return (
                                $(this)
                                    .data('status') === status
                            );

                        }
                    )
                    .addClass('active');


                /*
                |--------------------------------------------------------------------------
                | LOAD DATA
                |--------------------------------------------------------------------------
                */

                loadApplications(
                    1,
                    true,
                    false
                );


                /*
                |--------------------------------------------------------------------------
                | OBSERVER
                |--------------------------------------------------------------------------
                */

                initApplicationObserver();

            }
        );

        $(window).on(
            'scroll',
            function() {

                if (isLoadingApplications) {
                    return;
                }


                if (!hasMoreApplications) {
                    return;
                }


                const scrollTop =
                    $(window).scrollTop();

                const windowHeight =
                    $(window).height();

                const documentHeight =
                    $(document).height();


                /*
                |--------------------------------------------------------------------------
                | 500 PX SEBELUM BAWAH
                |--------------------------------------------------------------------------
                */

                const distanceFromBottom =
                    documentHeight -
                    (scrollTop + windowHeight);


                if (distanceFromBottom <= 500) {

                    loadApplications(
                        currentApplicationPage + 1,
                        false,
                        false
                    );

                }

            }
        );

        </script>
@endsection
