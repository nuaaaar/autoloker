@extends('layouts.dashboard-admin')

@section('title', 'Admin')

@section('css')
    <style>
        .password-hint{
            background:#1b2440;
            border:1px solid rgba(247,176,3,.25);
            border-left:4px solid #f7b003;
            border-radius:10px;
            padding:12px 15px;
        }

        .password-hint-title{
            color:#f7b003;
            font-size:13px;
            font-weight:600;
            margin-bottom:8px;
            display:flex;
            align-items:center;
        }

        .password-rule-list{
            margin:0;
            padding-left:18px;
        }

        .password-rule-list li{
            color:#bfc9dd;
            font-size:12px;
            line-height:1.8;
        }

        .password-rule-list strong{
            color:#ffffff;
            font-weight:600;
        }

        .input-group .btn{
            border-color:#dbdfe9;
        }

        .input-group .btn:hover{
            background:#f5f8fa;
        }

        .input-group .btn i{
            font-size:16px;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection

@section('breadcrumb')
    <h1
        class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
        Admin</h1>
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
        <li class="breadcrumb-item text-muted">Manajemen user</li>
        <!--begin::Item-->
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-500 w-5px h-2px"></span>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item text-muted">Admin</li>
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
                                <th>Nama</th>
                                <th>Email</th>
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
        <div class="modal-dialog">
            <div class="modal-content">

                <form id="formCreate">

                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">
                            Tambah Admin
                        </h5>

                        <button class="btn-close"
                            data-bs-dismiss="modal"
                            type="button"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label required">
                                Nama
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                name="name"
                                id="create_name"
                                placeholder="Masukkan nama"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label required">
                                Email
                            </label>

                            <input
                                type="email"
                                class="form-control"
                                name="email"
                                id="create_email"
                                placeholder="Masukkan email"
                                required>
                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Password Baru
                            </label>

                            <div class="input-group">

                                <input
                                    type="password"
                                    class="form-control"
                                    id="create_password"
                                    name="password">

                                <button
                                    type="button"
                                    class="btn btn-light btn-toggle-password"
                                    data-target="create_password">

                                    <i class="bi bi-eye"></i>

                                </button>

                            </div>

                            <div class="password-hint mt-3">

                                <div class="password-hint-title">

                                    <i class="ki-duotone ki-information-2 text-warning me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>

                                    Password harus memenuhi syarat berikut:

                                </div>

                                <ul class="password-rule-list">

                                    <li>
                                        Minimal <strong>8 karakter</strong>
                                    </li>

                                    <li>
                                        Memiliki minimal <strong>1 huruf besar</strong> (A-Z)
                                    </li>

                                    <li>
                                        Memiliki minimal <strong>1 huruf kecil</strong> (a-z)
                                    </li>

                                    <li>
                                        Memiliki minimal <strong>1 angka</strong> (0-9)
                                    </li>

                                    <li>
                                        Memiliki minimal <strong>1 simbol</strong>
                                        (@, $, !, %, *, #, ?, &)
                                    </li>

                                </ul>

                            </div>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Konfirmasi Password
                            </label>

                            <div class="input-group">

                                <input
                                    type="password"
                                    class="form-control"
                                    id="create_password_confirmation"
                                    name="password_confirmation">

                                <button
                                    type="button"
                                    class="btn btn-light btn-toggle-password"
                                    data-target="create_password_confirmation">

                                    <i class="bi bi-eye"></i>

                                </button>

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
        <div class="modal-dialog">
            <div class="modal-content">

                <form id="formEdit">

                    @csrf

                    <input type="hidden" id="edit_uuid">

                    <div class="modal-header">

                        <h5 class="modal-title">
                            Edit Admin
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
                                Nama
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                name="name"
                                id="edit_name">

                        </div>

                        <div class="mb-3">

                            <label class="form-label required">
                                Email
                            </label>

                            <input
                                type="email"
                                class="form-control"
                                name="email"
                                id="edit_email">

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Password Baru
                            </label>

                            <div class="input-group">

                                <input
                                    type="password"
                                    class="form-control"
                                    id="edit_password"
                                    name="password">

                                <button
                                    type="button"
                                    class="btn btn-light btn-toggle-password"
                                    data-target="edit_password">

                                    <i class="bi bi-eye"></i>

                                </button>

                            </div>

                            <div class="password-hint mt-3">

                                <div class="password-hint-title">

                                    <i class="ki-duotone ki-information-2 text-warning me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>

                                    Password harus memenuhi syarat berikut:

                                </div>

                                <ul class="password-rule-list">

                                    <li>
                                        Minimal <strong>8 karakter</strong>
                                    </li>

                                    <li>
                                        Memiliki minimal <strong>1 huruf besar</strong> (A-Z)
                                    </li>

                                    <li>
                                        Memiliki minimal <strong>1 huruf kecil</strong> (a-z)
                                    </li>

                                    <li>
                                        Memiliki minimal <strong>1 angka</strong> (0-9)
                                    </li>

                                    <li>
                                        Memiliki minimal <strong>1 simbol</strong>
                                        (@, $, !, %, *, #, ?, &)
                                    </li>

                                </ul>

                            </div>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Konfirmasi Password
                            </label>

                            <div class="input-group">

                                <input
                                    type="password"
                                    class="form-control"
                                    id="edit_password_confirmation"
                                    name="password_confirmation">

                                <button
                                    type="button"
                                    class="btn btn-light btn-toggle-password"
                                    data-target="edit_password_confirmation">

                                    <i class="bi bi-eye"></i>

                                </button>

                            </div>

                        </div>

                        <div class="alert alert-warning py-3">

                            <i class="ki-duotone ki-information-2 me-2 text-warning"></i>

                            Kosongkan password apabila tidak ingin mengubah password akun.

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
                            class="btn btn-warning">

                            Simpan Perubahan

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
                    <h5 class="modal-title">Hapus Admin</h5>
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

                    url: '{{ route("dashboard-admin.management-user.admin.index") }}',
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
                        data: "name"
                    },
                    {
                        data: "email"
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
                                onclick="editData('${data.uuid}','${data.name}','${data.email}')">

                                <i class="fas fa-pencil-alt"
                                style="display: contents;"
                                ></i>

                                </button>

                                <button
                                class="btn btn-outline-danger btn-sm" 
                                onclick="deleteData('${data.uuid}')">

                                <i class="fas fa-trash-alt"
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
                drawCallback: function() {
                    // Inisialisasi tooltip setelah DataTables selesai merender data
                    $('[data-bs-toggle="tooltip"]').tooltip();
                }
            });
            table.buttons().container().appendTo('.card-button');
        });

        function editData(uuid,name,email){

            $("#edit_uuid").val(uuid);

            $("#edit_name").val(name);

            $("#edit_email").val(email);

            $("#editModal").modal("show");

        }

        $("#formCreate").submit(function(e){

            e.preventDefault();

            $.ajax({

                url:"{{ route('dashboard-admin.management-user.admin.store') }}",

                type:"POST",

                data:$(this).serialize(),

                success:function(res){

                    $("#createModal").modal("hide");

                    $("#formCreate")[0].reset();

                    Swal.fire({

                        icon:"success",

                        title:"Berhasil",

                        text:res.message,

                        timer:1500,

                        showConfirmButton:false

                    });

                    $('#datatable').DataTable().ajax.reload(null, false);

                },

                error: function(xhr) {

                    console.log(xhr);

                    if (xhr.status == 422) {

                        let html = '';

                        $.each(xhr.responseJSON.errors, function(key, value) {
                            html += '• ' + value[0] + '<br>';
                        });

                        Swal.fire({
                            icon: 'error',
                            title: 'Validasi Gagal',
                            html: html
                        });

                    } else {

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message ?? 'Terjadi kesalahan.'
                        });

                    }

                }

            });

        });

        $("#formEdit").submit(function(e){

            e.preventDefault();

            $.ajax({

                url:"/dashboard-admin/management-user/admin/"+$("#edit_uuid").val(),

                type:"PUT",

                data:$(this).serialize(),

                success:function(res){

                    $("#editModal").modal("hide");

                    Swal.fire({

                        icon:"success",

                        title:"Berhasil",

                        text:res.message,

                        timer:1500,

                        showConfirmButton:false

                    });

                    $('#datatable').DataTable().ajax.reload(null,false);

                },

                error:function(xhr){

                    if(xhr.status==422){

                        let errors=xhr.responseJSON.errors;

                        let text="";

                        $.each(errors,function(key,value){

                            text+=value[0]+"\n";

                        });

                        Swal.fire({

                            icon:"error",

                            title:"Validasi Gagal",

                            text:text

                        });

                    }

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

                url: "{{ route('dashboard-admin.management-user.admin.index') }}/" + uuid,

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

        $(document).on("click", ".btn-toggle-password", function () {

            let input = $("#" + $(this).data("target"));

            let icon = $(this).find("i");

            if (input.attr("type") === "password") {

                input.attr("type", "text");

                icon.removeClass("bi-eye").addClass("bi-eye-slash");

            } else {

                input.attr("type", "password");

                icon.removeClass("bi-eye-slash").addClass("bi-eye");

            }

        });
    </script>
@endsection