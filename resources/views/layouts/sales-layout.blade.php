<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <meta name="description"
        content="Dreams POS is a powerful Bootstrap based Inventory Management Admin Template designed for businesses, offering seamless invoicing, project tracking, and estimates.">
    <meta name="keywords"
        content="inventory management, admin dashboard, bootstrap template, invoicing, estimates, business management, responsive admin, POS system"> --}}
    <meta name="author" content="ZB Solutions">
    <meta name="robots" content="index, follow">


    <title>ZB Online Sales</title>

        <!-- jQuery (must be first) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Toastr JS (must be after jQuery) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    {{-- <script src="{{ asset('assets/js/theme-script.js') }}" type="text/javascript"></script> --}}
    <!-- Summernote CSS -->
	<link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.min.css') }}">
    <!-- Summernote JS -->
	<script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}" type="text/javascript"></script>
	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset("assets/img/logo/favicon.png") }}">
	<!-- Apple Touch Icon -->
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/logo/favicon.png') }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
    <!-- animation CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables-bootstrap5.min.css') }}">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
    <!-- Daterangepikcer CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">

    <!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/tabler-icons/tabler-icons.min.css') }}">
    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/owlcarousel/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/owlcarousel/owl.theme.default.min.css') }}">
    <!-- Color Picker Css -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/@simonwep/pickr/themes/nano.min.css') }}">
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    @stack('css')

</head>

<body class="pos-page">
    {{-- <x-app-loader /> --}}
    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <!-- Header -->
        <x-sales-header />
        <!-- /Header -->

        @yield('content')


    </div>
    <!-- /Main Wrapper -->


    @yield('models')
    <!-- jQuery -->
    <script data-cfasync="false" src="{{ asset('assets/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js') }}"></script>
    <!-- Feather Icon JS -->
    <script src="{{ asset('assets/js/feather.min.js') }}" type="text/javascript"></script>
    <!-- Slimscroll JS -->
    <script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
    <!-- Bootstrap Core JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
    <!-- Datatable JS -->
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}" type="text/javascript"></script>
    <!-- Daterangepikcer JS -->
    <script src="{{ asset('assets/js/moment.min.js') }}"    type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"  type="text/javascript"></script>
    <!-- Owl JS -->
    <script src="{{ asset('assets/plugins/owlcarousel/owl.carousel.min.js') }}" type="text/javascript"></script>

    <!-- Select2 JS -->
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}" type="text/javascript"></script>
    <!-- Sticky-sidebar -->
    <script src="{{ asset('assets/plugins/theia-sticky-sidebar/ResizeSensor.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') }}" type="text/javascript"></script>
    <!-- Color Picker JS -->
    <script src="{{ asset('assets/plugins/@simonwep/pickr/pickr.es5.min.js') }}" type="text/javascript"></script>
    <!-- Custom JS -->
    <script src="{{ asset('assets/js/calculator.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/script.js') }}" type="text/javascript"></script>

    <script>
        function updateClock() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('en-GB');
            document.getElementById('clock').textContent = timeString;
        }

        updateClock();
        setInterval(updateClock, 1000);
    </script>




        <script>
            @if(session('success'))
                toastr.success("{{ session('success') }}");
            @endif

            @if(session('error'))
                toastr.error("{{ session('error') }}");
            @endif

            @if(session('warning'))
                toastr.warning("{{ session('warning') }}");
            @endif

            @if(session('info'))
                toastr.info("{{ session('info') }}");
            @endif

            // @if ($errors->any())
            //     @foreach ($errors->all() as $error)
            //         toastr.error("{{ $error }}");
            //     @endforeach
            // @endif
        </script>
        @stack('js')



</body>

</html>
