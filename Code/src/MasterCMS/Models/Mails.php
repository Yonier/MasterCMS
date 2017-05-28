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
    use MasterCMS\Models\phpMailer\PHPMailer;

    class Mails {

        private $config;
        private $hotel;
        private $users;
        private $request;
        private $outputData;
        private $params = Array();
        public $vars = Array();
        private $tplName = '';

        public function __construct()
        {
            $this->mail = new PHPMailer;
            $this->config = new Config;
            $this->hotel = new Hotel;
            $this->users = new Users;
        }

        public function displayError($a, $b)
        {
            echo '<h2>'. $a .'</h2>';
            echo $b;
        }

        public function display($a){
            echo '<div id="'.$a.'">';
        }

        public function setParam($param, $value)
        {
            $this->params[$param] = $value;
            $this->vars[$param] = $value;
        }
        
        public function unsetParam($param)
        {
            unset($this->params[$param]);
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
            $this->setEverything();
            extract($this->params);
            $file = $file;
            if (!file_exists(ROOT . 'src' . DS . 'MasterCMS' . DS . 'Views' . DS . 'WebViews' . DS . $this->hotel->getConfig('template_name') . DS . 'Langs' . DS . $this->config->select['WEB']['LANG'] . DS . 'Mails' . DS . $file)) {
                return $this->DisplayError('Can\'t found the file', 'Can\'t to found the HTML file: <b>' . $file .'</b>');
            } else {
                $data = file_get_contents(ROOT . 'src' . DS . 'MasterCMS' . DS . 'Views' . DS . 'WebViews' . DS . $this->hotel->getConfig('template_name') . DS . 'Langs' . DS . $this->config->select['WEB']['LANG'] . DS . 'Mails' . DS . $file);
                return $this->filterParams($data);
            }
        }

        public function send($mail_name, $subject, $body, $to, $file = false, $title = false, $html = true)
        {
            global $smtp;
            require (ROOT . 'src' . DS . 'MasterCMS' . DS . 'Config' . DS . 'SMTP.php');
            if (empty($smtp['SMTP']['MAILS'][$mail_name]['USER'])) {
                echo $mail_name . ' no ha sido encontrado <br>';
                return false;
            } else {
                // Mails
                $this->mail->SMTPAuth = true;
                $this->mail->Mailer = $smtp['SMTP']['MAILS'][$mail_name]['MAILER'];
                $this->mail->Host = $smtp['SMTP']['MAILS'][$mail_name]['HOST'];
                $this->mail->Port = $smtp['SMTP']['MAILS'][$mail_name]['PORT'];
                $this->mail->SMTPSecure = $smtp['SMTP']['MAILS'][$mail_name]['SMTP_SECURE'];
                $this->mail->Username = $smtp['SMTP']['MAILS'][$mail_name]['USER'];
                $this->mail->Password = $smtp['SMTP']['MAILS'][$mail_name]['PASS'];
                $this->mail->From = $smtp['SMTP']['MAILS'][$mail_name]['FROM'];
                if (empty($title) || $title == $smtp['SMTP']['MAILS'][$mail_name]['NAME']) {
                    $this->mail->FromName = $smtp['SMTP']['MAILS'][$mail_name]['NAME'];
                } else {
                    $this->mail->FromName = $title;
                }
                if ($html) {
                    $this->mail->IsHTML(true);
                } else {
                    $this->mail->IsHTML(false);
                }
                $this->mail->SingleTo = true;
                $this->mail->CharSet = 'UTF-8';
                $this->mail->AddReplyTo($smtp['SMTP']['MAILS'][$mail_name]['USER']);
                $this->mail->AddAddress($to);
                $this->mail->Subject = $subject;
                $this->mail->msgHTML($this->getHTML($body), dirname(__FILE__));
                if(!$this->mail->send()) {
                    return false;
                } else {
                    return true;
                }
            }
        }

        public function setEverything()
        {
            // Params
            $this->setParam('name', $this->config->select['WEB']['NAME']);
            $this->setParam('url', $this->config->select['WEB']['TYPE_HTTP'] . $this->config->select['WEB']['URL']);
            $this->setParam('cdn',  $this->config->select['WEB']['TYPE_HTTP'] . $this->config->select['WEB']['URL'] . '/' . $this->config->select['WEB']['CDN']);
            $this->setParam('lang',  $this->config->select['WEB']['LANG']);
            $this->setParam('logo', $this->config->select['WEB']['LOGO']);
            $this->setParam('contact_mail', $this->config->select['SMTP']['MAILS']['CONTACT']['FROM']);
            $this->setParam('support_mail', $this->config->select['SMTP']['MAILS']['SUPPORT']['FROM']);
            $this->setParam('facebook', $this->config->select['SOCIAL_NETWORKS']['FACEBOOK']);
            $this->setParam('twitter', $this->config->select['SOCIAL_NETWORKS']['TWITTER']);
            $this->setParam('instagram', $this->config->select['SOCIAL_NETWORKS']['INSTAGRAM']);
            $this->setParam('default_credits', $this->config->select['USER_REGISTER']['CREDITS']);
            $this->setParam('default_duckets', $this->config->select['USER_REGISTER']['DUCKETS']);
            $this->setParam('default_diamonds', $this->config->select['USER_REGISTER']['DIAMONDS']);
            $this->setParam('default_gotw', $this->config->select['USER_REGISTER']['GOTW']);
            $this->setParam('colors', $this->config->select['WEB']['HEADER_COLORS']);
            $this->setParam('onlines', $this->hotel->onlines());
        }

        public function generateToken()
        {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $charactersLength; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }
    }

?>