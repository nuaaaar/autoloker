@extends('layouts.dashboard-user')

@section('title', 'Beranda')

@section('css')

<style>

/* =========================================================
   DASHBOARD VARIABLES
   ========================================================= */

:root,
[data-bs-theme="light"] {

    --dashboard-bg: #f7f8fa;

    --dashboard-card: #ffffff;
    --dashboard-border: #e2e8f0;

    --dashboard-title: #182338;
    --dashboard-text: #475569;
    --dashboard-muted: #94a3b8;

    --dashboard-primary: #f7b003;
    --dashboard-primary-hover: #ffc928;

    --dashboard-primary-soft: #fff4d6;

    --dashboard-green: #3b765c;
    --dashboard-green-soft: #edf5f0;

    --dashboard-blue: #4d86cc;
    --dashboard-blue-soft: #edf5ff;

    --dashboard-purple: #7967c7;
    --dashboard-purple-soft: #f2efff;

    --dashboard-red: #d95c5c;
    --dashboard-red-soft: #fff1f1;

    --dashboard-shadow:
        0 8px 25px rgba(15, 23, 42, .06);

    --dashboard-shadow-hover:
        0 12px 28px rgba(15, 23, 42, .10);

    --dashboard-divider:
        rgba(15, 23, 42, .07);
}


[data-bs-theme="dark"] {

    --dashboard-bg: #0d1424;

    --dashboard-card: #11192d;
    --dashboard-border: rgba(255, 255, 255, .07);

    --dashboard-title: #ffffff;
    --dashboard-text: #c3ccdc;
    --dashboard-muted: #8190ad;

    --dashboard-primary: #f7b003;
    --dashboard-primary-hover: #ffc928;

    --dashboard-primary-soft: #2b241d;

    --dashboard-green: #69a487;
    --dashboard-green-soft: #172d25;

    --dashboard-blue: #76a5df;
    --dashboard-blue-soft: #182940;

    --dashboard-purple: #9a8be1;
    --dashboard-purple-soft: #28243d;

    --dashboard-red: #e47777;
    --dashboard-red-soft: #351f25;

    --dashboard-shadow:
        0 8px 25px rgba(0, 0, 0, .25);

    --dashboard-shadow-hover:
        0 12px 28px rgba(0, 0, 0, .35);

    --dashboard-divider:
        rgba(255, 255, 255, .06);
}


/* =========================================================
   PAGE
   ========================================================= */

.user-dashboard-page {
    padding: 0 0 40px;
}


/* =========================================================
   CARD
   ========================================================= */

.dashboard-card {

    background: var(--dashboard-card);

    border: 1px solid var(--dashboard-border);

    border-radius: 18px;

    box-shadow: var(--dashboard-shadow);

    overflow: hidden;

    transition:
        .25s ease,
        border-color .25s ease,
        box-shadow .25s ease;
}


.dashboard-card:hover {

    box-shadow: var(--dashboard-shadow-hover);
}


/* =========================================================
   WELCOME
   ========================================================= */

.dashboard-welcome {

    position: relative;

    padding: 25px;

    background:
        linear-gradient(
            110deg,
            var(--dashboard-primary-soft),
            var(--dashboard-card)
        );

    border: 1px solid var(--dashboard-border);

    border-radius: 18px;

    overflow: hidden;
}


.dashboard-welcome::after {

    content: "";

    position: absolute;

    width: 180px;
    height: 180px;

    right: -60px;
    top: -80px;

    border-radius: 50%;

    background: rgba(247, 176, 3, .08);
}


.dashboard-welcome-content {

    position: relative;

    z-index: 2;
}


.dashboard-welcome-label {

    color: var(--dashboard-primary);

    font-size: 11px;

    font-weight: 800;

    letter-spacing: 2px;

    text-transform: uppercase;
}


.dashboard-welcome-title {

    color: var(--dashboard-title);

    font-size: 25px;

    font-weight: 700;

    margin-top: 6px;

    margin-bottom: 6px;
}


.dashboard-welcome-subtitle {

    color: var(--dashboard-muted);

    font-size: 13px;
}


.dashboard-role-badge {

    display: inline-flex;

    align-items: center;

    gap: 6px;

    margin-top: 12px;

    padding: 6px 10px;

    border-radius: 20px;

    background: var(--dashboard-primary-soft);

    color: var(--dashboard-primary);

    font-size: 11px;

    font-weight: 700;
}


/* =========================================================
   PROFILE PROGRESS
   ========================================================= */

.dashboard-profile-progress {

    position: relative;

    z-index: 2;

    min-width: 220px;

    padding: 14px 16px;

    background: var(--dashboard-card);

    border: 1px solid var(--dashboard-border);

    border-radius: 14px;
}


.dashboard-profile-title {

    color: var(--dashboard-title);

    font-size: 12px;

    font-weight: 700;

    margin-bottom: 8px;
}


