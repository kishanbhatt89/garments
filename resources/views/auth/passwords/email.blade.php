@extends('layouts.auth')

@section('content')
<div class="d-flex flex-center flex-column flex-column-fluid">
						
    <div class="w-lg-500px p-10 p-lg-15 mx-auto">

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        
        <form class="form w-100" novalidate="novalidate" action="{{ route('password.email') }}" method="POST" id="kt_password_reset_form">

            @csrf
            
            <div class="text-center mb-10">
            
                <h1 class="text-dark mb-3">Forgot Password ?</h1>
                
                <div class="text-gray-400 fw-bold fs-4">Enter your email to reset your password.</div>
                
            </div>
            
            <div class="fv-row mb-10">

                <label class="form-label fw-bolder text-gray-900 fs-6">Email</label>
                <input class="form-control form-control-solid @error('email') is-invalid border-danger @enderror" type="email" placeholder="" id="email" name="email" autocomplete="off" value="{{ old('email') }}" />

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

            </div>
            
            <div class="d-flex flex-wrap justify-content-center pb-lg-0">

                <button type="submit" id="kt_password_reset_submit" class="btn btn-lg btn-primary fw-bolder me-4">
                    <span class="indicator-label">Send Password Reset Link</span>
                    <span class="indicator-progress">Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>

                <a href="{{ url('/') }}" class="btn btn-lg btn-light-primary fw-bolder">Cancel</a>

            </div>
            
        </form>
        
    </div>
    
</div>
@endsection