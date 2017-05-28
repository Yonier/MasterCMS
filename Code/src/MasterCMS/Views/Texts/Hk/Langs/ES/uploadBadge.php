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

	class uploadBadge {

		public $texts = array(
			'texts' => [
				// General
				'no_perms' => 'No tienes los suficientes permisos para ejecutar esta accion',
				'empty' => 'No dejes espacios en blanco',
				// Badge			
				'fail' => 'Placa no se ha podido subir, detalles: <br>',
				'success' => 'Placa subida exitosamente',
				// Pack
				'fail_pack' => 'Pack de placas no se ha podido subir, detalles: <br>',
				'success_pack' => 'Pack de placas subido exitosamente',
				// Change
				'no_flash_texts' => 'No se encontro el External Flash Texts',
				'cant_open' => 'No se pudo abrir el External Variables',
				'cant_write' => 'No se pudo escribir en el External Variables',
				'success_mod' => 'Se cambio la informaci&oacute;n de la placa exitosamente',
				// Delete
				'not_exist' => 'Esta placa no existe',
				'fail_del' => 'No se pudo eliminar la placa',
				'success_del' => 'Placa eliminada exitosamente'
			]
		);
	}

?>