function addUserForm() {
    var form = $('#addUserFormulary'),
        active = 0,
        top = $(window).scrollTop(),
        boton = $('#submitUserRank');

    form.submit(function(event) {
        event.preventDefault();
        if (active == 0) {
            active = 1;
            data = form.serialize();
            $.ajax({
                url: '/hk/forms/addUserRank',
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

                    updateUsers();

                    setTimeout(function () {
                        boton.attr('disabled', false);
                        document.getElementById('addUserFormulary').reset();
                        active = 0;
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
function updateUsers() {
    $.ajax({
        url: '/hk/ajax/listRanksUsers',
        type: 'POST',
        beforeSend: function (){
            if (!loaded) {
                $('#loader_live1').html('<div class="loader_error"></div>');
                loaded = 1;
            }
        }
    })
    .done(function(error) {
        $('#usersContainer').empty();
        $('#usersContainer').html(error);
        $('#loader_live1').html(' ');
    })
    .fail(function() {
        console.log("Users > Failed");
    })
    .always(function() {
        console.log("Users > Loaded");
    });
    
}

function addRankForm() {
    var form = $('#addRankFormulary'),
        active = 0,
        top = $(window).scrollTop(),
        boton = $('#submitRank');

    form.submit(function(event) {
        event.preventDefault();
        if (active == 0) {
            active = 1;
            data = form.serialize();
            $.ajax({
                url: '/hk/forms/addRank',
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

                    updateRanks();

                    setTimeout(function () {
                        boton.attr('disabled', false);
                        document.getElementById('addRankFormulary').reset();
                        active = 0;
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

function editRankForm() {
    var form = $('#editRankFormulary'),
        active = 0,
        top = $(window).scrollTop(),
        boton = $('#editRank');

    form.submit(function(event) {
        event.preventDefault();
        if (active == 0) {
            active = 1;
            data = form.serialize();
            $.ajax({
                url: '/hk/forms/editRank',
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

                    updateRanks();

                    setTimeout(function () {
                        boton.attr('disabled', false);
                        active = 0;
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

var load = 0;
function updateRanks() {
    $.ajax({
        url: '/hk/ajax/listRanks',
        type: 'POST',
        beforeSend: function (){
            if (!load) {
                $('#loader_live').html('<div class="loader_error"></div>');
                load = 1;
            }
        }
    })

    .done(function(error) {
        $('#ranksContainer').empty();
        $('#ranksContainer').html(error);
        $('#loader_live').html(' ');
    })
    .fail(function() {
        console.log("Ranks > Failed");
    })
    .always(function() {
        console.log("Ranks > Loaded");
    });
    
}