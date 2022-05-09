function edit(id)
{
    
    $.ajax({

        url: APP_URL+"/admin/states/"+id+"/details",
        type: 'GET',
        data: {id:id},
        dataType: 'json',
        //processData: false,
        
        success: function(res) {            
           let data = res.data; 
           
            $('#kt_modal_edit').html(data);
            $('#kt_modal_edit').modal('show');              
        }

    });
}

function save(name, permissions)
{
    $.ajax({

        type:'POST',

        url: APP_URL+'/admin/states',

        data: { name },

        success:function(data){            
            
            toastr.success(data.msg);
            
            $('#saveBtn').attr('data-kt-indicator', 'off');

            $("#name").val('');
            $('.name-error').addClass('d-none');
            $("#name").removeClass("is-invalid border-danger");

            $('#kt_modal_add').modal('hide');

            $('#kt_datatable_module').DataTable().ajax.reload();            

            location.reload();

        },

        error: function(data) {

            let response = data.responseJSON;            

            if (typeof response !== 'undefined') {
                
                if(response.data.name !== 'undefined') {

                    $("#name").addClass("is-invalid border-danger");
                    $('.name-error').text(response.data.name[0]);
                    $('.name-error').removeClass('d-none');                                    

                } else {

                    $("#name").removeClass("is-invalid border-danger");

                }

            }

            $('#saveBtn').attr('data-kt-indicator', 'off');

        }
    });
}

function update(name, id, existing_state)
{
    $.ajax({

        type:'PUT',

        url: APP_URL+'/admin/states/'+existing_state,

        data: { name, id },

        success:function(data){                        
            
            toastr.success(data.msg);
                        
            $('#updateBtn').attr('data-kt-indicator', 'off');

            $('.state-name-error').addClass('d-none');
            $("#state_name").removeClass("is-invalid border-danger");

            $('#kt_modal_edit').modal('hide');

            $('#kt_datatable_module').DataTable().ajax.reload();

            location.reload();

        },

        error: function(data) {

            let response = data.responseJSON;            

            if (typeof response !== 'undefined') {
                
                if(response.data.name !== 'undefined') {

                    $("#state_name").addClass("is-invalid border-danger");
                    $('.state-name-error').text(response.data.name[0]);
                    $('.state-name-error').removeClass('d-none');
                    

                } else {

                    $("#state_name").removeClass("is-invalid border-danger");

                }

            }

            $('#updateBtn').attr('data-kt-indicator', 'off');

        }
    });
}