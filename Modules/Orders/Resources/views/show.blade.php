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
                            <strong>Payment Type:</strong>
                            @if ($data->payment_type === 1)
                                Cash on Delivery
                            @else
                                Online Payment
                            @endif
                            <br>
                            <strong>Delivery type:</strong>
                            @if ($data->delivery_type !== 2)
                                @if ($data->delivery_method == 'express')
                                    Express Delivery
                                @elseif ($data->delivery_method == 'normal')
                                    Normal Delivery
                                @endif
                            @else
                                Pick up from Pharmacy
                            @endif
                            <br>
                            <strong>Delivery Time:</strong>
                            {{ $data->delivery_duration ?? 'N/A' }}
                            <br>
                            <strong>Delivery Date:</strong>
                            {{ $data->delivery_date ?? 'N/A' }}
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
                            @isset($data->ssl_charge)
                                <strong>SSL Amount:</strong>
                                {{ $data->ssl_charge }}
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
    @auth("web")
    {{ Auth::guard('web')->user()->can('create.user') }}
    @endauth
    @if(count($data->prescriptions) > 0)
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Prescription list</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($data->prescriptions as $item)
                            <div class="col-md-4">
                                <a href="{{ $item->url }}" target="_blank">
                                    <img src="{{ $item->url }}" alt="prescription" width="150px" height="200px">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                </div>
            </div>
        </div>
    @endif
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
                    <th>Company name</th>
                    <th>Generic</th>
                    <th>Strength</th>
                    <th>Packing type</th>
                    <th>Form</th>
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
                            <td>{{ $item->product['company']->name }}</td>
                            <td>{{ $item->product['Generic']->name }}</td>
                            <td>{{ $item->product['strength'] }}</td>
                            <td>{{ $item->product['primaryUnit']['name'] }}</td>
                            <td>{{ $item->product['form']->name }}</td>
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
