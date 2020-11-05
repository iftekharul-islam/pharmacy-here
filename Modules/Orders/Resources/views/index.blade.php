@extends('adminlte::page')
@section('title', 'Orders')
@section('content')
    <!-- @auth("web")
        <h1>Hello world</h1>
{{ Auth::guard('web')->user()->can('create.user') }}

    @endauth -->

    <div class="card">
        <div class="card-body">
            <form action="{{ route('orders.index') }}">
                <div class="row">
                <div class="col-4-xxxl col-lg-4 col-4 form-group">
                    <label>Start date</label>
                    <input name="start_date" type="date" class="form-control" value="{{ $display_Sdate ?? $display_Sdate  }}">
                </div>
                <div class="col-4-xxxl col-lg-4 col-4 form-group">
                    <label>End date</label>
                    <input name="end_date" type="date" class="form-control" value="{{ $display_Edate ?? $display_Edate  }}">
                </div>
                <div class="col-4-xxxl col-lg-4 col-4 form-group">
                    <label>Type</label>
                    <select name="status" class="form-control" id="">
                        <option value="" selected disabled>Select a type</option>
                        <option value="3" {{ $status == 3 ? 'selected' : ''}} >Completed</option>
                        <option value="2" {{ $status == 2 ? 'selected' : '' }}>Processing</option>
                        <option value="0" {{ $status === 0 ? 'selected' : '' }}>Pending</option>
                        <option value="10" {{ $status == 10 ? 'selected' : '' }}>Canceled</option>
                        <option value="9" {{ $status == 9 ? 'selected' : '' }}>On The Way</option>
                        <option value="1" {{ $status == 1 ? 'selected' : '' }}>Accepted</option>
                        <option value="7" {{ $status == 7 ? 'selected' : '' }}>Orphan</option>
                    </select>
                </div>
                <div class="col-12 form-group mg-t-2 float-right">
                    <button type="submit" class="btn btn-primary float-right">Search</button>
                </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Order List</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive">
            <table id="example1" class="table  mb-3">
                <thead>
                <tr>
                    <th>Order No</th>
                    <th>Pharmacy Name</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @if($data->isNotEmpty())
                    @foreach($data as $index => $item)
                        <tr>
                            <td>{{ $item->order_no }}</td>
                            <td>{{ $item->pharmacy->pharmacyBusiness['pharmacy_name'] }}</td>
                            <td>{{ $item->amount }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td>@include('orders::status', ['status' => $item->status])</td>

                            <td>
                                <a href="{{ route('orders.show', $item->id) }}" type="button"  class="btn btn-sm btn-success" >
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach

                @endif
                </tbody>
            </table>
            {{ $data->links() }}
        </div>
        <!-- /.card-body -->
    </div>

@endsection


