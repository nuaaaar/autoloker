@extends('layouts.dashboard-admin')

@php
    $categoryLabel = $category === 'security'
        ? 'Security'
        : 'Cleaning Service';

    $categoryShort = $category === 'security'
        ? 'Security'
        : 'CS';

    $indexRoute = route(
        'dashboard-admin.master.competency-scheme.category.index',
        ['category' => $category]
    );

    $storeRoute = route(
        'dashboard-admin.master.competency-scheme.category.store',
        ['category' => $category]
    );
@endphp

@section('title', 'Kompetensi Skema ' . $categoryLabel)

@section('css')

@endsection

@section('breadcrumb')

    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
        Kompetensi Skema {{ $categoryLabel }}
    </h1>

    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">

        <!--begin::Item-->
        <li class="breadcrumb-item text-muted">
            <a href="javascript:;" class="text-muted text-hover-primary">
                Beranda
            </a>
        </li>
        <!--end::Item-->

        <!--begin::Separator-->
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-500 w-5px h-2px"></span>
        </li>
        <!--end::Separator-->

        <!--begin::Item-->
        <li class="breadcrumb-item text-muted">
            Master
        </li>
        <!--end::Item-->

        <!--begin::Separator-->
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-500 w-5px h-2px"></span>
        </li>
        <!--end::Separator-->

        <!--begin::Item-->
        <li class="breadcrumb-item text-muted">
            Kompetensi Skema
        </li>
        <!--end::Item-->

        <!--begin::Separator-->
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-500 w-5px h-2px"></span>
        </li>
        <!--end::Separator-->

        <!--begin::Item-->
        <li class="breadcrumb-item text-muted">
            {{ $categoryLabel }}
        </li>
        <!--end::Item-->

    </ul>
    <!--end::Breadcrumb-->

@endsection

@section('content')

    <!--begin::Add Button-->
    <div class="row">
        <div class="col-lg-12">

            <button
                type="button"
                class="btn btn-primary py-2 mb-3"
                style="float:right"
                data-bs-toggle="modal"
                data-bs-target="#createModal">

                <i class="las la-plus me-1"></i>

                Tambah

            </button>

        </div>
    </div>
    <!--end::Add Button-->


    <!--begin::Table-->
    <div class="row">

        <div class="col-lg-12">

            <div class="card">

                <!--begin::Card Header-->
                <div class="card-header">

                    <div class="d-flex justify-content-between align-items-center w-100">

                        <div>
                            <h5 class="card-title mb-0">
                                List Kompetensi Skema {{ $categoryLabel }}
                            </h5>
                        </div>

                        <div class="card-toolbar">

                            <div class="card-button"></div>

                        </div>

                    </div>

                </div>
                <!--end::Card Header-->


                <!--begin::Card Body-->
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
                                    Nama Kompetensi Skema
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
                <!--end::Card Body-->

            </div>

        </div>

    </div>
    <!--end::Table-->


    <!--begin::Create Modal-->
    <div
        class="modal fade"
        id="createModal"
        tabindex="-1"
        aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <form id="formCreate">

                    @csrf

                    <div class="modal-header">

                        <h5 class="modal-title">
                            Tambah Kompetensi Skema {{ $categoryLabel }}
                        </h5>

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                        </button>

                    </div>


                    <div class="modal-body">

                        <div class="mb-3">

                            <label class="form-label required">
                                Kategori
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                value="{{ $categoryLabel }}"
                                readonly>

                            <input
                                type="hidden"
                                name="category"
                                value="{{ $category }}">

                        </div>


                        <div class="mb-3">

                            <label class="form-label required">
                                Nama Kompetensi Skema
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                name="title"
                                id="create_title"
                                placeholder="Masukkan Kompetensi Skema"
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
                            class="btn btn-primary">

                            Simpan

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
    <!--end::Create Modal-->


    <!--begin::Edit Modal-->
    <div
        class="modal fade"
        id="editModal"
        tabindex="-1"
        aria-hidden="true">

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
                            Edit Kompetensi Skema {{ $categoryLabel }}
                        </h5>

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                        </button>

                    </div>


                    <div class="modal-body">

                        <div class="mb-3">

                            <label class="form-label required">
                                Kategori
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                value="{{ $categoryLabel }}"
                                readonly>

                        </div>


                        <div class="mb-3">

                            <label class="form-label required">
                                Nama Kompetensi Skema
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="edit_title"
                                name="title"
                                placeholder="Masukkan Kompetensi Skema"
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
                            class="btn btn-primary">

                            Update

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
    <!--end::Edit Modal-->


    <!--begin::Delete Modal-->
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
                        Hapus Kompetensi Skema
                    </h5>

                    <button
                        class="btn-close"
                        type="button"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                    </button>

                </div>


                <div class="modal-body">

                    <p class="mb-0">
                        Tindakan ini akan menghapus data dan data
                        yang dihapus tidak dapat dipulihkan,
                        yakin ingin melanjutkan?
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
    <!--end::Delete Modal-->

