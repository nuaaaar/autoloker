@extends('layouts.dashboard-admin')

@section('title', 'Mitra')

@section('css')

@endsection

@section('breadcrumb')

    <h1
        class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
        Mitra
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
            Management User
        </li>

        <li class="breadcrumb-item">
            <span class="bullet bg-gray-500 w-5px h-2px"></span>
        </li>

        <li class="breadcrumb-item text-muted">
            Mitra
        </li>

    </ul>

@endsection


@section('content')

    {{-- =====================================================
        BUTTON TAMBAH
    ====================================================== --}}

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


    {{-- =====================================================
        TABLE
    ====================================================== --}}

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

                                <th width="8%">
                                    Logo
                                </th>

                                <th>
                                    Nama Mitra
                                </th>

                                <th>
                                    Alamat
                                </th>

                                <th>
                                    Telepon
                                </th>

                                <th width="8%">
                                    Status
                                </th>

                                <th class="text-end" width="8%">
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


    {{-- =====================================================
        MODAL CREATE
    ====================================================== --}}

    <div class="modal fade"
         id="createModal"
         tabindex="-1">

        <div class="modal-dialog">

            <div class="modal-content">

                <form id="formCreate"
                      enctype="multipart/form-data">

                    @csrf

                    <div class="modal-header">

                        <h5 class="modal-title">
                            Tambah Mitra
                        </h5>

                        <button
                            class="btn-close"
                            data-bs-dismiss="modal"
                            type="button">
                        </button>

                    </div>


                    <div class="modal-body">

                        {{-- NAMA --}}

                        <div class="mb-4">

                            <label class="form-label required">
                                Nama Mitra
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                name="name"
                                id="create_name"
                                placeholder="Masukkan nama mitra"
                                required>

                        </div>


                        {{-- LOGO --}}

                        <div class="mb-4">

                            <label class="form-label">
                                Logo
                            </label>

                            <input
                                type="file"
                                class="form-control"
                                name="logo"
                                id="create_logo"
                                accept=".jpg,.jpeg,.png,.webp">

                            <small class="text-muted">
                                Format JPG, JPEG, PNG atau WEBP. Maksimal 2 MB.
                            </small>

                            <div class="mt-2">

                                <img
                                    id="create_logo_preview"
                                    src=""
                                    style="
                                        display:none;
                                        max-width:100px;
                                        max-height:80px;
                                        object-fit:contain;
                                    ">

                            </div>

                        </div>


                        {{-- ALAMAT --}}

                        <div class="mb-4">

                            <label class="form-label">
                                Alamat
                            </label>

                            <textarea
                                class="form-control"
                                name="address"
                                id="create_address"
                                rows="3"
                                placeholder="Masukkan alamat mitra"></textarea>

                        </div>


                        {{-- DESKRIPSI --}}

                        <div class="mb-4">

                            <label class="form-label">
                                Deskripsi
                            </label>

                            <textarea
                                class="form-control"
                                name="description"
                                id="create_description"
                                rows="3"
                                placeholder="Masukkan deskripsi mitra"></textarea>

                        </div>


                        <div class="row">

                            {{-- WEBSITE --}}

                            <div class="col-md-6 mb-4">

                                <label class="form-label">
                                    Website
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    name="website"
                                    id="create_website"
                                    placeholder="https://example.com">

                            </div>


                            {{-- TELEPON --}}

                            <div class="col-md-6 mb-4">

                                <label class="form-label">
                                    Telepon
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    name="phone"
                                    id="create_phone"
                                    placeholder="08xxxxxxxxxx">

                            </div>

                        </div>


                        <div class="row">

                            {{-- STATUS --}}

                            <div class="col-md-12 mb-2">

                                <label class="form-label">
                                    Status
                                </label>

                                <select
                                    class="form-select"
                                    name="is_active"
                                    id="create_is_active">

                                    <option value="1">
                                        Aktif
                                    </option>

                                    <option value="0">
                                        Tidak Aktif
                                    </option>

                                </select>

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


    {{-- =====================================================
        MODAL EDIT
    ====================================================== --}}

    <div class="modal fade"
         id="editModal"
         tabindex="-1">

        <div class="modal-dialog">

            <div class="modal-content">

                <form id="formEdit"
                      enctype="multipart/form-data">

                    @csrf

                    @method('PUT')

                    <input
                        type="hidden"
                        id="edit_uuid">


                    <div class="modal-header">

                        <h5 class="modal-title">
                            Edit Mitra
                        </h5>

                        <button
                            class="btn-close"
                            data-bs-dismiss="modal"
                            type="button">
                        </button>

                    </div>


                    <div class="modal-body">

                        {{-- NAMA --}}

                        <div class="mb-4">

                            <label class="form-label required">
                                Nama Mitra
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                name="name"
                                id="edit_name"
                                required>

                        </div>


                        {{-- LOGO --}}

                        <div class="mb-4">

                            <label class="form-label">
                                Logo
                            </label>


                            <div id="edit_current_logo"
                                 class="mb-2">
                            </div>


                            <input
                                type="file"
                                class="form-control"
                                name="logo"
                                id="edit_logo"
                                accept=".jpg,.jpeg,.png,.webp">


                            <small class="text-muted">
                                Kosongkan jika tidak ingin mengganti logo.
                            </small>


                            <div class="mt-2">

                                <img
                                    id="edit_logo_preview"
                                    src=""
                                    style="
                                        display:none;
                                        max-width:100px;
                                        max-height:80px;
                                        object-fit:contain;
                                    ">

                            </div>

                        </div>


                        {{-- ALAMAT --}}

                        <div class="mb-4">

                            <label class="form-label">
                                Alamat
                            </label>

                            <textarea
                                class="form-control"
                                name="address"
                                id="edit_address"
                                rows="3"></textarea>

                        </div>


                        {{-- DESKRIPSI --}}

                        <div class="mb-4">

                            <label class="form-label">
                                Deskripsi
                            </label>

                            <textarea
                                class="form-control"
                                name="description"
                                id="edit_description"
                                rows="3"></textarea>

                        </div>


                        <div class="row">

                            {{-- WEBSITE --}}

                            <div class="col-md-6 mb-4">

                                <label class="form-label">
                                    Website
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    name="website"
                                    id="edit_website">

                            </div>


                            {{-- TELEPON --}}

                            <div class="col-md-6 mb-4">

                                <label class="form-label">
                                    Telepon
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    name="phone"
                                    id="edit_phone">

                            </div>

                        </div>


                        <div class="row">

                            {{-- STATUS --}}

                            <div class="col-md-12 mb-2">

                                <label class="form-label">
                                    Status
                                </label>

                                <select
                                    class="form-select"
                                    name="is_active"
                                    id="edit_is_active">

                                    <option value="1">
                                        Aktif
                                    </option>

                                    <option value="0">
                                        Tidak Aktif
                                    </option>

                                </select>

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
                            class="btn btn-primary"
                            type="submit">

                            Update

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    {{-- =====================================================
        MODAL DELETE
    ====================================================== --}}

    <div class="modal fade"
         tabindex="-1"
         role="dialog"
         id="deleteModal">

        <div class="modal-dialog"
             role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Hapus Mitra
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

