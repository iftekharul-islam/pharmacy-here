@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif(session('failed'))
        <div class="alert alert-danger">
            {{ session('failed') }}
        </div>
    @endif
    <h1>Welcome, {{ Auth::guard('web')->user()->name }}</h1>
@endsection
