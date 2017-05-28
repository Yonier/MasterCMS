$(document).ready(function() {
    forgotForm();    
});

function forgotForm() {
    var form = $('#forgotFormulary'),
        active = 0,
        top = $(window).scrollTop(),
        boton = $('#forgot');

    form.submit(function(event) {
        event.preventDefault();
        if (active == 0) {
            active = 1;
            data = form.serialize();
            $.ajax({
                url: '/forms/php/forgot_validation',
                type: 'POST',
                data: data,
                beforeSend: function(){
                    $('#forerror').html('<div class="loader_error"></div>');
                    boton.attr('disabled', true);
                },
                success: function(error) {
                    $('#forerror').fadeIn(500, function () {
                        setTimeout(function () {
                            active = 0;
                            boton.attr('disabled', false);
                        }, 500);
                    }); 
                    $('#forerror').html(error);
                    $('#password, #rpassword').val('');
                }
            });
        }
    });
    $('#forerror .alert button[data-dismiss="alert"]').click(function(event) {
        event.preventDefault();
        $('#forerror').hide('blind', 300);
    });
}