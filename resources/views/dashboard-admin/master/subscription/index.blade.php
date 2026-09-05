@extends('layouts.dashboard-admin')

@section('title', 'Subscription')

@section('css')

<style>

    .badge-role {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .badge-security {
        background: rgba(13, 110, 253, .12);
        color: #0d6efd;
    }

    .badge-bujp {
        background: rgba(255, 193, 7, .15);
        color: #ffc107;
    }

    .badge-client {
        background: rgba(25, 135, 84, .12);
        color: #198754;
    }

    .badge-active {
        padding: 5px 10px;
        border-radius: 20px;
        background: rgba(25, 135, 84, .12);
        color: #198754;
        font-size: 11px;
        font-weight: 600;
    }

    .badge-inactive {
        padding: 5px 10px;
        border-radius: 20px;
        background: rgba(220, 53, 69, .12);
        color: #dc3545;
        font-size: 11px;
        font-weight: 600;
    }

    .feature-item,
    .edit-feature-item {
        background: var(--bs-tertiary-bg);
        border-color: var(--bs-border-color) !important;
    }

    .feature-item .form-label,
    .edit-feature-item .form-label {
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 6px;
    }

    .btn-remove-feature,
    .btn-remove-edit-feature {
        height: 38px;
    }

</style>

@endsection


@section('breadcrumb')

    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
        Subscription
    </h1>

    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">

        <li class="breadcrumb-item text-muted">

            <a
                href="javascript:;"
                class="text-muted text-hover-primary">

                Beranda

            </a>

        </li>

        <li class="breadcrumb-item">

            <span class="bullet bg-gray-500 w-5px h-2px"></span>

        </li>

        <li class="breadcrumb-item text-muted">

            Master

        </li>

        <li class="breadcrumb-item">

            <span class="bullet bg-gray-500 w-5px h-2px"></span>

        </li>

        <li class="breadcrumb-item text-muted">

            Subscription

        </li>

    </ul>

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
                    class="table table-bordered dt-responsive nowrap w-100">

                    <thead>

                        <tr>

                            <th width="1%">
                                ID
                            </th>

                            <th>
                                Nama
                            </th>

                            <th>
                                Role
                            </th>

                            <th>
                                Harga
                            </th>

                            <th>
                                Durasi
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Urutan
                            </th>

                            <th
                                width="5%"
                                class="text-end">

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


{{-- ========================================================= --}}
{{-- CREATE MODAL --}}
{{-- ========================================================= --}}

<div
    class="modal fade"
    id="createModal"
    tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form id="formCreate">

                @csrf

                <div class="modal-header">

                    <h5 class="modal-title">
                        Tambah Subscription
                    </h5>

                    <button
                        class="btn-close"
                        data-bs-dismiss="modal"
                        type="button">
                    </button>

                </div>


                <div class="modal-body">

                    <div class="row">

                        {{-- NAMA --}}

                        <div class="col-md-6 mb-4">

                            <label class="form-label required">
                                Nama Subscription
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                name="name"
                                placeholder="Contoh: Premium"
                                required>

                        </div>


                        {{-- ROLE --}}

                        <div class="col-md-6 mb-4">

                            <label class="form-label required">
                                Role
                            </label>

                            <select
                                class="form-select"
                                name="role"
                                required>

                                <option value="">
                                    Pilih Role
                                </option>

                                <option value="security">
                                    Satpam
                                </option>

                                <option value="bujp">
                                    BUJP
                                </option>

                                <option value="client">
                                    Perusahaan
                                </option>

                            </select>

                        </div>


                        {{-- HARGA --}}

                        <div class="col-md-6 mb-4">

                            <label class="form-label required">
                                Harga
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    Rp
                                </span>

                                <input
                                    type="number"
                                    class="form-control"
                                    name="price"
                                    min="0"
                                    step="0.01"
                                    value="0"
                                    required>

                            </div>

                        </div>


                        {{-- DURASI --}}

                        <div class="col-md-3 mb-4">

                            <label class="form-label required">
                                Durasi
                            </label>

                            <input
                                type="number"
                                class="form-control"
                                name="duration"
                                min="1"
                                value="30"
                                required>

                        </div>


                        {{-- TIPE DURASI --}}

                        <div class="col-md-3 mb-4">

                            <label class="form-label required">
                                Tipe
                            </label>

                            <select
                                class="form-select"
                                name="duration_type"
                                required>

                                <option value="day">
                                    Hari
                                </option>

                                <option
                                    value="month"
                                    selected>

                                    Bulan

                                </option>

                                <option value="year">
                                    Tahun
                                </option>

                            </select>

                        </div>


                        {{-- URUTAN --}}

                        <div class="col-md-6 mb-4">

                            <label class="form-label">
                                Urutan
                            </label>

                            <input
                                type="number"
                                class="form-control"
                                name="sort_order"
                                min="0"
                                value="0">

                        </div>


                        {{-- STATUS --}}

                        <div class="col-md-6 mb-4">

                            <label class="form-label">
                                Status
                            </label>

                            <div class="form-check form-switch mt-3">

                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="is_active"
                                    value="1"
                                    checked>

                                <label class="form-check-label">
                                    Aktif
                                </label>

                            </div>

                        </div>


                        {{-- DESKRIPSI --}}

                        <div class="col-md-12 mb-4">

                            <label class="form-label">
                                Deskripsi
                            </label>

                            <textarea
                                class="form-control"
                                name="description"
                                rows="4"
                                placeholder="Deskripsi subscription..."></textarea>

                        </div>


                        {{-- FEATURES --}}

                        <div class="col-md-12">

                            <label class="form-label">
                                Features
                            </label>

                            <div id="features-wrapper">

                                <div class="feature-item border rounded p-3 mb-3">

                                    <div class="row g-3 align-items-end">

                                        <div class="col-md-6">

                                            <label class="form-label">
                                                Nama Feature
                                            </label>

                                            <input
                                                type="text"
                                                class="form-control feature-name"
                                                placeholder="Contoh: Job Vacancy">

                                        </div>


                                        <div class="col-md-4">

                                            <label class="form-label">
                                                Limit
                                            </label>

                                            <input
                                                type="number"
                                                class="form-control feature-limit"
                                                min="0"
                                                placeholder="Contoh: 10">

                                        </div>


                                        <div class="col-md-2">

                                            <button
                                                type="button"
                                                class="btn btn-light-danger w-100 btn-remove-feature">

                                                <i class="fas fa-trash"></i>

                                            </button>

                                        </div>

                                    </div>

                                </div>

                            </div>


                            <button
                                type="button"
                                class="btn btn-sm btn-light-primary"
                                id="btn-add-feature">

                                <i class="fas fa-plus me-1"></i>

                                Tambah Feature

                            </button>


                            <textarea
                                name="features"
                                id="features"
                                class="d-none"></textarea>


                            <div class="form-text">

                                Tambahkan fitur dan batas penggunaan
                                untuk paket subscription.

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


{{-- ========================================================= --}}
{{-- EDIT MODAL --}}
{{-- ========================================================= --}}

<div
    class="modal fade"
    id="editModal"
    tabindex="-1">

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
                        Edit Subscription
                    </h5>

                    <button
                        class="btn-close"
                        data-bs-dismiss="modal"
                        type="button">
                    </button>

                </div>


                <div class="modal-body">

                    <div class="row">

                        {{-- NAMA --}}

                        <div class="col-md-6 mb-4">

                            <label class="form-label required">
                                Nama Subscription
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="edit_name"
                                name="name"
                                required>

                        </div>


                        {{-- ROLE --}}

                        <div class="col-md-6 mb-4">

                            <label class="form-label required">
                                Role
                            </label>

                            <select
                                class="form-select"
                                id="edit_role"
                                name="role"
                                required>

                                <option value="security">
                                    Satpam
                                </option>

                                <option value="bujp">
                                    BUJP
                                </option>

                                <option value="client">
                                    Perusahaan
                                </option>

                            </select>

                        </div>


                        {{-- HARGA --}}

                        <div class="col-md-6 mb-4">

                            <label class="form-label required">
                                Harga
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    Rp
                                </span>

                                <input
                                    type="number"
                                    class="form-control"
                                    id="edit_price"
                                    name="price"
                                    min="0"
                                    step="0.01"
                                    required>

                            </div>

                        </div>


                        {{-- DURASI --}}

                        <div class="col-md-3 mb-4">

                            <label class="form-label required">
                                Durasi
                            </label>

                            <input
                                type="number"
                                class="form-control"
                                id="edit_duration"
                                name="duration"
                                min="1"
                                required>

                        </div>


                        {{-- TIPE --}}

                        <div class="col-md-3 mb-4">

                            <label class="form-label required">
                                Tipe
                            </label>

                            <select
                                class="form-select"
                                id="edit_duration_type"
                                name="duration_type"
                                required>

                                <option value="day">
                                    Hari
                                </option>

                                <option value="month">
                                    Bulan
                                </option>

                                <option value="year">
                                    Tahun
                                </option>

                            </select>

                        </div>


                        {{-- URUTAN --}}

                        <div class="col-md-6 mb-4">

                            <label class="form-label">
                                Urutan
                            </label>

                            <input
                                type="number"
                                class="form-control"
                                id="edit_sort_order"
                                name="sort_order"
                                min="0">

                        </div>


                        {{-- STATUS --}}

                        <div class="col-md-6 mb-4">

                            <label class="form-label">
                                Status
                            </label>

                            <div class="form-check form-switch mt-3">

                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="edit_is_active"
                                    name="is_active"
                                    value="1">

                                <label class="form-check-label">
                                    Aktif
                                </label>

                            </div>

                        </div>


                        {{-- DESKRIPSI --}}

                        <div class="col-md-12 mb-4">

                            <label class="form-label">
                                Deskripsi
                            </label>

                            <textarea
                                class="form-control"
                                id="edit_description"
                                name="description"
                                rows="4"></textarea>

                        </div>


                        {{-- FEATURES --}}

                        <div class="col-md-12">

                            <label class="form-label">
                                Features
                            </label>

                            <div id="edit_features_wrapper"></div>


                            <button
                                type="button"
                                class="btn btn-sm btn-light-primary"
                                id="btn-add-edit-feature">

                                <i class="fas fa-plus me-1"></i>

                                Tambah Feature

                            </button>


                            <textarea
                                name="features"
                                id="edit_features"
                                class="d-none"></textarea>


                            <div class="form-text">

                                Tambahkan fitur dan batas penggunaan
                                untuk paket subscription.

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
                        class="btn btn-primary"
                        type="submit">

                        Update

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- DELETE MODAL --}}
{{-- ========================================================= --}}

