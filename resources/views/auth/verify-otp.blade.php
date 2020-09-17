@extends('layouts.app')

@section('content')
    <section class="login-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3 d-none d-md-block">
                    <div class="login-image">
                        <img src="{{ asset('images/login-2.svg') }}" alt="img-fluid">
                    </div>
                </div>
                <div class="col-md-6">
                    <form method="POST" action="{{ route('customer.verifyOTP') }}">
                        @csrf
                        <div class="text-center mb-5"><img src="{{ asset('images/logo.svg') }}" alt="logo"></div>
                        <div class="form-group">
                            <label for="otp">{{ __('Verify OTP') }}</label>
                            <input id="otp" type="number" class="form-control @error('otp') is-invalid @enderror" name="otp" value="{{ old('otp') }}" autocomplete="phone_number" autofocus>
                            @error('otp')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn--sign-in">
                            {{ __('Verify OTP') }}
                        </button>
                    </form>
                </div>
                <div class="col-md-3">
                    <div class="login-image">
                        <img src="{{ asset('images/login-1.svg') }}" alt="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

