<!-- Reminder -->
@if($security->reminderCertificate)

    @php
        $certificate = $security->reminderCertificate;
        $isExpired = \Carbon\Carbon::parse($certificate->expired_date)->isPast();
    @endphp

    <div class="card reminder-card mb-4">

        <div class="card-body">

            <div class="reminder-box">

                <i class="ki-duotone ki-information-5 reminder-icon"></i>

                <div>

                    <div class="reminder-title">
                        {{ $isExpired
                            ? 'Sertifikat Sudah Berakhir'
                            : 'Sertifikat Segera Berakhir'
                        }}
                    </div>

                    <div class="reminder-text">

                        {{ $certificate->title }}

                        {{ $isExpired ? 'berakhir pada' : 'akan berakhir' }}

                        <br>

                        <strong>
                            {{ \Carbon\Carbon::parse($certificate->expired_date)->translatedFormat('d M Y') }}
                        </strong>

                    </div>

                    <a href="{{ route('user-page.profile') }}" class="reminder-link">
                        Perpanjang sekarang →
                    </a>

                </div>

            </div>

        </div>

    </div>

@endif

<!-- LOWONGAN -->

<div class="card mb-4">

    <div class="card-body">

        <div class="right-title">

            <h5>Lowongan Sesuai Profil</h5>

            <a href="{{ route('user-page.job-vacancy.index') }}">
                Lihat semua
            </a>

        </div>


        @forelse($recommendedJobs as $job)
            <div style="margin-bottom: 10px !important;">
                <a
                    href="{{ route(
                        'user-page.job-vacancy.show',
                        $job->uuid
                    ) }}"
                    class="job-item text-decoration-none"
                >

                    <div class="job-title">

                        {{ $job->position ?? '-' }}

                        @if($job->is_urgent ?? false)

                            <span class="urgent">
                                ⚡ Urgent
                            </span>

                        @endif

                    </div>


                    <div class="job-company">

                        {{ $job->bujp?->company_name
                            ?? $job->company?->company_name
                            ?? '-' }}

                        ·

                        {{ $job->city ?? '-' }}

                    </div>


                    <div class="job-bottom">

                        @if($job->is_show_fee)

                            <div class="salary">

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

                            </div>

                        @endif

                    </div>

                </a>
            </div>
        @empty

            <div class="text-muted small py-3">

                Belum ada lowongan yang sesuai dengan profil Anda.

            </div>

        @endforelse

    </div>

</div>

<!-- PELATIHAN -->

<div class="card">

    <div class="card-body">

        <div class="right-title">

            <h5>Pelatihan Unggulan</h5>

        </div>

        @forelse($featuredTrainings as $training)

            <a
                href="{{ route('user-page.training.show', $training->uuid) }}"
                class="training-item text-decoration-none d-block"
            >

                <div class="training-title">

                    {{ $training->title }}

                </div>

                <div class="training-org">

                    {{ $training->provider }}

                    @if($training->is_certificate)

                        <span class="bnsp">
                            • Bersertifikat
                        </span>

                    @endif

                </div>

                <div class="training-date">

                    {{ \Carbon\Carbon::parse($training->start_date)->format('d M Y') }}

                </div>

            </a>

        @empty

            <div class="text-muted text-center py-4">

                Belum ada pelatihan tersedia.

            </div>

        @endforelse

    </div>

</div>

<div class="right-footer">

    Autoloker © 2026 ·
    <a href="javascript:;">Kebijakan Privasi</a> ·
    <a href="javascript:;">Syarat Layanan</a>

</div>