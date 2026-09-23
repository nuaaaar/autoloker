<style>

    /* =========================================================
       WRAPPER
    ========================================================= */

    .subscription-page{
        width:100%;
    }


    /* =========================================================
       HEADER
    ========================================================= */

    .subscription-header{
        text-align:center;
        margin-bottom:28px;
    }

    .subscription-title{
        color:#f1f4fb;

        font-size:20px;
        font-weight:700;

        margin-bottom:7px;
    }

    .subscription-subtitle{
        color:#8fa1bd;

        font-size:12px;
        font-weight:500;

        margin:0;
    }


    /* =========================================================
       PACKAGE GRID
    ========================================================= */

    .subscription-packages{
        display:grid;

        grid-template-columns:repeat(3, 1fr);

        gap:14px;

        margin-bottom:28px;
    }


    /* =========================================================
       PACKAGE CARD
    ========================================================= */

    .subscription-card{

        position:relative;

        display:flex;
        flex-direction:column;

        min-height:400px;

        padding:20px;

        background:#11192d;

        border:1px solid #27334d;

        border-radius:17px;

        overflow:hidden;

        transition:.25s;
    }

    .subscription-card:hover{

        transform:translateY(-2px);

        border-color:#3b4967;

    }


    /* =========================================================
       PROFESSIONAL / PREMIUM
    ========================================================= */

    .subscription-card.featured{

        border-color:#8a6410;

        box-shadow:
            0 0 0 1px rgba(232,164,1,.08);

    }

    .subscription-card.featured::before{

        content:"";

        position:absolute;

        top:0;
        left:0;
        right:0;

        height:3px;

        background:#e8a401;

    }


    .subscription-card.premium::before{

        content:"";

        position:absolute;

        top:0;
        left:0;
        right:0;

        height:3px;

        background:#ffb800;

    }


    /* =========================================================
       PACKAGE NAME
    ========================================================= */

    .subscription-package-name{

        color:#8ea1bd;

        font-size:11px;
        font-weight:600;

        letter-spacing:1.3px;

        margin-bottom:8px;
    }

    .subscription-card.featured .subscription-package-name,
    .subscription-card.premium .subscription-package-name{

        color:#f2b000;

    }


    /* =========================================================
       POPULAR BADGE
    ========================================================= */

    .subscription-popular{

        position:absolute;

        top:13px;
        right:13px;

        padding:5px 11px;

        background:#f3ac00;

        color:#111827;

        border-radius:20px;

        font-size:10px;
        font-weight:800;

        line-height:1;
    }


    /* =========================================================
       PRICE
    ========================================================= */

    .subscription-price-wrapper{

        display:flex;

        align-items:baseline;

        gap:5px;

        margin-bottom:10px;
    }

    .subscription-price{

        color:#e9edf6;

        font-size:25px;

        font-weight:800;

        line-height:1;
    }

    .subscription-period{

        color:#8497b4;

        font-size:11px;
        font-weight:500;
    }


    /* =========================================================
       DESCRIPTION
    ========================================================= */

    .subscription-description{

        color:#8ea1bd;

        font-size:11px;

        font-weight:500;

        line-height:1.65;

        min-height:54px;

        margin-bottom:15px;
    }


    /* =========================================================
       FEATURE BOX
    ========================================================= */

    .subscription-features{

        padding:10px 12px;

        background:#151e34;

        border:1px solid #2b3852;

        border-radius:14px;

        margin-bottom:14px;
    }

    .subscription-card.featured .subscription-features,
    .subscription-card.premium .subscription-features{

        border-color:#4c4127;

    }


    .subscription-feature{

        display:flex;

        align-items:center;

        gap:8px;

        min-height:29px;

        color:#91a2bd;

        font-size:11px;

        font-weight:500;
    }

    .subscription-feature i{

        width:16px;

        color:#7d91b0;

        /* font-size:13px; */

        flex-shrink:0;

    }

    .subscription-feature-value{

        margin-left:auto;

        color:#8ea0bc;

        font-size:12px;

        font-weight:700;

        white-space:nowrap;
    }

    .subscription-feature-value.highlight{

        color:#ffb800;

    }

    .highlight {
        background: transparent !important;
        padding: 0px;
    }

    .subscription-feature-value.unlimited{

        color:#ffb800;

        font-weight:800;

    }


    /* CHECK ICON */

    .subscription-check{

        margin-left:auto;

        color:#00e5a0;

        font-size:17px;

        line-height:1;

    }


    /* DISABLED */

    .subscription-disabled{

        display:flex;

        align-items:center;

        gap:8px;

        min-height:29px;

        color:#91a2bd;

        font-size:11px;

        font-weight:500;

    }


    /* =========================================================
       BUTTON
    ========================================================= */

    .subscription-button{

        width:100%;

        margin-top:auto;

        height:43px;

        display:flex;

        align-items:center;
        justify-content:center;

        border:none;

        border-radius:13px;

        background:#f2aa00;

        color:#111827;

        font-size:13px;

        font-weight:800;

        text-decoration:none;

        transition:.25s;
    }

    .subscription-button:hover{

        background:#ffc126;

        color:#111827;

        transform:translateY(-1px);

    }


    .subscription-button.disabled{

        background:#11192d;

        border:1px solid #202d46;

        color:#667792;

        cursor:default;

        pointer-events:none;

    }


    /* =========================================================
       CURRENT PACKAGE
    ========================================================= */

    .current-subscription{

        padding:20px;

        background:#11192d;

        border:1px solid #27334d;

        border-radius:17px;

        margin-bottom:28px;
    }


    .current-subscription-label{

        color:#8da0bd;

        font-size:11px;

        font-weight:600;

        letter-spacing:1.5px;

        margin-bottom:18px;
    }


    .current-subscription-top{

        display:flex;

        align-items:flex-start;

        justify-content:space-between;

        gap:20px;

        margin-bottom:14px;
    }


    .current-subscription-name{

        color:#91a3bd;

        font-size:17px;

        font-weight:700;

        margin-bottom:4px;
    }


    .current-subscription-description{

        color:#8a9db8;

        font-size:11px;

        font-weight:500;

        line-height:1.5;

        margin:0;
    }


    .current-subscription-badge{

        flex-shrink:0;

        padding:6px 12px;

        background:#18223a;

        border:1px solid #2a3855;

        color:#8ea1bd;

        border-radius:20px;

        font-size:10px;

        font-weight:700;
    }


    .current-subscription-features{

        display:grid;

        grid-template-columns:repeat(2, 1fr);

        column-gap:30px;

        row-gap:8px;
    }


    .current-feature{

        display:flex;

        align-items:center;

        gap:8px;

        color:#8fa1bc;

        font-size:11px;

        font-weight:500;
    }

    .current-feature i{

        width:15px;

        color:#7e91ae;

        font-size:13px;

    }

    .current-feature strong{

        color:#aebbd0;

        font-weight:700;

    }

    .current-feature .cross{

        color:#29344a;

    }


    /* =========================================================
       FAQ
    ========================================================= */

    .faq-section {
        margin-top: 2px;
    }

    @media (max-width: 991px) {
        .faq-section {
            margin-bottom: 20%;
        }
    }


    .faq-title{

        color:#e8edf6;

        font-size:14px;

        font-weight:700;

        margin-bottom:10px;

    }


    .faq-item{

        background:#11192d;

        border:1px solid #27334d;

        border-radius:15px;

        margin-bottom:8px;

        overflow:hidden;

        transition:.25s;
    }


    .faq-item:hover{

        border-color:#4b5a78;

    }


    .faq-button{

        width:100%;

        padding:15px 17px;

        display:flex;

        align-items:center;

        justify-content:space-between;

        gap:15px;

        background:transparent;

        border:none;

        color:#dfe5ef;

        text-align:left;

        font-size:12px;

        font-weight:600;

        line-height:1.4;
    }


    .faq-button:hover{

        color:#fff;

    }


    .faq-button i{

        color:#7f91ad;

        font-size:13px;

        flex-shrink:0;

        transition:.25s;
    }


    .faq-button:not(.collapsed){

        color:#e8a401;

    }

    .faq-button:not(.collapsed) i{

        transform:rotate(180deg);

        color:#e8a401;

    }


    .faq-answer{

        padding:0 17px 15px;

        color:#8c9db7;

        font-size:11px;

        line-height:1.65;

    }


    /* =========================================================
       LIGHT MODE
    ========================================================= */

    [data-bs-theme="light"] .subscription-title{
        color:#1e293b;
    }

    [data-bs-theme="light"] .subscription-subtitle{
        color:#64748b;
    }


    [data-bs-theme="light"] .subscription-card{

        background:#ffffff;

        border-color:#e2e8f0;

    }

    [data-bs-theme="light"] .subscription-card:hover{

        border-color:#cbd5e1;

    }


    [data-bs-theme="light"] .subscription-card.featured,
    [data-bs-theme="light"] .subscription-card.premium{

        border-color:#d8b14a;

    }


    [data-bs-theme="light"] .subscription-package-name{

        color:#64748b;

    }

    [data-bs-theme="light"] .subscription-card.featured .subscription-package-name,
    [data-bs-theme="light"] .subscription-card.premium .subscription-package-name{

        color:#c68a00;

    }


    [data-bs-theme="light"] .subscription-price{

        color:#1e293b;

    }

    [data-bs-theme="light"] .subscription-period{

        color:#64748b;

    }

    [data-bs-theme="light"] .subscription-description{

        color:#64748b;

    }


    [data-bs-theme="light"] .subscription-features{

        background:#f8fafc;

        border-color:#e2e8f0;

    }

    [data-bs-theme="light"] .subscription-card.featured .subscription-features,
    [data-bs-theme="light"] .subscription-card.premium .subscription-features{

        border-color:#eadcae;

    }


    [data-bs-theme="light"] .subscription-feature{

        color:#64748b;

    }

    [data-bs-theme="light"] .subscription-feature i{

        color:#64748b;

    }

    [data-bs-theme="light"] .subscription-feature-value{

        color:#475569;

    }


    [data-bs-theme="light"] .subscription-button{

        background:#f2aa00;

        color:#111827;

    }

    [data-bs-theme="light"] .subscription-button:hover{

        background:#ffc126;

    }


    [data-bs-theme="light"] .subscription-button.disabled{

        background:#f8fafc;

        border-color:#e2e8f0;

        color:#94a3b8;

    }


    [data-bs-theme="light"] .current-subscription{

        background:#ffffff;

        border-color:#e2e8f0;

    }

    [data-bs-theme="light"] .current-subscription-label{

        color:#64748b;

    }

    [data-bs-theme="light"] .current-subscription-name{

        color:#334155;

    }

    [data-bs-theme="light"] .current-subscription-description{

        color:#64748b;

    }

    [data-bs-theme="light"] .current-subscription-badge{

        background:#f8fafc;

        border-color:#e2e8f0;

        color:#64748b;

    }

    [data-bs-theme="light"] .current-feature{

        color:#64748b;

    }

    [data-bs-theme="light"] .current-feature i{

        color:#64748b;

    }

    [data-bs-theme="light"] .current-feature strong{

        color:#475569;

    }

    [data-bs-theme="light"] .current-feature .cross{

        color:#cbd5e1;

    }


    [data-bs-theme="light"] .faq-title{

        color:#1e293b;

    }

    [data-bs-theme="light"] .faq-item{

        background:#ffffff;

        border-color:#e2e8f0;

    }

    [data-bs-theme="light"] .faq-item:hover{

        border-color:#cbd5e1;

    }

    [data-bs-theme="light"] .faq-button{

        color:#334155;

    }

    [data-bs-theme="light"] .faq-button:hover{

        color:#1e293b;

    }

    [data-bs-theme="light"] .faq-button:not(.collapsed){

        color:#c68a00;

    }

    [data-bs-theme="light"] .faq-answer{

        color:#64748b;

    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media(max-width:991px){

        .subscription-title{

            font-size:18px;

        }

        .subscription-subtitle{

            font-size:11px;

        }

        .subscription-packages{

            grid-template-columns:1fr;

            gap:12px;

        }

        .subscription-card{

            min-height:auto;

            padding:18px;

        }

        .subscription-description{

            min-height:auto;

        }

        .subscription-button{

            margin-top:12px;

        }

    }


    @media(max-width:575px){

        .subscription-header{

            margin-bottom:22px;

        }

        .subscription-title{

            font-size:17px;

        }

        .subscription-price{

            font-size:23px;

        }

        .subscription-card{

            border-radius:15px;

        }

        .current-subscription{

            padding:17px;

        }

        .current-subscription-top{

            align-items:flex-start;

        }

        .current-subscription-features{

            grid-template-columns:1fr;

            row-gap:9px;

        }

        .faq-button{

            padding:14px;

            font-size:11px;

        }

        .faq-answer{

            padding:0 14px 14px;

            font-size:10px;

        }

    }

</style>


<div class="subscription-page">


    <!-- =====================================================
         HEADER
    ====================================================== -->

    <div class="subscription-header">

        <h2 class="subscription-title">
            Paket Berlangganan
        </h2>

        <p class="subscription-subtitle">
            Pilih paket yang sesuai dengan kebutuhan kariermu
        </p>

    </div>


    <!-- =====================================================
        PACKAGE LIST
    ====================================================== -->

    {{-- =====================================================
     PACKAGE LIST
====================================================== --}}

<div class="subscription-packages">

    @forelse ($subscriptions as $subscription)

        @php
            /*
            |--------------------------------------------------------------------------
            | BASIC PACKAGE
            |--------------------------------------------------------------------------
            */

            $slug = strtolower(trim($subscription->slug ?? ''));

            $isBasic = $slug === 'dasar';

            /*
            |--------------------------------------------------------------------------
            | PACKAGE STATUS
            |--------------------------------------------------------------------------
            */

            $isCurrent = $currentSubscription
                && (int) $currentSubscription->master_subscription_id
                    === (int) $subscription->id;

            /*
            |--------------------------------------------------------------------------
            | PACKAGE STYLE
            |--------------------------------------------------------------------------
            */

            $isFeatured = in_array($slug, [
                'profesional',
                'professional',
            ]);

            $isPremium = $slug === 'premium';

            /*
            |--------------------------------------------------------------------------
            | PACKAGE NAME
            |--------------------------------------------------------------------------
            */

            $packageName = strtoupper(
                $subscription->name ?? ''
            );

            /*
            |--------------------------------------------------------------------------
            | PRICE
            |--------------------------------------------------------------------------
            */

            $isFree = (float) $subscription->price <= 0;

            /*
            |--------------------------------------------------------------------------
            | DURATION
            |--------------------------------------------------------------------------
            */

            $durationText = '';

            if ($subscription->duration) {

                switch ($subscription->duration_type) {

                    case 'day':

                        $durationText =
                            $subscription->duration . ' hari';

                        break;

                    case 'month':

                        $durationText =
                            $subscription->duration . ' bulan';

                        break;

                    case 'year':

                        $durationText =
                            $subscription->duration . ' tahun';

                        break;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | FEATURES
            |--------------------------------------------------------------------------
            */

            $features = is_array($subscription->features)
                ? $subscription->features
                : [];


            /*
            |--------------------------------------------------------------------------
            | JOB VACANCY
            |--------------------------------------------------------------------------
            */

            $jobVacancy = $features['job_vacancy'] ?? [];

            $jobVacancyEnabled =
                (bool) ($jobVacancy['enabled'] ?? false);

            $jobVacancyLimit =
                $jobVacancy['limit'] ?? 0;


            /*
            |--------------------------------------------------------------------------
            | TRAINING
            |--------------------------------------------------------------------------
            */

            $training = $features['training'] ?? [];

            $trainingEnabled =
                (bool) ($training['enabled'] ?? false);

            $trainingLimit =
                $training['limit'] ?? 0;

        @endphp


        {{-- =================================================
             PACKAGE CARD
        ================================================== --}}

        <div class="subscription-card
            {{ $isFeatured ? 'featured' : '' }}
            {{ $isPremium ? 'premium' : '' }}">


            {{-- =================================================
                 POPULAR
            ================================================== --}}

            @if ($isFeatured)

                <span class="subscription-popular">
                    TERPOPULER
                </span>

            @endif


            {{-- =================================================
                 PACKAGE NAME
            ================================================== --}}

            <div class="subscription-package-name">

                {{ $packageName }}

            </div>


            {{-- =================================================
                 PRICE
            ================================================== --}}

            <div class="subscription-price-wrapper">

                @if ($isFree)

                    <span class="subscription-price">
                        Gratis
                    </span>

                @else

                    <span class="subscription-price">

                        Rp {{ number_format(
                            $subscription->price,
                            0,
                            ',',
                            '.'
                        ) }}

                    </span>


                    @if ($durationText)

                        <span class="subscription-period">

                            /{{ $durationText }}

                        </span>

                    @endif

                @endif

            </div>


            {{-- =================================================
                 DESCRIPTION
            ================================================== --}}

            <div class="subscription-description">

                {{ $subscription->description }}

            </div>


            {{-- =================================================
                 FEATURES
            ================================================== --}}

            <div class="subscription-features">


                {{-- =================================================
                     JOB VACANCY
                ================================================== --}}

                <div class="subscription-feature">

                    <i class="ki-duotone ki-briefcase">

                        <span class="path1"></span>
                        <span class="path2"></span>

                    </i>


                    <span>
                        Lamaran aktif
                    </span>


                    @if (!$jobVacancyEnabled)

                        <i class="ki-duotone ki-cross subscription-check"></i>

                    @elseif ((int) $jobVacancyLimit === -1)

                        <span class="subscription-feature-value unlimited">

                            Tak terbatas

                        </span>

                    @else

                        <span class="subscription-feature-value
                            {{ !$isBasic ? 'highlight' : '' }}">

                            {{ $jobVacancyLimit }}

                        </span>

                    @endif

                </div>


                {{-- =================================================
                     TRAINING
                ================================================== --}}

                <div class="subscription-feature">

                    <i class="ki-duotone ki-teacher">

                        <span class="path1"></span>
                        <span class="path2"></span>

                    </i>


                    <span>
                        Pelatihan aktif
                    </span>


                    @if (!$trainingEnabled)

                        <i class="ki-duotone ki-cross subscription-check"></i>

                    @elseif ((int) $trainingLimit === -1)

                        <span class="subscription-feature-value unlimited">

                            Tak terbatas

                        </span>

                    @else

                        <span class="subscription-feature-value
                            {{ !$isBasic ? 'highlight' : '' }}">

                            {{ $trainingLimit }}

                        </span>

                    @endif

                </div>

            </div>


            {{-- =================================================
                 ACTION BUTTON
            ================================================== --}}

            @if ($isCurrent)

                {{-- CURRENT ACTIVE PACKAGE --}}

                <div class="subscription-button disabled">

                    Paket Aktif

                </div>


            @elseif ($isBasic)

                {{-- DEFAULT FREE PACKAGE --}}

                <div class="subscription-button disabled">

                    Paket Dasar

                </div>


            @else

                {{-- PAID PACKAGE --}}

                <button
                    type="button"
                    class="subscription-button btn-select-subscription"
                    data-uuid="{{ $subscription->uuid }}"
                    data-name="{{ $subscription->name }}"
                    data-price="{{ $subscription->price }}"
                >
                    Pilih Paket
                </button>

            @endif


        </div>

    @empty

        {{-- =================================================
             NO PACKAGE
        ================================================== --}}

        <div class="subscription-empty">

            <div class="subscription-empty-icon">

                <i class="ki-duotone ki-package">

                    <span class="path1"></span>
                    <span class="path2"></span>

                </i>

            </div>


            <div class="subscription-empty-title">

                Paket belum tersedia

            </div>


            <div class="subscription-empty-description">

                Belum ada paket yang tersedia untuk akun Anda.

            </div>

        </div>

    @endforelse

</div>



    {{-- =====================================================
        CURRENT SUBSCRIPTION
    ====================================================== --}}

    @php

        /*
        |--------------------------------------------------------------------------
        | CURRENT PACKAGE
        |--------------------------------------------------------------------------
        |
        | Kalau user belum punya user_subscriptions aktif,
        | maka otomatis dianggap menggunakan paket DASAR.
        |
        */

        $displaySubscription = $currentSubscription;

        if (!$displaySubscription) {

            $displaySubscription = $subscriptions
                ->first(function ($item) {

                    return strtolower(
                        trim($item->slug ?? '')
                    ) === 'dasar';

                });

        }

    @endphp

    {{-- =====================================================
        CURRENT PACKAGE
    ====================================================== --}}

    @php

        /*
        |--------------------------------------------------------------------------
        | TENTUKAN PAKET YANG DITAMPILKAN
        |--------------------------------------------------------------------------
        |
        | Jika user memiliki subscription aktif:
        |   gunakan user_subscriptions
        |
        | Jika belum:
        |   gunakan paket DASAR dari master_subscriptions
        |
        */

        $displaySubscription = $currentSubscription;

        if (!$displaySubscription) {

            $displaySubscription = $subscriptions->first(function ($subscription) {

                return strtolower(trim($subscription->slug ?? '')) === 'dasar';

            });

        }


        /*
        |--------------------------------------------------------------------------
        | JIKA PAKET TERSEDIA
        |--------------------------------------------------------------------------
        */

        if ($displaySubscription) {

            /*
            |--------------------------------------------------------------------------
            | FEATURES
            |--------------------------------------------------------------------------
            */

            if ($currentSubscription) {

                // Subscription aktif menggunakan snapshot limits
                $currentFeatures = is_array($currentSubscription->limits)
                    ? $currentSubscription->limits
                    : [];

                $currentName =
                    $currentSubscription->subscription_name;

                $currentPrice =
                    $currentSubscription->price;

                $currentDescription =
                    optional($currentSubscription->subscription)->description;

            } else {

                // User belum punya subscription
                // Gunakan features dari paket DASAR

                $currentFeatures = is_array($displaySubscription->features)
                    ? $displaySubscription->features
                    : [];

                $currentName =
                    $displaySubscription->name;

                $currentPrice =
                    $displaySubscription->price;

                $currentDescription =
                    $displaySubscription->description;

            }


            /*
            |--------------------------------------------------------------------------
            | JOB VACANCY
            |--------------------------------------------------------------------------
            */

            $currentJobVacancy =
                $currentFeatures['job_vacancy'] ?? [];

            $currentJobVacancyEnabled =
                (bool) ($currentJobVacancy['enabled'] ?? false);

            $currentJobVacancyLimit =
                $currentJobVacancy['limit'] ?? 0;


            /*
            |--------------------------------------------------------------------------
            | TRAINING
            |--------------------------------------------------------------------------
            */

            $currentTraining =
                $currentFeatures['training'] ?? [];

            $currentTrainingEnabled =
                (bool) ($currentTraining['enabled'] ?? false);

            $currentTrainingLimit =
                $currentTraining['limit'] ?? 0;

        }

    @endphp


    @if ($displaySubscription)

        <div class="current-subscription">

            {{-- =================================================
                LABEL
            ================================================== --}}

            <div class="current-subscription-label">

                PAKET SAYA SAAT INI

            </div>


            {{-- =================================================
                TOP
            ================================================== --}}

            <div class="current-subscription-top">

                <div>

                    <div class="current-subscription-name">

                        {{ strtoupper($currentName) }}

                    </div>


                    @if ($currentDescription)

                        <p class="current-subscription-description">

                            {{ $currentDescription }}

                        </p>

                    @endif

                </div>


                {{-- =================================================
                    PRICE
                ================================================== --}}

                <span class="current-subscription-badge">

                    @if ((float) $currentPrice <= 0)

                        Gratis

                    @else

                        Rp {{ number_format(
                            $currentPrice,
                            0,
                            ',',
                            '.'
                        ) }}

                    @endif

                </span>

            </div>


            {{-- =================================================
                ACTIVE PERIOD
                HANYA JIKA BENAR-BENAR MEMILIKI SUBSCRIPTION
            ================================================== --}}

            @if (
                $currentSubscription &&
                $currentSubscription->expired_at
            )

                <div class="current-subscription-period">

                    <i class="ki-duotone ki-calendar-8">

                        <span class="path1"></span>
                        <span class="path2"></span>

                    </i>

                    <span>

                        Aktif sampai

                        <strong>

                            {{ $currentSubscription->expired_at->format('d M Y') }}

                        </strong>

                    </span>

                </div>

            @endif


            {{-- =================================================
                FEATURES
            ================================================== --}}

            <div class="current-subscription-features">


                {{-- =================================================
                    JOB VACANCY / LAMARAN
                ================================================== --}}

                <div class="current-feature">

                    <i class="ki-duotone ki-briefcase">

                        <span class="path1"></span>
                        <span class="path2"></span>

                    </i>

                    <span>

                        Lamaran aktif:

                        @if (!$currentJobVacancyEnabled)

                            <strong>
                                Tidak tersedia
                            </strong>

                        @elseif ((int) $currentJobVacancyLimit === -1)

                            <strong>
                                Tak terbatas
                            </strong>

                        @else

                            <strong>
                                {{ $currentJobVacancyLimit }}
                            </strong>

                        @endif

                    </span>

                </div>


                {{-- =================================================
                    TRAINING
                ================================================== --}}

                <div class="current-feature">

                    <i class="ki-duotone ki-teacher">

                        <span class="path1"></span>
                        <span class="path2"></span>

                    </i>

                    <span>

                        Pelatihan aktif:

                        @if (!$currentTrainingEnabled)

                            <strong>
                                Tidak tersedia
                            </strong>

                        @elseif ((int) $currentTrainingLimit === -1)

                            <strong>
                                Tak terbatas
                            </strong>

                        @else

                            <strong>
                                {{ $currentTrainingLimit }}
                            </strong>

                        @endif

                    </span>

                </div>


            </div>


            {{-- =================================================
                INFO PAKET DASAR
                HANYA JIKA BELUM ADA SUBSCRIPTION
            ================================================== --}}

            @if (!$currentSubscription)

                <div class="current-subscription-note">

                    <i class="ki-duotone ki-information-2">

                        <span class="path1"></span>
                        <span class="path2"></span>

                    </i>

                    <span>

                        Anda sedang menggunakan paket dasar gratis.

                    </span>

                </div>

            @endif


        </div>

    @else

        {{-- =====================================================
            FALLBACK JIKA MASTER PAKET DASAR JUGA BELUM ADA
        ====================================================== --}}

        <div class="current-subscription">

            <div class="current-subscription-label">

                PAKET SAYA SAAT INI

            </div>

            <div class="current-subscription-top">

                <div>

                    <div class="current-subscription-name">

                        Belum Ada Paket

                    </div>

                    <p class="current-subscription-description">

                        Paket dasar belum tersedia.

                    </p>

                </div>

            </div>

        </div>

    @endif

    <!-- =====================================================
         FAQ
    ====================================================== -->

    <div class="faq-section">

        <div class="faq-title">
            Pertanyaan Umum
        </div>


        @forelse($faqs as $faq)

            <div class="faq-item">

                <button
                    class="faq-button collapsed"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#faq-{{ $faq->uuid }}"
                    aria-expanded="false"
                    aria-controls="faq-{{ $faq->uuid }}">

                    <span>
                        {{ $faq->title }}
                    </span>

                    <i class="ki-duotone ki-down">

                        <span class="path1"></span>
                        <span class="path2"></span>

                    </i>

                </button>


                <div
                    id="faq-{{ $faq->uuid }}"
                    class="collapse">

                    <div class="faq-answer">

                        {{ $faq->description }}

                    </div>

                </div>

            </div>

        @empty

            <div class="faq-item">

                <div class="faq-answer text-center py-4">

                    Belum ada pertanyaan umum.

                </div>

            </div>

        @endforelse


    </div>

</div>

{{-- =====================================================
    MODAL KONFIRMASI PILIH PAKET
====================================================== --}}

<div class="modal fade"
     id="modalSelectSubscription"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    Pilih Paket
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>

            </div>


            <div class="modal-body">

                <div class="text-center">

                    <div class="mb-4">

                        <i class="ki-duotone ki-package fs-3x text-primary">

                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>

                        </i>

                    </div>


                    <h5 class="mb-3">

                        Apakah Anda yakin?

                    </h5>


                    <p class="text-muted mb-2">

                        Anda akan memilih paket:

                    </p>


                    <div
                        id="selectedSubscriptionName"
                        class="fw-bold fs-4 mb-2">
                    </div>


                    <div
                        id="selectedSubscriptionPrice"
                        class="text-primary fw-bold">
                    </div>


                    <p class="text-muted mt-4 mb-0">

                        Setelah melanjutkan, Anda akan diarahkan
                        ke halaman pembayaran untuk menyelesaikan
                        pembelian paket.

                    </p>

                </div>

            </div>


            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-light"
                    data-bs-dismiss="modal">

                    Batal

                </button>


                <button
                    type="button"
                    id="btnConfirmSelectSubscription"
                    class="btn btn-primary">

                    Ya, Pilih Paket

                </button>

            </div>

        </div>

    </div>

</div>