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

    {{-- Bootstrap Toggle --}}
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

    <!-- Icons css -->
    <link href="{{ asset('assets/admin/css/icons.css') }}" rel="stylesheet">

    <!-- Internal Chart-Morris css-->
    <link href="{{ asset('assets/admin/plugins/morris.js/morris.css') }}" rel="stylesheet">

    <!--  Left-Sidebar css -->
    <link href="{{ asset('assets/admin/css/sidemenu.css') }}" rel="stylesheet">

    <!--  Right-sidemenu css -->
    <link href="{{ asset('assets/admin/plugins/sidebar/sidebar.css') }}" rel="stylesheet">

    <!-- Internal Nice-select css  -->
    <link href="{{ asset('assets/admin/plugins/jquery-nice-select/css/nice-select.css') }}" rel="stylesheet" />

    <!-- Internal News-Ticker css-->
    <link href="{{ asset('assets/admin/plugins/flag-icon-css/css/flag-icon.min.css') }}" rel="stylesheet">

    <!-- Jquery-countdown css-->
    <link href="{{ asset('assets/admin/plugins/jquery-countdown/countdown.css') }}" rel="stylesheet">

    <!-- Internal News-Ticker css-->
    <link href="{{ asset('assets/admin/plugins/newsticker/jquery.jConveyorTicker.css') }}" rel="stylesheet" />

    <!-- style css-->
    <link href="{{ asset('assets/admin/css/style.css') }}" rel="stylesheet">

    <!-- skin css-->
    <link href="{{ asset('assets/admin/css/skin-modes.css') }}" rel="stylesheet">

    <!-- dark-theme css-->
    <link href="{{ asset('assets/admin/css/style-dark.css') }}" rel="stylesheet">

    <!--- Animations css-->
    <link href="{{ asset('assets/admin/css/animate.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/admin/css/app.css') }}">

    @stack('css')

</head>

<body class="main-body app sidebar-mini dark-theme">

    <!-- Loader -->
    <div id="global-loader" class="dark-loader">
        <img src="{{ asset('assets/admin/img/loaders/loader.svg') }}" class="loader-img" alt="Loader">
    </div>
    <!-- /Loader -->

    <!-- Page -->
    <div class="page">
        {{-- Sidebar --}}
        @include('admin.partials.sidebar')

        <!-- main-content -->
        <div class="main-content app-content">
            <!-- Header -->
            @include('admin.partials.header')

            @yield('content')
        </div>
        <!-- /main-content -->

        {{-- Right Sidebar
        @include('admin.partials.right-sidebar') --}}

        <!-- Footer opened -->
        <div class="main-footer ht-40">
            <div class="container-fluid pd-t-0-f ht-100p">
                <span>Copyright © 2022
                    All rights reserved.</span>
            </div>
        </div>
        <!-- Footer closed -->
    </div>
    <!--end  Page -->

    <!-- Back-to-top -->
    <a href="#top" id="back-to-top"><i class="la la-chevron-up"></i></a>

    <!-- JQuery min js -->
    <script src="{{ asset('assets/admin/plugins/jquery/jquery.min.js') }}"></script>

    <!-- Datepicker js -->
    <script src="{{ asset('assets/admin/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>

    <!-- Bootstrap Bundle js -->
    <script src="{{ asset('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Ionicons js -->
    <script src="{{ asset('assets/admin/plugins/ionicons/ionicons.js') }}"></script>

    <!-- Moment js -->
    <script src="{{ asset('assets/admin/plugins/moment/moment.js') }}"></script>

    <!--Chart bundle min js -->
    <script src="{{ asset('assets/admin/plugins/chart.js/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/peity/jquery.peity.min.js') }}"></script>

    <!-- JQuery sparkline js -->
    <script src="{{ asset('assets/admin/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- Sampledata js -->
    <script src="{{ asset('assets/admin/js/chart.flot.sampledata.js') }}"></script>

    <!-- Perfect-scrollbar js -->
    <script src="{{ asset('assets/admin/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/perfect-scrollbar/p-scroll.js') }}"></script>

    <!-- Internal  Flot js-->
    <script src="{{ asset('assets/admin/plugins/jquery.flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/jquery.flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/jquery.flot/jquery.flot.categories.js') }}"></script>
    <script src="{{ asset('assets/admin/js/dashboard.sampledata.js') }}"></script>
    <script src="{{ asset('assets/admin/js/chart.flot.sampledata.js') }}"></script>


    <!-- Internal Newsticker js-->
    <script src="{{ asset('assets/admin/plugins/newsticker/jquery.jConveyorTicker.js') }}"></script>
    <script src="{{ asset('assets/admin/js/newsticker.js') }}"></script>

    {{-- Bootstrap Toggle --}}
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

    <!-- Eva-icons js -->
    <script src="{{ asset('assets/admin/js/eva-icons.min.js') }}"></script>

    <!-- Sidebar js -->
    <script src="{{ asset('assets/admin/plugins/side-menu/sidemenu.js') }}"></script>

    <!-- right-sidebar js -->
    <script src="{{ asset('assets/admin/plugins/sidebar/sidebar.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/sidebar/sidebar-custom.js') }}"></script>

    <!-- Rating js-->
    <script src="{{ asset('assets/admin/plugins/rating/jquery.rating-stars.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/rating/jquery.barrating.js') }}"></script>

    <!-- Internal Nice-select js-->
    <script src="{{ asset('assets/admin/plugins/jquery-nice-select/js/jquery.nice-select.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/jquery-nice-select/js/nice-select.js') }}"></script>

    {{-- Notify --}}
    @include('admin.partials.notify')

    <!-- Sticky js -->
    <script src="{{ asset('assets/admin/js/sticky.js') }}"></script>

    {{-- Nic Edit --}}
    <script src="{{ asset('assets/admin/js/nicEdit.js') }}"></script>

    <!-- index js -->
    <script src="{{ asset('assets/admin/js/dashboard.js') }}"></script>

    <!-- custom js -->
    <script src="{{ asset('assets/admin/js/custom.js') }}"></script>
    <script>
        "use strict";
        (function($) {
            bkLib.onDomLoaded(function() {
                $(".nicEdit").each(function(index) {
                    $(this).attr("id", "nicEditor" + index);
                    new nicEditor({
                        fullPanel: false
                    }).panelInstance('nicEditor' + index, {
                        hasPanel: true
                    });
                });
            });

            $(document).on('mouseover ', '.nicEdit-main,.nicEdit-panelContain', function() {
                $('.nicEdit-main').focus();
            });
        })(jQuery);
    </script>

    @stack('scripts')

</body>

</html>
