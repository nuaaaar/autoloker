@extends('layouts.dashboard-user')

@section('title', 'Statistik Pelatihan')

@section('content')

<div class="container-fluid">

    {{-- ================================================= --}}
    {{-- HEADER --}}
    {{-- ================================================= --}}

    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-7">

        <div>

            <h1 class="fw-bold text-gray-900 mb-2">
                Statistik Pelatihan
            </h1>

            <div class="text-muted">
                Ringkasan performa pelatihan dan peserta Anda
            </div>

        </div>

    </div>


    {{-- ================================================= --}}
    {{-- SUMMARY --}}
    {{-- ================================================= --}}

    <div class="row g-5 mb-7">

        {{-- TOTAL PELATIHAN --}}
        <div class="col-12 col-md-4">

            <div class="card card-flush h-100">

                <div class="card-body d-flex align-items-center">

                    <div class="symbol symbol-55px bg-light-primary me-5">

                        <span class="symbol-label">

                            <i class="ki-duotone ki-book-open fs-2x text-primary">
                            </i>

                        </span>

                    </div>

                    <div class="flex-grow-1">

                        <div class="text-muted fs-7 fw-semibold mb-1">
                            Total Pelatihan
                        </div>

                        <div class="fs-2x fw-bold text-gray-900">
                            {{ $totalTrainings }}
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- PUBLISHED --}}
        <div class="col-12 col-md-4">

            <div class="card card-flush h-100">

                <div class="card-body d-flex align-items-center">

                    <div class="symbol symbol-55px bg-light-success me-5">

                        <span class="symbol-label">

                            <i class="ki-duotone ki-check-circle fs-2x text-success">
                            </i>

                        </span>

                    </div>

                    <div class="flex-grow-1">

                        <div class="text-muted fs-7 fw-semibold mb-1">
                            Published
                        </div>

                        <div class="fs-2x fw-bold text-gray-900">
                            {{ $totalPublished }}
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- DRAFT --}}
        <div class="col-12 col-md-4">

            <div class="card card-flush h-100">

                <div class="card-body d-flex align-items-center">

                    <div class="symbol symbol-55px bg-light-warning me-5">

                        <span class="symbol-label">

                            <i class="ki-duotone ki-pencil fs-2x text-warning">
                            </i>

                        </span>

                    </div>

                    <div class="flex-grow-1">

                        <div class="text-muted fs-7 fw-semibold mb-1">
                            Draft
                        </div>

                        <div class="fs-2x fw-bold text-gray-900">
                            {{ $totalDraft }}
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- CLOSED --}}
        <div class="col-12 col-md-4">

            <div class="card card-flush h-100">

                <div class="card-body d-flex align-items-center">

                    <div class="symbol symbol-55px bg-light-danger me-5">

                        <span class="symbol-label">

                            <i class="ki-duotone ki-cross-circle fs-2x text-danger">
                            </i>

                        </span>

                    </div>

                    <div class="flex-grow-1">

                        <div class="text-muted fs-7 fw-semibold mb-1">
                            Closed
                        </div>

                        <div class="fs-2x fw-bold text-gray-900">
                            {{ $totalClosed }}
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- TOTAL PESERTA --}}
        <div class="col-12 col-md-4">

            <div class="card card-flush h-100">

                <div class="card-body d-flex align-items-center">

                    <div class="symbol symbol-55px bg-light-info me-5">

                        <span class="symbol-label">

                            <i class="ki-duotone ki-people fs-2x text-info">
                            </i>

                        </span>

                    </div>

                    <div class="flex-grow-1">

                        <div class="text-muted fs-7 fw-semibold mb-1">
                            Total Peserta
                        </div>

                        <div class="fs-2x fw-bold text-gray-900">
                            {{ $totalRegistrations }}
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- PESERTA DITERIMA --}}
        <div class="col-12 col-md-4">

            <div class="card card-flush h-100">

                <div class="card-body d-flex align-items-center">

                    <div class="symbol symbol-55px bg-light-primary me-5">

                        <span class="symbol-label">

                            <i class="ki-duotone ki-user-tick fs-2x text-primary">
                            </i>

                        </span>

                    </div>

                    <div class="flex-grow-1">

                        <div class="text-muted fs-7 fw-semibold mb-1">
                            Peserta Diterima
                        </div>

                        <div class="fs-2x fw-bold text-gray-900">
                            {{ $totalAccepted }}
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ================================================= --}}
    {{-- CHART --}}
    {{-- ================================================= --}}

    <div class="row g-5 mb-7">


        {{-- TREND PELATIHAN & PESERTA --}}

        <div class="col-xl-8">

            <div class="card card-flush h-100">

                <div class="card-header">

                    <div class="card-title">

                        <h3 class="fw-bold">
                            Trend Pelatihan & Peserta
                        </h3>

                    </div>

                    <div class="card-toolbar">

                        <span class="text-muted fs-7">
                            6 Bulan Terakhir
                        </span>

                    </div>

                </div>

                <div class="card-body">

                    <div style="height: 350px;">

                        <canvas id="trainingRegistrationChart"></canvas>

                    </div>

                </div>

            </div>

        </div>


        {{-- STATUS PESERTA --}}

        <div class="col-xl-4">

            <div class="card card-flush h-100">

                <div class="card-header">

                    <div class="card-title">

                        <h3 class="fw-bold">
                            Status Peserta
                        </h3>

                    </div>

                </div>

                <div class="card-body">

                    <div style="height: 300px;">

                        <canvas id="registrationStatusChart"></canvas>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ================================================= --}}
    {{-- CONVERSION --}}
    {{-- ================================================= --}}

    <div class="row g-5 mb-7">


        {{-- ACCEPTANCE RATE --}}

        @php

            $acceptanceRate = $totalRegistrations > 0
                ? round(($totalAccepted / $totalRegistrations) * 100, 1)
                : 0;

        @endphp

        <div class="col-md-4">

            <div class="card card-flush">

                <div class="card-body">

                    <div class="text-muted fs-7 mb-2">
                        Acceptance Rate
                    </div>

                    <div class="fs-1 fw-bold text-success">

                        {{ $acceptanceRate }}%

                    </div>

                    <div class="text-muted fs-7 mt-2">

                        {{ $totalAccepted }}
                        dari
                        {{ $totalRegistrations }}
                        peserta

                    </div>

                </div>

            </div>

        </div>


        {{-- REJECTION RATE --}}

        @php

            $rejectionRate = $totalRegistrations > 0
                ? round(($totalRejectedRegistrations / $totalRegistrations) * 100, 1)
                : 0;

        @endphp

        <div class="col-md-4">

            <div class="card card-flush">

                <div class="card-body">

                    <div class="text-muted fs-7 mb-2">
                        Rejection Rate
                    </div>

                    <div class="fs-1 fw-bold text-danger">

                        {{ $rejectionRate }}%

                    </div>

                    <div class="text-muted fs-7 mt-2">

                        {{ $totalRejectedRegistrations }}
                        dari
                        {{ $totalRegistrations }}
                        peserta

                    </div>

                </div>

            </div>

        </div>


        {{-- COMPLETION / PARTICIPATION --}}

        @php

            $participationRate = $totalTrainings > 0
                ? round(($totalPublished / $totalTrainings) * 100, 1)
                : 0;

        @endphp

        <div class="col-md-4">

            <div class="card card-flush">

                <div class="card-body">

                    <div class="text-muted fs-7 mb-2">
                        Publication Rate
                    </div>

                    <div class="fs-1 fw-bold text-primary">

                        {{ $participationRate }}%

                    </div>

                    <div class="text-muted fs-7 mt-2">

                        {{ $totalPublished }}
                        dari
                        {{ $totalTrainings }}
                        pelatihan

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ================================================= --}}
    {{-- TOP TRAINING --}}
    {{-- ================================================= --}}

    <div class="card card-flush mb-7">

        <div class="card-header">

            <div class="card-title">

                <h3 class="fw-bold">
                    Top 5 Pelatihan Berdasarkan Peserta
                </h3>

            </div>

        </div>

        <div class="card-body">

            @php

                $maxRegistrations =
                    $topTrainings->max('applications_count') ?: 1;

            @endphp


            @forelse($topTrainings as $training)

                @php

                    $percentage = $maxRegistrations > 0
                        ? ($training->applications_count / $maxRegistrations) * 100
                        : 0;

                @endphp


                <div class="mb-7">

                    <div class="d-flex justify-content-between align-items-center mb-2">

                        <div class="fw-semibold text-gray-800">

                            {{ $training->title ?? 'Pelatihan Tanpa Nama' }}

                        </div>

                        <div class="text-muted fs-7">

                            {{ $training->applications_count ?? 0 }}
                            peserta

                        </div>

                    </div>


                    <div class="progress h-7px">

                        <div
                            class="progress-bar"
                            role="progressbar"
                            style="width: {{ $percentage }}%"
                            aria-valuenow="{{ $percentage }}"
                            aria-valuemin="0"
                            aria-valuemax="100">
                        </div>

                    </div>

                </div>

            @empty

                <div class="text-center text-muted py-10">

                    <i class="ki-duotone ki-information-5 fs-3x text-muted mb-3"></i>

                    <div>
                        Belum ada data pelatihan.
                    </div>

                </div>

            @endforelse

        </div>

    </div>


