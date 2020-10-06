@extends('layouts.app')
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
                <div class="col-6">
                    <h2 class="my-dashboard-title">My Orders details</h2>
                </div>
                <div class="col-8">
                    <strong>Order no</strong>
                    <label> #{{ $data->order_no }} </label> &nbsp; &nbsp; &nbsp; &nbsp;
                    <strong>Order date :</strong>
                    <label>{{ date('d F Y', strtotime($data->order_date)) }} </label><br>
                    <strong>Address :</strong>
                    <label> {{ $data->address->address }}, {{ $data->address->area->name }}, {{ $data->address->area->thana->name }}, {{ $data->address->area->thana->district->name }}.</label><br>
                    <strong>Payment method :</strong>
                    <label>@if ($data->payment_type == 1)
                               Home delivery
                           @else
                                Pharmacy Pickup
                           @endif
                    </label><br>
                    <strong>Payment Type :</strong>
                    <label>
                        @if ($data->payment_type == 1)
                            <a class="badge badge-primary text-white">Cash on delivery</a>
                        @else
                            <a class="badge badge-primary text-white">Online payment</a>
                        @endif
                    </label><br>
                    @if ($data->delivery_type != 2)
                        <strong>Delivery Type :</strong>
                        <label>@if ($data->delivery_method = 'express')
                                   Express Delivery
                               @elseif ($data->delivery_method = 'normal')
                                   Normal Delivery
                               @endif
                        </label><br>
                    @endif
                    <strong>Delivery date :</strong>
                    <label>{{ date('d F Y', strtotime($data->delivery_date)) }}</label><br>
                    <strong>Delivery Time :</strong>
                    <label>{{ $data->delivery_time }}</label><br>
                    <strong>Charge Amount :</strong>
                    <label>{{ $data->delivery_charge }}</label><br>

                </div>
                <div class="col-8">
                <div class="my-order-list">
                    <div class="table-responsive">
{{--                        @if (count($orders) > 0)--}}
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
                            </table>
{{--                        @else--}}
{{--                            <h4 class="text-center">No data available</h4>--}}
{{--                        @endif--}}
                    </div>
                    <p><strong>Grand Total:</strong> {{ $data->amount + $data->delivery_charge }}</p>

                </div>
                </div>
            </div>
        </div>
    </div>
@endsection