$(document).ready(function() {

    let currentDraw = 1;


    /* =========================================================
       DATATABLE
    ========================================================= */

    if ($.fn.DataTable.isDataTable('#datatable')) {

        $('#datatable').DataTable().destroy();

    }


    let table = $('#datatable').DataTable({

        processing: true,

        serverSide: true,

        scrollX: true,

        responsive: false,

        "aLengthMenu": [
            [10, 25, 50, 75, 999999],
            [10, 25, 50, 75, "All"]
        ],


        ajax: {

            url: '{{ route("dashboard-admin.management-user.partner.index") }}',

            type: 'GET',


            data: function(d) {

                currentDraw = d.draw;

                d.page = (d.start / d.length) + 1;

                d.length = d.length;

            },


            dataFilter: function(response) {

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

            /* =================================================
               ID
            ================================================= */

            {

                data: "id",

                render: function(data) {

                    return ('000000' + data).slice(-6);

                }

            },


            /* =================================================
               LOGO
            ================================================= */

            {

                data: "logo",

                orderable: false,

                searchable: false,

                className: "text-center",

                render: function(data) {

                    if (data) {

                        return `
                            <img
                                src="{{ asset('storage') }}/${data}"
                                style="
                                    width:50px;
                                    height:50px;
                                    object-fit:contain;
                                    border-radius:8px;
                                ">
                        `;

                    }


                    return `
                        <span class="text-muted">
                            -
                        </span>
                    `;

                }

            },


            /* =================================================
               NAMA
            ================================================= */

            {

                data: "name",

                render: function(data, type, row) {

                    let html = `
                        <strong>
                            ${data ?? '-'}
                        </strong>
                    `;


                    if (row.description) {

                        html += `
                            <br>
                            <small class="text-muted">
                                ${row.description}
                            </small>
                        `;

                    }


                    return html;

                }

            },


            /* =================================================
               ALAMAT
            ================================================= */

            {

                data: "address",

                render: function(data) {

                    if (!data) {

                        return '-';

                    }


                    if (data.length > 80) {

                        return data.substring(0, 80) + '...';

                    }


                    return data;

                }

            },


            /* =================================================
               TELEPON
            ================================================= */

            {

                data: "phone",

                render: function(data) {

                    return data ?? '-';

                }

            },


            /* =================================================
               STATUS
            ================================================= */

            {

                data: "is_active",

                className: "text-center",

                render: function(data) {

                    if (data == 1 || data === true) {

                        return `
                            <span class="badge badge-light-success">
                                Aktif
                            </span>
                        `;

                    }


                    return `
                        <span class="badge badge-light-danger">
                            Tidak Aktif
                        </span>
                    `;

                }

            },

            /* =================================================
            ACTION
            ================================================= */

            {

                data: null,

                orderable: false,

                searchable: false,

                className: "text-end",

                render: function(data) {

                    let showUrl = "{{ route('dashboard-admin.management-user.partner.show', ':uuid') }}"
                        .replace(':uuid', data.uuid);

                    return `

                        {{-- DETAIL --}}

                        <a
                            href="${showUrl}"
                            class="btn btn-outline-info btn-sm me-1"
                            data-bs-toggle="tooltip"
                            title="Detail">

                            <i
                                class="fas fa-eye"
                                style="display: contents;">
                            </i>

                        </a>


                        {{-- EDIT --}}

                        <button
                            class="btn btn-outline-primary btn-sm me-1"
                            onclick="editData(
                                '${data.uuid}'
                            )"
                            data-bs-toggle="tooltip"
                            title="Edit">

                            <i
                                class="fas fa-pencil-alt"
                                style="display: contents;">
                            </i>

                        </button>


                        {{-- DELETE --}}

                        <button
                            class="btn btn-outline-danger btn-sm"
                            onclick="deleteData(
                                '${data.uuid}'
                            )"
                            data-bs-toggle="tooltip"
                            title="Hapus">

                            <i
                                class="fas fa-trash-alt"
                                style="display: contents;">
                            </i>

                        </button>

                    `;

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


        drawCallback: function() {

            $('[data-bs-toggle="tooltip"]').tooltip();

        }

    });


    table.buttons()
        .container()
        .appendTo('.card-button');



    /* =========================================================
       CREATE LOGO PREVIEW
    ========================================================= */

    $("#create_logo").change(function() {

        let file = this.files[0];


        if (!file) {

            $("#create_logo_preview")
                .hide()
                .attr("src", "");

            return;

        }


        let reader = new FileReader();


        reader.onload = function(e) {

            $("#create_logo_preview")
                .attr("src", e.target.result)
                .show();

        };


        reader.readAsDataURL(file);

    });



    /* =========================================================
       EDIT LOGO PREVIEW
    ========================================================= */

    $("#edit_logo").change(function() {

        let file = this.files[0];


        if (!file) {

            $("#edit_logo_preview")
                .hide()
                .attr("src", "");

            return;

        }


        let reader = new FileReader();


        reader.onload = function(e) {

            $("#edit_logo_preview")
                .attr("src", e.target.result)
                .show();

        };


        reader.readAsDataURL(file);

    });

});



/* =============================================================
   EDIT DATA
============================================================= */

function editData(uuid)
{

    $.ajax({

        url:
            "{{ route('dashboard-admin.management-user.partner.index') }}/"
            + uuid
            + "/edit",

        type: "GET",


        success: function(res) {

            let data = res.data;


            $("#edit_uuid")
                .val(data.uuid);


            $("#edit_name")
                .val(data.name);


            $("#edit_address")
                .val(data.address ?? '');


            $("#edit_description")
                .val(data.description ?? '');


            $("#edit_website")
                .val(data.website ?? '');


            $("#edit_phone")
                .val(data.phone ?? '');


            $("#edit_order")
                .val(data.order ?? 0);


            $("#edit_is_active")
                .val(data.is_active ? 1 : 0);


            /* =================================================
               CURRENT LOGO
            ================================================= */

            if (data.logo) {

                $("#edit_current_logo").html(`

                    <img
                        src="{{ asset('storage') }}/${data.logo}"
                        style="
                            width:100px;
                            height:80px;
                            object-fit:contain;
                            border:1px solid #ddd;
                            border-radius:6px;
                            padding:5px;
                        ">

                `);

            } else {

                $("#edit_current_logo").html(`

                    <span class="text-muted">
                        Belum ada logo
                    </span>

                `);

            }


            $("#edit_logo")
                .val('');


            $("#edit_logo_preview")
                .hide()
                .attr("src", "");


            $("#editModal")
                .modal("show");

        },


        error: function(xhr) {

            Swal.fire({

                icon: "error",

                title: "Gagal",

                text:
                    xhr.responseJSON?.message ??
                    "Data mitra tidak ditemukan."

            });

        }

    });

}



/* =============================================================
   CREATE
============================================================= */

$("#formCreate").submit(function(e) {

    e.preventDefault();


    let formData =
        new FormData(this);


    $.ajax({

        url:
            "{{ route('dashboard-admin.management-user.partner.store') }}",

        type: "POST",

        data: formData,

        processData: false,

        contentType: false,


        success: function(res) {

            $("#createModal")
                .modal("hide");


            $("#formCreate")[0]
                .reset();


            $("#create_logo_preview")
                .hide()
                .attr("src", "");


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


        error: function(xhr) {

            let message =
                xhr.responseJSON?.message ??
                "Terjadi kesalahan.";


            if (
                xhr.status === 422 &&
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



/* =============================================================
   UPDATE
============================================================= */

$("#formEdit").submit(function(e) {

    e.preventDefault();


    let uuid =
        $("#edit_uuid").val();


    let formData =
        new FormData(this);


    formData.append(
        "_method",
        "PUT"
    );


    $.ajax({

        url:
            "{{ route('dashboard-admin.management-user.partner.index') }}/"
            + uuid,

        type: "POST",

        data: formData,

        processData: false,

        contentType: false,


        success: function(res) {

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


        error: function(xhr) {

            let message =
                xhr.responseJSON?.message ??
                "Terjadi kesalahan.";


            if (
                xhr.status === 422 &&
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



/* =============================================================
   DELETE DATA
============================================================= */

function deleteData(uuid)
{

    $("#deleteUuid")
        .val(uuid);


    $("#deleteModal")
        .modal("show");

}



/* =============================================================
   DELETE SUBMIT
============================================================= */

$("#formDelete").submit(function(e) {

    e.preventDefault();


    let uuid =
        $("#deleteUuid").val();


    $.ajax({

        url:
            "{{ route('dashboard-admin.management-user.partner.index') }}/"
            + uuid,

        type: "DELETE",

        data: {

            _token:
                "{{ csrf_token() }}"

        },


        beforeSend: function() {

            $("#btn-submit-delete")

                .prop("disabled", true)

                .html("Menghapus...");

        },


        success: function(res) {

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


        error: function(xhr) {

            Swal.fire({

                icon: "error",

                title: "Gagal",

                text:
                    xhr.responseJSON?.message ??
                    "Terjadi kesalahan."

            });

        },


        complete: function() {

            $("#btn-submit-delete")

                .prop("disabled", false)

                .html("Iya, Hapus");

        }

    });

});

</script>

@endsection