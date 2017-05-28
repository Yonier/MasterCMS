<?php

	namespace MasterCMS\Views\Texts\Web\Langs\ES;

	use MasterCMS\Config\Config;	

	class Register {

		public $texts = array(
			'cont' => [
				'error_start' => '<div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><strong>Opps!</strong> ', 
				'error_end' => '</div>', 

				'success_start' => '<div class="alert alert-dismissible alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>&Eacute;xito!</strong> ', 
				'success_end' => '</div>', 
			],

			'texts' => [
				'empty' => 'No dejes espacios en blanco',
				'invalid_name' => 'Nombre de usuario inválido',
				'short_or_large_name' => 'El nombre de usuario debe contener de 4 a 15 letras',
				'short_or_large_password' => 'La clave debe contener de 4 a 30 letras',
				'banned_1' => 'Has sido baneado por: <strong>',
				'banned_2' => '</strong> por la razón: <strong>',
				'banned_3' => '</strong><br> Tu baneo expira el: <strong>',
				'banned_4' => '</strong>',
				'unbanned' => 'Ha acabado tu tiempo de baneo, espera un momento',
				'user_exist' => 'Este usuario ya existe, utiliza otro',
				'mail_exist' => 'Este correo electronico ya existe, utiliza otro',
				'mails_not_same' => 'Los correos electronicos no coinciden',
				'maintenance' => 'El sitio web se encuentra en mantenimiento, acceda en otro momento!',
				'passwords_not_same' => 'Las contase&ntilde;as no coinciden',
				'invalid_mail' => 'Correo electronico inválido',
				'max_accounts' => 'Has superado el limite de cuentas registradas por IP: ',
				'sessioned' => 'Cierra sesi&oacute;n para registrar otra cuenta',
				'not_numbers_on_pass' => 'La contrase&ntilde;a debe contener n&uacute;meros y letras',
				'agree_terms' => 'Debes aceptar los terminos antes de continuar',
				'database' => 'Se ha producido un error en la base de datos',
				'success' => 'Te has registrado &eacute;xitosamente, espera un momento'
			]
		);
	}

?>