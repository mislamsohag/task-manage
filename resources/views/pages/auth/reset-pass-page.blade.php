@extends('layout.app')

@section('title') {{'Reset Page'}} @endsection

@section('content')
    @include('components.auth.reset-pass-form')
@endsection

