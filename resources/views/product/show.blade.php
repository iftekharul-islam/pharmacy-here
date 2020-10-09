@extends('layouts.app')
<style>
    .save-profile-btn {
        border: 1px solid #00ce5e;
    }

    .related-madicine-badge {
        width: 60px;
        height: 60px;
        background: #AD272E;
        position: absolute;
        top: 0;
        left: 0;
        -webkit-clip-path: polygon(0 0, 0% 100%, 100% 0);
        clip-path: polygon(0 0, 0% 100%, 100% 0);
        padding-left: 0px;
        padding-top: 6px;
        color: #fff;
        font-size: 14px;
        font-weight: 500;
        text-transform: capitalize;
        padding-right: 20px;
    }
</style>
@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
        <div class="container mt-5">
            <div class="row">
                <div class="col-7 mx-auto">
                    <h2>Medicine Details</h2>
                    <div class="product-summary mt-5">
                        <table class="table table-borderless">
                            <tr>
                                <th>Name</th>
                                <td>{{ $data->name }}</td>
                            </tr>
                            <tr>
                                <th>Category</th>
                                <td>{{ $data->category->name }}</td>
                            </tr>
                            <tr>
                                <th>Generic</th>
                                <td> {{ $data->generic->name }}</td>
                            </tr>
                            <tr>
                                <th>Form</th>
                                <td>{{ $data->form->name }}</td>
                            </tr>
                            <tr>
                                <th>Company</th>
                                <td>{{ $data->company->name }}</td>
                            </tr>
                            <tr>
                                <th>Conversation factor</th>
                                <td>{{ $data->conversion_factor}}</td>
                            </tr>
                            <tr>
                                <th>Unit</th>
                                <td>{{ $data->primaryUnit->name }}</td>
                            </tr>
                            <tr>
                                <th>Min Order Qty</th>
                                <td>{{$data->min_order_qty}}</td>
                            </tr>
                            <tr>
                                <th>Price</th>
                                <td>{{ $data->purchase_price }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-7 mx-auto">
                    <div class="profile-btn">
                        <a href="{{ route('product-list') }}" class="btn--edit">Back</a>
                        <a href="{{ route('cart.addToCart', $data->id) }}" class="btn--primary save-profile-btn"><i class="fa fa-shopping-cart"></i> Add to cart</a>
                    </div>
                </div>
                @if (count($relatedProducts) > 0)
                <div class="col-12 my-5">
                    <h3>Similar Products</h3>
                    <hr class="fancy4">
                </div>
                <div class="col-12">
                    <div class="row">
                    @foreach($relatedProducts as $product)
                    <div class="medicine-details col-2 ml-3">
                        <div class="text-center mb-4">
                            @if ($product->is_prescripted == 1)
                                <div class="related-madicine-badge">RX</div>
                            @endif
                            @if ($product->form->slug == 'tablet' || $product->form->name == 'capsul')
                                <img src="{{ asset('images/pill.png') }}" class="pill" alt="pill">
                            @elseif ($product->form->slug == 'syrup')
                                <img src="{{ asset('images/syrup.png') }}" class="pill" alt="syrup">
                            @elseif ($product->form->slug == 'injection')
                                <img src="{{ asset('images/injection.png') }}" class="pill" alt="injection">
                            @elseif ($product->form->slug == 'suppository')
                                <img src="{{ asset('images/suppositories.png') }}" class="pill" alt="suppositories">
                            @else
                                <img src="{{ asset('images/pill.png') }}" class="pill" alt="pill">
                            @endif
                        </div>
                        <div class="medicine-details--content">
                            @if ($product->is_pre_order == 1 )
                                <a href="#" class="mb-3">Pre-order</a>
                            @else
                                <span class=" mb-4"></span>
                            @endif
                            <h6 style="margin: 0px">{{ $product->name }}</h6>
                            <small>{{ $product->primaryUnit->name }}</small>
                            <br>
                            <small>{{ $product->generic->name }}</small>
                            <p><small>{{ $product->company->name }}</small></p>
                        </div>
                        <a href="{{ route('single-product', $product->id) }}" class="btn btn--primary w-100">view</a>
                    </div>
                    @endforeach
                    </div>

                </div>
                @endif
            </div>
        </div>
@endsection