.dashboard-progress {

    height: 7px;

    background: var(--dashboard-divider);

    border-radius: 20px;

    overflow: hidden;
}


.dashboard-progress-bar {

    height: 100%;

    background: var(--dashboard-primary);

    border-radius: 20px;

    transition: width .4s ease;
}


.dashboard-profile-percent {

    color: var(--dashboard-primary);

    font-size: 13px;

    font-weight: 800;
}


/* =========================================================
   KPI
   ========================================================= */

.dashboard-stat {

    height: 100%;

    padding: 19px;

    background: var(--dashboard-card);

    border: 1px solid var(--dashboard-border);

    border-radius: 18px;

    box-shadow: var(--dashboard-shadow);

    transition:
        .25s ease,
        border-color .25s ease,
        transform .25s ease;
}


.dashboard-stat:hover {

    transform: translateY(-2px);

    border-color: rgba(247, 176, 3, .35);

    box-shadow: var(--dashboard-shadow-hover);
}


.dashboard-stat-top {

    display: flex;

    align-items: center;

    justify-content: space-between;
}


.dashboard-stat-icon {

    width: 42px;
    height: 42px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 13px;

    background: var(--dashboard-primary-soft);

    color: var(--dashboard-primary);

    font-size: 17px;
}


.dashboard-stat-icon.green {

    background: var(--dashboard-green-soft);

    color: var(--dashboard-green);
}


.dashboard-stat-icon.blue {

    background: var(--dashboard-blue-soft);

    color: var(--dashboard-blue);
}


.dashboard-stat-icon.purple {

    background: var(--dashboard-purple-soft);

    color: var(--dashboard-purple);
}


.dashboard-stat-label {

    margin-top: 15px;

    color: var(--dashboard-muted);

    font-size: 12px;

    font-weight: 600;
}


.dashboard-stat-value {

    margin-top: 4px;

    color: var(--dashboard-title);

    font-size: 29px;

    line-height: 1;

    font-weight: 800;
}


.dashboard-stat-description {

    margin-top: 8px;

    color: var(--dashboard-muted);

    font-size: 11px;
}


/* =========================================================
   SECTION HEADER
   ========================================================= */

.dashboard-section-header {

    display: flex;

    align-items: center;

    justify-content: space-between;

    padding: 17px 20px;

    border-bottom: 1px solid var(--dashboard-divider);
}


.dashboard-section-title {

    color: var(--dashboard-title);

    font-size: 14px;

    font-weight: 800;

    margin: 0;
}


.dashboard-section-subtitle {

    color: var(--dashboard-muted);

    font-size: 11px;

    margin-top: 3px;
}


.dashboard-section-link {

    color: var(--dashboard-primary);

    font-size: 11px;

    font-weight: 700;

    text-decoration: none;
}


.dashboard-section-link:hover {

    color: var(--dashboard-primary-hover);
}


/* =========================================================
   CATEGORY CARD
   ========================================================= */

.category-card {

    height: 100%;

    padding: 20px;

    border: 1px solid var(--dashboard-border);

    border-radius: 16px;

    background: var(--dashboard-card);
}


.category-header {

    display: flex;

    align-items: center;

    justify-content: space-between;

    margin-bottom: 20px;
}


.category-info {

    display: flex;

    align-items: center;

    gap: 11px;
}


.category-icon {

    width: 42px;
    height: 42px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 13px;

    background: var(--dashboard-primary-soft);

    color: var(--dashboard-primary);

    font-size: 17px;
}


.category-icon.cs {

    background: var(--dashboard-blue-soft);

    color: var(--dashboard-blue);
}


.category-name {

    color: var(--dashboard-title);

    font-size: 14px;

    font-weight: 800;
}


.category-description {

    color: var(--dashboard-muted);

    font-size: 11px;

    margin-top: 2px;
}


.category-badge {

    padding: 5px 9px;

    border-radius: 20px;

    background: var(--dashboard-primary-soft);

    color: var(--dashboard-primary);

    font-size: 10px;

    font-weight: 700;
}


.category-badge.cs {

    background: var(--dashboard-blue-soft);

    color: var(--dashboard-blue);
}


.category-main-value {

    color: var(--dashboard-title);

    font-size: 30px;

    font-weight: 800;

    line-height: 1;
}


.category-main-label {

    color: var(--dashboard-muted);

    font-size: 11px;

    margin-top: 5px;
}


.category-stat-row {

    display: flex;

    justify-content: space-between;

    align-items: center;

    padding: 11px 0;

    border-bottom: 1px solid var(--dashboard-divider);
}


.category-stat-row:last-child {

    border-bottom: none;

    padding-bottom: 0;
}


.category-stat-label {

    color: var(--dashboard-muted);

    font-size: 11px;
}


