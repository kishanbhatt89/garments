<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	
	<head>

        <base href="">

		<title>{{ config('app.name', 'Laravel') }}</title>
    
        <meta name="csrf-token" content="{{ csrf_token() }}">

		<meta charset="utf-8" />

		<meta name="description" content="" />

		<meta name="keywords" content="" />

		<meta name="viewport" content="width=device-width, initial-scale=1" />
		
		<link rel="shortcut icon" href="{{ asset('gapp') }}/media/logos/favicon.ico" />

		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		
		<link href="{{ asset('gapp') }}/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />

		<link href="{{ asset('gapp') }}/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
		
		<link href="{{ asset('gapp') }}/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />

		<link href="{{ asset('gapp') }}/css/style.bundle.css" rel="stylesheet" type="text/css" />

		@yield('custom-css')
		
	</head>
	
	<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed" style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
		
		<div class="d-flex flex-column flex-root">
			
			<div class="page d-flex flex-row flex-column-fluid">
				
				<div id="kt_aside" class="aside aside-dark aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_mobile_toggle">
					
					<div class="aside-logo flex-column-auto" id="kt_aside_logo">
						
						<a href="#">
							<img alt="Logo" src="{{ asset('gapp') }}/media/logos/logo-1-dark.svg" class="h-25px logo" />
						</a>
						
						<!--begin::Aside toggler-->
						@include('layouts.partials._sidebar_toggle')
						<!--end::Aside toggler-->

					</div>
					<!--end::Brand-->
					<!--begin::Aside menu-->
					@include('layouts.partials._sidebar')
					<!--end::Aside menu-->
					<!--begin::Footer-->
					{{-- @include('layouts.partials._sidebar_footer') --}}
					<!--end::Footer-->
				</div>
				<!--end::Aside-->
				<!--begin::Wrapper-->
				<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
					<!--begin::Header-->
					<div id="kt_header" class="header align-items-stretch">
						<!--begin::Container-->
						<div class="container-fluid d-flex align-items-stretch justify-content-between">
							<!--begin::Aside mobile toggle-->
							@include('layouts.partials._mobile_toggle')
							<!--end::Aside mobile toggle-->
							<!--begin::Mobile logo-->
							@include('layouts.partials._mobile_logo')
							<!--end::Mobile logo-->
							<!--begin::Wrapper-->
							@include('layouts.partials._topbar')
							<!--end::Wrapper-->
						</div>
						<!--end::Container-->
					</div>
					<!--end::Header-->
					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						@yield('content')
					</div>
					<!--end::Content-->
					<!--begin::Footer-->
					@include('layouts.partials._footer')
					<!--end::Footer-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::Root-->					
		
		@include('layouts.partials._scrolltop')				
				
		<script>var hostUrl = "{{ asset('gapp') }}/";</script>
		
		<script src="{{ asset('gapp') }}/plugins/global/plugins.bundle.js"></script>

		<script src="{{ asset('gapp') }}/js/scripts.bundle.js"></script>
		
		<script src="{{ asset('gapp') }}/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>

		<script src="{{ asset('gapp') }}/plugins/custom/datatables/datatables.bundle.js"></script>
		
		<script src="{{ asset('gapp') }}/js/widgets.bundle.js"></script>

		<script src="{{ asset('gapp') }}/js/custom/widgets.js"></script>

		<script src="{{ asset('gapp') }}/js/custom/apps/chat/chat.js"></script>

		<script src="https://momentjs.com/downloads/moment.min.js"></script>

		<!-- <script src="{{ asset('gapp') }}/js/custom/utilities/modals/upgrade-plan.js"></script>

		<script src="{{ asset('gapp') }}/js/custom/utilities/modals/create-app.js"></script>

		<script src="{{ asset('gapp') }}/js/custom/utilities/modals/users-search.js"></script> -->		

		<script>

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			toastr.options = {
				"closeButton": false,
				"debug": false,
				"newestOnTop": false,
				"progressBar": true,
				"positionClass": "toastr-top-right",
				"preventDuplicates": false,
				"showDuration": "300",
				"hideDuration": "1000",
				"timeOut": "5000",
				"extendedTimeOut": "1000",
				"showEasing": "swing",
				"hideEasing": "linear",
				"showMethod": "fadeIn",
				"hideMethod": "fadeOut"
			};

			const APP_URL = "{{ url('/') }}";

		</script>

		@yield('custom-js')
		
	</body>
	
</html>