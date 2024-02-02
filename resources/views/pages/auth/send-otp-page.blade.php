@extends('layout.app')

@section('title') {{'OTP Send Page'}} @endsection

@section('content')
    @include('components.auth.send-otp-form')
@endsection


