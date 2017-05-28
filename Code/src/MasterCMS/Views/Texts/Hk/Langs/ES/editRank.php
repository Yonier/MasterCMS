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

	class editRank {

		public $texts = array(
			'texts' => [
				'empty' => 'No dejes espacios en blanco',
 				'exist_name' => 'Nombre de rango ya existente',
 				'exist_id' => 'ID de rango ya existente',
 				'no_perms' => 'No tienes permisos para utilizar esta funcion',
 				'you_cant' => 'No puedes crear rangos con este tipo',
 				'shorter_or_larger_name' => 'El nombre del rango debe incluir de 3 a 50 caracteres',
 				'shorter_or_larger_color' => 'El color del rango debe incluir de 3 a 7 caracteres',
 				'shorter_or_larger_badge' => 'La placa del rango debe incluir de 2 a 32 caracteres',
 				'invalid_id' => 'ID de rango invalido, inserte uno mayor o igual a 1',
				'database' => 'Se ha producido un error en la base de datos',
				'success' => 'Rango editado exitosamente'
			]
		);
	}

?>