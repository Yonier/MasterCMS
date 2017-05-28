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

    class Hotel {

        private $con;
        private $config;
        private $sessions;

        public function __construct()
        {
            $this->con = new Connection();
            $this->config = new Config();
            $this->sessions = new Sessions();
            foreach ($this->config->select['DEFAULT_DB_CONFIG'] as $key => $value) {
                if (!$this->getConfig(strtolower($key))) {
                    $this->setConfig(strtolower($key), $value);
                }
            }

            $template_name = $this->getConfig('template_name');

            $rute = ROOT . 'src' . DS . 'MasterCMS' . DS . 'Views' . DS . 'WebViews' . DS . $template_name . DS;

            if (!file_exists($rute)) {
                die("Template {$template_name} doesn't exist");
            }

            if (!file_exists($rute . 'Langs' . DS . $this->config->select['WEB']['LANG'] . DS)) {
                die("Template {$template_name} doesn't have the {$this->config->select['WEB']['LANG']} language");
            }

            if (!file_exists($rute . 'Langs' . DS . $this->config->select['WEB']['LANG'] . DS . 'Texts' . DS . 'Main.php')) {
                die("Template {$template_name} doesn't have the Texts/Main.php file");
            } else {
                $class = "MasterCMS\\Views\\WebViews\\{$template_name}\\Langs\\{$this->config->select['WEB']['LANG']}\\Texts\\Main";
                if (!class_exists($class)) {
                    die("Template {$template_name} doesn't have the <b>{$class}</b> class");
                }
            }

            $theme_config = $rute . '.theme_config';
            $theme_autoconfigured = $rute . '.theme_autoconfigured';
            $db = $rute . 'db.sql';

            $file = fopen($theme_autoconfigured, 'a');
            foreach (new \SplFileObject($theme_autoconfigured) as $key => $value) {
                if ($key == 0) {
                    $autoconfigured = $value;
                }
            }

            if (!$autoconfigured) {
                unlink($theme_autoconfigured);
                if (file_exists($db)) {
                    $query = $this->con->query(file_get_contents($db));
                    if ($query) {
                        if (file_exists($theme_config)) {
                            foreach (new \SplFileObject($theme_config) as $key => $value) {
                                // Set Configs
                                if ($key == 0) {
                                    if (!empty($value)) {
                                        $theme_name = $value;
                                    }
                                }

                                if ($key == 1) {
                                    if (!empty($value)) {
                                        $theme_version = $value;
                                    }
                                }

                                if ($key == 2) {
                                    if (!empty($value)) {
                                        $theme_description = $value;
                                    }
                                }

                                if ($key == 3) {
                                    if (!empty($value)) {
                                        $theme_author = $value;
                                    }
                                }

                                if ($key == 4) {
                                    if (!empty($value)) {
                                        $theme_creation = $value;
                                    }
                                }

                                if ($key == 5) {
                                    if (!empty($value)) {
                                        $theme_licence = $value . "\n";
                                    }
                                }                                
                            }

                            $update = fwrite($file, 1 . "\n");
                            $update .= fwrite($file, $theme_name);
                            $update .= fwrite($file, $theme_version);
                            $update .= fwrite($file, $theme_description);
                            $update .= fwrite($file, $theme_author);
                            $update .= fwrite($file, $theme_creation);
                            $update .= fwrite($file, $theme_licence);
                            $theme_installed = date('d/m/Y - h:i:s', time());
                            $update .= fwrite($file, $theme_installed);
                            if (file_exists($rute . '.theme_autoconfigured')) {
                                exec("attrib +h {$rute}.theme_autoconfigured");
                            }
                            if (file_exists($rute . '.theme_config')) {
                                exec("attrib +h {$rute}.theme_config");
                            }
                            if (!$update) {
                                die("Can't write");
                            }
                        } else {
                            fwrite($file, 1 . "\n");
                            $theme_name = $this->config->select['WEB']['NAME'] . ' Theme' . "\n";
                            $theme_version = "1.0.0\n";
                            $theme_description = 'Default theme configuration' . "\n";
                            $theme_author = 'MasterCMS developers' . "\n";
                            $theme_creation = date('d/m/Y', time()) . "\n";
                            $theme_licence = "Free trial licence for {$this->config->select['WEB']['NAME']}" . "\n";
                            $theme_installed = date('d/m/Y - h:i:s', time());
                            $update = fwrite($file, $theme_name);
                            $update = fwrite($file, $theme_version);
                            $update .= fwrite($file, $theme_description);
                            $update .= fwrite($file, $theme_author);
                            $update .= fwrite($file, $theme_creation);
                            $update .= fwrite($file, $theme_licence);
                            $update .= fwrite($file, $theme_installed);
                            if (file_exists($rute . '.theme_autoconfigured')) {
                                exec("attrib +h {$rute}.theme_autoconfigured");
                            }
                            if (file_exists($rute . '.theme_config')) {
                                exec("attrib +h {$rute}.theme_config");
                            }
                            if (!$update) {
                                die("Can't write");
                            }
                        }
                    } else {
                        die("Theme SQL can't it be imported");
                    }
                } else {
                    if (file_exists($theme_config)) {
                        foreach (new \SplFileObject($theme_config) as $key => $value) {
                            // Set Configs
                            if ($key == 0) {
                                if (!empty($value)) {
                                    $theme_name = $value;
                                }
                            }

                            if ($key == 1) {
                                if (!empty($value)) {
                                    $theme_version = $value;
                                }
                            }

                            if ($key == 2) {
                                if (!empty($value)) {
                                    $theme_description = $value;
                                }
                            }

                            if ($key == 3) {
                                if (!empty($value)) {
                                    $theme_author = $value;
                                }
                            }

                            if ($key == 4) {
                                if (!empty($value)) {
                                    $theme_creation = $value;
                                }
                            }

                            if ($key == 5) {
                                if (!empty($value)) {
                                    $theme_licence = $value . "\n";
                                }
                            }
                        }

                        $update = fwrite($file, 1 . "\n");
                        $update .= fwrite($file, $theme_name);
                        $update .= fwrite($file, $theme_version);
                        $update .= fwrite($file, $theme_description);
                        $update .= fwrite($file, $theme_author);
                        $update .= fwrite($file, $theme_creation);
                        $update .= fwrite($file, $theme_licence);
                        $theme_installed = date('d/m/Y', time());
                        $update .= fwrite($file, $theme_installed);
                        if (file_exists($rute . '.theme_autoconfigured')) {
                            exec("attrib +h {$rute}.theme_autoconfigured");
                        }
                        if (file_exists($rute . '.theme_config')) {
                            exec("attrib +h {$rute}.theme_config");
                        }
                        if (!$update) {
                            die("Can't write");
                        }
                    } else {
                        fwrite($file, 1 . "\n");
                        $theme_name = $this->config->select['WEB']['NAME'] . ' Theme' . "\n";
                        $theme_version = "1.0.0\n";
                        $theme_description = 'Default theme configuration' . "\n";
                        $theme_author = 'MasterCMS developers' . "\n";
                        $theme_creation = date('d/m/Y', time()) . "\n";
                        $theme_licence = "Free trial licence for {$this->config->select['WEB']['NAME']}" . "\n";
                        $theme_installed = date('d/m/Y - h:i:s', time());
                        $update = fwrite($file, $theme_name);
                        $update = fwrite($file, $theme_version);
                        $update .= fwrite($file, $theme_description);
                        $update .= fwrite($file, $theme_author);
                        $update .= fwrite($file, $theme_creation);
                        $update .= fwrite($file, $theme_licence);
                        $update .= fwrite($file, $theme_installed);
                        if (file_exists($rute . '.theme_autoconfigured')) {
                            exec("attrib +h {$rute}.theme_autoconfigured");
                        }
                        if (file_exists($rute . '.theme_config')) {
                            exec("attrib +h {$rute}.theme_config");
                        }
                        if (!$update) {
                            die("Can't write");
                        }
                    }
                }
            }
            fclose($theme_autoconfigured);
            fclose($theme_config);

            $rute = ROOT . 'src' . DS . 'MasterCMS' . DS . 'Views' . DS . 'WebViews' . DS;
            $directory = opendir($rute);
            $files = array();
            while ($file = readdir($directory)) {
                if ($file != '.' && $file != '..') {
                    $fileExt = substr($file, -4, 4);
                    if (!is_file($file) && $fileExt != '.zip' && $fileExt != '.rar') {
                        array_push($files, $file);
                    }
                }
            }

            if (empty($files)) {
                die("Please install some Themes to MasterCMS");
            }

            if (!$template_name) {
                die("Please config your Template Name");
            }

        }

        public function getThemeInfo($info = 'name', $theme = false)
        {
            $template_name = $this->getConfig('template_name');
            if (!$theme) {
                $theme = $template_name;
            }
            $rute = ROOT . 'src' . DS . 'MasterCMS' . DS . 'Views' . DS . 'WebViews' . DS;
            if (file_exists($rute . $theme)) {
                $themeDir = $rute . $theme . DS;
                if (file_exists($themeDir . '.theme_autoconfigured')) {
                    $theme_config = $themeDir . '.theme_autoconfigured';
                    foreach (new \SplFileObject($theme_config) as $key => $value) {
                        if ($info == 'status') {
                            if ($key == 0) {
                                $return = $value;
                            }
                        } else if ($info == 'name') {
                            if ($key == 1) {
                                $return = $value;
                            }
                        } else if ($info == 'version') {
                            if ($key == 2) {
                                $return = $value;
                            }
                        } else if ($info == 'description') {
                            if ($key == 3) {
                                $return = $value;
                            }
                        } else if ($info == 'author') {
                            if ($key == 4) {
                                $return = $value;
                            }
                        } else if ($info == 'creation') {
                            if ($key == 5) {
                                $return = $value;
                            }
                        } else if ($info == 'licence') {
                            if ($key == 6) {
                                $return = $value;
                            }
                        } else if ($info == 'installed') {
                            if ($key == 7) {
                                $return = $value;
                            }
                        } else {
                            $return = false;
                        }
                    }

                    if ($info == 'langs') {
                        $template_name = $this->getConfig('template_name');
                        $rute = ROOT . 'src' . DS . 'MasterCMS' . DS . 'Views' . DS . 'WebViews' . DS . $template_name . DS . 'Langs' . DS;
                        $directory = opendir($rute);
                        $files = array();
                        while ($file = readdir($directory)) {
                            if ($file != '.' && $file != '..') {
                                $fileExt = substr($file, -4, 4);
                                if (!is_file($file) && $fileExt != '.zip' && $fileExt != '.rar') {
                                    array_push($files, $file);
                                }
                            }
                        }

                        $return = $files;
                    }
                } else if (file_exists($themeDir . '.theme_config')) {
                    $theme_config = $themeDir . '.theme_config';
                    foreach (new \SplFileObject($theme_config) as $key => $value) {
                        if ($info == 'status') {
                            $return = false;
                        } else if ($info == 'name') {
                            if ($key == 0) {
                                $return = $value;
                            }
                        } else if ($info == 'version') {
                            if ($key == 1) {
                                $return = $value;
                            }
                        } else if ($info == 'description') {
                            if ($key == 2) {
                                $return = $value;
                            }
                        } else if ($info == 'author') {
                            if ($key == 3) {
                                $return = $value;
                            }
                        } else if ($info == 'creation') {
                            if ($key == 4) {
                                $return = $value;
                            }
                        } else if ($info == 'licence') {
                            if ($key == 5) {
                                $return = $value;
                            }
                        } else if ($info == 'installed') {
                            $return = false;
                        } else {
                            $return = false;
                        }
                    }

                    if ($info == 'langs') {
                        $template_name = $this->getConfig('template_name');
                        $rute = ROOT . 'src' . DS . 'MasterCMS' . DS . 'Views' . DS . 'WebViews' . DS . $template_name . DS . 'Langs' . DS;
                        $directory = opendir($rute);
                        $files = array();
                        while ($file = readdir($directory)) {
                            if ($file != '.' && $file != '..') {
                                $fileExt = substr($file, -4, 4);
                                if (!is_file($file) && $fileExt != '.zip' && $fileExt != '.rar') {
                                    array_push($files, $file);
                                }
                            }
                        }

                        $return = $files;
                    }
                } else {
                    $return = false;
                }
            } else {
                $return = false;
            }

            return $return;
        }

        public function getConfig($name)
        {
            $query = $this->con->query("SELECT * FROM master_config WHERE name = '{$name}'");
            $select = mysqli_fetch_assoc($query);
            if ($this->con->num_rows($query)) {
                if (isset($select['value'])) {
                    return $select['value'];
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        public function getSuperUsers()
        {
            $list = $this->getConfig('super_users');
            $list = str_replace(' ', '', $list);
            $list = explode(',', $list);
            return $list;
        }

        public function setConfig($name, $value)
        {
            $query = $this->con->query("SELECT * FROM master_config WHERE name = '{$name}'");
            if ($this->con->num_rows($query)) {
                $query = $this->con->query("UPDATE master_config SET name = '{$name}', value = '{$value}' WHERE name = '{$name}'");
            } else {
                $query = $this->con->query("INSERT INTO master_config (name, value) VALUES ('{$name}', '{$value}')");
            }

            if ($query) {
                return true;
            } else {
                return false;
            }
        }

        public function restartConfig()
        {
            $query = $this->con->query("SELECT * FROM master_config");
            if ($this->con->num_rows($query)) {
                $query = $this->con->query("DELETE FROM master_config");
            } else {
                $query = false;
            }

            if ($query) {
                return true;
            } else {
                return false;
            }
        }

        public function generateTicket()
        {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $charactersLength; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }

        public function onlines()
        {
            //$query = $this->con->query("SELECT * FROM users WHERE online = '1'");
            $query = $this->con->query("SELECT * FROM users_online");
            $result = $this->con->num_rows($query);

            return $result;
        }

        public function getMaster($rank_type = false, $type = false)
        {
            if (!$this->getConfig('min_rank')) {
                $import = $this->setConfig('min_rank', $this->config->select['DEFAULT_DB_CONFIG']['MIN_RANK']);
                if (!$import) {
                    $data = false;
                } else {
                    $data = true;
                }
            } else {
                $data = true;
            }

            if (!$this->getConfig('medium_rank')) {
                $import = $this->setConfig('medium_rank', $this->config->select['DEFAULT_DB_CONFIG']['MEDIUM_RANK']);
                if (!$import) {
                    $data .= false;
                } else {
                    $data .= true;
                }
            } else {
                $data .= true;
            }

            if (!$this->getConfig('max_rank')) {
                $import = $this->setConfig('max_rank', $this->config->select['DEFAULT_DB_CONFIG']['MAX_RANK']);
                if (!$import) {
                    $data .= false;
                } else {
                    $data .= true;
                }
            } else {
                $data .= true;
            }

            if ($data) {
                if ($rank_type == 'min' || !$rank_type) {
                    $rank = 'min_rank';
                } else {
                    if ($rank_type == 'medium') {
                        $rank = 'medium_rank';
                    } else {
                        if ($rank_type == 'max') {
                            $rank = 'max_rank';
                        } else {
                            if ($rank_type == 'all') {
                                $rank = $rank_type;
                            } else {
                                if ($rank_type == 'medium+') {
                                    $rank = $rank_type;
                                } else {
                                    if ($rank_type == 'medium-') {
                                        $rank = $rank_type;
                                    } else {
                                        $rank = 'min_rank';
                                    }
                                }
                            }
                        }
                    }
                }

                if ($rank == 'all') {
                    $data = $this->getConfig('min_rank') . ',' . $this->getConfig('medium_rank') . ',' . $this->getConfig('max_rank');
                    $data = explode(',', $data);
                } elseif ($rank == 'medium+') {
                    $data = $this->getConfig('medium_rank') . ',' . $this->getConfig('max_rank');
                    $data = explode(',', $data);
                } elseif ($rank == 'medium-') {
                    $data = $this->getConfig('min_rank') . ',' . $this->getConfig('medium_rank');
                    $data = explode(',', $data);
                } else {
                    $data = $this->getConfig($rank);
                    $data = explode(',', $data);
                }

                $data = str_replace(' ', '', $data);

                if ($type == false) {
                    sort($data);
                } else {
                    rsort($data);
                }
            } else {
                $data = false;
            }

            return $data;
        }

        public function getMasterType($id = false)
        {
            if (!$id) {
                if ($this->sessions->get('session', 'username') && $this->sessions->get('session', 'password')) {
                    $username = $this->sessions->get('session', 'username');
                    $password = $this->sessions->get('session', 'password');
                } else {
                    $username = $this->sessions->get('cookie', 'username');
                    $password = $this->sessions->get('cookie', 'password');
                }
                $queryUser = $this->con->query("SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}'");
                $selectUser = mysqli_fetch_assoc($queryUser);
                $id = $selectUser['rank'];
                $query = $this->con->query("SELECT * FROM ranks WHERE id = '{$id}'");
                $select = mysqli_fetch_assoc($query);
                if ($this->con->num_rows($query) > 0) {
                    if (in_array($id, $this->getMaster('min'))) {
                        return 'min';
                    } else {
                        if (in_array($id, $this->getMaster('medium'))) {
                            return 'medium';
                        } else {
                            if (in_array($id, $this->getMaster('max'))) {
                                return 'max';
                            } else {
                                return false;
                            }
                        }
                    }
                } else {
                    return false;
                }
            } else {
                $query = $this->con->query("SELECT * FROM ranks WHERE id = '{$id}'");
                $select = mysqli_fetch_assoc($query);
                if ($this->con->num_rows($query) > 0) {
                    if (in_array($id, $this->getMaster('min'))) {
                        return 'min';
                    } else {
                        if (in_array($id, $this->getMaster('medium'))) {
                            return 'medium';
                        } else {
                            if (in_array($id, $this->getMaster('max'))) {
                                return 'max';
                            } else {
                                return false;
                            }
                        }
                    }
                } else {
                    return false;
                }
            }
        }

        public function sendMUS($value) {
            /*$mus_ip = $this->config->select['CLIENT']['HOST'];
            $mus_port = $this->config->select['CLIENT']['PORT'];
            if(!is_numeric($mus_port)){ 
                return false; 
            }
            $sock = socket_create(AF_INET, SOCK_STREAM, getprotobyname('tcp'));
            socket_connect($sock, $mus_ip, $mus_port);

            if(!is_resource($sock)) {
                return false;
            } else {
                socket_send($sock, $data, strlen($data), MSG_DONTROUTE);
                socket_recv($sock, $buf, 2048, MSG_WAITALL);
                return $buf;
            }
            socket_close($sock);*/
        }

        public function getDate($a)
        {
            if(!empty($a) || !$a == ''){
                if(is_numeric($a)){
                    $date = $a;
                    $date_now = time();
                    $difference = $date_now - $date;
                    if($difference <= '59'){ $echo = 'Just now'; }
                    elseif($difference <= '3599' && $difference >= '60'){ 
                        $minutes = date('i', $difference);
                        if($minutes[0] == 0) { $minutes = $minutes[1]; }
                        if($minutes == 1) { $minutes_str = 'minute ago'; }
                        else { $minutes_str = 'minutes ago'; }
                        $echo = ''.$minutes.' '.$minutes_str;//minutes
                    }elseif($difference <= '82799' && $difference >= '3600'){
                        $hours = date('G', $difference);
                        if($hours == 1) { $hours_str = 'hour ago'; }
                        else { $hours_str = 'hours ago'; }
                        $echo = ''.$hours.' '.$hours_str;//minutes
                    }elseif($difference <= '518399' && $difference >= '82800'){
                        $days = date('j', $difference);
                        if($days == 1) { $days_str = 'day ago'; }
                        else { $days_str = 'days ago'; }
                        $echo = ''.$days.' '.$days_str;//minutes
                    }elseif($difference <= '2678399' && $difference >= '518400'){
                        $week = floor(date('j', $difference) / 7);
                        if($week == 1) { $week_str = 'week ago'; }
                        else { $week_str = 'weeks ago'; }
                        $echo = ''.floor($week).' '.$week_str;//minutes
                    }else { $echo = ''.date('n', $difference).' month(s) ago'; }
                    return $echo;
                } else { return $a; }
            }else{ 
                return false;
            }
        }

        public function deletePath($path)
        {
            if (is_dir($path)) {
                $files = array_diff(scandir($path), array('.', '..'));
                foreach ($files as $file) {
                    $this->deletePath(realpath($path) . '/' . $file);
                }
                return rmdir($path);
            } else if (is_file($path)) {
                return unlink($path);
            }
            return false;
        }

        public function moveData($src, $dst) { 
            if (file_exists ( $dst ))
                $this->rrmdir ( $dst );
            if (is_dir ( $src )) {
                mkdir ( $dst );
                $files = scandir ( $src );
                foreach ( $files as $file )
                    if ($file != "." && $file != "..")
                        $this->rcopy ( "$src/$file", "$dst/$file" );

            } else if (file_exists ( $src ))
                copy($src, $dst);
                            $this->rrmdir($src);
        } 

        public function rrmdir($dir) {
            if (is_dir($dir)) {
                $files = scandir($dir);
                foreach ($files as $file)
                    if ($file != "." && $file != "..") $this->rrmdir("$dir/$file");
                rmdir($dir);
            }
            else if (file_exists($dir)) unlink($dir);
        }

        public function rcopy($src, $dst) {
            if (file_exists ( $dst ))
                $this->rrmdir ( $dst );
            if (is_dir ($src)) {
                mkdir ($dst);
                $files = scandir ( $src );
                foreach ( $files as $file )
                    if ($file != "." && $file != "..")
                        $this->rcopy ( "$src/$file", "$dst/$file" );
            } else if (file_exists ( $src ))
                copy ( $src, $dst );
        }

        public function __destruct()
        {
            $this->con->close();
        }
    }

?>