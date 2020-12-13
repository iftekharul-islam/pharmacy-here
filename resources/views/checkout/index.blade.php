@extends('layouts.app')
<style>
    /* Style the active class (and buttons on mouse-over) */
    .active, .selectedAddress:hover {
        background-color: #00CE5E;
        color: white;
    }

    .form-row {
        background-color: #fff;
        color: black;
    }

    .delivery-option {
        background-color: #fff;
        color: black;
    }

    .save-profile-btn {
        border: 1px solid #00ce5e;
    }

    .add-address {
        padding: 41px !important;
    }

    .agreement ul li a {
        color: #000;
        margin-left: 20px;
    }

    .custom-control-input:checked ~ .custom-control-label::before {
        color: #fff;
        border-color: #00AE4D !important;
        background-color: #00AE4D !important;
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
    <!-- checkout -->
    <section class="checkout-section">
        <div class="container">
            <div class="row">
                <h6><strong>{{ __('text.checkout_heading') }}</strong></h6>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="checkout-section--left">
                        <form id="main-form" method="post" action="{{ route('checkout.check')  }}">
                            @csrf
                            <input type="text" class="d-none" name="phone_number" value="{{ $user->phone_number }}">
                            <input type="hidden" name="delivery_type" value="">
                            <input type="hidden" name="amount" value="">
                            <input type="hidden" id="insert_pharmacy_id" name="pharmacy_id" value="">
                            <input type="hidden" class="normal_delivery_date" name="normal_delivery_date" value="">
                            <input type="hidden" class="normal_delivery_time" name="normal_delivery_time" value="">
                            <input type="hidden" class="express_delivery_time" name="express_delivery_time" value="">
                            <input type="hidden" class="express_delivery_date" name="express_delivery_date" value="">
                            <input type="hidden" class="delivery_duration" name="delivery_duration" value="">
                            <input type="hidden" name="order_items" value="{{ $data }}">
                            <input type="hidden" name="delivery_charge_amount" value="">
                            <input type="hidden" name="status" value="0">
                            <ul class="payment-step">
                                <li>
                                    <p>{{ __('text.delivery_address') }}</p>
                                    <div class="row">
                                        <div class="col-md-5 col-sm-5">
                                            <div class="address" id="myAddress">
                                                @foreach($addresses as $item)
                                                    <div class="address-box mr-2 selectedAddress"
                                                         onclick="getAddressId({{ $item['id'] }}, {{ $item['area_id'] }}, {{ $item['area']['thana_id'] }})">
                                                        <address>
                                                            {{ $item['address'] . ', ' . $item['area']['name'] . ', ' . $item['area']['thana']['name'] . ', ' . $item['area']['thana']['district']['name'] }}
                                                        </address>
                                                    </div>
                                                @endforeach
                                                <a href="#" class="add-address" data-toggle="modal"
                                                   data-target="#addressModal">
                                                    <i class="fas fa-plus-circle"></i>
                                                    <span>{{ __('text.address') }}</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 mt-2">
                                            <input type="text" class="d-none" name="shipping_address_id" value=""><br>
                                            <input type="text" class="d-none" id="pharmacy_search"
                                                   name="pharmacy_search_id" value="">
                                            @if ($errors->has('shipping_address_id'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('shipping_address_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <p>{{ __('text.phone_number') }}</p>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="text" name="phone_number" class="form-control mb-2"
                                                   onkeypress="return isNumber(event)"
                                                   value="{{ \Illuminate\Support\Facades\Auth::user()->phone_number }}"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 mt-2">
                                            @if ($errors->has('phone_number'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('phone_number') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                                <!-- Payment method -->
                                <li>
                                    <p>{{ __('text.payment_details') }}</p>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div
                                                class="d-flex align-items-center justify-content-between payment-method">
                                                <label id="cod" class="custom-radio" onclick="getPayTypeValue(1)">
                                                    <input type="radio" checked="checked" name="payment_type" value="1">
                                                    <span class="checkmark"></span>
                                                    Cash on Delivery
                                                </label>
                                                <label class="custom-radio" onclick="getPayTypeValue(2)">
                                                    <input type="radio" id="epay" name="payment_type" value="2">
                                                    <span class="checkmark"></span>
                                                    E - Payment
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <!-- Delivery option -->
                                <li>
                                    <p>{{ __('text.delivery_option') }}</p>
                                    <ul class="nav nav-pills mb-3 delivery-option-tabs" id="pills-tab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active home-delivery" id="pills-delivery-tab"
                                               data-toggle="pill" href="#pills-delivery" role="tab"
                                               aria-controls="pills-delivery" aria-selected="true"
                                               onclick="getDeliveryType(1)">{{ __('text.home_delivery') }}</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link pharmacy-delivery" id="pills-pharmacy-tab"
                                               data-toggle="pill" href="#pills-pharmacy" role="tab"
                                               aria-controls="pills-pharmacy" aria-selected="false"
                                               onclick="getDeliveryType(2)">{{ __('text.pickup_pharmacy') }}</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade home-delivery show active" id="pills-delivery"
                                             role="tabpanel" aria-labelledby="pills-delivery-tab">
                                            <div class="delivery-option">
                                                <label class="custom-radio" id="tab1" name="tab"
                                                       onclick="getDeliveryChargeValue(1)">
                                                    <input type="radio" checked="checked" name="delivery_charge"
                                                           value="1">
                                                    <span id="normal_delivery_charge" class="checkmark"></span>
                                                </label><br>
                                                <label class="custom-radio" id="tab2" name="tab"
                                                       onclick="getDeliveryChargeValue(2)">
                                                    <input type="radio" name="delivery_charge" value="2">
                                                    <span id="express_delivery_charge" class="checkmark"></span>
                                                </label>
                                                @if ( $isPreOrderMedicine )
                                                    <div class="order-summary">
                                                        {{ __('text.checkout_pre_order_notice') }}
                                                    </div>
                                                @else
                                                    <div class="tab-content express-content d-none"
                                                         id="pills-tabContent">
                                                        <div class="tab-pane fade show active" id="pills-normaldelivery"
                                                             role="tabpanel" aria-labelledby="pills-normaldelivery-tab">
                                                            <div class="form-row">
                                                                <div class="form-group col-md-6">
                                                                    <label for="inputdate">Time Slot</label>
                                                                    <select class="form-control express_slot"
                                                                            id="expressTime">
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="inputtime">Delivery Time</label>
                                                                    <input type="text" class="form-control express_date"
                                                                           id="inputtime" value="" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="pills-expressdelivery"
                                                             role="tabpanel"
                                                             aria-labelledby="pills-expressdelivery-tab">...
                                                        </div>
                                                    </div>
                                                    <div class="tab-content normal-content" id="pills-tabContent">
                                                        <div class="tab-pane fade show active" id="pills-normaldelivery"
                                                             role="tabpanel" aria-labelledby="pills-normaldelivery-tab">
                                                            <div class="form-row">
                                                                <div class="form-group col-md-6">
                                                                    <label for="inputdate">Delivery Time</label>
                                                                    <input type="text" class="form-control normal_date"
                                                                           id="inputdate" value="" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="pills-expressdelivery"
                                                             role="tabpanel"
                                                             aria-labelledby="pills-expressdelivery-tab">...
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                        </div>
                                        <div class="tab-pane fade pickup-pharmacy" id="pills-pharmacy" role="tabpanel"
                                             aria-labelledby="pills-pharmacy-tab">
                                            @if ( $isPreOrderMedicine )
                                                <div class="order-summary">
                                                    {{ __('text.pre_order_text') }}
                                                </div>
                                            @else
                                            @endif
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <p>{{ __('text.order_summary') }}</p>
                                    <div class="order-summary col-md-10">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tbody>
                                                <tr>
                                                    <td scope="col"><b>{{ __('text.product') }}</b></td>
                                                    <td scope="col"><b>{{ __('text.price') }}</b></td>
                                                    <td scope="col"><b>{{ __('text.quantity') }}</b></td>
                                                    <td class="text-center"><b>{{ __('text.sub_total') }}</b></td>
                                                    <td scope="col"></td>
                                                </tr>
                                                <?php $total = 0 ?>
                                                @if($data)
                                                    @foreach ($data as $id => $details)
                                                        <input type="hidden" name="cart_ids[]"
                                                               value="{{ $details->id }}">
                                                        <?php $total += $details['product']['purchase_price'] * $details['quantity'] ?>
                                                        <tr>
                                                            <td scope="row">{{ $details['product']['name'] }}</td>
                                                            <td>৳ {{ $details['product']['purchase_price'] }}
                                                                / {{ __('text.piece') }}</td>
                                                            <td data-th="Quantity">{{ $details['quantity'] }}</td>
                                                            <td data-th="Subtotal" class="text-center">
                                                                ৳ {{ $details['product']['purchase_price']  * $details->quantity }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td><h5>{{ __('text.total') }} ৳ {{ $total }}</h5></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <p id="grandTotal"></p>
                                </li>
                                <li>
                                    <div class="order-summary col-md-4">
                                        <div class="custom-control custom-checkbox mr-sm-mb-2">
                                            <input type="checkbox" class="custom-control-input" name="agreement"
                                                   id="customControlAutosizing" required>
                                            <label class="custom-control-label"
                                                   for="customControlAutosizing"><b>{{ __('text.agreement') }}</b></label>
                                        </div>
                                        <div class="agreement mt-2 ml-2">
                                            <ul>
                                                <li>
                                                    <small><a href="{{ route('terms') }}"
                                                              class="text-primary">{{ __('text.Terms_of_use') }}</a>
                                                    </small>
                                                </li>
                                                <li>
                                                    <small><a href="{{ route('privacy.page') }}"
                                                              class="text-primary">{{ __('text.privacy_policy') }}</a>
                                                    </small>
                                                </li>
                                                <li>
                                                    <small><a href="{{ route('return.page') }}"
                                                              class="text-primary">{{ __('text.refund_and_return') }}</a>
                                                    </small>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div class="col-md-12">
                                <button type="submit" id="final-submit"
                                        class="btn--primary checkout-btn save-profile-btn d-block px-5 mx-auto">{{ __('text.proceed_to_checkout') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="pharmacyModal" tabindex="-1" role="dialog" aria-labelledby="pharmacyModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pharmacyModalLabel">{{ __('text.select_address_title') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="district" class="col-form-label">{{ __('text.district') }}</label>
                        <select class="form-control" id="selectPharmacyDistrict" onchange="getPharmacyThanas(value)">
                            <option value="" disabled selected>{{ __('text.select_district') }}</option>
                            @foreach($allLocations as $district)
                                <option value="{{ $district->id }}"
                                        data-details="{{ $district->thanas }}">{{ $district->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="thana" class="col-form-label">{{ __('text.thana') }}</label>
                        <select class="form-control" id="selectPharmacyThana" onchange="getPharmacy()">

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="area" class="col-form-label">{{ __('text.pharmacy') }}</label>
                        <select class="form-control" id="selectPharmacy" name="select_pharamcy" disabled="">
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ __('text.cancel') }}</button>
                    <button type="submit" class="btn btn-success" id="pharmacy-submit"
                            disabled="">{{ __('text.save') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="addressModal" tabindex="-1" role="dialog" aria-labelledby="addressModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addressModalLabel">{{ __('text.new_address') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('customer.address.store') }}">
                        @csrf

                        <div class="form-group">
                            <label for="district" class="col-form-label">{{ __('text.district') }}</label>
                            <select class="form-control" id="selectDistrict" onchange="getThanas(value)">
                                <option value="" disabled selected>{{ __('text.select_district') }}</option>
                                @foreach($allLocations as $district)
                                    <option value="{{ $district->id }}"
                                            data-details="{{ $district->thanas }}">{{ $district->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="thana" class="col-form-label">{{ __('text.thana') }}</label>
                            <select class="form-control" id="selectThana" onchange="getAreas()">

                            </select>
                        </div>

                        <div class="form-group">
                            <label for="area" class="col-form-label">{{ __('text.area') }}</label>
                            <select class="form-control" id="selectArea" name="area_id" disabled="">
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="address" class="col-form-label">{{ __('text.address') }}</label>
                            <input type="text" name="address" class="form-control" id="address" disabled="" required>
                            @if ($errors->has('address'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                            @endif
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ __('text.cancel') }}</button>
                    <button type="submit" class="btn btn-success" id="submit" disabled="">{{ __('text.save') }}</button>
                </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section ('js')
    <script>
        $("#pharmacy-submit").on('click', function () {
            var pharmacy = $('#selectPharmacy').val();
            $('#pharmacy_search-error').addClass('d-none');
            $('#insert_pharmacy_id').val(pharmacy);
            $('#pharmacy_search').val(pharmacy);
            console.log(pharmacy, 'pharmacy');
            $('#pharmacyModal').modal('hide');
        });

        $('#final-submit').on('click', function () {
            window.scrollTo(0, 0);
        });

        $('#main-form').validate({ // initialize the plugin
            ignore: [],
            errorClass: "text-danger",
            rules: {
                shipping_address_id: {
                    required: true
                },
                pharmacy_search_id: {
                    required: true
                },
                agreement: {
                    required: true
                },
            },
            messages: {
                shipping_address_id: {
                    required: "Please Select a Address",
                },
                pharmacy_search_id: {
                    required: "No pharmacy selected. Please select one",
                },
                agreement: {
                    required: "* please Check",
                },
            }
        });

        $('#submit').on('click', function () {
            $('#addressModal').modal('hide');
        })
        // Get the container element
        var btnContainer = document.getElementById("myAddress");

        // Get all buttons with class="btn" inside the container
        var btns = btnContainer.getElementsByClassName("selectedAddress");

        // Loop through the buttons and add the active class to the current/clicked button
        for (var i = 0; i < btns.length; i++) {
            btns[i].addEventListener("click", function () {
                var current = document.getElementsByClassName("active");
                current[0].className = current[0].className.replace(" active", "");
                this.className += " active";
            });
        }
        let ExpressDeliveryTime = {!! json_encode($delivery_time['express_delivery_time']) !!};
        let NormalDeliveryTime = {!! json_encode($delivery_time['normal_delivery_time']) !!};
        console.log(ExpressDeliveryTime);
        console.log(NormalDeliveryTime);
            {{--let cashInNormalDelivery = parseFloat( "<?php echo $delivery_charge['normal_delivery']['cash']?>".replace(/,/g,'')) + parseFloat( "<?php echo $delivery_charge['normal_delivery']['delivery_charge']?>");--}}
        let cashInNormalDeliveryValue = parseFloat("<?php echo $delivery_charge['normal_delivery']['cash']?>".replace(/,/g, '')) + parseFloat("<?php echo $delivery_charge['normal_delivery']['delivery_charge']?>");
        let cashInNormalDeliveryAmount = cashInNormalDeliveryValue.toFixed(2);
        let cashInNormalDelivery = parseFloat(cashInNormalDeliveryAmount);

            {{--let cashInNormalDelivery = parseFloat( "<?php echo $delivery_charge['normal_delivery']['delivery_charge']?>");--}}
        let eamountInNormalDelivery = parseFloat("<?php echo $delivery_charge['normal_delivery']['ecash']?>");
        let eamountInExpressDelivery = parseFloat("<?php echo $delivery_charge['express_delivery']['ecash']?>");
            {{--let cashInNormalDeliveryCharge = parseFloat( "<?php echo $delivery_charge['normal_delivery']['delivery_charge']?>");--}}
            {{--let ecashInNormalDelivery = parseFloat(parseFloat( "<?php echo $delivery_charge['normal_delivery']['ecash']?>") + parseFloat( "<?php echo $delivery_charge['normal_delivery']['delivery_charge']?>")).toFixed(2);--}}

        let ecashInNormalDelivery = parseFloat("<?php echo $delivery_charge['normal_delivery']['delivery_charge']?>");
        let cashInExpressDeliveryValue = parseFloat("<?php echo $delivery_charge['express_delivery']['cash']?>".replace(/,/g, '')) + parseFloat("<?php echo $delivery_charge['express_delivery']['delivery_charge']?>");
        let cashInExpressDeliveryAmount = cashInExpressDeliveryValue.toFixed(2);
        let cashInExpressDelivery = parseFloat(cashInExpressDeliveryAmount);

            {{--let cashInExpressDelivery = parseFloat( "<?php echo $delivery_charge['express_delivery']['delivery_charge']?>");--}}
            {{--let cashInExpressDeliveryCharge = parseFloat( "<?php echo $delivery_charge['express_delivery']['delivery_charge']?>");--}}
            {{--let ecashInExpressDelivery = parseFloat(parseFloat( "<?php echo $delivery_charge['express_delivery']['ecash']?>") + parseFloat( "<?php echo $delivery_charge['express_delivery']['delivery_charge']?>")).toFixed(2);--}}

        let ecashInExpressDelivery = parseFloat("<?php echo $delivery_charge['express_delivery']['delivery_charge']?>");

            {{--let cashInCollectFromPharmacyD = parseFloat( "<?php echo $delivery_charge['collect_from_pharmacy']['discount']?>");--}}

        let discount = "<?php echo $delivery_charge['collect_from_pharmacy']['discount'] ?>";
        let cashInCollectFromPharmacy = parseFloat(discount.replace(/,/g, ''));

            {{--let ecashInCollectFromPharmacy = parseFloat( "<?php echo $delivery_charge['collect_from_pharmacy']['ecash']?>");--}}

        let ecashNoramlCharge = parseFloat("<?php echo $delivery_charge['normal_delivery']['delivery_charge']?>");
        let ecashExpressCharge = parseFloat("<?php echo $delivery_charge['express_delivery']['delivery_charge']?>");

        let customerAmount = parseFloat("<?php echo $amount ?>");
        let customerPayLimit = parseFloat("<?php echo $pay_limit ?>");
        console.log(customerAmount, 'customerAmount');
        console.log(customerPayLimit, 'customerPayLimit');


        // console.log(ecashInExpressDelivery, 'ecashInExpressDelivery')
        // console.log(cashInExpressDeliveryCharge, 'ecash In Express Delivery Charge')
        // console.log(cashInNormalDeliveryValue, 'cash In Normal cash In Normal Delivery Value')
        console.log(cashInNormalDelivery, 'cash In Normal Delivery')

        // console.log(cashInCollectFromPharmacy, 'cash In cashInCollectFromPharmacy')
        // console.log(ecashInNormalDelivery, 'ecash In NormalDelivery')
        // console.log(typeof (ecashInNormalDelivery), 'ecash In NormalDelivery')
        console.log(cashInExpressDelivery, 'cash In ExpressDelivery')
        // console.log(ecashInExpressDelivery, 'ecash In ExpressDelivery')
        // console.log(cashInCollectFromPharmacy, 'cash In CollectFromPharmacy')
        // console.log(ecashInCollectFromPharmacy, 'ecash In CollectFromPharmacy')


        var total = parseFloat("<?php echo $total ?>");

        var deliveryType = 1;

        var PreOrderMedicine = "<?php echo $isPreOrderMedicine  ?>";

        (function () {
            if (customerAmount > customerPayLimit) {
                $('#cod').addClass('d-none');
                $('#epay').attr('checked', true);
            }
            var payTypeValue = parseInt($('input[name="payment_type"]:checked').val());
            var deliveryCharge = parseInt($('input[name="delivery_charge"]:checked').val());
            $('input[name="delivery_type"]').val(deliveryType);
            if (PreOrderMedicine != '') {
                $('#tab2').addClass('d-none');
            }

            getPayTypeValue(payTypeValue);
            getDeliveryChargeValue(deliveryCharge);
            getDeliveryType(deliveryType);

            addDeliveryChargeToGrandTotal(deliveryType, payTypeValue, deliveryCharge);
        })();

        function getAddressId(id, areaId) {

            $('input[name="shipping_address_id"]').val(id);
            $('#shipping_address_id-error').addClass('d-none');
            $('#pharmacy_search-error').addClass('d-none');

            $.ajax({
                url: '{{ url('find-pharmacy') }}',
                method: "get",
                data: {_token: '{{ csrf_token() }}', id: areaId},

                success: function (response) {
                    if (response === true) {

                        $('#pharmacy_search').val('1');
                        $('#insert_pharmacy_id').val('');

                    } else {

                        $('#pharmacy_search').val('');
                        $('#insert_pharmacy_id').val('');

                        $('#pharmacyModal').modal('toggle');
                        $('#pharmacyModal').modal('show');
                    }
                },
                error: function (response) {
                    console.log(response);
                }
            });
        }

        function getDeliveryType(deliveryType) {
            var payTypeValue = parseInt($('input[name="payment_type"]:checked').val());
            var deliveryCharge = parseInt($('input[name="delivery_charge"]:checked').val());

            $('input[name="delivery_type"]').val(deliveryType);

            addDeliveryChargeToGrandTotal(deliveryType, payTypeValue, deliveryCharge);
        }

        function getDeliveryChargeValue(deliveryCharge) {
            var payTypeValue = parseInt($('input[name="payment_type"]:checked').val());

            addDeliveryChargeToGrandTotal(deliveryType, payTypeValue, deliveryCharge);

            if (deliveryCharge === 1) {
                <!-- Normal delivery date calculation -->

                var normal_start_time = '09:00:00';
                var normal_end_time = '18:00:00';

                var normal_time_slot = ["10:00 am-12:00 am", "7:00 pm-9:00 pm"];

                var tm = new Date();
                var time = tm.getHours() + ":" + tm.getMinutes() + ":" + tm.getSeconds();
                var time_new = moment.utc(time, 'hh:mm A').format('HH:mm:ss');

                var time_now = moment.utc(time, 'hh:mm A').format('HH:mm:ss');
                var check_start_time = moment.utc(NormalDeliveryTime[0].start_time, 'hh:mm A').add(-1, 'hours').format('HH:mm:ss');
                var check_end_time = moment.utc(NormalDeliveryTime[1].start_time, 'hh:mm A').add(-1, 'hours').format('HH:mm:ss');
                var first_time_duration = NormalDeliveryTime[0].start_time + '' + NormalDeliveryTime[0].end_time;
                var last_time_duration = NormalDeliveryTime[1].start_time + '' + NormalDeliveryTime[1].end_time;
                console.log('check_time');
                console.log(check_start_time);
                console.log('check_end_time');
                console.log(check_end_time);
                console.log('time now');
                console.log(time_now);

                if (check_start_time > time_now) {
                    console.log('hello in 1')
                } else if ( time_now < check_end_time) {
                    console.log('hello in 2')
                } else {
                    console.log('hello in 3')
                }

                var dt = new Date();
                var month = dt.getMonth() + 1;
                var date = dt.getDate() + "-" + month + "-" + dt.getFullYear()
                var next_date = (dt.getDate() + 1) + "-" + month + "-" + dt.getFullYear()
                var after_four_date = (dt.getDate() + 3) + "-" + month + "-" + dt.getFullYear()

                console.log(PreOrderMedicine);
                if (PreOrderMedicine !== '') {
                    $(".normal_delivery_date").val(after_four_date);
                    $(".normal_delivery_time").val(NormalDeliveryTime[0].start_time);
                    $(".delivery_duration").val(first_time_duration);

                }
                else if (time_now < check_start_time) {
                    $(".normal_date").val("(" + first_time_duration + ")" + ", " + date);
                    $(".normal_delivery_date").val(date);
                    $(".normal_delivery_time").val(NormalDeliveryTime[0].start_time);
                    $(".delivery_duration").val(first_time_duration);

                }
                else if (time_now > check_start_time && time_now < check_end_time) {
                    $(".normal_date").val("(" + last_time_duration + ")" + ", " + date);
                    $(".normal_delivery_date").val(date);
                    $(".normal_delivery_time").val(NormalDeliveryTime[1].start_time);
                    $(".delivery_duration").val(last_time_duration);

                } else {
                    $(".normal_date").val("(" + last_time_duration + ")" + ", " + next_date);
                    $(".normal_delivery_date").val(next_date);
                    $(".normal_delivery_time").val(NormalDeliveryTime[0].start_time);
                    $(".delivery_duration").val(last_time_duration);
                }

                // if (PreOrderMedicine !== '') {
                //     $(".normal_delivery_date").val(after_four_date);
                //     $(".normal_delivery_time").val('10:00:00');
                //     $(".delivery_duration").val(normal_time_slot[0]);
                //
                // }
                // else if (time_new < normal_start_time) {
                //     $(".normal_date").val("(" + normal_time_slot[0] + ")" + ", " + date);
                //     $(".normal_delivery_date").val(date);
                //     $(".normal_delivery_time").val('10:00:00');
                //     $(".delivery_duration").val(normal_time_slot[0]);
                //
                // }
                // else if (time_new > normal_start_time && time_new < normal_end_time) {
                //     $(".normal_date").val("(" + normal_time_slot[1] + ")" + ", " + date);
                //     $(".normal_delivery_date").val(date);
                //     $(".normal_delivery_time").val('19:00:00');
                //     $(".delivery_duration").val(normal_time_slot[1]);
                //
                // } else {
                //     $(".normal_date").val("(" + normal_time_slot[0] + ")" + ", " + next_date);
                //     $(".normal_delivery_date").val(next_date);
                //     $(".normal_delivery_time").val('10:00:00');
                //     $(".delivery_duration").val(normal_time_slot[0]);
                // }
                <!-- End of Normal delivery date calculation -->

                $('.express-content').addClass('d-none');
                $('.normal-content').removeClass('d-none');
            } else {
                $('.express_slot').html('');

                <!-- Express delivery date calculation -->
                var express_time_slot = [
                    '10:00 am - 11:00 am',
                    '11:01 am - 12:00 am',
                    '12:01 pm - 01:00 pm',
                    '01:01 pm - 02:00 pm',
                    '02:01 pm - 03:00 pm',
                    '03:01 pm - 04:00 pm',
                    '04:01 pm - 05:00 pm',
                    '05:01 pm - 06:00 pm',
                    '06:01 pm - 07:00 pm',
                    '07:01 pm - 08:00 pm'
                ];
                var express_time_slot_insert = ['10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00',
                    '16:00:00', '17:00:00', '18:00:00', '19:00:00', '20:00:00'];

                $('.express_slot').append(`<option value="" selected disabled>Please Select a slot</option>`);

                var tm = new Date();
                var time = tm.getHours() + ":" + tm.getMinutes() + ":" + tm.getSeconds();
                var time_now = moment.utc(time, 'hh:mm:ss').add(+2, 'hours').format('HH:mm:ss');

                var isAvailable = false;
                $.each(ExpressDeliveryTime, function (key, value) {
                    var check = moment.utc(value.start_time, 'hh:mm A').format('HH:mm:ss');
                    console.log('check')
                    console.log(check)
                    console.log('time_now')
                    console.log(time_now)

                    if ( check >= time_now ) {
                        console.log('i m in 1');
                        isAvailable = true;
                        $('.express_slot')
                            .append($("<option></option>")
                                .attr("value", value.start_time)
                                .text(value.start_time + ' - ' + value.end_time));
                    }
                });

                if (!isAvailable) {
                    $.each(ExpressDeliveryTime, function (key, value) {
                        console.log('i m in 2');
                        $('.express_slot')
                            .append($("<option></option>")
                                .attr("value", value.start_time)
                                .text(value.start_time + ' - ' + value.end_time));

                    });
                }

                // var available_time = null;
                //
                //
                // $.each(express_time_slot, function (key) {
                //     if (express_time_slot_insert[key] >= time_now) {
                //         available_time = key + 2;
                //         return false; // breaks
                //     }
                //
                // });
                //
                // if (available_time !== null) {
                //     $.each(express_time_slot, function (key, value) {
                //         if (key >= available_time) {
                //             $('.express_slot')
                //                 .append($("<option></option>")
                //                     .attr("value", express_time_slot_insert[key])
                //                     .text(value));
                //         }
                //     });
                // } else {
                //     $.each(express_time_slot, function (key, value) {
                //         $('.express_slot')
                //             .append($("<option></option>")
                //                 .attr("value", express_time_slot_insert[key])
                //                 .text(value));
                //     });
                // }

                <!--End express delivery date calculation -->

                $('.express-content').removeClass('d-none');
                $('.normal-content').addClass('d-none');
            }
        }

        $('#expressTime').on('change', function () {
            var time_slot = $('#expressTime option:selected').val()
            var time_slot_duration = $('#expressTime option:selected').html();

            var dt = new Date();
            var month = dt.getMonth() + 1;

            var date = dt.getDate() + "-" + month + "-" + dt.getFullYear()
            var next_date = dt.getDate() + 1 + "-" + month + "-" + dt.getFullYear()

            // var date2 = new Date();
            // var hours = date2.getHours();
            // var minutes = date2.getMinutes();
            // var ampm = hours >= 12 ? 'pm' : 'am';
            // hours = hours % 12;
            // hours = hours ? hours : 12; // the hour '0' should be '12'
            // minutes = minutes < 10 ? '0'+minutes : minutes;
            // var strTime = hours + ':' + minutes + ' ' + ampm;
            // console.log('Express time now')
            // console.log(strTime);

            var tm = new Date();
            var time = tm.getHours() + ":" + tm.getMinutes() + ":" + tm.getSeconds();
            var time_now = moment.utc(time, 'hh:mm a');
            var check = moment.utc(time_slot, 'hh:mm a').add(-2, 'hour');

            if (time_now > check) {
                $('.express_date').val(time_slot_duration + ", " + next_date);
                $(".express_delivery_date").val(next_date);
                $(".express_delivery_time").val(time_slot);
                $(".delivery_duration").val(time_slot_duration);
            } else {
                $('.express_date').val(time_slot_duration + ", " + date);
                $(".express_delivery_date").val(date);
                $(".express_delivery_time").val(time_slot);
                $(".delivery_duration").val(time_slot_duration);
            }

        });


        function addDeliveryChargeToGrandTotal(deliveryType, payTypeValue, deliveryCharge) {
            let grandTotal = total;
            $('input[name="delivery_charge_amount"]').prop('disabled', false);

            if (deliveryType === 1 && payTypeValue === 1 && deliveryCharge === 1) {
                grandTotalValue = total + cashInNormalDelivery;
                grandTotalAmount = grandTotalValue.toFixed(2);
                grandTotal = parseFloat(grandTotalAmount);
                $('input[name="delivery_charge_amount"]').val(cashInNormalDelivery);

            }
            if (deliveryType === 1 && payTypeValue === 1 && deliveryCharge === 2) {
                grandTotalValue = total + cashInExpressDelivery;
                grandTotalAmount = grandTotalValue.toFixed(2);
                grandTotal = parseFloat(grandTotalAmount);
                $('input[name="delivery_charge_amount"]').val(cashInExpressDelivery);
            }
            if (deliveryType === 1 && payTypeValue === 2 && deliveryCharge === 1) {
                console.log(ecashInNormalDelivery, 'e cash normal');
                grandTotal = total + ecashInNormalDelivery + eamountInNormalDelivery;
                $('input[name="delivery_charge_amount"]').val(ecashNoramlCharge);
                // $('input[name="delivery_charge_amount"]').val(ecashInNormalDelivery);
            }
            if (deliveryType === 1 && payTypeValue === 2 && deliveryCharge === 2) {
                console.log(ecashInExpressDelivery, 'e cash express');
                grandTotal = total + ecashInExpressDelivery + eamountInExpressDelivery;
                $('input[name="delivery_charge_amount"]').val(ecashExpressCharge);
            }

            if (deliveryType === 2 && payTypeValue === 1) {
                grandTotal = total - cashInCollectFromPharmacy;
                $('input[name="delivery_charge_amount"]').val(cashInCollectFromPharmacy);
            }
            if (deliveryType === 2 && payTypeValue === 2) {
                console.log('deliveryType 2 and payTypeValue 2')
                grandTotal = total;
                $('input[name="delivery_charge_amount"]').prop('disabled', true);
            }

            var grandTotalView = '{{ __('text.grand_total') }} : ' + grandTotal;

            if (deliveryType === 1 && payTypeValue === 1 && deliveryCharge === 1) {
                var grandTotalNormalDB = grandTotal - cashInNormalDelivery;
                console.log(grandTotalNormalDB, 'normal grandTotalDB');
                $('input[name="amount"]').val(grandTotalNormalDB);
            } else if (deliveryType === 1 && payTypeValue === 1 && deliveryCharge === 2) {
                var grandTotalExpressDB = grandTotal - cashInExpressDelivery;
                console.log(grandTotalExpressDB, 'normal grandTotalDB');
                $('input[name="amount"]').val(grandTotalExpressDB);
            } else if (deliveryType === 1 && payTypeValue === 2 && deliveryCharge === 1) {
                var egrandTotalNormalDB = grandTotal - ecashInNormalDelivery - eamountInNormalDelivery;
                console.log(grandTotal, 'normal e grandTotal');
                console.log(ecashInNormalDelivery, 'normal e ecashInNormalDelivery');
                console.log(egrandTotalNormalDB, 'normal e grandTotalDB');
                $('input[name="amount"]').val(egrandTotalNormalDB);

            } else if (deliveryType === 1 && payTypeValue === 2 && deliveryCharge === 2) {
                var egrandTotalExpressDB = grandTotal - ecashInExpressDelivery - eamountInExpressDelivery;
                console.log(egrandTotalExpressDB, 'express e grandTotalDB');
                $('input[name="amount"]').val(egrandTotalExpressDB);

            } else if (deliveryType === 2 && payTypeValue === 1) {
                var pickUpFromPharmacy = grandTotal + cashInCollectFromPharmacy;
                $('input[name="amount"]').val(pickUpFromPharmacy);

            } else {
                $('input[name="amount"]').val(grandTotal);
            }

            $('input[name="total"]').val(grandTotal);

            $('#grandTotal').html(grandTotalView);

        }


        function getPayTypeValue(payTypeValue) {
            var deliveryCharge = parseInt($('input[name="delivery_charge"]:checked').val());
            var deliveryType = parseInt($('input[name="delivery_type"]').val());

            if (payTypeValue === 2) {
                $('#normal_delivery_charge').html(showNormalDeliveryChargeInEpay());
                $('#express_delivery_charge').html(showExpressDeliveryChargeInEpay());
                addDeliveryChargeToGrandTotal(deliveryType, payTypeValue, deliveryCharge);
            } else {
                $('#normal_delivery_charge').html(showNormalDeliveryChargeInCash());
                $('#express_delivery_charge').html(showExpressDeliveryChargeInCash());
                addDeliveryChargeToGrandTotal(deliveryType, payTypeValue, deliveryCharge);
            }
        }

        function showNormalDeliveryChargeInCash() {
            return 'Normal Delivery Charge:(TK ' + cashInNormalDelivery + ')'
        }

        function showExpressDeliveryChargeInCash() {
            return 'Express Delivery Charge:(TK ' + cashInExpressDelivery + ')'
        }

        function showNormalDeliveryChargeInEpay() {
            return 'Normal Delivery Charge:( TK ' + ecashInNormalDelivery + ') + E-pay charge ( TK ' + eamountInNormalDelivery + ')';
        }

        function showExpressDeliveryChargeInEpay() {
            return 'Express Delivery Charge:( TK ' + ecashInExpressDelivery + ') + E-pay charge  ( TK ' + eamountInExpressDelivery + ')'
        }

        var addresses = {!! json_encode($allLocations) !!};
        var thanas = [];
        var areas = [];

        function getThanas() {
            var districtId = $('#selectDistrict option:selected').val();

            var selectedDistrict = addresses.find(address => address.id == districtId);

            thanas = selectedDistrict.thanas;

            $('#selectThana').html('');
            $('#selectThana').append(`<option value="" selected disabled>Please Select a thana</option>`);

            $.map(thanas, function (value) {
                $('#selectThana')
                    .append($("<option></option>")
                        .attr("value", value.id)
                        .text(value.name));
            });

        }

        function getPharmacyThanas() {
            var districtId = $('#selectPharmacyDistrict option:selected').val();

            var selectedDistrict = addresses.find(address => address.id == districtId);

            thanas = selectedDistrict.thanas;

            $('#selectPharmacyThana').html('');
            $('#selectPharmacyThana').append(`<option value="" selected disabled>Please Select a thana</option>`);

            $.map(thanas, function (value) {
                $('#selectPharmacyThana')
                    .append($("<option></option>")
                        .attr("value", value.id)
                        .text(value.name));
            });

        }

        function getAreas() {
            var areaId = $('#selectThana option:selected').val();
            var selectedThana = thanas.find(thana => thana.id == areaId);
            areas = selectedThana.areas;

            if (areas.length === 0) {
                $('#selectArea').attr('disabled', 'disabled');
                $('#address').attr('disabled', 'disabled');
                $('#submit').attr('disabled', 'disabled');
            }

            $('#selectArea').html('');
            $.map(areas, function (value) {
                $('#selectArea').removeAttr('disabled');
                $('#address').removeAttr('disabled');
                $('#submit').removeAttr('disabled');

                $('#selectArea')
                    .append($("<option></option>")
                        .attr("value", value.id)
                        .text(value.name));
            });
        }

        function getPharmacy() {
            var thanaId = $('#selectPharmacyThana option:selected').val();
            console.log(thanaId, 'thanaId');
            $.ajax({
                url: '{{ url('find-pharmacy-list') }}',
                method: "get",
                data: {_token: '{{ csrf_token() }}', id: thanaId},
                success: function (response) {
                    var values = response;
                    console.log(values)
                    $('#selectPharmacy').html('');
                    $.map(values, function (value) {
                        $('#selectPharmacy').removeAttr('disabled');
                        $('#pharmacy-submit').removeAttr('disabled');

                        $('#selectPharmacy')
                            .append($("<option></option>")
                                .attr("value", value.user_id)
                                .text(value.pharmacy_name));
                    });
                },
                error: function (response) {
                    console.log(response)
                }
            });
        }
    </script>
@endsection
