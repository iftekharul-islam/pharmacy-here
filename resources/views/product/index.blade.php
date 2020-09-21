@extends('layouts.app')

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
                                <div class="text-right mb-2">
                                    <i class="fas fa-heart"></i>
                                </div>
                                <div class="text-center mb-4">
                                    <img src="{{ asset('images/pill.png') }}" class="pill" alt="medicine">
                                </div>
                                <div class="medicine-details--content">
                                    <a href="#" class="mb-3">Tag</a>
                                    <p><strong>{{ $item->name }}</strong></p>
                                    <p><strong>{{ $item->company->name }}</strong></p>
                                </div>
                                <div class="package d-flex justify-content-between">
                                    <p>৳{{ $item->purchase_price }}</p>
                                    <p>Min quantity ({{ $item->min_order_qty }})</p>
                                </div>
                                <p><Strong>Packaging Type - <a class="badge-primary badge text-white">{{ $item->type }}</a></Strong></p>
                                <div class="medicine-details--footer d-flex justify-content-between align-items-center">
                                    <a href="{{ route('cart.addToCart', $item->id) }}" class="btn--add-to-cart"><i class="fas fa-cart-plus"></i> Add to Cart</a>
                                    <a href="{{ route('single-product', $item->id) }}" class="eyes"><i class="fas fa-eye"></i></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <h4>No data found!</h4>
            @endif
        </div>
    </section>
{{--    <div class="container">--}}
{{--        <div class="row justify-content-center">--}}
{{--            <div class="col-md-8">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">Medicine List</div>--}}
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
{{--                                                <i class="fa fa-eye"></i>--}}
{{--                                            </a>--}}
{{--                                            <a class="btn btn-sm btn-success mr-3"--}}
{{--                                               href="{{ route('cart.addToCart', $item->id) }}">--}}
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
@endsection
