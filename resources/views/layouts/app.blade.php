<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Evlando') }} - @yield('title')</title>

    <link rel="shortcut icon" href="/storage/images/default/59763.png">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('fontawesome/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jssor_internal.css') }}" rel="stylesheet">
    <link href="{{ asset('css/mystyle.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        @include('inc.navbar')
        <div class="container">
            @include('inc.messages')
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jssor.slider-27.5.0.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/jssor_internal.js') }}" type="text/javascript"></script>
    @yield('jssor')
    <script src="{{ asset('js/myscript.js') }}"></script>
    <!-- Infinite Scroll -->
    <script src="{{ asset('js/infinite-scroll.pkgd.min.js') }}"></script>
    @yield('infinite_scroll')
</body>
</html>
