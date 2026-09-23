@extends('layouts.user-page')

@section('title', 'Riwayat Pembayaran')

{{-- ================================================================
     CSS
================================================================ --}}

@section('style')
    <link
        href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css"
        rel="stylesheet"
    >

    @include('user-page.user-subscription.partials.style')

@endsection

@section('content')

    <div class="container-xxl payment-history-page">

        @include('user-page.user-subscription.partials.breadcrumb')


        <div class="row g-4">

            {{-- ====================================================
                 SIDEBAR KIRI
            ===================================================== --}}

            <div class="d-none d-lg-block col-lg-2">
            </div>


            {{-- ====================================================
                 CONTENT
            ===================================================== --}}

            <div class="col-12 col-lg-8">

                @include('user-page.user-subscription.partials.content')

            </div>


            {{-- ====================================================
                 SIDEBAR KANAN
            ===================================================== --}}

            <div class="d-none d-lg-block col-lg-2">
            </div>

        </div>

    </div>

@endsection

{{-- ================================================================
     JS
================================================================ --}}

@section('js')

    <script>

        $(document).ready(function () {


            /*
            |--------------------------------------------------------------------------
            | COPY NOMOR REKENING
            |--------------------------------------------------------------------------
            */

            $(document).on(
                'click',
                '.bank-copy-btn',
                function () {

                    const button = $(this);

                    const account =
                        button.data('account');


                    if (!account) {
                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | CLIPBOARD
                    |--------------------------------------------------------------------------
                    */

                    if (
                        navigator.clipboard &&
                        window.isSecureContext
                    ) {

                        navigator.clipboard
                            .writeText(account)
                            .then(function () {

                                showCopied(button);

                            })
                            .catch(function () {

                                fallbackCopy(account, button);

                            });

                    } else {

                        fallbackCopy(account, button);

                    }

                }
            );



            /*
            |--------------------------------------------------------------------------
            | FILE VALIDATION
            |--------------------------------------------------------------------------
            */

            $(document).on(
                'change',
                '#payment-proof',
                function () {

                    const file =
                        this.files[0];


                    if (!file) {
                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | MAX 5 MB
                    |--------------------------------------------------------------------------
                    */

                    const maxSize =
                        5 * 1024 * 1024;


                    if (file.size > maxSize) {

                        Swal.fire({

                            icon: 'warning',

                            title: 'File terlalu besar',

                            text:
                                'Ukuran bukti pembayaran maksimal 5 MB.'

                        });


                        $(this).val('');

                        return;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | FILE TYPE
                    |--------------------------------------------------------------------------
                    */

                    const allowedTypes = [

                        'image/jpeg',
                        'image/png',
                        'application/pdf'

                    ];


                    if (
                        !allowedTypes.includes(
                            file.type
                        )
                    ) {

                        Swal.fire({

                            icon: 'warning',

                            title: 'Format file tidak valid',

                            text:
                                'Silakan upload JPG, JPEG, PNG atau PDF.'

                        });


                        $(this).val('');

                    }

                }
            );



            /*
            |--------------------------------------------------------------------------
            | SUBMIT UPLOAD
            |--------------------------------------------------------------------------
            */

            $(document).on(
                'submit',
                '#upload-proof-form',
                function () {

                    const button =
                        $(this).find(
                            'button[type="submit"]'
                        );


                    button
                        .prop('disabled', true)
                        .html(
                            '<span class="spinner-border spinner-border-sm me-2"></span>' +
                            'Mengirim...'
                        );

                }
            );


            /*
            |--------------------------------------------------------------------------
            | DETAIL ORDER
            |--------------------------------------------------------------------------
            */

            $(document).on('click', '.btn-order-detail', function () {

                const button = $(this);

                const proof =
                    button.attr('data-payment-proof');


                /*
                |--------------------------------------------------------------------------
                | BASIC INFORMATION
                |--------------------------------------------------------------------------
                */

                $('#detail-order-number')
                    .text(
                        button.attr('data-order-number') || '-'
                    );


                $('#detail-package-name')
                    .text(
                        button.attr('data-package-name') || '-'
                    );


                const price =
                    parseFloat(
                        button.attr('data-price')
                    ) || 0;


                $('#detail-price')
                    .text(
                        'Rp ' +
                        new Intl.NumberFormat('id-ID')
                            .format(price)
                    );


                $('#detail-payment-method')
                    .text(
                        button.attr('data-payment-method') || '-'
                    );


                $('#detail-payment-date')
                    .text(
                        button.attr('data-payment-date') || '-'
                    );


                $('#detail-status')
                    .text(
                        button.attr('data-status') || '-'
                    );


                $('#detail-expired-at')
                    .text(
                        button.attr('data-expired-at') || '-'
                    );


                /*
                |--------------------------------------------------------------------------
                | PAYMENT PROOF
                |--------------------------------------------------------------------------
                */

                if (proof) {

                    const extension =
                        proof
                            .split('.')
                            .pop()
                            .toLowerCase();


                    let html = '';


                    /*
                    |--------------------------------------------------------------------------
                    | IMAGE
                    |--------------------------------------------------------------------------
                    */

                    if (
                        [
                            'jpg',
                            'jpeg',
                            'png'
                        ].includes(extension)
                    ) {

                        html = `

                            <div class="payment-proof-preview">

                                <img
                                    src="${proof}"
                                    alt="Bukti Pembayaran"
                                    class="payment-proof-image">

                            </div>


                            <a
                                href="${proof}"
                                target="_blank"
                                class="ph-btn ph-btn-outline mt-2">

                                <i class="bx bx-show me-1"></i>

                                Lihat Bukti

                            </a>

                        `;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | PDF
                    |--------------------------------------------------------------------------
                    */

                    else if (extension === 'pdf') {

                        html = `

                            <div class="payment-proof-pdf">

                                <i class="bx bxs-file-pdf"></i>

                                <span>
                                    Bukti pembayaran PDF
                                </span>

                            </div>


                            <a
                                href="${proof}"
                                target="_blank"
                                class="ph-btn ph-btn-outline mt-2">

                                <i class="bx bx-file me-1"></i>

                                Buka Bukti Pembayaran

                            </a>

                        `;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | OTHER
                    |--------------------------------------------------------------------------
                    */

                    else {

                        html = `

                            <a
                                href="${proof}"
                                target="_blank"
                                class="ph-btn ph-btn-outline">

                                <i class="bx bx-file me-1"></i>

                                Lihat Bukti Pembayaran

                            </a>

                        `;

                    }


                    $('#detail-payment-proof')
                        .html(html);

                    $('#detail-payment-proof-wrapper')
                        .show();

                }


                /*
                |--------------------------------------------------------------------------
                | NO PAYMENT PROOF
                |--------------------------------------------------------------------------
                */

                else {

                    $('#detail-payment-proof')
                        .html('');

                    $('#detail-payment-proof-wrapper')
                        .hide();

                }


                /*
                |--------------------------------------------------------------------------
                | SHOW MODAL
                |--------------------------------------------------------------------------
                */

                $('#orderDetailModal').modal('show');

            });


        });



        /*
        |--------------------------------------------------------------------------
        | OPEN UPLOAD MODAL
        |--------------------------------------------------------------------------
        */

        function openUploadProof(uuid)
        {
            if (!uuid) {
                return;
            }


            /*
            |--------------------------------------------------------------------------
            | ACTION URL
            |--------------------------------------------------------------------------
            */

            const action =
                "{{ url('user-page/subscription/order') }}/" +
                uuid +
                "/upload-proof";


            $('#upload-proof-form')
                .attr(
                    'action',
                    action
                );


            /*
            |--------------------------------------------------------------------------
            | RESET FORM
            |--------------------------------------------------------------------------
            */

            const form =
                document.getElementById(
                    'upload-proof-form'
                );


            if (form) {
                form.reset();
            }


            /*
            |--------------------------------------------------------------------------
            | DEFAULT DATE
            |--------------------------------------------------------------------------
            */

            $('#payment-date')
                .val(
                    "{{ date('Y-m-d') }}"
                );


            /*
            |--------------------------------------------------------------------------
            | SHOW MODAL
            |--------------------------------------------------------------------------
            */

            $('#uploadProofModal')
                .modal('show');
        }



        /*
        |--------------------------------------------------------------------------
        | SHOW COPIED
        |--------------------------------------------------------------------------
        */

        function showCopied(button)
        {
            const originalText =
                button.text();


            button.text(
                'Tersalin!'
            );


            setTimeout(
                function () {

                    button.text(
                        originalText
                    );

                },
                1500
            );
        }



        /*
        |--------------------------------------------------------------------------
        | FALLBACK COPY
        |--------------------------------------------------------------------------
        */

        function fallbackCopy(
            text,
            button
        ) {

            const textarea =
                document.createElement(
                    'textarea'
                );


            textarea.value = text;

            textarea.style.position =
                'fixed';

            textarea.style.opacity =
                '0';


            document.body.appendChild(
                textarea
            );


            textarea.focus();

            textarea.select();


            try {

                document.execCommand(
                    'copy'
                );


                showCopied(button);


            } catch (error) {

                Swal.fire({

                    icon: 'error',

                    title: 'Gagal',

                    text:
                        'Nomor rekening gagal disalin.'

                });

            }


            document.body.removeChild(
                textarea
            );
        }



        /*
        |--------------------------------------------------------------------------
        | RUPIAH
        |--------------------------------------------------------------------------
        */

        function formatRupiah(value)
        {
            return new Intl.NumberFormat(
                'id-ID',
                {
                    maximumFractionDigits: 0
                }
            ).format(
                parseFloat(value) || 0
            );
        }

    </script>

@endsection