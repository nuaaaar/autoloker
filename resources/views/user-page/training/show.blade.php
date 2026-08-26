@extends('layouts.user-page')

@section('title', 'Detail Pelatihan')

@section('style')

<style>

/* =========================================================
   TRAINING DETAIL
========================================================= */

.training-detail-wrapper {
    max-width: 760px;
    margin: 0 auto;
    padding: 25px 0 60px;
}


/* =========================================================
   BACK
========================================================= */

.training-back {
    display: inline-flex;
    align-items: center;
    gap: 7px;

    color: #8c99b5;
    font-size: 12px;
    font-weight: 500;

    text-decoration: none;

    margin-bottom: 14px;
}

.training-back:hover {
    color: #ffb000;
}


/* =========================================================
   CARD
========================================================= */

.training-detail-card {
    background: #101a32;
    border: 1px solid #202d4a;

    border-radius: 15px;

    padding: 20px;

    margin-bottom: 14px;
}


/* =========================================================
   HEADER
========================================================= */

.training-header-card {
    border-top: 4px solid #f5a900;
}


.training-header {
    display: flex;
    gap: 15px;
}


.training-poster {
    width: 82px;
    height: 82px;

    flex-shrink: 0;

    border-radius: 11px;

    background: #162542;

    border: 1px solid #263655;

    overflow: hidden;

    display: flex;
    align-items: center;
    justify-content: center;

    color: #ffb000;

    font-size: 26px;
}


.training-poster img {
    width: 100%;
    height: 100%;

    object-fit: cover;
}


.training-header-content {
    flex: 1;
}


.training-title-row {
    display: flex;
    align-items: center;

    gap: 8px;

    flex-wrap: wrap;
}


.training-title-row h1 {
    margin: 0;

    color: #f4f6fb;

    font-size: 18px;
    font-weight: 700;

    line-height: 1.4;
}


.training-provider-name {
    margin-top: 4px;

    color: #7785a2;

    font-size: 12px;
}


.training-meta {
    display: flex;

    flex-wrap: wrap;

    gap: 12px;

    margin-top: 8px;
}


.training-meta span {
    display: inline-flex;

    align-items: center;

    gap: 5px;

    color: #8290ac;

    font-size: 11px;
}


.training-meta i {
    color: #ffb000;

    font-size: 12px;
}


/* =========================================================
   BADGE
========================================================= */

.training-badges {
    display: flex;

    flex-wrap: wrap;

    gap: 6px;

    margin-top: 9px;
}


.training-badge {
    display: inline-flex;

    align-items: center;

    gap: 4px;

    padding: 4px 8px;

    border-radius: 6px;

    border: 1px solid #33415f;

    background: #141f39;

    color: #9ba7bd;

    font-size: 9px;

    font-weight: 600;
}


.training-badge.primary {
    color: #ffb000;

    border-color: #72551b;
}


.training-badge.success {
    color: #19c997;

    border-color: #146b58;

    background: #12352f;
}


.training-badge.danger {
    color: #ff6b6b;

    border-color: #713535;

    background: #351c24;
}


/* =========================================================
   SUMMARY
========================================================= */

.training-summary {
    display: grid;

    grid-template-columns: repeat(3, 1fr);

    border-top: 1px solid #202d4a;
    border-bottom: 1px solid #202d4a;

    margin-top: 18px;
}


.training-summary-item {
    padding: 13px 12px;

    border-right: 1px solid #202d4a;

    text-align: center;
}


.training-summary-item:last-child {
    border-right: 0;
}


.training-summary-item span {
    display: block;

    color: #71809c;

    font-size: 10px;
}


.training-summary-item strong {
    display: block;

    margin-top: 4px;

    color: #ffb000;

    font-size: 13px;
}


.training-summary-item small {
    color: #8996ad;

    font-size: 9px;
}


/* =========================================================
   QUOTA
========================================================= */

.training-quota {
    margin-top: 15px;
}


.training-quota-header {
    display: flex;

    align-items: center;

    justify-content: space-between;

    color: #71809c;

    font-size: 10px;

    margin-bottom: 6px;
}


.training-quota-header strong {
    color: #dce2ed;
}


.training-progress {
    width: 100%;

    height: 6px;

    border-radius: 10px;

    overflow: hidden;

    background: #1b2842;
}


.training-progress-bar {
    height: 100%;

    border-radius: 10px;

    background: #ffb000;
}


