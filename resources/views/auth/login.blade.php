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
                    <form method="POST" action="{{ route('customer.createOTP') }}">
                        @csrf
                        <div class="text-center mb-5"><img src="{{ asset('images/logo.svg') }}" alt="logo"></div>
                        <div class="form-group">
                            <label for="phone_number">{{ __('Phone Number') }}</label>
                            <input id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}" autocomplete="phone_number" autofocus>
                            @error('phone_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button onclick="savePhoneNumber()" type="submit" class="btn--sign-in">
                            {{ __('Create OTP') }}
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
        function savePhoneNumber() {
            var phone = document.getElementById('phone_number').value;

            localStorage.setItem('phone_number', phone);
        }
    </script>
@endsection
