@extends('adminlte::page')

@section('title', 'Orders')

@section('content_header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-4">
                    <a href="{{ route('orders.index') .'?status=0'  }}">
                    <div class="card">
                        <h2 class="card-body text-center">Pending</h2>
                    </div>
                    </a>
                </div>
                <div class="col-sm-4">
                    <a href="{{ route('orders.index') .'?status=2'  }}">
                    <div class="card">
                        <h2 class="card-body text-center">Processing</h2>
                    </div>
                    </a>
                </div>
                <div class="col-sm-4">
                    <a href="{{ route('orders.index') .'?status=3'  }}">
                    <div class="card">
                        <h2 class="card-body text-center">Completed</h2>
                    </div>
                    </a>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
@stop

@section('content')
    <!-- @auth("web")
        <h1>Hello world</h1>
{{ Auth::guard('web')->user()->can('create.user') }}

    @endauth -->


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