/* =========================================================
   ACTION
========================================================= */

.training-header-action {
    display: flex;

    gap: 10px;

    margin-top: 15px;
}


.btn-training-register {
    flex: 1;

    border: 0;

    border-radius: 9px;

    background: #ffb000;

    color: #101010;

    font-size: 12px;

    font-weight: 700;

    padding: 11px 18px;

    cursor: pointer;
}


.btn-training-register:hover {
    background: #ffc333;
}


.btn-training-register:disabled {
    opacity: .6;

    cursor: not-allowed;
}


.btn-training-share {
    min-width: 90px;

    border: 1px solid #2d3a58;

    border-radius: 9px;

    background: transparent;

    color: #8d99b2;

    font-size: 12px;

    cursor: pointer;
}


.btn-training-share:hover {
    border-color: #ffb000;

    color: #ffb000;
}


/* =========================================================
   DETAIL TITLE
========================================================= */

.training-detail-title {
    margin-bottom: 12px;

    color: #8291ad;

    font-size: 10px;

    font-weight: 700;

    letter-spacing: .6px;
}


.training-detail-text {
    color: #8794ad;

    font-size: 11px;

    line-height: 1.7;
}


/* =========================================================
   DETAIL LIST
========================================================= */

.training-detail-list {
    display: flex;

    flex-direction: column;

    gap: 9px;
}


.training-detail-list-item {
    display: flex;

    align-items: flex-start;

    gap: 8px;

    color: #a1acc0;

    font-size: 11px;

    line-height: 1.6;
}


.training-icon {
    width: 17px;
    height: 17px;

    flex-shrink: 0;

    border-radius: 50%;

    display: flex;

    align-items: center;
    justify-content: center;

    background: #17233c;

    color: #ffb000;

    font-size: 9px;
}


/* =========================================================
   INFO GRID
========================================================= */

.training-info-grid {
    display: grid;

    grid-template-columns: repeat(2, 1fr);

    gap: 14px 30px;
}


.training-info-item small {
    display: block;

    color: #64728d;

    font-size: 9px;

    margin-bottom: 3px;
}


.training-info-item strong {
    display: block;

    color: #d9deea;

    font-size: 11px;
}


/* =========================================================
   TAGS
========================================================= */

.training-tags {
    display: flex;

    flex-wrap: wrap;

    gap: 7px;
}


.training-tag {
    display: inline-flex;

    align-items: center;

    gap: 5px;

    padding: 5px 9px;

    border-radius: 6px;

    border: 1px solid #33415f;

    background: #141f39;

    color: #9ba7bd;

    font-size: 10px;
}


.training-tag.primary {
    color: #ffb000;

    border-color: #72551b;
}


/* =========================================================
   CERTIFICATE
========================================================= */

.training-certificate-box {
    display: flex;

    align-items: center;

    gap: 12px;

    padding: 13px;

    border: 1px solid #72551b;

    border-radius: 10px;

    background: #171a29;
}


.training-certificate-icon {
    width: 40px;
    height: 40px;

    flex-shrink: 0;

    border-radius: 9px;

    background: #202033;

    display: flex;

    align-items: center;
    justify-content: center;

    color: #ffb000;

    font-size: 18px;
}


.training-certificate-box strong {
    display: block;

    color: #e2e6ef;

    font-size: 12px;
}


.training-certificate-box span {
    display: block;

    margin-top: 3px;

    color: #71809a;

    font-size: 10px;
}


/* =========================================================
   INSTRUCTOR
========================================================= */

.training-instructor {
    display: flex;

    align-items: center;

    gap: 12px;
}


.training-instructor-avatar {
    width: 42px;
    height: 42px;

    flex-shrink: 0;

    border-radius: 50%;

    background: #16233d;

    display: flex;

    align-items: center;
    justify-content: center;

    color: #8190aa;

    font-size: 18px;
}


.training-instructor strong {
    display: block;

    color: #dce2ed;

    font-size: 12px;
}


.training-instructor span {
    display: block;

    margin-top: 3px;

    color: #6f7d98;

    font-size: 10px;
}


/* =========================================================
   STATISTICS
========================================================= */

.training-statistics {
    display: grid;

    grid-template-columns: repeat(2, 1fr);
}


.training-statistics > div {
    text-align: center;

    border-right: 1px solid #202d4a;
}


.training-statistics > div:last-child {
    border-right: 0;
}


