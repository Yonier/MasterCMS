function uploadMPUForm() {
    var form = $('#uploadMPUFormulary'),
        active = 0,
        top = $(window).scrollTop(),
        boton = $('#uploadMPU');

    form.submit(function(event) {
        event.preventDefault();
        if (active == 0) {
            active = 1;
            data = form.serialize();
            $.ajax({
                url: '/hk/forms/uploadMPU',
                type: 'POST',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
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

                    updateMPUS();

                    setTimeout(function () {
                        active = 0;
                        boton.attr('disabled', false);
                        document.getElementById('uploadMPUFormulary').reset();
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

function uploadMPUZIPForm() {
    var form = $('#uploadMPUZIPFormulary'),
        active = 0,
        top = $(window).scrollTop(),
        boton = $('#uploadMPUZIP');

    form.submit(function(event) {
        event.preventDefault();
        if (active == 0) {
            active = 1;
            data = form.serialize();
            $.ajax({
                url: '/hk/forms/uploadMPUZIP',
                type: 'POST',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function(){
                    $('#forerror2').html('<div class="loader_error"></div>');
                    boton.attr('disabled', true);
                },
                success: function(error) {
                    $('#forerror2').html(' ');
                    if (error.indexOf('exitosamente') == -1) {
                        demo.showNotification('top','right', error, 'danger', 'error');
                    } 

                    if (error.indexOf('exitosamente') != -1) {
                        demo.showNotification('top','right', error, 'success', 'check');
                    }

                    updateMPUS();

                    setTimeout(function () {
                        active = 0;
                        boton.attr('disabled', false);
                        document.getElementById('uploadMPUZIPFormulary').reset();
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

function deleteMPUForm() {
    var form = $('#deleteMPUFormulary'),
        active = 0,
        top = $(window).scrollTop(),
        boton = $('#deleteMPU');

    form.submit(function(event) {
        event.preventDefault();
        if (active == 0) {
            active = 1;
            data = form.serialize();
            $.ajax({
                url: '/hk/forms/deleteMPU',
                type: 'POST',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function(){
                    $('#forerror3').html('<div class="loader_error"></div>');
                    boton.attr('disabled', true);
                },
                success: function(error) {
                    $('#forerror3').html(' ');
                    if (error.indexOf('exitosamente') == -1) {
                        demo.showNotification('top','right', error, 'danger', 'error');
                    } 

                    if (error.indexOf('exitosamente') != -1) {
                        demo.showNotification('top','right', error, 'success', 'check');
                    }

                    updateMPUS();

                    setTimeout(function () {
                        active = 0;
                        boton.attr('disabled', false);
                        document.getElementById('deleteMPUFormulary').reset();
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
function updateMPUS() {
    $.ajax({
        url: '/hk/ajax/listMPUS',
        type: 'POST',
        beforeSend: function (){
            if (!loaded) {
                $('#loader_live1').html('<div class="loader_error"></div>');
                loaded = 1;
            }
        }
    })
    .done(function(error) {
        $('#mpusContainer').empty();
        $('#mpusContainer').html(error);
        $('#loader_live1').html(' ');
    })
    .fail(function() {
        console.log("MPUS > Failed");
    })
    .always(function() {
        console.log("MPUS > Loaded");
    });
    
}