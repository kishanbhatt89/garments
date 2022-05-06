@extends('layouts.auth')

@section('content')
    
    <div class="w-lg-500px p-10 p-lg-15 mx-auto">		

		<form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" action="{{ route('login') }}" method="POST">

			@csrf
			
			<div class="text-center mb-10">
			
				<h1 class="text-dark mb-3">Sign In</h1>
			
				<div class="text-gray-400 fw-bold fs-4">New Here?
				<a href="{{ route('register') }}" class="link-primary fw-bolder">Create an Account</a></div>
				
			</div>
			
			<div class="fv-row mb-10">
				
				<label class="form-label fs-6 fw-bolder text-dark">Email</label>
				
				<input class="form-control form-control-lg form-control-solid @error('email') is-invalid border-danger @enderror" type="email" id="email" name="email" autocomplete="email" required autofocus />

				@error('email')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
				
			</div>
			
			<div class="fv-row mb-10">
				
				<div class="d-flex flex-stack mb-2">

					<label class="form-label fw-bolder text-dark fs-6 mb-0">Password</label>

					<a href="{{ route('password.request') }}" class="link-primary fs-6 fw-bolder">Forgot Password ?</a>

				</div>

				<input class="form-control form-control-lg form-control-solid @error('password') is-invalid border-danger @enderror" type="password" name="password" autocomplete="off" />

				@error('password')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror

			</div>

			<div class="fv-row mb-10">

                <l class="form-check form-check-custom form-check-solid form-check-inline">
                    <input class="form-check-input" type="checkbox" name="remember" />
                    <span class="form-check-label fw-bold text-gray-700 fs-6">Remember Me</span>
                </l
				abel>
			</div>

			<div class="text-center">
				
				<button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
					<span class="indicator-label">Sign In</span>
					<span class="indicator-progress">Please wait...
					<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
				</button>								
				
			</div>
			
		</form>
		
	</div>

@endsection