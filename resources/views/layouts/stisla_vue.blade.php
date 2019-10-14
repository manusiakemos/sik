<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    {{--<link rel="stylesheet" href="{{ asset('css/style_dark.css') }}">--}}
    <link rel="icon" href="{{ asset('images/tabalong-square.png') }}">
    <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">

    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
    <script>
        var OneSignal = window.OneSignal || [];
        OneSignal.push(function() {
            OneSignal.init({
                appId: "31e318be-9285-4d18-b0c5-fc367f8dc8c4",
            });
        });
    </script>
    @laravelPWA
    <script src="{{ asset('register-service-worker.js') }}"></script>
</head>

<body class="layout-1">
<div id="app">
    <transition name="fade" mode="out-in">
        <router-view></router-view>
    </transition>
</div>

<!-- General JS Scripts -->
<script src="{{ (env('APP_ENV') === 'local') ? mix('js/main.js') : asset('js/main.js') }}"></script>
<script>
    window['isUpdateAvailable']
        .then(isAvailable => {
            if (isAvailable) {
                alert('new update available');
                location.reload(true);
                //  console.log('new update available');
            }
        });
</script>
</body>

</html>
