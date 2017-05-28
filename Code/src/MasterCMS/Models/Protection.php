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

	class Protection {
		
		private $con;

		public function __construct()
		{
			$this->con = new Connection();
		}

		public function encriptPassword($data) 
        { 
            $data = $data . "0193476930483547920343484548935845934934934MASTERCMS234934934";
            return rtrim(strtr(base64_encode($data), '+/', '-_'), '='); 
        } 

        public function decodePassword($data) 
        { 
            $data = $data;
            $data = base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
            $data = explode("0193476930483547920343484548935845934934934MASTERCMS234934934", $data);
            return $data[0];
        }

		public function filter($str)
	    {
	        $str = $this->con->real_escape_string(htmlspecialchars(trim($str)));;
	        $text = $str;
	        $text = str_replace("INSERT","IN-SER-T",$text);
	        $text = str_replace("DELETE","DE-LE-TE",$text);
	        $text = str_replace("TRUNCATE","TRUN-CA-TE",$text);
	        $text = str_replace("SELECT","SE-LEC-T",$text);
	        $text = str_replace("ALTER","AL-TER",$text);
	        $text = str_replace("UPDATE","UP-DA-TE",$text);
	        $text = str_replace("inert","IN-SER-T",$text);
	        $text = str_replace("delete","DE-LE-TE",$text);
	        $text = str_replace("truncate","TRUN-CA-TE",$text);
	        $text = str_replace("select","SE-LEC-T",$text);
	        $text = str_replace("alter","AL-TER",$text);
	        $text = str_replace("update","UP-DA-TE",$text);
	        $text = str_replace("script","",$text);
	        $text = str_replace("SCRIPT","",$text);
	        $text = str_replace('"','&#34;',$text);
	        $text = str_replace("'","&#39;",$text);
	        $text = str_replace("<","&#60;",$text);
	        $text = str_replace(">","&#62;",$text);
	        $text = str_replace("(","",$text);
	        $str = str_replace(")","",$text);
	        return $str;
	    }

	    public function htmlFilter($str)
	    {
	        $str = $this->con->real_escape_string($str);
	        $text = $str;
	        $text = str_replace("INSERT","IN-SER-T",$text);
	        $text = str_replace("DELETE","DE-LE-TE",$text);
	        $text = str_replace("TRUNCATE","TRUN-CA-TE",$text);
	        $text = str_replace("SELECT","SE-LEC-T",$text);
	        $text = str_replace("ALTER","AL-TER",$text);
	        $text = str_replace("UPDATE","UP-DA-TE",$text);
	        $text = str_replace("inert","IN-SER-T",$text);
	        $text = str_replace("delete","DE-LE-TE",$text);
	        $text = str_replace("truncate","TRUN-CA-TE",$text);
	        $text = str_replace("select","SE-LEC-T",$text);
	        $text = str_replace("alter","AL-TER",$text);
	        $text = str_replace("update","UP-DA-TE",$text);
	        $text = str_replace("script","",$text);
	        $text = str_replace("SCRIPT","",$text);
	        return $str;
	    }

	    public function urlFilter($text)
		{
	        $text = html_entity_decode($text);
	        $text = " ".$text;
	        $text = str_replace('(((f|ht){1}tp://)[-a-zA-Z0-9@:%_\+.~#?&//=]+)', '<a href="\\1" target=_blank>\\1</a>', $text);
	        $text = str_replace('(((f|ht){1}tps://)[-a-zA-Z0-9@:%_\+.~#?&//=]+)', '<a href="\\1" target=_blank>\\1</a>', $text);
	        $text = str_replace('([[:space:]()[{}])(www.[-a-zA-Z0-9@:%_\+.~#?&//=]+)', '\\1<a rel="nofollow" href="http://\\2" target=_blank>\\2</a>', $text);
	        $text = str_replace('([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})', '<a href="mailto:\\1" target=_blank>\\1</a>', $text);
	        return $text;
		}  

		public function __destruct()
		{
			$this->con->close();
		}
	}

?>