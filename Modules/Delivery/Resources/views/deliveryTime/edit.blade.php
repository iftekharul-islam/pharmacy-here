{{--@extends('products::layouts.master')--}}
@extends('adminlte::page')
@section('title', 'Update Delivery Time')
<style type="text/css">
    .error{
        color: red;
    }
</style>
@section('content')
    <div class="col-md-6">
        <div class="card card-primary-outline">
            <div class="card-header">
                <h3 class="card-title">Update Delivery Time</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" id="form" action="{{ route('delivery-time-update', $data['id']) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label for="start_month" class="col-sm-4 col-form-label">Start Month</label>
                        <div class="col-sm-8" id="">
                            <select class="form-control" name="start_month" id="start_month" required>
                                <option value="1" @if($data['start_month'] == 1) selected @endif>January</option>
                                <option value="2" @if($data['start_month'] == 2) selected @endif>February</option>
                                <option value="3" @if($data['start_month'] == 3) selected @endif>March</option>
                                <option value="4" @if($data['start_month'] == 4) selected @endif>April</option>
                                <option value="5" @if($data['start_month'] == 5) selected @endif>May</option>
                                <option value="6" @if($data['start_month'] == 6) selected @endif>June</option>
                                <option value="7" @if($data['start_month'] == 7) selected @endif>July</option>
                                <option value="8" @if($data['start_month'] == 8) selected @endif>August</option>
                                <option value="9" @if($data['start_month'] == 9) selected @endif>September</option>
                                <option value="10" @if($data['start_month'] == 10) selected @endif>October</option>
                                <option value="11" @if($data['start_month'] == 11) selected @endif>November</option>
                                <option value="12" @if($data['start_month'] == 12) selected @endif>December</option>
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
                                <option value="1" @if($data['end_month'] == 1) selected @endif>January</option>
                                <option value="2" @if($data['end_month'] == 2) selected @endif>February</option>
                                <option value="3" @if($data['end_month'] == 3) selected @endif>March</option>
                                <option value="4" @if($data['end_month'] == 4) selected @endif>April</option>
                                <option value="5" @if($data['end_month'] == 5) selected @endif>May</option>
                                <option value="6" @if($data['end_month'] == 6) selected @endif>June</option>
                                <option value="7" @if($data['end_month'] == 7) selected @endif>July</option>
                                <option value="8" @if($data['end_month'] == 8) selected @endif>August</option>
                                <option value="9" @if($data['end_month'] == 9) selected @endif>September</option>
                                <option value="10" @if($data['end_month'] == 10) selected @endif>October</option>
                                <option value="11" @if($data['end_month'] == 11) selected @endif>November</option>
                                <option value="12" @if($data['end_month'] == 12) selected @endif>December</option>
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
                            <input type="time" name="start_time" value="{{ $data['start_time'] }}" class="form-control" id="start_time" placeholder="Start Time" required>
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
                            <input type="time" name="end_time" value="{{ $data['end_time'] }}" class="form-control" id="end_time" placeholder="End Time" required>
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
                                <option value="1" @if($data['delivery_method'] == 1) selected @endif>Normal Delivery</option>
                                <option value="2" @if($data['delivery_method'] == 2) selected @endif>Express Delivery</option>
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
                                <option value="1" @if($data['delivery_method'] == 1) selected @endif>Active</option>
                                <option value="0" @if($data['delivery_method'] == 0) selected @endif>Inactive</option>
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


