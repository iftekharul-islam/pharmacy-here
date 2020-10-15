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
        border-radius: 50%;
        border: 1px solid #00AE4D;
        cursor: pointer;
        margin: 0;
        position: relative;
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
        font-family: sans-serif;
        max-width: 4.25rem;
        padding: .5rem;
        border: none;
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
    .my-header {
        margin-bottom: 1px!important;
    }
    .my-header-search {
        margin-bottom: 30px;
        margin-right: 0px!important;
        position: relative;
    }
    #searchResult {
        /*padding-top: 8px;*/
        position: absolute;
        width: 94.5%;
        z-index: 99;
        border: 1px solid #ced4da;
        margin-top: -11px;
        background: white;
        border-bottom-left-radius: 15px;
        border-bottom-right-radius: 15px;

    }
    #searchResult ul{
        overflow: hidden;
    }
    #searchResult li {
        padding-left: 2rem;
        padding-top: 2px;
        padding-bottom: 10px;
        text-align: left;
        cursor: pointer;

    }
    #searchResult li:last-child {
        border-bottom-left-radius: 15px;
        border-bottom-right-radius: 15px;
    }
    #searchResult li:hover {
        background: #ddd;
    }
    #medicine_search {
        z-index: 100;
    }
</style>
@section('content')
    <section class="medicine-section">
        @if(session('success'))
            <div id="successMessage" class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif (session('failed'))
            <div id="successMessage" class="alert alert-danger">
                {{ session('failed') }}
            </div>
        @endif
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-4 text-left">
                    <h2 class="my-header">{{ trans_choice('text.medicine', 10) }}</h2>
                </div>
                <div class="my-header-search col-md-6 ml-auto">
                    <label class="w-100 label-search">
                        <form id="form" action="{{ route('product-list') }}" method="GET">
                            <input type="text" id="medicine_search" class="form-control" name="medicine" placeholder="{{ __('text.search_medicine') }}">
                            <button type="submit" class="search-button"><i class="fas fa-search"></i></button>
                        </form>
                    </label>
                    <ul id="searchResult">
                    </ul>
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
                                @if ($item->form->slug == 'tablet' || $item->form->name == 'capsul')
                                    <img src="{{ asset('images/pill.png') }}" class="pill" alt="pill">
                                @elseif ($item->form->slug == 'syrup')
                                    <img src="{{ asset('images/syrup.png') }}" class="pill" alt="syrup">
                                @elseif ($item->form->slug == 'injection')
                                    <img src="{{ asset('images/injection.png') }}" class="pill" alt="injection">
                                @elseif ($item->form->slug == 'suppository')
                                    <img src="{{ asset('images/suppositories.png') }}" class="pill" alt="suppositories">
                                @else
                                    <img src="{{ asset('images/pill.png') }}" class="pill" alt="pill">
                                @endif
                                </div>
                                <div class="medicine-details--content">
                                    @if ($item->is_pre_order == 1 )
                                        <a href="#" class="mb-3">Pre-order</a>
                                        @else
                                        <span class="mb-3"></span>
                                    @endif
                                        <h4 style="margin: 0px">{{ $item->name }}</h4>
                                        <small>{{ $item->primaryUnit->name }}</small>
                                    <p><strong>{{ $item->company->name }}</strong></p>
                                </div>
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
                                        <div class="package d-flex justify-content-between">
                                            <p id="item-price-show-{{ $item->id }}" class="{{$matchedItem ? 'd-none' : ''}}">৳ {{ $item->purchase_price }} / {{ __('text.piece') }}</p>
                                            <input id="cart-price-show-{{ $item->id }}" class="countAmount-{{$item->id}} count-style {{$matchedItem ? '' : 'd-none'}}" style="color: #00CE5E;" value="৳ {{ $matchedItem ? $matchedItem->amount : '' }}" readonly>
                                            <p>{{ __('text.min_qty') }} ({{ $item->min_order_qty }})</p>
                                        </div>
                                        @else
                                        <div class="package d-flex justify-content-between">
                                            <p>৳ {{ $item->purchase_price }}</p>
                                            <p>Min quantity ({{ $item->min_order_qty }})</p>
                                        </div>
                                    @endauth
                                <p><strong>{{ __('text.packing_type') }} - <a class="badge-primary badge text-white">{{ $item->type }}</a></strong></p>
                                <div class="medicine-details--footer d-flex justify-content-between align-items-center">
                                @guest
                                        <a href="{{ route('customer.login') }}" id="show-cart-{{ $item->id }}" class="btn--add-to-cart"><i class="fas fa-cart-plus"></i> {{ __('text.add_to_cart') }}t</a>
                                @else
                                        <div class="number-input {{ $matchedItem ? 'block' : 'd-none'}}" id="show-button-{{ $item->id }}">
                                            <button id="decrease-{{$item->id }}" onclick="newItemdec(this, {{ $item->min_order_qty }}, {{ $item->purchase_price }}, {{ $item->id }} {{ $matchedItem ?  ',' .$matchedItem->id : ''}});" class="{{$matchedItem ? '' : 'disabled'}}"></button>
                                            <input id="input-{{$item->id }}" class="quantity new-input-{{ $matchedItem ?  $matchedItem->id : '' }} {{$matchedItem ? '' : 'disabled'}}"  name="quantity" value="{{ $matchedItem ? $matchedItem->quantity : '10'}}" type="number" readonly>
                                            <button id="increase-{{$item->id }}" onclick="newItemIncrease(this, {{ $item->purchase_price }}, {{ $item->id }} {{ $matchedItem ?  ',' .$matchedItem->id : '' }});" class="plus {{$matchedItem ? '' : 'disabled'}}"></button>
                                        </div>
                                        <a href="#" id="show-cart-{{ $item->id }}" onclick="addToCart(this, {{ $item->id }}, {{ $item->min_order_qty }}, {{ $item->purchase_price }});" class=" btn--add-to-cart {{ $matchedItem ? 'd-none' : 'block'}}"><i class="fas fa-cart-plus"></i> {{ __('text.add_to_cart') }}</a>
                                @endguest
                                    <a href="{{ route('single-product', ['medicine_id' => $item->id, 'medicine_slug' => $item->slug ] ) }}" class="eyes"><i class="fas fa-eye"></i></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{ $data->links() }}
            @else
                <h4 class="text-center">No Medicine Found!</h4>
            @endif
        </div>
    </section>