.training-statistics strong {
    display: block;

    color: #e4e8f1;

    font-size: 18px;
}


.training-statistics span {
    display: block;

    margin-top: 3px;

    color: #71809a;

    font-size: 9px;
}


/* =========================================================
   PROVIDER
========================================================= */

.training-provider {
    display: flex;

    align-items: center;

    gap: 12px;
}


.training-provider-icon {
    width: 40px;
    height: 40px;

    border-radius: 9px;

    background: #16233d;

    display: flex;

    align-items: center;
    justify-content: center;

    color: #7e8da8;

    font-size: 18px;
}


.training-provider strong {
    display: block;

    color: #dce1eb;

    font-size: 12px;
}


.training-provider span {
    display: block;

    margin-top: 2px;

    color: #6f7d98;

    font-size: 10px;
}


/* =========================================================
   FOOTER CTA
========================================================= */

.training-footer {
    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 20px;
}


.training-footer strong {
    display: block;

    color: #dce2ed;

    font-size: 12px;
}


.training-footer span {
    display: block;

    margin-top: 4px;

    color: #74819b;

    font-size: 10px;
}


.training-footer b {
    color: #ffb000;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 768px) {

    .training-detail-wrapper {
        padding: 15px 12px 40px;
    }


    .training-detail-card {
        padding: 16px;
    }


    .training-poster {
        width: 65px;
        height: 65px;
    }


    .training-title-row h1 {
        font-size: 16px;
    }


    .training-summary {
        grid-template-columns: repeat(2, 1fr);
    }


    .training-summary-item:nth-child(2) {
        border-right: 0;
    }


    .training-summary-item:last-child {
        grid-column: 1 / -1;

        border-top: 1px solid #202d4a;
    }


    .training-info-grid {
        grid-template-columns: 1fr 1fr;
    }


    .training-footer {
        flex-direction: column;

        align-items: stretch;
    }


    .training-footer .btn-training-register {
        width: 100%;
    }

}


