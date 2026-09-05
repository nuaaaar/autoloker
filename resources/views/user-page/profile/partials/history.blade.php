<style>
    .assignment-timeline{

        position:relative;

    }

    .assignment-item{

        position:relative;

        display:flex;

        gap: 16px;

        padding-bottom: 38px;

    }

    .assignment-item:last-child{

        padding-bottom:0;

    }

    .assignment-item:not(:last-child)::before{

        content:"";

        position:absolute;

        left: 15px;

        top: 30px;

        width:2px;

        height:calc(100% - 30px);

        background:#2b3651;

    }

    .assignment-icon{

        width: 30px;
        height: 30px;

        min-width: 30px;

        border-radius: 50%;

        border: 2px solid rgba(246,176,0,.35);

        background:#20293d;

        display:flex;
        align-items:center;
        justify-content:center;

    }

    .assignment-content{

        flex:1;

    }

    .assignment-position{

        color:#ffffff;

        font-size: 12px;

        font-weight: 700;

        margin-bottom: 2px;

    }

    .assignment-company{

        color:#f6b000;

        font-size: 10px;

        font-weight:600;

        margin-bottom: 0px;

    }

    .assignment-meta{

        color:#8f9db8;

        font-size: 9.5px;

        margin-bottom: 2px;

        font-family:monospace;

    }

    .assignment-description{

        color:#98a5bf;

        font-size: 9.5px;

        /* line-height:1.8; */

    }

    .history-wrapper{

        background:#11192d;

        border:1px solid rgba(255,255,255,.06);

        border-radius:22px;

        overflow: visible;

    }


    .history-header{

        padding:12px 24px;

        display:flex;

        justify-content:space-between;

        align-items:center;

        border-bottom:1px solid rgba(255,255,255,.05);

    }


    .history-heading{

        color:#fff;

        font-size: 14px;

        font-weight:700;

        margin:0;

    }


    .history-subtitle{

        margin-top:4px;

        color:#90a0be;

        font-size:11px;

    }

    .history-body{

        padding:0;

    }


    .history-card{

        display:flex;

        gap:18px;

        padding: 12px 24px;

        border-bottom:1px solid rgba(255,255,255,.05);

        transition:.25s;

    }

    .btn-add-history{

        background:#e8a400;

        color:#111;

        border:none;

        border-radius: 12px !important;

        padding:10px 22px;

        font-size: 11px !important;

        font-weight:700;

        transition:.25s;

    }

    .btn-add-history:hover{

        background:#f2b600;

        transform:translateY(-2px);

    }

    .assignment-current{

        width:46px !important;
        height:24px;

        cursor:pointer;

    }

    .assignment-current:checked{

        background-color:#f5b400;
        border-color:#f5b400;

    }

    .assignment-current:focus{

        box-shadow:none;

    }

    .input-dark textarea{

        background:none;

        border:none;

        color:#fff;

        height:66px;

        font-size: 11px;

    }

    .input-dark textarea:focus{

        box-shadow:none;

    }

    .btn-save-history{

        width:50%;

        height:34px;

        border:none;

        border-radius:9px;

        background:#e8a401;

        color:#fff;

        font-weight:600;

    }

    .history-card:hover{

        /* background:#18213a; */

    }


    .history-icon{

        width:36px;

        height:36px;

        border-radius:50%;

        background:rgba(232,164,0,.18);

        border:1px solid rgba(232,164,0,.5);

        display:flex;

        justify-content:center;

        align-items:center;

        flex-shrink:0;

        color:#e8a400;

        transition:.25s ease;

    }

    .history-icon i{

        font-size:14px;

    }

    /* Belum dijadikan badge */
    .history-icon.empty{

        background:transparent;

        border:1px solid transparent;

        color:rgba(255,255,255,.35);

    }

    .history-icon.empty i{

        opacity:.7;

    }


    .history-content{

        flex:1;

    }


    .history-top{

        display:flex;

        justify-content:space-between;

    }


    .history-title{

        font-size:12px;

        font-weight:700;

        color:#fff;

    }


    .history-instansi{

        margin-top:3px;

        color:#95a6c4;

        font-size:10px;

    }


    .history-badge{

        display:inline-block;

        margin-left:4px;

        background:rgba(232,164,0,.15);

        border:1px solid rgba(232,164,0,.45);

        color:#e8a400;

        padding: 2px 8px;

        border-radius:20px;

        font-size: 9.5px;

    }


    .history-status{

        padding: 2px 14px;

        border-radius:30px;

        font-size: 10px;

        height: 50%;

    }


    .history-status.expired{

        background:rgba(255,60,60,.12);

        color:#ff6666;

        border:1px solid rgba(255,80,80,.45);

    }

    .history-status.active{

        background:rgba(79, 255, 60, 0.12);

        color:#66ff78;

        border:1px solid rgba(80, 255, 95, 0.45);

    }


    .history-detail{

        margin-top:10px;

        display:flex;

        gap:15px;

        flex-wrap:wrap;

    }


    .history-number{

        padding: 4px 8px;

        border-radius:8px;

        background:#243152;

        color:#90a4d4;

        font-size: 9.5px;

    }


    .history-date{

        color:#9cabca;

        font-size:12px;

    }


    .history-category{

        margin-top:8px;

        display:inline-block;

        padding:4px 8px;

        border-radius:20px;

        background:#1e2d58;

        color:#92a7d9;

        font-size: 9.5px;

    }


    .history-menu{

        width:38px;

        height:38px;

        border:none;

        border-radius:10px;

        background:transparent;

        color:#8c9ab5;

    }


    .history-menu:hover{

        background:#263454;

        color:#fff;

    }

    .history-menu{

        width:38px;
        height:38px;

        border:none;

        background:transparent;

        border-radius:10px;

        color:#8d9ab5;

        transition:.2s;

    }

    .history-menu:hover{

        background:#263454;

        color:#fff;

    }

    .history-dropdown{

        /* width:240px; */

        background:#18233b;

        border:1px solid rgba(255,255,255,.08);

        border-radius:16px;

        overflow:hidden;

        padding:8px;

        box-shadow:0 12px 30px rgba(0,0,0,.35);

    }

    .history-dropdown .dropdown-item{

        display:flex;

        align-items:center;

        gap:8px;

        color:#d6dceb;

        font-size: 9.5px;

        font-weight:500;

        border-radius:10px;

        padding:6px 7px;

        transition:.2s;

    }

    .history-dropdown .dropdown-item:hover{

        background:#23314f;

        color:#fff;

    }

    .history-dropdown .dropdown-divider{

        border-color:rgba(255,255,255,.08);

    }

    .history-dropdown .text-danger{

        color:#ff6d6d !important;

    }

    .history-dropdown .text-danger:hover{

        background:rgba(255,0,0,.08);

    }

    .history-modal{

        background:#10182d;

        border:1px solid rgba(255,255,255,.08);

        border-radius:24px;

        color:#fff;

    }

    .history-modal-header{

        display:flex;

        justify-content:space-between;

        align-items:center;

        padding: 14px;

        border-bottom:1px solid rgba(255,255,255,.06);

    }

    .history-modal-icon{

        width: 34px;

        height:34px;

        border-radius:15px;

        border:1px solid rgba(211,155,25,.35);

        display:flex;

        justify-content:center;

        align-items:center;

        margin-right:10px;

    }

    .history-close{

        width:24px;

        height:24px;

        border:none;

        border-radius:50%;

        background:#1b274b;

        color:#8ea0c7;

    }

    .history-modal-body{

        padding:18px;

    }

    .btn-cancel-history{

        width:50%;

        height:34px;

        border-radius:9px;

        background:transparent;

        border:1px solid rgba(255,255,255,.08);

        color:#c8d3ef;

    }

    .history-modal-footer{

        padding: 16px;

        border-top:1px solid rgba(255,255,255,.06);

        display:flex;

        justify-content:flex-end;

        gap:14px;

    }

    .assignment-timeline{
        width:100%;
    }

    .assignment-item{
        width:100%;
        display:flex;
    }

    /* Aktif */
    .assignment-icon i{
        color:#ffc107;
    }

    /* Tidak aktif */
    .assignment-icon.inactive{
        background:transparent;
        border:1px solid rgba(255,255,255,.12);
    }

    .assignment-icon.inactive i{
        color:#8b93a7 !important;
    }

    .history-empty{

        padding:55px 30px;

        display:flex;
        flex-direction:column;
        align-items:center;
        justify-content:center;

        text-align:center;

    }

    .history-empty-icon{

        width: 32px;
        height: 32px;

        border-radius:50%;

        display:flex;
        align-items:center;
        justify-content:center;

        background:rgba(246,176,0,.08);

        border:1px solid rgba(246,176,0,.18);

        margin-bottom:22px;

    }

    .history-empty-title{

        color:#fff;

        font-size:16px;

        font-weight:700;

    }

    .history-empty-text{

        max-width:520px;

        margin-top:10px;

        color:#8fa0bc;

        font-size:12px;

        line-height:1.9;

    }

    .history-empty-benefit{

        margin-top:24px;

        display:flex;
        flex-direction:column;

        gap:12px;

        color:#c9d3e7;

        font-size:12px;

        text-align:left;

    }


    /* ===========================================
    LIGHT MODE
    =========================================== */

    [data-bs-theme="light"] .assignment-item:not(:last-child)::before{
        background:#e2e8f0;
    }

    [data-bs-theme="light"] .assignment-icon{
        background:#f8fafc;
        border-color:rgba(232,164,1,.35);
    }

    [data-bs-theme="light"] .assignment-icon.inactive{
        background:transparent;
        border-color:#dbe3ee;
    }

    [data-bs-theme="light"] .assignment-icon.inactive i{
        color:#94a3b8 !important;
    }

    [data-bs-theme="light"] .assignment-position{
        color:#1e293b;
    }

    [data-bs-theme="light"] .assignment-company{
        color:#d18f00;
    }

    [data-bs-theme="light"] .assignment-meta{
        color:#64748b;
    }

    [data-bs-theme="light"] .assignment-description{
        color:#64748b;
    }

    [data-bs-theme="light"] .history-wrapper{
        background:#ffffff;
        border-color:#e2e8f0;
    }

    [data-bs-theme="light"] .history-header{
        border-bottom-color:#e2e8f0;
    }

    [data-bs-theme="light"] .history-heading{
        color:#1e293b;
    }

    [data-bs-theme="light"] .history-subtitle{
        color:#64748b;
    }

    [data-bs-theme="light"] .history-card{
        border-bottom-color:#e2e8f0;
    }

    [data-bs-theme="light"] .btn-add-history{
        background:#e8a400;
        color:#111;
    }

    [data-bs-theme="light"] .btn-add-history:hover{
        background:#f2b600;
    }

    [data-bs-theme="light"] .input-dark textarea{
        color:#1e293b;
    }

    [data-bs-theme="light"] .btn-save-history{
        background:#e8a401;
        color:#fff;
    }

    [data-bs-theme="light"] .history-icon{
        background:rgba(232,164,0,.10);
        border-color:rgba(232,164,0,.35);
        color:#d18f00;
    }

    [data-bs-theme="light"] .history-icon.empty{
        background:transparent;
        border-color:transparent;
        color:#94a3b8;
    }

    [data-bs-theme="light"] .history-title{
        color:#1e293b;
    }

    [data-bs-theme="light"] .history-instansi{
        color:#64748b;
    }

    [data-bs-theme="light"] .history-badge{
        background:rgba(232,164,0,.10);
        border-color:rgba(232,164,0,.35);
        color:#c98d00;
    }

    [data-bs-theme="light"] .history-number{
        background:#f1f5f9;
        color:#64748b;
    }

    [data-bs-theme="light"] .history-date{
        color:#64748b;
    }

    [data-bs-theme="light"] .history-category{
        background:#eef2ff;
        color:#6478b8;
    }

    [data-bs-theme="light"] .history-menu{
        color:#64748b;
    }

    [data-bs-theme="light"] .history-menu:hover{
        background:#f1f5f9;
        color:#1e293b;
    }

    [data-bs-theme="light"] .history-dropdown{
        background:#ffffff;
        border-color:#e2e8f0;
        box-shadow:0 12px 30px rgba(15,23,42,.12);
    }

    [data-bs-theme="light"] .history-dropdown .dropdown-item{
        color:#475569;
    }

    [data-bs-theme="light"] .history-dropdown .dropdown-item:hover{
        background:#f1f5f9;
        color:#1e293b;
    }

    [data-bs-theme="light"] .history-dropdown .dropdown-divider{
        border-color:#e2e8f0;
    }

    [data-bs-theme="light"] .history-modal{
        background:#ffffff;
        border-color:#e2e8f0;
        color:#1e293b;
    }

    [data-bs-theme="light"] .history-modal-header{
        border-bottom-color:#e2e8f0;
    }

    [data-bs-theme="light"] .history-modal-icon{
        border-color:rgba(211,155,25,.35);
    }

    [data-bs-theme="light"] .history-close{
        background:#f1f5f9;
        color:#64748b;
    }

    [data-bs-theme="light"] .history-modal-footer{
        border-top-color:#e2e8f0;
    }

    [data-bs-theme="light"] .btn-cancel-history{
        border-color:#dbe3ee;
        color:#64748b;
    }

    [data-bs-theme="light"] .history-empty-icon{
        background:rgba(246,176,0,.10);
        border-color:rgba(246,176,0,.25);
    }

    [data-bs-theme="light"] .history-empty-title{
        color:#1e293b;
    }

    [data-bs-theme="light"] .history-empty-text{
        color:#64748b;
    }

    [data-bs-theme="light"] .history-empty-benefit{
        color:#475569;
    }

