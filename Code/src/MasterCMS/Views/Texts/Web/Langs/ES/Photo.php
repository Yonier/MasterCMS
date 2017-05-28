<?php

	namespace MasterCMS\Views\Texts\Web\Langs\ES;

	use MasterCMS\Config\Config;	

	class Photo {

		public $texts = array(
			'cont' => [
				'error_start' => '<div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><strong>Opps!</strong> ', 
				'error_end' => '</div>', 

				'success_start' => '<div class="alert alert-dismissible alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>&Eacute;xito!</strong> ', 
				'success_end' => '</div>', 
			],

			'texts' => [
				'empty' => 'No dejes espacios en blanco',
				'exist' => 'Esta imagen ya existe',
				'invalid_file' => 'Formato de archivo invalido',
				'invalid_size' => 'Tama&ntilde;o de archivo invalido',
				'cant' => 'No se pudo subir la imagen',
				'database' => 'Se ha producido un error en la base de datos',
				'success' => 'Imagen subida exitosamente'
			]
		);
	}

?>