@media (max-width: 480px) {

    .training-header {
        align-items: flex-start;
    }


    .training-poster {
        width: 55px;
        height: 55px;
    }


    .training-meta {
        gap: 8px;
    }


    .training-header-action {
        flex-direction: column;
    }


    .btn-training-share {
        min-height: 38px;
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

@endsection


@section('content')

<div class="container-xxl">

    {{-- =====================================================
        BREADCRUMB
    ====================================================== --}}

    <div class="network-breadcrumb mb-4">

        <a href="{{ route('user-page.home') }}">

            <i class="ki-duotone ki-home-2">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>

            <span>Beranda</span>

        </a>


        <span class="mx-2 text-muted">
            ›
        </span>


        <a href="{{ route('user-page.training.index') }}">

            <span>Pelatihan</span>

        </a>


        <span class="mx-2 text-muted">
            ›
        </span>


        <span class="active">
            Detail Pelatihan
        </span>

    </div>


    <div class="row g-4">


        {{-- =================================================
            SIDEBAR KIRI
        ================================================== --}}

        <div class="d-none d-lg-block col-lg-2">
        </div>


        {{-- =================================================
            CONTENT
        ================================================== --}}

        <div class="col-12 col-lg-8">

            <div class="training-detail-wrapper">


                {{-- BACK --}}

                <a
                    href="{{ route('user-page.training.index') }}"
                    class="training-back">

                    <i class="ki-duotone ki-arrow-left"></i>

                    Kembali ke Pelatihan

                </a>


                {{-- =================================================
                    HEADER TRAINING
                ================================================== --}}

                <div class="training-detail-card training-header-card">


                    <div class="training-header">


                        {{-- POSTER --}}

                        <div class="training-poster">

                            @if($data->poster)

                                <img
                                    src="{{ asset('storage/' . $data->poster) }}"
                                    alt="{{ $data->title }}">

                            @else

                                <i class="ki-duotone ki-teacher"></i>

                            @endif

                        </div>


                        {{-- CONTENT --}}

                        <div class="training-header-content">


                            <div class="training-title-row">

                                <h1>
                                    {{ $data->title ?? '-' }}
                                </h1>

                            </div>


                            <div class="training-provider-name">

                                {{ $data->provider ?? '-' }}

                            </div>


                            <div class="training-meta">


                                @if($data->city)

                                    <span>

                                        <i class="ki-duotone ki-geolocation"></i>

                                        {{ $data->city }}

                                    </span>

                                @endif


                                @if($data->training_mode)

                                    <span>

                                        <i class="ki-duotone ki-monitor"></i>

                                        {{ ucfirst($data->training_mode) }}

                                    </span>

                                @endif


                                @if($data->created_at)

                                    <span>

                                        <i class="ki-duotone ki-calendar"></i>

                                        Diposting
                                        {{ $data->created_at->diffForHumans() }}

                                    </span>

                                @endif

                            </div>


                            <div class="training-badges">


                                @if($data->category)

                                    <span class="training-badge primary">

                                        {{ $data->category }}

                                    </span>

                                @endif


                                @if($data->level)

                                    <span class="training-badge">

                                        {{ $data->level }}

                                    </span>

                                @endif


                                @if($data->is_free)

                                    <span class="training-badge success">

                                        Gratis

                                    </span>

                                @else

                                    <span class="training-badge">

                                        Berbayar

                                    </span>

                                @endif


                                @if($data->is_certificate)

                                    <span class="training-badge primary">

                                        <i class="ki-duotone ki-medal-star"></i>

                                        Bersertifikat

                                    </span>

                                @endif


                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                        SUMMARY
                    ================================================== --}}

                    <div class="training-summary">


                        <div class="training-summary-item">

                            <span>
                                Durasi
                            </span>

                            <strong>

                                {{ $data->duration_day ?: '-' }}

                                <small>
                                    Hari
                                </small>

                            </strong>

                        </div>


                        <div class="training-summary-item">

                            <span>
                                Biaya
                            </span>

                            <strong>

                                @if($data->is_free)

                                    Gratis

                                @elseif($data->price)

                                    Rp {{ number_format((float)$data->price, 0, ',', '.') }}

                                @else

                                    -

                                @endif

                            </strong>

                        </div>


                        <div class="training-summary-item">

                            <span>
                                Total JP
                            </span>

                            <strong>

                                {{ $data->total_jp ?: '-' }}

                                @if($data->total_jp)
                                    <small>JP</small>
                                @endif

                            </strong>

                        </div>


                    </div>


                    {{-- =================================================
                        QUOTA
                    ================================================== --}}

                    @php

                        $quota = (int) ($data->quota ?? 0);

                        $registered = (int) ($data->registered ?? 0);

                        $percentage = $quota > 0
                            ? min(100, round(($registered / $quota) * 100))
                            : 0;

                    @endphp


                    @if($quota > 0)

                        <div class="training-quota">


                            <div class="training-quota-header">

                                <span>

                                    Peserta

                                    <strong>
                                        {{ $registered }}/{{ $quota }}
                                    </strong>

                                </span>


                                <span>
                                    {{ $percentage }}% terisi
                                </span>

                            </div>


                            <div class="training-progress">

                                <div
                                    class="training-progress-bar"
                                    style="width: {{ $percentage }}%">
                                </div>

                            </div>

                        </div>

                    @endif


                    {{-- =================================================
                        ACTION
                    ================================================== --}}

                    <div class="training-header-action">


                        @if($quota > 0 && $registered >= $quota)

                            <button
                                type="button"
                                class="btn-training-register"
                                disabled>

                                <i class="ki-duotone ki-people me-1"></i>

                                Kuota Penuh

                            </button>

                        @else

                            <button
                                type="button"
                                class="btn-training-register"
                                onclick="registerTraining('{{ $data->uuid }}')">

                                <i class="ki-duotone ki-user-tick me-1"></i>

                                Daftar Pelatihan

                            </button>

                        @endif


                        <button
                            type="button"
                            class="btn-training-share"
                            onclick="shareTraining()">

                            <i class="ki-duotone ki-share"></i>

                            Bagikan

                        </button>


                    </div>


                </div>


                {{-- =================================================
                    TENTANG PELATIHAN
                ================================================== --}}

                @if($data->description)

                    <div class="training-detail-card">

                        <div class="training-detail-title">

                            TENTANG PELATIHAN

                        </div>


                        <div class="training-detail-text">

                            {!! nl2br(e($data->description)) !!}

                        </div>

                    </div>

                @endif


                {{-- =================================================
                    JADWAL & PELAKSANAAN
                ================================================== --}}

                <div class="training-detail-card">

                    <div class="training-detail-title">

                        JADWAL & PELAKSANAAN

                    </div>


                    <div class="training-info-grid">


                        @if($data->start_date)

                            <div class="training-info-item">

                                <small>
                                    TANGGAL MULAI
                                </small>

                                <strong>

                                    {{ \Carbon\Carbon::parse($data->start_date)
                                        ->translatedFormat('d M Y') }}

                                </strong>

                            </div>

                        @endif


                        @if($data->end_date)

                            <div class="training-info-item">

                                <small>
                                    TANGGAL SELESAI
                                </small>

                                <strong>

                                    {{ \Carbon\Carbon::parse($data->end_date)
                                        ->translatedFormat('d M Y') }}

                                </strong>

                            </div>

                        @endif


                        @if($data->duration_day)

                            <div class="training-info-item">

                                <small>
                                    DURASI
                                </small>

                                <strong>

                                    {{ $data->duration_day }} Hari

                                </strong>

                            </div>

                        @endif


                        @if($data->total_jp)

                            <div class="training-info-item">

                                <small>
                                    TOTAL JAM PELAJARAN
                                </small>

                                <strong>

                                    {{ $data->total_jp }} JP

                                </strong>

                            </div>

                        @endif


                        @if($data->training_mode)

                            <div class="training-info-item">

                                <small>
                                    MODE PELATIHAN
                                </small>

                                <strong>

                                    {{ ucfirst($data->training_mode) }}

                                </strong>

                            </div>

                        @endif


                    </div>

                </div>


                {{-- =================================================
                    LOKASI
                ================================================== --}}

                @if(
                    $data->training_mode != 'online' &&
                    (
                        $data->province ||
                        $data->city ||
                        $data->district ||
                        $data->village ||
                        $data->address
                    )
                )

                    <div class="training-detail-card">

                        <div class="training-detail-title">

                            LOKASI PELATIHAN

                        </div>


                        <div class="training-detail-list">


                            @if($data->province || $data->city)

                                <div class="training-detail-list-item">

                                    <span class="training-icon">

                                        <i class="ki-duotone ki-geolocation"></i>

                                    </span>

                                    <span>

                                        @if($data->city)
                                            {{ $data->city }}
                                        @endif

                                        @if($data->province)
                                            @if($data->city), @endif
                                            {{ $data->province }}
                                        @endif

                                    </span>

                                </div>

                            @endif


                            @if($data->district || $data->village)

                                <div class="training-detail-list-item">

                                    <span class="training-icon">

                                        <i class="ki-duotone ki-map"></i>

                                    </span>

                                    <span>

                                        @if($data->village)
                                            {{ $data->village }}
                                        @endif

                                        @if($data->district)

                                            @if($data->village), @endif

                                            {{ $data->district }}

                                        @endif

                                    </span>

                                </div>

                            @endif


                            @if($data->address)

                                <div class="training-detail-list-item">

                                    <span class="training-icon">

                                        <i class="ki-duotone ki-geolocation-home"></i>

                                    </span>

                                    <span>

                                        {{ $data->address }}

                                    </span>

                                </div>

                            @endif


                            @if($data->google_map)

                                <div class="training-detail-list-item">

                                    <span class="training-icon">

                                        <i class="ki-duotone ki-map"></i>

                                    </span>

                                    <span>

                                        <a
                                            href="{{ $data->google_map }}"
                                            target="_blank"
                                            style="color:#ffb000;text-decoration:none;">

                                            Lihat lokasi di Google Maps

                                            <i class="ki-duotone ki-arrow-up-right"></i>

                                        </a>

                                    </span>

                                </div>

                            @endif


                        </div>

                    </div>

                @endif


                {{-- =================================================
                    MEETING ONLINE
                ================================================== --}}

                @if(
                    $data->training_mode != 'offline' &&
                    $data->meeting_url
                )

                    <div class="training-detail-card">

                        <div class="training-detail-title">

                            PELATIHAN ONLINE

                        </div>


                        <div class="training-detail-list">

                            <div class="training-detail-list-item">

                                <span class="training-icon">

                                    <i class="ki-duotone ki-video"></i>

                                </span>

                                <span>

                                    Pelatihan dilaksanakan secara online.

                                    <a
                                        href="{{ $data->meeting_url }}"
                                        target="_blank"
                                        style="color:#ffb000;text-decoration:none;">

                                        Bergabung ke Meeting

                                    </a>

                                </span>

                            </div>

                        </div>

                    </div>

                @endif


                {{-- =================================================
                    SILABUS
                ================================================== --}}

                @php

                    $syllabus = [];

                    if ($data->syllabus) {

                        $decoded = json_decode(
                            $data->syllabus,
                            true
                        );

                        $syllabus = is_array($decoded)
                            ? $decoded
                            : preg_split(
                                '/\r\n|\r|\n/',
                                $data->syllabus
                            );

                    }

                @endphp


                @if(count($syllabus))

                    <div class="training-detail-card">

                        <div class="training-detail-title">

                            SILABUS & MATERI PELATIHAN

                        </div>


                        <div class="training-detail-list">

                            @foreach($syllabus as $index => $item)

                                @if(is_string($item) && trim($item))

                                    <div class="training-detail-list-item">

                                        <span class="training-icon">

                                            {{ $index + 1 }}

                                        </span>

                                        <span>

                                            {{ trim($item) }}

                                        </span>

                                    </div>

                                @endif

                            @endforeach

                        </div>

                    </div>

                @endif


                {{-- =================================================
                    PERSYARATAN
                ================================================== --}}

                @php

                    $requirements = [];

                    if ($data->requirements) {

                        $decoded = json_decode(
                            $data->requirements,
                            true
                        );

                        $requirements = is_array($decoded)
                            ? $decoded
                            : preg_split(
                                '/\r\n|\r|\n/',
                                $data->requirements
                            );

                    }

                @endphp


                @if(count($requirements))

                    <div class="training-detail-card">

                        <div class="training-detail-title">

                            PERSYARATAN PENDAFTARAN

                        </div>


                        <div class="training-detail-list">

                            @foreach($requirements as $item)

                                @if(is_string($item) && trim($item))

                                    <div class="training-detail-list-item">

                                        <span class="training-icon">

                                            <i class="ki-duotone ki-check"></i>

                                        </span>

                                        <span>

                                            {{ trim($item) }}

                                        </span>

                                    </div>

                                @endif

                            @endforeach

                        </div>

                    </div>

                @endif


                {{-- =================================================
                    INSTRUKTUR
                ================================================== --}}

                @if($data->instructor)

                    <div class="training-detail-card">

                        <div class="training-detail-title">

                            INSTRUKTUR

                        </div>


                        <div class="training-instructor">

                            <div class="training-instructor-avatar">

                                <i class="ki-duotone ki-user"></i>

                            </div>


                            <div>

                                <strong>

                                    {{ $data->instructor }}

                                </strong>

                                <span>
                                    Instruktur Pelatihan
                                </span>

                            </div>

                        </div>

                    </div>

                @endif


                {{-- =================================================
                    SERTIFIKAT
                ================================================== --}}

                @if($data->is_certificate)

                    <div class="training-detail-card">

                        <div class="training-detail-title">

                            SERTIFIKAT

                        </div>


                        <div class="training-certificate-box">

                            <div class="training-certificate-icon">

                                <i class="ki-duotone ki-medal-star"></i>

                            </div>


                            <div>

                                <strong>

                                    {{ $data->certificate_name
                                        ?: 'Sertifikat Pelatihan' }}

                                </strong>


                                <span>

                                    @if($data->certificate_validity)

                                        Berlaku
                                        {{ $data->certificate_validity }}

                                    @else

                                        Sertifikat diterbitkan setelah
                                        menyelesaikan pelatihan.

                                    @endif

                                </span>

                            </div>

                        </div>

                    </div>

                @endif


                {{-- =================================================
                    TAG
                ================================================== --}}

                @php

                    $tags = [];

                    if ($data->tags) {

                        $decoded = json_decode(
                            $data->tags,
                            true
                        );

                        $tags = is_array($decoded)
                            ? $decoded
                            : preg_split(
                                '/\r\n|\r|\n|,/',
                                $data->tags
                            );

                    }

                @endphp


                @if(count($tags))

                    <div class="training-detail-card">

                        <div class="training-detail-title">

                            TAG PELATIHAN

                        </div>


                        <div class="training-tags">

                            @foreach($tags as $tag)

                                @if(is_string($tag) && trim($tag))

                                    <span class="training-tag">

                                        #{{ trim($tag) }}

                                    </span>

                                @endif

                            @endforeach

                        </div>

                    </div>

                @endif


                {{-- =================================================
                    STATISTIK
                ================================================== --}}

                <div class="training-detail-card">

                    <div class="training-detail-title">

                        STATISTIK PELATIHAN

                    </div>


                    <div class="training-statistics">


                        <div>

                            <strong>
                                {{ $data->total_clicked ?? 0 }}
                            </strong>

                            <span>
                                DILIHAT
                            </span>

                        </div>


                        <div>

                            <strong>
                                {{ $data->registered ?? 0 }}
                            </strong>

                            <span>
                                PESERTA
                            </span>

                        </div>


                    </div>

                </div>


                {{-- =================================================
                    PENYELENGGARA
                ================================================== --}}

                <div class="training-detail-card">

                    <div class="training-detail-title">

                        PENYELENGGARA

                    </div>


                    <div class="training-provider">

                        <div class="training-provider-icon">

                            <i class="ki-duotone ki-office-bag"></i>

                        </div>


                        <div>

                            <strong>

                                {{ $data->provider ?? '-' }}

                            </strong>

                            <span>

                                Penyelenggara Pelatihan

                            </span>

                        </div>

                    </div>


                    @if($data->city || $data->province)

                        <div
                            style="
                                margin-top:12px;
                                color:#7c89a2;
                                font-size:10px;
                            "
                        >

                            <i class="ki-duotone ki-geolocation"></i>

                            {{ $data->city }}

                            @if($data->province)
                                , {{ $data->province }}
                            @endif

                        </div>

                    @endif

                </div>


                {{-- =================================================
                    BOTTOM CTA
                ================================================== --}}

                <div class="training-detail-card training-footer">


                    <div>

                        <strong>
                            Tertarik mengikuti pelatihan ini?
                        </strong>


                        @if($data->start_date)

                            <span>

                                Mulai:

                                <b>

                                    {{ \Carbon\Carbon::parse($data->start_date)
                                        ->translatedFormat('d M Y') }}

                                </b>

                            </span>

                        @endif

                    </div>


                    @if($quota > 0 && $registered >= $quota)

                        <button
                            type="button"
                            class="btn-training-register"
                            disabled>

                            Kuota Penuh

                        </button>

                    @else

                        <button
                            type="button"
                            class="btn-training-register"
                            onclick="registerTraining('{{ $data->uuid }}')">

                            <i class="ki-duotone ki-user-tick me-1"></i>

                            Daftar Pelatihan

                        </button>

                    @endif


                </div>


            </div>

        </div>


        {{-- =================================================
            SIDEBAR KANAN
        ================================================== --}}

        <div class="d-none d-lg-block col-lg-2">
        </div>


    </div>

