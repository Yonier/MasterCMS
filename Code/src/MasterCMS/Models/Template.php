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

    use MasterCMS\Config\{Config, Connection, Request};

    class Template {
        private $config;
        private $request;
        private $outputData;
        private $params = Array();
        public $vars = Array();
        private $tplName = '';
        private $users;
        private $con;   
        public $hotel;
        private $facebook;
        private $sessions;
        private $protection;

        public function __construct()
        {
            $this->config = new Config;
            $this->request = new Request;
            $this->users = new Users;
            $this->hotel = new Hotel;
            $this->con = new Connection;
            $this->facebook = new Facebook;
            $this->sessions = new Sessions;
            $this->protection = new Protection;
        }

        public function displayError($a, $b)
        {
            echo '<h2>'. $a .'</h2>';
            echo $b;
        }

        public function display($a){
            echo '<div id="'.$a.'">';
        }

        public function displayClosed(){
            echo '</div>
        ';
        }

        public function addMasterCMSTemplate($file)
        {
            echo $this->getHTML(ROOT . 'src' . DS . 'MasterCMS' . DS . 'Views' . DS . 'MasterCMS' . DS . $file);
        }

        public function addTemplate($file = false, $directory = false)
        {
            if (!$directory) {
                if (!$file) {
                    echo $this->getHTML(ROOT . 'src' . DS . 'MasterCMS' . DS . 'Views' . DS . 'WebViews' . DS . $this->hotel->getConfig('template_name') . DS . 'Langs' . DS . $this->config->select['WEB']['LANG'] . DS . $this->request->getController() . DS . $this->request->getMethod());
                } elseif ($file == '404') {
                    echo $this->getHTML(ROOT . 'src' . DS . 'MasterCMS' . DS . 'Views' . DS . 'WebViews' . DS . $this->hotel->getConfig('template_name') . DS . 'Langs' . DS . $this->config->select['WEB']['LANG'] . DS . 'Errors' . DS . $file);
                } elseif ($file == 'AdBlock') {
                    echo $this->getHTML(ROOT . 'src' . DS . 'MasterCMS' . DS . 'Views' . DS . 'WebViews' . DS . $this->hotel->getConfig('template_name') . DS . 'Langs' . DS . $this->config->select['WEB']['LANG'] . DS . 'Errors' . DS . $file);
                } else {
                    echo $this->getHTML(ROOT . 'src' . DS . 'MasterCMS' . DS . 'Views' . DS . 'WebViews' . DS . $this->hotel->getConfig('template_name') . DS . 'Langs' . DS . $this->config->select['WEB']['LANG'] . DS . $file);
                }
            } else {
                if ($directory == 'Hk') {
                    if (!$file) {
                        $rt = ROOT . 'src' . DS . 'MasterCMS' . DS . 'Views' . DS . $directory . DS . 'Langs' . DS . $this->config->select['WEB']['HK_LANG'] . $this->request->getController() . DS . $this->request->getMethod();
                        $rt2 = ROOT . 'src' . DS . 'MasterCMS' . DS . 'Views' . DS . 'WebViews' . DS . $this->hotel->getConfig('template_name') . DS . 'Langs' . DS . $this->config->select['WEB']['HK_LANG'] . DS . 'WebTemplates' . DS . $directory . DS . $this->request->getController() . DS . $this->request->getMethod();
                        if (is_readable($rt2 . '.tpl')) {
                            echo $this->getHTML($rt2);
                        } else {
                            echo $this->getHTML($rt);
                        }
                    } else {
                        $rt = ROOT . 'src' . DS . 'MasterCMS' . DS . 'Views' . DS . $directory . DS . 'Langs' . DS . $this->config->select['WEB']['HK_LANG'] . DS . $file;
                        $rt2 = ROOT . 'src' . DS . 'MasterCMS' . DS . 'Views' . DS . 'WebViews' . DS . $this->hotel->getConfig('template_name') . DS . 'Langs' . DS . $this->config->select['WEB']['HK_LANG'] . DS . 'WebTemplates' . DS . $directory . DS . $file;
                        if (is_readable($rt2 . '.tpl')) {
                            echo $this->getHTML($rt2);
                        } else {
                            echo $this->getHTML($rt);
                        }
                    }
                } else {
                    if (!$file) {
                        $rt = ROOT . 'src' . DS . 'MasterCMS' . DS . 'Views' . DS . $directory . DS . $this->request->getController() . DS . $this->request->getMethod();
                        $rt2 = ROOT . 'src' . DS . 'MasterCMS' . DS . 'Views' . DS . 'WebViews' . DS . $this->hotel->getConfig('template_name') . DS . 'Langs' . DS . $this->config->select['WEB']['LANG'] . DS . 'WebTemplates' . DS . $directory . DS . $this->request->getController() . DS . $this->request->getMethod();
                        if (is_readable($rt2 . '.tpl')) {
                            echo $this->getHTML($rt2);
                        } else {
                            echo $this->getHTML($rt);
                        }
                    } else {
                        $rt = ROOT . 'src' . DS . 'MasterCMS' . DS . 'Views' . DS . $directory . DS . $file;
                        $rt2 = ROOT . 'src' . DS . 'MasterCMS' . DS . 'Views' . DS . 'WebViews' . DS . $this->hotel->getConfig('template_name') . DS . 'Langs' . DS . $this->config->select['WEB']['LANG'] . DS . 'WebTemplates' . DS . $directory . DS . $file;
                        if (is_readable($rt2 . '.tpl')) {
                            echo $this->getHTML($rt2);
                        } else {
                            echo $this->getHTML($rt);
                        }
                    }
                }
            }
        }

        public function setParam($param, $value)
        {
            $this->params[$param] = $value;
            $this->vars[$param] = $value;
        }
        
        public function unsetParam($param)
        {
            unset($this->params[$param]);
            unset($this->vars[$param]);
        }       

        public function filterParams($str)
        {
            foreach ($this->params as $param => $value)
            {
                $str = str_ireplace('{@' . $param . '}', $value, $str);
            }
            
            foreach ($this->vars as $var => $value)
            {
                $var = $value;
            }

            return $str;
        }

        public function getHTML($file)
        {
            extract($this->params);
            $file = $file .  '.tpl';
            if (!file_exists($file)) {
                $this->displayError('Can\'t found the file', 'Can\'t to found the TPL file: <b>' . $file .'</b>');
            } else {
                ob_start();
                include($file);
                $data = ob_get_contents();
                ob_end_clean(); 
                return $this->filterParams($data);
            }
        }

        public function setEverything()
        {
            // Params
            global $smtp;
            require (ROOT . 'src' . DS . 'MasterCMS' . DS . 'Config' . DS . 'SMTP.php');
            $this->setParam('name', $this->config->select['WEB']['NAME']);
            $this->setParam('client_url', $this->config->select['WEB']['CLIENT_URL']);
            $this->setParam('url', $this->config->select['WEB']['TYPE_HTTP'] . $this->config->select['WEB']['URL']);
            $this->setParam('cdn',  $this->config->select['CDN']['TYPE_HTTP'] . $this->config->select['CDN']['URL'] . '/' . 'Resources/Themes' . '/' . $this->hotel->getConfig('template_name'));
            $this->setParam('client_cdn',  $this->config->select['CDN']['TYPE_HTTP'] . $this->config->select['CDN']['URL'] . '/' . 'Resources/Client');
            $this->setParam('master_cdn',  $this->config->select['CDN']['TYPE_HTTP'] . $this->config->select['CDN']['URL'] . '/' . 'Resources/MasterCMS');
            $this->setParam('cdn_url',  $this->config->select['CDN']['TYPE_HTTP'] . $this->config->select['CDN']['URL']);
            $this->setParam('swf_cdn',  $this->config->select['CDN']['SWF']['TYPE_HTTP'] . $this->config->select['CDN']['SWF']['URL'] . '/' . $this->config->select['CDN']['SWF']['WEB_RUTE']);
            $this->setParam('rute_cdn', $this->config->select['CDN']['RUTE']);
            $this->setParam('hk_cdn', $this->config->select['CDN']['TYPE_HTTP'] . $this->config->select['CDN']['URL'] . '/' . $this->config->select['CDN']['HK']);
            $this->setParam('lang',  $this->config->select['WEB']['LANG']);
            $this->setParam('logo', $this->hotel->getConfig('logo'));
            $this->setParam('contact_mail', $smtp['SMTP']['MAILS']['CONTACT']['FROM']);
            $this->setParam('support_mail', $smtp['SMTP']['MAILS']['SUPPORT']['FROM']);
            $this->setParam('facebook', $this->hotel->getConfig('facebook'));
            $this->setParam('twitter', $this->hotel->getConfig('twitter'));
            $this->setParam('instagram', $this->hotel->getConfig('instagram'));
            $this->setParam('default_credits', $this->config->select['USER_REGISTER']['CREDITS']);
            $this->setParam('default_duckets', $this->config->select['USER_REGISTER']['DUCKETS']);
            $this->setParam('default_diamonds', $this->config->select['USER_REGISTER']['DIAMONDS']);
            $this->setParam('default_gotw', $this->config->select['USER_REGISTER']['GOTW']);
            $this->setParam('colors', explode(',', $this->hotel->getConfig('colors')));
            $this->setParam('radio', $this->hotel->getConfig('radio'));
            $this->setParam('maintenance_description', $this->hotel->getConfig('maintenance_description'));
            $this->setParam('super_users', $this->hotel->getConfig('super_users'));
            $this->setParam('super_users_array', explode(',', $this->hotel->getConfig('super_users')));
            $this->setParam('onlines', number_format($this->hotel->onlines()));
            $this->setParam('ip', $this->users->getIP());
            if (!$this->users->getCountry()) {
                $country = 'IDK';
            } else {
                $country = $this->users->getCountry();
            }
            $this->setParam('country_code_ip', $country);
            $this->setParam('last_ip', $this->users->get('ip_last'));
            if (!$this->users->getCountry()) {
                $country = 'IDK';
            } else {
                $country = $this->users->getCountry($this->users->get('ip_last'));
            }
            $this->setParam('country_code_last', $country);

            // User Data
            if ($this->users->getSession()) {
                $getUser = $this->con->query("SELECT * FROM users WHERE username = '{$this->users->get('username')}' AND password = '{$this->users->get('password')}'");
                $selectUser = $this->con->fetch_array($getUser);
                if (empty($selectUser['username']) && empty($selectUser['password'])) {
                    foreach ($selectUser as $key => $value) {
                        $this->setParam('user_' . $key, 'Guess');
                    }
                } else {
                    foreach ($selectUser as $key => $value) {
                        $this->setParam('user_' . $key, $value);
                    }
                }
                $this->setParam('user_motto', $this->protection->filter($selectUser['motto']));
            }

            $this->setParam('master_version', $this->con->getMasterVersion());
            $this->setParam('theme_name', $this->hotel->getThemeInfo());
            $this->setParam('theme_lang', $this->config->select['WEB']['LANG']);
            $this->setParam('theme_langs', $this->hotel->getThemeInfo('langs'));
            $this->setParam('theme_langs_list', rtrim(implode(', ', $this->hotel->getThemeInfo('langs')), ','));
            $this->setParam('theme_description', $this->hotel->getThemeInfo('description'));
            $this->setParam('theme_author', $this->hotel->getThemeInfo('author'));
            $this->setParam('theme_version', $this->hotel->getThemeInfo('version'));
            $this->setParam('theme_creation', $this->hotel->getThemeInfo('creation'));
            $this->setParam('theme_installed', $this->hotel->getThemeInfo('installed'));

            $this->setParam('fbname', $this->facebook->getUser('name'));

            $this->setParam('fbLoginUrl', htmlspecialchars($this->facebook->getLoginUrl()));
            $this->setParam('fb_app_id', $this->config->select['SOCIAL_NETWORKS_LOGIN']['FACEBOOK']['APP_ID']);

            $this->setParam('username', $this->users->get('username'));
            $this->setParam('rank_id', $this->users->get('rank'));
            $select = $this->con->query("SELECT * FROM ranks WHERE id = '{$this->users->get('rank')}'");
            $select = $this->con->fetch_assoc($select);
            if (isset($select['name'])) {
                $this->setParam('rank', $select['name']);
            } else {
                $this->setParam('rank', 'Not founded');
            }
            $this->setParam('habbo_img', $this->hotel->getConfig('habbo_img'));
            $this->setParam('look', $this->users->get('look'));
            if ($this->users->get('last_used')) {
                $this->setParam('last_used', $this->hotel->getDate($this->users->get('last_used')));
            } else {
                $this->setParam('last_used', 'You wasn\'t online');
            }
            $this->setParam('badges_cdn', $this->config->select['CDN']['SWF']['TYPE_HTTP'] . $this->config->select['CDN']['SWF']['URL'] . '/' . $this->config->select['CDN']['SWF']['WEB_RUTE'] . '/' . $this->config->select['CDN']['SWF']['WEB_BADGES']);
            $this->setParam('mpus_cdn', $this->config->select['CDN']['SWF']['TYPE_HTTP'] . $this->config->select['CDN']['SWF']['URL'] . '/' . $this->config->select['CDN']['SWF']['WEB_RUTE'] . '/' . $this->config->select['CDN']['SWF']['WEB_MPUS']);
            $this->setParam('motto', $this->protection->filter($this->users->get('motto')));
            $this->setParam('credits', number_format($this->users->get('credits')));
            $this->setParam('duckets', number_format($this->users->get('activity_points')));
            $this->setParam('diamonds', number_format($this->users->get('vip_points')));
            $this->setParam('gotw', number_format($this->users->get('gotw_points')));
            $this->setParam('id', $this->users->get('id'));
        }

        public function __destruct()
        {
            $this->con->close();
        }
    }

?>