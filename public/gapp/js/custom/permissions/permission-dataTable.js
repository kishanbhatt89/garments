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

                            <a href="#" onclick="edit(${data.id})" data-role="${data.id}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" data-kt-docs-table-filter="edit_row">
                            <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                <span class="svg-icon svg-icon-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor"></path>
                                        <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor"></path>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </a>

                            <a href="#" data-kt-docs-table-filter="delete_row" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                <span class="svg-icon svg-icon-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor"></path>
                                        <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor"></path>
                                        <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor"></path>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </a>
                            
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
