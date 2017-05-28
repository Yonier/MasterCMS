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
   
	namespace MasterCMS\Controllers;

	use MasterCMS\Config\{Config, Connection};
	use MasterCMS\Models\{Template, Protection, Users, Sessions, Redirections, Facebook, Hotel, Mails};

	class webController {

		private $template;
		private $config;
		private $protection;
		private $users;
		private $sessions;
		private $con;
		private $redirections;
		private $facebook;
		private $hotel;
		private $page;
		private $url;
		private $main;

		public function __construct()
		{
			$this->con = new Connection;
			$this->template = new Template;
			$this->config = new Config;
			$this->protection = new Protection;
			$this->users = new Users;
			$this->sessions = new Sessions;
			$this->redirections = new Redirections;
			$this->facebook = new Facebook;
			$this->hotel = new Hotel;
			$this->mails = new Mails;
			$this->template->setEverything();
			$this->url = $this->template->vars['url'];
			$template_name = $this->hotel->getConfig('template_name');
			$class = "MasterCMS\\Views\\WebViews\\{$template_name}\\Langs\\{$this->config->select['WEB']['LANG']}\\Texts\\Main";
			$this->main = new $class;

			// Refer Limit And Updater
			if ($this->users->getSession()) {
				$query = $this->con->query("SELECT * FROM users_refer_limit WHERE user_id = '{$this->users->get('id')}' LIMIT 1");
				$count_refers = $this->con->num_rows("SELECT * FROM user_refers WHERE user_id = '{$this->users->get('id')}'");
				$query_award = $this->con->query("SELECT * FROM refers_awards WHERE refers_amount > '{$count_refers}'");
				$select_award = mysqli_fetch_assoc($query_award);
				if ($this->con->num_rows($query) == 0) {
					$this->con->query("INSERT INTO users_refer_limit (user_id, ref_limit) VALUES ('{$this->users->get('id')}', '{$select_award['refers_amount']}')");
				} else {
					if ($this->sessions->get('session', 'racancelled')) {
						$this->con->query("UPDATE users_refer_limit SET ref_limit = '{$select_award['refers_amount']}' WHERE user_id = '{$this->users->get('id')}'");
						$this->sessions->delete('session', 'racancelled');
					}

					if ($this->sessions->get('session', 'raccepted')) {
						$this->con->query("UPDATE users_refer_limit SET ref_limit = '{$select_award['refers_amount']}' WHERE user_id = '{$this->users->get('id')}'");
						$this->sessions->delete('session', 'raccepted');
					}
				}
			}
		}
		
		public function index()
		{
			if (!$this->sessions->get('session', 'verify_client')) {
				header("Location: {$this->url}/web/verify_client");
				exit();
			}

			// Template
			if (!$this->users->getSession()) {
				if (!$this->hotel->getConfig('maintenance')) {
					define('ADS', true);
					$this->template->setEverything();
					$this->template->setParam('title', $this->main->texts['titles']['index']);
					$this->template->addTemplate('Template' . DS . 'Header');
					$this->template->addTemplate();
					$this->template->addTemplate('Template' . DS . 'Footer');
				} else {
					define('ADS', true);
					$this->template->setEverything();
					$this->template->setParam('title', $this->main->texts['titles']['maintenance']);
					$this->template->addTemplate('Template' . DS . 'Header');
					$this->template->addTemplate('Web' . DS . 'Maintenance');
					$this->template->addTemplate('Template' . DS . 'Footer');
				}
			} else {
				define('ADS', true);
				$this->template->setEverything();
				$this->template->setParam('title', $this->main->texts['titles']['me']);
				$this->template->addTemplate('Template' . DS . 'Header');
				$this->template->addTemplate('Web' . DS . 'Me');
				$this->template->addTemplate('Template' . DS . 'Footer');
			}
		}

		public function news($id = false, $type = false)
		{
			$id = $this->protection->filter($id);
			$type = $this->protection->filter($type);
			if ($this->hotel->getConfig('maintenance') && !in_array($this->users->get('rank'), $this->hotel->getMaster('all'))) {
				header("Location: {$this->url}/");
				exit();
			}
			if ($id) {
				$query = $this->con->query("SELECT * FROM news WHERE id = '{$this->protection->filter($id)}' LIMIT 1");
				$select = mysqli_fetch_assoc($query);
				if ($this->con->num_rows($query) == 0) {
					$new_active = false;
				} else {
					$new_active = true;
				}
			} else {
				$query = $this->con->query("SELECT * FROM news LIMIT 1");
				$select = mysqli_fetch_assoc($query);
				if ($this->con->num_rows($query) == 0) {
					$new_have = false;
				} else {
					$new_have = true;
				}
			}
			// Template
			define('ADS', true);
			$this->template->setEverything();
			if ($new_active) {
				$this->template->setParam('title', $select['title']);
				$this->template->setParam('new_active', true);
				$this->template->setParam('new_id', $this->protection->filter($id));
			} else {
				$this->template->setParam('title', $this->main->texts['titles']['news']);
				$this->template->setParam('new_active', false);
			}
			$this->template->addTemplate('Template' . DS . 'Header');
			$this->template->addTemplate();
			$this->template->addTemplate('Template' . DS . 'Footer');
		}

		public function community()
		{
			if ($this->hotel->getConfig('maintenance') && !in_array($this->users->get('rank'), $this->hotel->getMaster('all'))) {
				header("Location: {$this->url}/");
				exit();
			}
			// Template
			define('ADS', true);
			$this->template->setEverything();
			$this->template->setParam('title', $this->main->texts['titles']['community']);
			$this->template->addTemplate('Template' . DS . 'Header');
			$this->template->addTemplate();
			$this->template->addTemplate('Template' . DS . 'Footer');
		}

		public function settings()
		{
			if ($this->hotel->getConfig('maintenance') && !in_array($this->users->get('rank'), $this->hotel->getMaster('all'))) {
				header("Location: {$this->url}/");
				exit();
			}

			if (!$this->users->getSession()) {
				header("Location: {$this->url}/");
				exit();
			}
			// Template
			define('ADS', true);
			$this->template->setEverything();
			$this->template->setParam('title', $this->main->texts['titles']['account_settings']);
			$this->template->addTemplate('Template' . DS . 'Header');
			$this->template->addTemplate();
			$this->template->addTemplate('Template' . DS . 'Footer');
		}

		public function adblock()
		{
			// Template
			$this->template->setEverything();
			$this->template->setParam('title', $this->main->texts['titles']['adblock']);
			$this->template->addTemplate('AdBlock');
		}

		public function profile($profile = false)
		{
			$profile = $this->protection->filter($profile);
			if ($this->hotel->getConfig('maintenance') && !in_array($this->users->get('rank'), $this->hotel->getMaster('all'))) {
				header("Location: {$this->url}/");
				exit();
			}
			// Template
			define('ADS', true);
			$this->template->setEverything();
			if (is_numeric($profile) || empty($profile)) {
				if (!$profile) {
					if ($this->users->getSession()) {
						$this->template->setParam('title', $this->main->texts['titles']['profiles']);
						$this->template->addTemplate('Template' . DS . 'Header');
						$this->template->addTemplate();
						$this->template->addTemplate('Template' . DS . 'Footer');
					} else {
						header("Location: {$this->url}/");
						exit();
					}
				} else {
					$query = $this->con->query("SELECT * FROM users WHERE id = '{$profile}'");
					$select = mysqli_fetch_assoc($query);
					if (!$select['block_view_profile']) {
						foreach ($select as $key => $value) {
							$this->template->setParam('user_' . $key, $value);
						}
						$this->template->setParam('user_motto', $this->protection->filter($select['motto']));
						if ($this->con->num_rows($query) > 0) {
							$this->template->setParam('title', 'Perfil de {@user_username}');
							$this->template->addTemplate('Template' . DS . 'Header');
							$this->template->addTemplate();
							$this->template->addTemplate('Template' . DS . 'Footer');
						} else {
							$this->template->setParam('title', 'Perfil no encontrado');
							$this->template->addTemplate('Template' . DS . 'Header');
							$this->template->addTemplate('404');
							$this->template->addTemplate('Template' . DS . 'Footer');
						}
					} else {
						$this->template->setParam('title', 'Perfil privado');
						$this->template->addTemplate('Template' . DS . 'Header');
						$this->template->addTemplate('Web' . DS . 'BlockProfile');
						$this->template->addTemplate('Template' . DS . 'Footer');
					}
				}
			} else {
				$this->template->setParam('title', 'Perfil no encontrado');
				$this->template->addTemplate('Template' . DS . 'Header');
				$this->template->addTemplate('404');
				$this->template->addTemplate('Template' . DS . 'Footer');
			}
		}

		public function top()
		{
			if ($this->hotel->getConfig('maintenance') && !in_array($this->users->get('rank'), $this->hotel->getMaster('all'))) {
				header("Location: {$this->url}/");
				exit();
			}
			// Template
			define('ADS', true);
			$this->template->setEverything();
			$this->template->setParam('title', $this->main->texts['titles']['tops']);
			$this->template->addTemplate('Template' . DS . 'Header');
			$this->template->addTemplate();
			$this->template->addTemplate('Template' . DS . 'Footer');
		}

		public function register($referId = false)
		{
			$referId = $this->protection->filter($referId);
			if (!$this->hotel->getConfig('maintenance')) {
				if ($this->users->getSession()) {
					header("Location: {$this->url}/");
					exit();
				} else {
					// Template
					define('ADS', true);
					$referId = $this->protection->filter($referId);
					if ($referId != false) {
						if (is_numeric($referId)) {
							$query = $this->con->query("SELECT * FROM users WHERE id = '{$referId}' LIMIT 1");
							$num_refered = $this->con->num_rows("SELECT * FROM user_refers WHERE refer_ip = '{$this->users->getIP()}'");
							$select = mysqli_fetch_assoc($query);
							$query_limit = $this->con->query("SELECT * FROM users_refer_limit WHERE user_id = '{$this->users->getIP()}'");
							$select_limit = mysqli_fetch_assoc($query_limit);

							if ($this->con->num_rows($query) == 0) {
								$this->sessions->set('session', 'refer', false);
							} else {
								if ($select['ip_reg'] == $this->users->getIP() || $select['ip_last'] == $this->users->getIP()) {
									$this->sessions->set('session', 'refer', false);
								} else {
									if ($num_refered == 0) {
										if ($this->con->num_rows($query_limit) != $select_limit['ref_limit']) {
											$this->sessions->set('session', 'refer', true);
											$this->sessions->set('session', 'refer_ip', $this->users->getIP());
											$this->sessions->set('session', 'referer_id', $select['id']);
										} else {
											$this->sessions->set('session', 'refer', false);
										}
									} else {
										$this->sessions->set('session', 'refer', false);
									}
								}
							}
						} else {
							$this->sessions->set('session', 'refer', false);
						}
					}
					$this->template->setEverything();
					$this->template->setParam('title', $this->main->texts['titles']['register']);
					$this->template->addTemplate('Template' . DS . 'Header');
					$this->template->addTemplate();
					$this->template->addTemplate('Template' . DS . 'Footer');
				}
			} else {
				define('ADS', true);
				$this->template->setEverything();
				$this->template->setParam('title', $this->main->texts['titles']['maintenance']);
				$this->template->addTemplate('Template' . DS . 'Header');
				$this->template->addTemplate('Web' . DS . 'Maintenance');
				$this->template->addTemplate('Template' . DS . 'Footer');
			}
		}

		public function logout()
		{
			if ($this->users->getSession()) {
				// Template
				define('ADS', false);
				$this->sessions->delete('session', '*');
				$this->sessions->delete('cookie', 'username');
				$this->sessions->delete('cookie', 'password');
				$this->template->setEverything();
				$this->template->setParam('title', $this->main->texts['titles']['logout']);
				$this->template->addTemplate('Template' . DS . 'Header');
				$this->template->addTemplate();
				$this->template->addTemplate('Template' . DS . 'Footer');
				$this->redirections->js($this->url, 3000);
			} else {
				$this->sessions->delete('session', '*');
				$this->sessions->delete('cookie', 'username');
				$this->sessions->delete('cookie', 'password');
				header("Location: {$this->url}/");
				exit();
			}
		}

		public function forgot_password($token = false)
		{
			$token = $this->protection->filter($token);
			if ($token) {
				if (!$this->users->getSession()) {
					$time = time();
					$query = $this->con->query("SELECT * FROM user_forgot_code WHERE code = '{$token}'");
					$select = mysqli_fetch_assoc($query);
					$queryUser = $this->con->query("SELECT * FROM users WHERE id = '{$select['user_id']}'");
					$selectUser = mysqli_fetch_assoc($queryUser);
					if ($this->con->num_rows($queryUser)) {
						if ($this->con->num_rows($query) > 0) {
							if ($select['expire'] <= $time) {
								define('ADS', false);
								$this->template->setEverything();
								$this->template->setParam('title', $this->main->texts['titles']['404']);
								$this->template->addTemplate('Template' . DS . 'Header');
								$this->template->addTemplate('404');
								$this->template->addTemplate('Template' . DS . 'Footer');
							} else {
								define('ADS', false);
								foreach ($selectUser as $key => $value) {
									$this->mails->setParam('user_' . $key, $value);
								}
								if ($this->mails->vars['user_facebook_account']) {
									$this->mails->setParam('user_mail', str_replace('.facebook', '', $this->mails->vars['user_mail']));
								}
								$this->mails->send('PRINCIPAL', $this->main->texts['mails']['password_changed'], 'PasswordChanged.html', $this->mails->vars['user_mail']);
								$this->sessions->set('session', 'forgot_code', $token);
								$this->template->setEverything();
								$this->template->setParam('title', 'Recuperar contrase&ntilde;a');
								$this->template->addTemplate('Template' . DS . 'Header');
								$this->template->addTemplate();
								$this->template->addTemplate('Template' . DS . 'Footer');
							}
						} else {
							define('ADS', false);
							$this->template->setEverything();
							$this->template->setParam('title', $this->main->texts['titles']['404']);
							$this->template->addTemplate('Template' . DS . 'Header');
							$this->template->addTemplate('404');
							$this->template->addTemplate('Template' . DS . 'Footer');
						}
					} else {
						define('ADS', false);
						$this->template->setEverything();
						$this->template->setParam('title', $this->main->texts['titles']['404']);
						$this->template->addTemplate('Template' . DS . 'Header');
						$this->template->addTemplate('404');
						$this->template->addTemplate('Template' . DS . 'Footer');
					}
				} else {
					$this->template->setEverything();
					$this->template->setParam('title', $this->main->texts['titles']['me']);
					$this->template->addTemplate('Template' . DS . 'Header');
					$this->template->addTemplate('Web/Me');
					$this->template->addTemplate('Template' . DS . 'Footer');
				}
			}
		}

		public function verificate_mail($code = false) {
			$code = $this->protection->filter($code);
			if ($code) {
				$query = $this->con->query("SELECT * FROM user_verification_code WHERE code = '{$code}'");
				$select = mysqli_fetch_assoc($query);
				$queryUser = $this->con->query("SELECT * FROM users WHERE id = '{$select['user_id']}'");
				$selectUser = mysqli_fetch_assoc($queryUser);
				$time = time();
				if ($this->con->num_rows($query) > 0) {
					if ($this->con->num_rows($queryUser)) {
						if ($select['expire'] > $time) {
							define('ADS', false);
							$this->template->setParam('new_mail', $select['new_mail']);
							$this->mails->setParam('new_mail', $select['new_mail']);
							foreach ($selectUser as $key => $value) {
								$this->mails->setParam('user_' . $key, $value);
							}
							if ($this->mails->vars['user_facebook_account']) {
								$this->mails->setParam('user_mail', str_replace('.facebook', '', $this->mails->vars['user_mail']));
							}
							$this->mails->send('PRINCIPAL', $this->main->texts['mails']['mail_changed'], 'MailChanged.html', $this->mails->vars['user_mail']);
							$this->mails->send('PRINCIPAL', $this->main->texts['mails']['mail_changed'], 'MailChanged.html', $select['new_mail']);
							$this->template->setEverything();
							$this->template->setParam('title', 'Correo verificado');
							$this->template->addTemplate('Template' . DS . 'Header');
							$this->template->addTemplate();
							$this->template->addTemplate('Template' . DS . 'Footer');
							$this->users->set('mail', $select['new_mail'], $selectUser['username']);
							$this->con->query("UPDATE user_verification_code SET expire = '0' WHERE code = '{$code}'");
						} else {
							define('ADS', false);
							$this->template->setEverything();
							$this->template->setParam('title', $this->main->texts['titles']['404']);
							$this->template->addTemplate('Template' . DS . 'Header');
							$this->template->addTemplate('404');
							$this->template->addTemplate('Template' . DS . 'Footer');
						}
					} else {
						define('ADS', false);
						$this->template->setEverything();
						$this->template->setParam('title', $this->main->texts['titles']['404']);
						$this->template->addTemplate('Template' . DS . 'Header');
						$this->template->addTemplate('404');
						$this->template->addTemplate('Template' . DS . 'Footer');
					}
				} else {
					define('ADS', false);
					$this->template->setEverything();
					$this->template->setParam('title', $this->main->texts['titles']['404']);
					$this->template->addTemplate('Template' . DS . 'Header');
					$this->template->addTemplate('404');
					$this->template->addTemplate('Template' . DS . 'Footer');
				}
			} else {
				define('ADS', false);
				$this->template->setEverything();
				$this->template->setParam('title', $this->main->texts['titles']['404']);
				$this->template->addTemplate('Template' . DS . 'Header');
				$this->template->addTemplate('404');
				$this->template->addTemplate('Template' . DS . 'Footer');
			}
		}

		public function delete_account($code = false) {
			$code = $this->protection->filter($code);
			if ($code) {
				$query = $this->con->query("SELECT * FROM user_delete_code WHERE code = '{$code}'");
				$select = mysqli_fetch_assoc($query);
				$queryUser = $this->con->query("SELECT * FROM users WHERE id = '{$select['user_id']}'");
				$selectUser = mysqli_fetch_assoc($queryUser);
				$time = time();
				if ($this->con->num_rows($query) > 0) {
					if ($this->con->num_rows($queryUser)) {
						if ($select['expire'] > $time) {
							define('ADS', false);
							foreach ($selectUser as $key => $value) {
								$this->mails->setParam('user_' . $key, $value);
							}
							if ($this->mails->vars['user_facebook_account']) {
								$this->mails->setParam('user_mail', str_replace('.facebook', '', $this->mails->vars['user_mail']));
							}
							$this->mails->send('PRINCIPAL', $this->main->texts['mails']['account_deleted'], 'AccountDeleted.html', $this->mails->vars['user_mail']);
							$this->template->setEverything();
							$this->template->setParam('title', $this->main->texts['titles']['deleted_account']);
							$this->template->addTemplate('Template' . DS . 'Header');
							$this->template->addTemplate();
							$this->template->addTemplate('Template' . DS . 'Footer');
							$this->users->delete($selectUser['username']);
						} else {
							define('ADS', false);
							$this->template->setEverything();
							$this->template->setParam('title', $this->main->texts['titles']['404']);
							$this->template->addTemplate('Template' . DS . 'Header');
							$this->template->addTemplate('404');
							$this->template->addTemplate('Template' . DS . 'Footer');
						}
					} else {
						define('ADS', false);
						$this->template->setEverything();
						$this->template->setParam('title', $this->main->texts['titles']['404']);
						$this->template->addTemplate('Template' . DS . 'Header');
						$this->template->addTemplate('404');
						$this->template->addTemplate('Template' . DS . 'Footer');
					}
				} else {
					define('ADS', false);
					$this->template->setEverything();
					$this->template->setParam('title', $this->main->texts['titles']['404']);
					$this->template->addTemplate('Template' . DS . 'Header');
					$this->template->addTemplate('404');
					$this->template->addTemplate('Template' . DS . 'Footer');
				}
			} else {
				define('ADS', false);
				$this->template->setEverything();
				$this->template->setParam('title', $this->main->texts['titles']['404']);
				$this->template->addTemplate('Template' . DS . 'Header');
				$this->template->addTemplate('404');
				$this->template->addTemplate('Template' . DS . 'Footer');
			}
		}

		public function cookies()
		{
			// Template
			define('ADS', true);
			$this->template->setEverything();
			$this->template->setParam('title', $this->main->texts['titles']['cookies']);
			$this->template->addTemplate('Template' . DS . 'Header');
			$this->template->addTemplate();
			$this->template->addTemplate('Template' . DS . 'Footer');
		}

		public function terms()
		{
			// Template
			define('ADS', true);
			$this->template->setEverything();
			$this->template->setParam('title', $this->main->texts['titles']['terms']);
			$this->template->addTemplate('Template' . DS . 'Header');
			$this->template->addTemplate();
			$this->template->addTemplate('Template' . DS . 'Footer');
		}

		public function mastercms()
		{
			// Template
			define('ADS', true);
			$this->template->setEverything();
			$this->template->setParam('title', $this->main->texts['titles']['mastercms']);
			$this->template->addTemplate('Template' . DS . 'Header');
			$this->template->addTemplate();
			$this->template->addTemplate('Template' . DS . 'Footer');
		}

		public function verify_client()
		{
			$this->sessions->set('session', 'verify_client', true);
			header("Location: {$this->url}/");
			exit();
		}

		public function team()
		{
			$this->template->setParam('title', $this->main->texts['titles']['team']);
			$this->template->addTemplate('Template' . DS . 'Header');
			$this->template->addTemplate();
			$this->template->addTemplate('Template' . DS . 'Footer');
		}

		public function error404()
		{
			$this->template->setParam('title', $this->main->texts['titles']['404']);
			$this->template->addTemplate('Template' . DS . 'Header');
			$this->template->addTemplate('404');
			$this->template->addTemplate('Template' . DS . 'Footer');
		}

		public function themeInfo()
		{
			$this->template->setParam('title', $this->main->texts['titles']['theme_info']);
			$this->template->addMasterCMSTemplate('ThemeInfo');
		}

		public function client($room = false)
		{
			if ($this->users->getSession()) {
				$pinSession = $this->sessions->get('session', 'client_pin');
				$userPin = $this->users->get('client_pin');
				if (in_array($this->users->get('rank'), $this->hotel->getMaster('all'))) {
					if ($pinSession) {
						if ($this->protection->encriptPassword($pinSession) != $userPin) {
							$this->sessions->delete('session', 'client_pin');
						}
					}
				}
				if ($pinSession || !$pinSession && !in_array($this->users->get('rank'), $this->hotel->getMaster('all'))) {
					$time = time();
					$ticket = $this->hotel->generateTicket();
					// Normal
					$this->con->query("UPDATE users SET auth_ticket = '', auth_ticket = '{$ticket}', ip_last = '', ip_last = '{$this->users->getIP()}', last_online = '', last_online = '{$time}' WHERE id = '{$this->users->get('id')}'");
					// Marsh
					$this->con->query("DELETE FROM user_tickets WHERE user_id = '{$this->users->get('id')}'");
					$this->con->query("DELETE FROM user_tickets WHERE userid = '{$this->users->get('id')}'");
					$this->con->query("INSERT INTO user_tickets (user_id, session_ticket) VALUES ('{$this->users->get('id')}', '{$ticket}')");
					$this->con->query("INSERT INTO user_tickets (userid, sessionticket) VALUES ('{$this->users->get('id')}', '{$ticket}')");
					// Plus
					$this->con->query("DELETE FROM user_auth_ticket WHERE user_id = '{$this->users->get('id')}'");
					$this->con->query("DELETE FROM user_auth_ticket WHERE userid = '{$this->users->get('id')}'");
					$this->con->query("INSERT INTO user_auth_ticket (user_id, auth_ticket) VALUES ('{$this->users->get('id')}', '{$ticket}')");
					$this->con->query("INSERT INTO user_auth_ticket (userid, auth_ticket) VALUES ('{$this->users->get('id')}', '{$ticket}')");
					
					foreach ($this->config->select['CLIENT'] as $key => $value) {
						$this->template->setParam(strtolower($key), $value);
					}
					$this->template->setParam('ticket', $ticket);
					if ($room) {
						if (is_numeric($room)) {
							$this->template->setParam('room', $room);
						}
					}
					$this->template->setParam('title', $this->main->texts['titles']['client']);
					$this->template->addTemplate();
				} else {
					if ($userPin) {
						define('ADS', false);
						$this->template->setEverything();
						$this->template->setParam('title', $this->main->texts['titles']['client_pin']);
						$this->template->setParam('client', true);
						$this->template->setParam('hk', false);
						$this->template->addTemplate('Template' . DS . 'Header', 'Hk');
						$this->template->addTemplate('Web' . DS . 'Pin', 'Hk');
						$this->template->addTemplate('Template' . DS . 'Footer', 'Hk');
					} else {
						define('ADS', false);
						$this->template->setEverything();
						$this->template->setParam('title', $this->main->texts['titles']['client_pin_create']);
						$this->template->setParam('client', true);
						$this->template->setParam('hk', false);
						$this->template->addTemplate('Template' . DS . 'Header', 'Hk');
						$this->template->addTemplate('Web' . DS . 'CreatePin', 'Hk');
						$this->template->addTemplate('Template' . DS . 'Footer', 'Hk');
					}
				}
			} else {
				header("Location: {$this->url}");
				exit();
			}
		}

		public function flash()
		{
			$this->template->setParam('title', $this->main->texts['titles']['flash']);
			$this->template->addTemplate('Template' . DS . 'Header');
			$this->template->addTemplate();
			$this->template->addTemplate('Template' . DS . 'Footer');
		}
	}

?>