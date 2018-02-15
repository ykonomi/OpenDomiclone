<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div>
                <a class="navbar-brand">
                    Domiclone
                </a>
                <!--
                    <a class="navbar-brand" href="/main" v-if="auth">
                    Join 
                    </a>
                    <a class="navbar-brand" href="/offline" v-if="auth">
                    Debug(Offline)
                    </a>
                    <a class="navbar-brand" href="/test" v-if="auth">
                    UIお試し
                    </a>
                -->
            </div>
        </div>
    </nav>
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
