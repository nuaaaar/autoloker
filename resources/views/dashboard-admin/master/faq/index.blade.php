@extends('layouts.dashboard-admin')

@section('title', 'FAQ')

@section('css')

@endsection

@section('breadcrumb')

    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
        FAQ
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
            FAQ
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
                            List FAQ
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

                                <th width="5%">
                                    Urutan
                                </th>

                                <th>
                                    Pertanyaan
                                </th>

                                {{-- <th>
                                    Jawaban
                                </th> --}}

                                <th
                                    class="text-end"
                                    width="8%">

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
    {{-- CREATE MODAL --}}
    {{-- ========================================================= --}}

    <div
        class="modal fade"
        id="createModal"
        tabindex="-1">

        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <form id="formCreate">

                    @csrf

                    <div class="modal-header">

                        <h5 class="modal-title">
                            Tambah FAQ
                        </h5>

                        <button
                            class="btn-close"
                            data-bs-dismiss="modal"
                            type="button">
                        </button>

                    </div>


                    <div class="modal-body">

                        {{-- PERTANYAAN --}}

                        <div class="mb-5">

                            <label class="form-label required">
                                Pertanyaan
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                name="title"
                                id="create_title"
                                placeholder="Masukkan pertanyaan FAQ"
                                required>

                        </div>


                        {{-- JAWABAN --}}

                        <div class="mb-5">

                            <label class="form-label required">
                                Jawaban
                            </label>

                            <textarea
                                class="form-control"
                                name="description"
                                id="create_description"
                                rows="6"
                                placeholder="Masukkan jawaban FAQ"
                                required></textarea>

                        </div>


                        {{-- ORDER --}}

                        <div class="mb-3">

                            <label class="form-label">
                                Urutan
                            </label>

                            <input
                                type="number"
                                class="form-control"
                                name="order"
                                id="create_order"
                                min="1"
                                placeholder="Kosongkan untuk otomatis">

                            <div class="form-text">
                                Jika dikosongkan, urutan akan dibuat otomatis.
                            </div>

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
                            class="btn btn-primary">

                            Simpan

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- EDIT MODAL --}}
    {{-- ========================================================= --}}

    <div
        class="modal fade"
        id="editModal"
        tabindex="-1">

        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <form id="formEdit">

                    @csrf

                    @method('PUT')

                    <input
                        type="hidden"
                        id="edit_uuid">


                    <div class="modal-header">

                        <h5 class="modal-title">
                            Edit FAQ
                        </h5>

                        <button
                            class="btn-close"
                            data-bs-dismiss="modal"
                            type="button">
                        </button>

                    </div>


                    <div class="modal-body">

                        {{-- PERTANYAAN --}}

                        <div class="mb-5">

                            <label class="form-label required">
                                Pertanyaan
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="edit_title"
                                name="title"
                                placeholder="Masukkan pertanyaan FAQ"
                                required>

                        </div>


                        {{-- JAWABAN --}}

                        <div class="mb-5">

                            <label class="form-label required">
                                Jawaban
                            </label>

                            <textarea
                                class="form-control"
                                id="edit_description"
                                name="description"
                                rows="6"
                                placeholder="Masukkan jawaban FAQ"
                                required></textarea>

                        </div>


                        {{-- ORDER --}}

                        <div class="mb-3">

                            <label class="form-label">
                                Urutan
                            </label>

                            <input
                                type="number"
                                class="form-control"
                                id="edit_order"
                                name="order"
                                min="1"
                                placeholder="Masukkan urutan">

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
                            type="submit">

                            Update

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- DELETE MODAL --}}
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
                        Hapus FAQ
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
                        Tindakan ini akan menghapus data dan data yang
                        dihapus tidak dapat dipulihkan, yakin ingin
                        melanjutkan?
                    </p>

                </div>


                <div class="modal-footer">

                    <form
                        action=""
                        method="post"
                        id="formDelete">

                        @csrf

                        @method("DELETE")

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
    | DESTROY EXISTING DATATABLE
    |--------------------------------------------------------------------------
    */

    if ($.fn.DataTable.isDataTable('#datatable')) {

        $('#datatable')
            .DataTable()
            .destroy();

    }


    /*
    |--------------------------------------------------------------------------
    | DATATABLE
    |--------------------------------------------------------------------------
    */

    let table = $('#datatable').DataTable({

        processing: true,

        serverSide: true,

        scrollX: true,

        aLengthMenu: [
            [10, 25, 50, 75, 999999],
            [10, 25, 50, 75, "All"]
        ],


        ajax: {

            url: '{{ route("dashboard-admin.master.faq.index") }}',

            type: 'GET',


            data: function (d) {

                currentDraw = d.draw;

                d.page =
                    (d.start / d.length) + 1;

                d.length = d.length;

            },


            dataFilter: function (response) {

                let json = JSON.parse(response);


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


        /*
        |--------------------------------------------------------------------------
        | COLUMNS
        |--------------------------------------------------------------------------
        */

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
                data: "order",

                className: "text-center",

                render: function (data) {

                    return data ?? '-';

                }

            },


            {
                data: "title",

                render: function (data) {

                    return data ?? '-';

                }

            },


            // {
            //     data: "description",

            //     render: function (data) {

            //         if (!data) {
            //             return '-';
            //         }

            //         /*
            //         | Batasi tampilan jawaban
            //         */

            //         if (data.length > 150) {

            //             return data.substring(0, 150) + '...';

            //         }

            //         return data;

            //     }

            // },


            {
                data: null,

                orderable: false,

                searchable: false,

                className: "text-end",


                render: function (data) {

                    /*
                    | Escape sederhana untuk mencegah
                    | masalah quote pada onclick.
                    */

                    let title =
                        $('<div>')
                            .text(data.title ?? '')
                            .html();

                    let description =
                        $('<div>')
                            .text(data.description ?? '')
                            .html();


                    return `

                        <button
                            class="btn btn-outline-primary btn-sm me-1"
                            onclick="editData(
                                '${data.uuid}',
                                '${title.replace(/'/g, "\\'")}',
                                '${description.replace(/'/g, "\\'")}',
                                '${data.order ?? ''}'
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
        | BUTTON
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | DRAW CALLBACK
        |--------------------------------------------------------------------------
        */

        drawCallback: function () {

            $('[data-bs-toggle="tooltip"]').tooltip();

        }

    });


    /*
    |--------------------------------------------------------------------------
    | BUTTON CONTAINER
    |--------------------------------------------------------------------------
    */

    table
        .buttons()
        .container()
        .appendTo('.card-button');

});


/*
|--------------------------------------------------------------------------
| EDIT DATA
|--------------------------------------------------------------------------
*/

function editData(
    uuid,
    title,
    description,
    order
) {

    $("#edit_uuid")
        .val(uuid);


    $("#edit_title")
        .val(title);


    $("#edit_description")
        .val(description);


    $("#edit_order")
        .val(order);


    $("#editModal")
        .modal("show");

}


/*
|--------------------------------------------------------------------------
| CREATE
|--------------------------------------------------------------------------
*/

$("#formCreate").submit(function (e) {

    e.preventDefault();


    $.ajax({

        url:
            "{{ route('dashboard-admin.master.faq.store') }}",

        type: "POST",

        data:
            $(this).serialize(),


        success: function (res) {

            $("#createModal")
                .modal("hide");


            $("#formCreate")[0]
                .reset();


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
                xhr.responseJSON?.message
                ?? "Terjadi kesalahan.";


            if (
                xhr.responseJSON?.errors
            ) {

                message =
                    Object.values(
                        xhr.responseJSON.errors
                    )
                    .flat()
                    .join("<br>");

            }


            Swal.fire({

                icon: "error",

                title: "Gagal",

                html: message

            });

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


    let uuid =
        $("#edit_uuid").val();


    $.ajax({

        url:
            "{{ route('dashboard-admin.master.faq.index') }}/"
            + uuid,

        type: "POST",


        data: {

            _token:
                "{{ csrf_token() }}",

            _method:
                "PUT",

            title:
                $("#edit_title").val(),

            description:
                $("#edit_description").val(),

            order:
                $("#edit_order").val()

        },


        success: function (res) {

            $("#editModal")
                .modal("hide");


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
                xhr.responseJSON?.message
                ?? "Terjadi kesalahan.";


            if (
                xhr.responseJSON?.errors
            ) {

                message =
                    Object.values(
                        xhr.responseJSON.errors
                    )
                    .flat()
                    .join("<br>");

            }


            Swal.fire({

                icon: "error",

                title: "Gagal",

                html: message

            });

        }

    });

});


/*
|--------------------------------------------------------------------------
| DELETE MODAL
|--------------------------------------------------------------------------
*/

function deleteData(uuid)
{

    $("#deleteUuid")
        .val(uuid);


    $("#deleteModal")
        .modal("show");

}


/*
|--------------------------------------------------------------------------
| DELETE
|--------------------------------------------------------------------------
*/

$("#formDelete").submit(function (e) {

    e.preventDefault();


    let uuid =
        $("#deleteUuid").val();


    $.ajax({

        url:
            "{{ route('dashboard-admin.master.faq.index') }}/"
            + uuid,

        type: "DELETE",


        data: {

            _token:
                "{{ csrf_token() }}"

        },


        beforeSend: function () {

            $("#btn-submit-delete")
                .prop("disabled", true)
                .html("Menghapus...");

        },


        success: function (res) {

            $("#deleteModal")
                .modal("hide");


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
                    xhr.responseJSON?.message
                    ??
                    "Terjadi kesalahan."

            });

        },


        complete: function () {

            $("#btn-submit-delete")
                .prop("disabled", false)
                .html("Iya, Hapus");

        }

    });

});

</script>

@endsection