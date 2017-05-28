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

	class uploadMPU {

		public $texts = array(
			'texts' => [
				// General
				'no_perms' => 'No tienes los suficientes permisos para ejecutar esta accion',
				'empty' => 'No dejes espacios en blanco',
				// Badge			
				'fail' => 'MPU no se ha podido subir, detalles: <br>',
				'success' => 'MPU subido exitosamente',
				// Pack
				'fail_pack' => 'Pack de MPUS no se ha podido subir, detalles: <br>',
				'success_pack' => 'Pack de MPUS subido exitosamente',
				// Delete
				'not_exist' => 'Este MPU no existe',
				'fail_del' => 'No se pudo eliminar el MPU',
				'success_del' => 'MPU eliminado exitosamente'
			]
		);
	}

?>