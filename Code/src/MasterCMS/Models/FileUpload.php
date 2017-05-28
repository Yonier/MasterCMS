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

	class FileUpload {

		private $config;
		private $hk;
		public $status;
		public $reason;
		private $users;
		private $hotel;
		private $template;
		private $protection;
		private $supportedFormats;

		public function __construct()
		{
			$this->hk = new Housekeeping;
			$this->config = new Config;
			$this->protection = new Protection;
			$this->hotel = new Hotel;
			$this->users = new Users;
		}

		public function uploadFile($file, $type = false)
		{
			define('KB', 1024);
			define('MB', 1048576);
			define('GB', 1073741824);
			define('TB', 1099511627776);
			$file['name'] = $this->protection->filter($file['name']);
			$rand = $this->generateToken();
			$ext = explode('.', $file['name']);
			$ext = end($ext);
			$fileName = $file['name'];
			$fileName = str_replace(' ', '', $fileName);
			$file2Name = str_replace('.zip', '', $fileName);
			$finalTemplate = substr($file2Name, -8, 8);
			$finalStyles = strstr($file2Name, -6);
			$finalStyles = substr($file2Name, -6, 6);
			try {
				if ($type == 'template') {
					$this->supportedFormats = ['application/zip', 'application/octet-stream', 'application/x-zip-compressed'];
					$rute = ROOT . 'src' . DS . 'MasterCMS' . DS . 'Views' . DS . 'WebViews' . DS;
					$ruteStyles = MAIN_ROOT . 'Resources' . DS . 'Themes' . DS;
					$this->status = false;
					if ($fileName == '.zip') {
					 	throw new \Exception("Invalid file name");
					} else if (empty($fileName)) {
						throw new \Exception("You must select a file");
					} elseif ($file['error']) {
						throw new \Exception("Invalid file, have errors");
					} else if (!in_array($file['type'], $this->supportedFormats)) {
						throw new \Exception("Not allowed file");
					} else if ($file['size'] > ($max_size = 15 * MB)) {
						throw new \Exception("File size exceeds 15MB");
					} else {
						$fileName = $file2Name;
						$zip = new \ZipArchive;
						if ($zip->open($file['tmp_name'])) {
							$zipFiles = zip_open($file['tmp_name']);
							$files = array();
						    while ($zip_entry = zip_read($zipFiles)) {
						    	array_push($files, zip_entry_name($zip_entry));
						    	if (zip_entry_name($zip_entry) == '.theme_name') {
						    		if (zip_entry_open($zipFiles, $zip_entry)) {
						    			$contest = zip_entry_read($zip_entry);
						    		}
						    	}
						    }

						    $files = str_replace('\\', '/', $files);
						    $files = str_replace(DS, '/', $files);
						
						    if (file_exists($rute . $contest . DS) && file_exists($ruteStyles . $contest . DS)) {
						    	throw new \Exception("Theme already exist");
						    } elseif (!in_array('Template/' . $contest . '/' . 'Langs/' . $this->config->select['WEB']['LANG'] . '/' . 'Texts' . '/' . 'Main.php', $files)) {
						    	throw new \Exception("Template needs Texts/Main.php");
						    } elseif (!in_array('Template/' . $contest . '/' . 'Langs/' . $this->config->select['WEB']['LANG'] . '/' . 'Web' . '/' . 'Index.tpl', $files)) {
						    	throw new \Exception("Template needs Web/Index.tpl");
						    } elseif (!in_array('Template/' . $contest . '/' . 'Langs/' . $this->config->select['WEB']['LANG'] . '/' . 'Web' . '/' . 'Me.tpl', $files)) {
						    	throw new \Exception("Template needs Web/Me.tpl");
						    } elseif (!in_array('Template/' . $contest . '/' . 'Langs/' . $this->config->select['WEB']['LANG'] . '/' . 'Template' . '/' . 'Header.tpl', $files)) {
						    	throw new \Exception("Template needs Template/Header.tpl");
						    } elseif (!in_array('Template/' . $contest . '/' . 'Langs/' . $this->config->select['WEB']['LANG'] . '/' . 'Template' . '/' . 'Footer.tpl', $files)) {
						    	throw new \Exception("Template needs Template/Footer.tpl");
						    } elseif (!in_array('Template/' . $contest . '/' . 'Langs/' . $this->config->select['WEB']['LANG'] . '/' . 'Mails' . '/' . 'Verification.html', $files)) {
						    	throw new \Exception("Template needs Mails/Verification.html");
						    } elseif (!in_array('Template/' . $contest . '/' . 'Langs/' . $this->config->select['WEB']['LANG'] . '/' . 'Mails' . '/' . 'PasswordChanged.html', $files)) {
						    	throw new \Exception("Template needs Mails/PasswordChanged.html");
						    } elseif (!in_array('Template/' . $contest . '/' . 'Langs/' . $this->config->select['WEB']['LANG'] . '/' . 'Mails' . '/' . 'MailChanged.html', $files)) {
						    	throw new \Exception("Template needs Mails/MailChanged.html");
						    } elseif (!in_array('Template/' . $contest . '/' . 'Langs/' . $this->config->select['WEB']['LANG'] . '/' . 'Mails' . '/' . 'Forgot.html', $files)) {
						    	throw new \Exception("Template needs Mails/Forgot.html");
						    } elseif (!in_array('Template/' . $contest . '/' . 'Langs/' . $this->config->select['WEB']['LANG'] . '/' . 'Mails' . '/' . 'Delete.html', $files)) {
						    	throw new \Exception("Template needs Mails/Delete.html");
						    } elseif (!in_array('Template/' . $contest . '/' . 'Langs/' . $this->config->select['WEB']['LANG'] . '/' . 'Mails' . '/' . 'AccountDeleted.html', $files)) {
						    	throw new \Exception("Template needs Mails/AccountDeleted.html");
						    } elseif (!in_array('Template/' . $contest . '/' . 'Langs/' . $this->config->select['WEB']['LANG'] . '/' . 'Mails' . '/' . 'AccountCreated.html', $files)) {
						    	throw new \Exception("Template needs Mails/AccountCreated.html");
						    } else {
						    	// Templates
						    	$dir = $rute . $contest;
						    	$extract = $zip->extractTo($rute . $contest . 'Extract' . DS);
						    	$this->hotel->moveData($rute . $contest . 'Extract' . DS . 'Template' . DS . $contest, $dir);
						    	$this->hotel->deletePath($rute . $contest . 'Extract');
						    	// Styles
						    	$dir = $ruteStyles . $contest;
						    	$extract .= $zip->extractTo($ruteStyles . $contest . 'Extract' . DS);	
						    	$this->hotel->moveData($ruteStyles . $contest . 'Extract' . DS . 'Styles' . DS . $contest, $dir);
						    	$this->hotel->deletePath($ruteStyles . $contest . 'Extract');	
						    	if (in_array('Template/' . $contest . '/' . '.theme_name', $files)) {
						    		unlink($rute . $contest . DS . '.theme_name');
						    	}
						    	if (in_array('Template/' . $contest . '/' . '.theme_', $files)) {
						    		unlink($rute . $contest . DS . '.theme_autoconfigured');
						    	}
						    	if ($extract) {
						    		$this->status = true;
						    		$this->hk->submitLog($this->users->get('id'), "Uploaded the theme <b>{$contest}</b>", time());
						    		throw new \Exception("Theme uploaded");
						    	} else {
						    		throw new \Exception("Theme can't be uploaded");
						    	}
						    }
						} else {
							throw new \Exception("Can't read the file");
						}
					}
				} else if ($type == 'badge') {
					$this->supportedFormats = ['image/gif'];
					$rute = $this->config->select['CDN']['SWF']['DIR_RUTE'] . DS . $this->config->select['CDN']['SWF']['DIR_BADGES'] . DS;
					$flashTexts = $this->config->select['CDN']['SWF']['DIR_RUTE'] . DS . $this->config->select['CDN']['SWF']['FLASH_TEXTS'];
					$name = $this->protection->filter($_POST['name']);
					$badgeTitle = $this->protection->filter($_POST['title']);
					$badgeDesc = $this->protection->filter($_POST['description']);
					$imageSize = getimagesize($file['tmp_name']);
					if ($fileName == '.gif') {
					 	throw new \Exception("Invalid file name, please put a name to the file");
					} else if (empty($fileName) || empty($name)) {
						throw new \Exception("Complete the formulary");
					} elseif (!file_exists($flashTexts)) {
						throw new \Exception("Can't found External Flash Texts");
					} elseif (!file_exists($rute)) {
						throw new \Exception("Can't found badge directory");
					} elseif ($file['error']) {
						throw new \Exception("Invalid file, have errors");
					} else if (!in_array($file['type'], $this->supportedFormats)) {
						throw new \Exception("This file is not allowed");
					} else if ($file['size'] > ($max_size = 1 * MB)) {
						throw new \Exception("File size exceeds 1MB");
					} else if (strlen($name) < 2 || strlen($name) > 30) {
						throw new \Exception("Badge name must be less than 30 letters");
					} else if (!file_exists($rute)) {
						throw new \Exception("Badges rute doesn't exist");
					} else if ($imageSize[0] > 50 || $imageSize[1] > 50) {
						throw new \Exception("Badge size exceeds 50x50 pixels");
					} else {
						$upload = move_uploaded_file($file['tmp_name'], $rute . $name . '.gif');
						if ($upload) {
							$this->status = true;
							if (file_exists($flashTexts)) {
								if ($badgeTitle) {
									$flash = fopen($flashTexts, 'a');
									if ($flash) {
										fwrite($flash, "badge_name_{$name}={$badgeTitle}\n");								
									}
								}
								if ($badgeDesc) {
									$flash = fopen($flashTexts, 'a');
									if ($flash) {
										fwrite($flash, "badge_desc_{$name}={$badgeDesc}\n");								
									}
								}
							}
							throw new \Exception("Badge uploaded");
						} else {
							throw new \Exception("Badge can't be uploaded");
						}
					}
					
				} else if ($type == 'badgeZIP') {
					$this->supportedFormats = ['application/zip', 'application/octet-stream', 'application/x-zip-compressed'];
					$rute = $this->config->select['CDN']['SWF']['DIR_RUTE'] . DS . $this->config->select['CDN']['SWF']['DIR_BADGES'] . DS;
					if ($fileName == '.zip') {
					 	throw new \Exception("Invalid file name, please put a name to the file");
					} elseif (!file_exists($rute)) {
						throw new \Exception("Can't found badge directory");
					} else if (empty($fileName)) {
						throw new \Exception("Complete the formulary");
					} elseif ($file['error']) {
						throw new \Exception("Invalid file, have errors");
					} else if (!in_array($file['type'], $this->supportedFormats)) {
						throw new \Exception("This file is not allowed");
					} else if ($file['size'] > ($max_size = 50 * MB)) {
						throw new \Exception("File size exceeds 50MB");
					} else if (!file_exists($rute)) {
						throw new \Exception("Badges rute doesn't exist");
					} else {
						$zip = new \ZipArchive;
						$open = $zip->open($file['tmp_name']);
						if ($open) {
							$zipFiles = zip_open($file['tmp_name']);
							$files = array();
						    while ($zip_entry = zip_read($zipFiles)) {
						    	array_push($files, zip_entry_name($zip_entry));
						    }
						    $access = true;
						    if ($access) {
						    	$extract = $zip->extractTo($rute);
						    	if ($extract) {
									$this->status = true;
									throw new \Exception("Badges uploaded");
								} else {
									throw new \Exception("Badges can't be uploaded");
								}
						    } else {
						    	throw new \Exception("Invalid file on the ZIP");
						    }
						} else {
							throw new \Exception("Can't open the ZIP");
						}
					}
					
				} else if ($type == 'MPU') {
					$this->supportedFormats = ['image/gif', 'image/jpeg', 'image/png'];
					$rute = $this->config->select['CDN']['SWF']['DIR_RUTE'] . DS . $this->config->select['CDN']['SWF']['DIR_MPUS'] . DS;
					$flashTexts = $this->config->select['CDN']['SWF']['DIR_RUTE'] . DS . $this->config->select['CDN']['SWF']['FLASH_TEXTS'];
					$name = $this->protection->filter($_POST['name']);
					if ($fileName == '.gif' || $fileName == '.jpg' || $fileName == '.png' || $fileName == '.jpeg') {
					 	throw new \Exception("Invalid file name, please put a name to the file");
					} else if (empty($fileName) || empty($name)) {
						throw new \Exception("You must select a file");
					} elseif (!file_exists($rute)) {
						throw new \Exception("Can't found MPUS directory");
					} elseif ($file['error']) {
						throw new \Exception("Invalid file, have errors");
					} else if (!in_array($file['type'], $this->supportedFormats)) {
						throw new \Exception("This file is not allowed");
					} else if ($file['size'] > ($max_size = 10 * MB)) {
						throw new \Exception("File size exceeds 10MB");
					} else {
						$upload = move_uploaded_file($file['tmp_name'], $rute . $name . '.' . $ext);
						if ($upload) {
							$this->status = true;
							throw new \Exception("MPU uploaded");
						} else {
							throw new \Exception("MPU can't be uploaded");
						}
					}
					
				} else if ($type == 'MPUZIP') {
					$this->supportedFormats = ['application/zip', 'application/octet-stream', 'application/x-zip-compressed'];
					$rute = $this->config->select['CDN']['SWF']['DIR_RUTE'] . DS . $this->config->select['CDN']['SWF']['DIR_MPUS'] . DS;
					if ($fileName == '.zip') {
					 	throw new \Exception("Invalid file name, please put a name to the file");
					} elseif (!file_exists($rute)) {
						throw new \Exception("Can't found badge directory");
					} else if (empty($fileName)) {
						throw new \Exception("Complete the formulary");
					} elseif ($file['error']) {
						throw new \Exception("Invalid file, have errors");
					} else if (!in_array($file['type'], $this->supportedFormats)) {
						throw new \Exception("This file is not allowed");
					} else if ($file['size'] > ($max_size = 50 * MB)) {
						throw new \Exception("File size exceeds 50MB");
					} else if (!file_exists($rute)) {
						throw new \Exception("MPUS rute doesn't exist");
					} else {
						$zip = new \ZipArchive;
						$open = $zip->open($file['tmp_name']);
						if ($open) {
							$zipFiles = zip_open($file['tmp_name']);
							$files = array();
						    while ($zip_entry = zip_read($zipFiles)) {
						    	array_push($files, zip_entry_name($zip_entry));
						    }
						    $access = true;
						    if ($access) {
						    	$extract = $zip->extractTo($rute);
						    	if ($extract) {
									$this->status = true;
									throw new \Exception("MPUS uploaded");
								} else {
									throw new \Exception("MPUS can't be uploaded");
								}
						    } else {
						    	throw new \Exception("Invalid file on the ZIP");
						    }
						} else {
							throw new \Exception("Can't open the ZIP");
						}
					}
					
				}
			} catch (\Exception $e) {
				$this->reason = $e->getMessage();
			}
		}

		public function generateToken()
        {
            $characters = '0123456789abcdefghijklmnopqrstuvwxy';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $charactersLength; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }
	}

?>