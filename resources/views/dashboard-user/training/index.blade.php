@extends('layouts.dashboard-user')

@section('title', 'Pelatihan Saya')

@section('css')

@endsection

@section('breadcrumb')
    <h1
        class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
        Pelatihan Saya</h1>
    <!--end::Title-->
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
        <!--begin::Item-->
        <li class="breadcrumb-item text-muted">
            <a href="javascript:;" class="text-muted text-hover-primary">Beranda</a>
        </li>
        <!--end::Item-->
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-500 w-5px h-2px"></span>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item text-muted">Pelatihan Saya</li>
        <!--end::Item-->
    </ul>
    <!--end::Breadcrumb-->
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <a href="{{ route('dashboard-user.training.create') }}">
                <button
                    class="btn btn-primary py-2 mb-3"
                    style="float:right">

                    <i class="las la-plus me-1"></i>

                    Tambah

                </button>
            </a>
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

                                <th>Pelatihan</th>

                                <th>Penyelenggara</th>

                                <th>Lokasi</th>

                                <th>Mode</th>

                                <th>Jadwal</th>

                                <th>Kuota</th>

                                <th>Biaya</th>

                                <th>Sertifikat</th>

                                <th>Status</th>

                                <th>Dilihat</th>

                                <th class="text-end" width="8%">Aksi</th>

                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!--end col-->
    </div><!--end row-->

    <div class="modal fade" id="closeModal" tabindex="-1">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Tutup Lowongan
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body text-center">

                    <div class="mb-5">

                        <i class="fas fa-lock text-warning"
                            style="font-size:60px"></i>

                    </div>

                    <h4 class="mb-3">
                        Yakin ingin menutup lowongan?
                    </h4>

                    <p class="text-muted mb-0">

                        Lowongan tidak akan tampil lagi kepada pelamar.
                        Anda masih dapat melihat data lowongan ini.

                    </p>

                    <input
                        type="hidden"
                        id="closeUuid">

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal">

                        Batal

                    </button>

                    <button
                        type="button"
                        class="btn btn-danger"
                        id="btnCloseVacancy">

                        <i class="fas fa-lock me-2"></i>

                        Tutup Lowongan

                    </button>

                </div>

            </div>

        </div>

    </div>

    <div class="modal fade" id="withdrawModal" tabindex="-1">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">

                        Tarik Pengajuan

                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body text-center">

                    <div class="mb-5">

                        <i class="fas fa-undo text-warning"
                        style="font-size:60px"></i>

                    </div>

                    <h4 class="mb-3">

                        Tarik pengajuan lowongan?

                    </h4>

                    <p class="text-muted mb-0">

                        Status lowongan akan dikembalikan menjadi <strong>Draft</strong>.
                        Anda dapat melakukan perubahan sebelum mengajukan kembali.

                    </p>

                    <input
                        type="hidden"
                        id="withdrawUuid">

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal">

                        Batal

                    </button>

                    <button
                        type="button"
                        class="btn btn-warning"
                        id="btnWithdrawVacancy">

                        <i class="fas fa-undo me-2"></i>

                        Tarik Pengajuan

                    </button>

                </div>

            </div>

        </div>

    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="deleteModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Lowongan</h5>
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
        function deleteData(uuid)
        {
            $("#deleteUuid").val(uuid);

            $("#deleteModal").modal("show");
        }

        $("#formDelete").submit(function(e){

            e.preventDefault();

            let uuid = $("#deleteUuid").val();

            $.ajax({

                url: "{{ route('dashboard-user.training.index') }}/" + uuid,

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

        function closeVacancy(uuid)
        {
            $("#closeUuid").val(uuid);

            $("#closeModal").modal("show");
        }

        $("#btnCloseVacancy").click(function(){

            let uuid = $("#closeUuid").val();

            $.ajax({

                url: "/dashboard-user/job-vacancy/" + uuid + "/close",

                type: "POST",

                data:{

                    _token:$('meta[name="csrf-token"]').attr("content")

                },

                beforeSend:function(){

                    $("#btnCloseVacancy")
                        .prop("disabled",true)
                        .html('<span class="spinner-border spinner-border-sm me-2"></span>Memproses...');

                },

                success:function(res){

                    $("#closeModal").modal("hide");

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

                        text:xhr.responseJSON.message

                    });

                },

                complete:function(){

                    $("#btnCloseVacancy")
                        .prop("disabled",false)
                        .html('<i class="fas fa-lock me-2"></i>Tutup Lowongan');

                }

            });

        });

        function withdrawVacancy(uuid)
        {
            $("#withdrawUuid").val(uuid);

            $("#withdrawModal").modal("show");
        }

        $("#btnWithdrawVacancy").click(function(){

            let uuid = $("#withdrawUuid").val();

            $.ajax({

                url: "/dashboard-user/job-vacancy/" + uuid + "/withdraw",

                type: "POST",

                data:{

                    _token:$('meta[name="csrf-token"]').attr("content")

                },

                beforeSend:function(){

                    $("#btnWithdrawVacancy")
                        .prop("disabled",true)
                        .html('<span class="spinner-border spinner-border-sm me-2"></span>Memproses...');

                },

                success:function(res){

                    $("#withdrawModal").modal("hide");

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

                        text:xhr.responseJSON.message

                    });

                },

                complete:function(){

                    $("#btnWithdrawVacancy")
                        .prop("disabled",false)
                        .html('<i class="fas fa-undo me-2"></i>Tarik Pengajuan');

                }

            });

        });
        
        $(document).ready(function() {
            let currentDraw = 1;

             if ($.fn.DataTable.isDataTable('#datatable')) {
                $('#datatable').DataTable().destroy();
            }

            let table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                responsive: false,
                "aLengthMenu": [[10, 25, 50, 75, 999999], [10, 25, 50, 75, "All"]],
                ajax: {

                    url: '{{ route("dashboard-user.training.index") }}',
                    type: 'GET',

                    data: function (d) {

                        currentDraw = d.draw;

                        d.page = (d.start / d.length) + 1;
                        d.length = d.length;
                        d.status = "{{ request('status', 'all') }}";

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
                            return ("000000" + data).slice(-6);
                        }
                    },

                    {
                        data: "title",
                        render:function(data){

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
                        data: "provider",
                        render:function(data){

                            return data ?? "-";

                        }
                    },

                    {
                        data:null,
                        render:function(data){

                            let lokasi=[];

                            if(data.city) lokasi.push(data.city);

                            if(data.province) lokasi.push(data.province);

                            if(lokasi.length==0){

                                return `
                                    <span class="badge badge-light-warning">
                                        Belum Diatur
                                    </span>
                                `;

                            }

                            return lokasi.join(", ");

                        }
                    },

                    {
                        data:"training_mode",
                        className:"text-center",
                        render:function(data){

                            switch(data){

                                case "offline":
                                    return `<span class="badge badge-light-danger">Offline</span>`;

                                case "online":
                                    return `<span class="badge badge-light-primary">Online</span>`;

                                case "hybrid":
                                    return `<span class="badge badge-light-success">Hybrid</span>`;

                                default:
                                    return "-";
                            }

                        }
                    },

                    {
                        data:null,
                        render:function(data){

                            if(!data.start_date){

                                return `
                                    <span class="badge badge-light-warning">
                                        Belum Diatur
                                    </span>
                                `;

                            }

                            let start = moment(data.start_date).format("DD-MM-YYYY");
                            let end = moment(data.end_date).format("DD-MM-YYYY");

                            return `
                                ${start}
                                <br>
                                <small class="text-muted">
                                    s/d ${end}
                                </small>
                            `;

                        }
                    },

                    {
                        data:null,
                        className:"text-center",
                        render:function(data){

                            let reg=data.registered ?? 0;
                            let quota=data.quota ?? 0;

                            return `${reg}/${quota}`;

                        }
                    },

                    {
                        data:null,
                        render:function(data){

                            if(data.is_free==1){

                                return `
                                    <span class="badge badge-light-success">
                                        Gratis
                                    </span>
                                `;

                            }

                            let formatter=new Intl.NumberFormat("id-ID");

                            return `
                                Rp ${formatter.format(data.price ?? 0)}
                            `;

                        }
                    },

                    {
                        data:"is_certificate",
                        className:"text-center",
                        render:function(data){

                            if(data==1){

                                return `
                                    <span class="badge badge-light-success">
                                        Ya
                                    </span>
                                `;

                            }

                            return `
                                <span class="badge badge-light-secondary">
                                    Tidak
                                </span>
                            `;

                        }
                    },

                    {
                        data:"status",
                        className:"text-center",
                        render:function(data){

                            switch(data){

                                case "draft":
                                    return `<span class="badge badge-light-secondary">Draft</span>`;

                                case "submitted":
                                    return `<span class="badge badge-light-warning">Submitted</span>`;

                                case "published":
                                    return `<span class="badge badge-light-success">Published</span>`;

                                case "running":
                                    return `<span class="badge badge-light-primary">Running</span>`;

                                case "closed":
                                    return `<span class="badge badge-light-danger">Closed</span>`;

                                case "cancelled":
                                    return `<span class="badge badge-light-dark">Cancelled</span>`;

                                case "rejected":
                                    return `<span class="badge badge-light-danger">Rejected</span>`;

                                default:
                                    return "-";
                            }

                        }
                    },

                    {
                        data:"total_clicked",
                        className:"text-center",
                        render:function(data){

                            return `
                                <span class="badge badge-light-info">
                                    ${data ?? 0}x
                                </span>
                            `;

                        }
                    },

                    {
                        data:null,
                        orderable:false,
                        searchable:false,
                        className:"text-end",
                        render:function(data){

                            let action = `

                                <!-- Detail -->
                                <a href="/dashboard-user/training/${data.uuid}"
                                    class="btn btn-outline-info btn-sm me-1"
                                    title="Detail">

                                    <i class="fas fa-eye"></i>

                                </a>

                            `;


                            switch(data.status){

                                /*=========================================
                                =                 DRAFT                   =
                                =========================================*/

                                case "draft":

                                    action += `

                                        <!-- Edit -->
                                        <a href="/dashboard-user/training/${data.uuid}/edit"
                                            class="btn btn-outline-primary btn-sm me-1"
                                            title="Edit">

                                            <i class="fas fa-pencil-alt"></i>

                                        </a>


                                        <!-- Hapus -->
                                        <button
                                            class="btn btn-outline-danger btn-sm"
                                            onclick="deleteData('${data.uuid}')"
                                            title="Hapus">

                                            <i class="fas fa-trash-alt"></i>

                                        </button>

                                    `;

                                break;


                                /*=========================================
                                =               SUBMITTED                 =
                                =========================================*/

                                case "submitted":

                                    action += `

                                        <!-- Tarik Pengajuan -->
                                        <button
                                            class="btn btn-outline-warning btn-sm"
                                            onclick="withdrawTraining('${data.uuid}')"
                                            title="Tarik Pengajuan">

                                            <i class="fas fa-undo"></i>

                                        </button>

                                    `;

                                break;


                                /*=========================================
                                =               PUBLISHED                 =
                                =========================================*/

                                case "published":

                                    action += `

                                        <!-- Peserta -->
                                        <a href="/dashboard-user/training/${data.uuid}/participants"
                                            class="btn btn-outline-success btn-sm me-1"
                                            title="Peserta">

                                            <i class="fas fa-users"></i>

                                        </a>

                                    `;

                                break;


                                /*=========================================
                                =                 RUNNING                 =
                                =========================================*/

                                case "running":

                                    action += `

                                        <!-- Peserta -->
                                        <a href="/dashboard-user/training/${data.uuid}/participants"
                                            class="btn btn-outline-success btn-sm me-1"
                                            title="Peserta">

                                            <i class="fas fa-users"></i>

                                        </a>


                                        <!-- Selesaikan -->
                                        <button
                                            class="btn btn-outline-primary btn-sm"
                                            onclick="completeTraining('${data.uuid}')"
                                            title="Selesaikan Pelatihan">

                                            <i class="fas fa-check"></i>

                                        </button>

                                    `;

                                break;


                                /*=========================================
                                =                 CLOSED                  =
                                =========================================*/

                                case "closed":

                                    action += `

                                        <!-- Buka Kembali -->
                                        <button
                                            class="btn btn-outline-success btn-sm"
                                            onclick="reopenTraining('${data.uuid}')"
                                            title="Buka Kembali">

                                            <i class="fas fa-lock-open"></i>

                                        </button>

                                    `;

                                break;


                                /*=========================================
                                =                REJECTED                 =
                                =========================================*/

                                case "rejected":

                                    action += `

                                        <!-- Perbaiki -->
                                        <a href="/dashboard-user/training/${data.uuid}/edit"
                                            class="btn btn-outline-primary btn-sm me-1"
                                            title="Perbaiki Pelatihan">

                                            <i class="fas fa-pencil-alt"></i>

                                        </a>


                                        <!-- Hapus -->
                                        <button
                                            class="btn btn-outline-danger btn-sm"
                                            onclick="deleteData('${data.uuid}')"
                                            title="Hapus">

                                            <i class="fas fa-trash-alt"></i>

                                        </button>

                                    `;

                                break;


                                /*=========================================
                                =                CANCELLED                =
                                =========================================*/

                                case "cancelled":

                                    action += `

                                        <!-- Hapus -->
                                        <button
                                            class="btn btn-outline-danger btn-sm"
                                            onclick="deleteData('${data.uuid}')"
                                            title="Hapus">

                                            <i class="fas fa-trash-alt"></i>

                                        </button>

                                    `;

                                break;

                            }


                            return action;

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
    </script>
@endsection