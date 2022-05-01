@extends('layouts.master')

@section('content')
        
    @include('admin.permissions.partials._toolbar')
    
    <div class="post d-flex flex-column-fluid" id="kt_post">
        
        <div id="kt_content_container" class="container-xxl">
         
            <div class="card">
                                                
                <div class="card-body py-4">
                    
                    <div class="d-flex flex-stack mb-5">
    
                        <div class="d-flex align-items-center position-relative my-1">
        
                            <input type="text" data-kt-docs-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Permissions"/>

                        </div>
    
                        @include('admin.permissions.partials._filter')
    
                        <div class="d-flex justify-content-end align-items-center d-none" data-kt-docs-table-toolbar="selected">
                            
                            <div class="fw-bolder me-5">
                                <span class="me-2" data-kt-docs-table-select="selected_count"></span> Selected
                            </div>

                            <button type="button" class="btn btn-danger" data-kt-docs-table-select="delete_selected">Selection Action</button>      
                                                    
                        </div>
                        
                    </div>

                    @include('admin.permissions.partials._table')

                </div>
                
            </div>
            
        </div>
        
    </div>

    @include('admin.permissions.partials._add')

    @include('admin.permissions.partials._edit')

@endsection

@section('custom-js')
    <script src="{{ asset('gapp') }}/js/custom/permissions/permission-dataTable.js"></script>
    <script src="{{ asset('gapp') }}/js/custom/permissions/permission-functions.js"></script>
    <script src="{{ asset('gapp') }}/js/custom/permissions/permission-utils.js"></script>
@endsection