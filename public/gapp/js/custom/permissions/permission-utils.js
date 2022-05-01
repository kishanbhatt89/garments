let cancelBtn = document.querySelectorAll('[data-kt-modal-action="cancel"]');
cancelBtn.forEach( function(cancelButton) {
    cancelButton.addEventListener('click', e => {
        e.preventDefault();
        $('#kt_modal_add').modal('hide');
        $('#kt_modal_edit').modal('hide');
    })
});

let addBtn = document.querySelector("#kt_add_button");
addBtn.addEventListener("click", function() {
    
    addBtn.setAttribute("data-kt-indicator", "on");
    
    setTimeout(function() {
        addBtn.removeAttribute("data-kt-indicator");
    }, 500);

});