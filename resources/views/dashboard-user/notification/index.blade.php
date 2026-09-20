@extends('layouts.dashboard-user')

@section('title', 'Notifikasi')

@section('css')

<style>

    /* =========================================================
       NOTIFICATION PAGE
    ========================================================= */

    .notification-page-card{

        background:#11192d;

        border:1px solid rgba(255,255,255,.06);

        border-radius:18px;

        overflow:hidden;

    }


    /* =========================================================
       HEADER
    ========================================================= */

    .notification-page-header{

        padding:18px 22px;

        border-bottom:1px solid rgba(255,255,255,.06);

    }


    .notification-page-title{

        color:#fff;

        font-size:15px;

        font-weight:700;

        margin:0;

    }


    .notification-page-subtitle{

        color:#8796b5;

        font-size:11px;

        margin-top:4px;

    }


    .notification-unread-info{

        display:flex;

        align-items:center;

        gap:6px;

        color:#91a0bc;

        font-size:10px;

    }


    .notification-unread-info .dot{

        width:7px;

        height:7px;

        background:#f7b003;

        border-radius:50%;

    }


    /* =========================================================
       FILTER
    ========================================================= */

    .notification-filter{

        padding:16px 22px;

        background:#0f172a;

        border-bottom:1px solid rgba(255,255,255,.05);

    }


    .notification-filter-label{

        color:#8d9bb5;

        font-size:10px;

        font-weight:600;

        margin-bottom:6px;

    }


    .notification-filter-input{

        height:38px;

        background:#151f36;

        border:1px solid #293651;

        border-radius:10px;

        color:#dce4f2;

        font-size:11px;

        padding:7px 11px;

        outline:none;

    }


    .notification-filter-input:focus{

        border-color:#f7b003;

        box-shadow:none;

    }


    .notification-filter-input::placeholder{

        color:#64748b;

    }


    .notification-filter-select{

        height:38px;

        background:#151f36;

        border:1px solid #293651;

        border-radius:10px;

        color:#dce4f2;

        font-size:11px;

        padding:7px 32px 7px 11px;

    }


    .notification-filter-select:focus{

        border-color:#f7b003;

        box-shadow:none;

    }


    .btn-notification-filter{

        height:38px;

        padding:0 17px;

        border:none;

        border-radius:10px;

        background:#f7b003;

        color:#111827;

        font-size:11px;

        font-weight:700;

    }


    .btn-notification-filter:hover{

        background:#ffc928;

        color:#111827;

    }


    .btn-notification-reset{

        height:38px;

        padding:0 14px;

        border:1px solid #293651;

        border-radius:10px;

        background:#151f36;

        color:#8796b5;

        font-size:11px;

        font-weight:600;

    }


    .btn-notification-reset:hover{

        border-color:#44516c;

        color:#fff;

    }


    /* =========================================================
       QUICK PERIOD
    ========================================================= */

    .notification-period{

        display:flex;

        align-items:center;

        gap:6px;

        margin-top:12px;

    }


    .notification-period-label{

        color:#687892;

        font-size:10px;

        margin-right:4px;

    }


    .notification-period-btn{

        padding:5px 10px;

        background:#151f36;

        border:1px solid #293651;

        border-radius:8px;

        color:#8292ad;

        font-size:9px;

        font-weight:600;

        text-decoration:none;

        transition:.2s;

    }


    .notification-period-btn:hover{

        color:#f7b003;

        border-color:#f7b00366;

    }


    .notification-period-btn.active{

        background:#2b241d;

        border-color:#f7b00366;

        color:#f7b003;

    }


    /* =========================================================
       ACTION HEADER
    ========================================================= */

    .notification-list-header{

        display:flex;

        align-items:center;

        justify-content:space-between;

        padding:15px 22px;

        border-bottom:1px solid rgba(255,255,255,.05);

    }


    .notification-list-title{

        color:#dce4f2;

        font-size:12px;

        font-weight:700;

    }


    .notification-mark-all{

        color:#f7b003;

        font-size:10px;

        font-weight:600;

        text-decoration:none;

    }


    .notification-mark-all:hover{

        color:#ffc928;

    }


    /* =========================================================
       NOTIFICATION ITEM
    ========================================================= */

    .notification-item{

        display:flex;

        align-items:flex-start;

        gap:13px;

        padding:16px 22px;

        border-bottom:1px solid rgba(255,255,255,.05);

        text-decoration:none;

        transition:.2s;

    }


    .notification-item:last-child{

        border-bottom:none;

    }


    .notification-item:hover{

        background:#151f36;

    }


    .notification-item.unread{

        background:#141e34;

    }


    .notification-item.unread:hover{

        background:#192642;

    }


    /* =========================================================
       ICON
    ========================================================= */

    .notification-item-icon{

        width:40px;

        height:40px;

        flex:0 0 40px;

        display:flex;

        align-items:center;

        justify-content:center;

        border-radius:12px;

        background:#1c2948;

        color:#8ea5ff;

    }


    .notification-item-icon i{

        font-size:18px;

    }


    .notification-item-icon.warning{

        color:#f7b003;

    }


    .notification-item-icon.danger{

        color:#ff6277;

    }


    .notification-item-icon.success{

        color:#00d99b;

    }


    .notification-item-icon.purple{

        color:#a875ff;

    }


    .notification-item-icon.info{

        color:#5da8ff;

    }


    /* =========================================================
       CONTENT
    ========================================================= */

    .notification-item-content{

        min-width:0;

        flex:1;

    }


    .notification-item-top{

        display:flex;

        align-items:flex-start;

        justify-content:space-between;

        gap:15px;

    }


    .notification-item-title{

        color:#e6ebf4;

        font-size:12px;

        font-weight:700;

        line-height:1.4;

    }


    .notification-item.unread .notification-item-title{

        color:#fff;

    }


    .notification-item-date{

        flex-shrink:0;

        color:#667791;

        font-size:9px;

        white-space:nowrap;

    }


    .notification-item-description{

        color:#8796b0;

        font-size:10px;

        font-weight:500;

        line-height:1.55;

        margin-top:4px;

    }


    .notification-item-footer{

        display:flex;

        align-items:center;

        gap:10px;

        margin-top:7px;

    }


    .notification-item-time{

        color:#667791;

        font-size:9px;

    }


    .notification-unread-dot{

        width:7px;

        height:7px;

        flex:0 0 7px;

        background:#f7b003;

        border-radius:50%;

        margin-top:5px;

    }


    /* =========================================================
       CATEGORY BADGE
    ========================================================= */

    .notification-category{

        display:inline-flex;

        align-items:center;

        padding:3px 7px;

        border-radius:6px;

        background:#1c2948;

        color:#8192ae;

        font-size:8px;

        font-weight:600;

    }


    .notification-category.warning{

        background:#3a2d12;

        color:#f7b003;

    }


    .notification-category.success{

        background:#0e332b;

        color:#00d99b;

    }


    .notification-category.danger{

        background:#3b1c25;

        color:#ff6277;

    }


    .notification-category.info{

        background:#152e4d;

        color:#5da8ff;

    }


    /* =========================================================
       EMPTY
    ========================================================= */

    .notification-empty{

        padding:60px 20px;

        text-align:center;

    }


    .notification-empty-icon{

        width:55px;

        height:55px;

        margin:0 auto 15px;

        display:flex;

        align-items:center;

        justify-content:center;

        background:#1b2642;

        border-radius:50%;

        color:#71829f;

    }


    .notification-empty-icon i{

        font-size:25px;

    }


    .notification-empty-title{

        color:#dce4f2;

        font-size:13px;

        font-weight:700;

    }


    .notification-empty-text{

        color:#71819c;

        font-size:10px;

        margin-top:5px;

    }


    /* =========================================================
       PAGINATION
    ========================================================= */

    .notification-pagination{

        padding:15px 22px;

        border-top:1px solid rgba(255,255,255,.05);

        display:flex;

        align-items:center;

        justify-content:space-between;

    }


    .notification-pagination-info{

        color:#687892;

        font-size:9px;

    }


    .notification-pagination-links{

        display:flex;

        align-items:center;

        gap:4px;

    }


    .notification-pagination-link{

        min-width:28px;

        height:28px;

        display:flex;

        align-items:center;

        justify-content:center;

        padding:0 7px;

        border:1px solid #293651;

        background:#151f36;

        border-radius:7px;

        color:#8292ad;

        font-size:9px;

        text-decoration:none;

    }


    .notification-pagination-link:hover{

        color:#f7b003;

        border-color:#f7b00366;

    }


    .notification-pagination-link.active{

        background:#f7b003;

        border-color:#f7b003;

        color:#111827;

        font-weight:700;

    }


    /* =========================================================
       LIGHT MODE
    ========================================================= */

    [data-bs-theme="light"] .notification-page-card{

        background:#fff;

        border-color:#e2e8f0;

    }


    [data-bs-theme="light"] .notification-page-title{

        color:#1e293b;

    }


    [data-bs-theme="light"] .notification-page-subtitle{

        color:#64748b;

    }


    [data-bs-theme="light"] .notification-unread-info{

        color:#64748b;

    }


    [data-bs-theme="light"] .notification-filter{

        background:#f8fafc;

        border-bottom-color:#e2e8f0;

    }


    [data-bs-theme="light"] .notification-filter-label{

        color:#64748b;

    }


    [data-bs-theme="light"] .notification-filter-input,
    [data-bs-theme="light"] .notification-filter-select{

        background:#fff;

        border-color:#dce3ec;

        color:#334155;

    }


    [data-bs-theme="light"] .notification-filter-input::placeholder{

        color:#94a3b8;

    }


    [data-bs-theme="light"] .notification-filter-select{

        color:#334155;

    }


    [data-bs-theme="light"] .btn-notification-reset{

        background:#fff;

        border-color:#dce3ec;

        color:#64748b;

    }


    [data-bs-theme="light"] .btn-notification-reset:hover{

        border-color:#cbd5e1;

        color:#334155;

    }


    [data-bs-theme="light"] .notification-period-btn{

        background:#fff;

        border-color:#dce3ec;

        color:#64748b;

    }


    [data-bs-theme="light"] .notification-period-btn.active{

        background:#fff8e6;

        border-color:#e8c35e;

        color:#c68a00;

    }


    [data-bs-theme="light"] .notification-list-header{

        border-bottom-color:#e2e8f0;

    }


    [data-bs-theme="light"] .notification-list-title{

        color:#334155;

    }


    [data-bs-theme="light"] .notification-item{

        border-bottom-color:#e2e8f0;

    }


    [data-bs-theme="light"] .notification-item:hover{

        background:#f8fafc;

    }


    [data-bs-theme="light"] .notification-item.unread{

        background:#fffaf0;

    }


    [data-bs-theme="light"] .notification-item.unread:hover{

        background:#fff7df;

    }


    [data-bs-theme="light"] .notification-item-icon{

        background:#eef2ff;

    }


    [data-bs-theme="light"] .notification-item-title{

        color:#334155;

    }


    [data-bs-theme="light"] .notification-item.unread .notification-item-title{

        color:#1e293b;

    }


    [data-bs-theme="light"] .notification-item-description{

        color:#64748b;

    }


    [data-bs-theme="light"] .notification-item-date,
    [data-bs-theme="light"] .notification-item-time{

        color:#94a3b8;

    }


    [data-bs-theme="light"] .notification-category{

        background:#f1f5f9;

        color:#64748b;

    }


    [data-bs-theme="light"] .notification-category.warning{

        background:#fff4d6;

        color:#b77900;

    }


    [data-bs-theme="light"] .notification-category.success{

        background:#dcfce7;

        color:#15803d;

    }


    [data-bs-theme="light"] .notification-category.danger{

        background:#fee2e2;

        color:#dc2626;

    }


    [data-bs-theme="light"] .notification-category.info{

        background:#e0f2fe;

        color:#0369a1;

    }


    [data-bs-theme="light"] .notification-empty-icon{

        background:#f1f5f9;

        color:#94a3b8;

    }


    [data-bs-theme="light"] .notification-empty-title{

        color:#334155;

    }


    [data-bs-theme="light"] .notification-empty-text{

        color:#94a3b8;

    }


    [data-bs-theme="light"] .notification-pagination{

        border-top-color:#e2e8f0;

    }


    [data-bs-theme="light"] .notification-pagination-info{

        color:#94a3b8;

    }


    [data-bs-theme="light"] .notification-pagination-link{

        background:#fff;

        border-color:#dce3ec;

        color:#64748b;

    }


    [data-bs-theme="light"] .notification-pagination-link.active{

        background:#f7b003;

        border-color:#f7b003;

        color:#111827;

    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media(max-width:991px){

        .notification-page-card{

            border-radius:15px;

        }


        .notification-page-header{

            padding:16px;

        }


        .notification-filter{

            padding:15px 16px;

        }


        .notification-list-header{

            padding:14px 16px;

        }


        .notification-item{

            padding:14px 16px;

        }

    }


    @media(max-width:575px){

        .notification-page-header{

            padding:15px;

        }


        .notification-page-title{

            font-size:14px;

        }


        .notification-page-subtitle{

            font-size:10px;

        }


        .notification-filter{

            padding:14px;

        }


        .notification-filter-row{

            row-gap:10px;

        }


        .notification-filter-input,
        .notification-filter-select,
        .btn-notification-filter,
        .btn-notification-reset{

            width:100%;

        }


        .notification-period{

            flex-wrap:wrap;

        }


        .notification-period-label{

            width:100%;

            margin-bottom:2px;

        }


        .notification-item{

            padding:13px 14px;

            gap:10px;

        }


        .notification-item-icon{

            width:36px;

            height:36px;

            flex-basis:36px;

            border-radius:10px;

        }


        .notification-item-icon i{

            font-size:16px;

        }


        .notification-item-top{

            display:block;

        }


        .notification-item-date{

            display:block;

            margin-top:3px;

        }


        .notification-item-title{

            font-size:11px;

        }


        .notification-item-description{

            font-size:9px;

        }


        .notification-pagination{

            padding:13px 14px;

        }


        .notification-pagination-info{

            display:none;

        }


        .notification-pagination-links{

            width:100%;

            justify-content:center;

        }

    }

</style>

@endsection

@section('breadcrumb')
    <h1
        class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
        Notifikasi</h1>
    <!--end::Title-->
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">

        {{-- BERANDA --}}
        <li class="breadcrumb-item text-muted">

            <a href="{{ route('dashboard-user.index') }}"
            class="text-muted text-hover-primary">

                Beranda

            </a>

        </li>


        {{-- SEPARATOR --}}
        <li class="breadcrumb-item">

            <span class="bullet bg-gray-500 w-5px h-2px"></span>

        </li>


        {{-- LOWONGAN --}}
        <li class="breadcrumb-item text-muted">

            <a href="javascript:;"
            class="text-muted text-hover-primary">

                Detail

            </a>

        </li>

    </ul>
    <!--end::Breadcrumb-->
@endsection


@section('content')

    <div class="row">

        <div class="col-xl-9">


            <!-- =================================================
                 NOTIFICATION CARD
            ================================================== -->

            <div class="notification-page-card">


                <!-- HEADER -->

                <div class="notification-page-header">

                    <div class="d-flex align-items-center justify-content-between">

                        <div>

                            <h3 class="notification-page-title">

                                Semua Notifikasi

                            </h3>

                            <div class="notification-page-subtitle">

                                Riwayat pemberitahuan dan aktivitas akun Anda

                            </div>

                        </div>


                        <div class="notification-unread-info">

                            <span class="dot"></span>

                            <span>
                                3 belum dibaca
                            </span>

                        </div>

                    </div>

                </div>



                <!-- =================================================
                     FILTER PERIODE
                ================================================== -->

                <div class="notification-filter">


                    <div class="row notification-filter-row align-items-end g-2">


                        <!-- FROM -->

                        <div class="col-12 col-md-4">

                            <div class="notification-filter-label">

                                Tanggal Mulai

                            </div>

                            <input
                                type="date"
                                class="form-control notification-filter-input"
                                value="{{ date('Y-m-01') }}">

                        </div>


                        <!-- TO -->

                        <div class="col-12 col-md-4">

                            <div class="notification-filter-label">

                                Tanggal Selesai

                            </div>

                            <input
                                type="date"
                                class="form-control notification-filter-input"
                                value="{{ date('Y-m-d') }}">

                        </div>


                        <!-- TYPE -->

                        <div class="col-12 col-md-4">

                            <div class="notification-filter-label">

                                Jenis Notifikasi

                            </div>

                            <select class="form-select notification-filter-select">

                                <option value="">
                                    Semua Notifikasi
                                </option>

                                <option value="job">
                                    Lowongan
                                </option>

                                <option value="training">
                                    Pelatihan
                                </option>

                                <option value="connection">
                                    Jejaring
                                </option>

                                <option value="system">
                                    Sistem
                                </option>

                            </select>

                        </div>


                    </div>



                    <!-- BUTTON -->

                    <div class="d-flex align-items-center gap-2 mt-3">

                        <button
                            type="button"
                            class="btn-notification-filter">

                            <i class="ki-duotone ki-filter fs-7 me-1">

                                <span class="path1"></span>
                                <span class="path2"></span>

                            </i>

                            Terapkan Filter

                        </button>


                        <button
                            type="button"
                            class="btn-notification-reset">

                            Reset

                        </button>

                    </div>



                    <!-- QUICK PERIOD -->

                    <div class="notification-period">

                        <span class="notification-period-label">

                            Periode cepat:

                        </span>


                        <a href="javascript:;"
                            class="notification-period-btn">

                            Hari Ini

                        </a>


                        <a href="javascript:;"
                            class="notification-period-btn active">

                            7 Hari

                        </a>


                        <a href="javascript:;"
                            class="notification-period-btn">

                            30 Hari

                        </a>


                        <a href="javascript:;"
                            class="notification-period-btn">

                            Bulan Ini

                        </a>

                    </div>

                </div>



                <!-- =================================================
                     LIST HEADER
                ================================================== -->

                <div class="notification-list-header">

                    <div class="notification-list-title">

                        Notifikasi

                    </div>


                    <a href="javascript:;"
                        class="notification-mark-all">

                        Tandai semua dibaca

                    </a>

                </div>



                <!-- =================================================
                     NOTIFICATION LIST
                ================================================== -->

                <div>


                    <!-- =================================================
                         ITEM 1
                    ================================================== -->

                    <a href="javascript:;"
                        class="notification-item unread">


                        <div class="notification-item-icon warning">

                            <i class="ki-duotone ki-briefcase">

                                <span class="path1"></span>
                                <span class="path2"></span>

                            </i>

                        </div>


                        <div class="notification-item-content">


                            <div class="notification-item-top">

                                <div class="notification-item-title">

                                    Lowongan baru tersedia

                                </div>

                                <div class="notification-item-date">

                                    20 Sep 2026

                                </div>

                            </div>


                            <div class="notification-item-description">

                                Terdapat lowongan Satpam baru yang
                                sesuai dengan profil dan kualifikasi
                                Anda.

                            </div>


                            <div class="notification-item-footer">

                                <span class="notification-category warning">

                                    Lowongan

                                </span>

                                <span class="notification-item-time">

                                    5 menit lalu

                                </span>

                            </div>

                        </div>


                        <span class="notification-unread-dot"></span>

                    </a>



                    <!-- =================================================
                         ITEM 2
                    ================================================== -->

                    <a href="javascript:;"
                        class="notification-item unread">


                        <div class="notification-item-icon danger">

                            <i class="ki-duotone ki-information-5">

                                <span class="path1"></span>
                                <span class="path2"></span>

                            </i>

                        </div>


                        <div class="notification-item-content">


                            <div class="notification-item-top">

                                <div class="notification-item-title">

                                    Sertifikat akan segera berakhir

                                </div>

                                <div class="notification-item-date">

                                    20 Sep 2026

                                </div>

                            </div>


                            <div class="notification-item-description">

                                Sertifikat Gada Pratama Anda akan
                                berakhir dalam 30 hari. Segera lakukan
                                perpanjangan jika diperlukan.

                            </div>


                            <div class="notification-item-footer">

                                <span class="notification-category danger">

                                    Sistem

                                </span>

                                <span class="notification-item-time">

                                    2 jam lalu

                                </span>

                            </div>

                        </div>


                        <span class="notification-unread-dot"></span>

                    </a>



                    <!-- =================================================
                         ITEM 3
                    ================================================== -->

                    <a href="javascript:;"
                        class="notification-item unread">


                        <div class="notification-item-icon purple">

                            <i class="ki-duotone ki-book-open">

                                <span class="path1"></span>
                                <span class="path2"></span>

                            </i>

                        </div>


                        <div class="notification-item-content">


                            <div class="notification-item-top">

                                <div class="notification-item-title">

                                    Pelatihan K3 Dasar akan dimulai

                                </div>

                                <div class="notification-item-date">

                                    19 Sep 2026

                                </div>

                            </div>


                            <div class="notification-item-description">

                                Pelatihan K3 Dasar - LSP Sekuriti
                                akan dimulai dalam 3 hari. Anda
                                terdaftar sebagai peserta.

                            </div>


                            <div class="notification-item-footer">

                                <span class="notification-category info">

                                    Pelatihan

                                </span>

                                <span class="notification-item-time">

                                    5 jam lalu

                                </span>

                            </div>

                        </div>


                        <span class="notification-unread-dot"></span>

                    </a>



                    <!-- =================================================
                         ITEM 4
                    ================================================== -->

                    <a href="javascript:;"
                        class="notification-item">


                        <div class="notification-item-icon success">

                            <i class="ki-duotone ki-user-tick">

                                <span class="path1"></span>
                                <span class="path2"></span>

                            </i>

                        </div>


                        <div class="notification-item-content">


                            <div class="notification-item-top">

                                <div class="notification-item-title">

                                    Permintaan koneksi diterima

                                </div>

                                <div class="notification-item-date">

                                    19 Sep 2026

                                </div>

                            </div>


                            <div class="notification-item-description">

                                Irwan Prasetyo menerima permintaan
                                koneksi Anda.

                            </div>


                            <div class="notification-item-footer">

                                <span class="notification-category success">

                                    Jejaring

                                </span>

                                <span class="notification-item-time">

                                    1 hari lalu

                                </span>

                            </div>

                        </div>

                    </a>



                    <!-- =================================================
                         ITEM 5
                    ================================================== -->

                    <a href="javascript:;"
                        class="notification-item">


                        <div class="notification-item-icon warning">

                            <i class="ki-duotone ki-bookmark">

                                <span class="path1"></span>
                                <span class="path2"></span>

                            </i>

                        </div>


                        <div class="notification-item-content">


                            <div class="notification-item-top">

                                <div class="notification-item-title">

                                    Lowongan disimpan

                                </div>

                                <div class="notification-item-date">

                                    18 Sep 2026

                                </div>

                            </div>


                            <div class="notification-item-description">

                                Lowongan Security Officer di PT ABC
                                berhasil ditambahkan ke daftar
                                lowongan tersimpan.

                            </div>


                            <div class="notification-item-footer">

                                <span class="notification-category warning">

                                    Lowongan

                                </span>

                                <span class="notification-item-time">

                                    2 hari lalu

                                </span>

                            </div>

                        </div>

                    </a>



                    <!-- =================================================
                         ITEM 6
                    ================================================== -->

                    <a href="javascript:;"
                        class="notification-item">


                        <div class="notification-item-icon info">

                            <i class="ki-duotone ki-check-circle">

                                <span class="path1"></span>
                                <span class="path2"></span>

                            </i>

                        </div>


                        <div class="notification-item-content">


                            <div class="notification-item-top">

                                <div class="notification-item-title">

                                    Profil berhasil diperbarui

                                </div>

                                <div class="notification-item-date">

                                    17 Sep 2026

                                </div>

                            </div>


                            <div class="notification-item-description">

                                Data profil Anda berhasil diperbarui
                                dan tersimpan di sistem.

                            </div>


                            <div class="notification-item-footer">

                                <span class="notification-category info">

                                    Sistem

                                </span>

                                <span class="notification-item-time">

                                    3 hari lalu

                                </span>

                            </div>

                        </div>

                    </a>


                </div>



                <!-- =================================================
                     PAGINATION
                ================================================== -->

                <div class="notification-pagination">


                    <div class="notification-pagination-info">

                        Menampilkan 1 - 6 dari 24 notifikasi

                    </div>


                    <div class="notification-pagination-links">

                        <a href="javascript:;"
                            class="notification-pagination-link">

                            <i class="ki-duotone ki-left fs-8">

                                <span class="path1"></span>
                                <span class="path2"></span>

                            </i>

                        </a>


                        <a href="javascript:;"
                            class="notification-pagination-link active">

                            1

                        </a>


                        <a href="javascript:;"
                            class="notification-pagination-link">

                            2

                        </a>


                        <a href="javascript:;"
                            class="notification-pagination-link">

                            3

                        </a>


                        <a href="javascript:;"
                            class="notification-pagination-link">

                            4

                        </a>


                        <a href="javascript:;"
                            class="notification-pagination-link">

                            <i class="ki-duotone ki-right fs-8">

                                <span class="path1"></span>
                                <span class="path2"></span>

                            </i>

                        </a>

                    </div>

                </div>


            </div>


        </div>


        <!-- =================================================
             RIGHT SIDE
        ================================================== -->

        <div class="col-xl-3">


            {{-- <div class="quick-card"
                style="
                    background:#11192d;
                    border-radius:18px;
                    border:1px solid rgba(255,255,255,.06);
                ">


                <div style="
                    padding:16px;
                    border-bottom:1px solid rgba(255,255,255,.05);
                ">

                    <div style="
                        color:#fff;
                        font-size:13px;
                        font-weight:700;
                    ">

                        Ringkasan

                    </div>

                    <div style="
                        color:#8796b5;
                        font-size:10px;
                        margin-top:3px;
                    ">

                        Status notifikasi Anda

                    </div>

                </div>


                <div style="padding:10px;">


                    <div class="quick-item">

                        <span>

                            Belum dibaca

                        </span>

                        <strong style="
                            color:#f7b003;
                            font-size:13px;
                        ">

                            3

                        </strong>

                    </div>


                    <div class="quick-item">

                        <span>

                            7 Hari Terakhir

                        </span>

                        <strong style="
                            color:#fff;
                            font-size:13px;
                        ">

                            8

                        </strong>

                    </div>


                    <div class="quick-item">

                        <span>

                            Bulan Ini

                        </span>

                        <strong style="
                            color:#fff;
                            font-size:13px;
                        ">

                            24

                        </strong>

                    </div>


                </div>

            </div> --}}


        </div>

    </div>

@endsection


@section('js')

<script>

    $(document).ready(function () {


        /*
        |--------------------------------------------------------------------------
        | QUICK PERIOD
        |--------------------------------------------------------------------------
        */

        $('.notification-period-btn').on('click', function (e) {

            e.preventDefault();

            $('.notification-period-btn')
                .removeClass('active');

            $(this)
                .addClass('active');

        });


        /*
        |--------------------------------------------------------------------------
        | RESET FILTER
        |--------------------------------------------------------------------------
        */

        $('.btn-notification-reset').on('click', function () {

            $('.notification-filter-input').val('');

            $('.notification-filter-select')
                .val('');

            $('.notification-period-btn')
                .removeClass('active');

        });


        /*
        |--------------------------------------------------------------------------
        | MARK ALL READ
        |--------------------------------------------------------------------------
        */

        $('.notification-mark-all').on('click', function (e) {

            e.preventDefault();

            $('.notification-item')
                .removeClass('unread');

            $('.notification-unread-dot')
                .remove();

        });

    });

</script>

@endsection