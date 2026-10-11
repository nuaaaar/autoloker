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

        min-height:44px;

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

    .notification-filter-input:focus-visible,
    .notification-filter-select:focus-visible,
    .btn-notification-filter:focus-visible,
    .btn-notification-reset:focus-visible,
    .notification-mark-all:focus-visible{
        outline:2px solid #f7b003;
        outline-offset:2px;
    }


    .notification-filter-input::placeholder{

        color:#64748b;

    }


    .notification-filter-select{

        min-height:44px;

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

        min-height:44px;

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

        min-height:44px;

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

        min-height:44px;

        padding:0 10px;

        display:inline-flex;

        align-items:center;

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
            <div class="notification-page-card">
                <header class="notification-page-header">
                    <div class="d-flex align-items-center justify-content-between gap-3">
                        <div>
                            <h2 class="notification-page-title">Semua Notifikasi</h2>
                            <div class="notification-page-subtitle">Riwayat pemberitahuan dan aktivitas akun Anda</div>
                        </div>
                        <div class="notification-unread-info" aria-live="polite">
                            @if ($unreadCount > 0)
                                <span class="dot" aria-hidden="true"></span>
                            @endif
                            <span>{{ $unreadCount }} belum dibaca</span>
                        </div>
                    </div>
                </header>

                <form class="notification-filter" method="GET" action="{{ route('dashboard-user.notification.index') }}">
                    <div class="row notification-filter-row align-items-end g-2">
                        <div class="col-12 col-md-4">
                            <label class="notification-filter-label" for="date-from">Tanggal Mulai</label>
                            <input id="date-from" type="date" name="date_from" class="form-control notification-filter-input" value="{{ request('date_from') }}">
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="notification-filter-label" for="date-to">Tanggal Selesai</label>
                            <input id="date-to" type="date" name="date_to" class="form-control notification-filter-input" value="{{ request('date_to') }}">
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="notification-filter-label" for="notification-type">Jenis Notifikasi</label>
                            <select id="notification-type" name="type" class="form-select notification-filter-select">
                                <option value="">Semua Notifikasi</option>
                                @foreach (['lowongan' => 'Lowongan', 'pelatihan' => 'Pelatihan', 'langganan' => 'Langganan', 'akun' => 'Akun'] as $value => $label)
                                    <option value="{{ $value }}" @selected(request('type') === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="notification-filter-label" for="notification-read-state">Status</label>
                            <select id="notification-read-state" name="is_read" class="form-select notification-filter-select">
                                <option value="">Semua Status</option>
                                <option value="0" @selected(request('is_read') === '0')>Belum dibaca</option>
                                <option value="1" @selected(request('is_read') === '1')>Sudah dibaca</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap align-items-center gap-2 mt-3">
                        <button type="submit" class="btn-notification-filter">Terapkan Filter</button>
                        <a href="{{ route('dashboard-user.notification.index') }}" class="btn-notification-reset d-inline-flex align-items-center">Reset</a>
                    </div>
                </form>

                <div class="notification-list-header">
                    <div class="notification-list-title">Notifikasi</div>
                    @if ($unreadCount > 0)
                        <form method="POST" action="{{ route('dashboard-user.notification.mark-all') }}">
                            @csrf
                            <button type="submit" class="notification-mark-all border-0 bg-transparent">Tandai semua dibaca</button>
                        </form>
                    @endif
                </div>

                <div>
                    @forelse ($notifications as $notification)
                        <article class="notification-item {{ $notification->is_read ? '' : 'unread' }}">
                            <div class="notification-item-content">
                                <div class="notification-item-top">
                                    <h3 class="notification-item-title">{{ $notification->title }}</h3>
                                    <time class="notification-item-date" datetime="{{ $notification->created_at->toIso8601String() }}">
                                        {{ $notification->created_at->format('d M Y H:i') }}
                                    </time>
                                </div>
                                @if ($notification->description)
                                    <p class="notification-item-description">{{ $notification->description }}</p>
                                @endif
                                <div class="notification-item-footer">
                                    <span class="notification-category">{{ $notification->type ? ucfirst($notification->type) : 'Notifikasi' }}</span>
                                    @if (! $notification->is_read)
                                        <form method="POST" action="{{ route('dashboard-user.notification.mark-read', $notification->uuid) }}">
                                            @csrf
                                            <button type="submit" class="notification-mark-all border-0 bg-transparent">Tandai dibaca</button>
                                        </form>
                                    @else
                                        <span class="notification-item-time">Dibaca</span>
                                    @endif
                                </div>
                            </div>
                            @if (! $notification->is_read)
                                <span class="notification-unread-dot" aria-label="Belum dibaca"></span>
                            @endif
                        </article>
                    @empty
                        <p class="notification-empty p-4 mb-0" role="status">Belum ada notifikasi.</p>
                    @endforelse
                </div>

                @if ($notifications->hasPages())
                    <div class="notification-pagination">
                        {{ $notifications->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

