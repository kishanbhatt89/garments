
        
    <div class="modal-dialog modal-dialog-centered mw-750px">
        
        <div class="modal-content">
            
            <div class="modal-header">
                
                <h2 class="fw-bolder">Edit a Permission</h2>
                
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-modal-action="cancel">
                    
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                        </svg>
                    </span>

                </div>
                
            </div>

            <input type="hidden" id="existing_permission_name" value="{{ $permission->name }}">
            
            <div class="modal-body scroll-y mx-lg-5 my-7">
            
                <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_edit" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_edit" data-kt-scroll-wrappers="#kt_modal_edit" data-kt-scroll-offset="300px">
                    
                    <div class="fv-row mb-10">
                        
                        <label class="fs-5 fw-bolder form-label mb-2">
                            <span class="required">Permission name</span>
                        </label>
                        
                        <input class="form-control form-control-solid" placeholder="Enter a permission name" name="name" id="permission_name" value="{{ $permission->name }}" />
                        
                        <span class="invalid-feedback d-none permission-name-error" role="alert">
                            <strong></strong>
                        </span>

                    </div>

                    <input type="hidden" name="permission_id" id="permission_id" value="{{ $permission->id }}">
                                                
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

let updateButton = document.querySelector("#updateBtn");

updateButton.addEventListener("click", function(e) {

    e.preventDefault();
    
    updateButton.setAttribute("data-kt-indicator", "on");

    let name = $("#permission_name").val();    
    let id = $("#permission_id").val();   
    
    let existing_permission_name = $('#existing_permission_name').val();

    update(name, id, existing_permission_name)
    
});


</script>