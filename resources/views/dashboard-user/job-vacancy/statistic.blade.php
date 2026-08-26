@extends('layouts.dashboard-user')

@section('title', 'Statistik Lowongan')

@section('content')

<div class="container-fluid">

    {{-- ================================================= --}}
    {{-- HEADER --}}
    {{-- ================================================= --}}

    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-7">

        <div>

            <h1 class="fw-bold text-gray-900 mb-2">
                Statistik Lowongan
            </h1>

            <div class="text-muted">
                Ringkasan performa lowongan dan pelamar Anda
            </div>

        </div>

    </div>


    {{-- ================================================= --}}
    {{-- SUMMARY --}}
    {{-- ================================================= --}}

    <div class="row g-5 mb-7">

        {{-- ================================================= --}}
        {{-- ROW 1 --}}
        {{-- ================================================= --}}

        {{-- TOTAL LOWONGAN --}}
        <div class="col-12 col-md-4">

            <div class="card card-flush h-100">

                <div class="card-body d-flex align-items-center">

                    <div class="symbol symbol-55px bg-light-primary me-5">

                        <span class="symbol-label">

                            <i class="ki-duotone ki-briefcase fs-2x text-primary">
                            </i>

                        </span>

                    </div>

                    <div class="flex-grow-1">

                        <div class="text-muted fs-7 fw-semibold mb-1">
                            Total Lowongan
                        </div>

                        <div class="fs-2x fw-bold text-gray-900">
                            {{ $totalJobs }}
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
                            {{ $publishedJobs }}
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
                            {{ $draftJobs }}
                        </div>

                    </div>

                </div>

            </div>

        </div>



        {{-- ================================================= --}}
        {{-- ROW 2 --}}
        {{-- ================================================= --}}

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
                            {{ $closedJobs }}
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- TOTAL PELAMAR --}}
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
                            Total Pelamar
                        </div>

                        <div class="fs-2x fw-bold text-gray-900">
                            {{ $totalApplications }}
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- PELAMAR AKTIF --}}
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
                            Pelamar Aktif
                        </div>

                        <div class="fs-2x fw-bold text-gray-900">
                            {{ $activeApplications }}
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


        {{-- TREND --}}

        <div class="col-xl-8">

        <div class="card card-flush h-100">

            <div class="card-header">

                <div class="card-title">

                    <h3 class="fw-bold">
                        Trend Lowongan & Pelamar
                    </h3>

                </div>

                <div class="card-toolbar">

                    <span class="text-muted fs-7">
                        Tahun {{ now()->year }}
                    </span>

                </div>

            </div>

            <div class="card-body">

                <div style="height: 350px;">

                    <canvas id="jobApplicationChart"></canvas>

                </div>

            </div>

        </div>

    </div>


        {{-- STATUS PELAMAR --}}

        <div class="col-xl-4">

            <div class="card card-flush h-100">

                <div class="card-header">

                    <div class="card-title">

                        <h3 class="fw-bold">
                            Status Pelamar
                        </h3>

                    </div>

                </div>

                <div class="card-body">

                    <canvas
                        id="applicationStatusChart"
                        height="250">
                    </canvas>

                </div>

            </div>

        </div>

    </div>


    {{-- ================================================= --}}
    {{-- CONVERSION --}}
    {{-- ================================================= --}}

    <div class="row g-5 mb-7">


        <div class="col-md-4">

            <div class="card card-flush">

                <div class="card-body">

                    <div class="text-muted fs-7 mb-2">
                        Review Rate
                    </div>

                    <div class="fs-1 fw-bold text-primary">

                        {{ $reviewRate }}%

                    </div>

                    <div class="text-muted fs-7 mt-2">

                        {{ $reviewedApplications }}
                        dari
                        {{ $totalApplications }}
                        pelamar

                    </div>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="card card-flush">

                <div class="card-body">

                    <div class="text-muted fs-7 mb-2">
                        Shortlist Rate
                    </div>

                    <div class="fs-1 fw-bold text-success">

                        {{ $shortlistRate }}%

                    </div>

                    <div class="text-muted fs-7 mt-2">

                        {{ $shortlistedApplications }}
                        dari
                        {{ $totalApplications }}
                        pelamar

                    </div>

                </div>

            </div>

        </div>


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

                        {{ $rejectedApplications }}
                        dari
                        {{ $totalApplications }}
                        pelamar

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ================================================= --}}
    {{-- TOP LOWONGAN --}}
    {{-- ================================================= --}}

    <div class="card card-flush mb-7">

        <div class="card-header">

            <div class="card-title">

                <h3 class="fw-bold">
                    Top 5 Lowongan Berdasarkan Pelamar
                </h3>

            </div>

        </div>

        <div class="card-body">

            @php

                $maxApplicants = $topJobs->max('applications_count') ?: 1;

            @endphp


            @forelse($topJobs as $job)

                @php

                    $percentage = $maxApplicants > 0
                        ? ($job->applications_count / $maxApplicants) * 100
                        : 0;

                @endphp


                <div class="mb-7">

                    <div class="d-flex justify-content-between align-items-center mb-2">

                        <div class="fw-semibold text-gray-800">

                            {{ $job->position ?? 'Lowongan Tanpa Nama' }}

                        </div>

                        <div class="text-muted fs-7">

                            {{ $job->applications_count ?? 0 }}
                            pelamar

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
                        Belum ada data lowongan.
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

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | TREND CHART
    |--------------------------------------------------------------------------
    */

    const jobApplicationCanvas =
        document.getElementById(
            'jobApplicationChart'
        );

    if (jobApplicationCanvas) {

        new Chart(
            jobApplicationCanvas,
            {

                type: 'line',

                data: {

                    labels: @json($monthLabels),

                    datasets: [

                        {
                            label: 'Lowongan',

                            data: @json($jobChartData),

                            tension: 0.4,

                            borderWidth: 2,

                            fill: false
                        },

                        {
                            label: 'Pelamar',

                            data: @json($applicationChartData),

                            tension: 0.4,

                            borderWidth: 2,

                            fill: false
                        }

                    ]

                },

                options: {

                    responsive: true,

                    maintainAspectRatio: false,

                    plugins: {

                        legend: {

                            position: 'bottom'

                        }

                    },

                    scales: {

                        y: {

                            beginAtZero: true,

                            ticks: {

                                precision: 0

                            }

                        }

                    }

                }

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | APPLICATION STATUS CHART
    |--------------------------------------------------------------------------
    */

    const statusCanvas =
        document.getElementById(
            'applicationStatusChart'
        );

    if (statusCanvas) {

        new Chart(
            statusCanvas,
            {

                type: 'doughnut',

                data: {

                    labels: [

                        'Applied',
                        'Reviewed',
                        'Shortlisted',
                        'Rejected'

                    ],

                    datasets: [

                        {

                            data: [

                                {{ $appliedApplications }},
                                {{ $reviewedApplications }},
                                {{ $shortlistedApplications }},
                                {{ $rejectedApplications }}

                            ],

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

                            position: 'bottom'

                        }

                    }

                }

            }
        );

    }

});

</script>

@endsection