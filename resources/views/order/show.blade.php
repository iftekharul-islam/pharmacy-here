@extends('layouts.app')
<style>
    .my-table {
        margin-left: -12px!important;
        width: 20px;
    }
</style>
@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif (session('failed'))
        <div class="alert alert-danger">
            {{ session('failed') }}
        </div>
    @endif
    <div class="order-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="my-dashboard-title">My Orders Details</h2>
                </div>
                <div class="col-5">
                    <table class="my-table table table-borderless">
                        <tr>
                            <th>Order no</th>
                            <td>#{{ $data->order_no }}</td>
                        </tr>
                        <tr>
                            <th>Order date:</th>
                            <td>{{ date('d F Y', strtotime($data->order_date)) }}</td>
                        </tr>
                        <tr>
                            <th>Address:</th>
                            <td>{{ $data->address->address }}, {{ $data->address->area->name }}, {{ $data->address->area->thana->name }}, {{ $data->address->area->thana->district->name }}.</td>
                        </tr>
                        <tr>
                            <th>Payment Type:</th>
                            <td>
                                @if ($data->payment_type == 1)
                                    Cash on Delivery
                                @else
                                    Online Payment
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Delivery Type:</th>
                            <td>{{ $data->delivery_type == 1 ? 'Home Delivery' : 'Pharmacy Pickup' }}</td>
                        </tr>
                        @if ($data->delivery_type != 2)
                            <tr>
                                <th>Delivery Method:</th>
                                <td>
                                    @if ($data->delivery_method = 'express')
                                        Express Delivery
                                    @elseif ($data->delivery_method = 'normal')
                                        Normal Delivery
                                    @endif
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <th>Delivery date:</th>
                            <td>
                                {{ date('d F Y', strtotime($data->delivery_date)) }}
                            </td>
                        </tr>
                        <tr>
                            <th>Delivery Time:</th>
                            <td>
                                {{ $data->delivery_time }}
                            </td>
                        </tr>
                        <tr>
                            <th>Charge Amount:</th>
                            <td>
                                {{ $data->delivery_charge }}
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-10">
                <div class="my-order-list">
                    <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Product</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Sub total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($data['orderItems'] as $product)
                                    <tr>
                                        <td>{{ $product->product->name }}</td>
                                        <td>{{ $product->product->purchase_price }}</td>
                                        <td>{{ $product->quantity }}</td>
                                        <td>{{ $product->quantity * $product->product->purchase_price }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfooter>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><strong>Grand Total : </strong>৳  {{ $data->amount + $data->delivery_charge }}</td>
                                    </tr>
                                </tfooter>
                            </table>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection
