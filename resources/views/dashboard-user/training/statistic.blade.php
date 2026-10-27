
@extends('layouts.dashboard-user')

@section('title', 'Statistik Pelatihan')

@section('css')
<style>
    .training-statistic .stat-card {
        border: 1px solid var(--bs-border-color);
        border-radius: 12px;
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .training-statistic .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, .06);
    }

    .training-statistic .stat-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 52px;
        height: 52px;
        flex-shrink: 0;
        border-radius: 12px;
    }

    .training-statistic .chart-container {
        position: relative;
        width: 100%;
        height: 330px;
    }

    .training-statistic .status-chart-container {
        position: relative;
        width: 100%;
        height: 290px;
    }

    .training-statistic .stat-value {
        font-size: 28px;
        font-weight: 700;
        line-height: 1.3;
        color: var(--bs-heading-color, var(--bs-body-color));
    }

    .training-statistic .stat-label {
        font-size: 13px;
        font-weight: 600;
        color: var(--bs-secondary-color);
    }

    .training-statistic .section-title {
        font-size: 17px;
        font-weight: 700;
    }

    .training-statistic .progress {
        background-color: var(--bs-secondary-bg);
        border-radius: 10px;
        overflow: hidden;
    }

    .training-statistic .progress-bar {
        border-radius: 10px;
        transition: width .5s ease;
    }

    .training-statistic .top-training-item:last-child {
        margin-bottom: 0 !important;
    }

    @media (max-width: 767px) {
        .training-statistic .chart-container {
            height: 280px;
        }

        .training-statistic .status-chart-container {
            height: 260px;
        }

        .training-statistic .stat-value {
            font-size: 24px;
        }
    }
</style>
@endsection

@section('content')

