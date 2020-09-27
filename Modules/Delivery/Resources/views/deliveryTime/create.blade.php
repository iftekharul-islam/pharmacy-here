{{--@extends('products::layouts.master')--}}
@extends('adminlte::page')
@section('title', 'Create Delivery Time')
<style type="text/css">
    .error{
        color: red;
    }
</style>
@section('content')
    <div class="col-md-6">
        <div class="card card-primary-outline">
            <div class="card-header">
                <h3 class="card-title">Create Delivery Time</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" id="form" action="{{ route('delivery-time-store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label for="start_month" class="col-sm-4 col-form-label">Start Month</label>
                        <div class="col-sm-8" id="">
                            <select class="form-control" name="start_month" id="start_month" required>
                                <option hidden></option>
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                            @if ($errors->has('start_month'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('start_month') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="end_month" class="col-sm-4 col-form-label">End Month</label>
                        <div class="col-sm-8" id="">
                            <select class="form-control" name="end_month" id="end_month" required>
                                <option hidden></option>
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                            @if ($errors->has('end_month'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('end_month') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="start_time" class="col-sm-4 col-form-label">Start Time</label>
                        <div class="col-sm-8  " id="name">
                            <input type="time" name="start_time" class="form-control" id="start_time" placeholder="Start Time" required>
                            @if ($errors->has('start_time'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('start_time') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="end_time" class="col-sm-4 col-form-label">End Time</label>
                        <div class="col-sm-8  " id="name">
                            <input type="time" name="end_time" class="form-control" id="end_time" placeholder="End Time" required>
                            @if ($errors->has('end_time'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('end_time') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="delivery_method" class="col-sm-4 col-form-label">Delivery Method</label>
                        <div class="col-sm-8" id="">
                            <select class="form-control" name="delivery_method" id="delivery_method">
                                <option value="1">Normal Delivery</option>
                                <option value="2">Express Delivery</option>
                            </select>
                            @if ($errors->has('delivery_method'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('delivery_method') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="status" class="col-sm-4 col-form-label">Status</label>
                        <div class="col-sm-8" id="">
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
                    <a href="{{ route('notice.index') }}" class="btn btn-danger">Back</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <script>
        $('#form').validate({
            rules: {
                notice: {
                    required: true
                },
                bn_notice: {
                    required: true
                },
            }
        });
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


