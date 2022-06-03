function edit(id)
{
    
    $.ajax({

        url: APP_URL+"/admin/categories/"+id+"/details",
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

function save(name,slug,parent_id)
{
    $.ajax({

        type:'POST',

        url: APP_URL+'/admin/categories',

        data: { name, slug, parent_id },

        success:function(data){            
            
            toastr.success(data.msg);
            
            $('#saveBtn').attr('data-kt-indicator', 'off');

            $('.name-error').addClass('d-none');
            $("#name").removeClass("is-invalid border-danger");

            $('.slug-error').addClass('d-none');
            $("#slug").removeClass("is-invalid border-danger");

            $('.parent-id-error').addClass('d-none');
            $("#parent_id").removeClass("is-invalid border-danger");

            $('#kt_modal_add').modal('hide');

            $('#kt_datatable_module').DataTable().ajax.reload();

            $("#name").val('');
            $("#slug").val('');
            $("#parent_id").val('');

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

                if(response.data.slug[0]) {

                    $("#slug").addClass("is-invalid border-danger");
                    $('.slug-error').text(response.data.slug[0]);
                    $('.slug-error').removeClass('d-none');
                    
                    $('#saveBtn').attr('data-kt-indicator', 'off');

                } else {

                    $("#slug").removeClass("is-invalid border-danger");

                }

                if(response.data.parent_id[0]) {

                    $("#parent_id").addClass("is-invalid border-danger");
                    $('.parent-id-error').text(response.data.parent_id[0]);
                    $('.parent-id-error').removeClass('d-none');
                    
                    $('#saveBtn').attr('data-kt-indicator', 'off');

                } else {

                    $("#parent_id").removeClass("is-invalid border-danger");

                }

            }

        }
    });
}

function update(name, slug, id, parent_id, existing_category)
{
    $.ajax({

        type:'PUT',

        url: APP_URL+'/admin/categories/'+existing_category,

        data: { name, slug, id, parent_id },

        success:function(data){                        
            
            toastr.success(data.msg);
                        
            $('#updateBtn').attr('data-kt-indicator', 'off');
            
            $('.category-name-error').addClass('d-none');
            $("#category_name").removeClass("is-invalid border-danger");

            $('.category-slug-error').addClass('d-none');
            $("#category_slug").removeClass("is-invalid border-danger");

            $('.category-parent-id-error').addClass('d-none');
            $("#category_parent_id").removeClass("is-invalid border-danger");

            $('#kt_modal_edit').modal('hide');

            $('#kt_datatable_module').DataTable().ajax.reload();

            location.reload();

        },

        error: function(data) {

            let response = data.responseJSON;            

            if (typeof response !== 'undefined') {
                
                if(response.data.name[0]) {

                    $("#category_name").addClass("is-invalid border-danger");
                    $('.category-name-error').text(response.data.name[0]);
                    $('.category-name-error').removeClass('d-none');

                    $('#updateBtn').attr('data-kt-indicator', 'off');

                } else {

                    $("#category_name").removeClass("is-invalid border-danger");

                }

                if(response.data.slug[0]) {

                    $("#category_slug").addClass("is-invalid border-danger");
                    $('.category-slug-error').text(response.data.slug[0]);
                    $('.category-slug-error').removeClass('d-none');

                    $('#updateBtn').attr('data-kt-indicator', 'off');

                } else {

                    $("#category_slug").removeClass("is-invalid border-danger");

                }

                if(response.data.parent_id[0]) {

                    $("#category_parent_id").addClass("is-invalid border-danger");
                    $('.category-parent-id-error').text(response.data.parent_id[0]);
                    $('.category-parent-id-error').removeClass('d-none');

                    $('#updateBtn').attr('data-kt-indicator', 'off');

                } else {

                    $("#category_parent_id").removeClass("is-invalid border-danger");

                }

            }

        }
    });
}