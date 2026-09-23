{{-- ================================================================
     FLASH MESSAGE
================================================================ --}}

@if(session('OK'))

    <div class="ph-flash ph-flash-success">

        <div class="ph-flash-icon">

            <i class="bx bx-check-circle"></i>

        </div>


        <div>

            <div class="ph-flash-title">
                Berhasil
            </div>

            <div class="ph-flash-message">
                {{ session('OK') }}
            </div>

        </div>

    </div>

@endif


@if(session('ERR'))

    <div class="ph-flash ph-flash-danger">

        <div class="ph-flash-icon">

            <i class="bx bx-error-circle"></i>

        </div>


        <div>

            <div class="ph-flash-title">
                Gagal
            </div>

            <div class="ph-flash-message">
                {{ session('ERR') }}
            </div>

        </div>

    </div>

@endif



{{-- ================================================================
     VALIDATION ERROR
================================================================ --}}

@if($errors->any())

    <div class="ph-flash ph-flash-danger">

        <div class="ph-flash-icon">

            <i class="bx bx-error-circle"></i>

        </div>


        <div>

            <div class="ph-flash-title">
                Periksa Data
            </div>


            <div class="ph-flash-message">

                {{ $errors->first() }}

            </div>

        </div>

    </div>

@endif



{{-- ================================================================
     SUMMARY
================================================================ --}}

<div class="payment-summary">


    {{-- TOTAL ORDER --}}
    <div class="payment-summary-card">

        <div class="payment-summary-label">

            Total Order

        </div>


        <div class="payment-summary-value">

            {{ $totalOrders }}

        </div>


        <div class="payment-summary-sub">

            semua waktu

        </div>

    </div>



    {{-- TOTAL DIBAYAR --}}
    <div class="payment-summary-card">

        <div class="payment-summary-label">

            Total Dibayar

        </div>


        <div class="payment-summary-value">

            Rp {{ number_format(
                $totalPaid,
                0,
                ',',
                '.'
            ) }}

        </div>


        <div class="payment-summary-sub">

            terverifikasi

        </div>

    </div>



    {{-- PAKET AKTIF --}}
    <div class="payment-summary-card">

        <div class="payment-summary-label">

            Paket Aktif

        </div>


        <div class="payment-summary-value">

            @if(
                $activeSubscription &&
                $activeSubscription->subscription
            )

                {{ $activeSubscription->subscription->name }}

            @else

                -

            @endif

        </div>


        <div class="payment-summary-sub">

            @if(
                $activeSubscription &&
                $activeSubscription->started_at
            )

                {{ \Carbon\Carbon::parse(
                    $activeSubscription->started_at
                )->format('Y-m-d') }}

            @else

                Belum ada

            @endif

        </div>

    </div>

</div>



{{-- ================================================================
     WAITING PAYMENT
================================================================ --}}

@if($pendingPayment)

    <div class="payment-alert warning">


        <div class="payment-alert-icon">

            <i class="bx bx-credit-card"></i>

        </div>


        <div class="payment-alert-content">

            <div class="payment-alert-title">

                Menunggu Pembayaran

            </div>


            <div class="payment-alert-description">

                {{ $pendingPayment->order_number }}

                @if($pendingPayment->subscription)

                    •
                    {{ $pendingPayment->subscription->name }}

                @endif

                •

                <strong>

                    Rp
                    {{ number_format(
                        $pendingPayment->price,
                        0,
                        ',',
                        '.'
                    ) }}

                </strong>

            </div>

        </div>


        <div class="payment-alert-action">

            <button
                type="button"
                class="ph-btn ph-btn-warning"
                onclick="
                    openUploadProof(
                        '{{ $pendingPayment->uuid }}'
                    )
                ">

                Upload Bukti

            </button>

        </div>

    </div>

@endif



{{-- ================================================================
     REJECTED PAYMENT
================================================================ --}}

@if($rejectedPayment)

    <div class="payment-alert danger">


        <div class="payment-alert-icon">

            <i class="bx bx-error-circle"></i>

        </div>


        <div class="payment-alert-content">

            <div class="payment-alert-title">

                Pembayaran Ditolak

            </div>


            <div class="payment-alert-description">

                {{ $rejectedPayment->rejected_reason
                    ?: 'Nominal transfer tidak sesuai. Harap kirim ulang bukti yang benar.'
                }}

            </div>

        </div>


        <div class="payment-alert-action">

            <button
                type="button"
                class="ph-btn ph-btn-danger"
                onclick="
                    openUploadProof(
                        '{{ $rejectedPayment->uuid }}'
                    )
                ">

                Upload Ulang

            </button>

        </div>

    </div>

