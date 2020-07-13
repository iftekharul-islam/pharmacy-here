{{--@extends('products::layouts.master')--}}
@extends('adminlte::page')

@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: {!! config('products.name') !!}
    </p>
@endsection


