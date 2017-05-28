$(document).ready(function() {
    deleteMessage();
});

function deleteMessage() {
    var form = $('.deleteMessage'),
        active = 0;

    $('.deleteMessage').click(function(event) {
        event.preventDefault();
        if (active == 0) {
            active = 1;
            ide = $(this).attr('data-delete');
            $.ajax({
                url: '/hk/forms/deleteMessage',
                type: 'POST',
                data: {id: ide},
                beforeSend: function(){
                    $('#forerror').html('<div class="loader_error"></div>');
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
                    }, 500);
                }
            });
        }
    });
}