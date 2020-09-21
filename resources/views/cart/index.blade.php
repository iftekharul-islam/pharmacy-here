@extends('layouts.app')

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <!-- cart section -->
    <div class="cart-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 text-center">
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
                                    <th scope="col">Sub total</th>
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
                                            <td>৳ {{ $details['amount'] }}</td>
                                            <td data-th="Quantity"><input type="number" class="quantity" value="{{ $details['quantity'] }}"></td>
                                            <td data-th="Subtotal" class="text-center">৳ {{ $details['amount'] * $details['quantity'] }}</td>
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

                                            <?php $total += $details['amount'] * $details['quantity'] ?>
                                            <tr>
                                                <td scope="row">{{ $details['product']['name'] }}</td>
                                                <td>৳ {{ $details['amount'] }}</td>
                                                <td data-th="Quantity"><input type="number" class="quantity" value="{{ $details['quantity'] }}"></td>
                                                <td data-th="Subtotal" class="text-center">৳ {{ $details->amount * $details->quantity }}</td>
                                                <td>
                                                    <div class="actions" data-th="">
                                                        <button class="btn btn-info btn-sm update-cart" data-id="{{ $details->id  }}"><i class="fa fa-refresh"></i></button>
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
                                        <td></td>
                                        <td>Total ৳{{ $total }}</td>
                                        <td>
                                            <a id="submit" onclick="checkMedicine({{ $data }})" {{--href="{{ route('checkout.preview')  }}"--}} class="btn--primary d-block cart-btn">Checkout</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{--    <div class="container">--}}
{{--        <div class="row justify-content-center">--}}
{{--            <div class="col-md-10">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">Cart List</div>--}}
{{--                        <div class="card-body">--}}
{{--                            <table id="cart" class="table table-hover table-condensed">--}}
{{--                                <thead>--}}
{{--                                    <tr>--}}
{{--                                        <th style="width:50%">Product</th>--}}
{{--                                        <th style="width:10%">Price</th>--}}
{{--                                        <th style="width:8%">Quantity</th>--}}
{{--                                        <th style="width:22%" class="text-center">Subtotal</th>--}}
{{--                                        <th style="width:10%"></th>--}}
{{--                                    </tr>--}}
{{--                                </thead>--}}
{{--                                <tbody>--}}

{{--                                    <?php $total = 0 ?>--}}
{{--                                    @guest--}}
{{--                                        @if(session('cart'))--}}
{{--                                            @foreach(session('cart') as $id => $details)--}}

{{--                                                <?php $total += $details['amount'] * $details['quantity'] ?>--}}

{{--                                                <tr>--}}
{{--                                                    <td data-th="Product">{{ $details['product_name'] }}</td>--}}
{{--                                                    <td data-th="Price">${{ $details['amount'] }}</td>--}}
{{--                                                    <td data-th="Quantity">--}}
{{--                                                        <input type="number" value="{{ $details['quantity'] }}" min="{{ $details['minQuantity'] }}" class="form-control quantity" />--}}
{{--                                                    </td>--}}
{{--                                                    <td data-th="Subtotal" class="text-center">${{ $details['amount'] * $details['quantity'] }}</td>--}}
{{--                                                    <td class="actions" data-th="">--}}
{{--                                                        <button class="btn btn-info btn-sm update-cart" data-id="{{ $id }}"><i class="fa fa-refresh"></i></button>--}}
{{--                                                        <button class="btn btn-danger btn-sm remove-from-cart" data-id="{{ $id }}"><i class="fa fa-trash-o"></i></button>--}}
{{--                                                    </td>--}}
{{--                                                </tr>--}}
{{--                                            @endforeach--}}
{{--                                        @endif--}}
{{--                                    @else--}}
{{--                                        @if($data)--}}
{{--                                            @foreach($data as $id => $details)--}}

{{--                                                <?php $total += $details['amount'] * $details['quantity'] ?>--}}

{{--                                                <tr>--}}
{{--                                                    <td class="nomargin">{{ $details->product->name }}</td>--}}
{{--                                                    <td data-th="Price">${{ $details->amount }}</td>--}}
{{--                                                    <td data-th="Quantity">--}}
{{--                                                        <input type="number" value="{{ $details->quantity }}"  min="{{ $details->product->min_order_qty }}" class="form-control quantity" />--}}
{{--                                                    </td>--}}
{{--                                                    <td data-th="Subtotal" class="text-center">${{ $details->amount * $details->quantity }}</td>--}}
{{--                                                    <td class="actions" data-th="">--}}
{{--                                                        <button class="btn btn-info btn-sm update-cart" data-id="{{ $details->id  }}"><i class="fa fa-refresh"></i></button>--}}
{{--                                                        <button class="btn btn-danger btn-sm remove-from-cart" data-id="{{ $details->id  }}"><i class="fa fa-trash-o"></i></button>--}}
{{--                                                    </td>--}}
{{--                                                </tr>--}}
{{--                                            @endforeach--}}
{{--                                        @endif--}}
{{--                                    @endguest--}}
{{--                                </tbody>--}}
{{--                                <tfoot>--}}
{{--                                    <tr>--}}
{{--                                        <td><a href="{{ route('product-list')  }}" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a></td>--}}
{{--                                        <td colspan="2" class="hidden-xs"></td>--}}
{{--                                        <td class="hidden-xs text-center"><strong>Total ${{ $total }}</strong></td>--}}
{{--                                        <td><a href="{{ route('checkout.preview')  }}" class="btn btn-warning">checkout</a></td>--}}
{{--                                    </tr>--}}
{{--                                </tfoot>--}}
{{--                            </table>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--    </div>--}}

@endsection


@section('js')
    <script>

        $(".update-cart").click(function (e) {
            e.preventDefault();

            var ele = $(this);

            $.ajax({
                url: '{{ url('cart/update-cart') }}',
                method: "patch",
                data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id"), quantity: ele.parents("tr").find(".quantity").val()},
                success: function (response) {
                    window.location.reload();
                }
            });
        });

        $(".remove-from-cart").click(function (e) {
            e.preventDefault();

            var ele = $(this);

            if(confirm("Are you sure")) {
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

        function checkMedicine(data){
            let medicineData = data;

            var preOrderMedicine = isPreOrderMedicine(medicineData);
            // console.log('Pre order Medicine: ', preOrderMedicine);
            if (preOrderMedicine) {
                preOrderMedicineAlert()
            }
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
            swal({
                title: "You have a Pre-order Medicine",
                text: "You have a pre-order medicine in cart. It will take 3-5 days to deliver, do you want to continue?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                // showCancelButton: true,
                // confirmButtonColor: '#3085d6',
                // cancelButtonColor: '#d33',
                // cancelButtonText: 'No',
                // confirmButtonText: 'Yes',
            })
            .then((result) => {
                if (result) {
                    console.log(result);
                }
            });

        }



    </script>

@endsection
