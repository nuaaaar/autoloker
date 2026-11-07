@extends('layouts.dashboard-user')

@section('title', 'Lowongan Anda')

@section('css')

@endsection

@section('breadcrumb')

    <h1
        class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">

        Lowongan Anda

    </h1>

    <!--end::Title-->

    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">

        {{-- BERANDA --}}
        <li class="breadcrumb-item text-muted">

            <a
                href="{{ route('dashboard-user.index') }}"
                class="text-muted text-hover-primary">

                Beranda

            </a>

        </li>


        {{-- SEPARATOR --}}
        <li class="breadcrumb-item">

            <span class="bullet bg-gray-500 w-5px h-2px"></span>

        </li>


        {{-- LOWONGAN --}}
        <li class="breadcrumb-item text-muted">

            <a
                href="{{ route('dashboard-user.job-vacancy.index') }}?status=all"
                class="text-muted text-hover-primary">

                Lowongan Anda

            </a>

        </li>


        {{-- STATUS --}}
        @if(request('status'))

            <li class="breadcrumb-item">

                <span class="bullet bg-gray-500 w-5px h-2px"></span>

            </li>


            <li class="breadcrumb-item text-muted">

                @switch(request('status'))

                    @case('published')

                        Dipublikasikan

                        @break

                    @case('draft')

                        Draft

                        @break

                    @case('closed')

                        Ditutup

                        @break

                    @case('all')

                        Semua Lowongan

                        @break

                    @default

                        Lowongan

                @endswitch

            </li>

        @endif

    </ul>
    <!--end::Breadcrumb-->

@endsection


@section('content')

    <!--begin::Add Button-->
    <div class="row">

        <div class="col-lg-12">

            <a href="{{ route('dashboard-user.job-vacancy.create') }}">

                <button
                    type="button"
                    class="btn btn-primary py-2 mb-3"
                    style="float:right">

                    <i class="las la-plus me-1"></i>

                    Tambah

                </button>

            </a>

        </div>

    </div>
    <!--end::Add Button-->


    <!--begin::Table-->
    <div class="row">

        <div class="col-lg-12">

            <div class="card">

                <!--begin::Card Header-->
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
                <!--end::Card Header-->


                <!--begin::Card Body-->
                <div class="card-body">

                    <table
                        id="datatable"
                        class="table table-bordered dt-responsive nowrap w-100 dataTable no-footer dtr-inline"
                        aria-describedby="datatable_info"
                        style="width: 1090px;">

                        <thead>

                            <tr>

                                {{-- ID --}}
                                <th width="5%">
                                    ID
                                </th>

                                 {{-- CATEGORY --}}
                                <th width="8%">
                                    Category
                                </th>

                                {{-- POSISI --}}
                                <th>
                                    Posisi
                                </th>

                                {{-- LOKASI --}}
                                <th>
                                    Lokasi
                                </th>

                                {{-- KUOTA --}}
                                <th>
                                    Kuota
                                </th>

                                {{-- GAJI --}}
                                <th>
                                    Gaji
                                </th>

                                {{-- PERIODE --}}
                                <th>
                                    Periode
                                </th>

                                {{-- STATUS --}}
                                <th>
                                    Status
                                </th>

                                {{-- DILIHAT --}}
                                <th>
                                    Dilihat
                                </th>

                                {{-- PELAMAR --}}
                                <th>
                                    Pelamar
                                </th>

                                {{-- DISIMPAN --}}
                                <th>
                                    Disimpan
                                </th>

                                {{-- AKSI --}}
                                <th>
                                    Aksi
                                </th>

                            </tr>

                        </thead>

                        <tbody>
                        </tbody>

                    </table>

                </div>
                <!--end::Card Body-->

            </div>

        </div>

    </div>
    <!--end::Table-->


    <!--begin::Close Modal-->
    <div
        class="modal fade"
        id="closeModal"
        tabindex="-1">

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

                        <i
                            class="fas fa-lock text-warning"
                            style="font-size:60px">
                        </i>

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
    <!--end::Close Modal-->




    <!--begin::Delete Modal-->
    <div
        class="modal fade"
        tabindex="-1"
        role="dialog"
        id="deleteModal">

        <div
            class="modal-dialog"
            role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Hapus Lowongan
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
    <!--end::Delete Modal-->

