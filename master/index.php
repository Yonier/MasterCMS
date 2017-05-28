<?php 

	// Constants
	error_reporting(0);
	@ini_set('upload_max_filesize', '150M');
	@ini_set('post_max_size', '150M');
	define('DS', DIRECTORY_SEPARATOR);
	define('DIRECTORY', realpath(dirname(__DIR__)) . DS);
	define('MAIN_ROOT', __DIR__ . DS);
	define('URL', $_SERVER['HTTP_HOST']);
	if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
		define('TYPE_HTTP', 'https://');
	} else {
		define('TYPE_HTTP', 'http://');
	}
	date_default_timezone_set('Europe/Madrid');
	
	// Autoloader Require
	try {
		$rute = DIRECTORY . 'Code' . DS . 'Autoload.php';
		if (is_readable($rute)) {
			require_once $rute;
		} else {
			$rute = MAIN_ROOT . 'Code' . DS . 'Autoload.php';
			if (is_readable($rute)) {
				require_once $rute;
			} else {
				throw new Exception("Autoload class was not founded");
			}
		}
	} catch (Exception $e) {
		die($e->getMessage());
	}

	// Run Code
	Autoload::run();
	MasterCMS\Config\Router::run(new MasterCMS\Config\Request());
	
?>