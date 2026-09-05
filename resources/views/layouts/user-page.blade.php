<!DOCTYPE html>
<html lang="en">

<head>
    <base href="./" />
    <title>Autoloker - @yield('title')</title>
    <meta charset="utf-8" />
    <meta name="description"
        content="Platform Satpam #1 Indonesia" />
    <meta name="keywords"
        content="Platform Satpam #1 Indonesia" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title"
        content="Platform Satpam #1 Indonesia" />
    <meta property="og:url" content="" />
    <meta property="og:site_name" content="Autoloker" />
    <link rel="canonical" href="" />
    <link rel="shortcut icon" href="/assets/media/logos/autoloker-logo-small.png" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
    <link href="/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        @media (min-width: 992px) {
            [data-kt-app-header-fixed=true][data-kt-app-sidebar-fixed=true][data-kt-app-sidebar-push-header=true] .app-header, [data-kt-app-header-fixed=true][data-kt-app-sidebar-sticky=on][data-kt-app-sidebar-push-header=true] .app-header {
                left: 0 !important;
            }
        }

        @media (min-width: 992px) {
            [data-kt-app-sidebar-fixed=true] .app-wrapper {
                margin-left: 0 !important;
            }
        }

        body, .app-default {
            background-color: #080d1c;
        }

        .app-header {
            background-color: #0c1427;
            border-bottom: 1px solid #ffffff14;
        }

        .app-header-menu .menu > .menu-item.here > .menu-link .menu-title {
            color: #e8a401;
        }

        .btn-check:checked + .btn.btn-active-color-primary i, .btn-check:checked + .btn.btn-active-color-primary .svg-icon, .btn-check:active + .btn.btn-active-color-primary i, .btn-check:active + .btn.btn-active-color-primary .svg-icon, .btn.btn-active-color-primary:focus:not(.btn-active) i, .btn.btn-active-color-primary:focus:not(.btn-active) .svg-icon, .btn.btn-active-color-primary:hover:not(.btn-active) i, .btn.btn-active-color-primary:hover:not(.btn-active) .svg-icon, .btn.btn-active-color-primary:active:not(.btn-active) i, .btn.btn-active-color-primary:active:not(.btn-active) .svg-icon, .btn.btn-active-color-primary.active i, .btn.btn-active-color-primary.active .svg-icon, .btn.btn-active-color-primary.show i, .btn.btn-active-color-primary.show .svg-icon, .show > .btn.btn-active-color-primary i, .show > .btn.btn-active-color-primary .svg-icon {
            color: #e8a401;
        }

        .header-search{

            position:relative;

            width:230px;   /* sebelumnya 420 / 300 */

            flex:none;

        }

        .search-input{
            width: 100%;
            height: 34px; /* lebih pendek */

            background:#1a2445;
            border:1px solid #26365b;
            border-radius:10px;

            color:#fff;
            font-size: 12px;

            padding:0 14px 0 36px;

            transition:.2s;
        }

        .search-input::placeholder{
            color:#8d98b3;
            font-size:10px;
        }

        .search-input:focus{
            outline:none;
            background:#202d56;
            border-color:#ffb400;
            box-shadow:none;
        }

        /* Desktop */
        .search-icon{
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 13px;
            color: #8d98b3;
        }

        .app-header-menu img{

            height:60px !important;

            width:auto;
            
            background: white;
            
            border-radius: 8px;

        }

        .app-header-menu{

            display:flex;
            align-items:center;
        }

        .app-header-menu img{

            margin-right:20px;

        }

        .header-search{

            margin-right:auto;

        }

        /* Mobile */
        @media (max-width: 767.98px){
            .search-icon{
                top: 50%;
            }
        }

        /* Desktop */
        .mobile-bottom-nav{
            display:none;
        }

        @media (max-width: 767px){

            .header-left{
                display:flex;
                align-items:center;
                gap:8px;
                flex:unset;
            }

            .header-logo img{
                height:26px;
            }

            .header-search{
                width:150px;   /* sebelumnya flex:1 */
                flex:none;
            }

            .search-input{
                width:100%;
                height:28px;
                font-size:11px;
                padding:0 10px 0 28px;
                border-radius:8px;
            }

            .search-input::placeholder{
                font-size:11px;
            }

            .search-icon{
                left:9px;
                font-size:11px;
            }

            .header-right{
                gap:8px;
            }

            .header-right i{
                font-size:17px;
            }

            .user-avatar{
                width:28px;
                height:28px;
            }

            .mobile-bottom-nav{

                display:flex;

                position:fixed;

                bottom:0;
                left:0;

                width:100%;
                height:65px;

                background:#0f172a;

                border-top:1px solid #263246;

                z-index:1055;

                justify-content:space-around;
                align-items:center;

                box-shadow:0 -3px 12px rgba(0,0,0,.15);

            }

            .mobile-bottom-nav a{

                display:flex;
                flex-direction:column;
                align-items:center;
                justify-content:center;

                color:#8f9bb3;

                text-decoration:none;

                font-size:11px;

                gap:4px;

            }

            .mobile-bottom-nav a i{

                font-size:20px;

            }

            .mobile-bottom-nav a.active{

                color:#ffb400;

            }

            /* supaya konten tidak tertutup bottombar */
            .app-main{

                padding-bottom:80px;

            }

            /* sembunyikan semua menu desktop */
            .app-navbar > :not(#kt_header_user_menu_toggle){
                display:none !important;
            }

            /* hanya profile yang tampil */
            #kt_header_user_menu_toggle{
                display:flex !important;
                margin-left:10px;
            }

            .header-search{
                width:140px;
            }

            .header-logo img{
                height:28px;
            }

            #kt_app_footer {
                display: none !important;
            }

        }

        .app-navbar{

            display:flex;
            align-items:center;
            gap:6px;

        }

        .app-navbar .nav-item{

            width:74px;
            height:64px;

            display:flex;
            flex-direction:column;

            justify-content:center;
            align-items:center;

            text-decoration:none;

            color:#94a3b8;

            transition:.25s;

            border-radius:10px;

            cursor:pointer;

        }

        .app-navbar .nav-item i{

            font-size:22px;
            margin-bottom:4px;

        }

        .app-navbar .nav-item span{

            font-size:11px;
            font-weight:500;

        }

        .app-navbar .nav-item:hover{

            color:#ffb400;
            background:rgba(255,180,0,.08);

        }

        .app-navbar .nav-item.active{

            color:#ffb400;

        }

        /* Navbar */
        .app-navbar .nav-item{

            color:#8f9bb3;

            transition:all .25s ease;

        }

        /* Icon */

        .app-navbar .nav-item i{

            color:inherit;

            transition:all .25s ease;

        }

        /* Text */

        .app-navbar .nav-item span{

            color:inherit;

            transition:all .25s ease;

        }

        /* Hover */

        .app-navbar .nav-item:hover{

            color:#e8a401;

        }

        /* Active */

        .app-navbar .nav-item.active{

            color:#e8a401;

        }

        .nav-avatar{

            width:28px;
            height:28px;
            object-fit:cover;

            margin-bottom:4px;

        }

        /* Desktop */
        .app-header{
            padding-left: 10%;
            padding-right: 10%;
        }

        /* Mobile */
        @media (max-width: 767.98px){
            .app-header{
                padding-left: 0;
                padding-right: 0;
            }

            #kt_header_user_menu_toggle{
                display:none !important;
            }
        }

        .bottom-avatar{

            width:22px;
            height:22px;

            object-fit:cover;

            margin-bottom:4px;

        }

        @media (max-width:767.98px){

            .mobile-logo{
                flex: 0 0 25%;
                max-width: 25%;
                justify-content: center;
                margin-right: 10px;
            }

            .mobile-search{
                flex: 0 0 75%;
                max-width: 75%;
                margin: 0 !important;
            }

            .mobile-search .header-search{
                width: 100%;
            }

            .mobile-search .search-input{
                width: 100%;
            }

        }

        .profile-trigger{
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            gap:4px;
        }

        .profile-info{
            display:flex;
            align-items:center;
            gap:3px;
        }

        .nav-avatar{
            width:32px;
            height:32px;
        }

        .profile-trigger span{

            font-size:13px;
            font-weight:600;

            color:#fff;

        }

        .menu-sub-dropdown{

            background:#16213d;

            border:1px solid #2b3b63;

            border-radius:18px;

            box-shadow:0 15px 40px rgba(0,0,0,.35);

        }

        .menu-link{

            color:#b7c1d8;

            font-size:15px;

            border-radius:10px;

            transition:.2s;

        }

        .menu-link:hover{

            background:#e8a401;

            color:#fff;

        }

        /* Menu dropdown */
        .menu-item .menu-link{
            color:#ffffff;
            border-radius:8px;
            transition:all .2s ease;
        }

        /* Icon */
        .menu-item .menu-link i{
            color:inherit;
            transition:all .2s ease;
        }

        /* Hover */
        .menu-item .menu-link:hover{
            color:#e8a401 !important;
            background:rgba(232, 164, 1, 0.08);
        }

        /* Icon ikut berubah */
        .menu-item .menu-link:hover i{
            color:#e8a401 !important;
        }

        .separator{

            border-color:#2b3b63 !important;

        }

        .app-main {
            padding: 1% 10%;
        }

        /* Mobile */
        @media (max-width: 991.98px){
            .app-main{
                padding: 10px;
            }
        }

        @media (min-width: 992px) {
            .app-container {
                padding-left: 0px !important;
                padding-right: 0px !important;
            }
        }
        
    </style>

    {{-- SIDEBAR USER --}}
    <style>
        .left-sidebar .card{
            background:#111b34;
            border:1px solid #243250;
            border-radius:16px;
            overflow:hidden;
            box-shadow:none;
        }

        /* Cover */

        .profile-cover{
            height:64px;
            background:linear-gradient(90deg,#1b3568,#132a53);
        }

        /* Avatar */

        .profile-avatar{
            position:relative;
            width:58px;
            margin:-30px 0 10px;
        }

        .profile-avatar img{
            width:58px;
            height:58px;
            border-radius:50%;
            border:2px solid #f4b400;
            object-fit:cover;
        }

        .online-badge{
            width:16px;
            height:16px;
            position:absolute;
            right:-2px;
            bottom:2px;

            border-radius:50%;

            background:#f4b400;

            display:flex;
            justify-content:center;
            align-items:center;
        }

        .online-badge i{
            font-size:8px !important;
        }

        /* Body */

        .profile-card .card-body{
            padding:14px;
        }

        /* Nama */

        .profile-name{

            color:#fff;

            font-size:12px;

            font-weight:700;

            margin-bottom:2px;

        }

        /* Jabatan */

        .profile-job{

            color:#b5bfd7;

            font-size:10px;

            line-height:18px;

        }

        /* Perusahaan */

        .profile-company{

            color:#8f9ab6;

            font-size:10px;

            margin-bottom:10px;

        }

        /* Badge */

        .badge-gada{

            display:inline-flex;

            align-items:center;

            padding:3px 8px;

            border-radius:6px;

            border:1px solid rgba(244,180,0,.45);

            background:rgba(244,180,0,.08);

            color:#f4b400;

            font-size:10px;

            font-weight:600;

        }

        /* Separator */

        .profile-card .separator{

            margin:12px 0 !important;

            border-color:#283552;

        }

        /* Statistik */

        .profile-stat div{

            display:flex;

            justify-content:space-between;

            align-items:center;

            margin-bottom:8px;

        }

        .profile-stat span{

            color:#8d98b3;

            font-size:12px;

        }

        .profile-stat strong{

            color:#f4b400;

            font-size:12px;

        }

        /* ==========================
        QUICK MENU
        ========================== */

        .quick-menu .card-body{

            padding:14px;

        }

        .menu-title{

            font-size:11px;

            color:#7d89a7;

            letter-spacing:2px;

            margin-bottom:8px;

        }

        .quick-item{

            display:flex;

            align-items:center;

            gap:10px;

            padding:10px 4px;

            border-radius:8px;

            text-decoration:none;

            color:#aeb7cb;

            transition:.2s;

        }

        .quick-item:hover{

            background:#182544;

            color:#fff;

        }

        .quick-item i{

            color:#f4b400;

            font-size:18px !important;

        }

        .quick-item span{

            font-size:13px;

            font-weight:500;

        }

        
        </style>

    {{-- CONTENT USER --}}
    <style>
        .job-filter-card,
        .job-card{

            background:#11192d;
            border:1px solid #263246;
            border-radius:18px;

        }

        .job-search{

            display:flex;
            align-items:center;

            background:#1a2545;

            height: 34px;

            border-radius:14px;

            padding:0 18px;

        }

        .job-search i{

            color:#7d8fb3;
            margin-right: 12px;

        }

        .job-search input{

            width:100%;
            border:0;
            outline:none;
            background:transparent;

            color:#fff;
            font-size: 13px;

        }

        .job-search input::placeholder{

            color:#7d8fb3;

        }

        .btn-filter{

            border:1px solid #2c3651;

            background:transparent;

            color:#8f9bb3;

            border-radius:30px;

            padding: 3px 12px;

            font-size: 11px;

            font-weight:600;

        }

        .btn-filter.active{

            background:#ffb400;
            color:#111;

            border-color:#ffb400;

        }

        .job-title{

            color:#fff;
            font-size: 13px !important;
            font-weight:700;

        }

        .company-name{

            margin-top: 1px;

            color:#8f9bb3;

            font-size: 10px;

        }

        .job-info{

            display:flex;
            gap: 15px;

            color:#8f9bb3;

            font-size: 10px;

        }

        .job-info span{

            display:flex;
            align-items:center;
            gap:6px;

        }

        .salary{

            color:#ffb400;

            font-size: 10px;

            font-weight:700;

        }

        .badge-license{

            border:1px solid rgba(255,180,0,.4);

            color:#ffb400;

            background:rgba(255,180,0,.08);

            border-radius:8px;

            padding: 2px 5px;

            display: flex;
            align-items:center;
            gap: 6px;

            font-size:10px;

        }

        .badge-urgent{

            background:rgba(255,70,70,.12);

            color:#ff6565;

            border:1px solid rgba(255,70,70,.35);

            border-radius:999px;

            padding: 2px 8px;

            font-size: 10px;

            font-weight:700;

        }

        .apply-info{

            color:#8f9bb3;

            font-size: 10px;

        }

        .company-icon{

            width:46px;
            height:46px;

            background:#1a2545;

            border-radius:18px;

            display:flex;
            align-items:center;
            justify-content:center;

            color:#90a0c4;

        }

        .job-divider{

            margin: 1px 0 22px;

            border-color:#263246;

        }

        .btn-apply{

            height: 32px;

            border:none;

            border-radius:14px;

            background:#ffb400;

            color:#111;

            font-weight:700;

            font-size: 12px;

        }

        .btn-save{

            width:140px;

            border-radius:14px;

            border:1px solid #2c3651;

            background:transparent;

            color:#8f9bb3;

            font-weight:700;

            font-size: 12px;

        }

        @media(max-width:991px){

            .job-title{

                font-size: 11px !important;

            }

            .company-name{

                font-size: 10px;

            }

            .salary{

                font-size: 10px !important;

            }

            .btn-save{

                width: 100px;

                font-size: 10px;

            }

            .btn-apply{

                width: 100px;

                font-size: 10px;

            }

            .company-icon{

                width: 36px;
                height: 36px;

            }

            .job-info {
                font-size: 10px;
            }

            .btn-filter {
                font-size: 9px;
            }

            .job-search input {
                font-size: 10px;
            }

        }
    </style>

    {{-- SIDEBAR RIGHT --}}
    <style>
        /* =======================================
        RIGHT SIDEBAR
        =======================================*/

        .right-sidebar .card{

            background:#111B34;

            border:1px solid #253454;

            border-radius:18px;

            box-shadow:none;

        }

        .right-sidebar .card-body{

            padding:18px;

        }

        /* =======================================
        REMINDER
        =======================================*/

        .reminder-card{

            background:rgba(244,180,0,.08);

            border:1px solid rgba(244,180,0,.35) !important;

        }

        .reminder-box{

            display:flex;

            gap: 12px;

            align-items:flex-start;

        }

        .reminder-icon{

            color:#f4b400;

            font-size: 20px;

            margin-top:2px;

        }

        .reminder-title{

            color:#f4b400;

            font-size: 12px;

            font-weight: 700;

            margin-bottom:1px;

        }

        .reminder-text{

            color:#8d99b5;

            font-size: 11px;

            /* line-height: 1px; */

        }

        .reminder-text strong{

            color:#f4b400;

            font-family:monospace;

        }

        .reminder-link{

            display:inline-block;

            margin-top: 1px;

            color:#f4b400;

            font-size:11px;

            font-weight:600;

            text-decoration:none;

        }

        .reminder-link:hover{

            text-decoration:underline;

        }

        /* =======================================
        TITLE
        =======================================*/

        .right-title{

            display:flex;

            justify-content:space-between;

            align-items:center;

            margin-bottom:18px;

        }

        .right-title h5{

            color:#fff;

            font-size: 11px;

            font-weight:700;

            margin:0;

        }

        .right-title a{

            color:#f4b400;

            text-decoration:none;

            font-size: 9.5px;

            font-weight:600;

        }

        /* =======================================
        JOB
        =======================================*/

        .job-item{

            margin-bottom: 10px;

        }

        .job-item:last-child{

            margin-bottom:0;

        }

        .job-title{

            color:#eef2ff;

            font-size: 11px;

            font-weight:600;

            /* line-height:18px; */

        }

        .job-company{

            color:#8d99b5;

            font-size: 11px;

            margin-top: 1px;

        }

        .job-bottom{

            display:flex;

            justify-content:space-between;

            align-items:center;

            margin-top: 1px;

        }

        .salary{

            color:#f4b400;

            font-size: 10px;

            font-family:monospace;

            font-weight:700;

        }

        .urgent{

            padding: 4px 10px;

            border-radius:8px;

            border:1px solid rgba(255,90,90,.4);

            color:#ff7474;

            background:rgba(255,90,90,.08);

            font-size: 9px;

        }

        /* =======================================
        TRAINING
        =======================================*/

        .training-item{

            margin-bottom: 10px;

        }

        .training-item:last-child{

            margin-bottom:0;

        }

        .training-title{

            color:#eef2ff;

            font-size: 11px;

            font-weight:600;

            /* line-height:18px; */

        }

        .training-org{

            color:#8d99b5;

            font-size: 9.5px;

        }

        .training-org .bnsp{

            color:#00df8b;

        }

        .training-date{

            color:#8d99b5;

            font-size: 9.5px;

            margin-top: 1px;

            font-family:monospace;

        }

        /* =======================================
        FOOTER
        =======================================*/

        .right-footer{

            padding: 10px 6px;

            color:#8d99b5;

            font-size: 9.5px;

            /* line-height:20px; */

        }

        .right-footer a{

            color:#8d99b5;

            text-decoration:none;

        }

        .right-footer a:hover{

            color:#fff;

        }
    </style>

    <style>
        /* =========================================================
        LIGHT MODE
        ========================================================= */

        [data-bs-theme="light"] body,
        [data-bs-theme="light"] .app-default {
            background-color: #ffffff !important;
            color: #212529;
        }


        /* =========================================================
        HEADER
        ========================================================= */

        [data-bs-theme="light"] .app-header {
            background-color: #ffffff !important;
            border-bottom: 1px solid #e5e7eb !important;
        }


        /* =========================================================
        SEARCH
        ========================================================= */

        [data-bs-theme="light"] .search-input {
            background: #f8f9fa !important;
            border: 1px solid #dfe3e8 !important;
            color: #212529 !important;
        }

        [data-bs-theme="light"] .search-input::placeholder {
            color: #8a94a6 !important;
        }

        [data-bs-theme="light"] .search-input:focus {
            background: #ffffff !important;
            border-color: #e8a401 !important;
        }

        [data-bs-theme="light"] .search-icon {
            color: #7d8797 !important;
        }


        /* =========================================================
        NAVBAR
        ========================================================= */

        [data-bs-theme="light"] .app-navbar .nav-item {
            color: #6b7280 !important;
        }

        [data-bs-theme="light"] .app-navbar .nav-item:hover {
            color: #e8a401 !important;
            background: rgba(232, 164, 1, 0.08) !important;
        }

        [data-bs-theme="light"] .app-navbar .nav-item.active {
            color: #e8a401 !important;
        }


        /* =========================================================
        PROFILE
        ========================================================= */

        [data-bs-theme="light"] .left-sidebar .card {
            background: #ffffff !important;
            border: 1px solid #e5e7eb !important;
        }

        [data-bs-theme="light"] .profile-name {
            color: #111827 !important;
        }

        [data-bs-theme="light"] .profile-job {
            color: #4b5563 !important;
        }

        [data-bs-theme="light"] .profile-company {
            color: #6b7280 !important;
        }

        [data-bs-theme="light"] .profile-card .separator {
            border-color: #e5e7eb !important;
        }

        [data-bs-theme="light"] .profile-stat span {
            color: #6b7280 !important;
        }

        [data-bs-theme="light"] .profile-stat strong {
            color: #e8a401 !important;
        }


        /* =========================================================
        QUICK MENU
        ========================================================= */

        [data-bs-theme="light"] .menu-title {
            color: #6b7280 !important;
        }

        [data-bs-theme="light"] .quick-item {
            color: #4b5563 !important;
        }

        [data-bs-theme="light"] .quick-item:hover {
            background: #f5f6f8 !important;
            color: #111827 !important;
        }

        [data-bs-theme="light"] .quick-item i {
            color: #e8a401 !important;
        }


        /* =========================================================
        JOB CARD
        ========================================================= */

        [data-bs-theme="light"] .job-filter-card,
        [data-bs-theme="light"] .job-card {
            background: #ffffff !important;
            border: 1px solid #e5e7eb !important;
        }

        [data-bs-theme="light"] .job-search {
            background: #f8f9fa !important;
        }

        [data-bs-theme="light"] .job-search input {
            color: #212529 !important;
        }

        [data-bs-theme="light"] .job-search input::placeholder {
            color: #8a94a6 !important;
        }

        [data-bs-theme="light"] .job-search i {
            color: #7d8797 !important;
        }


        /* =========================================================
        JOB TEXT
        ========================================================= */

        [data-bs-theme="light"] .job-title {
            color: #111827 !important;
        }

        [data-bs-theme="light"] .company-name,
        [data-bs-theme="light"] .job-info,
        [data-bs-theme="light"] .apply-info {
            color: #6b7280 !important;
        }

        [data-bs-theme="light"] .salary {
            color: #d99a00 !important;
        }

        [data-bs-theme="light"] .job-divider {
            border-color: #e5e7eb !important;
        }

        [data-bs-theme="light"] .company-icon {
            background: #f3f4f6 !important;
            color: #6b7280 !important;
        }


        /* =========================================================
        FILTER BUTTON
        ========================================================= */

        [data-bs-theme="light"] .btn-filter {
            border-color: #d1d5db !important;
            color: #6b7280 !important;
            background: transparent !important;
        }

        [data-bs-theme="light"] .btn-filter:hover {
            border-color: #e8a401 !important;
            color: #e8a401 !important;
        }

        [data-bs-theme="light"] .btn-filter.active {
            background: #ffb400 !important;
            color: #111111 !important;
            border-color: #ffb400 !important;
        }


        /* =========================================================
        RIGHT SIDEBAR
        ========================================================= */

        [data-bs-theme="light"] .right-sidebar .card {
            background: #ffffff !important;
            border: 1px solid #e5e7eb !important;
        }

        [data-bs-theme="light"] .right-title h5 {
            color: #111827 !important;
        }

        [data-bs-theme="light"] .right-title a {
            color: #d99a00 !important;
        }


        /* =========================================================
        RIGHT SIDEBAR - JOB
        ========================================================= */

        [data-bs-theme="light"] .job-company {
            color: #6b7280 !important;
        }

        [data-bs-theme="light"] .job-title {
            color: #111827 !important;
        }


        /* =========================================================
        RIGHT SIDEBAR - TRAINING
        ========================================================= */

        [data-bs-theme="light"] .training-title {
            color: #111827 !important;
        }

        [data-bs-theme="light"] .training-org,
        [data-bs-theme="light"] .training-date {
            color: #6b7280 !important;
        }

        [data-bs-theme="light"] .training-org .bnsp {
            color: #00a66a !important;
        }


        /* =========================================================
        REMINDER
        ========================================================= */

        [data-bs-theme="light"] .reminder-card {
            background: rgba(244, 180, 0, 0.08) !important;
            border: 1px solid rgba(244, 180, 0, 0.35) !important;
        }

        [data-bs-theme="light"] .reminder-text {
            color: #6b7280 !important;
        }

        [data-bs-theme="light"] .reminder-text strong,
        [data-bs-theme="light"] .reminder-title,
        [data-bs-theme="light"] .reminder-icon,
        [data-bs-theme="light"] .reminder-link {
            color: #d99a00 !important;
        }


        /* =========================================================
        DROPDOWN PROFILE
        ========================================================= */

        [data-bs-theme="light"] .menu-sub-dropdown {
            background: #ffffff !important;
            border: 1px solid #e5e7eb !important;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12) !important;
        }

        [data-bs-theme="light"] .menu-link,
        [data-bs-theme="light"] .menu-item .menu-link {
            color: #374151 !important;
        }

        [data-bs-theme="light"] .menu-item .menu-link:hover {
            color: #e8a401 !important;
            background: rgba(232, 164, 1, 0.08) !important;
        }

        [data-bs-theme="light"] .separator {
            border-color: #e5e7eb !important;
        }


        /* =========================================================
        PROFILE NAME DI HEADER
        ========================================================= */

        [data-bs-theme="light"] .profile-trigger span {
            color: #111827 !important;
        }


        /* =========================================================
        MOBILE BOTTOM NAV
        ========================================================= */

        [data-bs-theme="light"] .mobile-bottom-nav {
            background: #ffffff !important;
            border-top: 1px solid #e5e7eb !important;
            box-shadow: 0 -3px 12px rgba(0, 0, 0, 0.08) !important;
        }

        [data-bs-theme="light"] .mobile-bottom-nav a {
            color: #6b7280 !important;
        }

        [data-bs-theme="light"] .mobile-bottom-nav a.active {
            color: #e8a401 !important;
        }


        /* =========================================================
        BADGE
        ========================================================= */

        [data-bs-theme="light"] .badge-license {
            background: rgba(244, 180, 0, 0.08) !important;
            border-color: rgba(244, 180, 0, 0.35) !important;
            color: #d99a00 !important;
        }

        [data-bs-theme="light"] .badge-urgent,
        [data-bs-theme="light"] .urgent {
            background: rgba(255, 70, 70, 0.08) !important;
            color: #dc4c4c !important;
            border-color: rgba(255, 70, 70, 0.25) !important;
        }


        /* =========================================================
        FOOTER
        ========================================================= */

        [data-bs-theme="light"] .right-footer,
        [data-bs-theme="light"] .right-footer a {
            color: #6b7280 !important;
        }

        [data-bs-theme="light"] .right-footer a:hover {
            color: #111827 !important;
        }
    </style>

    @yield('style')
</head>

<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true"
    data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true"
    data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true"
    data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
    <script>
        var defaultThemeMode = "light";
        var themeMode;

        if (document.documentElement) {

            if (localStorage.getItem("data-bs-theme") !== null) {
                themeMode = localStorage.getItem("data-bs-theme");
            } else {
                themeMode = defaultThemeMode;
            }

            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches
                    ? "dark"
                    : "light";
            }

            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }
    </script>
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            <div id="kt_app_header" class="app-header" data-kt-sticky="true"
                data-kt-sticky-activate="{default: true, lg: true}" data-kt-sticky-name="app-header-minimize"
                data-kt-sticky-offset="{default: '200px', lg: '0'}" data-kt-sticky-animation="false">
                <div class="app-container container-fluid d-flex align-items-stretch justify-content-between"
                    id="kt_app_header_container">
                    <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0 mobile-logo">
                        <a href="javascript:;" class="d-lg-none">
                            <img alt="Logo"
                                src="{{ asset('/assets/media/logos/autoloker-logo.png') }}"
                                class="h-50px" style="background: white; border-radius: 8px;" />
                        </a>
                    </div>

                    <div class="d-flex align-items-center d-lg-none ms-n3 me-1 me-md-2 mobile-search">
                        {{-- <div class="header-search">
                            <i class="ki-duotone ki-magnifier search-icon">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>

                            <input
                                type="text"
                                class="search-input"
                                placeholder="Cari orang, lowongan, SOP..."
                            >
                        </div> --}}
                    </div>
                    <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1"
                        id="kt_app_header_wrapper">
                        <div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true"
                            data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}"
                            data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="end"
                            data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true"
                            data-kt-swapper-mode="{default: 'append', lg: 'prepend'}"
                            data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}" style="margin-bottom: auto; margin-top: auto;">
                            
                                <img src="{{ asset('/assets/media/logos/autoloker-logo.png') }}"
                                    height="40">

                                {{-- <div class="header-search">
                                    <i class="ki-duotone ki-magnifier search-icon">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>

                                    <input
                                        type="text"
                                        class="search-input"
                                        placeholder="Cari orang, lowongan, SOP..."
                                    >
                                </div> --}}
                        </div>
                        <div class="app-navbar flex-shrink-0">

                            <a href="{{ route('user-page.home') }}" class="nav-item {{ Route::is('user-page.home') ? 'active' : '' }}">
                                <i class="ki-duotone ki-home"></i>
                                <span>Home</span>
                            </a>

                            <a href="{{ route('user-page.network') }}" class="nav-item {{ Route::is('user-page.network') ? 'active' : '' }}">
                                <i class="ki-duotone ki-profile-circle"></i>
                                <span>Jejaring</span>
                            </a>

                            <a href="{{ route('user-page.training.index') }}" class="nav-item {{ Route::is('user-page.training.index') ? 'active' : '' }}">
                                <i class="ki-duotone ki-briefcase"></i>
                                <span>Pelatihan</span>
                            </a>

                            <a href="{{ route('user-page.certificate') }}" class="nav-item {{ Route::is('user-page.certificate') ? 'active' : '' }}">
                                <i class="ki-duotone ki-verify"></i>
                                <span>Sertifikasi</span>
                            </a>

                            {{-- <a href="javascript:;" class="nav-item">
                                <i class="ki-duotone ki-message-text-2"></i>
                                <span>Pesan</span>
                            </a> --}}

                            <a href="{{ route('user-page.notif') }}" class="nav-item {{ Route::is('user-page.notif') ? 'active' : '' }}">
                                <i class="ki-duotone ki-notification"></i>
                                <span>Notifikasi</span>
                            </a>

                            <div class="nav-item position-relative"
                                id="kt_header_user_menu_toggle"
                                data-kt-menu-trigger="{default:'click',lg:'click'}"
                                data-kt-menu-placement="bottom-end">

                                @php
                                    $security = \App\Models\UserSecurity::with('security')->where('user_id', Auth::user()->id)->first();
                                    $userName = $security->security->name ?? 'Nama Belum diisi';
                                    $userPosition = $security->security->position ?? 'jabatan Belum diisi';
                                    $userAvatar = $security->security->formal_photo ?  Storage::url($security->security->formal_photo) : asset('assets/media/avatars/300-3.jpg');
                                @endphp

                                <div class="profile-trigger">

                                    <img src="{{ $userAvatar }}"
                                        class="nav-avatar rounded-circle">

                                    <div class="profile-info">
                                        <span>Profil</span>
                                        <i class="ki-duotone ki-down fs-7"></i>
                                    </div>

                                </div>

                                <!--begin::User menu-->
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-semibold py-4 fs-6 w-325px"
                                    data-kt-menu="true">

                                    <!-- User -->
                                    <div class="px-5">
                                        <div class="d-flex align-items-center">

                                            <img src="{{ $userAvatar }}"
                                                class="rounded-circle me-4"
                                                width="72"
                                                height="72"
                                                style="object-fit: cover;">

                                            <div>
                                                <div class="fw-bold fs-3 text-white">
                                                    {{ $userName }}
                                                </div>

                                                <div class="fs-5 text-gray-500">
                                                    {{ $userPosition }}
                                                </div>
                                            </div>

                                        </div>

                                        <a href="{{ route('user-page.profile') }}"
                                            class="btn btn-outline btn-outline-secondary w-100 mt-5 text-warning" style="border-color:#ffb400;"
                                            onclick="window.location=this.href"
                                            >
                                            Lihat Profil
                                        </a>

                                    </div>

                                    <div class="separator my-5"></div>

                                    <div class="menu-item px-5">
                                        <a href="javascript:;" class="menu-link px-3 text-white">

                                            <i class="ki-duotone ki-setting-2 fs-2 me-3"></i>

                                            Pengaturan & Privasi

                                        </a>
                                    </div>
                                    
                                    {{-- <div class="separator my-5"></div> --}}

                                    <div class="menu-item px-5">
                                    <div class="menu-link px-3 text-white d-flex align-items-center justify-content-between">

                                        <div class="d-flex align-items-center">
                                            <i class="ki-duotone ki-moon fs-2 me-3 theme-icon"></i>

                                            <span>Tampilan</span>
                                        </div>

                                        <div class="d-flex align-items-center gap-2">

                                            <button type="button"
                                                class="btn btn-sm btn-icon btn-light"
                                                id="btnThemeLight"
                                                title="Light Mode">
                                                <i class="ki-duotone ki-sun fs-3"></i>
                                            </button>

                                            <button type="button"
                                                class="btn btn-sm btn-icon btn-dark"
                                                id="btnThemeDark"
                                                title="Dark Mode">
                                                <i class="ki-duotone ki-moon fs-3"></i>
                                            </button>

                                        </div>

                                    </div>
                                </div>

                                    {{-- <div class="menu-item px-5">
                                        <a href="javascript:;" class="menu-link px-3 text-white">

                                            <i class="ki-duotone ki-lock fs-2 me-3"></i>

                                            Keamanan Akun

                                        </a>
                                    </div> --}}

                                    {{-- <div class="menu-item px-5">
                                        <a href="javascript:;" class="menu-link px-3 text-white">

                                            <i class="ki-duotone ki-geolocation-home fs-2 me-3"></i>

                                            Bahasa : Indonesia

                                        </a>
                                    </div> --}}

                                    <div class="separator my-3"></div>

                                    <div class="menu-item px-5">
                                        <a href="javascript:;" class="menu-link px-3 text-white text-danger" id="btnLogout">

                                            <i class="ki-duotone ki-exit-right fs-2 me-3 text-danger"></i>

                                            Keluar

                                        </a>
                                    </div>

                                </div>

                            </div>

                        </div>
                        <div class="mobile-bottom-nav">

                            <a href="{{ route('user-page.home') }}" class="{{ Route::is('user-page.home') ? 'active' : '' }}">
                                <i class="ki-duotone ki-home"></i>
                                <span>Home</span>
                            </a>

                            <a href="{{ route('user-page.network') }}" class="{{ Route::is('user-page.network') ? 'active' : '' }}">
                                <i class="ki-duotone ki-profile-circle"></i>
                                <span>Jejaring</span>
                            </a>

                            <a href="{{ route('user-page.training.index') }}" class="{{ Route::is('user-page.training.index') ? 'active' : '' }}">
                                <i class="ki-duotone ki-briefcase"></i>
                                <span>Pelatihan</span>
                            </a>

                            <a href="{{ route('user-page.certificate') }}" class="{{ Route::is('user-page.certificate') ? 'active' : '' }}">
                                <i class="ki-duotone ki-verify"></i>
                                <span>Sertifikasi</span>
                            </a>

                            {{-- <a href="javascript:;">
                                <i class="ki-duotone ki-message-text-2"></i>
                                <span>Pesan</span>
                            </a> --}}

                            <a href="{{ route('user-page.notif') }}" class="{{ Route::is('user-page.notif') ? 'active' : '' }}">
                                <i class="ki-duotone ki-notification"></i>
                                <span>Notif</span>
                            </a>

                            <!-- PROFILE -->
                            <a href="{{ route('user-page.profile') }}"
                            data-kt-menu-trigger="click"
                            data-kt-menu-placement="top-end">

                                <img src="/assets/media/avatars/300-3.jpg"
                                    class="bottom-avatar rounded-circle">

                                <span>Profil</span>

                            </a>

                        </div>
                    </div>
                </div>
            </div>
            <!--end::Header-->
            <!--begin::Wrapper-->
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                <!--begin::Main-->
                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                    <!--begin::Content wrapper-->
                    <div class="d-flex flex-column flex-column-fluid">
                        @yield('content')
                    </div>
                    <!--end::Content wrapper-->
                    <!--begin::Footer-->
                    {{-- <div id="kt_app_footer" class="app-footer d-none d-md-block">
                        <!--begin::Footer container-->
                        <div
                            class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
                            <!--begin::Copyright-->
                            <div class="text-gray-900 order-2 order-md-1">
                                <span class="text-muted fw-semibold me-1">2026&copy;</span>
                                <a href="https://keenthemes.com" target="_blank"
                                    class="text-gray-800 text-hover-primary">Keenthemes</a>
                            </div>
                            <!--end::Copyright-->
                            <!--begin::Menu-->
                            <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
                                <li class="menu-item">
                                    <a href="https://keenthemes.com" target="_blank"
                                        class="menu-link px-2">About</a>
                                </li>
                                <li class="menu-item">
                                    <a href="https://devs.keenthemes.com" target="_blank"
                                        class="menu-link px-2">Support</a>
                                </li>
                                <li class="menu-item">
                                    <a href="https://1.envato.market/EA4JP" target="_blank"
                                        class="menu-link px-2">Purchase</a>
                                </li>
                            </ul>
                            <!--end::Menu-->
                        </div>
                        <!--end::Footer container-->
                    </div> --}}
                    <!--end::Footer-->
                </div>
                <!--end:::Main-->
            </div>
            <!--end::Wrapper-->
        </div>
    </div>
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <i class="ki-duotone ki-arrow-up">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
    </div>
    <script src="/assets/plugins/global/plugins.bundle.js"></script>
    <script src="/assets/js/scripts.bundle.js"></script>
    <script src="/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/map.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
    <script src="/assets/js/widgets.bundle.js"></script>
    <script src="/assets/js/custom/widgets.js"></script>
    <script src="/assets/js/custom/apps/chat/chat.js"></script>
    <script src="/assets/js/custom/utilities/modals/upgrade-plan.js"></script>
    <script src="/assets/js/custom/utilities/modals/create-app.js"></script>
    <script src="/assets/js/custom/utilities/modals/new-target.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).on('click', '#btnLogout', function () {

            Swal.fire({

                title: 'Logout?',
                text: 'Apakah Anda yakin ingin keluar?',
                icon: 'question',

                showCancelButton: true,

                confirmButtonColor: '#ffc107',
                cancelButtonColor: '#6c757d',

                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal',

                background: '#152040',
                color: '#fff'

            }).then((result) => {

                if (!result.isConfirmed) return;

                $.ajax({

                    url: "{{ route('logout') }}",

                    type: "POST",

                    data: {
                        _token: "{{ csrf_token() }}"
                    },

                    success: function(res){

                        Swal.fire({

                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message,
                            timer: 1200,
                            showConfirmButton: false,
                            background: '#152040',
                            color: '#fff'

                        }).then(() => {

                            window.location.href = res.redirect;

                        });

                    },

                    error: function(){

                        Swal.fire({

                            icon: 'error',
                            title: 'Oops...',
                            text: 'Logout gagal.',
                            confirmButtonColor: '#ffc107',
                            background: '#152040',
                            color: '#fff'

                        });

                    }

                });

            });

        });
    </script>

    {{-- PROFILE --}}
    <script>
        $(document).on("click",".profile-menu",function(){

            $(".profile-menu").removeClass("active");

            $(this).addClass("active");

            let target = $(this).data("target");

            $(".profile-page").addClass("d-none");

            $("#" + target).removeClass("d-none");

        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const html = document.documentElement;

            const btnLight = document.getElementById('btnThemeLight');
            const btnDark = document.getElementById('btnThemeDark');

            function setTheme(theme) {

                html.setAttribute('data-bs-theme', theme);

                localStorage.setItem('data-bs-theme', theme);

                updateThemeButton(theme);
            }

            function updateThemeButton(theme) {

                if (!btnLight || !btnDark) {
                    return;
                }

                if (theme === 'light') {

                    btnLight.classList.add('active');
                    btnDark.classList.remove('active');

                    btnLight.classList.remove('btn-light');
                    btnLight.classList.add('btn-warning');

                    btnDark.classList.remove('btn-dark');
                    btnDark.classList.add('btn-light');

                } else {

                    btnDark.classList.add('active');
                    btnLight.classList.remove('active');

                    btnDark.classList.remove('btn-light');
                    btnDark.classList.add('btn-warning');

                    btnLight.classList.remove('btn-warning');
                    btnLight.classList.add('btn-light');
                }
            }

            // Klik Light
            if (btnLight) {
                btnLight.addEventListener('click', function (e) {

                    e.preventDefault();
                    e.stopPropagation();

                    setTheme('light');
                });
            }

            // Klik Dark
            if (btnDark) {
                btnDark.addEventListener('click', function (e) {

                    e.preventDefault();
                    e.stopPropagation();

                    setTheme('dark');
                });
            }

            // Ambil theme saat halaman dibuka
            let currentTheme = html.getAttribute('data-bs-theme');

            if (!currentTheme) {
                currentTheme = localStorage.getItem('data-bs-theme') || 'light';
            }

            updateThemeButton(currentTheme);

        });
    </script>

    @if(session('swal'))
        <script>
            Swal.fire({
                icon: "{{ session('swal.icon') }}",
                title: "{{ session('swal.title') }}",
                text: "{{ session('swal.text') }}",
                confirmButtonColor: '#ffc107',
                background: '#152040',
                color: 'white',
                didOpen: () => {
                    document.querySelector('.swal2-title').style.setProperty('color', '#fff', 'important');
                    document.querySelector('.swal2-html-container').style.setProperty('color', '#fff', 'important');
                }
            });
        </script>
    @endif

    @yield('js')
</body>

</html>
