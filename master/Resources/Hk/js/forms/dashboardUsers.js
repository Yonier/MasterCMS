function editUserSearchForm() {
    var form = $('#editUserSearchFormulary'),
        active = 0,
        boton = $('#editUserSearch');

    form.submit(function(event) {
        event.preventDefault();
        if (active == 0) {
            active = 1;
            data = form.serialize();
            $.ajax({
                url: '/hk/forms/editUserSearch',
                type: 'POST',
                data: data,
                beforeSend: function(){
                    $('#listUsers').html('<div class="loader_error"></div>');
                    boton.attr('disabled', true);
                },
                success: function(error) {
                    $('#listUsers').html(' ');
                    $('#listUsers').html(error);

                    setTimeout(function () {
                        boton.attr('disabled', false);
                        active = 0;
                    }, 500);
                }
            });
        }
    });
}

function editUserForm() {
    var form = $('#editUserFormulary'),
        active = 0,
        top = $(window).scrollTop(),
        boton = $('#editUser');

    form.submit(function(event) {
        event.preventDefault();
        if (active == 0) {
            active = 1;
            data = form.serialize();
            $.ajax({
                url: '/hk/forms/editUser',
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

function deleteUserForm() {
    var form = $('#deleteUserFormulary'),
        active = 0,
        top = $(window).scrollTop(),
        boton = $('#deleteUser');

    form.submit(function(event) {
        event.preventDefault();
        if (active == 0) {
            active = 1;
            data = form.serialize();
            $.ajax({
                url: '/hk/forms/deleteUser',
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
                        document.getElementById('deleteUserFormulary').reset();
                    }, 500);
                }
            });
        }
    });
}

function syncAccountForm() {
    var form = $('#syncAccountFormulary'),
        active = 0,
        top = $(window).scrollTop(),
        boton = $('#syncAccount');

    form.submit(function(event) {
        event.preventDefault();
        if (active == 0) {
            active = 1;
            data = form.serialize();
            $.ajax({
                url: '/hk/forms/syncAccount',
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
                        document.getElementById('syncAccountFormulary').reset();
                    }, 500);
                }
            });
        }
    });
}