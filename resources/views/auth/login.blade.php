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
                    <form method="POST" id="form" action="{{ route('customer.createOTP') }}">
                        @csrf
                        <div class="text-center mb-5"><img src="{{ asset('images/logo.png') }}" alt="logo"></div>
                        <div class="form-group">
                            <label for="phone_number">{{ __('Phone Number') }}</label>
                            <input id="phone_number" type="number" class="form-control @error('phone_number') is-invalid @enderror mb-2" name="phone_number"  value="{{ old('phone_number') }}" onkeypress="return isNumber(event)" autocomplete="phone_number">
                            <label class="check_first d-none"></label>
                            <label class="check_digit d-none"></label>
                            <label class="check_max_digit d-none"></label>
                            @error('phone_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button id="submit" onclick="savePhoneNumber()" type="submit" class="btn--sign-in">
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

        $('#phone_number').keyup(function () {

            var value = $(this).val();
            var value2 = $(this).val().substr(0,2);

            if(value2 !== '01' ){
                $(".check_first").removeClass("d-none",).addClass('text-danger').html('Please Start number with 01');
                $('#submit').prop('disabled', true)
            } else {
                $(".check_first").removeClass('text-danger').addClass('d-none')
            }

            if ( value.length < 11 ) {
                $(".check_digit").removeClass("d-none").addClass('text-danger').html('Phone number minimum 11 digit');
            } else {
                $(".check_digit").removeClass('text-danger').addClass('d-none')
            }
            if ( value.length > 12 ) {
                $('#phone_number').on('keypress', function () {
                    return false;
                });
            } else {
                $('#phone_number').off('keypress')
            }

            if ( (value2 !== '01' ) || ( value.length < 11 ) ) {
                $('#submit').prop('disabled', true)
            } else {
                $('#submit').prop('disabled', false)
            }

        })

        function savePhoneNumber() {
            var phone = document.getElementById('phone_number').value;
            localStorage.setItem('phone_number', phone);
        }
    </script>
@endsection
