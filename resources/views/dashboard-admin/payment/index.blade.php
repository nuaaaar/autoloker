@extends('layouts.dashboard-admin')

@section('title', 'Approval Pembayaran Manual')

@section('css')

<style>

    .filter-label {
        font-weight: 600;
        font-size: 13px;
        margin-bottom: 5px;
    }

    .payment-status {
        font-size: 12px;
        font-weight: 600;
        padding: 5px 9px;
        border-radius: 6px;
    }

</style>

@endsection


@section('breadcrumb')

    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
        Approval Pembayaran
    </h1>

    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">

        <li class="breadcrumb-item text-muted">
            <a href="javascript:;" class="text-muted text-hover-primary">
                Beranda
            </a>
        </li>

        <li class="breadcrumb-item">
            <span class="bullet bg-gray-500 w-5px h-2px"></span>
        </li>

        <li class="breadcrumb-item text-muted">
            Pembayaran
        </li>

        <li class="breadcrumb-item">
            <span class="bullet bg-gray-500 w-5px h-2px"></span>
        </li>

        <li class="breadcrumb-item text-muted">
            Approval Pembayaran
        </li>

    </ul>

@endsection


@section('content')

<div class="row">

    <div class="col-lg-12">

        <div class="card">

            <div class="card-header">

                <div class="d-flex justify-content-between align-items-center">

                    <h5 class="card-title mb-0">
                        List Pembayaran Manual
                    </h5>

                    <div class="card-toolbar">

                        <div class="card-button"></div>

                    </div>

                </div>

            </div>


            <div class="card-body">


                {{-- FILTER --}}

                <div class="row mb-5">

                    <div class="col-md-3 mb-3">

                        <label class="filter-label">
                            Start Date
                        </label>

                        <input
                            type="date"
                            id="start_date"
                            class="form-control">

                    </div>


                    <div class="col-md-3 mb-3">

                        <label class="filter-label">
                            End Date
                        </label>

                        <input
                            type="date"
                            id="end_date"
                            class="form-control">

                    </div>


                    <div class="col-md-3 mb-3">

                        <label class="filter-label">
                            Status
                        </label>

                        <select
                            id="status"
                            class="form-select">

                            <option value="">
                                Semua Status
                            </option>

                            <option value="pending_payment">
                                Menunggu Pembayaran
                            </option>

                            <option value="verification">
                                Menunggu Verifikasi
                            </option>

                            <option value="approved">
                                Disetujui
                            </option>

                            <option value="rejected">
                                Ditolak
                            </option>

                        </select>

                    </div>


                    <div class="col-md-3 mb-3 d-flex align-items-end">

                        <button
                            type="button"
                            class="btn btn-primary me-2"
                            id="btnFilter">

                            <i class="fas fa-filter me-1"></i>

                            Filter

                        </button>


                        <button
                            type="button"
                            class="btn btn-light"
                            id="btnReset">

                            <i class="fas fa-sync-alt me-1"></i>

                            Reset

                        </button>

                    </div>

                </div>


                {{-- TABLE --}}

                <div class="table-responsive">

                    <table
                        id="datatable"
                        class="table table-bordered dt-responsive nowrap w-100">

                        <thead>

                            <tr>

                                <th width="1%">
                                    ID
                                </th>

                                <th>
                                    Order
                                </th>

                                <th>
                                    User
                                </th>

                                <th>
                                    Paket
                                </th>

                                <th>
                                    Role
                                </th>

                                <th>
                                    Harga
                                </th>

                                <th>
                                    Pembayaran
                                </th>

                                <th>
                                    Tanggal
                                </th>

                                <th>
                                    Status
                                </th>

                                <th
                                    width="8%"
                                    class="text-end">

                                    Aksi

                                </th>

                            </tr>

                        </thead>

                        <tbody>
                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- REJECT MODAL --}}

