@forelse($applications as $application)

    @php
        /*
        |--------------------------------------------------------------------------
        | PROFILE PELAMAR BERDASARKAN CATEGORY LOWONGAN
        |--------------------------------------------------------------------------
        */
        $profile = null;

        if (($job->category ?? null) === 'security') {
            $profile = $application->security;
        } elseif (($job->category ?? null) === 'cs') {
            $profile = $application->cleaning_service;
        }
    @endphp

    <div class="card border mb-4">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-start">

                {{-- PROFILE --}}
                <div class="d-flex align-items-center">

                    <div class="symbol symbol-50px symbol-circle me-4 overflow-hidden">

                        @if($profile?->formal_photo)

                            <img
                                src="{{ asset('storage/' . $profile->formal_photo) }}"
                                alt="{{ $profile->name ?? '-' }}"
                                style="width:50px;height:50px;object-fit:cover;"
                            >

                        @else

                            <div class="symbol-label bg-light-primary">

                                <i class="fas fa-user text-primary"></i>

                            </div>

                        @endif

                    </div>

                    <div>

                        <h4 class="fw-bold mb-1">
                            {{ $profile?->name ?? '-' }}
                        </h4>

                        <div class="text-muted">
                            {{ $profile?->email ?? '-' }}
                        </div>

                        <div class="text-muted fs-7 mt-1">

                            Melamar:

                            {{ $application->created_at?->translatedFormat('d F Y H:i') }}

                        </div>

                    </div>

                </div>


                {{-- STATUS --}}
                <div>

                    @switch(strtolower($application->status))

                        @case('applied')

                            <span class="badge badge-light-primary">
                                Applied
                            </span>

                        @break

                        @case('reviewed')

                            <span class="badge badge-light-warning">
                                Reviewed
                            </span>

                        @break

                        @case('shortlisted')

                            <span class="badge badge-light-success">
                                Shortlisted
                            </span>

                        @break

                        @case('rejected')

                            <span class="badge badge-light-danger">
                                Rejected
                            </span>

                        @break

                        @default

                            <span class="badge badge-light-secondary">
                                {{ $application->status }}
                            </span>

                    @endswitch

                </div>

            </div>


            <div class="separator my-4"></div>


            <div class="d-flex justify-content-between align-items-center">

                {{-- IDENTITAS --}}
                <div class="text-muted">

                    <i class="fas fa-id-card me-1"></i>

                    {{ $profile?->ktp_number ?? '-' }}

                </div>


                {{-- DETAIL --}}
                <a
                    href="{{ route(
                        'dashboard-user.job-application.show',
                        [
                            'uuid' => $job->uuid ?? request()->route('uuid'),
                            'application' => $application->id
                        ]
                    ) }}"
                    class="btn btn-sm btn-light-primary"
                >

                    <i class="fas fa-eye me-1"></i>

                    Lihat Detail

                </a>

            </div>

        </div>

    </div>

@empty

    <div class="text-center py-10">

        <i class="fas fa-users fs-3x text-muted mb-4"></i>

        <h4 class="fw-bold">
            Belum Ada Pelamar
        </h4>

        <div class="text-muted">
            Belum ada pelamar untuk lowongan ini.
        </div>

    </div>

@endforelse