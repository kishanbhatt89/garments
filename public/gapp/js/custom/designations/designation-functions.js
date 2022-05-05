function edit(id)
{
    
    $.ajax({

        url: "designations/"+id+"/details",
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

        url: 'designations',

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

function update(name, id, existing_designation)
{
    $.ajax({

        type:'PUT',

        url: 'designations/'+existing_designation,

        data: { name, id },

        success:function(data){                        
            
            toastr.success(data.msg);
                        
            $('#updateBtn').attr('data-kt-indicator', 'off');

            $("#designation_name").val('');
            $('.designation-name-error').addClass('d-none');
            $("#designation_name").removeClass("is-invalid border-danger");

            $('#kt_modal_edit').modal('hide');

            $('#kt_datatable_module').DataTable().ajax.reload();

            location.reload();

        },

        error: function(data) {

            let response = data.responseJSON;            

            if (typeof response !== 'undefined') {
                
                if(response.data.name !== 'undefined') {

                    $("#designation_name").addClass("is-invalid border-danger");
                    $('.designation-name-error').text(response.data.name[0]);
                    $('.designation-name-error').removeClass('d-none');                    

                } else {

                    $("#designation_name").removeClass("is-invalid border-danger");

                }

            }

            $('#updateBtn').attr('data-kt-indicator', 'off');

        }
    });
}