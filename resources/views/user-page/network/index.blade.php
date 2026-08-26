@extends('layouts.user-page')

@section('title', 'Jejaring')

@section('content')
    <div class="container-xxl">
        @include('user-page.network.partials.breadcrumb')

        <div class="row g-4">

            <!-- Sidebar Kiri (Desktop Only) -->
            <div class="d-none d-lg-block col-lg-2">
                
            </div>

            <!-- Content (Selalu Tampil) -->
            <div class="col-12 col-lg-8">
                @include('user-page.network.partials.card-invitation')
                @include('user-page.network.partials.card-network-pending')
                @include('user-page.network.partials.card-network-recommend')
            </div>

            <!-- Sidebar Kanan (Desktop Only) -->
            <div class="d-none d-lg-block col-lg-2">

            </div>

        </div>
    </div>

@endsection
