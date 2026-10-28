<style>
    
    /* =========================================================
    TRAINING CARD
    ========================================================= */

    .training-card {
        overflow: hidden;
        margin-bottom: 22px;
        padding: 20px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 5px 20px rgba(15, 23, 42, 0.04);
        transition: box-shadow 0.2s ease, transform 0.2s ease;
    }

    .training-card:hover {
        box-shadow: 0 8px 26px rgba(15, 23, 42, 0.08);
    }

    .training-card-completed {
        border-color: #dbe5df;
    }

    .training-card-cancelled {
        border-color: #f1d5d5;
    }

    .training-card-top,
    .training-content {
        width: 100%;
        min-width: 0;
    }

    /* =========================================================
    BANNER / POSTER
    ========================================================= */

    .training-card-banner {
        width: 100%;
        height: 220px;
        overflow: hidden;
        margin-bottom: 20px;
        background: #f1f5f9;
        border-radius: 11px;
    }

    .training-card-banner img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    .training-card-banner-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        color: #94a3b8;
        background: linear-gradient(135deg, #f8fafc, #e2e8f0);
    }

    .training-card-banner-placeholder i {
        font-size: 42px;
    }

    /* =========================================================
    TITLE AND STATUS
    ========================================================= */

    .training-title-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 18px;
    }

    .training-title-wrapper {
        flex: 1;
        min-width: 0;
    }

    .training-title {
        margin: 0 0 8px;
        color: #182338;
        font-size: 19px;
        font-weight: 700;
        line-height: 1.5;
        overflow-wrap: anywhere;
    }

    .training-provider {
        color: #64748b;
        font-size: 13px;
        overflow-wrap: anywhere;
    }

    .training-status {
        flex-shrink: 0;
    }

    .training-status-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 11px;
        border-radius: 7px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .training-status-ongoing {
        color: #166534;
        background: #dcfce7;
    }

    .training-status-upcoming {
        color: #92400e;
        background: #fef3c7;
    }

    .training-status-completed {
        color: #475569;
        background: #e2e8f0;
    }

    .training-status-cancelled {
        color: #b91c1c;
        background: #fee2e2;
    }

    /* =========================================================
    CATEGORY, SUBCATEGORY AND MODE
    ========================================================= */

    .training-type-row {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 7px;
        margin-bottom: 10px;
    }

    .training-category,
    .training-sub-category,
    .training-mode,
    .training-tuk-badge {
        display: inline-flex;
        align-items: center;
        width: fit-content;
        max-width: 100%;
        padding: 5px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
        line-height: 1.5;
        overflow-wrap: anywhere;
    }

    .training-category {
        color: #39745a;
        background: #e8f3ed;
    }

    .training-sub-category {
        color: #475569;
        background: #f1f5f9;
    }

    .training-mode {
        color: #2563eb;
        background: #eff6ff;
    }

    .training-tuk-badge {
        color: #8a6100;
        background: #fff4d6;
    }

    /* =========================================================
    META INFORMATION
    ========================================================= */

    .training-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 12px 20px;
        margin-top: 18px;
    }

    .training-meta-item {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #64748b;
        font-size: 12px;
        line-height: 1.6;
        overflow-wrap: anywhere;
    }

    .training-meta-item i {
        flex-shrink: 0;
        font-size: 16px;
    }

    /* =========================================================
    TUK INFORMATION
    ========================================================= */

    .training-extra-info {
        display: flex;
        flex-wrap: wrap;
        gap: 8px 16px;
        margin-top: 14px;
    }

    .training-extra-info-item {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        color: #64748b;
        font-size: 12px;
        overflow-wrap: anywhere;
    }

    .training-extra-info-item i {
        flex-shrink: 0;
        font-size: 16px;
    }

    .training-extra-info-item strong {
        color: #334155;
        font-weight: 700;
    }

    /* =========================================================
    STATUS NOTICE
    ========================================================= */

    .training-upcoming-notice,
    .training-completed-notice {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 18px;
        padding: 10px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
    }

    .training-upcoming-notice {
        color: #92400e;
        background: #fffbeb;
    }

    .training-completed-notice {
        color: #475569;
        background: #f1f5f9;
    }

    .training-upcoming-notice i,
    .training-completed-notice i {
        flex-shrink: 0;
        font-size: 17px;
    }

    /* =========================================================
    BOTTOM
    ========================================================= */

    .training-bottom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        margin-top: 20px;
        padding-top: 16px;
        border-top: 1px solid #e2e8f0;
    }

    .training-registered {
        color: #64748b;
        font-size: 12px;
        line-height: 1.8;
        overflow-wrap: anywhere;
    }

    .btn-training-detail,
    .btn-search-training {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 10px 16px;
        color: #ffffff !important;
        background: #39745a;
        border: 1px solid #39745a;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none !important;
        white-space: nowrap;
        transition: background 0.2s ease;
    }

    .btn-training-detail:hover,
    .btn-search-training:hover {
        color: #ffffff !important;
        background: #2d6049;
    }

    /* =========================================================
    EMPTY STATE
    ========================================================= */

    .training-empty {
        padding: 35px 20px;
        text-align: center;
    }

    .training-empty-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 65px;
        height: 65px;
        margin: 0 auto 16px;
        color: #39745a;
        background: #e8f3ed;
        border-radius: 50%;
    }

    .training-empty-icon i {
        font-size: 30px;
    }

    .training-empty h5 {
        margin-bottom: 8px;
        color: #182338;
        font-size: 17px;
        font-weight: 700;
    }

    .training-empty-text {
        color: #64748b;
        font-size: 13px;
    }

    .training-empty .btn-search-training {
        margin-top: 18px;
    }

    /* =========================================================
    RESPONSIVE
    ========================================================= */

    @media (max-width: 767px) {
        .training-card {
            padding: 15px;
            border-radius: 12px;
        }

        .training-card-banner {
            height: 175px;
            margin-bottom: 16px;
        }

        .training-title-row {
            flex-direction: column;
            gap: 12px;
        }

        .training-status {
            order: -1;
        }

        .training-title {
            font-size: 17px;
        }

        .training-meta {
            gap: 10px 14px;
            margin-top: 15px;
        }

        .training-bottom {
            align-items: flex-start;
            flex-direction: column;
            gap: 13px;
        }

        .btn-training-detail {
            width: 100%;
        }
    }

    @media (max-width: 480px) {
        .training-card-banner {
            height: 145px;
        }

        .training-type-row {
            gap: 6px;
        }

        .training-category,
        .training-sub-category,
        .training-mode,
        .training-tuk-badge {
            font-size: 10px;
        }
    }


    /* =========================================================
    TRAINING PRICE & DISCOUNT
    ========================================================= */

    .training-price-wrapper {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 7px;
        margin-top: 6px;
    }

    .training-price-original {
        color: #94a3b8;
        font-size: 12px;
        text-decoration: line-through;
    }

    .training-price-final {
        color: #182338;
        font-size: 15px;
        font-weight: 800;
    }

    .training-discount-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 7px;
        color: #b91c1c;
        background: #fee2e2;
        border-radius: 5px;
        font-size: 10px;
        font-weight: 800;
    }

    .training-price-saving {
        width: 100%;
        color: #39745a;
        font-size: 11px;
        font-weight: 600;
    }

    .training-price-free {
        color: #39745a;
        font-size: 14px;
        font-weight: 800;
    }


