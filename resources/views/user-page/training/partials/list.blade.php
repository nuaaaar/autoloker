@forelse($trainings as $training)

    @php

        /*
        |--------------------------------------------------------------------------
        | QUOTA
        |--------------------------------------------------------------------------
        */

        $quota = (int) (
            $training->quota ?? 0
        );

        $registered = (int) (
            $training->registered_count ?? 0
        );


        /*
        |--------------------------------------------------------------------------
        | PERCENTAGE
        |--------------------------------------------------------------------------
        */

        $percentage = $quota > 0
            ? min(
                100,
                round(
                    ($registered / $quota) * 100
                )
            )
            : 0;


        /*
        |--------------------------------------------------------------------------
        | FULL
        |--------------------------------------------------------------------------
        */

        $isFull =
            $quota > 0
            && $registered >= $quota;


        /*
        |--------------------------------------------------------------------------
        | PROVIDER
        |--------------------------------------------------------------------------
        */

        $providerName =
            $training->provider?->name
            ?? $training->provider
            ?? '-';


        /*
        |--------------------------------------------------------------------------
        | PRICE
        |--------------------------------------------------------------------------
        */

        $price = isset($training->price)
            ? (float) $training->price
            : 0;


        /*
        |--------------------------------------------------------------------------
        | IS FREE
        |--------------------------------------------------------------------------
        */

        $isFree =
            isset($training->is_free)
            ? (bool) $training->is_free
            : $price <= 0;

    @endphp


    {{-- =========================================================
         TRAINING CARD
    ========================================================== --}}

    <div class="card training-card mb-3">

        <div class="card-body">


            {{-- =================================================
                 TITLE
            ================================================== --}}

            <div class="d-flex justify-content-between align-items-start flex-wrap">

                <div>

                    <div class="d-flex align-items-center flex-wrap gap-2">


                        {{-- =================================================
                             TITLE
                        ================================================== --}}

                        <h4 class="training-name mb-0">

                            {{ $training->title ?? '-' }}

                        </h4>


                        {{-- =================================================
                             CERTIFICATE
                        ================================================== --}}

                        @if(
                            isset($training->is_certificate)
                            && $training->is_certificate
                        )

                            <span class="training-badge badge-green">

                                Bersertifikat

                            </span>

                        @endif


                        {{-- =================================================
                             PROVIDER TYPE
                        ================================================== --}}

                        @if(!empty($training->provider_type))

                            <span class="training-badge badge-green">

                                {{ $training->provider_type }}

                            </span>

                        @endif


                        {{-- =================================================
                             STATUS
                        ================================================== --}}

                        @if(($training->status ?? null) === 'running')

                            <span class="training-badge badge-yellow">

                                Sedang Berjalan

                            </span>

                        @else

                            <span class="training-badge badge-blue">

                                Terdaftar

                            </span>

                        @endif


                    </div>


                    {{-- =================================================
                         PROVIDER
                    ================================================== --}}

                    <div class="training-provider mt-1">

                        {{ $providerName }}

                    </div>

                </div>

            </div>



            {{-- =========================================================
                 INFO
            ========================================================== --}}

            <div class="training-info mt-4">


                {{-- =================================================
                     DATE
                ================================================== --}}

                @if($training->start_date)

                    <span>

                        <i class="ki-duotone ki-calendar fs-6">

                            <span class="path1"></span>
                            <span class="path2"></span>

                        </i>

                        {{ \Carbon\Carbon::parse(
                            $training->start_date
                        )->translatedFormat('d M Y') }}


                        @if($training->end_date)

                            -

                            {{ \Carbon\Carbon::parse(
                                $training->end_date
                            )->translatedFormat('d M Y') }}

                        @endif

                    </span>

                @endif



                {{-- =================================================
                     DURATION
                ================================================== --}}

                @if(
                    !empty($training->duration_day)
                    || !empty($training->duration)
                )

                    <span>

                        <i class="ki-duotone ki-book fs-6">

                            <span class="path1"></span>
                            <span class="path2"></span>

                        </i>

                        @if(!empty($training->duration_day))

                            {{ $training->duration_day }}
                            Hari

                        @else

                            {{ $training->duration }}

                        @endif

                    </span>

                @endif



                {{-- =================================================
                     MODE
                ================================================== --}}

                @if(!empty($training->training_mode))

                    <span>

                        <i class="ki-duotone ki-geolocation fs-6">

                            <span class="path1"></span>
                            <span class="path2"></span>

                        </i>

                        {{ ucfirst(
                            $training->training_mode
                        ) }}

                    </span>

                @elseif(!empty($training->location))

                    <span>

                        <i class="ki-duotone ki-geolocation fs-6">

                            <span class="path1"></span>
                            <span class="path2"></span>

                        </i>

                        {{ $training->location }}

                    </span>

                @endif


            </div>



            {{-- =========================================================
                 QUOTA + PRICE
            ========================================================== --}}

            <div class="d-flex justify-content-between align-items-center mt-4">


                {{-- =================================================
                     QUOTA
                ================================================== --}}

                <div class="training-quota">

                    Kuota :

                    <strong>

                        {{ $registered }}/{{ $quota }}

                    </strong>

                </div>



                {{-- =================================================
                     PRICE
                ================================================== --}}

                <div class="training-price">

                    @if($isFree)

                        Gratis

                    @elseif($price > 0)

                        Rp
                        {{ number_format(
                            $price,
                            0,
                            ',',
                            '.'
                        ) }}

                    @else

                        -

                    @endif

                </div>


            </div>



            {{-- =========================================================
                 PROGRESS
            ========================================================== --}}

            @if($quota > 0)

                <div class="progress training-progress mt-2">

                    <div
                        class="progress-bar"
                        role="progressbar"
                        style="width: {{ $percentage }}%;"
                        aria-valuenow="{{ $percentage }}"
                        aria-valuemin="0"
                        aria-valuemax="100"
                    ></div>

                </div>

            @endif



            {{-- =========================================================
                 BUTTON
            ========================================================== --}}

            @if($isFull)

                {{-- =================================================
                     FULL
                ================================================== --}}

                <div
                    class="btn-training-register mt-4 w-100"
                    style="
                        opacity: .6;
                        cursor: not-allowed;
                    "
                >

                    <i class="ki-duotone ki-users fs-7 me-1">

                        <span class="path1"></span>
                        <span class="path2"></span>

                    </i>

                    Kuota Penuh

                </div>

            @else

                {{-- =================================================
                     DETAIL
                ================================================== --}}

                <a
                    href="{{ route(
                        'user-page.training.show',
                        $training->uuid
                    ) }}"
                    class="btn-training-register mt-4 w-100"
                >

                    <i class="ki-duotone ki-eye fs-7 me-1">

                        <span class="path1"></span>
                        <span class="path2"></span>

                    </i>

                    Lihat Detail Pelatihan

                </a>

            @endif


        </div>

    </div>


@empty


    {{-- =========================================================
         EMPTY
    ========================================================== --}}

    <div class="card training-card">

        <div class="card-body">

            <div class="training-empty">

                <i class="ki-duotone ki-book-open">

                    <span class="path1"></span>
                    <span class="path2"></span>

                </i>

                <div>

                    Tidak ada pelatihan yang ditemukan.

                </div>


                @if(request('search'))

                    <div class="mt-2">

                        Coba gunakan kata kunci lain.

                    </div>

                @endif

            </div>

        </div>

    </div>

@endforelse