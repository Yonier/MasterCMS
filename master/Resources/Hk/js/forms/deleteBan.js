$(document).ready(function() {
    deleteBan();
});

function deleteBan() {
    var form = $('.deleteBan'),
        active = 0;

    $('.deleteBan').click(function(event) {
        event.preventDefault();
        if (active == 0) {
            active = 1;
            ide = $(this).attr('data-delete');
            $.ajax({
                url: '/hk/forms/deleteBan',
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

                    updateBans();

                    setTimeout(function () {
                        active = 0;
                    }, 500);
                }
            });
        }
    });
}