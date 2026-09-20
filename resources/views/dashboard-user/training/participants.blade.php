@extends('layouts.dashboard-user')

@section('title', 'Peserta Pelatihan')

@section('breadcrumb')
    <h1
        class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
        Pelatihan Saya</h1>
    <!--end::Title-->
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
        <!--begin::Item-->
        <li class="breadcrumb-item text-muted">
            <a href="javascript:;" class="text-muted text-hover-primary">Beranda</a>
        </li>
        <!--end::Item-->
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-500 w-5px h-2px"></span>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item text-muted">
            <a href="{{ route('dashboard-user.training.index') }}" class="text-muted text-hover-primary">Pelatihan Saya</a>
        </li>
        <!--end::Item-->
        <!--end::Item-->
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-500 w-5px h-2px"></span>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <a href="javascript:;" class="text-muted text-hover-primary ms-2">Lihat Peserta</a>
        <!--end::Item-->
    </ul>
    <!--end::Breadcrumb-->
@endsection

@section('content')

    <div class="container-xxl">

        {{-- =========================================================
            HEADER
        ========================================================== --}}

        <div class="d-flex align-items-center justify-content-between mb-4">

            <div>

            </div>

            <a href="{{ route('dashboard-user.training.index') }}"
            class="btn btn-light">

                <i class="fas fa-arrow-left me-2"></i>

                Kembali

            </a>

        </div>


        {{-- =========================================================
            TRAINING INFO
        ========================================================== --}}

        <div class="card mb-5">

            <div class="card-body">

                <div class="row align-items-center">

                    <div class="col-md-8">

                        <h4 class="fw-bold mb-2">

                            {{ $training->title ?? '-' }}

                        </h4>

                        <div class="text-muted fs-7">

                            <i class="fas fa-building me-1"></i>

                            {{ $training->provider ?? '-' }}

                        </div>

                        <div class="text-muted fs-7 mt-1">

                            <i class="fas fa-map-marker-alt me-1"></i>

                            {{ $training->city ?? '-' }},
                            {{ $training->province ?? '-' }}

                        </div>

                    </div>


                    <div class="col-md-4 text-md-end mt-4 mt-md-0">

                        @php

                            $statusClass = [
                                'draft' => 'warning',
                                'rejected' => 'danger',
                                'submitted' => 'info',
                                'published' => 'success',
                                'running' => 'primary',
                                'closed' => 'secondary',
                                'cancelled' => 'danger',
                            ][$training->status] ?? 'secondary';

                        @endphp

                        <span class="badge badge-light-{{ $statusClass }} px-4 py-2">

                            {{ ucfirst($training->status) }}

                        </span>

                        <div class="mt-2 text-muted fs-8">

                            Kuota:

                            <strong>
                                {{ $training->quota ?: 'Tidak terbatas' }}
                            </strong>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- =========================================================
            STATISTICS
        ========================================================== --}}

        <div class="row g-4 mb-5">

            <div class="col-6 col-lg-3">

                <div class="card h-100">

                    <div class="card-body">

                        <div class="d-flex align-items-center">

                            <div class="symbol symbol-45px me-4">

                                <div class="symbol-label bg-light-primary">

                                    <i class="fas fa-users text-primary fs-3"></i>

                                </div>

                            </div>

                            <div>

                                <div class="text-muted fs-8">
                                    Total Peserta
                                </div>

                                <div class="fw-bold fs-2"
                                    id="totalParticipants">

                                    {{ $totalParticipants }}

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <div class="col-6 col-lg-3">

                <div class="card h-100">

                    <div class="card-body">

                        <div class="d-flex align-items-center">

                            <div class="symbol symbol-45px me-4">

                                <div class="symbol-label bg-light-warning">

                                    <i class="fas fa-clock text-warning fs-3"></i>

                                </div>

                            </div>

                            <div>

                                <div class="text-muted fs-8">
                                    Menunggu Persetujuan
                                </div>

                                <div class="fw-bold fs-2">

                                    {{ $totalPending }}

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <div class="col-6 col-lg-3">

                <div class="card h-100">

                    <div class="card-body">

                        <div class="d-flex align-items-center">

                            <div class="symbol symbol-45px me-4">

                                <div class="symbol-label bg-light-success">

                                    <i class="fas fa-check text-success fs-3"></i>

                                </div>

                            </div>

                            <div>

                                <div class="text-muted fs-8">
                                    Disetujui
                                </div>

                                <div class="fw-bold fs-2">

                                    {{ $totalApproved }}

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <div class="col-6 col-lg-3">

                <div class="card h-100">

                    <div class="card-body">

                        <div class="d-flex align-items-center">

                            <div class="symbol symbol-45px me-4">

                                <div class="symbol-label bg-light-danger">

                                    <i class="fas fa-times text-danger fs-3"></i>

                                </div>

                            </div>

                            <div>

                                <div class="text-muted fs-8">
                                    Ditolak
                                </div>

                                <div class="fw-bold fs-2">

                                    {{ $totalRejected }}

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- =========================================================
            PARTICIPANTS
        ========================================================== --}}

        <div class="card">

            <div class="card-header">

                <div class="card-title">

                    <h3 class="fw-bold mb-0">
                        Daftar Peserta
                    </h3>

                </div>

            </div>


            <div class="card-body">

                {{-- FILTER --}}

                <div class="row g-3 mb-5">

                    <div class="col-md-8">

                        <div class="position-relative">

                            <i class="fas fa-search position-absolute top-50 translate-middle-y ms-4 text-muted"></i>

                            <input
                                type="text"
                                id="searchParticipant"
                                class="form-control form-control-solid ps-12"
                                placeholder="Cari nama, email, nomor KTP..."
                            >

                        </div>

                    </div>


                    <div class="col-md-4">

                        <select
                            id="statusParticipant"
                            class="form-select form-select-solid"
                        >

                            <option value="all">
                                Semua Status
                            </option>

                            <option value="pending">
                                Menunggu Persetujuan
                            </option>

                            <option value="approved">
                                Disetujui
                            </option>

                            <option value="rejected">
                                Ditolak
                            </option>

                        </select>

                    </div>

                </div>


                {{-- LOADING --}}

                <div
                    id="participantLoading"
                    class="text-center py-10"
                    style="display:none;"
                >

                    <div class="spinner-border text-primary"></div>

                    <div class="text-muted mt-3">
                        Memuat peserta...
                    </div>

                </div>


                {{-- LIST --}}

                <div id="participantList">

                    @include(
                        'dashboard-user.training.partials.participant-list',
                        ['participants' => $participants]
                    )

                </div>

            </div>

        </div>

    </div>

