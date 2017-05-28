function addMessageForm() {
    var form = $('#addMessageFormulary'),
        active = 0,
        top = $(window).scrollTop(),
        boton = $('#submitmessage');

    form.submit(function(event) {
        event.preventDefault();
        if (active == 0) {
            active = 1;
            data = form.serialize();
            $.ajax({
                url: '/hk/forms/addMessage',
                type: 'POST',
                data: data,
                beforeSend: function(){
                    $('#forerror').html('<div class="loader_error"></div>');
                    boton.attr('disabled', true);
                },
                success: function(error) {
                    $('#forerror').html(' ');
                    if (error.indexOf('exitosamente') == -1) {
                        demo.showNotification('top','right', error, 'danger', 'error');
                    } 

                    if (error.indexOf('exitosamente') != -1) {
                        demo.showNotification('top','right', error, 'success', 'check');
                    }

                    updateMessages();

                    setTimeout(function () {
                        active = 0;
                        boton.attr('disabled', false);
                    }, 500);
                }
            });
        }
    });
    $('#forerror .alert button[data-dismiss="alert"]').click(function(event) {
        event.preventDefault();
        $('#forerror').hide('blind', 300);
    });
}

var loaded = 0;
function updateMessages() {
    $.ajax({
        url: '/hk/ajax/listMessages',
        type: 'POST',
        beforeSend: function (){
            if (!loaded) {
                $('#loader_live').html('<div class="loader_error"></div>');
                loaded = 1;
            }
        }
    })
    .done(function(error) {
        $('#messagesContainer').html(error);
        $('#loader_live').html(' ');
    })
    .fail(function() {
        console.log("Messages > Failed");
    })
    .always(function() {
        console.log("Messages > Loaded");
    });
    
}