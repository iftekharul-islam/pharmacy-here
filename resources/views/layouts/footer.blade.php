<!-- footer -->
<footer class="footer mt-5 pb-5">
    <div class="container">
        <div class="row">
            <div class="col-10 mx-auto">
                <div class="footer-menu">
                    <div class="footer-menu-list">
                        <a href="#" class="subidha--logo">
                            <img src="{{ asset('images/logo.png') }}" alt="subidha logo" class="img-fluid"><span
                                class="">{{ __('text.subidha') }}</span>
                        </a>
                        <p>{{ __('text.footer_h1') }}</p>
                        <p>{{ __('text.footer_h2') }}</p>
                        <p>{{ __('text.footer_h3') }}</p>
                    </div>

                    <div class="footer-menu-list">
                        <a href="#">{{ trans_choice('text.company', 1) }}</a>
                        <ul>
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
                            Village : Chak kanchan, <br>P.O. : Farakkabad, P.S. : Biral,<br>District : Dinajpur-5210
                            <p>Trade License No : 077</p>
                            <p>Email: subidhabd@gmail.com</p>
                        </address>
                    </div>
                    <div class="footer-menu-list">
                        <a href="#">{{ __('text.social') }}</a>
                        <ul>
                            <li><a href="https://play.google.com/store/apps/details?id=com.subidhabd.customerapp"
                                   target="tab"><i
                                        class="fab fa-google-play mr-2"></i>{{ __('text.play_store_link') }}</a></li>
                            <li><a href="https://www.facebook.com/subidhabd" target="tab"><i
                                        class="fab fa-facebook-square mr-2"></i>{{ __('text.facebook') }}</a></li>
                            <li><a href="https://twitter.com" target="tab"><i
                                        class="fab fa-twitter mr-2"></i>{{ __('text.twitter') }}</a></li>
                            <li><a href="https://www.instagram.com/?hl=en" target="tab"><i
                                        class="fab fa-instagram mr-2"></i>{{ __('text.instagram') }}</a></li>
                            <li><a href="https://www.youtube.com" target="tab"><i
                                        class="fab fa-youtube mr-2"></i>{{ __('text.youtube') }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
