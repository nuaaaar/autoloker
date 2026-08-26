@forelse($bookmarks as $bookmark)

    @php
        $job = $bookmark->job_vacancy;
    @endphp


    @if(!$job)
        @continue
    @endif


    <div class="bookmark-card {{ $job->is_urgent ? 'urgent' : '' }}">

        {{-- ================================================= --}}
        {{-- TOP --}}
        {{-- ================================================= --}}

        <div class="bookmark-card-top">

            <div>

                @if($job->is_urgent)

                    <div class="bookmark-urgent">
                        ⚡ URGENT
                    </div>

                @endif


                <h3 class="bookmark-job-title">

                    {{ $job->position ?? '-' }}

                </h3>


                <div class="bookmark-company">

                    {{ $job->bujp?->company_name
                        ?? $job->company?->company_name
                        ?? '-' }}

                </div>

            </div>


            <div class="bookmark-icon">

                <i class="ki-duotone ki-bookmark-2"></i>

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

                {{ $job->working_system == 'shift'
                    ? 'Shift'
                    : 'Non-Shift' }}

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

                        /{{ $job->fee_type == 'monthly'
                            ? 'bulan'
                            : 'hari' }}

                    </small>

                </span>

                {{-- BARIS BARU SETELAH SALARY --}}
                <div class="bookmark-meta-break"></div>

            @endif


            {{-- ================================================= --}}
            {{-- CERTIFICATE --}}
            {{-- ================================================= --}}

            @if($job->certificate)

                @php

                    $certificates = json_decode(
                        $job->certificate,
                        true
                    );

                    if (!is_array($certificates)) {

                        $certificates = [
                            $job->certificate
                        ];

                    }

                @endphp

                @foreach($certificates as $certificate)

                    <span class="bookmark-badge">
                        {{ $certificate }}
                    </span>

                @endforeach

            @endif


            {{-- ================================================= --}}
            {{-- UJI KOMPETENSI / SERTIFIKASI --}}
            {{-- ================================================= --}}

            @if($job->competency_scheme)

                @php

                    $competencySchemes = json_decode(
                        $job->competency_scheme,
                        true
                    );

                    if (!is_array($competencySchemes)) {

                        $competencySchemes = [
                            $job->competency_scheme
                        ];

                    }

                @endphp

                @foreach($competencySchemes as $scheme)

                    <span class="bookmark-badge">
                        {{ $scheme }}
                    </span>

                @endforeach

            @endif


            {{-- APPLICANTS --}}

            <span class="bookmark-applicants">

                {{ $job->applications_count ?? 0 }}

                pelamar

            </span>

        </div>


        {{-- ================================================= --}}
        {{-- BOTTOM INFO --}}
        {{-- ================================================= --}}

        <div class="bookmark-bottom-info">

            <span>

                Disimpan

                {{ $bookmark->created_at?->translatedFormat(
                    'd M Y'
                ) }}

            </span>


            @if($job->end_date)

                <span class="bookmark-deadline">

                    Deadline:

                    <strong>

                        {{ \Carbon\Carbon::parse(
                            $job->end_date
                        )->translatedFormat(
                            'd M Y'
                        ) }}

                    </strong>

                </span>

            @endif

        </div>


        {{-- ================================================= --}}
        {{-- ACTION --}}
        {{-- ================================================= --}}

        <div class="bookmark-actions">

            <a
                href="{{ route(
                    'user-page.job-vacancy.show',
                    $job->uuid
                ) }}"
                class="bookmark-btn-detail">

                Lihat Detail

            </a>

            @php

                $job = $bookmark->job_vacancy;

                $application = $job->applications->first();

                $applicationStatus = $application?->status;

            @endphp


            @if($applicationStatus === 'shortlisted')

                <button
                    type="button"
                    class="btn-apply flex-grow-1"
                    disabled
                    style="background-color: #198754;">

                    <i class="ki-duotone ki-check me-1"></i>

                    Anda Terpilih

                </button>


            @elseif($applicationStatus === 'rejected')

                <button
                    type="button"
                    class="btn-apply flex-grow-1"
                    disabled
                    style="background-color: #dc3545;">

                    <i class="ki-duotone ki-cross me-1"></i>

                    Lamaran Ditolak

                </button>


            @elseif($applicationStatus === 'reviewed')

                <button
                    type="button"
                    class="btn-apply flex-grow-1"
                    disabled
                    style="background-color: #ffc107; color: #212529;">

                    <i class="ki-duotone ki-time me-1"></i>

                    Sedang Direview

                </button>


            @elseif($applicationStatus === 'applied')

                <button
                    type="button"
                    class="btn-apply flex-grow-1"
                    onclick="cancelApplyJob(
                        this,
                        '{{ $job->uuid }}'
                    )">

                    <i class="ki-duotone ki-check me-1"></i>

                    Sudah Dilamar

                </button>


            @else

                <button
                    type="button"
                    class="btn-apply flex-grow-1"
                    onclick="applyJob(
                        this,
                        '{{ $job->uuid }}'
                    )">

                    Lamar Sekarang

                </button>

            @endif

        </div>

    </div>


@empty

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