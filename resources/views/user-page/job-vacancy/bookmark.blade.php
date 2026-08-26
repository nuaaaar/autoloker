@extends('layouts.user-page')

@section('title', 'Bookmark Lowongan')

@section('style')
    <style>
        /* =========================================
        BOOKMARK PAGE
        ========================================= */

        .bookmark-page {
            max-width: 700px;
            margin: 0 auto;
            padding: 24px 0 60px;
        }

        /* Breadcrumb */
        .bookmark-breadcrumb {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 12px;
            color: #8190a8;
            margin-bottom: 24px;
        }

        .bookmark-breadcrumb i {
            font-size: 13px;
        }

        .bookmark-breadcrumb .active {
            color: #dce3ef;
            font-weight: 600;
        }

        /* Header */
        .bookmark-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 18px;
        }

        .bookmark-title {
            margin: 0;
            color: #e5eaf3;
            font-size: 18px;
            font-weight: 700;
            line-height: 1.3;
        }

        .bookmark-subtitle {
            margin-top: 5px;
            color: #8190a8;
            font-size: 12px;
        }

        /* Search */
        .bookmark-search {
            width: 130px;
            height: 34px;
            border: 1px solid #24324d;
            border-radius: 9px;
            background: transparent;
            color: #91a0b8;
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 0 11px;
            font-size: 11px;
            white-space: nowrap;
        }

        .bookmark-search i {
            font-size: 13px;
        }

        /* Urgent */
        .urgent-summary {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            border: 1px solid #806300;
            background: rgba(255, 183, 0, .08);
            color: #ffbd00;
            border-radius: 8px;
            padding: 7px 11px;
            font-size: 11px;
            font-weight: 600;
            margin-bottom: 22px;
        }

        /* Toolbar */
        .bookmark-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 11px;
            color: #8190a8;
        }

        .bookmark-sort {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .bookmark-sort-item {
            padding: 6px 9px;
            border-radius: 8px;
            color: #8190a8;
            cursor: pointer;
            white-space: nowrap;
        }

        .bookmark-sort-item.active {
            color: #ffb900;
            border: 1px solid #6c570f;
            background: rgba(255, 185, 0, .06);
            font-weight: 600;
        }

        /* =========================================
        BOOKMARK CARD
        ========================================= */

        .bookmark-card {
            background: #0d1629;
            border: 1px solid #1d2a42;
            border-radius: 13px;
            padding: 17px;
            margin-bottom: 12px;
            transition: .2s ease;
        }

        .bookmark-card:hover {
            border-color: #35435d;
        }

        .bookmark-card.urgent {
            border-color: #725b0c;
        }

        /* Card Header */
        .bookmark-card-top {
            display: flex;
            justify-content: space-between;
            gap: 15px;
        }

        .bookmark-urgent {
            color: #ffbf00;
            font-size: 10px;
            font-weight: 700;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 5px;
            text-transform: uppercase;
        }

        .bookmark-job-title {
            color: #e5eaf3;
            font-size: 14px;
            font-weight: 700;
            line-height: 1.35;
            margin: 0;
        }

        .bookmark-company {
            color: #8291aa;
            font-size: 11px;
            margin-top: 3px;
        }

        .bookmark-icon {
            color: #ffbd00;
            font-size: 17px;
            flex-shrink: 0;
            padding-top: 25px;
        }

        /* Location */
        .bookmark-info {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 14px;
            margin-top: 9px;
            color: #8392aa;
            font-size: 10px;
        }

        .bookmark-info span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .bookmark-info i {
            font-size: 12px;
        }

        /* Salary */
        .bookmark-meta {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 12px;
        }

        .bookmark-salary {
            color: #e6eaf1;
            font-size: 13px;
            font-weight: 700;
        }

        .bookmark-badge {
            border: 1px solid #26344e;
            border-radius: 5px;
            color: #94a4bd;
            padding: 3px 7px;
            font-size: 9px;
        }

        .bookmark-applicants {
            color: #8090a8;
            font-size: 10px;
        }

        /* Bottom info */
        .bookmark-bottom-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-top: 9px;
            color: #8090a8;
            font-size: 10px;
        }

        .bookmark-deadline {
            text-align: right;
        }

        .bookmark-deadline strong {
            color: #ffbd00;
            font-weight: 600;
        }

        /* Buttons */
        .bookmark-actions {
            display: flex;
            gap: 8px;
            margin-top: 12px;
        }

        .bookmark-btn-detail,
        .bookmark-btn-apply {
            height: 33px;
            border-radius: 8px;
            font-size: 10px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: .2s ease;
        }

        .bookmark-btn-detail {
            flex: 1;
            background: transparent;
            border: 1px solid #24324b;
            color: #8292ab;
        }

        .bookmark-btn-detail:hover {
            border-color: #40506c;
            color: #dce3ef;
        }

        .bookmark-btn-apply {
            flex: 1;
            background: #ffb700;
            border: 1px solid #ffb700;
            color: #101827;
        }

        .bookmark-btn-apply:hover {
            background: #ffc52c;
        }

        /* Mobile */
        @media (max-width: 768px) {

            .bookmark-page {
                padding: 18px 15px 50px;
            }

            .bookmark-header {
                align-items: center;
            }

            .bookmark-title {
                font-size: 16px;
            }

            .bookmark-search {
                width: 110px;
            }

            .bookmark-toolbar {
                align-items: flex-start;
                gap: 8px;
            }

            .bookmark-sort {
                gap: 2px;
                overflow-x: auto;
            }

            .bookmark-sort-item {
                padding: 5px 7px;
            }

            .bookmark-bottom-info {
                align-items: flex-start;
            }
        }
    </style>

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
        BOOKMARK TOOLBAR
        ========================================================= */

        .bookmark-toolbar {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 24px;
            color: #7f91ad;
            font-size: 13px;
        }


        /* =========================================================
        SORT AREA
        ========================================================= */

        .bookmark-sort {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 6px;
            flex-wrap: wrap;
        }

        .bookmark-sort > span:first-child {
            margin-right: 4px;
            color: #7f91ad;
        }


        /* =========================================================
        SORT BUTTON
        ========================================================= */

        .bookmark-sort-item {
            appearance: none;
            -webkit-appearance: none;

            border: 1px solid transparent;
            outline: none;

            background: transparent;
            color: #8294af;

            font-family: inherit;
            font-size: 10px;
            font-weight: 500;

            line-height: 1;
            white-space: nowrap;

            padding: 9px 12px;
            border-radius: 9px;

            cursor: pointer;

            transition:
                color .2s ease,
                background-color .2s ease,
                border-color .2s ease,
                box-shadow .2s ease;
        }


        /* Hover */

        .bookmark-sort-item:hover {
            color: #eeb000;
            background: rgba(238, 176, 0, .06);
            border-color: rgba(238, 176, 0, .18);
        }


        /* Active */

        .bookmark-sort-item.active {
            color: #f5b400;

            background: rgba(245, 180, 0, .08);

            border-color: rgba(245, 180, 0, .45);

            box-shadow:
                0 0 0 1px rgba(245, 180, 0, .03);
        }


        /* Active + hover */

        .bookmark-sort-item.active:hover {
            color: #ffc21a;
            background: rgba(245, 180, 0, .12);
            border-color: rgba(245, 180, 0, .55);
        }


        /* =========================================================
        FOCUS
        ========================================================= */

        .bookmark-sort-item:focus {
            outline: none;
        }

        .bookmark-sort-item:focus-visible {
            outline: 2px solid rgba(245, 180, 0, .4);
            outline-offset: 2px;
        }


        /* =========================================================
        MOBILE
        ========================================================= */

        @media (max-width: 767.98px) {

            .bookmark-toolbar {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .bookmark-sort {
                width: 100%;
                justify-content: flex-start;
                overflow-x: auto;
                flex-wrap: nowrap;
                padding-bottom: 3px;

                scrollbar-width: none;
            }

            .bookmark-sort::-webkit-scrollbar {
                display: none;
            }

            .bookmark-sort > span:first-child {
                flex-shrink: 0;
            }

            .bookmark-sort-item {
                flex-shrink: 0;
                font-size: 12px;
                padding: 8px 10px;
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

    <style>
        .bookmark-meta-break {
            flex-basis: 100%;
            height: 0;
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
                Bookmark Lowongan
            </span>

        </div>

        <div class="row g-4">

            <!-- Sidebar Kiri (Desktop Only) -->
            <div class="d-none d-lg-block col-lg-2">
                
            </div>

            <!-- Content (Selalu Tampil) -->
            <div class="col-12 col-lg-8">
                <div class="bookmark-page">


            {{-- HEADER --}}
            <div class="bookmark-header">

                <div>

                    <h1 class="bookmark-title">
                        Bookmark Lowongan
                    </h1>

                    <div class="bookmark-subtitle">

                        {{ $totalBookmarks }} lowongan tersimpan

                        ·

                        {{ $totalAppliedBookmarks }} sudah dilamar

                    </div>

                </div>


                {{-- <button type="button" class="bookmark-search">

                    <i class="ki-duotone ki-magnifier"></i>

                    Cari Lowongan

                </button> --}}

            </div>


            {{-- URGENT SUMMARY --}}
            @if($totalUrgent > 0)

                <div class="urgent-summary">

                    <span>⚡</span>

                    {{ $totalUrgent }} lowongan urgent

                </div>

            @endif


            {{-- TOOLBAR --}}
            <div class="bookmark-toolbar">

                <span>
                    {{ $totalBookmarks }} lowongan tersimpan
                </span>

                <div class="bookmark-sort">

                    <span>
                        Urutkan:
                    </span>

                    <button
                        type="button"
                        class="bookmark-sort-item {{ $sort == 'latest' ? 'active' : '' }}"
                        data-sort="latest">

                        Terbaru Disimpan

                    </button>

                    <button
                        type="button"
                        class="bookmark-sort-item {{ $sort == 'deadline' ? 'active' : '' }}"
                        data-sort="deadline">

                        Deadline Terdekat

                    </button>

                    <button
                        type="button"
                        class="bookmark-sort-item {{ $sort == 'applicants' ? 'active' : '' }}"
                        data-sort="applicants">

                        Pelamar Tersedikit

                    </button>

                </div>

            </div>

            {{-- ================================================= --}}
            {{-- DUMMY JOB 1 --}}
            {{-- ================================================= --}}

            <div id="bookmarkList">

                @include(
                    'user-page.job-vacancy.partials.bookmark-list',
                    [
                        'bookmarks' => $bookmarks
                    ]
                )

            </div>


            {{-- ================================================= --}}
            {{-- LOADING --}}
            {{-- ================================================= --}}

            <div
                id="bookmarkLoading"
                class="text-center py-4 d-none"
            >

                <div class="spinner-border spinner-border-sm text-warning"></div>

                <span class="ms-2">
                    Memuat lowongan tersimpan...
                </span>

            </div>


            {{-- ================================================= --}}
            {{-- END --}}
            {{-- ================================================= --}}

            <div
                id="bookmarkEnd"
                class="text-center py-4 d-none"
            >

                <span class="text-muted">

                    Semua lowongan tersimpan sudah ditampilkan.

                </span>

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
        $(document).on('click', '.bookmark-sort-item', function () {

            let sort = $(this).data('sort');

            let url = new URL(window.location.href);

            url.searchParams.set('sort', sort);

            window.location.href = url.toString();

        });

        function applyJob(button, uuid)
        {
            Swal.fire({
                title: 'Lamar Lowongan?',
                text: 'Apakah Anda yakin ingin melamar lowongan ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Lamar',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {

                if (!result.isConfirmed) {
                    return;
                }

                const $button = $(button);

                $button.prop('disabled', true);

                $.ajax({

                    url: `/user-page/job-vacancy/${uuid}/apply`,

                    type: "POST",

                    data: {
                        _token: "{{ csrf_token() }}",
                    },

                    success: function(response) {

                        if (response.success) {

                            $button
                                .html('<i class="ki-duotone ki-check me-1"></i> Sudah Dilamar')
                                .attr(
                                    'onclick',
                                    `cancelApplyJob(this, '${uuid}')`
                                );

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Lamaran berhasil dikirim.',
                                timer: 1500,
                                showConfirmButton: false
                            });

                        }

                    },

                    error: function(xhr) {

                        console.log(xhr.responseText);

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: xhr.responseJSON?.message
                                ?? 'Terjadi kesalahan saat mengirim lamaran.'
                        });

                    },

                    complete: function() {

                        $button.prop('disabled', false);

                    }

                });

            });
        }

        function cancelApplyJob(button, uuid)
        {
            Swal.fire({
                title: 'Batalkan Lamaran?',
                text: 'Apakah Anda yakin ingin membatalkan lamaran pada lowongan ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Batalkan',
                cancelButtonText: 'Tidak',
                reverseButtons: true
            }).then((result) => {

                if (!result.isConfirmed) {
                    return;
                }

                const $button = $(button);

                $button.prop('disabled', true);

                $.ajax({

                    url: `/user-page/job-vacancy/${uuid}/cancel-apply`,

                    type: "DELETE",

                    data: {
                        _token: "{{ csrf_token() }}"
                    },

                    success: function(response) {

                        if (response.success) {

                            $button
                                .html('Lamar Sekarang')
                                .attr(
                                    'onclick',
                                    `applyJob(this, '${uuid}')`
                                );

                            Swal.fire({
                                icon: 'success',
                                title: 'Lamaran Dibatalkan',
                                text: 'Lamaran Anda berhasil dibatalkan.',
                                timer: 1500,
                                showConfirmButton: false
                            });

                        }

                    },

                    error: function(xhr) {

                        console.log(xhr.responseText);

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: xhr.responseJSON?.message
                                ?? 'Terjadi kesalahan saat membatalkan lamaran.'
                        });

                    },

                    complete: function() {

                        $button.prop('disabled', false);

                    }

                });
            });
        }

        let bookmarkRequest = null;

        let bookmarkPage = 1;

        let bookmarkLoading = false;

        let bookmarkHasMore = true;


        /*
        |--------------------------------------------------------------------------
        | LOAD BOOKMARK
        |--------------------------------------------------------------------------
        */

        function loadBookmarks(
            page = 1,
            reset = false
        ) {

            /*
            |--------------------------------------------------------------------------
            | CEGAH REQUEST GANDA
            |--------------------------------------------------------------------------
            */

            if (bookmarkLoading) {
                return;
            }


            /*
            |--------------------------------------------------------------------------
            | CEK DATA
            |--------------------------------------------------------------------------
            */

            if (
                !reset &&
                !bookmarkHasMore
            ) {

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | STATE
            |--------------------------------------------------------------------------
            */

            bookmarkLoading = true;


            /*
            |--------------------------------------------------------------------------
            | LOADING
            |--------------------------------------------------------------------------
            */

            $('#bookmarkLoading')
                .removeClass('d-none');


            /*
            |--------------------------------------------------------------------------
            | REQUEST
            |--------------------------------------------------------------------------
            */

            bookmarkRequest = $.ajax({

                url: "{{ route('user-page.job-vacancy.bookmark') }}",

                type: "GET",

                data: {

                    page: page,

                    sort:
                        $('#bookmarkSort').val()
                        || "{{ $sort }}"

                },

                dataType: "json",


                /*
                |--------------------------------------------------------------------------
                | SUCCESS
                |--------------------------------------------------------------------------
                */

                success: function(response) {

                    if (
                        !response ||
                        !response.success
                    ) {

                        return;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | RESET
                    |--------------------------------------------------------------------------
                    */

                    if (reset) {

                        $('#bookmarkList')
                            .html(response.html);

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | APPEND
                    |--------------------------------------------------------------------------
                    */

                    else {

                        $('#bookmarkList')
                            .append(response.html);

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | PAGE
                    |--------------------------------------------------------------------------
                    */

                    bookmarkPage =
                        parseInt(
                            response.current_page
                        ) || page;


                    /*
                    |--------------------------------------------------------------------------
                    | HAS MORE
                    |--------------------------------------------------------------------------
                    */

                    bookmarkHasMore =
                        response.has_more === true;


                    /*
                    |--------------------------------------------------------------------------
                    | END
                    |--------------------------------------------------------------------------
                    */

                    if (bookmarkHasMore) {

                        $('#bookmarkEnd')
                            .addClass('d-none');

                    }

                    else {

                        $('#bookmarkEnd')
                            .removeClass('d-none');

                    }

                },


                /*
                |--------------------------------------------------------------------------
                | ERROR
                |--------------------------------------------------------------------------
                */

                error: function(
                    xhr,
                    status
                ) {

                    if (
                        status === 'abort'
                    ) {

                        return;

                    }


                    console.error(
                        'Bookmark error:',
                        xhr.responseText
                    );

                },


                /*
                |--------------------------------------------------------------------------
                | COMPLETE
                |--------------------------------------------------------------------------
                */

                complete: function() {

                    bookmarkLoading = false;

                    bookmarkRequest = null;


                    $('#bookmarkLoading')
                        .addClass('d-none');

                }

            });

        }


        /*
        |--------------------------------------------------------------------------
        | INFINITE SCROLL
        |--------------------------------------------------------------------------
        */

        $(window).on(
            'scroll.bookmark',
            function() {

                /*
                |--------------------------------------------------------------------------
                | CEGAH REQUEST
                |--------------------------------------------------------------------------
                */

                if (
                    bookmarkLoading ||
                    !bookmarkHasMore
                ) {

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | POSISI SCROLL
                |--------------------------------------------------------------------------
                */

                const scrollTop =
                    $(window).scrollTop();

                const windowHeight =
                    $(window).height();

                const documentHeight =
                    $(document).height();


                /*
                |--------------------------------------------------------------------------
                | JARAK KE BAWAH
                |--------------------------------------------------------------------------
                */

                const distanceFromBottom =
                    documentHeight -
                    (
                        scrollTop +
                        windowHeight
                    );


                /*
                |--------------------------------------------------------------------------
                | LOAD 500PX SEBELUM BAWAH
                |--------------------------------------------------------------------------
                */

                if (
                    distanceFromBottom <= 500
                ) {

                    loadBookmarks(
                        bookmarkPage + 1,
                        false
                    );

                }

            }
        );

        $('#bookmarkSort').on(
            'change',
            function() {

                /*
                |--------------------------------------------------------------------------
                | RESET
                |--------------------------------------------------------------------------
                */

                bookmarkPage = 1;

                bookmarkHasMore = true;

                bookmarkLoading = false;


                $('#bookmarkEnd')
                    .addClass('d-none');


                /*
                |--------------------------------------------------------------------------
                | LOAD PAGE 1
                |--------------------------------------------------------------------------
                */

                loadBookmarks(
                    1,
                    true
                );

            }
        );
    </script>

@endsection