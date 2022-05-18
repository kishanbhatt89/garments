"use strict";

let KTDatatablesServerSide = function () {
    
    let table;
    let dt;
    let filterRole;
    
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
                url: APP_URL+"/admin/plans/table",
            },

            columns: [                
                { data: 'razor_plan_id' },
                { data: 'razor_plan_name' },                
                { data: 'razor_plan_price' },                                
                { data: 'razor_plan_is_active' },                
                { data: 'razor_plan_created_at' },
                { data: 'created_at' },
                { data: 'updated_at' }                
            ],

            columnDefs: [                
                {
                    targets: 0,
                    render: function (data, type, row) {
                        return data;
                    }
                },                                
                {
                    targets: 1,
                    render: function (data, type, row) {                                                
                        return data;
                    }
                },                
                {
                    targets: 2,
                    render: function (data, type, row) {                        
                        return data;
                    }
                },
                {
                    targets: 3,
                    render: function (data, type, row) {
                        return `${data}`;
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
                    targets: 6,
                    render: function (data, type, row) {                        
                        return data;
                    }
                }                
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

    var handleFilterDatatable = () => {
        
        filterRole = document.querySelectorAll('[data-kt-docs-table-filter="role"] [name="role"]');

        const filterButton = document.querySelector('[data-kt-docs-table-filter="filter"]');
                
        filterButton.addEventListener('click', function () {
            
            let role = '';
            
            filterRole.forEach(r => {
                if (r.checked) {
                    role = r.value;
                }
                
                if (role === 'all') {
                    role = '';
                }
            });
            
            dt.search(role).draw();

        });

    }
    
    var handleDeleteRows = () => {
        
        const deleteButtons = document.querySelectorAll('[data-kt-docs-table-filter="delete_row"]');

        deleteButtons.forEach(d => {
            
            d.addEventListener('click', function (e) {

                e.preventDefault();
                
                const parent = e.target.closest('tr');
                
                const state = parent.querySelectorAll('td')[1].innerText;

                Swal.fire({

                    text: "Are you sure you want to delete " + state + "?",
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
                    
                            url: APP_URL+'/admin/states/' + state,
                    
                            data: { state },
                    
                            success:function(data){                                            
                                
                                toastr.success(data.msg);

                                dt.search('').draw();                                                    
                    
                            },
                    
                            error: function(data) {                                                                
                                
                                toastr.error(data.responseJSON.msg);
                                
                            }
                        });

                        
                    } else if (result.dismiss === 'cancel') {                        
                        
                        toastr.error(state + " state was not deleted.");
                        
                    }
                });
            })
        });
    }

    var handleResetForm = () => {
        
        const resetButton = document.querySelector('[data-kt-docs-table-filter="reset"]');
        
        resetButton.addEventListener('click', function () {
            
            filterRole[0].checked = true;
            
            dt.search('').draw();

        });

    }
    
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

                    text: "Are you sure you want to delete selected states?",
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

                        let statesArr = [];

                        $("input:checkbox[name=deleteSelected]:checked").each(function() {                            
                            statesArr.push($(this).val());
                        });                        

                        $.ajax({

                            type:'DELETE',
                    
                            url: APP_URL+'/admin/states/destroyMultiple',
                    
                            data: { states: statesArr },
                    
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

                            text: "Selected roles was not deleted.",
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
            toggleToolbars();
            //handleFilterDatatable();
            handleDeleteRows();
            //handleResetForm();
        }

    }

}();

KTUtil.onDOMContentLoaded(function () {

    KTDatatablesServerSide.init();

});


$('#saveBtn').on('click', function(e) {

    e.preventDefault();
        
    $('#saveBtn').attr('data-kt-indicator', 'on');

    let razor_plan_name = $("#razor_plan_name").val();    
    let razor_plan_description = $("#razor_plan_description").val();    
    let razor_plan_price = $("#razor_plan_price").val();    

    save(razor_plan_name, razor_plan_description, razor_plan_price);

});