</div>

@endsection


@section('js')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

$(document).ready(function () {


    /*
    |--------------------------------------------------------------------------
    | DATA
    |--------------------------------------------------------------------------
    */

    const trainingTrend =
        @json($trainingTrend);

    const registrationTrend =
        @json($registrationTrend);

    const statusChart =
        @json($statusChart);


    /*
    |--------------------------------------------------------------------------
    | THEME COLOR
    |--------------------------------------------------------------------------
    */

    const chartTextColor =
        getComputedStyle(document.documentElement)
            .getPropertyValue('--bs-body-color')
            .trim();

    const chartBorderColor =
        getComputedStyle(document.documentElement)
            .getPropertyValue('--bs-border-color')
            .trim();


    /*
    |--------------------------------------------------------------------------
    | TREND PELATIHAN & PESERTA
    |--------------------------------------------------------------------------
    */

    const trainingRegistrationCanvas =
        document.getElementById(
            'trainingRegistrationChart'
        );


    if (trainingRegistrationCanvas) {

        new Chart(
            trainingRegistrationCanvas,
            {

                type: 'line',

                data: {

                    labels: trainingTrend.map(
                        item => item.label
                    ),

                    datasets: [

                        {

                            label: 'Pelatihan',

                            data: trainingTrend.map(
                                item => item.total
                            ),

                            tension: 0.4,

                            borderWidth: 2,

                            fill: false,

                            pointRadius: 4,

                            pointHoverRadius: 6

                        },

                        {

                            label: 'Peserta',

                            data: registrationTrend.map(
                                item => item.total
                            ),

                            tension: 0.4,

                            borderWidth: 2,

                            fill: false,

                            pointRadius: 4,

                            pointHoverRadius: 6

                        }

                    ]

                },

                options: {

                    responsive: true,

                    maintainAspectRatio: false,

                    interaction: {

                        intersect: false,

                        mode: 'index'

                    },

                    plugins: {

                        legend: {

                            position: 'bottom',

                            labels: {

                                color: chartTextColor

                            }

                        }

                    },

                    scales: {

                        x: {

                            ticks: {

                                color: chartTextColor

                            },

                            grid: {

                                color: chartBorderColor

                            }

                        },

                        y: {

                            beginAtZero: true,

                            ticks: {

                                precision: 0,

                                color: chartTextColor

                            },

                            grid: {

                                color: chartBorderColor

                            }

                        }

                    }

                }

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | STATUS PESERTA
    |--------------------------------------------------------------------------
    */

    const registrationStatusCanvas =
        document.getElementById(
            'registrationStatusChart'
        );

    if (registrationStatusCanvas) {

        new Chart(
            registrationStatusCanvas,
            {

                type: 'doughnut',

                data: {

                    labels: statusChart.map(
                        item => item.label
                    ),

                    datasets: [

                        {

                            data: statusChart.map(
                                item => item.total
                            ),

                            borderWidth: 0

                        }

                    ]

                },

                options: {

                    responsive: true,

                    maintainAspectRatio: false,

                    cutout: '70%',

                    plugins: {

                        legend: {

                            position: 'bottom',

                            labels: {

                                color: chartTextColor,

                                usePointStyle: true,

                                padding: 15

                            }

                        }

                    }

                }

            }
        );

    }

});

</script>

@endsection