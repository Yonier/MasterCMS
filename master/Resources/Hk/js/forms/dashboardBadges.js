function uploadBadgeForm() {
    var form = $('#uploadBadgeFormulary'),
        active = 0,
        top = $(window).scrollTop(),
        boton = $('#uploadBadge');

    form.submit(function(event) {
        event.preventDefault();
        if (active == 0) {
            active = 1;
            data = form.serialize();
            $.ajax({
                url: '/hk/forms/uploadBadge',
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

                    setTimeout(function () {
                        active = 0;
                        boton.attr('disabled', false);
                        document.getElementById('uploadBadgeFormulary').reset();
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

function uploadBadgeZIPForm() {
    var form = $('#uploadBadgeZIPFormulary'),
        active = 0,
        top = $(window).scrollTop(),
        boton = $('#uploadBadgeZIP');

    form.submit(function(event) {
        event.preventDefault();
        if (active == 0) {
            active = 1;
            data = form.serialize();
            $.ajax({
                url: '/hk/forms/uploadBadgeZIP',
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

                    setTimeout(function () {
                        active = 0;
                        boton.attr('disabled', false);
                        document.getElementById('uploadBadgeZIPFormulary').reset();
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

function submitBadgeInfoForm() {
    var form = $('#submitBadgeInfoFormulary'),
        active = 0,
        top = $(window).scrollTop(),
        boton = $('#submitBadgeInfo');

    form.submit(function(event) {
        event.preventDefault();
        if (active == 0) {
            active = 1;
            data = form.serialize();
            $.ajax({
                url: '/hk/forms/submitBadgeInfo',
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

                    setTimeout(function () {
                        active = 0;
                        boton.attr('disabled', false);
                        document.getElementById('submitBadgeInfoFormulary').reset();
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

function deleteBadgeForm() {
    var form = $('#deleteBadgeFormulary'),
        active = 0,
        top = $(window).scrollTop(),
        boton = $('#deleteBadge');

    form.submit(function(event) {
        event.preventDefault();
        if (active == 0) {
            active = 1;
            data = form.serialize();
            $.ajax({
                url: '/hk/forms/deleteBadge',
                type: 'POST',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function(){
                    $('#forerror4').html('<div class="loader_error"></div>');
                    boton.attr('disabled', true);
                },
                success: function(error) {
                    $('#forerror4').html(' ');
                    if (error.indexOf('exitosamente') == -1) {
                        demo.showNotification('top','right', error, 'danger', 'error');
                    } 

                    if (error.indexOf('exitosamente') != -1) {
                        demo.showNotification('top','right', error, 'success', 'check');
                    }

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

function deleteThemeForm() {
    var form = $('#deleteThemeFormulary'),
        active = 0,
        top = $(window).scrollTop(),
        boton = $('#deleteTheme');

    form.submit(function(event) {
        event.preventDefault();
        if (active == 0) {
            active = 1;
            data = form.serialize();
            $.ajax({
                url: '/hk/forms/deleteTheme',
                type: 'POST',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function(){
                    $('#forerror5').html('<div class="loader_error"></div>');
                    boton.attr('disabled', true);
                },
                success: function(error) {
                    $('#forerror5').html(' ');
                    if (error.indexOf('exitosamente') == -1) {
                        demo.showNotification('top','right', error, 'danger', 'error');
                    } 

                    if (error.indexOf('exitosamente') != -1) {
                        demo.showNotification('top','right', error, 'success', 'check');
                    }

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