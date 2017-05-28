<?php

	namespace MasterCMS\Views\Texts\Web\Langs\ES;

	use MasterCMS\Config\Config;	

	class Forgot {

		public $texts = array(
			'cont' => [
				'error_start' => '<div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><strong>Opps!</strong> ', 
				'error_end' => '</div>', 

				'success_start' => '<div class="alert alert-dismissible alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>&Eacute;xito!</strong> ', 
				'success_end' => '</div>', 
			],

			'texts' => [
				'empty' => 'No dejes espacios en blanco',
				'incorrect_data' => 'Su correo electronico no esta registrado en la base de datos',
				'invalid_format' => 'Formato de correo electronico no valido',
				'short_or_large_password' => 'La clave debe contener de 4 a 30 letras',
				'passwords_not_same' => 'Las contase&ntilde;as no coinciden',
				'cant_be_same' => 'La contraseña no puede ser la anterior',
				// Back To Text
				'mail_title' => '¿Has olvidado tu contraseña?',
				'sended' => 'Ya se ha enviado un correo electronico a usted, espere 24 horas a que caduque el anterior',
				'database' => 'Se ha producido un error en la base de datos',
				'mail_error' => 'Se ha producido un error al enviar el correo',
				'not_numbers_on_pass' => 'La contrase&ntilde;a debe contener n&uacute;meros y letras',
				'facebook' => 'Esta cuenta pertenece a un facebook, debe recuperarla desde su cuenta de facebook',
				'success' => 'Se ha enviado tu correo de recuperaci&oacute;n, si no lo encuentras revisa en la parte de correo no deseado (SPAM)',
				'success_val' => 'Se ha modificado tu contraseña correctamente, espere un momento'
			]
		);
	}

?>