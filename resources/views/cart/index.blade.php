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
                                            <td data-th="Quantity"><input type="number" class="quantity" value="{{ $details['quantity'] }}" min="{{ $details['minQuantity'] }}"></td>
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

                                            <?php $total += $details['product']['purchase_price'] * $details['quantity'] ?>
                                            <tr>
                                                <td scope="row">{{ $details['product']['name'] }}</td>
                                                <td>৳ {{ $details['product']['purchase_price'] }}</td>
                                                <td data-th="Quantity"><input type="number" class="quantity" value="{{ $details['quantity'] }}" min="{{ $details['product']['min_order_qty'] }}"></td>
                                                <td>৳ {{ $details['product']['purchase_price'] * $details->quantity }}</td>
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
                                        <td><h5>Total ৳ {{ $total }}</h5></td>
                                        @guest
                                                <td><p class="badge btn-primary">Please login first to checkout</p></td>
                                            @else
                                                <td>
                                                    <a id="submit" href="#" onclick="checkMedicine({{ $data }})" class="btn--primary d-block cart-btn text-white">Checkout</a>
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


            var newData = '';
        function checkMedicine(data){
            let medicineData = data;
            newData = data;

            var preOrderMedicine = isPreOrderMedicine(medicineData);
            if (preOrderMedicine) {
                preOrderMedicineAlert();
                return;
            }

            // var prescribedMedicine = isPrescribedMedicine(medicineData);
            // if (prescribedMedicine) {
            //     isPrescribedMedicineAlert(medicineData);
            //     return;
            // }
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
                // buttons: true,
                // dangerMode: true,
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
                    // window.location = "/checkout/preview"
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
                if (result.isDismissed) {
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
                    // window.location.reload();
                    window.location = "/checkout/preview";
                }
            });
        }



    </script>

@endsection
