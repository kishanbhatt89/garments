<div class="modal fade" id="kt_modal_add" tabindex="-1" aria-hidden="true" aria-label="Close">
                                
    <div class="modal-dialog modal-dialog-centered mw-750px">
        
        <div class="modal-content">
            
            <div class="modal-header">
                
                <h2 class="fw-bolder">Add a Client</h2>
                
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-modal-action="cancel">
                    
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                        </svg>
                    </span>

                </div>
                
            </div>
            
            <div class="modal-body scroll-y mx-lg-5 my-7">
                
                <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add" data-kt-scroll-wrappers="#kt_modal_add" data-kt-scroll-offset="300px">
                    
                    <div class="fv-row mb-10">
                    
                        <label class="fs-5 fw-bolder form-label mb-2">
                            <span class="required">Name</span>
                        </label>
                        
                        <input class="form-control form-control-solid" placeholder="Name" name="name" id="name" />
                        
                        <span class="invalid-feedback d-none name-error" role="alert">
                            <strong></strong>
                        </span>

                    </div>

                    <div class="fv-row mb-7">
                        
                        <label class="fs-5 fw-bolder form-label mb-2">
                            <span class="required">Email</span>
                        </label>
                        
                        <input type="email" class="form-control form-control-solid" placeholder="Email" name="email" id="email" />
                        
                        <span class="invalid-feedback d-none email-error" role="alert">
                            <strong></strong>
                        </span>
                        
                    </div>                
                    
                    <label class="required fw-bold fs-6 mb-5">Role</label>

                    <div class="fv-row mb-7 d-flex">                        
                    
                        <div class="d-flex fv-row">
                            
                            <div class="form-check form-check-custom form-check-solid me-3">
                                
                                <input class="form-check-input" name="role" type="radio" value="{{ $role->name }}" id="role" checked  />
                                
                                <label class="form-check-label" for="role">
                                    <div class="fw-bolder text-gray-800">{{ ucfirst($role->name) }}</div>                                        
                                </label>

                            </div>
                            
                        </div>                            
                                                                        
                    </div>
                    <div class="r-error d-none mb-4">
                            <span class="invalid-feedback d-none role-error" role="alert">
                                <strong></strong>
                            </span>                                              
                        </div>

                    <div class="fv-row mb-7">
                        
                        <label class="fs-5 fw-bolder form-label mb-2">
                            <span class="required">Password</span>
                        </label>
                        
                        <input type="password" class="form-control form-control-solid" placeholder="Password" name="password" id="password" />
                        
                        <span class="invalid-feedback d-none password-error" role="alert">
                            <strong></strong>
                        </span>
                        
                    </div>    

                    <div class="fv-row mb-7">
                        
                        <label class="fs-5 fw-bolder form-label mb-2">
                            <span class="required">Confirm Password</span>
                        </label>
                        
                        <input type="password" class="form-control form-control-solid" placeholder="Confirm Password" name="password_confirmation" id="password_confirmation" />                                                
                        
                    </div>    

                    <div class="fv-row mb-7">
                        
                        <label class="fs-5 fw-bolder form-label mb-2">
                            <span class="required">Mobile</span>
                        </label>
                        
                        <input type="text" class="form-control form-control-solid" placeholder="Mobile" name="mobile" id="mobile" />
                        
                        <span class="invalid-feedback d-none mobile-error" role="alert">
                            <strong></strong>
                        </span>
                        
                    </div>    

                    <div class="fv-row mb-7">
                        
                        <label class="fs-5 fw-bolder form-label mb-2">
                            <span class="required">Designation</span>
                        </label>
                        
                        <input type="text" class="form-control form-control-solid" placeholder="Designation" name="designation" id="designation" />
                        
                        <span class="invalid-feedback d-none designation-error" role="alert">
                            <strong></strong>
                        </span>
                        
                    </div>    

                    <div class="fv-row mb-7">
                        
                        <label class="fs-5 fw-bolder form-label mb-2">
                            <span class="required">Address</span>
                        </label>
                                                
                        <textarea placeholder="Address" name="address" id="address" class="form-control form-control-solid" rows="5"></textarea>
                        
                        <span class="invalid-feedback d-none address-error" role="alert">
                            <strong></strong>
                        </span>
                        
                    </div>

                </div>
                                                                
                <div class="text-center pt-15">

                    <button type="button" class="btn btn-light me-3" data-kt-modal-action="cancel">Cancel</button>

                    <button type="button" class="btn btn-primary me-3" id="saveBtn">

                        <span class="indicator-label">
                            Submit
                        </span>

                        <span class="indicator-progress">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>

                    </button>                                                    

                </div>

            </div>
            
        </div>
        
    </div>                                
    
</div>