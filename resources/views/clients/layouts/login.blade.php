
    <div class="main_menu">
        <nav>




            <ul>


                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif
                    <li>/</li>

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a href="">
                            {{ Auth::user()->name }}
                            <i class="fa fa-angle-down"></i>

                        </a>

                        <ul class="sub_menu">
                            <li> <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                      document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a></li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </ul>

                    </li>
                @endguest
            </ul>

        </nav>
    </div>

