<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | {{ __('Admin area') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-shared.ico />
    <!-- PWA  -->
    <meta name="theme-color" content="#6777ef" />
    <link rel="apple-touch-icon" href="{{ asset('image/logo.jpg') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin/dist/css/adminlte.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- jQuery -->
    <script src="{{ asset('admin') }}/plugins/jquery/jquery.min.js"></script>
    @yield('css')
</head>

<body class="layout-top-nav">
    <div class="wrapper">
        <!-- Navbar -->
        <x-backend.shareds.navbar />
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        {{-- <aside class="main-sidebar sidebar-dark-primary elevation-4">

                <x-backend.shareds.side-menu-logo />

                <!-- Sidebar -->
                <div class="sidebar">

                    <x-backend.shareds.side-menu-panel />

                    <!-- Sidebar Menu -->
                    <x-backend.shareds.side-menu />
                    <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside> --}}

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        @yield('breadcump')
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @yield('main')
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <div class="col-xs-4 col-md-12">
            <x-backend.shareds.bottom-bar />
        </div>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('admin') }}/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="{{ asset('admin') }}/plugins/jquery/jquery.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        // $.widget.bridge('uibutton', $.ui.button)
    </script>
    <script src="{{ asset('admin') }}/plugins/moment/moment.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('admin') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('admin') }}/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js">
    </script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('admin') }}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('admin') }}/dist/js/adminlte.js"></script>

    <!-- Summernote -->
    <script src="{{ asset('admin') }}/plugins/summernote/summernote-bs4.min.js"></script>
    <script>
        function getCookie(cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }
    </script>
    @yield('js')
    <script src="{{ asset('/sw.js') }}"></script>
    <!-- Laravel PWA -->
    <script>
        if ("serviceWorker" in navigator) {
            // Register a service worker hosted at the root of the
            // site using the default scope.
            navigator.serviceWorker.register("/sw.js").then(
                (registration) => {
                    console.log("Service worker registration succeeded:", registration);
                },
                (error) => {
                    console.error(`Service worker registration failed: ${error}`);
                },
            );
        } else {
            console.error("Service workers are not supported.");
        }
    </script>
</body>

</html>