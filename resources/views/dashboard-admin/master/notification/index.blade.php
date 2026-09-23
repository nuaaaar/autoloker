@extends('layouts.dashboard-admin')

@section('title', 'Notifikasi')

@section('css')

<style>

    .notification-template {
        min-height: 100px;
        resize: vertical;
    }

    .notification-help {
        font-size: 11px;
        color: #8b98b5;
        margin-top: 5px;
    }

    .channel-box {
        border: 1px solid #e1e3ea;
        border-radius: 8px;
        padding: 12px;
    }

    .channel-box .form-check {
        margin-bottom: 8px;
    }

    .channel-box .form-check:last-child {
        margin-bottom: 0;
    }

</style>

@endsection


@section('breadcrumb')

    <h1
        class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">

        Notifikasi

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

            Notifikasi

        </li>

    </ul>

@endsection


@section('content')


{{-- ========================================================= --}}
{{-- BUTTON TAMBAH --}}
{{-- ========================================================= --}}

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



{{-- ========================================================= --}}
{{-- TABLE --}}
{{-- ========================================================= --}}

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
                    style="width:100%;">

                    <thead>

                        <tr>

                            <th width="1%">
                                ID
                            </th>

                            <th>
                                Kode
                            </th>

                            <th>
                                Nama
                            </th>

                            <th>
                                Kategori
                            </th>

                            <th>
                                Dashboard
                            </th>

                            <th>
                                Channel
                            </th>

                            <th>
                                Status
                            </th>

                            <th
                                class="text-end"
                                width="5%">

                                Aksi

                            </th>

                        </tr>

                    </thead>


                    <tbody></tbody>

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

    <div class="modal-dialog modal-xl">

        <div class="modal-content">

            <form id="formCreate">

                @csrf


                <div class="modal-header">

                    <h5 class="modal-title">

                        Tambah Notifikasi

                    </h5>


                    <button
                        class="btn-close"
                        data-bs-dismiss="modal"
                        type="button">
                    </button>

                </div>


                <div class="modal-body">

                    <div class="row g-5">


                        {{-- LEFT --}}
                        <div class="col-lg-6">

                            <h6 class="fw-bold mb-4">
                                Informasi Notifikasi
                            </h6>


                            <div class="mb-4">

                                <label class="form-label required">

                                    Kode Event

                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    name="code"
                                    id="create_code"
                                    placeholder="JOB_APPLICATION_SUBMITTED"
                                    required>

                                <div class="notification-help">

                                    Gunakan huruf kapital,
                                    angka dan underscore.

                                </div>

                            </div>


                            <div class="mb-4">

                                <label class="form-label required">

                                    Nama Notifikasi

                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    name="name"
                                    id="create_name"
                                    placeholder="Lamaran Berhasil Dikirim"
                                    required>

                            </div>


                            <div class="mb-4">

                                <label class="form-label required">

                                    Kategori

                                </label>

                                <select
                                    class="form-select"
                                    name="category"
                                    id="create_category"
                                    required>

                                    <option value="">
                                        Pilih Kategori
                                    </option>

                                    <option value="job">
                                        Job
                                    </option>

                                    <option value="training">
                                        Training
                                    </option>

                                    <option value="network">
                                        Network
                                    </option>

                                    <option value="certificate">
                                        Certificate
                                    </option>

                                    <option value="subscription">
                                        Subscription
                                    </option>

                                    <option value="system">
                                        System
                                    </option>

                                </select>

                            </div>


                            <div class="mb-4">

                                <label class="form-label">

                                    Deskripsi

                                </label>

                                <textarea
                                    class="form-control"
                                    name="description"
                                    id="create_description"
                                    rows="3"
                                    placeholder="Penjelasan fungsi notifikasi">
                                </textarea>

                            </div>


                            <div class="mb-4">

                                <label class="form-label required">

                                    Judul Template

                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    name="title_template"
                                    id="create_title_template"
                                    placeholder="Lamaran {job_title} berhasil dikirim"
                                    required>

                                <div class="notification-help">

                                    Contoh variable:
                                    {job_title},
                                    {company_name}

                                </div>

                            </div>


                            <div class="mb-4">

                                <label class="form-label required">

                                    Pesan Template

                                </label>

                                <textarea
                                    class="form-control notification-template"
                                    name="message_template"
                                    id="create_message_template"
                                    rows="5"
                                    placeholder="Lamaran Anda untuk posisi {job_title} di {company_name} berhasil dikirim."
                                    required>
                                </textarea>

                            </div>

                        </div>



                        {{-- RIGHT --}}
                        <div class="col-lg-6">

                            <h6 class="fw-bold mb-4">
                                Routing & Channel
                            </h6>


                            <div class="mb-4">

                                <label class="form-label">

                                    Dashboard Route

                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    name="dashboard_route"
                                    id="create_dashboard_route"
                                    placeholder="user-page.job-vacancy.show">

                                <div class="notification-help">

                                    Gunakan nama route Laravel,
                                    bukan URL.

                                </div>

                            </div>


                            <div class="mb-4">

                                <label class="form-label">

                                    Flutter Route

                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    name="flutter_route"
                                    id="create_flutter_route"
                                    placeholder="job_vacancy_detail">

                            </div>


                            <div class="mb-4">

                                <label class="form-label">

                                    Email Subject

                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    name="email_subject"
                                    id="create_email_subject"
                                    placeholder="Lamaran Anda berhasil dikirim">

                            </div>


                            <div class="mb-4">

                                <label class="form-label">

                                    Email Template

                                </label>

                                <textarea
                                    class="form-control notification-template"
                                    name="email_template"
                                    id="create_email_template"
                                    rows="5"
                                    placeholder="Gunakan variable yang sama seperti message template.">
                                </textarea>

                            </div>


                            <div class="mb-4">

                                <label class="form-label">

                                    Channel

                                </label>


                                <div class="channel-box">

                                    <div class="form-check">

                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="web_enabled"
                                            value="1"
                                            id="create_web_enabled"
                                            checked>

                                        <label
                                            class="form-check-label"
                                            for="create_web_enabled">

                                            Dashboard / Web

                                        </label>

                                    </div>


                                    <div class="form-check">

                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="mobile_enabled"
                                            value="1"
                                            id="create_mobile_enabled"
                                            checked>

                                        <label
                                            class="form-check-label"
                                            for="create_mobile_enabled">

                                            Flutter / Mobile

                                        </label>

                                    </div>


                                    <div class="form-check">

                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="email_enabled"
                                            value="1"
                                            id="create_email_enabled">

                                        <label
                                            class="form-check-label"
                                            for="create_email_enabled">

                                            Email

                                        </label>

                                    </div>


                                    <div class="form-check">

                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="push_enabled"
                                            value="1"
                                            id="create_push_enabled">

                                        <label
                                            class="form-check-label"
                                            for="create_push_enabled">

                                            Push Notification

                                        </label>

                                    </div>

                                </div>

                            </div>


                            <div class="mb-4">

                                <div class="form-check form-switch">

                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="is_active"
                                        value="1"
                                        id="create_is_active"
                                        checked>

                                    <label
                                        class="form-check-label"
                                        for="create_is_active">

                                        Notifikasi Aktif

                                    </label>

                                </div>

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

    <div class="modal-dialog modal-xl">

        <div class="modal-content">

            <form id="formEdit">

                @csrf

                @method('PUT')

                <input
                    type="hidden"
                    id="edit_uuid">


                <div class="modal-header">

                    <h5 class="modal-title">

                        Edit Notifikasi

                    </h5>


                    <button
                        class="btn-close"
                        data-bs-dismiss="modal"
                        type="button">
                    </button>

                </div>


                <div class="modal-body">

                    <div class="row g-5">

                        {{-- LEFT --}}
                        <div class="col-lg-6">

                            <h6 class="fw-bold mb-4">
                                Informasi Notifikasi
                            </h6>


                            <div class="mb-4">

                                <label class="form-label required">
                                    Kode Event
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    name="code"
                                    id="edit_code"
                                    required>

                            </div>


                            <div class="mb-4">

                                <label class="form-label required">
                                    Nama Notifikasi
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    name="name"
                                    id="edit_name"
                                    required>

                            </div>


                            <div class="mb-4">

                                <label class="form-label required">
                                    Kategori
                                </label>

                                <select
                                    class="form-select"
                                    name="category"
                                    id="edit_category"
                                    required>

                                    <option value="">
                                        Pilih Kategori
                                    </option>

                                    <option value="job">
                                        Job
                                    </option>

                                    <option value="training">
                                        Training
                                    </option>

                                    <option value="network">
                                        Network
                                    </option>

                                    <option value="certificate">
                                        Certificate
                                    </option>

                                    <option value="subscription">
                                        Subscription
                                    </option>

                                    <option value="system">
                                        System
                                    </option>

                                </select>

                            </div>


                            <div class="mb-4">

                                <label class="form-label">
                                    Deskripsi
                                </label>

                                <textarea
                                    class="form-control"
                                    name="description"
                                    id="edit_description"
                                    rows="3">
                                </textarea>

                            </div>


                            <div class="mb-4">

                                <label class="form-label required">
                                    Judul Template
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    name="title_template"
                                    id="edit_title_template"
                                    required>

                            </div>


                            <div class="mb-4">

                                <label class="form-label required">
                                    Pesan Template
                                </label>

                                <textarea
                                    class="form-control notification-template"
                                    name="message_template"
                                    id="edit_message_template"
                                    rows="5"
                                    required>
                                </textarea>

                            </div>

                        </div>


                        {{-- RIGHT --}}
                        <div class="col-lg-6">

                            <h6 class="fw-bold mb-4">
                                Routing & Channel
                            </h6>


                            <div class="mb-4">

                                <label class="form-label">
                                    Dashboard Route
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    name="dashboard_route"
                                    id="edit_dashboard_route">

                            </div>


                            <div class="mb-4">

                                <label class="form-label">
                                    Flutter Route
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    name="flutter_route"
                                    id="edit_flutter_route">

                            </div>


                            <div class="mb-4">

                                <label class="form-label">
                                    Email Subject
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    name="email_subject"
                                    id="edit_email_subject">

                            </div>


                            <div class="mb-4">

                                <label class="form-label">
                                    Email Template
                                </label>

                                <textarea
                                    class="form-control notification-template"
                                    name="email_template"
                                    id="edit_email_template"
                                    rows="5">
                                </textarea>

                            </div>


                            <div class="mb-4">

                                <label class="form-label">
                                    Channel
                                </label>


                                <div class="channel-box">

                                    <div class="form-check">

                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="web_enabled"
                                            value="1"
                                            id="edit_web_enabled">

                                        <label
                                            class="form-check-label"
                                            for="edit_web_enabled">

                                            Dashboard / Web

                                        </label>

                                    </div>


                                    <div class="form-check">

                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="mobile_enabled"
                                            value="1"
                                            id="edit_mobile_enabled">

                                        <label
                                            class="form-check-label"
                                            for="edit_mobile_enabled">

                                            Flutter / Mobile

                                        </label>

                                    </div>


                                    <div class="form-check">

                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="email_enabled"
                                            value="1"
                                            id="edit_email_enabled">

                                        <label
                                            class="form-check-label"
                                            for="edit_email_enabled">

                                            Email

                                        </label>

                                    </div>


                                    <div class="form-check">

                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="push_enabled"
                                            value="1"
                                            id="edit_push_enabled">

                                        <label
                                            class="form-check-label"
                                            for="edit_push_enabled">

                                            Push Notification

                                        </label>

                                    </div>

                                </div>

                            </div>


                            <div class="mb-4">

                                <div class="form-check form-switch">

                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="is_active"
                                        value="1"
                                        id="edit_is_active">

                                    <label
                                        class="form-check-label"
                                        for="edit_is_active">

                                        Notifikasi Aktif

                                    </label>

                                </div>

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

                    Hapus Notifikasi

                </h5>


                <button
                    class="btn-close"
                    type="button"
                    data-bs-dismiss="modal">
                </button>

            </div>


            <div class="modal-body">

                <p>

                    Tindakan ini akan menghapus data dan
                    data yang dihapus tidak dapat dipulihkan,
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

            url: '{{ route("dashboard-admin.master.notification.index") }}',

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

                render: function (data) {

                    return ('000000' + data).slice(-6);

                }
            },


            {
                data: "code",

                render: function (data) {

                    return `
                        <span class="fw-bold">
                            ${data}
                        </span>
                    `;

                }
            },


            {
                data: "name"
            },


            {
                data: "category",

                render: function (data) {

                    if (!data) {
                        return '-';
                    }

                    return `
                        <span class="badge badge-light-primary">
                            ${data}
                        </span>
                    `;

                }

            },


            {
                data: "dashboard_route",

                render: function (data) {

                    if (!data) {
                        return '<span class="text-muted">-</span>';
                    }

                    return `
                        <span class="text-muted">
                            ${data}
                        </span>
                    `;

                }

            },


            {
                data: null,

                orderable: false,

                searchable: false,

                render: function (data) {

                    let channel = [];

                    if (data.web_enabled) {
                        channel.push('Web');
                    }

                    if (data.mobile_enabled) {
                        channel.push('Mobile');
                    }

                    if (data.email_enabled) {
                        channel.push('Email');
                    }

                    if (data.push_enabled) {
                        channel.push('Push');
                    }

                    return channel.length
                        ? channel.join(', ')
                        : '-';

                }

            },


            {
                data: "is_active",

                render: function (data) {

                    if (data) {

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



    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    $("#formCreate").submit(function (e) {

        e.preventDefault();


        $.ajax({

            url: "{{ route('dashboard-admin.master.notification.store') }}",

            type: "POST",

            data: $(this).serialize(),


            success: function (res) {

                $("#createModal").modal("hide");

                $("#formCreate")[0].reset();


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

                Swal.fire({

                    icon: "error",

                    title: "Gagal",

                    text: xhr.responseJSON?.message
                        ?? "Terjadi kesalahan."

                });

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


        let uuid = $("#edit_uuid").val();


        $.ajax({

            url:
                "{{ route('dashboard-admin.master.notification.index') }}"
                + "/" + uuid,

            type: "POST",

            data: {

                _token: "{{ csrf_token() }}",

                _method: "PUT",

                code: $("#edit_code").val(),

                name: $("#edit_name").val(),

                category: $("#edit_category").val(),

                description: $("#edit_description").val(),

                title_template: $("#edit_title_template").val(),

                message_template: $("#edit_message_template").val(),

                email_subject: $("#edit_email_subject").val(),

                email_template: $("#edit_email_template").val(),

                dashboard_route: $("#edit_dashboard_route").val(),

                flutter_route: $("#edit_flutter_route").val(),

                web_enabled:
                    $("#edit_web_enabled").is(":checked") ? 1 : 0,

                mobile_enabled:
                    $("#edit_mobile_enabled").is(":checked") ? 1 : 0,

                email_enabled:
                    $("#edit_email_enabled").is(":checked") ? 1 : 0,

                push_enabled:
                    $("#edit_push_enabled").is(":checked") ? 1 : 0,

                is_active:
                    $("#edit_is_active").is(":checked") ? 1 : 0

            },


            success: function (res) {

                $("#editModal").modal("hide");


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

                Swal.fire({

                    icon: "error",

                    title: "Gagal",

                    text: xhr.responseJSON?.message
                        ?? "Terjadi kesalahan."

                });

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


        let uuid = $("#deleteUuid").val();


        $.ajax({

            url:
                "{{ route('dashboard-admin.master.notification.index') }}"
                + "/" + uuid,

            type: "DELETE",

            data: {

                _token: "{{ csrf_token() }}"

            },


            beforeSend: function () {

                $("#btn-submit-delete")
                    .prop("disabled", true)
                    .html("Menghapus...");

            },


            success: function (res) {

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


            error: function (xhr) {

                Swal.fire({

                    icon: "error",

                    title: "Gagal",

                    text:
                        xhr.responseJSON?.message
                        ?? "Terjadi kesalahan."

                });

            },


            complete: function () {

                $("#btn-submit-delete")
                    .prop("disabled", false)
                    .html("Iya, Hapus");

            }

        });

    });

});



/*
|--------------------------------------------------------------------------
| EDIT DATA
|--------------------------------------------------------------------------
*/

function editData(data)
{
    $("#edit_uuid").val(data.uuid);

    $("#edit_code").val(data.code);

    $("#edit_name").val(data.name);

    $("#edit_category").val(data.category);

    $("#edit_description").val(data.description);

    $("#edit_title_template").val(data.title_template);

    $("#edit_message_template").val(data.message_template);

    $("#edit_email_subject").val(data.email_subject);

    $("#edit_email_template").val(data.email_template);

    $("#edit_dashboard_route").val(data.dashboard_route);

    $("#edit_flutter_route").val(data.flutter_route);


    $("#edit_web_enabled")
        .prop("checked", data.web_enabled == true || data.web_enabled == 1);

    $("#edit_mobile_enabled")
        .prop("checked", data.mobile_enabled == true || data.mobile_enabled == 1);

    $("#edit_email_enabled")
        .prop("checked", data.email_enabled == true || data.email_enabled == 1);

    $("#edit_push_enabled")
        .prop("checked", data.push_enabled == true || data.push_enabled == 1);

    $("#edit_is_active")
        .prop("checked", data.is_active == true || data.is_active == 1);


    $("#editModal").modal("show");
}



/*
|--------------------------------------------------------------------------
| DELETE DATA
|--------------------------------------------------------------------------
*/

function deleteData(uuid)
{
    $("#deleteUuid").val(uuid);

    $("#deleteModal").modal("show");
}

</script>

@endsection