.category-stat-value {

    color: var(--dashboard-title);

    font-size: 12px;

    font-weight: 800;
}


/* =========================================================
   ATTENTION
   ========================================================= */

.attention-item {

    display: flex;

    align-items: center;

    gap: 12px;

    padding: 15px 20px;

    border-bottom: 1px solid var(--dashboard-divider);
}


.attention-item:last-child {

    border-bottom: none;
}


.attention-icon {

    width: 39px;
    height: 39px;

    flex-shrink: 0;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 12px;

    background: var(--dashboard-primary-soft);

    color: var(--dashboard-primary);
}


.attention-content {

    min-width: 0;

    flex: 1;
}


.attention-title {

    color: var(--dashboard-title);

    font-size: 12px;

    font-weight: 700;

    white-space: nowrap;

    overflow: hidden;

    text-overflow: ellipsis;
}


.attention-meta {

    color: var(--dashboard-muted);

    font-size: 10px;

    margin-top: 3px;
}


.attention-count {

    color: var(--dashboard-primary);

    font-size: 11px;

    font-weight: 800;

    white-space: nowrap;
}


/* =========================================================
   JOB LIST
   ========================================================= */

.job-item {

    display: flex;

    align-items: center;

    gap: 13px;

    padding: 15px 20px;

    border-bottom: 1px solid var(--dashboard-divider);
}


.job-item:last-child {

    border-bottom: none;
}


.job-icon {

    width: 40px;
    height: 40px;

    flex-shrink: 0;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 12px;

    background: var(--dashboard-primary-soft);

    color: var(--dashboard-primary);
}


.job-content {

    flex: 1;

    min-width: 0;
}


.job-title {

    color: var(--dashboard-title);

    font-size: 12px;

    font-weight: 700;

    white-space: nowrap;

    overflow: hidden;

    text-overflow: ellipsis;
}


.job-meta {

    display: flex;

    align-items: center;

    gap: 7px;

    margin-top: 4px;

    color: var(--dashboard-muted);

    font-size: 10px;
}


.job-status {

    padding: 4px 7px;

    border-radius: 20px;

    font-size: 9px;

    font-weight: 700;
}


.job-status.published {

    background: var(--dashboard-green-soft);

    color: var(--dashboard-green);
}


.job-status.draft {

    background: var(--dashboard-primary-soft);

    color: var(--dashboard-primary);
}


.job-status.closed {

    background: var(--dashboard-red-soft);

    color: var(--dashboard-red);
}


.job-applications {

    color: var(--dashboard-muted);

    font-size: 10px;

    white-space: nowrap;
}


/* =========================================================
   ACTIVITY
   ========================================================= */

.activity-item {

    display: flex;

    align-items: center;

    gap: 13px;

    padding: 15px 20px;

    border-bottom: 1px solid var(--dashboard-divider);
}


.activity-item:last-child {

    border-bottom: none;
}


.activity-avatar {

    width: 40px;
    height: 40px;

    flex-shrink: 0;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: var(--dashboard-primary-soft);

    color: var(--dashboard-primary);
}


.activity-content {

    min-width: 0;

    flex: 1;
}


.activity-name {

    color: var(--dashboard-title);

    font-size: 12px;

    font-weight: 700;
}


.activity-description {

    color: var(--dashboard-muted);

    font-size: 10px;

    margin-top: 3px;
}


.activity-time {

    color: var(--dashboard-muted);

    font-size: 9px;

    white-space: nowrap;
}


/* =========================================================
   QUICK ACTION
   ========================================================= */

.quick-action {

    padding: 10px;
}


.quick-action-item {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 10px;

    padding: 13px 14px;

    margin-bottom: 9px;

    border-radius: 13px;

    background: var(--dashboard-divider);

    color: var(--dashboard-text);

    text-decoration: none;

    font-size: 12px;

    font-weight: 700;

    transition: .2s ease;
}


.quick-action-item:last-child {

    margin-bottom: 0;
}


.quick-action-item:hover {

    background: var(--dashboard-primary-soft);

    color: var(--dashboard-primary);

    transform: translateX(2px);
}


.quick-action-left {

    display: flex;

    align-items: center;

    gap: 10px;
}


.quick-action-icon {

    width: 30px;
    height: 30px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 9px;

    background: var(--dashboard-card);

    color: var(--dashboard-primary);
}


/* =========================================================
   EMPTY
   ========================================================= */

.dashboard-empty {

    padding: 35px 20px;

    text-align: center;

    color: var(--dashboard-muted);

    font-size: 12px;
}


.dashboard-empty i {

    display: block;

    margin-bottom: 10px;

    font-size: 25px;
}


/* =========================================================
   RESPONSIVE
   ========================================================= */

@media (max-width: 1199px) {

    .dashboard-profile-progress {

        min-width: 190px;
    }

}


