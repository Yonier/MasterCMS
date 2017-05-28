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
   
	namespace MasterCMS\Views\WebViews\Darker\Langs\ES\Texts;

	use MasterCMS\Config\Config;	

	class Main {

		public $texts = array(
			'cont' => [
				'error_start' => '<script>$(document).ready(function() {alertify.error("',
				'error_end' => '"); });</script>',
				'success_start' => '<script>$(document).ready(function() {alertify.success("',
				'success_end' => '"); });</script>'
			],

			'titles' => [
				'index' => 'Diversión sin límites, Habbo Creditos, HC y más gratis',
				'me' => '{@user_username}',
				'maintenance' => 'Mantenimiento',
				'register' => 'Registro',
				'news' => 'Noticias',
				'community' => 'Comunidad',
				'account_settings' => 'Ajustes de cuenta',
				'adblock' => 'Desactive el AdBlock',
				'profiles' => 'Perfil de {@user_username}',
				'tops' => 'Tops del hotel',
				'logout' => 'Cerrando sesi&oacute;n',
				'404' => 'Error 404',
				'deleted_account' => 'Cuenta eliminada',
				'cookies' => 'Política de Cookies',
				'terms' => 'Términos y condiciones',
				'mastercms' => 'Cr&eacute;ditos de MasterCMS',
				'team' => 'Equipo administrativo',
				'client' => 'Diversión dentro del hotel',
				'client_pin' => 'C&oacute;digo de seguridad del client',
				'client_pin_create' => 'Crear c&oacute	;digo de seguridad del client',
				'theme_info' => 'Informaci&oacute;n de el tema {@theme_name}'
			],

			'mails' => [
				'account_created' => 'Cuenta creada',
				'password_changed' => 'Clave cambiada',
				'mail_changed' => 'Correo electronico cambiado',
				'account_deleted' => 'Cuenta eliminada'
			],
		);
	}

?>