@extends('layouts.master')

@section('content')
        
    @include('admin.categories.partials._toolbar')

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
                        Edit Category</a>

                    </li>

                </ul>

                <form action="{{ route('admin.categories.update', $category->id) }}" enctype="multipart/form-data" method="post">

                    @csrf
                    @method('PUT')

                    <input type="hidden" name="category_id" value="{{ $category->id }}">

                    <div class="tab-content" id="myTabContent">
                        
                        <div class="tab-pane fade show active" id="kt_add_category" role="tabpanel">
                            
                            <div class="card card-flush">
                                
                                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                                    
                                    <div class="card-title">
                                        
                                        <h2>Edit Category</h2>
                                        
                                    </div>
                                    
                                </div>
                                
                                <div class="card-body pt-0">
                                                                                                    
                                    <div class="row fv-row mb-7">

                                        <div class="col-md-3 text-md-end">
                                            
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">Name</span>
                                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Enter category name."></i>
                                            </label>
                                            
                                        </div>

                                        <div class="col-md-9">
                                            
                                            <input type="text" class="form-control form-control-solid @error('name') is-invalid @enderror" name="name" id="name" value="{{ $category->name ?? '' }}" />

                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            
                                        </div>                                        

                                    </div>

                                    <div class="row fv-row mb-7">

                                        <div class="col-md-3 text-md-end">
                                            
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">Slug</span>
                                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Enter category slug name."></i>
                                            </label>
                                            
                                        </div>

                                        <div class="col-md-9">
                                            
                                            <input type="text" class="form-control form-control-solid" name="slug" id="slug" value="{{ $category->slug ?? '' }}" />

                                            @error('slug')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            
                                        </div>                                        

                                    </div>

                                    <div class="row fv-row mb-7">

                                        <div class="col-md-3 text-md-end">
                                            
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span>Parent Category</span>
                                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Select parent category."></i>
                                            </label>
                                            
                                        </div>

                                        <div class="col-md-9">
                                            
                                            <select class="form-select form-control form-select-solid" ata-hide-search="true" name="parent_id" id="parent_id" data-control="select2" data-placeholder="Select a parent cateogry">
                                                <option></option>
                                                @foreach ($categories as $cat)
                                                    <option value="{{ $cat->id }}" @if($category->parent_id == $cat->id) 'selected' @endif>{{ $cat->name }}</option>    
                                                @endforeach                                                    
                                            </select>                                            

                                            @error('parent_id')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                                                                    
                                        </div>                                        

                                    </div>
                                    
                                    
                                                                        
                                    <div class="row fv-row mb-7">

                                        <div class="col-md-3 text-md-end">
                                            
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">Image</span>
                                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Select category image."></i>
                                            </label>
                                            
                                        </div>

                                        <div class="col-md-9">

                                            @php
                                                $image = $category->image ?? '';
                                                $image_url = asset('storage/categories/'.$image);
                                            @endphp

                                            @if ($image)
                                                <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url({{ $image_url }}) !important;">                                                
                                            @else
                                                <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url({{ $image_url }})">
                                            @endif                                                                                                                               

                                                <div class="image-input-wrapper w-125px h-125px"></div>                                                
                                                
                                                <label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                                    data-kt-image-input-action="change"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-dismiss="click"
                                                    title="Change Image">
                                                    <i class="bi bi-pencil-fill fs-7"></i>
                                                    
                                                    <input type="file" name="image" accept=".png, .jpg, .jpeg" />
                                                    <input type="hidden" name="image_remove" />
                                                    
                                                </label>                                                
                                                
                                                <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                                    data-kt-image-input-action="cancel"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-dismiss="click"
                                                    title="Cancel Image">
                                                    <i class="bi bi-x fs-2"></i>
                                                </span>
                                                                                                
                                                <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                                    data-kt-image-input-action="remove"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-dismiss="click"
                                                    title="Remove Image">
                                                    <i class="bi bi-x fs-2"></i>
                                                </span>
                                                
                                            </div>      
                                            
                                            @error('image')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                        </div>                                        

                                    </div>

                                    <div class="row fv-row mb-7">

                                        <div class="col-md-3 text-md-end">
                                            
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">Active/InActive</span>
                                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"></i>
                                            </label>
                                            
                                        </div>

                                        <div class="col-md-9" style="margin-top: 10px;">
                                            
                                            <input class="form-check-input" type="checkbox" @if($category->is_active) checked  @endif name="is_active" />
                                            <span class="form-check-label">Active</span>                                            
                                            
                                        </div>                                        

                                    </div>                                    
                                    
                                                                                                            
                                    <div class="row">

                                        <div class="col-md-9 offset-md-3">
                                            
                                            <div class="separator mb-6"></div>
                                            
                                            <div class="d-flex justify-content-end">
                                                
                                                <button type="submit"class="btn btn-primary">
                                                    <span class="indicator-label">Update</span>
                                                    <span class="indicator-progress">Please wait...
                                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                </button>

                                                <a href="{{ route('admin.categories.index') }}" class="btn btn-primary ms-2">Back</a>                                            

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