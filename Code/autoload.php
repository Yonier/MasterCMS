<?php

	class Autoload {

		public static function run()
		{
			// Constants
			session_start();
			define('ROOT', __DIR__ . DS);			

			// Geolocalize IP
			try {
				$rute = ROOT . 'src' . DS . 'MasterCMS' . DS . 'Models' . DS . 'GeoIP.php';
				if (!is_readable($rute)) {
					throw new Exception("MasterCMS: Cannot get file <strong>{$rute}</strong>");
				} else {
					require_once $rute;
				}
			} catch (Exception $e) {
				die($e->getMessage());
			}

			// Autoload
			spl_autoload_register(function($class){
				try {
					$rute = ROOT . 'src' . DS . $class . '.php';
					$last = strstr($rute, -14, 14);
					if ($last != 'Texts' . DS . 'Main.php') {
						if (!is_readable($rute)) {
							throw new Exception("MasterCMS: Cannot get file <strong>{$rute}</strong>");
						} else {
							require_once $rute;
						}
					}
				} catch (Exception $e) {
					die($e->getMessage());
				}
			});
		}
	}

?>