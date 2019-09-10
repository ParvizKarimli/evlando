<nav class="navbar navbar-inverse">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Evlando') }}
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                &nbsp;
            </ul>

            <ul class="nav navbar-nav">
                <li><a href="/about">{{ __('navbar.about_us') }}</a></li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ route('login') }}">{{ __('navbar.log_in') }}</a></li>
                    <li><a href="{{ route('register') }}">{{ __('navbar.register') }}</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="/dashboard">{{ __('navbar.dashboard') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();"
                                >
                                    {{ __('navbar.log_out') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif
                <!-- Language Setting Links -->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        {{ App::getLocale() }} <span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a href=""
                               onclick="event.preventDefault();
                               document.getElementById('lang-set-form-en').submit();"
                            >
                                en
                            </a>
                            {!! Form::open(['action' => ['LanguagesController@set'], 'method' => 'POST', 'id' => 'lang-set-form-en']) !!}
                                {!! Form::hidden('lang', 'en') !!}
                            {!! Form::close() !!}
                        </li>
                        <li>
                            <a href=""
                               onclick="event.preventDefault();
                               document.getElementById('lang-set-form-az').submit();"
                            >
                                az
                            </a>
                            {!! Form::open(['action' => ['LanguagesController@set'], 'method' => 'POST', 'id' => 'lang-set-form-az']) !!}
                                {!! Form::hidden('lang', 'az') !!}
                            {!! Form::close() !!}
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
