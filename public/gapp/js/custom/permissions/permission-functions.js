function edit(id)
{
    $.ajax({

        url: "permissions/"+id+"/details",
        type: 'GET',
        data: {id:id},
        dataType: 'json',
        success: function(res) {
            
            $('#permission_name').val(res.data.name);
            $('#kt_modal_edit').modal('show');  
            $('#permission_id').val(res.data.id)          
        }

    });
}

function save(name)
{
    $.ajax({

        type:'POST',

        url: 'permissions',

        data: { name:name },

        success:function(data){            
            
            toastr.success(data.msg);
            
            saveBtn.setAttribute("data-kt-indicator", "off");

            $('.name-error').addClass('d-none');

            $("#name").removeClass("is-invalid border-danger");

            $('#kt_modal_add').modal('hide');

            $('#kt_datatable_module').DataTable().ajax.reload();

            $("#name").val('');

        },

        error: function(data) {

            let response = data.responseJSON;            

            if (typeof response !== 'undefined') {
                
                if(response.data.name[0]) {

                    $("#name").addClass("is-invalid border-danger");
                    $('.name-error').text(response.data.name[0]);
                    $('.name-error').removeClass('d-none');

                    saveBtn.setAttribute("data-kt-indicator", "off");

                } else {

                    $("#name").removeClass("is-invalid border-danger");

                }

            }

        }
    });
}

function update(name, id)
{
    $.ajax({

        type:'PUT',

        url: 'permissions/'+name,

        data: { name:name, id: id },

        success:function(data){                        
            
            toastr.success(data.msg);
            
            updateButton.setAttribute("data-kt-indicator", "off");

            $('.permission-name-error').addClass('d-none');
            $("#permission_name").removeClass("is-invalid border-danger");

            $('#kt_modal_edit').modal('hide');

            $('#kt_datatable_module').DataTable().ajax.reload();

        },

        error: function(data) {

            let response = data.responseJSON;            

            if (typeof response !== 'undefined') {
                
                if(response.data.name[0]) {

                    $("#permission_name").addClass("is-invalid border-danger");
                    $('.permission-name-error').text(response.data.name[0]);
                    $('.permission-name-error').removeClass('d-none');

                    updateButton.setAttribute("data-kt-indicator", "off");

                } else {

                    $("#permission_name").removeClass("is-invalid border-danger");

                }

            }

        }
    });
}