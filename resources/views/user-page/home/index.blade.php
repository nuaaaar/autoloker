@extends('layouts.user-page')

@section('title', 'Home')

@section('content')
    <div class="container-xxl py-5">

        <div class="row g-4">

            <!-- Sidebar Kiri (Desktop Only) -->
            <div class="d-none d-lg-block col-lg-3 left-sidebar">
                @include('user-page.home.partials.sidebar-left-user')
            </div>

            <!-- Content (Selalu Tampil) -->
            <div class="col-12 col-lg-6">
                @if($profile_progress['progress'] < 100)
                    @include('user-page.home.partials.alert-complete-data')
                @endif
                @include('user-page.home.partials.content-user')
            </div>

            <!-- Sidebar Kanan (Desktop Only) -->
            <div class="d-none d-lg-block col-lg-3 right-sidebar">
                @include('user-page.home.partials.sidebar-right-user')
            </div>

        </div>

    </div>

@endsection

@section('js')
    <script>
        $(document).on('click', '.profile-alert-detail', function (e) {
            e.preventDefault();

            let $this = $(this);
            let $list = $this.next('.profile-alert-list');
            let $icon = $this.find('.toggle-icon');

            $list.stop(true, true).slideToggle(250);

            if ($list.is(':visible')) {
                $icon.removeClass('ki-down').addClass('ki-up');
            } else {
                $icon.removeClass('ki-up').addClass('ki-down');
            }
        });

        $(document).on('click', '.profile-alert-close', function () {
            $(this).closest('.profile-alert-card').fadeOut(300);
        });


        function saveJob(button, uuid)
        {
            let $button = $(button);

            // Cegah double click
            if ($button.data('loading')) {
                return;
            }

            $button.data('loading', true);

            let originalHtml = $button.html();

            // Loading
            $button.prop('disabled', true);

            $button.html(`
                <span class="spinner-border spinner-border-sm me-1"></span>
                Memproses...
            `);

            let url = `/user-page/job-vacancy/${uuid}/bookmark`;

            url = url.replace(':uuid', uuid);

            $.ajax({

                url: url,

                type: 'POST',

                dataType: 'json',

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                success: function(response) {

                    console.log('Bookmark:', response);

                    if (!response.success) {

                        $button.html(originalHtml);

                        return;
                    }

                    if (response.saved) {

                        // =========================
                        // SUDAH DISIMPAN
                        // =========================

                        $button
                            .addClass('saved')
                            .html(`
                                <i class="ki-duotone ki-check fs-7 me-1"></i>
                                Tersimpan
                            `);

                    } else {

                        // =========================
                        // DIHAPUS DARI SIMPANAN
                        // =========================

                        $button
                            .removeClass('saved')
                            .html(`
                                Simpan
                            `);

                    }

                },

                error: function(xhr) {

                    console.log('Bookmark Error:', xhr);
                    console.log(xhr.responseText);

                    $button.html(originalHtml);

                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Tidak dapat mengubah bookmark.'
                    });

                },

                complete: function() {

                    $button
                        .prop('disabled', false)
                        .data('loading', false);

                }

            });
        }

        function applyJob(button, uuid)
        {
            Swal.fire({
                title: 'Lamar Lowongan?',
                text: 'Apakah Anda yakin ingin melamar lowongan ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Lamar',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {

                if (!result.isConfirmed) {
                    return;
                }

                const $button = $(button);

                $button.prop('disabled', true);

                $.ajax({

                    url: `/user-page/job-vacancy/${uuid}/apply`,

                    type: "POST",

                    data: {
                        _token: "{{ csrf_token() }}",
                    },

                    success: function(response) {

                        if (response.success) {

                            $button
                                .html('<i class="ki-duotone ki-check me-1"></i> Sudah Dilamar')
                                .attr(
                                    'onclick',
                                    `cancelApplyJob(this, '${uuid}')`
                                );

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Lamaran berhasil dikirim.',
                                timer: 1500,
                                showConfirmButton: false
                            });

                        }

                    },

                    error: function(xhr) {

                        console.log(xhr.responseText);

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: xhr.responseJSON?.message
                                ?? 'Terjadi kesalahan saat mengirim lamaran.'
                        });

                    },

                    complete: function() {

                        $button.prop('disabled', false);

                    }

                });

            });
        }

        function cancelApplyJob(button, uuid)
        {
            Swal.fire({
                title: 'Batalkan Lamaran?',
                text: 'Apakah Anda yakin ingin membatalkan lamaran pada lowongan ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Batalkan',
                cancelButtonText: 'Tidak',
                reverseButtons: true
            }).then((result) => {

                if (!result.isConfirmed) {
                    return;
                }

                const $button = $(button);

                $button.prop('disabled', true);

                $.ajax({

                    url: `/user-page/job-vacancy/${uuid}/cancel-apply`,

                    type: "DELETE",

                    data: {
                        _token: "{{ csrf_token() }}"
                    },

                    success: function(response) {

                        if (response.success) {

                            $button
                                .html('Lamar Sekarang')
                                .attr(
                                    'onclick',
                                    `applyJob(this, '${uuid}')`
                                );

                            Swal.fire({
                                icon: 'success',
                                title: 'Lamaran Dibatalkan',
                                text: 'Lamaran Anda berhasil dibatalkan.',
                                timer: 1500,
                                showConfirmButton: false
                            });

                        }

                    },

                    error: function(xhr) {

                        console.log(xhr.responseText);

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: xhr.responseJSON?.message
                                ?? 'Terjadi kesalahan saat membatalkan lamaran.'
                        });

                    },

                    complete: function() {

                        $button.prop('disabled', false);

                    }

                });
            });
        }

        let jobFilterTimer = null;

        let currentJobRequest = null;

        let currentJobPage = 1;

        let isLoadingJobs = false;

        let hasMoreJobs = true;

        /*
        |--------------------------------------------------------------------------
        | LOAD JOBS
        |--------------------------------------------------------------------------
        */

        function loadJobs(page = 1, updateUrl = true, reset = true)
        {
            /*
            |--------------------------------------------------------------------------
            | CEGAH REQUEST GANDA
            |--------------------------------------------------------------------------
            */

            if (isLoadingJobs) {
                return;
            }


            /*
            |--------------------------------------------------------------------------
            | CEK MASIH ADA DATA
            |--------------------------------------------------------------------------
            */

            if (!reset && !hasMoreJobs) {
                return;
            }


            /*
            |--------------------------------------------------------------------------
            | PARAMETER
            |--------------------------------------------------------------------------
            */

            const params = {

                search:
                    $('#jobSearch').val() || '',

                province:
                    $('#filterLocation').val() || '',

                working_type:
                    $('#filterWorkingType').val() || '',

                working_system:
                    $('#filterWorkingSystem').val() || '',

                certificate:
                    $('#filterCertificate').val() || '',

                min_salary:
                    $('#modalMinSalary').val() || '',

                urgent:
                    $('#modalUrgent').val() || '',

                experience:
                    $('#modalExperience').val() || '',

                gender:
                    $('#modalGender').val() || '',

                page: page

            };


            /*
            |--------------------------------------------------------------------------
            | ABORT REQUEST SEBELUMNYA
            |--------------------------------------------------------------------------
            */

            if (currentJobRequest) {

                currentJobRequest.abort();

            }


            isLoadingJobs = true;


            /*
            |--------------------------------------------------------------------------
            | LOADING
            |--------------------------------------------------------------------------
            */

            $('#jobLoading').removeClass('d-none');


            /*
            |--------------------------------------------------------------------------
            | AJAX
            |--------------------------------------------------------------------------
            */

            currentJobRequest = $.ajax({

                url: "{{ route('user-page.job-vacancy.list') }}",

                type: "GET",

                data: params,

                dataType: "json",


                success: function(response) {

                    if (!response.success) {
                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | RESET
                    |--------------------------------------------------------------------------
                    */

                    if (reset) {

                        $('#jobList').html(
                            response.html
                        );

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | LOAD BERIKUTNYA
                    |--------------------------------------------------------------------------
                    */

                    else {

                        $('#jobList').append(
                            response.html
                        );

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | UPDATE PAGE
                    |--------------------------------------------------------------------------
                    */

                    currentJobPage =
                        response.current_page;


                    /*
                    |--------------------------------------------------------------------------
                    | MASIH ADA DATA?
                    |--------------------------------------------------------------------------
                    */

                    hasMoreJobs =
                        response.has_more;


                    /*
                    |--------------------------------------------------------------------------
                    | SEMUA DATA SUDAH HABIS
                    |--------------------------------------------------------------------------
                    */

                    if (!hasMoreJobs) {

                        $('#jobEnd')
                            .removeClass('d-none');

                    }

                    else {

                        $('#jobEnd')
                            .addClass('d-none');

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | UPDATE URL
                    |--------------------------------------------------------------------------
                    */

                    if (updateUrl && reset) {

                        const url =
                            new URL(
                                window.location.href
                            );


                        Object.entries(params).forEach(
                            ([key, value]) => {

                                if (
                                    value !== '' &&
                                    value !== null &&
                                    value !== undefined
                                ) {

                                    url.searchParams.set(
                                        key,
                                        value
                                    );

                                }

                                else {

                                    url.searchParams.delete(
                                        key
                                    );

                                }

                            }
                        );


                        /*
                        | Page tidak perlu disimpan
                        */

                        url.searchParams.delete(
                            'page'
                        );


                        window.history.pushState(
                            {},
                            '',
                            url
                        );

                    }

                },


                error: function(xhr, status) {

                    if (status === 'abort') {
                        return;
                    }


                    console.error(
                        xhr.responseText
                    );

                },


                complete: function() {

                    isLoadingJobs = false;

                    currentJobRequest = null;


                    $('#jobLoading')
                        .addClass('d-none');

                }

            });
        }

        $(window).on('scroll', function () {

            const scrollTop =
                $(window).scrollTop();

            const windowHeight =
                $(window).height();

            const documentHeight =
                $(document).height();

            const distanceFromBottom =
                documentHeight -
                (scrollTop + windowHeight);


            if (
                distanceFromBottom <= 500 &&
                !isLoadingJobs &&
                hasMoreJobs
            ) {

                loadJobs(
                    currentJobPage + 1,
                    false,
                    false
                );

            }

        });

        function resetJobList()
        {
            currentJobPage = 1;

            hasMoreJobs = true;

            isLoadingJobs = false;


            $('#jobEnd')
                .addClass('d-none');


            $('#jobList')
                .scrollTop(0);


            loadJobs(
                1,
                true,
                true
            );
        }

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        $('#jobSearch').on(
            'input',
            function() {

                clearTimeout(
                    jobFilterTimer
                );


                jobFilterTimer = setTimeout(
                    function() {

                        loadJobs(1);

                    },
                    400
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | FILTER DROPDOWN
        |--------------------------------------------------------------------------
        */

        $(
            '#filterLocation, ' +
            '#filterWorkingType, ' +
            '#filterWorkingSystem, ' +
            '#filterCertificate'
        )
        .on(
            'change',
            function() {

                loadJobs(1);

            }
        );


        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */

        $(document).on(
            'click',
            '#jobList .pagination a',
            function(e) {

                e.preventDefault();


                const url = new URL(
                    $(this).attr('href'),
                    window.location.origin
                );


                const page =
                    url.searchParams.get('page') || 1;


                loadJobs(
                    page,
                    true
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | BROWSER BACK / FORWARD
        |--------------------------------------------------------------------------
        */

        window.addEventListener(
            'popstate',
            function() {

                const params =
                    new URLSearchParams(
                        window.location.search
                    );


                $('#jobSearch').val(
                    params.get('search') || ''
                );


                $('#filterLocation').val(
                    params.get('province') || ''
                );


                $('#filterWorkingType').val(
                    params.get('working_type') || ''
                );


                $('#filterWorkingSystem').val(
                    params.get('working_system') || ''
                );


                $('#filterCertificate').val(
                    params.get('certificate') || ''
                );


                loadJobs(
                    params.get('page') || 1,
                    false
                );

            }
        );

        /*
        |--------------------------------------------------------------------------
        | INITIAL LOAD
        |--------------------------------------------------------------------------
        */

        $(document).ready(function() {

            /*
            |--------------------------------------------------------------------------
            | AMBIL FILTER DARI URL
            |--------------------------------------------------------------------------
            */

            const params =
                new URLSearchParams(
                    window.location.search
                );


            $('#jobSearch').val(
                params.get('search') || ''
            );


            $('#filterLocation').val(
                params.get('province') || ''
            );


            $('#filterWorkingType').val(
                params.get('working_type') || ''
            );


            $('#filterWorkingSystem').val(
                params.get('working_system') || ''
            );


            $('#filterCertificate').val(
                params.get('certificate') || ''
            );


            loadJobs(
                params.get('page') || 1,
                false
            );

        });

        $('#btnApplyJobFilter').on('click', function () {

            loadJobs();

            const modalElement = document.getElementById(
                'jobFilterModal'
            );

            const modal = bootstrap.Modal.getInstance(
                modalElement
            );

            if (modal) {

                modal.hide();

            }

        });

        $('#btnResetJobFilter').on('click', function () {

            /*
            |--------------------------------------------------------------------------
            | RESET SEARCH
            |--------------------------------------------------------------------------
            */

            $('#jobSearch').val('');


            /*
            |--------------------------------------------------------------------------
            | RESET FILTER UTAMA
            |--------------------------------------------------------------------------
            */

            $('#filterLocation').val('');

            $('#filterWorkingType').val('');

            $('#filterWorkingSystem').val('');

            $('#filterCertificate').val('');


            /*
            |--------------------------------------------------------------------------
            | RESET FILTER MODAL
            |--------------------------------------------------------------------------
            */

            $('#modalMinSalary').val('');

            $('#modalUrgent').val('');

            $('#modalExperience').val('');

            $('#modalGender').val('');


            /*
            |--------------------------------------------------------------------------
            | LOAD ULANG
            |--------------------------------------------------------------------------
            */

            loadJobs();


            /*
            |--------------------------------------------------------------------------
            | CLOSE MODAL
            |--------------------------------------------------------------------------
            */

            const modalElement = document.getElementById(
                'jobFilterModal'
            );

            const modal = bootstrap.Modal.getInstance(
                modalElement
            );

            if (modal) {

                modal.hide();

            }

        });
    </script>
@endsection
