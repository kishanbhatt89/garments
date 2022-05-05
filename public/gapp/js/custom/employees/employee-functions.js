function edit(id)
{
    
    $.ajax({

        url: "employees/"+id+"/details",
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

        url: 'employees',

        data: { name, email, role, password, password_confirmation, mobile, designation, address },

        success:function(data){            
            
            toastr.success(data.msg);
            
            $('#saveBtn').attr('data-kt-indicator', 'off');

            $("#name").val('');
            $('.name-error').addClass('d-none');
            $("#name").removeClass("is-invalid border-danger");

            $("#email").val('');
            $('.email-error').addClass('d-none');
            $("#email").removeClass("is-invalid border-danger");

            $("#password").val('');
            $('.password-error').addClass('d-none');
            $("#password").removeClass("is-invalid border-danger");

            $("#mobile").val('');
            $('.mobile-error').addClass('d-none');
            $("#mobile").removeClass("is-invalid border-danger");

            $("#designation").val('');
            $('.designation-error').addClass('d-none');
            $("#designation").removeClass("is-invalid border-danger");

            $("#address").val('');
            $('.address-error').addClass('d-none');
            $("#address").removeClass("is-invalid border-danger");

            $('#kt_modal_add').modal('hide');
            $('#kt_datatable_module').DataTable().ajax.reload();
            
            location.reload();

        },

        error: function(data) {

            let response = data.responseJSON;                        
            
            if (typeof response !== 'undefined') {

                if(typeof response.data.mobile !== 'undefined') {
                    $("#mobile").addClass("is-invalid border-danger");
                    $('.mobile-error').text(response.data.mobile[0]);
                    $('.mobile-error').removeClass('d-none');                                        
                } else {
                    $("#mobile").removeClass("is-invalid border-danger");
                }

                if(typeof response.data.designation !== 'undefined') {
                    $("#designation").addClass("is-invalid border-danger");
                    $('.designation-error').text(response.data.designation[0]);
                    $('.designation-error').removeClass('d-none');                                        
                } else {
                    $("#designation").removeClass("is-invalid border-danger");
                }

                if(typeof response.data.address !== 'undefined') {
                    $("#address").addClass("is-invalid border-danger");
                    $('.address-error').text(response.data.address[0]);
                    $('.address-error').removeClass('d-none');                                        
                } else {
                    $("#address").removeClass("is-invalid border-danger");
                }
                
                if(typeof response.data.name !== 'undefined') {
                    $("#name").addClass("is-invalid border-danger");
                    $('.name-error').text(response.data.name[0]);
                    $('.name-error').removeClass('d-none');                                        
                } else {
                    $("#name").removeClass("is-invalid border-danger");
                }

                if(typeof response.data.email !== 'undefined') {
                    $("#email").addClass("is-invalid border-danger");
                    $('.email-error').text(response.data.email[0]);
                    $('.email-error').removeClass('d-none');                                        
                } else {
                    $("#email").removeClass("is-invalid border-danger");
                }

                if(typeof response.data.password !== 'undefined') {
                    $("#password").addClass("is-invalid border-danger");
                    $('.password-error').text(response.data.password[0]);
                    $('.password-error').removeClass('d-none');                                        
                } else {
                    $("#password").removeClass("is-invalid border-danger");
                }                
                
            }

            $('#saveBtn').attr('data-kt-indicator', 'off');

        }
    });
}

function update(id, name, email, role, mobile, designation, address)
{
    
    
    $.ajax({

        type:'PUT',

        url: 'employees/'+id,

        data: { id, name, email, role, mobile, designation, address },

        success:function(data){                        
            
            toastr.success(data.msg);
                        
            $('#updateBtn').attr('data-kt-indicator', 'off');            

            $("#employee_name").val('');
            $('.employee_name-error').addClass('d-none');
            $("#employee_name").removeClass("is-invalid border-danger");

            $("#employee_email").val('');
            $('.employee_email-error').addClass('d-none');
            $("#employee_email").removeClass("is-invalid border-danger");

            $("#employee_role").val('');
            $('.employee_role-error').addClass('d-none');
            $("#employee_role").removeClass("is-invalid border-danger");

            $("#employee_mobile").val('');
            $('.employee_mobile-error').addClass('d-none');
            $("#employee_mobile").removeClass("is-invalid border-danger");

            $("#employee_designation").val('');
            $('.employee_designation-error').addClass('d-none');
            $("#employee_designation").removeClass("is-invalid border-danger");

            $("#employee_address").val('');
            $('.employee_address-error').addClass('d-none');
            $("#employee_address").removeClass("is-invalid border-danger");

            $('#kt_modal_edit').modal('hide');

            $('#kt_datatable_module').DataTable().ajax.reload();

            location.reload();

        },

        error: function(data) {

            let response = data.responseJSON;            

            if (typeof response !== 'undefined') {
                
                if(typeof response.data.mobile !== 'undefined') {
                    $("#employee_mobile").addClass("is-invalid border-danger");
                    $('.employee_mobile-error').text(response.data.mobile[0]);
                    $('.employee_mobile-error').removeClass('d-none');                                        
                } else {
                    $("#employee_mobile").removeClass("is-invalid border-danger");
                }

                if(typeof response.data.designation !== 'undefined') {
                    $("#employee_designation").addClass("is-invalid border-danger");
                    $('.employee_designation-error').text(response.data.designation[0]);
                    $('.employee_designation-error').removeClass('d-none');                                        
                } else {
                    $("#employee_designation").removeClass("is-invalid border-danger");
                }

                if(typeof response.data.address !== 'undefined') {
                    $("#employee_address").addClass("is-invalid border-danger");
                    $('.employee_address-error').text(response.data.address[0]);
                    $('.employee_address-error').removeClass('d-none');                                        
                } else {
                    $("#employee_address").removeClass("is-invalid border-danger");
                }
                
                if(typeof response.data.name !== 'undefined') {
                    $("#employee_name").addClass("is-invalid border-danger");
                    $('.employee_name-error').text(response.data.name[0]);
                    $('.employee_name-error').removeClass('d-none');                                        
                } else {
                    $("#employee_name").removeClass("is-invalid border-danger");
                }

                if(typeof response.data.email !== 'undefined') {
                    $("#employee_email").addClass("is-invalid border-danger");
                    $('.employee_email-error').text(response.data.email[0]);
                    $('.employee_email-error').removeClass('d-none');                                        
                } else {
                    $("#employee_email").removeClass("is-invalid border-danger");
                }                

            }

            $('#updateBtn').attr('data-kt-indicator', 'off');            

        }
    });
}