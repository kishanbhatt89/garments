<div class="modal fade" id="kt_modal_add" tabindex="-1" aria-hidden="true" aria-label="Close">
                                
    <div class="modal-dialog modal-dialog-centered mw-750px">
        
        <div class="modal-content">
            
            <div class="modal-header">
                
                <h2 class="fw-bolder">Add a Role</h2>
                
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
                            <span class="required">Role name</span>
                        </label>
                        
                        <input class="form-control form-control-solid" placeholder="Enter a role name" name="name" id="name" />
                        
                        <span class="invalid-feedback d-none name-error" role="alert">
                            <strong></strong>
                        </span>

                    </div>

                    <div class="fv-row">
                        
                        <label class="fs-5 fw-bolder form-label mb-2">Role Permissions</label>
                        
                        <div class="table-responsive">
                            
                            <table class="table align-middle table-row-dashed fs-6 gy-5">
                                
                                <tbody class="text-gray-600 fw-bold">
                                    
                                    <tr>
                                        
                                        <td class="text-gray-800 text-left">User Management</td>
                                        
                                        <td>
                                            
                                            <div class="d-flex">
                                                
                                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-10">
                                                    <input class="form-check-input" type="checkbox" value="user_management-create" name="user_management-create" />
                                                    <span class="form-check-label">Create</span>
                                                </label>
                                                
                                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-10">
                                                    <input class="form-check-input" type="checkbox" value="user_management-read" name="user_management-read" />
                                                    <span class="form-check-label">Read</span>
                                                </label>
                                                
                                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-10">
                                                    <input class="form-check-input" type="checkbox" value="user_management-update" name="user_management-update" />
                                                    <span class="form-check-label">Update</span>
                                                </label>

                                                <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="user_management-delete" name="user_management-delete" />
                                                    <span class="form-check-label">Delete</span>
                                                </label>

                                            </div>
                                            
                                        </td>
                                        
                                    </tr>

                                    <tr>
                                        
                                        <td class="text-gray-800 text-left">Role Management</td>
                                        
                                        <td>
                                            
                                            <div class="d-flex">
                                                
                                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-10">
                                                    <input class="form-check-input" type="checkbox" value="role_management-create" name="role_management-create" />
                                                    <span class="form-check-label">Create</span>
                                                </label>
                                                
                                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-10">
                                                    <input class="form-check-input" type="checkbox" value="role_management-read" name="role_management-read" />
                                                    <span class="form-check-label">Read</span>
                                                </label>
                                                
                                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-10">
                                                    <input class="form-check-input" type="checkbox" value="role_management-update" name="role_management-update" />
                                                    <span class="form-check-label">Update</span>
                                                </label>

                                                <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="role_management-delete" name="role_management-delete" />
                                                    <span class="form-check-label">Delete</span>
                                                </label>

                                            </div>
                                            
                                        </td>
                                        
                                    </tr>

                                    <tr>
                                        
                                        <td class="text-gray-800 text-left">Permission Management</td>
                                        
                                        <td>
                                            
                                            <div class="d-flex">
                                                
                                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-10">
                                                    <input class="form-check-input" type="checkbox" value="permission_management-create" name="permission_management-create" />
                                                    <span class="form-check-label">Create</span>
                                                </label>
                                                
                                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-10">
                                                    <input class="form-check-input" type="checkbox" value="permission_management-read" name="permission_management-read" />
                                                    <span class="form-check-label">Read</span>
                                                </label>
                                                
                                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-10">
                                                    <input class="form-check-input" type="checkbox" value="permission_management-update" name="permission_management-update" />
                                                    <span class="form-check-label">Update</span>
                                                </label>

                                                <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="permission_management-delete" name="permission_management-delete" />
                                                    <span class="form-check-label">Delete</span>
                                                </label>

                                            </div>
                                            
                                        </td>
                                        
                                    </tr>
                                    
                                </tbody>

                            </table>

                        </div>

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