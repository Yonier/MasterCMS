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

	class generalThemes {

		public $texts = array(
			'texts' => [
				// General
				'empty' => 'No dejes espacios en blanco',
				'no_perms' => 'No tienes los suficientes permisos para ejecutar esta accion',
				// Template			
				'fail' => 'Template no se ha podido subir, detalles: <br>',
				'success' => 'Template subido exitosamente, espera un momento',
				// Change Theme
				'not_exist' => 'Tema no existente, verifique de nuevo',
				'not_exist_style' => 'Tema no contiene sus styles, subalos por favor',
				'success_changes' => 'Tema cambiado exitosamente, espere un momento',
				'database' => 'Se ha producido un error en la base de datos',
				// Export Theme
				'success_export' => 'Tema exportado exitosamente, espere un momento',
				// Delete Theme
				'cant_current_del' => 'No puedes eliminar el Theme actual, intentelo desde el servidor',
				'success_delete' => 'Tema eliminado exitosamente',
				// Styles
				'fail_styles' => 'Estilos no se han podido subir, detalles: <br>',
				'success_styles' => 'Estilos subidos exitosamente, espera un momento',
				// Creation
				'cant_create' => 'No se pudo crear el archivo ZIP'
			]
		);
	}

?>