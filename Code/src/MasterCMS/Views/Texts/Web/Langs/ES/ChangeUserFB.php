<?php

	namespace MasterCMS\Views\Texts\Web\Langs\ES;

	use MasterCMS\Config\Config;	

	class ChangeUserFB {

		public $texts = array(
			'cont' => [
				'error_start' => '<div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><strong>Opps!</strong> ', 
				'error_end' => '</div>', 

				'success_start' => '<div class="alert alert-dismissible alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>&Eacute;xito!</strong> ', 
				'success_end' => '</div>', 
			],

			'texts' => [
				'empty' => 'No dejes espacios en blanco',
				'incorrect_data' => 'El nombre de usuario ya esta en uso, utilize otro',
				'facebook_account' => 'Esta cuenta pertenece a una cuenta de facebook, no puede ser utilizada por logueo manual',
				'sessioned' => 'Cierra sesi&oacute;n para iniciar sesi&oacute;n en otra cuenta',
				'database' => 'Se ha producido un error en la base de datos',
				'short_or_large_name' => 'El nombre de usuario debe contener de 4 a 15 letras',
				'invalid_name' => 'Nombre de usuario invalido',
				'completed' => 'Se ha cambiado el nombre anteriormente',
				'no_facebook' => 'Esta cuenta no esta asociada a un facebook',
				'success' => 'Has cambiado tu nombre de usuario, espera un momento'
			]
		);
	}

?>