@extends('adminlte::page')

@section('title', 'Transaction History')

@section('content_header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Payment History</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
@stop

@section('content')
    <!-- @auth("web")
        {{ Auth::guard('web')->user()->can('create.user') }}
    @endauth -->

    <div class="card">
        <div class="card-body">
            <form action="{{ route('transactionHistory.show', $userId) }}">
                <div class="row">
                    <div class="col-6-xxxl col-lg-6 col-6 form-group">
                        <label>Start date</label>
                        <input name="start_date" type="date" class="form-control" value="{{ $startDate ?? '' }}">
                    </div>
                    <div class="col-6-xxxl col-lg-6 col-6 form-group">
                        <label>End date</label>
                        <input name="end_date" type="date" class="form-control" value="{{ $endDate ?? '' }}">
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
            <h3 class="card-title">Payment History</h3>
            <a class="btn btn-success float-right"
               href="{{ route('export.transaction.history', [ 'toDate' => $startDate, 'endDate' => $endDate, 'userId' => $userId ]) }}">Export
                transaction
            </a>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive">
            @if(count($data) > 0)
                <table id="example1" class="table  mb-3">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Date</th>
                        <th>Transaction ID</th>
                        <th>Payment Through</th>
                        <th>Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $index => $item)
                        <tr>
                            <td>{{ $data->firstItem() + $index }}</td>
                            <td>{{ date('d F, Y', strtotime($item->date)) }}</td>
                            <td>{{ $item->transaction_id }}</td>
                            <td>{{ $item->payment_method }}</td>
                            <td>{{ $item->amount }}</td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
                {{ $data->links() }}
            @else
                <h3 class="text-center">No data Found !!!</h3>
            @endif
        </div>
        <!-- /.card-body -->
    </div>

@endsection
