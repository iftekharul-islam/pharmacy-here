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
                        <div class="text-center mb-5"><img src="{{ asset('images/logo.png') }}" alt="logo"></div>
                        @if(session('failed'))
                            <div class="alert alert-danger text-center">
                                {{ session('failed') }}
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="phone_number">{{ __('Phone Number') }}</label>
                            <input id="phone_number" type="text" class="form-control" value="{{ session()->get('phone_number') }}" autocomplete="phone_number" disabled>
                        </div>
                        <div class="form-group">
                            <label for="otp">{{ __('Verify OTP') }}</label>
                            <input id="otp" type="text" class="form-control @error('otp') is-invalid @enderror" name="otp" value="{{ old('otp') }}" onkeypress="return isNumber(event)" autocomplete="phone_number" autofocus>
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
@section('js')
    <script>
        function isNumber(evt)
        {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode == 13 || (charCode >= 48 && charCode <= 57))
            {
                return true;
            }
            return false;
        }
    </script>
@endsection

