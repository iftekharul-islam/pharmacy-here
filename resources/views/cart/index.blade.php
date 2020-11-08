@extends('layouts.app')
<style>
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        opacity: 1;
    }

    /**   **************  */
    input[type="number"] {
        -webkit-appearance: textfield;
        -moz-appearance: textfield;
        appearance: textfield;
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
    }

    .number-input {
        display: inline-flex;
    }

    .number-input,
    .number-input * {
        box-sizing: border-box;
    }

    .number-input button {
        outline:none;
        -webkit-appearance: none;
        background-color: transparent;
        align-items: center;
        justify-content: center;
        width: 1.5rem;
        height: 1.5rem;
        cursor: pointer;
        margin: 0;
        position: relative;
        margin-top: 4px;
        border: 1px solid #00AE4D;
        border-radius: 50%;
    }
    .number-input button:focus {
        outline: none !important;
    }
    .number-input button:before,
    .number-input button:after {
        display: inline-block;
        position: absolute;
        content: '';
        width: 1rem;
        height: 2px;
        background-color: #00AE4D;
        transform: translate(-50%, -50%);
    }
    .number-input button.plus:after {
        transform: translate(-50%, -50%) rotate(90deg);
    }

    .number-input input[type=number] {
        width: 60px;
        font-family: sans-serif;
        max-width: 4.25rem;
        padding: .5rem;
        border: solid #ddd;
        border-width: 0 5px;
        font-size: 1.6rem;
        height: 2rem;
        font-weight: bold;
        text-align: center;
    }
    .number-input input[type=number]:focus {
        outline: none!important;
    }
    .count-style {
        border: none;
        height: 25px;
        width: 50% !important;
    }
    .count-style:focus {
        outline: none!important;
    }

    .order-summary table tbody tr td input {
        border: none!important;
    }
    .btn-continue {
        width: 180px;
        color: #00AE4D !important;
        border-radius: 10px;
        border: 1px solid #00AE4D!important;
    }

    @media (max-width: 510px){
        .btn-continue {
            font-size: 8px!important;
            width: 160px;
            color: #00AE4D !important;
            border-radius: 10px;
            border: 1px solid #00AE4D!important;
            margin-right: 20px;
        }
    }
    .btn-checkout {
        width: 180px;
        background: #00AE4D !important;
        font-weight: 500;
        font-size: 16px;
    }
    @media (max-width: 992px) {
        .btn-checkout {
            font-size: 8px!important;
            width: 160px;
            background: #00AE4D !important;
            font-weight: 500;
            font-size: 16px;
        }

    }
    .btn-continue:hover{
        background: #00AE4D;
        font-weight: 500;
        font-size: 16px;
        color: #ffffff!important;
    }
    .grand-total-final {
        /*margin-left: 408px;*/
        width: 209px;
        display: flex;
        position: absolute;
        bottom: 6px;
        right: 200px;
    }

    @media ( max-width: 992px) {
        .grand-total-final {
            display: flex;
            width: 100%;
            margin-left: 0px;
            top: -14px;
            position: absolute;
            margin-right: -216px;
            font-size: 13px;
        }
        .grand-total-final input {
            position: absolute;
            width: 130px !important;
            left: 90px;
            top: -2px;
        }
    }
    .grand-total-count-style {
        border: none;
        height: 25px;
        width: 40% !important;
    }
    @media (max-width: 992px) {
        .grand-total-count-style {
            border: none;
            height: 25px;
            width: 80% !important;
            font-size: 13px;
        }
    }
    .grand-total-count-style:focus {
        outline: none!important;
    }
    .new-cart-button {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    @media (max-width: 992px) {
        .new-cart-button {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 20px;
        }

    }
</style>
@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif(session('failed'))
        <div class="alert alert-danger">
            {{ session('failed') }}
        </div>
    @endif
    <!-- cart section -->
    <div class="cart-section">
        <div class="container">
            <div class="row">
                <div class="col-10 mx-auto">
                    <div class="row">
                        <div class="col-12">
                            <h2>{{ __('text.cart_list') }}</h2>
                        </div>
                    </div>
                    <strong class="note-text text-danger d-none">Please add amount more than ৳100</strong>
                    <div class="order-summary">
                        <div class="table-responsive">
                            <table class="table">
{{--                                <thead class="thead-light">--}}
                                <tbody>
                                <tr>
                                    <td scope="col">{{ __('text.product') }}</td>
                                    <td scope="col">{{ __('text.price') }}</td>
                                    <td scope="col">{{ __('text.quantity') }}</td>
                                    <td scope="col" class="text-center">{{ __('text.sub_total') }}</td>
                                    <td scope="col"></td>
                                </tr>
{{--                                </thead>--}}
                                <tbody>
                                <?php $total = 0 ?>
                                @guest
                                    @if(session('cart'))
                                        @foreach(session('cart') as $id => $details)

                                            <?php $total += $details['amount'] * $details['quantity'] ?>
                                        <tr>
                                            <td scope="row">{{ $details['product_name'] }}</td>
                                            <td class="float-left">৳ {{ $details['amount'] }} / {{ __('text.piece') }}</td>
                                            <td data-th="Quantity"><input type="number" class="quantity" value="{{ $details['quantity'] }}" min="{{ $details['minQuantity'] }}"></td>
                                            <td data-th="Subtotal" class="text-center"><p>৳</p> {{ $details['amount'] * $details['quantity'] }}</td>
                                            <td>
                                                <div class="actions" data-th="">
                                                    <button class="btn btn-info btn-sm update-cart" data-id="{{ $id }}"><i class="fa fa-refresh"></i></button>
                                                    <button class="btn btn-danger btn-sm remove-from-cart ml-2" data-id="{{ $id }}"><i class="fa fa-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endif
                                @else
                                    @if($data)
                                        @foreach($data as $id => $details)

                                            <?php $total += $details['product']['purchase_price'] * $details['quantity'] ?>
                                            <tr>
                                                <td scope="row">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            @if ($details->product->form->slug == 'tablet' || $details->product->form->name == 'capsul')
                                                                <img src="{{ asset('images/pill.png') }}" class="pill" alt="pill">
                                                            @elseif ($details->product->form->slug == 'syrup')
                                                                <img src="{{ asset('images/syrup.png') }}" class="pill" alt="syrup">
                                                            @elseif ($details->product->form->slug == 'injection')
                                                                <img src="{{ asset('images/injection.png') }}" class="pill" alt="injection">
                                                            @elseif ($details->product->form->slug == 'suppository')
                                                                <img src="{{ asset('images/suppositories.png') }}" class="pill" alt="suppositories">
                                                            @else
                                                                <img src="{{ asset('images/pill.png') }}" class="pill" alt="pill">
                                                            @endif
                                                        </div>
                                                        <div class="col-md-9">
                                                            <strong>{{ $details['product']['name'] }}</strong><br>
                                                            <small>{{ $details['product']['form']['name'] }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>৳ {{ $details['product']['purchase_price'] }} / {{ __('text.piece') }}</td>
                                                <td data-th="Quantity">
                                                    <div class="number-input" id="show-button-{{ $details->id }}">
                                                        <button id="decrease-{{$details->id }}" onclick="newItemdec(this, {{ $details['product']['purchase_price'] }}, {{ $details->id }}, {{ $details['product']['min_order_qty'] }})"></button>
                                                        <input id="input-{{ $details->id }}" class="quantity new-input-{{ $details->id }}" min="{{ $details['product']['min_order_qty'] }}"  name="quantity" value="{{ $details->quantity }}" type="number" readonly>
                                                        <button id="increase-{{$details->id }}" onclick="newItemIncrease(this, {{ $details['product']['purchase_price'] }}, {{ $details->id }}, {{ $details['product']['min_order_qty'] }})" class="plus"></button>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <input class="countAmount-{{$details->id}} count-style text-left ml-4" value="৳ {{ $details->amount }}" readonly>
                                                </td>
                                                <td>
                                                    <div class="actions" data-th="">
                                                        <button class="btn btn-danger btn-sm remove-from-cart ml-2" data-id="{{ $details->id  }}"><i class="fa fa-trash"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endguest
                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="new-cart-button">
                                    <a href="{{ route('product-list')  }}" class="btn btn-continue d-block text-center"><i class="fas fa-arrow-left"></i> {{ __('text.continue_shopping') }}</a>
                                    <a id="submit" href="#" onclick="checkMedicine({{ $data }})" class="btn btn-checkout d-block text-center text-white">{{ __('text.checkout') }}</a>
                                </div>
                                <div class="text-center grand-total-final">
                                    <b>Grand Total : ৳</b>
                                    <input type="number" class="grand-total grand-total-count-style" value="{{ $total }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        // (function () {
        //     let total = $('.grand-total').val();
        //     if ( total < 100 ) {
        //         $('#submit').addClass('disabled');
        //     }
        // })();
        let cartIncrement, cartDecrement;
        function  newItemIncrease(item, price, productId, minValue) {

            console.log(item, 'this');
            console.log(productId, 'productId');

            item.parentNode.querySelector('input[type=number]').stepUp();

            let inputNumber = $('#' + item.id).parent().find('input').val();
            let total = parseFloat(inputNumber * price).toFixed(2);
            let initTotal = $(".grand-total").val();
            let grandTotal = parseFloat(price + parseFloat(initTotal)).toFixed(2);

            console.log(inputNumber, 'inputNumber');
            console.log(total, 'total');
            console.log(initTotal, 'initTotal');
            console.log(grandTotal, 'grandTotal');

            $(".countAmount-"+productId).val(total);
            $(".grand-total").val(grandTotal);


                clearTimeout(cartIncrement);
                clearTimeout(cartDecrement);

                cartIncrement = setTimeout(function () {
                    $.ajax({
                        url: "{{ route('update.cart') }}",
                        method: "put",
                        data: {_token: "{{ csrf_token() }}", id: productId, quantity: inputNumber },

                        success: function (result) {
                            console.log('cart updated');
                        },
                        error: function (result) {
                            console.log(result);
                        }
                    });
                }, 500);

        }

        function  newItemdec(item, price, productId, minValue) {

            let inputNumber = $('#' + item.id).parent().find('input').val();
            let newValue = parseInt(inputNumber);

            if (  newValue <= minValue ) {
                return;
            }

            item.parentNode.querySelector('input[type=number]').stepDown();

            let total = newValue * price;
            let initTotal = $(".grand-total").val();
            let grandTotal = parseFloat(parseFloat(initTotal).toFixed(2) - price).toFixed(2);

            console.log(total, 'total');
            console.log(initTotal, 'initTotal');
            console.log(grandTotal, 'grandTotal');

            $(".countAmount-"+productId).val(parseFloat(total - price).toFixed(2));
            $(".grand-total").val(grandTotal);


                clearTimeout(cartIncrement);

                cartDecrement = setTimeout(function () {

                        $.ajax({
                            url: "{{ route('update.cart') }}",
                            method: "put",
                            data: {_token: "{{ csrf_token() }}", id: productId, quantity: newValue - 1},

                            success: function (result) {
                                console.log('cart updated');
                            },
                            error: function (result) {
                                console.log(result);
                            }
                        });

                }, 500);
        }
        $(".update-cart").click(function (e) {
            e.preventDefault();

            var ele = $(this);

            $.ajax({
                url: '{{ url('cart/update-cart') }}',
                method: "put",
                data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id"), quantity: ele.parents("tr").find(".quantity").val()},
                success: function (response) {
                    window.location.reload();
                }
            });
        });

        $(".remove-from-cart").click(function (e) {
            e.preventDefault();

            var ele = $(this);

            Swal.fire({
                title: "{{ __('text.warning') }}",
                text: "{{ __('text.delete_cart') }}",
                icon: "warning",
                showCancelButton: true,
                reverseButtons: true,
                cancelButtonColor: '#d33',
                confirmButtonColor: '#00AE4D',
                cancelButtonText: 'No',
                confirmButtonText: 'Yes',
            }).then((result) => {
                if (result.isConfirmed)  {
                    $.ajax({
                        url: '{{ url('cart/remove-from-cart') }}',
                        method: "DELETE",
                        data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id")},
                        success: function (response) {
                            window.location.reload();
                        }
                    });
                }
            });
        });


            var newData = '';
        function checkMedicine(data){
            let total = $('.grand-total').val();
            console.log(total, 'total');
            if ( total < 100 ) {
                $('.note-text').removeClass('d-none');
                return;
            }

            $('.note-text').addClass('d-none');

            let medicineData = data;
            newData = data;

            var preOrderMedicine = isPreOrderMedicine(medicineData);
            var prescribedMedicine = isPrescribedMedicine(newData);
            if (preOrderMedicine) {
                preOrderMedicineAlert();
                return;
            }
            if (prescribedMedicine) {
                isPrescribedMedicineAlert(newData);
                return;
            }
            window.location = "/checkout/preview";
        }

        function isPreOrderMedicine(medicines) {
            let count = 0;
            $.each(medicines, function(key, value) {
                if (value.product.is_pre_order) {
                    count++;
                }
            });
            return !!count;
        }

        function preOrderMedicineAlert() {
            Swal.fire({
                title: "{{ __('text.pre_order_medicine') }}",
                text: "{{ __('text.pre_order_medicine_notice') }}",
                icon: "warning",
                showCancelButton: true,
                reverseButtons: true,
                confirmButtonColor: '#00AE4D',
                cancelButtonColor: '#d33',
                cancelButtonText: 'No',
                confirmButtonText: 'Yes',
            })
            .then((result) => {
                if (result.isConfirmed) {
                    var prescribedMedicine = isPrescribedMedicine(newData);
                    if (prescribedMedicine) {
                        isPrescribedMedicineAlert(newData);
                        return;
                    }
                    window.location = "/checkout/preview"
                }
                if (result.isDismissed) {

                }
            });

        }

        function isPrescribedMedicine(medicines) {
            let count = 0;
            $.each(medicines, function(key, value) {
                if (value.product.is_prescripted) {
                    count++;
                }
            });

            return !!count;

        }

        function isPrescribedMedicineAlert(medicines) {
            Swal.fire({
                title: "{{ __('text.warning') }}",
                text: "{{ __('text.prescribed_medicine_notice') }}",
                icon: "warning",
                showCancelButton: true,
                reverseButtons: true,
                confirmButtonColor: '#00AE4D',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'Remove prescribed medicine',
            })
            .then((result) => {
                if (result.isConfirmed) {
                    window.location = "/prescription/create";
                }
                if (result.dismiss === Swal.DismissReason.cancel) {
                    removePrescribedMedicine(medicines);
                }
            });
        }

        function removePrescribedMedicine(medicines) {
            var medicineIds = [];
            $.each(medicines, function(key, value) {
                if (value.product.is_prescripted) {
                    medicineIds.push(value.id);
                }
            });

            $.ajax({
                url: '{{ url('cart/remove-from-cart') }}',
                method: "DELETE",
                data: {_token: '{{ csrf_token() }}', id: medicineIds},
                success: function (response) {
                    console.log(response);
                    window.location = "/checkout/preview";
                }
            });
        }



    </script>

@endsection
