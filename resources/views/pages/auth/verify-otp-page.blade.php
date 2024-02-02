@extends('layout.app')

@section('title') {{'OTP Verify Page'}} @endsection

@section('content')
    @include('components.auth.verify-otp-form')
@endsection
