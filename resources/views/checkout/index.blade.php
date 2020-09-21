@extends('layouts.app')

@section('content')
    <!-- checkout -->
    <section class="checkout-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h6><strong>You’re almost there...</strong></h6>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="checkout-section--left">
                        <form method="post" action="{{ route('checkout.check')  }}">
                            @csrf
                            <input type="text" class="d-none" name="phone_number" value="{{ $user->phone_number }}">
                            <input type="text" class="d-none" name="delivery_type" value="">
                        <ul class="payment-step">
                            <li>
                                <p>Delivery Address</p>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="address">
                                            <div class="address-box">
                                                <div class="d-flex justify-content-between name-edit">
                                                    <p><b>Rakibul H. Rocky</b></p>
                                                    <a href="#"><i class="fas fa-pencil-alt"></i> Edit</a>
                                                </div>
                                                <address>
                                                    278/C, Mirpur 14, Dhaka Cantonment, Dhaka - 1206.
                                                    <p>Phone: +880 1234 567890</p>
                                                </address>
                                            </div>
                                            <a href="#" class="add-address">
                                                <i class="fas fa-plus-circle"></i>
                                                <span>Add Address</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <p>Order Summary</p>
                                <div class="order-summary">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class="thead-light">
                                            <tr>
                                                <th scope="col">Product</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col">Sub total</th>
                                                <th scope="col"></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $total = 0 ?>
                                            @if($data)
                                                @foreach($data as $id => $details)

                                                    <?php $total += $details['amount'] * $details['quantity'] ?>
                                                    <tr>
                                                        <td scope="row">{{ $details['product']['name'] }}</td>
                                                        <td>৳ {{ $details['amount'] }}</td>
                                                        <td data-th="Quantity">{{ $details['quantity'] }}</td>
                                                        <td data-th="Subtotal" class="text-center">৳ {{ $details->amount * $details->quantity }}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>Total ৳{{ $total }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <p>Payment Details</p>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="d-flex align-items-center justify-content-between payment-method">
                                            <label class="custom-radio">
                                                <input type="radio" checked="checked" name="payType" value="1">
                                                <span class="checkmark"></span>
                                                bKash/Nogod/Rocket
                                            </label>
                                            <label class="custom-radio">
                                                <input type="radio" name="payType" value="1">
                                                <span class="checkmark"></span>
                                                Cash on Delivery
                                            </label>
                                            <label class="custom-radio">
                                                <input type="radio" name="payType" value="2">
                                                <span class="checkmark"></span>
                                                Credit/ Debit Card
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="row">
                            <div class="col-md-8 p-0">
                                <button type="submit" class="w-100 text-center btn--primary d-block checkout-btn">Proceed to Checkout</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section ('js')
@endsection
