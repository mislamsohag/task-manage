@extends('layout.sidenav-layout')
@section('content')
    @include('components.task.list')
    @include('components.task.create')
    @include('components.task.update')
    @include('components.task.delete')
@endsection