@endsection
@section('js')
    <script>
        var isNameSet = false;
        $(document).ready(function(){

            console.log(isNameSet);

            if (!isNameSet) {
                $("#medicine_search").keyup(function () {
                    var search = $(this).val();
                    console.log(search);
                    if (search != "") {
                        $.ajax({
                            url: "search/medicine-name",
                            type: 'get',
                            data: {medicine: search},
                            dataType: 'json',
                            success: function (response) {
                                var len = response.length;
                                $("#searchResult").empty();
                                $("#searchResult").append(`<li value=""></li>`);
                                for (var i = 0; i < len; i++) {
                                    console.log(response[i]);
                                    var id = response[i]['id'];
                                    var name = response[i]['name'];
                                    var image = response[i]['form_id'];
                                    if(image == 1 || image == 2){
                                        var pill = `<img width="20px" height="20px" src="{{ asset('images/pill.png') }}" class="pill mr-2" alt="pill">`;
                                    }
                                    else if (image == 3) {
                                        var pill = `<img width="20px" height="20px" src="{{ asset('images/syrup.png') }}" class="pill mr-2" alt="pill">`;
                                    }
                                    else if (image == 4) {
                                        var pill = `<img width="20px" height="20px" src="{{ asset('images/injection.png') }}" class="pill mr-2" alt="pill">`;
                                    }
                                    else if (image == 5) {
                                        var pill = `<img width="20px" height="20px" src="{{ asset('images/suppositories.png') }}" class="pill mr-2" alt="pill">`;
                                    }else {
                                        var pill = `<img width="20px" height="20px" src="{{ asset('images/pill.png') }}" class="pill mr-2" alt="pill">`;
                                    }

                                    if (search != name) {
                                        $("#searchResult")
                                            .append(`<li value='" + id + "'>` +
                                                pill + name +
                                                `</li> ` );
                                    }

                                }
                                // binding click event to li
                                $("#searchResult li").bind("click", function () {
                                    console.log(this);
                                    setText(this);
                                    isNameSet = true;

                                    console.log(isNameSet);
                                    $('#form').submit();
                                });
                            }
                        });
                    } else {
                        $("#searchResult").empty();
                    }
                });
            }
        });
        // Set Text to search box and get details
        function setText(element){
            var value = $(element).text();
            $("#medicine_search").val(value);
            $("#searchResult").empty();
        }


        function addToCart(item, id, minValue, price) {
            console.log(item, "this")
            console.log(id, "id")
            $('#item-price-show-' + id).addClass('d-none');
            $('#cart-price-show-' + id).removeClass('d-none');
            let total = minValue * price;
            $('#cart-price-show-' + id).val('৳ ' +total);

            $('#show-cart-' + id).addClass('d-none');
            $('#show-button-' + id).removeClass('d-none');
            $('#input-' + id).val(minValue);

            {{--var zoektermen = '{{session()->put('cartCount', count()+1 ?? '') }}';--}}
{{--            {!! session()->!!}--}}

            $.ajax({
                url: 'cart/add-to-cart/' + id,
                method: "get",
                data: {_token: "{{ csrf_token() }}" },

                success: function(result) {
                    console.log('Add to cart');

                    getCartCount();
                },
                error: function(result) {
                    console.log(result);
                }
            });
        }

        let cartIncrement, cartDecrement;

        function  newItemIncrease(item, price, productId, id) {

            console.log(item, 'this');
            console.log(productId, 'productId');

            item.parentNode.querySelector('input[type=number]').stepUp();

            let inputNumber = $('#' + item.id).parent().find('input').val();
            let total = inputNumber * price;

            $(".countAmount-"+productId).val('৳ ' +total);

            if (id === undefined) {

                clearTimeout(cartIncrement);
                clearTimeout(cartDecrement);
                cartIncrement = setTimeout(function () {

                $.ajax({
                    url: "{{ route('find.cart') }}",
                    method: "get",
                    data: {_token: "{{ csrf_token() }}", id: productId},

                    success: function(result) {
                        console.log(result)
                        id = result.id;
                        console.log(id, 'id form ajax')
                        console.log(productId, 'productId form ajax')

                        let inputNumber = $('#' + item.id).parent().find('input').val();
                        console.log(inputNumber, 'from inputNumber');

                            console.log(inputNumber, 'inputNumber from update ajax')
                            console.log(productId, 'productId from update ajax')
                            $.ajax({
                                url: "{{ route('update.cart') }}",
                                method: "put",
                                data: {_token: "{{ csrf_token() }}", id: id, quantity: inputNumber, productId: productId },

                                success: function(result) {
                                    console.log('cart updated');
                                },
                                error: function(result) {
                                    console.log(result);
                                }
                            });

                    },
                    error: function(result) {
                        console.log(result);
                    }
                });
                }, 100);

            } else {

                console.log(productId, 'up productId');
                console.log('up');
                console.log(item.id);

                let inputNumber = $('#' + item.id).parent().find('input').val();
                console.log(inputNumber, 'from inputNumber');


                clearTimeout(cartIncrement);
                clearTimeout(cartDecrement);

                cartIncrement = setTimeout(function () {
                    console.log(inputNumber, 'inputNumber from update ajax')
                    console.log(productId, 'productId from update ajax')
                    $.ajax({
                        url: "{{ route('update.cart') }}",
                        method: "put",
                        data: {_token: "{{ csrf_token() }}", id: id, quantity: inputNumber, productId: productId},

                        success: function (result) {
                            console.log('cart updated');
                        },
                        error: function (result) {
                            console.log(result);
                        }
                    });
                }, 500);

            }
        }

        function  newItemdec(item, minValue, price, productId, id) {

            item.parentNode.querySelector('input[type=number]').stepDown();

            let inputNumber = $('#' + item.id).parent().find('input').val();
            let total = inputNumber * price;

            $(".countAmount-"+productId).val('৳ ' + total);

            if (id === undefined) {

                if (inputNumber < minValue) {
                    $('#show-cart-' + productId).removeClass('d-none');
                    $('.new-input-' + id).val(minValue);
                    $('#show-button-' + productId).addClass('d-none');
                    $('#show-button-' + productId).removeClass('block');

                    $('#item-price-show-'+productId).removeClass('d-none');
                    $('#cart-price-show-'+productId).addClass('d-none');
                }

                clearTimeout(cartDecrement);
                clearTimeout(cartIncrement);

                cartDecrement = setTimeout(function () {

                $.ajax({
                    url: "{{ route('find.cart') }}",
                    method: "get",
                    data: {_token: "{{ csrf_token() }}", id: productId},

                    success: function (result) {
                        id = result.id;
                        productId =  result.product_id;

                        var inputNumber = $('#' + item.id).parent().find('input').val();
                        console.log(inputNumber, 'from inputNumber');

                        if (productId === undefined || inputNumber === undefined) {
                            $('#show-cart-' + minValue).removeClass('d-none');
                            $('.new-input-' + id).val(minValue);
                            $('#show-button-' + minValue).addClass('d-none');
                            $('#show-button-' + minValue).removeClass('block');
                        } else {
                            if (inputNumber < minValue) {
                                $('#show-cart-' + productId).removeClass('d-none');
                                $('.new-input-' + id).val(minValue);
                                $('#show-button-' + productId).addClass('d-none');
                                $('#show-button-' + productId).removeClass('block');

                                $('#item-price-show-'+productId).removeClass('d-none');
                                $('#cart-price-show-'+productId).addClass('d-none');
                            }
                        }
                            console.log(inputNumber, 'inputNumber');
                            console.log(minValue, 'minValue');


                            if (inputNumber >= minValue) {

                                $.ajax({
                                    url: "{{ route('update.cart') }}",
                                    method: "put",
                                    data: {
                                        _token: "{{ csrf_token() }}",
                                        id: id,
                                        quantity: inputNumber,
                                        productId: productId
                                    },

                                    success: function (result) {
                                        console.log('cart updated');
                                    },
                                    error: function (result) {
                                        console.log(result);
                                    }
                                });
                            } else {
                                $.ajax({
                                    url: "{{ route('delete.cart') }}",
                                    method: "DELETE",
                                    data: {_token: "{{ csrf_token() }}", id: id, productId: productId},

                                    success: function (result) {
                                        console.log('delete from cart');
                                        // console.log(result);
                                        getCartCount();
                                    },
                                    error: function (result) {
                                        console.log(result);
                                    }
                                });
                            }

                    },
                    error: function (result) {
                        console.log(result);
                    }
                });
            }, 100);
            } else {

                console.log('down');
                console.log(item, 'item');
                console.log(id, 'id');
                console.log(minValue, 'minValue');
                console.log(productId, 'productId');

                console.log(inputNumber, 'from inputNumber');


                    if (inputNumber < minValue) {
                        $('#show-cart-' + productId).removeClass('d-none');
                        $('.new-input-' + id).val(minValue);
                        $('#show-button-' + productId).addClass('d-none');
                        $('#show-button-' + productId).removeClass('block');

                        $('#item-price-show-'+productId).removeClass('d-none');
                        $('#cart-price-show-'+productId).addClass('d-none');
                    }

                clearTimeout(cartDecrement);
                clearTimeout(cartIncrement);

                cartDecrement = setTimeout(function () {
                    console.log(inputNumber, 'inputNumber');
                    console.log(minValue, 'minValue');

                    // if (inputNumber === undefined) {
                    //     return;
                    // }
                    if (inputNumber >= minValue) {

                        $.ajax({
                            url: "{{ route('update.cart') }}",
                            method: "put",
                            data: {_token: "{{ csrf_token() }}", id: id, quantity: inputNumber, productId: productId},

                            success: function (result) {
                                console.log('cart updated');
                            },
                            error: function (result) {
                                console.log(result);
                            }
                        });
                    } else {
                        console.log('delete function')
                        console.log(productId, 'productId')
                        $.ajax({
                            url: "{{ route('delete.cart') }}",
                            method: "DELETE",
                            data: {_token: "{{ csrf_token() }}", id: id, productId: productId},

                            success: function (result) {
                                console.log('delete from cart');
                                getCartCount();
                                // console.log(result);
                            },
                            error: function (result) {
                                console.log(result);
                            }
                        });
                    }

                }, 500);
            }
        }


        function getCartCount() {
            $.ajax({
                url: 'cart-count',
                method: "get",
                data: {_token: "{{ csrf_token() }}"},
                success: function (respones) {
                    console.log(respones.length, 'cart response' );
                    $('#cartCount').html(respones.length);
                }
            });
        }
    </script>
@endsection
