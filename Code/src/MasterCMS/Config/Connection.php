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

	class Connection {

		private $data = array(
			'HOST'          =>         '127.0.0.1',
	        'PORT'          =>         '3306',
	        'USER'          =>         'root',
	        'PASS'          =>         '',
	        'DB'            =>         'mastercms'
		);
		
		public $con;

		public function __construct()
		{
	        try {
		        if (version_compare(PHP_VERSION, '7.0.0') <= 0) {
		        	throw new \Exception('MasterCMS is not available for <strong>PHP ' . phpversion() . '</strong><br>' . 'Please install PHP greater than <strong>PHP 7</strong>');
		        } else if (!extension_loaded('mysqli')) {
		        	throw new \Exception('MasterCMS need MySQLi extension');
		        } else if (!extension_loaded('curl')) {
		        	throw new \Exception('MasterCMS need cURL extension');
		        } /* else if (!extension_loaded('sockets')) {
		        	throw new \Exception('MasterCMS need Sockets extension');
		        } */ else {
		        	if (!$this->con) {
		        		$this->run();
		        	}
		        }
	        } catch (\Exception $e) {
	        	die($e->getMessage());
	        }
		}

		public function run()
		{
			try {
    			$this->con = new \mysqli();
    			$this->con->connect($this->data['HOST'], $this->data['USER'], $this->data['PASS'], $this->data['DB'], $this->data['PORT']);
		        $rute = ROOT;
		        $ruteStyles = MAIN_ROOT;

		        if ($this->con->connect_error) {
					throw new \Exception("Error conecting to the MySQL Server: " . $this->con->connect_error);
		        } else if (!$this->con->set_charset("utf8")) {
		            throw new \Exception("Error loading MySQL Character: " . $this->con->error);
		        } else if (!is_writable($rute)) {
	        		throw new \Exception("<b>{$rute}</b> most be writable");
	        	} else if (!is_writable($ruteStyles)) {
	        		throw new \Exception("<b>{$ruteStyles}</b> most be writable");
	        	}
 			} catch (\Exception $e) {
	        	die($e->getMessage());
	        }
		}

		public function query($query) {
        	$result = $this->con->query($query);
	        return $result;
	    }

	    public function num_rows($row)
	    {
    		if (is_object($row)) {
	    		$row = $row->num_rows;
	    	} else {
	    		$row = $this->con->query($row);
	    		$row = $row->num_rows;
	    	}

	    	return $row;
	    }

	    public function fetch_assoc($query)
	    {
	    	if (is_object($query)) {
	    		$query = $query->fetch_assoc();
	    	} else {
	    		$query = $this->con->query($query);
	    		$query = $query->fetch_assoc();
	    	}

	    	return $query;
	    }

	    public function fetch_array($query)
	    {
	    	if (is_object($query)) {
	    		$query = $query->fetch_array();
	    	} else {
	    		$query = $this->con->query($query);
	    		$query = $query->fetch_array();
	    	}
	    	return $query;
	    }

	    public function real_escape_string($str)
	    {
	    	$str = $this->con->real_escape_string($str);
	    	return $str;
	    }

	    public function getMasterVersion()
	    {
	    	return '2.0.0 FREE';
	    }

	    public function close()
	    {
	    	$this->con->close();
	    }

	    public function __destruct()
	    {
	    	if ($this->con) {
	    		$this->close();
	    	}
	    }
	}

?>