@endif



{{-- ================================================================
     BANK ACCOUNT
================================================================ --}}

<div class="ph-section-title">

    Rekening Tujuan Transfer

</div>


<div class="bank-account-grid">


    @forelse(
        $bankAccounts
        as $bank
    )

        @php

            $bankName =
                strtolower(
                    trim(
                        $bank->bank_name
                    )
                );


            $bankClass = 'default';


            if (
                str_contains(
                    $bankName,
                    'bca'
                )
            ) {

                $bankClass = 'bca';

            } elseif (
                str_contains(
                    $bankName,
                    'mandiri'
                )
            ) {

                $bankClass = 'mandiri';

            } elseif (
                str_contains(
                    $bankName,
                    'bni'
                )
            ) {

                $bankClass = 'bni';

            }

        @endphp


        <div class="bank-card {{ $bankClass }}">


            <div class="bank-name">

                <span>

                    {{ strtoupper(
                        $bank->bank_name
                    ) }}

                </span>


                <i class="bx bx-credit-card-alt"></i>

            </div>


            <div class="bank-account-number">

                {{ $bank->bank_number }}

            </div>


            <div class="bank-account-owner">

                {{ $bank->bank_account_name }}

            </div>


            <button
                type="button"
                class="bank-copy-btn"
                data-account="{{ $bank->bank_number }}">

                Salin Nomor

            </button>

        </div>

    @empty

        <div class="bank-empty">

            <i class="bx bx-credit-card"></i>

            <span>
                Rekening pembayaran belum tersedia.
            </span>

        </div>

    @endforelse

</div>


<div class="bank-description">

    Transfer nominal tepat.
    Bukti wajib diunggah agar bisa diverifikasi admin.

</div>



{{-- ================================================================
     RIWAYAT ORDER
================================================================ --}}

<div class="ph-section-title">

    Riwayat Order

</div>



{{-- ================================================================
     ORDER LIST
================================================================ --}}

