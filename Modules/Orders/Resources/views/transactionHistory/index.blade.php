@extends('adminlte::page')

@section('title', 'Transaction History')

@section('content_header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Transactions</h1>
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
            <h3 class="card-title">Transactions of Pharmacy</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive">
            <table id="example1" class="table  mb-3">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>Pharmacy Name</th>
                    <th>Order Amount</th>
                    <th>Paid Amount</th>
                    <th>Due Amount</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @if(! empty($orders))
                    @foreach($orders as $index => $item)
                        <?php $i = 1?>
                        <tr>
                            <td>{{ $i + $index }}</td>
                            <td>{{ $item->pharmacy_name }}</td>
{{--                            <td>{{ $item->pharmacy->pharmacyBusiness['pharmacy_name'] }}</td>--}}
                            <td>{{ $item->total_amount }}</td>
{{--                            <td>{{ $item->total_amount }}</td>--}}
                            <td>{{ $transactionHistories[$index]->amount ?? 0 }}</td>
{{--                            <td>{{ $item->amount }}</td>--}}
                            <td>{{ $due[$index]->due ?? 0 }}</td>
{{--                            <td>{{ $item->total_amount - $item->amount }}</td>--}}

                            <td>
                                <a href="{{ route('transactionHistory.show', $item->pharmacy_id) }}" type="button"  class="btn btn-sm btn-success" >
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ route('transactionHistory.create', $item->pharmacy_id) }}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-edit"></i> </a>

                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
{{--            {{ $orders->links() }}--}}
        </div>
        <!-- /.card-body -->
    </div>

@endsection


