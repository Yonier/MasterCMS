<?php

	namespace MasterCMS\Views\Texts\Web\Langs\ES;

	use MasterCMS\Config\Config;	

	class Login {

		public $texts = array(
			'cont' => [
				'error_start' => '<div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><strong>Opps!</strong> ', 
				'error_end' => '</div>', 

				'success_start' => '<div class="alert alert-dismissible alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>&Eacute;xito!</strong> ', 
				'success_end' => '</div>', 
			],

			'texts' => [
				'empty' => 'No dejes espacios en blanco',
				'incorrect_data' => 'Nombre de usuario o contrase&ntilde;a incorrecta',
				'facebook_account' => 'Esta cuenta pertenece a una cuenta de facebook, no puede ser utilizada por logueo manual',
				'banned_1' => 'Has sido baneado por: <strong>',
				'banned_2' => '</strong> por la razón: <strong>',
				'banned_3' => '</strong><br> Tu baneo expira el: <strong>',
				'banned_4' => '</strong>',
				'unbanned' => 'Ha acabado tu tiempo de baneo, espera un momento',
				'account_has_2' => 'Se registraron 2 cuentas o mas con el mismo nombre, contacte con un administrador para solucionar este error',
				'sessioned' => 'Cierra sesi&oacute;n para realizar esta acci&oacute;n, <a href="/web/logout">Click aqu&iacute;</a>',
				'maintenance' => 'El sitio web se encuentra en mantenimiento, acceda en otro momento!',
				'unsessioned' => 'Abre sesi&oacute;n para realizar esta acci&oacute;n, <a href="/web">Click aqu&iacute;</a>',
				'database' => 'Se ha producido un error en la base de datos',
				'success' => 'Has iniciado sesi&oacute;n, espera un momento'
			]
		);
	}

?>