@extends('layouts.auth')

@section('content')
<div class="w-lg-550px p-10 p-lg-15 mx-auto">
    
    <form class="form w-100" novalidate="novalidate" method="POST" action="{{ route('password.update') }}" id="kt_new_password_form">

        <input type="hidden" name="token" value="{{ $token }}">

        @csrf

        <div class="text-center mb-10">
            
            <h1 class="text-dark mb-3">Setup New Password</h1>
            
            <div class="text-gray-400 fw-bold fs-4">Already have reset your password ?

            <a href="{{ route('login') }}">Sign in here</a></div>
            
        </div>

        <div class="fv-row mb-10">

            <label class="form-label fw-bolder text-gray-900 fs-6">Email</label>
            <input class="form-control form-control-solid @error('email') is-invalid border-danger @enderror" type="email" placeholder="" id="email" name="email" autocomplete="email" autofocus value="{{ old('email') }}" required />

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div>
        
        <div class="mb-10 fv-row" data-kt-password-meter="true">
            
            <div class="mb-1">
                
                <label class="form-label fw-bolder text-dark fs-6">Password</label>
                
                <div class="position-relative mb-3">
                    <input class="form-control form-control-lg form-control-solid @error('password') is-invalid border-danger @enderror" type="password" placeholder="" id="password" name="password" required autocomplete="new-password" />

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                        <i class="bi bi-eye-slash fs-2"></i>
                        <i class="bi bi-eye fs-2 d-none"></i>
                    </span>
                </div>
                
                <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                </div>
                
            </div>
            
            <div class="text-muted">Use 8 or more characters with a mix of letters, numbers &amp; symbols.</div>
            
        </div>
        
        <div class="fv-row mb-10">
            <label class="form-label fw-bolder text-dark fs-6">Confirm Password</label>
            <input class="form-control form-control-lg form-control-solid" type="password" placeholder="" name="password_confirmation" id="password-confirm" autocomplete="new-password" required />
        </div>
                        
        <div class="text-center">
            <button type="submit" id="kt_new_password_submit" class="btn btn-lg btn-primary fw-bolder">
                <span class="indicator-label">Reset Password</span>
                <span class="indicator-progress">Please wait...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
        </div>
        
    </form>
    
</div>
@endsection