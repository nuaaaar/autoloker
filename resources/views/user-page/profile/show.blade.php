@extends('layouts.user-page')

@section('title', 'Profil')

@section('content')
    <div class="container-xxl">
        @include('user-page.profile.partials.detail.breadcrumb')

        <div class="row g-4">

            <!-- Sidebar Kiri (Desktop Only) -->
            <div class="d-none d-lg-block col-lg-2">
                
            </div>

            <!-- Content (Selalu Tampil) -->
            <div class="col-12 col-lg-8">
                @if($profile_progress['progress'] < 100)
                    @include('user-page.profile.partials.detail.alert-complete-data')
                @endif
                @include('user-page.profile.partials.detail.header')
            </div>

            <!-- Sidebar Kanan (Desktop Only) -->
            <div class="d-none d-lg-block col-lg-2">

            </div>

        </div>
    </div>

@endsection
