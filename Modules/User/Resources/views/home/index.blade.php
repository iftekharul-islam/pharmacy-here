@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')
    <h1>Dashboard</h1>
    {{ var_dump(Auth::check()) }}
    <p>
        This view is loaded from module: {!! config('user.name') !!}
    </p>
@endsection
