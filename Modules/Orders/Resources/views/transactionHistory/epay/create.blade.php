{{--@extends('products::layouts.master')--}}
@extends('adminlte::page')
@section('title', 'Transaction Payment')

@section('content')
    <div class="col-md-6">
        <div class="card card-primary-outline">
            <div class="card-header">
                <h3 class="card-title">Transaction Payment</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('transactionHistory.store') }}" method="POST">
                @csrf
                <input type="hidden" name="pharmacy_id" value="{{ $data->pharmacy_id }}">
                <div class="card-body">
                    <div class="form-group row">
                        @if (isset($data->pharmacy->pharmacyOrder[0]->pharmacy_amount))
                            @if ($data->pharmacy->pharmacyOrder[0]->pharmacy_amount > $data->amount)
                                <label for="due-amount" class="col-sm-4 col-form-label">Due amount</label>
                                <div class="col-sm-8">
                                        <label class="col-form-label">{{ $data->pharmacy->pharmacyOrder[0]->pharmacy_amount - $data->amount }}</label>
                                </div>
                            @else
                                <label for="due-amount" class="col-sm-4 col-form-label">Paid more amount</label>
                                <div class="col-sm-8">
                                    <label class="col-form-label">{{ $data->amount - $data->pharmacy->pharmacyOrder[0]->pharmacy_amount }}</label>
                                </div>

                            @endif
                        @else
                            <label for="due-amount" class="col-sm-4 col-form-label">Due amount</label>
                            <div class="col-sm-8">
                                <label class="col-form-label">{{ $data->amount }}</label>
                            </div>
                        @endif
                    </div>
                <div class="form-group row">
                    <label for="amount" class="col-sm-4 col-form-label">Amount</label>
                    <div class="col-sm-8">
                        <input type="number" name="amount" value="" class="form-control" min="0" id="amount" placeholder="Amount">
                        @if ($errors->has('amount'))
                            <span class="text-danger">
                                <strong>{{ $errors->first('amount') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                    <div class="form-group row">
                        <label for="payment_method" class="col-sm-4 col-form-label">Payment Method</label>
                        <div class="col-sm-8">
                            <input type="text" name="payment_method" value="Bank" class="form-control" id="payment_method" placeholder="Payment Method">
                            @if ($errors->has('payment_method'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('payment_method') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="transaction_id" class="col-sm-4 col-form-label">Transaction ID</label>
                        <div class="col-sm-8">
                            <input type="text" name="transaction_id"  class="form-control" id="transaction_id" placeholder="Transaction ID">
                            @if ($errors->has('transaction_id'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('transaction_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <a href="{{ route('transactionHistory.index') }}" class="btn btn-danger">Back</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script !src="">
        function isNumber(evt)
        {
            // console.log (evt);
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode == 13 || charCode == 46 || (charCode >= 48 && charCode <= 57))
            {
                return true;
            }
            return false;
        }
    </script>
@endsection


