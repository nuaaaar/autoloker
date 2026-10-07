@extends('layouts.dashboard-admin')

@section('title', 'Beranda')

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
    <style>
        /* =========================================================
        THEME VARIABLES
        ========================================================= */

        :root,
        [data-bs-theme="light"] {
            --map-card-bg: #ffffff;
            --map-card-border: #e2e8f0;
            --map-header-bg: #ffffff;
            --map-header-border: #e2e8f0;

            --map-text: #182338;
            --map-text-secondary: #64748b;
            --map-text-muted: #94a3b8;

            --map-container-bg: #e8eef5;

            --map-card-inner-bg: #ffffff;
            --map-card-inner-border: #e2e8f0;

            --map-popup-bg: #ffffff;
            --map-popup-border: #e2e8f0;
            --map-popup-footer-bg: #f8fafc;

            --map-divider: rgba(15, 23, 42, .08);

            --map-accent: #f59e0b;
            --map-primary: #2563eb;

            --map-success: #16a34a;
            --map-danger: #dc2626;
            --map-warning: #d97706;
            --map-info: #0891b2;
            --map-secondary: #6b7280;

            --map-shadow: 0 8px 25px rgba(15, 23, 42, .08);
            --map-hover-shadow: 0 15px 30px rgba(15, 23, 42, .12);

            --map-leaflet-text: #182338;
        }


        [data-bs-theme="dark"] {
            --map-card-bg: #111827;
            --map-card-border: #374151;
            --map-header-bg: #111827;
            --map-header-border: #293548;

            --map-text: #ffffff;
            --map-text-secondary: #9ca3af;
            --map-text-muted: #6b7280;

            --map-container-bg: #020617;

            --map-card-inner-bg: #111827;
            --map-card-inner-border: #273244;

            --map-popup-bg: #111827;
            --map-popup-border: #293548;
            --map-popup-footer-bg: #0f172a;

            --map-divider: rgba(255, 255, 255, .08);

            --map-accent: #f59e0b;
            --map-primary: #2563eb;

            --map-success: #16a34a;
            --map-danger: #dc2626;
            --map-warning: #d97706;
            --map-info: #0891b2;
            --map-secondary: #6b7280;

            --map-shadow: 0 8px 25px rgba(0, 0, 0, .25);
            --map-hover-shadow: 0 15px 30px rgba(0, 0, 0, .35);

            --map-leaflet-text: #ffffff;
        }


        /* =========================================================
        MAP CARD
        ========================================================= */

        .map-card {
            background: var(--map-card-bg);
            color: var(--map-text);
            border: 1px solid var(--map-card-border);
            box-shadow: var(--map-shadow);
        }


        #indonesia-map {
            width: 100%;
            height: 450px;
        }


        .leaflet-container {
            background: var(--map-container-bg);
        }


        /* =========================================================
        MARKER
        ========================================================= */

        .marker-dot {
            width: 16px;
            height: 16px;

            background: var(--map-accent);

            border-radius: 50%;
            border: 3px solid #fff;

            box-shadow:
                0 0 10px var(--map-accent),
                0 0 20px var(--map-accent);
        }


        /* =========================================================
        CARD HEADER
        ========================================================= */

        .map-card .card-header {
            background: var(--map-header-bg);
            border-bottom: 1px solid var(--map-header-border);
        }


        .map-card .card-header h5 {
            color: var(--map-text);
        }


        .map-card .card-header small {
            color: var(--map-text-secondary) !important;
        }


        /* =========================================================
        MAP ICON
        ========================================================= */

        .map-icon {
            width: 52px;
            height: 52px;

            border-radius: 14px;

            background: linear-gradient(
                135deg,
                #2563eb,
                #3b82f6
            );

            display: flex;
            align-items: center;
            justify-content: center;

            color: #fff;
            font-size: 22px;

            box-shadow: 0 0 15px rgba(59, 130, 246, .35);
        }


        /* =========================================================
        DASHBOARD CARD
        ========================================================= */

        .dashboard-card {
            position: relative;

            display: flex;
            align-items: center;

            padding: 18px;

            border-radius: 16px;

            background: var(--map-card-inner-bg);
            border: 1px solid var(--map-card-inner-border);

            overflow: hidden;

            transition: .3s;

            min-height: 110px;
        }


        .dashboard-card:hover {
            transform: translateY(-5px);

            border-color: var(--map-primary);

            box-shadow: var(--map-hover-shadow);
        }


        .dashboard-card::after {
            content: "";

            position: absolute;

            right: -35px;
            top: -35px;

            width: 90px;
            height: 90px;

            border-radius: 50%;

            opacity: .08;

            background: var(--map-text);
        }


        /* =========================================================
        CARD ICON
        ========================================================= */

        .dashboard-card .card-icon {
            width: 56px;
            height: 56px;

            border-radius: 14px;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 22px;

            color: #fff;

            margin-right: 16px;

            flex-shrink: 0;
        }


        /* =========================================================
        CARD CONTENT
        ========================================================= */

        .card-content span {
            color: var(--map-text-secondary);

            font-size: 13px;

            display: block;
        }


        .card-content h3 {
            color: var(--map-text);

            margin: 4px 0;

            font-size: 28px;
            font-weight: 700;
        }


        .card-content small {
            color: var(--map-text-muted);
        }


        /* =========================================================
        CARD COLORS
        ========================================================= */

        .dashboard-card.success .card-icon {
            background: var(--map-success);
        }


        .dashboard-card.danger .card-icon {
            background: var(--map-danger);
        }


        .dashboard-card.primary .card-icon {
            background: var(--map-primary);
        }


        .dashboard-card.warning .card-icon {
            background: var(--map-warning);
        }


        .dashboard-card.info .card-icon {
            background: var(--map-info);
        }


        .dashboard-card.secondary .card-icon {
            background: var(--map-secondary);
        }


        /* =========================================================
        LEAFLET POPUP WRAPPER
        ========================================================= */

        .leaflet-popup-content-wrapper {
            padding: 0;

            border-radius: 14px;

            overflow: hidden;

            background: var(--map-popup-bg);

            color: var(--map-text);

            border: 1px solid var(--map-popup-border);

            box-shadow: var(--map-shadow);
        }


        .leaflet-popup-tip {
            background: var(--map-popup-bg);
        }


        .leaflet-popup-content {
            margin: 0 !important;
        }


        /* =========================================================
        POPUP
        ========================================================= */

        .province-popup {
            width: 320px;

            background: var(--map-popup-bg);

            color: var(--map-text);
        }


        /* =========================================================
        POPUP HEADER
        ========================================================= */

        .popup-header {
            padding: 18px;

            text-align: center;

            border-bottom: 1px solid var(--map-popup-border);
        }


        .popup-header h5 {
            margin: 0;

            color: var(--map-accent);

            font-weight: 700;

            font-size: 18px;
        }


        .popup-header small {
            color: var(--map-text-secondary);
        }


        /* =========================================================
        POPUP BODY
        ========================================================= */

        .popup-body {
            padding: 15px;
        }


        /* =========================================================
        POPUP GRID
        ========================================================= */

        .popup-row {
            display: grid;

            grid-template-columns: 2fr 1fr 1fr;

            align-items: center;

            padding: 10px 0;

            border-bottom: 1px solid var(--map-divider);
        }


        .popup-row:last-child {
            border-bottom: none;
        }


        .popup-head {
            color: var(--map-text-secondary);

            font-size: 12px;

            font-weight: 600;

            text-transform: uppercase;

            padding-bottom: 12px;
        }


        /* =========================================================
        USER NAME
        ========================================================= */

        .user-name {
            display: flex;

            align-items: center;

            gap: 10px;

            font-weight: 500;

            color: var(--map-text);
        }


        /* =========================================================
        BADGE
        ========================================================= */

        .province-popup .badge {
            width: 34px;
            height: 34px;

            display: flex;

            justify-content: center;
            align-items: center;

            margin: auto;

            border-radius: 50%;

            font-size: 14px;

            font-weight: 700;
        }


        .province-popup .badge-success {
            background: var(--map-success);
            color: #fff;
        }


        .province-popup .badge-danger {
            background: var(--map-danger);
            color: #fff;
        }


        /* =========================================================
        POPUP FOOTER
        ========================================================= */

        .popup-footer {
            display: flex;

            justify-content: space-between;

            padding: 15px 18px;

            border-top: 1px solid var(--map-popup-border);

            background: var(--map-popup-footer-bg);
        }


        .footer-item {
            text-align: center;

            flex: 1;
        }


        .footer-item small {
            display: block;

            color: var(--map-text-secondary);
        }


        .footer-item strong {
            font-size: 20px;

            color: var(--map-text);
        }


        /* =========================================================
        LEAFLET CONTROLS
        Supaya tombol zoom juga mengikuti theme
        ========================================================= */

        .leaflet-control-zoom a {
            background: var(--map-card-bg);
            color: var(--map-text);
            border-color: var(--map-card-border);
        }


        .leaflet-control-zoom a:hover {
            background: var(--map-card-inner-border);
            color: var(--map-text);
        }


        /* =========================================================
        LEAFLET ATTRIBUTION
        ========================================================= */

        .leaflet-control-attribution {
            background: var(--map-card-bg) !important;
            color: var(--map-text-secondary) !important;
        }


        .leaflet-control-attribution a {
            color: var(--map-primary);
        }


        /* =========================================================
        LIGHT MODE - LEAFLET POPUP SHADOW
        ========================================================= */

        [data-bs-theme="light"] .leaflet-popup-content-wrapper {
            box-shadow: 0 10px 30px rgba(15, 23, 42, .15);
        }


        /* =========================================================
        DARK MODE - LEAFLET POPUP SHADOW
        ========================================================= */

        [data-bs-theme="dark"] .leaflet-popup-content-wrapper {
            box-shadow:
                0 10px 30px rgba(0, 0, 0, .45),
                0 0 20px rgba(0, 0, 0, .15);
        }
    </style>
