    <!-- jQuery (must be first) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Toastr JS (must be after jQuery) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('assets/js/theme-script.js') }}" type="62427e9c5fffd0f0e06cdda6-text/javascript"></script>
	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset("assets/img/logo/favicon.png") }}">
	<!-- Apple Touch Icon -->
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/logo/favicon.png') }}">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="{{ asset("assets/css/bootstrap.min.css") }}">
	<!-- Datatable CSS -->
	<link rel="stylesheet" href="{{ asset('assets/css/dataTables-bootstrap5.min.css') }}">
    <!-- animation CSS -->
	<link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
	<!-- Tabler Icon CSS -->
	<link rel="stylesheet" href="{{ asset('assets/plugins/tabler-icons/tabler-icons.min.css') }}">
	<!-- Feathericon CSS -->
	<link rel="stylesheet" href="{{ asset('assets/css/feather.css') }}">
    <!-- Fontawesome CSS -->
	<link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
	<!-- Color Picker Css -->
	<link rel="stylesheet" href="{{ asset('assets/plugins/@simonwep/pickr/themes/nano.min.css') }}">
	<!-- Main CSS -->
	<link rel="stylesheet" href="{{ asset("assets/css/style.css") }}">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    @stack('css')
