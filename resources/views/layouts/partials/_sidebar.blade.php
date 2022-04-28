<div class="aside-menu flex-column-fluid">
    <!--begin::Aside Menu-->
    <div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="0">
        <!--begin::Menu-->
        <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500" id="#kt_aside_menu" data-kt-menu="true" data-kt-menu-expand="false">
            
            <div class="menu-item">
                <a class="menu-link {{ (request()->is('admin/dashboard')) ? 'active' : '' }}" href="{{ route('dashboard') }}" title="Dashboard Module" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                    <span class="menu-icon">
                        
                        <span class="svg-icon svg-icon-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect x="2" y="2" width="9" height="9" rx="2" fill="black"></rect>
                                <rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="black"></rect>
                                <rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="black"></rect>
                                <rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="black"></rect>
                            </svg>
                        </span>
                        
                    </span>
                    <span class="menu-title">Dashboard</span>
                </a>
            </div>

            <div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1 
                {{ ( request()->is('admin/users') || 
                   request()->is('admin/roles') ||
                   request()->is('admin/permissions') ) ? 'show' : '' }}">
                <span class="menu-link 
                {{ ( request()->is('admin/users') || 
                   request()->is('admin/roles') ||
                   request()->is('admin/permissions') ) ? 'active' : '' }}">
                    <span class="menu-icon">
                        
                        <span class="svg-icon svg-icon-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M6.28548 15.0861C7.34369 13.1814 9.35142 12 11.5304 12H12.4696C14.6486 12 16.6563 13.1814 17.7145 15.0861L19.3493 18.0287C20.0899 19.3618 19.1259 21 17.601 21H6.39903C4.87406 21 3.91012 19.3618 4.65071 18.0287L6.28548 15.0861Z" fill="black"></path>
                                <rect opacity="0.3" x="8" y="3" width="8" height="8" rx="4" fill="black"></rect>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-title">User Management</span>
                    <span class="menu-arrow" title="User Management Module" data-bs-toggle="tooltip" data-bs-trigger="hover"></span>
                </span>
                <div class="menu-sub menu-sub-accordion">
                    <div class="menu-item">
                        <a class="menu-link {{ (request()->is('admin/users')) ? 'active' : '' }}" href="{{ route('users.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Users</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link {{ (request()->is('admin/roles')) ? 'active' : '' }}" href="{{ route('roles.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Roles</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link {{ (request()->is('admin/permissions')) ? 'active' : '' }}" href="{{ route('permissions.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Permissions</span>
                        </a>
                    </div>
                </div>
            </div>
            
        </div>
        <!--end::Menu-->
    </div>
    <!--end::Aside Menu-->
</div>