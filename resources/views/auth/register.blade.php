{{--@extends('adminlte::auth.login')--}}
{{--@extends('auth::layouts.master')--}}
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
                    <form method="POST" action="{{ route('customer.nameUpdate') }}">
                        @csrf
                        <div class="text-center mb-5"><img src="{{ asset('images/logo.svg') }}" alt="logo"></div>
                        <div class="form-group">
                            <label for="name">{{ __('Customer Name') }}</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="phone_number" autofocus>
                            @error('name')
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
        function savePhoneNumber() {
            var phone = document.getElementById('phone_number').value;
            // console.log(phone);

            localStorage.setItem('phone_number', phone);
        }
    </script>
@stop