<div
    class="modal fade"
    id="rejectModal"
    tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <form id="formReject">

                @csrf

                <input
                    type="hidden"
                    id="reject_uuid">


                <div class="modal-header">

                    <h5 class="modal-title">
                        Tolak Pembayaran
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>


                <div class="modal-body">

                    <div class="alert alert-warning">

                        Pembayaran akan ditandai sebagai
                        <strong>ditolak</strong>.

                    </div>


                    <label class="form-label required">

                        Alasan Penolakan

                    </label>


                    <textarea
                        class="form-control"
                        id="rejected_reason"
                        name="rejected_reason"
                        rows="4"
                        placeholder="Masukkan alasan penolakan..."
                        required></textarea>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal">

                        Batal

                    </button>


                    <button
                        type="submit"
                        class="btn btn-danger"
                        id="btnSubmitReject">

                        Tolak Pembayaran

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<div
    class="modal fade"
    id="detailModal"
    tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    Detail Pembayaran
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>


            <div class="modal-body">

                <div id="detailLoading"
                     class="text-center py-5">

                    <div
                        class="spinner-border text-primary">
                    </div>

                    <div class="mt-3">
                        Memuat detail...
                    </div>

                </div>


                <div id="detailContent"
                     style="display:none;">

                    <div class="row">


                        {{-- ORDER --}}

                        <div class="col-md-6 mb-5">

                            <label class="text-muted fs-7">
                                Nomor Order
                            </label>

                            <div
                                class="fw-bold"
                                id="detail_order_number">
                            </div>

                        </div>


                        {{-- STATUS --}}

                        <div class="col-md-6 mb-5">

                            <label class="text-muted fs-7">
                                Status
                            </label>

                            <div id="detail_status">
                            </div>

                        </div>


                        {{-- USER --}}

                        <div class="col-md-6 mb-5">

                            <label class="text-muted fs-7">
                                Nama User
                            </label>

                            <div
                                class="fw-bold"
                                id="detail_user_name">
                            </div>

                        </div>


                        {{-- EMAIL --}}

                        <div class="col-md-6 mb-5">

                            <label class="text-muted fs-7">
                                Email
                            </label>

                            <div id="detail_user_email">
                            </div>

                        </div>


                        {{-- ROLE --}}

                        <div class="col-md-6 mb-5">

                            <label class="text-muted fs-7">
                                Role
                            </label>

                            <div id="detail_role">
                            </div>

                        </div>


                        {{-- PAKET --}}

                        <div class="col-md-6 mb-5">

                            <label class="text-muted fs-7">
                                Paket
                            </label>

                            <div
                                class="fw-bold"
                                id="detail_subscription">
                            </div>

                        </div>


                        {{-- HARGA --}}

                        <div class="col-md-6 mb-5">

                            <label class="text-muted fs-7">
                                Harga
                            </label>

                            <div
                                class="fw-bold"
                                id="detail_price">
                            </div>

                        </div>


                        {{-- PAYMENT METHOD --}}

                        <div class="col-md-6 mb-5">

                            <label class="text-muted fs-7">
                                Metode Pembayaran
                            </label>

                            <div id="detail_payment_method">
                            </div>

                        </div>


                        {{-- PAYMENT ACCOUNT --}}

                        <div class="col-md-6 mb-5">

                            <label class="text-muted fs-7">
                                Rekening / Akun Pembayaran
                            </label>

                            <div id="detail_payment_account">
                            </div>

                        </div>


                        {{-- PAYMENT DATE --}}

                        <div class="col-md-6 mb-5">

                            <label class="text-muted fs-7">
                                Tanggal Pembayaran
                            </label>

                            <div id="detail_payment_date">
                            </div>

                        </div>


                        {{-- EXPIRED --}}

                        <div class="col-md-6 mb-5">

                            <label class="text-muted fs-7">
                                Expired
                            </label>

                            <div id="detail_expired_at">
                            </div>

                        </div>


                        {{-- NOTES --}}

                        <div class="col-md-12 mb-5">

                            <label class="text-muted fs-7">
                                Catatan
                            </label>

                            <div
                                class="border rounded p-3"
                                id="detail_notes">
                            </div>

                        </div>


                        {{-- REJECT REASON --}}

                        <div
                            class="col-md-12 mb-5"
                            id="detail_rejected_wrapper"
                            style="display:none;">

                            <label class="text-muted fs-7">
                                Alasan Penolakan
                            </label>

                            <div
                                class="alert alert-danger mb-0"
                                id="detail_rejected_reason">
                            </div>

                        </div>


                        {{-- BUKTI PEMBAYARAN --}}

                        <div class="col-md-12">

                            <label class="text-muted fs-7 mb-2">
                                Bukti Pembayaran
                            </label>

                            <div
                                class="border rounded p-3 text-center">

                                <a
                                    href="#"
                                    id="detail_file_link"
                                    target="_blank">

                                    <img
                                        src=""
                                        id="detail_file"
                                        class="img-fluid rounded"
                                        style="max-height:400px;"
                                        alt="Bukti Pembayaran">

                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-light"
                    data-bs-dismiss="modal">

                    Tutup

                </button>

            </div>

        </div>

    </div>

