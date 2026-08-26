@extends('layouts.dashboard-admin')

@section('title', 'Berjalan')

@section('css')

@endsection

@section('breadcrumb')
    <h1
        class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
        Manajemen Pelatihan</h1>
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
        <li class="breadcrumb-item text-muted">Manajemen Pelatihan</li>
        <!--end::Item-->
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-500 w-5px h-2px"></span>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item text-muted">Berjalan</li>
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

    <div class="modal fade"
        id="modalCloseTraining"
        tabindex="-1">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">

                        <i class="fas fa-lock text-warning me-2"></i>

                        Tutup Pelatihan

                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body text-center">

                    <i class="fas fa-lock text-warning mb-4"
                    style="font-size:55px;">
                    </i>

                    <h5>
                        Tutup pelatihan ini?
                    </h5>

                    <p class="text-muted">

                        Pelatihan akan berubah menjadi
                        <strong>Closed</strong>.

                    </p>

                    <input
                        type="hidden"
                        id="closeTrainingUuid">

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
                        id="btnConfirmClose">

                        <i class="fas fa-lock me-1"></i>

                        Tutup Pelatihan

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
                responsive: false,
                "aLengthMenu": [[10, 25, 50, 75, 999999], [10, 25, 50, 75, "All"]],
                ajax: {

                    url: '{{ route("dashboard-admin.training.running.index") }}',
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
                            return `
                                <a href="/dashboard-admin/training/${data.uuid}"
                                    class="btn btn-outline-info btn-sm me-1"
                                    title="Detail">

                                    <i class="fas fa-eye"></i>

                                </a>

                                <button
                                    class="btn btn-outline-warning btn-sm me-1"
                                    onclick="closeTraining('${data.uuid}')"
                                    title="Tutup Pelatihan">

                                    <i class="fas fa-lock"></i>

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

        function closeTraining(uuid)
        {
            $("#closeTrainingUuid").val(uuid);

            let modal = new bootstrap.Modal(
                document.getElementById("modalCloseTraining")
            );

            modal.show();
        }


        $("#btnConfirmClose").click(function(){

            let uuid = $("#closeTrainingUuid").val();

            let button = $(this);

            button.prop("disabled", true);

            $.ajax({

                url: `/dashboard-admin/training/${uuid}/close`,

                type: "POST",

                data: {

                    _token: "{{ csrf_token() }}"

                },

                success: function(response){

                    bootstrap.Modal
                        .getInstance(
                            document.getElementById("modalCloseTraining")
                        )
                        .hide();

                    Swal.fire({
                        icon: "success",
                        title: "Pelatihan Ditutup",
                        text: response.message,
                        confirmButtonColor: "#d6a13b"
                    }).then(function(){

                        $('#datatable').DataTable().ajax.reload(null, false);

                    });

                },

                error: function(xhr){

                    Swal.fire({
                        icon: "error",
                        title: "Gagal",
                        text: xhr.responseJSON?.message ??
                            "Terjadi kesalahan."
                    });

                },

                complete: function(){

                    button.prop("disabled", false);

                }

            });

        });
    </script>
@endsection