@extends('adminlte::page')

@section('title', 'Home')

@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: {!! config('user.name') !!}
    </p>
@endsection
