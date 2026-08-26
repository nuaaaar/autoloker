@extends('layouts.dashboard-admin')

@section('title', 'Detail')

@section('css')
    <style>
        .page-title{

            font-size:28px;

            font-weight:700;

        }

        .job-header-card{

            border-radius:18px;

        }

        .job-icon{

            width:90px;

            height:90px;

            border-radius:18px;

            background:#152040;

            color:#fff;

            display:flex;

            justify-content:center;

            align-items:center;

            font-size:34px;

        }

        .job-location,
        .job-period{

            color:#6c757d;

            font-size:15px;

        }

        .badge-status{

            font-size:14px;

            padding:12px 20px;

            border-radius:30px;

        }

        .summary-card{

            background:#FFD54A;

            border-radius:15px;

            padding:22px;

            display:flex;

            align-items:center;

            transition:.3s;

            height:100%;

        }

        .summary-card:hover{

            transform:translateY(-4px);

        }

        .summary-icon{

            width:60px;

            height:60px;

            border-radius:50%;

            background:#152040;

            color:#fff;

            display:flex;

            justify-content:center;

            align-items:center;

            font-size:22px;

            margin-right:18px;

        }

        .summary-card small{

            display:block;

            color:#555;

            font-weight:600;

        }

        .summary-card h4{

            margin:3px 0 0;

            font-size:19px;

            font-weight:700;

            color:#152040;

        }

        .detail-card{

            border-radius:16px;

        }

        .detail-card .card-header{

            padding:18px 22px;

        }

        .detail-card .card-header h5{

            font-size:18px;

            font-weight:700;

            color:#152040;

        }

        .detail-table{

            margin-bottom:0;

        }

        .detail-table td{

            color:#6c757d;

            padding:12px 6px;

            vertical-align:top;

            font-weight:500;

        }

        .detail-table th{

            color:#152040;

            padding:12px 6px;

            font-weight:600;

        }

        .detail-table tr:not(:last-child){

            border-bottom:1px dashed #ececec;

        }

        .salary-text{

            color:white;

            font-size:30px;

            font-weight:700;

        }

        .check-item{

            display:flex;

            align-items:flex-start;

            margin-bottom:14px;

        }

        .check-item i{

            color:#ffc107;

            font-size:18px;

            margin-right:12px;

            margin-top:3px;

        }

        .check-item span{

            color:white;

            line-height:1.7;

        }

        .certificate-badge{

            display:inline-block;

            background:#152040;

            color:#fff;

            padding:10px 18px;

            border-radius:30px;

            margin:6px;

            font-size:14px;

            font-weight:600;

            transition:.3s;

        }

        .certificate-badge:hover{

            background:#ffc107;

            color:#152040;

        }

        .detail-card .card-body{

            line-height:1.8;

        }
    </style>
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
        <li class="breadcrumb-item text-muted">
            <a href="javascript:;" class="text-muted text-hover-primary">Manajemen Pelatihan</a>
        </li>
        <!--end::Item-->
        <!--end::Item-->
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-500 w-5px h-2px"></span>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <a href="javascript:;" class="text-muted text-hover-primary ms-2">Detail</a>
        <!--end::Item-->
    </ul>
    <!--end::Breadcrumb-->
@endsection

