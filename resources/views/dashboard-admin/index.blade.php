@extends('layouts.dashboard-admin')

@section('title', 'Beranda')

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
    <style>
        .map-card{

            background:#111827;
            color:white;
            border:1px solid #374151;

        }


        #indonesia-map{

            width:100%;
            height:450px;

        }


        .leaflet-container{

            background:#020617;

        }



        .marker-dot{


            width:16px;
            height:16px;


            background:#f59e0b;


            border-radius:50%;


            border:3px solid white;


            box-shadow:
            0 0 10px #f59e0b,
            0 0 20px #f59e0b;


        }
        
        .card-header{
            background:#111827;
            border-bottom:1px solid #293548;
        }

        .map-icon{

            width:52px;
            height:52px;

            border-radius:14px;

            background:linear-gradient(135deg,#2563eb,#3b82f6);

            display:flex;
            align-items:center;
            justify-content:center;

            color:#fff;
            font-size:22px;

            box-shadow:0 0 15px rgba(59,130,246,.35);

        }

        .card-header h5{
            color:#fff;
        }

        .card-header small{
            color:#9CA3AF !important;
        }

        .dashboard-card{

            position:relative;

            display:flex;
            align-items:center;

            padding:18px;

            border-radius:16px;

            background:#111827;

            border:1px solid #273244;

            overflow:hidden;

            transition:.3s;

            min-height:110px;

        }

        .dashboard-card:hover{

            transform:translateY(-5px);

            border-color:#3b82f6;

            box-shadow:0 15px 30px rgba(0,0,0,.35);

        }

        .dashboard-card::after{

            content:"";

            position:absolute;

            right:-35px;
            top:-35px;

            width:90px;
            height:90px;

            border-radius:50%;

            opacity:.08;

            background:white;

        }

        .card-icon{

            width:56px;
            height:56px;

            border-radius:14px;

            display:flex;
            align-items:center;
            justify-content:center;

            font-size:22px;

            color:#fff;

            margin-right:16px;

            flex-shrink:0;

        }

        .card-content span{

            color:#9CA3AF;

            font-size:13px;

            display:block;

        }

        .card-content h3{

            color:#fff;

            margin:4px 0;

            font-size:28px;

            font-weight:700;

        }

        .card-content small{

            color:#6B7280;

        }

        /* Warna */

        .success .card-icon{
            background:#16a34a;
        }

        .danger .card-icon{
            background:#dc2626;
        }

        .primary .card-icon{
            background:#2563eb;
        }

        .warning .card-icon{
            background:#d97706;
        }

        .info .card-icon{
            background:#0891b2;
        }

        .secondary .card-icon{
            background:#6b7280;
        }

        .province-popup{
            width:280px;
        }

        .popup-title{
            color:#f59e0b;
            font-weight:700;
            margin-bottom:2px;
        }

        .popup-subtitle{
            color:#9CA3AF;
            font-size:12px;
            margin-bottom:10px;
        }

        /* ===========================
        LEAFLET POPUP
        =========================== */

        .leaflet-popup-content-wrapper{

            padding:0;

            border-radius:14px;

            overflow:hidden;

            background:#111827;

        }

        .leaflet-popup-tip{

            background:#111827;

        }

        .leaflet-popup-content{

            margin:0 !important;

        }



        /* ===========================
        POPUP
        =========================== */

        .province-popup{

            width:320px;

            background:#111827;

            color:#fff;

        }



        /* HEADER */

        .popup-header{

            padding:18px;

            text-align:center;

            border-bottom:1px solid #293548;

        }

        .popup-header h5{

            margin:0;

            color:#f59e0b;

            font-weight:700;

            font-size:18px;

        }

        .popup-header small{

            color:#9CA3AF;

        }



        /* BODY */

        .popup-body{

            padding:15px;

        }



        /* GRID */

        .popup-row{

            display:grid;

            grid-template-columns:2fr 1fr 1fr;

            align-items:center;

            padding:10px 0;

            border-bottom:1px solid rgba(255,255,255,.08);

        }

        .popup-row:last-child{

            border-bottom:none;

        }



        .popup-head{

            color:#9CA3AF;

            font-size:12px;

            font-weight:600;

            text-transform:uppercase;

            padding-bottom:12px;

        }



        .user-name{

            display:flex;

            align-items:center;

            gap:10px;

            font-weight:500;

        }



        /* BADGE */

        .badge{

            width:34px;

            height:34px;

            display:flex;

            justify-content:center;

            align-items:center;

            margin:auto;

            border-radius:50%;

            font-size:14px;

            font-weight:700;

        }



        .badge-success{

            background:#16a34a;

            color:#fff;

        }



        .badge-danger{

            background:#dc2626;

            color:#fff;

        }



        /* FOOTER */

        .popup-footer{

            display:flex;

            justify-content:space-between;

            padding:15px 18px;

            border-top:1px solid #293548;

            background:#0f172a;

        }



        .footer-item{

            text-align:center;

            flex:1;

        }



        .footer-item small{

            display:block;

            color:#9CA3AF;

        }



        .footer-item strong{

            font-size:20px;

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
        $(document).ready(function(){


            let map = L.map('indonesia-map')
                .setView(
                    [-2.5,118],
                    5
                );



            /*
            Dark Map
            */

            L.tileLayer(
                'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png',
                {

                    maxZoom:19

                }

            ).addTo(map);




            /*
            Data Laravel
            */

            let provinces = @json($provinces);



            console.log(provinces);



            /*
            Custom Marker
            */


            let markerIcon = L.divIcon({

                className:'custom-marker',

                html:`

                    <div class="marker-dot"></div>

                `,

                iconSize:[
                    16,
                    16
                ],

                iconAnchor:[
                    8,
                    8
                ]

            });

            $.each(provinces, function(index, province){

                const popup = `
                    <div class="province-popup">

                        <div class="popup-header">
                            <h5>${province.name}</h5>
                            <small>Ringkasan Pengguna</small>
                        </div>

                        <div class="popup-body">

                            <div class="popup-row popup-head">
                                <div>User</div>
                                <div class="text-success">Aktif</div>
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

                                <small>Total Aktif</small>

                                <strong class="text-success">
                                    9
                                </strong>

                            </div>

                        </div>

                    </div>
                `;


                L.marker(
                    [province.lat, province.lng],
                    {
                        icon: markerIcon
                    }
                )
                .addTo(map)
                .bindPopup(popup,{
                    minWidth:320,
                    maxWidth:320
                });

            });
        
            /*
            fix ukuran map
            */

            setTimeout(function(){

                map.invalidateSize();

            },500);



        });



        </script>

@endsection