@endsection


@section('js')

<script>

    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */

    function deleteData(uuid)
    {
        $("#deleteUuid").val(uuid);

        $("#deleteModal").modal("show");
    }


    $("#formDelete").submit(function(e){

        e.preventDefault();

        let uuid =
            $("#deleteUuid").val();


        $.ajax({

            url:
                "{{ route('dashboard-user.job-vacancy.index') }}"
                + "/" + uuid,

            type: "DELETE",

            data: {

                _token:
                    "{{ csrf_token() }}"

            },


            beforeSend: function(){

                $("#btn-submit-delete")
                    .prop("disabled", true)
                    .html("Menghapus...");

            },


            success: function(res){

                $("#deleteModal").modal("hide");


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


            error: function(xhr){

                Swal.fire({

                    icon: "error",

                    title: "Gagal",

                    text:
                        xhr.responseJSON?.message
                        ?? "Terjadi kesalahan."

                });

            },


            complete: function(){

                $("#btn-submit-delete")
                    .prop("disabled", false)
                    .html("Iya, Hapus");

            }

        });

    });


    /*
    |--------------------------------------------------------------------------
    | Close Vacancy
    |--------------------------------------------------------------------------
    */

    function closeVacancy(uuid)
    {
        $("#closeUuid").val(uuid);

        $("#closeModal").modal("show");
    }


    $("#btnCloseVacancy").click(function(){

        let uuid =
            $("#closeUuid").val();


        $.ajax({

            url:
                "/dashboard-user/job-vacancy/"
                + uuid
                + "/close-publication",

            type: "POST",

            data: {

                _token:
                    $('meta[name="csrf-token"]').attr("content")

            },


            beforeSend: function(){

                $("#btnCloseVacancy")
                    .prop("disabled", true)
                    .html(
                        '<span class="spinner-border spinner-border-sm me-2"></span>'
                        + 'Memproses...'
                    );

            },


            success: function(res){

                $("#closeModal").modal("hide");


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


            error: function(xhr){

                Swal.fire({

                    icon: "error",

                    title: "Gagal",

                    text:
                        xhr.responseJSON?.message
                        ?? "Terjadi kesalahan."

                });

            },


            complete: function(){

                $("#btnCloseVacancy")
                    .prop("disabled", false)
                    .html(
                        '<i class="fas fa-lock me-2"></i>'
                        + 'Tutup Lowongan'
                    );

            }

        });

    });


    /*
    |--------------------------------------------------------------------------
    | DataTable
    |--------------------------------------------------------------------------
    */

    $(document).ready(function() {

        let currentDraw = 1;


        if (
            $.fn.DataTable.isDataTable('#datatable')
        ) {

            $('#datatable')
                .DataTable()
                .destroy();

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

                url:
                    '{{ route("dashboard-user.job-vacancy.index") }}',

                type: 'GET',


                data: function (d) {

                    currentDraw =
                        d.draw;


                    d.page =
                        (d.start / d.length) + 1;


                    d.length =
                        d.length;


                    d.status =
                        "{{ request('status', 'all') }}";

                },


                dataFilter: function (response) {

                    let json =
                        JSON.parse(response);


                    return JSON.stringify({

                        draw:
                            currentDraw,

                        recordsTotal:
                            json.results.total,

                        recordsFiltered:
                            json.results.total,

                        data:
                            json.results.data

                    });

                }

            },


            columns: [

                /*
                |--------------------------------------------------------------------------
                | 2. ID
                |--------------------------------------------------------------------------
                */

                {

                    data: "id",

                    render: function(data) {

                        return (
                            '000000' + data
                        ).slice(-6);

                    }

                },

                /*
                |--------------------------------------------------------------------------
                | 1. CATEGORY
                |--------------------------------------------------------------------------
                */

                {

                    data: "category",

                    className: "text-center",

                    render: function(data) {

                        if (!data) {

                            return `
                                <span
                                    class="badge badge-light-secondary">

                                    -

                                </span>
                            `;

                        }


                        switch (
                            String(data).toLowerCase()
                        ) {

                            case "security":

                                return `
                                    <span
                                        class="badge badge-light-primary">

                                        <i
                                            class="fas fa-shield-alt me-1">
                                        </i>

                                        Satpam

                                    </span>
                                `;


                            case "cs":

                                return `
                                    <span
                                        class="badge badge-light-success">

                                        <i
                                            class="fas fa-broom me-1">
                                        </i>

                                        Cleaning Service

                                    </span>
                                `;


                            default:

                                return `
                                    <span
                                        class="badge badge-light-secondary">

                                        ${data}

                                    </span>
                                `;

                        }

                    }

                },


                /*
                |--------------------------------------------------------------------------
                | 3. POSISI
                |--------------------------------------------------------------------------
                */

                {

                    data: "position",

                    render: function(data) {

                        if (!data) {

                            return `
                                <span
                                    class="badge badge-light-warning">

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
                | 4. LOKASI
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


                        if (lokasi.length === 0) {

                            return `
                                <span
                                    class="badge badge-light-warning">

                                    Belum Diisi

                                </span>
                            `;

                        }


                        return `
                            <span>

                                <i
                                    class="fas fa-map-marker-alt text-muted me-1">
                                </i>

                                ${lokasi.join(", ")}

                            </span>
                        `;

                    }

                },


                /*
                |--------------------------------------------------------------------------
                | 5. KUOTA
                |--------------------------------------------------------------------------
                */

                {

                    data: "kuota",

                    className: "text-center",

                    render: function(data) {

                        if (!data) {

                            return "-";

                        }


                        return `
                            <span
                                class="badge badge-light-primary">

                                ${data} Orang

                            </span>
                        `;

                    }

                },


                /*
                |--------------------------------------------------------------------------
                | 6. GAJI
                |--------------------------------------------------------------------------
                */

                {

                    data: null,

                    render: function(data) {

                        if (
                            data.is_show_fee == 0
                        ) {

                            return `
                                <span
                                    class="badge badge-light-secondary">

                                    Dirahasiakan

                                </span>
                            `;

                        }


                        let formatter =
                            new Intl.NumberFormat('id-ID');


                        let min =
                            data.min_price
                                ? formatter.format(
                                    data.min_price
                                )
                                : "-";


                        let max =
                            data.max_price
                                ? formatter.format(
                                    data.max_price
                                )
                                : "-";


                        let type =
                            data.fee_type == "daily"
                                ? "/ Hari"
                                : "/ Bulan";


                        return `
                            <span class="fw-semibold">

                                Rp ${min} - ${max}

                            </span>

                            <br>

                            <small class="text-muted">

                                ${type}

                            </small>
                        `;

                    }

                },


                /*
                |--------------------------------------------------------------------------
                | 7. PERIODE
                |--------------------------------------------------------------------------
                */

                {
                    data: null,
                    render: function(data) {
                        if (!data.published_at) {
                            return '<span class="text-muted">Belum diterbitkan</span>';
                        }

                        const publishedAt = moment(data.published_at).format("DD-MM-YYYY HH:mm");
                        const expiresAt = data.publication_expires_at
                            ? moment(data.publication_expires_at).format("DD-MM-YYYY HH:mm")
                            : "Tidak tersedia";
                        const cost = Number(data.publication_token_cost || 0);
                        const costLabel = cost > 0 ? `${cost} token` : "Gratis transisi";

                        return `${publishedAt}<br><small class="text-muted">Berakhir ${expiresAt} · ${costLabel}</small>`;
                    }
                },


                /*
                |--------------------------------------------------------------------------
                | 8. STATUS
                |--------------------------------------------------------------------------
                */

                {

                    data: null,
                    className: "text-center",
                    render: function(data) {
                        if (data.status === "published"
                            && data.publication_expires_at
                            && new Date(data.publication_expires_at) <= new Date()) {
                            return '<span class="badge badge-light-secondary">Berakhir</span>';
                        }

                        const labels = {
                            draft: ["Draft", "secondary"],
                            published: ["Tayang", "success"],
                            closed: ["Ditutup", "danger"],
                            rejected: ["Ditolak", "dark"],
                            expired: ["Berakhir", "secondary"]
                        };
                        const [label, style] = labels[data.status] || ["-", "secondary"];
                        return `<span class="badge badge-light-${style}">${label}</span>`;
                    }
                },


                /*
                |--------------------------------------------------------------------------
                | 9. DILIHAT
                |--------------------------------------------------------------------------
                */

                {

                    data: "total_clicked",

                    className: "text-center",

                    render: function(data) {

                        return `
                            <span
                                class="badge badge-light-info">

                                <i
                                    class="fas fa-eye me-1">
                                </i>

                                ${data ?? 0}

                            </span>
                        `;

                    }

                },


                /*
                |--------------------------------------------------------------------------
                | 10. PELAMAR
                |--------------------------------------------------------------------------
                */

                {

                    data: "applications_count",

                    className: "text-center",

                    render: function(data, type, row) {

                        let total =
                            data ?? 0;


                        let reviewed =
                            row.reviewed_count ?? 0;


                        let shortlisted =
                            row.shortlisted_count ?? 0;


                        let rejected =
                            row.rejected_count ?? 0;


                        return `

                            <div
                                class="d-flex flex-column align-items-center">

                                <span
                                    class="badge badge-light-primary"
                                    title="Total Pelamar">

                                    <i
                                        class="fas fa-users me-1">
                                    </i>

                                    ${total}

                                </span>


                                <div class="mt-1">

                                    <small
                                        class="text-warning me-1"
                                        title="Reviewed">

                                        ${reviewed}
                                        Reviewed

                                    </small>


                                    <small
                                        class="text-success me-1"
                                        title="Shortlisted">

                                        ${shortlisted}
                                        Shortlisted

                                    </small>


                                    <small
                                        class="text-danger"
                                        title="Rejected">

                                        ${rejected}
                                        Rejected

                                    </small>

                                </div>

                            </div>

                        `;

                    }

                },


                /*
                |--------------------------------------------------------------------------
                | 11. DISIMPAN
                |--------------------------------------------------------------------------
                */

                {

                    data: "bookmarks_count",

                    className: "text-center",

                    render: function(data) {

                        return `
                            <span
                                class="badge badge-light-warning">

                                <i
                                    class="fas fa-bookmark me-1">
                                </i>

                                ${data ?? 0}

                            </span>
                        `;

                    }

                },


                /*
                |--------------------------------------------------------------------------
                | 12. AKSI
                |--------------------------------------------------------------------------
                */

                {

                    data: null,

                    orderable: false,

                    searchable: false,

                    className: "text-end",

                    render: function(data) {
                        const isCurrentlyPublished = data.status === "published"
                            && data.publication_expires_at
                            && new Date(data.publication_expires_at) > new Date();
                        const canPublish = !isCurrentlyPublished
                            && ["draft", "rejected", "closed", "expired", "published"].includes(data.status);

                        let action = `
                            <a href="/dashboard-user/job-vacancy/${data.uuid}" class="btn btn-outline-info btn-sm me-1" aria-label="Detail lowongan">Detail</a>
                            <a href="/dashboard-user/job-application/${data.uuid}/applicants" class="btn btn-outline-primary btn-sm me-1" aria-label="Lihat pelamar">Pelamar</a>
                        `;

                        if (!isCurrentlyPublished && ["draft", "rejected", "closed", "expired", "published"].includes(data.status)) {
                            action += `<a href="/dashboard-user/job-vacancy/${data.uuid}/edit" class="btn btn-outline-warning btn-sm me-1">Edit</a>`;
                        }

                        if (isCurrentlyPublished) {
                            action += `<button type="button" class="btn btn-outline-secondary btn-sm me-1" onclick="closeVacancy('${data.uuid}')">Hentikan masa tayang</button>`;
                        } else if (canPublish) {
                            action += `<form method="POST" action="/dashboard-user/job-vacancy/${data.uuid}/publish" class="d-inline"><input type="hidden" name="_token" value="{{ csrf_token() }}"><button type="submit" class="btn btn-warning btn-sm">Terbitkan</button></form>`;
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


            /*
            |--------------------------------------------------------------------------
            | DRAW CALLBACK
            |--------------------------------------------------------------------------
            */

            drawCallback: function() {

                $('[data-bs-toggle="tooltip"]')
                    .tooltip();

            }

        });


        /*
        |--------------------------------------------------------------------------
        | Append DataTable Buttons
        |--------------------------------------------------------------------------
        */

        table
            .buttons()
            .container()
            .appendTo('.card-button');

    });

</script>

@endsection