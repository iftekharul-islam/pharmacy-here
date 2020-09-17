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
                            <li>
                                <a class="btn--primary join">
                                    {{ \Illuminate\Support\Facades\Auth::user()->name }}
                                </a>
                            </li>
                            <li>
                                <a class="btn--primary join"  onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4">
            @yield('content')
        </main>
    </div>
@yield('js')
    <!-- font awesome -->
    <script src="{{ asset('js/icon.js') }}"></script>
</body>
</html>
