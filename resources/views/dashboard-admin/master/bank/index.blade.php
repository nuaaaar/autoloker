@extends('layouts.dashboard-admin')

@section('title', 'Bank')

@section('css')

@endsection

@section('breadcrumb')

    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
        Bank
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
            Master
        </li>

        <li class="breadcrumb-item">
            <span class="bullet bg-gray-500 w-5px h-2px"></span>
        </li>

        <li class="breadcrumb-item text-muted">
            Bank
        </li>

    </ul>

@endsection


@section('content')

    {{-- ========================================================= --}}
    {{-- BUTTON TAMBAH --}}
    {{-- ========================================================= --}}

    <div class="row">

        <div class="col-lg-12">

            <button
                class="btn btn-primary py-2 mb-3"
                style="float:right"
                data-bs-toggle="modal"
                data-bs-target="#createModal">

                <i class="las la-plus me-1"></i>

                Tambah

            </button>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- TABLE --}}
    {{-- ========================================================= --}}

    <div class="row">

        <div class="col-lg-12">

            <div class="card">

                <div class="card-header">

                    <div class="d-flex justify-content-between">

                        <h5 class="card-title mb-0">
                            List Data
                        </h5>

                        <div class="card-toolbar">

                            <div class="card-button"></div>

                        </div>

                    </div>

                </div>


                <div class="card-body">

                    <table
                        id="datatable"
                        class="table table-bordered dt-responsive nowrap w-100 dataTable no-footer dtr-inline"
                        aria-describedby="datatable_info"
                        style="width: 1090px;">

                        <thead>

                            <tr>

                                <th width="1%">
                                    ID
                                </th>

                                <th>
                                    Nama Pemilik Rekening
                                </th>

                                <th>
                                    Nomor Rekening
                                </th>

                                <th>
                                    Nama Bank
                                </th>

                                <th
                                    class="text-end"
                                    width="5%">

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


    {{-- ========================================================= --}}
    {{-- MODAL CREATE --}}
    {{-- ========================================================= --}}

    <div
        class="modal fade"
        id="createModal"
        tabindex="-1">

        <div class="modal-dialog">

            <div class="modal-content">

                <form id="formCreate">

                    @csrf

                    <div class="modal-header">

                        <h5 class="modal-title">
                            Tambah Bank
                        </h5>

                        <button
                            class="btn-close"
                            data-bs-dismiss="modal"
                            type="button">
                        </button>

                    </div>


                    <div class="modal-body">

                        {{-- Nama Pemilik --}}

                        <div class="mb-4">

                            <label class="form-label required">
                                Nama Pemilik Rekening
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                name="account_name"
                                id="create_account_name"
                                placeholder="Masukkan nama pemilik rekening"
                                maxlength="255"
                                required>

                        </div>


                        {{-- Nomor Rekening --}}

                        <div class="mb-4">

                            <label class="form-label required">
                                Nomor Rekening
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                name="bank_number"
                                id="create_bank_number"
                                placeholder="Masukkan nomor rekening"
                                maxlength="100"
                                required>

                        </div>


                        {{-- Nama Bank --}}

                        <div class="mb-2">

                            <label class="form-label required">
                                Nama Bank
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                name="bank_name"
                                id="create_bank_name"
                                placeholder="Contoh: BCA"
                                maxlength="255"
                                required>

                        </div>

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
                            class="btn btn-primary"
                            id="btn-submit-create">

                            Simpan

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- MODAL EDIT --}}
    {{-- ========================================================= --}}

    <div
        class="modal fade"
        id="editModal"
        tabindex="-1">

        <div class="modal-dialog">

            <div class="modal-content">

                <form id="formEdit">

                    @csrf

                    @method('PUT')

                    <input
                        type="hidden"
                        id="edit_uuid">


                    <div class="modal-header">

                        <h5 class="modal-title">
                            Edit Bank
                        </h5>

                        <button
                            class="btn-close"
                            data-bs-dismiss="modal"
                            type="button">
                        </button>

                    </div>


                    <div class="modal-body">

                        {{-- Nama Pemilik --}}

                        <div class="mb-4">

                            <label class="form-label required">
                                Nama Pemilik Rekening
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                name="account_name"
                                id="edit_account_name"
                                placeholder="Masukkan nama pemilik rekening"
                                maxlength="255"
                                required>

                        </div>


                        {{-- Nomor Rekening --}}

                        <div class="mb-4">

                            <label class="form-label required">
                                Nomor Rekening
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                name="bank_number"
                                id="edit_bank_number"
                                placeholder="Masukkan nomor rekening"
                                maxlength="100"
                                required>

                        </div>


                        {{-- Nama Bank --}}

                        <div class="mb-2">

                            <label class="form-label required">
                                Nama Bank
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                name="bank_name"
                                id="edit_bank_name"
                                placeholder="Contoh: BCA"
                                maxlength="255"
                                required>

                        </div>

                    </div>


                    <div class="modal-footer">

                        <button
                            type="button"
                            class="btn btn-light"
                            data-bs-dismiss="modal">

                            Batal

                        </button>

                        <button
                            class="btn btn-primary"
                            type="submit"
                            id="btn-submit-edit">

                            Update

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- MODAL DELETE --}}
    {{-- ========================================================= --}}

    <div
        class="modal fade"
        tabindex="-1"
        role="dialog"
        id="deleteModal">

        <div
            class="modal-dialog"
            role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Hapus Bank
                    </h5>

                    <button
                        class="btn-close"
                        type="button"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                    </button>

                </div>


                <div class="modal-body">

                    <p>
                        Tindakan ini akan menghapus data dan data
                        yang dihapus tidak dapat dipulihkan, yakin
                        ingin melanjutkan?
                    </p>

                </div>


                <div class="modal-footer">

                    <form
                        action=""
                        method="post"
                        id="formDelete">

                        @csrf

                        @method('DELETE')

                        <input
                            type="hidden"
                            id="deleteUuid">


                        <button
                            type="button"
                            class="btn btn-light font-weight-bolder"
                            data-bs-dismiss="modal">

                            Tutup

                        </button>


                        <button
                            type="submit"
                            class="btn btn-danger font-weight-bolder"
                            id="btn-submit-delete">

                            Iya, Hapus

                        </button>

                    </form>

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

                aLengthMenu: [
                    [10, 25, 50, 75, 999999],
                    [10, 25, 50, 75, "All"]
                ],


                ajax: {

                    url: '{{ route("dashboard-admin.master.bank.index") }}',

                    type: 'GET',


                    data: function (d) {

                        currentDraw = d.draw;

                        d.page = (d.start / d.length) + 1;

                        d.length = d.length;

                    },


                    dataFilter: function (response) {

                        let json = JSON.parse(response);

                        return JSON.stringify({

                            draw: currentDraw,

                            recordsTotal: json.results.total,

                            recordsFiltered: json.results.total,

                            data: json.results.data

                        });

                    }

                },


                columns: [

                    /*
                    |--------------------------------------------------------------------------
                    | ID
                    |--------------------------------------------------------------------------
                    */

                    {

                        data: "id",

                        render: function (data) {

                            return ('000000' + data).slice(-6);

                        }

                    },


                    /*
                    |--------------------------------------------------------------------------
                    | ACCOUNT NAME
                    |--------------------------------------------------------------------------
                    */

                    {

                        data: "account_name",

                        render: function (data) {

                            return data ?? '-';

                        }

                    },


                    /*
                    |--------------------------------------------------------------------------
                    | BANK NUMBER
                    |--------------------------------------------------------------------------
                    */

                    {

                        data: "bank_number",

                        render: function (data) {

                            return data ?? '-';

                        }

                    },


                    /*
                    |--------------------------------------------------------------------------
                    | BANK NAME
                    |--------------------------------------------------------------------------
                    */

                    {

                        data: "bank_name",

                        render: function (data) {

                            return data ?? '-';

                        }

                    },


                    /*
                    |--------------------------------------------------------------------------
                    | ACTION
                    |--------------------------------------------------------------------------
                    */

                    {

                        data: null,

                        orderable: false,

                        searchable: false,

                        className: "text-end",


                        render: function (data) {

                            return `

                                <button
                                    class="btn btn-outline-primary btn-sm me-1"
                                    onclick="editData(
                                        '${data.uuid}',
                                        '${escapeHtml(data.account_name)}',
                                        '${escapeHtml(data.bank_number)}',
                                        '${escapeHtml(data.bank_name)}'
                                    )">

                                    <i
                                        class="fas fa-pencil-alt"
                                        style="display: contents;">
                                    </i>

                                </button>


                                <button
                                    class="btn btn-outline-danger btn-sm"
                                    onclick="deleteData('${data.uuid}')">

                                    <i
                                        class="fas fa-trash-alt"
                                        style="display: contents;">
                                    </i>

                                </button>

                            `;

                        }

                    }

                ],


                /*
                |--------------------------------------------------------------------------
                | BUTTONS
                |--------------------------------------------------------------------------
                */

                dom: 'Blfrtip',

                buttons: [

                    {

                        extend: 'colvis',

                        text: '<i class="fas fa-eye me-1"></i>Kolom',

                        className: 'btn btn-light-primary'

                    },


                    {

                        extend: 'copy',

                        text: '<i class="fas fa-copy me-1"></i>Copy',

                        className: 'btn btn-light-danger'

                    },


                    {

                        extend: 'excel',

                        text: '<i class="fas fa-file-excel me-1"></i>Excel',

                        className: 'btn btn-light-success'

                    }

                ],


                /*
                |--------------------------------------------------------------------------
                | DRAW CALLBACK
                |--------------------------------------------------------------------------
                */

                drawCallback: function () {

                    $('[data-bs-toggle="tooltip"]').tooltip();

                }

            });


            table
                .buttons()
                .container()
                .appendTo('.card-button');

        });


        /*
        |--------------------------------------------------------------------------
        | ESCAPE HTML
        |--------------------------------------------------------------------------
        */

        function escapeHtml(value)
        {

            if (value === null || value === undefined) {

                return '';

            }

            return String(value)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');

        }


        /*
        |--------------------------------------------------------------------------
        | EDIT DATA
        |--------------------------------------------------------------------------
        */

        function editData(
            uuid,
            accountName,
            bankNumber,
            bankName
        ) {

            $("#edit_uuid").val(uuid);

            $("#edit_account_name").val(accountName);

            $("#edit_bank_number").val(bankNumber);

            $("#edit_bank_name").val(bankName);

            $("#editModal").modal("show");

        }


        /*
        |--------------------------------------------------------------------------
        | CREATE
        |--------------------------------------------------------------------------
        */

        $("#formCreate").submit(function (e) {

            e.preventDefault();


            let form = $(this);

            let button = $("#btn-submit-create");


            $.ajax({

                url: "{{ route('dashboard-admin.master.bank.store') }}",

                type: "POST",

                data: form.serialize(),


                beforeSend: function () {

                    button
                        .prop("disabled", true)
                        .html("Menyimpan...");

                },


                success: function (res) {

                    $("#createModal").modal("hide");

                    form[0].reset();


                    Swal.fire({

                        icon: "success",

                        title: "Berhasil",

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

                    let message =
                        xhr.responseJSON?.message ??
                        "Terjadi kesalahan.";


                    /*
                    |--------------------------------------------------------------------------
                    | Laravel Validation Error
                    |--------------------------------------------------------------------------
                    */

                    if (xhr.responseJSON?.errors) {

                        message = Object.values(
                            xhr.responseJSON.errors
                        )[0][0];

                    }


                    Swal.fire({

                        icon: "error",

                        title: "Gagal",

                        text: message

                    });

                },


                complete: function () {

                    button
                        .prop("disabled", false)
                        .html("Simpan");

                }

            });

        });


        /*
        |--------------------------------------------------------------------------
        | EDIT
        |--------------------------------------------------------------------------
        */

        $("#formEdit").submit(function (e) {

            e.preventDefault();


            let uuid = $("#edit_uuid").val();

            let button = $("#btn-submit-edit");


            $.ajax({

                url:
                    "{{ route('dashboard-admin.master.bank.index') }}/"
                    + uuid,

                type: "POST",


                data: {

                    _token: "{{ csrf_token() }}",

                    _method: "PUT",

                    account_name:
                        $("#edit_account_name").val(),

                    bank_number:
                        $("#edit_bank_number").val(),

                    bank_name:
                        $("#edit_bank_name").val()

                },


                beforeSend: function () {

                    button
                        .prop("disabled", true)
                        .html("Memperbarui...");

                },


                success: function (res) {

                    $("#editModal").modal("hide");


                    Swal.fire({

                        icon: "success",

                        title: "Berhasil",

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

                    let message =
                        xhr.responseJSON?.message ??
                        "Terjadi kesalahan.";


                    if (xhr.responseJSON?.errors) {

                        message = Object.values(
                            xhr.responseJSON.errors
                        )[0][0];

                    }


                    Swal.fire({

                        icon: "error",

                        title: "Gagal",

                        text: message

                    });

                },


                complete: function () {

                    button
                        .prop("disabled", false)
                        .html("Update");

                }

            });

        });


        /*
        |--------------------------------------------------------------------------
        | DELETE DATA
        |--------------------------------------------------------------------------
        */

        function deleteData(uuid)
        {

            $("#deleteUuid").val(uuid);

            $("#deleteModal").modal("show");

        }


        /*
        |--------------------------------------------------------------------------
        | DELETE
        |--------------------------------------------------------------------------
        */

        $("#formDelete").submit(function (e) {

            e.preventDefault();


            let uuid = $("#deleteUuid").val();

            let button = $("#btn-submit-delete");


            $.ajax({

                url:
                    "{{ route('dashboard-admin.master.bank.index') }}/"
                    + uuid,

                type: "DELETE",


                data: {

                    _token: "{{ csrf_token() }}"

                },


                beforeSend: function () {

                    button
                        .prop("disabled", true)
                        .html("Menghapus...");

                },


                success: function (res) {

                    $("#deleteModal").modal("hide");


                    Swal.fire({

                        icon: "success",

                        title: "Berhasil",

                        text: res.message,

                        timer: 1800,

                        showConfirmButton: false

                    });


                    $('#datatable')
                        .DataTable()
                        .ajax
                        .reload(null, false);

                },


                error: function (xhr) {

                    Swal.fire({

                        icon: "error",

                        title: "Gagal",

                        text:
                            xhr.responseJSON?.message ??
                            "Terjadi kesalahan."

                    });

                },


                complete: function () {

                    button
                        .prop("disabled", false)
                        .html("Iya, Hapus");

                }

            });

        });

    </script>

@endsection