@endsection


@section('js')

<script>

    $(document).ready(function () {

        let currentDraw = 1;

        /*
        |--------------------------------------------------------------------------
        | Destroy Existing DataTable
        |--------------------------------------------------------------------------
        */

        if ($.fn.DataTable.isDataTable('#datatable')) {

            $('#datatable')
                .DataTable()
                .destroy();

        }


        /*
        |--------------------------------------------------------------------------
        | DataTable
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

                url: @json($indexRoute),

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

                },

                error: function (xhr) {

                    console.error(
                        'DataTable Error:',
                        xhr.responseText
                    );

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

                        return (
                            '000000' + data
                        ).slice(-6);

                    }

                },


                /*
                |--------------------------------------------------------------------------
                | Title
                |--------------------------------------------------------------------------
                */

                {

                    data: "title"

                },


                /*
                |--------------------------------------------------------------------------
                | Action
                |--------------------------------------------------------------------------
                */

                {

                    data: null,

                    orderable: false,

                    searchable: false,

                    className: "text-end",


                    render: function (data) {

                        /*
                        | Escape value untuk menghindari
                        | masalah quote pada title.
                        */

                        let uuid =
                            $('<div>')
                                .text(data.uuid)
                                .html();

                        let title =
                            $('<div>')
                                .text(data.title)
                                .html();


                        return `

                            <button
                                type="button"
                                class="btn btn-outline-primary btn-sm me-1"
                                onclick="editData(
                                    '${uuid}',
                                    '${title}'
                                )">

                                <i
                                    class="fas fa-pencil-alt"
                                    style="display: contents;">
                                </i>

                            </button>


                            <button
                                type="button"
                                class="btn btn-outline-danger btn-sm"
                                onclick="deleteData('${uuid}')">

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
            | Buttons
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
            | Draw Callback
            |--------------------------------------------------------------------------
            */

            drawCallback: function () {

                $('[data-bs-toggle="tooltip"]').tooltip();

            }

        });


        /*
        |--------------------------------------------------------------------------
        | Append DataTable Buttons
        |--------------------------------------------------------------------------
        */

        table
            .buttons()
            .container()
            .appendTo('.card-button');

    });


    /*
    |--------------------------------------------------------------------------
    | Edit Data
    |--------------------------------------------------------------------------
    */

    function editData(uuid, title)
    {

        $("#edit_uuid").val(uuid);

        $("#edit_title").val(title);

        $("#editModal").modal("show");

    }


    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    $("#formCreate").submit(function (e) {

        e.preventDefault();


        let form = $(this);


        $.ajax({

            url: @json($storeRoute),

            type: "POST",

            data: form.serialize(),


            beforeSend: function () {

                form.find('button[type="submit"]')
                    .prop("disabled", true)
                    .html("Menyimpan...");

            },


            success: function (res) {

                $("#createModal").modal("hide");

                $("#formCreate")[0].reset();


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


                /*
                |--------------------------------------------------------------------------
                | Validation Error
                |--------------------------------------------------------------------------
                */

                if (
                    xhr.responseJSON?.errors?.title
                ) {

                    message =
                        xhr.responseJSON
                            .errors
                            .title[0];

                }


                Swal.fire({

                    icon: "error",

                    title: "Gagal",

                    text: message

                });

            },


            complete: function () {

                form.find('button[type="submit"]')
                    .prop("disabled", false)
                    .html("Simpan");

            }

        });

    });


    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    $("#formEdit").submit(function (e) {

        e.preventDefault();


        let uuid =
            $("#edit_uuid").val();


        let title =
            $("#edit_title").val();


        $.ajax({

            url:
                @json($indexRoute)
                + "/" + uuid,

            type: "POST",


            data: {

                _token:
                    "{{ csrf_token() }}",

                _method:
                    "PUT",

                title:
                    title

            },


            beforeSend: function () {

                $("#formEdit")
                    .find('button[type="submit"]')
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
                    xhr.responseJSON?.message
                    ?? "Terjadi kesalahan.";


                if (
                    xhr.responseJSON?.errors?.title
                ) {

                    message =
                        xhr.responseJSON
                            .errors
                            .title[0];

                }


                Swal.fire({

                    icon: "error",

                    title: "Gagal",

                    text: message

                });

            },


            complete: function () {

                $("#formEdit")
                    .find('button[type="submit"]')
                    .prop("disabled", false)
                    .html("Update");

            }

        });

    });


    /*
    |--------------------------------------------------------------------------
    | Delete Modal
    |--------------------------------------------------------------------------
    */

    function deleteData(uuid)
    {

        $("#deleteUuid").val(uuid);

        $("#deleteModal").modal("show");

    }


    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */

    $("#formDelete").submit(function (e) {

        e.preventDefault();


        let uuid =
            $("#deleteUuid").val();


        $.ajax({

            url:
                @json($indexRoute)
                + "/" + uuid,

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
                        xhr.responseJSON?.message
                        ?? "Terjadi kesalahan."

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