@endsection

@section('breadcrumb')
<!--begin::Title-->
<h1
    class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
    Beranda</h1>
<!--end::Title-->
<!--begin::Breadcrumb-->
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1 mb-3">
    <!--begin::Item-->
    <li class="breadcrumb-item text-muted">
        <a href="javascript:;" class="text-muted text-hover-primary">Beranda</a>
    </li>
    <!--end::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-500 w-5px h-2px"></span>
    </li>
    <!--end::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item text-muted">Beranda</li>
    <!--end::Item-->
</ul>
<!--end::Breadcrumb-->
@endsection

@section('content')
    <div class="row g-3 mb-4">

        <!-- Satpam Aktif -->
        <div class="col-6 col-md-4">
            <div class="dashboard-card success">
                <div class="card-icon">
                    <i class="fas fa-user-shield"></i>
                </div>

                @php
                    $securityActive = \App\Models\Security::whereHas('user_security.user', function($q){
                        $q->where('status', 'active');
                    })->count();
                @endphp

                <div class="card-content">
                    <span>Satpam Aktif</span>
                    <h3>{{ $securityActive }}</h3>
                    <small>Pengguna aktif</small>
                </div>
            </div>
        </div>

        <!-- Satpam Tidak Aktif -->
        {{-- <div class="col-6 col-md-4">
            <div class="dashboard-card danger">
                <div class="card-icon">
                    <i class="fas fa-user-slash"></i>
                </div>

                @php
                    $securityNonActive = \App\Models\Security::whereHas('user_security.user', function($q){
                        $q->where('status', 'non-acitve');
                    })->count();
                @endphp

                <div class="card-content">
                    <span>Satpam Tidak Aktif</span>
                    <h3>{{ $securityNonActive }}</h3>
                    <small>Pengguna nonaktif</small>
                </div>
            </div>
        </div> --}}

        <!-- Perusahaan Aktif -->
        <div class="col-6 col-md-4">
            <div class="dashboard-card primary">
                <div class="card-icon">
                    <i class="fas fa-building"></i>
                </div>

                @php
                    $companyActive = \App\Models\Company::where('is_active', 1)->count();
                @endphp

                <div class="card-content">
                    <span>Perusahaan Aktif</span>
                    <h3>{{ $companyActive }}</h3>
                    <small>Perusahaan Klien</small>
                </div>
            </div>
        </div>

        <!-- Perusahaan Tidak Aktif -->
        {{-- <div class="col-6 col-md-4">
            <div class="dashboard-card warning">
                <div class="card-icon">
                    <i class="fas fa-building-circle-xmark"></i>
                </div>

                @php
                    $companyNonActive = \App\Models\Company::where('is_active', 0)->count();
                @endphp

                <div class="card-content">
                    <span>Perusahaan Tidak Aktif</span>
                    <h3>{{ $companyNonActive }}</h3>
                    <small>Perusahaan Klien</small>
                </div>
            </div>
        </div> --}}

        <!-- BUJP Aktif -->
        <div class="col-6 col-md-4">
            <div class="dashboard-card info">
                <div class="card-icon">
                    <i class="fas fa-shield-halved"></i>
                </div>

                @php
                    $bujpActive = \App\Models\BUJP::where('is_active', 1)->count();
                @endphp

                <div class="card-content">
                    <span>BUJP Aktif</span>
                    <h3>{{ $bujpActive }}</h3>
                    <small>Badan Usaha</small>
                </div>
            </div>
        </div>

        <!-- BUJP Tidak Aktif -->
        {{-- <div class="col-6 col-md-4">
            <div class="dashboard-card secondary">
                <div class="card-icon">
                    <i class="fas fa-ban"></i>
                </div>

                @php
                    $bujpNonActive = \App\Models\BUJP::where('is_active', 0)->count();
                @endphp

                <div class="card-content">
                    <span>BUJP Tidak Aktif</span>
                    <h3>{{ $bujpNonActive }}</h3>
                    <small>Badan Usaha</small>
                </div>
            </div>
        </div> --}}

    </div>

    <div class="card map-card mt-3">

        <div class="card-header border-0 px-5 py-5">
            <div class="">

                <div class="d-flex align-items-center">

                    <div class="map-icon me-3">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>

                    <div>
                        <h5 class="mb-1 fw-bold text-white">
                            Peta Persebaran Pengguna
                        </h5>

                        <small class="text-muted">
                            Monitoring jumlah <strong>Satpam</strong>,
                            <strong>BUJP</strong>, dan
                            <strong>Pemerintah</strong> di seluruh provinsi Indonesia.
                        </small>
                    </div>
                    

                </div>

            </div>
        </div>


        <div class="card-body p-0">

            <div id="indonesia-map"></div>

        </div>

    </div>
