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
                            <strong>Delivery type:</strong>
                            @if ($data->delivery_type !== 2)
                                @if ($data->delivery_method == 'express')
                                    Express Delivery
                                @elseif ($data->delivery_method == 'normal')
                                    Normal Delivery
                                @endif
                                <br>
                                @if ($data->payment_type === 1)
                                    <strong>Payment Type:</strong>
                                    Cash on Delivery
                                @else
                                    Online Payment
                                    <br>
                                @endif
                            @else
                                Pick up from Pharmacy
                                <br>
                            @endif
                            <strong>Delivery Time:</strong>
                            {{ $data->delivery_duration ?? 'N/A' }}
                            <br>
                            @if ($data->payment_type === 1 && $data->delivery_type === 2)
                                <strong>Discount Amount:</strong>
                            @else
                                <strong>Charge Amount:</strong>
                            @endif
                            {{ $data->delivery_charge }}
                            <br>
                            <strong>Total Amount:</strong>
                            {{ $data->customer_amount }}
                            <br>
                            @isset($data->point_amount)
                                <strong>Point Amount:</strong>
                                {{ $data->point_amount }}
                                <br>
                            @endisset
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
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>

@endsection
