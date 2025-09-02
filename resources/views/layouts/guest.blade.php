<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Login') }}</title>

        <!-- Scripts -->
        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">

    <!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/tabler-icons/tabler-icons.min.css') }}">
    <!-- Scripts -->

    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

    <!-- Styles -->
    {{-- @livewireStyles --}}
</head>

<body>
    {{-- <div class="font-sans text-gray-900 antialiased">
        {{ $slot }}
    </div> --}}


    {{-- <div id="global-loader">
        <div class="whirly-loader"> </div>
    </div> --}}

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <div class="account-content">
            <div class="login-wrapper login-new">
                <div class="row w-100">
                    <div class="col-lg-5 mx-auto">
                        <div class="login-content user-login">
                            <div class="login-logo">
                                <img src="{{ asset('assets/img/logo/logo.png') }}" alt="img">
                                <a href="" class="login-logo logo-white">
                                    <img src="{{ asset('assets/img/logo/logo.png') }}" alt="Img">
                                </a>
                            </div>

                             {{ $slot }}


                        </div>
                        <div class="my-4 d-flex justify-content-center align-items-center copyright-text">
                            <p>Copyright &copy; 2025 ZB Solution</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Main Wrapper -->

    {{-- @livewireScripts --}}
    <!-- jQuery -->
    <script src="{{asset('assets/js/jquery-3.7.1.min.js" type="1072e6b1b18cfa6bc3dbb629-text/javascript')}}"></script>

    <!-- Feather Icon JS -->
    <script src="{{asset('assets/js/feather.min.js" type="1072e6b1b18cfa6bc3dbb629-text/javascript')}}"></script>

    <!-- Bootstrap Core JS -->
    <script src="{{asset('assets/js/bootstrap.bundle.min.js" type="1072e6b1b18cfa6bc3dbb629-text/javascript')}}"></script>

    <!-- Custom JS -->
    <script src="{{asset('assets/js/script.js" type="1072e6b1b18cfa6bc3dbb629-text/javascript')}}"></script>

    <script src="../../cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js"
        data-cf-settings="1072e6b1b18cfa6bc3dbb629-|49" defer></script>
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
        integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
        data-cf-beacon='{"rayId":"954236488d4d5134","version":"2025.6.2","serverTiming":{"name":{"cfExtPri":true,"cfEdge":true,"cfOrigin":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"3ca157e612a14eccbb30cf6db6691c29","b":1}'
        crossorigin="anonymous"></script>


</body>

</html>
