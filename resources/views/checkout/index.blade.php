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
                            <!-- Delivery option -->
                            <li>
                                <p>Delivery Option </p>
                                <ul class="nav nav-pills mb-3 delivery-option-tabs" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" id="pills-delivery-tab" data-toggle="pill" href="#pills-delivery" role="tab" aria-controls="pills-delivery" aria-selected="true">Home Delivery</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="pills-pharmacy-tab" data-toggle="pill" href="#pills-pharmacy" role="tab" aria-controls="pills-pharmacy" aria-selected="false">Pickup Pharmacy</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade home-delivery show active" id="pills-delivery" role="tabpanel" aria-labelledby="pills-delivery-tab">
                                        <div class="delivery-option custom-radio-btn">
                                            <label class="custom-radio">
                                                <input type="radio" checked="checked" name="radio-btn">
                                                <span class="checkmark"></span>
                                                Normal Delivery (Charge: TK 0.00)
                                            </label>
                                            <label class="custom-radio">
                                                <input type="radio" name="radio-btn">
                                                <span class="checkmark"></span>
                                                Express Delivery (Charge: TK 50.00)
                                            </label>
                                        </div>
                                        <form action="#">
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="inputdate">Choose Date</label>
                                                    <input type="date" class="form-control" id="inputdate" placeholder="Start date" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="inputtime">Choose Time</label>
                                                    <input type="time" class="form-control" id="inputtime" placeholder="Start time" required>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                    <div class="tab-pane fade pickup-pharmacy" id="pills-pharmacy" role="tabpanel" aria-labelledby="pills-pharmacy-tab">...</div>
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
