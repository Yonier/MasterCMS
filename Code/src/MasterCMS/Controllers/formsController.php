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

	use MasterCMS\Config\{Config, Connection, Request};
	use MasterCMS\Models\{Template, Protection, Sessions, Users, Mails, Redirections, Hotel};

	class formsController {

		private $con;
		private $template;
		private $config;
		private $protection;
		private $users;
		private $mails;
		private $sessions;
		private $redirections;
		private $hotel;
		private $url;

		public function __construct()
		{
			$this->con = new Connection();
			$this->template = new Template;
			$this->config = new Config;
			$this->protection = new Protection;
			$this->sessions = new Sessions;
			$this->users = new Users;
			$this->mails = new Mails;
			$this->redirections = new Redirections;
			$this->hotel = new Hotel;
			$this->template->setEverything();
			$this->url = $this->template->vars['url'];
			$textsNames = array('Login', 'Register', 'Refers', 'Forgot', 'ChangeUserFB', 'Settings');
			$template_name = $this->hotel->getConfig('template_name');
			foreach ($textsNames as $key) {
				$class = "MasterCMS\\Views\\Texts\\Web\\Langs\\{$this->config->select['WEB']['LANG']}\\" . $key;
				$this->$key = new $class;
				$template_name = $this->hotel->getConfig('template_name');
				$class = "MasterCMS\\Views\\WebViews\\{$template_name}\\Langs\\{$this->config->select['WEB']['LANG']}\\Texts\\Main";
				$classRute = ROOT . 'src' . DS . 'MasterCMS' . DS . 'Views' . DS . 'WebViews' . DS . $template_name . DS . 'Langs' . DS . $this->config->select['WEB']['LANG'] . DS . 'Texts' . DS;
				if (file_exists($classRute . 'Main' . '.php')) {
					if (class_exists($class)) {
						$class = new $class;
						$cont = $class->texts['cont'];
						foreach ($cont as $key2 => $value) {
							if ($key2 == 'error_start') {
								$this->$key->texts['cont']['error_start'] = $class->texts['cont']['error_start'];
							}

							if ($key2 == 'error_end') {
								$this->$key->texts['cont']['error_end'] = $class->texts['cont']['error_end'];
							}

							if ($key2 == 'success_start') {
								$this->$key->texts['cont']['success_start'] = $class->texts['cont']['success_start'];
							}

							if ($key2 == 'success_end') {
								$this->$key->texts['cont']['success_end'] = $class->texts['cont']['success_end'];
							}
						}
					}
				}
			}

			$class = "MasterCMS\\Views\\WebViews\\{$template_name}\\Langs\\{$this->config->select['WEB']['LANG']}\\Texts\\Main";
			$this->main = new $class;
		}

		public function php($type, $add = false, $add2 = false)
		{
			// If not logged
			if (!$this->users->getSession()) {
				if ($type == 'login') {
					// Gets
					$username = $this->protection->filter($_POST['username']);
				    $password = $this->protection->filter($_POST['password']);
				    $remember = $this->protection->filter($_POST['remember']);
					$getUser = $this->con->query("SELECT * FROM users WHERE username = '{$username}' AND password = '{$this->protection->encriptPassword($password)}'");
					$getSame = $this->con->num_rows("SELECT * FROM users WHERE username = '{$username}'");
					$selectUser = $this->con->fetch_assoc($getUser);
					$getFb = $this->con->query("SELECT * FROM users WHERE username = '{$username}' AND facebook_account = '1'");
					$getBan = $this->con->query("SELECT * FROM bans WHERE value = '{$this->users->getIP()}' OR value = '{$username}' LIMIT 1");
					$cb = $this->con->fetch_assoc($getBan);

					// Form
					if (empty($username) || empty($password)) {
						echo $this->Login->texts['cont']['error_start'] . $this->Login->texts['texts']['empty'] . $this->Login->texts['cont']['error_end'];
					} elseif ($getSame > 1) {
						echo $this->Login->texts['cont']['error_start'] . $this->Login->texts['texts']['account_has_2'] . $this->Login->texts['cont']['error_end'];
					} elseif ($this->con->num_rows($getUser) == 0) {
						echo $this->Login->texts['cont']['error_start'] . $this->Login->texts['texts']['incorrect_data'] . $this->Login->texts['cont']['error_end'];
					} elseif ($this->con->num_rows($getBan) > 0) {					
						if ($cb['expire'] <= time()) {
							$this->con->query("DELETE FROM bans WHERE value = '{$cb['value']}'");

							if (!$this->users->getSession()) {
								if ($this->hotel->getConfig('maintenance') && !in_array($selectUser['rank'], $this->hotel->getMaster('all'))) {
									echo $this->Login->texts['cont']['error_start'] . $this->Login->texts['texts']['maintenance'] . $this->Login->texts['cont']['error_end'];
								} else {
									$password = $this->protection->encriptPassword($password);
									$time = time();
									if (!$remember) {
										$this->sessions->set('session', 'username', $username);
										$this->sessions->set('session', 'password', $password);
										$set = $this->users->set('last_used', time());
										$set .= $this->users->set('ip_last', $this->users->getIP());
									} else {
										$this->sessions->set('cookie', 'username', $username);
										$this->sessions->set('cookie', 'password', $password);
										$set = $this->con->query("UPDATE users SET last_used = '{$time}', ip_last = '{$this->users->getIP()}' WHERE username = '{$username}'");
									}

									echo $this->Login->texts['cont']['success_start'] . $this->Login->texts['texts']['success'] . $this->Login->texts['cont']['success_end'] . $this->redirections->js($this->url, 3000);
									if (!$set) {
										echo $this->Login->texts['cont']['error_start'] . $this->Login->texts['texts']['database'] . $this->Login->texts['cont']['error_end'];
									}

									$this->sessions->delete('session', 'refer');
									$this->sessions->delete('session', 'refer_ip');
									$this->sessions->delete('session', 'referer_id');
								}

							} else {
								echo $this->Login->texts['cont']['error_start'] . $this->Login->texts['texts']['sessioned'] . $this->Login->texts['cont']['error_end'];
							}
						} else {
							echo $this->Login->texts['cont']['error_start'] . $this->Login->texts['texts']['banned_1'] . $cb['added_by'] . $this->Login->texts['texts']['banned_2'] . $cb['reason'] . $this->Login->texts['texts']['banned_3'] . date('d/m/Y - H:i:s', $cb['expire']) . $this->Login->texts['texts']['banned_4'] . $this->Login->texts['cont']['error_end'];
						}
					} elseif ($this->con->num_rows($getFb) > 0) {
						echo $this->Login->texts['cont']['error_start'] . $this->Login->texts['texts']['facebook_account'] . $this->Login->texts['cont']['error_end'];
					} else {
						if (!$this->users->getSession()) {
							if ($this->hotel->getConfig('maintenance') && !in_array($selectUser['rank'], $this->hotel->getMaster('all'))) {
								echo $this->Login->texts['cont']['error_start'] . $this->Login->texts['texts']['maintenance'] . $this->Login->texts['cont']['error_end'];
							} else {
								$password = $this->protection->encriptPassword($password);
								$time = time();
								if (!$remember) {
									$this->sessions->set('session', 'username', $username);
									$this->sessions->set('session', 'password', $password);
									$set = $this->users->set('last_used', time());
									$set .= $this->users->set('ip_last', $this->users->getIP());
								} else {
									$this->sessions->set('cookie', 'username', $username);
									$this->sessions->set('cookie', 'password', $password);
									$set = $this->con->query("UPDATE users SET last_used = '{$time}', ip_last = '{$this->users->getIP()}' WHERE username = '{$username}'");
								}

								if (!$set) {
									echo $this->Login->texts['cont']['error_start'] . $this->Login->texts['texts']['database'] . $this->Login->texts['cont']['error_end'];
								} else {
									echo $this->Login->texts['cont']['success_start'] . $this->Login->texts['texts']['success'] . $this->Login->texts['cont']['success_end'] . $this->redirections->js($this->url, 3000);
								}

								$this->sessions->delete('session', 'refer');
								$this->sessions->delete('session', 'refer_ip');
								$this->sessions->delete('session', 'referer_id');
							}

						} else {
							echo $this->Login->texts['cont']['error_start'] . $this->Login->texts['texts']['sessioned'] . $this->Login->texts['cont']['error_end'];
						}
					}
				}

				if ($type == 'register') {
					$username = $this->protection->filter($_POST['username']);
				    $password = $this->protection->filter($_POST['password']);
				    $rpassword = $this->protection->filter($_POST['rpassword']);
				    $mail = $this->protection->filter($_POST['mail']);
				    $rmail = $this->protection->filter($_POST['rmail']);
				    $gender = $this->protection->filter($_POST['gender']);
				    $look = $this->protection->filter($_POST['look']);
				    $terms = $this->protection->filter($_POST['terms']);
				    $motto = $this->config->select['USER_REGISTER']['MOTTO'];
				    $credits = $this->config->select['USER_REGISTER']['CREDITS'];
				    $duckets = $this->config->select['USER_REGISTER']['DUCKETS'];
				    $diamonds = $this->config->select['USER_REGISTER']['DIAMONDS'];
				    $gotw = $this->config->select['USER_REGISTER']['GOTW'];
				    $home_room = $this->config->select['USER_REGISTER']['HOME_ROOM'];
				    $ip_reg = $this->users->getIP();
				    $getUserIP = $this->con->query("SELECT * FROM users WHERE ip_reg = '{$ip_reg}' OR ip_last = '{$ip_reg}'");
				    $getUser = $this->con->query("SELECT * FROM users WHERE username = '{$username}'");
				    $getMail = $this->con->query("SELECT * FROM users WHERE mail = '{$mail}'");
				    $getBan = $this->con->query("SELECT * FROM bans WHERE value = '{$this->users->getIP()}' LIMIT 1");
				    $cb = $this->con->fetch_assoc($getBan);
					$filter = preg_replace("/[^a-z\d\-=\?!@:\.]/i", "", $username);
					$pass1 = strpos($password, 1);
					
					if (!$look) {
						if ($gender == 'M') {
							$look = 'hd-180-2.hr-3163-42.he-3070-62.ch-3030-1330.cp-3315-1427.lg-3058-110.sh-3016-100.wa-2001-70';
						} else {
							$look = 'hd-3096-1.hr-3012-31.ch-665-92.cc-3066-1324.lg-3006-63.sh-3016-1408';
						}
					}

					// Form
					if (empty($username) || empty($password) || empty($mail) || empty($rmail) || empty($rpassword) || empty($gender)) {
				        echo $this->Register->texts['cont']['error_start'] . $this->Register->texts['texts']['empty'] . $this->Register->texts['cont']['error_end'];
				    } elseif ($username !== $filter || strrpos($username, "MOD-") !== false || strrpos($username, "-MOD") !== false) {
				    	echo $this->Register->texts['cont']['error_start'] . $this->Register->texts['texts']['invalid_name'] . $this->Register->texts['cont']['error_end'];
				    } elseif (strlen($username) < 4 || strlen($username) > 15) {
				        echo $this->Register->texts['cont']['error_start'] . $this->Register->texts['texts']['short_or_large_name'] . $this->Register->texts['cont']['error_end'];
				    } elseif (strlen($password) > 30 || strlen($password) < 4) {
				        echo $this->Register->texts['cont']['error_start'] . $this->Register->texts['texts']['short_or_large_password'] . $this->Register->texts['cont']['error_end'];
				    } elseif($this->con->num_rows($getUser) > 0) {
				        echo $this->Register->texts['cont']['error_start'] . $this->Register->texts['texts']['user_exist'] . $this->Register->texts['cont']['error_end'];
				    } elseif($this->con->num_rows($getMail) > 0) {
				        echo $this->Register->texts['cont']['error_start'] . $this->Register->texts['texts']['mail_exist'] . $this->Register->texts['cont']['error_end'];
				    } elseif ($mail != $rmail) {
				        echo $this->Register->texts['cont']['error_start'] . $this->Register->texts['texts']['mails_not_same'] . $this->Register->texts['cont']['error_end'];
				    } elseif ($password != $rpassword) {
				        echo $this->Register->texts['cont']['error_start'] . $this->Register->texts['texts']['passwords_not_same'] . $this->Register->texts['cont']['error_end'];
				    } elseif (!preg_match("`[0-9]`", $password) || !preg_match("`[a-z]`", $password)) {
				    	echo $this->Register->texts['cont']['error_start'] . $this->Register->texts['texts']['not_numbers_on_pass'] . $this->Register->texts['cont']['error_end'];
				    } elseif (!$this->users->validateMail($mail)) {
				        echo $this->Register->texts['cont']['error_start'] . $this->Register->texts['texts']['invalid_mail'] . $this->Register->texts['cont']['error_end'];
				    } elseif (!$terms) {
				    	echo $this->Register->texts['cont']['error_start'] . $this->Register->texts['texts']['agree_terms'] . $this->Register->texts['cont']['error_end'];
				    } elseif ($this->con->num_rows($getUserIP) >= $this->config->select['USER_REGISTER']['MAX_ACCOUNTS']) {
				        echo $this->Register->texts['cont']['error_start'] . $this->Register->texts['texts']['max_accounts'] . $this->config->select['USER_REGISTER']['MAX_ACCOUNTS'] . $this->Register->texts['cont']['error_end'];
				    } elseif($this->con->num_rows($getBan) > 0) {
				        if ($cb['expire'] <= time()) {
							$this->con->query("DELETE FROM bans WHERE value = '{$cb['value']}'");
					    	if (!$this->users->getSession()) {
					    		$password = $this->protection->encriptPassword($password);
								$add = $this->users->add($username, $password, $mail, $gender, $motto, $look, $credits, $duckets, $diamonds, $ip_reg);
						    	if ($add) {
						    		echo $this->Register->texts['cont']['success_start'] . $this->Register->texts['texts']['success'] . $this->Register->texts['cont']['success_end'] . $this->redirections->js($this->url, 3000);

									if ($this->sessions->get('session', 'refer')) {
										$this->users->addRefer($username, $this->sessions->get('session', 'referer_id'), $this->sessions->get('session', 'refer_ip'));
									}
									$this->sessions->delete('session', 'refer');
									$this->sessions->delete('session', 'refer_ip');
									$this->sessions->delete('session', 'referer_id');
									$this->sessions->set('session', 'username', $username);
									$this->sessions->set('session', 'password', $password);
									$queryUser = $this->con->query("SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}'");
									$selectUser = $this->con->fetch_assoc($queryUser);
									foreach ($selectUser as $key => $value) {
										$this->mails->setParam('user_' . $key, $value);
									}
									$this->mails->send('PRINCIPAL', $this->main->texts['mails']['account_created'], 'AccountCreated.html', $this->mails->vars['user_mail']);
						    	} else {
						    		echo $this->Register->texts['cont']['error_start'] . $this->Register->texts['texts']['database'] . $this->Register->texts['cont']['error_end'];
						    	}
							} else {
								echo $this->Register->texts['cont']['error_start'] . $this->Register->texts['texts']['sessioned'] . $this->Register->texts['cont']['error_end'];
							}
						} else {
							echo $this->Register->texts['cont']['error_start'] . $this->Register->texts['texts']['banned_1'] . $cb['added_by'] . $cb2['added_by'] . $this->Register->texts['texts']['banned_2'] . $cb['reason'] . $cb2['reason'] . $this->Register->texts['texts']['banned_3'] . date('d/m/Y - H:i:s', $cb['expire']) . date('d/m/Y - H:i:s', $cb2['expire']) . $this->Register->texts['texts']['banned_4'] . $this->Register->texts['cont']['error_end'];
						}
				    } else {
				    	if (!$this->users->getSession()) {
					    	if (!$this->hotel->getConfig('maintenance')) {
					    		$password = $this->protection->encriptPassword($password);
								$add = $this->users->add($username, $password, $mail, $gender, $motto, $look, $credits, $duckets, $diamonds, $ip_reg, $home_room);
						    	if ($add) {
						    		echo $this->Register->texts['cont']['success_start'] . $this->Register->texts['texts']['success'] . $this->Register->texts['cont']['success_end'] . $this->redirections->js($this->url, 3000);
						    		if ($this->sessions->get('session', 'refer')) {
										$this->users->addRefer($username, $this->sessions->get('session', 'referer_id'), $this->sessions->get('session', 'refer_ip'));
									}
									$this->sessions->delete('session', 'refer');
									$this->sessions->delete('session', 'refer_ip');
									$this->sessions->delete('session', 'referer_id');
									$this->sessions->set('session', 'username', $username);
									$this->sessions->set('session', 'password', $password);
									$queryUser = $this->con->query("SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}'");
									$selectUser = $this->con->fetch_assoc($queryUser);
									foreach ($selectUser as $key => $value) {
										$this->mails->setParam('user_' . $key, $value);
									}
									$this->mails->send('PRINCIPAL', $this->main->texts['mails']['account_created'], 'AccountCreated.html', $this->mails->vars['user_mail']);
						    	} else {
						    		echo $this->Register->texts['cont']['error_start'] . $this->Register->texts['texts']['database'] . $this->Register->texts['cont']['error_end'];
						    	}
					    	} else {
					    		echo $this->Register->texts['cont']['error_start'] . $this->Register->texts['texts']['maintenance'] . $this->Register->texts['cont']['error_end'];
					    	}
						} else {
							echo $this->Register->texts['cont']['error_start'] . $this->Register->texts['texts']['sessioned'] . $this->Register->texts['cont']['error_end'];
						}
				    }
				}

				if ($type == 'forgot') {
					$mail = $this->protection->filter($_POST['mail']);
					$user = $this->con->query("SELECT * FROM users WHERE mail = '{$mail}' LIMIT 1");
					$user_select = $this->con->fetch_assoc($user);
					if (empty($mail)) {
						echo $this->Forgot->texts['cont']['error_start'] . $this->Forgot->texts['texts']['empty'] . $this->Forgot->texts['cont']['error_end'];
					} else {
						if ($this->con->num_rows($user) == 0) {
							echo $this->Forgot->texts['cont']['error_start'] . $this->Forgot->texts['texts']['incorrect_data'] . $this->Forgot->texts['cont']['error_end'];
						} else {
							if (!$this->users->validateMail($mail)) {
								echo $this->Forgot->texts['cont']['error_start'] . $this->Forgot->texts['texts']['invalid_mail'] . $this->Forgot->texts['cont']['error_end'];
							} else {
								$select = $this->con->query("SELECT * FROM user_forgot_code WHERE user_id = '{$user_select['id']}' ORDER BY id DESC");
								$show = $this->con->fetch_assoc($select);
								if ($this->con->num_rows($select) == 0) {
									if ($user_select['facebook_account'] == 1) {
										echo $this->Forgot->texts['cont']['error_start'] . $this->Forgot->texts['texts']['facebook'] . $this->Forgot->texts['cont']['error_end'];
									} else {
										$this->mails->setParam('username', $user_select['username']);
										$token = $this->mails->generateToken();
										$this->mails->setParam('token', $token);
										$hours = time() + (1 * 24 * 60 * 60);
										$time = time();
										foreach ($user_select as $key => $value) {
											$this->mails->setParam('user_' . $key, $value);
										}
										$sended = $this->mails->send('PRINCIPAL', $this->Forgot->texts['texts']['mail_title'], 'Forgot.html', $mail);
										if ($sended) {
											$query = $this->con->query("INSERT INTO user_forgot_code (user_id, code, expire, timestamp) VALUES ('{$user_select['id']}', '{$token}', '{$hours}', '{$time}')");
											if ($query) {
												echo $this->Forgot->texts['cont']['success_start'] . $this->Forgot->texts['texts']['success'] . $this->Forgot->texts['cont']['success_end'];
											} else {
												echo $this->Forgot->texts['cont']['error_start'] . $this->Forgot->texts['texts']['database'] . $this->Forgot->texts['cont']['error_end'];
											}
										} else {
											echo $this->Forgot->texts['cont']['error_start'] . $this->Forgot->texts['texts']['mail_error'] . $this->Forgot->texts['cont']['error_end'];
										}
									}
								} else {
									if ($show['expire'] <= time()) {
										if ($user_select['facebook_account'] == 1) {
											echo $this->Forgot->texts['cont']['error_start'] . $this->Forgot->texts['texts']['facebook'] . $this->Forgot->texts['cont']['error_end'];
										} else {
											$this->mails->setParam('username', $user_select['username']);
											$token = $this->mails->generateToken();
											$this->mails->setParam('token', $token);
											$hours = time() + (1 * 24 * 60 * 60);
											foreach ($user_select as $key => $value) {
												$this->mails->setParam('user_' . $key, $value);
											}
											$sended = $this->mails->send('PRINCIPAL', $this->Forgot->texts['texts']['mail_title'], 'Forgot.html', $mail);
											if ($sended) {
												$query = $this->con->query("INSERT INTO user_forgot_code (user_id, code, expire) VALUES ('{$user_select['id']}', '{$token}', '{$hours}')");
												if ($query) {
													echo $this->Forgot->texts['cont']['success_start'] . $this->Forgot->texts['texts']['success'] . $this->Forgot->texts['cont']['success_end'];
												} else {
													echo $this->Forgot->texts['cont']['error_start'] . $this->Forgot->texts['texts']['database'] . $this->Forgot->texts['cont']['error_end'];
												}
											} else {
												echo $this->Forgot->texts['cont']['error_start'] . $this->Forgot->texts['texts']['mail_error'] . $this->Forgot->texts['cont']['error_end'];
											}
										}
									} else {
										echo $this->Forgot->texts['cont']['error_start'] . $this->Forgot->texts['texts']['sended'] . $this->Forgot->texts['cont']['error_end'];
									}
								}
							}
						}
					}
				}

				if ($type == 'forgot_validation') {
					$password = $this->protection->filter($_POST['password']);
					$rpassword = $this->protection->filter($_POST['rpassword']);
					$code = $this->con->query("SELECT * FROM user_forgot_code WHERE code = '{$this->sessions->get('session', 'forgot_code')}'");
					$select_code = $this->con->fetch_assoc($code);
					$user = $this->con->query("SELECT * FROM users WHERE id = '{$select_code['user_id']}' LIMIT 1");
					$user_select = $this->con->fetch_assoc($user);
					if (empty($password) || empty($rpassword)) {
						echo $this->Forgot->texts['cont']['error_start'] . $this->Forgot->texts['texts']['empty'] . $this->Forgot->texts['cont']['error_end'];
					} else {
						if (strlen($password) > 30 || strlen($password) < 4) {
							echo $this->Forgot->texts['cont']['error_start'] . $this->Forgot->texts['texts']['short_or_large_password'] . $this->Forgot->texts['cont']['error_end'];
						} else {
							if ($password != $rpassword) {
								echo $this->Forgot->texts['cont']['error_start'] . $this->Forgot->texts['texts']['passwords_not_same'] . $this->Forgot->texts['cont']['error_end'];
							} elseif (!preg_match("`[0-9]`", $password)) {
						    	echo $this->Forgot->texts['cont']['error_start'] . $this->Forgot->texts['texts']['not_numbers_on_pass'] . $this->Forgot->texts['cont']['error_end'];
						    } else {
								if ($this->protection->encriptPassword($password) == $user_select['password']) {
									echo $this->Forgot->texts['cont']['error_start'] . $this->Forgot->texts['texts']['cant_be_same'] . $this->Forgot->texts['cont']['error_end'];
								} else {
									$update = $this->users->set('password', $this->protection->encriptPassword($password), $user_select['username']);
									$update .= $this->con->query("UPDATE user_forgot_code SET expire = '0' WHERE user_id = '{$user_select['id']}'");
									if ($update) {
										echo $this->Forgot->texts['cont']['success_start'] . $this->Forgot->texts['texts']['success_val'] . $this->Forgot->texts['cont']['success_end'] . $this->redirections->js($this->url, 3000);
										$this->sessions->delete('session', 'forgot_code');
									} else {
										echo $this->Forgot->texts['cont']['error_start'] . $this->Forgot->texts['texts']['database'] . $this->Forgot->texts['cont']['error_end'];
									}
								}
							}
						}
					}
				}
			}

			// If logged

			if ($this->users->getSession()) {
				if ($type == 'refers') {
					$query_refers = $this->con->query("SELECT * FROM user_refers WHERE user_id = '{$this->users->get('id')}'");
	            	$select_refers = $this->con->fetch_assoc($query_refers);
	            	$count_refers = $this->con->num_rows($query_refers);

	            	$query_awards = $this->con->query("SELECT * FROM refers_awards WHERE refers_amount >= '{$count_refers}' LIMIT 1");
	            	$select_awards = $this->con->fetch_assoc($query_awards);
	            	$num_all_awards = $this->con->num_rows("SELECT * FROM refers_awards");

	            	$user_awards = $this->con->query("SELECT * FROM user_awards WHERE user_id = '{$this->users->get('id')}' AND award_type = 'refers' AND award_id = '{$select_awards['id']}' ORDER BY id DESC LIMIT 1");
	            	$select_user_awards = $this->con->fetch_assoc($user_awards);

	            	$query = $this->con->query("SELECT * FROM users_refer_limit WHERE user_id = '{$this->users->get('id')}' LIMIT 1");
					$query_award = $this->con->query("SELECT * FROM refers_awards WHERE refers_amount > '{$count_refers}'");
					$select_award = $this->con->fetch_assoc($query_award);

					$query_awar = $this->con->query("SELECT * FROM refers_awards WHERE refers_amount = '{$count_refers}'");
					$selec_award = $this->con->fetch_assoc($query_awar);

	            	if ($this->users->getSession()) {
	            		if ($num_all_awards != 0) {
	            			if ($select_awards['refers_amount'] == $count_refers) {
	            				if ($select_user_awards['status'] == 'reclamed' || $select_user_awards['status'] == 'declimed') {
	            					echo $this->Refers->texts['cont']['error_start'] . $this->Refers->texts['texts']['reclamed'] . $this->Refers->texts['cont']['error_end'];
	            				} else {

	            					if ($this->con->num_rows($query) == 0) {
										$this->con->query("INSERT INTO users_refer_limit (user_id, ref_limit) VALUES ('{$this->users->get('id')}', '{$select_award['refers_amount']}')");
									} else {
										if (!$add) {
											$this->sessions->set('session', 'raccepted', true);
											$this->sessions->set('session', 'racancelled', false);

											if ($select_awards['award_type'] == 'credits') {
			            						if (is_numeric($select_award['value'])) {
			            							$this->users->set('credits', ($this->users->get('credits') + $select_award['value']));
			            						} else {
			            							$this->users->set('credits', ($this->users->get('credits') + 1000));
			            						}
			            					} elseif ($select_awards['award_type'] == 'diamonds') {
			            						if (is_numeric($select_award['value'])) {
			            							$this->users->set('vip_points', ($this->users->get('vip_points') + $select_award['value']));
			            						} else {
			            							$this->users->set('vip_points', ($this->users->get('vip_points') + 10));
			            						}
			            					} elseif ($select_awards['award_type'] == 'duckets') {
			            						if (is_numeric($select_award['value'])) {
			            							$this->users->set('activity_points', ($this->users->get('activity_points') + $select_award['value']));
			            						} else {
			            							$this->users->set('activity_points', ($this->users->get('activity_points') + 10000));
			            						}
			            					} elseif ($select_awards['award_type'] == 'badges') {
			            						// Code
			            					} elseif ($select_awards['award_type'] == 'ranks') {
			            						if (is_numeric($select_award['value'])) {
			            							$this->users->set('rank', $select_award['value']);
			            						} else {
			            							$this->users->set('rank', 1);
			            						}
			            					} elseif ($select_awards['award_type'] == 'rares') {
			            						// Code
			            					} else {
			            						if (is_numeric($select_award['value'])) {
			            							$this->users->set('credits', ($this->users->get('credits') + $select_award['value']));
			            						} else {
			            							$this->users->set('credits', ($this->users->get('credits') + 1000));
			            						}
			            					}

			            					$this->con->query("INSERT INTO user_awards (user_id, award_id, award_type, status) VALUES ('{$this->users->get('id')}' , '{$selec_award['id']}' , 'refers', 'reclamed')");

			            					echo $this->Refers->texts['cont']['success_start'] . $this->Refers->texts['texts']['success'] . $this->Refers->texts['cont']['success_end'] . $this->redirections->js($this->url, 3000);

										} elseif ($add == 'dec') {
											$this->sessions->set('session', 'racancelled', true);
											$this->sessions->set('session', 'raccepted', false);

											$this->con->query("INSERT INTO user_awards (user_id, award_id, award_type, status) VALUES ('{$this->users->get('id')}' , '{$selec_award['id']}' , 'refers', 'declimed')");

											echo $this->Refers->texts['cont']['success_start'] . $this->Refers->texts['texts']['success_dec'] . $this->Refers->texts['cont']['success_end'] . $this->redirections->js($this->url, 3000);
										}
									}
	            				}
	            			} else {
	            				echo $this->Refers->texts['cont']['error_start'] . $this->Refers->texts['texts']['need_refers'] . $this->Refers->texts['cont']['error_end'];
	            			}
	            		} else {
	            			echo $this->Refers->texts['cont']['error_start'] . $this->Refers->texts['texts']['no_awards'] . $this->Refers->texts['cont']['error_end'];
	            		}
	            	}
				}

				if ($type == 'fbusername') {
					$username = $this->protection->filter($_POST['username']);
					$query = $this->con->query("SELECT * FROM users WHERE username = '{$username}'");
					$filter = preg_replace("/[^a-z\d\-=\?!@:\.]/i", "", $username);
					if ($this->users->get('facebook_account')) {
						if ($this->users->get('facebook_completed') == 0 && $this->users->get('facebook_account') == 1) {
							if (empty($username)) {
								echo $this->ChangeUserFB->texts['cont']['error_start'] . $this->ChangeUserFB->texts['texts']['empty'] . $this->ChangeUserFB->texts['cont']['error_end'];
							} elseif (strlen($username) < 4 || strlen($username) > 15) {
						        echo $this->ChangeUserFB->texts['texts']['short_or_large_name'];
						    } elseif ($username !== $filter || strrpos($username, "MOD-") !== false || strrpos($username, "-MOD") !== false) {
								echo $this->ChangeUserFB->texts['cont']['error_start'] . $this->ChangeUserFB->texts['texts']['invalid_name'] . $this->ChangeUserFB->texts['cont']['error_end'];
							} else {
								if ($this->con->num_rows($query) > 0) {
									echo $this->ChangeUserFB->texts['cont']['error_start'] . $this->ChangeUserFB->texts['texts']['incorrect_data'] . $this->ChangeUserFB->texts['cont']['error_end'];
								} else {
									$update = $this->users->set('username', $username);
									$update .= $this->users->set('facebook_completed', 1);
									if ($update) {
										echo $this->ChangeUserFB->texts['cont']['success_start'] . $this->ChangeUserFB->texts['texts']['success'] . $this->ChangeUserFB->texts['cont']['success_end'] . $this->redirections->js($this->url, 3000);
									} else {
										echo $this->ChangeUserFB->texts['cont']['error_start'] . $this->ChangeUserFB->texts['texts']['database'] . $this->ChangeUserFB->texts['cont']['error_end'] . $this->redirections->js($this->url, 3000);
									}
								}
							}
						} else {
							echo $this->ChangeUserFB->texts['cont']['error_start'] . $this->ChangeUserFB->texts['texts']['completed'] . $this->ChangeUserFB->texts['cont']['error_end'];
						}
					} else {
						echo $this->ChangeUserFB->texts['cont']['error_start'] . $this->ChangeUserFB->texts['texts']['no_facebook'] . $this->ChangeUserFB->texts['cont']['error_end'];
					}
				}

				if ($type == 'settings') {
					if ($add == 'general') {
						$chat_color = $this->protection->filter($_POST['chat_color']);
						$colors = array(0, 'blue', 'red', 'green', 'cyan', 'purple');
						$allowtr = $this->protection->filter($_POST['allowtr']);
						$allowfr = $this->protection->filter($_POST['allowfr']);
						$allowpr = $this->protection->filter($_POST['allowpr']);
						$oldchat = $this->protection->filter($_POST['oldchat']);
						$invitations = $this->protection->filter($_POST['invitations']);
						$focus = $this->protection->filter($_POST['focus']);
						$error_start = $this->Settings->texts['cont']['error_start'];
						$error_end = $this->Settings->texts['cont']['error_end'];
						if (!in_array($chat_color, $colors)) {
							$error = $this->Settings->texts['texts']['invalid_color'];
						} else if ($allowfr != 0 && $allowfr != 1 || $allowtr != 0 && $allowtr != 1 || $allowpr != 0 && $allowpr != 1 || $oldchat != 0 && $oldchat != 1 || $invitations != 0 && $invitations != 1) {
							$error = $this->Settings->texts['texts']['dont_try_inyect'];
						} else {
							$edit = $this->users->set('chat_color', "@{$chat_color}@");
							$edit .= $this->users->set('block_newfriends', $allowfr);
							$edit .= $this->users->set('block_trade', $allowtr);
							$edit .= $this->users->set('block_view_profile', $allowpr);
							$edit .= $this->users->set('prefer_old_chat', $oldchat);
							$edit .= $this->users->set('ignoreRoomInvitations', $invitations);
							$edit .= $this->users->set('dontfocususers', $focus);

							$this->hotel->sendMUS("updatechatsettings;{$this->users->get('id')}");
							$this->hotel->sendMUS("updatepetitionsdisable;{$this->users->get('id')};{$allowfr}");
							$this->hotel->sendMUS("updatetradesdisable;{$this->users->get('id')};{$allowtr}");
							$this->hotel->sendMUS("updateignoreroominvitations;{$this->users->get('id')};{$invitations}");
							$this->hotel->sendMUS("updatedontfocususers;{$this->users->get('id')};{$focus}");
							$this->hotel->sendMUS("updateprefoldchat;{$this->users->get('id')};{$oldchat}");

							if ($edit) {
								$error_start = $this->Settings->texts['cont']['success_start'];
								$error = $this->Settings->texts['texts']['success'];
								$error_end = $this->Settings->texts['cont']['success_end'];
							} else {
								$error = $this->Settings->texts['texts']['database'];
							}
						}
						echo $error_start . $error . $error_end;
					} else if ($add == 'password') {
						$error_start = $this->Settings->texts['cont']['error_start'];
						$error_end = $this->Settings->texts['cont']['error_end'];
						if (!$this->users->get('facebook_account')) {
							$oldpassword = $this->protection->filter($_POST['oldpassword']);
							$newpassword = $this->protection->filter($_POST['newpassword']);
							$rnewpassword = $this->protection->filter($_POST['rnewpassword']);
							if (empty($oldpassword) || empty($newpassword) || empty($rnewpassword)) {
								$error = $this->Settings->texts['texts']['empty'];
							} else if ($this->protection->encriptPassword($oldpassword) != $this->users->get('password')) {
								$error = $this->Settings->texts['texts']['not_same'];
							} else if ($newpassword != $rnewpassword) {
								$error = $this->Settings->texts['texts']['not_same_new'];
							} elseif (strlen($newpassword) < 4 || strlen($newpassword) > 30) {
								$error = $this->Settings->texts['texts']['short_or_large_password'];
							} elseif (!preg_match("`[0-9]`", $newpassword) || !preg_match("`[a-z]`", $newpassword)) {
						    	$error = $this->Settings->texts['texts']['not_numbers_on_pass'];
						    } elseif ($this->protection->encriptPassword($newpassword) == $this->users->get('password')) {
								$error = $this->Settings->texts['texts']['cant_be_old_pass'];
							} else {
								$queryUser = $this->con->query("SELECT * FROM users WHERE id = '{$this->users->get('id')}'");
								$selectUser = $this->con->fetch_assoc($queryUser);
								foreach ($selectUser as $key => $value) {
									$this->mails->setParam('user_' . $key, $value);
								}
								if ($this->mails->vars['user_facebook_account']) {
									$this->mails->setParam('user_mail', str_replace('.facebook', '', $this->mails->vars['user_mail']));
								}
								$this->mails->send('PRINCIPAL', 'Password Changed', 'PasswordChanged.html', $this->users->get('mail'));
								$set = $this->users->set('password', $this->protection->encriptPassword($newpassword));
								if ($set) {
									$error_start = $this->Settings->texts['cont']['success_start'];
									$error = $this->Settings->texts['texts']['success_pass'];
									$error .= $this->redirections->js($this->url . '/hk', 3000);
									$error_end = $this->Settings->texts['cont']['success_end'];
									$this->sessions->delete('session', '*');
									$this->sessions->delete('cookie', 'username');
									$this->sessions->delete('cookie', 'password');
								} else {
									$error = $this->Settings->texts['texts']['database'];
								}
							}
						} else {
							$error = $this->Settings->texts['texts']['facebook_account'];
						}
						echo $error_start . $error . $error_end;
					} else if ($add == 'mail') {
						$error_start = $this->Settings->texts['cont']['error_start'];
						$error_end = $this->Settings->texts['cont']['error_end'];
						if (!$this->users->get('facebook_account')) {
							$oldmail = $this->protection->filter($_POST['oldmail']);
							$newmail = $this->protection->filter($_POST['newmail']);
							$rnewmail = $this->protection->filter($_POST['rnewmail']);
							$queryMails = $this->con->query("SELECT * FROM users WHERE mail = '{$newmail}'");
							if (empty($oldmail) || empty($newmail) || empty($rnewmail)) {
								$error = $this->Settings->texts['texts']['empty'];
							} elseif (!$this->users->validateMail($newmail)) {
								$error = $this->Settings->texts['texts']['invalid_mail'];
							} else if ($oldmail != $this->users->get('mail')) {
								$error = $this->Settings->texts['texts']['not_same_mail'];
							} else if ($newmail != $rnewmail) {
								$error = $this->Settings->texts['texts']['not_same_new_mail'];
							} else if ($newmail == $this->users->get('mail')) {
								$error = $this->Settings->texts['texts']['cant_be_old_mail'];
							} else if ($this->con->num_rows($queryMails) > 0) {
								$error = $this->Settings->texts['texts']['mail_used'];
							} else {
								$query = $this->con->query("SELECT * FROM user_verification_code WHERE user_id = '{$this->users->get('id')}' ORDER BY id DESC");
								$hours = time() + (1 * 24 * 60 * 60);
								$time = time();
								if ($this->con->num_rows($query) > 0) {
									$select = $this->con->fetch_assoc($query);
									if ($select['expire'] <= $time) {
										// Send Mail
										$token = $this->mails->generateToken();
										$this->mails->setParam('token', $token);
										$this->mails->setParam('username', $this->users->get('username'));
										$this->mails->setParam('old_mail', $this->users->get('mail'));
										$this->mails->setParam('new_mail', $newmail);
										$queryUser = $this->con->query("SELECT * FROM users WHERE id = '{$this->users->get('id')}'");
										$selectUser = $this->con->fetch_assoc($queryUser);
										foreach ($selectUser as $key => $value) {
											$this->mails->setParam('user_' . $key, $value);
										}
										$send = $this->mails->send('PRINCIPAL', $this->Settings->texts['texts']['mail_title'], 'Verification.html', $newmail);
										if ($send) {
											$error_start = $this->Settings->texts['cont']['success_start'];
											$time = time();
											$add = $this->con->query("INSERT INTO user_verification_code (user_id, code, expire, new_mail, timestamp) VALUES ('{$this->users->get('id')}', '{$token}', '{$hours}', '{$newmail}', {$time})");
											if ($add) {
												$error_start = $this->Settings->texts['cont']['success_start'];
												$error = $this->Settings->texts['texts']['success_mail'];
												$error_end = $this->Settings->texts['cont']['success_end'];
											} else {
												$error = $this->Settings->texts['texts']['database'];
											}
											$error_end = $this->Settings->texts['cont']['success_end'];
										} else {
											$error = $this->Settings->texts['texts']['mail_error'];
										}
									} else {
										$error = $this->Settings->texts['texts']['mail_sended'];
									}
								} else {
									// Send Mail
									$token = $this->mails->generateToken();
									$this->mails->setParam('token', $token);
									$this->mails->setParam('username', $this->users->get('username'));
									$this->mails->setParam('old_mail', $this->users->get('mail'));
									$this->mails->setParam('new_mail', $newmail);
									$queryUser = $this->con->query("SELECT * FROM users WHERE id = '{$this->users->get('id')}'");
									$selectUser = $this->con->fetch_assoc($queryUser);
									foreach ($selectUser as $key => $value) {
										$this->mails->setParam('user_' . $key, $value);
									}
									$send = $this->mails->send('PRINCIPAL', $this->Settings->texts['texts']['mail_title'], 'Verification.html', $newmail);
									if ($send) {
										$time = time();
										$add = $this->con->query("INSERT INTO user_verification_code (user_id, code, expire, new_mail, timestamp) VALUES ('{$this->users->get('id')}', '{$token}', '{$hours}', '{$newmail}', {$time})");
										if ($add) {
											$error_start = $this->Settings->texts['cont']['success_start'];
											$error = $this->Settings->texts['texts']['success_mail'];
											$error_end = $this->Settings->texts['cont']['success_end'];
										} else {
											$error = $this->Settings->texts['texts']['database'];
										}
									} else {
										$error = $this->Settings->texts['texts']['mail_error'];
									}
								}
							}
						} else {
							$error = $this->Settings->texts['texts']['facebook_account'];
						}
						echo $error_start . $error . $error_end;
					} else if ($add == 'delete') {
						$error_start = $this->Settings->texts['cont']['error_start'];
						$error_end = $this->Settings->texts['cont']['error_end'];
						$accept = $this->protection->filter($_POST['accept']);
						if (!$accept) {
							$error = $this->Settings->texts['texts']['accept'];
						} else {
							$query = $this->con->query("SELECT * FROM user_delete_code WHERE user_id = '{$this->users->get('id')}' ORDER BY id DESC");
							$hours = time() + (1 * 24 * 60 * 60);
							$time = time();
							if ($this->con->num_rows($query) > 0) {
								$select = $this->con->fetch_assoc($query);
								if ($select['expire'] <= $time) {
									// Send Mail
									$token = $this->mails->generateToken();
									$this->mails->setParam('token', $token);
									$this->mails->setParam('username', $this->users->get('username'));
									$queryUser = $this->con->query("SELECT * FROM users WHERE id = '{$this->users->get('id')}'");
								$selectUser = $this->con->fetch_assoc($queryUser);
								foreach ($selectUser as $key => $value) {
									$this->mails->setParam('user_' . $key, $value);
								}
									$send = $this->mails->send('PRINCIPAL', $this->Settings->texts['texts']['mail_title_del'], 'Delete.html', $this->users->get('mail'));
									if ($send) {
										$time = time();
										$add = $this->con->query("INSERT INTO user_delete_code (user_id, code, expire, timestamp) VALUES ('{$this->users->get('id')}', '{$token}', '{$hours}', {$time})");
										if ($add) {
											$error_start = $this->Settings->texts['cont']['success_start'];
											$error = $this->Settings->texts['texts']['success_mail_del'];
											$error_end = $this->Settings->texts['cont']['success_end'];
										} else {
											$error = $this->Settings->texts['texts']['database'];
										}
									} else {
										$error = $this->Settings->texts['texts']['mail_error'];
									}
								} else {
									$error = $this->Settings->texts['texts']['mail_sended'];
								}
							} else {
								// Send Mail
								$token = $this->mails->generateToken();
								$this->mails->setParam('token', $token);
								$this->mails->setParam('username', $this->users->get('username'));
								$queryUser = $this->con->query("SELECT * FROM users WHERE id = '{$this->users->get('id')}'");
								$selectUser = $this->con->fetch_assoc($queryUser);
								foreach ($selectUser as $key => $value) {
									$this->mails->setParam('user_' . $key, $value);
								}
								$send = $this->mails->send('PRINCIPAL', $this->Settings->texts['texts']['mail_title_del'], 'Delete.html', $this->users->get('mail'));
								if ($send) {
									$time = time();
									$add = $this->con->query("INSERT INTO user_delete_code (user_id, code, expire, timestamp) VALUES ('{$this->users->get('id')}', '{$token}', '{$hours}', {$time})");
									if ($add) {
										$error_start = $this->Settings->texts['cont']['success_start'];
										$error = $this->Settings->texts['texts']['success_mail_del'];
										$error_end = $this->Settings->texts['cont']['success_end'];
									} else {
										$error = $this->Settings->texts['texts']['database'];
									}
								} else {
									$error = $this->Settings->texts['texts']['mail_error'];
								}
							}
						}
						echo $error_start . $error . $error_end;
					}
				}
			}
		}
	}

?>
