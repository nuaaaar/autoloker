@extends('layouts.dashboard-admin')

@php
    $categoryLabel = $category === 'cs' ? 'Cleaning Service' : 'Satpam';
    $indexUrl = route('dashboard-admin.master.category-certificate.category.index', ['category' => $category]);
    $storeUrl = route('dashboard-admin.master.category-certificate.category.store', ['category' => $category]);
    $updateUrlTemplate = route('dashboard-admin.master.category-certificate.category.update', [
        'category' => $category,
        'uuid' => '__UUID__',
    ]);
    $deleteUrlTemplate = route('dashboard-admin.master.category-certificate.category.destroy', [
        'category' => $category,
        'uuid' => '__UUID__',
    ]);
@endphp

@section('title', 'Kategori Pelatihan ' . $categoryLabel)

@section('css')
<style>
    #datatable td { vertical-align: middle; }
    .category-form-help { font-size: .875rem; color: #7e8299; }
</style>
@endsection

@section('breadcrumb')
    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
        Kategori Pelatihan {{ $categoryLabel }}
    </h1>

    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
        <li class="breadcrumb-item text-muted">
            <a href="javascript:;" class="text-muted text-hover-primary">Beranda</a>
        </li>
        <li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
        <li class="breadcrumb-item text-muted">Master</li>
        <li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
        <li class="breadcrumb-item text-muted">Kategori Pelatihan</li>
        <li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
        <li class="breadcrumb-item text-muted">{{ $categoryLabel }}</li>
    </ul>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <button type="button" class="btn btn-primary py-2 mb-3 float-end"
                    data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="las la-plus me-1"></i> Tambah
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <h5 class="card-title mb-0">List Kategori Pelatihan {{ $categoryLabel }}</h5>
                        <div class="card-toolbar"><div class="card-button"></div></div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable"
                               class="table table-bordered dt-responsive nowrap w-100 dataTable no-footer dtr-inline">
                            <thead>
                                <tr>
                                    <th width="1%">ID</th>
                                    <th>Nama Kategori Pelatihan</th>
                                    <th>Parent ID</th>
                                    <th>TUK</th>
                                    <th>Level</th>
                                    <th class="text-end" width="8%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- CREATE MODAL --}}
    <div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formCreate">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Kategori Pelatihan {{ $categoryLabel }}</h5>
                        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label required" for="create_title">Nama Kategori Pelatihan</label>
                            <input type="text" class="form-control" name="title" id="create_title"
                                   placeholder="Masukkan Kategori Pelatihan" maxlength="255" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="create_parent_id">Parent Kategori</label>
                            <select class="form-select" name="parent_id" id="create_parent_id">
                                <option value="">-- Tidak Ada Parent --</option>
                                @foreach(($parentCertificates ?? collect()) as $parent)
                                    <option value="{{ $parent->id }}">
                                        {{ $parent->title }} (Level {{ $parent->level }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="category-form-help mt-1">Kosongkan jika data ini merupakan kategori utama.</div>
                        </div>

                        <div class="mb-3">
                            <input type="hidden" name="is_tuk" value="0">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="is_tuk"
                                       id="create_is_tuk" value="1">
                                <label class="form-check-label" for="create_is_tuk">Merupakan TUK</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label required" for="create_level">Level</label>
                            <input type="number" class="form-control" name="level" id="create_level"
                                   value="1" min="1" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="btnCreate">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- EDIT MODAL --}}
    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formEdit">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_uuid">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Kategori Pelatihan</h5>
                        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label required" for="edit_title">Nama Kategori Pelatihan</label>
                            <input type="text" class="form-control" id="edit_title" name="title"
                                   maxlength="255" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="edit_parent_id">Parent Kategori</label>
                            <select class="form-select" name="parent_id" id="edit_parent_id">
                                <option value="">-- Tidak Ada Parent --</option>
                                @foreach(($parentCertificates ?? collect()) as $parent)
                                    <option value="{{ $parent->id }}">
                                        {{ $parent->title }} (Level {{ $parent->level }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="category-form-help mt-1">Pilih kategori induk atau kosongkan untuk kategori utama.</div>
                        </div>

                        <div class="mb-3">
                            <input type="hidden" name="is_tuk" value="0">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="is_tuk"
                                       id="edit_is_tuk" value="1">
                                <label class="form-check-label" for="edit_is_tuk">Merupakan TUK</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label required" for="edit_level">Level</label>
                            <input type="number" class="form-control" name="level" id="edit_level"
                                   value="1" min="1" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="btnUpdate">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- DELETE MODAL --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Kategori Pelatihan</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0">Tindakan ini akan menghapus data dan data yang dihapus tidak dapat dipulihkan. Yakin ingin melanjutkan?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="btn-submit-delete">Iya, Hapus</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
$(document).ready(function () {
    let currentDraw = 1;

    const indexUrl = @json($indexUrl);
    const storeUrl = @json($storeUrl);
    const updateUrlTemplate = @json($updateUrlTemplate);
    const deleteUrlTemplate = @json($deleteUrlTemplate);

    function escapeHtml(value) {
        return $('<div>').text(value == null ? '' : value).html();
    }

    function showError(xhr) {
        const errors = xhr.responseJSON?.errors || {};
        const firstError = Object.values(errors).flat()[0];
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: firstError || xhr.responseJSON?.message || 'Terjadi kesalahan.'
        });
    }

    if ($.fn.DataTable.isDataTable('#datatable')) {
        $('#datatable').DataTable().destroy();
    }

    const table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        aLengthMenu: [[10, 25, 50, 75, 999999], [10, 25, 50, 75, 'All']],
        ajax: {
            url: indexUrl,
            type: 'GET',
            data: function (d) {
                currentDraw = d.draw;
                d.page = (d.start / d.length) + 1;
                d.length = d.length;
            },
            dataFilter: function (response) {
                const json = JSON.parse(response);
                return JSON.stringify({
                    draw: currentDraw,
                    recordsTotal: json.results.total,
                    recordsFiltered: json.results.total,
                    data: json.results.data
                });
            },
            error: function (xhr) {
                console.error('DataTable Error:', xhr.responseText);
            }
        },
        columns: [
            {
                data: 'id',
                render: function (data) {
                    return escapeHtml(('000000' + data).slice(-6));
                }
            },
            {
                data: 'title',
                render: function (data) {
                    return escapeHtml(data);
                }
            },
            {
                data: 'parent_id',
                render: function (data) {
                    return data ? escapeHtml(data) : '-';
                }
            },
            {
                data: 'is_tuk',
                render: function (data) {
                    return Number(data) === 1
                        ? '<span class="badge badge-light-primary">Ya</span>'
                        : '<span class="badge badge-light-secondary">Tidak</span>';
                }
            },
            {
                data: 'level',
                render: function (data) {
                    return escapeHtml(data ?? 1);
                }
            },
            {
                data: null,
                orderable: false,
                searchable: false,
                className: 'text-end',
                render: function (row) {
                    const uuid = escapeHtml(row.uuid);
                    const title = escapeHtml(row.title);
                    const parentId = row.parent_id == null ? '' : row.parent_id;
                    const isTuk = Number(row.is_tuk) === 1 ? 1 : 0;
                    const level = row.level ?? 1;

                    return `
                        <button type="button"
                            class="btn btn-outline-primary btn-sm me-1"
                            onclick="editData('${row.id}', '${uuid}', '${title}', '${parentId}', ${isTuk}, ${level})"
                            title="Edit">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
                        <button type="button"
                            class="btn btn-outline-danger btn-sm"
                            onclick="deleteData('${uuid}')"
                            title="Hapus">
                            <i class="fas fa-trash-alt"></i>
                        </button>`;
                }
            }
        ],
        dom: 'Blfrtip',
        buttons: [
            { extend: 'colvis', text: '<i class="fas fa-eye me-1"></i>Kolom', className: 'btn btn-light-primary' },
            { extend: 'copy', text: '<i class="fas fa-copy me-1"></i>Copy', className: 'btn btn-light-danger' },
            { extend: 'excel', text: '<i class="fas fa-file-excel me-1"></i>Excel', className: 'btn btn-light-success' }
        ],
        drawCallback: function () {
            $('[data-bs-toggle="tooltip"]').tooltip();
        }
    });

    table.buttons().container().appendTo('.card-button');

    $('#formCreate').on('submit', function (e) {
        e.preventDefault();
        const form = $(this);
        const button = $('#btnCreate');

        $.ajax({
            url: storeUrl,
            type: 'POST',
            data: form.serialize(),
            beforeSend: function () {
                button.prop('disabled', true).text('Menyimpan...');
            },
            success: function (res) {
                $('#createModal').modal('hide');
                form[0].reset();
                $('#create_level').val(1);

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: res.message,
                    timer: 1500,
                    showConfirmButton: false
                });
                table.ajax.reload(null, false);
            },
            error: showError,
            complete: function () {
                button.prop('disabled', false).text('Simpan');
            }
        });
    });

    $('#formEdit').on('submit', function (e) {
        e.preventDefault();

        const uuid = $('#edit_uuid').val();
        const updateUrl = updateUrlTemplate.replace('__UUID__', encodeURIComponent(uuid));
        const button = $('#btnUpdate');

        $.ajax({
            url: updateUrl,
            type: 'POST',
            data: $(this).serialize(),
            beforeSend: function () {
                button.prop('disabled', true).text('Memperbarui...');
            },
            success: function (res) {
                $('#editModal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: res.message,
                    timer: 1500,
                    showConfirmButton: false
                });
                table.ajax.reload(null, false);
            },
            error: showError,
            complete: function () {
                button.prop('disabled', false).text('Update');
            }
        });
    });

    let selectedDeleteUuid = null;

    $('#btn-submit-delete').on('click', function () {
        if (!selectedDeleteUuid) return;

        const button = $(this);
        const deleteUrl = deleteUrlTemplate.replace('__UUID__', encodeURIComponent(selectedDeleteUuid));

        $.ajax({
            url: deleteUrl,
            type: 'POST',
            data: {
                _token: @json(csrf_token()),
                _method: 'DELETE'
            },
            beforeSend: function () {
                button.prop('disabled', true).text('Menghapus...');
            },
            success: function (res) {
                $('#deleteModal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: res.message,
                    timer: 1800,
                    showConfirmButton: false
                });
                table.ajax.reload(null, false);
                selectedDeleteUuid = null;
            },
            error: showError,
            complete: function () {
                button.prop('disabled', false).text('Iya, Hapus');
            }
        });
    });

    window.editData = function (id, uuid, title, parentId, isTuk, level) {
        $('#edit_uuid').val(uuid);
        $('#edit_title').val($('<textarea>').html(title).text());
        $('#edit_parent_id').val(parentId || '');
        $('#edit_is_tuk').prop('checked', Number(isTuk) === 1);
        $('#edit_level').val(level || 1);

        // Hindari memilih data itu sendiri sebagai parent.
        $('#edit_parent_id option').prop('disabled', false);
        $('#edit_parent_id option').filter(function () {
            return String($(this).val()) === String(id);
        }).prop('disabled', true);

        $('#editModal').modal('show');
    };

    window.deleteData = function (uuid) {
        selectedDeleteUuid = uuid;
        $('#deleteModal').modal('show');
    };
});
</script>
@endsection