@endsection

@section('js')
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    $(document).ready(function () {

        let map = L.map('indonesia-map')
            .setView(
                [-2.5, 118],
                5
            );


        /*
        |--------------------------------------------------------------------------
        | OpenStreetMap
        |--------------------------------------------------------------------------
        | Tidak membutuhkan API key
        |--------------------------------------------------------------------------
        */

        L.tileLayer(
            'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }
        ).addTo(map);


        /*
        |--------------------------------------------------------------------------
        | Data Laravel
        |--------------------------------------------------------------------------
        */

        let provinces = @json($provinces);

        console.log(provinces);


        /*
        |--------------------------------------------------------------------------
        | Custom Marker
        |--------------------------------------------------------------------------
        */

        let markerIcon = L.divIcon({

            className: 'custom-marker',

            html: `
                <div class="marker-dot"></div>
            `,

            iconSize: [
                16,
                16
            ],

            iconAnchor: [
                8,
                8
            ]

        });


        /*
        |--------------------------------------------------------------------------
        | Province Marker
        |--------------------------------------------------------------------------
        */

        $.each(provinces, function (index, province) {

            const popup = `

                <div class="province-popup">

                    <div class="popup-header">

                        <h5>${province.name}</h5>

                        <small>
                            Ringkasan Pengguna
                        </small>

                    </div>


                    <div class="popup-body">

                        <div class="popup-row popup-head">

                            <div>User</div>

                            <div class="text-success">
                                Aktif
                            </div>

                        </div>


                        <div class="popup-row">

                            <div class="user-name">

                                <i class="fas fa-user-shield text-primary"></i>

                                Satpam

                            </div>

                            <div>

                                <span class="badge badge-success">
                                    4
                                </span>

                            </div>

                        </div>


                        <div class="popup-row">

                            <div class="user-name">

                                <i class="fas fa-building text-warning"></i>

                                Perusahaan

                            </div>

                            <div>

                                <span class="badge badge-success">
                                    3
                                </span>

                            </div>

                        </div>


                        <div class="popup-row">

                            <div class="user-name">

                                <i class="fas fa-shield-halved text-info"></i>

                                BUJP

                            </div>

                            <div>

                                <span class="badge badge-success">
                                    2
                                </span>

                            </div>

                        </div>

                    </div>


                    <div class="popup-footer">

                        <div class="footer-item">

                            <small>
                                Total Aktif
                            </small>

                            <strong class="text-success">
                                9
                            </strong>

                        </div>

                    </div>

                </div>

            `;


            L.marker(
                [
                    province.lat,
                    province.lng
                ],
                {
                    icon: markerIcon
                }
            )

            .addTo(map)

            .bindPopup(
                popup,
                {
                    minWidth: 320,
                    maxWidth: 320
                }
            );

        });


        /*
        |--------------------------------------------------------------------------
        | Fix ukuran map
        |--------------------------------------------------------------------------
        */

        setTimeout(function () {

            map.invalidateSize();

        }, 500);

    });
</script>

@endsection