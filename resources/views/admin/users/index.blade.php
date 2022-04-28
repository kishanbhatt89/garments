@extends('layouts.master')

@section('content')
        
    <div class="toolbar" id="kt_toolbar">
        
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack justify-content-center">
            
            <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                
                <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Users List</h1>
                
                <span class="h-20px border-gray-300 border-start mx-4"></span>
                
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Dashboard</a>
                    </li>
                    
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-300 w-5px h-2px"></span>
                    </li>
                    
                    <li class="breadcrumb-item text-muted">User Management</li>
                    
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-300 w-5px h-2px"></span>
                    </li>                    
                    
                    <li class="breadcrumb-item text-dark">Users List</li>
                    
                </ul>
                
            </div>
            
            <!-- <div class="d-flex align-items-center gap-2 gap-lg-3">
                
                <div class="m-0">
                 
                    <a href="#" class="btn btn-sm btn-flex btn-light btn-active-primary fw-bolder" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                    
                    <span class="svg-icon svg-icon-5 svg-icon-gray-500 me-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="black" />
                        </svg>
                    </span>
                    Filter</a>
                    
                    <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" id="kt_menu_6220ed9a76bfe">
                        
                        <div class="px-7 py-5">
                            <div class="fs-5 text-dark fw-bolder">Filter Options</div>
                        </div>
                        
                        <div class="separator border-gray-200"></div>
                        
                        <div class="px-7 py-5">
                            
                            <div class="mb-10">
                                
                                <label class="form-label fw-bold">Status:</label>
                            
                                <div>
                                    <select class="form-select form-select-solid" data-kt-select2="true" data-placeholder="Select option" data-dropdown-parent="#kt_menu_6220ed9a76bfe" data-allow-clear="true">
                                        <option></option>
                                        <option value="1">Approved</option>
                                        <option value="2">Pending</option>
                                        <option value="2">In Process</option>
                                        <option value="2">Rejected</option>
                                    </select>
                                </div>
                                
                            </div>
                            
                            <div class="mb-10">
                                
                                <label class="form-label fw-bold">Member Type:</label>
                                
                                <div class="d-flex">
                                    
                                    <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                        <input class="form-check-input" type="checkbox" value="1" />
                                        <span class="form-check-label">Author</span>
                                    </label>
                                    
                                    <label class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="2" checked="checked" />
                                        <span class="form-check-label">Customer</span>
                                    </label>
                                    
                                </div>
                                
                            </div>
                            
                            <div class="mb-10">
                                
                                <label class="form-label fw-bold">Notifications:</label>
                                
                                <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="" name="notifications" checked="checked" />
                                    <label class="form-check-label">Enabled</label>
                                </div>
                                
                            </div>
                            
                            <div class="d-flex justify-content-end">
                                <button type="reset" class="btn btn-sm btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true">Reset</button>
                                <button type="submit" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">Apply</button>
                            </div>
                            
                        </div>
                        
                    </div>
                    
                </div>
                
                <a href="../../demo1/dist/.html" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">Create</a>
                
            </div> -->
            
        </div>
        
    </div>
    
    <div class="post d-flex flex-column-fluid" id="kt_post">
        
        <div id="kt_content_container" class="container-xxl">
         
            <div class="card">
                                                
                <div class="card-body py-4">
                    
                    <div class="d-flex flex-stack mb-5">
    
                        <div class="d-flex align-items-center position-relative my-1">
        
                            <input type="text" data-kt-docs-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Users"/>

                        </div>
    
                        <div class="d-flex justify-content-end" data-kt-docs-table-toolbar="base">
                    
                            <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">                                
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="black"></path>
                                    </svg>
                                </span>
                            Filter</button>

                            <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px py-1" data-kt-menu="true" id="kt-toolbar-filter">
                                <!--begin::Header-->
                                <div class="px-7 py-5">
                                    <div class="fs-4 text-dark fw-bolder">Filter Options</div>
                                </div>
                                <!--end::Header-->
                                <!--begin::Separator-->
                                <div class="separator border-gray-200"></div>
                                <!--end::Separator-->
                                <!--begin::Content-->
                                <div class="px-7 py-5">
                                    <!--begin::Input group-->
                                    <div class="mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label fs-5 fw-bold mb-3">Payment Type:</label>
                                        <!--end::Label-->
                                        <!--begin::Options-->
                                        <div class="d-flex flex-column flex-wrap fw-bold" data-kt-docs-table-filter="payment_type">
                                            <!--begin::Option-->
                                            <label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                <input class="form-check-input" type="radio" name="payment_type" value="all" checked="checked" wtx-context="602F7FA1-AB44-42CC-8D8A-77EAC525AE2F">
                                                <span class="form-check-label text-gray-600">All</span>
                                            </label>
                                            <!--end::Option-->
                                            <!--begin::Option-->
                                            <label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                <input class="form-check-input" type="radio" name="payment_type" value="visa" wtx-context="CF900BC1-0587-4037-9459-2087D146D9C8">
                                                <span class="form-check-label text-gray-600">Visa</span>
                                            </label>
                                            <!--end::Option-->
                                            <!--begin::Option-->
                                            <label class="form-check form-check-sm form-check-custom form-check-solid mb-3">
                                                <input class="form-check-input" type="radio" name="payment_type" value="mastercard" wtx-context="4C50D3D6-6B9B-4BD2-8D90-93BC9FC3D0A3">
                                                <span class="form-check-label text-gray-600">Mastercard</span>
                                            </label>
                                            <!--end::Option-->
                                            <!--begin::Option-->
                                            <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" name="payment_type" value="americanexpress" wtx-context="518F83F4-0296-4CE5-8E16-AFE1D7EE3325">
                                                <span class="form-check-label text-gray-600">American Express</span>
                                            </label>
                                            <!--end::Option-->
                                        </div>
                                        <!--end::Options-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Actions-->
                                    <div class="d-flex justify-content-end">
                                        <button type="reset" class="btn btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true" data-kt-docs-table-filter="reset">Reset</button>
                                        <button type="submit" class="btn btn-primary" data-kt-menu-dismiss="true" data-kt-docs-table-filter="filter">Apply</button>
                                    </div>
                                    <!--end::Actions-->
                                </div>
                                <!--end::Content-->
                            </div>
        
                            <button type="button" class="btn btn-primary me-3" data-bs-toggle="tooltip" title="Coming Soon">Add Users</button>

                            <!-- <button type="button" class="btn btn-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <span class="svg-icon svg-icon-1 position-absolute ms-4"></span>
                                Export Report
                            </button>                            

                            <div id="kt_datatable_example_1_export_menu" class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-200px py-4" data-kt-menu="true">
                            
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-export="copy">
                                        Copy to clipboard
                                    </a>
                                </div>
                            
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-export="excel">
                                        Export as Excel
                                    </a>
                                </div>
                            
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-export="csv">
                                        Export as CSV
                                    </a>
                                </div>
                            
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-export="pdf">
                                        Export as PDF
                                    </a>
                                </div>
                            
                            </div> -->
                            
                            <div id="kt_datatable_example_1_export"></div>

                            
        
                        </div>
    
                        <div class="d-flex justify-content-end align-items-center d-none" data-kt-docs-table-toolbar="selected">
                            
                            <div class="fw-bolder me-5">
                                <span class="me-2" data-kt-docs-table-select="selected_count"></span> Selected
                            </div>

                            <button type="button" class="btn btn-danger" data-kt-docs-table-select="delete_selected">Selection Action</button>      
                                                    
                        </div>
                        
                    </div>

                    <table id="kt_datatable_example_1" class="table align-middle table-row-dashed fs-6 gy-5">

                        <thead>

                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th class="w-10px pe-2">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                        <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_datatable_example_1 .form-check-input" value="1"/>
                                    </div>
                                </th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Created At</th>
                                <th>Updated At</th>                                
                                <th class="text-end min-w-100px">Actions</th>
                            </tr>

                        </thead>

                        <tbody class="text-gray-600 fw-bold">

                        </tbody>

                    </table>

                </div>
                
            </div>
            
        </div>
        
    </div>

@endsection

@section('custom-js')
    <script src="{{ asset('gapp') }}/js/custom/users/user-dataTable.js"></script>
@endsection