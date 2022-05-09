$('#saveGeneralSettingBtn').on('click', function(e) {

    e.preventDefault();

    $(this).attr('data-kt-indicator', 'on');

    let company_name = $('#company_name').val();
    let company_address = $('#company_address').val();

    $.ajax({

        type:'POST',

        url: APP_URL+'/admin/settings',

        data: { company_name, company_address },

        success:function(data){         
            $('#saveGeneralSettingBtn').attr('data-kt-indicator', 'off');               
            $('#company_name').val(company_name);
            $('#company_address').val(company_address);
            toastr.success(data.msg);            
        },

        error: function(data) {
            $('#saveGeneralSettingBtn').attr('data-kt-indicator', 'off');               
            toastr.error(data.msg);            
        }

    });

});


$('#saveEmailSettingBtn').on('click', function(e) {

    e.preventDefault();

    $(this).attr('data-kt-indicator', 'on');

    let company_mail_mailer = $('#company_mail_mailer').val();
    let company_mail_host = $('#company_mail_host').val();
    let company_mail_port = $('#company_mail_port').val();
    let company_mail_username = $('#company_mail_username').val();
    let company_mail_password = $('#company_mail_password').val();
    let company_mail_encryption = $('#company_mail_encryption').val();
    let company_mail_from_address = $('#company_mail_from_address').val();
    let company_mail_from_name = $('#company_mail_from_name').val();
    
    $.ajax({

        type:'POST',

        url: APP_URL+'/admin/settings',

        data: { 
            company_mail_mailer, 
            company_mail_host, 
            company_mail_port, 
            company_mail_username, 
            company_mail_password, 
            company_mail_encryption, 
            company_mail_from_address, 
            company_mail_from_name 
        },

        success:function(data){         

            $('#saveEmailSettingBtn').attr('data-kt-indicator', 'off');               

            $('#company_mail_mailer').val(company_mail_mailer);
            $('#company_mail_host').val(company_mail_host);
            $('#company_mail_port').val(company_mail_port);
            $('#company_mail_username').val(company_mail_username);
            $('#company_mail_password').val(company_mail_password);
            $('#company_mail_encryption').val(company_mail_encryption);
            $('#company_mail_from_address').val(company_mail_from_address);
            $('#company_mail_from_name').val(company_mail_from_name);            

            toastr.success(data.msg);    

        },

        error: function(data) {

            $('#saveEmailSettingBtn').attr('data-kt-indicator', 'off');               

            toastr.error(data.msg);            

        }

    });

});

$('#saveSupportSettingBtn').on('click', function(e) {

    e.preventDefault();

    $(this).attr('data-kt-indicator', 'on');

    let company_mobile = $('#company_mobile').val();
    let company_email = $('#company_email').val();

    $.ajax({

        type:'POST',

        url: APP_URL+'/admin/settings',

        data: { company_mobile, company_email },

        success:function(data){         
            $('#saveSupportSettingBtn').attr('data-kt-indicator', 'off');               
            $('#company_mobile').val(company_mobile);
            $('#company_email').val(company_email);
            toastr.success(data.msg);            
        },

        error: function(data) {
            $('#saveSupportSettingBtn').attr('data-kt-indicator', 'off');               
            toastr.error(data.msg);            
        }

    });

});