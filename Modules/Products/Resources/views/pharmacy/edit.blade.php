{{--@extends('products::layouts.master')--}}
@extends('adminlte::page')
@section('title', 'Edit Pharmacy')

@section('content')
    <div class="col-md-6">
        <div class="card card-primary-outline">
            <div class="card-header">
                <h3 class="card-title">Update Pharmacy</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('pharmacy.update', $pharmacy->id) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label for="name" class="col-sm-4 col-form-label">Pharmacy Name</label>
                        <div class="col-sm-8  " id="pharmacy_name">
                            <input type="text" name="pharmacy_name" value="{{ $pharmacy->pharmacy_name ?? '' }}" class="form-control" id="pharmacy_name" placeholder="Pharmacy Name">
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection



