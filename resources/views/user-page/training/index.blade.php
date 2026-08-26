@extends('layouts.user-page')

@section('title', 'Pelatihan')

@section('style')
    <style>
        

        /*
        |--------------------------------------------------------------------------
        | FIX METRONIC SCROLL
        |--------------------------------------------------------------------------
        */

        #kt_app_wrapper {
            min-height: 100vh;
        }

        #kt_app_main {
            min-height: 0;
        }

        #kt_app_main > .d-flex.flex-column.flex-column-fluid {
            min-height: 0;
        }


        /*
        |--------------------------------------------------------------------------
        | CONTENT BOLEH MEMANJANG
        |--------------------------------------------------------------------------
        */

        #kt_app_main .flex-column-fluid {
            min-height: 0;
        }


        /*
        |--------------------------------------------------------------------------
        | JOB LIST
        |--------------------------------------------------------------------------
        */

        #jobList {
            width: 100%;
        }


        /*
        |--------------------------------------------------------------------------
        | PASTIKAN CONTENT TIDAK TERKUNCI
        |--------------------------------------------------------------------------
        */

        html,
        body {
            min-height: 100%;
        }
    </style>
@endsection

@section('content')
    <div class="container-xxl">
        @include('user-page.training.partials.breadcrumb')

        <div class="row g-4">

            <!-- Sidebar Kiri (Desktop Only) -->
            <div class="d-none d-lg-block col-lg-2">
                
            </div>

            <!-- Content (Selalu Tampil) -->
            <div class="col-12 col-lg-8">
                @include('user-page.training.partials.content')
            </div>

            <!-- Sidebar Kanan (Desktop Only) -->
            <div class="d-none d-lg-block col-lg-2">

            </div>

        </div>
    </div>

@endsection

@section('js')

<script>

    /*
    |--------------------------------------------------------------------------
    | VARIABLE
    |--------------------------------------------------------------------------
    */

    let trainingFilterTimer = null;

    let currentTrainingRequest = null;

    let currentTrainingPage = 1;

    let isLoadingTrainings = false;

    let hasMoreTrainings = true;


    /*
    |--------------------------------------------------------------------------
    | LOAD TRAININGS
    |--------------------------------------------------------------------------
    */

    function loadTrainings(
        page = 1,
        updateUrl = true,
        reset = true
    ) {

        /*
        |--------------------------------------------------------------------------
        | CEGAH REQUEST GANDA
        |--------------------------------------------------------------------------
        */

        if (isLoadingTrainings) {

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | CEK DATA
        |--------------------------------------------------------------------------
        */

        if (!reset && !hasMoreTrainings) {

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | PARAMETER
        |--------------------------------------------------------------------------
        */

        const params = {

            search:
                $('#trainingSearch').val() || '',

            page: page

        };


        /*
        |--------------------------------------------------------------------------
        | ABORT REQUEST SEBELUMNYA
        |--------------------------------------------------------------------------
        */

        if (currentTrainingRequest) {

            currentTrainingRequest.abort();

        }


        isLoadingTrainings = true;


        /*
        |--------------------------------------------------------------------------
        | LOADING
        |--------------------------------------------------------------------------
        */

        $('#trainingLoading')
            .removeClass('d-none');


        /*
        |--------------------------------------------------------------------------
        | AJAX
        |--------------------------------------------------------------------------
        */

        currentTrainingRequest = $.ajax({

            url: "{{ route('user-page.training.list') }}",

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

                    $('#trainingList').html(
                        response.html
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | APPEND
                |--------------------------------------------------------------------------
                */

                else {

                    $('#trainingList').append(
                        response.html
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | PAGE
                |--------------------------------------------------------------------------
                */

                currentTrainingPage =
                    response.current_page;


                /*
                |--------------------------------------------------------------------------
                | HAS MORE
                |--------------------------------------------------------------------------
                */

                hasMoreTrainings =
                    response.has_more;


                /*
                |--------------------------------------------------------------------------
                | END
                |--------------------------------------------------------------------------
                */

                if (!hasMoreTrainings) {

                    $('#trainingEnd')
                        .removeClass('d-none');

                }

                else {

                    $('#trainingEnd')
                        .addClass('d-none');

                }


                /*
                |--------------------------------------------------------------------------
                | UPDATE URL
                |--------------------------------------------------------------------------
                */

                if (
                    updateUrl &&
                    reset
                ) {

                    const url =
                        new URL(
                            window.location.href
                        );


                    Object.entries(params)
                        .forEach(
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
                    |--------------------------------------------------------------------------
                    | PAGE TIDAK DISIMPAN
                    |--------------------------------------------------------------------------
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


            error: function(
                xhr,
                status
            ) {

                if (
                    status === 'abort'
                ) {

                    return;

                }


                console.error(
                    'Training Error:',
                    xhr.responseText
                );

            },


            complete: function() {

                isLoadingTrainings =
                    false;

                currentTrainingRequest =
                    null;


                $('#trainingLoading')
                    .addClass('d-none');

            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | INFINITE SCROLL
    |--------------------------------------------------------------------------
    */

    $(window).on(
        'scroll',
        function() {

            const scrollTop =
                $(window).scrollTop();

            const windowHeight =
                $(window).height();

            const documentHeight =
                $(document).height();


            const distanceFromBottom =
                documentHeight -
                (
                    scrollTop +
                    windowHeight
                );


            /*
            |--------------------------------------------------------------------------
            | LOAD SAAT 500PX DARI BAWAH
            |--------------------------------------------------------------------------
            */

            if (

                distanceFromBottom <= 500 &&

                !isLoadingTrainings &&

                hasMoreTrainings

            ) {

                loadTrainings(

                    currentTrainingPage + 1,

                    false,

                    false

                );

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | SEARCH
    |--------------------------------------------------------------------------
    */

    $('#trainingSearch').on(
        'input',
        function() {

            clearTimeout(
                trainingFilterTimer
            );


            trainingFilterTimer =
                setTimeout(
                    function() {

                        currentTrainingPage =
                            1;

                        hasMoreTrainings =
                            true;


                        $('#trainingEnd')
                            .addClass('d-none');


                        loadTrainings(
                            1,
                            true,
                            true
                        );

                    },
                    400
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


            $('#trainingSearch').val(
                params.get('search') || ''
            );


            currentTrainingPage =
                1;

            hasMoreTrainings =
                true;


            loadTrainings(
                1,
                false,
                true
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | INITIAL LOAD
    |--------------------------------------------------------------------------
    */

    $(document).ready(
        function() {

            const params =
                new URLSearchParams(
                    window.location.search
                );


            $('#trainingSearch').val(
                params.get('search') || ''
            );


            loadTrainings(
                1,
                false,
                true
            );

        }
    );

</script>

@endsection