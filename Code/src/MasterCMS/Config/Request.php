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

	class Request {

		private $controller;
		private $method;
		private $argument;

		public function __construct()
		{
			if (isset($_GET['url'])) {
				$rute = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
				$rute = explode('/', $rute);
				$rute = array_filter($rute);

				if ($rute[0] == 'index.php') {
					$this->controller = 'web';
				} else {
					$this->controller = strtolower(array_shift($rute));
				}
				
				$this->method = strtolower(array_shift($rute));

				if (!$this->method) {
					$this->method = 'index';
				}

				$this->argument = $rute;
			} else {
				$this->controller = 'web';
				$this->method = 'index';
			}

		}

		public function getController()
		{
			return $this->controller;
		}

		public function getMethod()
		{
			return $this->method;
		}

		public function getArgument()
		{
			return $this->argument;
		}
	}

?>