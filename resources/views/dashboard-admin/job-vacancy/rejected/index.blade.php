@extends('layouts.dashboard-admin')

@section('title', 'Ditolak')

@section('css')
    <style>
        .job-category {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 6px 10px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 700;
            line-height: 1;
            white-space: nowrap;
        }

        .job-category.security {
            background: #edf5ff;
            color: #4d86cc;
        }

        .job-category.cs {
            background: #edf4f0;
            color: #3b765c;
        }

        .job-category.unknown {
            background: #f1f3f5;
            color: #6c757d;
        }
    </style>
@endsection

@section('breadcrumb')

    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
        Manajemen Lowongan
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
            Manajemen Lowongan
        </li>

        <li class="breadcrumb-item">
            <span class="bullet bg-gray-500 w-5px h-2px"></span>
        </li>

        <li class="breadcrumb-item text-muted">
            Ditolak
        </li>

    </ul>

@endsection

@section('content')

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
                        style="width: 1090px;"
                    >

                        <thead>

                            <tr>

                                <th width="1%">
                                    ID
                                </th>

                                <th>
                                    Category
                                </th>

                                <th>
                                    Posisi
                                </th>

                                <th>
                                    Perusahaan
                                </th>

                                <th>
                                    Lokasi
                                </th>

                                <th>
                                    Kuota
                                </th>

                                <th>
                                    Gaji
                                </th>

                                <th>
                                    Periode
                                </th>

                                <th>
                                    Status
                                </th>

                                <th>
                                    Dilihat
                                </th>

                                <th>
                                    Pelamar
                                </th>

                                <th>
                                    Simpan
                                </th>

                                <th class="text-end" width="5%">
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

@endsection

@section('js')

    <script>

        $(document).ready(function () {

            let currentDraw = 1;

            if ($.fn.DataTable.isDataTable('#datatable')) {
                $('#datatable').DataTable().destroy();
            }

            let table = $('#datatable').DataTable({

                processing: true,

                serverSide: true,

                scrollX: true,

                responsive: false,

                aLengthMenu: [
                    [10, 25, 50, 75, 999999],
                    [10, 25, 50, 75, "All"]
                ],

                ajax: {

                    url: '{{ route("dashboard-admin.job-vacancy.rejected.index") }}',

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

                    // =====================================================
                    // ID
                    // =====================================================

                    {
                        data: "id",

                        render: function (data) {

                            return ('000000' + data).slice(-6);
                        }
                    },

                    // =====================================================
                    // CATEGORY
                    // =====================================================

                    {
                        data: "category",

                        className: "text-center",

                        render: function (data) {

                            if (data === "security") {

                                return `
                                    <span class="job-category security">
                                        <i class="fas fa-shield-alt"></i>
                                        Satpam
                                    </span>
                                `;
                            }

                            if (data === "cs") {

                                return `
                                    <span class="job-category cs">
                                        <i class="fas fa-broom"></i>
                                        Cleaning Service
                                    </span>
                                `;
                            }

                            return `
                                <span class="job-category unknown">
                                    <i class="fas fa-question-circle"></i>
                                    -
                                </span>
                            `;
                        }
                    },

                    // =====================================================
                    // POSISI
                    // =====================================================

                    {
                        data: "position",

                        render: function (data) {

                            if (!data) {

                                return `
                                    <span class="badge badge-light-warning">
                                        Belum Diisi
                                    </span>
                                `;
                            }

                            return data;
                        }
                    },

                    // =====================================================
                    // PERUSAHAAN
                    // =====================================================

                    {
                        data: null,

                        render: function (data) {

                            let company = "-";

                            let badge = "badge-light-secondary";

                            let icon = "fa-building";

                            if (data.bujp) {

                                company = data.bujp.company_name;

                                badge = "badge-light-primary";
                            }

                            if (data.company) {

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

                    // =====================================================
                    // LOKASI
                    // =====================================================

                    {
                        data: null,

                        render: function (data) {

                            let lokasi = [];

                            if (data.city) {
                                lokasi.push(data.city);
                            }

                            if (data.province) {
                                lokasi.push(data.province);
                            }

                            if (lokasi.length === 0) {

                                return `
                                    <span class="badge badge-light-warning">
                                        Belum Diisi
                                    </span>
                                `;
                            }

                            return lokasi.join(", ");
                        }
                    },

                    // =====================================================
                    // KUOTA
                    // =====================================================

                    {
                        data: "kuota",

                        className: "text-center",

                        render: function (data) {

                            if (!data) {
                                return "-";
                            }

                            return data + " Orang";
                        }
                    },

                    // =====================================================
                    // GAJI
                    // =====================================================

                    {
                        data: null,

                        render: function (data) {

                            if (data.is_show_fee == 0) {

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
                                <small class="text-muted">
                                    ${type}
                                </small>
                            `;
                        }
                    },

                    // =====================================================
                    // PERIODE
                    // =====================================================

                    {
                        data: null,

                        render: function (data) {

                            if (!data.start_date || !data.end_date) {

                                return `
                                    <span class="badge badge-light-warning">
                                        Belum Diatur
                                    </span>
                                `;
                            }

                            let start = moment(data.start_date)
                                .format("DD-MM-YYYY");

                            let end = moment(data.end_date)
                                .format("DD-MM-YYYY");

                            return `
                                ${start}
                                <br>
                                <small class="text-muted">
                                    s/d ${end}
                                </small>
                            `;
                        }
                    },

                    // =====================================================
                    // STATUS
                    // =====================================================

                    {
                        data: "status",

                        className: "text-center",

                        render: function (data) {

                            switch (data) {

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

                                case "closed":

                                    return `
                                        <span class="badge badge-light-danger">
                                            Closed
                                        </span>
                                    `;

                                case "rejected":

                                    return `
                                        <span class="badge badge-light-dark">
                                            Rejected
                                        </span>
                                    `;

                                default:

                                    return "-";
                            }
                        }
                    },

                    // =====================================================
                    // DILIHAT
                    // =====================================================

                    {
                        data: "total_clicked",

                        render: function (data) {

                            return `
                                <span class="badge badge-light-info">
                                    ${data ?? 0}x
                                </span>
                            `;
                        }
                    },

                    // =====================================================
                    // PELAMAR
                    // =====================================================

                    {
                        data: "applications_count",

                        render: function (data) {

                            return `
                                <span class="badge badge-light-info">
                                    ${data ?? 0}x
                                </span>
                            `;
                        }
                    },

                    // =====================================================
                    // SIMPAN
                    // =====================================================

                    {
                        data: "bookmarks_count",

                        render: function (data) {

                            return `
                                <span class="badge badge-light-info">
                                    ${data ?? 0}x
                                </span>
                            `;
                        }
                    },

                    // =====================================================
                    // AKSI
                    // =====================================================

                    {
                        data: null,

                        orderable: false,

                        searchable: false,

                        className: "text-end",

                        render: function (data) {

                            return `
                                <a
                                    href="/dashboard-admin/job-vacancy/${data.uuid}"
                                    class="btn btn-outline-info btn-sm me-1"
                                    title="Detail"
                                >
                                    <i class="fas fa-eye"></i>
                                </a>
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

            table.buttons()
                .container()
                .appendTo('.card-button');

        });

    </script>

@endsection