<div
    class="modal fade"
    tabindex="-1"
    id="deleteModal">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    Hapus Subscription
                </h5>

                <button
                    class="btn-close"
                    type="button"
                    data-bs-dismiss="modal">
                </button>

            </div>


            <div class="modal-body">

                <p>
                    Tindakan ini akan menghapus data dan data
                    yang dihapus tidak dapat dipulihkan,
                    yakin ingin melanjutkan?
                </p>

            </div>


            <div class="modal-footer">

                <form
                    action=""
                    method="post"
                    id="formDelete">

                    @csrf

                    @method('DELETE')

                    <input
                        type="hidden"
                        id="deleteUuid">


                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal">

                        Tutup

                    </button>


                    <button
                        type="submit"
                        class="btn btn-danger"
                        id="btn-submit-delete">

                        Iya, Hapus

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection


@section('js')

<script>

    $(document).ready(function () {

        let currentDraw = 1;


        /*
        |--------------------------------------------------------------------------
        | DATATABLE
        |--------------------------------------------------------------------------
        */

        if ($.fn.DataTable.isDataTable('#datatable')) {

            $('#datatable')
                .DataTable()
                .destroy();

        }


        let table = $('#datatable').DataTable({

            processing: true,

            serverSide: true,

            scrollX: true,


            aLengthMenu: [
                [10, 25, 50, 75, 999999],
                [10, 25, 50, 75, "All"]
            ],


            ajax: {

                url: '{{ route("dashboard-admin.master.subscription.index") }}',

                type: 'GET',


                data: function (d) {

                    currentDraw = d.draw;

                    d.page =
                        (d.start / d.length) + 1;

                },


                dataFilter: function (response) {

                    let json =
                        JSON.parse(response);


                    return JSON.stringify({

                        draw: currentDraw,

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

                {
                    data: "id",

                    render: function (data) {

                        return (
                            '000000' + data
                        ).slice(-6);

                    }

                },


                {
                    data: "name",

                    render: function (data) {

                        return `
                            <span class="fw-semibold">
                                ${data ?? '-'}
                            </span>
                        `;

                    }

                },


                {
                    data: "role",

                    render: function (data) {

                        let label = data ?? '-';

                        let className =
                            'badge-role badge-' +
                            (data ?? '');


                        if (data === 'security') {
                            label = 'Satpam';
                        }

                        if (data === 'bujp') {
                            label = 'BUJP';
                        }

                        if (data === 'client') {
                            label = 'Perusahaan';
                        }


                        return `
                            <span class="${className}">
                                ${label}
                            </span>
                        `;

                    }

                },


                {
                    data: "price",

                    render: function (data) {

                        let price =
                            Number(data || 0);


                        return new Intl.NumberFormat(
                            'id-ID',
                            {
                                style: 'currency',
                                currency: 'IDR',
                                minimumFractionDigits: 0
                            }
                        ).format(price);

                    }

                },


                {
                    data: "duration",

                    render: function (data, type, row) {

                        let duration =
                            data ?? 0;

                        let label =
                            row.duration_type ?? '';


                        if (
                            row.duration_type === 'day'
                        ) {

                            label = 'Hari';

                        }

                        if (
                            row.duration_type === 'month'
                        ) {

                            label = 'Bulan';

                        }

                        if (
                            row.duration_type === 'year'
                        ) {

                            label = 'Tahun';

                        }


                        return `
                            ${duration}
                            ${label}
                        `;

                    }

                },


                {
                    data: "is_active",

                    render: function (data) {

                        if (
                            data == 1 ||
                            data === true ||
                            data === "1"
                        ) {

                            return `
                                <span class="badge-active">
                                    Aktif
                                </span>
                            `;

                        }


                        return `
                            <span class="badge-inactive">
                                Non Aktif
                            </span>
                        `;

                    }

                },


                {
                    data: "sort_order",

                    className: "text-center"

                },


                {
                    data: null,

                    orderable: false,

                    searchable: false,

                    className: "text-end",


                    render: function (data) {

                        return `

                            <button
                                class="btn btn-outline-primary btn-sm me-1"
                                onclick='editData(${JSON.stringify(data)})'>

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


            drawCallback: function () {

                $('[data-bs-toggle="tooltip"]')
                    .tooltip();

            }

        });


        table
            .buttons()
            .container()
            .appendTo('.card-button');


        /*
        |--------------------------------------------------------------------------
        | CREATE
        |--------------------------------------------------------------------------
        */

        $("#formCreate").submit(function (e) {

            e.preventDefault();


            buildFeatures();


            $.ajax({

                url:
                    "{{ route('dashboard-admin.master.subscription.store') }}",

                type: "POST",

                data:
                    $(this).serialize(),


                success: function (res) {

                    $("#createModal")
                        .modal("hide");


                    $("#formCreate")[0]
                        .reset();


                    resetCreateFeatures();


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


                error: function (xhr) {

                    showAjaxError(xhr);

                }

            });

        });


        /*
        |--------------------------------------------------------------------------
        | EDIT
        |--------------------------------------------------------------------------
        */

        $("#formEdit").submit(function (e) {

            e.preventDefault();


            let uuid =
                $("#edit_uuid").val();


            /*
            | Build JSON Features terlebih dahulu
            */

            buildEditFeatures();


            $.ajax({

                url:
                    "{{ route('dashboard-admin.master.subscription.index') }}/"
                    + uuid,

                type: "POST",

                data: {

                    _token:
                        "{{ csrf_token() }}",

                    _method:
                        "PUT",

                    name:
                        $("#edit_name").val(),

                    role:
                        $("#edit_role").val(),

                    price:
                        $("#edit_price").val(),

                    duration:
                        $("#edit_duration").val(),

                    duration_type:
                        $("#edit_duration_type").val(),

                    description:
                        $("#edit_description").val(),

                    features:
                        $("#edit_features").val(),

                    is_active:
                        $("#edit_is_active").is(':checked')
                            ? 1
                            : 0,

                    sort_order:
                        $("#edit_sort_order").val()

                },


                success: function (res) {

                    $("#editModal")
                        .modal("hide");


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


                error: function (xhr) {

                    showAjaxError(xhr);

                }

            });

        });


        /*
        |--------------------------------------------------------------------------
        | DELETE
        |--------------------------------------------------------------------------
        */

        $("#formDelete").submit(function (e) {

            e.preventDefault();


            let uuid =
                $("#deleteUuid").val();


            $.ajax({

                url:
                    "{{ route('dashboard-admin.master.subscription.index') }}/"
                    + uuid,

                type: "DELETE",

                data: {

                    _token:
                        "{{ csrf_token() }}"

                },


                beforeSend: function () {

                    $("#btn-submit-delete")
                        .prop("disabled", true)
                        .html("Menghapus...");

                },


                success: function (res) {

                    $("#deleteModal")
                        .modal("hide");


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


                error: function (xhr) {

                    showAjaxError(xhr);

                },


                complete: function () {

                    $("#btn-submit-delete")
                        .prop("disabled", false)
                        .html("Iya, Hapus");

                }

            });

        });


        /*
        |--------------------------------------------------------------------------
        | TAMBAH FEATURE CREATE
        |--------------------------------------------------------------------------
        */

        $('#btn-add-feature').on('click', function () {

            addFeature();

        });


        /*
        |--------------------------------------------------------------------------
        | TAMBAH FEATURE EDIT
        |--------------------------------------------------------------------------
        */

        $('#btn-add-edit-feature').on('click', function () {

            addEditFeature();

        });


        /*
        |--------------------------------------------------------------------------
        | HAPUS FEATURE CREATE
        |--------------------------------------------------------------------------
        */

        $(document).on(
            'click',
            '.btn-remove-feature',
            function () {

                $(this)
                    .closest('.feature-item')
                    .remove();

            }
        );


        /*
        |--------------------------------------------------------------------------
        | HAPUS FEATURE EDIT
        |--------------------------------------------------------------------------
        */

        $(document).on(
            'click',
            '.btn-remove-edit-feature',
            function () {

                $(this)
                    .closest('.edit-feature-item')
                    .remove();

            }
        );


        /*
        |--------------------------------------------------------------------------
        | RESET CREATE MODAL
        |--------------------------------------------------------------------------
        */

        $('#createModal').on(
            'hidden.bs.modal',
            function () {

                resetCreateFeatures();

            }
        );

    });


    /*
    |--------------------------------------------------------------------------
    | EDIT DATA
    |--------------------------------------------------------------------------
    */

    function editData(data)
    {
        $("#edit_uuid")
            .val(data.uuid);


        $("#edit_name")
            .val(data.name);


        $("#edit_role")
            .val(data.role);


        $("#edit_price")
            .val(data.price);


        $("#edit_duration")
            .val(data.duration);


        $("#edit_duration_type")
            .val(data.duration_type);


        $("#edit_description")
            .val(data.description);


        $("#edit_sort_order")
            .val(data.sort_order);


        $("#edit_is_active")
            .prop(
                "checked",
                data.is_active == 1 ||
                data.is_active === true ||
                data.is_active === "1"
            );


        /*
        |--------------------------------------------------------------------------
        | LOAD FEATURES
        |--------------------------------------------------------------------------
        */

        loadEditFeatures(
            data.features
        );


        $("#editModal")
            .modal("show");
    }


    /*
    |--------------------------------------------------------------------------
    | ADD FEATURE
    |--------------------------------------------------------------------------
    */

    function addFeature(
        name = '',
        limit = ''
    ) {

        const html = `

            <div class="feature-item border rounded p-3 mb-3">

                <div class="row g-3 align-items-end">

                    <div class="col-md-6">

                        <label class="form-label">
                            Nama Feature
                        </label>

                        <input
                            type="text"
                            class="form-control feature-name"
                            value="${escapeHtml(name)}"
                            placeholder="Contoh: Job Vacancy">

                    </div>


                    <div class="col-md-4">

                        <label class="form-label">
                            Limit
                        </label>

                        <input
                            type="number"
                            class="form-control feature-limit"
                            value="${limit}"
                            min="0"
                            placeholder="Contoh: 10">

                    </div>


                    <div class="col-md-2">

                        <button
                            type="button"
                            class="btn btn-light-danger w-100 btn-remove-feature">

                            <i class="fas fa-trash"></i>

                        </button>

                    </div>

                </div>

            </div>

        `;


        $('#features-wrapper')
            .append(html);
    }


    /*
    |--------------------------------------------------------------------------
    | BUILD FEATURES CREATE
    |--------------------------------------------------------------------------
    */

    function buildFeatures()
    {
        const features = {};


        $('.feature-item').each(function () {

            const name =
                $(this)
                    .find('.feature-name')
                    .val()
                    .trim();


            const limit =
                $(this)
                    .find('.feature-limit')
                    .val();


            if (!name) {
                return;
            }


            const key =
                makeFeatureKey(name);


            if (!key) {
                return;
            }


            features[key] = {

                enabled: true,

                limit:
                    limit !== ''
                        ? parseInt(limit)
                        : 0

            };

        });


        $('#features')
            .val(
                JSON.stringify(features)
            );
    }


    /*
    |--------------------------------------------------------------------------
    | LOAD FEATURES EDIT
    |--------------------------------------------------------------------------
    */

    function loadEditFeatures(features)
    {
        $('#edit_features_wrapper').empty();

        /*
        |--------------------------------------------------------------------------
        | Jika kosong
        |--------------------------------------------------------------------------
        */

        if (!features) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Jika masih berupa JSON STRING
        |--------------------------------------------------------------------------
        */

        if (typeof features === 'string') {

            try {

                features = JSON.parse(features);

            } catch (e) {

                console.error(
                    'Features JSON tidak valid:',
                    e
                );

                return;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Pastikan hasil akhirnya object
        |--------------------------------------------------------------------------
        */

        if (
            typeof features !== 'object' ||
            Array.isArray(features)
        ) {

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Tampilkan setiap feature
        |--------------------------------------------------------------------------
        */

        Object.keys(features).forEach(function (key) {

            const feature = features[key];


            /*
            |--------------------------------------------------------------------------
            | job_vacancy
            | menjadi
            | Job Vacancy
            |--------------------------------------------------------------------------
            */

            let name = key
                .replace(/_/g, ' ')
                .replace(/\b\w/g, function (letter) {
                    return letter.toUpperCase();
                });


            let limit = '';


            /*
            |--------------------------------------------------------------------------
            | Ambil limit
            |--------------------------------------------------------------------------
            */

            if (
                feature &&
                typeof feature === 'object'
            ) {

                limit = feature.limit ?? '';

            }


            /*
            |--------------------------------------------------------------------------
            | Tambahkan ke repeater
            |--------------------------------------------------------------------------
            */

            addEditFeature(
                name,
                limit
            );

        });
    }


    /*
    |--------------------------------------------------------------------------
    | ADD FEATURE EDIT
    |--------------------------------------------------------------------------
    */

    function addEditFeature(
        name = '',
        limit = ''
    ) {

        const html = `

            <div class="edit-feature-item border rounded p-3 mb-3">

                <div class="row g-3 align-items-end">

                    <div class="col-md-6">

                        <label class="form-label">
                            Nama Feature
                        </label>

                        <input
                            type="text"
                            class="form-control edit-feature-name"
                            value="${escapeHtml(name)}"
                            placeholder="Contoh: Job Vacancy">

                    </div>


                    <div class="col-md-4">

                        <label class="form-label">
                            Limit
                        </label>

                        <input
                            type="number"
                            class="form-control edit-feature-limit"
                            value="${limit}"
                            min="0"
                            placeholder="Contoh: 10">

                    </div>


                    <div class="col-md-2">

                        <button
                            type="button"
                            class="btn btn-light-danger w-100 btn-remove-edit-feature">

                            <i class="fas fa-trash"></i>

                        </button>

                    </div>

                </div>

            </div>

        `;


        $('#edit_features_wrapper')
            .append(html);
    }


    /*
    |--------------------------------------------------------------------------
    | BUILD FEATURES EDIT
    |--------------------------------------------------------------------------
    */

    function buildEditFeatures()
    {
        const features = {};


        $('.edit-feature-item').each(function () {

            const name =
                $(this)
                    .find('.edit-feature-name')
                    .val()
                    .trim();


            const limit =
                $(this)
                    .find('.edit-feature-limit')
                    .val();


            if (!name) {
                return;
            }


            const key =
                makeFeatureKey(name);


            if (!key) {
                return;
            }


            features[key] = {

                enabled: true,

                limit:
                    limit !== ''
                        ? parseInt(limit)
                        : 0

            };

        });


        $('#edit_features')
            .val(
                JSON.stringify(features)
            );
    }


    /*
    |--------------------------------------------------------------------------
    | MAKE FEATURE KEY
    |--------------------------------------------------------------------------
    */

    function makeFeatureKey(name)
    {
        return name
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, '_')
            .replace(/^_+|_+$/g, '');
    }


    /*
    |--------------------------------------------------------------------------
    | RESET CREATE FEATURES
    |--------------------------------------------------------------------------
    */

    function resetCreateFeatures()
    {
        $('#features-wrapper')
            .empty();


        addFeature();


        $('#features')
            .val('');
    }


    /*
    |--------------------------------------------------------------------------
    | ESCAPE HTML
    |--------------------------------------------------------------------------
    */

    function escapeHtml(value)
    {
        if (
            value === null ||
            value === undefined
        ) {

            return '';

        }


        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }


    /*
    |--------------------------------------------------------------------------
    | AJAX ERROR
    |--------------------------------------------------------------------------
    */

    function showAjaxError(xhr)
    {
        let message =
            xhr.responseJSON?.message
            ??
            "Terjadi kesalahan.";


        if (
            xhr.responseJSON?.errors
        ) {

            message =
                Object.values(
                    xhr.responseJSON.errors
                )
                .flat()
                .join('<br>');

        }


        Swal.fire({

            icon: "error",

            title: "Gagal",

            html: message

        });
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE DATA
    |--------------------------------------------------------------------------
    */

    function deleteData(uuid)
    {
        $("#deleteUuid")
            .val(uuid);


        $("#deleteModal")
            .modal("show");
    }

</script>

@endsection