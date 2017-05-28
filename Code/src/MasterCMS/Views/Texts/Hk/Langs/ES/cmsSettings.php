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

	class cmsSettings {

		public $texts = array(
			'texts' => [
				// General
				'no_perms' => 'No tienes los suficientes permisos para ejecutar esta accion',
				'empty' => 'No dejes espacios en blanco',
				// Options
				'success_save' => 'Se han guardado los cambios exitosamente',
				'fail_save' => 'No se pudieron guardar los cambios',
				// Restart
				'accept_conditions' => 'Debes aceptar las condiciones antes de continuar',
				'success_res' => 'Se ha restablecido la configuracion exitosamente, puede que se le cierre la sesion a la Housekeeping debido a que se puessden desconfigurar los min, medium y max ranks',
				'database' => 'Se ha producido un error en la base de datos',
				// Maintenance
				'success_mainte' => 'Configuraci&oacute;n de mantenimiento guardada exitosamente'
			]
		);
	}

?>