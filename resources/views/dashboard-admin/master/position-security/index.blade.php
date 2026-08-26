@extends('layouts.dashboard-admin')

@section('title', 'Jabatan Satpam')

@section('css')

@endsection

@section('breadcrumb')
    <h1
        class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
        Jabatan Satpam</h1>
    <!--end::Title-->
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
        <!--begin::Item-->
        <li class="breadcrumb-item text-muted">
            <a href="javascript:;" class="text-muted text-hover-primary">Beranda</a>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-500 w-5px h-2px"></span>
        </li>
        <!--end::Item-->
        <li class="breadcrumb-item text-muted">Master</li>
        <!--begin::Item-->
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-500 w-5px h-2px"></span>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item text-muted">Jabatan Satpam</li>
        <!--end::Item-->
    </ul>
    <!--end::Breadcrumb-->
@endsection

@section('content')
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

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h5 class="card-title mb-0">List Data</h5>
                        <div class="card-toolbar">
                            <div class="card-button"></div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="datatable"
                        class="table table-bordered dt-responsive nowrap w-100 dataTable no-footer dtr-inline"
                        aria-describedby="datatable_info" style="width: 1090px;">
                        <thead>
                            <tr>
                                <th width="1%">ID</th>
                                <th>Nama Jabatan Satpam</th>
                                <th class="text-end" width="5%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!--end col-->
    </div><!--end row-->

    <div class="modal fade" id="createModal" tabindex="-1">

        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <form id="formCreate">

                    @csrf

                    <div class="modal-header">

                        <h5 class="modal-title">
                            Tambah Jabatan Satpam
                        </h5>

                        <button
                            class="btn-close"
                            data-bs-dismiss="modal"
                            type="button">
                        </button>

                    </div>


                    <div class="modal-body">


                        {{-- =====================================================
                            NAMA JABATAN
                        ====================================================== --}}

                        <div class="mb-5">

                            <label class="form-label required">
                                Nama Jabatan Satpam
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                name="title"
                                id="create_title"
                                placeholder="Masukkan Jabatan Satpam"
                                required>

                        </div>



                        {{-- =====================================================
                            DESKRIPSI
                        ====================================================== --}}

                        <div class="mb-5">

                            <label class="form-label">
                                Deskripsi Jabatan
                            </label>

                            <textarea
                                class="form-control"
                                name="description"
                                id="create_description"
                                rows="4"
                                placeholder="Masukkan deskripsi jabatan"></textarea>

                        </div>



                        {{-- =====================================================
                            RESPONSIBILITY
                        ====================================================== --}}

                        <div class="mb-3">

                            <div class="d-flex justify-content-between align-items-center mb-2">

                                <label class="form-label mb-0">
                                    Responsibility
                                </label>

                                <button
                                    type="button"
                                    class="btn btn-sm btn-light-primary"
                                    id="btn-add-responsibility-create">

                                    <i class="fas fa-plus me-1"></i>

                                    Tambah Responsibility

                                </button>

                            </div>


                            <div id="create-responsibility-container">


                                <div class="input-group mb-2 responsibility-item">

                                    <input
                                        type="text"
                                        name="responsibility[]"
                                        class="form-control"
                                        placeholder="Masukkan tanggung jawab">

                                    <button
                                        type="button"
                                        class="btn btn-light-danger btn-remove-responsibility">

                                        <i class="fas fa-trash"></i>

                                    </button>

                                </div>


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

    <div class="modal fade" id="editModal" tabindex="-1">

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
                            Edit Jabatan Satpam
                        </h5>

                        <button
                            class="btn-close"
                            data-bs-dismiss="modal"
                            type="button">
                        </button>

                    </div>


                    <div class="modal-body">


                        {{-- =====================================================
                            NAMA JABATAN
                        ====================================================== --}}

                        <div class="mb-5">

                            <label class="form-label required">
                                Nama Jabatan Satpam
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="edit_title"
                                name="title"
                                required>

                        </div>



                        {{-- =====================================================
                            DESKRIPSI
                        ====================================================== --}}

                        <div class="mb-5">

                            <label class="form-label">
                                Deskripsi Jabatan
                            </label>

                            <textarea
                                class="form-control"
                                name="description"
                                id="edit_description"
                                rows="4"
                                placeholder="Masukkan deskripsi jabatan"></textarea>

                        </div>



                        {{-- =====================================================
                            RESPONSIBILITY
                        ====================================================== --}}

                        <div class="mb-3">

                            <div class="d-flex justify-content-between align-items-center mb-2">

                                <label class="form-label mb-0">
                                    Responsibility
                                </label>

                                <button
                                    type="button"
                                    class="btn btn-sm btn-light-primary"
                                    id="btn-add-responsibility-edit">

                                    <i class="fas fa-plus me-1"></i>

                                    Tambah Responsibility

                                </button>

                            </div>


                            <div id="edit-responsibility-container"></div>

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

    <div class="modal fade" tabindex="-1" role="dialog" id="deleteModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Jabatan Satpam</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" data-bs-original-title="" title=""></button>
                </div>
                <div class="modal-body">
                    <p>Tindakan ini akan menghapus data dan data yang dihapus tidak dapat dipulihkan, yakin ingin melanjutkan?</p>
                </div>
                <div class="modal-footer">
                    <form action="" method="post" id="formDelete">
                        @csrf
                        @method("DELETE")
                        <input type="hidden" id="deleteUuid">
                        <button type="button" class="btn btn-light font-weight-bolder" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-danger font-weight-bolder" id="btn-submit-delete">Iya, Hapus</button>
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

             if ($.fn.DataTable.isDataTable('#datatable')) {
                $('#datatable').DataTable().destroy();
            }

            let table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                "aLengthMenu": [[10, 25, 50, 75, 999999], [10, 25, 50, 75, "All"]],
                ajax: {

                    url: '{{ route("dashboard-admin.master.position-security.index") }}',
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
                        render: function(data){
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

                        render:function(data){

                            return `
                                <button
                                    class="btn btn-outline-primary btn-sm me-1"
                                    onclick="editData('${data.uuid}')">

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
                drawCallback: function() {
                    // Inisialisasi tooltip setelah DataTables selesai merender data
                    $('[data-bs-toggle="tooltip"]').tooltip();
                }
            });
            table.buttons().container().appendTo('.card-button');
        });

        function editData(uuid)
        {
            $.ajax({

                url:
                    "{{ route('dashboard-admin.master.position-security.index') }}/"
                    + uuid,

                type: "GET",


                beforeSend: function(){

                    Swal.fire({

                        title: "Memuat data...",

                        allowOutsideClick: false,

                        didOpen: () => {

                            Swal.showLoading();

                        }

                    });

                },


                success: function(res){

                    Swal.close();


                    /*
                    |--------------------------------------------------------------------------
                    | DATA
                    |--------------------------------------------------------------------------
                    */

                    let data = res.data;


                    $("#edit_uuid")
                        .val(data.uuid);


                    $("#edit_title")
                        .val(data.title);


                    $("#edit_description")
                        .val(data.description ?? "");


                    /*
                    |--------------------------------------------------------------------------
                    | RESPONSIBILITY
                    |--------------------------------------------------------------------------
                    */

                    let container =
                        $("#edit-responsibility-container");


                    container.empty();


                    let responsibilities =
                        data.responsibility ?? [];


                    if (
                        !Array.isArray(responsibilities)
                        ||
                        responsibilities.length === 0
                    ) {

                        container.append(
                            responsibilityInput()
                        );

                    } else {

                        responsibilities.forEach(function(item){

                            container.append(
                                responsibilityInput(item)
                            );

                        });

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | SHOW MODAL
                    |--------------------------------------------------------------------------
                    */

                    $("#editModal").modal("show");

                },


                error: function(xhr){

                    Swal.close();


                    Swal.fire({

                        icon: "error",

                        title: "Gagal",

                        text:
                            xhr.responseJSON?.message ??
                            "Data tidak ditemukan."

                    });

                }

            });
        }

        $("#formCreate").submit(function(e){

            e.preventDefault();


            $.ajax({

                url: "{{ route('dashboard-admin.master.position-security.store') }}",

                type: "POST",

                data: $(this).serialize(),


                beforeSend: function(){

                    $("#formCreate button[type='submit']")
                        .prop("disabled", true)
                        .html("Menyimpan...");

                },


                success: function(res){

                    $("#createModal").modal("hide");

                    $("#formCreate")[0].reset();


                    /*
                    |--------------------------------------------------------------------------
                    | RESET RESPONSIBILITY
                    |--------------------------------------------------------------------------
                    */

                    $("#create-responsibility-container").html(`

                        <div class="input-group mb-2 responsibility-item">

                            <input
                                type="text"
                                name="responsibility[]"
                                class="form-control"
                                placeholder="Masukkan tanggung jawab">

                            <button
                                type="button"
                                class="btn btn-light-danger btn-remove-responsibility">

                                <i class="fas fa-trash"></i>

                            </button>

                        </div>

                    `);


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


                error: function(xhr){

                    let message =
                        xhr.responseJSON?.message ??
                        "Terjadi kesalahan.";


                    if (xhr.responseJSON?.errors) {

                        message = Object
                            .values(xhr.responseJSON.errors)
                            .flat()
                            .join("<br>");

                    }


                    Swal.fire({

                        icon: "error",

                        title: "Gagal",

                        html: message

                    });

                },


                complete: function(){

                    $("#formCreate button[type='submit']")
                        .prop("disabled", false)
                        .html("Simpan");

                }

            });

        });

        $("#formEdit").submit(function(e){

            e.preventDefault();


            let uuid = $("#edit_uuid").val();


            $.ajax({

                url:
                    "{{ route('dashboard-admin.master.position-security.index') }}/"
                    + uuid,

                type: "POST",


                data: {

                    _token: "{{ csrf_token() }}",

                    _method: "PUT",

                    title:
                        $("#edit_title").val(),

                    description:
                        $("#edit_description").val(),

                    responsibility:
                        $("#edit-responsibility-container input[name='responsibility[]']")
                            .map(function(){

                                return $(this).val();

                            })
                            .get()

                },


                beforeSend: function(){

                    $("#formEdit button[type='submit']")
                        .prop("disabled", true)
                        .html("Mengupdate...");

                },


                success: function(res){

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


                error: function(xhr){

                    let message =
                        xhr.responseJSON?.message ??
                        "Terjadi kesalahan.";


                    if (xhr.responseJSON?.errors) {

                        message = Object
                            .values(xhr.responseJSON.errors)
                            .flat()
                            .join("<br>");

                    }


                    Swal.fire({

                        icon: "error",

                        title: "Gagal",

                        html: message

                    });

                },


                complete: function(){

                    $("#formEdit button[type='submit']")
                        .prop("disabled", false)
                        .html("Update");

                }

            });

        });

        function deleteData(uuid)
        {
            $("#deleteUuid").val(uuid);

            $("#deleteModal").modal("show");
        }

        $("#formDelete").submit(function(e){

            e.preventDefault();

            let uuid = $("#deleteUuid").val();

            $.ajax({

                url: "{{ route('dashboard-admin.master.position-security.index') }}/" + uuid,

                type: "DELETE",

                data: {
                    _token: "{{ csrf_token() }}"
                },

                beforeSend:function(){

                    $("#btn-submit-delete")
                        .prop("disabled",true)
                        .html("Menghapus...");

                },

                success:function(res){

                    $("#deleteModal").modal("hide");

                    Swal.fire({

                        icon:"success",

                        title:"Berhasil",

                        text:res.message,

                        timer:1800,

                        showConfirmButton:false

                    });

                    $('#datatable').DataTable().ajax.reload(null, false);

                },

                error:function(xhr){

                    Swal.fire({

                        icon:"error",

                        title:"Gagal",

                        text:xhr.responseJSON?.message ?? "Terjadi kesalahan."

                    });

                },

                complete:function(){

                    $("#btn-submit-delete")
                        .prop("disabled",false)
                        .html("Iya, Hapus");

                }

            });

        });

        /*
        |--------------------------------------------------------------------------
        | RESPONSIBILITY TEMPLATE
        |--------------------------------------------------------------------------
        */

        function responsibilityInput(value = '')
        {
            return `

                <div class="input-group mb-2 responsibility-item">

                    <input
                        type="text"
                        name="responsibility[]"
                        class="form-control"
                        placeholder="Masukkan tanggung jawab"
                        value="${escapeHtml(value)}">

                    <button
                        type="button"
                        class="btn btn-light-danger btn-remove-responsibility">

                        <i class="fas fa-trash"></i>

                    </button>

                </div>

            `;
        }


        /*
        |--------------------------------------------------------------------------
        | ESCAPE HTML
        |--------------------------------------------------------------------------
        */

        function escapeHtml(text)
        {
            if (!text) {
                return '';
            }

            return $('<div>')
                .text(text)
                .html();
        }

        $("#btn-add-responsibility-create").on(
            "click",
            function () {

                $("#create-responsibility-container")
                    .append(
                        responsibilityInput()
                    );

            }
        );

        $(document).on(
            "click",
            ".btn-remove-responsibility",
            function () {

                $(this)
                    .closest(".responsibility-item")
                    .remove();

            }
        );

        $("#btn-add-responsibility-edit").on(
            "click",
            function () {

                $("#edit-responsibility-container")
                    .append(
                        responsibilityInput()
                    );

            }
        );
    </script>
@endsection