@section('content')
    <div class="container-fluid">
        
        <div class="d-flex align-items-center justify-content-between mb-4">

            <div>

                @if($data->status == 'submitted')

                <button
                    type="button"
                    class="btn btn-danger me-2"
                    data-bs-toggle="modal"
                    data-bs-target="#rejectModal">

                    <i class="fas fa-times-circle me-2"></i>

                    Tolak Pelatihan

                </button>

                <button
                    type="button"
                    class="btn btn-success"
                    data-bs-toggle="modal"
                    data-bs-target="#publishModal">

                    <i class="fas fa-check-circle me-2"></i>

                    Terbitkan Pelatihan

                </button>

                @endif

            </div>

            <button
                type="button"
                class="btn btn-light"
                onclick="window.history.back()">

                <i class="fas fa-arrow-left me-2"></i>

                Kembali

            </button>

        </div>

        <!-- Hero Card -->
        <div class="card border-0 shadow-sm job-header-card">

            <div class="card-body">

                <div class="row align-items-center">

                    <!-- Informasi -->
                    <div class="col-lg-8">

                        <div class="d-flex align-items-center">

                            <div class="job-icon">

                                <i class="fas fa-graduation-cap"></i>

                            </div>

                            <div class="ms-4">

                                <h2 class="mb-2">

                                    {{ $data->title }}

                                    @if($data->is_certificate)

                                        <div class="mt-3">

                                            <span class="badge bg-warning text-dark fs-7 px-4 py-2">

                                                <i class="fas fa-certificate me-2"></i>

                                                Bersertifikat

                                            </span>

                                        </div>

                                    @endif

                                </h2>

                                <div class="text-muted fw-semibold mb-3">

                                    <i class="fas fa-building me-2"></i>

                                    {{ $data->provider }}

                                </div>

                                <div class="d-flex flex-wrap align-items-center">

                                    <span class="job-location">

                                        <i class="fas fa-layer-group me-1"></i>

                                        {{ ucfirst($data->category) }}

                                    </span>

                                    <span class="mx-3 text-muted">|</span>

                                    <span class="job-location">

                                        <i class="fas fa-signal me-1"></i>

                                        {{ ucfirst($data->level) }}

                                    </span>

                                    <span class="mx-3 text-muted">|</span>

                                    <span class="job-location">

                                        <i class="fas fa-calendar-alt me-1"></i>

                                        {{ \Carbon\Carbon::parse($data->start_date)->format('d M Y') }}

                                        -

                                        {{ \Carbon\Carbon::parse($data->end_date)->format('d M Y') }}

                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- Status -->
                    <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">

                        @switch($data->status)

                            @case('draft')

                                <span class="badge badge-status badge-secondary">

                                    Draft

                                </span>

                            @break

                            @case('submitted')

                                <span class="badge badge-status badge-warning">

                                    Menunggu Persetujuan

                                </span>

                            @break

                            @case('published')

                                <span class="badge badge-status badge-success">

                                    Dipublikasikan

                                </span>

                            @break

                            @case('running')

                                <span class="badge badge-status badge-primary">

                                    Sedang Berlangsung

                                </span>

                            @break

                            @case('closed')

                                <span class="badge badge-status badge-dark">

                                    Ditutup

                                </span>

                            @break

                            @case('cancelled')

                                <span class="badge badge-status badge-danger">

                                    Dibatalkan

                                </span>

                            @break

                            @case('rejected')

                                <span class="badge badge-status badge-danger">

                                    Ditolak

                                </span>

                            @break

                        @endswitch


                        <div class="mt-4">

                            @if($data->is_free)

                                <span class="badge bg-success fs-6 px-5 py-3">

                                    <i class="fas fa-gift me-2"></i>

                                    GRATIS

                                </span>

                            @else

                                <div class="salary-text">

                                    Rp {{ number_format((int)$data->price,0,',','.') }}

                                </div>

                                <small class="text-muted">

                                    Biaya Pelatihan

                                </small>

                            @endif

                        </div>

                    </div>

                </div>

            </div>

        </div>

        @if($data->status=='rejected')

            <div class="alert alert-danger mt-4">

                <strong>

                    Alasan Penolakan

                </strong>

                <hr>

                {{ $data->reason_rejected }}

            </div>

        @endif

        <!-- Summary -->
        <div class="row mt-4">

            <!-- Kuota -->
            <div class="col-lg-3 col-md-6 mb-3">

                <div class="summary-card">

                    <div class="summary-icon">

                        <i class="fas fa-users"></i>

                    </div>

                    <div>

                        <small>Kuota Peserta</small>

                        <h4>

                            {{ number_format($data->quota ?? 0) }}

                            Orang

                        </h4>

                    </div>

                </div>

            </div>

            <!-- Terdaftar -->
            <div class="col-lg-3 col-md-6 mb-3">

                <div class="summary-card">

                    <div class="summary-icon">

                        <i class="fas fa-user-check"></i>

                    </div>

                    <div>

                        <small>Peserta Terdaftar</small>

                        <h4>

                            {{ number_format($data->registered ?? 0) }}

                            Orang

                        </h4>

                    </div>

                </div>

            </div>

            <!-- Dilihat -->
            <div class="col-lg-3 col-md-6 mb-3">

                <div class="summary-card">

                    <div class="summary-icon">

                        <i class="fas fa-eye"></i>

                    </div>

                    <div>

                        <small>Dilihat</small>

                        <h4>

                            {{ number_format($data->total_clicked ?? 0) }}

                            Kali

                        </h4>

                    </div>

                </div>

            </div>

            <div class="col-lg-3 col-md-6 mb-3">

                <div class="summary-card">

                    <div class="summary-icon">

                        @switch($data->training_mode)

                            @case('online')
                                <i class="fas fa-video"></i>
                            @break

                            @case('offline')
                                <i class="fas fa-map-marker-alt"></i>
                            @break

                            @default
                                <i class="fas fa-laptop-house"></i>
                        @endswitch

                    </div>

                    <div>

                        <small>Mode Pelatihan</small>

                        <h4>

                            {{ ucfirst($data->training_mode) }}

                        </h4>

                    </div>

                </div>

            </div>

        </div>

        <div class="row mt-4">

            <!-- Informasi Dasar -->
            <div class="col-lg-6 mb-4">

                <div class="card border-0 shadow-sm detail-card">

                    <div class="card-header bg-white border-0">

                        <h5 class="mb-0">
                            <i class="fas fa-circle-info text-warning me-2"></i>
                            Informasi Dasar
                        </h5>

                    </div>

                    <div class="card-body">

                        <table class="table table-borderless detail-table">

                            <tr>
                                <td width="40%">Judul</td>
                                <th>{{ $data->title }}</th>
                            </tr>

                            <tr>
                                <td>Penyelenggara</td>
                                <th>{{ $data->provider }}</th>
                            </tr>

                            <tr>
                                <td>Instruktur</td>
                                <th>{{ $data->instructor ?: '-' }}</th>
                            </tr>

                            <tr>
                                <td>Kategori</td>
                                <th>{{ ucfirst($data->category) }}</th>
                            </tr>

                            <tr>
                                <td>Level</td>
                                <th>{{ ucfirst($data->level) }}</th>
                            </tr>

                            <tr>
                                <td>Biaya</td>

                                <th>

                                    @if($data->is_free)

                                        <span class="badge bg-success">
                                            Gratis
                                        </span>

                                    @else

                                        Rp {{ number_format($data->price,0,',','.') }}

                                    @endif

                                </th>

                            </tr>

                            <tr>
                                <td>Status</td>

                                <th>

                                    @switch($data->status)

                                        @case('draft')
                                            <span class="badge bg-secondary">Draft</span>
                                        @break

                                        @case('submitted')
                                            <span class="badge bg-warning">Menunggu Review</span>
                                        @break

                                        @case('published')
                                            <span class="badge bg-success">Dipublikasikan</span>
                                        @break

                                        @case('running')
                                            <span class="badge bg-primary">Berlangsung</span>
                                        @break

                                        @case('closed')
                                            <span class="badge bg-dark">Ditutup</span>
                                        @break

                                        @case('cancelled')
                                            <span class="badge bg-danger">Dibatalkan</span>
                                        @break

                                        @case('rejected')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @break

                                    @endswitch

                                </th>

                            </tr>

                        </table>

                    </div>

                </div>

            </div>


            <!-- Jadwal -->

            <div class="col-lg-6 mb-4">

                <div class="card border-0 shadow-sm detail-card">

                    <div class="card-header bg-white border-0">

                        <h5 class="mb-0">

                            <i class="fas fa-calendar-alt text-warning me-2"></i>

                            Jadwal Pelatihan

                        </h5>

                    </div>

                    <div class="card-body">

                        <table class="table table-borderless detail-table">

                            <tr>
                                <td width="40%">Tanggal Mulai</td>

                                <th>

                                    {{ \Carbon\Carbon::parse($data->start_date)->format('d M Y') }}

                                </th>

                            </tr>

                            <tr>
                                <td>Tanggal Selesai</td>

                                <th>

                                    {{ \Carbon\Carbon::parse($data->end_date)->format('d M Y') }}

                                </th>

                            </tr>

                            <tr>
                                <td>Durasi</td>

                                <th>

                                    {{ $data->duration_day }}

                                    Hari

                                </th>

                            </tr>

                            <tr>
                                <td>Total JP</td>

                                <th>

                                    {{ $data->total_jp }}

                                    JP

                                </th>

                            </tr>

                            <tr>
                                <td>Mode</td>

                                <th>

                                    {{ ucfirst($data->training_mode) }}

                                </th>

                            </tr>

                        </table>

                    </div>

                </div>

            </div>

        </div>

        <div class="row">

            <div class="col-lg-12 mb-4">

                <div class="card border-0 shadow-sm detail-card">

                    <div class="card-header bg-white border-0">

                        <h5>

                            <i class="fas fa-map-marker-alt text-warning me-2"></i>

                            Lokasi Pelatihan

                        </h5>

                    </div>

                    <div class="card-body">

                        @if($data->training_mode != 'online')

                            <table class="table table-borderless detail-table">

                                <tr>
                                    <td width="25%">Provinsi</td>
                                    <th>{{ $data->province }}</th>
                                </tr>

                                <tr>
                                    <td>Kota</td>
                                    <th>{{ $data->city }}</th>
                                </tr>

                                {{-- <tr>
                                    <td>Kecamatan</td>
                                    <th>{{ $data->district }}</th>
                                </tr>

                                <tr>
                                    <td>Kelurahan</td>
                                    <th>{{ $data->village }}</th>
                                </tr> --}}

                                <tr>
                                    <td>Alamat</td>
                                    <th>{{ $data->address }}</th>
                                </tr>

                                @if($data->google_map)

                                <tr>
                                    <td>Google Maps</td>

                                    <th>

                                        <a href="{{ $data->google_map }}" target="_blank">

                                            Lihat Lokasi

                                        </a>

                                    </th>

                                </tr>

                                @endif

                            </table>

                        @endif


                        @if($data->training_mode != 'offline')

                            <hr>

                            <h6>

                                Meeting Online

                            </h6>

                            <a href="{{ $data->meeting_url }}"

                                target="_blank"

                                class="btn btn-warning">

                                <i class="fas fa-video me-2"></i>

                                Gabung Meeting

                            </a>

                        @endif

                    </div>

                </div>

            </div>

        </div>

        <div class="card border-0 shadow-sm detail-card mb-4">

            <div class="card-header bg-white border-0">

                <h5>

                    <i class="fas fa-file-alt text-warning me-2"></i>

                    Deskripsi Pelatihan

                </h5>

            </div>

            <div class="card-body">

                {!! nl2br(e($data->description)) !!}

            </div>

        </div>

        <div class="row">

            <div class="col-lg-6 mb-4">

                <div class="card border-0 shadow-sm detail-card">

                    <div class="card-header bg-white border-0">

                        <h5>

                            <i class="fas fa-book text-warning me-2"></i>

                            Materi Pelatihan

                        </h5>

                    </div>

                    <div class="card-body">

                        @foreach(json_decode($data->syllabus,true) ?? [] as $item)

                            <div class="check-item">

                                <i class="fas fa-check-circle"></i>

                                <span>{{ $item }}</span>

                            </div>

                        @endforeach

                    </div>

                </div>

            </div>

            <div class="col-lg-6 mb-4">

                <div class="card border-0 shadow-sm detail-card">

                    <div class="card-header bg-white border-0">

                        <h5>

                            <i class="fas fa-list-check text-warning me-2"></i>

                            Persyaratan Peserta

                        </h5>

                    </div>

                    <div class="card-body">

                        @foreach(json_decode($data->requirements,true) ?? [] as $item)

                            <div class="check-item">

                                <i class="fas fa-check-circle"></i>

                                <span>{{ $item }}</span>

                            </div>

                        @endforeach

                    </div>

                </div>

            </div>

        </div>

        <div class="row">

            <div class="col-lg-6 mb-4">

                <div class="card border-0 shadow-sm detail-card">

                    <div class="card-header bg-white border-0">

                        <h5>

                            <i class="fas fa-certificate text-warning me-2"></i>

                            Sertifikat

                        </h5>

                    </div>

                    <div class="card-body">

                        @if($data->is_certificate)

                            <table class="table table-borderless detail-table">

                                <tr>

                                    <td width="35%">

                                        Nama Sertifikat

                                    </td>

                                    <th>

                                        {{ $data->certificate_name }}

                                    </th>

                                </tr>

                                <tr>

                                    <td>

                                        Masa Berlaku

                                    </td>

                                    <th>

                                        {{ $data->certificate_validity ?: '-' }}

                                    </th>

                                </tr>

                            </table>

                        @else

                            <div class="alert alert-warning mb-0">

                                Pelatihan ini tidak menyediakan sertifikat.

                            </div>

                        @endif

                    </div>

                </div>

            </div>

            <div class="col-lg-6 mb-4">

                <div class="card border-0 shadow-sm detail-card">

                    <div class="card-header bg-white border-0">

                        <h5>

                            <i class="fas fa-tags text-warning me-2"></i>

                            Tag

                        </h5>

                    </div>

                    <div class="card-body">

                        @foreach(json_decode($data->tags,true) ?? [] as $tag)

                            <span class="certificate-badge">

                                #{{ $tag }}

                            </span>

                        @endforeach

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="modal fade" id="publishModal" tabindex="-1">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">

                        Terbitkan Pelatihan

                    </h5>

                    <button
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body text-center">

                    <i class="fas fa-check-circle text-success fs-3x mb-5"></i>

                    <h4>

                        Yakin ingin menerbitkan Pelatihan ini?

                    </h4>

                    <p class="text-muted mb-0">

                        Setelah diterbitkan, Pelatihan akan langsung tampil kepada seluruh pelamar.

                    </p>

                </div>

                <div class="modal-footer">

                    <button
                        class="btn btn-light"
                        data-bs-dismiss="modal">

                        Batal

                    </button>

                    <button
                        class="btn btn-success"
                        id="btnConfirmPublish">

                        Ya, Terbitkan

                    </button>

                </div>

            </div>

        </div>

    </div>

    <div class="modal fade" id="rejectModal" tabindex="-1">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">

                        Tolak Pelatihan

                    </h5>

                    <button
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="alert alert-warning">

                        Berikan alasan penolakan agar BUJP / Company dapat memperbaiki Pelatihan.

                    </div>

                    <label class="form-label required">

                        Alasan Penolakan

                    </label>

                    <textarea
                        class="form-control"
                        id="reasonRejected"
                        rows="5"
                        placeholder="Tuliskan alasan penolakan..."></textarea>

                    <div
                        class="invalid-feedback"
                        id="reasonError">
                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        class="btn btn-light"
                        data-bs-dismiss="modal">

                        Batal

                    </button>

                    <button
                        class="btn btn-danger"
                        id="btnConfirmReject">

                        Tolak Pelatihan

                    </button>

                </div>

            </div>

        </div>

    </div>