</div>
@endsection


@section('js')

<script>

$(document).ready(function () {


    let currentDraw = 1;


    /*
    |--------------------------------------------------------------------------
    | DATATABLE
    |--------------------------------------------------------------------------
    */

    if ($.fn.DataTable.isDataTable('#datatable')) {

        $('#datatable')
            .DataTable()
            .destroy();

    }


    let table = $('#datatable').DataTable({

        processing: true,

        serverSide: true,

        scrollX: true,

        responsive: false,

        aLengthMenu: [
            [10, 25, 50, 75, 999999],
            [10, 25, 50, 75, "All"]
        ],


        ajax: {

            url: '{{ route("dashboard-admin.payment.index") }}',

            type: 'GET',


            data: function (d) {

                currentDraw = d.draw;

                d.page =
                    (d.start / d.length) + 1;

                d.length =
                    d.length;


                /*
                |--------------------------------------------------------------------------
                | FILTER
                |--------------------------------------------------------------------------
                */

                d.start_date =
                    $('#start_date').val();

                d.end_date =
                    $('#end_date').val();

                d.status =
                    $('#status').val();

                d.search =
                    d.search.value;

            },


            dataFilter: function (response) {

                let json =
                    JSON.parse(response);


                return JSON.stringify({

                    draw: currentDraw,

                    recordsTotal:
                        json.results.total,

                    recordsFiltered:
                        json.results.total,

                    data:
                        json.results.data

                });

            }

        },


        columns: [

            {
                data: "id",

                render: function (data) {

                    return (
                        '000000' + data
                    ).slice(-6);

                }

            },


            {
                data: "order_number",

                render: function (data) {

                    return `
                        <span class="fw-bold">
                            ${data ?? '-'}
                        </span>
                    `;

                }

            },


            {
                data: "user",

                render: function (data) {

                    if (!data) {
                        return '-';
                    }

                    return `
                        <div>
                            <div class="fw-semibold">
                                ${data.name ?? '-'}
                            </div>

                            <small class="text-muted">
                                ${data.email ?? '-'}
                            </small>
                        </div>
                    `;

                }

            },


            {
                data: "subscription",

                render: function (data) {

                    if (!data) {
                        return '-';
                    }

                    return data.name ?? '-';

                }

            },


            {
                data: "role",

                render: function (data) {

                    return `
                        <span class="badge badge-light-primary">
                            ${data ?? '-'}
                        </span>
                    `;

                }

            },


            {
                data: "price",

                render: function (data) {

                    let number =
                        parseFloat(data || 0);

                    return 'Rp ' +
                        number.toLocaleString(
                            'id-ID'
                        );

                }

            },


            {
                data: "payment_method",

                render: function (data, type, row) {

                    return `
                        <div>
                            <div>
                                ${data ?? '-'}
                            </div>

                            <small class="text-muted">
                                ${row.payment_account ?? ''}
                            </small>
                        </div>
                    `;

                }

            },


            {
                data: "payment_date",

                render: function (data) {

                    if (!data) {
                        return '-';
                    }

                    let date =
                        new Date(data);

                    return date.toLocaleString(
                        'id-ID'
                    );

                }

            },


            {
                data: "status",

                render: function (data) {

                    if (data === 'pending_payment') {

                        return `
                            <span class="badge badge-light-warning">
                                Menunggu
                            </span>
                        `;

                    }


                    if (data === 'approved') {

                        return `
                            <span class="badge badge-light-success">
                                Disetujui
                            </span>
                        `;

                    }


                    if (data === 'rejected') {

                        return `
                            <span class="badge badge-light-danger">
                                Ditolak
                            </span>
                        `;

                    }


                    return `
                        <span class="badge badge-light-secondary">
                            ${data ?? '-'}
                        </span>
                    `;

                }

            },


            {
                data: null,

                orderable: false,

                searchable: false,

                className: "text-end",

                render: function (data) {

                    let action = `
                        <button
                            type="button"
                            class="btn btn-outline-info btn-sm me-1"
                            onclick="detailData('${data.uuid}')"
                            data-bs-toggle="tooltip"
                            title="Detail">

                            <i
                                class="fas fa-eye"
                                style="display: contents;">
                            </i>

                        </button>
                    `;


                    /*
                    |--------------------------------------------------------------------------
                    | ACTION APPROVAL
                    |--------------------------------------------------------------------------
                    */

                    if (data.status === 'verification') {

                        action += `

                            <button
                                type="button"
                                class="btn btn-outline-success btn-sm me-1 btn-approve"
                                data-uuid="${data.uuid}"
                                data-bs-toggle="tooltip"
                                title="Approve">

                                <i
                                    class="fas fa-check"
                                    style="display: contents;">
                                </i>

                            </button>


                            <button
                                type="button"
                                class="btn btn-outline-danger btn-sm"
                                onclick="rejectData('${data.uuid}')"
                                data-bs-toggle="tooltip"
                                title="Reject">

                                <i
                                    class="fas fa-times"
                                    style="display: contents;">
                                </i>

                            </button>

                        `;
                    }


                    return action;

                }

            }

        ],


        dom: 'Blfrtip',


        buttons: [

            {
                extend: 'colvis',

                text:
                    '<i class="fas fa-eye me-1"></i>Kolom',

                className:
                    'btn btn-light-primary'

            },


            {
                extend: 'copy',

                text:
                    '<i class="fas fa-copy me-1"></i>Copy',

                className:
                    'btn btn-light-danger'

            },


            {
                extend: 'excel',

                text:
                    '<i class="fas fa-file-excel me-1"></i>Excel',

                className:
                    'btn btn-light-success'

            }

        ],


        drawCallback: function () {

            $('[data-bs-toggle="tooltip"]').tooltip();

        }

    });


    table
        .buttons()
        .container()
        .appendTo('.card-button');


    /*
    |--------------------------------------------------------------------------
    | FILTER
    |--------------------------------------------------------------------------
    */

    $('#btnFilter').on(
        'click',
        function () {

            table
                .ajax
                .reload();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | RESET
    |--------------------------------------------------------------------------
    */

    $('#btnReset').on(
        'click',
        function () {

            $('#start_date').val('');

            $('#end_date').val('');

            $('#status').val('');

            table
                .ajax
                .reload();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | REJECT FORM
    |--------------------------------------------------------------------------
    */

    $('#formReject').submit(
        function (e) {

            e.preventDefault();


            let uuid =
                $('#reject_uuid').val();


            let reason =
                $('#rejected_reason').val();


            $('#btnSubmitReject')
                .prop('disabled', true)
                .html('Memproses...');


            $.ajax({

                url:
                    "{{ route('dashboard-admin.payment.reject', ':uuid') }}"
                        .replace(':uuid', uuid),

                type: 'POST',

                data: {

                    _token:
                        "{{ csrf_token() }}",

                    rejected_reason:
                        reason

                },


                success: function (res) {

                    $('#rejectModal')
                        .modal('hide');


                    $('#formReject')[0]
                        .reset();


                    Swal.fire({

                        icon: 'success',

                        title: 'Berhasil',

                        text:
                            res.message,

                        timer: 1500,

                        showConfirmButton: false

                    });


                    table
                        .ajax
                        .reload(
                            null,
                            false
                        );

                },


                error: function (xhr) {

                    Swal.fire({

                        icon: 'error',

                        title: 'Gagal',

                        text:
                            xhr.responseJSON?.message ??
                            'Terjadi kesalahan.'

                    });

                },


                complete: function () {

                    $('#btnSubmitReject')
                        .prop('disabled', false)
                        .html(
                            'Tolak Pembayaran'
                        );

                }

            });

        }
    );

});

$(document).on('click', '.btn-approve', function (e) {

    e.preventDefault();

    let uuid = $(this).data('uuid');

    approveData(uuid);

});

/*
|--------------------------------------------------------------------------
| APPROVE
|--------------------------------------------------------------------------
*/

function approveData(uuid)
{
    Swal.fire({

        title: 'Approve Pembayaran?',

        text: 'Pembayaran ini akan disetujui dan subscription user akan diaktifkan.',

        icon: 'question',

        showCancelButton: true,

        confirmButtonText: 'Ya, Approve',

        cancelButtonText: 'Batal',

        reverseButtons: true

    }).then(function (result) {

        if (!result.isConfirmed) {
            return;
        }

        let url = "{{ route('dashboard-admin.payment.approve', ':uuid') }}"
            .replace(':uuid', uuid);

        console.log('APPROVE URL:', url);

        $.ajax({

            url: url,

            method: 'POST',

            data: {
                _token: "{{ csrf_token() }}"
            },

            beforeSend: function () {

                Swal.fire({

                    title: 'Memproses...',

                    text: 'Mohon tunggu.',

                    allowOutsideClick: false,

                    allowEscapeKey: false,

                    didOpen: function () {
                        Swal.showLoading();
                    }

                });

            },

            success: function (res) {

                Swal.fire({

                    icon: 'success',

                    title: 'Berhasil',

                    text: res.message,

                    timer: 1500,

                    showConfirmButton: false

                });

                $('#datatable')
                    .DataTable()
                    .ajax
                    .reload(null, false);

            },

            error: function (xhr) {

                console.log('APPROVE ERROR:', xhr);

                Swal.fire({

                    icon: 'error',

                    title: 'Gagal',

                    text:
                        xhr.responseJSON?.message ??
                        'Terjadi kesalahan.'

                });

            }

        });

    });
}


/*
|--------------------------------------------------------------------------
| REJECT
|--------------------------------------------------------------------------
*/

function rejectData(uuid)
{

    $('#reject_uuid')
        .val(uuid);


    $('#rejected_reason')
        .val('');


    $('#rejectModal')
        .modal('show');

}

function detailData(uuid)
{
    $('#detailLoading').show();

    $('#detailContent').hide();

    $('#detailModal').modal('show');


    $.ajax({

        url:
            "{{ route('dashboard-admin.payment.show', ':uuid') }}"
                .replace(':uuid', uuid),

        type: 'GET',


        success: function (res) {

            let data = res.data;


            /*
            |--------------------------------------------------------------------------
            | ORDER
            |--------------------------------------------------------------------------
            */

            $('#detail_order_number')
                .text(data.order_number ?? '-');


            /*
            |--------------------------------------------------------------------------
            | USER
            |--------------------------------------------------------------------------
            */

            $('#detail_user_name')
                .text(
                    data.user?.name ?? '-'
                );


            $('#detail_user_email')
                .text(
                    data.user?.email ?? '-'
                );


            /*
            |--------------------------------------------------------------------------
            | ROLE
            |--------------------------------------------------------------------------
            */

            $('#detail_role')
                .html(`
                    <span class="badge badge-light-primary">
                        ${data.role ?? '-'}
                    </span>
                `);


            /*
            |--------------------------------------------------------------------------
            | SUBSCRIPTION
            |--------------------------------------------------------------------------
            */

            $('#detail_subscription')
                .text(
                    data.subscription?.name ?? '-'
                );


            /*
            |--------------------------------------------------------------------------
            | PRICE
            |--------------------------------------------------------------------------
            */

            let price =
                parseFloat(data.price || 0);


            $('#detail_price')
                .text(
                    'Rp ' +
                    price.toLocaleString('id-ID')
                );


            /*
            |--------------------------------------------------------------------------
            | PAYMENT
            |--------------------------------------------------------------------------
            */

            $('#detail_payment_method')
                .text(
                    data.payment_method ?? '-'
                );


            $('#detail_payment_account')
                .text(
                    data.payment_account ?? '-'
                );


            /*
            |--------------------------------------------------------------------------
            | DATE
            |--------------------------------------------------------------------------
            */

            $('#detail_payment_date')
                .text(
                    formatDate(data.payment_date)
                );


            $('#detail_expired_at')
                .text(
                    formatDate(data.expired_at)
                );


            /*
            |--------------------------------------------------------------------------
            | NOTES
            |--------------------------------------------------------------------------
            */

            $('#detail_notes')
                .text(
                    data.notes ?? '-'
                );


            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

            let statusHtml = '';


            if (data.status === 'pending_payment') {

                statusHtml = `
                    <span class="badge badge-light-warning">
                        Menunggu Bukti Upload
                    </span>
                `;

            } else if (data.status === 'verification') {

                statusHtml = `
                    <span class="badge badge-light-info">
                        Menunggu Verifikasi
                    </span>
                `;

            }
            else if (data.status === 'approved') {

                statusHtml = `
                    <span class="badge badge-light-success">
                        Disetujui
                    </span>
                `;

            }
            else if (data.status === 'rejected') {

                statusHtml = `
                    <span class="badge badge-light-danger">
                        Ditolak
                    </span>
                `;

            }
            else {

                statusHtml = `
                    <span class="badge badge-light-secondary">
                        ${data.status ?? '-'}
                    </span>
                `;

            }


            $('#detail_status')
                .html(statusHtml);


            /*
            |--------------------------------------------------------------------------
            | REJECTED REASON
            |--------------------------------------------------------------------------
            */

            if (data.rejected_reason) {

                $('#detail_rejected_wrapper')
                    .show();

                $('#detail_rejected_reason')
                    .text(
                        data.rejected_reason
                    );

            }
            else {

                $('#detail_rejected_wrapper')
                    .hide();

            }


            /*
            |--------------------------------------------------------------------------
            | FILE
            |--------------------------------------------------------------------------
            */

            if (data.file) {

                let fileUrl =
                    "/uploads/payment/" +
                    data.file;


                $('#detail_file')
                    .attr(
                        'src',
                        fileUrl
                    );


                $('#detail_file_link')
                    .attr(
                        'href',
                        fileUrl
                    )
                    .show();

            }
            else {

                $('#detail_file')
                    .attr(
                        'src',
                        ''
                    );


                $('#detail_file_link')
                    .hide();

            }


            /*
            |--------------------------------------------------------------------------
            | SHOW
            |--------------------------------------------------------------------------
            */

            $('#detailLoading')
                .hide();

            $('#detailContent')
                .show();

        },


        error: function (xhr) {

            $('#detailModal')
                .modal('hide');


            Swal.fire({

                icon: 'error',

                title: 'Gagal',

                text:
                    xhr.responseJSON?.message ??
                    'Gagal mengambil detail pembayaran.'

            });

        }

    });

}

function formatDate(date)
{
    if (!date) {
        return '-';
    }

    let d = new Date(date);

    return d.toLocaleString('id-ID', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

</script>

@endsection