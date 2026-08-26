@extends('layouts.dashboard-admin')

@section('title', 'Satpam')

@section('css')
    <style>
        
    </style>
@endsection

@section('breadcrumb')
    <h1
        class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
        Satpam</h1>
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
        <li class="breadcrumb-item text-muted">Manajemen User</li>
        <!--begin::Item-->
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-500 w-5px h-2px"></span>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item text-muted">Satpam</li>
        <!--end::Item-->
    </ul>
    <!--end::Breadcrumb-->
@endsection

@section('content')
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
                                <th>Tempat, Tanggal Lahir</th>
                                <th>Jenis Kelamin</th>
                                <th>Domisili</th>
                                <th>Status Akun</th>
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


    <div class="modal fade" id="statusModal" tabindex="-1">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 id="modalTitle" class="modal-title"></h5>

                    <button
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body text-center">

                    <input type="hidden" id="uuid">
                    <input type="hidden" id="status">

                    <div id="modalIcon" class="mb-3"></div>

                    <h5 id="securityName"></h5>

                    <p id="modalText"></p>

                </div>

                <div class="modal-footer">

                    <button
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">

                        Batal

                    </button>

                    <button
                        id="btnSubmitStatus"
                        class="btn">

                    </button>

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
                autoWidth: false,
                responsive: false,
                "aLengthMenu": [[10, 25, 50, 75, 999999], [10, 25, 50, 75, "All"]],
                ajax: {

                    url: '{{ route("dashboard-admin.management-user.security.index") }}',
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
                        data: "name",
                        render: function(data){

                            if(!data){
                                return `
                                    <span class="badge badge-light-warning">
                                        Belum Diisi
                                    </span>
                                `;
                            }

                            return data;
                        }
                    },
                    {
                        data: "email",
                        render: function(data){

                            if(!data){
                                return `
                                    <span class="badge badge-light-warning">
                                        Belum Diisi
                                    </span>
                                `;
                            }

                            return data;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row){

                            let date = '-';

                            if(row.birth_date){
                                let d = new Date(row.birth_date);

                                let day = String(d.getDate()).padStart(2,'0');
                                let month = String(d.getMonth()+1).padStart(2,'0');
                                let year = d.getFullYear();

                                date = day + '-' + month + '-' + year;
                            }

                            return (row.birth_place ?? '-') + ', ' + date;
                        }
                    },
                    {
                        data: "gender",
                        render: function(data){

                            if(!data){
                                return `
                                    <span class="badge badge-light-warning">
                                        Belum Diisi
                                    </span>
                                `;
                            }

                            return data;
                        }
                    },
                    {
                        data: "province",
                        render: function(data){

                            if(!data){
                                return `
                                    <span class="badge badge-light-warning">
                                        Belum Diisi
                                    </span>
                                `;
                            }

                            return data;
                        }
                    },
                    {
                        data: "user_security.user.status",
                        render: function(data){

                            if(data == 'active'){

                                return `
                                    <span class="badge badge-light-success">
                                        Aktif
                                    </span>
                                `;

                            }

                            return `
                                <span class="badge badge-light-danger">
                                    Nonaktif
                                </span>
                            `;

                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        className: "text-end",
                        render:function(data){

                        let statusButton = '';

                        if(data.user_security.user.status == 'active'){

                            statusButton = `
                                <button
                                    class="btn btn-outline-danger btn-sm btnStatus"
                                    data-uuid="${data.uuid}"
                                    data-status="non-active"
                                    data-name="${data.name}"
                                    title="Nonaktifkan Akun">

                                    <i class="fas fa-user-slash"></i>

                                </button>
                            `;

                        }else{

                            statusButton = `
                                <button
                                    class="btn btn-outline-success btn-sm btnStatus"
                                    data-uuid="${data.uuid}"
                                    data-status="active"
                                    data-name="${data.name}"
                                    title="Aktifkan Akun">

                                    <i class="fas fa-user-check"></i>

                                </button>
                            `;

                        }

                        return `

                            <a href="/dashboard-admin/management-user/security/${data.uuid}"
                                class="btn btn-outline-info btn-sm me-1">

                                <i class="fas fa-eye"></i>

                            </a>

                            ${statusButton}

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

        $(document).on('click','.btnStatus',function(){

            let uuid=$(this).data('uuid');
            let status=$(this).data('status');
            let name=$(this).data('name');

            $('#uuid').val(uuid);
            $('#status').val(status);

            $('#securityName').text(name);

            if(status=='active'){

                $('#modalTitle').text('Aktifkan Akun');

                $('#modalText').text(
                    'Apakah Anda yakin ingin mengaktifkan akun satpam ini?'
                );

                $('#modalIcon').html(
                    '<i class="fas fa-user-check fa-4x text-success"></i>'
                );

                $('#btnSubmitStatus')
                    .removeClass('btn-danger')
                    .addClass('btn-success')
                    .html('<i class="fas fa-check me-1"></i> Aktifkan');

            }else{

                $('#modalTitle').text('Nonaktifkan Akun');

                $('#modalText').text(
                    'Apakah Anda yakin ingin menonaktifkan akun satpam ini?'
                );

                $('#modalIcon').html(
                    '<i class="fas fa-user-slash fa-4x text-danger"></i>'
                );

                $('#btnSubmitStatus')
                    .removeClass('btn-success')
                    .addClass('btn-danger')
                    .html('<i class="fas fa-ban me-1"></i> Nonaktifkan');

            }

            new bootstrap.Modal(
                document.getElementById('statusModal')
            ).show();

        });

        $('#btnSubmitStatus').click(function(){

            $.ajax({

                url:'/dashboard-admin/management-user/security/'+$('#uuid').val()+'/status',

                type:'POST',

                data:{

                    _token:$('meta[name="csrf-token"]').attr('content'),

                    status:$('#status').val()

                },

                success:function(res){

                    bootstrap.Modal.getInstance(
                        document.getElementById('statusModal')
                    ).hide();

                    Swal.fire({

                        icon:'success',

                        title:'Berhasil',

                        text:res.message

                    });

                    $('#datatable').DataTable().ajax.reload(null, false);

                },

                error:function(){

                    Swal.fire({

                        icon:'error',

                        title:'Gagal',

                        text:'Terjadi kesalahan.'

                    });

                }

            });

        });
    </script>
@endsection