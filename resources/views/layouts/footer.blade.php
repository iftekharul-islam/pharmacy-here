<!-- footer -->
<footer class="footer mt-5 pb-5">
    <div class="container">
        <div class="row">
            <div class="col-10 mx-auto">
                <div class="footer-menu">
                    <div class="footer-menu-list">
                        <a href="#" class="subidha--logo">
                            <img src="{{ asset('images/logo.png') }}" alt="subidha logo" class="img-fluid"><span class="">{{ __('text.subidha') }}</span>
                        </a>
{{--                        <p>Lorem ipsum dolor sit amet, consectetur--}}
{{--                            adipiscing elit ut aliquam, purus--}}
{{--                            sit amet luctus venenatis</p>--}}
                        <p>Medicine purchase and get home delivery with lots of payment methods</p>
                        <p>Medicine alarm – never forget to take medicines timely</p>
                        <p>Prescription holder – keep prescriptions safely. No chance of prescription missing</p>
                    </div>

                    <div class="footer-menu-list">
                        <a href="#">{{ trans_choice('text.company', 1) }}</a>
                        <ul>
{{--                            <li><a href="{{ route('home') }}">Home</a></li>--}}
                            <li><a href="{{ route('terms') }}">{{ __('text.Terms_of_use') }}</a></li>
                            <li><a href="{{ route('about.page') }}">{{ __('text.about_us') }}</a></li>
                            <li><a href="{{ route('faq') }}">{{ __('text.faq') }}</a></li>
                            <li><a href="{{ route('return.page') }}">{{ __('text.refund_and_return') }}</a></li>
                            <li><a href="{{ route('privacy.page') }}">{{ __('text.privacy_policy') }}</a></li>
                        </ul>
                    </div>

                    <div class="footer-menu-list">
                        <a href="#">{{ __('text.contact_us') }}</a>
                        <address>
                            Village : Chak kanchan, <br>P.O. : Farakkabad, P.S. : Biral,<br>District : Dinajpur-5210 <br>
                            <br><p>Email: subidhabd@gmail.com</p>
                        </address>
                    </div>
                    <div class="footer-menu-list">
                        <a href="#">{{ __('text.social') }}</a>
                        <ul>
                            <li><a href="https://www.facebook.com" target="tab"><i class="fab fa-facebook-square mr-2"></i>{{ __('text.facebook') }}</a></li>
                            <li><a href="https://twitter.com" target="tab"><i class="fab fa-twitter mr-2"></i>{{ __('text.twitter') }}</a></li>
                            <li><a href="https://www.instagram.com/?hl=en" target="tab"><i class="fab fa-instagram mr-2"></i>{{ __('text.instagram') }}</a></li>
                            <li><a href="https://www.youtube.com" target="tab"><i class="fab fa-youtube mr-2"></i>{{ __('text.youtube') }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
