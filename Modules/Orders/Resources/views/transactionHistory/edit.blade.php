{{--@extends('products::layouts.master')--}}
@extends('adminlte::page')
@section('title', 'Edit Notice')

@section('content')
    <div class="col-md-6">
        <div class="card card-primary-outline">
            <div class="card-header">
                <h3 class="card-title">Edit Notice</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('notice.update', $data['id']) }}" method="POST">

                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group row">
                        <label for="notice" class="col-sm-4 col-form-label">Notice</label>
                        <div class="col-sm-8" id="">
                            <input type="text" name="notice" value="{{ $data->notice }}" class="form-control" id="notice" placeholder="Notice" required>
                            @if ($errors->has('notice'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('notice') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bn_notice" class="col-sm-4 col-form-label">Notice(Bangla)</label>
                        <div class="col-sm-8  " id="name">
                            <input type="text" name="bn_notice" value="{{ $data->bn_notice }}" class="form-control" id="bn_notice" placeholder="Notice(Bangla)" required>
                            @if ($errors->has('bn_notice'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('bn_notice') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="status" class="col-sm-4 col-form-label">Status</label>
                        <div class="col-sm-8" id="">
                            <select class="form-control" name="status" id="status">
                                <option value="1" @if ($data->status == 1) selected @endif>Active</option>
                                <option value="0" @if ($data->status == 0) selected @endif>Inactive</option>
                            </select>
                            @if ($errors->has('status'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('status') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="type" class="col-sm-4 col-form-label">User Type</label>
                        <div class="col-sm-8" id="">
                            <select class="form-control" name="type" id="type">
                                <option value="1" @if ($data->type == 1) selected @endif>Pharmacy</option>
                                <option value="2" @if ($data->type == 2) selected @endif>Customer</option>
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


