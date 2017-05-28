<?php

	namespace MasterCMS\Views\Texts\Web\Langs\ES;

	use MasterCMS\Config\Config;	

	class Refers {

		public $texts = array(
			'cont' => [
				'error_start' => '<div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><strong>Opps!</strong> ', 
				'error_end' => '</div>', 

				'success_start' => '<div class="alert alert-dismissible alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>&Eacute;xito!</strong> ', 
				'success_end' => '</div>', 
			],

			'texts' => [
				'no_awards' => 'Actualmente no hay premios disponibles por referidos',
				'need_refers' => 'Necesitas m&aacute;s referidos para obtener tu premio',
				'reclamed' => 'Ya has reclamado tu premio, ahora toca seguir avanzando para m&aacute;s premios',
				// Back To Text
				'database' => 'Se ha producido un error en la base de datos',
				'success_dec' => 'Tu premio ha sido declinado, espera un momento',
				'success' => 'Tu premio ha sido reclamado, espera un momento'
			]
		);
	}

?>