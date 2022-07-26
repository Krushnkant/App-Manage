<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Quixlab - Bootstrap Admin Dashboard Template by Themefisher.com</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <!-- Pignose Calender -->
    <link href="{{asset('user/assets/plugins/pg-calendar/css/pignose.calendar.min.css')}}" rel="stylesheet">
    <!-- Chartist -->
    <link rel="stylesheet" href="{{asset('user/assets/plugins/chartist/css/chartist.min.css')}}">
    <link rel="stylesheet" href="{{asset('user/assets/plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css')}}">
    <!-- Custom Stylesheet -->
    <link href="{{asset('user/assets/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('user/assets/css/jquery.filer-dragdropbox-theme.css') }}" rel="stylesheet">

</head>

<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    
    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            @include('user.layouts.navbar')
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->
        <div class="header">    
            @include('user.layouts.header')
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="nk-sidebar">           
            @include('user.layouts.sidebar')
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            @yield('content')
            <!-- #/ container -->
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
        
        
        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
        @include('user.layouts.footer')
        </div>
        <!--**********************************
            Footer end
        ***********************************-->
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    @stack('scripts')

    <script src="{{asset("user/assets/plugins/common/common.min.js")}}"></script>
    <script src="{{asset("user/assets/js/custom.min.js")}}"></script>
    <script src="{{asset("user/assets/js/settings.js")}}"></script>
    <script src="{{asset("user/assets/js/gleek.js")}}"></script>
    <script src="{{asset("user/assets/js/styleSwitcher.js")}}"></script>

    <!-- Chartjs -->
    <script src="{{asset("user/assets/plugins/chart.js/Chart.bundle.min.js")}}"></script>
    <!-- Circle progress -->
    <script src="{{asset("user/assets/plugins/circle-progress/circle-progress.min.js")}}"></script>
    <!-- Datamap -->
    <script src="{{asset("user/assets/plugins/d3v3/index.js")}}"></script>
    <script src="{{asset("user/assets/plugins/topojson/topojson.min.js")}}"></script>
    <script src="{{asset("user/assets/plugins/datamaps/datamaps.world.min.js")}}"></script>
    <!-- Morrisjs -->
    <script src="{{asset("user/assets/plugins/raphael/raphael.min.js")}}"></script>
    <script src="{{asset("user/assets/plugins/morris/morris.min.js")}}"></script>
    <!-- Pignose Calender -->
    <script src="{{asset("user/assets/plugins/moment/moment.min.js")}}"></script>
    <script src="{{asset("user/assets/plugins/pg-calendar/js/pignose.calendar.min.js")}}"></script>
    <!-- ChartistJS -->
    <script src="{{asset("user/assets/plugins/chartist/js/chartist.min.js")}}"></script>
    <script src="{{asset("user/assets/plugins/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js")}}"></script>

    <script src="{{asset("user/assets/js/dashboard/dashboard-1.js")}}"></script>
    <script src="{{asset("user/assets/js/CatImgJs.js") }}" type="text/javascript"></script>
</body>

</html>