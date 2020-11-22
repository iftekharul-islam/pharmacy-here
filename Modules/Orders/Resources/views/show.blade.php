@extends('adminlte::page')

@section('title', 'order Details')

@section('content_header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>Order Information</h4>

                        </div>
                        <div class="card-body">
                            <strong>Pharmacy Name : </strong>
                            <span>{{ $data->pharmacy->pharmacyBusiness->pharmacy_name ?? '' }}</span><br>
                            <strong>Customer Name : </strong> <span>{{ $data->customer->name ?? '' }}</span><br>
                            <strong>Delivery Address : </strong>
                            <span>{{ $data->address->address . ', ' . $data->address->area->name . ', ' . $data->address->area->thana->name .', '. $data->address->area->thana->district->name  }}</span><br>
                            <strong>Customer Phone : </strong> <span>{{ $data->customer->phone_number }}</span><br>
                            @if ($data->cancelReason !== null)
                                <strong>Cancel Reason : </strong> <span>{{ $data->cancelReason->reason}}</span><br>
                            @endif
                            @if ($data->delivery_type !== 2)
                                <strong>Delivery type:</strong>
                                @if ($data->delivery_method == 'express')
                                    Express Delivery
                                @elseif ($data->delivery_method == 'normal')
                                    Normal Delivery
                                @endif
                            @endif
                            <br>
                            <strong>Payment Type:</strong>
                            @if ($data->payment_type == 1)
                                Cash on Delivery
                            @else
                                Online Payment
                            @endif
                            <br>
                            <strong>Delivery Time:</strong>
                            {{ $data->delivery_duration ?? 'N/A' }}
                            <br>
                            <strong>Charge Amount:</strong>
                            {{ $data->delivery_charge }}
                            <br>
                            <strong>Total Amount:</strong>
                            {{ $data->delivery_charge + $data->amount }}
                            <br>
                        </div>
                    </div>

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
            <h3 class="card-title">Medicine List</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive">
            <table id="example1" class="table  mb-3">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>Medicine Name</th>
                    <th>Quantity</th>
                    <th>Amount</th>
                    {{--                    <th>Action</th>--}}
                </tr>
                </thead>
                <tbody>
                @if($data->orderItems->isNotEmpty())
                    @foreach($data->orderItems as $index => $item)
                        <tr>
                            <td>{{  $index++ }}</td>
                            <td>{{ $item->product['name'] }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->quantity * $item->product->purchase_price }}</td>

                            <td>
                                {{--                                <button type="button" onclick="showProduct({{ $item }})" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-default">--}}
                                {{--                                    <i class="fa fa-eye"></i>--}}
                                {{--                                </button>--}}
                                {{--                                <a href="{{ route('transactionHistory.create', $item['id']) }}" class="btn btn-sm btn-primary">--}}
                                {{--                                    <i class="fa fa-edit"></i> </a>--}}

                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
            {{--            {{ $data->links() }}--}}
        </div>
        <!-- /.card-body -->
    </div>

@endsection


