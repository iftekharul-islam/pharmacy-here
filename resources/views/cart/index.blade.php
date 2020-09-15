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
                                    @if($data)
                                        @foreach($data as $id => $details)

                                            <?php $total += $details->amount * $details->quantity ?>

                                            <tr>
                                                <td class="nomargin">{{ $details->product->name }}</td>
                                                <td data-th="Price">${{ $details->amount }}</td>
                                                <td data-th="Quantity">
                                                    <input type="number" value="{{ $details->quantity }}" class="form-control quantity" />
                                                </td>
                                                <td data-th="Subtotal" class="text-center">${{ $details->amount * $details->quantity }}</td>
                                                <td class="actions" data-th="">
                                                    <button class="btn btn-info btn-sm update-cart" data-id="{{ $details->id  }}"><i class="fa fa-refresh"></i></button>
                                                    <button class="btn btn-danger btn-sm remove-from-cart" data-id="{{ $details->id  }}"><i class="fa fa-trash-o"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td><a href="{{ route('product-list')  }}" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a></td>
                                        <td colspan="2" class="hidden-xs"></td>
                                        <td class="hidden-xs text-center"><strong>Total ${{ $total }}</strong></td>
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
{{--@section('content')--}}
{{--    <div class="container">--}}
{{--        <div class="row justify-content-center">--}}
{{--            <div class="col-md-8">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">Medicine LIst</div>--}}
{{--                    <div class="card-body">--}}
{{--                        @if (count($data) > 0)--}}
{{--                            <table id="example2" class="table table-bordered table-hover">--}}
{{--                                <thead>--}}
{{--                                <tr>--}}
{{--                                    <th>Serial no</th>--}}
{{--                                    <th>Name</th>--}}
{{--                                    <th>Amount</th>--}}
{{--                                    <th>Action</th>--}}
{{--                                </tr>--}}
{{--                                </thead>--}}
{{--                                <tbody>--}}
{{--                                @foreach($data as $index=>$item)--}}
{{--                                    <tr>--}}
{{--                                        <td>{{ ++$index }}</td>--}}
{{--                                        <td>{{ $item->name }}</td>--}}
{{--                                        <td>{{ $item->purchase_price }}</td>--}}

{{--                                        <td>--}}
{{--                                            <a class="btn btn-sm btn-primary mr-3"--}}
{{--                                               href="{{ route('single-product', $item->id) }}">--}}
{{--                                                <i class="fa fa-edit"></i>--}}
{{--                                            </a>--}}
{{--                                            <a class="btn btn-sm btn-success mr-3"--}}
{{--                                               onclick="addToCart({{ $item }})">--}}
{{--                                                <i class="fa fa-shopping-cart"></i>--}}
{{--                                            </a>--}}
{{--                                            <button class="btn btn-danger btn-sm" type="button"--}}
{{--                                                    onclick="deleteGame({{ $item->id }})">--}}
{{--                                                <i class="far fa-trash-alt"></i></button>--}}
{{--                                            <form id="delete-form-{{ $item->id }}"--}}
{{--                                                  action="{{ route('product.destroy', $item->id) }}"--}}
{{--                                                  method="post" style="display: none;">--}}
{{--                                                @csrf--}}
{{--                                                @method('DELETE')--}}
{{--                                            </form>--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                @endforeach--}}
{{--                                </tbody>--}}
{{--                            </table>--}}
{{--                        @else--}}
{{--                            <h4 class="text-center">No data found</h4>--}}
{{--                        @endif--}}
{{--                        <div class="col-md">--}}
{{--                            {{ $data->links() }}--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endsection--}}
