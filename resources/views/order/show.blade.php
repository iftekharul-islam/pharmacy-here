@extends('layouts.app')
<style>
    .my-table {
        margin-left: -12px!important;
        width: 20px;
    }
    .my-table tr th {
        min-width: 157px!important;
    }
    .btn--primary{
        border: none!important;
    }
</style>
@section('content')
    @if(session('success'))
        <div id="successMessage" class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif (session('failed'))
        <div id="successMessage" class="alert alert-danger">
            {{ session('failed') }}
        </div>
    @endif
    <div class="order-section">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <h2 class="my-dashboard-title">{{ __('text.my_order_detials') }}</h2>
{{--                <div class="col-5">--}}
                    <table class="my-table table table-borderless">
                        <tr>
                            <th>{{ __('text.order_no') }}</th>
                            <td>#{{ $data->order_no }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('text.order_date') }}:</th>
                            <td>{{ date('d F Y', strtotime($data->order_date)) }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('text.address') }}:</th>
                            <td>{{ $data->address->address }}, {{ $data->address->area->name }}, {{ $data->address->area->thana->name }}, {{ $data->address->area->thana->district->name }}.</td>
                        </tr>
                        <tr>
                            <th>{{ __('text.status') }}:</th>
                            <td>
                                @if ($data->status == 0)
                                    <span class="badge badge-danger">Pending</span>
                                @elseif ($data->status == 1)
                                    <span class="badge badge-warning">Accepted</span>
                                @elseif ($data->status == 2)
                                    <span class="badge" style="background: #FFFF00">Processing</span>
                                @elseif ($data->status == 3)
                                    <span class="badge badge-success">Completed</span>
                                @elseif ($data->status == 4)
                                    <span class="badge badge-info">Failed</span>
                                @elseif ($data->status == 5)
                                    <span class="badge badge-danger">Rejected By Pharmacy</span>
                                @elseif ($data->status == 6)
                                    <span class="badge badge-info">Forwarded</span>
                                @elseif ($data->status == 7)
                                    <span class="badge badge-danger">Expired</span>
                                @elseif ($data->status == 8)
                                    <span class="badge badge-info">Orphan</span>
                                @elseif ($data->status == 9)
                                    <span class="badge badge-info">On The Way</span>
                                @elseif ($data->status == 10)
                                    <span class="badge badge-danger">Cancel</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>{{ __('text.payment_type') }}:</th>
                            <td>
                                @if ($data->payment_type == 1)
                                    Cash on Delivery
                                @else
                                    Online Payment
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>{{ __('text.delivery_type') }}:</th>
                            <td>{{ $data->delivery_type == 1 ? 'Home Delivery' : 'Pharmacy Pickup' }}</td>
                        </tr>
                        @if ($data->delivery_type !== 2)
                            <tr>
                                <th>{{ __('text.delivery_method') }}:</th>
                                <td>
                                    @if ($data->delivery_method == 'express')
                                        Express Delivery
                                    @elseif ($data->delivery_method == 'normal')
                                        Normal Delivery
                                    @endif
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <th>{{ __('text.delivery_date') }}:</th>
                            <td>
                                {{ date('d F Y', strtotime($data->delivery_date)) }}
                            </td>
                        </tr>
                        <tr>
                            <th>{{ __('text.delivery_time') }}:</th>
                            <td>
                                {{ $data->delivery_time }}
                            </td>
                        </tr>
                        <tr>
                            <th>{{ __('text.charge_amount') }}:</th>
                            <td>
                                {{ $data->delivery_charge }}
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-7">
                <div class="my-order-list">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('text.product') }}</th>
                                    <th scope="col">{{ __('text.price') }}</th>
                                    <th scope="col">{{ __('text.price') }}</th>
                                    <th scope="col">{{ __('text.sub_total') }}l</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($data['orderItems'] as $product)
                                <tr>
                                    <td>{{ $product->product->name }}</td>
                                    <td>৳ {{ $product->product->purchase_price }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>৳ {{ $product->quantity * $product->product->purchase_price }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfooter>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><strong>{{ __('text.grand_total') }} : </strong>৳  {{ $data->amount + $data->delivery_charge }}</td>
                                </tr>
                            </tfooter>
                        </table>
                    </div>
                </div>
                    <form method="post" action="{{route('order.to.cart')}}">
                        <input type="hidden" name="itemId" value="{{ $data->id }}">
                        @csrf
                    <div class="text-center">
                        <button type="submit" class="button btn--primary mt-5">{{ __('text.add_item_to_cart') }}</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
