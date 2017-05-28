function deleteLogsForm() {
    var boton = $('#deleteAll'),
        active = 0;

    boton.click(function(event) {
        event.preventDefault();
        if (active == 0) {
            active = 1;
            $.ajax({
                url: '/hk/forms/deleteLogs',
                type: 'POST',
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

                    updateLogs();

                    setTimeout(function () {
                        boton.attr('disabled', false);
                        active = 0;
                    }, 500);
                }
            });
        }
    });
}

var loaded = 0;
function updateLogs() {
    $.ajax({
        url: '/hk/ajax/listLogs',
        type: 'POST',
        beforeSend: function (){
            if (!loaded) {
                $('#loader_live1').html('<div class="loader_error"></div>');
                loaded = 1;
            }
        }
    })
    .done(function(error) {
        $('#logsContainer').empty();
        $('#logsContainer').html(error);
        $('#loader_live1').html(' ');
    })
    .fail(function() {
        console.log("Logs > Failed");
    })
    .always(function() {
        console.log("Logs > Loaded");
    });
    
}

function deleteClientLogsForm() {
    var boton = $('#deleteAll'),
        active = 0;

    boton.click(function(event) {
        event.preventDefault();
        if (active == 0) {
            active = 1;
            $.ajax({
                url: '/hk/forms/deleteClientLogs',
                type: 'POST',
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

                    updateClientLogs();

                    setTimeout(function () {
                        boton.attr('disabled', false);
                        active = 0;
                    }, 500);
                }
            });
        }
    });
}

var loadedd = 0;
function updateClientLogs() {
    $.ajax({
        url: '/hk/ajax/listClientLogs',
        type: 'POST',
        beforeSend: function (){
            if (!loadedd) {
                $('#loader_live1').html('<div class="loader_error"></div>');
                loadedd = 1;
            }
        }
    })
    .done(function(error) {
        $('#logsContainer').empty();
        $('#logsContainer').html(error);
        $('#loader_live1').html(' ');
    })
    .fail(function() {
        console.log("Logs > Failed");
    })
    .always(function() {
        console.log("Logs > Loaded");
    });
    
}