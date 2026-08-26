@forelse($jobs as $job)

    <div class="card job-card mb-4">

        <div class="card-body p-4">

            {{-- ================================================= --}}
            {{-- JOB INFORMATION --}}
            {{-- ================================================= --}}

            <a
                href="{{ route(
                    'user-page.job-vacancy.show',
                    $job->uuid
                ) }}"
                class="job-card-link"
            >

                <div class="d-flex justify-content-between">

                    <div class="flex-grow-1">

                        {{-- ================================================= --}}
                        {{-- TITLE --}}
                        {{-- ================================================= --}}

                        <div class="d-flex align-items-center flex-wrap gap-2">

                            <h5 class="job-title mb-0">

                                {{ $job->position ?? '-' }}

                            </h5>


                            {{-- URGENT --}}

                            @if($job->is_urgent ?? false)

                                <span class="badge-urgent">

                                    ⚡ Urgent

                                </span>

                            @endif

                        </div>


                        {{-- ================================================= --}}
                        {{-- COMPANY --}}
                        {{-- ================================================= --}}

                        <div class="company-name">

                            {{ $job->bujp?->company_name
                                ?? $job->company?->company_name
                                ?? '-' }}

                        </div>


                        {{-- ================================================= --}}
                        {{-- LOCATION + WORKING SYSTEM --}}
                        {{-- ================================================= --}}

                        <div class="job-info mt-1">

                            <span>

                                <i class="ki-duotone ki-geolocation"></i>

                                {{ $job->city ?? '-' }}

                            </span>


                            <span>

                                <i class="ki-duotone ki-time"></i>

                                {{ $job->working_system === 'shift'
                                    ? 'Shift'
                                    : 'Non-Shift' }}

                            </span>

                        </div>


                        {{-- ================================================= --}}
                        {{-- SALARY --}}
                        {{-- ================================================= --}}

                        @if($job->is_show_fee)

                            <div class="d-flex align-items-center flex-wrap gap-2 mt-1">

                                <span class="salary">

                                    Rp
                                    {{ number_format(
                                        (float) $job->min_price,
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                                    @if($job->max_price)

                                        –
                                        Rp
                                        {{ number_format(
                                            (float) $job->max_price,
                                            0,
                                            ',',
                                            '.'
                                        ) }}

                                    @endif


                                    @if($job->fee_type === 'monthly')

                                        /bulan

                                    @else

                                        /hari

                                    @endif

                                </span>

                            </div>

                        @endif


                        {{-- ================================================= --}}
                        {{-- CERTIFICATE --}}
                        {{-- ================================================= --}}

                        @php

                            $certificates = [];

                            if ($job->certificate) {

                                $decoded = json_decode(
                                    $job->certificate,
                                    true
                                );

                                if (is_array($decoded)) {

                                    $certificates = $decoded;

                                } else {

                                    $certificates = [
                                        $job->certificate
                                    ];

                                }

                            }

                        @endphp


                        @if(count($certificates))

                            <div class="d-flex align-items-center flex-wrap gap-2 mt-1">

                                @foreach($certificates as $certificate)

                                    <span class="badge-license">

                                        <i class="ki-duotone ki-shield-tick text-warning fs-7"></i>

                                        {{ $certificate }}

                                    </span>

                                @endforeach

                            </div>

                        @endif



                        {{-- ================================================= --}}
                        {{-- KOMPETENSI SKEMA --}}
                        {{-- ================================================= --}}

                        @php

                            $competencySchemes = [];

                            if ($job->competency_scheme) {

                                $decoded = json_decode(
                                    $job->competency_scheme,
                                    true
                                );

                                if (is_array($decoded)) {

                                    $competencySchemes = $decoded;

                                } else {

                                    $competencySchemes = [
                                        $job->competency_scheme
                                    ];

                                }

                            }

                        @endphp


                        @if(count($competencySchemes))

                            <div class="d-flex align-items-center flex-wrap gap-2 mt-2">

                                @foreach($competencySchemes as $scheme)

                                    <span class="badge-license">

                                        <i class="ki-duotone ki-medal-star text-success fs-7"></i>

                                        {{ $scheme }}

                                    </span>

                                @endforeach

                            </div>

                        @endif


                        {{-- ================================================= --}}
                        {{-- WORK TYPE + QUOTA --}}
                        {{-- ================================================= --}}

                        <div class="apply-info mt-1">

                            {{ match($job->working_type) {

                                'permanent' => 'Tetap',

                                'contract' => 'Kontrak',

                                'intenrship' => 'Internship',

                                'freelance' => 'Freelance',

                                default => '-'

                            } }}


                            @if($job->kuota)

                                • Kuota {{ $job->kuota }}

                            @endif

                        </div>


                        {{-- ================================================= --}}
                        {{-- DEADLINE --}}
                        {{-- ================================================= --}}

                        @if($job->end_date)

                            <div class="apply-info mt-1">

                                Batas lamaran

                                {{ \Carbon\Carbon::parse(
                                    $job->end_date
                                )->translatedFormat('d M Y') }}

                            </div>

                        @endif


                        {{-- ================================================= --}}
                        {{-- STATISTIK --}}
                        {{-- ================================================= --}}

                        <div class="apply-info mt-1">

                            {{ number_format(
                                $job->applications_count ?? 0,
                                0,
                                ',',
                                '.'
                            ) }}
                            pelamar

                            •
                            {{ $job->total_clicked ?? 0 }}
                            dilihat

                            •
                            {{ $job->bookmarks_count ?? 0 }}
                            disimpan

                            •
                            Diperbarui
                            {{ $job->created_at?->diffForHumans() }}

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- ICON --}}
                    {{-- ================================================= --}}

                    <div class="company-icon">

                        <i class="ki-duotone ki-office-bag fs-2"></i>

                    </div>

                </div>

            </a>


            <hr class="job-divider">


            {{-- ================================================= --}}
            {{-- ACTION --}}
            {{-- ================================================= --}}

            <div class="d-flex gap-3">

                {{-- APPLY --}}

                @if($job->application_status === 'shortlisted')

                    <button
                        type="button"
                        class="btn-apply flex-grow-1"
                        disabled
                        style="background-color: #198754;">

                        <i class="ki-duotone ki-check me-1"></i>

                        Anda Terpilih

                    </button>


                @elseif($job->application_status === 'rejected')

                    <button
                        type="button"
                        class="btn-apply flex-grow-1"
                        disabled
                        style="background-color: #dc3545;">

                        <i class="ki-duotone ki-cross me-1"></i>

                        Lamaran Ditolak

                    </button>


                @elseif($job->application_status === 'reviewed')

                    <button
                        type="button"
                        class="btn-apply flex-grow-1"
                        disabled
                        style="background-color: #ffc107; color: #212529;">

                        <i class="ki-duotone ki-time me-1"></i>

                        Sedang Direview

                    </button>


                @elseif($job->application_status === 'applied')

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


                {{-- BOOKMARK --}}

                <button
                    type="button"
                    class="btn-save {{ $job->is_bookmarked ? 'saved' : '' }}"
                    onclick="saveJob(
                        this,
                        '{{ $job->uuid }}'
                    )"
                >

                    @if($job->is_bookmarked)

                        <i class="ki-duotone ki-check fs-7 me-1"></i>

                        Tersimpan

                    @else

                        <i class="ki-duotone ki-bookmark-2 fs-7 me-1"></i>

                        Simpan

                    @endif

                </button>

            </div>

        </div>

    </div>

@empty


    {{-- ================================================= --}}
    {{-- EMPTY --}}
    {{-- ================================================= --}}

    <div class="card job-card mb-4">

        <div class="card-body p-4 text-center">

            <i class="ki-duotone ki-briefcase fs-2x mb-3"></i>

            <h5 class="job-title">

                Belum ada lowongan

            </h5>

            <div class="apply-info">

                Saat ini belum tersedia lowongan
                yang dapat dilamar.

            </div>

        </div>

    </div>

@endforelse