{{--@extends('products::layouts.master')--}}
@extends('adminlte::page')
@section('title', 'Transaction Payment')

@section('content')
    <div class="col-md-6">
        <div class="card card-primary-outline">
            <div class="card-header">
                <h3 class="card-title">Customer details</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card-body">
                <div class="form-group row">
                    <label for="due-amount" class="col-sm-4 col-form-label">Name</label>
                    <div class="col-sm-8">
                        <label class="col-form-label">{{ $data->name }}</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="due-amount" class="col-sm-4 col-form-label">E-mail</label>
                    <div class="col-sm-8">
                        <label class="col-form-label">{{ $data->email }}</label>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="due-amount" class="col-sm-4 col-form-label">Phone number</label>
                    <div class="col-sm-8">
                        <label class="col-form-label">{{ $data->phone_number }}</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script !src="">
        function isNumber(evt)
        {
            // console.log (evt);
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode == 13 || charCode == 46 || (charCode >= 48 && charCode <= 57))
            {
                return true;
            }
            return false;
        }
    </script>
@endsection


