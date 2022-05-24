<div class="modal-dialog modal-dialog-centered mw-750px">
    
    <div class="modal-content">
        
        <div class="modal-header">
            
            <h2 class="fw-bolder">Edit a Role</h2>
            
            <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-modal-action="cancel">
                
                <span class="svg-icon svg-icon-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                        <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                    </svg>
                </span>

            </div>
            
        </div>

        <input type="hidden" id="existing_role_name" value="{{ $role->name }}">
        
        <div class="modal-body scroll-y mx-lg-5 my-7">
        
            <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_edit" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_edit" data-kt-scroll-wrappers="#kt_modal_edit" data-kt-scroll-offset="300px">
                
                <div class="fv-row mb-10">
                    
                    <label class="fs-5 fw-bolder form-label mb-2">
                        <span class="required">Role name</span>
                    </label>
                    
                    <input class="form-control form-control-solid" placeholder="Enter a role name" name="name" id="role_name" value="{{ $role->name }}" />
                    
                    <span class="invalid-feedback d-none role-name-error" role="alert">
                        <strong></strong>
                    </span>

                </div>

                <div class="fv-row">
                    
                    <label class="fs-5 fw-bolder form-label mb-2">Role Permissions</label>
                    
                    <div class="table-responsive">
                        
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            
                            <tbody class="text-gray-600 fw-bold">
                                
                                <tr>
                                    
                                    <td class="text-gray-800 text-left">Employee Management</td>
                                    
                                    <td>
                                        
                                        <div class="d-flex">
                                            
                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-10">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    value="employee_management-create" 
                                                    name="employee_management-create" 
                                                    @if($role['permissions']->contains('name','employee_management-create')) checked @endif                                              
                                                    />
                                                <span class="form-check-label">Create</span>
                                            </label>
                                            
                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-10">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    value="employee_management-read" 
                                                    name="employee_management-read" 
                                                    @if($role['permissions']->contains('name','employee_management-read')) checked @endif
                                                    />
                                                <span class="form-check-label">Read</span>
                                            </label>
                                            
                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-10">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    value="employee_management-update" 
                                                    name="employee_management-update" 
                                                    @if($role['permissions']->contains('name','employee_management-update')) checked @endif
                                                    />
                                                <span class="form-check-label">Update</span>
                                            </label>

                                            <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    value="employee_management-delete" 
                                                    name="employee_management-delete" 
                                                    @if($role['permissions']->contains('name','employee_management-delete')) checked @endif
                                                    />
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
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    value="role_management-create" 
                                                    name="role_management-create" 
                                                    @if($role['permissions']->contains('name','role_management-create')) checked @endif                                              
                                                    />
                                                <span class="form-check-label">Create</span>
                                            </label>
                                            
                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-10">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    value="role_management-read" 
                                                    name="role_management-read" 
                                                    @if($role['permissions']->contains('name','role_management-read')) checked @endif
                                                    />
                                                <span class="form-check-label">Read</span>
                                            </label>
                                            
                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-10">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    value="role_management-update" 
                                                    name="role_management-update" 
                                                    @if($role['permissions']->contains('name','role_management-update')) checked @endif
                                                    />
                                                <span class="form-check-label">Update</span>
                                            </label>

                                            <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    value="role_management-delete" 
                                                    name="role_management-delete" 
                                                    @if($role['permissions']->contains('name','role_management-delete')) checked @endif
                                                    />
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
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    value="permission_management-create" 
                                                    name="permission_management-create" 
                                                    @if($role['permissions']->contains('name','permission_management-create')) checked @endif                                              
                                                    />
                                                <span class="form-check-label">Create</span>
                                            </label>
                                            
                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-10">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    value="permission_management-read" 
                                                    name="permission_management-read" 
                                                    @if($role['permissions']->contains('name','permission_management-read')) checked @endif
                                                    />
                                                <span class="form-check-label">Read</span>
                                            </label>
                                            
                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-10">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    value="permission_management-update" 
                                                    name="permission_management-update" 
                                                    @if($role['permissions']->contains('name','permission_management-update')) checked @endif
                                                    />
                                                <span class="form-check-label">Update</span>
                                            </label>

                                            <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    value="permission_management-delete" 
                                                    name="permission_management-delete" 
                                                    @if($role['permissions']->contains('name','permission_management-delete')) checked @endif
                                                    />
                                                <span class="form-check-label">Delete</span>
                                            </label>

                                        </div>
                                        
                                    </td>
                                    
                                </tr>

                                <tr>
                                    
                                    <td class="text-gray-800 text-left">Client Management</td>
                                    
                                    <td>
                                        
                                        <div class="d-flex">
                                            
                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-10">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    value="client_management-create" 
                                                    name="client_management-create" 
                                                    @if($role['permissions']->contains('name','client_management-create')) checked @endif                                              
                                                    />
                                                <span class="form-check-label">Create</span>
                                            </label>
                                            
                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-10">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    value="client_management-read" 
                                                    name="client_management-read" 
                                                    @if($role['permissions']->contains('name','client_management-read')) checked @endif
                                                    />
                                                <span class="form-check-label">Read</span>
                                            </label>
                                            
                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-10">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    value="client_management-update" 
                                                    name="client_management-update" 
                                                    @if($role['permissions']->contains('name','client_management-update')) checked @endif
                                                    />
                                                <span class="form-check-label">Update</span>
                                            </label>

                                            <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    value="client_management-delete" 
                                                    name="client_management-delete" 
                                                    @if($role['permissions']->contains('name','client_management-delete')) checked @endif
                                                    />
                                                <span class="form-check-label">Delete</span>
                                            </label>

                                        </div>
                                        
                                    </td>
                                    
                                </tr>

                                <!--
                                <tr>
                                    
                                    <td class="text-gray-800 text-left">Subscription Management</td>
                                    
                                    <td>
                                        
                                        <div class="d-flex">
                                            
                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-10">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    value=subscription_management-create" 
                                                    name="subscription_management-create" 
                                                    @if($role['permissions']->contains('name','subscription_management-create')) checked @endif                                              
                                                    />
                                                <span class="form-check-label">Create</span>
                                            </label>
                                            
                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-10">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    value="subscription_management-read" 
                                                    name="subscription_management-read" 
                                                    @if($role['permissions']->contains('name','subscription_management-read')) checked @endif
                                                    />
                                                <span class="form-check-label">Read</span>
                                            </label>
                                            
                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-10">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    value="subscription_management-update" 
                                                    name="subscription_management-update" 
                                                    @if($role['permissions']->contains('name','subscription_management-update')) checked @endif
                                                    />
                                                <span class="form-check-label">Update</span>
                                            </label>

                                            <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    value="subscription_management-delete" 
                                                    name="subscription_management-delete" 
                                                    @if($role['permissions']->contains('name','subscription_management-delete')) checked @endif
                                                    />
                                                <span class="form-check-label">Delete</span>
                                            </label>

                                        </div>
                                        
                                    </td>
                                    
                                </tr>
                                -->
                                
                                <tr>
                                    
                                    <td class="text-gray-800 text-left">State Management</td>
                                    
                                    <td>
                                        
                                        <div class="d-flex">
                                            
                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-10">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    value=state_management-create" 
                                                    name="state_management-create" 
                                                    @if($role['permissions']->contains('name','state_management-create')) checked @endif                                              
                                                    />
                                                <span class="form-check-label">Create</span>
                                            </label>
                                            
                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-10">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    value="state_management-read" 
                                                    name="state_management-read" 
                                                    @if($role['permissions']->contains('name','state_management-read')) checked @endif
                                                    />
                                                <span class="form-check-label">Read</span>
                                            </label>
                                            
                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-10">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    value="state_management-update" 
                                                    name="state_management-update" 
                                                    @if($role['permissions']->contains('name','state_management-update')) checked @endif
                                                    />
                                                <span class="form-check-label">Update</span>
                                            </label>

                                            <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    value="state_management-delete" 
                                                    name="state_management-delete" 
                                                    @if($role['permissions']->contains('name','state_management-delete')) checked @endif
                                                    />
                                                <span class="form-check-label">Delete</span>
                                            </label>

                                        </div>
                                        
                                    </td>
                                    
                                </tr>

                                <tr>
                                    
                                    <td class="text-gray-800 text-left">City Management</td>
                                    
                                    <td>
                                        
                                        <div class="d-flex">
                                            
                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-10">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    value=city_management-create" 
                                                    name="city_management-create" 
                                                    @if($role['permissions']->contains('name','city_management-create')) checked @endif                                              
                                                    />
                                                <span class="form-check-label">Create</span>
                                            </label>
                                            
                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-10">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    value="city_management-read" 
                                                    name="city_management-read" 
                                                    @if($role['permissions']->contains('name','city_management-read')) checked @endif
                                                    />
                                                <span class="form-check-label">Read</span>
                                            </label>
                                            
                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-10">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    value="city_management-update" 
                                                    name="city_management-update" 
                                                    @if($role['permissions']->contains('name','city_management-update')) checked @endif
                                                    />
                                                <span class="form-check-label">Update</span>
                                            </label>

                                            <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    value="city_management-delete" 
                                                    name="city_management-delete" 
                                                    @if($role['permissions']->contains('name','city_management-delete')) checked @endif
                                                    />
                                                <span class="form-check-label">Delete</span>
                                            </label>

                                        </div>
                                        
                                    </td>
                                    
                                </tr>

                                <tr>
                                    
                                    <td class="text-gray-800 text-left">Designation Management</td>
                                    
                                    <td>
                                        
                                        <div class="d-flex">
                                            
                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-10">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    value=designation_management-create" 
                                                    name="designation_management-create" 
                                                    @if($role['permissions']->contains('name','designation_management-create')) checked @endif                                              
                                                    />
                                                <span class="form-check-label">Create</span>
                                            </label>
                                            
                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-10">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    value="designation_management-read" 
                                                    name="designation_management-read" 
                                                    @if($role['permissions']->contains('name','designation_management-read')) checked @endif
                                                    />
                                                <span class="form-check-label">Read</span>
                                            </label>
                                            
                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-10">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    value="designation_management-update" 
                                                    name="designation_management-update" 
                                                    @if($role['permissions']->contains('name','designation_management-update')) checked @endif
                                                    />
                                                <span class="form-check-label">Update</span>
                                            </label>

                                            <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    value="designation_management-delete" 
                                                    name="designation_management-delete" 
                                                    @if($role['permissions']->contains('name','designation_management-delete')) checked @endif
                                                    />
                                                <span class="form-check-label">Delete</span>
                                            </label>

                                        </div>
                                        
                                    </td>
                                    
                                </tr>

                                <tr>
                                    
                                    <td class="text-gray-800 text-left">GST Profile Management</td>
                                    
                                    <td>
                                        
                                        <div class="d-flex">
                                            
                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-10">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    value=gst_profile_management-create" 
                                                    name="gst_profile_management-create" 
                                                    @if($role['permissions']->contains('name','gst_profile_management-create')) checked @endif                                              
                                                    />
                                                <span class="form-check-label">Create</span>
                                            </label>
                                            
                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-10">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    value="gst_profile_management-read" 
                                                    name="gst_profile_management-read" 
                                                    @if($role['permissions']->contains('name','gst_profile_management-read')) checked @endif
                                                    />
                                                <span class="form-check-label">Read</span>
                                            </label>
                                            
                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-10">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    value="gst_profile_management-update" 
                                                    name="gst_profile_management-update" 
                                                    @if($role['permissions']->contains('name','gst_profile_management-update')) checked @endif
                                                    />
                                                <span class="form-check-label">Update</span>
                                            </label>

                                            <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    value="gst_profile_management-delete" 
                                                    name="gst_profile_management-delete" 
                                                    @if($role['permissions']->contains('name','gst_profile_management-delete')) checked @endif
                                                    />
                                                <span class="form-check-label">Delete</span>
                                            </label>

                                        </div>
                                        
                                    </td>
                                    
                                </tr>

                                <tr>
                                    
                                    <td class="text-gray-800 text-left">Setting Management</td>
                                    
                                    <td>
                                        
                                        <div class="d-flex">
                                            
                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-10">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    valuesettingmanagement-create" 
                                                    name="setting_management-create" 
                                                    @if($role['permissions']->contains('name','setting_management-create')) checked @endif                                              
                                                    />
                                                <span class="form-check-label">Create</span>
                                            </label>
                                            
                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-10">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    value="setting_management-read" 
                                                    name="setting_management-read" 
                                                    @if($role['permissions']->contains('name','setting_management-read')) checked @endif
                                                    />
                                                <span class="form-check-label">Read</span>
                                            </label>
                                            
                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-10">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    value="setting_management-update" 
                                                    name="setting_management-update" 
                                                    @if($role['permissions']->contains('name','setting_management-update')) checked @endif
                                                    />
                                                <span class="form-check-label">Update</span>
                                            </label>

                                            <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    value="setting_management-delete" 
                                                    name="setting_management-delete" 
                                                    @if($role['permissions']->contains('name','setting_management-delete')) checked @endif
                                                    />
                                                <span class="form-check-label">Delete</span>
                                            </label>

                                        </div>
                                        
                                    </td>
                                    
                                </tr>
                                
                            </tbody>

                        </table>

                    </div>

                </div>   

                <input type="hidden" name="role_id" id="role_id" value="{{ $role->id }}">
                                            
            </div>
                                    
            <div class="text-center pt-15">

                <button type="button" class="btn btn-light me-3" data-kt-modal-action="cancel">Cancel</button>

                <button type="button" class="btn btn-primary me-3" id="updateBtn">

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

<script>    

    $('#updateBtn').on('click', function(e) {

        e.preventDefault();
                
        $('#updateBtn').attr("data-kt-indicator", "on");

        let permissionsArray = [];

        $('input[type="checkbox"]:checked').each(function() {
            permissionsArray.push($(this).val());
        });        

        let name = $("#role_name").val();    
        let id = $("#role_id").val();    

        let existing_role_name = $('#existing_role_name').val();

        update(name, id, permissionsArray, existing_role_name)
        
    });

</script>