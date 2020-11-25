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
                <input type="hidden" name="pharmacy_id" value="{{ $data->user_id }}">
                <div class="card-body">
                    <div class="form-group row">
                        @php
                            $subidha_amount = isset($data->pharmacyOrder[0]) ? $data->pharmacyOrder[0]->subidha_amount : 0;
                            $pharmacy_amount = isset($data->pharmacyOrder[0]) ? $data->pharmacyOrder[0]->pharmacy_amount : 0;
                            $amount = isset($data->pharmacyTransaction[0]) ? $data->pharmacyTransaction[0]->amount : 0;
                            $payable = $subidha_amount + $amount ;
                        @endphp
                        @if (isset($pharmacy_amount))
                            @if ($pharmacy_amount > $payable)
                                <label for="due-amount" class="col-sm-4 col-form-label">Due amount</label>
                                <div class="col-sm-8">
                                    <label
                                        class="col-form-label">{{ number_format($pharmacy_amount - $payable, 2) }}</label>
                                </div>
                            @else
                                <label for="due-amount" class="col-sm-4 col-form-label">Paid more amount</label>
                                <div class="col-sm-8">
                                    <label
                                        class="col-form-label">{{ number_format($payable - $pharmacy_amount, 2) }}</label>
                                </div>

                            @endif
                        @else
                            <label for="due-amount" class="col-sm-4 col-form-label">Due amount</label>
                            <div class="col-sm-8">
                                <label class="col-form-label">{{ $payable }}</label>
                            </div>
                        @endif
                    </div>
                <div class="form-group row">
                    <label for="amount" class="col-sm-4 col-form-label">Amount</label>
                    <div class="col-sm-8">
                        <input type="number" step="0.01" name="amount" value="" class="form-control" min="0" id="amount"
                               placeholder="Amount">
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
                    <a href="{{ URL::previous() }}" class="btn btn-danger">Back</a>
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


