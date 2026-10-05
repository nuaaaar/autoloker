@extends('layouts.dashboard-admin')

@php
    $categoryLabel = $category === 'cs'
        ? 'Cleaning Service'
        : 'Satpam';

    $pageTitle = 'Sertifikasi ' . $categoryLabel;
@endphp

@section('title', $pageTitle)

@section('css')
@endsection

@section('breadcrumb')

    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
        {{ $pageTitle }}
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
            {{ $pageTitle }}
        </li>

    </ul>

@endsection

@section('content')

    <div class="row">

        <div class="col-lg-12">

            <button
                class="btn btn-primary py-2 mb-3"
                style="float:right"
                data-bs-toggle="modal"
                data-bs-target="#createModal"
            >
                <i class="las la-plus me-1"></i>
                Tambah
            </button>

        </div>

    </div>

    <div class="row">

        <div class="col-lg-12">

            <div class="card">

                <div class="card-header">

                    <div class="d-flex justify-content-between">

                        <h5 class="card-title mb-0">
                            List Sertifikasi {{ $categoryLabel }}
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
                        style="width: 1090px;"
                    >

                        <thead>

                            <tr>

                                <th width="1%">
                                    ID
                                </th>

                                <th>
                                    Nama Sertifikasi
                                </th>

                                <th
                                    class="text-end"
                                    width="5%"
                                >
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


    {{-- CREATE MODAL --}}
    <div
        class="modal fade"
        id="createModal"
        tabindex="-1"
    >

        <div class="modal-dialog">

            <div class="modal-content">

                <form id="formCreate">

                    @csrf

                    <div class="modal-header">

                        <h5 class="modal-title">
                            Tambah Sertifikasi {{ $categoryLabel }}
                        </h5>

                        <button
                            class="btn-close"
                            data-bs-dismiss="modal"
                            type="button"
                        ></button>

                    </div>

                    <div class="modal-body">

                        <label class="form-label required">
                            Nama Sertifikasi
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            name="title"
                            id="create_title"
                            placeholder="Masukkan Sertifikasi"
                            required
                        >

                    </div>

                    <div class="modal-footer">

                        <button
                            type="button"
                            class="btn btn-light"
                            data-bs-dismiss="modal"
                        >
                            Batal
                        </button>

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            Simpan
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    {{-- EDIT MODAL --}}
    <div
        class="modal fade"
        id="editModal"
        tabindex="-1"
    >

        <div class="modal-dialog">

            <div class="modal-content">

                <form id="formEdit">

                    @csrf
                    @method('PUT')

                    <input
                        type="hidden"
                        id="edit_uuid"
                    >

                    <div class="modal-header">

                        <h5 class="modal-title">
                            Edit Sertifikasi {{ $categoryLabel }}
                        </h5>

                        <button
                            class="btn-close"
                            data-bs-dismiss="modal"
                            type="button"
                        ></button>

                    </div>

                    <div class="modal-body">

                        <label class="form-label required">
                            Nama Sertifikasi
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="edit_title"
                            name="title"
                            required
                        >

                    </div>

                    <div class="modal-footer">

                        <button
                            type="button"
                            class="btn btn-light"
                            data-bs-dismiss="modal"
                        >
                            Batal
                        </button>

                        <button
                            class="btn btn-primary"
                            type="submit"
                        >
                            Update
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    {{-- DELETE MODAL --}}
    <div
        class="modal fade"
        tabindex="-1"
        role="dialog"
        id="deleteModal"
    >

        <div
            class="modal-dialog"
            role="document"
        >

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Hapus Sertifikasi {{ $categoryLabel }}
                    </h5>

                    <button
                        class="btn-close"
                        type="button"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>

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
                        id="formDelete"
                    >

                        @csrf
                        @method("DELETE")

                        <input
                            type="hidden"
                            id="deleteUuid"
                        >

                        <button
                            type="button"
                            class="btn btn-light font-weight-bolder"
                            data-bs-dismiss="modal"
                        >
                            Tutup
                        </button>

                        <button
                            type="submit"
                            class="btn btn-danger font-weight-bolder"
                            id="btn-submit-delete"
                        >
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

        const category = @json($category);

        const indexUrl = @json(
            route(
                'dashboard-admin.master.certificate.category.index',
                ['category' => $category]
            )
        );

        const storeUrl = @json(
            route(
                'dashboard-admin.master.certificate.category.store',
                ['category' => $category]
            )
        );

        const updateUrlTemplate = @json(
            route(
                'dashboard-admin.master.certificate.category.update',
                [
                    'category' => $category,
                    'uuid' => '__UUID__'
                ]
            )
        );

        const deleteUrlTemplate = @json(
            route(
                'dashboard-admin.master.certificate.category.destroy',
                [
                    'category' => $category,
                    'uuid' => '__UUID__'
                ]
            )
        );


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

                url: indexUrl,

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

                {

                    data: "id",

                    render: function (data) {

                        return ('000000' + data).slice(-6);

                    }

                },

                {

                    data: "title"

                },

                {

                    data: null,

                    orderable: false,

                    searchable: false,

                    className: "text-end",

                    render: function (data) {

                        return `

                            <button
                                class="btn btn-outline-primary btn-sm me-1"
                                onclick='editData(
                                    ${JSON.stringify(data.uuid)},
                                    ${JSON.stringify(data.title)}
                                )'
                            >

                                <i
                                    class="fas fa-pencil-alt"
                                    style="display: contents;"
                                ></i>

                            </button>


                            <button
                                class="btn btn-outline-danger btn-sm"
                                onclick='deleteData(
                                    ${JSON.stringify(data.uuid)}
                                )'
                            >

                                <i
                                    class="fas fa-trash-alt"
                                    style="display: contents;"
                                ></i>

                            </button>

                        `;

                    }

                }

            ],

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

            drawCallback: function () {

                $('[data-bs-toggle="tooltip"]').tooltip();

            }

        });


        table
            .buttons()
            .container()
            .appendTo('.card-button');


        // CREATE
        $("#formCreate").submit(function (e) {

            e.preventDefault();

            $.ajax({

                url: storeUrl,

                type: "POST",

                data: $(this).serialize(),

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
                        xhr.responseJSON?.message ??
                        "Terjadi kesalahan.";

                    if (
                        xhr.responseJSON?.errors?.title
                    ) {

                        message =
                            xhr.responseJSON.errors.title[0];

                    }

                    Swal.fire({

                        icon: "error",

                        title: "Gagal",

                        text: message

                    });

                }

            });

        });


        // EDIT
        $("#formEdit").submit(function (e) {

            e.preventDefault();

            let uuid = $("#edit_uuid").val();

            let updateUrl =
                updateUrlTemplate.replace(
                    '__UUID__',
                    uuid
                );

            $.ajax({

                url: updateUrl,

                type: "POST",

                data: {

                    _token: "{{ csrf_token() }}",

                    _method: "PUT",

                    title: $("#edit_title").val()

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

                    if (
                        xhr.responseJSON?.errors?.title
                    ) {

                        message =
                            xhr.responseJSON.errors.title[0];

                    }

                    Swal.fire({

                        icon: "error",

                        title: "Gagal",

                        text: message

                    });

                }

            });

        });


        // DELETE
        $("#formDelete").submit(function (e) {

            e.preventDefault();

            let uuid = $("#deleteUuid").val();

            let deleteUrl =
                deleteUrlTemplate.replace(
                    '__UUID__',
                    uuid
                );

            $.ajax({

                url: deleteUrl,

                type: "DELETE",

                data: {

                    _token: "{{ csrf_token() }}"

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
                            xhr.responseJSON?.message ??
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

    });


    function editData(uuid, title)
    {
        $("#edit_uuid").val(uuid);

        $("#edit_title").val(title);

        $("#editModal").modal("show");
    }


    function deleteData(uuid)
    {
        $("#deleteUuid").val(uuid);

        $("#deleteModal").modal("show");
    }

</script>

@endsection