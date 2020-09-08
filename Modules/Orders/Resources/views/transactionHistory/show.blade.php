@extends('adminlte::page')

@section('title', 'Transaction History')

@section('content_header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Transaction History</h1>
                </div>
                {{--                <div class="col-sm-6">--}}
                {{--                    <a href="{{ route('transactionHistory.create') }}" class="btn btn-sm btn-success float-right">--}}
                {{--                        Create Notice--}}
                {{--                    </a>--}}
                {{--                </div>--}}
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
            <h3 class="card-title">Transaction History List</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive">
            <table id="example1" class="table  mb-3">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>Date</th>
                    <th>Transaction ID</th>
                    <th>Pharmacy Name</th>
                    <th>Payment Method</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @if($data->isNotEmpty())
                    @foreach($data as $index => $item)
                        <tr>
                            <td>{{ $data->firstItem() + $index }}</td>
                            <td>{{ date('d F, Y', strtotime($item->date)) }}</td>
                            <td>{{ $item->transaction_id }}</td>
                            <td>{{ $item->pharmacy->pharmacyBusiness['pharmacy_name'] }}</td>
                            <td>{{ $item->payment_method }}</td>
                            <td>{{ $item->amount }}</td>

                            <td>
                                {{--                                <button type="button" onclick="showProduct({{ $item }})" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-default">--}}
                                {{--                                    <i class="fa fa-eye"></i>--}}
                                {{--                                </button>--}}
                                <a href="{{ route('transactionHistory.create', $item['id']) }}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-edit"></i> </a>

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


