<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" href="{{ asset('images/tabalong-square.png') }}">
    {{-- <script src="https://www.google.com/recaptcha/api.js" async defer></script> --}}
    {{--@laravelPWA--}}
</head>

<body class="layout-1">
    <div id="app">
        <transition name="fade" mode="out-in">
            <router-view></router-view>
        </transition>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('/js/akthermal.lib.js') }}"></script>
     {{--<script src="{{ asset('/js/main.js') }}"></script>--}}
    <script src="{{ (env('APP_ENV') === 'local') ? mix('js/main.js') : asset('js/main.js') }}"></script>
</body>

</html>