</style>


@forelse($applications as $application)

    @php
        /*
        |--------------------------------------------------------------------------
        | TRAINING
        |--------------------------------------------------------------------------
        */

        $training = $application->training;

        /*
        |--------------------------------------------------------------------------
        | JIKA TRAINING SUDAH DIHAPUS
        |--------------------------------------------------------------------------
        */

        if (!$training) {
            continue;
        }

        /*
        |--------------------------------------------------------------------------
        | STATUS TRAINING
        |--------------------------------------------------------------------------
        */

        $trainingStatus = $training->status ?? null;
        $today = now()->toDateString();

        /*
        |--------------------------------------------------------------------------
        | TENTUKAN STATUS DISPLAY
        |--------------------------------------------------------------------------
        */

        if ($trainingStatus === 'running') {
            $displayStatus = 'ongoing';

        } elseif (
            $trainingStatus === 'published'
            && $training->start_date
            && $training->start_date > $today
        ) {
            $displayStatus = 'upcoming';

        } elseif (
            $trainingStatus === 'closed'
            || (
                $training->end_date
                && $training->end_date < $today
            )
        ) {
            $displayStatus = 'completed';

        } elseif ($trainingStatus === 'cancelled') {
            $displayStatus = 'cancelled';

        } else {
            $displayStatus = 'upcoming';
        }

        /*
        |--------------------------------------------------------------------------
        | STATUS MAP
        |--------------------------------------------------------------------------
        */

        $statusMap = [
            'ongoing' => [
                'label' => 'Sedang Berlangsung',
                'class' => 'training-status-ongoing',
            ],
            'upcoming' => [
                'label' => 'Akan Datang',
                'class' => 'training-status-upcoming',
            ],
            'completed' => [
                'label' => 'Selesai',
                'class' => 'training-status-completed',
            ],
            'cancelled' => [
                'label' => 'Dibatalkan',
                'class' => 'training-status-cancelled',
            ],
        ];

        $status = $statusMap[$displayStatus];

        /*
        |--------------------------------------------------------------------------
        | PROVIDER
        |--------------------------------------------------------------------------
        */

        $provider = $training->provider ?? '-';

        if (is_object($provider)) {
            $provider = $provider->name
                ?? $provider->title
                ?? '-';
        }

        /*
        |--------------------------------------------------------------------------
        | CATEGORY
        |--------------------------------------------------------------------------
        */

        $category = $training->category ?? null;

        if (is_object($category)) {
            $category = $category->name
                ?? $category->title
                ?? null;
        }

        /*
        |--------------------------------------------------------------------------
        | SUB CATEGORY
        |--------------------------------------------------------------------------
        */

        $subCategory = $training->sub_category ?? null;

        if (is_object($subCategory)) {
            $subCategory = $subCategory->name
                ?? $subCategory->title
                ?? null;
        }

        /*
        |--------------------------------------------------------------------------
        | TUK
        |--------------------------------------------------------------------------
        */

        $tuk = $training->tuk ?? null;

        if (is_object($tuk)) {
            $tuk = $tuk->name
                ?? $tuk->title
                ?? null;
        }

        /*
        |--------------------------------------------------------------------------
        | TRAINING MODE
        |--------------------------------------------------------------------------
        */

        $trainingMode = $training->training_mode ?? 'offline';

        switch ($trainingMode) {
            case 'online':
                $modeLabel = 'Online';
                break;

            case 'offline':
                $modeLabel = 'Offline';
                break;

            case 'hybrid':
                $modeLabel = 'Hybrid';
                break;

            default:
                $modeLabel = ucfirst($trainingMode);
                break;
        }

        /*
        |--------------------------------------------------------------------------
        | BANNER / POSTER
        |--------------------------------------------------------------------------
        */

        $poster = $training->poster ?? null;

        $posterUrl = null;

        if ($poster) {
            $posterUrl = \Illuminate\Support\Str::startsWith(
                $poster,
                ['http://', 'https://']
            )
                ? $poster
                : asset('storage/' . ltrim($poster, '/'));
        }

        /*
        |--------------------------------------------------------------------------
        | DATE
        |--------------------------------------------------------------------------
        */

        $startDate = $training->start_date ?? null;
        $endDate = $training->end_date ?? null;

        /*
        |--------------------------------------------------------------------------
        | LOCATION
        |--------------------------------------------------------------------------
        */

        $location = $training->address ?? null;

        /*
        |--------------------------------------------------------------------------
        | DURATION
        |--------------------------------------------------------------------------
        */

        $duration = $training->duration_day ?? null;

        /*
        |--------------------------------------------------------------------------
        | TOTAL JP
        |--------------------------------------------------------------------------
        */

        $totalJp = $training->total_jp ?? null;

        /*
        |--------------------------------------------------------------------------
        | REGISTERED DATE
        |--------------------------------------------------------------------------
        */

        $registeredDate = $application->created_at ?? null;

        /*
        |--------------------------------------------------------------------------
        | PRICE & DISCOUNT
        |--------------------------------------------------------------------------
        */

        $isFree = $training->is_free ?? false;
        $price = (float) ($training->price ?? 0);

        /*
        |--------------------------------------------------------------------------
        | DISCOUNT PERCENTAGE
        |--------------------------------------------------------------------------
        */

        $discount = (float) ($training->discount ?? 0);

        // Pastikan diskon berada pada rentang 0–100 persen.
        $discount = max(0, min(100, $discount));

        $discountAmount = $price * ($discount / 100);

        $finalPrice = max(0, $price - $discountAmount);

        $hasDiscount = $discount > 0 && $price > 0;

        /*
        |--------------------------------------------------------------------------
        | FREE TRAINING
        |--------------------------------------------------------------------------
        */

        $isFree = in_array($isFree, [true, 1, '1', 'true'], true);

        /*
        |--------------------------------------------------------------------------
        | UUID
        |--------------------------------------------------------------------------
        */

        $uuid = $training->uuid ?? null;
    @endphp

    <div class="training-card
        {{ $displayStatus === 'completed' ? 'training-card-completed' : '' }}
        {{ $displayStatus === 'cancelled' ? 'training-card-cancelled' : '' }}
    ">

        {{-- =====================================================
            BANNER / POSTER
        ====================================================== --}}

        @if($posterUrl)
            <div class="training-card-banner">
                <img
                    src="{{ $posterUrl }}"
                    alt="Banner {{ $training->title ?? 'Pelatihan' }}"
                    loading="lazy"
                    onerror="this.parentElement.style.display='none';"
                >
            </div>
        @endif

        <div class="training-card-top">

            <div class="training-content">

                {{-- =================================================
                    TITLE ROW
                ================================================== --}}

                <div class="training-title-row">

                    <div class="training-title-wrapper">

                        {{-- =================================================
                            CATEGORY + SUBCATEGORY + MODE
                        ================================================== --}}

                        <div class="training-type-row">

                            @if($category)
                                <span class="training-category">
                                    {{ $category }}
                                </span>
                            @endif

                            @if($subCategory)
                                <span class="training-sub-category">
                                    {{ $subCategory }}
                                </span>
                            @endif

                            <span class="training-mode">
                                {{ $modeLabel }}
                            </span>

                        </div>

                        {{-- =================================================
                            TITLE
                        ================================================== --}}

                        <h4 class="training-title">
                            {{ $training->title ?? '-' }}
                        </h4>

                        {{-- =================================================
                            PROVIDER
                        ================================================== --}}

                        <div class="training-provider">
                            {{ $provider }}
                        </div>

                    </div>

                    {{-- =================================================
                        STATUS
                    ================================================== --}}

                    <div class="training-status">
                        <span class="training-status-badge {{ $status['class'] }}">
                            {{ $status['label'] }}
                        </span>
                    </div>

                </div>

                {{-- =================================================
                    META
                ================================================== --}}

                <div class="training-meta">

                    {{-- DATE --}}

                    @if($startDate)
                        <span class="training-meta-item">
                            <i class="ki-duotone ki-calendar-8">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>

                            {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d M Y') }}

                            @if($endDate)
                                – {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d M Y') }}
                            @endif
                        </span>
                    @endif

                    {{-- LOCATION --}}

                    @if($location && $trainingMode !== 'online')
                        <span class="training-meta-item">
                            <i class="ki-duotone ki-geolocation">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>

                            {{ $location }}
                        </span>
                    @endif

                    {{-- DURATION --}}

                    @if($duration)
                        <span class="training-meta-item">
                            <i class="ki-duotone ki-book-open">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>

                            {{ $duration }} Hari
                        </span>
                    @endif

                    {{-- TOTAL JP --}}

                    @if($totalJp)
                        <span class="training-meta-item">
                            <i class="ki-duotone ki-time">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>

                            {{ $totalJp }} JP
                        </span>
                    @endif


                </div>

                {{-- =================================================
                    TUK
                ================================================== --}}

                @if($tuk)
                    <div class="training-extra-info">
                        <span class="training-extra-info-item">
                            <i class="ki-duotone ki-geolocation">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>

                            <span>
                                <strong>TUK:</strong>
                                {{ $tuk }}
                            </span>
                        </span>
                    </div>
                @endif

                {{-- =================================================
                    ONGOING NOTICE
                ================================================== --}}

                @if($displayStatus === 'ongoing')
                    <div class="training-upcoming-notice">
                        <i class="ki-duotone ki-time">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>

                        <span>Pelatihan sedang berlangsung</span>
                    </div>
                @endif

                {{-- =================================================
                    UPCOMING NOTICE
                ================================================== --}}

                @if($displayStatus === 'upcoming')
                    <div class="training-upcoming-notice">
                        <i class="ki-duotone ki-time">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>

                        <span>Segera dimulai</span>
                    </div>
                @endif

                {{-- =================================================
                    COMPLETED NOTICE
                ================================================== --}}

                @if($displayStatus === 'completed')
                    <div class="training-completed-notice">
                        <i class="ki-duotone ki-check-circle">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>

                        <span>Pelatihan telah selesai</span>
                    </div>
                @endif

                {{-- =================================================
                    CANCELLED NOTICE
                ================================================== --}}

                @if($displayStatus === 'cancelled')
                    <div class="training-completed-notice">
                        <i class="ki-duotone ki-cross-circle">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>

                        <span>Pelatihan dibatalkan</span>
                    </div>
                @endif

                {{-- =================================================
                    BOTTOM
                ================================================== --}}
                <div class="training-bottom">

                    <div class="training-registered">

                        @if($registeredDate)
                            <div>
                                Terdaftar
                                {{ \Carbon\Carbon::parse($registeredDate)->translatedFormat('d M Y') }}
                            </div>
                        @endif

                        {{-- GRATIS --}}
                        @if($isFree || $finalPrice <= 0)

                            <div class="training-price-free">
                                Gratis
                            </div>

                        {{-- HARGA DENGAN DISKON --}}
                        @elseif($hasDiscount)

                            <div class="training-price-wrapper">

                                <span class="training-discount-badge">
                                    Diskon {{ rtrim(rtrim(number_format($discount, 2, ',', '.'), '0'), ',') }}%
                                </span>

                                <span class="training-price-original">
                                    Rp {{ number_format($price, 0, ',', '.') }}
                                </span>

                            </div>

                            <div class="training-price-final">
                                Rp {{ number_format($finalPrice, 0, ',', '.') }}
                            </div>

                            <div class="training-price-saving">
                                Hemat Rp {{ number_format($discountAmount, 0, ',', '.') }}
                            </div>

                        {{-- HARGA NORMAL --}}
                        @elseif($price > 0)

                            <div class="training-price-final">
                                Rp {{ number_format($price, 0, ',', '.') }}
                            </div>

                        @endif

                    </div>

                    {{-- DETAIL --}}
                    @if($uuid)
                        <a
                            href="{{ route('user-page.training.show', $uuid) }}"
                            class="btn-training-detail"
                        >
                            Lihat Detail
                        </a>
                    @endif

                </div>

            </div>

        </div>

    </div>

@empty

    {{-- =========================================================
        EMPTY STATE
    ========================================================== --}}

    <div class="training-card">

        <div class="training-empty">

            <div class="training-empty-icon">
                <i class="ki-duotone ki-teacher">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </div>

            <h5>Belum Ada Pelatihan</h5>

            <div class="training-empty-text">
                Kamu belum mengikuti pelatihan apa pun.
            </div>

            <a
                href="{{ route('user-page.training.index') }}"
                class="btn-search-training"
            >
                <i class="ki-duotone ki-teacher">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>

                Cari Pelatihan
            </a>

        </div>

    </div>

@endforelse
