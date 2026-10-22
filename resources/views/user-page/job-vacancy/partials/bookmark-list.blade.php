<style>
    /* =========================================
       THEME VARIABLES - LIGHT MODE (DEFAULT)
    ========================================= */

    :root,
    [data-bs-theme="light"] {
        --bookmark-bg: #FFFFFF;
        --bookmark-bg-secondary: #F8FAFC;
        --bookmark-bg-hover: #F8FAFC;

        --bookmark-text: #263247;
        --bookmark-text-strong: #172033;
        --bookmark-text-muted: #64748B;

        --bookmark-border: #E2E8F0;
        --bookmark-border-soft: #EDF1F6;

        --bookmark-accent: #C99A1A;
        --bookmark-accent-hover: #B88712;
        --bookmark-accent-text: #FFFFFF;
        --bookmark-accent-soft: rgba(201, 154, 26, .10);

        --bookmark-shadow: 0 8px 24px rgba(38, 50, 71, .06);

        --bookmark-urgent-bg: rgba(232, 168, 1, .12);
        --bookmark-urgent-text: #A8790B;

        --bookmark-success: #198754;
        --bookmark-danger: #DC3545;
        --bookmark-warning: #FFC107;
        --bookmark-warning-text: #212529;
    }

    /* =========================================
       THEME VARIABLES - DARK MODE
    ========================================= */

    [data-bs-theme="dark"] {
        --bookmark-bg: #11192C;
        --bookmark-bg-secondary: #182338;
        --bookmark-bg-hover: #202D46;

        --bookmark-text: #DCE4F2;
        --bookmark-text-strong: #F5F7FA;
        --bookmark-text-muted: #95A2BD;

        --bookmark-border: rgba(255, 255, 255, .10);
        --bookmark-border-soft: rgba(255, 255, 255, .07);

        --bookmark-accent: #E8A801;
        --bookmark-accent-hover: #F2B600;
        --bookmark-accent-text: #171717;
        --bookmark-accent-soft: rgba(232, 168, 1, .12);

        --bookmark-shadow: 0 8px 24px rgba(0, 0, 0, .18);

        --bookmark-urgent-bg: rgba(232, 168, 1, .14);
        --bookmark-urgent-text: #F5B942;

        --bookmark-success: #198754;
        --bookmark-danger: #DC3545;
        --bookmark-warning: #FFC107;
        --bookmark-warning-text: #171717;
    }

    /* =========================================
       BOOKMARK CARD
    ========================================= */

    .bookmark-card {
        background: var(--bookmark-bg);
        border: 1px solid var(--bookmark-border);
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 20px;
        box-shadow: var(--bookmark-shadow);
        color: var(--bookmark-text);
        transition: background .2s ease,
                    border-color .2s ease,
                    box-shadow .2s ease;
    }

    .bookmark-card:hover {
        border-color: var(--bookmark-accent);
    }

    .bookmark-card.urgent {
        border-left: 4px solid var(--bookmark-accent);
    }

    /* =========================================
       TOP SECTION
    ========================================= */

    .bookmark-card-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
    }

    .bookmark-company-info {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        flex: 1;
        min-width: 0;
    }

    .bookmark-company-content {
        flex: 1;
        min-width: 0;
    }

    /* =========================================
       COMPANY LOGO
    ========================================= */

    .bookmark-company-logo-wrapper {
        width: 68px;
        height: 68px;
        flex: 0 0 68px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border: 1px solid var(--bookmark-border);
        border-radius: 12px;
        background: var(--bookmark-bg);
        transition: background .2s ease, border-color .2s ease;
    }

    .bookmark-company-logo {
        display: block;
        width: 100%;
        height: 100%;
        padding: 6px;
        object-fit: contain;
    }

    .bookmark-company-logo-fallback {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--bookmark-bg-secondary);
        color: var(--bookmark-text-muted);
    }

    /* =========================================
       URGENT BADGE
    ========================================= */

    .bookmark-urgent {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        margin-bottom: 8px;
        padding: 5px 10px;
        border-radius: 6px;
        background: var(--bookmark-urgent-bg);
        color: var(--bookmark-urgent-text);
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .5px;
    }

    /* =========================================
       JOB TITLE & COMPANY
    ========================================= */

    .bookmark-job-title {
        margin: 0 0 6px;
        color: var(--bookmark-text-strong);
        font-size: 18px;
        font-weight: 800;
        line-height: 1.45;
        overflow-wrap: anywhere;
        transition: color .2s ease;
    }

    .bookmark-company {
        color: var(--bookmark-text-muted);
        font-size: 13px;
        font-weight: 600;
        overflow-wrap: anywhere;
    }

    .bookmark-icon {
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: var(--bookmark-accent-soft);
        color: var(--bookmark-accent);
        font-size: 20px;
    }

    /* =========================================
       JOB INFO
    ========================================= */

    .bookmark-info {
        display: flex;
        flex-wrap: wrap;
        gap: 10px 18px;
        margin-top: 18px;
        color: var(--bookmark-text-muted);
        font-size: 13px;
    }

    .bookmark-info span {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .bookmark-info i {
        font-size: 16px;
    }

    /* =========================================
       META
    ========================================= */

    .bookmark-meta {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 16px;
    }

    .bookmark-salary {
        color: var(--bookmark-accent);
        font-size: 15px;
        font-weight: 800;
    }

    .bookmark-salary small {
        color: var(--bookmark-text-muted);
        font-size: 12px;
        font-weight: 500;
    }

    .bookmark-meta-break {
        flex-basis: 100%;
        height: 0;
    }

    .bookmark-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 10px;
        border: 1px solid var(--bookmark-border);
        border-radius: 7px;
        background: var(--bookmark-bg-secondary);
        color: var(--bookmark-text);
        font-size: 11px;
        font-weight: 600;
        line-height: 1.4;
        transition: background .2s ease, border-color .2s ease;
    }

    .bookmark-applicants {
        color: var(--bookmark-text-muted);
        font-size: 12px;
    }

    /* =========================================
       BOTTOM INFO
    ========================================= */

    .bookmark-bottom-info {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 8px 16px;
        margin-top: 18px;
        padding-top: 14px;
        border-top: 1px solid var(--bookmark-border-soft);
        color: var(--bookmark-text-muted);
        font-size: 12px;
    }

    .bookmark-deadline strong {
        color: var(--bookmark-text);
        font-weight: 700;
    }

    /* =========================================
       ACTION BUTTONS
    ========================================= */

    .bookmark-actions {
        display: flex;
        align-items: stretch;
        gap: 12px;
        margin-top: 18px;
    }

    .bookmark-btn-detail,
    .bookmark-actions .btn-apply {
        min-height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 16px;
        border: 1px solid transparent;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 700;
        text-align: center;
        text-decoration: none;
        transition: background .2s ease,
                    border-color .2s ease,
                    color .2s ease,
                    opacity .2s ease;
    }

    .bookmark-btn-detail {
        flex: 1;
        border-color: var(--bookmark-border);
        background: var(--bookmark-bg);
        color: var(--bookmark-text);
    }

    .bookmark-btn-detail:hover {
        border-color: var(--bookmark-accent);
        background: var(--bookmark-bg-secondary);
        color: var(--bookmark-accent);
    }

    .bookmark-actions .btn-apply {
        flex: 1;
        background: var(--bookmark-accent);
        color: var(--bookmark-accent-text);
        border-color: var(--bookmark-accent);
        cursor: pointer;
    }

    .bookmark-actions .btn-apply:hover:not(:disabled) {
        background: var(--bookmark-accent-hover);
        border-color: var(--bookmark-accent-hover);
    }

    .bookmark-actions .btn-apply:disabled {
        opacity: .9;
        cursor: not-allowed;
    }

    /* Status colors are intentionally preserved
       for applied/rejected/shortlisted states. */

    .bookmark-actions .btn-apply[style*="#198754"],
    .bookmark-actions .btn-apply[style*="rgb(25, 135, 84)"] {
        color: #FFFFFF !important;
    }

    .bookmark-actions .btn-apply[style*="#dc3545"],
    .bookmark-actions .btn-apply[style*="rgb(220, 53, 69)"] {
        color: #FFFFFF !important;
    }

    .bookmark-actions .btn-apply[style*="#ffc107"],
    .bookmark-actions .btn-apply[style*="rgb(255, 193, 7)"] {
        color: #212529 !important;
    }

    /* =========================================
       EMPTY STATE
    ========================================= */

    .bookmark-card > .text-center h5 {
        color: var(--bookmark-text-strong);
    }

    .bookmark-card > .text-center .text-muted {
        color: var(--bookmark-text-muted) !important;
    }

    .bookmark-card > .text-center > i {
        color: var(--bookmark-accent);
    }

    /* =========================================
       RESPONSIVE
    ========================================= */

    @media (max-width: 576px) {
        .bookmark-card {
            padding: 16px;
            border-radius: 13px;
        }

        .bookmark-card-top {
            gap: 10px;
        }

        .bookmark-company-info {
            gap: 10px;
        }

        .bookmark-company-logo-wrapper {
            width: 52px;
            height: 52px;
            flex-basis: 52px;
            border-radius: 10px;
        }

        .bookmark-company-logo {
            padding: 4px;
        }

        .bookmark-company-logo-fallback .ki-office-bag {
            font-size: 1.25rem !important;
        }

        .bookmark-job-title {
            font-size: 15px;
        }

        .bookmark-company {
            font-size: 12px;
        }

        .bookmark-icon {
            width: 34px;
            height: 34px;
            font-size: 17px;
        }

        .bookmark-info {
            gap: 8px 12px;
            margin-top: 14px;
            font-size: 12px;
        }

        .bookmark-meta {
            gap: 7px;
            margin-top: 13px;
        }

        .bookmark-salary {
            font-size: 14px;
        }

        .bookmark-bottom-info {
            align-items: flex-start;
            flex-direction: column;
            margin-top: 14px;
            padding-top: 12px;
        }

        .bookmark-actions {
            gap: 8px;
            margin-top: 14px;
        }

        .bookmark-btn-detail,
        .bookmark-actions .btn-apply {
            min-height: 40px;
            padding: 9px 10px;
            font-size: 12px;
        }
    }

    @media (max-width: 360px) {
        .bookmark-company-logo-wrapper {
            width: 44px;
            height: 44px;
            flex-basis: 44px;
        }

        .bookmark-company-info {
            gap: 8px;
        }

        .bookmark-job-title {
            font-size: 14px;
        }

        .bookmark-icon {
            width: 30px;
            height: 30px;
        }

        .bookmark-actions {
            flex-direction: column;
        }

        .bookmark-btn-detail,
        .bookmark-actions .btn-apply {
            width: 100%;
        }
    }
