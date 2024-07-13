<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <x-shared.ico />
    <meta name="theme-color" content="#6777ef" />
    <link rel="apple-touch-icon" href="{{ asset('image/logo.jpg') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('admin') }}/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('admin') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin') }}/dist/css/adminlte.css">
    <style>
    body, html {
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #f3f3f3;
    }

    #loading-screen {
        position: fixed;
        width: 100%;
        height: 100%;
        background-color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }
    </style>
</head>

<body class="login-page vh-100">
    <div id="loading-screen">
        <div class="loader"></div>
    </div>
    <div class="loader-btn"></div>
    <div id="content" style="display: none;">
        @yield('main')
    </div>
    <!-- jQuery -->
    <script src="{{ asset('admin') }}/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('admin') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('admin') }}/dist/js/adminlte.min.js"></script>
    <!-- Laravel PWA -->
    <script src="{{ asset('/sw.js') }}"></script>
    <script>
        // loader script
    window.addEventListener('load', function () {
        const loadingScreen = document.getElementById('loading-screen');
        const content = document.getElementById('content');

        loadingScreen.style.display = 'none';
        content.style.display = 'block';
    });

    const form = document.getElementById('form-login');
    let textLogin = document.getElementById('text-login');
    let btnLogin = document.getElementById('button-login')
    const loader = document.getElementsByClassName('loader-btn');

    console.log(form);
    console.log(loader[0]);
       form.addEventListener('submit', function(e) {
            console.log('submit event on login')
            btnLogin.removeChild(textLogin);
            btnLogin.append(loader[0]);
       })
    </script>
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
