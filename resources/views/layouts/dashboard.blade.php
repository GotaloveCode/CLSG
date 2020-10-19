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

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/vendors.min.css') }}">
    <!-- END: Vendor CSS-->

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
@stack('css')
<!-- END: Custom CSS-->
    <script>
    window.url ="{{url('/')}}";
    </script>
</head>
<body class="vertical-layout vertical-menu content-detached-right-sidebar   fixed-navbar" data-open="click"
      data-menu="vertical-menu" data-col="content-detached-right-sidebar">
<div id="app">
    @include('layouts.partials.header')
    @include('layouts.partials.sidebar')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>
    @include('layouts.partials.footer')
</div>


<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>

<!-- BEGIN: Vendor JS-->
{{--commented out jquery,bootstrap,popper since they are in app.js--}}
<script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{ asset('app-assets/js/core/app-menu.min.js') }}"></script>
<script src="{{ asset('app-assets/js/core/app.min.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/customizer.min.js') }}"></script>
<!-- END: Theme JS-->
<script>
    @if(Session::has('success'))
    window.Vue.swal("Success","{{ Session::get('success') }}");
    @endif
    @if($errors->any())
    @foreach($errors->all() as $error)
    window.Vue.swal('Error','{{$error}}');
    @endforeach
    @endif
</script>
<!-- BEGIN: Page JS-->
@stack('scripts')
<!-- END: Page JS-->
</body>
</html>