@media (max-width: 767px) {

    .dashboard-welcome {

        padding: 18px;
    }


    .dashboard-welcome-title {

        font-size: 21px;
    }


    .dashboard-profile-progress {

        width: 100%;

        margin-top: 18px;
    }


    .dashboard-stat-value {

        font-size: 25px;
    }


    .category-main-value {

        font-size: 26px;
    }

}

</style>

@endsection


@section('content')

<div class="user-dashboard-page">

    {{-- =====================================================
        PAGE TITLE
    ====================================================== --}}

    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
        Beranda
    </h1>


    {{-- =====================================================
        BREADCRUMB
    ====================================================== --}}

    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1 mb-5">

        <li class="breadcrumb-item text-muted">

            <a href="javascript:;" class="text-muted text-hover-primary">
                Beranda
            </a>

        </li>

    </ul>


    {{-- =====================================================
        WELCOME
    ====================================================== --}}

    <div class="dashboard-welcome mb-6">

        <div class="dashboard-welcome-content">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-4">

                <div>

                    <div class="dashboard-welcome-label">
                        Dashboard
                    </div>

                    <div class="dashboard-welcome-title">

                        Selamat Datang,
                        {{ $profile->company_name ?? $profile->name ?? 'Pengguna' }}

                    </div>

                    <div class="dashboard-welcome-subtitle">

                        Pantau lowongan, pelamar, dan proses rekrutmen Anda dari satu tempat.

                    </div>

                    <div class="dashboard-role-badge">

                        @if(Auth::user()->role === 'company')

                            <i class="ki-duotone ki-office-bag fs-6">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>

                        @else

                            <i class="ki-duotone ki-briefcase fs-6">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>

                        @endif

                        {{ $roleLabel }}

                    </div>

                </div>


                {{-- PROFILE PROGRESS --}}

                <div class="dashboard-profile-progress">

                    <div class="d-flex justify-content-between align-items-center mb-2">

                        <div class="dashboard-profile-title">
                            Kelengkapan Profil
                        </div>

                        <div class="dashboard-profile-percent">

                            {{ $profile_progress['progress'] ?? 0 }}%

                        </div>

                    </div>


                    <div class="dashboard-progress">

                        <div
                            class="dashboard-progress-bar"
                            style="width: {{ $profile_progress['progress'] ?? 0 }}%;">
                        </div>

                    </div>


                    @if(($profile_progress['progress'] ?? 0) < 100)

                        <div class="text-muted fs-8 mt-2">

                            Lengkapi profil untuk meningkatkan kelengkapan data.

                        </div>

                    @else

                        <div class="text-success fs-8 mt-2">

                            Profil Anda sudah lengkap.

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
        PROFILE ALERT
    ====================================================== --}}

    @if(($profile_progress['progress'] ?? 0) < 100)

        @if(view()->exists('dashboard-user.partials.alert-complete-data'))

            @include('dashboard-user.partials.alert-complete-data')

        @endif

    @endif


    {{-- =====================================================
        KPI STATISTICS
    ====================================================== --}}

    <div class="row g-5 mb-6">


        {{-- TOTAL JOB --}}

        <div class="col-xl-3 col-md-6">

            <div class="dashboard-stat">

                <div class="dashboard-stat-top">

                    <div class="dashboard-stat-icon">

                        <i class="ki-duotone ki-briefcase fs-3">

                            <span class="path1"></span>
                            <span class="path2"></span>

                        </i>

                    </div>

                </div>

                <div class="dashboard-stat-label">
                    Total Lowongan
                </div>

                <div class="dashboard-stat-value">
                    {{ number_format($totalJobs) }}
                </div>

                <div class="dashboard-stat-description">
                    Semua lowongan yang dibuat
                </div>

            </div>

        </div>


        {{-- ACTIVE JOB --}}

        <div class="col-xl-3 col-md-6">

            <div class="dashboard-stat">

                <div class="dashboard-stat-top">

                    <div class="dashboard-stat-icon green">

                        <i class="ki-duotone ki-check-circle fs-3">

                            <span class="path1"></span>
                            <span class="path2"></span>

                        </i>

                    </div>

                </div>

                <div class="dashboard-stat-label">
                    Lowongan Aktif
                </div>

                <div class="dashboard-stat-value">
                    {{ number_format($publishedJobs) }}
                </div>

                <div class="dashboard-stat-description">
                    Lowongan dengan status published
                </div>

            </div>

        </div>


        {{-- TOTAL APPLICATION --}}

        <div class="col-xl-3 col-md-6">

            <div class="dashboard-stat">

                <div class="dashboard-stat-top">

                    <div class="dashboard-stat-icon blue">

                        <i class="ki-duotone ki-people fs-3">

                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>

                        </i>

                    </div>

                </div>

                <div class="dashboard-stat-label">
                    Total Pelamar
                </div>

                <div class="dashboard-stat-value">
                    {{ number_format($totalApplications) }}
                </div>

                <div class="dashboard-stat-description">
                    Seluruh pelamar pada lowongan Anda
                </div>

            </div>

        </div>


        {{-- SHORTLIST --}}

        <div class="col-xl-3 col-md-6">

            <div class="dashboard-stat">

                <div class="dashboard-stat-top">

                    <div class="dashboard-stat-icon purple">

                        <i class="ki-duotone ki-medal-star fs-3">

                            <span class="path1"></span>
                            <span class="path2"></span>

                        </i>

                    </div>

                </div>

                <div class="dashboard-stat-label">
                    Shortlisted
                </div>

                <div class="dashboard-stat-value">
                    {{ number_format($shortlistedApplications) }}
                </div>

                <div class="dashboard-stat-description">
                    Kandidat yang masuk shortlist
                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
        MAIN CONTENT
    ====================================================== --}}

    <div class="row g-5">


        {{-- =================================================
            LEFT COLUMN
        ================================================== --}}

        <div class="col-xl-8">


            {{-- =================================================
                CATEGORY STATISTICS
            ================================================== --}}

            <div class="dashboard-card mb-5">

                <div class="dashboard-section-header">

                    <div>

                        <h3 class="dashboard-section-title">
                            Statistik Berdasarkan Kategori
                        </h3>

                        <div class="dashboard-section-subtitle">
                            Ringkasan lowongan dan pelamar berdasarkan kategori tenaga kerja.
                        </div>

                    </div>

                    <a
                        href="{{ route('dashboard-user.job-vacancy.statistic') }}"
                        class="dashboard-section-link">

                        Lihat Statistik
                        <i class="fas fa-arrow-right ms-1"></i>

                    </a>

                </div>


                <div class="card-body p-5">

                    <div class="row g-5">


                        {{-- =================================================
                            SECURITY
                        ================================================== --}}

                        @php

                            $security =
                                $categoryStatistics['security']
                                ?? [
                                    'label' => 'Satpam',
                                    'totalJobs' => 0,
                                    'publishedJobs' => 0,
                                    'draftJobs' => 0,
                                    'closedJobs' => 0,
                                    'applications' => 0,
                                    'activeApplications' => 0,
                                    'applied' => 0,
                                    'reviewed' => 0,
                                    'shortlisted' => 0,
                                    'rejected' => 0,
                                    'reviewRate' => 0,
                                    'shortlistRate' => 0,
                                ];

                        @endphp


                        <div class="col-md-6">

                            <div class="category-card">

                                <div class="category-header">

                                    <div class="category-info">

                                        <div class="category-icon">

                                            <i class="fas fa-shield-alt"></i>

                                        </div>

                                        <div>

                                            <div class="category-name">
                                                Satpam
                                            </div>

                                            <div class="category-description">
                                                Security
                                            </div>

                                        </div>

                                    </div>

                                    <span class="category-badge">
                                        SECURITY
                                    </span>

                                </div>


                                <div class="mb-4">

                                    <div class="category-main-value">

                                        {{ number_format($security['totalJobs']) }}

                                    </div>

                                    <div class="category-main-label">
                                        Total Lowongan
                                    </div>

                                </div>


                                <div class="category-stat-row">

                                    <span class="category-stat-label">
                                        Lowongan Aktif
                                    </span>

                                    <span class="category-stat-value">

                                        {{ number_format($security['publishedJobs']) }}

                                    </span>

                                </div>


                                <div class="category-stat-row">

                                    <span class="category-stat-label">
                                        Total Pelamar
                                    </span>

                                    <span class="category-stat-value">

                                        {{ number_format($security['applications']) }}

                                    </span>

                                </div>


                                <div class="category-stat-row">

                                    <span class="category-stat-label">
                                        Pelamar Aktif
                                    </span>

                                    <span class="category-stat-value">

                                        {{ number_format($security['activeApplications']) }}

                                    </span>

                                </div>


                                <div class="category-stat-row">

                                    <span class="category-stat-label">
                                        Reviewed
                                    </span>

                                    <span class="category-stat-value">

                                        {{ number_format($security['reviewed']) }}

                                    </span>

                                </div>


                                <div class="category-stat-row">

                                    <span class="category-stat-label">
                                        Shortlisted
                                    </span>

                                    <span class="category-stat-value">

                                        {{ number_format($security['shortlisted']) }}

                                    </span>

                                </div>


                                <div class="category-stat-row">

                                    <span class="category-stat-label">
                                        Shortlist Rate
                                    </span>

                                    <span class="category-stat-value text-success">

                                        {{ $security['shortlistRate'] }}%

                                    </span>

                                </div>

                            </div>

                        </div>


                        {{-- =================================================
                            CLEANING SERVICE
                        ================================================== --}}

                        @php

                            $cs =
                                $categoryStatistics['cs']
                                ?? [
                                    'label' => 'Cleaning Service',
                                    'totalJobs' => 0,
                                    'publishedJobs' => 0,
                                    'draftJobs' => 0,
                                    'closedJobs' => 0,
                                    'applications' => 0,
                                    'activeApplications' => 0,
                                    'applied' => 0,
                                    'reviewed' => 0,
                                    'shortlisted' => 0,
                                    'rejected' => 0,
                                    'reviewRate' => 0,
                                    'shortlistRate' => 0,
                                ];

                        @endphp


                        <div class="col-md-6">

                            <div class="category-card">

                                <div class="category-header">

                                    <div class="category-info">

                                        <div class="category-icon cs">

                                            <i class="fas fa-broom"></i>

                                        </div>

                                        <div>

                                            <div class="category-name">
                                                Cleaning Service
                                            </div>

                                            <div class="category-description">
                                                Cleaning Service
                                            </div>

                                        </div>

                                    </div>

                                    <span class="category-badge cs">
                                        CLEANING SERVICE
                                    </span>

                                </div>


                                <div class="mb-4">

                                    <div class="category-main-value">

                                        {{ number_format($cs['totalJobs']) }}

                                    </div>

                                    <div class="category-main-label">
                                        Total Lowongan
                                    </div>

                                </div>


                                <div class="category-stat-row">

                                    <span class="category-stat-label">
                                        Lowongan Aktif
                                    </span>

                                    <span class="category-stat-value">

                                        {{ number_format($cs['publishedJobs']) }}

                                    </span>

                                </div>


                                <div class="category-stat-row">

                                    <span class="category-stat-label">
                                        Total Pelamar
                                    </span>

                                    <span class="category-stat-value">

                                        {{ number_format($cs['applications']) }}

                                    </span>

                                </div>


                                <div class="category-stat-row">

                                    <span class="category-stat-label">
                                        Pelamar Aktif
                                    </span>

                                    <span class="category-stat-value">

                                        {{ number_format($cs['activeApplications']) }}

                                    </span>

                                </div>


                                <div class="category-stat-row">

                                    <span class="category-stat-label">
                                        Reviewed
                                    </span>

                                    <span class="category-stat-value">

                                        {{ number_format($cs['reviewed']) }}

                                    </span>

                                </div>


                                <div class="category-stat-row">

                                    <span class="category-stat-label">
                                        Shortlisted
                                    </span>

                                    <span class="category-stat-value">

                                        {{ number_format($cs['shortlisted']) }}

                                    </span>

                                </div>


                                <div class="category-stat-row">

                                    <span class="category-stat-label">
                                        Shortlist Rate
                                    </span>

                                    <span class="category-stat-value text-success">

                                        {{ $cs['shortlistRate'] }}%

                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =================================================
                ATTENTION JOBS
            ================================================== --}}

            <div class="dashboard-card mb-5">

                <div class="dashboard-section-header">

                    <div>

                        <h3 class="dashboard-section-title">
                            Perlu Ditindaklanjuti
                        </h3>

                        <div class="dashboard-section-subtitle">
                            Lowongan yang memiliki pelamar dan membutuhkan perhatian.
                        </div>

                    </div>

                    <span class="badge badge-light-warning">
                        {{ $pendingReview }} menunggu review
                    </span>

                </div>


                @forelse($attentionJobs as $job)

                    <div class="attention-item">

                        <div class="attention-icon">

                            @if($job->category === 'security')

                                <i class="fas fa-shield-alt"></i>

                            @else

                                <i class="fas fa-broom"></i>

                            @endif

                        </div>


                        <div class="attention-content">

                            <div class="attention-title">

                                {{ $job->position ?? '-' }}

                            </div>

                            <div class="attention-meta">

                                {{ $job->category === 'security'
                                    ? 'Satpam'
                                    : 'Cleaning Service'
                                }}

                                ·

                                {{ number_format($job->applications_count) }}
                                pelamar

                            </div>

                        </div>


                        <div class="text-end">

                            @if($job->pending_applications_count > 0)

                                <div class="attention-count">

                                    {{ $job->pending_applications_count }}

                                    pending

                                </div>

                            @endif


                            <a
                                href="{{ route(
                                    'dashboard-user.job-application.index',
                                    ['uuid' => $job->uuid]
                                ) }}"
                                class="btn btn-sm btn-light-primary mt-1">

                                Lihat

                            </a>

                        </div>

                    </div>

                @empty

                    <div class="dashboard-empty">

                        <i class="fas fa-check-circle text-success"></i>

                        Tidak ada pelamar yang perlu ditindaklanjuti.

                    </div>

                @endforelse

            </div>


            {{-- =================================================
                RECENT JOBS
            ================================================== --}}

            <div class="dashboard-card mb-5">

                <div class="dashboard-section-header">

                    <div>

                        <h3 class="dashboard-section-title">
                            Lowongan Terbaru
                        </h3>

                        <div class="dashboard-section-subtitle">
                            Lima lowongan terakhir yang dibuat.
                        </div>

                    </div>

                    <a
                        href="{{ route('dashboard-user.job-vacancy.index') }}"
                        class="dashboard-section-link">

                        Lihat Semua
                        <i class="fas fa-arrow-right ms-1"></i>

                    </a>

                </div>


                @forelse($recentJobs as $job)

                    <div class="job-item">

                        <div class="job-icon">

                            @if($job->category === 'security')

                                <i class="fas fa-shield-alt"></i>

                            @else

                                <i class="fas fa-broom"></i>

                            @endif

                        </div>


                        <div class="job-content">

                            <div class="job-title">

                                {{ $job->position ?? '-' }}

                            </div>


                            <div class="job-meta">

                                <span>

                                    {{ $job->category === 'security'
                                        ? 'Satpam'
                                        : 'Cleaning Service'
                                    }}

                                </span>

                                <span>•</span>

                                <span>

                                    {{ $job->created_at?->diffForHumans() }}

                                </span>

                            </div>

                        </div>


                        <div class="text-end">

                            @switch($job->status)

                                @case('published')

                                    <div class="job-status published">
                                        Published
                                    </div>

                                    @break

                                @case('draft')

                                    <div class="job-status draft">
                                        Draft
                                    </div>

                                    @break

                                @case('closed')

                                    <div class="job-status closed">
                                        Closed
                                    </div>

                                    @break

                                @default

                                    <div class="job-status draft">
                                        {{ ucfirst($job->status ?? '-') }}
                                    </div>

                            @endswitch


                            <div class="job-applications mt-2">

                                <i class="fas fa-users me-1"></i>

                                {{ number_format($job->applications_count) }}
                                pelamar

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="dashboard-empty">

                        <i class="fas fa-briefcase"></i>

                        Belum ada lowongan.

                    </div>

                @endforelse

            </div>


            {{-- =================================================
                RECENT ACTIVITY
            ================================================== --}}

            <div class="dashboard-card">

                <div class="dashboard-section-header">

                    <div>

                        <h3 class="dashboard-section-title">
                            Aktivitas Terbaru
                        </h3>

                        <div class="dashboard-section-subtitle">
                            Aktivitas pelamar terbaru pada lowongan Anda.
                        </div>

                    </div>

                </div>


                @forelse($recentApplications as $application)

                    <div class="activity-item">

                        <div class="activity-avatar">

                            <i class="fas fa-user"></i>

                        </div>


                        <div class="activity-content">

                            <div class="activity-name">

                                Pelamar baru

                            </div>


                            <div class="activity-description">

                                Seseorang melamar pada lowongan

                                <strong>

                                    {{ $application->job_vacancy?->position ?? '-' }}

                                </strong>

                                ·

                                {{ $application->job_vacancy?->category === 'security'
                                    ? 'Satpam'
                                    : 'Cleaning Service'
                                }}

                            </div>

                        </div>


                        <div class="activity-time">

                            {{ $application->created_at?->diffForHumans() }}

                        </div>

                    </div>

                @empty

                    <div class="dashboard-empty">

                        <i class="fas fa-history"></i>

                        Belum ada aktivitas pelamar.

                    </div>

                @endforelse

            </div>

        </div>


        {{-- =================================================
            RIGHT COLUMN
        ================================================== --}}

        <div class="col-xl-4">


            {{-- =================================================
                QUICK ACTION
            ================================================== --}}

            <div class="dashboard-card mb-5">

                <div class="dashboard-section-header">

                    <div>

                        <h3 class="dashboard-section-title">
                            Quick Action
                        </h3>

                        <div class="dashboard-section-subtitle">
                            Akses menu yang sering digunakan.
                        </div>

                    </div>

                </div>


                <div class="quick-action">


                    {{-- CREATE JOB --}}

                    <a
                        href="{{ route('dashboard-user.job-vacancy.create') }}"
                        class="quick-action-item">

                        <div class="quick-action-left">

                            <div class="quick-action-icon">

                                <i class="fas fa-plus"></i>

                            </div>

                            <span>
                                Buat Lowongan
                            </span>

                        </div>

                        <i class="fas fa-chevron-right fs-8"></i>

                    </a>


                    {{-- JOB VACANCY --}}

                    <a
                        href="{{ route('dashboard-user.job-vacancy.index') }}"
                        class="quick-action-item">

                        <div class="quick-action-left">

                            <div class="quick-action-icon">

                                <i class="fas fa-briefcase"></i>

                            </div>

                            <span>
                                Kelola Lowongan
                            </span>

                        </div>

                        <i class="fas fa-chevron-right fs-8"></i>

                    </a>


                    {{-- STATISTIC --}}

                    <a
                        href="{{ route('dashboard-user.job-vacancy.statistic') }}"
                        class="quick-action-item">

                        <div class="quick-action-left">

                            <div class="quick-action-icon">

                                <i class="fas fa-chart-line"></i>

                            </div>

                            <span>
                                Statistik
                            </span>

                        </div>

                        <i class="fas fa-chevron-right fs-8"></i>

                    </a>


                    {{-- PROFILE --}}

                    <a
                        href="javascript:;"
                        class="quick-action-item">

                        <div class="quick-action-left">

                            <div class="quick-action-icon">

                                <i class="fas fa-building"></i>

                            </div>

                            <span>
                                Profil {{ $roleLabel }}
                            </span>

                        </div>

                        <i class="fas fa-chevron-right fs-8"></i>

                    </a>


                </div>

            </div>


            {{-- =================================================
                CATEGORY SUMMARY
            ================================================== --}}

            <div class="dashboard-card mb-5">

                <div class="dashboard-section-header">

                    <div>

                        <h3 class="dashboard-section-title">
                            Ringkasan Kategori
                        </h3>

                        <div class="dashboard-section-subtitle">
                            Distribusi lowongan dan pelamar.
                        </div>

                    </div>

                </div>


                <div class="card-body p-5">


                    {{-- SECURITY --}}

                    <div class="d-flex align-items-center mb-5">

                        <div
                            class="category-icon me-3"
                            style="width:38px;height:38px;">

                            <i class="fas fa-shield-alt"></i>

                        </div>


                        <div class="flex-grow-1">

                            <div class="fw-bold text-gray-800 fs-7">

                                Satpam

                            </div>

                            <div class="text-muted fs-8">

                                {{ number_format($totalSecurityJobs) }}
                                lowongan

                            </div>

                        </div>


                        <div class="text-end">

                            <div class="fw-bold text-gray-800">

                                {{ number_format($totalSecurityApplications) }}

                            </div>

                            <div class="text-muted fs-8">

                                pelamar

                            </div>

                        </div>

                    </div>


                    {{-- CS --}}

                    <div class="d-flex align-items-center">

                        <div
                            class="category-icon cs me-3"
                            style="width:38px;height:38px;">

                            <i class="fas fa-broom"></i>

                        </div>


                        <div class="flex-grow-1">

                            <div class="fw-bold text-gray-800 fs-7">

                                Cleaning Service

                            </div>

                            <div class="text-muted fs-8">

                                {{ number_format($totalCsJobs) }}
                                lowongan

                            </div>

                        </div>


                        <div class="text-end">

                            <div class="fw-bold text-gray-800">

                                {{ number_format($totalCsApplications) }}

                            </div>

                            <div class="text-muted fs-8">

                                pelamar

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =================================================
                RECRUITMENT SUMMARY
            ================================================== --}}

            <div class="dashboard-card">

                <div class="dashboard-section-header">

                    <div>

                        <h3 class="dashboard-section-title">
                            Status Rekrutmen
                        </h3>

                        <div class="dashboard-section-subtitle">
                            Ringkasan proses pelamar.
                        </div>

                    </div>

                </div>


                <div class="card-body p-5">


                    {{-- APPLIED --}}

                    <div class="category-stat-row">

                        <span class="category-stat-label">

                            Applied

                        </span>

                        <span class="category-stat-value">

                            {{ number_format($appliedApplications) }}

                        </span>

                    </div>


                    {{-- REVIEWED --}}

                    <div class="category-stat-row">

                        <span class="category-stat-label">

                            Reviewed

                        </span>

                        <span class="category-stat-value">

                            {{ number_format($reviewedApplications) }}

                        </span>

                    </div>


                    {{-- SHORTLISTED --}}

                    <div class="category-stat-row">

                        <span class="category-stat-label">

                            Shortlisted

                        </span>

                        <span class="category-stat-value text-success">

                            {{ number_format($shortlistedApplications) }}

                        </span>

                    </div>


                    {{-- REJECTED --}}

                    <div class="category-stat-row">

                        <span class="category-stat-label">

                            Rejected

                        </span>

                        <span class="category-stat-value text-danger">

                            {{ number_format($rejectedApplications) }}

                        </span>

                    </div>


                    {{-- ACTIVE --}}

                    <div class="category-stat-row">

                        <span class="category-stat-label">

                            Proses Aktif

                        </span>

                        <span class="category-stat-value">

                            {{ number_format($activeApplications) }}

                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection


@section('js')

<script>

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    |
    | Saat ini dashboard tidak membutuhkan JavaScript khusus.
    | Semua data dirender dari controller.
    |
    */

</script>

@endsection