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
        width: 2rem;
        height: 2rem;
        cursor: pointer;
        margin: 0;
        position: relative;
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
        width: 64px;
    }
    .count-style:focus {
        outline: none!important;
    }

    .order-summary table tbody tr td input {
        border: none!important;
    }
    .note-text {
        position: absolute;
        margin-left: -142px;
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
                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            <h2>Cart list</h2>
                        </div>
                    </div>
                    <div class="order-summary">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">Product</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Quantity</th>
                                    <th class="text-center">Sub total</th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $total = 0 ?>
                                @guest
                                    @if(session('cart'))
                                        @foreach(session('cart') as $id => $details)

                                            <?php $total += $details['amount'] * $details['quantity'] ?>
                                        <tr>
                                            <td scope="row">{{ $details['product_name'] }}</td>
                                            <td class="float-left">৳ {{ $details['amount'] }}</td>
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
                                                <td scope="row">{{ $details['product']['name'] }}</td>
                                                <td class="text-center">৳ {{ $details['product']['purchase_price'] }}</td>
                                                <td data-th="Quantity">
                                                    <div class="number-input" id="show-button-{{ $details->id }}">
                                                        <button id="decrease-{{$details->id }}" onclick="newItemdec(this, {{ $details['product']['purchase_price'] }}, {{ $details->id }}, {{ $details['product']['min_order_qty'] }})"></button>
                                                        <input id="input-{{ $details->id }}" class="quantity new-input-{{ $details->id }}" min="{{ $details['product']['min_order_qty'] }}"  name="quantity" value="{{ $details->quantity }}" type="number" readonly>
                                                        <button id="increase-{{$details->id }}" onclick="newItemIncrease(this, {{ $details['product']['purchase_price'] }}, {{ $details->id }}, {{ $details['product']['min_order_qty'] }})" class="plus"></button>
                                                    </div>
                                                </td>
                                                <td class="text-center">৳
                                                    <input class="countAmount-{{$details->id}} count-style" value="{{ $details->amount }}" readonly>
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
                                    <tr>
                                        <td><a href="{{ route('product-list')  }}" class="btn--primary d-block cart-btn">Continue Shopping</a></td>
                                        <td></td>
                                        <td class="text-right total-amount-alignment"><b>Grand total</b></td>
                                        <td class="text-center total-amount-alignment">৳
                                            <input type="number" class="grand-total count-style" value="{{ $total }}" readonly>
                                        </td>
                                        @guest
                                                <td><p class="badge btn-primary">Please login first to checkout</p></td>
                                            @else
                                                <td>
                                                    <a id="submit" href="#" onclick="checkMedicine({{ $data }})" class="btn--primary d-block cart-btn text-white">Checkout</a>
                                                    <strong class="note-text alert-note text-danger d-none">Please add amount more than ৳100</strong>
                                                </td>
                                        @endguest
                                    </tr>
                                </tbody>
                            </table>
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
            let total = inputNumber * price;
            let initTotal = parseInt($(".grand-total").val());
            let grandTotal = price + initTotal;

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
            let initTotal = parseInt($(".grand-total").val());
            let grandTotal = initTotal - price;

            $(".countAmount-"+productId).val(total-price);
            console.log(".countAmount-"+productId);
            $(".grand-total").val(grandTotal);
                // clearTimeout(cartDecrement);
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
                title: "Warning",
                text: "Do you want to delete this Medicine from Cart ?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
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
                $('.alert-note').removeClass('d-none');
                return;
            }

            $('.alert-note').addClass('d-none');

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
                title: "Pre-order Medicine",
                text: "You have a pre-order medicine in cart. It will take 3-5 days to deliver, do you want to continue?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
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
                title: "Notice",
                text: "You have a prescribed medicine in cart. Do you want to upload prescription?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
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
