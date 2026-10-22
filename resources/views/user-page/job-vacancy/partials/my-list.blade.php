@forelse($applications as $application)

    @php

        $job = $application->job_vacancy;

    @endphp


    @if(!$job)

        @continue

    @endif


    @php

        $statusMap = [

            'applied' => [
                'label' => 'Menunggu',
                'class' => 'status-applied',
            ],

            'reviewed' => [
                'label' => 'Diproses',
                'class' => 'status-reviewed',
            ],

            'shortlisted' => [
                'label' => 'Terpilih',
                'class' => 'status-shortlisted',
            ],

            'rejected' => [
                'label' => 'Tidak Lolos',
                'class' => 'status-rejected',
            ],

        ];


        $status = $statusMap[
            $application->status
        ] ?? [

            'label' => 'Menunggu',

            'class' => 'status-applied',

        ];


        /*
        |--------------------------------------------------------------------------
        | COMPANY
        |--------------------------------------------------------------------------
        */

        $companyName =
            $job->bujp?->company_name
            ??
            $job->company?->company_name
            ??
            '-';


        /*
        |--------------------------------------------------------------------------
        | CERTIFICATE
        |--------------------------------------------------------------------------
        */

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


    <div class="application-card">

        <div class="application-card-top">


            {{-- =================================================
                AVATAR
            ================================================== --}}

            @php
                $company = $job->bujp ?? $job->company;
                $companyLogo = $company->logo ?? null;
            @endphp

            <div class="company-avatar">
                @if($companyLogo)
                    <img
                        src="{{ \Illuminate\Support\Facades\Storage::url($companyLogo) }}"
                        alt="Logo {{ $company->company_name ?? 'Perusahaan' }}"
                        class="company-avatar-logo"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                    >

                    <div class="company-avatar-fallback" style="display: none;">
                        <i class="ki-duotone ki-user"></i>
                    </div>
                @else
                    <div class="company-avatar-fallback">
                        <i class="ki-duotone ki-user"></i>
                    </div>
                @endif
            </div>


            {{-- =================================================
                CONTENT
            ================================================== --}}

            <div class="application-content">


                {{-- =================================================
                    TITLE
                ================================================== --}}

                <div class="application-title-row">

                    <div class="flex-grow-1">

                        <h4 class="application-title">

                            {{ $job->position ?? '-' }}

                        </h4>


                        <div class="application-company">

                            {{ $companyName }}

                            @if($job->city)

                                · {{ $job->city }}

                            @endif

                        </div>

                    </div>


                    {{-- STATUS --}}

                    <div class="application-status">

                        <span
                            class="status-badge {{ $status['class'] }}">

                            {{ $status['label'] }}

                        </span>

                    </div>

                </div>


                {{-- =================================================
                    META
                ================================================== --}}

                <div class="application-meta">

                    {{-- SALARY --}}

                    @if($job->is_show_fee)

                        <span class="application-salary">

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

                            <small>
                                /
                                {{ $job->fee_type == 'monthly'
                                    ? 'bulan'
                                    : 'hari'
                                }}
                            </small>

                        </span>

                        {{-- BARIS BARU --}}
                        <div style="flex-basis: 100%; height: 0;"></div>

                    @endif


                    {{-- CERTIFICATE --}}

                    @foreach($certificates as $certificate)

                        <span class="application-badge">
                            {{ $certificate }}
                        </span>

                    @endforeach


                    {{-- COMPETENCY SCHEME --}}

                    @foreach($competencySchemes as $scheme)

                        <span class="application-badge">
                            {{ $scheme }}
                        </span>

                    @endforeach


                    {{-- LOCATION --}}

                    @if($job->city)

                        <span class="application-location">

                            <i class="ki-duotone ki-geolocation"></i>

                            {{ $job->city }}

                        </span>

                    @endif


                    {{-- WORKING SYSTEM --}}

                    @if($job->working_system)

                        <span class="application-location">

                            <i class="ki-duotone ki-time"></i>

                            {{ match ($job->working_system) { 'shift' => 'Shift', 'reliever' => 'Reliever', default => 'Non-Shift' } }}
                        </span>

                    @endif

                </div>


                {{-- =================================================
                    BOTTOM
                ================================================== --}}

                <div class="application-bottom">


                    <span class="application-date">

                        Dikirim

                        {{ $application->created_at
                            ? $application->created_at
                                ->translatedFormat('d M Y')
                            : '-'
                        }}

                    </span>


                    <a
                        href="{{ route(
                            'user-page.job-vacancy.show',
                            $job->uuid
                        ) }}"
                        class="btn-detail">

                        Lihat Detail

                    </a>

                </div>

            </div>

        </div>

    </div>

@empty


    <div class="application-card">

        <div class="text-center py-5">

            <i
                class="ki-duotone ki-briefcase fs-2x mb-3">

            </i>


            <h5>

                Belum Ada Lamaran

            </h5>


            <div class="text-muted">

                Kamu belum memiliki lamaran
                untuk lowongan apa pun.

            </div>

        </div>

    </div>

@endforelse