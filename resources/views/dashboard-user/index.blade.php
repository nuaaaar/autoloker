@extends('layouts.dashboard-user')

@section('title', 'Beranda')

@section('css')
    <style>
        /* ===========================
            COMPANY DASHBOARD
        =========================== */

        .company-dashboard-card{

            background:#11192d;

            border:1px solid rgba(255,255,255,.07);

            border-radius:18px;

            overflow:hidden;

        }

        .company-dashboard-header{

            padding:18px 22px;

            background:linear-gradient(90deg,#2b241d,#11192d);

            border:1px solid rgba(247,176,3,.28);

        }

        .company-dashboard-subtitle{

            font-size:11px;

            color:#f7b003;

            font-weight:700;

            letter-spacing:2px;

            text-transform:uppercase;

        }

        .company-dashboard-title{

            color:#fff;

            font-size:26px;

            font-weight:700;

            margin-top:6px;

        }

        .company-dashboard-company{

            font-size:13px;

            color:#91a0bc;

        }

        .btn-company-primary{

            background:#f7b003;

            color:#111;

            border:none;

            padding:10px 22px;

            border-radius:14px;

            font-size:13px;

            font-weight:700;

        }

        .btn-company-primary:hover{

            background:#ffc928;

        }

        .stat-card{

            background:#11192d;

            border:1px solid rgba(255,255,255,.06);

            border-radius:18px;

            padding:18px;

            transition:.25s;

        }

        .stat-card:hover{

            border-color:#f7b00355;

            transform:translateY(-2px);

        }

        .stat-title{

            color:#8796b5;

            font-size:13px;

            font-weight:600;

        }

        .stat-value{

            color:#f7b003;

            font-size:34px;

            font-weight:700;

            margin-top:10px;

        }

        .stat-small{

            color:#91a0bc;

            font-size:12px;

        }

        .stat-icon{

            width:38px;

            height:38px;

            border-radius:12px;

            display:flex;

            align-items:center;

            justify-content:center;

            background:#1b2442;

        }

        .activity-card{

            background:#11192d;

            border-radius:18px;

            border:1px solid rgba(255,255,255,.06);

        }

        .activity-header{

            padding:16px 22px;

            border-bottom:1px solid rgba(255,255,255,.05);

        }

        .activity-title{

            color:#fff;

            font-size:14px;

            font-weight:700;

        }

        .activity-item{

            display:flex;

            align-items:center;

            gap:14px;

            padding:16px 22px;

            border-bottom:1px solid rgba(255,255,255,.05);

        }

        .activity-item:last-child{

            border-bottom:none;

        }

        .activity-icon{

            width:42px;

            height:42px;

            border-radius:50%;

            background:#1d2746;

            display:flex;

            justify-content:center;

            align-items:center;

        }

        .activity-name{

            font-size:13px;

            color:#fff;

            font-weight:600;

        }

        .activity-time{

            font-size:11px;

            color:#91a0bc;

        }

        .quick-card{

            background:#11192d;

            border-radius:18px;

            border:1px solid rgba(255,255,255,.06);

        }

        .quick-item{

            display:flex;

            justify-content:space-between;

            align-items:center;

            padding:14px 16px;

            margin:12px;

            border-radius:14px;

            background:#1c2747;

            transition:.2s;

            color:#fff;

            text-decoration:none;

            font-size:13px;

            font-weight:600;

        }

        .quick-item:hover{

            background:#24345f;

            color:#f7b003;

        }
    </style>
@endsection

@section('content')
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
    </ul>
    <!--end::Breadcrumb-->

    <div class="row">

        <div class="col-xl-9">

            @if($profile_progress['progress'] < 100)
                @include('dashboard-user.partials.alert-complete-data')
            @endif

            <!-- Header -->
            @include('dashboard-user.partials.header')

            <!-- Statistic -->
            @include('dashboard-user.partials.statistic')

            <!-- Activity -->
            @include('dashboard-user.partials.activity')

        </div>

        <div class="col-xl-3">

            <!-- Quick Action -->
            @include('dashboard-user.partials.quick-action')

        </div>

    </div>
@endsection

@section('js')
    {{-- ALERT COMPLETE DATA--}}
    <script>
        $(document).on('click', '.profile-alert-detail', function (e) {
            e.preventDefault();

            let $this = $(this);
            let $list = $this.next('.profile-alert-list');
            let $icon = $this.find('.toggle-icon');

            $list.stop(true, true).slideToggle(250);

            if ($list.is(':visible')) {
                $icon.removeClass('ki-down').addClass('ki-up');
            } else {
                $icon.removeClass('ki-up').addClass('ki-down');
            }
        });

        $(document).on('click', '.profile-alert-close', function () {
            $(this).closest('.profile-alert-card').fadeOut(300);
        });
    </script>
@endsection