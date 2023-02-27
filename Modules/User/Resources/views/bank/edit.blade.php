{{--@extends('products::layouts.master')--}}
@extends('adminlte::page')
@section('title', 'Edit Bank')

@section('content')
    <div class="col-md-6">
        <div class="card card-primary-outline">
            <div class="card-header">
                <h3 class="card-title">Edit Bank</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('bank.update', $data['id']) }}" method="POST">

                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group row">
                        <label for="bank_name" class="col-sm-6 col-form-label">Bank Name</label>
                        <div class="col-sm-6" id="">
                            <input type="text" name="bank_name" value="{{ $data->bank_name }}" class="form-control" id="bank_name" placeholder="Bank Name" required>
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
                            <input type="text" name="bn_bank_name" value="{{ $data->bn_bank_name }}" class="form-control" id="bn_bank_name" placeholder="Bank Name (Bangla)" required>
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


