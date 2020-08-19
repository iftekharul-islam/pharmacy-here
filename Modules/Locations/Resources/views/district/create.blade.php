{{--@extends('products::layouts.master')--}}
@extends('adminlte::page')
@section('title', 'Districts')

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
                @if($errors->any())
                    {!! implode('', $errors->all('<div>:message</div>')) !!}
                @endif
                <div class="card-body">
                    <div class="form-group row">
                        <label for="name" class="col-sm-4 col-form-label">Name(English)</label>
                        <div class="col-sm-8" id="">
                            <input type="text" name="name" class="form-control" id="name" placeholder="District Name" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bn_name" class="col-sm-4 col-form-label">Name(Bangla)</label>
                        <div class="col-sm-8" id="">
                            <input type="text" name="bn_name" class="form-control" id="bn_name" placeholder="District Name(Bangla)" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="division_id" class="col-sm-4 col-form-label">Division</label>
                        <div class="col-sm-8  ">

                            <select class="form-control" name="division_id" required>
                                <option value="" hidden selected></option>
                                @foreach($divisions as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
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


