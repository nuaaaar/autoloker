@extends('layouts.dashboard-user')

@section('title', 'Lihat Pelamar')

@section('breadcrumb')
    <h1
        class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
        Lowongan Saya</h1>
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
            <a href="{{ route('dashboard-user.job-vacancy.index') }}" class="text-muted text-hover-primary">Lowongan Saya</a>
        </li>
        <!--end::Item-->
        <!--end::Item-->
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-500 w-5px h-2px"></span>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <a href="javascript:;" class="text-muted text-hover-primary ms-2">Lihat Pelamar</a>
        <!--end::Item-->
    </ul>
    <!--end::Breadcrumb-->
@endsection

@section('content')

    <div class="container-fluid py-5">

        <div class="d-flex align-items-center justify-content-between mb-4">

            <div>

            </div>

            <a href="{{ route('dashboard-user.job-vacancy.index') }}"
            class="btn btn-light">

                <i class="fas fa-arrow-left me-2"></i>

                Kembali

            </a>

        </div>

        {{-- HEADER --}}
        <div class="card mb-5">

            <div class="card-body">

                <div class="d-flex flex-wrap justify-content-between align-items-center gap-4">

                    <div>

                        <div class="d-flex align-items-center gap-3 mb-2">

                            <h2 class="mb-0 fw-bold">
                                Pelamar Lowongan
                            </h2>

                        </div>

                        <div class="text-muted">

                            {{ $job->position ?? '-' }}

                            <span class="mx-2">•</span>

                            {{ $job->bujp?->company_name
                                ?? $job->company?->company_name
                                ?? '-' }}

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- STATISTIC --}}
        <div class="row g-5 mb-5">

            <div class="col-md-3">

                <div class="card">

                    <div class="card-body">

                        <div class="text-muted">
                            Total Pelamar
                        </div>

                        <div class="fs-2x fw-bold">
                            {{ $total }}
                        </div>

                    </div>

                </div>

            </div>


            <div class="col-md-3">

                <div class="card">

                    <div class="card-body">

                        <div class="text-muted">
                            Applied
                        </div>

                        <div class="fs-2x fw-bold text-primary">
                            {{ $applied }}
                        </div>

                    </div>

                </div>

            </div>


            <div class="col-md-3">

                <div class="card">

                    <div class="card-body">

                        <div class="text-muted">
                            Reviewed
                        </div>

                        <div class="fs-2x fw-bold text-warning">
                            {{ $reviewed }}
                        </div>

                    </div>

                </div>

            </div>


            <div class="col-md-3">

                <div class="card">

                    <div class="card-body">

                        <div class="text-muted">
                            Shortlisted
                        </div>

                        <div class="fs-2x fw-bold text-success">
                            {{ $shortlisted }}
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- FILTER --}}
        <div class="card mb-5">

            <div class="card-body">

                <div class="row g-3">

                    <div class="col-md-6">

                        <input
                            type="text"
                            id="applicationSearch"
                            class="form-control"
                            placeholder="Cari nama, email atau KTP..."
                        >

                    </div>


                    <div class="col-md-3">

                        <select
                            id="applicationStatus"
                            class="form-select"
                        >

                            <option value="">
                                Semua Status
                            </option>

                            <option value="APPLIED">
                                Applied
                            </option>

                            <option value="REVIEWED">
                                Reviewed
                            </option>

                            <option value="SHORTLISTED">
                                Shortlisted
                            </option>

                            <option value="REJECTED">
                                Rejected
                            </option>

                        </select>

                    </div>

                </div>

            </div>

        </div>


        {{-- LIST --}}
        <div class="card">

            <div class="card-body">

                <div id="applicationList">

                    @include(
                        'dashboard-user.job-application.partials.list',
                        [
                            'applications' => $applications
                        ]
                    )

                </div>


                <div
                    id="applicationLoading"
                    class="text-center py-5 d-none"
                >

                    <span class="spinner-border text-primary"></span>

                    <div class="text-muted mt-3">
                        Memuat pelamar...
                    </div>

                </div>


                <div
                    id="applicationEnd"
                    class="text-center text-muted py-4 d-none"
                >

                    Semua pelamar telah ditampilkan.

                </div>

            </div>

        </div>

    </div>

@endsection

@section('js')
<script>
    $(document).ready(function () {

        let searchTimer = null;

        /*
        |--------------------------------------------------------------------------
        | LOAD APPLICATION
        |--------------------------------------------------------------------------
        */

        function loadApplications(page = 1) {

            let search = $('#applicationSearch').val();
            let status = $('#applicationStatus').val();

            $.ajax({

                url: window.location.href,

                type: 'GET',

                data: {
                    search: search,
                    status: status,
                    page: page
                },

                beforeSend: function () {

                    $('#applicationList').addClass('opacity-50');

                },

                success: function (response) {

                    if (response.success) {

                        // Ganti list pelamar
                        $('#applicationList').html(response.html);

                        // Update pagination jika digunakan
                        $('#applicationPagination').html(
                            response.pagination ?? ''
                        );

                    }

                },

                error: function (xhr) {

                    console.error(xhr);

                },

                complete: function () {

                    $('#applicationList').removeClass('opacity-50');

                }

            });

        }


        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        $('#applicationSearch').on('keyup', function () {

            clearTimeout(searchTimer);

            searchTimer = setTimeout(function () {

                loadApplications(1);

            }, 400);

        });


        /*
        |--------------------------------------------------------------------------
        | STATUS
        |--------------------------------------------------------------------------
        */

        $('#applicationStatus').on('change', function () {

            loadApplications(1);

        });


        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */

        $(document).on(
            'click',
            '#applicationPagination a',
            function (e) {

                e.preventDefault();

                let url = new URL($(this).attr('href'));

                let page = url.searchParams.get('page') || 1;

                loadApplications(page);

            }
        );

    });
</script>
@endsection