</div>

@endsection


@section('js')

<script>

function shareTraining()
{
    const title = @json($data->title);

    const url = window.location.href;


    if (navigator.share) {

        navigator.share({
            title: title,
            text: 'Lihat pelatihan ' + title,
            url: url
        });

    } else {

        navigator.clipboard.writeText(url);

        Swal.fire({
            icon: 'success',
            title: 'Link Disalin',
            text: 'Link pelatihan berhasil disalin.',
            timer: 1500,
            showConfirmButton: false
        });

    }
}


function registerTraining(uuid)
{
    Swal.fire({

        title: 'Daftar Pelatihan?',

        text: 'Apakah Anda yakin ingin mendaftar pelatihan ini?',

        icon: 'question',

        showCancelButton: true,

        confirmButtonText: 'Ya, Daftar',

        cancelButtonText: 'Batal',

        reverseButtons: true

    }).then((result) => {

        if (!result.isConfirmed) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Endpoint pendaftaran
        |--------------------------------------------------------------------------
        |
        | Sesuaikan route ketika fitur registrasi training sudah dibuat.
        |
        */

        $.ajax({

            url: `/user-page/training/${uuid}/register`,

            type: 'POST',

            data: {

                _token: "{{ csrf_token() }}"

            },

            success: function(response) {

                if (response.success) {

                    Swal.fire({

                        icon: 'success',

                        title: 'Berhasil',

                        text: response.message
                            ?? 'Pendaftaran pelatihan berhasil.',

                        timer: 1500,

                        showConfirmButton: false

                    }).then(() => {

                        location.reload();

                    });

                }

            },

            error: function(xhr) {

                Swal.fire({

                    icon: 'error',

                    title: 'Gagal',

                    text: xhr.responseJSON?.message
                        ?? 'Terjadi kesalahan saat mendaftar pelatihan.'

                });

            }

        });

    });
}

</script>

@endsection