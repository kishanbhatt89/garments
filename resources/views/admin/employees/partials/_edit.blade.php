<div class="modal-dialog modal-dialog-centered mw-750px">
    
    <div class="modal-content">
        
        <div class="modal-header">
            
            <h2 class="fw-bolder">Edit a Employee</h2>
            
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
                        
                        <input class="form-control form-control-solid" placeholder="Name" name="name" id="employee_name" value="{{ $user->name }}" />
                        
                        <span class="invalid-feedback d-none employee_name-error" role="alert">
                            <strong></strong>
                        </span>

                    </div>

                    <div class="fv-row mb-7">
                        
                        <label class="fs-5 fw-bolder form-label mb-2">
                            <span class="required">Email</span>
                        </label>
                        
                        <input type="email" class="form-control form-control-solid" placeholder="Email" name="email" id="employee_email" value="{{ $user->email }}" />
                        
                        <span class="invalid-feedback d-none employee_email-error" role="alert">
                            <strong></strong>
                        </span>
                        
                    </div>              
                    
                    <div class="fv-row mb-7">
                        
                        <label class="fs-5 fw-bolder form-label mb-2">
                            <span class="required">Designation</span>
                        </label>

                        <select class="form-select form-control form-select-solid" data-allow-clear="true" name="designations_id" id="employee_designations_id" data-control="select2" data-placeholder="Select a designation">
                            <option></option>
                            @foreach ($designations as $designation)
                                <option value="{{ $designation->id }}" @if($user->designation->id == $designation->id) selected @endif>{{ $designation->name }}</option>    
                            @endforeach                                                    
                        </select>                                            
                        
                        <span class="invalid-feedback d-none employee_designation-error" role="alert">
                            <strong></strong>
                        </span>
                        
                    </div>
                    
                    <div class="fv-row mb-7">
                        
                        <label class="fs-5 fw-bolder form-label mb-2">
                            <span class="required">State</span>
                        </label>

                        <select class="form-select form-control form-select-solid" data-allow-clear="true" name="states_id" id="employee_states_id" data-control="select2" data-placeholder="Select a state">
                            <option></option>
                            @foreach ($states as $state)
                                <option value="{{ $state->id }}" @if($user->state->id == $state->id) selected @endif>{{ $state->name }}</option>    
                            @endforeach                                                    
                        </select>                                            
                        
                        <span class="invalid-feedback d-none employee_state-error" role="alert">
                            <strong></strong>
                        </span>
                        
                    </div>

                    <div class="fv-row mb-7">
                        
                        <label class="fs-5 fw-bolder form-label mb-2">
                            <span class="required">City</span>
                        </label>

                        <select class="form-select form-control form-select-solid" data-allow-clear="true" name="cities_id" id="employee_cities_id" data-control="select2" data-placeholder="Select a city">
                            <option></option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}" @if($user->city->id == $city->id) selected @endif>{{ $city->name }}</option>    
                            @endforeach                                                    
                        </select>                                            
                        
                        <span class="invalid-feedback d-none employee_city-error" role="alert">
                            <strong></strong>
                        </span>
                        
                    </div>                                    
                    
                    <div class="fv-row mb-7">
                        
                        <label class="fs-5 fw-bolder form-label mb-2">
                            <span class="required">Mobile</span>
                        </label>
                        
                        <input type="text" class="form-control form-control-solid" placeholder="Mobile" name="employee_mobile" id="employee_mobile" value="{{ $user->userDetails->mobile }}" />
                        
                        <span class="invalid-feedback d-none employee_mobile-error" role="alert">
                            <strong></strong>
                        </span>
                        
                    </div>                           

                    <div class="fv-row mb-7">
                        
                        <label class="fs-5 fw-bolder form-label mb-2">
                            <span class="required">Address</span>
                        </label>
                                                
                        <textarea placeholder="Address" name="employee_address" id="employee_address" class="form-control form-control-solid" rows="5">{{ $user->userDetails->address }}</textarea>
                        
                        <span class="invalid-feedback d-none employee_address-error" role="alert">
                            <strong></strong>
                        </span>
                        
                    </div>

                    <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">

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

        let name = $("#employee_name").val();    
        let email = $("#employee_email").val();    

        let designation = $('#employee_designations_id').val();
        let state = $('#employee_states_id').val();
        let city = $('#employee_cities_id').val();
        
        let mobile = $("#employee_mobile").val();            
        let address = $("#employee_address").val();    

        let id = $("#user_id").val();            
        
        update(id, name, email, designation, state, city, mobile, address);
        
    });

    //let cancelBtnEdit = document.querySelectorAll('[data-kt-modal-action="cancel"]');
    document.querySelectorAll('[data-kt-modal-action="cancel"]').forEach( function(cancelButtonEdit) {
        cancelButtonEdit.addEventListener('click', e => {
            e.preventDefault();            
            $('#kt_modal_edit').modal('hide');
        })
    });

</script>