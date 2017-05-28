$(document).ready(function() {
    commentForm();    
    updateComments();
    setInterval(function () {
        updateComments();
    }, 5000);
});

function commentForm() {
    var form = $('#commentFormulary'),
        active = 0,
        top = $(window).scrollTop(),
        boton = $('#comment');

    form.submit(function(event) {
        event.preventDefault();
        if (active == 0) {
            active = 1;
            data = form.serialize();
            $.ajax({
                url: '/forms/php/comment',
                type: 'POST',
                data: data,
                beforeSend: function(){
                    $('#error').addClass('loading');
                    $('#error').html('<div class="loader_error"></div>');
                    $('#error').addClass('fixed');
                    boton.attr('disabled', true);
                },
                success: function(error) {
                    $('#error').fadeIn(500, function () {
                        setTimeout(function () {
                            active = 0;
                            boton.attr('disabled', false);
                            updateComments();
                        }, 500);
                    }); 

                    $('#error').removeClass('loading');
                    top = $(window).scrollTop();
                    if (top < 300) {
                        $('#error').removeClass('fixed');
                    }
                    $('#error').html(error);
                    $('#username').val('');
                }
            });
        }
    });
    $('#error .alert button[data-dismiss="alert"]').click(function(event) {
        event.preventDefault();
        $('#error').hide('blind', 300);
    });
}

var loaded = 0;
function updateComments() {
    $.ajax({
        url: comment_id,
        type: 'POST',
        beforeSend: function (){
            if (!loaded) {
                $('#loader_live1').html('<div class="loader_error"></div>');
                loaded = 1;
            }
        }
    })
    .done(function(error) {
        $('#commentsContainer').empty();
        $('#commentsContainer').html(error);
        $('#loader_live1').html(' ');
    })
    .fail(function() {
        console.log("Users > Failed");
    })
    .always(function() {
        console.log("Users > Loaded");
    });
    
}