<div class="container-fluid training-statistic">

    {{-- HEADER --}}
    <div class="d-flex flex-column flex-md-row
                align-items-md-center justify-content-between mb-7">

        <div>
            <h1 class="fw-bold text-gray-900 mb-2">
                Statistik Pelatihan
            </h1>

            <div class="text-muted">
                Ringkasan performa pelatihan dan peserta Anda.
            </div>

            @if(isset($bujp))
                <div class="text-muted fs-7 mt-2">
                    <i class="ki-duotone ki-office-bag fs-5 me-1">
                    </i>
                    {{ $bujp->name ?? $bujp->company_name ?? 'Data organisasi' }}
                </div>
            @endif
        </div>

        <div class="text-muted fs-7 mt-3 mt-md-0">
            <i class="ki-duotone ki-calendar fs-5 me-1"></i>
            Tahun {{ now()->year }}
        </div>

    </div>

    {{-- ================================================= --}}
    {{-- SUMMARY --}}
    {{-- ================================================= --}}

    <div class="row g-5 mb-7">

        {{-- TOTAL PELATIHAN --}}
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card card-flush stat-card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="stat-icon bg-light-primary me-4">
                        <i class="ki-duotone ki-book-open fs-2x text-primary"></i>
                    </div>

                    <div class="flex-grow-1">
                        <div class="stat-label mb-1">
                            Total Pelatihan
                        </div>
                        <div class="stat-value">
                            {{ number_format($totalTrainings, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- PUBLISHED --}}
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card card-flush stat-card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="stat-icon bg-light-success me-4">
                        <i class="ki-duotone ki-check-circle fs-2x text-success"></i>
                    </div>

                    <div class="flex-grow-1">
                        <div class="stat-label mb-1">
                            Published
                        </div>
                        <div class="stat-value">
                            {{ number_format($totalPublished, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- DRAFT --}}
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card card-flush stat-card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="stat-icon bg-light-warning me-4">
                        <i class="ki-duotone ki-pencil fs-2x text-warning"></i>
                    </div>

                    <div class="flex-grow-1">
                        <div class="stat-label mb-1">
                            Draft
                        </div>
                        <div class="stat-value">
                            {{ number_format($totalDraft, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- CLOSED --}}
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card card-flush stat-card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="stat-icon bg-light-danger me-4">
                        <i class="ki-duotone ki-cross-circle fs-2x text-danger"></i>
                    </div>

                    <div class="flex-grow-1">
                        <div class="stat-label mb-1">
                            Closed
                        </div>
                        <div class="stat-value">
                            {{ number_format($totalClosed, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TOTAL PENDAFTAR --}}
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card card-flush stat-card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="stat-icon bg-light-info me-4">
                        <i class="ki-duotone ki-people fs-2x text-info"></i>
                    </div>

                    <div class="flex-grow-1">
                        <div class="stat-label mb-1">
                            Total Pendaftar
                        </div>
                        <div class="stat-value">
                            {{ number_format($totalRegistrations, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- PESERTA AKTIF --}}
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card card-flush stat-card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="stat-icon bg-light-primary me-4">
                        <i class="ki-duotone ki-user-tick fs-2x text-primary"></i>
                    </div>

                    <div class="flex-grow-1">
                        <div class="stat-label mb-1">
                            Pendaftar Aktif
                        </div>
                        <div class="stat-value">
                            {{ number_format($activeRegistrations, 0, ',', '.') }}
                        </div>
                        <div class="text-muted fs-8 mt-1">
                            Pending + Approved
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

        {{-- TREND BULANAN --}}
        <div class="col-12 col-xl-8">
            <div class="card card-flush stat-card h-100">

                <div class="card-header">
                    <div class="card-title">
                        <div>
                            <h3 class="section-title mb-1">
                                Trend Pelatihan & Pendaftar
                            </h3>
                            <div class="text-muted fs-7">
                                Perbandingan aktivitas bulanan
                            </div>
                        </div>
                    </div>

                    <div class="card-toolbar">
                        <span class="badge badge-light-primary">
                            {{ now()->year }}
                        </span>
                    </div>
                </div>

                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="trainingRegistrationChart"></canvas>
                    </div>
                </div>

            </div>
        </div>

        {{-- STATUS PENDAFTAR --}}
        <div class="col-12 col-xl-4">
            <div class="card card-flush stat-card h-100">

                <div class="card-header">
                    <div class="card-title">
                        <div>
                            <h3 class="section-title mb-1">
                                Status Pendaftar
                            </h3>
                            <div class="text-muted fs-7">
                                Distribusi status pendaftaran
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="status-chart-container">
                        <canvas id="registrationStatusChart"></canvas>
                    </div>
                </div>

            </div>
        </div>

    </div>

    {{-- ================================================= --}}
    {{-- CONVERSION RATE --}}
    {{-- ================================================= --}}

    <div class="row g-5 mb-7">

        {{-- ACCEPTANCE RATE --}}
        <div class="col-12 col-md-4">
            <div class="card card-flush stat-card h-100">
                <div class="card-body">

                    <div class="d-flex align-items-center mb-3">
                        <div class="stat-icon bg-light-success me-3"
                             style="width:42px;height:42px;">
                            <i class="ki-duotone ki-user-tick fs-2 text-success"></i>
                        </div>

                        <div class="stat-label">
                            Acceptance Rate
                        </div>
                    </div>

                    <div class="fs-1 fw-bold text-success">
                        {{ $acceptanceRate }}%
                    </div>

                    <div class="text-muted fs-7 mt-2">
                        {{ $totalAccepted }} dari
                        {{ $totalRegistrations }} pendaftar diterima
                    </div>

                    <div class="progress h-6px mt-4">
                        <div class="progress-bar bg-success"
                             role="progressbar"
                             style="width: {{ min(100, max(0, $acceptanceRate)) }}%"
                             aria-valuenow="{{ $acceptanceRate }}"
                             aria-valuemin="0"
                             aria-valuemax="100">
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- REJECTION RATE --}}
        <div class="col-12 col-md-4">
            <div class="card card-flush stat-card h-100">
                <div class="card-body">

                    <div class="d-flex align-items-center mb-3">
                        <div class="stat-icon bg-light-danger me-3"
                             style="width:42px;height:42px;">
                            <i class="ki-duotone ki-cross-circle fs-2 text-danger"></i>
                        </div>

                        <div class="stat-label">
                            Rejection Rate
                        </div>
                    </div>

                    <div class="fs-1 fw-bold text-danger">
                        {{ $rejectionRate }}%
                    </div>

                    <div class="text-muted fs-7 mt-2">
                        {{ $totalRejectedRegistrations }} dari
                        {{ $totalRegistrations }} pendaftar ditolak
                    </div>

                    <div class="progress h-6px mt-4">
                        <div class="progress-bar bg-danger"
                             role="progressbar"
                             style="width: {{ min(100, max(0, $rejectionRate)) }}%"
                             aria-valuenow="{{ $rejectionRate }}"
                             aria-valuemin="0"
                             aria-valuemax="100">
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- PUBLICATION RATE --}}
        <div class="col-12 col-md-4">
            <div class="card card-flush stat-card h-100">
                <div class="card-body">

                    <div class="d-flex align-items-center mb-3">
                        <div class="stat-icon bg-light-primary me-3"
                             style="width:42px;height:42px;">
                            <i class="ki-duotone ki-book-open fs-2 text-primary"></i>
                        </div>

                        <div class="stat-label">
                            Publication Rate
                        </div>
                    </div>

                    <div class="fs-1 fw-bold text-primary">
                        {{ $publicationRate }}%
                    </div>

                    <div class="text-muted fs-7 mt-2">
                        {{ $totalPublished }} dari
                        {{ $totalTrainings }} pelatihan dipublikasikan
                    </div>

                    <div class="progress h-6px mt-4">
                        <div class="progress-bar bg-primary"
                             role="progressbar"
                             style="width: {{ min(100, max(0, $publicationRate)) }}%"
                             aria-valuenow="{{ $publicationRate }}"
                             aria-valuemin="0"
                             aria-valuemax="100">
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

    {{-- ================================================= --}}
    {{-- TOP 5 TRAINING --}}
    {{-- ================================================= --}}

    <div class="card card-flush stat-card mb-7">

        <div class="card-header">
            <div class="card-title">
                <div>
                    <h3 class="section-title mb-1">
                        Top 5 Pelatihan Berdasarkan Pendaftar
                    </h3>
                    <div class="text-muted fs-7">
                        Pelatihan dengan jumlah pendaftar terbanyak
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">

            @php
                $maxRegistrations = $topTrainings->max(
                    'applications_count'
                ) ?: 1;
            @endphp

            @forelse($topTrainings as $training)

                @php
                    $percentage = (
                        $training->applications_count / $maxRegistrations
                    ) * 100;

                    $statusClasses = [
                        'published' => 'badge-light-success',
                        'draft' => 'badge-light-warning',
                        'closed' => 'badge-light-danger',
                        'rejected' => 'badge-light-danger',
                    ];

                    $statusLabels = [
                        'published' => 'Published',
                        'draft' => 'Draft',
                        'closed' => 'Closed',
                        'rejected' => 'Rejected',
                    ];

                    $statusClass = $statusClasses[$training->status]
                        ?? 'badge-light-secondary';

                    $statusLabel = $statusLabels[$training->status]
                        ?? ucfirst($training->status ?? 'Unknown');
                @endphp

                <div class="top-training-item mb-7">

                    <div class="d-flex flex-column flex-sm-row
                                justify-content-between
                                align-items-sm-center gap-2 mb-3">

                        <div class="flex-grow-1">
                            <div class="fw-bold text-gray-800 mb-2">
                                {{ $training->title ?? 'Pelatihan Tanpa Nama' }}
                            </div>

                            <span class="badge {{ $statusClass }}">
                                {{ $statusLabel }}
                            </span>
                        </div>

                        <div class="text-sm-end">
                            <div class="fw-bold text-gray-900">
                                {{ number_format(
                                    $training->applications_count,
                                    0,
                                    ',',
                                    '.'
                                ) }}
                                pendaftar
                            </div>

                            <div class="text-muted fs-8">
                                {{ number_format($percentage, 0) }}%
                                dari nilai tertinggi
                            </div>
                        </div>

                    </div>

                    <div class="progress h-7px">
                        <div class="progress-bar bg-primary"
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
                    <i class="ki-duotone ki-information-5 fs-3x mb-3"></i>

                    <div class="fw-semibold mb-1">
                        Belum ada data pelatihan
                    </div>

                    <div class="fs-7">
                        Data akan ditampilkan setelah pelatihan tersedia.
                    </div>
                </div>

            @endforelse

        </div>
    </div>

    {{-- ================================================= --}}
    {{-- RINGKASAN STATUS TAMBAHAN --}}
    {{-- ================================================= --}}

    <div class="card card-flush stat-card mb-7">

        <div class="card-header">
            <div class="card-title">
                <div>
                    <h3 class="section-title mb-1">
                        Ringkasan Status Pelatihan
                    </h3>
                    <div class="text-muted fs-7">
                        Seluruh status pelatihan yang tercatat
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            @php
                $trainingStatuses = [
                    [
                        'label' => 'Published',
                        'total' => $totalPublished,
                        'color' => 'success',
                    ],
                    [
                        'label' => 'Draft',
                        'total' => $totalDraft,
                        'color' => 'warning',
                    ],
                    [
                        'label' => 'Closed',
                        'total' => $totalClosed,
                        'color' => 'danger',
                    ],
                    [
                        'label' => 'Rejected',
                        'total' => $totalRejected,
                        'color' => 'info',
                    ],
                ];
            @endphp

            <div class="row g-5">
                @foreach($trainingStatuses as $item)

                    @php
                        $statusPercentage = $totalTrainings > 0
                            ? round(
                                ($item['total'] / $totalTrainings) * 100,
                                1
                            )
                            : 0;
                    @endphp

                    <div class="col-12 col-md-6">

                        <div class="d-flex justify-content-between
                                    align-items-center mb-2">

                            <span class="fw-semibold text-gray-700">
                                {{ $item['label'] }}
                            </span>

                            <span class="fw-bold text-gray-900">
                                {{ $item['total'] }}
                                <span class="text-muted fw-normal fs-8">
                                    ({{ $statusPercentage }}%)
                                </span>
                            </span>

                        </div>

                        <div class="progress h-6px">
                            <div class="progress-bar bg-{{ $item['color'] }}"
                                 role="progressbar"
                                 style="width: {{ min(100, max(0, $statusPercentage)) }}%"
                                 aria-valuenow="{{ $statusPercentage }}"
                                 aria-valuemin="0"
                                 aria-valuemax="100">
                            </div>
                        </div>

                    </div>

                @endforeach
            </div>

        </div>
    </div>

</div>

@endsection

@section('js')

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.8/dist/chart.umd.min.js"></script>

<script>
$(document).ready(function () {

    /*
    |--------------------------------------------------------------------------
    | DATA DARI CONTROLLER
    |--------------------------------------------------------------------------
    */
    const monthLabels = @json($monthLabels);
    const trainingChartData = @json($trainingChartData);
    const registrationChartData = @json($registrationChartData);
    const statusChart = @json($statusChart);

    /*
    |--------------------------------------------------------------------------
    | THEME
    |--------------------------------------------------------------------------
    */
    function getChartColors() {
        const styles = getComputedStyle(document.documentElement);

        return {
            text: styles.getPropertyValue('--bs-body-color').trim()
                || '#475569',

            muted: styles.getPropertyValue('--bs-secondary-color').trim()
                || '#94a3b8',

            border: styles.getPropertyValue('--bs-border-color').trim()
                || '#e2e8f0',

            primary: '#3974d8',
            success: '#3b9b75',
            warning: '#f0ad35',
            danger: '#e35d6a',
            info: '#45a4c7'
        };
    }

    let trainingRegistrationChart = null;
    let registrationStatusChart = null;

    /*
    |--------------------------------------------------------------------------
    | TREND PELATIHAN DAN PENDAFTAR
    |--------------------------------------------------------------------------
    */
    function renderTrainingRegistrationChart() {
        const canvas = document.getElementById(
            'trainingRegistrationChart'
        );

        if (!canvas || typeof Chart === 'undefined') {
            return;
        }

        const colors = getChartColors();

        if (trainingRegistrationChart) {
            trainingRegistrationChart.destroy();
        }

        trainingRegistrationChart = new Chart(canvas, {
            type: 'line',

            data: {
                labels: monthLabels,

                datasets: [
                    {
                        label: 'Pelatihan',
                        data: trainingChartData,

                        borderColor: colors.primary,
                        backgroundColor: colors.primary
                            + '1A',

                        pointBackgroundColor: colors.primary,
                        pointBorderColor: '#ffffff',

                        borderWidth: 2.5,
                        pointRadius: 3,
                        pointHoverRadius: 6,

                        tension: 0.35,
                        fill: false
                    },

                    {
                        label: 'Pendaftar',
                        data: registrationChartData,

                        borderColor: colors.success,
                        backgroundColor: colors.success
                            + '1A',

                        pointBackgroundColor: colors.success,
                        pointBorderColor: '#ffffff',

                        borderWidth: 2.5,
                        pointRadius: 3,
                        pointHoverRadius: 6,

                        tension: 0.35,
                        fill: false
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
                            color: colors.text,
                            usePointStyle: true,
                            pointStyle: 'circle',
                            padding: 20
                        }
                    },

                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return context.dataset.label
                                    + ': '
                                    + new Intl.NumberFormat('id-ID')
                                        .format(context.parsed.y ?? 0);
                            }
                        }
                    }
                },

                scales: {
                    x: {
                        ticks: {
                            color: colors.text,
                            maxRotation: 45,
                            minRotation: 0
                        },

                        grid: {
                            display: false
                        },

                        border: {
                            color: colors.border
                        }
                    },

                    y: {
                        beginAtZero: true,

                        ticks: {
                            precision: 0,
                            color: colors.text
                        },

                        grid: {
                            color: colors.border
                        },

                        border: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | DOUGHNUT STATUS PENDAFTAR
    |--------------------------------------------------------------------------
    */
    function renderRegistrationStatusChart() {
        const canvas = document.getElementById(
            'registrationStatusChart'
        );

        if (!canvas || typeof Chart === 'undefined') {
            return;
        }

        const colors = getChartColors();

        if (registrationStatusChart) {
            registrationStatusChart.destroy();
        }

        registrationStatusChart = new Chart(canvas, {
            type: 'doughnut',

            data: {
                labels: statusChart.map(function (item) {
                    return item.label;
                }),

                datasets: [
                    {
                        data: statusChart.map(function (item) {
                            return Number(item.total) || 0;
                        }),

                        backgroundColor: [
                            colors.warning,
                            colors.success,
                            colors.danger
                        ],

                        hoverOffset: 7,
                        borderWidth: 0,
                        spacing: 3
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
                            color: colors.text,
                            usePointStyle: true,
                            pointStyle: 'circle',
                            padding: 16
                        }
                    },

                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                const value = Number(context.raw) || 0;

                                const total = context.dataset.data.reduce(
                                    function (sum, item) {
                                        return sum + (Number(item) || 0);
                                    },
                                    0
                                );

                                const percentage = total > 0
                                    ? (value / total * 100).toFixed(1)
                                    : '0.0';

                                return context.label + ': '
                                    + new Intl.NumberFormat('id-ID')
                                        .format(value)
                                    + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | INIT
    |--------------------------------------------------------------------------
    */
    renderTrainingRegistrationChart();
    renderRegistrationStatusChart();

});
</script>

@endsection
