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
   
	namespace MasterCMS\Models;

	use MasterCMS\Config\{Config, Connection};

	class Sessions {

		private $con;

		public function __construct()
		{
			$this->con = new Connection;
			$this->protection = new Protection;
		}
		
		public function set($type = 'session', $session, $value, $time = 3600 * 24 * 365, $directory = '/')
		{
			if ($type == 'session') {
				$_SESSION[$session] = $this->protection->filter($value);
			} elseif ($type == 'cookie') {
				setcookie($session, $this->protection->filter($value), time() + $time, $directory);
			}
		}

		public function get($type = 'session', $session)
		{
			if ($type == 'session') {
				if ($_SESSION[$session]) {
					return $this->protection->filter($_SESSION[$session]);
				} else {
					return false;
				}
			} else {
				if ($_COOKIE[$session]) {
					return $this->protection->filter($_COOKIE[$session]);
				} else {
					return false;
				}
			}
		}

		public function delete($type = 'session', $session, $directory = '/')
		{
			if ($type == 'session') {
				if ($session == '*') {
					foreach ($_SESSION as $key => $value) {
						unset($_SESSION[$key]);
					}
				} else {
					if ($_SESSION[$session]) {
						unset($_SESSION[$session]);
					} else {
						return false;
					}
				}
			} else {
				if ($session == '*') {
					foreach ($_COOKIE as $key => $value) {
						setcookie($key, '', time() - 1000, $directory);
					}
				} else {
					if ($_COOKIE[$session]) {
						setcookie($session, '', time() - 1000, $directory);
					} else {
						return false;
					}
				}
			}
		}

		public function __destruct()
		{
			$this->con->close();
		}
	}

?>