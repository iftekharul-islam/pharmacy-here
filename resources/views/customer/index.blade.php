@extends('layouts.app')

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="order-section">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="nav flex-column nav-pills my-dashboard" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link " id="v-pills-account-tab" data-toggle="pill" href="#v-pills-account" role="tab" aria-controls="v-pills-account" aria-selected="true">My Account</a>
                        <a class="nav-link active" id="v-pills-orders-tab" data-toggle="pill" href="#v-pills-orders" role="tab" aria-controls="v-pills-orders" aria-selected="false">My Orders</a>
                        <a class="nav-link" id="v-pills-wishlists-tab" data-toggle="pill" href="#v-pills-wishlists" role="tab" aria-controls="v-pills-wishlists" aria-selected="false">My Wishlists</a>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="tab-content my-dashboard-content" id="v-pills-tabContent">
                        <div class="tab-pane fade my-account" id="v-pills-account" role="tabpanel" aria-labelledby="v-pills-account-tab">...</div>

                        <div class="tab-pane fade show active my-orders" id="v-pills-orders" role="tabpanel" aria-labelledby="v-pills-orders-tab">
                            <h2 class="my-dashboard-title">My Orders</h2>
                            <div class="my-order-list">
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Order #</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Ship To</th>
                                            <th scope="col">Order total</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td scope="row">#1003 </td>
                                            <td>16/09/20 </td>
                                            <td>Rakibul H. Rocky</td>
                                            <td>৳ 2400</td>
                                            <td>Canceled</td>
                                            <td><a href="#">View Order</a></td>
                                        </tr>
                                        <tr>
                                            <td scope="row">#1003 </td>
                                            <td>16/09/20 </td>
                                            <td>Rakibul H. Rocky</td>
                                            <td>৳ 2400</td>
                                            <td>Confirm</td>
                                            <td><a href="#">View Order</a></td>
                                        </tr>
                                        <tr>
                                            <td scope="row">#1003 </td>
                                            <td>16/09/20 </td>
                                            <td>Rakibul H. Rocky</td>
                                            <td>৳ 2400</td>
                                            <td>Complete</td>
                                            <td><a href="#">View Order</a></td>
                                        </tr>
                                        <tr>
                                            <td scope="row">#1003 </td>
                                            <td>16/09/20 </td>
                                            <td>Rakibul H. Rocky</td>
                                            <td>৳ 2400</td>
                                            <td>Canceled</td>
                                            <td><a href="#">View Order</a></td>
                                        </tr>
                                        <tr>
                                            <td scope="row">#1003 </td>
                                            <td>16/09/20 </td>
                                            <td>Rakibul H. Rocky</td>
                                            <td>৳ 2400</td>
                                            <td>Canceled</td>
                                            <td><a href="#">View Order</a></td>
                                        </tr>
                                        <tr>
                                            <td scope="row">#1003 </td>
                                            <td>16/09/20 </td>
                                            <td>Rakibul H. Rocky</td>
                                            <td>৳ 2400</td>
                                            <td>Canceled</td>
                                            <td><a href="#">View Order</a></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade my-wishlists" id="v-pills-wishlists" role="tabpanel" aria-labelledby="v-pills-wishlists-tab">...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
@endsection
