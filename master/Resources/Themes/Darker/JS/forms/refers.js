$(document).ready(function() {

    $('#ref_B').click(function(){

        var data = $('#ref_B').data('done');

        ClipboardHelper.copyText($('#refers_link').val());
        $('#tlll').html('<h3>'+ data +'</h3>');

    });

    refersForm();   
    refersdecForm();

});

var ClipboardHelper = {

        copyText:function(text) // Linebreaks with \n
        {
            var $tempInput =  $("<textarea>");
            $("body").append($tempInput);
            $tempInput.val(text).select();
            document.execCommand("copy");
            $tempInput.remove();
        }
    };

function refersForm() {
    var form = $('#refersFormulary'),
        active = 0,
        top = $(window).scrollTop(),
        boton = $('#acceptreward')

    form.submit(function(event) {
        event.preventDefault();
        if (active == 0) {
            active = 1;
            data = form.serialize();
            $.ajax({
                url: '/forms/php/refers',
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
                        }, 500);
                    });

                    $('#error').removeClass('loading');
                    top = $(window).scrollTop();
                    if (top < 300) {
                        $('#error').removeClass('fixed');
                    } 
                    $('#error').html(error);
                    $('#password, #rpassword').val('');
                }
            });
        }
    });

	$('#error .alert button[data-dismiss="alert"]').click(function(event) {
        event.preventDefault();
        $('#error').hide('blind', 300);
    });
}

function refersdecForm() {
    var form = $('#refersdecFormulary'),
        active = 0,
        boton = $('decline_reward');

    form.submit(function(event) {
        event.preventDefault();
        if (active == 0) {
            active = 1;
            data = form.serialize();
            $.ajax({
                url: '/forms/php/refers/dec',
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
                        }, 1000);
                    }); 
                    $('#error').removeClass('loading');
                    top = $(window).scrollTop();
                    if (top < 300) {
                        $('#error').removeClass('fixed');
                    } 
                    $('#error').html(error);
                    $('#password, #rpassword').val('');
                }
            });
        }
    });

    $('#error .alert button[data-dismiss="alert"]').click(function(event) {
        event.preventDefault();
        $('#error').hide('blind', 300);
    });
}