<?php

	namespace MasterCMS\Views\Texts\Web\Langs\ES;

	use MasterCMS\Config\Config;	

	class Settings {

		public $texts = array(
			'cont' => [
				'error_start' => '<div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><strong>Opps!</strong> ', 
				'error_end' => '</div>', 

				'success_start' => '<div class="alert alert-dismissible alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>&Eacute;xito!</strong> ', 
				'success_end' => '</div>', 
			],

			'texts' => [
				// General
				'empty' => 'No dejes espacios en blanco',
				'invalid_color' => 'El color seleccionado no es valido',
				'dont_try_inyect' => 'No intentes hacer una inyeccion',
				'not_same' => 'Tu contraseña no coincide con la antigüa',
				'not_same_new' => 'Las nuevas contraseñas no coinciden',
				// Password
				'facebook_account' => 'Las cuentas de facebook no tienen autorizacion para realizar esta acci&oacute;n',
				'short_or_large_password' => 'La clave debe contener de 4 a 30 letras',
				'success_pass' => 'Contrase&ntilde;a cambiada exitosamente, espera un momento para loguearte',
				'cant_be_old_pass' => 'La nueva contraseña no puede ser la antigüa',
				'not_numbers_on_pass' => 'La contrase&ntilde;a debe contener n&uacute;meros y letras',
				// Mail
				'success_mail' => 'Se ha enviado un correo electronico a su nuevo correo para verificar el cambio de correo',
				'cant_be_old_mail' => 'El nuevo correo no puede ser el antigüo',
				'invalid_mail' => 'Correo electronico invalido',
				'mail_title' => 'Verificación de correo electronico',
				'not_same_new_mail' => 'Los correos electronicos no coinciden',
				'not_same_mail' => 'Este no es su antigüo correo',
				'mail_used' => 'Este correo electronico ya esta en uso',
				'mail_error' => 'Se ha producido un error al tratar de enviar el correo electronico',
				'mail_sended' => 'Ya se ha enviado un correo electronico a usted, espere 24 horas a que caduque el anterior',
				// Delete
				'success_mail_del' => 'Se ha enviado un correo electronico a su nuevo correo para verificar el cierre de su cuenta',
				'accept' => 'Debes aceptar las consecuencias de el cierre de su cuenta antes de continuar',
				'mail_title_del' => 'Decea eliminar su cuenta?',
				// Normal
				'database' => 'Se ha producido un error en la base de datos',
				'success' => 'Informaci&oacute;n cambiada exitosamente'
			]
		);
	}

?>