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

	class createPin {

		public $texts = array(

			'texts' => [
				'empty' => 'No dejes espacios en blanco',
				'not_same' => 'Los codigos de seguridad no coinciden',
				'shorter_or_larger' => 'El codigo de seguridad debe tener de 4 a 30 caracteres',
				'has_pin' => 'Ya has asignado un codigo de seguridad',
				'not_numbers_on_pass' => 'El codigo de seguridad debe contener n&uacute;meros y letras',
				'database' => 'Se ha producido un error en la base de datos',
				'success' => 'Has asignado tu codigo de seguridad del housekeeping exitosamente, espera un momento',
				'success_client' => 'Has asignado tu codigo de seguridad del client exitosamente, espera un momento'
			]
		);
	}

?>