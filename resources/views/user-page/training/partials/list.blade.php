<style>
    .training-card {
        --training-primary: #f7b003;
        --training-primary-hover: #ffc928;
        --training-text: #182338;
        --training-muted: #64748b;
        --training-border: #e2e8f0;

        overflow: hidden;
        border: 1px solid var(--training-border);
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 8px 25px rgba(15, 23, 42, .05);
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .training-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(15, 23, 42, .09);
    }

    /* Banner */
    .training-banner {
        position: relative;
        height: 210px;
        overflow: hidden;
        background:
            linear-gradient(135deg, #26364d 0%, #465a72 50%, #9b7830 100%);
    }

    .training-banner-image {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        transition: transform .4s ease;
    }

    .training-card:hover .training-banner-image {
        transform: scale(1.035);
    }

    .training-banner-fallback {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 10px;
        color: rgba(255, 255, 255, .9);
        font-size: 14px;
        font-weight: 700;
        letter-spacing: .5px;
        background:
            radial-gradient(circle at 80% 15%, rgba(247, 176, 3, .25), transparent 35%),
            linear-gradient(135deg, #1d2c42, #465a72);
    }

    .training-banner-overlay {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 18px 22px;
        color: #fff;
        background: linear-gradient(
            180deg,
            rgba(10, 20, 35, .28) 0%,
            transparent 35%,
            rgba(10, 20, 35, .78) 100%
        );
        pointer-events: none;
    }

    .training-banner-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 8px;
    }

    .training-banner-label,
    .training-certificate-badge {
        display: inline-flex;
        align-items: center;
        padding: 7px 11px;
        border-radius: 7px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .4px;
    }

    .training-banner-label {
        color: #fff;
        background: rgba(15, 23, 42, .55);
        backdrop-filter: blur(5px);
    }

    .training-certificate-badge {
        color: #fff;
        background: rgba(247, 176, 3, .95);
    }

    .training-banner-caption {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        align-self: flex-start;
        padding: 7px 11px;
        border: 1px solid rgba(255, 255, 255, .2);
        border-radius: 8px;
        color: #fff;
        background: rgba(15, 23, 42, .48);
        font-size: 12px;
        font-weight: 600;
        backdrop-filter: blur(5px);
    }

    /* Heading */
    .training-heading {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
    }

    .training-heading-content {
        min-width: 0;
        flex: 1;
    }

    .training-title {
        margin: 0 0 9px;
        color: var(--training-text);
        font-size: 19px;
        font-weight: 800;
        line-height: 1.45;
        overflow-wrap: anywhere;
    }

    .training-provider {
        display: flex;
        align-items: center;
        gap: 6px;
        color: var(--training-muted);
        font-size: 13px;
        font-weight: 500;
    }

    .training-heading-badges {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        flex-wrap: wrap;
        gap: 7px;
    }

    .training-provider-type,
    .training-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 10px;
        border-radius: 7px;
        white-space: nowrap;
        font-size: 11px;
        font-weight: 700;
    }

    .training-provider-type {
        color: #53647b;
        background: #f1f5f9;
    }

    .training-status-dot {
        width: 6px;
        height: 6px;
        flex: 0 0 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .training-status-open {
        color: #28734d;
        background: #e8f6ed;
    }

    .training-status-closed {
        color: #b54747;
        background: #fff0f0;
    }

    .training-status-default {
        color: #6b7280;
        background: #f1f5f9;
    }

    /* Taxonomy badges */
    .training-taxonomy {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 18px;
    }

    .training-taxonomy-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        max-width: 100%;
        padding: 8px 11px;
        border: 1px solid transparent;
        border-radius: 8px;
        font-size: 12px;
        line-height: 1.5;
        overflow-wrap: anywhere;
    }

    .training-taxonomy-badge strong {
        font-weight: 800;
    }

    .taxonomy-role {
        color: #7457a6;
        background: #f4efff;
        border-color: #e7dcff;
    }

    .taxonomy-category {
        color: #8b6500;
        background: #fff7df;
        border-color: #ffebad;
    }

    .taxonomy-subcategory {
        color: #3769a8;
        background: #edf5ff;
        border-color: #d9e9ff;
    }

    .taxonomy-tuk {
        color: #3f6d5c;
        background: #edf7f1;
        border-color: #d7ebdf;
    }

    /* Informasi */
    .training-info {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
        padding: 20px;
        border: 1px solid #edf0f5;
        border-radius: 12px;
        background: #fafbfc;
    }

    .training-info-item {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
    }

    .training-info-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        flex: 0 0 42px;
        border-radius: 10px;
    }

    .info-icon-date {
        color: #ad7a00;
        background: #fff2c7;
    }

    .info-icon-duration {
        color: #5d69bb;
        background: #eeefff;
    }

    .info-icon-mode {
        color: #2879a8;
        background: #e7f5ff;
    }

    .info-icon-quota {
        color: #7d61b1;
        background: #f1eaff;
    }

    .training-info-content {
        display: flex;
        flex-direction: column;
        min-width: 0;
        gap: 4px;
    }

    .training-info-label {
        color: #8792a4;
        font-size: 11px;
        font-weight: 600;
    }

    .training-info-value {
        color: var(--training-text);
        font-size: 13px;
        font-weight: 700;
        overflow-wrap: anywhere;
    }

    .training-quota-unlimited {
        color: #94a3b8;
        font-size: 11px;
        font-weight: 500;
    }

    /* Progress kuota */
    .training-quota-section {
        padding: 0 2px;
    }

    .training-quota-header {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 9px;
        color: var(--training-muted);
        font-size: 12px;
    }

    .training-quota-header strong {
        color: var(--training-text);
        font-weight: 800;
    }

    .training-progress {
        height: 7px;
        overflow: hidden;
        border-radius: 20px;
        background: #edf0f5;
    }

    .training-progress .progress-bar {
        border-radius: 20px;
        background: #f7b003;
        transition: width .3s ease;
    }

    .training-progress .training-progress-full {
        background: #d95c5c;
    }

    .training-full-notice {
        display: flex;
        align-items: center;
        color: #c24141;
        font-size: 12px;
        font-weight: 600;
    }

    /* Footer */
    .training-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        padding-top: 20px;
        border-top: 1px solid #edf0f5;
    }

    .training-price-wrapper {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .training-price-label {
        color: #8792a4;
        font-size: 11px;
        font-weight: 600;
    }

    .training-price {
        color: var(--training-text);
        font-size: 22px;
        font-weight: 800;
        line-height: 1.3;
    }

    .training-price-currency {
        margin-right: 2px;
        font-size: 13px;
        font-weight: 700;
    }

    .training-price-free {
        color: #3b765c;
        font-size: 20px;
    }

    .btn-training-detail {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 12px 18px;
        border: 1px solid #f7b003;
        border-radius: 9px;
        color: #302500;
        background: #f7b003;
        font-size: 13px;
        font-weight: 800;
        text-decoration: none;
        transition: background .2s ease, border-color .2s ease, transform .2s ease;
    }

    .btn-training-detail:hover {
        color: #302500;
        border-color: #ffc928;
        background: #ffc928;
        transform: translateY(-1px);
    }

    /* Empty state */
    .training-empty-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 75px;
        height: 75px;
        border-radius: 20px;
        color: #a17a13;
        background: #fff4d6;
    }

    /* Responsive */
    @media (max-width: 767.98px) {
        .training-banner {
            height: 175px;
        }

        .training-card .card-body {
            padding: 20px !important;
        }

        .training-heading {
            flex-direction: column;
            gap: 12px;
        }

        .training-heading-badges {
            justify-content: flex-start;
        }

        .training-title {
            font-size: 17px;
        }

        .training-taxonomy {
            gap: 7px;
            margin-top: 15px;
        }

        .training-taxonomy-badge {
            font-size: 11px;
            padding: 7px 9px;
        }

        .training-info {
            grid-template-columns: 1fr;
            gap: 16px;
            padding: 15px;
        }

        .training-footer {
            align-items: flex-start;
            flex-direction: column;
        }

        .btn-training-detail {
            width: 100%;
        }

        .training-price {
            font-size: 21px;
        }
    }

    @media (max-width: 420px) {
        .training-banner {
            height: 150px;
        }

        .training-banner-overlay {
            padding: 12px;
        }

        .training-banner-label,
        .training-certificate-badge {
            padding: 6px 8px;
            font-size: 10px;
        }

        .training-banner-caption {
            padding: 6px 8px;
            font-size: 11px;
        }
    }

    /* Dark mode */
    [data-bs-theme="dark"] .training-card,
    .dark-layout .training-card,
    .dark-mode .training-card,
    [data-theme="dark"] .training-card {
        --training-text: #e5e7eb;
        --training-muted: #aab4c3;
        --training-border: #374151;

        border-color: #374151;
        background: #1f2937;
        box-shadow: none;
    }

    [data-bs-theme="dark"] .training-info,
    .dark-layout .training-info,
    .dark-mode .training-info,
    [data-theme="dark"] .training-info {
        border-color: #374151;
        background: #263244;
    }

    [data-bs-theme="dark"] .training-provider-type,
    .dark-layout .training-provider-type,
    .dark-mode .training-provider-type,
    [data-theme="dark"] .training-provider-type {
        color: #d1d5db;
        background: #374151;
    }

    [data-bs-theme="dark"] .training-info-label,
    .dark-layout .training-info-label,
    .dark-mode .training-info-label,
    [data-theme="dark"] .training-info-label {
        color: #aab4c3;
    }

    [data-bs-theme="dark"] .training-footer,
    .dark-layout .training-footer,
    .dark-mode .training-footer,
    [data-theme="dark"] .training-footer {
        border-top-color: #374151;
    }

    [data-bs-theme="dark"] .taxonomy-role,
    .dark-layout .taxonomy-role,
    .dark-mode .taxonomy-role,
    [data-theme="dark"] .taxonomy-role {
        color: #d4c2ff;
        background: #352b4b;
        border-color: #51416f;
    }

    [data-bs-theme="dark"] .taxonomy-category,
    .dark-layout .taxonomy-category,
    .dark-mode .taxonomy-category,
    [data-theme="dark"] .taxonomy-category {
        color: #ffe08a;
        background: #44391e;
        border-color: #655329;
    }

    [data-bs-theme="dark"] .taxonomy-subcategory,
    .dark-layout .taxonomy-subcategory,
    .dark-mode .taxonomy-subcategory,
    [data-theme="dark"] .taxonomy-subcategory {
        color: #b6d7ff;
        background: #243a55;
        border-color: #345578;
    }

    [data-bs-theme="dark"] .taxonomy-tuk,
    .dark-layout .taxonomy-tuk,
    .dark-mode .taxonomy-tuk,
    [data-theme="dark"] .taxonomy-tuk {
        color: #b9e3cb;
        background: #263f35;
        border-color: #365a49;
    }

    [data-bs-theme="dark"] .training-status-open,
    .dark-layout .training-status-open,
    .dark-mode .training-status-open,
    [data-theme="dark"] .training-status-open {
        color: #a7e4bd;
        background: #214334;
    }

    [data-bs-theme="dark"] .training-status-closed,
    .dark-layout .training-status-closed,
    .dark-mode .training-status-closed,
    [data-theme="dark"] .training-status-closed {
        color: #ffb4b4;
        background: #492b2b;
    }

    [data-bs-theme="dark"] .training-status-default,
    .dark-layout .training-status-default,
    .dark-mode .training-status-default,
    [data-theme="dark"] .training-status-default {
        color: #d1d5db;
        background: #374151;
    }

        /* Area harga dan diskon */
    .training-price-wrapper {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
    }

    .training-discount-pricing {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 4px;
    }

    .training-discount-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 9px;
        border-radius: 6px;
        color: #c24141;
        background: #fff0f0;
        border: 1px solid #ffdada;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .3px;
    }

    .training-original-price {
        color: #94a3b8;
        font-size: 12px;
        font-weight: 500;
        text-decoration: line-through;
    }

    .training-price-discounted {
        color: #c24141;
        font-size: 22px;
        font-weight: 800;
        line-height: 1.3;
    }

    .training-savings {
        color: #3b765c;
        font-size: 11px;
        font-weight: 700;
    }

    /* Dark mode */
    [data-bs-theme="dark"] .training-discount-badge,
    .dark-layout .training-discount-badge,
    .dark-mode .training-discount-badge,
    [data-theme="dark"] .training-discount-badge {
        color: #ffb4b4;
        background: #492b2b;
        border-color: #663838;
    }

    [data-bs-theme="dark"] .training-price-discounted,
    .dark-layout .training-price-discounted,
    .dark-mode .training-price-discounted,
    [data-theme="dark"] .training-price-discounted {
        color: #ff8c8c;
    }

    [data-bs-theme="dark"] .training-savings,
    .dark-layout .training-savings,
    .dark-mode .training-savings,
    [data-theme="dark"] .training-savings {
        color: #a7e4bd;
    }
