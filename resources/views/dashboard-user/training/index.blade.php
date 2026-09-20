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

                                <th>Peserta</th>

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


            /*
            |--------------------------------------------------------------------------
            | DESTROY DATATABLE JIKA SUDAH ADA
            |--------------------------------------------------------------------------
            */

            if ($.fn.DataTable.isDataTable('#datatable')) {

                $('#datatable').DataTable().destroy();

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

                responsive: false,


                /*
                |--------------------------------------------------------------------------
                | LENGTH MENU
                |--------------------------------------------------------------------------
                */

                "aLengthMenu": [
                    [10, 25, 50, 75, 999999],
                    [10, 25, 50, 75, "All"]
                ],


                /*
                |--------------------------------------------------------------------------
                | AJAX
                |--------------------------------------------------------------------------
                */

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


                /*
                |--------------------------------------------------------------------------
                | COLUMNS
                |--------------------------------------------------------------------------
                */

                columns: [


                    /*
                    |--------------------------------------------------------------------------
                    | ID
                    |--------------------------------------------------------------------------
                    */

                    {
                        data: "id",

                        render: function(data) {

                            return ("000000" + data).slice(-6);

                        }
                    },


                    /*
                    |--------------------------------------------------------------------------
                    | PELATIHAN
                    |--------------------------------------------------------------------------
                    */

                    {
                        data: "title",

                        render: function(data) {

                            if (!data) {

                                return `
                                    <span class="badge badge-light-warning">
                                        Belum Diisi
                                    </span>
                                `;

                            }

                            return `
                                <div class="fw-bold">
                                    ${data}
                                </div>
                            `;

                        }
                    },


                    /*
                    |--------------------------------------------------------------------------
                    | PENYELENGGARA
                    |--------------------------------------------------------------------------
                    */

                    {
                        data: "provider",

                        render: function(data) {

                            if (!data) {

                                return "-";

                            }

                            return `
                                <i class="fas fa-building me-1 text-muted"></i>
                                ${data}
                            `;

                        }
                    },


                    /*
                    |--------------------------------------------------------------------------
                    | LOKASI
                    |--------------------------------------------------------------------------
                    */

                    {
                        data: null,

                        render: function(data) {

                            let lokasi = [];


                            if (data.city) {

                                lokasi.push(data.city);

                            }


                            if (data.province) {

                                lokasi.push(data.province);

                            }


                            if (lokasi.length == 0) {

                                return `
                                    <span class="badge badge-light-warning">
                                        Belum Diatur
                                    </span>
                                `;

                            }


                            return `
                                <i class="fas fa-map-marker-alt me-1 text-muted"></i>
                                ${lokasi.join(", ")}
                            `;

                        }
                    },


                    /*
                    |--------------------------------------------------------------------------
                    | MODE
                    |--------------------------------------------------------------------------
                    */

                    {
                        data: "training_mode",

                        className: "text-center",

                        render: function(data) {

                            switch(data) {

                                case "offline":

                                    return `
                                        <span class="badge badge-light-danger">
                                            <i class="fas fa-map-marker-alt me-1"></i>
                                            Offline
                                        </span>
                                    `;


                                case "online":

                                    return `
                                        <span class="badge badge-light-primary">
                                            <i class="fas fa-globe me-1"></i>
                                            Online
                                        </span>
                                    `;


                                case "hybrid":

                                    return `
                                        <span class="badge badge-light-success">
                                            <i class="fas fa-random me-1"></i>
                                            Hybrid
                                        </span>
                                    `;


                                default:

                                    return "-";

                            }

                        }
                    },


                    /*
                    |--------------------------------------------------------------------------
                    | JADWAL
                    |--------------------------------------------------------------------------
                    */

                    {
                        data: null,

                        render: function(data) {

                            if (!data.start_date) {

                                return `
                                    <span class="badge badge-light-warning">
                                        Belum Diatur
                                    </span>
                                `;

                            }


                            let start = moment(
                                data.start_date
                            ).format("DD-MM-YYYY");


                            let end = moment(
                                data.end_date
                            ).format("DD-MM-YYYY");


                            return `
                                <i class="fas fa-calendar-alt me-1 text-muted"></i>
                                ${start}

                                <br>

                                <small class="text-muted">
                                    s/d ${end}
                                </small>
                            `;

                        }
                    },


                    /*
                    |--------------------------------------------------------------------------
                    | KUOTA
                    |--------------------------------------------------------------------------
                    */

                    {
                        data: null,

                        className: "text-center",

                        render: function(data) {

                            let quota = data.quota ?? 0;

                            return `
                                <span class="badge badge-light-primary">
                                    <i class="fas fa-users me-1"></i>
                                    ${quota} Orang
                                </span>
                            `;

                        }
                    },


                    /*
                    |--------------------------------------------------------------------------
                    | PESERTA
                    |--------------------------------------------------------------------------
                    */

                    {
                        data: null,

                        className: "text-center",

                        render: function(data) {

                            let total = data.total_applications ?? 0;

                            let pending = data.total_pending ?? 0;

                            let approved = data.total_approved ?? 0;

                            let rejected = data.total_rejected ?? 0;


                            return `

                                <div class="d-flex flex-column align-items-center">

                                    <!-- TOTAL -->

                                    <span
                                        class="badge badge-light-primary mb-1"
                                        data-bs-toggle="tooltip"
                                        title="Total Pendaftar"
                                    >

                                        <i class="fas fa-users me-1"></i>

                                        ${total}

                                    </span>


                                    <!-- DETAIL STATUS -->

                                    <div
                                        class="small text-nowrap"
                                        style="font-size:10px;"
                                    >

                                        <!-- PENDING -->

                                        <span
                                            class="text-warning"
                                            data-bs-toggle="tooltip"
                                            title="Menunggu Persetujuan"
                                        >

                                            <i class="fas fa-clock"></i>

                                            ${pending}

                                        </span>


                                        <span class="mx-1 text-muted">
                                            •
                                        </span>


                                        <!-- APPROVED -->

                                        <span
                                            class="text-success"
                                            data-bs-toggle="tooltip"
                                            title="Disetujui"
                                        >

                                            <i class="fas fa-check"></i>

                                            ${approved}

                                        </span>


                                        <span class="mx-1 text-muted">
                                            •
                                        </span>


                                        <!-- REJECTED -->

                                        <span
                                            class="text-danger"
                                            data-bs-toggle="tooltip"
                                            title="Ditolak"
                                        >

                                            <i class="fas fa-times"></i>

                                            ${rejected}

                                        </span>

                                    </div>

                                </div>

                            `;

                        }
                    },


                    /*
                    |--------------------------------------------------------------------------
                    | BIAYA
                    |--------------------------------------------------------------------------
                    */

                    {
                        data: null,

                        render: function(data) {

                            if (data.is_free == 1) {

                                return `
                                    <span class="badge badge-light-success">
                                        <i class="fas fa-gift me-1"></i>
                                        Gratis
                                    </span>
                                `;

                            }


                            let formatter =
                                new Intl.NumberFormat("id-ID");


                            return `
                                Rp ${formatter.format(data.price ?? 0)}
                            `;

                        }
                    },


                    /*
                    |--------------------------------------------------------------------------
                    | SERTIFIKAT
                    |--------------------------------------------------------------------------
                    */

                    {
                        data: "is_certificate",

                        className: "text-center",

                        render: function(data) {

                            if (data == 1) {

                                return `
                                    <span class="badge badge-light-success">
                                        <i class="fas fa-certificate me-1"></i>
                                        Ya
                                    </span>
                                `;

                            }


                            return `
                                <span class="badge badge-light-secondary">
                                    <i class="fas fa-times me-1"></i>
                                    Tidak
                                </span>
                            `;

                        }
                    },


                    /*
                    |--------------------------------------------------------------------------
                    | STATUS
                    |--------------------------------------------------------------------------
                    */

                    {
                        data: "status",

                        className: "text-center",

                        render: function(data) {

                            switch(data) {

                                case "draft":

                                    return `
                                        <span class="badge badge-light-secondary">
                                            Draft
                                        </span>
                                    `;


                                case "submitted":

                                    return `
                                        <span class="badge badge-light-warning">
                                            Submitted
                                        </span>
                                    `;


                                case "published":

                                    return `
                                        <span class="badge badge-light-success">
                                            Published
                                        </span>
                                    `;


                                case "running":

                                    return `
                                        <span class="badge badge-light-primary">
                                            Running
                                        </span>
                                    `;


                                case "closed":

                                    return `
                                        <span class="badge badge-light-danger">
                                            Closed
                                        </span>
                                    `;


                                case "cancelled":

                                    return `
                                        <span class="badge badge-light-dark">
                                            Cancelled
                                        </span>
                                    `;


                                case "rejected":

                                    return `
                                        <span class="badge badge-light-danger">
                                            Rejected
                                        </span>
                                    `;


                                default:

                                    return "-";

                            }

                        }
                    },


                    /*
                    |--------------------------------------------------------------------------
                    | DILIHAT
                    |--------------------------------------------------------------------------
                    */

                    {
                        data: "total_clicked",

                        className: "text-center",

                        render: function(data) {

                            return `
                                <span
                                    class="badge badge-light-info"
                                    data-bs-toggle="tooltip"
                                    title="Total Dilihat"
                                >

                                    <i class="fas fa-eye me-1"></i>

                                    ${data ?? 0}x

                                </span>
                            `;

                        }
                    },


                    /*
                    |--------------------------------------------------------------------------
                    | AKSI
                    |--------------------------------------------------------------------------
                    */

                    {
                        data: null,

                        orderable: false,

                        searchable: false,

                        className: "text-end",

                        render: function(data) {


                            let action = `

                                <!-- Detail -->

                                <a
                                    href="/dashboard-user/training/${data.uuid}"
                                    class="btn btn-outline-info btn-sm me-1"
                                    title="Detail"
                                    data-bs-toggle="tooltip"
                                >

                                    <i class="fas fa-eye"></i>

                                </a>

                            `;


                            switch(data.status) {


                                /*=========================================
                                =                 DRAFT                   =
                                =========================================*/

                                case "draft":

                                    action += `

                                        <!-- Edit -->

                                        <a
                                            href="/dashboard-user/training/${data.uuid}/edit"
                                            class="btn btn-outline-primary btn-sm me-1"
                                            title="Edit"
                                            data-bs-toggle="tooltip"
                                        >

                                            <i class="fas fa-pencil-alt"></i>

                                        </a>


                                        <!-- Hapus -->

                                        <button
                                            class="btn btn-outline-danger btn-sm"
                                            onclick="deleteData('${data.uuid}')"
                                            title="Hapus"
                                            data-bs-toggle="tooltip"
                                        >

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
                                            title="Tarik Pengajuan"
                                            data-bs-toggle="tooltip"
                                        >

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

                                        <a
                                            href="/dashboard-user/training/${data.uuid}/participants"
                                            class="btn btn-outline-success btn-sm me-1"
                                            title="Peserta"
                                            data-bs-toggle="tooltip"
                                        >

                                            <i class="fas fa-users"></i>

                                        </a>


                                        <!-- Mulai -->

                                        <button
                                            class="btn btn-outline-primary btn-sm me-1"
                                            onclick="startTraining('${data.uuid}')"
                                            title="Mulai Pelatihan"
                                            data-bs-toggle="tooltip"
                                        >

                                            <i class="fas fa-play"></i>

                                        </button>


                                        <!-- Batalkan -->

                                        <button
                                            class="btn btn-outline-danger btn-sm"
                                            onclick="cancelTraining('${data.uuid}')"
                                            title="Batalkan Pelatihan"
                                            data-bs-toggle="tooltip"
                                        >

                                            <i class="fas fa-times"></i>

                                        </button>

                                    `;

                                break;


                                /*=========================================
                                =                 RUNNING                 =
                                =========================================*/

                                case "running":

                                    action += `

                                        <!-- Peserta -->

                                        <a
                                            href="/dashboard-user/training/${data.uuid}/participants"
                                            class="btn btn-outline-success btn-sm me-1"
                                            title="Peserta"
                                            data-bs-toggle="tooltip"
                                        >

                                            <i class="fas fa-users"></i>

                                        </a>


                                        <!-- Selesaikan -->

                                        <button
                                            class="btn btn-outline-primary btn-sm"
                                            onclick="completeTraining('${data.uuid}')"
                                            title="Selesaikan Pelatihan"
                                            data-bs-toggle="tooltip"
                                        >

                                            <i class="fas fa-check"></i>

                                        </button>

                                    `;

                                break;


                                /*=========================================
                                =                 CLOSED                  =
                                =========================================*/

                                case "closed":

                                    // action += `

                                    //     <!-- Buka Kembali -->

                                    //     <button
                                    //         class="btn btn-outline-success btn-sm"
                                    //         onclick="reopenTraining('${data.uuid}')"
                                    //         title="Buka Kembali">

                                    //         <i class="fas fa-lock-open"></i>

                                    //     </button>

                                    // `;

                                break;


                                /*=========================================
                                =                REJECTED                 =
                                =========================================*/

                                case "rejected":

                                    action += `

                                        <!-- Perbaiki -->

                                        <a
                                            href="/dashboard-user/training/${data.uuid}/edit"
                                            class="btn btn-outline-primary btn-sm me-1"
                                            title="Perbaiki Pelatihan"
                                            data-bs-toggle="tooltip"
                                        >

                                            <i class="fas fa-pencil-alt"></i>

                                        </a>


                                        <!-- Hapus -->

                                        <button
                                            class="btn btn-outline-danger btn-sm"
                                            onclick="deleteData('${data.uuid}')"
                                            title="Hapus"
                                            data-bs-toggle="tooltip"
                                        >

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
                                            title="Hapus"
                                            data-bs-toggle="tooltip"
                                        >

                                            <i class="fas fa-trash-alt"></i>

                                        </button>

                                    `;

                                break;

                            }


                            return action;

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


                /*
                |--------------------------------------------------------------------------
                | DRAW CALLBACK
                |--------------------------------------------------------------------------
                */

                drawCallback: function() {

                    $('[data-bs-toggle="tooltip"]').tooltip();

                }

            });


            /*
            |--------------------------------------------------------------------------
            | BUTTON CONTAINER
            |--------------------------------------------------------------------------
            */

            table.buttons()
                .container()
                .appendTo('.card-button');

        });

        function startTraining(uuid)
        {
            Swal.fire({

                title: 'Mulai Pelatihan?',

                text: 'Apakah Anda yakin ingin memulai pelatihan ini?',

                icon: 'question',

                showCancelButton: true,

                confirmButtonText: 'Ya, Mulai',

                cancelButtonText: 'Batal',

                reverseButtons: true

            }).then((result) => {

                if (!result.isConfirmed) {
                    return;
                }

                $.ajax({

                    url: `/dashboard-user/training/${uuid}/start`,

                    type: 'POST',

                    data: {
                        _token: "{{ csrf_token() }}"
                    },

                    success: function(response) {

                        Swal.fire({

                            icon: 'success',

                            title: 'Berhasil',

                            text: response.message,

                            timer: 1500,

                            showConfirmButton: false

                        }).then(() => {

                            $('#dataTable').DataTable().ajax.reload(null, false);

                        });

                    },

                    error: function(xhr) {

                        Swal.fire({

                            icon: 'error',

                            title: 'Gagal',

                            text: xhr.responseJSON?.message
                                ?? 'Terjadi kesalahan saat memulai pelatihan.'

                        });

                    }

                });

            });
        }

        function cancelTraining(uuid)
        {
            Swal.fire({

                title: 'Batalkan Pelatihan?',

                text: 'Pelatihan yang dibatalkan tidak dapat berjalan.',

                icon: 'warning',

                showCancelButton: true,

                confirmButtonText: 'Ya, Batalkan',

                cancelButtonText: 'Tidak',

                reverseButtons: true

            }).then((result) => {

                if (!result.isConfirmed) {
                    return;
                }

                $.ajax({

                    url: `/dashboard-user/training/${uuid}/cancel`,

                    type: 'POST',

                    data: {
                        _token: "{{ csrf_token() }}"
                    },

                    success: function(response) {

                        Swal.fire({

                            icon: 'success',

                            title: 'Berhasil',

                            text: response.message,

                            timer: 1500,

                            showConfirmButton: false

                        }).then(() => {

                            $('#dataTable').DataTable().ajax.reload(null, false);

                        });

                    },

                    error: function(xhr) {

                        Swal.fire({

                            icon: 'error',

                            title: 'Gagal',

                            text: xhr.responseJSON?.message
                                ?? 'Terjadi kesalahan saat membatalkan pelatihan.'

                        });

                    }

                });

            });
        }

        function completeTraining(uuid)
        {
            Swal.fire({

                title: 'Selesaikan Pelatihan?',

                text: 'Apakah pelatihan ini sudah selesai dilaksanakan?',

                icon: 'question',

                showCancelButton: true,

                confirmButtonText: 'Ya, Selesaikan',

                cancelButtonText: 'Batal',

                reverseButtons: true

            }).then((result) => {

                if (!result.isConfirmed) {
                    return;
                }

                $.ajax({

                    url: `/dashboard-user/training/${uuid}/close`,

                    type: 'POST',

                    data: {
                        _token: "{{ csrf_token() }}"
                    },

                    success: function(response) {

                        Swal.fire({

                            icon: 'success',

                            title: 'Berhasil',

                            text: response.message,

                            timer: 1500,

                            showConfirmButton: false

                        }).then(() => {

                            $('#dataTable').DataTable().ajax.reload(null, false);

                        });

                    },

                    error: function(xhr) {

                        Swal.fire({

                            icon: 'error',

                            title: 'Gagal',

                            text: xhr.responseJSON?.message
                                ?? 'Terjadi kesalahan saat menyelesaikan pelatihan.'

                        });

                    }

                });

            });
        }
    </script>
@endsection