@extends('layouts.dashboard-admin')

@section('title', 'BUJP')

@section('css')
    <style>

    </style>
@endsection

@section('breadcrumb')
    <h1
        class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
        BUJP</h1>
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
        <li class="breadcrumb-item text-muted">BUJP</li>
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
                                <th>Nama BUJP</th>
                                <th>Email</th>
                                <th>NIB</th>
                                <th>NPWP</th>
                                <th>SIO</th>
                                <th>Status Verifikasi</th>
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

    <div class="modal fade" id="verifyModal" tabindex="-1">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        Verifikasi Perusahaan
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <input type="hidden" id="verify_uuid">

                    <div class="text-center">

                        <div class="mb-3">

                            <i class="fas fa-building fa-4x text-success"></i>

                        </div>

                        <h5 id="verify_company"></h5>

                        <p class="text-muted mb-0">

                            Apakah Anda yakin ingin memverifikasi perusahaan ini?

                        </p>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">

                        Batal

                    </button>

                    <button
                        class="btn btn-success"
                        id="btnSubmitVerify">

                        <i class="fas fa-check me-1"></i>

                        Ya, Verifikasi

                    </button>

                </div>

            </div>

        </div>

    </div>

    <div class="modal fade" id="statusModal" tabindex="-1">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="statusTitle"></h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body text-center">

                    <input type="hidden" id="status_uuid">
                    <input type="hidden" id="status_value">

                    <div id="statusIcon" class="mb-3"></div>

                    <h5 id="statusCompany"></h5>

                    <p id="statusMessage" class="text-muted mb-0"></p>

                </div>

                <div class="modal-footer">

                    <button
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">

                        Batal

                    </button>

                    <button
                        class="btn"
                        id="btnSubmitStatus">

                        Simpan

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

                    url: '{{ route("dashboard-admin.management-user.bujp.index") }}',
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
                        data: "company_name",
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
                        data: "nib",
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
                        data: "npwp",
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
                        render: function(data){

                            if(!data.sio_number){

                                return `
                                    <span class="badge badge-light-warning">
                                        Belum Diisi
                                    </span>
                                `;

                            }

                            let badge = '';

                            if(data.sio_expired_date){

                                let expired = new Date(data.sio_expired_date);
                                let today = new Date();

                                if(expired < today){

                                    badge = `
                                        <span class="badge badge-light-danger ms-2">
                                            Expired
                                        </span>
                                    `;

                                }else{

                                    badge = `
                                        <span class="badge badge-light-success ms-2">
                                            Aktif
                                        </span>
                                    `;

                                }

                            }

                            return `
                                ${data.sio_number}
                                ${badge}
                            `;
                        }
                    },

                    {
                        data: "is_verified",
                        render:function(data){

                            if(data){

                                return `
                                    <span class="badge badge-light-success">
                                        Terverifikasi
                                    </span>
                                `;

                            }

                            return `
                                <span class="badge badge-light-warning">
                                    Belum Verifikasi
                                </span>
                            `;

                        }
                    },

                    {
                        data:"is_active",
                        render:function(data){

                            if(data){

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
                        data:null,
                        orderable:false,
                        searchable:false,
                        className:"text-end",

                        render: function(data){

                            let verifyButton = '';

                            if(data.is_verified == 0){

                                verifyButton = `
                                    <button
                                        class="btn btn-outline-success btn-sm me-1 btnVerify"
                                        data-uuid="${data.uuid}"
                                        data-company="${data.company_name}"
                                        title="Verifikasi Perusahaan">

                                        <i class="fas fa-check-circle"></i>

                                    </button>
                                `;

                            }

                            let statusButton = '';

                            if(data.is_active == 1){

                                statusButton = `
                                    <button
                                        class="btn btn-outline-danger btn-sm me-1 btnStatus"
                                        data-status="0"
                                        data-uuid="${data.uuid}"
                                        data-company="${data.company_name}"
                                        title="Nonaktifkan Akun">

                                        <i class="fas fa-user-slash"></i>

                                    </button>
                                `;

                            }else{

                                statusButton = `
                                    <button
                                        class="btn btn-outline-success btn-sm me-1 btnStatus"
                                        data-status="1"
                                        data-uuid="${data.uuid}"
                                        data-company="${data.company_name}"
                                        title="Aktifkan Akun">

                                        <i class="fas fa-user-check"></i>

                                    </button>
                                `;

                            }

                            return `

                                <a href="/dashboard-admin/management-user/bujp/${data.uuid}"
                                    class="btn btn-outline-info btn-sm me-1"
                                    title="Lihat Detail">

                                    <i class="fas fa-eye"></i>

                                </a>

                                ${verifyButton}

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

        $(document).on('click','.btnVerify',function(){

            let uuid=$(this).data('uuid');

            let company=$(this).data('company');

            $('#verify_uuid').val(uuid);

            $('#verify_company').text(company);

            $('#verifyModal').modal('show');

        });



        $('#btnSubmitVerify').click(function(){

            let uuid=$('#verify_uuid').val();

            $.ajax({

                url:'/dashboard-admin/management-user/bujp/'+uuid+'/verify',

                type:'POST',

                data:{
                    _token:$('meta[name="csrf-token"]').attr('content')
                },

                beforeSend:function(){

                    $('#btnSubmitVerify')
                    .prop('disabled',true)
                    .html('<i class="fas fa-spinner fa-spin"></i> Memproses...');

                },

                success:function(res){

                    $('#verifyModal').modal('hide');

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

                        title:'Oops',

                        text:'Terjadi kesalahan.'

                    });

                },

                complete:function(){

                    $('#btnSubmitVerify')
                    .prop('disabled',false)
                    .html('<i class="fas fa-check me-1"></i> Ya, Verifikasi');

                }

            });

        });

        $(document).on('click','.btnStatus',function(){

            let uuid = $(this).data('uuid');
            let company = $(this).data('company');
            let status = $(this).data('status');

            $('#status_uuid').val(uuid);
            $('#status_value').val(status);
            $('#statusCompany').text(company);

            if(status == 1){

                $('#statusTitle').text('Aktifkan Akun');

                $('#statusMessage').text(
                    'Apakah Anda yakin ingin mengaktifkan akun perusahaan ini?'
                );

                $('#statusIcon').html(
                    '<i class="fas fa-user-check text-success fa-4x"></i>'
                );

                $('#btnSubmitStatus')
                    .removeClass('btn-danger')
                    .addClass('btn-success')
                    .html('<i class="fas fa-check me-1"></i> Aktifkan');

            }else{

                $('#statusTitle').text('Nonaktifkan Akun');

                $('#statusMessage').text(
                    'Apakah Anda yakin ingin menonaktifkan akun perusahaan ini?'
                );

                $('#statusIcon').html(
                    '<i class="fas fa-user-slash text-danger fa-4x"></i>'
                );

                $('#btnSubmitStatus')
                    .removeClass('btn-success')
                    .addClass('btn-danger')
                    .html('<i class="fas fa-ban me-1"></i> Nonaktifkan');

            }

            new bootstrap.Modal(document.getElementById('statusModal')).show();

        });

        $('#btnSubmitStatus').click(function(){

            let uuid = $('#status_uuid').val();
            let status = $('#status_value').val();

            $.ajax({

                url: '/dashboard-admin/management-user/bujp/' + uuid + '/status',

                type: 'POST',

                data: {

                    _token: $('meta[name="csrf-token"]').attr('content'),

                    status: status

                },

                beforeSend:function(){

                    $('#btnSubmitStatus')
                        .prop('disabled',true);

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

                error:function(xhr){

                    Swal.fire({

                        icon:'error',

                        title:'Oops',

                        text:'Terjadi kesalahan.'

                    });

                },

                complete:function(){

                    $('#btnSubmitStatus')
                        .prop('disabled',false);

                }

            });

        });
    </script>
@endsection