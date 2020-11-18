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
    .medicine-image {
        border: 1px solid #00ce5e;
    }
    .product-details-btn {
        margin-top: 45px;
    }
</style>
@section('content')
    @if(session('success'))
        <div id="successMessage" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-12 mb-5">
                    <h2>{{ __('text.medicine_details') }}</h2>
                </div>
                <div class="col-md-3">
                    <div class="medicine-image p-5 text-center">
                        @if ($data->form->slug == 'tablet' || $data->form->name == 'capsul')
                            <img src="{{ asset('images/pill-large.png') }}" class="pill" alt="pill">
                        @elseif ($data->form->slug == 'syrup')
                            <img src="{{ asset('images/syrup-large.png') }}" class="pill" alt="syrup">
                        @elseif ($data->form->slug == 'injection')
                            <img src="{{ asset('images/injection-large.png') }}" class="pill" alt="injection">
                        @elseif ($data->form->slug == 'suppository')
                            <img src="{{ asset('images/suppositories-large.png') }}" class="pill" alt="suppositories">
                        @else
                            <img src="{{ asset('images/pill-large.png') }}" class="pill" alt="pill">
                        @endif
                    </div>
                </div>
                <div class="col-md-7">
                        <div class="pl-2">
                            <h3>{{ $data->name }}</h3>
                            <h3 class="text-success">৳ {{ $data->purchase_price }} / {{ __('text.piece') }}</h3>
                        </div>
                        <div>
                            <table class="table table-borderless">
                                <tr>
                                    <th>{{ __('text.generic') }}</th>
                                    <td> {{ $data->generic->name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trans_choice('text.company', 2) }}</th>
                                    <td>{{ $data->company->name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('text.form') }}</th>
                                    <td>{{ $data->form->name }}</td>
                                </tr>
                                @if(!empty($data->strength))
                                    <tr>
                                        <th>{{ __('text.strength') }}</th>
                                        <td>{{ $data->strength }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    <div class="product-details-btn ml-2">
                            <a href="{{ route('product-list') }}" class="btn--edit mr-2">{{ __('text.back') }}</a>
                            @guest
                                <a href="{{ route('customer.login', $data->id) }}" class="btn--primary"><i class="fa fa-shopping-cart"></i> {{ __('text.add_to_cart') }}</a>
                            @else
                                <a href="{{ route('cart.addToCart', $data->id) }}" class="btn--primary"><i class="fa fa-shopping-cart"></i> {{ __('text.add_to_cart') }}</a>
                            @endguest
                        </div>
                </div>
            </div>
            <div class="row">
                @if (count($relatedProducts) > 0)
                    <div class="col-12 my-5">
                        <h3>{{ __('text.similar_product') }}</h3>
                        <hr class="fancy4">
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            @foreach($relatedProducts as $product)
                                <div class="col-sm-6 col-lg-3 mb-3">
                                <div class="medicine-details mb-1">
                                    <div class="text-center mb-4">
                                        @if ($product->is_prescripted == 1)
                                            <div class="related-madicine-badge">RX</div>
                                        @endif
                                        <div class="pt-5">
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
                                    </div>
                                    <div class="medicine-details--content">
                                        @if ($product->is_pre_order == 1 )
                                            <a href="#" class="mb-3">Pre-order</a>
                                        @else
                                            <span class=" mb-4"></span>
                                        @endif
                                        <h5 style="margin: 0px">{{ $product->name }}</h5>
                                        <small>{{ $product->strength }}</small><small class="float-right text-success">৳ {{ $product->purchase_price }} / {{ $product->primaryUnit->name }}</small>
                                        <br>
                                        <small>{{ $product->generic->name }}</small>
                                        <p><small>{{ $product->company->name }}</small></p>
                                    </div>
                                    @auth
                                        <a href="{{ route('single-product', ['medicine_id' => $product->id, 'medicine_slug' => $product->slug ]) }}" class="btn btn--primary w-100">{{ __('text.view') }}</a>
                                    @else
                                        <a href="{{ route('customer.login') }}" class="btn btn--primary w-100">{{ __('text.view') }}</a>
                                    @endauth
                                </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    {{ $relatedProducts->links() }}
                @endif
            </div>
        </div>
@endsection
