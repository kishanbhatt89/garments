@extends('layouts.master')

@section('content')
        
    @include('auth.partials._toolbar')

    <div class="post d-flex flex-column-fluid" id="kt_post">
        
        <div id="kt_content_container" class="container-xxl">

            <div class="flex-lg-row-fluid ms-lg-15">

                <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
                    
                    <li class="nav-item">

                        <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#kt_add_category">
                        
                        <span class="svg-icon svg-icon-2 me-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M11 2.375L2 9.575V20.575C2 21.175 2.4 21.575 3 21.575H9C9.6 21.575 10 21.175 10 20.575V14.575C10 13.975 10.4 13.575 11 13.575H13C13.6 13.575 14 13.975 14 14.575V20.575C14 21.175 14.4 21.575 15 21.575H21C21.6 21.575 22 21.175 22 20.575V9.575L13 2.375C12.4 1.875 11.6 1.875 11 2.375Z" fill="black" />
                            </svg>
                        </span>
                        Change Password</a>

                    </li>

                </ul>

                <form action="{{ route('admin.changepassword') }}" enctype="multipart/form-data" method="post">

                    @csrf

                    <div class="tab-content" id="myTabContent">
                        
                        <div class="tab-pane fade show active" id="kt_add_category" role="tabpanel">
                            
                            <div class="card card-flush">
                                
                                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                                                        
                                    
                                </div>
                                
                                <div class="card-body pt-0">
                                                                                                    
                                    <div class="row fv-row mb-7">

                                        <div class="col-md-3 text-md-end">
                                            
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">New Password</span>
                                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Enter new password."></i>
                                            </label>
                                            
                                        </div>

                                        <div class="col-md-9">
                                            
                                            <input type="text" class="form-control form-control-solid @error('password') is-invalid @enderror" name="password" id="password" value="{{ old('passowrd') ?? '' }}" />

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            
                                        </div>                                        

                                    </div>

                                    
                                    
                                                                                                            
                                    <div class="row">

                                        <div class="col-md-9 offset-md-3">
                                            
                                            <div class="separator mb-6"></div>
                                            
                                            <div class="d-flex justify-content-end">
                                                
                                                <button type="submit"class="btn btn-primary">
                                                    <span class="indicator-label">Update Password</span>
                                                    <span class="indicator-progress">Please wait...
                                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                </button>                                                

                                            </div>

                                        </div>

                                    </div>                                                                    
                                    
                                </div>
                                
                            </div>
                            
                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <script>        

    </script>

@endsection