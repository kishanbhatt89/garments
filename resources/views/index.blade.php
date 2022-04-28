<!DOCTYPE html>

<html lang="en">
	
	<head>
                
		<title>Welcome To Garments App</title>

		<meta charset="utf-8" />

		<meta name="description" content="" />

		<meta name="keywords" content="" />

		<meta name="viewport" content="width=device-width, initial-scale=1" />
	
		<link rel="shortcut icon" href="{{ asset('gapp') }}/media/logos/favicon.ico" />
		
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />

		<link href="{{ asset('gapp') }}/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />

		<link href="{{ asset('gapp') }}/css/style.bundle.css" rel="stylesheet" type="text/css" />
		
	</head>
	
	<body id="kt_body" class="auth-bg">
		
		<div class="d-flex flex-column flex-root">
			
			<div class="d-flex flex-column flex-column-fluid">
				
				<div class="d-flex flex-column flex-column-fluid text-center p-10 py-lg-7">
					
					<a href="#" class="mb-5 pt-lg-5">
						<img alt="Logo" src="{{ asset('gapp') }}/media/logos/logo-1.svg" class="h-40px mb-5" />
					</a>
					
					<div class="pt-lg-5 mb-10">
						
						<h1 class="fw-bolder fs-2qx text-gray-800 mb-7">Welcome to Garments App</h1>
						
						<div class="fw-bold fs-3 text-muted mb-15">Best garments
						<br />with premium quality.</div>

                        <div class="text-center">
                            @if (Route::has('login'))                            
                                @auth
                                    <a href="{{ route('dashboard') }}" class="btn btn-lg btn-primary fw-bolder">Dashboard</a>                                
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-lg btn-primary fw-bolder" style="margin-right: 10px">Sign In</a>                                                                
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="btn btn-lg btn-primary fw-bolder" style="margin-left: 10px">Sign Up</a>            
                                    @endif
                                @endauth                            
                            @endif
                        </div>												
						
					</div>
					
					<div class="d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-100px min-h-lg-350px" style="background-image: url({{ asset('gapp') }}/media/illustrations/sketchy-1/17.png"></div>
					
				</div>								
				
			</div>
			
		</div>
		
		<script>var hostUrl = "{{ asset('gapp') }}/";</script>
		
		<script src="{{ asset('gapp') }}/plugins/global/plugins.bundle.js"></script>

		<script src="{{ asset('gapp') }}/js/scripts.bundle.js"></script>
		
	</body>
	
</html>