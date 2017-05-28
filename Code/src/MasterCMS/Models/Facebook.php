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

	class Facebook {

		private $config;
		public $loginUrl;
		public $fb;
		private $helper;
		private $session;
		private $sessions;

		public function __construct()
		{
			$this->config = new Config;
			$this->con = new Connection;
			$this->sessions = new Sessions;

			$this->fb = new Facebook\Facebook([
			  'app_id' => $this->config->select['SOCIAL_NETWORKS_LOGIN']['FACEBOOK']['APP_ID'],
			  'app_secret' => $this->config->select['SOCIAL_NETWORKS_LOGIN']['FACEBOOK']['APP_SECRET'],
			  'default_graph_version' => 'v2.8',
			]);

			$this->helper = $this->fb->getRedirectLoginHelper();

			try {
				if (isset($_SESSION['facebook_access_token'])) {
					$accessToken = $_SESSION['facebook_access_token'];
				} else {
			  		$accessToken = $this->helper->getAccessToken();
				}
			} catch(Facebook\Exceptions\FacebookResponseException $e) {
			 	die('Graph returned an error: ' . $e->getMessage());
			  	exit;
			} catch(Facebook\Exceptions\FacebookSDKException $e) {
				die('Facebook SDK returned an error: ' . $e->getMessage());
			  	exit;
			}

			if (isset($accessToken)) {

				if (isset($_SESSION['facebook_access_token'])) {
					$this->fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
					$this->session = true;
				} else {

					$_SESSION['facebook_access_token'] = (string) $accessToken;

					$oAuth2Client = $this->fb->getOAuth2Client();

					$longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
					$_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;

					$this->fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
					$this->session = true;
				}
				
				try {
					$response = $this->fb->get('/me');
				} catch(Facebook\Exceptions\FacebookResponseException $e) {
					session_destroy();
					header("Location: /");
					exit;
				} catch(Facebook\Exceptions\FacebookSDKException $e) {
					die('Facebook SDK returned an error: ' . $e->getMessage());
					exit;
				}

			} else {
				$this->session = false;
			}
		}

		public function getSession()
		{
			if ($this->session) {
				return true;
			} else {
				return false;
			}
		}

		public function getUser($value)
		{
			if ($this->getSession()) {
				$response = $this->fb->get('/me?fields=id, name, first_name, last_name, email, gender');
				$profile = $response->getGraphNode()->asArray();
				if (isset($profile['name'])) {
					return $profile[$value];
				} else {
					return false;
				}
			} else {
				return false;
			}
		}

		public function getLoginUrl()
		{
			$redirect = $this->config->select['WEB']['TYPE_HTTP'] . $this->config->select['WEB']['URL'] . '/web/verify_client';
			$permissions = ['email'];
			$this->loginUrl = $this->helper->getLoginUrl($redirect, $permissions);
			return $this->loginUrl;
		}

		public function __destruct()
		{
			$this->con->close();
		}
	}

?>