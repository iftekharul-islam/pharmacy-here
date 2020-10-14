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

    <div class="card col-md-6">
        <div class="card-body">
            <form method="get" action="{{ route('transactionHistory.index') }}">
{{--                <div class="row">--}}
                    <div class="form-group">
                        <label>Area</label>
                        <select name="area_id" class="form-control" id="">
                            <option value="" selected disabled>Select area</option>
                            @foreach($areas as $area)
                                    <option value="{{ $area->id }}" {{ $area->id == $areaId ? 'selected' : '' }}>{{ $area->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class=" form-group mg-t-2 float-right">
                        <button type="submit" class="btn btn-primary float-right">Search</button>
                    </div>
{{--                </div>--}}
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Transactions of Pharmacy</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive">
            @if (count($transactionHistories) > 0)
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
                    @foreach($transactionHistories as $index => $item)
                        <?php $i = 1?>
                        <tr>
                            <td>{{ $i + $index }}</td>
                            <td>{{ $item->pharmacy->pharmacy_name }}</td>
                            <td>{{ $item->amount }}</td>
                            <td>{{ $item->pharmacy->pharmacyOrder[0]->amount }}</td>
                            <td>{{ $item->amount - $item->pharmacy->pharmacyOrder[0]->amount   }}</td>
                            <td>
                                <a href="{{ route('transactionHistory.show', $item->pharmacy_id) }}" type="button"  class="btn btn-sm btn-success" >
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ route('transactionHistory.create', $item->pharmacy_id) }}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-plus"></i> </a>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <h4 class="text-center">No data found !</h4>
            @endif
{{--            {{ $orders->links() }}--}}
        </div>
        <!-- /.card-body -->
    </div>

@endsection


