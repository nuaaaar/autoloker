
@extends('layouts.dashboard-user')

@section('title', 'Paket Berlangganan')

@section('css')
<style>
    .subscription-page {
        --sub-primary: #1264d8;
        --sub-primary-soft: #edf5ff;
        --sub-success: #0c9f76;
        --sub-warning: #d99100;
        --sub-danger: #dc3545;
        --sub-border: #dee5ee;
        --sub-muted: #64748b;
        --sub-text: #1e293b;
        --sub-bg: #f6f8fc;
        --sub-surface: #ffffff;
        --sub-surface-soft: #f8fafc;
        --sub-table-head: #f1f5f9;
        --sub-shadow: 0 5px 22px rgba(15, 23, 42, .045);

        color: var(--sub-text);
        min-width: 0;
    }

    [data-bs-theme="dark"] .subscription-page,
    .dark-layout .subscription-page,
    .dark-mode .subscription-page,
    [data-theme="dark"] .subscription-page {
        --sub-primary: #2684ff;
        --sub-primary-soft: rgba(38, 132, 255, .13);
        --sub-success: #20c997;
        --sub-warning: #ffc107;
        --sub-danger: #ff6b81;
        --sub-border: #374151;
        --sub-muted: #a5b4c7;
        --sub-text: #e5e7eb;
        --sub-bg: #111827;
        --sub-surface: #1f2937;
        --sub-surface-soft: #182230;
        --sub-table-head: #263244;
        --sub-shadow: 0 5px 22px rgba(0, 0, 0, .12);
    }

    .subscription-page .sub-heading {
        color: var(--sub-text);
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .subscription-page .sub-muted {
        color: var(--sub-muted);
    }

    .subscription-page .sub-panel {
        background: var(--sub-surface);
        border: 1px solid var(--sub-border);
        border-radius: 14px;
        box-shadow: var(--sub-shadow);
        margin-bottom: 22px;
        min-width: 0;
        overflow: hidden;
    }

    .subscription-page .sub-panel-header {
        align-items: center;
        border-bottom: 1px solid var(--sub-border);
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        justify-content: space-between;
        padding: 20px 22px;
    }

    .subscription-page .sub-panel-body {
        padding: 22px;
    }

    .subscription-page .sub-stat-card {
        background: var(--sub-surface);
        border: 1px solid var(--sub-border);
        border-radius: 14px;
        box-shadow: var(--sub-shadow);
        height: 100%;
        padding: 20px;
    }

    .subscription-page .sub-stat-top {
        align-items: center;
        display: flex;
        gap: 14px;
        justify-content: space-between;
    }

    .subscription-page .sub-stat-label {
        color: var(--sub-muted);
        font-size: .82rem;
        margin-bottom: 8px;
    }

    .subscription-page .sub-stat-value {
        color: var(--sub-text);
        font-size: 1.6rem;
        font-weight: 750;
        line-height: 1.2;
        overflow-wrap: anywhere;
    }

    .subscription-page .sub-stat-icon {
        align-items: center;
        background: var(--sub-primary-soft);
        border-radius: 12px;
        color: var(--sub-primary);
        display: inline-flex;
        flex-shrink: 0;
        font-size: 1.5rem;
        height: 48px;
        justify-content: center;
        width: 48px;
    }

    .subscription-page .sub-current-card {
        background: linear-gradient(125deg, #1264d8, #3988ee);
        border: 0;
        border-radius: 14px;
        box-shadow: var(--sub-shadow);
        color: #fff;
        overflow: hidden;
        padding: 25px;
        position: relative;
    }

    .subscription-page .sub-current-card::after {
        background: rgba(255,255,255,.08);
        border-radius: 50%;
        content: "";
        height: 220px;
        position: absolute;
        right: -65px;
        top: -105px;
        width: 220px;
    }

    .subscription-page .sub-current-card > * {
        position: relative;
        z-index: 1;
    }

    .subscription-page .sub-current-card .sub-muted {
        color: rgba(255,255,255,.78);
    }

    .subscription-page .sub-current-card .sub-current-title {
        font-size: 1.4rem;
        font-weight: 750;
        margin: 8px 0;
        overflow-wrap: anywhere;
    }

    .subscription-page .sub-current-card .sub-current-price {
        font-size: 1.7rem;
        font-weight: 750;
    }

    .subscription-page .sub-current-card .sub-current-divider {
        border-color: rgba(255,255,255,.22);
        margin: 20px 0;
        opacity: 1;
    }

    .subscription-page .sub-info-label {
        color: var(--sub-muted);
        font-size: .78rem;
        margin-bottom: 5px;
    }

    .subscription-page .sub-info-value {
        color: var(--sub-text);
        font-size: .91rem;
        font-weight: 600;
        overflow-wrap: anywhere;
    }

    .subscription-page .sub-current-card .sub-info-label,
    .subscription-page .sub-current-card .sub-info-value {
        color: #fff;
    }

    .subscription-page .sub-status {
        border-radius: 6px;
        display: inline-flex;
        font-size: .75rem;
        font-weight: 650;
        justify-content: center;
        padding: 6px 10px;
        white-space: nowrap;
    }

    .subscription-page .sub-status-paid {
        background: rgba(12,159,118,.13);
        color: var(--sub-success);
    }

    .subscription-page .sub-status-pending {
        background: rgba(217,145,0,.14);
        color: var(--sub-warning);
    }

    .subscription-page .sub-status-rejected {
        background: rgba(220,53,69,.12);
        color: var(--sub-danger);
    }

    .subscription-page .sub-status-neutral {
        background: var(--sub-primary-soft);
        color: var(--sub-primary);
    }

    .subscription-page .sub-table-wrap {
        padding: 18px 22px 22px;
        min-width: 0;
    }

    .subscription-page .sub-table-scroll {
        max-width: 100%;
        width: 100%;
    }

    .subscription-page #subscription-orders-datatable {
        border-collapse: collapse !important;
        color: var(--sub-text);
        margin-bottom: 0 !important;
        width: 100% !important;
    }

    .subscription-page #subscription-orders-datatable > thead > tr > th {
        background: var(--sub-table-head) !important;
        border: 1px solid var(--sub-border) !important;
        color: var(--sub-text) !important;
        font-size: .78rem;
        font-weight: 700;
        padding: 13px 12px !important;
        vertical-align: middle;
        white-space: nowrap;
    }

    .subscription-page #subscription-orders-datatable > tbody > tr > td {
        background: var(--sub-surface) !important;
        border: 1px solid var(--sub-border) !important;
        color: var(--sub-text) !important;
        font-size: .84rem;
        padding: 12px !important;
        vertical-align: middle;
    }

    .subscription-page #subscription-orders-datatable tbody tr:hover td {
        background: var(--sub-surface-soft) !important;
    }

    .subscription-page #subscription-orders-datatable .sub-order-number {
        color: var(--sub-primary);
        font-weight: 700;
        white-space: nowrap;
    }

    .subscription-page #subscription-orders-datatable .sub-order-name {
        font-weight: 600;
    }

    .subscription-page .dataTables_wrapper {
        color: var(--sub-text);
        font-size: .84rem;
    }

    .subscription-page .dataTables_wrapper .dataTables_length,
    .subscription-page .dataTables_wrapper .dataTables_filter,
    .subscription-page .dataTables_wrapper .dataTables_info {
        color: var(--sub-muted) !important;
        padding-bottom: 12px;
        padding-top: 4px;
    }

    .subscription-page .dataTables_wrapper .dataTables_length label,
    .subscription-page .dataTables_wrapper .dataTables_filter label {
        align-items: center;
        display: inline-flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .subscription-page .dataTables_wrapper .dataTables_filter input,
    .subscription-page .dataTables_wrapper .dataTables_length select {
        background-color: var(--sub-surface) !important;
        border: 1px solid var(--sub-border) !important;
        border-radius: 6px;
        color: var(--sub-text) !important;
        min-height: 36px;
        outline: none;
        padding: 6px 10px;
    }

    .subscription-page .dataTables_wrapper .dataTables_filter input {
        margin-left: 0;
        width: min(240px, 60vw);
    }

    .subscription-page .dataTables_wrapper .dataTables_filter input:focus,
    .subscription-page .dataTables_wrapper .dataTables_length select:focus {
        border-color: var(--sub-primary) !important;
        box-shadow: 0 0 0 .15rem rgba(18,100,216,.12);
    }

    .subscription-page .dataTables_wrapper .dataTables_paginate {
        padding-top: 4px;
    }

    .subscription-page .dataTables_wrapper .dataTables_paginate .paginate_button {
        background: var(--sub-surface) !important;
        border: 1px solid var(--sub-border) !important;
        border-radius: 6px !important;
        color: var(--sub-text) !important;
        margin: 0 2px;
        padding: 6px 11px !important;
    }

    .subscription-page .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: var(--sub-primary-soft) !important;
        border-color: var(--sub-primary) !important;
        color: var(--sub-primary) !important;
    }

    .subscription-page .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .subscription-page .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background: var(--sub-primary) !important;
        border-color: var(--sub-primary) !important;
        color: #fff !important;
    }

    .subscription-page .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
        opacity: .45;
    }

    .subscription-page .dataTables_wrapper .dataTables_processing {
        background: var(--sub-surface);
        border: 1px solid var(--sub-border);
        color: var(--sub-text);
    }

    .subscription-page .dataTables_wrapper .dataTables_empty {
        padding: 28px 12px !important;
        text-align: center;
    }

    [data-bs-theme="dark"] .subscription-page .dataTables_wrapper,
    .dark-layout .subscription-page .dataTables_wrapper,
    .dark-mode .subscription-page .dataTables_wrapper,
    [data-theme="dark"] .subscription-page .dataTables_wrapper {
        color: var(--sub-text);
    }

    .subscription-page .sub-empty {
        color: var(--sub-muted);
        padding: 35px 15px;
        text-align: center;
    }

    .subscription-page .sub-empty i {
        display: block;
        font-size: 2.3rem;
        margin-bottom: 10px;
    }

    .subscription-page .btn-sub-primary {
        background: var(--sub-primary);
        border: 1px solid var(--sub-primary);
        border-radius: 7px;
        color: #fff;
        font-weight: 600;
    }

    .subscription-page .btn-sub-primary:hover {
        filter: brightness(.94);
        color: #fff;
    }

    .subscription-page .btn-sub-outline {
        background: transparent;
        border: 1px solid var(--sub-border);
        border-radius: 7px;
        color: var(--sub-text);
        font-weight: 600;
    }

    .subscription-page .btn-sub-outline:hover {
        background: var(--sub-surface-soft);
        color: var(--sub-primary);
    }

    .subscription-page .sub-action-buttons {
        align-items: center;
        display: flex;
        gap: 6px;
        justify-content: center;
        white-space: nowrap;
    }

    /* Modal: variables mandiri karena modal berada di luar .subscription-page */
    .sub-modal {
        --modal-bg: #fff;
        --modal-text: #1e293b;
        --modal-muted: #64748b;
        --modal-border: #dee5ee;
        --modal-input-bg: #fff;
        --modal-input-text: #1e293b;
    }

    [data-bs-theme="dark"] .sub-modal,
    .dark-layout .sub-modal,
    .dark-mode .sub-modal,
    [data-theme="dark"] .sub-modal {
        --modal-bg: #1f2937;
        --modal-text: #e5e7eb;
        --modal-muted: #a5b4c7;
        --modal-border: #374151;
        --modal-input-bg: #182230;
        --modal-input-text: #e5e7eb;
    }

    .sub-modal .modal-content {
        background: var(--modal-bg);
        border: 1px solid var(--modal-border);
        border-radius: 14px;
        color: var(--modal-text);
    }

    .sub-modal .modal-header,
    .sub-modal .modal-footer {
        border-color: var(--modal-border);
    }

    .sub-modal .modal-title,
    .sub-modal .form-label {
        color: var(--modal-text);
        font-weight: 600;
    }

    .sub-modal .sub-modal-description {
        color: var(--modal-muted);
        font-size: .85rem;
    }

    .sub-modal .form-control,
    .sub-modal .form-select {
        background-color: var(--modal-input-bg);
        border-color: var(--modal-border);
        color: var(--modal-input-text);
    }

    .sub-modal .form-control::placeholder {
        color: var(--modal-muted);
        opacity: .8;
    }

    .sub-modal .form-control:focus,
    .sub-modal .form-select:focus {
        border-color: var(--sub-primary, #1264d8);
        box-shadow: 0 0 0 .15rem rgba(18,100,216,.13);
    }

    .sub-modal .btn-close {
        filter: none;
    }

    [data-bs-theme="dark"] .sub-modal .btn-close,
    .dark-layout .sub-modal .btn-close,
    .dark-mode .sub-modal .btn-close,
    [data-theme="dark"] .sub-modal .btn-close {
        filter: invert(1) grayscale(100%) brightness(200%);
    }

    @media (max-width: 767.98px) {
        .subscription-page .sub-panel-header,
        .subscription-page .sub-panel-body {
            padding: 16px;
        }

        .subscription-page .sub-table-wrap {
            padding: 14px;
        }

        .subscription-page .sub-stat-card {
            padding: 16px;
        }

        .subscription-page .sub-stat-value {
            font-size: 1.35rem;
        }

        .subscription-page .sub-current-card {
            padding: 20px;
        }

        .subscription-page .dataTables_wrapper .dataTables_filter,
        .subscription-page .dataTables_wrapper .dataTables_length {
            float: none !important;
            text-align: left !important;
            width: 100%;
        }

        .subscription-page .dataTables_wrapper .dataTables_filter label {
            align-items: flex-start;
            flex-direction: column;
            width: 100%;
        }

        .subscription-page .dataTables_wrapper .dataTables_filter input {
            margin: 0;
            width: 100%;
        }

        .subscription-page .dataTables_wrapper .dataTables_paginate {
            float: none !important;
            overflow-x: auto;
            text-align: left !important;
            white-space: nowrap;
        }
    }
</style>

<link
    href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
    rel="stylesheet">
@endsection

@section('breadcrumb')

    <h1
        class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">

        Berlangganan

    </h1>

    <!--end::Title-->

    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">

        {{-- BERANDA --}}
        <li class="breadcrumb-item text-muted">

            <a
                href="{{ route('dashboard-user.index') }}"
                class="text-muted text-hover-primary">

                Beranda

            </a>

        </li>


        {{-- SEPARATOR --}}
        <li class="breadcrumb-item">

            <span class="bullet bg-gray-500 w-5px h-2px"></span>

        </li>

        <li class="breadcrumb-item text-muted">

            <a
                href="javascript:;"
                class="text-muted text-hover-primary">

                Berlangganan

            </a>

        </li>

        {{-- SEPARATOR --}}
        <li class="breadcrumb-item">

            <span class="bullet bg-gray-500 w-5px h-2px"></span>

        </li>


        {{-- LOWONGAN --}}
        <li class="breadcrumb-item text-muted">

            <a
                href="{{ route('dashboard-user.job-vacancy.index') }}?status=all"
                class="text-muted text-hover-primary">

                Riwayat Pembayaran

            </a>

        </li>

    </ul>
    <!--end::Breadcrumb-->

@endsection

@section('content')
<div class="subscription-page">
    @php
        $orders = $orders ?? collect();
        $subscriptions = $subscriptions ?? collect();
        $currentSubscription = $currentSubscription ?? $activeSubscription ?? null;
        $bankAccounts = $bankAccounts ?? collect();

        $totalOrders = $orders->count();

        $pendingOrders = $orders->filter(function ($order) {
            return in_array($order->status ?? '', [
                'pending_payment',
                'verification',
            ]);
        })->count();

        $paidOrders = $orders->filter(function ($order) {
            return in_array($order->status ?? '', [
                'paid',
                'verified',
                'success',
                'active',
            ]);
        })->count();
    @endphp

    {{-- Alert --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bx bx-check-circle me-1"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bx bx-error-circle me-1"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Periksa kembali data yang Anda masukkan.</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    {{-- Summary --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="sub-stat-card">
                <div class="sub-stat-top">
                    <div>
                        <div class="sub-stat-label">Paket Aktif</div>
                        <div class="sub-stat-value">
                            {{ $currentSubscription ? '1' : '0' }}
                        </div>
                    </div>
                    <div class="sub-stat-icon">
                        <i class="bx bx-crown"></i>
                    </div>
                </div>
                <div class="sub-muted small mt-3">
                    Status langganan Anda
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="sub-stat-card">
                <div class="sub-stat-top">
                    <div>
                        <div class="sub-stat-label">Perlu Diproses</div>
                        <div class="sub-stat-value">{{ $pendingOrders }}</div>
                    </div>
                    <div class="sub-stat-icon">
                        <i class="bx bx-time-five"></i>
                    </div>
                </div>
                <div class="sub-muted small mt-3">
                    Menunggu pembayaran atau verifikasi
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="sub-stat-card">
                <div class="sub-stat-top">
                    <div>
                        <div class="sub-stat-label">Pembayaran Berhasil</div>
                        <div class="sub-stat-value">{{ $paidOrders }}</div>
                    </div>
                    <div class="sub-stat-icon">
                        <i class="bx bx-check-circle"></i>
                    </div>
                </div>
                <div class="sub-muted small mt-3">
                    Total order yang telah dibayar
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="sub-stat-card">
                <div class="sub-stat-top">
                    <div>
                        <div class="sub-stat-label">Total Riwayat Order</div>
                        <div class="sub-stat-value">{{ $totalOrders }}</div>
                    </div>
                    <div class="sub-stat-icon">
                        <i class="bx bx-receipt"></i>
                    </div>
                </div>
                <div class="sub-muted small mt-3">
                    Seluruh transaksi berlangganan
                </div>
            </div>
        </div>
    </div>

    {{-- Payment History --}}
    <div class="sub-panel">
        <div class="sub-panel-header">
            <div>
                <h5 class="sub-heading mb-1">Riwayat Pembayaran</h5>
                <div class="sub-muted small">
                    Daftar transaksi dan status pembayaran paket Anda.
                </div>
            </div>

            <div class="sub-muted small">
                Total {{ $totalOrders }} transaksi
            </div>
        </div>

        <div class="sub-table-wrap">
            <div class="sub-table-scroll">
                <table id="subscription-orders-datatable"
                       class="table table-bordered dt-responsive nowrap w-100 dataTable no-footer dtr-inline">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 55px;">No.</th>
                            <th>Nomor Order</th>
                            <th>Nama Paket</th>
                            <th class="text-end">Total Pembayaran</th>
                            <th>Tanggal Order</th>
                            <th class="text-center">Status Pembayaran</th>
                            <th class="text-center" style="width: 110px;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($orders as $order)
                            @php
                                $orderStatus = $order->status ?? 'pending_payment';

                                $statusLabels = [
                                    'pending_payment' => 'Menunggu Pembayaran',
                                    'verification' => 'Menunggu Verifikasi',
                                    'paid' => 'Lunas',
                                    'verified' => 'Lunas',
                                    'success' => 'Berhasil',
                                    'active' => 'Aktif',
                                    'rejected' => 'Ditolak',
                                    'cancelled' => 'Dibatalkan',
                                    'expired' => 'Kedaluwarsa',
                                ];

                                $statusClasses = [
                                    'pending_payment' => 'sub-status-pending',
                                    'verification' => 'sub-status-neutral',
                                    'paid' => 'sub-status-paid',
                                    'verified' => 'sub-status-paid',
                                    'success' => 'sub-status-paid',
                                    'active' => 'sub-status-paid',
                                    'rejected' => 'sub-status-rejected',
                                    'cancelled' => 'sub-status-rejected',
                                    'expired' => 'sub-status-rejected',
                                ];

                                $orderNumber =
                                    $order->order_number
                                    ?? $order->invoice_number
                                    ?? $order->uuid
                                    ?? '-';

                                $orderSubscription =
                                    $order->subscription
                                    ?? $order->userSubscription
                                    ?? null;

                                $orderSubscriptionName =
                                    $orderSubscription->name
                                    ?? $orderSubscription->subscription_name
                                    ?? $order->subscription_name
                                    ?? $order->package_name
                                    ?? '-';

                                $orderAmount =
                                    $order->price
                                    ?? $order->total
                                    ?? $order->amount
                                    ?? 0;

                                $orderDate =
                                    $order->created_at
                                    ?? $order->order_date
                                    ?? null;

                                $orderUuid = $order->uuid ?? null;

                                $canUploadProof = in_array($orderStatus, [
                                    'pending_payment',
                                    'rejected',
                                ]);
                            @endphp

                            <tr>
                                <td class="text-center"></td>

                                <td>
                                    <span class="sub-order-number">
                                        {{ $orderNumber }}
                                    </span>
                                </td>

                                <td>
                                    <span class="sub-order-name">
                                        {{ $orderSubscriptionName }}
                                    </span>
                                </td>

                                <td class="text-end text-nowrap">
                                    Rp {{ number_format((float) $orderAmount, 0, ',', '.') }}
                                </td>

                                <td class="text-nowrap">
                                    {{ $orderDate ? \Carbon\Carbon::parse($orderDate)->format('d M Y H:i') : '-' }}
                                </td>

                                <td class="text-center">
                                    <span class="sub-status {{ $statusClasses[$orderStatus] ?? 'sub-status-neutral' }}">
                                        {{ $statusLabels[$orderStatus] ?? ucfirst(str_replace('_', ' ', $orderStatus)) }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    <div class="sub-action-buttons">
                                        @if ($canUploadProof && $orderUuid)
                                            <button type="button"
                                                    class="btn btn-sm btn-sub-primary btn-upload-proof"
                                                    data-uuid="{{ $orderUuid }}"
                                                    data-order-number="{{ $orderNumber }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#uploadProofModal"
                                                    title="Unggah bukti pembayaran">
                                                <i class="bx bx-upload"></i>
                                            </button>
                                        @elseif (in_array($orderStatus, ['verification']))
                                            <span class="sub-muted" title="Menunggu verifikasi">
                                                <i class="bx bx-time-five fs-5"></i>
                                            </span>
                                        @elseif (in_array($orderStatus, ['paid', 'verified', 'success', 'active']))
                                            <span style="color: var(--sub-success);" title="Pembayaran berhasil">
                                                <i class="bx bx-check-circle fs-5"></i>
                                            </span>
                                        @else
                                            <span class="sub-muted">-</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


{{-- Modal Upload Bukti Pembayaran --}}
<div class="modal fade sub-modal"
     id="uploadProofModal"
     tabindex="-1"
     aria-labelledby="uploadProofModalLabel"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form id="uploadProofForm"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="modal-header">
                    <div>
                        <h5 class="modal-title" id="uploadProofModalLabel">
                            Unggah Bukti Pembayaran
                        </h5>

                        <div class="sub-modal-description mt-1">
                            Pastikan data pembayaran dan bukti transfer benar.
                        </div>
                    </div>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Tutup"></button>
                </div>

                <div class="modal-body">

                    <div class="alert alert-info py-2 small">
                        <i class="bx bx-info-circle me-1"></i>
                        Nomor Order:
                        <strong id="uploadProofOrderNumber">-</strong>
                    </div>

                    {{-- Metode Pembayaran --}}
                    <div class="mb-3">
                        <label for="payment_method" class="form-label">
                            Metode Pembayaran
                            <span class="text-danger">*</span>
                        </label>

                        <select name="payment_method"
                                id="payment_method"
                                class="form-select"
                                maxlength="50"
                                required>

                            <option value="">Pilih metode pembayaran</option>

                            @foreach(
                                $bankAccounts
                                as $bank
                            )

                                <option
                                    value="{{ $bank->bank_name }}">

                                    {{ strtoupper(
                                        $bank->bank_name
                                    ) }}

                                </option>

                            @endforeach
                        </select>
                    </div>

                    {{-- Rekening Pengirim --}}
                    <div class="mb-3">
                        <label for="payment_account" class="form-label">
                            Rekening Pengirim / Keterangan
                        </label>

                        <input type="text"
                               name="payment_account"
                               id="payment_account"
                               class="form-control"
                               maxlength="255"
                               placeholder="Nama pemilik rekening atau keterangan">

                        <div class="sub-modal-description mt-1">
                            Opsional. Isi nama pemilik rekening atau informasi pembayaran.
                        </div>
                    </div>

                    {{-- Tanggal Pembayaran --}}
                    <div class="mb-3">
                        <label for="payment_date" class="form-label">
                            Tanggal Pembayaran
                            <span class="text-danger">*</span>
                        </label>

                        <input type="date"
                               name="payment_date"
                               id="payment_date"
                               class="form-control"
                               max="{{ now()->format('Y-m-d') }}"
                               required>
                    </div>

                    {{-- File Bukti Pembayaran --}}
                    <div class="mb-3">
                        <label for="payment_proof" class="form-label">
                            File Bukti Pembayaran
                            <span class="text-danger">*</span>
                        </label>

                        <input type="file"
                               name="payment_proof"
                               id="payment_proof"
                               class="form-control"
                               accept=".jpg,.jpeg,.png,.pdf"
                               required>

                        <div class="sub-modal-description mt-1">
                            Format JPG, JPEG, PNG, atau PDF. Maksimal 5 MB.
                        </div>
                    </div>

                    <div id="proofFileName"
                         class="sub-modal-description"
                         aria-live="polite"></div>

                </div>

                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-sub-outline"
                            data-bs-dismiss="modal">
                        Batal
                    </button>

                    <button type="submit"
                            class="btn btn-sub-primary"
                            id="btnSubmitProof">

                        <i class="bx bx-upload me-1"></i>
                        Kirim Bukti Pembayaran
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection



@section('js')
<script>
document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | DataTables - Riwayat Pembayaran
    |--------------------------------------------------------------------------
    */

    const tableElement = document.getElementById(
        'subscription-orders-datatable'
    );

    if (tableElement && window.jQuery && $.fn.DataTable) {

        if ($.fn.DataTable.isDataTable('#subscription-orders-datatable')) {
            $('#subscription-orders-datatable').DataTable().destroy();
        }

        $('#subscription-orders-datatable').DataTable({
            processing: false,
            serverSide: false,
            scrollX: true,
            responsive: false,
            autoWidth: false,
            pageLength: 10,

            lengthMenu: [
                [10, 25, 50, 75, 999999],
                [10, 25, 50, 75, 'Semua']
            ],

            order: [],

            columnDefs: [
                {
                    targets: [0, 6],
                    orderable: false,
                    searchable: false
                },
                {
                    targets: [0, 5, 6],
                    className: 'text-center'
                },
                {
                    targets: [3],
                    className: 'text-end'
                }
            ],

            language: {
                processing: 'Memproses...',
                search: 'Cari:',
                searchPlaceholder: 'Cari riwayat pembayaran...',
                lengthMenu: 'Tampilkan _MENU_ data',
                info: 'Menampilkan _START_–_END_ dari _TOTAL_ data',
                infoEmpty: 'Menampilkan 0–0 dari 0 data',
                infoFiltered: '(difilter dari _MAX_ total data)',
                zeroRecords: 'Data pembayaran tidak ditemukan',
                emptyTable: 'Belum ada riwayat pembayaran',

                paginate: {
                    first: 'Awal',
                    last: 'Akhir',
                    next: 'Berikutnya',
                    previous: 'Sebelumnya'
                }
            },

            drawCallback: function () {
                const api = this.api();
                const pageInfo = api.page.info();

                api.column(0, { page: 'current' })
                    .nodes()
                    .each(function (cell, index) {
                        cell.textContent = pageInfo.start + index + 1;
                    });
            }
        });
    }


    /*
    |--------------------------------------------------------------------------
    | Elemen Modal Upload
    |--------------------------------------------------------------------------
    */

    const uploadForm = document.getElementById('uploadProofForm');
    const orderNumberLabel = document.getElementById('uploadProofOrderNumber');
    const proofInput = document.getElementById('payment_proof');
    const proofFileName = document.getElementById('proofFileName');
    const submitProofButton = document.getElementById('btnSubmitProof');

    /*
    |--------------------------------------------------------------------------
    | Siapkan Form Berdasarkan UUID Order
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll('.btn-upload-proof').forEach(function (button) {

        button.addEventListener('click', function () {

            const uuid = this.dataset.uuid;
            const orderNumber = this.dataset.orderNumber || '-';

            if (orderNumberLabel) {
                orderNumberLabel.textContent = orderNumber;
            }

            if (uploadForm && uuid) {

                const uploadUrlTemplate = @json(
                    route(
                        'dashboard-user.user-subscription.order.upload-proof',
                        ['uuid' => '__ORDER_UUID__']
                    )
                );

                uploadForm.action = uploadUrlTemplate.replace(
                    '__ORDER_UUID__',
                    encodeURIComponent(uuid)
                );
            }

            if (proofFileName) {
                proofFileName.textContent = '';
                proofFileName.style.color = '';
            }

            if (submitProofButton) {
                submitProofButton.disabled = false;
                submitProofButton.innerHTML =
                    '<i class="bx bx-upload me-1"></i> Kirim Bukti Pembayaran';
            }
        });
    });


    /*
    |--------------------------------------------------------------------------
    | Validasi File Bukti Pembayaran
    |--------------------------------------------------------------------------
    */

    if (proofInput) {

        proofInput.addEventListener('change', function () {

            const file = this.files && this.files.length
                ? this.files[0]
                : null;

            if (!file) {
                proofFileName.textContent = '';
                return;
            }

            const allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];
            const extension = file.name.split('.').pop().toLowerCase();
            const maxSize = 5 * 1024 * 1024;

            if (!allowedExtensions.includes(extension)) {
                this.value = '';

                proofFileName.textContent =
                    'Format file tidak didukung. Gunakan JPG, JPEG, PNG, atau PDF.';

                proofFileName.style.color = '#dc3545';
                return;
            }

            if (file.size > maxSize) {
                this.value = '';

                proofFileName.textContent =
                    'Ukuran file melebihi batas maksimal 5 MB.';

                proofFileName.style.color = '#dc3545';
                return;
            }

            proofFileName.textContent =
                'File dipilih: ' + file.name +
                ' (' + (file.size / (1024 * 1024)).toFixed(2) + ' MB)';

            proofFileName.style.color = '';
        });
    }


    /*
    |--------------------------------------------------------------------------
    | Submit Form
    |--------------------------------------------------------------------------
    */

    if (uploadForm) {

        uploadForm.addEventListener('submit', function (event) {

            if (!uploadForm.action) {
                event.preventDefault();

                alert('URL unggah bukti pembayaran belum tersedia.');
                return;
            }

            if (!uploadForm.checkValidity()) {
                event.preventDefault();
                uploadForm.reportValidity();
                return;
            }

            if (proofInput && proofInput.files.length) {

                const file = proofInput.files[0];
                const allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];
                const extension = file.name.split('.').pop().toLowerCase();
                const maxSize = 5 * 1024 * 1024;

                if (
                    !allowedExtensions.includes(extension) ||
                    file.size > maxSize
                ) {
                    event.preventDefault();

                    alert('File harus berformat JPG, JPEG, PNG, atau PDF dengan ukuran maksimal 5 MB.');
                    return;
                }
            }

            if (submitProofButton) {
                submitProofButton.disabled = true;
                submitProofButton.innerHTML =
                    '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>' +
                    'Mengirim...';
            }
        });
    }


    /*
    |--------------------------------------------------------------------------
    | Reset Modal Ketika Ditutup
    |--------------------------------------------------------------------------
    */

    const uploadModalElement = document.getElementById('uploadProofModal');

    if (uploadModalElement) {

        uploadModalElement.addEventListener('hidden.bs.modal', function () {

            if (uploadForm) {
                uploadForm.reset();
            }

            if (proofFileName) {
                proofFileName.textContent = '';
                proofFileName.style.color = '';
            }

            if (submitProofButton) {
                submitProofButton.disabled = false;
                submitProofButton.innerHTML =
                    '<i class="bx bx-upload me-1"></i> Kirim Bukti Pembayaran';
            }
        });
    }

});
</script>
@endsection