@endsection

@section('js')
    <script>
        // Publish

        $("#btnConfirmPublish").click(function(){

            $.ajax({

                url: "/dashboard-admin/training/{{ $data->uuid }}/publish",

                type:"POST",

                data:{
                    _token:$('meta[name="csrf-token"]').attr("content")
                },

                success:function(res){

                    Swal.fire({

                        icon:"success",

                        title:"Berhasil",

                        text:res.message

                    }).then(function(){

                        location.reload();

                    });

                }

            });

        });



        // Reject

        $("#btnConfirmReject").click(function(){

            $("#reasonRejected").removeClass("is-invalid");

            $("#reasonError").html("");

            let reason = $("#reasonRejected").val();

            if(reason.trim()==""){

                $("#reasonRejected").addClass("is-invalid");

                $("#reasonError").html("Alasan penolakan wajib diisi.");

                return;

            }

            $.ajax({

                url:"/dashboard-admin/training/{{ $data->uuid }}/reject",

                type:"POST",

                data:{

                    _token:$('meta[name="csrf-token"]').attr("content"),

                    reason_rejected:reason

                },

                success:function(res){

                    Swal.fire({

                        icon:"success",

                        title:"Berhasil",

                        text:res.message

                    }).then(function(){

                        location.reload();

                    });

                }

            });

        });
    </script>
@endsection