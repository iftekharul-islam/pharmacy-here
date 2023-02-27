{{--@extends('products::layouts.master')--}}
@extends('adminlte::page')

@section('adminlte_css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<style>
      .select2-container .select2-selection--single{height:auto;}
      .select2-container--default .select2-selection--single .select2-selection__rendered{line-height: 1;}
  </style>
@endsection

@section('title', 'Manual Points')

@section('content')



    <div class="col-md-6">
        @if(session('success'))
            <div id="successMessage" class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif (session('failed'))
            <div id="successMessage" class="alert alert-danger">
                {{ session('failed') }}
            </div>
        @endif

        <div class="card card-primary-outline">
            <div class="card-header">
                <h3 class="card-title">Create Manual Points</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('point.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label for="customer_id" class="col-sm-4 col-form-label">Customer</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="customer_id"  required>
                                <option value="" selected>Select Customer</option>
                                @if($customer->isNotEmpty())
                                    @foreach($customer as $item)
                                        <option value="{{ $item->id }}"  @if($item->id == old('customer_id')) selected @endif>{{ $item->name }}</option>
                                    @endforeach
                                @endif
                            </select>

                            @if ($errors->has('customer_id'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('customer_id') }}</strong>
                                </span>
                            @endif

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="point" class="col-sm-4 col-form-label">Point</label>
                        <div class="col-sm-8" id="">
                            <input type="number" name="point" class="form-control" value="{{ old('point') }}" id="bn_name" placeholder="Point" required>
                            @if ($errors->has('point'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('point') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <a href="{{ url()->previous() }}" class="btn btn-danger">Back</a>
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


