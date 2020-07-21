{{--@extends('products::layouts.master')--}}
@extends('adminlte::page')


@section('content')
    <div class="col-md-6">
        <div class="card card-primary-outline">
            <div class="card-header">
                <h3 class="card-title">Update Product Unit</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('unit.update', $unit['id']) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label for="name" class="col-sm-4 col-form-label">Name</label>
                        <div class="col-sm-8  " id="name">
                            <input type="text" name="name" value="{{ $unit->name ?? '' }}" class="form-control" id="name" placeholder="Name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="status" class="col-sm-4 col-form-label">Status</label>
                        <div class="col-sm-8" id="">
                            <select class="form-control" name="status" id="status">
                                <option value="1" @if ($unit->status == 1) selected @endif>Active</option>
                                <option value="0" @if ($unit->status == 0) selected @endif>Inactive</option>
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



