@extends('layout.app')
@section('title') {{'Login Page'}} @endsection
@section('content')
    @include('components.auth.login-form')
@endsection