</style>

{{-- List Pelatihan --}}
@forelse($trainings as $training)
    @php
        /*
        |--------------------------------------------------------------------------
        | Informasi Kuota
        |--------------------------------------------------------------------------
        */
        $quota = (int) ($training->quota ?? 0);
        $registered = (int) ($training->registered_count ?? 0);

        $percentage = $quota > 0
            ? min(100, round(($registered / $quota) * 100))
            : 0;

        $isFull = $quota > 0 && $registered >= $quota;

        /*
        |--------------------------------------------------------------------------
        | Informasi Provider
        |--------------------------------------------------------------------------
        */
        $providerName = $training->provider_name
            ?? $training->provider->name
            ?? 'Penyelenggara Pelatihan';

        /*
        |--------------------------------------------------------------------------
        | Harga
        |--------------------------------------------------------------------------
        */
        $price = (float) ($training->price ?? 0);
        $isFree = $price <= 0;

        /*
        |--------------------------------------------------------------------------
        | Kategori dan Sasaran Peserta
        |--------------------------------------------------------------------------
        */
        $category = $training->category ?? null;
        $subCategory = $training->sub_category ?? null;
        $categoryRole = strtolower(trim($training->category_role ?? ''));
        $tuk = strtolower(trim($training->tuk ?? ''));

        $categoryRoleLabels = [
            'security' => 'Security',
            'cs'       => 'Customer Service',
        ];

        $tukLabels = [
            'mandiri'      => 'Mandiri',
            'sewaktu'      => 'Sewaktu',
            'tempat kerja' => 'Tempat Kerja',
            'tempat_kerja' => 'Tempat Kerja',
        ];

        $categoryRoleLabel = $categoryRoleLabels[$categoryRole]
            ?? ($training->category_role ?? '');

        $tukLabel = $tukLabels[$tuk] ?? ($training->tuk ?? '');

        /*
        |--------------------------------------------------------------------------
        | Poster
        |--------------------------------------------------------------------------
        | Diasumsikan poster tersimpan di storage/app/public.
        */
        $poster = $training->poster ?? null;

        $posterUrl = $poster
            ? asset('storage/' . ltrim($poster, '/'))
            : null;

        /*
        |--------------------------------------------------------------------------
        | Jadwal Pelatihan
        |--------------------------------------------------------------------------
        */
        $startDate = $training->start_date ?? null;
        $endDate = $training->end_date ?? null;

        $dateLabel = 'Jadwal belum ditentukan';

        if ($startDate && $endDate) {
            $dateLabel = \Carbon\Carbon::parse($startDate)->translatedFormat('d M Y')
                . ' - '
                . \Carbon\Carbon::parse($endDate)->translatedFormat('d M Y');
        } elseif ($startDate) {
            $dateLabel = \Carbon\Carbon::parse($startDate)->translatedFormat('d M Y');
        }

        /*
        |--------------------------------------------------------------------------
        | Durasi dan Metode
        |--------------------------------------------------------------------------
        */
        $duration = $training->duration ?? null;
        $trainingMode = $training->training_mode ?? $training->mode ?? null;

        /*
        |--------------------------------------------------------------------------
        | Status
        |--------------------------------------------------------------------------
        */
        $status = strtolower(trim($training->status ?? ''));

        $statusLabels = [
            'published' => 'Dibuka',
            'open'      => 'Dibuka',
            'active'    => 'Aktif',
            'draft'     => 'Draft',
            'closed'    => 'Ditutup',
            'completed' => 'Selesai',
        ];

        $statusLabel = $statusLabels[$status] ?? ucfirst($status ?: 'Tersedia');

        $statusClass = in_array($status, ['published', 'open', 'active'])
            ? 'training-status-open'
            : (in_array($status, ['closed', 'completed'])
                ? 'training-status-closed'
                : 'training-status-default');

        /*
        |--------------------------------------------------------------------------
        | URL Detail
        |--------------------------------------------------------------------------
        | Sesuaikan nama route jika berbeda pada aplikasi Anda.
        */
        $detailUrl = route('dashboard-user.training.show', $training->uuid);
    @endphp

    <div class="card training-card mb-4">

        {{-- Banner Poster --}}
        <div class="training-banner">

            @if($posterUrl)
                <img
                    src="{{ $posterUrl }}"
                    alt="Poster {{ $training->title ?? 'Pelatihan' }}"
                    class="training-banner-image"
                    loading="lazy"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                >

                <div class="training-banner-fallback" style="display: none;">
                    <i class="ki-duotone ki-book-open fs-3x">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <span>Program Pelatihan</span>
                </div>
            @else
                <div class="training-banner-fallback">
                    <i class="ki-duotone ki-book-open fs-3x">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <span>Program Pelatihan</span>
                </div>
            @endif

            <div class="training-banner-overlay">
                <div class="training-banner-top">
                    <span class="training-banner-label">
                        <i class="ki-duotone ki-book-open fs-6 me-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        PROGRAM PELATIHAN
                    </span>

                    @if(!empty($training->certificate))
                        <span class="training-certificate-badge">
                            <i class="ki-duotone ki-award fs-6 me-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            Sertifikat
                        </span>
                    @endif
                </div>

                <div class="training-banner-caption">
                    <i class="ki-duotone ki-calendar fs-6 me-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    {{ $dateLabel }}
                </div>
            </div>
        </div>

        <div class="card-body p-5">

            {{-- Judul dan Status --}}
            <div class="training-heading">
                <div class="training-heading-content">
                    <h3 class="training-title">
                        {{ $training->title ?? 'Pelatihan Tanpa Judul' }}
                    </h3>

                    <div class="training-provider">
                        <i class="ki-duotone ki-user fs-5 me-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <span>{{ $training->provider }}</span>
                    </div>
                </div>

                <div class="training-heading-badges">
                    @if(!empty($training->provider_type))
                        <span class="training-provider-type">
                            {{ ucfirst(str_replace('_', ' ', $training->provider_type)) }}
                        </span>
                    @endif

                    <span class="training-status {{ $statusClass }}">
                        <span class="training-status-dot"></span>
                        {{ $statusLabel }}
                    </span>
                </div>
            </div>

            {{-- Detail Kategori, Subkategori, Sasaran, dan TUK --}}
            @if(
                !empty($category) ||
                !empty($subCategory) ||
                !empty($categoryRoleLabel) ||
                !empty($tukLabel)
            )
                <div class="training-taxonomy">

                    @if(!empty($categoryRoleLabel))
                        <span class="training-taxonomy-badge taxonomy-role">
                            <i class="ki-duotone ki-people fs-6">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <span>
                                Sasaran:
                                <strong>{{ $categoryRoleLabel }}</strong>
                            </span>
                        </span>
                    @endif

                    @if(!empty($category))
                        <span class="training-taxonomy-badge taxonomy-category">
                            <i class="ki-duotone ki-category fs-6">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <span>
                                Kategori:
                                <strong>
                                    {{ is_object($category) ? ($category->name ?? $category->title ?? '-') : $category }}
                                </strong>
                            </span>
                        </span>
                    @endif

                    @if(!empty($subCategory))
                        <span class="training-taxonomy-badge taxonomy-subcategory">
                            <i class="ki-duotone ki-hierarchy fs-6">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <span>
                                Subkategori:
                                <strong>
                                    {{ is_object($subCategory) ? ($subCategory->name ?? $subCategory->title ?? '-') : $subCategory }}
                                </strong>
                            </span>
                        </span>
                    @endif

                    @if(!empty($tukLabel))
                        <span class="training-taxonomy-badge taxonomy-tuk">
                            <i class="ki-duotone ki-geolocation fs-6">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <span>
                                TUK:
                                <strong>{{ $tukLabel }}</strong>
                            </span>
                        </span>
                    @endif

                </div>
            @endif

            {{-- Informasi Pelatihan --}}
            <div class="training-info mt-4">

                <div class="training-info-item">
                    <div class="training-info-icon info-icon-date">
                        <i class="ki-duotone ki-user fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>

                    <div class="training-info-content">
                        <span class="training-info-label">INSTRUKTUR</span>
                        <span class="training-info-value">{{ $training->instructor }}</span>
                    </div>
                </div>

                <div class="training-info-item">
                    <div class="training-info-icon info-icon-date">
                        <i class="ki-duotone ki-calendar fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>

                    <div class="training-info-content">
                        <span class="training-info-label">Jadwal Pelatihan</span>
                        <span class="training-info-value">{{ $dateLabel }}</span>
                    </div>
                </div>

                @if(!empty($duration))
                    <div class="training-info-item">
                        <div class="training-info-icon info-icon-duration">
                            <i class="ki-duotone ki-time fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </div>

                        <div class="training-info-content">
                            <span class="training-info-label">Durasi</span>
                            <span class="training-info-value">{{ $duration }}</span>
                        </div>
                    </div>
                @endif

                @if(!empty($trainingMode))
                    <div class="training-info-item">
                        <div class="training-info-icon info-icon-mode">
                            <i class="ki-duotone ki-screen fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </div>

                        <div class="training-info-content">
                            <span class="training-info-label">Metode Pelatihan</span>
                            <span class="training-info-value">
                                {{ ucfirst(str_replace('_', ' ', $trainingMode)) }}
                            </span>
                        </div>
                    </div>
                @endif

                <div class="training-info-item">
                    <div class="training-info-icon info-icon-quota">
                        <i class="ki-duotone ki-users fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>

                    <div class="training-info-content">
                        <span class="training-info-label">Kuota Peserta</span>
                        <span class="training-info-value">
                            {{ $registered }} peserta
                            @if($quota > 0)
                                / {{ $quota }} peserta
                            @else
                                <span class="training-quota-unlimited">(Tidak dibatasi)</span>
                            @endif
                        </span>
                    </div>
                </div>

            </div>

            {{-- Progress Kuota --}}
            @if($quota > 0)
                <div class="training-quota-section mt-4">
                    <div class="training-quota-header">
                        <span>Kuota Terisi</span>
                        <strong>{{ $percentage }}%</strong>
                    </div>

                    <div class="progress training-progress">
                        <div
                            class="progress-bar {{ $isFull ? 'training-progress-full' : '' }}"
                            role="progressbar"
                            style="width: {{ $percentage }}%;"
                            aria-valuenow="{{ $percentage }}"
                            aria-valuemin="0"
                            aria-valuemax="100">
                        </div>
                    </div>

                    @if($isFull)
                        <div class="training-full-notice mt-2">
                            <i class="ki-duotone ki-information-2 fs-6 me-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                            Kuota pelatihan telah terpenuhi.
                        </div>
                    @endif
                </div>
            @endif

            {{-- Footer: Harga, Diskon, dan Tombol Detail --}}
            <div class="training-footer mt-5">

                <div class="training-price-wrapper">
                    <span class="training-price-label">Biaya Pelatihan</span>

                    @if((float) ($training->discount ?? 0) > 0)
                        @php
                            $discount = (float) $training->discount;
                            $originalPrice = (float) $price;

                            // Diskon dianggap sebagai persentase (%).
                            $discountAmount = $originalPrice * $discount / 100;
                            $finalPrice = max(0, $originalPrice - $discountAmount);
                        @endphp

                        <div class="training-discount-pricing">
                            <div class="training-discount-badge">
                                <i class="ki-duotone ki-discount fs-6">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                DISKON {{ rtrim(rtrim(number_format($discount, 2, ',', '.'), '0'), ',') }}%
                            </div>

                            <div class="training-original-price">
                                Rp {{ number_format($originalPrice, 0, ',', '.') }}
                            </div>

                            <div class="training-price training-price-discounted">
                                @if($finalPrice <= 0)
                                    GRATIS
                                @else
                                    <span class="training-price-currency">Rp</span>
                                    {{ number_format($finalPrice, 0, ',', '.') }}
                                @endif
                            </div>

                            <div class="training-savings">
                                Hemat Rp {{ number_format($discountAmount, 0, ',', '.') }}
                            </div>
                        </div>

                    @elseif($isFree)
                        <div class="training-price training-price-free">
                            GRATIS
                        </div>
                    @else
                        <div class="training-price">
                            <span class="training-price-currency">Rp</span>
                            {{ number_format($price, 0, ',', '.') }}
                        </div>
                    @endif
                </div>

                <a
                    href="{{ route('user-page.training.show', $training->uuid) }}"
                    class="btn btn-training-detail"
                >
                    Lihat Detail
                    <i class="ki-duotone ki-arrow-right fs-4 ms-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </a>

            </div>

        </div>
    </div>

@empty
    <div class="card">
        <div class="card-body text-center py-15">
            <div class="training-empty-icon mb-4">
                <i class="ki-duotone ki-book-open fs-3x">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </div>

            <h4 class="text-gray-800 mb-2">Belum Ada Pelatihan</h4>
            <p class="text-muted mb-0">
                Saat ini belum ada pelatihan yang tersedia.
            </p>
        </div>
    </div>
@endforelse