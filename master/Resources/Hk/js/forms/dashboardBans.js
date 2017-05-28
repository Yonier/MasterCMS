function submitNewForm() {
    var form = $('#submitBanFormulary'),
        active = 0,
        top = $(window).scrollTop(),
        boton = $('#submitBan');

    form.submit(function(event) {
        event.preventDefault();
        if (active == 0) {
            active = 1;
            data = form.serialize();
            $.ajax({
                url: '/hk/forms/submitBan',
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

                    updateBans();

                    setTimeout(function () {
                        boton.attr('disabled', false);
                        active = 0;
                        document.getElementById('submitBanFormulary').reset();
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
function updateBans() {
    $.ajax({
        url: '/hk/ajax/listBans',
        type: 'POST',
        beforeSend: function (){
            if (!loaded) {
                $('#loader_live1').html('<div class="loader_error"></div>');
                loaded = 1;
            }
        }
    })
    .done(function(error) {
        $('#bansContainer').empty();
        $('#bansContainer').html(error);
        $('#loader_live1').html(' ');
    })
    .fail(function() {
        console.log("Bans > Failed");
    })
    .always(function() {
        console.log("Bans > Loaded");
    });
    
}