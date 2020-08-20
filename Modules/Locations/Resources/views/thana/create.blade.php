{{--@extends('products::layouts.master')--}}
@extends('adminlte::page')
@section('title', 'Create Thana')

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
                @if($errors->any())
                    {!! implode('', $errors->all('<div>:message</div>')) !!}
                @endif
                <div class="card-body">
                    <div class="form-group row">
                        <label for="name" class="col-sm-4 col-form-label">Name(English)</label>
                        <div class="col-sm-8" id="">
                            <input type="text" name="name" class="form-control" id="name" placeholder="Thana Name" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bn_name" class="col-sm-4 col-form-label">Name(Bangla)</label>
                        <div class="col-sm-8" id="">
                            <input type="text" name="bn_name" class="form-control" id="bn_name" placeholder="Thana Name(Bangla)" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="district_id" class="col-sm-4 col-form-label">District</label>
                        <div class="col-sm-8  ">

                            <select class="form-control" name="district_id" required>
                                <option value="" hidden selected></option>
                                @if($districts->isNotEmpty())
                                    @foreach($districts as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                @endif
                            </select>

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="status" class="col-sm-4 col-form-label">Active</label>
                        <div class="col-sm-8  ">
                            <select class="form-control" name="status" required>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>

                        </div>
                    </div>
                    
                
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
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


