let cancelBtn = document.querySelectorAll('[data-kt-modal-action="cancel"]');
cancelBtn.forEach( function(cancelButton) {
    cancelButton.addEventListener('click', e => {
        e.preventDefault();
        $('#kt_modal_add').modal('hide');
        $('#kt_modal_edit').modal('hide');
    })
});


$('#kt_add_button').on('click', function() {
    
    
    $('#kt_add_button').attr("data-kt-indicator", "on")
    
    setTimeout(function() {
        
        $('#kt_add_button').attr("data-kt-indicator", "off")

    }, 500);

});