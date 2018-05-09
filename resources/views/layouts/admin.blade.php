<!DOCTYPE html>
<html lang="en">
<head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap -->
    <link href="{{ asset('vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ asset('vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="{{ asset('css/admin/custom.min.css') }}" rel="stylesheet">

    @stack('page-styles')
</head>

<body class="nav-md">
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                    <a href="{{ route('admin.dashboard.index') }}" class="site_title"><i class="fa fa-paw"></i> <span>{{ env('APP_NAME') }}</span></a>
                </div>

                <div class="clearfix"></div>

                <!-- menu profile quick info -->
                @include('partials.admin.sidebar._user-profile-data')
                <!-- /menu profile quick info -->

                <br />

                <!-- sidebar menu -->
                @include('partials.admin.sidebar._menu')
                <!-- /sidebar menu -->

                <!-- /menu footer buttons -->
                @include('partials.admin.sidebar._footer')
                <!-- /menu footer buttons -->
            </div>
        </div>

        <!-- top navigation -->
        @include('partials.admin.top._menu')
        <!-- /top navigation -->

        <!-- page content -->
        @yield('content')
        <!-- /page content -->

        <!-- footer content -->
        <footer>
            <div class="pull-right">
                Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
    </div>
</div>

<!-- jQuery -->
<script src="{{ asset('vendors/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('vendors/fastclick/lib/fastclick.js') }}"></script>
<!-- NProgress -->
<script src="{{ asset('vendors/nprogress/nprogress.js') }}"></script>
<!-- Laroute -->
<script src="{{ asset('js/laroute.js') }}"></script>

<!-- Custom Theme Scripts -->
<script src="{{ asset('js/admin/custom.min.js') }}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
@stack('page-scripts')
</body>
</html>