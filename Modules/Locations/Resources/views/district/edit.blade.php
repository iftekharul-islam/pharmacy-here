{{--@extends('products::layouts.master')--}}
@extends('adminlte::page')
@section('title', 'Edit Districts')

@section('content')
    <div class="col-md-6">
        <div class="card card-primary-outline">
            <div class="card-header">
                <h3 class="card-title">Edit District</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('district.update', $district->id) }}" method="POST">
                @csrf
                @method('PUT')
                @if($errors->any())
                    {!! implode('', $errors->all('<div>:message</div>')) !!}
                @endif
                <div class="card-body">
                    <div class="form-group row">
                        <label for="name" class="col-sm-4 col-form-label">Name(English)</label>
                        <div class="col-sm-8" id="">
                            <input type="text" name="name" class="form-control" id="name" placeholder="District Name" value="{{ $district->name }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bn_name" class="col-sm-4 col-form-label">Name(Bangla)</label>
                        <div class="col-sm-8" id="">
                            <input type="text" name="bn_name" class="form-control" id="bn_name" placeholder="District Name(Bangla)" value="{{ $district->bn_name }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="division_id" class="col-sm-4 col-form-label">Division</label>
                        <div class="col-sm-8  ">

                            <select class="form-control" name="division_id" required>
                                <option value="" hidden selected></option>
                                @foreach($divisions as $item)
                                <option value="{{ $item->id }}" @if($item->id == $district->division_id) selected @endif >{{ $item->name }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="status" class="col-sm-4 col-form-label">Active</label>
                        <div class="col-sm-8  ">
                            <select class="form-control" name="status" required>
                                <option value="1" @if($district->status == 1) selected @endif >Yes</option>
                                <option value="0" @if($district->status == 0) selected @endif>No</option>
                            </select>

                        </div>
                    </div>
                    
                
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
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


