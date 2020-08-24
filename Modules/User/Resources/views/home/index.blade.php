@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')
    <h1>Welcome, {{ Auth::guard('web')->user()->name }}</h1>
@endsection
