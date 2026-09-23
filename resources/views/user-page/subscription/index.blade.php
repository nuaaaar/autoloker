@extends('layouts.user-page')

@section('title', 'Paket Berlangganan')

@section('content')

    <div class="container-xxl">

        @include('user-page.subscription.partials.breadcrumb')

        <div class="row g-4">

            <!-- Sidebar Kiri -->
            <div class="d-none d-lg-block col-lg-2">
            </div>

            <!-- Content -->
            <div class="col-12 col-lg-8">

                @include('user-page.subscription.partials.content')

            </div>

            <!-- Sidebar Kanan -->
            <div class="d-none d-lg-block col-lg-2">
            </div>

        </div>

    </div>

@endsection

@section('js')
<script>

    let selectedSubscriptionUuid = null;


    /*
    |--------------------------------------------------------------------------
    | PILIH PAKET
    |--------------------------------------------------------------------------
    */

    $(document).on('click', '.btn-select-subscription', function () {

        selectedSubscriptionUuid = $(this).data('uuid');

        const name = $(this).data('name');
        const price = parseFloat($(this).data('price')) || 0;


        $('#selectedSubscriptionName')
            .text(name);


        if (price <= 0) {

            $('#selectedSubscriptionPrice')
                .text('Gratis');

        } else {

            $('#selectedSubscriptionPrice')
                .text(
                    'Rp ' +
                    new Intl.NumberFormat('id-ID').format(price)
                );

        }


        $('#modalSelectSubscription').modal('show');

    });


    /*
    |--------------------------------------------------------------------------
    | KONFIRMASI
    |--------------------------------------------------------------------------
    */

    $(document).on(
        'click',
        '#btnConfirmSelectSubscription',
        function () {

            if (!selectedSubscriptionUuid) {
                return;
            }

            const button = $(this);

            button
                .prop('disabled', true)
                .html(
                    '<span class="spinner-border spinner-border-sm me-2"></span>' +
                    'Memproses...'
                );


            $.ajax({

                url: "{{ route('user-page.subscription.order.store') }}",

                type: "POST",

                data: {

                    _token: "{{ csrf_token() }}",

                    subscription_uuid:
                        selectedSubscriptionUuid

                },


                success: function (response) {

                    if (response.success) {

                        window.location.href =
                            response.redirect;

                    }

                },


                error: function (xhr) {

                    button
                        .prop('disabled', false)
                        .html('Ya, Pilih Paket');


                    let message =
                        'Terjadi kesalahan. Silakan coba lagi.';


                    if (
                        xhr.responseJSON &&
                        xhr.responseJSON.message
                    ) {

                        message =
                            xhr.responseJSON.message;

                    }


                    Swal.fire({

                        icon: 'error',

                        title: 'Gagal',

                        text: message

                    });

                }

            });

        }
    );

</script>
@endsection