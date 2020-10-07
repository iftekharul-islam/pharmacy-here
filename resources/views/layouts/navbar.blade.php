<nav class="navbar navbar-expand-lg subidha-menu">
    <div class="container">
        <!-- logo -->
        <a class="navbar-brand subidha--logo" href="{{ route('home') }}">
            <img src="{{ asset('images/logo.png') }}" class="img-fluid" alt="Subidha logo"><span class="">Subidha</span>
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
{{--                <li>--}}
{{--                    <a href="#">Offer</a>--}}
{{--                    <a>Upcomming</a>--}}
{{--                </li>--}}
                <li>
                    <a href="{{ route('faq') }}">Need Help?</a>
{{--                    <a>Upcomming</a>--}}
                </li>
                <li class="language">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle language-dropdown" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{ asset('images/usa.svg') }}" alt=""> EN
                        </button>
                        <div class="dropdown-menu dropdown-menu-custom my-language" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#"><img src="{{ asset('images/bd.png') }}" alt="bangladesh-flag">BD</a>
                        </div>
                    </div>
                </li>
                <li>
                    <a class="nav-link" href="{{ route('cart.index') }}"><i class="fas fa-cart-plus"></i><span class="badge badge-pill badge-danger">{{ session('cartCount')!= null ? session('cartCount') : '' }}</span></a>
                </li>
                @guest
                    <li>
                        <a class="btn--primary join" href="{{ route('customer.login') }}">{{ __('Login') }}</a>
                    </li>
                @else
                    <li><a href="#" class="btn--primary join dropdown-toggle" id="dropdownprofile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ \Illuminate\Support\Facades\Auth::user()->name }}</a>
                        <div class="dropdown-menu dropdown-menu-profile" aria-labelledby="dropdownprofile">
                            <a class="dropdown-item" href="{{ route('customer.details') }}"></i> Dashboard</a>
                            <a class="dropdown-item" href="#" onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();"></i> {{ __('Logout') }}</a>
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
