<nav class="navbar navbar-expand-lg subidha-menu">
    <div class="container">
        <!-- logo -->
        <a class="navbar-brand subidha--logo" href="{{ route('home') }}">
            <img src="{{ asset('images/logo.png') }}" class="img-fluid" alt="Subidha logo"><span class="">{{ __('text.subidha') }}</span>
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
                    @if(app()->getLocale() == 'en')
                        <button class="btn btn-secondary language-dropdown py-0" type="button">
                        <a href=" {{ url('locale/bn') }}" ><img width="36px" src="{{ asset('images/bd.png') }}" alt="bangladesh-flag"> BD</a>
                        </button>
                    @else
                        <button class="btn btn-secondary language-dropdown" type="button">
                                <a href=" {{ url('locale/en') }}"><img src="{{ asset('images/usa.svg') }}" alt="usa-flag"> EN </a>
                        </button>
                    @endif
                </li>
                <li>
{{--                    <a class="nav-link" href="{{ route('cart.index') }}"><i class="fas fa-cart-plus"></i><span class="badge badge-pill badge-danger">{{ session('cartCount')!= null ? session('cartCount') : '' }}</span></a>--}}
                    <a  class="nav-link" href="{{ route('cart.index') }}"><i class="fas fa-cart-plus"></i><span id="cartCount" class="badge badge-pill badge-danger">{{ session('cartCount')!= null ? session('cartCount') : '' }}</span></a>
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
