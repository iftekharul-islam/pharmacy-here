{{--@extends('products::layouts.master')--}}
@extends('adminlte::page')
@section('title', 'Create Notice')
<style type="text/css">
    .error{
        color: red;
    }
</style>
@section('content')
    <div class="col-md-6">
        <div class="card card-primary-outline">
            <div class="card-header">
                <h3 class="card-title">Notice details</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="form-group row">
                    <label for="notice" class="col-sm-4 col-form-label">Notice</label>
                    <label for="notice" class="col-sm-8 col-form-label">{{ $data->notice }}</label>
                </div>
                <div class="form-group row">
                    <label for="notice" class="col-sm-4 col-form-label">Notice(Bangla)</label>
                    <label for="notice" class="col-sm-8 col-form-label">{{ $data->bn_notice }}</label>
                </div>

                <div class="form-group row">
                    <label for="status" class="col-sm-4 col-form-label">Status</label>
                    <label for="status" class="col-sm-4 col-form-label">
                        @if($data->status == 1)
                            <a href="javascript:void(0)" class="btn btn-success">Active</a>
                        @else
                            <a href="javascript:void(0)" class="btn btn-f">Inactive</a>
                        @endif
                    </label>
                </div>

            </div>
        </div>
    </div>
    <div class="card">
                <div class="card-header">
                    <h3 class="card-title">User list</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive">
                    <table id="example1" class="table  mb-3">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>User Type</th>
                            <th>Area</th>
                        </tr>
                        </thead>
                        @foreach($data->UserNotices as $key=>$item)
                            @php
                                $user = $item->user->name ?? '';
                            @endphp
                            <tbody>
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $item->pharmacy->pharmacy_name ?? $user }}</td>
                                    <td>{{ $data->type == 1 ? 'Pharmacy' : 'Customer' }}</td>
                                    <td>{{ $item->pharmacy->area->name ?? 'N/A' }}</td>
                                </tr>
                            </tbody>
                        @endforeach
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
@endsection


