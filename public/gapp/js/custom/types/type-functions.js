function edit(id)
{
    
    $.ajax({

        url: APP_URL+"/admin/types/"+id+"/details",
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

function save(name)
{
    $.ajax({

        type:'POST',

        url: APP_URL+'/admin/types',

        data: { name },

        success:function(data){            
            
            toastr.success(data.msg);
            
            $('#saveBtn').attr('data-kt-indicator', 'off');

            $('.name-error').addClass('d-none');

            $("#name").removeClass("is-invalid border-danger");

            $('#kt_modal_add').modal('hide');

            $('#kt_datatable_module').DataTable().ajax.reload();

            $("#name").val('');

            location.reload();

        },

        error: function(data) {

            let response = data.responseJSON;            

            if (typeof response !== 'undefined') {
                
                if(response.data.name[0]) {

                    $("#name").addClass("is-invalid border-danger");
                    $('.name-error').text(response.data.name[0]);
                    $('.name-error').removeClass('d-none');
                    
                    $('#saveBtn').attr('data-kt-indicator', 'off');

                } else {

                    $("#name").removeClass("is-invalid border-danger");

                }

            }

        }
    });
}

function update(name, id, existing_type)
{
    $.ajax({

        type:'PUT',

        url: APP_URL+'/admin/types/'+existing_type,

        data: { name, id },

        success:function(data){                        
            
            toastr.success(data.msg);
                        
            $('#updateBtn').attr('data-kt-indicator', 'off');
            
            $('.city-name-error').addClass('d-none');
            $("#city_name").removeClass("is-invalid border-danger");

            $('#kt_modal_edit').modal('hide');

            $('#kt_datatable_module').DataTable().ajax.reload();

            location.reload();

        },

        error: function(data) {

            let response = data.responseJSON;            

            if (typeof response !== 'undefined') {
                
                if(response.data.name[0]) {

                    $("#type_name").addClass("is-invalid border-danger");
                    $('.type-name-error').text(response.data.name[0]);
                    $('.type-name-error').removeClass('d-none');

                    $('#updateBtn').attr('data-kt-indicator', 'off');

                } else {

                    $("#type_name").removeClass("is-invalid border-danger");

                }

            }

        }
    });
}