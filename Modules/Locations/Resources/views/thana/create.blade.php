{{--@extends('products::layouts.master')--}}
@extends('adminlte::page')
@section('title', 'Create Thana')

@section('adminlte_css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<style>
      .select2-container .select2-selection--single{height:auto;}
      .select2-container--default .select2-selection--single .select2-selection__rendered{line-height: 1;}
  </style>
@endsection

@section('content')
    <div class="col-md-6">
        <div class="card card-primary-outline">
            <div class="card-header">
                <h3 class="card-title">Create Thana</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('thana.store') }}" method="POST">
                @csrf 
                <div class="card-body">
                    <div class="form-group row">
                        <label for="name" class="col-sm-4 col-form-label">Name(English)</label>
                        <div class="col-sm-8" id="">
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" id="name" placeholder="Thana Name" required>
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
                            <input type="text" name="bn_name" class="form-control" value="{{ old('bn_name') }}" id="bn_name" placeholder="Thana Name(Bangla)" required>
                            @if ($errors->has('bn_name'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('bn_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="district_id" class="col-sm-4 col-form-label">District</label>
                        <div class="col-sm-8  ">

                            <select class="form-control select2" name="district_id" required>
                                <option value="" hidden selected>Select District</option>
                                @if($districts->isNotEmpty())
                                    @foreach($districts as $item)
                                        <option value="{{ $item->id }}"  @if($item->id == old('district_id')) selected @endif>{{ $item->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @if ($errors->has('district_id'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('district_id') }}</strong>
                                </span>
                            @endif

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="status" class="col-sm-4 col-form-label">Active</label>
                        <div class="col-sm-8  ">
                            <select class="form-control" name="status" required>
                                <option value="1" @if(old('status') == 1) selected @endif>Yes</option>
                                <option value="0" @if(old('status') === 0) selected @endif>No</option>
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
                    <a href="{{ route('thana') }}" class="btn btn-danger">Back</a>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('adminlte_js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
     $(document).ready(function() {
            $('.select2').select2();
        });
</script>
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


