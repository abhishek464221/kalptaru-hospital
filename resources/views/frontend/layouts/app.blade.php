<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Medicare Plus')</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.png') }}">

    <!-- CSS -->
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend/images/favicon.png') }}">

<link rel="stylesheet" href="{{ asset('frontend/plugin/bootstrap/css/bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/plugin/bootstrap/css/bootstrap-theme.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/fonts/poppins/poppins.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/plugin/fonts/font-awesome/css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/plugin/jquery-ui/jquery-ui.min.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/plugin/process-bar/tox-progress.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/plugin/owl-carouse/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/plugin/owl-carouse/owl.theme.default.min.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/plugin/animsition/css/animate.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/plugin/mediaelement/mediaelementplayer.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/plugin/datetimepicker/bootstrap-datepicker3.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/plugin/datetimepicker/bootstrap-datetimepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/plugin/lightgallery/lightgallery.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">

    @stack('styles')
</head>
<body>

<!-- Loader -->
<div class="load-page">
    <div class="sk-wave">
        <div class="sk-rect sk-rect1"></div>
        <div class="sk-rect sk-rect2"></div>
        <div class="sk-rect sk-rect3"></div>
        <div class="sk-rect sk-rect4"></div>
        <div class="sk-rect sk-rect5"></div>
    </div>
</div>

<div id="wrapper-container" class="site-wrapper-container">
    @include('frontend.includes.header')

    <div id="main-content" class="site-main-content">
        <section class="site-content-area">
            @yield('content')
        </section>
    </div>

    @include('frontend.includes.footer')
</div>

<!-- Include Appointment Modal -->
@include('frontend.components.appointment-modal')

<!-- Scripts -->
<script src="{{ asset('frontend/plugin/jquery/jquery-2.0.2.min.js') }}"></script>
<script src="{{ asset('frontend/plugin/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('frontend/plugin/bootstrap/js/bootstrap.js') }}"></script>
<script src="{{ asset('frontend/plugin/process-bar/tox-progress.js') }}"></script>
<script src="{{ asset('frontend/plugin/waypoint/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('frontend/plugin/counterup/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('frontend/plugin/owl-carouse/owl.carousel.min.js') }}"></script>
<script src="{{ asset('frontend/plugin/mediaelement/mediaelement-and-player.js') }}"></script>
<script src="{{ asset('frontend/plugin/masonry/masonry.pkgd.min.js') }}"></script>
<script src="{{ asset('frontend/plugin/datetimepicker/moment.min.js') }}"></script>
<script src="{{ asset('frontend/plugin/datetimepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('frontend/plugin/datetimepicker/bootstrap-datepicker.tr.min.js') }}"></script>
<script src="{{ asset('frontend/plugin/datetimepicker/bootstrap-datetimepicker.js') }}"></script>
<script src="{{ asset('frontend/plugin/datetimepicker/bootstrap-datetimepicker.fr.js') }}"></script>
<script src="{{ asset('frontend/plugin/lightgallery/picturefill.min.js') }}"></script>
<script src="{{ asset('frontend/plugin/lightgallery/lightgallery.js') }}"></script>
<script src="{{ asset('frontend/plugin/lightgallery/lg-pager.js') }}"></script>
<script src="{{ asset('frontend/plugin/lightgallery/lg-autoplay.js') }}"></script>
<script src="{{ asset('frontend/plugin/lightgallery/lg-fullscreen.js') }}"></script>
<script src="{{ asset('frontend/plugin/lightgallery/lg-zoom.js') }}"></script>
<script src="{{ asset('frontend/plugin/lightgallery/lg-hash.js') }}"></script>
<script src="{{ asset('frontend/plugin/lightgallery/lg-share.js') }}"></script>
<script src="{{ asset('frontend/plugin/sticky/jquery.sticky.js') }}"></script>
<script src="{{ asset('frontend/js/main.js') }}"></script>

@stack('scripts')
</body>
</html>