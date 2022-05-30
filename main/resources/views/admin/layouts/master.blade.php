<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="Keywords"
        content="bootstrap admin template, admin template ,admin panel template ,bootstrap 4 admin template ,bootstrap admin ,admin dashboard template ,bootstrap admin panel ,bitcoin dashboard ,crypto dashboard ,btc dashboard ,cryptocurrency dashboard ,bitcoin template ,cryptocurrency template ,crypto template ,cryptocurrency dashboard template ,cryptocurrency admin template ,crypto admin template ,btconline dashboard ,ryptocurrency dashboard template ,crypto admin template ,crypto trading dashboard ,cryptocurrency admin template " />

    <!-- Title -->
    <title> HDMI50 App || @yield('title') </title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/admin/img/brand/favicon.png') }}" type="image/x-icon" />

    <!-- Icons css -->
    <link href="{{ asset('assets/admin/css/icons.css') }}" rel="stylesheet">

    <!--  Right-sidemenu css -->
    <link href="{{ asset('assets/admin/plugins/sidebar/sidebar.css') }}" rel="stylesheet">

    <!--  Custom Scroll bar-->
    <link href="{{ asset('assets/admin/plugins/mscrollbar/jquery.mCustomScrollbar.css') }}" rel="stylesheet" />

    <!--  Left-Sidebar css -->
    <link href="{{ asset('assets/admin/css/sidemenu.css') }}" rel="stylesheet">

    <!-- style css-->
    <link href="{{ asset('assets/admin/css/style.css') }}" rel="stylesheet">

    <!-- skin css-->
    <link href="{{ asset('assets/admin/css/skin-modes.css') }}" rel="stylesheet">

    <!-- dark-theme css-->
    <link href="{{ asset('assets/admin/css/style-dark.css') }}" rel="stylesheet">

    <!--- Animations css-->
    <link href="{{ asset('assets/admin/css/animate.css') }}" rel="stylesheet">
    @stack('css')

</head>

<body class="main-body dark-theme">

    <!-- Loader -->
    <div id="global-loader" class="dark-loader">
        <img src="{{ asset('assets/admin/img/loaders/loader.svg') }}" class="loader-img" alt="Loader">
    </div>
    <!-- /Loader -->

    <!-- Page -->
    <div class="page">
    @yield('content')
      
    </div>

    <script src="{{ asset('assets/admin/plugins/jquery/jquery.min.js') }}"></script>
    <!-- JQuery min js -->

    <!-- Bootstrap Bundle js -->
    <script src="{{ asset('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Ionicons js -->
    <script src="{{ asset('assets/admin/plugins/ionicons/ionicons.js') }}"></script>

    <!-- Moment js -->
    <script src="{{ asset('assets/admin/plugins/moment/moment.js') }}"></script>

    <!-- eva-icons js -->
    <script src="{{ asset('assets/admin/js/eva-icons.min.js') }}"></script>

    <!-- Rating js-->
    <script src="{{ asset('assets/admin/plugins/rating/jquery.rating-stars.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/rating/jquery.barrating.js') }}"></script>

    @include('admin.partials.notify')

    <!-- Custom js -->
    <script src="{{ asset('assets/admin/js/custom.js') }}"></script>
    @stack('scripts')

</body>

</html>
