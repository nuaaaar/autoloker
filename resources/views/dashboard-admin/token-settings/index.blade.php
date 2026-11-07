@extends('layouts.dashboard-admin')

@section('title', 'Pengaturan token')

@section('css')
    @include('partials.token-billing-styles')
@endsection

@section('breadcrumb')
    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Pengaturan token</h1>
    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
        <li class="breadcrumb-item text-muted">Beranda</li>
        <li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
        <li class="breadcrumb-item text-muted">Pengaturan token</li>
    </ul>
@endsection

@section('content')
    <div class="token-billing-content">
    @if(session('success'))
        <div class="alert alert-success" role="status">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger" role="alert">
            <p class="mb-1">Pengaturan belum disimpan. Periksa nilai berikut:</p>
            <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="row">
        <div class="col-12 col-xl-8">
            <form method="POST" action="{{ route('dashboard-admin.token-settings.update') }}" class="card">
                @csrf
                @method('PUT')
                <div class="card-header"><h2 class="card-title fs-4 fw-bold">Harga publikasi dan konversi</h2></div>
                <div class="card-body">
                    <p class="text-muted">Perubahan berlaku untuk pesanan dan publikasi baru. Saldo, pesanan yang sudah dibuat, dan publikasi aktif mempertahankan nilainya.</p>
                    <div class="row g-5">
                        <div class="col-12 col-md-6">
                            <label for="idr_per_token" class="form-label fw-semibold">Rupiah per token</label>
                            <input id="idr_per_token" name="idr_per_token" type="number" min="1" step="1" required class="form-control" value="{{ old('idr_per_token', $settings->idr_per_token) }}">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="job_post_tokens" class="form-label fw-semibold">Biaya publikasi lowongan (token)</label>
                            <input id="job_post_tokens" name="job_post_tokens" type="number" min="1" step="1" required class="form-control" value="{{ old('job_post_tokens', $settings->job_post_tokens) }}">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="job_post_days" class="form-label fw-semibold">Masa tayang lowongan (hari)</label>
                            <input id="job_post_days" name="job_post_days" type="number" min="1" step="1" required class="form-control" value="{{ old('job_post_days', $settings->job_post_days) }}">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="training_post_tokens" class="form-label fw-semibold">Biaya publikasi pelatihan (token)</label>
                            <input id="training_post_tokens" name="training_post_tokens" type="number" min="1" step="1" required class="form-control" value="{{ old('training_post_tokens', $settings->training_post_tokens) }}">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="training_post_days" class="form-label fw-semibold">Masa tayang pelatihan (hari)</label>
                            <input id="training_post_days" name="training_post_days" type="number" min="1" step="1" required class="form-control" value="{{ old('training_post_days', $settings->training_post_days) }}">
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <button type="submit" class="btn btn-warning fw-semibold">Simpan pengaturan</button>
                </div>
            </form>
        </div>
    </div>
    </div>
@endsection
