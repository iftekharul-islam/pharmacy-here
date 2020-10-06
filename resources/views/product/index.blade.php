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
        border: 1px solid #ddd;
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
        border: none;
        align-items: center;
        justify-content: center;
        width: 2rem;
        height: 2rem;
        cursor: pointer;
        margin: 0;
        position: relative;
    }

    .number-input button:before,
    .number-input button:after {
        display: inline-block;
        position: absolute;
        content: '';
        width: 1rem;
        height: 2px;
        background-color: #212121;
        transform: translate(-50%, -50%);
    }
    .number-input button.plus:after {
        transform: translate(-50%, -50%) rotate(90deg);
    }

    .number-input input[type=number] {
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
</style>
@section('content')
    <section class="medicine-section">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h2>Medicines</h2>
                </div>
            </div>
            @if (count($data) > 0)
                <div class="row mb-5">
                    @foreach($data as $index=>$item)
                        <div class="col-sm-6 col-lg-3 mb-3">
                            <div href="#" class="medicine-details">
                                @if ($item->is_prescripted == 1)
                                    <div class="madicine-badge">RX</div>
                                @endif
                                <div class="text-right mb-2">
                                    <i class="fas fa-heart"></i>
                                </div>
                                <div class="text-center mb-4">
                                    <img src="{{ asset('images/pill.png') }}" class="pill" alt="medicine">
                                </div>
                                <div class="medicine-details--content">
                                    @if ($item->is_pre_order == 1 )
                                        <a href="#" class="mb-3">Pre-order</a>
                                        @else
                                        <span class="mb-3"></span>
                                    @endif
                                    <p><h5>{{ $item->name }}</h5></p>
                                    <p><strong>{{ $item->company->name }}</strong></p>
                                </div>
                                <div class="package d-flex justify-content-between">
                                    <p>৳ {{ $item->purchase_price }}</p>
                                    <p>Min quantity ({{ $item->min_order_qty }})</p>
                                </div>
                                <p><strong>Packaging Type - <a class="badge-primary badge text-white">{{ $item->type }}</a></strong></p>
                                <div class="medicine-details--footer d-flex justify-content-between align-items-center">
                                @auth
                                    @php
                                        $matchedItem = null;
                                    @endphp
                                    @foreach ($cartItems as $cart)
                                        @if ($cart->product_id === $item->id)
                                                @php
                                                    $matchedItem = $cart;
                                                @endphp
                                            @break
                                        @endif
                                    @endforeach
                                        <div class="number-input {{ $matchedItem ? 'block' : 'd-none'}}" id="show-button-{{ $item->id }}">
                                            <button onclick="newItemdec(this, {{ $matchedItem ?  $matchedItem->id . ',' : ''}} {{ $item->min_order_qty }}, {{ $item->id }});" class="{{$matchedItem ? '' : 'disabled'}}"></button>
                                            <input class="quantity new-input-{{ $matchedItem ?  $matchedItem->id : '' }} {{$matchedItem ? '' : 'disabled'}}" min="9" name="quantity" value="{{ $matchedItem ? $matchedItem->quantity : '10'}}" type="number">
                                            <button onclick="newItemIncrease(this, {{ $matchedItem ?  $matchedItem->id. ',' : '' }} {{ $item->min_order_qty }}, {{ $item->id }});" class="plus {{$matchedItem ? '' : 'disabled'}}"></button>
                                        </div>

                                        <a href="{{ route('cart.addToCart', $item->id) }}" id="show-cart-{{ $item->id }}" class=" btn--add-to-cart {{ $matchedItem ? 'd-none' : 'block'}}"><i class="fas fa-cart-plus"></i> Add to Cart</a>
                                @else
                                    <a href="{{ route('cart.addToCart', $item->id) }}" id="show-cart-{{ $item->id }}" class="btn--add-to-cart" onclick="addToCart({{ $item->id }})"><i class="fas fa-cart-plus"></i> Add to Cart</a>
                                @endauth
                                    <a href="{{ route('single-product', $item->id) }}" class="eyes"><i class="fas fa-eye"></i></a>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <h4 class="text-center">No Medicine Found!</h4>
            @endif
        </div>
    </section>
@endsection
@section('js')
    <script>
        {{--function addToCart(item, id) {--}}
        {{--    console.log(item, "this")--}}
        {{--    $('#show-cart-' + id).addClass('d-none');--}}
        {{--    $('#show-button-' + id).removeClass('d-none');--}}
        {{--    $('.new-input-' + id).val(10);--}}
        {{--    $.ajax({--}}
        {{--        url: 'cart/add-to-cart/' + id,--}}
        {{--        method: "get",--}}
        {{--        data: {_token: "{{ csrf_token() }}" },--}}

        {{--        success: function(result) {--}}
        {{--            console.log('Add to cart');--}}
        {{--        },--}}
        {{--        error: function(result) {--}}
        {{--            console.log(result);--}}
        {{--        }--}}
        {{--    });--}}
        {{--}--}}

        let cartIncrement, cartDecrement;

        function  newItemIncrease(item, id, minValue) {

            console.log('up');
            item.parentNode.querySelector('input[type=number]').stepUp();
            let inputNumber = $('.new-input-' + id).val();

            clearTimeout(cartIncrement);
            clearTimeout(cartDecrement);

            cartIncrement = setTimeout(function () {

                $.ajax({
                    url: "{{ route('update.cart') }}",
                    method: "put",
                    data: {_token: "{{ csrf_token() }}", id: id, quantity: inputNumber },

                    success: function(result) {
                        console.log('cart updated');
                    },
                    error: function(result) {
                        console.log(result);
                    }
                });
            }, 500);


        }

        function  newItemdec(item, id, minValue, itemId) {

            {{--if (itemId === undefined) {--}}
            {{--    $.ajax({--}}
            {{--        url: "{{ route('find.cart') }}",--}}
            {{--        method: "get",--}}
            {{--        data: {_token: "{{ csrf_token() }}", id: minValue},--}}

            {{--        success: function(result) {--}}
            {{--            $('#show-cart-' + minValue).removeClass('d-none');--}}
            {{--            $('.new-input-' + id).val(id);--}}
            {{--            $('#show-button-' + minValue).addClass('d-none');--}}
            {{--            $('#show-button-' + minValue).removeClass('block');--}}
            {{--            id = result;--}}
            {{--        },--}}
            {{--        error: function(result) {--}}
            {{--            console.log(result);--}}
            {{--        }--}}
            {{--    });--}}
            {{--}--}}

            console.log('down');
            console.log(item, 'item');
            console.log(id, 'id');
            console.log(minValue, 'minValue');
            console.log(itemId, 'itemId');

            item.parentNode.querySelector('input[type=number]').stepDown();
            let inputNumber = $('.new-input-' + id).val();

            if (itemId === undefined){
                $('#show-cart-' + minValue).removeClass('d-none');
                $('.new-input-' + id).val(10);
                $('#show-button-' + minValue).addClass('d-none');
                $('#show-button-' + minValue).removeClass('block');
            }
            else {
                if ( inputNumber < minValue )  {
                    $('#show-cart-' + itemId).removeClass('d-none');
                    $('.new-input-' + id).val(minValue);
                    $('#show-button-' + itemId).addClass('d-none');
                    $('#show-button-' + itemId).removeClass('block');
                }
            }

            clearTimeout(cartDecrement);
            clearTimeout(cartIncrement);

            cartDecrement = setTimeout(function () {
                if (inputNumber >= minValue) {
                    $.ajax({
                        url: "{{ route('update.cart') }}",
                        method: "put",
                        data: {_token: "{{ csrf_token() }}", id: id, quantity: inputNumber },

                        success: function(result) {
                            console.log('cart updated');
                        },
                        error: function(result) {
                            console.log(result);
                        }
                    });
                } else {
                    $.ajax({
                        url: "{{ route('delete.cart') }}",
                        method: "DELETE",
                        data: {_token: "{{ csrf_token() }}", id: id},

                        success: function(result) {
                            console.log('delete from cart');
                            // console.log(result);
                        },
                        error: function(result) {
                            console.log(result);
                        }
                    });
                }

            }, 500);
        }
    </script>
@endsection
