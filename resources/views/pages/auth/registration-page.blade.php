@extends('layout.app')

@section('title') {{'Ragistration Page'}} @endsection

@section('content')
@include('components.auth.registration-form')
@endsection