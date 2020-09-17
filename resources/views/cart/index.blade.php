@extends('layouts.app')

@section('content')

    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Cart List</div>
                        <div class="card-body">
                            <table id="cart" class="table table-hover table-condensed">
                                <thead>
                                    <tr>
                                        <th style="width:50%">Product</th>
                                        <th style="width:10%">Price</th>
                                        <th style="width:8%">Quantity</th>
                                        <th style="width:22%" class="text-center">Subtotal</th>
                                        <th style="width:10%"></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php $total = 0 ?>
                                    @guest
                                        @if(session('cart'))
                                            @foreach(session('cart') as $id => $details)

                                                <?php $total += $details['amount'] * $details['quantity'] ?>

                                                <tr>
                                                    <td data-th="Product">{{ $details['product_name'] }}</td>
                                                    <td data-th="Price">${{ $details['amount'] }}</td>
                                                    <td data-th="Quantity">
                                                        <input type="number" value="{{ $details['quantity'] }}" min="{{ $details['minQuantity'] }}" class="form-control quantity" />
                                                    </td>
                                                    <td data-th="Subtotal" class="text-center">${{ $details['amount'] * $details['quantity'] }}</td>
                                                    <td class="actions" data-th="">
                                                        <button class="btn btn-info btn-sm update-cart" data-id="{{ $id }}"><i class="fa fa-refresh"></i></button>
                                                        <button class="btn btn-danger btn-sm remove-from-cart" data-id="{{ $id }}"><i class="fa fa-trash-o"></i></button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    @else
                                        @if($data)
                                            @foreach($data as $id => $details)

                                                <?php $total += $details['amount'] * $details['quantity'] ?>

                                                <tr>
                                                    <td class="nomargin">{{ $details->product->name }}</td>
                                                    <td data-th="Price">${{ $details->amount }}</td>
                                                    <td data-th="Quantity">
                                                        <input type="number" value="{{ $details->quantity }}"  min="{{ $details->product->min_order_qty }}" class="form-control quantity" />
                                                    </td>
                                                    <td data-th="Subtotal" class="text-center">${{ $details->amount * $details->quantity }}</td>
                                                    <td class="actions" data-th="">
                                                        <button class="btn btn-info btn-sm update-cart" data-id="{{ $details->id  }}"><i class="fa fa-refresh"></i></button>
                                                        <button class="btn btn-danger btn-sm remove-from-cart" data-id="{{ $details->id  }}"><i class="fa fa-trash-o"></i></button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endguest
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td><a href="{{ route('product-list')  }}" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a></td>
                                        <td colspan="2" class="hidden-xs"></td>
                                        <td class="hidden-xs text-center"><strong>Total ${{ $total }}</strong></td>
                                        <td><a href="{{ route('checkout.preview')  }}" class="btn btn-warning">checkout</a></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </div>

@endsection


@section('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script type="text/javascript">

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

    </script>

@endsection
