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
                        <p>Lorem ipsum dolor sit amet, consectetur
                            adipiscing elit ut aliquam, purus
                            sit amet luctus venenatis</p>
                    </div>

                    <div class="footer-menu-list">
                        <a href="#">{{ __('text.company') }}</a>
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
                        <a href="#">CONTACT US</a>
                        <address>
                            House 5/4/B (2nd Floor), Block A,<br> Lalmatia, Dhaka-1207<br>
                            <br><p>info@subidha.com</p>
                            <p>+880 1234 567890</p>
                        </address>
                    </div>
                    <div class="footer-menu-list">
                        <a href="#">SOCIAL</a>
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
