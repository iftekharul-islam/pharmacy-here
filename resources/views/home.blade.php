@extends('layouts.app')
@section('content')
    <!-- Medicine section -->
    <section class="medicine-search-section">
        <div class="container">
            <div class="row">
                <div class="col-md-8 mx-auto text-center">
                    <h2>We Deliver Your Medication</h2>
                    <p>Say goodbye to all your healthcare worries with us</p>
                    <label class="w-100 label-search">
                        <input type="search" class="form-control" placeholder="Search your medicine here">
                        <button type="submit" class="search-button"><i class="fas fa-search"></i></button>
                    </label>
                </div>
            </div>
        </div>
        <div class="medicine-image">
            <div class="left">
                <img src="{{ asset('images/medicine-2.svg') }}" alt="medicine" class="img-fluid">
                <img src="{{ asset('images/medicine-1.svg') }}" alt="medicine" class="img-fluid">
                <img src="{{ asset('images/medicine-2.svg') }}" alt="medicine" class="img-fluid">
            </div>
            <div class="right">
                <img src="{{ asset('images/flower.svg') }}" alt="flower" class="img-fluid">
            </div>
        </div>
    </section>
    <!-- card -->
    <section class="card-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-4 delivery-card">
                    <div class="card-item">
                        <div class="left">
                            <h4>Home Delivery</h4>
                            <p>With extra care we deliver
                                your products.</p>
                            <a href="#" class="btn--shop-now">Shop Now</a>
                        </div>
                        <div class="right">
                            <img src="{{ asset('images/card-image-1.svg') }}" alt="card 1">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 delivery-card">
                    <div class="card-item">
                        <div class="left">
                            <h4>Home Delivery</h4>
                            <p>With extra care we deliver
                                your products.</p>
                            <a href="#" class="btn--shop-now">Shop Now</a>
                        </div>
                        <div class="right">
                            <img src="{{ asset('images/card-image-2.svg') }}" alt="card 1">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 delivery-card">
                    <div class="card-item">
                        <div class="left">
                            <h4>Home Delivery</h4>
                            <p>With extra care we deliver
                                your products.</p>
                            <a href="#" class="btn--shop-now">Shop Now</a>
                        </div>
                        <div class="right">
                            <img src="{{ asset('images/card-image-3.svg') }}" alt="card 1">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- download sec tion -->
    <section class="download-section">
        <div class="container">
            <div class="row">
                <div class="col-md-11 mx-auto">
                    <div class="download">
                        <div class="left">
                            <h2>Download the app now!</h2>
                            <p>Download now and get all our services through the app.</p>
                        </div>
                        <div class="right">
                            <a href="#"><img src="{{ asset('images/google-play.svg') }}" alt="play store"></a>
                            <a href="#"><img src="{{ asset('images/apple.svg') }}" alt="apple store"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-10 mx-auto">
                    <div class="footer-menu">
                        <div class="footer-menu-list">
                            <a href="#"><img src="{{ asset('images/logo.svg') }}" alt="subidha logo" class="img-fluid"></a>
                            <p>Lorem ipsum dolor sit amet, consectetur
                                adipiscing elit ut aliquam, purus
                                sit amet luctus venenatis</p>
                        </div>

                        <div class="footer-menu-list">
                            <a href="#">COMPANY</a>
                            <ul>
                                <li><a href="#">Home</a></li>
                                <li><a href="#">Services</a></li>
                                <li><a href="#">About Us</a></li>
                                <li><a href="#">FAQs</a></li>
                            </ul>
                        </div>

                        <div class="footer-menu-list">
                            <a href="#">CONTACT US</a>
                            <address>
                                House 5/4/B (2nd Floor), Block A,<br> Lalmatia, Dhaka-1207<br>
                                <a href="#">info@subidha.com</a>
                                <p>+880 1234 567890</p>
                            </address>
                            <div class="social-icon">
                                <a href="#"><i class="fab fa-facebook-square"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                                <a href="#"><i class="fab fa-youtube"></i></a>
                                <a href="#"><i class="fab fa-linkedin"></i></a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </footer>
@endsection
