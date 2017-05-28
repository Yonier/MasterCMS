$(document).ready(function() {
    pinForm();    
});

function pinForm() {
    var form = $('#pinFormulary'),
        active = 0,
        top = $(window).scrollTop(),
        boton = $('#submitpin');

    form.submit(function(event) {
        event.preventDefault();
        if (active == 0) {
            active = 1;
            data = form.serialize();
            $.ajax({
                url: '/hk/forms/createPin/client',
                type: 'POST',
                data: data,
                beforeSend: function(){
                    $('#forerror').html('<div class="loader_error"></div>');
                    boton.attr('disabled', true);
                },
                success: function(error) {
                    setTimeout(function () {
                        active = 0;
                        boton.attr('disabled', false);
                    }, 500);
                    
                    if (error.indexOf('exitosamente') == -1) {
                        demo.showNotification('top','right', error, 'danger', 'error');
                    } 

                    if (error.indexOf('exitosamente') != -1) {
                        demo.showNotification('top','right', error, 'success', 'check');
                    }
                    $('#forerror').html(' ');
                    $('#pin, #rpin').val('');
                }
            });
        }
    });
    $('#forerror .alert button[data-dismiss="alert"]').click(function(event) {
        event.preventDefault();
        $('#forerror').hide('blind', 300);
    });
}