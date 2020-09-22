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
                                        <div class="delivery-option">
                                             <label class="custom-radio" id="tab1" name="tab" onclick="getDeliveryChargeValue(1)">
                                                <input type="radio" checked="checked" name="delivery_charge_amount" value="1">
                                                <span id="normal_delivery_charge" class="checkmark"></span>
{{--                                                Normal Delivery (Charge: TK {{ $delivery_charge['normal_delivery']['cash'] }})--}}
                                              </label><br>
                                              <label class="custom-radio" id="tab2" name="tab" onclick="getDeliveryChargeValue(2)">
                                                <input type="radio" name="delivery_charge_amount" value="2">
                                                <span id="express_delivery_charge" class="checkmark"></span>
{{--                                                Express Delivery (Charge: TK {{ $delivery_charge['express_delivery']['cash'] }})--}}
                                              </label>
{{--                                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">--}}
{{--                                                <li class="nav-item" role="presentation">--}}
{{--                                                    <a class="nav-link active" id="pills-normaldelivery-tab" data-toggle="pill" href="#pills-normaldelivery" role="tab" aria-controls="pills-normaldelivery" aria-selected="true">Normal Delivery (Charge: TK 0.00)</a>--}}
{{--                                                </li>--}}
{{--                                                <li class="nav-item" role="presentation">--}}
{{--                                                    <a class="nav-link" id="pills-expressdelivery-tab" data-toggle="pill" href="#pills-expressdelivery" role="tab" aria-controls="pills-expressdelivery" aria-selected="false">Express Delivery (Charge: TK 50.00)</a>--}}
{{--                                                </li>--}}
{{--                                            </ul>--}}
                                            <div class="tab-content" id="pills-tabContent">
                                                <div class="tab-pane fade show active" id="pills-normaldelivery" role="tabpanel" aria-labelledby="pills-normaldelivery-tab">
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
                                                <div class="tab-pane fade" id="pills-expressdelivery" role="tabpanel" aria-labelledby="pills-expressdelivery-tab">...</div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane fade pickup-pharmacy" id="pills-pharmacy" role="tabpanel" aria-labelledby="pills-pharmacy-tab"></div>
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

                                                    <?php $total +=  $details['product']['purchase_price']  * $details['quantity'] ?>
                                                    <tr>
                                                        <td scope="row">{{ $details['product']['name'] }}</td>
                                                        <td>৳ {{ $details['product']['purchase_price'] }}</td>
                                                        <td data-th="Quantity">{{ $details['quantity'] }}</td>
                                                        <td data-th="Subtotal" class="text-center">৳ {{ $details['product']['purchase_price']  * $details->quantity }}</td>
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
                                <p id="grandTotal">
{{--                                    Grand Total : {{ $total }}--}}
                                </p>

                            </li>
                            <li>
                                <p>Payment Details</p>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="d-flex align-items-center justify-content-between payment-method">
{{--                                            <label class="custom-radio">--}}
{{--                                                <input type="radio" checked="checked" name="payType" value="1">--}}
{{--                                                <span class="checkmark"></span>--}}
{{--                                                bKash/Nogod/Rocket--}}
{{--                                            </label>--}}
                                            <label class="custom-radio" onclick="getPayTypeValue(1)">
                                                <input type="radio" checked="checked" name="payType" value="1">
                                                <span class="checkmark"></span>
                                                Cash on Delivery
                                            </label>
                                            <label class="custom-radio" onclick="getPayTypeValue(2)">
                                                <input type="radio" name="payType" value="2">
                                                <span class="checkmark"></span>
                                                E - Payment
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
    <script>

        let cashInNormalDelivery =parseFloat( "<?php echo $delivery_charge['normal_delivery']['cash']?>");
        let ecashInNormalDelivery =parseFloat( "<?php echo $delivery_charge['normal_delivery']['ecash']?>");
        let cashInExpressDelivery =parseFloat( "<?php echo $delivery_charge['express_delivery']['cash']?>");
        let ecashInExpressDelivery =parseFloat( "<?php echo $delivery_charge['express_delivery']['ecash']?>");

        var total =parseFloat(  "<?php echo $total ?>");


        (function() {
            var payTypeValue =parseInt( $('input[name="payType"]:checked').val() );
            var deliveryCharge =parseInt( $('input[name="delivery_charge_amount"]:checked').val() );

            getPayTypeValue(payTypeValue);
            getDeliveryChargeValue(deliveryCharge);

            addDeliveryChargeToGrandTotal(payTypeValue, deliveryCharge);
        })();

        function getDeliveryChargeValue(deliveryCharge) {
            var payTypeValue =parseInt( $('input[name="payType"]:checked').val() );

            addDeliveryChargeToGrandTotal(payTypeValue, deliveryCharge);
        }

        function addDeliveryChargeToGrandTotal(payTypeValue, deliveryCharge) {
            let grandTotal = 0;

            if (payTypeValue === 1 && deliveryCharge === 1) {
                grandTotal = total + cashInNormalDelivery;
            }
            if (payTypeValue === 1 && deliveryCharge === 2) {
                grandTotal = total + cashInExpressDelivery;
            }
            if (payTypeValue === 2 && deliveryCharge === 1) {
                grandTotal = total + ecashInNormalDelivery;
            }
            if (payTypeValue === 2 && deliveryCharge === 2) {
                grandTotal = total + ecashInExpressDelivery;
            }

            var grandTotalView = 'Grand Total : ' + grandTotal;

            // console.log(typeof( cashInNormalDelivery ));
            // console.log(cashInNormalDelivery);
            // console.log(typeof( grandTotal));
            // console.log(grandTotal);

            $('#grandTotal').html(grandTotalView);

        }


        function getPayTypeValue(payTypeValue)
        {
            var deliveryCharge =parseInt( $('input[name="delivery_charge_amount"]:checked').val() );

            if (payTypeValue === 2) {
                $('#normal_delivery_charge').html(showNormalDeliveryChargeInEpay());
                $('#express_delivery_charge').html(showExpressDeliveryChargeInEpay());
                addDeliveryChargeToGrandTotal(payTypeValue, deliveryCharge);
            }
            else {
                $('#normal_delivery_charge').html(showNormalDeliveryChargeInCash());
                $('#express_delivery_charge').html(showExpressDeliveryChargeInCash());
                addDeliveryChargeToGrandTotal(payTypeValue, deliveryCharge);
            }
        }
        function showNormalDeliveryChargeInCash() {
            return 'Normal Delivery (Charge: TK ' + cashInNormalDelivery + ')'
        }
        function showExpressDeliveryChargeInCash() {
            return 'Express Delivery (Charge: TK ' + cashInExpressDelivery + ')'
        }
        function showNormalDeliveryChargeInEpay() {
            return 'Normal Delivery (Charge: TK ' + ecashInNormalDelivery + ')'
        }
        function showExpressDeliveryChargeInEpay() {
            return 'Express Delivery (Charge: TK ' + ecashInExpressDelivery + ')'
        }

    </script>
@endsection
