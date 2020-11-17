{{--@extends('products::layouts.master')--}}
@extends('adminlte::page')
@section('title', 'Customer Create')

@section('content')
    <div class="col-md-6">
        <div class="card card-primary-outline">
            <div class="card-header">
                <h3 class="card-title">Customer details</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('customer.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Name</label>
                        <div class="col-sm-8">
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                                   placeholder="name" required>
                            @if ($errors->has('name'))
                                <span class="text-danger">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">E-mail</label>
                        <div class="col-sm-8">
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control"
                                   placeholder="e-mail" required>
                            @if ($errors->has('email'))
                                <span class="text-danger">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Phone number</label>
                        <div class="col-sm-8">
                            <input type="number" name="phone_number" value="{{ old('phone_number') }}"
                                   class="form-control" placeholder="phone-number" required>
                            @if ($errors->has('phone_number'))
                                <span class="text-danger">
                                <strong>{{ $errors->first('phone_number') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Status</label>
                        <div class="col-sm-8">
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

                    <div class="card-footer">
                        <a href="{{ url('user/dashboard') }}" class="btn btn-danger">Back</a>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
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


