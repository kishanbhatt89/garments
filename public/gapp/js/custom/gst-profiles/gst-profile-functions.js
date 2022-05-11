function edit(id)
{
    
    $.ajax({

        url: APP_URL+"/admin/gst-profiles/"+id+"/details",
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

function save(name, gst_percentage)
{
    $.ajax({

        type:'POST',

        url: APP_URL+'/admin/gst-profiles',

        data: { name, gst_percentage },

        success:function(data){            
            
            toastr.success(data.msg);
            
            $('#saveBtn').attr('data-kt-indicator', 'off');

            $("#name").val('');
            $('.name-error').addClass('d-none');
            $("#name").removeClass("is-invalid border-danger");

            $("#gst_percentage").val('');
            $('.gst_percentage-error').addClass('d-none');
            $("#gst_percentage").removeClass("is-invalid border-danger");

            $('#kt_modal_add').modal('hide');

            $('#kt_datatable_module').DataTable().ajax.reload();            

            location.reload();

        },

        error: function(data) {

            let response = data.responseJSON;            

            if (typeof response !== 'undefined') {

                if(response.data.gst_percentage !== 'undefined') {

                    $("#gst_percentage").addClass("is-invalid border-danger");
                    $('.gst_percentage-error').text(response.data.gst_percentage[0]);
                    $('.gst_percentage-error').removeClass('d-none');                                    

                } else {

                    $("#gst_percentage").removeClass("is-invalid border-danger");

                }                
                
                
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

function update(name, gst_percentage, id, existing_name)
{
    
    $.ajax({

        type:'PUT',

        url: APP_URL+'/admin/gst-profiles/'+existing_name,

        data: { name, gst: gst_percentage, id },

        success:function(data){                        
            
            toastr.success(data.msg);
                        
            $('#updateBtn').attr('data-kt-indicator', 'off');

            $('.name_edit-error').addClass('d-none');
            $("#name_edit").removeClass("is-invalid border-danger");
            
            $('.gst_percentage_edit-error').addClass('d-none');
            $("#gst_percentage_edit").removeClass("is-invalid border-danger");

            $('#kt_modal_edit').modal('hide');

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

                if(response.data.gst_percentage !== 'undefined') {

                    $("#gst_percentage").addClass("is-invalid border-danger");
                    $('.gst_percentage-error').text(response.data.gst_percentage[0]);
                    $('.gst_percentage-error').removeClass('d-none');
                    

                } else {

                    $("#gst_percentage").removeClass("is-invalid border-danger");

                }

            }

            $('#updateBtn').attr('data-kt-indicator', 'off');

        }
    });
}