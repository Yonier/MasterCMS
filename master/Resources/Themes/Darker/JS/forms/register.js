$(document).ready(function() {
    registerForm();    
});

function registerForm() {
    var form = $('#registerFormulary'),
        active = 0,
        top = $(window).scrollTop(),
        boton = $('#register');

    form.submit(function(event) {
        event.preventDefault();
        if (active == 0) {
            active = 1;
            var user = $('#username').val();
            var pass = $('#password').val();
            var rpass = $('#rpassword').val();
            var mail = $('#mail').val();
            var rmail = $('#rmail').val();
            var remember = $('#remember').val();
            var gender = $('#gender').val();
            var terms = $('#terms').val();
            // var data = 'username='+user+'&password='+pass+'&mail='+mail+'&rmail='+rmail+'&rpassword='+rpass+'&terms='+terms+'&look=hr-893-1036.hd-209-1.ch-3030-82.lg-275-92.sh-295-110.ha-1012&gender='+gender;
            data = form.serialize();
            $.ajax({
                url: '/forms/php/register',
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