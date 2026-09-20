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
    <link href="/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet" type="text/css" href="/assets/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script></script>
    <style>
        body {
            background-color: #080d1c;
        }

        .card-button{
            display:flex;
            align-items:center;
            gap:8px;
            flex-wrap:wrap;
        }

        .card-button .dt-buttons{
            display:flex;
            gap:8px;
            flex-wrap:wrap;
        }

        .card-button .btn{
            height:38px;
            min-width:38px;
            display:flex;
            align-items:center;
            justify-content:center;
            border-radius:10px;
            padding:0 14px;
            font-size:13px;
            font-weight:600;
            transition:.2s;
        }

        .card-button .btn i{
            font-size:14px;
        }

        /* Copy */
        .btn-copy{
            background:#dc3545;
            border-color:#dc3545;
            color:#fff;
        }

        .btn-copy:hover{
            background:#bb2d3b;
            border-color:#bb2d3b;
        }

        /* Excel */
        .btn-excel{
            background:#198754;
            border-color:#198754;
            color:#fff;
        }

        .btn-excel:hover{
            background:#157347;
            border-color:#157347;
        }

        /* Column */
        .btn-colvis{
            background:#f7b003;
            border-color:#f7b003;
            color:#fff;
        }

        .btn-colvis:hover{
            background:#f7b003;
            border-color:#f7b003;
        }

        div.dt-button-collection button.dt-button:active:not(.disabled), div.dt-button-collection button.dt-button.active:not(.disabled), div.dt-button-collection div.dt-button:active:not(.disabled), div.dt-button-collection div.dt-button.active:not(.disabled), div.dt-button-collection a.dt-button:active:not(.disabled), div.dt-button-collection a.dt-button.active:not(.disabled) {
            background-color: #f7b003;
        }

        div.dt-button-info,
        div.dt-button-info h2 {
            color: #000 !important;
        }
    </style>
    @yield('css')
</head>

