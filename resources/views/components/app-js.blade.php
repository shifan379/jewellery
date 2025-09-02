

    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}" type="text/javascript"></script>

    <!-- Bootstrap Core JS -->
	<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
	<!-- Feather Icon JS -->
	<script src="{{ asset('assets/js/feather.min.js') }}" type="text/javascript"></script>
	<!-- Slimscroll JS -->
    <!-- Datatable JS -->
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}" type="760da1dc9a40e43dbe4a35db-text/javascript"></script>
	<script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
	<!-- Color Picker JS -->
	<script src="{{ asset('assets/plugins/@simonwep/pickr/pickr.es5.min.js') }}" type="text/javascript"></script>
	<!-- Custom JS -->
	<script src="{{ asset('assets/js/theme-colorpicker.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/js/script.js') }}" type="text/javascript"></script>

    <script src="{{ asset('assets/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js') }}" data-cf-settings="62427e9c5fffd0f0e06cdda6-|49" defer></script><script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"rayId":"954235ae9edd5134","version":"2025.6.2","serverTiming":{"name":{"cfExtPri":true,"cfEdge":true,"cfOrigin":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"3ca157e612a14eccbb30cf6db6691c29","b":1}' crossorigin="anonymous"></script>

    <x-app-alert/>
    @stack('js')
