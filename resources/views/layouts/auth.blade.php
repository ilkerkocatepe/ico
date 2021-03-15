<!DOCTYPE html>
<html class="loading" lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-textdirection="ltr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title') - {{ \App\Models\Setting::where('setting','title')->first()->value }}</title>
        <link rel="apple-touch-icon" href="{{ asset('storage/assets/front/images/logosq.png') }}">
        <link rel="shortcut icon" href="{{ asset('storage/assets/front/images/logosq.png') }}" type="image/x-icon">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/vendors.min.css')}}">

        <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/bootstrap.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/bootstrap-extended.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/colors.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/components.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/themes/dark-layout.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/themes/bordered-layout.css')}}">

        @yield('page-css')

        <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
        <script src="{{ mix('js/app.js') }}" defer></script>
        {!! RecaptchaV3::initJs() !!}
    </head>

    <body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static   menu-collapsed" data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper">
                <div class="content-header row">
                </div>
                <div class="content-body">
                    <div class="auth-wrapper auth-v1 px-2">
                        <div class="auth-inner py-2">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{asset('app-assets/vendors/js/vendors.min.js')}}"></script>

        <script src="{{asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js')}}"></script>

        <script src="{{asset('app-assets/js/core/app-menu.js')}}"></script>
        <script src="{{asset('app-assets/js/core/app.js')}}"></script>

        @yield('page-js')
        @include('layouts.user.sweetalerts')
        <script>
            $(window).on('load', function() {
                if (feather) {
                    feather.replace({
                        width: 14,
                        height: 14
                    });
                }
            })
        </script>
    </body>
</html>