@if($orders->count())


    @foreach($orders as $order)


        @php

            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

            $status =
                $order->status;


            switch ($status) {

                case 'pending_payment':

                    $statusClass =
                        'pending';

                    $statusLabel =
                        'Menunggu Pembayaran';

                    $statusIcon =
                        'bx-time-five';

                    break;


                case 'verification':

                    $statusClass =
                        'verification';

                    $statusLabel =
                        'Menunggu Verifikasi';

                    $statusIcon =
                        'bx-rotate-left';

                    break;


                case 'verified':

                    $statusClass =
                        'paid';

                    $statusLabel =
                        'Terverifikasi';

                    $statusIcon =
                        'bx-file';

                    break;


                case 'approved':

                    $statusClass =
                        'approved';

                    $statusLabel =
                        'Terverifikasi';

                    $statusIcon =
                        'bx-file';

                    break;


                case 'rejected':

                    $statusClass =
                        'rejected';

                    $statusLabel =
                        'Ditolak';

                    $statusIcon =
                        'bx-error-circle';

                    break;


                default:

                    $statusClass =
                        'verification';

                    $statusLabel =
                        ucfirst(
                            str_replace(
                                '_',
                                ' ',
                                $status
                            )
                        );

                    $statusIcon =
                        'bx-file';

                    break;

            }


            /*
            |--------------------------------------------------------------------------
            | SUBSCRIPTION
            |--------------------------------------------------------------------------
            */

            $subscription =
                $order->subscription;


            /*
            |--------------------------------------------------------------------------
            | USER SUBSCRIPTION
            |--------------------------------------------------------------------------
            */

            $userSubscription =
                $order->userSubscription;


            /*
            |--------------------------------------------------------------------------
            | PAYMENT PROOF
            |--------------------------------------------------------------------------
            */

            $proofUploaded =
                !empty(
                    $order->file
                );


            /*
            |--------------------------------------------------------------------------
            | VERIFIED
            |--------------------------------------------------------------------------
            */

            $verified =
                !empty(
                    $order->verified_at
                );


            /*
            |--------------------------------------------------------------------------
            | PAYMENT DATE
            |--------------------------------------------------------------------------
            */

            $paymentDate = null;

            if ($order->payment_date) {

                $paymentDate =
                    $order
                        ->payment_date
                        ->format('Y-m-d');

            }


            /*
            |--------------------------------------------------------------------------
            | EXPIRED DATE
            |--------------------------------------------------------------------------
            */

            $expiredDate = null;

            if (
                $userSubscription &&
                $userSubscription->expired_at
            ) {

                $expiredDate =
                    $userSubscription
                        ->expired_at
                        ->format('Y-m-d');

            }


            /*
            |--------------------------------------------------------------------------
            | ORDER DATE
            |--------------------------------------------------------------------------
            */

            $orderDate = null;

            if ($order->created_at) {

                $orderDate =
                    $order
                        ->created_at
                        ->format('Y-m-d');

            }

        @endphp



        {{-- ========================================================
             ORDER CARD
        ========================================================= --}}

        <div class="payment-order-card status-{{ $statusClass }}">


            {{-- ====================================================
                 HEADER
            ===================================================== --}}

            <div class="order-header">


                <div class="order-title-wrapper">


                    <div class="order-icon">

                        <i
                            class="bx {{ $statusIcon }}">
                        </i>

                    </div>


                    <div>


                        <div class="order-number">

                            {{ $order->order_number }}

                        </div>


                        <div class="order-package">

                            {{ $subscription
                                ? $subscription->name
                                : '-'
                            }}

                        </div>


                    </div>


                </div>



                {{-- STATUS --}}
                <div class="ph-status {{ $statusClass }}">

                    {{ $statusLabel }}

                </div>


            </div>



            {{-- ====================================================
                 INFORMATION
            ===================================================== --}}

            <div class="order-information">


                {{-- NOMINAL --}}
                <div class="order-info-item">

                    <div class="order-info-label">

                        Nominal

                    </div>


                    <div class="order-info-value">

                        Rp
                        {{ number_format(
                            $order->price,
                            0,
                            ',',
                            '.'
                        ) }}

                    </div>

                </div>



                {{-- TANGGAL ORDER --}}
                <div class="order-info-item">

                    <div class="order-info-label">

                        Tanggal Order

                    </div>


                    <div class="order-info-value">

                        {{ $orderDate ?: '-' }}

                    </div>

                </div>



                {{-- METODE --}}
                <div class="order-info-item">

                    <div class="order-info-label">

                        Metode

                    </div>


                    <div class="order-info-value">

                        {{ $order->payment_method ?: '-' }}

                    </div>

                </div>



                {{-- TANGGAL TRANSFER --}}
                <div class="order-info-item">

                    <div class="order-info-label">

                        Tgl Transfer

                    </div>


                    <div class="order-info-value">

                        {{ $paymentDate ?: '-' }}

                    </div>

                </div>



                {{-- BERLAKU HINGGA --}}
                @if($userSubscription)

                    <div class="order-info-item">

                        <div class="order-info-label">

                            Berlaku Hingga

                        </div>


                        <div class="order-info-value success">

                            {{ $expiredDate ?: '-' }}

                        </div>

                    </div>

                @endif


            </div>



            {{-- ====================================================
                 TIMELINE
            ===================================================== --}}

            <div class="payment-timeline">


                {{-- ORDER DIBUAT --}}
                <div class="timeline-item completed">


                    <div class="timeline-dot">

                        <i class="bx bx-check"></i>

                    </div>


                    <div class="timeline-label">

                        Order Dibuat

                    </div>


                </div>



                {{-- BUKTI DIKIRIM --}}
                <div
                    class="
                        timeline-item

                        @if($proofUploaded)
                            completed
                        @elseif(
                            $status ===
                            'pending_payment'
                        )
                            current
                        @endif
                    ">


                    <div class="timeline-dot">

                        @if($proofUploaded)

                            <i class="bx bx-check"></i>

                        @elseif(
                            $status ===
                            'pending_payment'
                        )

                            <i class="bx bx-time"></i>

                        @endif

                    </div>


                    <div class="timeline-label">

                        Bukti Dikirim

                    </div>


                </div>



                {{-- VERIFIKASI --}}
                <div
                    class="
                        timeline-item

                        @if($status === 'rejected')
                            rejected
                        @elseif($verified)
                            current
                        @endif
                    ">


                    <div class="timeline-dot">


                        @if($status === 'rejected')

                            <i class="bx bx-x"></i>

                        @elseif($verified)

                            <i class="bx bx-check"></i>

                        @endif


                    </div>


                    <div class="timeline-label">


                        @if($status === 'rejected')

                            Ditolak

                        @else

                            Terverifikasi

                        @endif


                    </div>


                </div>


            </div>



            {{-- ====================================================
                 VERIFIED MESSAGE
            ===================================================== --}}

            @if($verified)


                <div class="payment-verification-message">


                    <i class="bx bx-file"></i>


                    <span>

                        Diverifikasi

                        @if($order->verified_by)

                            oleh
                            {{ $order->verified_by }}

                        @else

                            oleh Admin AutoLoker

                        @endif


                        @if($order->verified_at)

                            •

                            {{ $order->verified_at->format('Y-m-d') }}

                        @endif

                    </span>


                </div>


            @endif



            {{-- ====================================================
                 REJECTED MESSAGE
            ===================================================== --}}

            @if(
                $status === 'rejected'
            )


                <div class="payment-rejected-message">


                    <i class="bx bx-error-circle"></i>


                    <span>

                        {{ $order->rejected_reason
                            ?: 'Pembayaran ditolak. Silakan kirim ulang bukti pembayaran yang benar.'
                        }}

                    </span>


                </div>


            @endif



            {{-- ====================================================
                 ACTION
            ===================================================== --}}

            <div
                class="
                    order-actions

                    @if(
                        !in_array(
                            $status,
                            [
                                'pending_payment',
                                'rejected'
                            ]
                        )
                    )
                        single
                    @endif
                ">


                {{-- DETAIL --}}
                <button
                    type="button"
                    class="order-action btn-order-detail"

                    data-order-id="{{ $order->uuid }}"

                    data-order-number="{{ $order->order_number }}"

                    data-package-name="{{ $subscription
                        ? $subscription->name
                        : '-'
                    }}"

                    data-price="{{ $order->price }}"

                    data-payment-method="{{ $order->payment_method ?: '-' }}"

                    data-payment-date="{{ $paymentDate ?: '-' }}"

                    data-status="{{ $statusLabel }}"

                    data-expired-at="{{ $expiredDate ?: '-' }}"

                    data-payment-proof="{{ $order->file
                        ? asset('uploads/payment/' . $order->file)
                        : ''
                    }}">

                    Lihat Detail

                </button>



                {{-- UPLOAD --}}
                @if(
                    in_array(
                        $status,
                        [
                            'pending_payment',
                            'rejected'
                        ]
                    )
                )


                    <button
                        type="button"

                        class="
                            order-action

                            @if(
                                $status ===
                                'rejected'
                            )
                                danger
                            @else
                                primary
                            @endif
                        "

                        onclick="
                            openUploadProof(
                                '{{ $order->uuid }}'
                            )
                        ">


                        @if(
                            $status ===
                            'rejected'
                        )

                            Upload Ulang

                        @else

                            Upload Bukti

                        @endif


                    </button>


                @endif


            </div>


        </div>


    @endforeach


