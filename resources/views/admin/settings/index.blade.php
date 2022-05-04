@extends('layouts.master')

@section('content')
        
    @include('admin.settings.partials._toolbar')
    
    <div class="post d-flex flex-column-fluid" id="kt_post">
        
        <div id="kt_content_container" class="container-xxl">
            
            <div class="flex-lg-row-fluid ms-lg-15">
                
                <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
                    
                    <li class="nav-item">

                        <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#kt_company_general_settings">
                        
                        <span class="svg-icon svg-icon-2 me-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M11 2.375L2 9.575V20.575C2 21.175 2.4 21.575 3 21.575H9C9.6 21.575 10 21.175 10 20.575V14.575C10 13.975 10.4 13.575 11 13.575H13C13.6 13.575 14 13.975 14 14.575V20.575C14 21.175 14.4 21.575 15 21.575H21C21.6 21.575 22 21.175 22 20.575V9.575L13 2.375C12.4 1.875 11.6 1.875 11 2.375Z" fill="black" />
                            </svg>
                        </span>
                        General</a>

                    </li>
                    
                    <li class="nav-item">

                        <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_company_email_settings">
                        
                        <span class="svg-icon svg-icon-2 me-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M11 2.375L2 9.575V20.575C2 21.175 2.4 21.575 3 21.575H9C9.6 21.575 10 21.175 10 20.575V14.575C10 13.975 10.4 13.575 11 13.575H13C13.6 13.575 14 13.975 14 14.575V20.575C14 21.175 14.4 21.575 15 21.575H21C21.6 21.575 22 21.175 22 20.575V9.575L13 2.375C12.4 1.875 11.6 1.875 11 2.375Z" fill="black" />
                            </svg>
                        </span>
                        Email</a>

                    </li>
                    
                    <li class="nav-item">

                        <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_company_support_settings">
                        
                        <span class="svg-icon svg-icon-2 me-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M11 2.375L2 9.575V20.575C2 21.175 2.4 21.575 3 21.575H9C9.6 21.575 10 21.175 10 20.575V14.575C10 13.975 10.4 13.575 11 13.575H13C13.6 13.575 14 13.975 14 14.575V20.575C14 21.175 14.4 21.575 15 21.575H21C21.6 21.575 22 21.175 22 20.575V9.575L13 2.375C12.4 1.875 11.6 1.875 11 2.375Z" fill="black" />
                            </svg>
                        </span>
                        Support</a>

                    </li>
                    
                </ul>
                
                <div class="tab-content" id="myTabContent">
                    
                    <div class="tab-pane fade show active" id="kt_company_general_settings" role="tabpanel">
                        
                        <div class="card card-flush">
                            
                            <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                                
                                <div class="card-title">
                                    
                                    <h2>Company General Settings</h2>
                                    
                                </div>
                                
                            </div>
                            
                            <div class="card-body pt-0">
                                                                                                
                                <div class="row fv-row mb-7">

                                    <div class="col-md-3 text-md-end">
                                        
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Name</span>
                                            <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Set the title company name."></i>
                                        </label>
                                        
                                    </div>

                                    <div class="col-md-9">
                                        
                                        <input type="text" class="form-control form-control-solid" name="company_name" id="company_name" value="{{ $settings['general']['company_name'] ?? '' }}" />
                                        
                                    </div>
                                </div>
                                
                                <div class="row fv-row mb-7">

                                    <div class="col-md-3 text-md-end">
                                        
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Address</span>
                                            <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Set the of the company."></i>
                                        </label>
                                        
                                    </div>

                                    <div class="col-md-9">
                                        
                                        <textarea class="form-control form-control-solid" id="company_address" name="company_address">{{ $settings['general']['company_address'] ?? '' }}</textarea>
                                        
                                    </div>
                                </div>
                                                                    
                                <div class="row fv-row mb-7">

                                    <div class="col-md-3 text-md-end">
                                        
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Large Logo</span>
                                            <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Set the company logo large size."></i>
                                        </label>
                                        
                                    </div>

                                    <div class="col-md-9">
                                                                                    
                                        <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url(/assets/media/svg/avatars/blank.svg)">

                                            <div class="image-input-wrapper w-125px h-125px"></div>                                                
                                            
                                            <label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="change"
                                                data-bs-toggle="tooltip"
                                                data-bs-dismiss="click"
                                                title="Change Large Logo">
                                                <i class="bi bi-pencil-fill fs-7"></i>
                                                
                                                <input type="file" name="company_large_logo" accept=".png, .jpg, .jpeg" />
                                                <input type="hidden" name="company_large_logo_remove" />
                                                
                                            </label>                                                
                                            
                                            <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="cancel"
                                                data-bs-toggle="tooltip"
                                                data-bs-dismiss="click"
                                                title="Cancel Large Logo">
                                                <i class="bi bi-x fs-2"></i>
                                            </span>
                                                                                            
                                            <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="remove"
                                                data-bs-toggle="tooltip"
                                                data-bs-dismiss="click"
                                                title="Remove Large Logo">
                                                <i class="bi bi-x fs-2"></i>
                                            </span>
                                            
                                        </div>                                            

                                    </div>

                                </div>

                                <div class="row fv-row mb-7">

                                    <div class="col-md-3 text-md-end">
                                        
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Small Logo</span>
                                            <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Set the company logo small size."></i>
                                        </label>
                                        
                                    </div>

                                    <div class="col-md-9">
                                                                                    
                                        <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url(/assets/media/svg/avatars/blank.svg)">

                                            <div class="image-input-wrapper w-125px h-125px"></div>                                                
                                            
                                            <label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="change"
                                                data-bs-toggle="tooltip"
                                                data-bs-dismiss="click"
                                                title="Change Small Logo">
                                                <i class="bi bi-pencil-fill fs-7"></i>
                                                
                                                <input type="file" name="company_small_logo" accept=".png, .jpg, .jpeg" />
                                                <input type="hidden" name="company_small_logo_remove" />
                                                
                                            </label>                                                
                                            
                                            <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="cancel"
                                                data-bs-toggle="tooltip"
                                                data-bs-dismiss="click"
                                                title="Cancel Small Logo">
                                                <i class="bi bi-x fs-2"></i>
                                            </span>
                                                                                            
                                            <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="remove"
                                                data-bs-toggle="tooltip"
                                                data-bs-dismiss="click"
                                                title="Remove Small Logo">
                                                <i class="bi bi-x fs-2"></i>
                                            </span>
                                            
                                        </div>                                            

                                    </div>

                                </div>
                                                                                                        
                                <div class="row">

                                    <div class="col-md-9 offset-md-3">
                                        
                                        <div class="separator mb-6"></div>
                                        
                                        <div class="d-flex justify-content-end">
                                            
                                            <button type="button" id="saveGeneralSettingBtn" class="btn btn-primary">
                                                <span class="indicator-label">Save</span>
                                                <span class="indicator-progress">Please wait...
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                            </button>

                                        </div>

                                    </div>

                                </div>                                                                    
                                
                            </div>
                            
                        </div>
                        
                    </div>
                    
                    <div class="tab-pane fade" id="kt_company_email_settings" role="tabpanel">
                        
                        <div class="card card-flush">
                         
                            <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                                
                                <div class="card-title">
                                    
                                    <h2>Company Email Settings</h2>
                                    
                                </div>
                                
                            </div>
                            
                            <div class="card-body pt-0">
                                
                                <form id="kt_company_email_settings_form" class="form" action="#">
                                    
                                    <div class="row fv-row mb-7">

                                        <div class="col-md-3 text-md-end">
                                            
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">Mail Mailer</span>
                                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Set the name of the store"></i>
                                            </label>
                                            
                                        </div>
                                        <div class="col-md-9">
                                            
                                            <input type="text" class="form-control form-control-solid" name="company_mail_mailer" id="company_mail_mailer" value="{{ $settings['email']['company_mail_mailer'] ?? '' }}" />
                                            
                                        </div>

                                    </div>

                                    <div class="row fv-row mb-7">

                                        <div class="col-md-3 text-md-end">
                                            
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">Mail Host</span>
                                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Set the name of the store"></i>
                                            </label>
                                            
                                        </div>
                                        <div class="col-md-9">
                                            
                                            <input type="text" class="form-control form-control-solid" name="company_mail_host" id="company_mail_host" value="{{ $settings['email']['company_mail_host'] ?? '' }}" />
                                            
                                        </div>

                                    </div>

                                    <div class="row fv-row mb-7">

                                        <div class="col-md-3 text-md-end">
                                            
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">Mail Port</span>
                                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Set the name of the store"></i>
                                            </label>
                                            
                                        </div>
                                        <div class="col-md-9">
                                            
                                            <input type="text" class="form-control form-control-solid" name="company_mail_port" id="company_mail_port" value="{{ $settings['email']['company_mail_port'] ?? '' }}" />
                                            
                                        </div>

                                    </div>

                                    <div class="row fv-row mb-7">

                                        <div class="col-md-3 text-md-end">
                                            
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">Mail Username</span>
                                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Set the name of the store"></i>
                                            </label>
                                            
                                        </div>
                                        <div class="col-md-9">
                                            
                                            <input type="text" class="form-control form-control-solid" name="company_mail_username" id="company_mail_username" value="{{ $settings['email']['company_mail_username'] ?? '' }}" />
                                            
                                        </div>

                                    </div>

                                    <div class="row fv-row mb-7">

                                        <div class="col-md-3 text-md-end">
                                            
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">Mail Password</span>
                                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Set the name of the store"></i>
                                            </label>
                                            
                                        </div>
                                        <div class="col-md-9">
                                            
                                            <input type="text" class="form-control form-control-solid" name="company_mail_password" id="company_mail_password" value="{{ $settings['email']['company_mail_password'] ?? '' }}" />
                                            
                                        </div>

                                    </div>

                                    <div class="row fv-row mb-7">

                                        <div class="col-md-3 text-md-end">
                                            
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">Mail Encryption</span>
                                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Set the name of the store"></i>
                                            </label>
                                            
                                        </div>
                                        <div class="col-md-9">
                                            
                                            <input type="text" class="form-control form-control-solid" name="company_mail_encryption" id="company_mail_encryption" value="{{ $settings['email']['company_mail_encryption'] ?? '' }}" />
                                            
                                        </div>

                                    </div>

                                    <div class="row fv-row mb-7">

                                        <div class="col-md-3 text-md-end">
                                            
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">Mail From Address</span>
                                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Set the name of the store"></i>
                                            </label>
                                            
                                        </div>
                                        <div class="col-md-9">
                                            
                                            <input type="text" class="form-control form-control-solid" name="company_mail_from_address" id="company_mail_from_address" value="{{ $settings['email']['company_mail_from_address'] ?? '' }}" />
                                            
                                        </div>

                                    </div>

                                    <div class="row fv-row mb-7">

                                        <div class="col-md-3 text-md-end">
                                            
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">Mail From Name</span>
                                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Set the name of the store"></i>
                                            </label>
                                            
                                        </div>
                                        <div class="col-md-9">
                                            
                                            <input type="text" class="form-control form-control-solid" name="company_mail_from_name" id="company_mail_from_name" value="{{ $settings['email']['company_mail_from_name'] ?? '' }}" />
                                            
                                        </div>

                                    </div>
                                                                        
                                    <div class="row">

                                        <div class="col-md-9 offset-md-3">
                                            
                                            <div class="separator mb-6"></div>
                                            
                                            <div class="d-flex justify-content-end">
                                                
                                                <button type="button" id="saveEmailSettingBtn" class="btn btn-primary">
                                                    <span class="indicator-label">Save</span>
                                                    <span class="indicator-progress">Please wait...
                                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                </button>
                                                
                                            </div>

                                        </div>

                                    </div>
                                    
                                </form>
                                
                            </div>
                            
                        </div>
                        
                    </div>
                    
                    <div class="tab-pane fade" id="kt_company_support_settings" role="tabpanel">
                        
                        <div class="card card-flush">
                            
                            <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                                
                                <div class="card-title">
                                    
                                    <h2>Company Support Settings</h2>
                                    
                                </div>
                                
                            </div>
                            
                            <div class="card-body pt-0">
                                
                                <form id="kt_company_support_settings_form" class="form" action="#">

                                    <div class="row fv-row mb-7">

                                        <div class="col-md-3 text-md-end">
                                            
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">Mobile</span>
                                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Set the name of the store"></i>
                                            </label>
                                            
                                        </div>
                                        <div class="col-md-9">
                                            
                                            <input type="text" class="form-control form-control-solid" name="company_mobile" id="company_mobile" value="{{ $settings['support']['company_mobile'] ?? '' }}" />
                                            
                                        </div>

                                    </div>

                                    <div class="row fv-row mb-7">

                                        <div class="col-md-3 text-md-end">
                                            
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">Email</span>
                                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Set the name of the store"></i>
                                            </label>
                                            
                                        </div>
                                        <div class="col-md-9">
                                            
                                            <input type="text" class="form-control form-control-solid" name="company_email" id="company_email" value="{{ $settings['support']['company_email'] ?? '' }}" />
                                            
                                        </div>

                                    </div>
                                                                                                            
                                    <div class="row">

                                        <div class="col-md-9 offset-md-3">
                                            
                                            <div class="separator mb-6"></div>
                                            
                                            <div class="d-flex justify-content-end">
                                                                                                
                                                <button type="button" id="saveSupportSettingBtn" class="btn btn-primary">
                                                    <span class="indicator-label">Save</span>
                                                    <span class="indicator-progress">Please wait...
                                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                </button>
                                                
                                            </div>

                                        </div>

                                    </div>
                                    
                                </form>
                                
                            </div>
                            
                        </div>
                        
                    </div>
                    
                </div>
                
            </div>
            
        </div>
        
    </div>        

@endsection

@section('custom-js')
    <script src="{{ asset('gapp') }}/js/custom/settings/setting-functions.js"></script>
@endsection