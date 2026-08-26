@extends('layouts.dashboard-admin')

@section('title', 'Terpublish')

@section('css')

@endsection

@section('breadcrumb')
    <h1
        class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
        Manajemen Lowongan</h1>
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
        <li class="breadcrumb-item text-muted">Manajemen Lowongan</li>
        <!--end::Item-->
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-500 w-5px h-2px"></span>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item text-muted">Terpublish</li>
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
                                <th>Posisi</th>
                                <th>Perusahaan</th>
                                <th>Lokasi</th>
                                <th>Kuota</th>
                                <th>Gaji</th>
                                <th>Periode</th>
                                <th>Status</th>
                                <th>Dilihat</th>
                                <th>Pelamar</th>
                                <th>Simpan</th>
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

    <!-- MODAL HAPUS LOWONGAN -->
    <div class="modal fade" id="deleteJobModal" tabindex="-1" aria-labelledby="deleteJobModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="deleteJobModalLabel">
                        Hapus Lowongan
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                    </button>

                </div>

                <div class="modal-body text-center">

                    <i class="fas fa-exclamation-triangle text-danger fs-1 mb-3"></i>

                    <h5>Apakah Anda yakin?</h5>

                    <p class="text-muted mb-0">
                        Lowongan yang dihapus tidak dapat dikembalikan.
                    </p>

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
                        id="btn-confirm-delete-job">

                        <i class="fas fa-trash-alt me-2"></i>
                        Hapus Lowongan

                    </button>

                </div>

            </div>

        </div>

    </div>
@endsection