@else


    {{-- ========================================================
         EMPTY
    ========================================================= --}}

    <div class="payment-order-card">


        <div class="payment-empty-state">


            <div class="payment-empty-icon">

                <i class="bx bx-receipt"></i>

            </div>


            <div class="payment-empty-title">

                Belum Ada Order

            </div>


            <div class="payment-empty-description">

                Anda belum memiliki riwayat pembayaran.

            </div>


        </div>


    </div>


@endif



{{-- ================================================================
     UPLOAD PAYMENT PROOF MODAL
================================================================ --}}

<div
    class="modal fade payment-modal"
    id="uploadProofModal"
    tabindex="-1"
    aria-hidden="true">


    <div class="modal-dialog modal-dialog-centered">


        <div class="modal-content">


            <form
                id="upload-proof-form"
                method="POST"
                enctype="multipart/form-data">


                @csrf



                {{-- HEADER --}}
                <div class="modal-header">


                    <h5 class="modal-title">

                        Upload Bukti Pembayaran

                    </h5>


                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                    </button>


                </div>



                {{-- BODY --}}
                <div class="modal-body">


                    {{-- PAYMENT METHOD --}}
                    <div class="mb-3">


                        <label class="form-label">

                            Metode Pembayaran

                        </label>


                        <select
                            name="payment_method"
                            class="form-control"
                            required>


                            <option value="">

                                Pilih Metode

                            </option>


                            @foreach(
                                $bankAccounts
                                as $bank
                            )

                                <option
                                    value="{{ $bank->bank_name }}">

                                    {{ strtoupper(
                                        $bank->bank_name
                                    ) }}

                                </option>

                            @endforeach


                        </select>


                    </div>



                    {{-- PAYMENT ACCOUNT --}}
                    <div class="mb-3">


                        <label class="form-label">

                            Rekening Pengirim

                        </label>


                        <input
                            type="text"
                            name="payment_account"
                            class="form-control"
                            placeholder="Nomor rekening pengirim">


                    </div>



                    {{-- PAYMENT DATE --}}
                    <div class="mb-3">


                        <label class="form-label">

                            Tanggal Transfer

                        </label>


                        <input
                            type="date"
                            name="payment_date"
                            id="payment-date"
                            class="form-control"
                            value="{{ date('Y-m-d') }}"
                            required>


                    </div>



                    {{-- PAYMENT PROOF --}}
                    <div class="mb-3">


                        <label class="form-label">

                            Bukti Pembayaran

                        </label>


                        <input
                            type="file"
                            name="payment_proof"
                            id="payment-proof"
                            class="form-control"
                            accept="image/jpeg,image/png,application/pdf"
                            required>


                    </div>



                    <div class="payment-upload-help">

                        Format JPG, JPEG, PNG atau PDF.
                        Maksimal 5 MB.

                    </div>


                </div>



                {{-- FOOTER --}}
                <div class="modal-footer">


                    <button
                        type="button"
                        class="ph-btn ph-btn-outline"
                        data-bs-dismiss="modal">

                        Batal

                    </button>


                    <button
                        type="submit"
                        class="ph-btn ph-btn-warning">

                        Kirim Bukti

                    </button>


                </div>


            </form>


        </div>


    </div>


