@extends('layouts.user-page')

@section('title', 'Paket Berlangganan')

@section('content')

    <div class="container-xxl">

        @include('user-page.subscription.partials.breadcrumb')

        <div class="row g-4">

            <!-- Sidebar Kiri -->
            <div class="d-none d-lg-block col-lg-2">
            </div>

            <!-- Content -->
            <div class="col-12 col-lg-8">

                @include('user-page.subscription.partials.content')

            </div>

            <!-- Sidebar Kanan -->
            <div class="d-none d-lg-block col-lg-2">
            </div>

        </div>

    </div>

@endsection