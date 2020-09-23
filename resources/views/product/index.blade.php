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
@endsection
