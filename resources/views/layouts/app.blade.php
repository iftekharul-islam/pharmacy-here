<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
{{--    <script src="{{ asset('js/app.js') }}" ></script>--}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg subidha-menu">
            <div class="container">
                <!-- logo -->
                <a class="navbar-brand subidha--logo" href="{{ route('home') }}">
                    <img src="{{ asset('images/logo.svg') }}" class="img-fluid" alt="Subidha logo"><span class="">Subidha</span>
                </a>

                <!-- Toggle button for small device -->
                <div class="toggler-position">
                    <button class="navbar-toggler custom-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse custom-collapse" id="navbarSupportedContent">
                    <ul class="navbar-list ml-auto">
                        <li>
                            <a href="#">Offer</a>
                        </li>
                        <li>
                            <a href="#">Need Help?</a>
                        </li>
                        <li class="language">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle language-dropdown" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="{{ asset('images/usa.svg') }}" alt=""> English
                                </button>
                                <div class="dropdown-menu dropdown-menu-custom" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#"><img src="{{ asset('images/bd.png') }}" alt="bangladesh-flag">BD</a>

                                </div>
                            </div>
                        </li>
                        <li>
                            <a class="nav-link" href="{{ route('cart.index') }}">{{ __('Cart') }} <span class="badge badge-pill badge-danger">{{ session('cartCount')!= null ? session('cartCount') : '' }}</span></a>
                        </li>
                        @guest
                            <li>
                                <a class="btn--primary join" href="{{ route('customer.login') }}">{{ __('Login') }}</a>
                            </li>
                        @else
                            <li><a href="#" class="btn--primary join dropdown-toggle" id="dropdownprofile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ \Illuminate\Support\Facades\Auth::user()->name }}</a>
                                <div class="dropdown-menu dropdown-menu-profile" aria-labelledby="dropdownprofile">
                                    <a class="dropdown-item" href="{{ route('customer.details') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                                    <a class="dropdown-item" href="#" onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}</a>
                                    <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main>
            @yield('content')
        </main>
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
    </div>
    <!-- font awesome -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
    <script src="{{ asset('js/icon.js') }}"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <!-- font awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <!-- owl -->
{{--    <script src="js/owl.carousel.min.js"></script>--}}
    <!-- custom jquery -->
{{--    <script src="{{ asset('js/main.js') }}"></script>--}}
    @yield('js')
</body>
</html>
