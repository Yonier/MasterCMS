<?php
    
    /**
     *
     *   MasterCMS
     *
     *   Copyright (c) 2017 MasterCMS
     *
     *   @author <Denzel Code>
     *   -------------------------------------------------------------------------
     *   Licensed under the Apache License, Version 2.0 (the "License");
     *   you may not use this file except in compliance with the License.
     *   You may obtain a copy of the License at
     *
     *       http://www.apache.org/licenses/LICENSE-2.0
     *
     *   Unless required by applicable law or agreed to in writing, software
     *   distributed under the License is distributed on an "AS IS" BASIS,
     *   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
     *   See the License for the specific language governing permissions and
     *   limitations under the License.
     *   -------------------------------------------------------------------------
    */
   
	namespace MasterCMS\Views\Texts\Hk\Langs\ES;

	use MasterCMS\Config\Config;	

	class submitPin {

		public $texts = array(
			'cont' => [
				'error_start' => '<div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><strong>Opps!</strong> ', 
				'error_end' => '</div>', 

				'success_start' => '<div class="alert alert-dismissible alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>&Eacute;xito!</strong> ', 
				'success_end' => '</div>', 
			],

			'texts' => [
				'empty' => 'No dejes espacios en blanco',
				'invalid_data' => 'Este no es su codigo de seguridad',
				'sessioned' => 'Ya has iniciado tu codigo de seguridad',
 				'no_perms' => 'No tienes permisos para ejecutar esta accion',
 				'log_to_make' => 'Debes loguearte con tu codigo de seguridad para ejecutar esta acci&oacute;n',
				'database' => 'Se ha producido un error en la base de datos',
				'success' => 'Has accedido a el panel de administraci&oacute;n exitosamente, espera un momento',
				'success_client' => 'Has accedido a el client exitosamente, espera un momento'
			]
		);
	}

?>