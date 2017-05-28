$(document).ready(function() {
    deleteRankUser();
});

function deleteRankUser() {
    var form = $('.deleteRankUser'),
        active = 0;

    $('.deleteRankUser').click(function(event) {
        event.preventDefault();
        if (active == 0) {
            active = 1;
            ide = $(this).attr('data-delete');
            $.ajax({
                url: '/hk/forms/deleteUserRank',
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

                    updateUsers();

                    setTimeout(function () {
                        active = 0;
                    }, 500);
                }
            });
        }
    });
}