
function save(name, description, price)
{
    $.ajax({

        type:'POST',

        url: APP_URL+'/admin/plans',

        data: { name, description, price },

        success:function(data){            
            
            toastr.success(data.msg);
            
            $('#saveBtn').attr('data-kt-indicator', 'off');

            $("#razor_plan_name").val('');
            $('.razor_plan_name-error').addClass('d-none');
            $("#razor_plan_name").removeClass("is-invalid border-danger");

            $("#razor_plan_description").val('');
            $('.razor_plan_description-error').addClass('d-none');
            $("#razor_plan_description").removeClass("is-invalid border-danger");

            $("#razor_plan_price").val('');
            $('.razor_plan_price-error').addClass('d-none');
            $("#razor_plan_price").removeClass("is-invalid border-danger");

            $('#kt_modal_add').modal('hide');

            $('#kt_datatable_module').DataTable().ajax.reload();            

            location.reload();

        },

        error: function(data) {

            let response = data.responseJSON;            

            if (typeof response !== 'undefined') {
                
                if(response.data.name !== 'undefined') {

                    $("#razor_plan_name").addClass("is-invalid border-danger");
                    $('.razor_plan_name-error').text(response.data.name[0]);
                    $('.razor_plan_name-error').removeClass('d-none');                                        

                } else {

                    $("#razor_plan_name").removeClass("is-invalid border-danger");

                }

                if(response.data.description !== 'undefined') {

                    $("#razor_plan_description").addClass("is-invalid border-danger");
                    $('.razor_plan_description-error').text(response.data.description[0]);
                    $('.razor_plan_description-error').removeClass('d-none');                                        

                } else {

                    $("#razor_plan_description").removeClass("is-invalid border-danger");

                }

                if(response.data.price !== 'undefined') {

                    $("#razor_plan_price").addClass("is-invalid border-danger");
                    $('.razor_plan_price-error').text(response.data.price[0]);
                    $('.razor_plan_price-error').removeClass('d-none');                                    

                } else {

                    $("#razor_plan_price").removeClass("is-invalid border-danger");

                }                                    

            }

            $('#saveBtn').attr('data-kt-indicator', 'off');

        }
    });
}