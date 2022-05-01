<div class="d-flex justify-content-end" data-kt-docs-table-toolbar="base">
                    
    <!-- <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">                                
        <span class="svg-icon svg-icon-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="black"></path>
            </svg>
        </span>
    Filter</button>

    <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px py-1" data-kt-menu="true" id="kt-toolbar-filter">
        
        <div class="px-7 py-5">
            <div class="fs-4 text-dark fw-bolder">Filter Options</div>
        </div>
        
        <div class="separator border-gray-200"></div>
        
        <div class="px-7 py-5">
            
            <div class="mb-10">
                
                <label class="form-label fs-5 fw-bold mb-3">Role Type:</label>
                
                <div class="d-flex flex-column flex-wrap fw-bold" data-kt-docs-table-filter="role">

                    <label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">

                        <input class="form-check-input" type="radio" name="role" value="all" checked="checked" name="all" id="all" checked="checked">

                        <span class="form-check-label text-gray-600">All</span>

                    </label>

                    @foreach ($roles as $role)
                        
                        <label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">

                            <input class="form-check-input" type="radio" name="role" value="{{ $role->name }}" id="role_{{ $role->id }}">

                            <span class="form-check-label text-gray-600">{{ ucfirst($role->name) }}</span>

                        </label>
                        
                    @endforeach                                                                                        
                </div>
                
            </div>
            
            <div class="d-flex justify-content-end">

                <button type="reset" class="btn btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true" data-kt-docs-table-filter="reset">Reset</button>

                <button type="submit" class="btn btn-primary" data-kt-menu-dismiss="true" data-kt-docs-table-filter="filter">Apply</button>

            </div>
            
        </div>
        
    </div> -->

    <button type="button" class="btn btn-primary me-3" id="kt_add_button" data-bs-toggle="modal" data-bs-target="#kt_modal_add">

        <span class="indicator-label">
            Add Permissions
        </span>

        <span class="indicator-progress">
            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
        </span>

    </button>                            
                                
    <div id="kt_datatable_exports"></div>                            

</div>