@endsection


@section('js')

    <script>

        $(document).ready(function () {

            let timer = null;


            /*
            |--------------------------------------------------------------------------
            | LOAD PARTICIPANTS
            |--------------------------------------------------------------------------
            */

            function loadParticipants(page = 1)
            {
                let search = $('#searchParticipant').val();
                let status = $('#statusParticipant').val();


                $('#participantLoading').show();

                $('#participantList').css(
                    'opacity',
                    '0.5'
                );


                $.ajax({

                    url: "{{ route('dashboard-user.training.participants', $training->uuid) }}",

                    type: "GET",

                    data: {
                        search: search,
                        status: status,
                        page: page
                    },

                    success: function (response) {

                        if (response.success) {

                            $('#participantList').html(
                                response.html
                            );

                        }

                    },

                    error: function (xhr) {

                        console.error(xhr);

                        Swal.fire({

                            icon: 'error',

                            title: 'Gagal',

                            text: 'Gagal memuat daftar peserta.'

                        });

                    },

                    complete: function () {

                        $('#participantLoading').hide();

                        $('#participantList').css(
                            'opacity',
                            '1'
                        );

                    }

                });
            }


            /*
            |--------------------------------------------------------------------------
            | SEARCH
            |--------------------------------------------------------------------------
            */

            $('#searchParticipant').on(
                'keyup',
                function () {

                    clearTimeout(timer);

                    timer = setTimeout(
                        function () {

                            loadParticipants(1);

                        },
                        400
                    );

                }
            );


            /*
            |--------------------------------------------------------------------------
            | FILTER
            |--------------------------------------------------------------------------
            */

            $('#statusParticipant').on(
                'change',
                function () {

                    loadParticipants(1);

                }
            );


            /*
            |--------------------------------------------------------------------------
            | PAGINATION
            |--------------------------------------------------------------------------
            */

            $(document).on(
                'click',
                '#participantList .pagination a',
                function (e) {

                    e.preventDefault();

                    let url = $(this).attr('href');

                    if (!url) {
                        return;
                    }


                    let page = new URL(
                        url,
                        window.location.origin
                    ).searchParams.get('page');


                    loadParticipants(page || 1);

                }
            );

        });

    </script>

@endsection