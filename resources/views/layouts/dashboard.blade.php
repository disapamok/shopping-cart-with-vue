<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    ABC {{ trans('general.company') }} - {{ auth()->user()->role->name }} Dashboard
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="languageSelector" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ trans('general.select_language') }} ({{ app()->getLocale() }})
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="languageSelector">
                                    <a class="dropdown-item" href="#" onclick="changeLang('si')">
                                        {{ __('Sinhala') }}
                                    </a>
                                    <a class="dropdown-item" href="#" onclick="changeLang('en')">
                                        {{ __('English') }}
                                    </a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container dashboard-content">
                <div class="row">
                    <div class="col-lg-3 sidebar">
                        <div class="greet">
                            <h4>Hi, {{ auth()->user()->name }}</h4>
                            <p>{{ trans('general.admin.greet') }}</p>
                        </div>
                        <div class="menu">
                            <ul>
                                @can('touch_product')
                                    <li>
                                        <a href=""
                                            class="active">{{ trans('general.admin.nav_prod_dashboard') }}</a>
                                    </li>
                                @endcan
                                @can('view_reports')
                                    <li>
                                        <a href="" class="active">{{ trans('general.admin.reports') }}</a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-9 admin-container">
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function changeLang(lang) {
            localStorage.setItem("lang", lang);
            location.href = '/lang-' + lang;
        }
    </script>
</body>

</html>
