@extends('auth::layouts.master')

@section('content')
    <h1>Hello, {{\Auth::user()->name}}</h1>
    <p>
        This create view is loaded from module: {!! config('auth.name') !!}
    </p>
@endsection
