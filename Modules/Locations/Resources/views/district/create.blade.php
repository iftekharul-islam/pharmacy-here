{{--@extends('products::layouts.master')--}}
@extends('adminlte::page')
@section('title', 'Create Districts')

@section('content')
    <div class="col-md-6">
        <div class="card card-primary-outline">
            <div class="card-header">
                <h3 class="card-title">Create District</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('district.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label for="name" class="col-sm-4 col-form-label">Name(English)</label>
                        <div class="col-sm-8" id="">
                            <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" placeholder="District Name" required>
                            @if ($errors->has('name'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bn_name" class="col-sm-4 col-form-label">Name(Bangla)</label>
                        <div class="col-sm-8" id="">
                            <input type="text" name="bn_name" class="form-control" id="bn_name" value="{{ old('bn_name') }}" placeholder="District Name(Bangla)" required>
                            @if ($errors->has('bn_name'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('bn_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="division_id" class="col-sm-4 col-form-label">Division</label>
                        <div class="col-sm-8  ">

                            <select class="form-control" name="division_id" required>
                                <option value="" hidden selected>Select Division</option>
                                @foreach($divisions as $item)
                                <option value="{{ $item->id }}" @if($item->id == old('division_id')) selected @endif>{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('division_id'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('division_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="status" class="col-sm-4 col-form-label">Active</label>
                        <div class="col-sm-8  ">
                            <select class="form-control" name="status" required>
                                <option value="1" @if(old('status') == 1) selected @endif>Yes</option>
                                <option value="0" @if(old('status') == 0) selected @endif>No</option>
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
                    <a href="{{ route('districts') }}" class="btn btn-danger">Back</a>
                    <button type="submit" class="btn btn-primary">Create</button>
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


