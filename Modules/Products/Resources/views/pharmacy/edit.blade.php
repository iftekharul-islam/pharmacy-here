{{--@extends('products::layouts.master')--}}
@extends('adminlte::page')
@section('title', 'Edit Pharmacy')

@section('content')

    <div class="col-md-6">
        <div class="card card-primary-outline">
            <div class="card-header">
                <h3 class="card-title">Update Pharmacy</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('pharmacy.update', $pharmacy->id) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label for="pharmacy_name" class="col-sm-4 col-form-label">Pharmacy Name</label>
                        <div class="col-sm-8" id="pharmacy_name">
                            <input type="text" name="pharmacy_name" value="{{ $pharmacy->pharmacy_name ?? old('pharmacy_name') }}" class="form-control" id="pharmacy_name" placeholder="Pharmacy Name">
                            @if ($errors->has('pharmacy_name'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('pharmacy_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pharmacy_address" class="col-sm-4 col-form-label">Pharmacy Address</label>
                        <div class="col-sm-8" id="pharmacy_address">
                            <input type="text" name="pharmacy_address" value="{{ $pharmacy->pharmacy_address ?? old('pharmacy_address') }}" class="form-control" id="pharmacy_address" placeholder="Pharmacy Address">
                            @if ($errors->has('pharmacy_address'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('pharmacy_address') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bank_account_name" class="col-sm-4 col-form-label">Bank A/C Name</label>
                        <div class="col-sm-8" id="bank_account_name">
                            <input type="text" name="bank_account_name" value="{{ $pharmacy->bank_account_name ?? old('bank_account_name') }}" class="form-control" id="bank_account_name" placeholder="Bank A/C Name">
                            @if ($errors->has('bank_account_name'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('bank_account_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bank_account_number" class="col-sm-4 col-form-label">Bank A/C Number</label>
                        <div class="col-sm-8" id="bank_account_number">
                            <input type="text" name="bank_account_number" value="{{ $pharmacy->bank_account_number ?? old('bank_account_number') }}" class="form-control" id="bank_account_number" placeholder="Bank A/C Number">
                            @if ($errors->has('bank_account_number'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('bank_account_number') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bank_name" class="col-sm-4 col-form-label">Bank Name</label>
                        <div class="col-sm-8" id="bank_name">
                            <input type="text" name="bank_name" value="{{ $pharmacy->bank_name ?? old('bank_name') }}" class="form-control" id="bank_name" placeholder="Bank Name">
                            @if ($errors->has('bank_name'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('bank_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bank_brunch_name" class="col-sm-4 col-form-label">Branch Name</label>
                        <div class="col-sm-8" id="bank_brunch_name">
                            <input type="text" name="bank_brunch_name" value="{{ $pharmacy->bank_brunch_name ?? old('bank_brunch_name') }}" class="form-control" id="bank_brunch_name" placeholder="Bank Branch Name">
                            @if ($errors->has('bank_brunch_name'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('bank_brunch_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bkash_number" class="col-sm-4 col-form-label">Bkash Number</label>
                        <div class="col-sm-8" id="bkash_number">
                            <input type="text" name="bkash_number" value="{{ $pharmacy->bkash_number ?? old('bkash_number') }}" class="form-control" id="bkash_number" placeholder="Bkash Number">
                            @if ($errors->has('bkash_number'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('bkash_number') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="start_time" class="col-sm-4 col-form-label">Start Time</label>
                        <div class="col-sm-8" id="start_time">
                            <input type="time" name="start_time" value="{{ $pharmacy->start_time ?? old('start_time') }}" class="form-control" id="start_time" placeholder="Start Time">
                            @if ($errors->has('start_time'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('start_time') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="end_time" class="col-sm-4 col-form-label">End Time</label>
                        <div class="col-sm-8" id="end_time">
                            <input type="time" name="end_time" value="{{ $pharmacy->end_time ?? old('end_time') }}" class="form-control" id="end_time" placeholder="End Time">
                            @if ($errors->has('end_time'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('end_time') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="break_start_time" class="col-sm-4 col-form-label">Break Start Time</label>
                        <div class="col-sm-8" id="break_start_time">
                            <input type="time" name="break_start_time" value="{{ $pharmacy->break_start_time ?? old('break_start_time') }}" class="form-control" id="break_start_time" placeholder="Break Start Time">
                            @if ($errors->has('break_start_time'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('break_start_time') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="break_end_time" class="col-sm-4 col-form-label">Break End Time</label>
                        <div class="col-sm-8" id="break_end_time">
                            <input type="time" name="break_end_time" value="{{ $pharmacy->break_end_time ?? old('break_end_time') }}" class="form-control" id="break_end_time" placeholder="Break End Time">
                            @if ($errors->has('break_end_time'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('break_end_time') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <a href="{{ route('pharmacy.index') }}" class="btn btn-danger">Back</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection



