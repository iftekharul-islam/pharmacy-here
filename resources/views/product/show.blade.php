@extends('layouts.app')
<style>
    .save-profile-btn {
        border: 1px solid #00ce5e;
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
                        <a href="{{ url()->previous() }}" class="btn--edit">Back</a>
                        <a href="{{ route('cart.addToCart', $data->id) }}" class="btn--primary save-profile-btn"><i class="fa fa-shopping-cart"></i> Add to cart</a>
                    </div>
                </div>
            </div>
        </div>
@endsection
