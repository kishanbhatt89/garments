@extends('layouts.auth')

@section('content')

    <div class="w-lg-600px p-10 p-lg-15 mx-auto">
        
        <form class="form w-100" novalidate="novalidate" id="kt_sign_up_form" method="POST" action="{{ route('register') }}">
            
            @csrf

            <div class="mb-10 text-center">
                
                <h1 class="text-dark mb-3">Create an Account</h1>
                
                <div class="text-gray-400 fw-bold fs-4">
                    Already have an account?
                    <a href="{{ route('login') }}" class="link-primary fw-bolder">Sign is here</a>
                </div>                

            </div>                                

            <div class="fv-row mb-7">                        

                <label class="form-label fw-bolder text-dark fs-6">Name</label>

                <input class="form-control form-control-lg form-control-solid @error('name') is-invalid border-danger @enderror" type="text" placeholder="" name="name" id="name" required autocomplete="name" autofocus value="{{ old('name') }}" />       
                
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

            </div>
            
            <div class="fv-row mb-7">

                <label class="form-label fw-bolder text-dark fs-6">Email</label>

                <input class="form-control form-control-lg form-control-solid @error('email') is-invalid border-danger @enderror" type="email" placeholder="" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" />

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

                        <input class="form-control form-control-lg form-control-solid @error('password') is-invalid border-dander @enderror" type="password" placeholder="" name="password" required autocomplete="new-password" />

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
            
            <div class="fv-row mb-5">
                <label class="form-label fw-bolder text-dark fs-6">Confirm Password</label>
                <input class="form-control form-control-lg form-control-solid" type="password" placeholder="" name="password_confirmation" autocomplete="new-password" />
            </div>
            
            <!-- <div class="fv-row mb-10">
                <label class="form-check form-check-custom form-check-solid form-check-inline">
                    <input class="form-check-input" type="checkbox" name="toc" value="1" />
                    <span class="form-check-label fw-bold text-gray-700 fs-6">I Agree
                    <a href="#" class="ms-1 link-primary">Terms and conditions</a>.</span>
                </label>
            </div> -->
            
            <div class="text-center">
                <button type="submit" id="kt_sign_up_submit" class="btn btn-lg btn-primary">
                    <span class="indicator-label">Sign Up</span>
                    <span class="indicator-progress">Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
            
        </form>
        
    </div>
@endsection