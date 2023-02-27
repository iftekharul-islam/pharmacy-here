{{--@extends('products::layouts.master')--}}
@extends('adminlte::page')
@section('title', 'Create Bank')

@section('content')
    <div class="col-md-6">
        <div class="card card-primary-outline">
            <div class="card-header">
                <h3 class="card-title">Create Bank</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('bank.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label for="bank_name" class="col-sm-6 col-form-label">Bank Name</label>
                        <div class="col-sm-6" id="">
                            <input type="text" name="bank_name" class="form-control" id="bank_name" placeholder="Bank Name">
                            @if ($errors->has('bank_name'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('bank_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bn_bank_name" class="col-sm-6 col-form-label">Bank Name(Bangla)</label>
                        <div class="col-sm-6  " id="name">
                            <input type="text" name="bn_bank_name" class="form-control" id="bn_bank_name" placeholder="Bank Name(Bangla)">
                            @if ($errors->has('bn_bank_name'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('bn_bank_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="status" class="col-sm-6 col-form-label">Status</label>
                        <div class="col-sm-6" id="">
                            <select class="form-control" name="status" id="status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            @if ($errors->has('status'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('status') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <a href="{{ route('bank.index') }}" class="btn btn-danger">Back</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection




