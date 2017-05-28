$(document).ready(function() {
    deleteNew();
});

function deleteNew() {
    var form = $('.deleteNew'),
        active = 0;

    $('.deleteNew').click(function(event) {
        event.preventDefault();
        if (active == 0) {
            active = 1;
            ide = $(this).attr('data-delete');
            $.ajax({
                url: '/hk/forms/deleteNew',
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

                    updateNews();

                    setTimeout(function () {
                        active = 0;
                    }, 500);
                }
            });
        }
    });
}