</style>

@forelse($bookmarks as $bookmark)

    @php
        $job = $bookmark->job_vacancy;
    @endphp

    @if(!$job)
        @continue
    @endif

    @php
        $company = $job->bujp ?? $job->company;
        $companyLogo = $company->logo ?? null;

        $application = $job->applications->first();
        $applicationStatus = $application?->status;

        $certificates = [];

        if ($job->certificate) {
            $decoded = json_decode($job->certificate, true);

            $certificates = is_array($decoded)
                ? $decoded
                : [$job->certificate];
        }

        $competencySchemes = [];

        if ($job->competency_scheme) {
            $decoded = json_decode($job->competency_scheme, true);

            $competencySchemes = is_array($decoded)
                ? $decoded
                : [$job->competency_scheme];
        }
    @endphp

    <div class="bookmark-card {{ $job->is_urgent ? 'urgent' : '' }}">

        {{-- ================================================= --}}
        {{-- TOP --}}
        {{-- ================================================= --}}

        <div class="bookmark-card-top">

            <div class="bookmark-company-info">

                {{-- COMPANY LOGO --}}
                <div class="bookmark-company-logo-wrapper flex-shrink-0">

                    @if($companyLogo)

                        <img
                            src="{{ Storage::url($companyLogo) }}"
                            alt="Logo {{ $company->company_name ?? 'Perusahaan' }}"
                            class="bookmark-company-logo"
                            loading="lazy"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                        >

                        <div
                            class="bookmark-company-logo-fallback"
                            style="display: none;"
                        >
                            <i class="ki-duotone ki-office-bag fs-2"></i>
                        </div>

                    @else

                        <div class="bookmark-company-logo-fallback">
                            <i class="ki-duotone ki-office-bag fs-2"></i>
                        </div>

                    @endif

                </div>

                {{-- JOB INFORMATION --}}
                <div class="bookmark-company-content">

                    @if($job->is_urgent)
                        <div class="bookmark-urgent">
                            ⚡ URGENT
                        </div>
                    @endif

                    <h3 class="bookmark-job-title">
                        {{ $job->position ?? '-' }}
                    </h3>

                    <div class="bookmark-company">
                        {{ $company->company_name ?? '-' }}
                    </div>

                </div>

            </div>

        </div>

        {{-- ================================================= --}}
        {{-- INFO --}}
        {{-- ================================================= --}}

        <div class="bookmark-info">

            <span>
                <i class="ki-duotone ki-geolocation"></i>
                {{ $job->city ?? '-' }}
            </span>

            <span>
                <i class="ki-duotone ki-time"></i>
                {{ match ($job->working_system) {
                    'shift' => 'Shift',
                    'reliever' => 'Reliever',
                    default => 'Non-Shift'
                } }}
            </span>

        </div>

        {{-- ================================================= --}}
        {{-- META --}}
        {{-- ================================================= --}}

        <div class="bookmark-meta">

            @if($job->is_show_fee)

                <span class="bookmark-salary">

                    Rp {{ number_format(
                        (float) $job->min_price,
                        0,
                        ',',
                        '.'
                    ) }}

                    @if($job->max_price)

                        –
                        Rp {{ number_format(
                            (float) $job->max_price,
                            0,
                            ',',
                            '.'
                        ) }}

                    @endif

                    <small>
                        /{{ $job->fee_type == 'monthly' ? 'bulan' : 'hari' }}
                    </small>

                </span>

                {{-- BARIS BARU SETELAH SALARY --}}
                <div class="bookmark-meta-break"></div>

            @endif

            {{-- CERTIFICATE --}}
            @foreach($certificates as $certificate)

                <span class="bookmark-badge">
                    {{ $certificate }}
                </span>

            @endforeach

            {{-- UJI KOMPETENSI / SERTIFIKASI --}}
            @foreach($competencySchemes as $scheme)

                <span class="bookmark-badge">
                    {{ $scheme }}
                </span>

            @endforeach

            {{-- APPLICANTS --}}
            <span class="bookmark-applicants">
                {{ $job->applications_count ?? 0 }} pelamar
            </span>

        </div>

        {{-- ================================================= --}}
        {{-- BOTTOM INFO --}}
        {{-- ================================================= --}}

        <div class="bookmark-bottom-info">

            <span>
                Disimpan
                {{ $bookmark->created_at?->translatedFormat('d M Y') }}
            </span>

            @if($job->end_date)

                <span class="bookmark-deadline">

                    Deadline:

                    <strong>
                        {{ \Carbon\Carbon::parse($job->end_date)->translatedFormat('d M Y') }}
                    </strong>

                </span>

            @endif

        </div>

        {{-- ================================================= --}}
        {{-- ACTION --}}
        {{-- ================================================= --}}

        <div class="bookmark-actions">

            {{-- DETAIL --}}
            <a
                href="{{ route('user-page.job-vacancy.show', $job->uuid) }}"
                class="bookmark-btn-detail"
            >
                Lihat Detail
            </a>

            {{-- APPLY STATUS --}}
            @if($applicationStatus === 'shortlisted')

                <button
                    type="button"
                    class="btn-apply flex-grow-1"
                    disabled
                    style="background-color: #198754; color: #FFFFFF;"
                >
                    <i class="ki-duotone ki-check me-1"></i>
                    Anda Terpilih
                </button>

            @elseif($applicationStatus === 'rejected')

                <button
                    type="button"
                    class="btn-apply flex-grow-1"
                    disabled
                    style="background-color: #dc3545; color: #FFFFFF;"
                >
                    <i class="ki-duotone ki-cross me-1"></i>
                    Lamaran Ditolak
                </button>

            @elseif($applicationStatus === 'reviewed')

                <button
                    type="button"
                    class="btn-apply flex-grow-1"
                    disabled
                    style="background-color: #ffc107; color: #212529;"
                >
                    <i class="ki-duotone ki-time me-1"></i>
                    Sedang Direview
                </button>

            @elseif($applicationStatus === 'applied')

                <button
                    type="button"
                    class="btn-apply flex-grow-1"
                    onclick="cancelApplyJob(this, '{{ $job->uuid }}')"
                >
                    <i class="ki-duotone ki-check me-1"></i>
                    Sudah Dilamar
                </button>

            @else

                <button
                    type="button"
                    class="btn-apply flex-grow-1"
                    onclick="applyJob(this, '{{ $job->uuid }}')"
                >
                    Lamar Sekarang
                </button>

            @endif

        </div>

    </div>

@empty

    {{-- EMPTY STATE --}}
    {{-- Jangan tampilkan empty state saat AJAX page > 1 --}}

    @if($bookmarks->currentPage() == 1)

        <div class="bookmark-card">

            <div class="text-center py-5">

                <i class="ki-duotone ki-bookmark-2 fs-2x mb-3"></i>

                <h5>
                    Belum Ada Lowongan Tersimpan
                </h5>

                <div class="text-muted">
                    Simpan lowongan yang menarik untuk
                    melihatnya kembali nanti.
                </div>

            </div>

        </div>

    @endif

@endforelse