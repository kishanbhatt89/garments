function edit(id)
{
    
    $.ajax({

        url: "gst-profiles/"+id+"/details",
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

function save(company_name, company_gst_number)
{
    $.ajax({

        type:'POST',

        url: 'gst-profiles',

        data: { company_name, company_gst_number },

        success:function(data){            
            
            toastr.success(data.msg);
            
            $('#saveBtn').attr('data-kt-indicator', 'off');

            $("#company_name").val('');
            $('.company_name-error').addClass('d-none');
            $("#company_name").removeClass("is-invalid border-danger");

            $("#company_gst_number").val('');
            $('.company_gst_number-error').addClass('d-none');
            $("#company_gst_number").removeClass("is-invalid border-danger");

            $('#kt_modal_add').modal('hide');

            $('#kt_datatable_module').DataTable().ajax.reload();            

            location.reload();

        },

        error: function(data) {

            let response = data.responseJSON;            

            if (typeof response !== 'undefined') {

                if(response.data.company_gst_number !== 'undefined') {

                    $("#company_gst_number").addClass("is-invalid border-danger");
                    $('.company_gst_number-error').text(response.data.company_gst_number[0]);
                    $('.company_gst_number-error').removeClass('d-none');                                    

                } else {

                    $("#company_gst_number").removeClass("is-invalid border-danger");

                }

                console.log(response.data.company_name !== 'undefined' ? response.data.company_name[0] : '');
                
                
                if(response.data.company_name !== 'undefined') {

                    $("#company_name").addClass("is-invalid border-danger");
                    $('.company_name-error').text(response.data.company_name[0]);
                    $('.company_name-error').removeClass('d-none');                                    

                } else {

                    $("#company_name").removeClass("is-invalid border-danger");

                }

                

            }

            $('#saveBtn').attr('data-kt-indicator', 'off');

        }
    });
}

function update(name, gst, id, existing_company_name)
{
    
    $.ajax({

        type:'PUT',

        url: 'gst-profiles/'+existing_company_name,

        data: { name, gst, id },

        success:function(data){                        
            
            toastr.success(data.msg);
                        
            $('#updateBtn').attr('data-kt-indicator', 'off');

            $('.company_name_edit-error').addClass('d-none');
            $("#company_name_edit").removeClass("is-invalid border-danger");
            $('.company_gst_number_edit-error').addClass('d-none');
            $("#company_gst_number_edit").removeClass("is-invalid border-danger");

            $('#kt_modal_edit').modal('hide');

            $('#kt_datatable_module').DataTable().ajax.reload();

            location.reload();

        },

        error: function(data) {

            let response = data.responseJSON;            

            if (typeof response !== 'undefined') {
                
                if(response.data.company_name !== 'undefined') {

                    $("#company_name").addClass("is-invalid border-danger");
                    $('.company_name-error').text(response.data.company_name[0]);
                    $('.company_name-error').removeClass('d-none');
                    

                } else {

                    $("#company_name").removeClass("is-invalid border-danger");

                }

                if(response.data.company_gst_number !== 'undefined') {

                    $("#company_gst_number").addClass("is-invalid border-danger");
                    $('.company_gst_number-error').text(response.data.company_gst_number[0]);
                    $('.company_gst_number-error').removeClass('d-none');
                    

                } else {

                    $("#company_gst_number").removeClass("is-invalid border-danger");

                }

            }

            $('#updateBtn').attr('data-kt-indicator', 'off');

        }
    });
}