</div>



{{-- ================================================================
     DETAIL ORDER MODAL
================================================================ --}}

<div
    class="modal fade payment-modal"
    id="orderDetailModal"
    tabindex="-1"
    aria-hidden="true">


    <div class="modal-dialog modal-dialog-centered">


        <div class="modal-content">


            {{-- HEADER --}}
            <div class="modal-header">


                <h5 class="modal-title">

                    Detail Order

                </h5>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>


            </div>



            {{-- BODY --}}
            <div class="modal-body">


                <div class="detail-modal-grid">


                    {{-- ORDER --}}
                    <div class="detail-modal-item">

                        <div class="detail-modal-label">

                            Nomor Order

                        </div>


                        <div
                            class="detail-modal-value"
                            id="detail-order-number">

                            -

                        </div>

                    </div>



                    {{-- PACKAGE --}}
                    <div class="detail-modal-item">

                        <div class="detail-modal-label">

                            Paket

                        </div>


                        <div
                            class="detail-modal-value"
                            id="detail-package-name">

                            -

                        </div>

                    </div>



                    {{-- PRICE --}}
                    <div class="detail-modal-item">

                        <div class="detail-modal-label">

                            Nominal

                        </div>


                        <div
                            class="detail-modal-value"
                            id="detail-price">

                            -

                        </div>

                    </div>



                    {{-- PAYMENT METHOD --}}
                    <div class="detail-modal-item">

                        <div class="detail-modal-label">

                            Metode Pembayaran

                        </div>


                        <div
                            class="detail-modal-value"
                            id="detail-payment-method">

                            -

                        </div>

                    </div>



                    {{-- PAYMENT DATE --}}
                    <div class="detail-modal-item">

                        <div class="detail-modal-label">

                            Tanggal Transfer

                        </div>


                        <div
                            class="detail-modal-value"
                            id="detail-payment-date">

                            -

                        </div>

                    </div>



                    {{-- STATUS --}}
                    <div class="detail-modal-item">

                        <div class="detail-modal-label">

                            Status

                        </div>


                        <div
                            class="detail-modal-value"
                            id="detail-status">

                            -

                        </div>

                    </div>



                    {{-- EXPIRED --}}
                    <div class="detail-modal-item">

                        <div class="detail-modal-label">

                            Berlaku Hingga

                        </div>


                        <div
                            class="detail-modal-value"
                            id="detail-expired-at">

                            -

                        </div>

                    </div>

                    {{-- PAYMENT PROOF --}}
                    <div
                        class="detail-modal-item"
                        id="detail-payment-proof-wrapper"
                        style="display: none;">

                        <div class="detail-modal-label">

                            Bukti Pembayaran

                        </div>


                        <div class="detail-modal-value">

                            <div id="detail-payment-proof"></div>

                        </div>

                    </div>


                </div>


            </div>



            {{-- FOOTER --}}
            <div class="modal-footer">


                <button
                    type="button"
                    class="ph-btn ph-btn-outline"
                    data-bs-dismiss="modal">

                    Tutup

                </button>


            </div>


        </div>


    </div>


</div>