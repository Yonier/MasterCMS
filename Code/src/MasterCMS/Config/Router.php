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
   
	namespace MasterCMS\Config;

	use MasterCMS\Models\Template;
	use MasterCMS\Models\Hotel;

	class Router {

		public static function run(Request $request)
		{
			$controller = $request->getController() . 'Controller';
			$rute = ROOT . 'src' . DS . 'MasterCMS' . DS . 'Controllers' . DS . $controller . '.php';
			$method = $request->getMethod();
			if ($method == 'index.php') {
				$method = 'index';
			}
			$argument = $request->getArgument();
			$hotel = new Hotel;
			if (is_readable($rute)) {
				$rute_f = ROOT . 'src' . DS . 'MasterCMS' . DS . 'Views' . DS . 'WebViews' . DS . $hotel->getConfig('template_name') . DS . 'Controllers' . DS . $controller . '.php';
				if (is_readable($rute_f)) {
					$view = 'MasterCMS\\Views\\WebViews\\' . $hotel->getConfig('template_name') . '\\Controllers\\' . $controller;
				} else {
					$view = 'MasterCMS\\Controllers\\' . $controller;
				}
				$controller = new $view;
				if (!isset($argument)) {
					call_user_func(array($controller, $method));
				} else {	
					call_user_func_array(array($controller, $method), $argument);
				}

				if (!method_exists($view, $method)) {
					define('ADS', false);
					$template = new Template;
					$template->setEverything();
					$template->setParam('title', 'Error 404');
					$template->addTemplate('Template' . DS . 'Header');
					$template->addTemplate('404');
					$template->addTemplate('Template' . DS . 'Footer');
				}
			} else {
				$rute_f = ROOT . 'src' . DS . 'MasterCMS' . DS . 'Views' . DS . 'WebViews' . DS . $hotel->getConfig('template_name') . DS . 'Controllers' . DS . $controller . '.php';
				if (is_readable($rute_f)) {
					$view = 'MasterCMS\\Views\\WebViews\\' . $hotel->getConfig('template_name') . '\\Controllers\\' . $controller;
					$controller = new $view;
					if (!isset($argument)) {
						call_user_func(array($controller, $method));
					} else {
						call_user_func_array(array($controller, $method), $argument);
					}

					if (!method_exists($view, $method)) {
						define('ADS', false);
						$template = new Template;
						$template->setEverything();
						$template->setParam('title', 'Error 404');
						$template->addTemplate('Template' . DS . 'Header');
						$template->addTemplate('404');
						$template->addTemplate('Template' . DS . 'Footer');
					}
				} else {
					define('ADS', false);
					$template = new Template;
					$template->setEverything();
					$template->setParam('title', 'Error 404');
					$template->addTemplate('Template' . DS . 'Header');
					$template->addTemplate('404');
					$template->addTemplate('Template' . DS . 'Footer');
				}
			}
		}
	}

?>