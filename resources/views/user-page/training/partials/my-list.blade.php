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

        $trainingStatus = $training->status;

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

            /*
            |--------------------------------------------------------------------------
            | DEFAULT
            |--------------------------------------------------------------------------
            */

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

        $provider = $training->provider
            ?? '-';


        /*
        |--------------------------------------------------------------------------
        | LEVEL
        |--------------------------------------------------------------------------
        */

        $level = $training->level
            ?? null;


        /*
        |--------------------------------------------------------------------------
        | CATEGORY
        |--------------------------------------------------------------------------
        */

        $category = $training->category
            ?? null;


        /*
        |--------------------------------------------------------------------------
        | TRAINING MODE
        |--------------------------------------------------------------------------
        */

        $trainingMode = $training->training_mode
            ?? 'offline';


        /*
        |--------------------------------------------------------------------------
        | MODE LABEL
        |--------------------------------------------------------------------------
        */

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

                $modeLabel = ucfirst(
                    $trainingMode
                );

                break;

        }


        /*
        |--------------------------------------------------------------------------
        | DATE
        |--------------------------------------------------------------------------
        */

        $startDate = $training->start_date
            ?? null;

        $endDate = $training->end_date
            ?? null;


        /*
        |--------------------------------------------------------------------------
        | LOCATION
        |--------------------------------------------------------------------------
        */

        $location = $training->address
            ?? null;


        /*
        |--------------------------------------------------------------------------
        | DURATION
        |--------------------------------------------------------------------------
        */

        $duration = $training->duration_day
            ?? null;


        /*
        |--------------------------------------------------------------------------
        | TOTAL JP
        |--------------------------------------------------------------------------
        */

        $totalJp = $training->total_jp
            ?? null;


        /*
        |--------------------------------------------------------------------------
        | REGISTERED DATE
        |--------------------------------------------------------------------------
        */

        $registeredDate = $application->created_at
            ?? null;


        /*
        |--------------------------------------------------------------------------
        | PRICE
        |--------------------------------------------------------------------------
        */

        $isFree = $training->is_free;

        $price = $training->price;


        /*
        |--------------------------------------------------------------------------
        | UUID
        |--------------------------------------------------------------------------
        */

        $uuid = $training->uuid;


    @endphp


    <div
        class="training-card

        {{ $displayStatus === 'completed'
            ? 'training-card-completed'
            : ''
        }}

        {{ $displayStatus === 'cancelled'
            ? 'training-card-cancelled'
            : ''
        }}"
    >


        {{-- =====================================================
            TOP
        ====================================================== --}}

        <div class="training-card-top">


            <div class="training-content">


                {{-- =================================================
                    TITLE ROW
                ================================================== --}}

                <div class="training-title-row">


                    <div class="training-title-wrapper">


                        {{-- =================================================
                            CATEGORY + MODE
                        ================================================== --}}

                        <div class="training-type-row">

                            @if($category)

                                <span class="training-category">
                                    {{ $category }}
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

                        <span
                            class="training-status-badge
                            {{ $status['class'] }}"
                        >

                            {{ $status['label'] }}

                        </span>

                    </div>

                </div>


                {{-- =================================================
                    META
                ================================================== --}}

                <div class="training-meta">


                    {{-- =================================================
                        DATE
                    ================================================== --}}

                    @if($startDate)

                        <span class="training-meta-item">

                            <i class="ki-duotone ki-calendar-8">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>

                            {{ \Carbon\Carbon::parse($startDate)
                                ->translatedFormat('Y-m-d')
                            }}

                            @if($endDate)

                                –

                                {{ \Carbon\Carbon::parse($endDate)
                                    ->translatedFormat('Y-m-d')
                                }}

                            @endif

                        </span>

                    @endif


                    {{-- =================================================
                        LOCATION
                    ================================================== --}}

                    @if(
                        $location
                        && $trainingMode !== 'online'
                    )

                        <span class="training-meta-item">

                            <i class="ki-duotone ki-geolocation">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>

                            {{ $location }}

                        </span>

                    @endif


                    {{-- =================================================
                        DURATION
                    ================================================== --}}

                    @if($duration)

                        <span class="training-meta-item">

                            <i class="ki-duotone ki-book-open">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>

                            {{ $duration }} Hari

                        </span>

                    @endif


                    {{-- =================================================
                        TOTAL JP
                    ================================================== --}}

                    @if($totalJp)

                        <span class="training-meta-item">

                            <i class="ki-duotone ki-time">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>

                            {{ $totalJp }} JP

                        </span>

                    @endif


                    {{-- =================================================
                        LEVEL
                    ================================================== --}}

                    @if($level)

                        <span class="training-meta-item">

                            <i class="ki-duotone ki-star">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>

                            {{ $level }}

                        </span>

                    @endif

                </div>


                {{-- =================================================
                    ONGOING
                ================================================== --}}

                @if($displayStatus === 'ongoing')

                    <div class="training-upcoming-notice">

                        <i class="ki-duotone ki-time">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>

                        <span>
                            Pelatihan sedang berlangsung
                        </span>

                    </div>

                @endif


                {{-- =================================================
                    UPCOMING
                ================================================== --}}

                @if($displayStatus === 'upcoming')

                    <div class="training-upcoming-notice">

                        <i class="ki-duotone ki-time">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>

                        <span>
                            Segera dimulai
                        </span>

                    </div>

                @endif


                {{-- =================================================
                    COMPLETED
                ================================================== --}}

                @if($displayStatus === 'completed')

                    <div class="training-completed-notice">

                        <i class="ki-duotone ki-check-circle">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>

                        <span>
                            Pelatihan telah selesai
                        </span>

                    </div>

                @endif


                {{-- =================================================
                    CANCELLED
                ================================================== --}}

                @if($displayStatus === 'cancelled')

                    <div class="training-completed-notice">

                        <i class="ki-duotone ki-cross-circle">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>

                        <span>
                            Pelatihan dibatalkan
                        </span>

                    </div>

                @endif


                {{-- =================================================
                    BOTTOM
                ================================================== --}}

                <div class="training-bottom">


                    <span class="training-registered">


                        @if($registeredDate)

                            Terdaftar

                            {{ \Carbon\Carbon::parse($registeredDate)
                                ->translatedFormat('Y-m-d')
                            }}

                        @endif


                        {{-- =================================================
                            GRATIS
                        ================================================== --}}

                        @if(
                            $isFree === '1'
                            || $isFree === 1
                            || $isFree === true
                            || $isFree === 'true'
                        )

                            · Gratis


                        {{-- =================================================
                            BERBAYAR
                        ================================================== --}}

                        @elseif($price !== null && $price !== '')

                            · Rp
                            {{ number_format(
                                (float) $price,
                                0,
                                ',',
                                '.'
                            ) }}

                        @endif


                    </span>


                    {{-- =================================================
                        DETAIL
                    ================================================== --}}

                    <a
                        href="{{ route(
                            'user-page.training.show',
                            $uuid
                        ) }}"
                        class="btn-training-detail"
                    >

                        Lihat Detail

                    </a>


                </div>

            </div>

        </div>

    </div>


@empty


    {{-- =========================================================
        EMPTY
    ========================================================== --}}

    <div class="training-card">

        <div class="training-empty">


            <div class="training-empty-icon">

                <i class="ki-duotone ki-teacher">

                    <span class="path1"></span>

                    <span class="path2"></span>

                </i>

            </div>


            <h5>
                Belum Ada Pelatihan
            </h5>


            <div class="training-empty-text">

                Kamu belum mengikuti pelatihan apa pun.

            </div>


            <a
                href="{{ route(
                    'user-page.training.index'
                ) }}"
                class="btn-search-training mt-3"
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