<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0, minimal-ui">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CLSG') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i"
        rel="stylesheet">


<!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap-extended.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/colors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/components.min.css') }}">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/colors/palette-gradient.min.css') }}">

    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
{{--    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">--}}
<!-- END: Custom CSS-->

    @stack('css')
</head>
<body class="vertical-layout vertical-menu 1-column blank-page" data-open="click" data-menu="vertical-menu"
      data-col="1-column">
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper" id="app">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section class="row flexbox-container">
                <div class="col-12 d-flex align-items-center justify-content-center">
                    @yield('content')
                </div>
            </section>
        </div>
    </div>
</div>


<!-- Scripts -->
{{--<script src="{{ asset('js/app.js') }}"></script>--}}

<!-- BEGIN: Vendor JS-->
{{--<script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}"></script>--}}
<!-- BEGIN Vendor JS-->

@stack('scripts')
</body>
</html>
