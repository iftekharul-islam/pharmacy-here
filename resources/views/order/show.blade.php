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
                    <label> #{{ $data->order_no }} </label><br>
                    <strong>Order date</strong>
                    <label> #{{ $data->order_date }} </label><br>
                    <strong>Address</strong>
{{--                    <label> #{{ $data->order_date }} </label><br>--}}

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
                    <p><strong>Grand Total:</strong> {{ $data->amount }}</p>

                </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- font awesome -->
    <script src="{{ asset('js/icon.js') }}"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <!-- font awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <!-- owl -->
    <script src="js/owl.carousel.min.js"></script>
    <!-- custom jquery -->
    <script src="js/main.js"></script>

@endsection