<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true"
    data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true"
    data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true"
    data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
    <script>
        var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }
    </script>
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            <div id="kt_app_header" class="app-header" data-kt-sticky="true"
                data-kt-sticky-activate="{default: true, lg: true}" data-kt-sticky-name="app-header-minimize"
                data-kt-sticky-offset="{default: '200px', lg: '0'}" data-kt-sticky-animation="false">
                <div class="app-container container-fluid d-flex align-items-stretch justify-content-between"
                    id="kt_app_header_container">
                    <div class="d-flex align-items-center d-lg-none ms-n3 me-1 me-md-2" title="Show sidebar menu">
                        <div class="btn btn-icon btn-active-color-primary w-35px h-35px"
                            id="kt_app_sidebar_mobile_toggle">
                            <i class="ki-duotone ki-abstract-14 fs-2 fs-md-1">
                            </i>
                        </div>
                    </div>
                    <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
                        <a href="javascript:;" class="d-lg-none">
                            <img alt="Logo" src="/assets/media/logos/autoloker-logo.png" class="h-50px" style="background: white; border-radius: 8px;"/>
                        </a>
                    </div>
                    <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1"
                        id="kt_app_header_wrapper">
                        <div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true"
                            data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}"
                            data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="end"
                            data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true"
                            data-kt-swapper-mode="{default: 'append', lg: 'prepend'}"
                            data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
                            
                        </div>
                        <div class="app-navbar flex-shrink-0">
                            <div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">

                                {{-- TOGGLE BUTTON --}}
                                <a href="#"
                                    class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px"
                                    data-kt-menu-trigger="{default:'click', lg: 'hover'}"
                                    data-kt-menu-attach="parent"
                                    data-kt-menu-placement="bottom-end">

                                    {{-- LIGHT ICON --}}
                                    <i class="ki-duotone ki-night-day theme-light-show fs-1">
                                    </i>

                                    {{-- DARK ICON --}}
                                    <i class="ki-duotone ki-moon theme-dark-show fs-1">
                                    </i>

                                </a>


                                {{-- THEME MENU --}}
                                <div
                                    id="theme-mode-menu"
                                    class="menu menu-sub menu-sub-dropdown menu-column menu-rounded
                                        menu-title-gray-700 menu-icon-gray-500 menu-active-bg
                                        menu-state-color fw-semibold py-4 fs-base w-150px"
                                    data-kt-menu="true"
                                    data-kt-element="theme-mode-menu">


                                    {{-- LIGHT --}}
                                    <div class="menu-item px-3 my-0">

                                        <a href="#"
                                            class="menu-link px-3 py-2 active"
                                            data-kt-element="mode"
                                            data-kt-value="light">

                                            <span class="menu-icon">

                                                <i class="ki-duotone ki-night-day fs-2">
                                                </i>

                                            </span>

                                            <span class="menu-title">
                                                Light
                                            </span>

                                        </a>

                                    </div>


                                    {{-- DARK --}}
                                    <div class="menu-item px-3 my-0">

                                        <a href="#"
                                            class="menu-link px-3 py-2"
                                            data-kt-element="mode"
                                            data-kt-value="dark">

                                            <span class="menu-icon">

                                                <i class="ki-duotone ki-moon fs-2">
                                                </i>

                                            </span>

                                            <span class="menu-title">
                                                Dark
                                            </span>

                                        </a>

                                    </div>

                                </div>

                            </div>
                            <!--end::Theme mode-->
                            <!--begin::User menu-->
                            <div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">
                                <!--begin::Menu wrapper-->
                                <div class="cursor-pointer symbol symbol-35px"
                                    data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                                    data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                    <img src="/assets/media/avatars/300-3.jpg" class="rounded-3" alt="user" />
                                </div>
                                <!--begin::User account menu-->
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
                                    data-kt-menu="true">
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <div class="menu-content d-flex align-items-center px-3">
                                            <!--begin::Avatar-->
                                            <div class="symbol symbol-50px me-5">
                                                <img alt="Logo" src="{{ Auth::user()->avatar ?? '/assets/media/avatars/300-3.jpg' }}" />
                                            </div>
                                            <!--end::Avatar-->
                                            <!--begin::Username-->
                                            <div class="d-flex flex-column">
                                                <div class="fw-bold d-flex align-items-center fs-5">{{ Auth::user()->name }}
                                                    {{-- <span
                                                        class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">Pro</span> --}}
                                                </div>
                                                <a href="#"
                                                    class="fw-semibold text-muted text-hover-primary fs-7">{{ Auth::user()->email }}</a>
                                            </div>
                                            <!--end::Username-->
                                        </div>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu separator-->
                                    <div class="separator my-2"></div>
                                    <!--end::Menu separator-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-5">
                                        <a href="javascript:;" class="menu-link px-5">My Profile</a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-5">
                                        <a href="javascript:;"
                                            class="menu-link px-5">
                                            <button id="btnLogout" type="button" class="btn p-0 border-0 bg-transparent shadow-none text-start w-100">
                                                Sign Out
                                            </button>
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                </div>
                                <!--end::User account menu-->
                                <!--end::Menu wrapper-->
                            </div>
                            <!--end::User menu-->
                            <!--begin::Header menu toggle-->
                            <!--end::Header menu toggle-->
                            <!--begin::Aside toggle-->
                            <!--end::Header menu toggle-->
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Header-->
            <!--begin::Wrapper-->
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                <!--begin::Sidebar-->
                <div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true"
                    data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}"
                    data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start"
                    data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
                    <!--begin::Logo-->
                    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
                        <!--begin::Logo image-->
                        <a href="javascript:;">
                            <img alt="Logo" src="/assets/media/logos/autoloker-logo.png"
                                class="h-50px app-sidebar-logo-default" style="background: white; border-radius: 8px;"/>
                            <img alt="Logo" src="/assets/media/logos/autoloker-logo-small.png"
                                class="h-50px app-sidebar-logo-minimize" style="background: white; border-radius: 8px;"/>
                        </a>
                        <!--end::Logo image-->
                        <!--begin::Sidebar toggle-->
                        <!--begin::Minimized sidebar setup:
                            if (isset($_COOKIE["sidebar_minimize_state"]) && $_COOKIE["sidebar_minimize_state"] === "on") {
                                1. "src/js/layout/sidebar.js" adds "sidebar_minimize_state" cookie value to save the sidebar minimize state.
                                2. Set data-kt-app-sidebar-minimize="on" attribute for body tag.
                                3. Set data-kt-toggle-state="active" attribute to the toggle element with "kt_app_sidebar_toggle" id.
                                4. Add "active" class to to sidebar toggle element with "kt_app_sidebar_toggle" id.
                            }
                        -->
                        <div id="kt_app_sidebar_toggle"
                            class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary h-30px w-30px position-absolute top-50 start-100 translate-middle rotate"
                            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
                            data-kt-toggle-name="app-sidebar-minimize">
                            <i class="ki-duotone ki-black-left-line fs-3 rotate-180">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </div>
                        <!--end::Sidebar toggle-->
                    </div>
                    <!--end::Logo-->
                    <!--begin::sidebar menu-->
                    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
                        <!--begin::Menu wrapper-->
                        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
                            <!--begin::Scroll wrapper-->
                            <div id="kt_app_sidebar_menu_scroll" class="scroll-y my-5 mx-3" data-kt-scroll="true"
                                data-kt-scroll-activate="true" data-kt-scroll-height="auto"
                                data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
                                data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px"
                                data-kt-scroll-save-state="true">
                                <!--begin::Menu-->
                                <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6"
                                    id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
                                    <div class="menu-item">

                                        <a href="{{ route('dashboard-admin.index') }}" class="menu-link {{ Route::is('dashboard-admin.index') ? 'active' : '' }}">

                                            <span class="menu-icon">
                                                <i class="ki-duotone ki-home fs-2">
                                                </i>
                                            </span>

                                            <span class="menu-title">
                                                Beranda
                                            </span>

                                        </a>

                                    </div>
                                    <div data-kt-menu-trigger="click" class="menu-item {{ Route::is('dashboard-admin.master.*') ? 'here show' : '' }} menu-accordion">
                                        <!--begin:Menu link-->
                                        <span class="menu-link">
                                            <span class="menu-icon">
                                                <i class="ki-duotone ki-data fs-2">
                                                </i>
                                            </span>
                                            <span class="menu-title">Master</span>
                                            <span class="menu-arrow"></span>
                                        </span>
                                        <!--end:Menu link-->
                                        <!--begin:Menu sub-->
                                        <div class="menu-sub menu-sub-accordion">
                                            <!--begin:Menu item-->
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a class="menu-link {{ Route::is('dashboard-admin.master.position.*') ? 'active' : '' }}" href="{{ route('dashboard-admin.master.position.index') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Jabatan</span>
                                                </a>
                                                <a class="menu-link {{ Route::is('dashboard-admin.master.position-security.*') ? 'active' : '' }}" href="{{ route('dashboard-admin.master.position-security.index') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Jabatan Satpam</span>
                                                </a>
                                                <a class="menu-link {{ Route::is('dashboard-admin.master.placement.*') ? 'active' : '' }}" href="{{ route('dashboard-admin.master.placement.index') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Penempatan</span>
                                                </a>
                                                <a class="menu-link {{ Route::is('dashboard-admin.master.ability.*') ? 'active' : '' }}" href="{{ route('dashboard-admin.master.ability.index') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Kemampuan</span>
                                                </a>
                                                <a class="menu-link {{ Route::is('dashboard-admin.master.category-certificate.*') ? 'active' : '' }}" href="{{ route('dashboard-admin.master.category-certificate.index') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Kategori Sertifikasi</span>
                                                </a>
                                                <a class="menu-link {{ Route::is('dashboard-admin.master.certificate.*') ? 'active' : '' }}" href="{{ route('dashboard-admin.master.certificate.index') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Sertifikasi</span>
                                                </a>
                                                <a class="menu-link {{ Route::is('dashboard-admin.master.competency-scheme.*') ? 'active' : '' }}" href="{{ route('dashboard-admin.master.competency-scheme.index') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Kompetensi Skema</span>
                                                </a>
                                                <a class="menu-link {{ Route::is('dashboard-admin.master.industry.*') ? 'active' : '' }}" href="{{ route('dashboard-admin.master.industry.index') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Bidang Usaha</span>
                                                </a>
                                                <a class="menu-link {{ Route::is('dashboard-admin.master.subscription.*') ? 'active' : '' }}" href="{{ route('dashboard-admin.master.subscription.index') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Subscription</span>
                                                </a>
                                                <a class="menu-link {{ Route::is('dashboard-admin.master.faq.*') ? 'active' : '' }}" href="{{ route('dashboard-admin.master.faq.index') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">FAQ</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->
                                        </div>
                                        <!--end:Menu sub-->
                                    </div>

                                    <div data-kt-menu-trigger="click" class="menu-item {{ Route::is('dashboard-admin.management-user.*') ? 'here show' : '' }} menu-accordion">
                                        <!--begin:Menu link-->
                                        <span class="menu-link">
                                            <span class="menu-icon">
                                                <i class="ki-duotone ki-users fs-2">
                                                </i>
                                            </span>
                                            <span class="menu-title">Manajemen User</span>
                                            <span class="menu-arrow"></span>
                                        </span>
                                        <!--end:Menu link-->
                                        <!--begin:Menu sub-->
                                        <div class="menu-sub menu-sub-accordion">
                                            <!--begin:Menu item-->
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a class="menu-link {{ Route::is('dashboard-admin.management-user.admin.*') ? 'active' : '' }}" href="{{ route('dashboard-admin.management-user.admin.index') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Admin</span>
                                                </a>
                                                <a class="menu-link {{ Route::is('dashboard-admin.management-user.security.*') ? 'active' : '' }}" href="{{ route('dashboard-admin.management-user.security.index') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Satpam</span>
                                                </a>
                                                <a class="menu-link {{ Route::is('dashboard-admin.management-user.bujp.*') ? 'active' : '' }}" href="{{ route('dashboard-admin.management-user.bujp.index') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">BUJP</span>
                                                </a>
                                                <a class="menu-link {{ Route::is('dashboard-admin.management-user.company.*') ? 'active' : '' }}" href="{{ route('dashboard-admin.management-user.company.index') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Perusahaan Klien</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->
                                        </div>
                                        <!--end:Menu sub-->
                                    </div>

                                    <div data-kt-menu-trigger="click" class="menu-item {{ Route::is('dashboard-admin.job-vacancy.*') ? 'here show' : '' }} menu-accordion">
                                        <!--begin:Menu link-->
                                        <span class="menu-link">
                                            <span class="menu-icon">
                                                <i class="ki-duotone ki-briefcase fs-2">
                                                </i>
                                            </span>
                                            <span class="menu-title">Manajemen Lowongan</span>
                                            <span class="menu-arrow"></span>
                                        </span>
                                        <!--end:Menu link-->
                                        <!--begin:Menu sub-->
                                        <div class="menu-sub menu-sub-accordion">
                                            <!--begin:Menu item-->
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a class="menu-link {{ Route::is('dashboard-admin.job-vacancy.submitted.*') ? 'active' : '' }}" href="{{ route('dashboard-admin.job-vacancy.submitted.index') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Menunggu Review</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->
                                        </div>
                                        <!--end:Menu sub-->
                                        <!--begin:Menu sub-->
                                        <div class="menu-sub menu-sub-accordion">
                                            <!--begin:Menu item-->
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a class="menu-link {{ Route::is('dashboard-admin.job-vacancy.rejected.*') ? 'active' : '' }}" href="{{ route('dashboard-admin.job-vacancy.rejected.index') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Ditolak</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->
                                        </div>
                                        <!--end:Menu sub-->
                                        <!--begin:Menu sub-->
                                        <div class="menu-sub menu-sub-accordion">
                                            <!--begin:Menu item-->
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a class="menu-link {{ Route::is('dashboard-admin.job-vacancy.published.*') ? 'active' : '' }}" href="{{ route('dashboard-admin.job-vacancy.published.index') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Terpublish</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->
                                        </div>
                                        <!--end:Menu sub-->
                                        <!--begin:Menu sub-->
                                        <div class="menu-sub menu-sub-accordion">
                                            <!--begin:Menu item-->
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a class="menu-link {{ Route::is('dashboard-admin.job-vacancy.closed.*') ? 'active' : '' }}" href="{{ route('dashboard-admin.job-vacancy.closed.index') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Ditutup</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->
                                        </div>
                                        <!--end:Menu sub-->
                                    </div>

                                    <div data-kt-menu-trigger="click" class="menu-item {{ Route::is('dashboard-admin.training.*') ? 'here show' : '' }} menu-accordion">
                                        <!--begin:Menu link-->
                                        <span class="menu-link">
                                            <span class="menu-icon">
                                                <i class="ki-duotone ki-award fs-2">
                                                </i>
                                            </span>
                                            <span class="menu-title">Manajemen Pelatihan</span>
                                            <span class="menu-arrow"></span>
                                        </span>
                                        <!--end:Menu link-->
                                        <!--begin:Menu sub-->
                                        <div class="menu-sub menu-sub-accordion">
                                            <!--begin:Menu item-->
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a class="menu-link {{ Route::is('dashboard-admin.training.submitted.*') ? 'active' : '' }}" href="{{ route('dashboard-admin.training.submitted.index') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Menunggu Review</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->
                                        </div>
                                        <!--end:Menu sub-->
                                        <!--begin:Menu sub-->
                                        <div class="menu-sub menu-sub-accordion">
                                            <!--begin:Menu item-->
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a class="menu-link {{ Route::is('dashboard-admin.training.rejected.*') ? 'active' : '' }}" href="{{ route('dashboard-admin.training.rejected.index') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Ditolak</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->
                                        </div>
                                        <!--end:Menu sub-->
                                        <!--begin:Menu sub-->
                                        <div class="menu-sub menu-sub-accordion">
                                            <!--begin:Menu item-->
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a class="menu-link {{ Route::is('dashboard-admin.training.published.*') ? 'active' : '' }}" href="{{ route('dashboard-admin.training.published.index') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Terpublish</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->
                                        </div>
                                        <!--end:Menu sub-->
                                        <!--begin:Menu sub-->
                                        <div class="menu-sub menu-sub-accordion">
                                            <!--begin:Menu item-->
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a class="menu-link {{ Route::is('dashboard-admin.training.cancelled.*') ? 'active' : '' }}" href="{{ route('dashboard-admin.training.cancelled.index') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Dibatalkan</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->
                                        </div>
                                        <!--end:Menu sub-->
                                        <!--begin:Menu sub-->
                                        <div class="menu-sub menu-sub-accordion">
                                            <!--begin:Menu item-->
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a class="menu-link {{ Route::is('dashboard-admin.training.running.*') ? 'active' : '' }}" href="{{ route('dashboard-admin.training.running.index') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Berjalan</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->
                                        </div>
                                        <!--end:Menu sub-->
                                        <!--begin:Menu sub-->
                                        <div class="menu-sub menu-sub-accordion">
                                            <!--begin:Menu item-->
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a class="menu-link {{ Route::is('dashboard-admin.training.closed.*') ? 'active' : '' }}" href="{{ route('dashboard-admin.training.closed.index') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Ditutup</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->
                                        </div>
                                        <!--end:Menu sub-->
                                    </div>
                                </div>
                                <!--end::Menu-->
                            </div>
                            <!--end::Scroll wrapper-->
                        </div>
                        <!--end::Menu wrapper-->
                    </div>
                    <!--end::sidebar menu-->
                    <!--begin::Footer-->
                    <div class="app-sidebar-footer flex-column-auto pt-2 pb-6 px-6" id="kt_app_sidebar_footer">

                    </div>
                    <!--end::Footer-->
                </div>
                <!--end::Sidebar-->
                <!--begin::Main-->
                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                    <!--begin::Content wrapper-->
                    <div class="d-flex flex-column flex-column-fluid">
                        <!--begin::Toolbar-->
                        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
                            <!--begin::Toolbar container-->
                            <div id="kt_app_toolbar_container"
                                class="app-container container-fluid d-flex flex-stack">
                                <!--begin::Page title-->
                                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                                    @yield('breadcrumb')
                                </div>
                                <!--end::Page title-->
                            </div>
                            <!--end::Toolbar container-->
                        </div>
                        <div id="kt_app_content" class="app-content flex-column-fluid">

                            <div id="kt_app_content_container"
                                class="app-container container-fluid">

                                @yield('content')

                            </div>

                        </div>
                    </div>
                    <!--end::Content wrapper-->
                    <!--begin::Footer-->
                    <div id="kt_app_footer" class="app-footer">
                        <!--begin::Footer container-->
                        <div
                            class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
                            <!--begin::Copyright-->
                            <div class="text-gray-900 order-2 order-md-1">
                                <span class="text-muted fw-semibold me-1">2026&copy;</span>
                                <a href="javascript:;"
                                    class="text-gray-800 text-hover-primary">Keenthemes</a>
                            </div>
                            <!--end::Copyright-->
                            <!--begin::Menu-->
                            <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
                                <li class="menu-item">
                                    <a href="javascript:;"
                                        class="menu-link px-2">About</a>
                                </li>
                                <li class="menu-item">
                                    <a href="javascript:;"
                                        class="menu-link px-2">Support</a>
                                </li>
                            </ul>
                            <!--end::Menu-->
                        </div>
                        <!--end::Footer container-->
                    </div>
                    <!--end::Footer-->
                </div>
                <!--end:::Main-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <i class="ki-duotone ki-arrow-up">
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
    <!-- Required datatable js -->
    <script src="/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <!-- Buttons examples -->
    <script src="/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="/assets/libs/jszip/jszip.min.js"></script>
    <script src="/assets/libs/pdfmake/build/pdfmake.min.js"></script>
    <script src="/assets/libs/pdfmake/build/vfs_fonts.js"></script>
    <script src="/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/4.0.1/js/dataTables.fixedHeader.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/4.0.1/js/fixedHeader.dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.dataTables.js"></script>

    <!-- Responsive examples -->
    <script src="/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

    <!-- Datatable init js -->
    <script src="/assets/js/pages/datatables.init.js"></script>

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

                    url: "{{ route('lgt-admn') }}",

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

    @yield('js')
</body>

</html>
