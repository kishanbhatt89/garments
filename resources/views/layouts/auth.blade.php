<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	
	<head>            

		<title>{{ config('app.name', 'Laravel') }}</title>

        <meta name="csrf-token" content="{{ csrf_token() }}">

		<meta charset="utf-8" />

		<meta name="description" content="" />

		<meta name="keywords" content="" />

		<meta name="viewport" content="width=device-width, initial-scale=1" />
		
		<link rel="shortcut icon" href="{{ asset('gapp') }}/media/logos/favicon.ico" />

		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		
		<link href="{{ asset('gapp') }}/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />

		<link href="{{ asset('gapp') }}/css/style.bundle.css" rel="stylesheet" type="text/css" />
		
	</head>
	
	<body id="kt_body" class="bg-body">
		
		<div class="d-flex flex-column flex-root">
			
			<div class="d-flex flex-column flex-lg-row flex-column-fluid">
				
				<div class="d-flex flex-column flex-lg-row-auto w-xl-600px positon-xl-relative" style="background-color: #F2C98A">
					
					<div class="d-flex flex-column position-xl-fixed top-0 bottom-0 w-xl-600px scroll-y">
						
						<div class="d-flex flex-row-fluid flex-column text-center p-10 pt-lg-20">
							
							<a href="#" class="py-9 mb-5">
								<img alt="Logo" src="{{ asset('gapp') }}/media/logos/logo-2.svg" class="h-60px" />
							</a>
							
							<h1 class="fw-bolder fs-2qx pb-5 pb-md-10" style="color: #986923;">Welcome to Garments App</h1>
							
							<p class="fw-bold fs-2" style="color: #986923;">Discover Amazing Garments

							<br />with great quality</p>
							
						</div>
						
						<div class="d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-100px min-h-lg-350px" style="background-image: url({{ asset('gapp') }}/media/illustrations/sketchy-1/13.png"></div>
						
					</div>
					
				</div>
				
				<div class="d-flex flex-column flex-lg-row-fluid py-10">
					
					<div class="d-flex flex-center flex-column flex-column-fluid">
						@yield('content')
					</div>										
					
				</div>
				
			</div>
			
		</div>
		
		<script>var hostUrl = "{{ asset('gapp') }}/";</script>
		
		<script src="{{ asset('gapp') }}/plugins/global/plugins.bundle.js"></script>

		<script src="{{ asset('gapp') }}/js/scripts.bundle.js"></script>
		
		@if (request()->is('login'))		
			<!-- <script src="{{ asset('gapp') }}/js/custom/authentication/sign-in/general.js"></script> -->
		@endif

		@if (request()->is('register'))
        	<!-- <script src="{{ asset('gapp') }}/js/custom/authentication/sign-up/general.js"></script> -->
		@endif		

		<script>

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

		</script>

		@error('active')
			<script>
				toastr.error('{{ $message }}');
			</script>				
		@enderror
		
	</body>
	
</html>