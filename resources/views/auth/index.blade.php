@extends('layouts.auth')

@section('left-panel')
    @include('auth.partials.banner-security')
    @include('auth.partials.banner-company')
@endsection

@section('right-panel')
    @include('auth.partials.login')
    @include('auth.partials.register')
    @include('auth.partials.register-security')
    @include('auth.partials.register-bujp')
    @include('auth.partials.register-company')
@endsection