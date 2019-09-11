<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/frontend.css') }}">
    <link rel="icon" href="{{ asset('images/tabalong-square.png') }}">
    <script src='https://api.mapbox.com/mapbox-gl-js/v1.2.0/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v1.2.0/mapbox-gl.css' rel='stylesheet' />

{{--@stack("style")--}}
<body>
{{--@include('components.navbar')--}}

{{--@yield('content')--}}

<div id="app">
    <router-view></router-view>
</div>

<!-- General JS Scripts -->
<script>
    localStorage.setItem("app_name", "{{ config("app.name") }}");
</script>
<script src="{{ (env('APP_ENV') === 'local') ? mix('js/frontend.js') : asset('js/frontend.js') }}"></script>

{{--@stack("script")--}}
</body>

</html>