</style>

<div class="history-wrapper">

    <!-- Header -->
    <div class="history-header">

        <div>

            <h4 class="history-heading">
                Riwayat Penugasan
            </h4>

            <div class="history-subtitle">

                Urutan terbaru

            </div>

        </div>

        <button type="button" class="btn-add-history py-2 btnAddHistory"  data-bs-toggle="modal" data-bs-target="#historyModal">

            <i class="ki-duotone ki-plus fs-9 me-2"></i>

            Tambah

        </button>

    </div>


    <!-- Body -->

    <div class="history-body">
        <div class="history-card">
            <div class="assignment-timeline">

                @forelse ($security_histories as $history)
                    <div class="assignment-item" data-uuid="{{ $history->uuid }}">

                        <div class="assignment-icon {{ $history->is_current == 0 ? 'inactive' : '' }}">

                            <i class="ki-duotone ki-shield-tick fs-2 {{ $history->is_current == 1 ? 'text-warning' : '' }}">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>

                        </div>

                        <div class="assignment-content">

                            <h5 class="assignment-position">
                                {{ $history->position }}
                            </h5>

                            <div class="assignment-company">
                                {{ $history->company_name }}
                            </div>

                            <div class="assignment-meta">
                                {{ date('d F Y', strtotime($history->start_date)) }} &nbsp;&ndash;&nbsp; {{ $history->is_current == 0 ?  date('d F Y', strtotime($history->end_date)) : 'Sekarang' }}
                                <span class="mx-2">•</span>
                                {{ $history->location }}
                            </div>

                            <div class="assignment-description">

                                {{ $history->description }}

                            </div>

                        </div>

                        <div class="dropup">

                            <button
                                class="history-menu"
                                type="button"
                                data-bs-toggle="dropdown"
                                data-bs-auto-close="static">

                                <i class="ki-duotone ki-dots-horizontal fs-4"></i>

                            </button>

                            <ul class="dropdown-menu dropdown-menu-end history-dropdown">

                                <li>

                                    <a class="dropdown-item btnEditHistory"
                                        href="javascript:;"
                                        data-uuid="{{ $history->uuid }}"
                                        data-position="{{ $history->position }}"
                                        data-company="{{ $history->company_name }}"
                                        data-location="{{ $history->location }}"
                                        data-placement="{{ $history->placement }}"
                                        data-start="{{ $history->start_date }}"
                                        data-end="{{ $history->end_date }}"
                                        data-current="{{ $history->is_current }}"
                                        data-description="{{ $history->description }}"
                                        data-category="{{ $history->category }}"
                                        >

                                        <i class="ki-duotone ki-notepad-edit me-3"></i>

                                        Edit

                                    </a>

                                </li>

                                <li><hr class="dropdown-divider"></li>

                                <li>

                                    <a class="dropdown-item text-danger btnDeleteSubmitHistory"
                                        href="javascript:;"
                                        data-uuid="{{ $history->uuid }}">

                                        <i class="ki-duotone ki-trash text-danger me-3"></i>

                                        Hapus

                                    </a>

                                </li>

                            </ul>

                        </div>

                    </div>

                @empty
                    <div class="history-empty">

                        <div class="history-empty-icon">

                            <i class="ki-duotone ki-briefcase fs-6 text-warning">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>

                        </div>

                        <h5 class="history-empty-title">

                            Belum Ada Riwayat Penugasan

                        </h5>

                        <div class="history-empty-text">

                            Tambahkan riwayat penugasan atau pengalaman kerja sebagai
                            anggota keamanan agar perusahaan dapat melihat pengalaman
                            dan penempatan yang pernah Anda jalani.

                        </div>

                        <div class="history-empty-benefit">

                            <div>

                                <i class="ki-duotone ki-check-circle text-success me-2"></i>

                                Menampilkan pengalaman kerja

                            </div>

                            <div>

                                <i class="ki-duotone ki-check-circle text-success me-2"></i>

                                Meningkatkan kepercayaan perusahaan

                            </div>

                            <div>

                                <i class="ki-duotone ki-check-circle text-success me-2"></i>

                                Memperbesar peluang diterima bekerja

                            </div>

                        </div>

                    </div>
                @endforelse

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="historyModal" tabindex="-1">

    <div class="modal-dialog modal-md modal-dialog-centered">

        <div class="modal-content history-modal">

            <!-- Header -->

            <div class="history-modal-header">

                <div class="d-flex align-items-center">

                    <div class="history-modal-icon">

                        <i class="ki-duotone ki-award fs-3 text-warning"></i>

                    </div>

                    <div>

                        <h5 class="mb-0" id="historyModalTitle">Tambah Riwayat Penugasan</h5>

                        <small class="text-muted" id="historyModalSubtitle">
                            Lengkapi informasi riwayat penugasan
                        </small>

                    </div>

                </div>

                <button
                    class="history-close"
                    data-bs-dismiss="modal">

                    <i class="ki-duotone ki-cross fs-8"></i>

                </button>

            </div>

            <form id="formHistory" method="POST" action="{{ route('user-page.profile.history.store') }}" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="uuid" id="historyUuid">

                <div class="history-modal-body">

                    <!-- Nama -->

                    <div class="mb-4">

                        <label class="form-label-dark">

                            Jabatan / Posisi
                            <span class="text-danger">*</span>

                        </label>

                        <div class="input-dark">

                            <i class="ki-duotone ki-shield"></i>

                            <input
                                type="text"
                                name="position"
                                class="form-control"
                                placeholder="cth: Satpam Gada Pratama"
                                required
                                >

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-4">

                            <label class="form-label-dark">

                                Perusahaan / BUJP
                                <span class="text-danger">*</span>

                            </label>

                            <div class="input-dark">

                                <i class="ki-duotone ki-office-bag"></i>

                                <input
                                    class="form-control"
                                    name="company_name"
                                    placeholder="PT .."
                                    required
                                    >

                            </div>

                        </div>

                        <div class="col-md-6 mb-4">

                            <label class="form-label-dark">

                                Lokasi
                                <span class="text-danger">*</span>

                            </label>

                            <div class="input-dark">

                                <i class="ki-duotone ki-map"></i>

                                <input
                                    type="text"
                                    name="location"
                                    class="form-control"
                                    placeholder="Balikpapan"
                                    required
                                    >

                            </div>

                        </div>

                    </div>

                    <div class="mb-4">

                        <label class="form-label-dark">

                            Jenis Lokasi Penugasan
                            <span class="text-danger">*</span>

                        </label>

                        <select name="category" class="form-select input-select-dark" required>

                            <option>Pilih jenis...</option>

                            @php
                                $master_placements = \App\Models\MasterPlacement::orderBy('title')->get();
                            @endphp

                            @foreach($master_placements as $placement)

                                <option value="{{ $placement->title }}">{{ $placement->title }}</option>

                            @endforeach

                        </select>

                    </div>

                    <div class="mb-4">

                        <div class="d-flex justify-content-between align-items-center mb-2">

                            <label class="form-label-dark mb-0">
                                Periode
                                <span class="text-danger">*</span>
                            </label>

                            <div class="d-flex align-items-center">

                                <span class="text-muted me-2 small">
                                    Masih aktif di sini
                                </span>

                                <div class="form-check form-switch m-0">

                                    <input
                                        class="form-check-input assignment-current"
                                        type="checkbox"
                                        id="isCurrentAssignment"
                                        name="is_current">

                                </div>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6">

                                <input
                                    type="date"
                                    name="start_date"
                                    class="form-control input-date-dark"
                                    required>

                            </div>

                            <div class="col-md-6">

                                <input
                                    type="date"
                                    name="end_date"
                                    id="endDate"
                                    class="form-control input-date-dark"
                                    required>

                            </div>

                        </div>

                    </div>

                    <div class="mb-4">

                        <label class="form-label-dark">

                            Deksripsi Tugas <span class="text-muted">(opsional)</span>

                        </label>

                        <div class="input-dark" style="padding: 0px !important;">

                            <textarea
                                name="description"
                                class="form-control"
                                placeholder="Jelaskan tanggung jawab dan pencapaian Anda di posisi ini.."></textarea>

                        </div>

                    </div>

                </div>

                <div class="history-modal-footer">

                    <button
                        class="btn-cancel-history"
                        data-bs-dismiss="modal"
                        type="button">

                        Batal

                    </button>

                    <button
                        class="btn-save-history"
                        type="button"
                        id="btnSaveHistory">

                        Tambahkan

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<div class="modal fade" id="deleteHistoryModal" tabindex="-1">

    <div class="modal-dialog modal-sm modal-dialog-centered">

        <div class="modal-content delete-modal">

            <div class="delete-modal-body">

                <div class="delete-icon">

                    <i class="ki-duotone ki-cross fs-6 text-danger">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>

                </div>

                <h4 class="delete-title">
                    Hapus Riwayat Penugasan?
                </h4>

                <p class="delete-description">

                    Data riwayat penugasan ini akan dihapus permanen dan
                    tidak bisa dikembalikan.

                </p>

                <input type="hidden" id="deleteHistoryUuid">

            </div>

            <div class="delete-modal-footer">

                <button
                    type="button"
                    class="btn-delete-cancel"
                    data-bs-dismiss="modal">

                    Batal

                </button>

                <button
                    type="button"
                    class="btn-delete-confirm"
                    id="btnDeleteHistory">

                    Hapus

                </button>

            </div>

        </div>

    </div>

</div>