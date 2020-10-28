@extends('adminlte::page')

@section('title', 'Transaction History')

@section('content_header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>COD Transaction History</h1>
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
            <form action="{{ route('cod.transactionHistory.show', $userId) }}">
                <div class="row">
                    <div class="col-6-xxxl col-lg-6 col-6 form-group">
                        <label>Start date</label>
                        <input name="start_date" type="date" class="form-control" value="{{ $startDate ?? $startDate }}">
                    </div>
                    <div class="col-6-xxxl col-lg-6 col-6 form-group">
                        <label>End date</label>
                        <input name="end_date" type="date" class="form-control" value="{{ $endDate ?? $endDate }}">
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
            <h3 class="card-title">COD Payment History</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive">
            <table id="example1" class="table  mb-3">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>Date</th>
                    <th>Order Amount</th>
                    <th>Pharmacy Amount</th>
                    <th>Subidha Amount</th>
                </tr>
                </thead>
                <tbody>
                @if($data->isNotEmpty())
                    @foreach($data as $index => $item)
                        <tr>
                            <td>{{ $data->firstItem() + $index }}</td>
                            <td>{{ date('d F, Y', strtotime($item->order_date)) }}</td>
                            <td>{{ $item->customer_amount }}</td>
                            <td>{{ $item->pharmacy_amount }}</td>
                            <td>{{ $item->subidha_comission }}</td>
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


