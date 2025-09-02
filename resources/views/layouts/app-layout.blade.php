<!DOCTYPE html>
<html lang="en" data-layout-mode="light_mode">

<x-app-head/>


<body>
    {{-- <x-app-loader/> --}}
	<!-- Main Wrapper -->
	<div class="main-wrapper">

        <x-app-header/>
		<!-- /Header -->

		<x-app-main-sidebar/>
		<!-- /Sidebar -->

		<x-app-horizontal-sidebar/>
		<!-- /Horizontal Sidebar -->

		<x-app-two-sidebar/>
		<!-- /Two Col Sidebar -->

		<div class="page-wrapper">
            @yield('content')

			<x-app-footer/>
		</div>

	</div>
	<!-- /Main Wrapper -->

	<x-app-js/>



</body>


</html>
