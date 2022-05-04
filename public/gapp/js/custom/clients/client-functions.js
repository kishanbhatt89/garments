function edit(id)
{
    
    $.ajax({

        url: "clients/"+id+"/details",
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

function save(name, email, role, password, password_confirmation, mobile, designation, address)
{
    $.ajax({

        type:'POST',

        url: 'clients',

        data: { name, email, role, password, password_confirmation, mobile, designation, address },

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

                if(response.data.email[0]) {
                    $("#email").addClass("is-invalid border-danger");
                    $('.email-error').text(response.data.email[0]);
                    $('.email-error').removeClass('d-none');                    
                    $('#saveBtn').attr('data-kt-indicator', 'off');
                } else {
                    $("#email").removeClass("is-invalid border-danger");
                }

                if(response.data.password[0]) {
                    $("#password").addClass("is-invalid border-danger");
                    $('.password-error').text(response.data.password[0]);
                    $('.password-error').removeClass('d-none');                    
                    $('#saveBtn').attr('data-kt-indicator', 'off');
                } else {
                    $("#password").removeClass("is-invalid border-danger");
                }

                if(response.data.role[0]) {
                    $("#role").addClass("is-invalid border-danger");
                    $('.role-error').text(response.data.role[0]);
                    $('.role-error').removeClass('invalid-feedback');
                    $('.role-error').addClass('text-danger');
                    $('.role-error').removeClass('d-none');                    
                    $('.r-error').removeClass('d-none');                    
                    $('#saveBtn').attr('data-kt-indicator', 'off');
                } else {
                    $("#role").removeClass("is-invalid border-danger");
                }

                if(response.data.mobile[0]) {
                    $("#mobile").addClass("is-invalid border-danger");
                    $('.mobile-error').text(response.data.mobile[0]);
                    $('.mobile-error').removeClass('d-none');                    
                    $('#saveBtn').attr('data-kt-indicator', 'off');
                } else {
                    $("#mobile").removeClass("is-invalid border-danger");
                }

                if(response.data.designation[0]) {
                    $("#designation").addClass("is-invalid border-danger");
                    $('.designation-error').text(response.data.designation[0]);
                    $('.designation-error').removeClass('d-none');                    
                    $('#saveBtn').attr('data-kt-indicator', 'off');
                } else {
                    $("#designation").removeClass("is-invalid border-danger");
                }

                if(response.data.address[0]) {
                    $("#address").addClass("is-invalid border-danger");
                    $('.address-error').text(response.data.address[0]);
                    $('.address-error').removeClass('d-none');                    
                    $('#saveBtn').attr('data-kt-indicator', 'off');
                } else {
                    $("#address").removeClass("is-invalid border-danger");
                }

            }

        }
    });
}

function update(id, name, email, role, mobile, designation, address)
{
    
    
    $.ajax({

        type:'PUT',

        url: 'clients/'+id,

        data: { id, name, email, role, mobile, designation, address },

        success:function(data){                        
            
            toastr.success(data.msg);
                        
            $('#updateBtn').attr('data-kt-indicator', 'off');

            $('.role-name-error').addClass('d-none');
            $("#role_name").removeClass("is-invalid border-danger");

            $('#kt_modal_edit').modal('hide');

            $('#kt_datatable_module').DataTable().ajax.reload();

            location.reload();

        },

        error: function(data) {

            let response = data.responseJSON;            

            if (typeof response !== 'undefined') {
                
                if(response.data.name[0]) {

                    $("#role_name").addClass("is-invalid border-danger");
                    $('.role-name-error').text(response.data.name[0]);
                    $('.role-name-error').removeClass('d-none');

                    $('#updateBtn').attr('data-kt-indicator', 'off');

                } else {

                    $("#role_name").removeClass("is-invalid border-danger");

                }

            }

        }
    });
}