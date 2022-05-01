"use strict";

let KTDatatablesServerSide = function () {
    
    let table;
    let dt;
    let filterPermission;
    
    let initDatatable = function () {

        dt = $("#kt_datatable_module").DataTable({

            searchDelay: 500,
            processing: true,
            serverSide: true,
            order: [[1, 'asc']],
            stateSave: true,            

            select: {
                style: 'multi',
                selector: 'td:first-child input[type="checkbox"]',
                className: 'row-selected'
            },

            ajax: {
                url: "http://127.0.0.1:8000/admin/permissions/table",
            },

            columns: [
                { data: 'id' },
                { data: 'name' },
                { data: 'slug' },
                { data: 'permission' },                
                { data: 'created_at' },
                { data: 'updated_at' },                
                { data: null },
            ],

            columnDefs: [
                {
                    targets: 0,
                    orderable: false,
                    render: function (data) {
                        return `
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" name="deleteSelected" value="${data}" />
                            </div>`;
                    }
                },
                {
                    targets: 1,
                    render: function (data, type, row) {
                        return data.charAt(0).toUpperCase() + data.slice(1);
                    }
                },                
                {
                    targets: 2,
                    render: function (data, type, row) {
                        return `
                            <span class="badge badge-light-success">${data}</span>
                        `;                                                
                    }
                },                
                {
                    targets: 3,
                    render: function (data, type, row) {
                        return `
                            <span class="badge badge-light-success">${data}</span>
                        `;                                                
                    }
                },
                {
                    targets: 4,
                    render: function (data, type, row) {                                                
                        return data;
                    }
                },                
                {
                    targets: 5,
                    render: function (data, type, row) {                        
                        return data;
                    }
                },
                {
                    targets: -1,
                    data: null,
                    orderable: false,
                    className: 'text-end',
                    render: function (data, type, row) {
                        return `
                            <a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                                Actions
                                <span class="svg-icon svg-icon-5 m-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                            <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999)"></path>
                                        </g>
                                    </svg>
                                </span>
                            </a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" onclick="edit(${data.id})" data-role="${data.id}" data-kt-docs-table-filter="edit_row">
                                        Edit
                                    </a>
                                </div>
                                <!--end::Menu item-->

                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-docs-table-filter="delete_row">
                                        Delete
                                    </a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        `;
                    },
                },
            ],
            
            createdRow: function (row, data, dataIndex) {

                $(row).find('td:eq(4)').attr('data-filter', data.CreditCardType);

            }

        });

        table = dt.$;

        new $.fn.dataTable.Buttons( dt, {

            buttons: [                
                {
                    extend:    'excel',
                    text:      '<i class="fa fa-files-o"></i> Excel',
                    titleAttr: 'Excel',
                    className: 'btn btn-primary btn-lg',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend:    'pdf',
                    text:      '<i class="fa fa-file-pdf-o"></i> PDF',
                    titleAttr: 'PDF',
                    className: 'btn btn-primary btn-lg',
                    exportOptions: {
                        columns: ':visible'
                    }
                },                                 
            ]
        } );

        dt.buttons().container().appendTo('#kt_datatable_exports');
        
        dt.on('draw', function () {
            initToggleToolbar();
            toggleToolbars();
            handleDeleteRows();
            KTMenu.createInstances();
        });

    }

    let handleSearchDatatable = function () {

        const filterSearch = document.querySelector('[data-kt-docs-table-filter="search"]');

        filterSearch.addEventListener('keyup', function (e) {

            dt.search(e.target.value).draw();

        });

    }

    // var handleFilterDatatable = () => {
        
    //     filterPermission = document.querySelectorAll('[data-kt-docs-table-filter="role"] [name="role"]');
        
    //     const filterButton = document.querySelector('[data-kt-docs-table-filter="filter"]');
                
    //     filterButton.addEventListener('click', function () {
            
    //         let role = '';
            
    //         filterPermission.forEach(r => 
    //             {
    //             if (r.checked) {
    //                 role = r.value;
    //             }
                
    //             if (role === 'all') {
    //                 role = '';
    //             }
    //         });
            
    //         dt.search(role).draw();

    //     });

    // }
    
    var handleDeleteRows = () => {
        
        const deleteButtons = document.querySelectorAll('[data-kt-docs-table-filter="delete_row"]');

        deleteButtons.forEach(d => {
            
            d.addEventListener('click', function (e) {

                e.preventDefault();
                
                const parent = e.target.closest('tr');
                
                const permission = parent.querySelectorAll('td')[2].innerText;
                console.log(permission);

                Swal.fire({

                    text: "Are you sure you want to delete " + permission + "?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Yes, delete!",
                    cancelButtonText: "No, cancel",
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-light-primary"
                    }

                }).then(function (result) {

                    if (result.value) {                                        

                        $.ajax({

                            type:'DELETE',
                    
                            url: 'permissions/' + permission,
                    
                            data: { permission },
                    
                            success:function(data){                                            
                                
                                toastr.success(data.msg);

                                dt.search('').draw();                                                    
                    
                            },
                    
                            error: function(data) {                                                                
                                
                                toastr.error(data.responseJSON.msg);
                                
                            }
                        });

                        
                    } else if (result.dismiss === 'cancel') {                        
                        
                        toastr.error(permission + " permission was not deleted.");
                        
                    }
                });
            })
        });
    }

    // var handleResetForm = () => {
        
    //     const resetButton = document.querySelector('[data-kt-docs-table-filter="reset"]');
        
    //     resetButton.addEventListener('click', function () {
            
    //         filterPermission[0].checked = true;
            
    //         dt.search('').draw();

    //     });

    // }
    
    var initToggleToolbar = function () {
        
        const container = document.querySelector('#kt_datatable_module');

        const checkboxes = container.querySelectorAll('[type="checkbox"]');
        
        const deleteSelected = document.querySelector('[data-kt-docs-table-select="delete_selected"]');        
        
        
        checkboxes.forEach(c => {
            
            c.addEventListener('click', function () {
                setTimeout(function () {
                    toggleToolbars();
                }, 50);
            });

        });

        if (deleteSelected) {
            
            deleteSelected.addEventListener('click', function () {
                
                Swal.fire({

                    text: "Are you sure you want to delete selected permissions?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    showLoaderOnConfirm: true,
                    confirmButtonText: "Yes, delete!",
                    cancelButtonText: "No, cancel",
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-light-primary"
                    },

                }).then(function (result) {
                    
                    if (result.value) {

                        let permissionsArr = [];

                        $("input:checkbox[name=deleteSelected]:checked").each(function() {                            
                            permissionsArr.push($(this).val());
                        });                        

                        $.ajax({

                            type:'DELETE',
                    
                            url: 'permissions/destroyMultiple',
                    
                            data: { permissions: permissionsArr },
                    
                            success:function(data){                                            
                                
                                toastr.success(data.msg);

                                dt.search('').draw();                                                    
                    
                            },
                    
                            error: function(data) {                                                            
                                
                                toastr.error(data.responseJSON.msg);
                                
                            }
                        });

                        const headerCheckbox = container.querySelectorAll('[type="checkbox"]')[0];

                        headerCheckbox.checked = false;
                        
                    } else if (result.dismiss === 'cancel') {

                        Swal.fire({

                            text: "Selected permissions was not deleted.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary",
                            }

                        });

                    }

                });

            });

        }
        
    }
    
    let toggleToolbars = function () {
        
        const container = document.querySelector('#kt_datatable_module');
        const toolbarBase = document.querySelector('[data-kt-docs-table-toolbar="base"]');
        const toolbarSelected = document.querySelector('[data-kt-docs-table-toolbar="selected"]');
        const selectedCount = document.querySelector('[data-kt-docs-table-select="selected_count"]');
        
        const allCheckboxes = container.querySelectorAll('tbody [type="checkbox"]');
        
        let checkedState = false;

        let count = 0;

        allCheckboxes.forEach(c => {
            if (c.checked) {
                checkedState = true;
                count++;
            }
        });
        
        if (checkedState && selectedCount) {

            selectedCount.innerHTML = count;
            toolbarBase.classList.add('d-none');
            toolbarSelected.classList.remove('d-none');

        } else {

            toolbarBase.classList.remove('d-none');
            toolbarSelected.classList.add('d-none');

        }

    }
    
    return {

        init: function () {
            initDatatable();
            handleSearchDatatable();
            initToggleToolbar();
            //handleFilterDatatable();
            handleDeleteRows();
            //handleResetForm();
        }

    }

}();

KTUtil.onDOMContentLoaded(function () {

    KTDatatablesServerSide.init();

});

let saveBtn = document.querySelector("#saveBtn");
saveBtn.addEventListener("click", function(e) {

    e.preventDefault();
    
    saveBtn.setAttribute("data-kt-indicator", "on");

    let name = $("#name").val();    

    save(name);

});


let updateButton = document.querySelector("#updateBtn");
updateButton.addEventListener("click", function(e) {

    e.preventDefault();
    
    updateButton.setAttribute("data-kt-indicator", "on");

    let name = $("#permission_name").val();    
    let id = $("#permission_id").val();    

    update(name, id)
    
});
