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

	class generalLogs {

		public $texts = array(
			'texts' => [
				// General
				'empty' => 'No dejes espacios en blanco',
				'no_perms' => 'No tienes los suficientes permisos para ejecutar esta accion',
				'database' => 'Se ha producido un error en la base de datos',
				'not_found' => 'No se ha encontrado el usuario ',
				'success' => 'Se ha realizado la accion exitosamente',
                    'shorter_or_larger_username' => 'Nombre de usuario debe tener de 4 a 15 caracteres',
                    'shorter_or_larger_password' => 'Contrase&ntilde;a debe tener de 4 a 30 caracteres',
                    'shorter_or_larger_motto' => 'Misi&oacute;n debe tener maximo 50 caracteres',
                    'not_exist' => 'Usuario no existente',
                    'exist_username' => 'Nombre de usuario ya esta en uso',
                    'exist_mail' => 'Correo electronico en uso',
                    'invalid_mail' => 'Correo electronico invalido',
                    'not_user' => 'No has seleccionado un usuario',
                    'cant_you' => 'No puedes realizar esta accion contigo',
                    'accept_consequence' => 'Debes aceptar las consecuencias'
			]
		);
	}

?>