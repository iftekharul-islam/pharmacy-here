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
</style>
@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <!-- checkout -->
    <section class="checkout-section">
        <div class="container">
            <div class="row">
                <h6><strong>You’re almost there...</strong></h6>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="checkout-section--left">
                        <form id="main-form" method="post" action="{{ route('checkout.check')  }}">
                            @csrf
                            <input type="text" class="d-none" name="phone_number" value="{{ $user->phone_number }}">
                            <input type="hidden" name="delivery_type" value="">
                            <input type="hidden" name="amount" value="">
                            <input type="hidden" name="pharmacy_id" value="">
                            <input type="hidden" class="normal_delivery_date" name="normal_delivery_date" value="">
                            <input type="hidden" class="normal_delivery_time" name="normal_delivery_time" value="">
                            <input type="hidden" class="express_delivery_time" name="express_delivery_time" value="">
                            <input type="hidden" class="express_delivery_date" name="express_delivery_date" value="">
                            <input type="hidden" name="order_items" value="{{ $data }}">
                            <input type="hidden" name="delivery_charge_amount" value="">
                            <input type="hidden" name="status" value="0">
                            <ul class="payment-step">
                                <li>
                                    <p>Delivery Address</p>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="address" id="myAddress">
                                                @foreach($addresses as $item)
                                                <div class="address-box mr-2 selectedAddress" onclick="getAddressId({{ $item['id'] }}, {{ $item['area_id'] }}, {{ $item['area']['thana_id'] }})">
                                                    <address>
                                                        {{ $item['address'] . ', ' . $item['area']['name'] . ', ' . $item['area']['thana']['name'] . ', ' . $item['area']['thana']['district']['name'] }}
                                                    </address>
                                                </div>
                                                @endforeach
                                                <a href="#" class="add-address" data-toggle="modal" data-target="#addressModal">
                                                    <i class="fas fa-plus-circle"></i>
                                                    <span>Address</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 mt-2">
                                            <input type="text" class="d-none" name="shipping_address_id" value="">
                                            @if ($errors->has('shipping_address_id'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('shipping_address_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <p>Phone Number</p>
                                    <div class="row">
                                        <div class="col-md-4">
                                                <input type="text" name="phone_number" class="form-control mb-2" onkeypress="return isNumber(event)" value="{{ \Illuminate\Support\Facades\Auth::user()->phone_number }}" required>
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
                                    <p>Payment Details</p>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="d-flex align-items-center justify-content-between payment-method">
                                                <label class="custom-radio" onclick="getPayTypeValue(1)">
                                                    <input type="radio" checked="checked" name="payment_type" value="1">
                                                    <span class="checkmark"></span>
                                                    Cash on Delivery
                                                </label>
                                                <label class="custom-radio" onclick="getPayTypeValue(2)">
                                                    <input type="radio" name="payment_type" value="2">
                                                    <span class="checkmark"></span>
                                                    E - Payment
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <!-- Delivery option -->
                                <li>
                                    <p>Delivery Option </p>
                                    <ul class="nav nav-pills mb-3 delivery-option-tabs" id="pills-tab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active" id="pills-delivery-tab" data-toggle="pill" href="#pills-delivery" role="tab" aria-controls="pills-delivery" aria-selected="true" onclick="getDeliveryType(1)">Home Delivery</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link " id="pills-pharmacy-tab" data-toggle="pill" href="#pills-pharmacy" role="tab" aria-controls="pills-pharmacy" aria-selected="false" onclick="getDeliveryType(2)">Pickup Pharmacy</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade home-delivery show active" id="pills-delivery" role="tabpanel" aria-labelledby="pills-delivery-tab">
                                            <div class="delivery-option">
                                                 <label class="custom-radio" id="tab1" name="tab" onclick="getDeliveryChargeValue(1)">
                                                    <input type="radio" checked="checked" name="delivery_charge" value="1">
                                                    <span id="normal_delivery_charge" class="checkmark"></span>
                                                  </label><br>
                                                  <label class="custom-radio" id="tab2" name="tab" onclick="getDeliveryChargeValue(2)">
                                                    <input type="radio" name="delivery_charge" value="2">
                                                    <span id="express_delivery_charge" class="checkmark"></span>
                                                  </label>
                                                @if ( $isPreOrderMedicine )
                                                    <div class="order-summary">
                                                        You have a pre-order medicine in cart. It will take 3-5 days to deliver
                                                    </div>
                                                @else
                                                <div class="tab-content express-content d-none" id="pills-tabContent">
                                                    <div class="tab-pane fade show active" id="pills-normaldelivery" role="tabpanel" aria-labelledby="pills-normaldelivery-tab">
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label for="inputdate">Time Slot</label>
                                                                <select class="form-control express_slot" id="expressTime">
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="inputtime">Delivery Time</label>
                                                                <input type="text" class="form-control express_date" id="inputtime" value="" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="pills-expressdelivery" role="tabpanel" aria-labelledby="pills-expressdelivery-tab">...</div>
                                                </div>
                                                <div class="tab-content normal-content" id="pills-tabContent">
                                                    <div class="tab-pane fade show active" id="pills-normaldelivery" role="tabpanel" aria-labelledby="pills-normaldelivery-tab">
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label for="inputdate">Delivery Time</label>
                                                                <input type="text" class="form-control normal_date" id="inputdate" value="" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="pills-expressdelivery" role="tabpanel" aria-labelledby="pills-expressdelivery-tab">...</div>
                                                </div>
                                                @endif
                                            </div>

                                        </div>
                                        <div class="tab-pane fade pickup-pharmacy" id="pills-pharmacy" role="tabpanel" aria-labelledby="pills-pharmacy-tab">
                                            @if ( $isPreOrderMedicine )
                                                <div class="order-summary">
                                                    You have a pre-order medicine in cart. It will take 3-5 days to deliver
                                                </div>
                                                @else
                                            @endif
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
                                                    @foreach ($data as $id => $details)
                                                        <input type="hidden" name="cart_ids[]" value="{{ $details->id }}">
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
                                                    <td><h5>Total ৳ {{ $total }}</h5></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <p id="grandTotal"></p>
                                </li>
                            </ul>
                            <div class="row">
                                <div class="col-md-8 p-0">
                                    <button type="submit" id="final-submit" class="w-100 text-center btn--primary d-block checkout-btn save-profile-btn d-block">Proceed to Checkout</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="addressModal" tabindex="-1" role="dialog" aria-labelledby="addressModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addressModalLabel">New Address</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form method="post" action="{{ route('customer.address.store') }}">
                    @csrf

                        <div class="form-group">
                            <label for="district" class="col-form-label">District</label>
                            <select class="form-control" id="selectDistrict" onchange="getThanas(value)">
                                    <option value="" disabled selected>Please select a district name</option>
                                @foreach($allLocations as $district)
                                    <option value="{{ $district->id }}" data-details="{{ $district->thanas }}" >{{ $district->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="thana" class="col-form-label">Thana</label>
                            <select class="form-control" id="selectThana" onchange="getAreas()">

                            </select>
                        </div>

                        <div class="form-group">
                            <label for="area" class="col-form-label">Area</label>
                            <select class="form-control" id="selectArea" name="area_id" disabled="">
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="address" class="col-form-label">Address</label>
                            <input type="text" name="address" class="form-control" id="address" disabled="" required>
                            @if ($errors->has('address'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                            @endif
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="submit" disabled="">Save address</button>
                </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section ('js')
    <script>
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
            },
        });

        $('#submit').on('click', function () {
            $('#submit').addClass('d-none');
        })
        // Get the container element
        var btnContainer = document.getElementById("myAddress");

        // Get all buttons with class="btn" inside the container
        var btns = btnContainer.getElementsByClassName("selectedAddress");

        // Loop through the buttons and add the active class to the current/clicked button
        for (var i = 0; i < btns.length; i++) {
            btns[i].addEventListener("click", function() {
                var current = document.getElementsByClassName("active");
                current[0].className = current[0].className.replace(" active", "");
                this.className += " active";
            });
        }

        let cashInNormalDelivery = parseFloat( "<?php echo $delivery_charge['normal_delivery']['cash']?>" ) + parseFloat( "<?php echo $delivery_charge['normal_delivery']['delivery_charge']?>");
        {{--let cashInNormalDeliveryCharge = parseFloat( "<?php echo $delivery_charge['normal_delivery']['delivery_charge']?>");--}}
        let ecashInNormalDelivery = parseFloat(parseFloat( "<?php echo $delivery_charge['normal_delivery']['ecash']?>") + parseFloat( "<?php echo $delivery_charge['normal_delivery']['delivery_charge']?>")).toFixed(2);
        let cashInExpressDelivery = parseFloat( "<?php echo $delivery_charge['express_delivery']['cash']?>") + parseFloat( "<?php echo $delivery_charge['express_delivery']['delivery_charge']?>");
        {{--let cashInExpressDeliveryCharge = parseFloat( "<?php echo $delivery_charge['express_delivery']['delivery_charge']?>");--}}
        let ecashInExpressDelivery = parseFloat(parseFloat( "<?php echo $delivery_charge['express_delivery']['ecash']?>") + parseFloat( "<?php echo $delivery_charge['express_delivery']['delivery_charge']?>")).toFixed(2);;
        let cashInCollectFromPharmacy = parseFloat( "<?php echo $delivery_charge['collect_from_pharmacy']['discount']?>");
        let ecashInCollectFromPharmacy = parseFloat( "<?php echo $delivery_charge['collect_from_pharmacy']['ecash']?>");

        let ecashNoramlCharge = parseFloat( "<?php echo $delivery_charge['normal_delivery']['delivery_charge']?>");
        let ecashExpressCharge = parseFloat( "<?php echo $delivery_charge['express_delivery']['delivery_charge']?>");




        // console.log(ecashInExpressDelivery, 'ecashInExpressDelivery')
        // console.log(cashInExpressDeliveryCharge, 'ecash In Express Delivery Charge')
        // console.log(cashInNormalDeliveryCharge, 'ecash In NormalDelivery Charge')

        // console.log(cashInNormalDelivery, 'cash In NormalDelivery')
        console.log(ecashInNormalDelivery, 'ecash In NormalDelivery')
        console.log(typeof (ecashInNormalDelivery), 'ecash In NormalDelivery')
        // console.log(cashInExpressDelivery, 'cash In ExpressDelivery')
        // console.log(ecashInExpressDelivery, 'ecash In ExpressDelivery')
        // console.log(cashInCollectFromPharmacy, 'cash In CollectFromPharmacy')
        // console.log(ecashInCollectFromPharmacy, 'ecash In CollectFromPharmacy')


        var total = parseFloat("<?php echo $total ?>");

        var deliveryType = 1;

        (function() {
            var payTypeValue =parseInt( $('input[name="payment_type"]:checked').val() );
            var deliveryCharge = parseInt( $('input[name="delivery_charge"]:checked').val() );
            $('input[name="delivery_type"]').val(deliveryType);
            console.log(deliveryCharge, 'On page load')

            getPayTypeValue(payTypeValue);
            getDeliveryChargeValue(deliveryCharge);
            getDeliveryType(deliveryType);

            addDeliveryChargeToGrandTotal(deliveryType, payTypeValue, deliveryCharge);
        })();

        function getAddressId(id, areaId, thanaId) {

            $('input[name="shipping_address_id"]').val(id);

            $.ajax({
                url: '{{ url('find-pharmacy') }}',
                method: "get",
                data: {_token: '{{ csrf_token() }}', id: areaId},

                success: function (response) {

                    console.log(response);

                    if (response === true) {
                        console.log(id, 'hello :) its true')
                        $('input[name="pharmacy_id"]').val(id);

                    } else {
                        console.log(response, 'response')
                        console.log('hello :) its false')
                        console.log(thanaId, 'thana')

                        $.ajax({
                            url: '{{ url('find-pharmacy-list') }}',
                            method: "get",
                            data: {_token: '{{ csrf_token() }}', id: thanaId},
                            success: function (response) {
                                var values = response;
                                console.log(values)
                                var options = {};
                                $.map(values,
                                    function(o) {
                                        options[o.user_id] = o.pharmacy_name + ', ' + o.area.name ;
                                    });
                                Swal.fire({
                                    // html : 'You need to Select a pharmacy',
                                    icon: 'warning',
                                    title: 'Pharmacy not available at your location !!!',
                                    input: 'select',
                                    inputOptions:options,
                                    inputPlaceholder: 'Please select a pharmacy',
                                    showCancelButton: true,
                                    inputValidator: function (value) {
                                        return new Promise(function (resolve, reject) {
                                            if (value !== '') {
                                                resolve();
                                            } else {
                                                resolve('You need to select a Pharmacy');
                                            }
                                        });
                                    }
                                }).then(function (result) {
                                    $('input[name="pharmacy_id"]').val(result.value);
                                    if (result.value) {
                                        Swal.fire({
                                            icon: 'success',
                                            showConfirmButton: false,
                                            timer: 1000
                                        });
                                    }
                                });


                            },
                        });
                    }
                },
                error: function (response) {
                    console.log(response);
                }
            });
        }

        function getDeliveryType(deliveryType) {
            var payTypeValue =parseInt( $('input[name="payment_type"]:checked').val() );
            var deliveryCharge =parseInt( $('input[name="delivery_charge"]:checked').val() );
            console.log(deliveryCharge, 'hdjasdnj');

            $('input[name="delivery_type"]').val(deliveryType);

            addDeliveryChargeToGrandTotal(deliveryType, payTypeValue, deliveryCharge);
        }

        function getDeliveryChargeValue(deliveryCharge) {
            var payTypeValue =parseInt( $('input[name="payment_type"]:checked').val() );

            addDeliveryChargeToGrandTotal(deliveryType, payTypeValue, deliveryCharge);

            if (deliveryCharge === 1) {
                <!-- Normal delivery date calculation -->

                var normal_start_time = '09:00:00';
                var normal_end_time = '18:00:00';

                var normal_time_slot = ["10:00 am-12:00 am", "7:00 pm-9:00 pm"];

                var dt = new Date();
                var month = dt.getMonth()+ 1;
                var date = dt.getDate() + "-" + month  + "-" + dt.getFullYear()
                var next_date = (dt.getDate() + 1) + "-" + month + "-" + dt.getFullYear()
                console.log(date, 'today date');
                console.log(next_date, 'next date');

                var tm = new Date();
                var time = tm.getHours() + ":" + tm.getMinutes() + ":" + tm.getSeconds();
                // document.write(next_date);

                if ( time < normal_start_time) {
                    $(".normal_date").val("(" +normal_time_slot[0] + ")" + ", " + date);
                    $(".normal_delivery_date").val(date);
                    $(".normal_delivery_time").val('10:00:00');
                }
                if ( time > normal_start_time && time < normal_end_time) {
                    $(".normal_date").val("(" +normal_time_slot[1] + ")" + ", " + date);
                    $(".normal_delivery_date").val(date);
                    $(".normal_delivery_time").val('19:00:00');
                }
                else {
                    $(".normal_date").val("(" + normal_time_slot[0] + ")" + ", " + next_date);
                    $(".normal_delivery_date").val(next_date);
                    $(".normal_delivery_time").val('10:00:00');
                }
                <!-- End of Normal delivery date calculation -->

                $('.express-content').addClass('d-none');
                $('.normal-content').removeClass('d-none');
            }
            else {
                $('.express_slot').html('');

                <!-- Express delivery date calculation -->
                // var express_time = ['8:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '14:00', '16:00', '17:00', '18:00'];
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
                $.each(express_time_slot, function(key, value) {
                    $('.express_slot')
                        .append($("<option></option>")
                            .attr("value", express_time_slot_insert[key])
                            .text(value));
                });

                <!--End express delivery date calculation -->

                $('.express-content').removeClass('d-none');
                $('.normal-content').addClass('d-none');
            }
        }

        $('#expressTime').on('change', function () {
            var time_slot = $('#expressTime option:selected').val()

            var dt = new Date();
            var month = dt.getMonth()+ 1;

            var date = dt.getDate() + "-" + month + "-" + dt.getFullYear()
            var next_date = dt.getDate() + 1 + "-" + month + "-" + dt.getFullYear()

            var tm = new Date();
            var time = tm.getHours() + ":" + tm.getMinutes() + ":" + tm.getSeconds();

            var check_time = moment.utc(time_slot, 'hh:mm:ss').add(-2, 'hour').format('HH:mm:ss');
            var show_time = moment.utc(time_slot, 'hh:mm:ss').format('hh:mm A');

            if (time > check_time) {
                $('.express_date').val(show_time + ", " + next_date);
                $(".express_delivery_date").val(next_date);
                $(".express_delivery_time").val(time_slot);
            } else {
                $('.express_date').val( moment.utc(time_slot, 'hh:mm:ss').format('hh:mm A') + ", " + date);
                $(".express_delivery_date").val(date);
                $(".express_delivery_time").val(time_slot);
            }

        });


        function addDeliveryChargeToGrandTotal(deliveryType, payTypeValue, deliveryCharge) {
            let grandTotal = total;
            console.log(total, 'first total');
            $('input[name="delivery_charge_amount"]').prop('disabled', false);
            // console.log('hello 1');
            console.log('Add delivery total');
            console.log('Delivery type: ', deliveryType);
            console.log('pay type: ', payTypeValue);
            console.log('Delivery Charge: ', deliveryCharge);

            if (deliveryType === 1 && payTypeValue === 1 && deliveryCharge === 1) {
                grandTotal = total + cashInNormalDelivery;
                $('input[name="delivery_charge_amount"]').val(cashInNormalDelivery);

            }
            if (deliveryType === 1 && payTypeValue === 1 && deliveryCharge === 2) {
                grandTotal = total + cashInExpressDelivery;
                $('input[name="delivery_charge_amount"]').val(cashInExpressDelivery);
            }
            if (deliveryType === 1 && payTypeValue === 2 && deliveryCharge === 1) {
                console.log(ecashInNormalDelivery, 'e cash normal');
                grandTotal = total + parseFloat(ecashInNormalDelivery) ;
                $('input[name="delivery_charge_amount"]').val(ecashNoramlCharge);
                // $('input[name="delivery_charge_amount"]').val(ecashInNormalDelivery);
            }
            if (deliveryType === 1 && payTypeValue === 2 && deliveryCharge === 2) {
                console.log(ecashInExpressDelivery, 'e cash express');
                grandTotal = total + parseFloat(ecashInExpressDelivery);
                $('input[name="delivery_charge_amount"]').val(ecashExpressCharge)
            }

            if (deliveryType === 2 && payTypeValue === 1 ) {
                grandTotal = total - cashInCollectFromPharmacy;
                $('input[name="delivery_charge_amount"]').prop('disabled', true);
            }
            if (deliveryType === 2 && payTypeValue === 2 ) {
                console.log('deliveryType 2 and payTypeValue 2')
                grandTotal = total ;
                $('input[name="delivery_charge_amount"]').prop('disabled', true);
            }

            var grandTotalView = 'Grand Total : ' + grandTotal;

        if (deliveryType === 1 && payTypeValue === 1 && deliveryCharge === 1) {
            var grandTotalNormalDB = grandTotal - cashInNormalDelivery ;
            console.log(grandTotalNormalDB, 'normal grandTotalDB');
            $('input[name="amount"]').val(grandTotalNormalDB);
        }else if (deliveryType === 1 && payTypeValue === 1 && deliveryCharge === 2) {
            var grandTotalExpressDB = grandTotal - cashInExpressDelivery ;
            console.log(grandTotalExpressDB, 'normal grandTotalDB');
            $('input[name="amount"]').val(grandTotalExpressDB);
        }
        else if (deliveryType === 1 && payTypeValue === 2 && deliveryCharge === 1) {
            var egrandTotalNormalDB = grandTotal - ecashInNormalDelivery ;
            console.log(grandTotal, 'normal e grandTotal');
            console.log(ecashInNormalDelivery, 'normal e ecashInNormalDelivery');
            console.log(egrandTotalNormalDB, 'normal e grandTotalDB');
            $('input[name="amount"]').val(egrandTotalNormalDB);

        } else if (deliveryType === 1 && payTypeValue === 2 && deliveryCharge === 2) {
            var egrandTotalExpressDB = grandTotal - ecashInExpressDelivery ;
            console.log(egrandTotalExpressDB, 'express e grandTotalDB');
            $('input[name="amount"]').val(egrandTotalExpressDB);

        } else {
            $('input[name="amount"]').val(grandTotal);
        }
            // console.log('hello 2');

            console.log(typeof( cashInNormalDelivery ));
            console.log(cashInNormalDelivery);
            console.log(typeof( grandTotal));
            console.log(grandTotal);

            $('input[name="total"]').val(grandTotal);

            $('#grandTotal').html(grandTotalView);

        }


        function getPayTypeValue(payTypeValue) {
            var deliveryCharge = parseInt( $('input[name="delivery_charge"]:checked').val() );
            var deliveryType = parseInt( $('input[name="delivery_type"]').val() );
            console.log('paytype()');
            console.log(deliveryCharge);

            if (payTypeValue === 2) {
                $('#normal_delivery_charge').html(showNormalDeliveryChargeInEpay());
                $('#express_delivery_charge').html(showExpressDeliveryChargeInEpay());
                addDeliveryChargeToGrandTotal(deliveryType, payTypeValue, deliveryCharge);
            }
            else {
                $('#normal_delivery_charge').html(showNormalDeliveryChargeInCash());
                $('#express_delivery_charge').html(showExpressDeliveryChargeInCash());
                addDeliveryChargeToGrandTotal(deliveryType, payTypeValue, deliveryCharge);
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

        var addresses = {!! json_encode($allLocations) !!};
        var thanas = [];
        var areas = [];

        function getThanas() {
            var districtId = $('#selectDistrict option:selected').val();

            var selectedDistrict = addresses.find(address => address.id == districtId);

             thanas = selectedDistrict.thanas;

            $('#selectThana').html('');
            $('#selectThana').append(`<option value="" selected disabled>Please Select a thana</option>`);

            $.map(thanas, function(value) {
                $('#selectThana')
                    .append($("<option></option>")
                        .attr("value",value.id)
                        .text(value.name));
            });

        }

        function getAreas() {
            var areaId = $('#selectThana option:selected').val();
            var selectedThana = thanas.find(thana => thana.id == areaId);
            areas = selectedThana.areas;

            if ( areas.length === 0 ) {
                $('#selectArea').attr('disabled', 'disabled');
                $('#address').attr('disabled', 'disabled');
                $('#submit').attr('disabled', 'disabled');
            }

            $('#selectArea').html('');
            $.map(areas, function(value) {
                    $('#selectArea').removeAttr('disabled');
                    $('#address').removeAttr('disabled');
                    $('#submit').removeAttr('disabled');

                    $('#selectArea')
                        .append($("<option></option>")
                            .attr("value",value.id)
                            .text(value.name));
            });
        }
    </script>
@endsection
