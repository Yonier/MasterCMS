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
	use MasterCMS\Models\{Template, Protection, Users, Sessions, Redirections, Facebook, Hotel, FileUpload, Housekeeping};

	class hkController {

		private $template;
		private $config;
		private $protection;
		private $users;
		private $sessions;
		private $con;
		private $redirections;
		private $facebook;
		private $hk;
		private $upload;
		private $hotel;
		private $min_rank;
		private $url;
		private $text;

		public function __construct()
		{
			$this->template = new Template;
			$this->config = new Config;
			$this->protection = new Protection;
			$this->users = new Users;
			$this->sessions = new Sessions;
			$this->hotel = new Hotel;
			$this->con = new Connection;
			$this->redirections = new Redirections;
			$this->facebook = new Facebook;	
			$this->hk = new Housekeeping;	 	
			$this->upload = new FileUpload;	 	
			$this->min_rank = $this->hotel->getMaster();
			$this->medium_rank = $this->hotel->getMaster('medium');
			$this->max_rank = $this->hotel->getMaster('max');
			$this->template->setEverything();
			$this->url = $this->template->vars['url'];

			$rute = ROOT . 'src' . DS . 'MasterCMS' . DS . 'Views' . DS . 'Hk' . DS;
			$class = "\\MasterCMS\\Views\\Hk\\Langs\\{$this->config->select['WEB']['HK_LANG']}\\Texts\\Main";
			if (!file_exists($rute . 'Langs' . DS . $this->config->select['WEB']['HK_LANG'] . DS)) {
                die("Housekeeping doesn't have the {$this->config->select['WEB']['HK_LANG']} language");
            } else if (!file_exists($file = $rute . 'Langs' . DS . $this->config->select['WEB']['HK_LANG'] . DS . 'Texts' . DS . 'Main.php')) {
            	die("Housekeeping doesn't have <b>{$file}</b> file");
            } else if (!class_exists($class)) {
            	die("Housekeeping doesn't have <b>{$class}</b> class");
            } else {
				$this->text = new $class;
            }

			if (!$this->sessions->get('session', 'verify_client')) {
				header("Location: {$this->url}/web/verify_client");
				exit();
			}

			if (!$this->users->getSession()) {
				header("Location: {$this->url}/");
				exit;
			} else {
				if (!in_array($this->users->get('rank'), $this->hotel->getMaster()) && !in_array($this->users->get('rank'), $this->hotel->getMaster('medium')) && !in_array($this->users->get('rank'), $this->hotel->getMaster('max'))) {
					header("Location: {$this->url}/");
					exit();
				}
				$pinSession = $this->sessions->get('session', 'pin');
				if ($pinSession) {
					if ($pinSession != $this->users->get('pin')) {
						$this->sessions->delete('session', 'pin');
						header("Location: {$this->url}/hk");
						exit();
					}
				}
			}

			$textsNames = array('createPin', 'submitPin', 'addMessage', 'deleteMessage', 'addUserRank', 'deleteUserRank', 'addRank', 'deleteRank', 'editRank', 'submitNew', 'deleteNew', 'editNew', 'uploadTemplate', 'generalThemes', 'submitBan', 'deleteBan', 'uploadBadge', 'cmsSettings', 'generalUsers', 'generalLogs', 'uploadMPU');

			foreach ($textsNames as $key) {
				$class = "MasterCMS\\Views\\Texts\\Hk\\Langs\\{$this->config->select['WEB']['HK_LANG']}\\" . $key;
				$this->$key = new $class;
			}
			$this->template->setParam('hk', true);
			$this->template->setParam('client', false);
		}
		
		public function index()
		{
			if (!$this->sessions->get('session', 'pin')) {
				if (!$this->users->get('pin')) {
					define('ADS', false);
					$this->template->setEverything();
					$this->template->setParam('title', $this->text->texts['titles']['create_pin']);
					$this->template->setParam('client', false);
					$this->template->setParam('hk', true);
					$this->template->addTemplate('Template' . DS . 'Header', 'Hk');
					$this->template->addTemplate('Web' . DS . 'CreatePin', 'Hk');
					$this->template->addTemplate('Template' . DS . 'Footer', 'Hk');
				} else {
					define('ADS', false);
					$this->template->setEverything();
					$this->template->setParam('title', $this->text->texts['titles']['pin']);
					$this->template->setParam('client', false);
					$this->template->setParam('hk', true);
					$this->template->addTemplate('Template' . DS . 'Header', 'Hk');
					$this->template->addTemplate('Web' . DS . 'Pin', 'Hk');
					$this->template->addTemplate('Template' . DS . 'Footer', 'Hk');
				}
			} else {
				define('ADS', false);
				$this->template->setEverything();
				$this->template->setParam('users_registered', number_format($this->con->num_rows("SELECT * FROM users")));
				$time = time();
				$this->template->setParam('baned_users', number_format($this->con->num_rows("SELECT * FROM bans")));
				$this->template->setParam('expired_bans', number_format($this->con->num_rows("SELECT * FROM bans WHERE expire <= '{$time}'")));
				if (!$this->con->num_rows("SELECT * FROM bans WHERE expire <= '{$time}'")) {
					$this->template->setParam('expired_bans', 'ningunos');
				}
				$this->template->setParam('created_rooms', number_format($this->con->num_rows("SELECT * FROM rooms")));
				$query = $this->con->query("SELECT * FROM rooms");
				$num = 0;
				while ($select = $this->con->fetch_array($query)) {
					$num = $num + $select['users_now'];
				}
				$this->template->setParam('room_users', number_format($num));
				if (!$num) {
					$this->template->setParam('room_users', 'ningun');
				}
				$this->template->setParam('created_news', number_format($this->con->num_rows("SELECT * FROM news")));
				$this->template->setParam('title', $this->text->texts['titles']['index']);
				$this->template->addTemplate('Template' . DS . 'Header', 'Hk');
				$this->template->addTemplate('Web' . DS . 'Index', 'Hk');
				$this->template->addTemplate('Template' . DS . 'Footer', 'Hk');
			}
			
		}

		public function web($page = false, $extra = false, $extra2 = false)
		{
			$page = $this->protection->filter($page);
			$extra = $this->protection->filter($extra);
			$extra2 = $this->protection->filter($extra2);
			$pinSession = $this->sessions->get('session', 'pin');
			if ($pinSession) {
				if ($page == 'ranks') {
					if (in_array($this->users->get('rank'), $this->hotel->getMaster('max'))) {
						if (!$extra) {
							$this->sessions->delete('session', 'id_edit');
							$this->sessions->delete('session', 'name_edit');
							$this->template->setParam('title', $this->text->texts['titles']['ranks']);
							$this->template->addTemplate('Template' . DS . 'Header', 'Hk');
							$this->template->addTemplate('Web' . DS . 'Ranks', 'Hk');
							$this->template->addTemplate('Template' . DS . 'Footer', 'Hk');
						} else {
							if (is_numeric($extra)) {
								$query = $this->con->query("SELECT * FROM ranks WHERE id = '{$extra}'");
								if ($this->con->num_rows($query) > 0) {
									$select = $this->con->fetch_assoc($query);
									foreach ($select as $key => $value) {
										$this->template->setParam('rank_' . $key, $value);
									}
									$this->sessions->set('session', 'id_edit', $this->template->vars['rank_id']);
									$this->sessions->set('session', 'name_edit', $this->template->vars['rank_name']);
									$this->template->setParam('title', $this->text->texts['titles']['edit_rank']);
									$this->template->addTemplate('Template' . DS . 'Header', 'Hk');
									$this->template->addTemplate('Web' . DS . 'EditRank', 'Hk');
									$this->template->addTemplate('Template' . DS . 'Footer', 'Hk');
								} else {
									header("Location: {$this->url}/hk/web/ranks");
									exit();
								}
							} else {
								header("Location: {$this->url}/hk/web/ranks");
								exit();
							}
						}
					}
				} elseif ($page == 'news') {
					if (in_array($this->users->get('rank'), $this->hotel->getMaster('all'))) {
						if (!$extra) {
							$this->sessions->delete('session', 'id_edit');
							$this->template->setParam('title', $this->text->texts['titles']['news']);
							$this->template->addTemplate('Template' . DS . 'Header', 'Hk');
							$this->template->addTemplate('Web' . DS . 'News', 'Hk');
							$this->template->addTemplate('Template' . DS . 'Footer', 'Hk');
						} else {
							if (is_numeric($extra)) {
								$query = $this->con->query("SELECT * FROM news WHERE id = '{$extra}'");
								if ($this->con->num_rows($query) == 0) {
									header("Location: {$this->url}/hk/web/news");
									exit();
								} else {
									$select = $this->con->fetch_assoc($query);
									$queryUser = $this->con->query("SELECT * FROM users WHERE id = '{$select['author']}'");
									$selectUser = $this->con->fetch_assoc($queryUser);
									if ($this->hotel->getMasterType() == 'min' && $this->hotel->getMasterType($selectUser['rank']) == 'medium' || $this->hotel->getMasterType() == 'min' && $this->hotel->getMasterType($selectUser['rank']) == 'max' || $this->hotel->getMasterType() == 'medium' && $this->hotel->getMasterType($selectUser['rank']) == 'max') {
										header("Location: {$this->url}/hk/web/news");
										exit();
									} else {
										$this->sessions->set('session', 'id_edit', $select['id']);
										foreach ($select as $key => $value) {
											$this->template->setParam('news_' . $key, $value);
										}
										$this->template->setParam('title', $this->text->texts['titles']['edit_new']);
										$this->template->addTemplate('Template' . DS . 'Header', 'Hk');
										$this->template->addTemplate('Web' . DS . 'EditNew', 'Hk');
										$this->template->addTemplate('Template' . DS . 'Footer', 'Hk');
									}
								}
							} else {
								header("Location: {$this->url}/hk/web/news");
								exit();
							}
						}
					} else {
						header("Location: {$this->url}/hk/web/news");
						exit();	
					}
				} elseif ($page == 'bans') {
					if (in_array($this->users->get('rank'), $this->hotel->getMaster('all'))) {
						$this->template->setParam('title', $this->text->texts['titles']['bans']);
						$this->template->addTemplate('Template' . DS . 'Header', 'Hk');
						$this->template->addTemplate('Web' . DS . 'Bans', 'Hk');
						$this->template->addTemplate('Template' . DS . 'Footer', 'Hk');
					} else {
						header("Location: {$this->url}/hk");
						exit();	
					}
				} elseif ($page == 'users') {
					if (in_array($this->users->get('rank'), $this->hotel->getMaster('all'))) {
						if (!$extra) {
							$this->sessions->delete('session', 'id_edit');
							$this->template->setParam('title', $this->text->texts['titles']['users']);
							$this->template->addTemplate('Template' . DS . 'Header', 'Hk');
							$this->template->addTemplate('Web' . DS . 'Users', 'Hk');
							$this->template->addTemplate('Template' . DS . 'Footer', 'Hk');
						} else {
							if (is_numeric($extra)) {
								$query = $this->con->query("SELECT * FROM users WHERE id = '{$extra}'");
								if ($this->con->num_rows($query) == 0) {
									header("Location: {$this->url}/hk/web/users");
									exit();
								} else {
									$select = $this->con->fetch_assoc($query);
									$queryUser = $this->con->query("SELECT * FROM users WHERE id = '{$select['id']}'");
									$selectUser = $this->con->fetch_assoc($queryUser);
									if ($this->hotel->getMasterType() == 'min' && $this->hotel->getMasterType($selectUser['rank']) == 'medium' || $this->hotel->getMasterType() == 'min' && $this->hotel->getMasterType($selectUser['rank']) == 'max' || $this->hotel->getMasterType() == 'medium' && $this->hotel->getMasterType($selectUser['rank']) == 'max' || $this->hotel->getMasterType() == 'max' && $this->hotel->getMasterType($selectUser['rank']) == 'max' && $selectUser['username'] != $this->users->get('username') && $selectUser['rank'] > $this->users->get('rank')) {
										header("Location: {$this->url}/hk/web/users");
										exit();
									} else {
										if ($this->hotel->getMasterType($selectUser['rank']) == 'max' && in_array($selectUser['username'], $this->hotel->getSuperUsers()) && $selectUser['username'] != $this->users->get('username')) {
											header("Location: {$this->url}/hk/web/users");
											exit();
										} else {
											$this->sessions->set('session', 'id_edit', $select['id']);
											foreach ($select as $key => $value) {
												$this->template->setParam('users_' . $key, $value);
											}
											$queryRank = $this->con->query("SELECT * FROM ranks WHERE id = '{$select['rank']}'");
											$selectRank = $this->con->fetch_assoc($queryRank);
											if (!$selectRank['name']) {
												$selectRank['name'] = 'Not found';
											}
											$this->template->setParam('users_rank_name', $selectRank['name']);
											$country = $this->users->getCountry($select['ip_last']);
											if (empty($country)) {
												$country = 'IDK';
											} else {
												$country = $country;
											}
											$this->template->setParam('users_country', $country);
											$country = $this->users->getCountry($select['ip_reg']);
											if (empty($country)) {
												$country = 'IDK';
											} else {
												$country = $country;
											}
											if ($select['online']) {
												$this->template->setParam('users_status', 'online');
											} else {
												$this->template->setParam('users_status', 'offline');
											}
											$this->template->setParam('users_country_reg', $country);
											$this->template->setParam('title', $this->text->texts['titles']['users_edit']);
											$this->template->addTemplate('Template' . DS . 'Header', 'Hk');
											$this->template->addTemplate('Web' . DS . 'UsersEdit', 'Hk');
											$this->template->addTemplate('Template' . DS . 'Footer', 'Hk');
										}
									}
								}
							} else {
								header("Location: {$this->url}/hk/web/news");
								exit();
							}
						}
					} else {
						header("Location: {$this->url}/hk/web/news");
						exit();	
					}
				} elseif ($page == 'main') {
					if ($this->hotel->getMasterType() == 'max' && in_array($this->users->get('username'), $this->hotel->getSuperUsers())) {
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
                        $this->template->setParam('files', $files);
						$this->template->setParam('title', $this->text->texts['titles']['mastercms']);
						$this->template->addTemplate('Template' . DS . 'Header', 'Hk');
						$this->template->addTemplate('Web' . DS . 'Main', 'Hk');
						$this->template->addTemplate('Template' . DS . 'Footer', 'Hk');
					} else {
						header("Location: {$this->url}/hk");
						exit();
					}
				} elseif ($page == 'cms') {
					if ($this->hotel->getMasterType() == 'max' && in_array($this->users->get('username'), $this->hotel->getSuperUsers())) {
						$this->template->setParam('title', $this->text->texts['titles']['cms_settings']);
						$this->template->addTemplate('Template' . DS . 'Header', 'Hk');
						$this->template->addTemplate('Web' . DS . 'CMS', 'Hk');
						$this->template->addTemplate('Template' . DS . 'Footer', 'Hk');
					} else {
						header("Location: {$this->url}/hk");
						exit();
					}
				} elseif ($page == 'logs') {
					if ($this->hotel->getMasterType() == 'max') {
						$this->template->setParam('title', $this->text->texts['titles']['cms_logs']);
						$this->template->addTemplate('Template' . DS . 'Header', 'Hk');
						$this->template->addTemplate('Web' . DS . 'Logs', 'Hk');
						$this->template->addTemplate('Template' . DS . 'Footer', 'Hk');
					} else {
						header("Location: {$this->url}/hk");
						exit();
					}
				} else {
					header("Location: {$this->url}/hk");
					exit();
				}
			} else {
				header("Location: {$this->url}/hk");
				exit();
			}
		}

		public function game($page = false, $extra = false, $extra2 = false)
		{
			$page = $this->protection->filter($page);
			$extra = $this->protection->filter($extra);
			$extra2 = $this->protection->filter($extra2);
			$pinSession = $this->sessions->get('session', 'pin');
			if ($pinSession) {
				if ($page == 'badges') {
					if (in_array($this->users->get('rank'), $this->hotel->getMaster('medium+'))) {
						$this->template->setParam('title', $this->text->texts['titles']['badges']);
						$this->template->addTemplate('Template' . DS . 'Header', 'Hk');
						$this->template->addTemplate('Game' . DS . 'Badges', 'Hk');
						$this->template->addTemplate('Template' . DS . 'Footer', 'Hk');
					} else {
						header("Location: {$this->url}/hk");
						exit();
					}
				} elseif ($page == 'logs') {
					if ($this->hotel->getMasterType() == 'max') {
						$this->template->setParam('title', $this->text->texts['titles']['cms_logs']);
						$this->template->addTemplate('Template' . DS . 'Header', 'Hk');
						$this->template->addTemplate('Game' . DS . 'Logs', 'Hk');
						$this->template->addTemplate('Template' . DS . 'Footer', 'Hk');
					} else {
						header("Location: {$this->url}/hk");
						exit();
					}
				} elseif ($page == 'mpu') {
					if (in_array($this->users->get('rank'), $this->hotel->getMaster('medium+'))) {
						$this->template->setParam('title', $this->text->texts['titles']['cms_logs']);
						$this->template->addTemplate('Template' . DS . 'Header', 'Hk');
						$this->template->addTemplate('Game' . DS . 'MPU', 'Hk');
						$this->template->addTemplate('Template' . DS . 'Footer', 'Hk');
					} else {
						header("Location: {$this->url}/hk");
						exit();
					}
				} else {
					header("Location: {$this->url}/hk");
					exit();
				}
			} else {
				header("Location: {$this->url}/hk");
				exit();
			}
		}

		public function logout()
		{
			$this->sessions->delete('session', 'pin');
			header("Location: {$this->url}/hk");
			exit();
		}

		public function ajax($type, $extra = false)
		{
			$pinSession = $this->sessions->get('session', 'pin');
			if ($pinSession) {
				if ($type == 'listMessages') {
					$query = $this->con->query("SELECT * FROM dashboard_messages ORDER BY id DESC");
					$this->template->addTemplate('Ajax' . DS . 'Template' . DS . 'Header', 'Hk');
					if ($this->con->num_rows($query) == 0) {
						$this->template->addTemplate('Ajax' . DS . 'Nothing', 'Hk');
					} else {
						while ($select = $this->con->fetch_assoc($query)) {
							$queryUser = $this->con->query("SELECT * FROM users WHERE id = '{$select['user_id']}'");
							$userSelect = $this->con->fetch_assoc($queryUser);
							$this->template->setParam('owner_message', $userSelect['username']);
							$this->template->setParam('time', $this->hotel->getDate($select['timestamp']));
							$this->template->setParam('id', $select['id']);
							$this->template->setParam('message', $select['message']);
							$this->template->addTemplate('Ajax' . DS . 'listMessages', 'Hk');
						}
					}
					$this->template->setParam('listmessages', true);
					$this->template->addTemplate('Ajax' . DS . 'Template' . DS . 'Footer', 'Hk');
				}

				if ($type == 'listNews') {
					$query = $this->con->query("SELECT * FROM news ORDER BY id DESC");
					$this->template->addTemplate('Ajax' . DS . 'Template' . DS . 'Header', 'Hk');
					if ($this->con->num_rows($query) == 0) {
						$this->template->addTemplate('Ajax' . DS . 'Nothing', 'Hk');
					} else {
						while ($select = $this->con->fetch_assoc($query)) {
							foreach ($select as $key => $value) {
								$this->template->setParam('news_' . $key, $value);
							}
							$queryUser = $this->con->query("SELECT * FROM users WHERE id = '{$select['author']}'");
							$selectUser = $this->con->fetch_assoc($queryUser);
							if ($this->con->num_rows($queryUser) == 0) {
								$this->template->setParam('news_author', 'Not found');
							} else {
								$this->template->setParam('news_author', $selectUser['username']);
							}
							foreach ($selectUser as $key => $value) {
								$this->template->setParam('users_' . $key, $value);
							}
							$this->template->setParam('news_published', $this->hotel->getDate($select['published']));
							$this->template->addTemplate('Ajax' . DS . 'listNews', 'Hk');
						}
					}
					$this->template->setParam('listnews', true);
					$this->template->addTemplate('Ajax' . DS . 'Template' . DS . 'Footer', 'Hk');
				}

				if ($type == 'listMPUS') {
					$rute = $this->config->select['CDN']['SWF']['DIR_RUTE'] . DS . $this->config->select['CDN']['SWF']['DIR_MPUS'] . DS;
					$directory = opendir($rute);
					$files = [];
					while ($file = readdir($directory)) {
			        	if ($file != '.' && $file != '..') {
			        		array_push($files, $file);
			        	}
					}
					rsort($files);
					if (count($files) > 0) {
						$this->template->setParam('files', $files);
						$this->template->addTemplate('Ajax' . DS . 'Template' . DS . 'Header', 'Hk');
						foreach ($files as $key => $value) {
							$this->template->setParam('file_name', $value);
							$this->template->addTemplate('Ajax' . DS . 'listMPUS', 'Hk');
						}
						$this->template->addTemplate('Ajax' . DS . 'Template' . DS . 'Footer', 'Hk');
					} else {
						$this->template->addTemplate('Ajax' . DS . 'Nothing', 'Hk');
					}
				}

				if ($type == 'listLogs') {
					$query = $this->con->query("SELECT * FROM dashboard_logs ORDER BY id DESC");
					$this->template->addTemplate('Ajax' . DS . 'Template' . DS . 'Header', 'Hk');
					if ($this->con->num_rows($query) == 0) {
						$this->template->addTemplate('Ajax' . DS . 'Nothing', 'Hk');
					} else {
						while ($select = $this->con->fetch_assoc($query)) {
							foreach ($select as $key => $value) {
								$this->template->setParam('logs_' . $key, $value);
							}
							$queryUser = $this->con->query("SELECT * FROM users WHERE id = '{$select['user_id']}'");
							$selectUser = $this->con->fetch_assoc($queryUser);
							if ($this->con->num_rows($queryUser) == 0) {
								$this->template->setParam('logs_user', 'Not found');
							} else {
								$this->template->setParam('logs_user', $selectUser['username']);
							}
							foreach ($selectUser as $key => $value) {
								$this->template->setParam('users_' . $key, $value);
							}
							$this->template->setParam('logs_time', $this->hotel->getDate($select['timestamp']));
							$this->template->addTemplate('Ajax' . DS . 'listLogs', 'Hk');
						}
					}
					$this->template->setParam('listnews', true);
					$this->template->addTemplate('Ajax' . DS . 'Template' . DS . 'Footer', 'Hk');
				}

				if ($type == 'listClientLogs') {
					$query = $this->con->query("SELECT * FROM logs_client_staff ORDER BY id DESC");
					$this->template->addTemplate('Ajax' . DS . 'Template' . DS . 'Header', 'Hk');
					if ($this->con->num_rows($query) == 0) {
						$this->template->addTemplate('Ajax' . DS . 'Nothing', 'Hk');
					} else {
						while ($select = $this->con->fetch_assoc($query)) {
							foreach ($select as $key => $value) {
								$this->template->setParam('logs_' . $key, $value);
							}
							$queryUser = $this->con->query("SELECT * FROM users WHERE id = '{$select['user_id']}'");
							$selectUser = $this->con->fetch_assoc($queryUser);
							if ($this->con->num_rows($queryUser) == 0) {
								$this->template->setParam('logs_user', 'Not found');
							} else {
								$this->template->setParam('logs_user', $selectUser['username']);
							}
							foreach ($selectUser as $key => $value) {
								$this->template->setParam('users_' . $key, $value);
							}
							$this->template->setParam('logs_time', $this->hotel->getDate($select['timestamp']));
							$this->template->addTemplate('Ajax' . DS . 'listClientLogs', 'Hk');
						}
					}
					$this->template->setParam('listnews', true);
					$this->template->addTemplate('Ajax' . DS . 'Template' . DS . 'Footer', 'Hk');
				}

				if ($type == 'listBans') {
					$query = $this->con->query("SELECT * FROM bans ORDER BY id DESC");
					$this->template->addTemplate('Ajax' . DS . 'Template' . DS . 'Header', 'Hk');
					if ($this->con->num_rows($query) == 0) {
						$this->template->addTemplate('Ajax' . DS . 'Nothing', 'Hk');
					} else {
						while ($select = $this->con->fetch_assoc($query)) {
							foreach ($select as $key => $value) {
								$this->template->setParam('bans_' . $key, $value);
							}
							$queryUser = $this->con->query("SELECT * FROM users WHERE username = '{$select['added_by']}'");
							$selectUser = $this->con->fetch_assoc($queryUser);
							if ($this->con->num_rows($queryUser) == 0) {
								$this->template->setParam('bans_author', 'Not found');
							} else {
								$this->template->setParam('bans_author', $selectUser['username']);
							}
							foreach ($selectUser as $key => $value) {
								$this->template->setParam('users_' . $key, $value);
							}
							$this->template->setParam('bans_date', $this->hotel->getDate($select['added_date']));
							$this->template->setParam('bans_expire_date', date('d/m/Y - H:i:s', $select['expire']));
							$this->template->addTemplate('Ajax' . DS . 'listBans', 'Hk');
						}
					}
					$this->template->setParam('listbans', true);
					$this->template->addTemplate('Ajax' . DS . 'Template' . DS . 'Footer', 'Hk');
				}

				if ($type == 'listRanks') {
					$query = $this->con->query("SELECT * FROM ranks ORDER BY id DESC");
					$this->template->addTemplate('Ajax' . DS . 'Template' . DS . 'Header', 'Hk');
					if ($this->con->num_rows($query) == 0) {
						$this->template->addTemplate('Ajax' . DS . 'Nothing', 'Hk');
					} else {
						while ($select = $this->con->fetch_assoc($query)) {
							$queryRank = $this->con->query("SELECT * FROM ranks WHERE id = '{$select['id']}'");
							$selectRank = $this->con->fetch_array($queryRank);
							foreach ($selectRank as $key => $value) {
								$this->template->setParam('rank_' . $key, $value);
							}
							if ($this->hotel->getMasterType($selectRank['id']) == 'min') {
								$this->template->setParam('rank_type', 'Minimo');
							} else {
								if ($this->hotel->getMasterType($selectRank['id']) == 'medium') {
									$this->template->setParam('rank_type', 'Medio');
								} else {
									if ($this->hotel->getMasterType($selectRank['id']) == 'max') {
										$this->template->setParam('rank_type', 'Maximo');
									} else {
										$this->template->setParam('rank_type', 'Ninguno');
									}
								}
							}
							if ($selectRank['fuse_hide_staff']) {
								$this->template->setParam('visibility', false);
							} else {
								$this->template->setParam('visibility', true);
							}
							$this->template->addTemplate('Ajax' . DS . 'listRanks', 'Hk');
						}
					}
					$this->template->setParam('listranks', true);
					$this->template->addTemplate('Ajax' . DS . 'Template' . DS . 'Footer', 'Hk');
				}

				if ($type == 'listRanksUsers') {
					$query = $this->con->query("SELECT * FROM users WHERE rank >= '2' ORDER BY rank DESC");
					$this->template->addTemplate('Ajax' . DS . 'Template' . DS . 'Header', 'Hk');
					if ($this->con->num_rows($query) == 0) {
						$this->template->addTemplate('Ajax' . DS . 'Nothing', 'Hk');
					} else {
						while ($select = $this->con->fetch_assoc($query)) {
							$queryRank = $this->con->query("SELECT * FROM ranks WHERE id = '{$select['rank']}'");
							$selectRank = $this->con->fetch_assoc($queryRank);
							foreach ($select as $key => $value) {
								$this->template->setParam('staff_' . $key, $value);
							}
							if (!$this->template->vars['staff_ip_last']) {
								$this->template->setParam('staff_ip_last', $this->template->vars['staff_ip_reg']);
							}
							if ($this->template->vars['staff_staff_occult']) {
								$this->template->setParam('staff_occult', true);
							} else {
								$this->template->setParam('staff_occult', false);
							}
							$this->template->setParam('staff_rank', $selectRank['name']);
							$this->template->setParam('staff_rank_id', $selectRank['id']);
							$country = $this->users->getCountry($select['ip_last']);
							if (empty($country)) {
								$country = 'IDK';
							} else {
								$country = $country;
							}
							$this->template->setParam('staff_country', $country);

							$status = $this->users->get('online');
							if ($status == 0) {
								$status = 'offline';
							} else {
								$status = 'online';
							}
							$this->template->setParam('staff_status', $status);
							$this->template->addTemplate('Ajax' . DS . 'listRanksUsers', 'Hk');
						}
					}
					$this->template->setParam('ranks', true);
					$this->template->addTemplate('Ajax' . DS . 'Template' . DS . 'Footer', 'Hk');
				}
			}
		}

		public function forms($type, $extra = false)
		{
			$pinSession = $this->sessions->get('session', 'pin');
			$pinSessionClient = $this->sessions->get('session', 'client_pin');
			if (in_array($this->users->get('rank'), $this->hotel->getMaster('all'))) {
				if (!$pinSessionClient) {
					if ($type == 'createPin') {
						if ($extra == 'client') {
							if (!$this->users->get('client_pin')) {
								$pin = $this->protection->filter($_POST['pin']);
								$rpin = $this->protection->filter($_POST['rpin']);
								if (empty($pin) || empty($rpin)) {
									echo $this->createPin->texts['texts']['empty'];
								} else {
									if (strlen($pin) < 4 || strlen($pin) > 30) {
										echo $this->createPin->texts['texts']['shorter_or_larger'];
									} elseif (!preg_match("`[0-9]`", $pin) || !preg_match("`[a-z]`", $pin)) {
								    	echo $this->createPin->texts['texts']['not_numbers_on_pass'];
								    } else {
										if ($pin != $rpin) {
											echo $this->createPin->texts['texts']['not_same'];
										} else {
											$update = $this->users->set('client_pin', $this->protection->encriptPassword($pin));
											$update .= $this->hk->submitLog($this->users->get('id'), "Configured his game security code", time());
											if ($update) {
												echo $this->createPin->texts['texts']['success_client'] . $this->redirections->js($this->url . '/web/client', 3000);
											} else {
												echo $this->createPin->texts['texts']['database'];
											}
										}
									}
								}
							} else {
								echo $this->createPin->texts['texts']['has_pin'];
							}
						}
					}

					if ($type == 'submitPin') {
						if ($extra == 'client') {
							$userPin = $this->users->get('client_pin');
							$pin = $this->protection->filter($_POST['pin']);
							$pinEncripted = $this->protection->encriptPassword($pin);
							if (!$pinSessionClient) {
								if (empty($pin)) {
									echo $this->submitPin->texts['texts']['empty'];
								} else {
									if ($pinEncripted != $userPin) {
										echo $this->submitPin->texts['texts']['invalid_data'];
										$this->hk->submitLog($this->users->get('id'), "Failed entering to the <b>game</b>", time());
									} else {
										$query = $this->sessions->set('session', 'client_pin', $pinEncripted);
										$query .= $this->hk->submitLog($this->users->get('id'), "Enter to the <b>game</b>", time());
										if ($query) {
											echo $this->submitPin->texts['texts']['success_client'] . $this->redirections->js($this->url . '/web/client', 3000);
										} else {
											echo $this->submitPin->texts['texts']['database'];
										}
									}
								}
							} else {
								echo $this->submitPin->texts['texts']['sessioned'];
							}
						}
					}
				} else {

				}

				if (!$pinSession) {
					// Create Pin
					if ($type == 'createPin') {
						if (!$extra) {
							if (!$this->users->get('pin')) {
								$pin = $this->protection->filter($_POST['pin']);
								$rpin = $this->protection->filter($_POST['rpin']);
								if (empty($pin) || empty($rpin)) {
									echo $this->createPin->texts['texts']['empty'];
								} else {
									if (strlen($pin) < 4 || strlen($pin) > 30) {
										echo $this->createPin->texts['texts']['shorter_or_larger'];
									} elseif (!preg_match("`[0-9]`", $pin) || !preg_match("`[a-z]`", $pin)) {
								    	echo $this->createPin->texts['texts']['not_numbers_on_pass'];
								    } else {
										if ($pin != $rpin) {
											echo $this->createPin->texts['texts']['not_same'];
										} else {
											$update = $this->users->set('pin', $this->protection->encriptPassword($pin));
											$update .= $this->hk->submitLog($this->users->get('id'), "Configured his security code", time());
											if ($update) {
												echo $this->createPin->texts['texts']['success'] . $this->redirections->js($this->url . '/hk', 3000);
											} else {
												echo $this->createPin->texts['texts']['database'];
											}
										}
									}
								}
							} else {
								echo $this->createPin->texts['texts']['has_pin'];
							}
						} # Else if
					}

					// submit Pin
					if ($type == 'submitPin') {
						if (!$extra) {
							$userPin = $this->users->get('pin');
							$pin = $this->protection->filter($_POST['pin']);
							$pinEncripted = $this->protection->encriptPassword($pin);
							if (!$pinSession) {
								if (empty($pin)) {
									echo $this->submitPin->texts['texts']['empty'];
								} else {
									if ($pinEncripted != $userPin) {
										echo $this->submitPin->texts['texts']['invalid_data'];
										$this->hk->submitLog($this->users->get('id'), "Failed entering to <b>panel</b>", time());
									} else {
										$query = $this->sessions->set('session', 'pin', $pinEncripted);
										$query .= $this->hk->submitLog($this->users->get('id'), "Enter to <b>panel</b>", time());
										if ($query) {
											echo $this->submitPin->texts['texts']['success'] . $this->redirections->js($this->url . '/hk', 3000);
										} else {
											echo $this->submitPin->texts['texts']['database'];
										}
									}
								}
							} else {
								echo $this->submitPin->texts['texts']['sessioned'];
							}
						} # Else if
					}
				} else {
					// add Messages
					if ($type == 'addMessage') {
						$message = $this->protection->htmlFilter($_POST['message']);
						if (empty($message)) {
							echo $this->addMessage->texts['texts']['empty'];
						} else {
							if (!in_array($this->users->get('rank'), $this->hotel->getMaster('medium+'))) {
								echo $this->addMessage->texts['texts']['no_perms'];
							} else {
								$query = $this->hk->submitMessage($this->users->get('id'), $message, time());
								$queryId = $this->con->query("SELECT * FROM dashboard_messages WHERE user_id = '{$this->users->get('id')}' ORDER BY id DESC LIMIT 1");
								$selectId = $this->con->fetch_assoc($queryId);
								$queryUser = $this->con->query("SELECT * FROM users WHERE id = '{$selectId['user_id']}'");
								$selectUser = $this->con->fetch_assoc($queryUser);
								$query .= $this->hk->submitLog($this->users->get('id'), "Added the staff message number: <b>{$selectId['id']}</b>", time());
								if ($query) {
									echo $this->addMessage->texts['texts']['success'];
								} else {
									echo $this->addMessage->texts['texts']['database'];
								}
							}
						}
					}

					if ($type == 'deleteMessage') {
						$id = $this->protection->filter($_POST['id']);
						$query = $this->con->query("SELECT * FROM dashboard_messages WHERE id = '{$id}' LIMIT 1");
						$select = $this->con->fetch_assoc($query);
						$queryUser = $this->con->query("SELECT * FROM users WHERE id = '{$select['user_id']}'");
						$selectUser = $this->con->fetch_assoc($queryUser);
						if (empty($id) || !is_numeric($id)) {
							echo $this->deleteMessage->texts['texts']['empty'];
						} else {
							if ($this->con->num_rows($query) == 0) {
								echo $this->deleteMessage->texts['texts']['not_exist'];
							} else {
								if (!in_array($this->users->get('rank'), $this->hotel->getMaster()) && !in_array($this->users->get('rank'), $this->hotel->getMaster('medium')) && !in_array($this->users->get('rank'), $this->hotel->getMaster('max')) && $this->con->num_rows($queryUser) == 0) {
									echo $this->deleteMessage->texts['texts']['no_perms'];
								} else {
									$delete = $this->hk->submitLog($this->users->get('id'), "Deleted the staff message: <b>{$id}</b> and was published by <b>{$selectUser['username']}</b>", time());
									$delete .= $this->hk->deleteMessage($id);
									if ($delete) {
										echo $this->deleteMessage->texts['texts']['success'];
									} else {
										echo $this->deleteMessage->texts['texts']['database'];
									}
								}
							}
						}
					}

					if ($type == 'addUserRank') {
						$username = $this->protection->filter($_POST['username']);
						$rank = $this->protection->filter($_POST['rank']);
						$pin = $this->protection->filter($_POST['pin']);
						$work = $this->protection->filter($_POST['work']);
						$client_pin = $this->protection->filter($_POST['client_pin']);
						$type = $this->protection->filter($_POST['type']);
						if (empty($username) || empty($rank) || empty($work)) {
							echo $this->addUserRank->texts['texts']['empty'];
						} else {
							$query = $this->con->query("SELECT * FROM users WHERE username = '{$username}' LIMIT 1");
							$selectUser = $this->con->fetch_assoc($query);
							$queryRank = $this->con->query("SELECT * FROM ranks WHERE id = '{$rank}' LIMIT 1");
							$selectRank = $this->con->fetch_assoc($queryRank);
							$staff_rank_id = $selectUser['rank'];
							if ($this->con->num_rows($query) == 0) {
								echo $this->addUserRank->texts['texts']['not_exist'];
							} else {
								if (strlen($work) < 4 || strlen($work) > 50) {
									echo $this->addUserRank->texts['texts']['shorter_or_larger_work'];
								} else {
									if (!in_array($this->users->get('rank'), $this->hotel->getMaster('medium+'))) {
										echo $this->addUserRank->texts['texts']['no_perms'];
									} else {
										if ($this->con->num_rows($queryRank) > 0) {
											if (in_array($this->users->get('rank'), $this->hotel->getMaster('max')) && in_array($rank, $this->hotel->getMaster('max')) && $rank > $this->users->get('rank')
												||
												in_array($this->users->get('rank'), $this->hotel->getMaster('medium')) && in_array($rank, $this->hotel->getMaster('medium')) && $rank > $this->users->get('rank')
												||
												$this->users->get('rank') == $rank) {
												echo $this->addUserRank->texts['texts']['you_cant_rank'];
											} else {
												if (is_numeric($rank)) {
													if ($rank != $selectUser['rank']) {
														if ($username != $this->users->get('username')) {
															if (in_array($this->users->get('rank'), $this->hotel->getMaster('medium+')) && in_array($staff_rank_id, $this->hotel->getMaster('min'))
																||
																in_array($this->users->get('rank'), $this->hotel->getMaster('max')) && in_array($staff_rank_id, $this->hotel->getMaster('medium'))
																||
																in_array($this->users->get('rank'), $this->hotel->getMaster('medium+')) && in_array($staff_rank_id, $this->hotel->getMaster('medium+')) && $this->users->get('rank') > $staff_rank_id
																||
																in_array($this->users->get('rank'), $this->hotel->getMaster('medium+')) && !in_array($staff_rank_id, $this->hotel->getMaster('all'))) {
																$set = $this->users->set('rank', $rank, $username);
																$set = $this->users->set('work', $work, $username);

																if ($pin) {
																	$set .= $this->users->set('pin', $this->protection->encriptPassword($pin), $username);
																} else {
																	$set .= $this->users->set('pin', '', $username);
																}

																if ($client_pin) {
																	$set .= $this->users->set('client_pin', $this->protection->encriptPassword($client_pin), $username);
																} else {
																	$set .= $this->users->set('client_pin', '', $username);
																}

																if ($type == 1) {
																	$set .= $this->users->set('staff_occult', 1, $username);
																} else {
																	$set .= $this->users->set('staff_occult', 0, $username);
																}
																$set .= $this->hk->submitLog($this->users->get('id'), "Gived the rank <b>{$selectRank['name']}</b> to <b>{$username}</b>", time());
																if ($set) {
																	echo $this->addUserRank->texts['texts']['success'];
																} else {
																	echo $this->addUserRank->texts['texts']['database'];
																}
															} else {
																echo $this->addUserRank->texts['texts']['you_cant'];
															}
														} else {
															echo $this->addUserRank->texts['texts']['you_cant_you'];
														}
													} else {
														echo $this->addUserRank->texts['texts']['has_rank'];
													}
												} else {
													echo $this->addUserRank->texts['texts']['dont_try_inyect'];
												}
											}
										} else {
											echo $this->addUserRank->texts['texts']['not_exist_rank'];
										}
									}
								}
							}
						}
					}

					if ($type == 'deleteUserRank') {
						$id = $this->protection->filter($_POST['id']);
						if (empty($id)) {
							echo $this->deleteUserRank->texts['texts']['empty'];
						} else {
							$queryUser = $this->con->query("SELECT * FROM users WHERE id = '{$id}'");
							$selectUser = $this->con->fetch_assoc($queryUser);
							$staff_rank_id = $selectUser['rank'];
							if (!$this->con->num_rows($queryUser)) {
								echo $this->deleteUserRank->texts['texts']['no_exist'];
							} else {
								if (!in_array($this->users->get('rank'), $this->hotel->getMaster('medium+'))) {
									echo $this->deleteUserRank->texts['texts']['no_perms'];
								} else {
									if (in_array($this->users->get('rank'), $this->hotel->getMaster('medium+')) && in_array($staff_rank_id, $this->hotel->getMaster('min'))
										||
										in_array($this->users->get('rank'), $this->hotel->getMaster('max')) && in_array($staff_rank_id, $this->hotel->getMaster('medium'))
										||
										in_array($this->users->get('rank'), $this->hotel->getMaster('medium+')) && in_array($staff_rank_id, $this->hotel->getMaster('medium+')) && $this->users->get('rank') > $staff_rank_id
										||
										in_array($this->users->get('rank'), $this->hotel->getMaster('medium+')) && !in_array($staff_rank_id, $this->hotel->getMaster('all'))) {
										if ($id == $this->users->get('id')) {
											echo $this->deleteUserRank->texts['texts']['you_cant_you'];
										} else {
											$set = $this->users->set('rank', 1, $selectUser['username']);
											$set .= $this->users->set('pin', '', $selectUser['username']);
											$set .= $this->users->set('client_pin', '', $selectUser['username']);
											if ($set) {
												echo $this->deleteUserRank->texts['texts']['success'];
											} else {
												echo $this->deleteUserRank->texts['texts']['database'];
											}
										}
									} else {
										echo $this->deleteUserRank->texts['texts']['you_cant'];
									}
								}
							}
						}
					}

					if ($type == 'addRank') {
						$id = $this->protection->filter($_POST['id']);
						$name = $this->protection->filter($_POST['name']);
						$type = $this->protection->filter($_POST['type']);
						$visibility = $this->protection->filter($_POST['visibility']);
						$badge = $this->protection->filter($_POST['badge']);
						$color = $this->protection->filter($_POST['color']);
						$rank = $this->users->get('rank');
						if (in_array($rank, $this->hotel->getMaster('max'))) {
							if (empty($name) || empty($visibility) || empty($badge) || empty($type) || empty($color)) {
								echo $this->addRank->texts['texts']['empty'];
							} else {
								if (strlen($name) < 3 || strlen($name) > 50) {
									echo $this->addRank->texts['texts']['shorter_or_larger_name'];
								} else {
									if (strlen($color) < 3 || strlen($color) > 7) {
										echo $this->addRank->texts['texts']['shorter_or_larger_color'];
									} else {
										if (is_numeric($id) && $id < 1) {
											echo $this->addRank->texts['texts']['invalid_id'];
										} else {
											if (strlen($badge) < 2 || strlen($badge) > 32) {
												echo $this->addRank->texts['texts']['shorter_or_larger_badge'];
											} else {
												$query = $this->con->query("SELECT * FROM ranks WHERE name = '{$name}'");
												if ($this->con->num_rows($query) > 0) {
													echo $this->addRank->texts['texts']['exist'];
												} else {
													$mtype = $this->hotel->getMasterType($rank);
													if ($mtype == $type || $mtype == 'max' && $type == 'medium' || $mtype == 'max' && $type == 'min' || $mtype == 'medium' && $type == 'min' || $mtype == 'medium' && $type == 'nothing' || $mtype == 'max' && $type == 'nothing') {
														if ($visibility == 'yes') {
															$visibility = 0;
														} else {
															$visibility = 1;
														}
														if (empty($id)) {
															$add = $this->con->query("INSERT INTO ranks (name, badge, color, fuse_hide_staff) VALUES ('{$name}', '{$badge}', '{$color}', '{$visibility}')");
															$select = $this->con->fetch_assoc($this->con->query("SELECT * FROM ranks ORDER BY id DESC LIMIT 1"));
															if ($type == 'min') {
																$add .= $this->hotel->setConfig('min_rank', $this->hotel->getConfig('min_rank') . ', ' . $select['id']);
															} elseif ($type == 'medium') {
																$add .= $this->hotel->setConfig('medium_rank', $this->hotel->getConfig('medium_rank') . ', ' . $select['id']);
															} elseif ($type == 'max') {
																$add .= $this->hotel->setConfig('max_rank', $this->hotel->getConfig('max_rank') . ', ' . $select['id']);
															}
														} else {
															$queryRank = $this->con->query("SELECT * FROM ranks WHERE id = '{$id}'");
															$query = $this->con->query("SELECT * FROM ranks WHERE id = '{$id}'");
															if ($this->con->num_rows($query) > 0) {
																$selectRank = $this->con->fetch_assoc($queryRank);
																// Change
																$query = $this->con->query("SELECT * FROM ranks ORDER BY id DESC LIMIT 1");
																$select = $this->con->fetch_assoc($query);
																$new_id = ($select['id'] + 1);
																if ($id != 1) {
																 	if ($this->hotel->getMasterType($selectRank['id']) == 'min') {
																		$add = $this->hotel->setConfig('min_rank', $this->hotel->getConfig('min_rank') . ', ' . $new_id);
																	} elseif ($this->hotel->getMasterType($selectRank['id']) == 'medium') {
																		$add = $this->hotel->setConfig('medium_rank', $this->hotel->getConfig('medium_rank') . ', ' . $new_id);
																	} elseif ($this->hotel->getMasterType($selectRank['id']) == 'max') {
																		$add = $this->hotel->setConfig('max_rank', $this->hotel->getConfig('max_rank') . ', ' . $new_id);
																	}
																} else {
																	$add = true;
																}
																$add .= $this->con->query("UPDATE ranks SET id = '{$new_id}' WHERE id = '{$id}'");
																$add .= $this->con->query("INSERT INTO ranks (id, name, badge, color, fuse_hide_staff) VALUES ('{$id}', '{$name}', '{$badge}', '{$color}', '{$visibility}')");
																if ($id != 1) {
																	if ($type == 'min') {
																		$add .= $this->hotel->setConfig('min_rank', $this->hotel->getConfig('min_rank') . ', ' . $id);
																	} elseif ($type == 'medium') {
																		$add .= $this->hotel->setConfig('medium_rank', $this->hotel->getConfig('medium_rank') . ', ' . $id);
																	} elseif ($type == 'max') {
																		$add .= $this->hotel->setConfig('max_rank', $this->hotel->getConfig('max_rank') . ', ' . $id);
																	}
																} else {
																	$add .= true;
																}

															} else {
																$add = $this->con->query("INSERT INTO ranks (id, name, badge, color, fuse_hide_staff) VALUES ('{$id}', '{$name}', '{$badge}', '{$color}', '{$visibility}')");
																$query = $this->con->query("SELECT * FROM ranks ORDER BY id DESC LIMIT 1");
																$select = $this->con->fetch_assoc($query);
																if ($id != 1) {
																	if ($type == 'min') {
																		$add .= $this->hotel->setConfig('min_rank', $this->hotel->getConfig('min_rank') . ', ' . $select['id']);
																	} elseif ($type == 'medium') {
																		$add .= $this->hotel->setConfig('medium_rank', $this->hotel->getConfig('medium_rank') . ', ' . $select['id']);
																	} elseif ($type == 'max') {
																		$add .= $this->hotel->setConfig('max_rank', $this->hotel->getConfig('max_rank') . ', ' . $select['id']);
																	}
																} else {
																	$add .= true;
																}
															}
														}

														$add .= $this->hk->submitLog($this->users->get('id'), "Created the rank <b>{$name}</b> with the type " . strtoupper($type) . "", time());

														if ($add) {
															echo $this->addRank->texts['texts']['success'];
														} else {
															echo $this->addRank->texts['texts']['database'];
														}

													} else {
														echo $this->addRank->texts['texts']['you_cant'];
													}
												}
											}
										}
									}
								}
							}
						} else {
							echo $this->addRank->texts['texts']['no_perms'];
						}
					}	

					if ($type == 'deleteRank') {
						$id = $this->protection->filter($_POST['id']);
						if (empty($id)) {
							echo $this->deleteRank->texts['texts']['empty'];
						} else {
							if (!in_array($this->users->get('rank'), $this->hotel->getMaster('max'))) {
								echo $this->deleteRank->texts['texts']['no_perms'];
							} else {
								$query = $this->con->query("SELECT * FROM ranks WHERE id = '{$id}'");
								$select = $this->con->fetch_assoc($query);
								$staff_rank_id = $select['id'];
								if ($this->con->num_rows($query) == 0) {
									echo $this->deleteRank->texts['texts']['no_exist'];
								} else {
									if (in_array($this->users->get('rank'), $this->hotel->getMaster('medium+')) && in_array($staff_rank_id, $this->hotel->getMaster('min')) || in_array($this->users->get('rank'), $this->hotel->getMaster('max')) && in_array($staff_rank_id, $this->hotel->getMaster('medium')) || in_array($this->users->get('rank'), $this->hotel->getMaster('medium+')) && in_array($staff_rank_id, $this->hotel->getMaster('medium+')) && $this->users->get('rank') > $staff_rank_id || in_array($this->users->get('rank'), $this->hotel->getMaster('medium+')) && !in_array($staff_rank_id, $this->hotel->getMaster('all'))) {
										if ($this->hotel->getMasterType($select['id']) == 'min') {
											$data = str_replace(', ' . $select['id'], '', $this->hotel->getConfig('min_rank'));
											$data = str_replace($select['id'] . ', ', '', $data);
											$delete = $this->hotel->setConfig('min_rank', $data);
										} elseif ($this->hotel->getMasterType($select['id']) == 'medium') {
											$data = str_replace(', ' . $select['id'], '', $this->hotel->getConfig('medium_rank'));
											$data = str_replace($select['id'] . ', ', '', $data);
											$delete = $this->hotel->setConfig('medium_rank', $data);
										} elseif ($this->hotel->getMasterType($select['id']) == 'max') {
											$data = str_replace(', ' . $select['id'], '', $this->hotel->getConfig('max_rank'));
											$data = str_replace($select['id'] . ', ', '', $data);
											$delete = $this->hotel->setConfig('max_rank', $data);
										}
										$delete .= $this->hk->submitLog($this->users->get('id'), "Edited the rank <b>{$select['name']}</b>", time());
										$delete .= $this->con->query("DELETE FROM ranks WHERE id = '{$select['id']}'");
										if ($delete) {
											echo $this->deleteRank->texts['texts']['success'];
										} else {
											echo $this->deleteRank->texts['texts']['database'];
										}
									} else {
										echo $this->deleteRank->texts['texts']['you_cant'];
									}
								}
							}
						}
					}

					if ($type == 'editRank') {
						$id = $this->protection->filter($_POST['id']);
						$name = $this->protection->filter($_POST['name']);
						$type = $this->protection->filter($_POST['type']);
						$visibility = $this->protection->filter($_POST['visibility']);
						$badge = $this->protection->filter($_POST['badge']);
						$color = $this->protection->filter($_POST['color']);
						$rank = $this->users->get('rank');
						$id_edit = $this->sessions->get('session', 'id_edit');
						$name_edit = $this->sessions->get('session', 'name_edit');
						$actived_comments = $this->protection->filter($_POST['actived_comments']);
						if ($id_edit) {
							if (!in_array($rank, $this->hotel->getMaster('max'))) {
								echo $this->editRank->texts['texts']['no_perms'];
							} else {
								if (empty($name) || empty($type) || empty($visibility) || empty($badge) || empty($color)) {
									echo $this->editRank->texts['texts']['empty'];
								} else {
									if (strlen($name) < 3 || strlen($name) > 50) {
										echo $this->editRank->texts['texts']['shorter_or_larger_name'];
									} else {
										if (strlen($color) < 3 || strlen($color) > 7) {
											echo $this->editRank->texts['texts']['shorter_or_larger_color'];
										} else {
											if (strlen($badge) < 2 || strlen($badge) > 32) {
												echo $this->editRank->texts['texts']['shorter_or_larger_badge'];
											} else {
												if ($this->con->num_rows("SELECT * FROM ranks WHERE name = '{$name}' AND id != '{$id_edit}'") > 0) {
													echo $this->editRank->texts['texts']['exist_name'];
												} else {
													$mtype = $this->hotel->getMasterType($rank);
													if ($mtype == $type || $mtype == 'max' && $type == 'medium' || $mtype == 'max' && $type == 'min' || $mtype == 'medium' && $type == 'min' || $mtype == 'medium' && $type == 'nothing' || $mtype == 'max' && $type == 'nothing') {
														$query = $this->con->query("SELECT * FROM ranks WHERE name = '{$name}'");
														if ($id != 1) {
															// Remove ID from perms
															if ($this->hotel->getMasterType($id_edit) == 'min') {
																$new_perm = str_replace(', ' . $id_edit, '', $this->hotel->getConfig('min_rank'));
																$new_perm = str_replace($id_edit . ', ', '', $new_perm);
																$set = $this->hotel->setConfig('min_rank', $new_perm);
															} elseif ($this->hotel->getMasterType($id_edit) == 'medium') {
																$new_perm = str_replace(', ' . $id_edit, '', $this->hotel->getConfig('medium_rank'));
																$new_perm = str_replace($id_edit . ', ', '', $new_perm);
																$set = $this->hotel->setConfig('medium_rank', $new_perm);
															} elseif ($this->hotel->getMasterType($id_edit) == 'max') {
																$new_perm = str_replace(', ' . $id_edit, '', $this->hotel->getConfig('max_rank'));
																$new_perm = str_replace($id_edit . ', ', '', $new_perm);
																$set = $this->hotel->setConfig('max_rank', $new_perm);
															}
															// Add new ID to perms
															if ($type == 'min') {
																$set .= $this->hotel->setConfig('min_rank', $this->hotel->getConfig('min_rank') . ', ' . $id_edit);
															} elseif ($type == 'medium') {
																$set .= $this->hotel->setConfig('medium_rank', $this->hotel->getConfig('medium_rank') . ', ' . $id_edit);
															} elseif ($type == 'max') {
																$set .= $this->hotel->setConfig('max_rank', $this->hotel->getConfig('max_rank') . ', ' . $id_edit);
															}
														} else {
															$set = true;
														}
														if ($visibility == 'yes') {
															$visibility = 0;
														} else {
															$visibility = 1;
														}
														$set .= $this->con->query("UPDATE ranks SET id = '{$id_edit}', name = '{$name}', badge = '{$badge}', color = '{$color}', fuse_hide_staff = '{$visibility}' WHERE id = '{$id_edit}'");
														if ($set) {
															echo $this->editRank->texts['texts']['success'];
														} else {
															echo $this->editRank->texts['texts']['database'];
														}
													} else {
														echo $this->editRank->texts['texts']['you_cant'];
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}

				if ($type == 'submitNew') {
					$title = $this->protection->filter($_POST['title']);
					$short_story = $this->protection->filter($_POST['short_story']);
					$long_story = $this->protection->htmlFilter($_POST['long_story']);
					$image = $this->protection->filter($_POST['image']);
					$actived_comments = $this->protection->filter($_POST['actived_comments']);
					if (empty($title) || empty($short_story) || empty($long_story) || empty($image) || empty($actived_comments)) {
						echo $this->submitNew->texts['texts']['empty'];
					} else {
						if (strlen($title) < 4 || strlen($title) > 255) {
							echo $this->submitNew->texts['texts']['shorter_or_larger_title'];
						} else {
							if (strlen($image) < 4 || strlen($image) > 255) {
								echo $this->submitNew->texts['texts']['shorter_or_larger_image'];
							} else {
								if (!in_array($this->users->get('rank'), $this->hotel->getMaster('all'))) {
									echo $this->submitNew->texts['texts']['no_perms'];
								} else {
									$time = time();
									if ($actived_comments == 'active') {
										$actived_comments = 1;
									} else {
										$actived_comments = 0;
									}	
									$add = $this->con->query("INSERT INTO news (title, shortstory, longstory, image, published, author, comments) VALUES ('{$title}', '{$short_story}', '{$long_story}', '{$image}', '{$time}', '{$this->users->get('id')}', '{$actived_comments}')");
									$add .= $this->hk->submitLog($this->users->get('id'), "Added the new title: <b>{$title}</b>", time());
									if ($add) {
										echo $this->submitNew->texts['texts']['success'];
									} else {
										echo $this->submitNew->texts['texts']['database'];
									}
								}
							}
						}
					}
				}

				if ($type == 'maintenance') {
					if (in_array($this->users->get('rank'), $this->hotel->getMaster('max')) && in_array($this->users->get('username'), $this->hotel->getSuperUsers())) {
						$description = $this->protection->htmlFilter($_POST['description']);
						$status = $this->protection->filter($_POST['status']);
						if ($status == 1) {
							$status = 1;
						} else {
							$status = 0;
						}
						if (empty($description)) {
							echo $this->cmsSettings->texts['texts']['empty'];
						} else {
							$this->hotel->setConfig('maintenance', $status);
							$this->hotel->setConfig('maintenance_description', $description);
							echo $this->cmsSettings->texts['texts']['success_mainte'];
						}
					} else {
						echo $this->cmsSettings->texts['texts']['no_perms'];
					}
				}

				if ($type == 'otherOptions') {
					if (in_array($this->users->get('rank'), $this->hotel->getMaster('max')) && in_array($this->users->get('username'), $this->hotel->getSuperUsers())) {
						$logo = $this->protection->filter($_POST['logo']);
						$habbo_img = $this->protection->filter($_POST['habbo_img']);
						$radio = $this->protection->filter($_POST['radio']);
						$facebook = $this->protection->filter($_POST['facebook']);
						$twitter = $this->protection->filter($_POST['twitter']);
						$instagram = $this->protection->filter($_POST['instagram']);
						$min_rank = $this->protection->filter($_POST['min_ranks']);
						$medium_rank = $this->protection->filter($_POST['medium_ranks']);
						$max_rank = $this->protection->filter($_POST['max_ranks']);
						$super_users = $this->protection->filter($_POST['super_users']);

						if (empty($logo) || empty($habbo_img) || empty($min_rank) || empty($medium_rank) || empty($max_rank)) {
							echo $this->cmsSettings->texts['texts']['empty']; 
						} else {
							$save = $this->hotel->setConfig('logo', $logo);
							$save .= $this->hotel->setConfig('habbo_img', $habbo_img);
							$save .= $this->hotel->setConfig('facebook', $facebook);
							$save .= $this->hotel->setConfig('twitter', $twitter);
							$save .= $this->hotel->setConfig('instagram', $instagram);
							$save .= $this->hotel->setConfig('min_rank', $min_rank);
							$save .= $this->hotel->setConfig('medium_rank', $medium_rank);
							$save .= $this->hotel->setConfig('max_rank', $max_rank);
							$save .= $this->hotel->setConfig('radio', $radio);
							if (in_array($this->users->get('username'), $this->hotel->getSuperUsers())) {
								$save .= $this->hotel->setConfig('super_users', $super_users);
							}
							if ($save) {
								echo $this->cmsSettings->texts['texts']['success_save'];
							} else {
								echo $this->cmsSettings->texts['texts']['fail_save'];
							}
						}
					} else {
						echo $this->cmsSettings->texts['texts']['no_perms'];
					}
				}

				if ($type == 'restart') {
					$conditions = $this->protection->filter($_POST['conditions']);
					if (!$conditions) {
						echo $this->cmsSettings->texts['texts']['accept_conditions'];
					} else {
						$restart = $this->hotel->restartConfig();
						if ($restart) {
							echo $this->cmsSettings->texts['texts']['success_res'];
						} else {
							echo $this->cmsSettings->texts['texts']['database'];
						}
					}
				}

				if ($type == 'editNew') {
					$id_edit = $this->protection->filter($this->sessions->get('session', 'id_edit'));
					$title = $this->protection->filter($_POST['title']);
					$short_story = $this->protection->filter($_POST['short_story']);
					$long_story = $this->protection->htmlFilter($_POST['long_story']);
					$image = $this->protection->filter($_POST['image']);
					$actived_comments = $this->protection->filter($_POST['actived_comments']);
					$query = $this->con->query("SELECT * FROM news WHERE id = '{$id_edit}'");
					if ($this->con->num_rows($query) > 0) {
						if (empty($title) || empty($short_story) || empty($long_story) || empty($image)) {
							echo $this->editNew->texts['texts']['empty'];
						} else {
							if (strlen($title) < 4 || strlen($title) > 255) {
								echo $this->editNew->texts['texts']['shorter_or_larger_title'];
							} else {
								if (strlen($image) < 4 || strlen($image) > 255) {
									echo $this->editNew->texts['texts']['shorter_or_larger_image'];
								} else {
									if (!in_array($this->users->get('rank'), $this->hotel->getMaster('all'))) {
										echo $this->editNew->texts['texts']['no_perms'];
									} else {
										if ($this->hotel->getMasterType() == 'min' && $this->hotel->getMasterType($selectUser['rank']) == 'medium' || $this->hotel->getMasterType() == 'min' && $this->hotel->getMasterType($selectUser['rank']) == 'max' || $this->hotel->getMasterType() == 'medium' && $this->hotel->getMasterType($selectUser['rank']) == 'max') {
											echo $this->editNew->texts['texts']['no_perms'];
										} else {
											if ($actived_comments == 'active') {
												$actived_comments = 1;
											} else {
												$actived_comments = 0;
											}
											$select = $this->con->fetch_assoc($query);
											$queryUser = $this->con->query("SELECT * FROM users WHERE id = '{$select['author']}'");
											$selectUser = $this->con->fetch_assoc($queryUser);
											$time = time();
											$edit = $this->con->query("UPDATE news SET title = '{$title}', longstory = '{$long_story}', shortstory = '{$short_story}', published = '{$time}', image = '{$image}', comments = '{$actived_comments}' WHERE id = '{$id_edit}'");
											$edit .= $this->hk->submitLog($this->users->get('id'), "Edited the new number <b>{$id_edit}</b>", time());
											if ($edit) {
												echo $this->editNew->texts['texts']['success'];
											} else {
												echo $this->editNew->texts['texts']['database'];
											}
										}
									}
								}
							}
						}
					} else {
						echo $this->editNew->texts['texts']['not_exist'];
					}
				}

				if ($type == 'deleteNew') {
					$id = $this->protection->filter($_POST['id']);
					$query = $this->con->query("SELECT * FROM news WHERE id = '{$id}' LIMIT 1");
					$select = $this->con->fetch_assoc($query);
					if (empty($id) || !is_numeric($id)) {
						echo $this->deleteNew->texts['texts']['empty'];
					} else {
						if ($this->con->num_rows($query) == 0) {
							echo $this->deleteNew->texts['texts']['not_exist'];
						} else {
							if (!in_array($this->users->get('rank'), $this->hotel->getMaster('all'))) {
								echo $this->deleteNew->texts['texts']['no_perms'];
							} else {
								$queryUser = $this->con->query("SELECT * FROM users WHERE id = '{$select['author']}'");
								$selectUser = $this->con->fetch_assoc($queryUser);
								if ($this->hotel->getMasterType() == 'min' && $this->hotel->getMasterType($selectUser['rank']) == 'medium' || $this->hotel->getMasterType() == 'min' && $this->hotel->getMasterType($selectUser['rank']) == 'max' || $this->hotel->getMasterType() == 'medium' && $this->hotel->getMasterType($selectUser['rank']) == 'max') {
									echo $this->deleteNew->texts['texts']['no_perms'];
								} else {
									$delete = $this->hk->submitLog($this->users->get('id'), "Deleted the new title: <b>{$select['title']}</b>", time());
									$delete .= $this->con->query("DELETE FROM news WHERE id = '{$id}'");
									if ($delete) {
										echo $this->deleteNew->texts['texts']['success'];
									} else {
										echo $this->deleteNew->texts['texts']['database'];
									}
								}
							}
						}
					}
				}

				if ($type == 'deleteBan') {
					$id = $this->protection->filter($_POST['id']);
					$query = $this->con->query("SELECT * FROM bans WHERE id = '{$id}' LIMIT 1");
					$select = $this->con->fetch_assoc($query);
					if (empty($id) || !is_numeric($id)) {
						echo $this->deleteBan->texts['texts']['empty'];
					} else {
						if ($this->con->num_rows($query) == 0) {
							echo $this->deleteBan->texts['texts']['not_exist'];
						} else {
							if (!in_array($this->users->get('rank'), $this->hotel->getMaster('all'))) {
								echo $this->deleteBan->texts['texts']['no_perms'];
							} else {
								$queryUser = $this->con->query("SELECT * FROM users WHERE username = '{$select['added_by']}'");
								$selectUser = $this->con->fetch_assoc($queryUser);
								if ($this->hotel->getMasterType() == 'min' && $this->hotel->getMasterType($selectUser['rank']) == 'medium' || $this->hotel->getMasterType() == 'min' && $this->hotel->getMasterType($selectUser['rank']) == 'max' || $this->hotel->getMasterType() == 'medium' && $this->hotel->getMasterType($selectUser['rank']) == 'max') {
									echo $this->deleteBan->texts['texts']['no_perms'];
								} else {
									$delete = $this->hk->submitLog($this->users->get('id'), "Deleted the ban value: <b>{$select['value']}</b>", time());
									$delete .= $this->hk->deleteBan($id);
									if ($delete) {
										echo $this->deleteBan->texts['texts']['success'];
									} else {
										echo $this->deleteBan->texts['texts']['database'];
									}
								}
							}
						}
					}
				}

				if ($type == 'submitBan') {
					if (in_array($this->users->get('rank'), $this->hotel->getMaster('all'))) {
						$username = $this->protection->filter($_POST['username']);
						$reason = $this->protection->filter($_POST['reason']);
						$typeBan = $this->protection->filter($_POST['type']);
						$expire = $this->protection->filter($_POST['expire']);
						$real_date = $expire + time();
						if ($type == 'user') {
							$type = 'user';
						} else {
							$type = 'ip';
						}
						$getUser = $this->con->query("SELECT * FROM users WHERE username = '{$username}'");
						$getBan = $this->con->query("SELECT * FROM bans WHERE value = '{$username}' AND bantype = '{$type}'");
						$select = $this->con->fetch_assoc($getUser);

						if (empty($username) || empty($reason) || empty($typeBan) || empty($expire)) {
							echo $this->submitBan->texts['texts']['empty'];
						} elseif (!$this->con->num_rows($getUser)) {
							echo $this->submitBan->texts['texts']['invalid_username'];
						} else if ($this->con->num_rows($getBan)) {
							echo $this->submitBan->texts['texts']['already_banned'];
						} else if ($username == $this->users->get('username')) {
							echo $this->submitBan->texts['texts']['you_cant_you'];
						} else if ($this->hotel->getMasterType() == 'min' && $this->hotel->getMasterType($select['rank']) == 'medium' || $this->hotel->getMasterType() == 'min' && $this->hotel->getMasterType($select['rank']) == 'max' || $this->hotel->getMasterType() == 'medium' && $this->hotel->getMasterType($select['rank']) == 'max') {
							echo $this->submitBan->texts['texts']['you_cant'];
						} else {
							if ($typeBan == 'user') {
								$username = $select['username'];

								$ban = $this->hk->submitBan($typeBan, $username, $reason, $real_date, $this->users->get('username'), time());

								if ($ban) {
									echo $this->submitBan->texts['texts']['success'];
								} else {
									echo $this->submitBan->texts['texts']['database'];
								}

							} else {
								if (!empty($select['ip_last'])) {
									$username = $select['ip_last'];
								} else {
									$username = $select['ip_reg'];
								}

								if ($username == $this->users->get('ip_reg') || $username == $this->users->get('ip_last')) {
									echo $this->submitBan->texts['texts']['thats_your_ip'];
								} else {
									$ban = $this->hk->submitBan($typeBan, $username, $reason, $real_date, $this->users->get('username'), time());
									if ($ban) {
										echo $this->submitBan->texts['texts']['success'];
										$this->hk->submitLog($this->users->get('id'), "Banned with the value: <b>{$username}</b>", time());
									} else {
										echo $this->submitBan->texts['texts']['database'];
									}
								}
							}
						}

					} else {
						echo $this->submitBan->texts['texts']['no_perms'];
					}
				}

				if ($type == 'uploadBadge') {
					if (in_array($this->users->get('rank'), $this->hotel->getMaster('medium+'))) {
						$file = $_FILES['badge'];
						$this->upload->uploadFile($file, 'badge');
						if ($this->upload->status) {
							echo $this->uploadBadge->texts['texts']['success'];
							$this->hk->submitLog($this->users->get('id'), "Uploaded the badge <b>{$file['name']}</b>", time());
						} else {
							echo $this->uploadBadge->texts['texts']['fail'];
							echo "<b>{$this->upload->reason}</b>";
						}
					} else {
						echo $this->uploadBadge->texts['texts']['no_perms'];
					}
				}

				if ($type == 'submitBadgeInfo') {
					if (in_array($this->users->get('rank'), $this->hotel->getMaster('medium+'))) {
						$rute = $this->config->select['CDN']['SWF']['DIR_RUTE'] . DS . $this->config->select['CDN']['SWF']['DIR_BADGES'] . DS;
						$flashTexts = $this->config->select['CDN']['SWF']['DIR_RUTE'] . DS . $this->config->select['CDN']['SWF']['FLASH_TEXTS'];
						$name = $this->protection->filter($_POST['name']);
						$title = $this->protection->filter($_POST['title']);
						$desc = $this->protection->filter($_POST['description']);
						$badge = $rute . DS . $name . '.gif';
						if (empty($name) || empty($title) || empty($desc)) {
							echo $this->uploadBadge->texts['texts']['empty'];
						} else if (!file_exists($badge)) {
							echo $this->uploadBadge->texts['texts']['not_exist'];
						} else if (!file_exists($flashTexts)) {
							echo $this->uploadBadge->texts['texts']['no_flash_texts'];
						} else {
							$open = fopen($flashTexts, 'a');
							if ($open) {
								$write = fwrite($open, "badge_name_{$name}={$title}\n");
								$write .= fwrite($open, "badge_desc_{$name}={$desc}\n");
								if ($write) {
									echo $this->uploadBadge->texts['texts']['success_mod'];
								} else {
									echo $this->uploadBadge->texts['texts']['cant_write'];
								}
							} else {
								echo $this->uploadBadge->texts['texts']['cant_open'];
							}
						}
					} else {
						echo $this->uploadBadge->texts['texts']['no_perms'];
					}
				}

				if ($type == 'deleteBadge') {
					if (in_array($this->users->get('rank'), $this->hotel->getMaster('medium+'))) {
						$rute = $this->config->select['CDN']['SWF']['DIR_RUTE'] . DS . $this->config->select['CDN']['SWF']['DIR_BADGES'] . DS;
						$name = $this->protection->filter($_POST['name']);
						$badge = $rute . DS . $name . '.gif';
						if (empty($name)) {
							echo $this->uploadBadge->texts['texts']['empty'];
						} else if (!file_exists($badge)) {
							echo $this->uploadBadge->texts['texts']['not_exist'];
						} else {
							$delete = unlink($badge);
							if ($delete) {
								echo $this->uploadBadge->texts['texts']['success_del'];
							} else {
								echo $this->uploadBadge->texts['texts']['fail_del'];
							}
						}
					} else {
						echo $this->uploadBadge->texts['texts']['no_perms'];
					}
				}

				if ($type == 'uploadBadgeZIP') {
					if (in_array($this->users->get('rank'), $this->hotel->getMaster('max')) && in_array($this->users->get('username'), $this->hotel->getSuperUsers())) {
						$file = $_FILES['badges'];
						$this->upload->uploadFile($file, 'badgeZIP');
						if ($this->upload->status) {
							echo $this->uploadBadge->texts['texts']['success_pack'];
							$file['name'] = $this->protection->filter($file['name']);
							$this->hk->submitLog($this->users->get('id'), "Uploaded the badge pack <b>{$file['name']}</b>", time());
						} else {
							echo $this->uploadBadge->texts['texts']['fail_pack'];
							echo "<b>{$this->upload->reason}</b>";
						}
					} else {
						echo $this->uploadBadge->texts['texts']['no_perms'];
					}
				}

				if ($type == 'uploadMPU') {
					if (in_array($this->users->get('rank'), $this->hotel->getMaster('medium+'))) {
						$file = $_FILES['mpu'];
						$this->upload->uploadFile($file, 'MPU');
						if ($this->upload->status) {
							echo $this->uploadMPU->texts['texts']['success'];
							$this->hk->submitLog($this->users->get('id'), "Uploaded the MPU <b>{$file['name']}</b>", time());
						} else {
							echo $this->uploadMPU->texts['texts']['fail'];
							echo "<b>{$this->upload->reason}</b>";
						}
					} else {
						echo $this->uploadMPU->texts['texts']['no_perms'];
					}
				}

				if ($type == 'uploadMPUZIP') {
					if (in_array($this->users->get('rank'), $this->hotel->getMaster('max')) && in_array($this->users->get('username'), $this->hotel->getSuperUsers())) {
						$file = $_FILES['mpus'];
						$this->upload->uploadFile($file, 'MPUZIP');
						if ($this->upload->status) {
							echo $this->uploadMPU->texts['texts']['success_pack'];
							$file['name'] = $this->protection->filter($file['name']);
							$this->hk->submitLog($this->users->get('id'), "Uploaded the MPU pack <b>{$file['name']}</b>", time());
						} else {
							echo $this->uploadMPU->texts['texts']['fail_pack'];
							echo "<b>{$this->upload->reason}</b>";
						}
					} else {
						echo $this->uploadMPU->texts['texts']['no_perms'];
					}
				}

				if ($type == 'deleteMPU') {
					if (in_array($this->users->get('rank'), $this->hotel->getMaster('medium+'))) {
						$rute = $this->config->select['CDN']['SWF']['DIR_RUTE'] . DS . $this->config->select['CDN']['SWF']['DIR_MPUS'] . DS;
						$name = $this->protection->filter($_POST['name']);
						$mpu = $rute . DS . $name;
						if (empty($name)) {
							echo $this->uploadMPU->texts['texts']['empty'];
						} else if (!file_exists($mpu)) {
							echo $this->uploadMPU->texts['texts']['not_exist'];
						} else {
							$delete = unlink($mpu);
							if ($delete) {
								echo $this->uploadMPU->texts['texts']['success_del'];
							} else {
								echo $this->uploadMPU->texts['texts']['fail_del'];
							}
						}
					} else {
						echo $this->uploadMPU->texts['texts']['no_perms'];
					}
				}

				if ($type == 'uploadTemplate') {
					if ($this->hotel->getMasterType() == 'max' && in_array($this->users->get('username'), $this->hotel->getSuperUsers())) {
						$file = $_FILES['template'];
						$this->upload->uploadFile($file, 'template');
						if ($this->upload->status) {
							echo $this->uploadTemplate->texts['texts']['success'] . $this->redirections->js($this->url . '/hk/web/main', 3000);
						} else {
							echo $this->uploadTemplate->texts['texts']['fail'];
							echo "<b>{$this->upload->reason}</b>";
						}
					} else {
						echo $this->uploadTemplate->texts['texts']['no_perms'];
					}
				}

				if ($type == 'uploadStyles') {
					if ($this->hotel->getMasterType() == 'max' && in_array($this->users->get('username'), $this->hotel->getSuperUsers())) {
						$file = $_FILES['styles'];
						$this->upload->uploadFile($file, 'styles');
						if ($this->upload->status) {
							echo $this->uploadTemplate->texts['texts']['success_styles'] . $this->redirections->js($this->url . '/hk/web/main', 3000);
							$this->hk->submitLog($this->users->get('id'), "Uploaded styles {$file['name']}", time());
						} else {
							echo $this->uploadTemplate->texts['texts']['fail_styles'];
							echo "<b>{$this->upload->reason}</b>";
						}
					} else {
						echo $this->uploadTemplate->texts['texts']['no_perms'];
					}
				}

				if ($type == 'changeTheme') {
					if ($this->hotel->getMasterType() == 'max' && in_array($this->users->get('username'), $this->hotel->getSuperUsers())) {
						$theme = $this->protection->filter($_POST['theme']);
						$theme = str_replace(' ', '', $theme);
						$rute = ROOT . 'src' . DS . 'MasterCMS' . DS . 'Views' . DS . 'WebViews' . DS;
						$ruteStyles = MAIN_ROOT . 'Resources' . DS . 'Themes' . DS;
						if (empty($theme)) {
							echo $this->generalThemes->texts['texts']['empty'];
						} else if (!file_exists($rute . $theme . DS)) {
							echo $this->generalThemes->texts['texts']['not_exist'];
						} else if (!file_exists($ruteStyles . $theme . DS)) {
							echo $this->generalThemes->texts['texts']['not_exist_style'];
						} else {
							$this->hk->submitLog($this->users->get('id'), "Changed the theme from <b>{$this->hotel->getThemeInfo()}</b> to <b>{$this->hotel->getThemeInfo('name', $theme)}</b>", time());
							$set = $this->hotel->setConfig('template_name', $theme);
							if ($set) {
								echo $this->generalThemes->texts['texts']['success_changes'] . $this->redirections->js($this->url . '/hk/web/main', 3000);
							} else {
								echo $this->generalThemes->texts['texts']['database'];
							}
						}
					} else {
						echo $this->generalThemes->texts['texts']['no_perms'];
					}
				}

				if ($type == 'exportTheme' && !$extra) {
					if ($this->hotel->getMasterType() == 'max' && in_array($this->users->get('username'), $this->hotel->getSuperUsers())) {
						$theme = $this->protection->filter($_POST['theme']);
						$theme = str_replace(' ', '', $theme);
						$rute = ROOT . 'src' . DS . 'MasterCMS' . DS . 'Views' . DS . 'WebViews' . DS;
						$ruteStyles = MAIN_ROOT . 'Resources' . DS . 'Themes' . DS;
						if (empty($theme)) {
							echo $this->generalThemes->texts['texts']['empty'];
						} else if (!file_exists($rute . $theme . DS)) {
							echo $this->generalThemes->texts['texts']['not_exist'];
						} else {
							echo $this->generalThemes->texts['texts']['success_export'] . $this->redirections->js($this->url . "/hk/forms/exportTheme/{$theme}", 3000);
						}
					} else {
						echo $this->generalThemes->texts['texts']['no_perms'];
					}
				} else if ($type == 'exportTheme' && $extra) {
					$extra = $this->protection->filter($extra);
					if ($this->hotel->getMasterType() == 'max' && in_array($this->users->get('username'), $this->hotel->getSuperUsers())) {
						$rute = ROOT . 'src' . DS . 'MasterCMS' . DS . 'Views' . DS . 'WebViews' . DS;
						$ruteStyles = MAIN_ROOT . 'Resources' . DS . 'Themes' . DS;
						$ruteZip = ROOT . 'src' . DS . 'MasterCMS' . DS . 'Views' . DS . 'TemplateZIP' . DS;
						$theme = str_replace(' ', '', $extra);
						if (!file_exists($rute . $theme . DS)) {
							echo $this->generalThemes->texts['texts']['not_exist'];
						} else {
							$zip = new \ZipArchive;
							$zipRute = $rute . $theme . DS;
							$zipRT = $ruteZip . $theme . '.zip';
							if ($zip->open($zipRT, $zip::CREATE | $zip::OVERWRITE)) {
								$files = new \RecursiveIteratorIterator(
									new \RecursiveDirectoryIterator($zipRute),
									\RecursiveIteratorIterator::LEAVES_ONLY
								);
								foreach ($files as $entry) {
									if (!$entry->isDir()) {
										$entryName = substr($entry, strlen($rute . $theme) + 1);
										if ($entryName != '.theme_autoconfigured') {
											$relativePath = 'Template' . DS . $theme . DS . $entryName;
											$zip->addFile($entry, $relativePath);
										}
									}
								}

								$zipStyle = $ruteStyles . $theme;
								if (file_exists($zipStyle)) {
									$files = new \RecursiveIteratorIterator(
										new \RecursiveDirectoryIterator($zipStyle . DS),
										\RecursiveIteratorIterator::LEAVES_ONLY
									);
									foreach ($files as $entry) {
										if (!$entry->isDir()) {
											$entryName = substr($entry, strlen($zipStyle) + 1);
											$relativePath = 'Styles' . DS . $theme . DS . $entryName;
											$zip->addFile($entry, $relativePath);
										}
									}
								}

								$this->hk->submitLog($this->users->get('id'), "Exported the theme <b>{$theme}</b>", time());

								if ($this->config->select['WEB']['LANG'] == 'ES') {
									$text = "# {$theme}\n{$theme} es un tema para MasterCMS\nPara instalar {$theme} en siga las siguientes instrucciones:\n\n- Ve a la housekeeping.\n- Ve a MasterCMS Settings.\n- Sube el ZIP de el tema en el subidor de temas.\n- Cambia tu tema actual a {$theme}.\n\nAviso: Para poder hacer los pasos anteriores debe estar en la lista de \"Super Users\"\n\n Eso es todo, disfrutelo!";
								} else {
									$text = "# {$theme}\n{$theme} is a theme for MasterCMS\nTo install {$theme} follow the next instructions:\n\n- Go to the housekeeping.\n- Go to MasterCMS Settings.\n- Upload the ZIP of this theme on the theme uploader.\n- Change your current theme to {$theme}.\n\nAdvice: To do the steps you need to be on the \"Super Users\" list\n\nThats it, enjoy it!";
								}

								$zip->addFromString('README.md', $text);

								$zip->addFromString('.theme_name', "{$theme}");
								$zip->close();
								header("Content-type: application/octet-stream");
								header("Content-disposition: attachment; filename = '{$theme}.zip'");
								readfile($zipRT);
								unlink($zipRT);
							} else {
								echo $this->generalThemes->texts['texts']['cant_create'];
							}
						}
					} else {
						echo $this->generalThemes->texts['texts']['no_perms'];
					}
				} else if ($type == 'deleteTheme') {
					if ($this->hotel->getMasterType() == 'max' && in_array($this->users->get('username'), $this->hotel->getSuperUsers())) {
						$rute = ROOT . 'src' . DS . 'MasterCMS' . DS . 'Views' . DS . 'WebViews' . DS;
						$ruteStyles = MAIN_ROOT . 'Resources' . DS . 'Themes' . DS;
						$ruteZip = ROOT . 'src' . DS . 'MasterCMS' . DS . 'Views' . DS . 'TemplateZIP' . DS;
						$theme = $this->protection->filter($_POST['theme']);
						$theme = str_replace(' ', '', $theme);
						$current_theme = $this->hotel->getConfig('template_name');
						if (empty($theme)) {
							echo $this->generalThemes->texts['texts']['empty'];
						} else if (!file_exists($rute . $theme . DS)) {
							echo $this->generalThemes->texts['texts']['not_exist'];
						} else if (strtolower($theme) == strtolower($current_theme)) {
							echo $this->generalThemes->texts['texts']['cant_current_del'];
						} else {
							// Delete Template
							$this->hotel->deletePath($rute . $theme);
							// Delete Styles
							if (file_exists($ruteStyles . $theme . DS)) {
								$this->hotel->deletePath($ruteStyles . $theme);
							}

							$this->hk->submitLog($this->users->get('id'), "Deleted the theme <b>{$theme}</b>", time());
							echo $this->generalThemes->texts['texts']['success_delete'] . $this->redirections->js($this->url . '/hk/web/main', 3000);
						}
					} else {
						echo $this->generalThemes->texts['texts']['no_perms'];
					}
				}

				if ($type == 'editUserSearch') {
					$username = $this->protection->filter($_POST['username']);
					if (empty($username)) {
						echo $this->generalUsers->texts['texts']['empty'];
					} else {
						$query = $this->con->query("SELECT * FROM users WHERE (username LIKE '%{$username}%') ORDER BY id ASC");
						if ($this->con->num_rows($query)) {
							$this->template->setParam('listusersedit', true);
							$this->template->setParam('post_username', $username);
							$this->template->addTemplate('Ajax' . DS . 'Template' . DS . 'Header', 'Hk');
							while ($select = $this->con->fetch_assoc($query)) {
								foreach ($select as $key => $value) {
									$this->template->setParam('users_' . $key, $value);
								}
								if ($select['online']) {
									$this->template->setParam('users_status', 'online');
								} else {
									$this->template->setParam('users_status', 'offline');
								}
								$queryRank = $this->con->query("SELECT * FROM ranks WHERE id = '{$select['rank']}'");
								$selectRank = $this->con->fetch_assoc($queryRank);
								if (!$selectRank['name']) {
									$selectRank['name'] = 'Not found';
								}
								$this->template->setParam('users_rank_name', $selectRank['name']);
								$country = $this->users->getCountry($select['ip_last']);
								if (empty($country)) {
									$country = 'IDK';
								} else {
									$country = $country;
								}
								$this->template->setParam('users_country', $country);

 								$this->template->addTemplate('Ajax' . DS . 'listEditUserSearch', 'Hk');
							}
							$this->template->addTemplate('Ajax' . DS . 'Template' . DS . 'Footer', 'Hk');
						} else {
							echo $this->generalUsers->texts['texts']['not_found'] . $username;
						}
					}
				}

				if ($type == 'editUser') {
					$user_id = $this->sessions->get('session', 'id_edit');
					$username = $this->protection->filter($_POST['username']);
					$motto = $this->protection->filter($_POST['motto']);
					$mail = $this->protection->filter($_POST['mail']);
					$credits = $this->protection->filter($_POST['credits']);
					$duckets = $this->protection->filter($_POST['duckets']);
					$diamonds = $this->protection->filter($_POST['diamonds']);
					$queryUser = $this->con->query("SELECT * FROM users WHERE id = '{$user_id}'");
					$selectUser = $this->con->fetch_assoc($queryUser);
					$query = $this->con->query("SELECT * FROM users WHERE username = '{$username}'");
					$select = $this->con->fetch_assoc($query);
					$queryMail = $this->con->query("SELECT * FROM users WHERE mail = '{$mail}'");
					if ($credits < 1) {
						$credits = 0;
					}
					if ($ducket < 1) {
						$ducket = 0;
					}
					if ($diamonds < 1) {
						$diamonds = 0;
					}
					if ($this->con->num_rows($queryUser)) {
						if (!$user_id) {
							echo $this->generalUsers->texts['texts']['not_user'];
						} else {
							if ($this->hotel->getMasterType() == 'min') {
								if (strlen($motto) > 50) {
									echo $this->generalUsers->texts['texts']['shorter_or_larger_motto'];
								} else {
									if ($this->hotel->getMasterType() == 'min' && $this->hotel->getMasterType($selectUser['rank']) == 'medium' || $this->hotel->getMasterType() == 'min' && $this->hotel->getMasterType($selectUser['rank']) == 'max' || $this->hotel->getMasterType() == 'medium' && $this->hotel->getMasterType($selectUser['rank']) == 'max' || $this->hotel->getMasterType() == 'max' && $this->hotel->getMasterType($selectUser['rank']) == 'max' && $selectUser['username'] != $this->users->get('username') && $selectUser['rank'] > $this->users->get('rank')) {
										echo $this->generalUsers->texts['texts']['no_perms'];
									} else {
										$this->users->set('motto', $credits, $selectUser['motto']);
										$this->users->set('credits', $credits, $selectUser['username']);
										$this->users->set('activity_points', $duckets, $selectUser['username']);
										$this->users->set('vip_points', $diamonds, $selectUser['username']);
										$this->hk->submitLog($this->users->get('id'), "Edited the user number: <b>{$selectUser['id']}</b>", time());
										echo $this->generalUsers->texts['texts']['success'];
									}
								}
							} else if (in_array($this->users->get('rank'), $this->hotel->getMaster('medium+'))) {
								if (empty($username) || empty($motto) || empty($mail)) {
									echo $this->generalUsers->texts['texts']['empty'];
								} else if (strlen($username) < 4 || strlen($username) > 15) {
									echo $this->generalUsers->texts['texts']['shorter_or_larger_username'];
								} elseif (strlen($motto) > 50) {
									echo $this->generalUsers->texts['texts']['shorter_or_larger_motto'];
								} else {
									if ($this->hotel->getMasterType() == 'min' && $this->hotel->getMasterType($selectUser['rank']) == 'medium' || $this->hotel->getMasterType() == 'min' && $this->hotel->getMasterType($selectUser['rank']) == 'max' || $this->hotel->getMasterType() == 'medium' && $this->hotel->getMasterType($selectUser['rank']) == 'max' || $this->hotel->getMasterType() == 'max' && $this->hotel->getMasterType($selectUser['rank']) == 'max' && $selectUser['username'] != $this->users->get('username') && $selectUser['rank'] > $this->users->get('rank')) {
										echo $this->generalUsers->texts['texts']['no_perms'];
									} else {
										if ($this->hotel->getMasterType($selectUser['rank']) != 'max' && !in_array($selectUser['username'], $this->hotel->getSuperUsers()) && $selectUser['username'] != $this->users->get('username') || $selectUser['username'] == $this->users->get('username')) {

											if ($this->users->validateMail($mail)) {
												if ($this->hotel->getMasterType() == 'max' && in_array($this->users->get('username'), $this->hotel->getSuperUsers())) {
													if ($password) {
														if (strlen($password) < 4 || strlen($password) > 30) {
															echo $this->generalUsers->texts['texts']['shorter_or_larger_password'];
														} else {
															if ($username != $selectUser['username']) {
																if (!$this->con->num_rows($query)) {
																	if ($mail != $selectUser['mail']) {
																		if (!$this->con->num_rows($queryMail)) {
																			$this->users->set('password', $this->protection->encriptPassword($password), $selectUser['username']);
																			$this->users->set('motto', $motto, $selectUser['username']);
																			$this->users->set('mail', $mail, $selectUser['username']);
																			$this->users->set('credits', $credits, $selectUser['username']);
																			$this->users->set('activity_points', $duckets, $selectUser['username']);
																			$this->users->set('vip_points', $diamonds, $selectUser['username']);
																			$this->users->set('username', $username, $selectUser['username']);
																			$this->hk->submitLog($this->users->get('id'), "Edited the user number: <b>{$selectUser['id']}</b>", time());
																			echo $this->generalUsers->texts['texts']['success'];
																		} else {
																			echo $this->generalUsers->texts['texts']['exist_mail'];
																		}
																	} else {
																		$this->users->set('password', $this->protection->encriptPassword($password), $selectUser['username']);
																		$this->users->set('motto', $motto, $selectUser['username']);
																		$this->users->set('mail', $mail, $selectUser['username']);
																		$this->users->set('credits', $credits, $selectUser['username']);
																		$this->users->set('activity_points', $duckets, $selectUser['username']);
																		$this->users->set('vip_points', $diamonds, $selectUser['username']);
																		$this->users->set('username', $username, $selectUser['username']);
																		$this->hk->submitLog($this->users->get('id'), "Edited the user number: <b>{$selectUser['id']}</b>", time());
																		echo $this->generalUsers->texts['texts']['success'];
																	}
																} else {
																	echo $this->generalUsers->texts['texts']['exist_username'];
																}
															} else {
																if ($mail != $selectUser['mail']) {
																	if (!$this->con->num_rows($queryMail)) {
																		$this->users->set('password', $this->protection->encriptPassword($password), $selectUser['username']);
																		$this->users->set('motto', $motto, $selectUser['username']);
																		$this->users->set('mail', $mail, $selectUser['username']);
																		$this->users->set('credits', $credits, $selectUser['username']);
																		$this->users->set('activity_points', $duckets, $selectUser['username']);
																		$this->users->set('vip_points', $diamonds, $selectUser['username']);
																		$this->users->set('username', $username, $selectUser['username']);
																		$this->hk->submitLog($this->users->get('id'), "Edited the user number: <b>{$selectUser['id']}</b>", time());
																		echo $this->generalUsers->texts['texts']['success'];
																	} else {
																		echo $this->generalUsers->texts['texts']['exist_mail'];
																	}
																} else {
																	$this->users->set('password', $this->protection->encriptPassword($password), $selectUser['username']);
																	$this->users->set('motto', $motto, $selectUser['username']);
																	$this->users->set('mail', $mail, $selectUser['username']);
																	$this->users->set('credits', $credits, $selectUser['username']);
																	$this->users->set('activity_points', $duckets, $selectUser['username']);
																	$this->users->set('vip_points', $diamonds, $selectUser['username']);
																	$this->users->set('username', $username, $selectUser['username']);
																	$this->hk->submitLog($this->users->get('id'), "Edited the user number: <b>{$selectUser['id']}</b>", time());
																	echo $this->generalUsers->texts['texts']['success'];
																}
															}
														}
													} else {
														if ($username != $selectUser['username']) {
															if (!$this->con->num_rows($query)) {
																if ($mail != $selectUser['mail']) {
																	if (!$this->con->num_rows($queryMail)) {
																		$this->users->set('motto', $motto, $selectUser['username']);
																		$this->users->set('mail', $mail, $selectUser['username']);
																		$this->users->set('credits', $credits, $selectUser['username']);
																		$this->users->set('activity_points', $duckets, $selectUser['username']);
																		$this->users->set('vip_points', $diamonds, $selectUser['username']);
																		$this->users->set('username', $username, $selectUser['username']);
																		$this->hk->submitLog($this->users->get('id'), "Edited the user number: <b>{$selectUser['id']}</b>", time());
																		echo $this->generalUsers->texts['texts']['success'];
																	} else {
																		echo $this->generalUsers->texts['texts']['exist_mail'];
																	}
																} else {
																	$this->users->set('password', $this->protection->encriptPassword($password), $selectUser['username']);
																	$this->users->set('motto', $motto, $selectUser['username']);
																	$this->users->set('mail', $mail, $selectUser['username']);
																	$this->users->set('credits', $credits, $selectUser['username']);
																	$this->users->set('activity_points', $duckets, $selectUser['username']);
																	$this->users->set('vip_points', $diamonds, $selectUser['username']);
																	$this->users->set('username', $username, $selectUser['username']);
																	$this->hk->submitLog($this->users->get('id'), "Edited the user number: <b>{$selectUser['id']}</b>", time());
																	echo $this->generalUsers->texts['texts']['success'];
																}
															} else {
																echo $this->generalUsers->texts['texts']['exist_username'];
															}
														} else {
															if ($mail != $selectUser['mail']) {
																if (!$this->con->num_rows($queryMail)) {
																	$this->users->set('motto', $motto, $selectUser['username']);
																	$this->users->set('mail', $mail, $selectUser['username']);
																	$this->users->set('credits', $credits, $selectUser['username']);
																	$this->users->set('activity_points', $duckets, $selectUser['username']);
																	$this->users->set('vip_points', $diamonds, $selectUser['username']);
																	$this->users->set('username', $username, $selectUser['username']);
																	$this->hk->submitLog($this->users->get('id'), "Edited the user number: <b>{$selectUser['id']}</b>", time());
																	echo $this->generalUsers->texts['texts']['success'];
																} else {
																	echo $this->generalUsers->texts['texts']['exist_mail'];
																}
															} else {
																$this->users->set('motto', $motto, $selectUser['username']);
																$this->users->set('mail', $mail, $selectUser['username']);
																$this->users->set('credits', $credits, $selectUser['username']);
																$this->users->set('activity_points', $duckets, $selectUser['username']);
																$this->users->set('vip_points', $diamonds, $selectUser['username']);
																$this->users->set('username', $username, $selectUser['username']);
																$this->hk->submitLog($this->users->get('id'), "Edited the user number: <b>{$selectUser['id']}</b>", time());
																echo $this->generalUsers->texts['texts']['success'];
															}
														}
													}
												} else {
													if ($username != $selectUser['username']) {
														if (!$this->con->num_rows($query)) {
															if ($mail != $selectUser['mail']) {
																if (!$this->con->num_rows($queryMail)) {
																	$this->users->set('motto', $motto, $selectUser['username']);
																	$this->users->set('mail', $mail, $selectUser['username']);
																	$this->users->set('credits', $credits, $selectUser['username']);
																	$this->users->set('activity_points', $duckets, $selectUser['username']);
																	$this->users->set('vip_points', $diamonds, $selectUser['username']);
																	$this->users->set('username', $username, $selectUser['username']);
																	$this->hk->submitLog($this->users->get('id'), "Edited the user number: <b>{$selectUser['id']}</b>", time());
																	echo $this->generalUsers->texts['texts']['success'];
																} else {
																	echo $this->generalUsers->texts['texts']['exist_mail'];
																}
															} else {
																$this->users->set('password', $this->protection->encriptPassword($password), $selectUser['username']);
																$this->users->set('motto', $motto, $selectUser['username']);
																$this->users->set('mail', $mail, $selectUser['username']);
																$this->users->set('credits', $credits, $selectUser['username']);
																$this->users->set('activity_points', $duckets, $selectUser['username']);
																$this->users->set('vip_points', $diamonds, $selectUser['username']);
																$this->users->set('username', $username, $selectUser['username']);
																$this->hk->submitLog($this->users->get('id'), "Edited the user number: <b>{$selectUser['id']}</b>", time());
																echo $this->generalUsers->texts['texts']['success'];
															}
														} else {
															echo $this->generalUsers->texts['texts']['exist_username'];
														}
													} else {
														if ($mail != $selectUser['mail']) {
															if (!$this->con->num_rows($queryMail)) {
																$this->users->set('motto', $motto, $selectUser['username']);
																$this->users->set('mail', $mail, $selectUser['username']);
																$this->users->set('credits', $credits, $selectUser['username']);
																$this->users->set('activity_points', $duckets, $selectUser['username']);
																$this->users->set('vip_points', $diamonds, $selectUser['username']);
																$this->users->set('username', $username, $selectUser['username']);
																$this->hk->submitLog($this->users->get('id'), "Edited the user number: <b>{$selectUser['id']}</b>", time());
																echo $this->generalUsers->texts['texts']['success'];
															} else {
																echo $this->generalUsers->texts['texts']['exist_mail'];
															}
														} else {
															$this->users->set('motto', $motto, $selectUser['username']);
															$this->users->set('mail', $mail, $selectUser['username']);
															$this->users->set('credits', $credits, $selectUser['username']);
															$this->users->set('activity_points', $duckets, $selectUser['username']);
															$this->users->set('vip_points', $diamonds, $selectUser['username']);
															$this->users->set('username', $username, $selectUser['username']);
															$this->hk->submitLog($this->users->get('id'), "Edited the user number: <b>{$selectUser['id']}</b>", time());
															echo $this->generalUsers->texts['texts']['success'];
														}
													}
												}
											} else {
												echo $this->generalUsers->texts['texts']['invalid_mail'];
											}
										} else {
											echo $this->generalUsers->texts['texts']['no_perms'];
										}
									}
								}
							} else {
								echo $this->generalUsers->texts['texts']['no_perms'];
							}
						}
					} else {
						echo $this->generalUsers->texts['texts']['not_exist'];
					}
				}

				if ($type == 'deleteUser') {
					$username = $this->protection->filter($_POST['username']);
					$consequence = $this->protection->filter($_POST['consequence']);
					if (in_array($this->users->get('rank'), $this->hotel->getMaster('medium+'))) {
						$queryUser = $this->con->query("SELECT * FROM users WHERE username = '{$username}'");
						$selectUser = $this->con->fetch_assoc($queryUser);
						if (empty($username)) {
							echo $this->generalUsers->texts['texts']['empty'];
						} else {
							if ($this->con->num_rows($queryUser)) {
								if ($username != $this->users->get('username')) {
									if ($consequence) {
										if ($this->hotel->getMasterType() == 'min' && $this->hotel->getMasterType($selectUser['rank']) == 'medium' || $this->hotel->getMasterType() == 'min' && $this->hotel->getMasterType($selectUser['rank']) == 'max' || $this->hotel->getMasterType() == 'medium' && $this->hotel->getMasterType($selectUser['rank']) == 'max' || $this->hotel->getMasterType() == 'max' && $this->hotel->getMasterType($selectUser['rank']) == 'max' && $selectUser['username'] != $this->users->get('username') && $selectUser['rank'] > $this->users->get('rank')) {
											echo $this->generalUsers->texts['texts']['no_perms'];
										} else {
											if ($this->hotel->getMasterType($selectUser['rank']) != 'max' && !in_array($selectUser['username'], $this->hotel->getSuperUsers())) {
												$this->hk->submitLog($this->users->get('id'), "Deleted user: <b>{$selectUser['username']}</b>", time());
												$delete = $this->users->delete($selectUser['username']);
												if ($delete) {
													echo $this->generalUsers->texts['texts']['success'];
												} else {
													echo $this->generalUsers->texts['texts']['database'];
												}
											} else {
												echo $this->generalUsers->texts['texts']['no_perms'];
											}
										}
									} else {
										echo $this->generalUsers->texts['texts']['accept_consequence'];
									}
								} else {
									echo $this->generalUsers->texts['texts']['cant_you'];
								}
							} else {
								echo $this->generalUsers->texts['texts']['not_exist'];
							}
						}
					} else {
						echo $this->generalUsers->texts['texts']['no_perms'];
					}
				}

				if ($type == 'syncAccount') {
					$username = $this->protection->filter($_POST['username']);
					if (in_array($this->users->get('rank'), $this->hotel->getMaster('max'))) {
						$queryUser = $this->con->query("SELECT * FROM users WHERE username = '{$username}'");
						$selectUser = $this->con->fetch_assoc($queryUser);
						if (empty($username)) {
							echo $this->generalUsers->texts['texts']['empty'];
						} else {
							if ($this->con->num_rows($queryUser)) {
								if ($username != $this->users->get('username')) {
									if ($this->hotel->getMasterType() == 'min' && $this->hotel->getMasterType($selectUser['rank']) == 'medium' || $this->hotel->getMasterType() == 'min' && $this->hotel->getMasterType($selectUser['rank']) == 'max' || $this->hotel->getMasterType() == 'medium' && $this->hotel->getMasterType($selectUser['rank']) == 'max' || $this->hotel->getMasterType() == 'max' && $this->hotel->getMasterType($selectUser['rank']) == 'max' && $selectUser['username'] != $this->users->get('username') && $selectUser['rank'] > $this->users->get('rank')) {
										echo $this->generalUsers->texts['texts']['no_perms'];
									} else {
										if ($this->hotel->getMasterType($selectUser['rank']) != 'max' && !in_array($selectUser['username'], $this->hotel->getSuperUsers())) {
											$this->users->set('ip_last', $this->users->getIP(), $username);
											$this->users->set('last_used', time(), $username);
											$this->sessions->delete('session', '*');
											$this->sessions->delete('cookie', 'username');
											$this->sessions->delete('cookie', 'password');
											$this->hk->submitLog($this->users->get('id'), "Synchronized with user: <b>{$selectUser['username']}</b>", time());
											if ($selectUser['facebook_account']) {
												$this->sessions->set('session', 'facebook_id', $selectUser['facebook_id']);
											} else {
												$this->sessions->set('session', 'username', $selectUser['username']);
												$this->sessions->set('session', 'password', $selectUser['password']);
											}
											echo $this->generalUsers->texts['texts']['success'] . $this->redirections->js($this->url, 3000);
										} else {
											echo $this->generalUsers->texts['texts']['no_perms'];
										}
									}
								} else {
									echo $this->generalUsers->texts['texts']['cant_you'];
								}
							} else {
								echo $this->generalUsers->texts['texts']['not_exist'];
							}
						}
					} else {
						echo $this->generalUsers->texts['texts']['no_perms'];
					}
				}

				if ($type == 'deleteLogs') {
					if ($this->hotel->getMasterType() == 'max') {
						$delete = $this->hk->deleteLog('*');
						$delete .= $this->hk->submitLog($this->users->get('id'), "Deleted every staff logs on the <b>CMS</b>", time());
						if ($delete) {
							echo $this->generalLogs->texts['texts']['success'];
						} else {
							echo $this->generalLogs->texts['texts']['database'];
						}
					} else {
						echo $this->generalLogs->texts['texts']['no_perms'];
					}
				}

				if ($type == 'deleteClientLogs') {
					if ($this->hotel->getMasterType() == 'max') {
						$time = time();
						$delete = $this->con->query("DELETE FROM logs_client_staff");
						$delete .= $this->hk->submitLog($this->users->get('id'), "Deleted every staff logs on the <b>Game</b>", time());
						$delete .= $this->con->query("INSERT INTO logs_client_staff (user_id, data_string, timestamp) VALUES ('{$this->users->get('id')}', 'Deleted every staff logs on the <b>Game</b>', '{$time}')");
						if ($delete) {
							echo $this->generalLogs->texts['texts']['success'];
						} else {
							echo $this->generalLogs->texts['texts']['database'];
						}
					} else {
						echo $this->generalLogs->texts['texts']['no_perms'];
					}
				}
			} else {
				$this->redirections->js($this->url, 3000);
				echo $this->submitPin->texts['texts']['no_perms'];
			}
		}

		public function __destruct()
		{
			$this->con->close();
		}
	}

?>