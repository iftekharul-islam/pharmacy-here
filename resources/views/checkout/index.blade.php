@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Medicine LIst</div>
                    <div class="card-body">
                        <form method="post" action="{{ route('checkout.check')  }}">
                            @csrf
                            <div class="card-body">
                                <strong>Customer Name : </strong> <span></span><br>
                                <strong>Delivery Address : </strong> <span></span><br>
                                <strong>Customer Phone : </strong> <span></span><br>
                            </div>
                            <input type="radio" value="1" name="payType"> COD</input>
                            <input type="radio" value="2" name="payType"> E-pay</input>
                            <br>
                            <tr>
                                <td><button type="submit" class="btn btn-warning">checkout</button></td>
                            </tr>
                        </form>
                    </div>

                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
@endsection
@section ('js')
@endsection