@section('js')
    <script>

        let deleteJobUuid = null;

        $(document).on('click', '.btn-delete-job', function () {

            deleteJobUuid = $(this).data('uuid');

            $('#deleteJobModal').modal('show');

        });

        $(document).on('click', '#btn-confirm-delete-job', function () {

            if (!deleteJobUuid) {
                return;
            }

            const button = $(this);

            button.prop('disabled', true);

            button.html(`
                <span class="spinner-border spinner-border-sm me-2"></span>
                Menghapus...
            `);

            $.ajax({

                url: "{{ route('dashboard-admin.job-vacancy.destroy') }}",

                type: "DELETE",

                data: {
                    _token: "{{ csrf_token() }}",
                    uuid: deleteJobUuid
                },

                success: function (response) {

                    $('#deleteJobModal').modal('hide');

                    // reload DataTable
                    $('#datatable-job').DataTable().ajax.reload(null, false);

                    toastr.success(
                        response.message ?? 'Lowongan berhasil dihapus.'
                    );

                    deleteJobUuid = null;

                    $('#datatable').DataTable().ajax.reload(null, false);

                },

                error: function (xhr) {

                    toastr.error(
                        xhr.responseJSON?.message ??
                        'Lowongan gagal dihapus.'
                    );

                },

                complete: function () {

                    button.prop('disabled', false);

                    button.html(`
                        <i class="fas fa-trash-alt me-2"></i>
                        Hapus Lowongan
                    `);

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

                    url: '{{ route("dashboard-admin.job-vacancy.published.index") }}',
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
                        data: "position",
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
                        data:null,
                        render:function(data){

                            let company = "-";
                            let badge = "badge-light-secondary";
                            let icon = "fa-building";

                            if(data.bujp){

                                company = data.bujp.company_name;
                                badge = "badge-light-primary";

                            }

                            if(data.company){

                                company = data.company.company_name;
                                badge = "badge-light-success";

                            }

                            return `
                                <div class="d-flex align-items-center">

                                    <div class="symbol symbol-35px me-2">

                                        <span class="symbol-label bg-light">
                                            <i class="fas ${icon} text-primary"></i>
                                        </span>

                                    </div>

                                    <div>

                                        <div class="fw-bold">
                                            ${company}
                                        </div>

                                        <span class="badge ${badge}">
                                            ${data.bujp ? 'BUJP' : 'Company'}
                                        </span>

                                    </div>

                                </div>
                            `;
                        }
                    },
                    {
                        data: null,
                        render:function(data){

                            let lokasi = [];

                            if(data.city) lokasi.push(data.city);
                            if(data.province) lokasi.push(data.province);

                            if(lokasi.length == 0){
                                return `
                                    <span class="badge badge-light-warning">
                                        Belum Diisi
                                    </span>
                                `;
                            }

                            return lokasi.join(", ");
                        }
                    },
                    {
                        data: "kuota",
                        className:"text-center",
                        render:function(data){

                            if(!data){
                                return "-";
                            }

                            return data + " Orang";
                        }
                    },
                    {
                        data:null,
                        render:function(data){

                            if(data.is_show_fee == 0){
                                return `
                                    <span class="badge badge-light-secondary">
                                        Dirahasiakan
                                    </span>
                                `;
                            }

                            let formatter = new Intl.NumberFormat('id-ID');

                            let min = data.min_price
                                ? formatter.format(data.min_price)
                                : "-";

                            let max = data.max_price
                                ? formatter.format(data.max_price)
                                : "-";

                            let type = data.fee_type == "daily"
                                ? "/ Hari"
                                : "/ Bulan";

                            return `
                                Rp ${min} - ${max}
                                <br>
                                <small class="text-muted">${type}</small>
                            `;
                        }
                    },
                    {
                        data:null,
                        render:function(data){

                            if(!data.start_date || !data.end_date){

                                return `
                                    <span class="badge badge-light-warning">
                                        Belum Diatur
                                    </span>
                                `;
                            }

                            let start = moment(data.start_date).format("DD-MM-YYYY");
                            let end   = moment(data.end_date).format("DD-MM-YYYY");

                            return `
                                ${start}
                                <br>
                                <small class="text-muted">s/d ${end}</small>
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

                                case "closed":
                                    return `<span class="badge badge-light-danger">Closed</span>`;

                                case "rejected":
                                    return `<span class="badge badge-light-dark">Rejected</span>`;

                                default:
                                    return "-";
                            }
                        }
                    },
                    {
                        data: "total_clicked",
                        className: "text-center",

                        render: function(data) {

                            return `
                                <span class="badge badge-light-info">

                                    <i class="fas fa-eye me-1"></i>

                                    ${data ?? 0}

                                </span>
                            `;
                        }
                    },
                    {
                        data: "applications_count",
                        className: "text-center",

                        render: function(data) {

                            return `
                                <span class="badge badge-light-primary">

                                    <i class="fas fa-users me-1"></i>

                                    ${data ?? 0}

                                </span>
                            `;
                        }
                    },
                    {
                        data: "bookmarks_count",
                        className: "text-center",

                        render: function(data) {

                            return `
                                <span class="badge badge-light-warning">

                                    <i class="fas fa-bookmark me-1"></i>

                                    ${data ?? 0}

                                </span>
                            `;
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        className: "text-end",

                        render: function(data) {

                            return `
                                <div class="d-flex justify-content-end gap-1">

                                    <!-- DETAIL -->
                                    <a
                                        href="/dashboard-admin/job-vacancy/${data.uuid}"
                                        class="btn btn-outline-info btn-sm"
                                        title="Detail"
                                        data-bs-toggle="tooltip">

                                        <i class="fas fa-eye"></i>

                                    </a>


                                    <!-- PELAMAR -->
                                    <a
                                        href="/dashboard-admin/job-application/${data.uuid}/applications"
                                        class="btn btn-outline-primary btn-sm"
                                        title="Lihat Pelamar"
                                        data-bs-toggle="tooltip">

                                        <i class="fas fa-users"></i>

                                    </a>

                                    <!-- HAPUS -->
                                    <button
                                        type="button"
                                        class="btn btn-outline-danger btn-sm btn-delete-job"
                                        data-uuid="${data.uuid}"
                                        title="Hapus Lowongan"
                                        data-bs-toggle="tooltip">

                                        <i class="fas fa-trash-alt"></i>

                                    </button>

                                </div>
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
    </script>
@endsection