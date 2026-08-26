@extends('layouts.dashboard-user')

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
        Lowongan Saya</h1>
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
            <a href="{{ route('dashboard-user.job-vacancy.index') }}" class="text-muted text-hover-primary">Lowongan Saya</a>
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

        <!-- Breadcrumb -->
        <div class="d-flex align-items-center justify-content-between mb-4">

            <div>

            </div>

            <a href="{{ route('dashboard-user.job-vacancy.index') }}"
            class="btn btn-light">

                <i class="fas fa-arrow-left me-2"></i>

                Kembali

            </a>

        </div>

        <!-- Hero Card -->

        <div class="card border-0 shadow-sm job-header-card">

            <div class="card-body">

                <div class="row align-items-center">

                    <div class="col-lg-8">

                        <div class="d-flex align-items-center">

                            <div class="job-icon">

                                <i class="fas fa-briefcase"></i>

                            </div>

                            <div class="ms-4">

                                <h2 class="mb-2">

                                    {{ $data->position }}

                                </h2>

                                <div class="d-flex flex-wrap">

                                    <span class="job-location">

                                        <i class="fas fa-map-marker-alt me-1"></i>

                                        {{ $data->city }},
                                        {{ $data->province }}

                                    </span>

                                    <span class="mx-3 text-muted">

                                        |

                                    </span>

                                    <span class="job-period">

                                        <i class="fas fa-calendar-alt me-1"></i>

                                        {{ \Carbon\Carbon::parse($data->start_date)->format('d M Y') }}

                                        -

                                        {{ \Carbon\Carbon::parse($data->end_date)->format('d M Y') }}

                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>

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

                            @case('closed')

                                <span class="badge badge-status badge-dark">

                                    Ditutup

                                </span>

                            @break

                            @case('rejected')

                                <span class="badge badge-status badge-danger">

                                    Ditolak

                                </span>

                            @break

                        @endswitch

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

            <div class="col-lg-3 col-md-6 mb-3">

                <div class="summary-card">

                    <div class="summary-icon">

                        <i class="fas fa-users"></i>

                    </div>

                    <div>

                        <small>Kuota</small>

                        <h4>

                            {{ number_format($data->kuota) }}

                            Orang

                        </h4>

                    </div>

                </div>

            </div>


            <div class="col-lg-3 col-md-6 mb-3">

                <div class="summary-card">

                    <div class="summary-icon">

                        <i class="fas fa-pencil"></i>

                    </div>

                    <div>

                        <small>Pelamar</small>

                        <h4>

                            0 Orang

                        </h4>

                    </div>

                </div>

            </div>


            <div class="col-lg-3 col-md-6 mb-3">

                <div class="summary-card">

                    <div class="summary-icon">

                        <i class="fas fa-bookmark"></i>

                    </div>

                    <div>

                        <small>Disimpan</small>

                        <h4>

                            0 Kali

                        </h4>

                    </div>

                </div>

            </div>


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
                                <td width="40%">Posisi</td>
                                <th>{{ $data->position ?? '-' }}</th>
                            </tr>

                            <tr>
                                <td>Status</td>
                                <th>

                                    @switch($data->status)

                                        @case('draft')
                                            <span class="badge bg-secondary">Draft</span>
                                        @break

                                        @case('submitted')
                                            <span class="badge bg-warning">Submitted</span>
                                        @break

                                        @case('published')
                                            <span class="badge bg-success">Published</span>
                                        @break

                                        @case('closed')
                                            <span class="badge bg-dark">Closed</span>
                                        @break

                                        @case('rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                        @break

                                    @endswitch

                                </th>
                            </tr>

                            <tr>
                                <td>Jenis Pekerjaan</td>
                                <th>{{ ucfirst($data->working_type) }}</th>
                            </tr>

                            <tr>
                                <td>Sistem Kerja</td>
                                <th>{{ ucfirst($data->working_system) }}</th>
                            </tr>

                            <tr>
                                <td>Kuota</td>
                                <th>{{ number_format($data->kuota) }} Orang</th>
                            </tr>

                            <tr>
                                <td>Periode Lowongan</td>
                                <th>

                                    {{ \Carbon\Carbon::parse($data->start_date)->format('d M Y') }}

                                    -

                                    {{ \Carbon\Carbon::parse($data->end_date)->format('d M Y') }}

                                </th>
                            </tr>

                            <tr>

                                <td>Jumlah Dilihat</td>

                                <th>

                                    {{ number_format($data->total_clicked ?? 0) }}

                                    Kali

                                </th>

                            </tr>

                        </table>

                    </div>

                </div>

            </div>

            <!-- Lokasi Penempatan -->

            <div class="col-lg-6 mb-4">

                <div class="card border-0 shadow-sm detail-card">

                    <div class="card-header bg-white border-0">

                        <h5 class="mb-0">

                            <i class="fas fa-location-dot text-warning me-2"></i>

                            Lokasi Penempatan

                        </h5>

                    </div>

                    <div class="card-body">

                        <table class="table table-borderless detail-table">

                            <tr>

                                <td width="40%">Provinsi</td>

                                <th>{{ $data->province ?? '-' }}</th>

                            </tr>

                            <tr>

                                <td>Kota / Kabupaten</td>

                                <th>{{ $data->city ?? '-' }}</th>

                            </tr>

                            {{-- <tr>

                                <td>Kecamatan</td>

                                <th>{{ $data->district ?? '-' }}</th>

                            </tr>

                            <tr>

                                <td>Kelurahan</td>

                                <th>{{ $data->village ?? '-' }}</th>

                            </tr> --}}

                            <tr>

                                <td>Alamat Lengkap</td>

                                <th>

                                    {{ $data->address ?? '-' }}

                                </th>

                            </tr>

                        </table>

                    </div>

                </div>

            </div>

        </div>

        <div class="row">

            <!-- Deskripsi Pekerjaan -->
            <div class="col-lg-12 mb-4">

                <div class="card border-0 shadow-sm detail-card">

                    <div class="card-header bg-white border-0">

                        <h5 class="mb-0">
                            <i class="fas fa-file-lines text-warning me-2"></i>
                            Deskripsi Pekerjaan
                        </h5>

                    </div>

                    <div class="card-body">

                        {!! nl2br(e($data->description_work)) !!}

                    </div>

                </div>

            </div>



            <!-- Persyaratan -->

            <div class="col-lg-5 mb-4">

                <div class="card border-0 shadow-sm detail-card">

                    <div class="card-header bg-white border-0">

                        <h5 class="mb-0">

                            <i class="fas fa-user-check text-warning me-2"></i>

                            Persyaratan Pelamar

                        </h5>

                    </div>


                    <div class="card-body">

                        <table class="table table-borderless detail-table mb-0">


                            {{-- JENIS KELAMIN --}}
                            <tr>

                                <td width="45%">
                                    Jenis Kelamin
                                </td>

                                <th>
                                    {{ $data->gender ?? 'Semua Gender' }}
                                </th>

                            </tr>


                            {{-- USIA --}}
                            <tr>

                                <td>
                                    Usia
                                </td>

                                <th>

                                    @if($data->min_age || $data->max_age)

                                        {{ $data->min_age ?? '-' }}

                                        -

                                        {{ $data->max_age ?? '-' }}

                                        Tahun

                                    @else

                                        Tidak ditentukan

                                    @endif

                                </th>

                            </tr>


                            {{-- TINGGI BADAN --}}
                            <tr>

                                <td>
                                    Tinggi Badan
                                </td>

                                <th>

                                    @if($data->min_height || $data->max_height)

                                        {{ $data->min_height ?? '-' }}

                                        -

                                        {{ $data->max_height ?? '-' }}

                                        cm

                                    @else

                                        Tidak ditentukan

                                    @endif

                                </th>

                            </tr>


                            {{-- BERAT BADAN --}}
                            <tr>

                                <td>
                                    Berat Badan
                                </td>

                                <th>

                                    @if($data->min_weight || $data->max_weight)

                                        {{ $data->min_weight ?? '-' }}

                                        -

                                        {{ $data->max_weight ?? '-' }}

                                        kg

                                    @else

                                        Tidak ditentukan

                                    @endif

                                </th>

                            </tr>


                            {{-- PENDIDIKAN --}}
                            <tr>

                                <td>
                                    Pendidikan
                                </td>

                                <th>
                                    {{ $data->last_education ?? 'Tidak ditentukan' }}
                                </th>

                            </tr>


                            {{-- PENGALAMAN --}}
                            <tr>

                                <td>
                                    Minimal Pengalaman
                                </td>

                                <th>

                                    {{ $data->min_experience ?? 0 }}

                                    Tahun

                                </th>

                            </tr>


                        </table>

                    </div>

                </div>

            </div>

            <!-- Gaji -->

            <div class="col-lg-7 mb-4">

                <div class="card border-0 shadow-sm detail-card">

                    <div class="card-header bg-white border-0">

                        <h5 class="mb-0">

                            <i class="fas fa-wallet text-warning me-2"></i>

                            Informasi Gaji

                        </h5>

                    </div>

                    <div class="card-body">

                        @if($data->is_show_fee)

                            <h3 class="salary-text">

                                Rp {{ number_format($data->min_price,0,',','.') }}

                                -

                                Rp {{ number_format($data->max_price,0,',','.') }}

                            </h3>

                            <span class="badge bg-warning text-dark mt-2">

                                {{ ucfirst($data->fee_type) }}

                            </span>

                        @else

                            <div class="alert alert-warning mb-0">

                                Nominal gaji tidak ditampilkan oleh perusahaan.

                            </div>

                        @endif

                    </div>

                </div>

            </div>



            <!-- Tanggung Jawab -->

            <div class="col-lg-6 mb-4">

                <div class="card border-0 shadow-sm detail-card">

                    <div class="card-header bg-white border-0">

                        <h5 class="mb-0">

                            <i class="fas fa-list-check text-warning me-2"></i>

                            Tanggung Jawab

                        </h5>

                    </div>

                    <div class="card-body">

                        @php

                            $responsibilities = json_decode($data->responsibility,true) ?? [];

                        @endphp

                        @forelse($responsibilities as $item)

                            <div class="check-item">

                                <i class="fas fa-check-circle"></i>

                                <span>{{ $item }}</span>

                            </div>

                        @empty

                            <span class="text-muted">

                                Tidak ada data.

                            </span>

                        @endforelse

                    </div>

                </div>

            </div>



            <!-- Benefit -->

            <div class="col-lg-6 mb-4">

                <div class="card border-0 shadow-sm detail-card">

                    <div class="card-header bg-white border-0">

                        <h5 class="mb-0">

                            <i class="fas fa-gift text-warning me-2"></i>

                            Fasilitas & Benefit

                        </h5>

                    </div>

                    <div class="card-body">

                        @php

                            $facilities = json_decode($data->facility,true) ?? [];

                        @endphp

                        @forelse($facilities as $item)

                            <div class="check-item">

                                <i class="fas fa-check-circle"></i>

                                <span>{{ $item }}</span>

                            </div>

                        @empty

                            <span class="text-muted">

                                Tidak ada data.

                            </span>

                        @endforelse

                    </div>

                </div>

            </div>



            <!-- Sertifikasi -->

            <div class="col-lg-12 mb-4">

                <div class="card border-0 shadow-sm detail-card">

                    <div class="card-header bg-white border-0">

                        <h5 class="mb-0">

                            <i class="fas fa-certificate text-warning me-2"></i>

                            Sertifikasi yang Dibutuhkan

                        </h5>

                    </div>

                    <div class="card-body">

                        @php

                            $certificates = json_decode($data->certificate,true) ?? [];

                        @endphp

                        @forelse($certificates as $certificate)

                            <span class="certificate-badge">

                                {{ $certificate }}

                            </span>

                        @empty

                            <span class="text-muted">

                                Tidak ada sertifikasi khusus.

                            </span>

                        @endforelse

                    </div>

                </div>

            </div>

            <!-- Kompetensi Skema -->

            <div class="col-lg-12 mb-4">

                <div class="card border-0 shadow-sm detail-card">

                    <div class="card-header bg-white border-0">

                        <h5 class="mb-0">

                            <i class="fas fa-award text-warning me-2"></i>

                            Uji Kompetensi Skema yang Dibutuhkan

                        </h5>

                    </div>


                    <div class="card-body">

                        @php

                            $competencySchemes = json_decode(
                                $data->competency_scheme,
                                true
                            ) ?? [];

                        @endphp


                        @forelse($competencySchemes as $scheme)

                            <span class="certificate-badge">

                                {{ $scheme }}

                            </span>

                        @empty

                            <span class="text-muted">

                                Tidak ada uji kompetensi skema khusus.

                            </span>

                        @endforelse

                    </div>

                </div>

            </div>

        </div>
    </div>
@endsection

@section('js')
    
@endsection