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

	class Users {

		private $con;
		private $mail;
		private $redirections;
		private $sessions;
		private $config;
		private $template;
		private $facebook;
		private $protection;
		private $hotel;

		public function __construct()
		{
			$this->con = new Connection;
			$this->sessions = new Sessions;
			$this->redirections = new Redirections;
			$this->config = new Config;
			$this->protection = new Protection;
			$this->request = new Request;
			$this->facebook = new Facebook;
			$this->hotel = new Hotel;
			$this->url = $this->template->vars['url'];

			if ($this->request->getMethod() == 'verify_client' && $this->request->getController() == 'web') {
				$getUser = $this->con->query("SELECT * FROM users WHERE facebook_id = '{$this->facebook->getUser('id')}' AND facebook_account = '1'");
				$selectUser = $this->con->fetch_assoc($getUser);
				if (!$this->hotel->getConfig('maintenance')) {
					if ($this->facebook->getSession()) {
						if (!$this->con->num_rows($getUser)) {
							$motto = $this->config->select['USER_REGISTER']['MOTTO'];
						    $credits = $this->config->select['USER_REGISTER']['CREDITS'];
						    $duckets = $this->config->select['USER_REGISTER']['DUCKETS'];
						    $diamonds = $this->config->select['USER_REGISTER']['DIAMONDS'];
						    $gotw = $this->config->select['USER_REGISTER']['GOTW'];
						    $ip_reg = $this->getIP();
						    $home_room = $this->config->select['USER_REGISTER']['HOME_ROOM'];
							if ($this->facebook->getUser('gender') == 'male') {
								$gender = 'M';
								$look = 'hd-180-2.hr-3163-42.he-3070-62.ch-3030-1330.cp-3315-1427.lg-3058-110.sh-3016-100.wa-2001-70';
							} else {
								$gender = 'F';
								$look = 'hd-3096-1.hr-3012-31.ch-665-92.cc-3066-1324.lg-3006-63.sh-3016-1408';
							}
							$add = $this->add(substr($this->facebook->getUser('first_name'), 0, 10) . substr($this->facebook->getUser('id'), 2, 5) . rand(0, 9) . rand(0, 9), $this->protection->encriptPassword($this->generateToken()), $this->facebook->getUser('email') . '.facebook', $gender, $motto, $look, $credits, $duckets, $diamonds, $ip_reg, $home_room, 1, $this->facebook->getUser('id'), 0);
							if (!$add) {
								$this->sessions->delete('session', 'username');
								$this->sessions->delete('session', 'password');
								$this->sessions->delete('cookie', 'username');
								$this->sessions->delete('cookie', 'password');
								$this->sessions->delete('session', 'facebook_id');
							} else {
								$this->sessions->delete('session', 'username');
								$this->sessions->delete('session', 'password');
								$this->sessions->delete('cookie', 'username');
								$this->sessions->delete('cookie', 'password');
								$this->sessions->delete('session', 'facebook_id');
								$this->sessions->set('session', 'facebook_id', $this->facebook->getUser('id'));
							}
						} else {
							$ip_last = $this->getIP();
							$this->sessions->delete('session', 'username');
							$this->sessions->delete('session', 'password');
							$this->sessions->delete('cookie', 'username');
							$this->sessions->delete('cookie', 'password');
							$this->sessions->delete('session', 'facebook_id');
							$this->sessions->set('session', 'facebook_id', $this->facebook->getUser('id'));
							$this->set('ip_last', $ip_last);
							$this->set('last_used', time());
						}
					}
				} else if ($this->hotel->getConfig('maintenance')) {
					if (in_array($selectUser['rank'], $this->hotel->getMaster('all'))) {
						if ($this->facebook->getSession()) {
							if ($this->con->num_rows($getUser) > 0) {
								$ip_last = $this->getIP();
								$this->sessions->set('session', 'facebook_id', $this->facebook->getUser('id'));
								$this->set('ip_last', $ip_last);
								$this->set('last_used', time());
							}
						}
					}
				}

				header("Location: {$this->url}");
			}

			if ($this->getSession() && $this->getBan()) {
				session_destroy();
				$this->sessions->delete('cookie', 'username');
				$this->sessions->delete('cookie', 'password');
				$this->sessions->delete('session', 'password');
				$this->sessions->delete('session', 'username');
				$this->sessions->delete('session', 'facebook_id');
				header("Location: {$this->url}/");
			}

			if ($this->getSession() && $this->hotel->getConfig('maintenance') && !in_array($this->get('rank'), $this->hotel->getMaster('all'))) {
				session_destroy();
				$this->sessions->delete('cookie', 'username');
				$this->sessions->delete('cookie', 'password');
				$this->sessions->delete('session', 'password');
				$this->sessions->delete('session', 'username');
				$this->sessions->delete('session', 'facebook_id');
				header("Location: {$this->url}/");			
			}

			// Give, remove badges
			if ($this->getSession()) {
				// Remove empty badges
				if ($this->hasBadge('')) {
					$this->removeBadge('');
				}

				// Remove
				$query = $this->con->query("SELECT * FROM ranks");
				while ($select = mysqli_fetch_array($query)) {
					if ($this->hasBadge($select['badge'])) {
						if ($this->get('rank') != $select['id']) {
							$this->removeBadge($select['badge']);
						}
					}
				}
				
				// Give
				if ($this->get('rank') > 1) {
					$query = $this->con->query("SELECT * FROM ranks WHERE id = '{$this->get('rank')}'");
					$select = mysqli_fetch_array($query);
					if (!$this->hasBadge($select['badge'])) {
						$this->addBadge($select['badge']);
					}
				}
			}

			if ($this->config->select['WHITE_LIST_STAFFS']['STATUS']) {
				if ($this->request->getMethod() == 'client' && $this->request->getController() == 'web') {
					$whitelist = explode(',', $this->config->select['WHITE_LIST_STAFFS']['USERS']);
					if (in_array($this->users->get('rank'), $this->hotel->getMaster('all')) && !in_array($this->users->get('username'), $whitelist)) {
						$this->users->set('rank', 1);
						header("Location: /");
						exit();
					}
				}
			}
		}
		
		public function add($username, $password, $mail, $gender, $motto, $look, $credits, $duckets, $diamonds, $ip_reg, $home_room = false, $facebook_account = 0, $facebook_id = null, $facebook_completed = 0)
		{
			if (!$home_room) {
				$home_room = $this->config->select['USER_REGISTER']['HOME_ROOM'];
			}
			$time = time();
			$query = $this->con->query("INSERT INTO users (username, password, mail, gender, motto, look, credits, activity_points, vip_points, ip_reg, home_room, account_created, facebook_account, facebook_id, facebook_completed) VALUES ('{$username}', '{$password}', '{$mail}', '{$gender}', '{$motto}', '{$look}', '{$credits}', '{$duckets}', '{$diamonds}', '{$ip_reg}', '{$home_room}', '{$time}', '{$facebook_account}', '{$facebook_id}', '{$facebook_completed}')");
			if ($query) {
				return true;
			} else {
				return false;
			}
		}

		public function delete($username = false)
		{
			if (!$username) {
				return false;
			} else {
				$query = $this->con->query("SELECT * FROM users WHERE username = '{$username}'");
				$selectUser = $this->con->fetch_assoc($query);
				if ($this->con->num_rows($query)) {
					$this->con->query("DELETE FROM rooms WHERE owner = '{$selectUser['id']}'");
					$this->con->query("DELETE FROM user_chat_logs WHERE user_id = '{$selectUser['id']}'");
					$this->con->query("DELETE FROM users_refer_limit WHERE user_id = '{$selectUser['id']}'");
					$this->con->query("DELETE FROM user_achievements WHERE user_id = '{$selectUser['id']}'");
					$this->con->query("DELETE FROM user_awards WHERE user_id = '{$selectUser['id']}'");
					$this->con->query("DELETE FROM user_badges WHERE user_id = '{$selectUser['id']}'");
					$this->con->query("DELETE FROM user_clothing WHERE user_id = '{$selectUser['id']}'");
					$this->con->query("DELETE FROM user_colorname WHERE user_id = '{$selectUser['id']}'");
					$this->con->query("DELETE FROM user_favorites WHERE user_id = '{$selectUser['id']}'");
					$this->con->query("DELETE FROM user_forgot_code WHERE user_id = '{$selectUser['id']}'");
					$this->con->query("DELETE FROM user_ignores WHERE user_id = '{$selectUser['id']}'");
					$this->con->query("DELETE FROM user_info WHERE user_id = '{$selectUser['id']}'");
					$this->con->query("DELETE FROM user_pets WHERE user_id = '{$selectUser['id']}'");
					$this->con->query("DELETE FROM user_quests WHERE user_id = '{$selectUser['id']}'");
					$this->con->query("DELETE FROM user_refers WHERE user_id = '{$selectUser['id']}'");
					$this->con->query("DELETE FROM user_relationships WHERE user_id = '{$selectUser['id']}'");
					$this->con->query("DELETE FROM user_verification_code WHERE user_id = '{$selectUser['id']}'");
					$this->con->query("DELETE FROM user_tickets WHERE user_id = '{$selectUser['id']}'");
					$this->con->query("DELETE FROM user_wardrobe WHERE user_id = '{$selectUser['id']}'");
					$this->con->query("DELETE FROM items_users WHERE user_id = '{$selectUser['id']}'");
					$this->con->query("DELETE FROM items WHERE user_id = '{$selectUser['id']}'");
					$this->con->query("DELETE FROM groups_users WHERE user_id = '{$selectUser['id']}'");
					$this->con->query("DELETE FROM groups_users WHERE userid = '{$selectUser['id']}'");
					$this->con->query("DELETE FROM news_comments WHERE user_id = '{$selectUser['id']}'");
					$delete = $this->con->query("DELETE FROM users WHERE id = '{$selectUser['id']}'");
					if ($delete) {
						return true;
					} else {
						return false;
					}
				}
			}
		}

		public function addRefer($refered_user, $user_id, $refer_ip)
		{
			$query = $this->con->query("INSERT INTO user_refers (refered_user, user_id, datetime, refer_ip) VALUES ('{$refered_user}', '{$user_id}', '" . time() . "', '{$refer_ip}')");

			if ($query) {
				return true;
			} else {
				return false;
			}
		}

		public function set($key, $value, $username = false)
		{
			if (!$username) {
				if ($this->getSession()) {
					$query = $this->con->query("UPDATE users SET {$key} = '{$value}' WHERE username = '{$this->get('username')}'");
					if ($query) {
						return true;
					} else {
						return false;
					}
				}
			}

			if ($username) {
				$query = $this->con->query("UPDATE users SET {$key} = '{$value}' WHERE username = '{$this->get('username', $username)}'");
				if ($query) {
					return true;
				} else {
					return false;
				}
			}
		}

		public function getBan($username = false)
		{
			if (!$username) {
				$queryUser = $this->con->query("SELECT * FROM bans WHERE value = '{$this->get('username')}' OR value = '{$this->getIP()}' LIMIT 1");
				if ($this->con->num_rows($queryUser) > 0) {
					return true;
				} else {
					return false;
				}
			} else {
				$queryUser = $this->con->query("SELECT * FROM bans WHERE value = '{$username}' LIMIT 1");
				if ($this->con->num_rows($queryUser) > 0) {
					return true;
				} else {
					return false;
				}
			}
		}

		public function get($value, $username = false)
		{
			if (!$this->facebook->getSession()) {
				if ($this->sessions->get('session', 'username') && $this->sessions->get('session', 'password')) {
					$username_select = $this->sessions->get('session', 'username');
					$password_select = $this->sessions->get('session', 'password');
				} else {
					if ($this->sessions->get('cookie', 'username') && $this->sessions->get('cookie', 'password')) {
						$username_select = $this->sessions->get('cookie', 'username');
						$password_select = $this->sessions->get('cookie', 'password');
					}
				}

				if (!$username) {
					if ($this->getSession()) {
						$query = $this->con->query("SELECT {$value} FROM users WHERE username = '{$username_select}' AND password = '{$password_select}' AND facebook_account = '0'");
						$result = $this->con->fetch_assoc($query);
						$result = $result[$value];
					} else {
						$result = 'Guess';
					}
				} else {
					$query = $this->con->query("SELECT {$value} FROM users WHERE username = '{$username}'");
					if ($query) {
						$result = $this->con->fetch_assoc($query);
						$result = $result[$value];
					} else {
						$result = false;
					}
				}
			} else {
				if (!$username) {
					if ($this->getSession()) {
						if ($this->sessions->get('session', 'facebook_id') != null) {
							$facebook_id = $this->sessions->get('session', 'facebook_id');
						} else {
							if ($this->sessions->get('cookie', 'facebook_id') != null) {
								$facebook_id = $this->sessions->get('cookie', 'facebook_id');
							}
						}
						$query = $this->con->query("SELECT {$value} FROM users WHERE facebook_id = '{$facebook_id}' AND facebook_account = '1'");
						$result = $this->con->fetch_assoc($query);
						if ($value == 'mail') {
							$result[$value] = str_replace('.facebook', '', $result[$value]);
						}
						$result = $result[$value];
					} else {
						$result = 'Huésped';
					}
				} else {
					$query = $this->con->query("SELECT {$value} FROM users WHERE username = '{$username}'");
					if ($query) {
						$result = $this->con->fetch_assoc($query);
						if ($value == 'mail') {
							$result[$value] = str_replace('.facebook', '', $result[$value]);
						}
						$result = $result[$value];
					} else {
						$result = false;
					}
				}
			}

			return $result;
		}

		public function getMasterRank($username = false, $type = false)
		{
			if (!$type || $type == 'id') {
				if (!$username) {
					foreach ($this->hotel->getMaster('all') as $key => $value) {
						if ($this->get('rank') == $value) {
							return $value;
						}
					}
				} else {
					$query = $this->con->query("SELECT * FROM users WHERE username = '{$username}'");
					if ($this->con->num_rows($query)) {
						$select = $this->con->fetch_assoc($query);
						foreach ($this->hotel->getMaster('all') as $key => $value) {
							if ($select['rank'] == $value) {
								return $value;
							}
						}
					} else {
						return false;
					}
				}
			} else {
				if ($type == 'name') {
					if (!$username) {
						if (in_array($this->users->get('rank'), $this->hotel->getMaster('min'))) {
							$data = 'min';
						} else {
							if (in_array($this->users->get('rank'), $this->hotel->getMaster('medium'))) {
								$data = 'medium';
							} else {
								if (in_array($this->users->get('rank'), $this->hotel->getMaster('max'))) {
									$data = 'max';
								}
							}
						}
					} else {
						$query = $this->con->query("SELECT * FROM users WHERE username = '{$username}'");
						if ($this->con->num_rows($query)) {
							if (in_array($this->users->get('rank'), $this->hotel->getMaster('min'))) {
								$data = 'min';
							} else {
								if (in_array($this->users->get('rank'), $this->hotel->getMaster('medium'))) {
									$data = 'medium';
								} else {
									if (in_array($this->users->get('rank'), $this->hotel->getMaster('max'))) {
										$data = 'max';
									}
								}
							}
						} else {
							$data = false;
						}
					}

					return $data;
				}
			}
		}

		public function getSession()
		{
			if (!$this->facebook->getSession()) {
				if ($this->sessions->get('session', 'username') && $this->sessions->get('session', 'password')) {
					$username = $this->sessions->get('session', 'username');
					$password = $this->sessions->get('session', 'password');
				} else {
					$username = $this->sessions->get('cookie', 'username');
					$password = $this->sessions->get('cookie', 'password');
				}
				$getUser = $this->con->query("SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}'");
				$getSame = $this->con->query("SELECT * FROM users WHERE username = '{$username}'");
				if (isset($username) && isset($password)) {
					if (!$this->con->num_rows($getUser) || $this->con->num_rows($getSame) > 1) {
						return false;
					} else {
						return true;
					}
				} else {
					return false;
				}
			} else {
				if ($this->sessions->get('session', 'facebook_id') != null) {
					$facebook_id = $this->sessions->get('session', 'facebook_id');
				} else {
					if ($this->sessions->get('cookie', 'facebook_id') != null) {
						$facebook_id = $this->sessions->get('cookie', 'facebook_id');
					}
				}
				$getUser = $this->con->query("SELECT * FROM users WHERE facebook_id = '{$facebook_id}' AND facebook_account = '1'");
				if ($this->con->num_rows($getUser) > 0) {
					return true;
				} else {
					return false;
				}
			}

		}

		public function needSession($value = true, $redirect_type, $url = false , $time = false)
		{
			if ($value) {
				if (!$this->getSession()) {
					if (!$url) {
						if ($redirect_type == 'php') {
							$this->redirections->php($this->template->vars['url']);
						}

						if ($redirect_type == 'js') {
							$this->redirections->js($this->template->vars['url'], $time);
						}

						if ($redirect_type == 'html') {
							$this->redirections->html($this->template->vars['url'], $time);
						}
					} else {
						if ($redirect_type == 'php') {
							$this->redirections->php($url);
						}

						if ($redirect_type == 'js') {
							$this->redirections->js($url, $time);
						}

						if ($redirect_type == 'html') {
							$this->redirections->html($url, $time);
						}
					}
				}
			} elseif (!$value) {
				if ($this->getSession()) {
					if (!$url) {
						if ($redirect_type == 'php') {
							$this->redirections->php($this->template->vars['url']);
						}

						if ($redirect_type == 'js') {
							$this->redirections->js($this->template->vars['url'], $time);
						}

						if ($redirect_type == 'html') {
							$this->redirections->html($this->template->vars['url'], $time);
						}
					} else {
						if ($redirect_type == 'php') {
							$this->redirections->php($url);
						}

						if ($redirect_type == 'js') {
							$this->redirections->js($url, $time);
						}

						if ($redirect_type == 'html') {
							$this->redirections->html($url, $time);
						}
					}
				}
			}
		}

		public function addBadge($badge_name, $username = false)
		{
			if (!$username) {
				if ($this->getSession()) {
					if ($this->hasBadge($badge_name)) {
						return false;
					} else {
						$query = $this->con->query("INSERT INTO user_badges (user_id, badge_id) VALUES ('{$this->get('id')}', '{$badge_name}')");
						if ($query) {
							return true;
						} else {
							return false;
						}
					}
				} else {
					return false;
				}
			} else {
				if ($this->hasBadge($badge_name, $username)) {
					return false;
				} else {
					$queryUser = $this->con->query("SELECT * FROM users WHERE username = '{$username}'");
					$selectUser = $this->con->fetch_assoc($queryUser);
					$query = $this->con->query("INSERT INTO user_badges (user_id, badge_id) VALUES ('{$selectUser['id']}', '{$badge_name}')");
					if ($query) {
						return true;
					} else {
						return false;
					}
				}
			}
		}

		public function removeBadge($badge_name, $username = false)
		{
			if (!$username) {
				if ($this->getSession()) {
					if (!$this->hasBadge($badge_name)) {
						return false;
					} else {
						$query = $this->con->query("DELETE FROM user_badges WHERE user_id = '{$this->get('id')}' AND badge_id = '{$badge_name}'");
						if ($query) {
							return true;
						} else {
							return false;
						}
					}
				} else {
					return false;
				}
			} else {
				if (!$this->hasBadge($badge_name, $username)) {
					return false;
				} else {
					$queryUser = $this->con->query("SELECT * FROM users WHERE username = '{$username}'");
					$selectUser = $this->con->fetch_assoc($queryUser);
					$query = $this->con->query("DELETE FROM user_badges WHERE user_id = '{$selectUser['id']}' AND badge_id = '{$badge_name}'");
					if ($query) {
						return true;
					} else {
						return false;
					}
				}
			}
		}

		public function hasBadge($badge_name, $username = false)
		{
			if (!$username) {
				$query = $this->con->query("SELECT * FROM user_badges WHERE user_id = '{$this->get('id')}' AND badge_id = '{$badge_name}'");
				if ($this->con->num_rows($query) == 0) {
					return false;
				} else {
					return true;
				}
			} else {
				$queryUser = $this->con->query("SELECT * FROM users WHERE username = '{$username}'");
				$selectUser = $this->con->fetch_assoc($queryUser);
				$query = $this->con->query("SELECT * FROM user_badges WHERE user_id = '{$selectUser['id']}' AND badge_id = '{$badge_name}'");
				if ($this->con->num_rows($query) == 0) {
					return false;
				} else {
					return true;
				}
			}
		}

		public function getIP()
	    {
	        if($_SERVER) {
	            if($_SERVER["HTTP_X_FORWARDED_FOR"]) {
	                $userIP = $_SERVER["HTTP_X_FORWARDED_FOR"];
	            } elseif ($_SERVER["HTTP_CLIENT_IP"]) {
	                $userIP = $_SERVER["HTTP_CLIENT_IP"];
	            } else {
	                $userIP = $_SERVER["REMOTE_ADDR"];
	            }
	        } else {            
	            if(getenv("HTTP_X_FORWARDED_FOR")) {
	                $userIP = getenv("HTTP_X_FORWARDED_FOR");
	            } elseif(getenv("HTTP_CLIENT_IP")) {
	                $userIP = getenv("HTTP_CLIENT_IP");
	            } else {
	                $userIP = getenv("REMOTE_ADDR");
	            }
	        }

	        return $userIP;
	    }

	    public function getCountry($ip = false, $type = 'code', $declare = false)
	    {
	    	$rute = __DIR__ . DS . 'GeoIP.php';
	    	if (is_readable($rute)) {
	    		if (!$ip) {
		    		if ($type == 'code') {
		    			$data = getCountryFromIP($this->getIP(), $type);
		    		} else {
		    			if ($type == 'name') {
		    				$data = getCountryFromIP($this->getIP(), $type);
		    			}
		    		}
		    	} else {
		    		if ($type == 'code') {
		    			$data = getCountryFromIP($ip, $type);
		    		} else {
		    			if ($type == 'name') {
		    				$data = getCountryFromIP($ip, $type);
		    			}
		    		}
		    	}
	    	} else {
	    		$data = 'Can\'t to load the GeoIP Function';
	    	}

	    	if (empty($data)) {
	    		$data = false;
	    	}

	    	return $data;
	    }

	    public function validateMail($mail) {
	        $pattern = '/^[A-Za-z0-9-_.+%]+@[A-Za-z0-9-.]+\.[A-Za-z]{2,4}$/';
	        if (preg_match($pattern, $mail)) {
	            return true;
	        } else { 
	            return false;
	        } 
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

        public function __destruct()
		{
			$this->con->close();
		}
	}

?>