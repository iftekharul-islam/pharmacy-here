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
                <input type="hidden" name="pharmacy_id" value="{{ $data->pharmacy['id'] }}">
                <div class="card-body">
                    <div class="form-group row">
                        <label for="amount" class="col-sm-4 col-form-label">Amount</label>
                        <div class="col-sm-8" id="">
                            <input type="number" name="amount" class="form-control" id="amount" placeholder="Amount">
                            @if ($errors->has('amount'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('amount') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="payment_method" class="col-sm-4 col-form-label">Payment Method</label>
                        <div class="col-sm-8  " id="name">
                            <input type="text" name="payment_method" value="bank" class="form-control" id="payment_method" placeholder="Payment Method">
                            @if ($errors->has('payment_method'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('payment_method') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="bank_name" class="col-sm-4 col-form-label">Bank Name</label>
                        <div class="col-sm-8  " id="name">
                            <input type="text" name="bank_name" value="{{ $data->pharmacy->pharmacyBusiness['bank_name'] }}" class="form-control" id="bank_name" placeholder="Bank Name">
                            @if ($errors->has('bank_name'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('bank_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="bank_branch_name" class="col-sm-4 col-form-label">Branch Name</label>
                        <div class="col-sm-8  " id="name">
                            <input type="text" name="bank_branch_name" value="{{ $data->pharmacy->pharmacyBusiness['bank_brunch_name'] }}" class="form-control" id="bank_branch_name" placeholder="Branch Name">
                            @if ($errors->has('bank_branch_name'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('bank_branch_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="bank_account_name" class="col-sm-4 col-form-label">Bank Account Name</label>
                        <div class="col-sm-8  " id="name">
                            <input type="text" name="bank_account_name" value="{{ $data->pharmacy->pharmacyBusiness['bank_account_name'] }}" class="form-control" id="bank_account_name" placeholder="Bank Account Name">
                            @if ($errors->has('bank_account_name'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('bank_account_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="bank_account_number" class="col-sm-4 col-form-label">Bank Account Number</label>
                        <div class="col-sm-8  " id="name">
                            <input type="text" name="bank_account_number" value="{{ $data->pharmacy->pharmacyBusiness['bank_account_number'] }}" class="form-control" id="bank_account_number" placeholder="Bank Account Number">
                            @if ($errors->has('bank_account_number'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('bank_account_number') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>


                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <a href="{{ route('notice.index') }}" class="btn btn-danger">Back</a>
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


