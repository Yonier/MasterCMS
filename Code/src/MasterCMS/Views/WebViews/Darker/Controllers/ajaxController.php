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
   
	namespace MasterCMS\Views\WebViews\Darker\Controllers;

	use MasterCMS\Config\{Config, Connection};
	use MasterCMS\Models\{Template, Protection, Users, Sessions, Redirections, Facebook, Hotel, Mails};

	class ajaxController {

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

		public function __construct()
		{	
			$this->template = new Template;
			$this->config = new Config;
			$this->protection = new Protection;
			$this->users = new Users;
			$this->sessions = new Sessions;
			$this->con = new Connection;
			$this->redirections = new Redirections;
			$this->facebook = new Facebook;
			$this->hotel = new Hotel;
			$this->mails = new Mails;
			$this->template->setEverything();
		}

		public function comments($new_id)
		{
			$query = $this->con->query("SELECT * FROM news_comments WHERE new_id = '{$new_id}' ORDER BY id DESC");
			if ($this->con->num_rows($query) > 0) {
				while ($select = mysqli_fetch_assoc($query)) {
					foreach ($select as $key => $value) {
						$this->template->setParam('comment_' . $key, $value);
					}
					$this->template->setParam('comment_ago', $this->hotel->getDate($select['timestamp']));
					$queryUser = $this->con->query("SELECT * FROM users WHERE id = '{$select['user_id']}'");
					if ($this->con->num_rows($queryUser) > 0) {
						$selectUser = mysqli_fetch_assoc($queryUser);
						foreach ($selectUser as $key => $value) {
							$this->template->setParam('user_' . $key, $value);
						}
					} else {
						$selectUser = mysqli_fetch_assoc($queryUser);
						foreach ($selectUser as $key => $value) {
							$this->template->setParam('user_' . $key, 'Not Found');
						}
					}
					$this->template->addTemplate('Ajax' . DS . 'Comments');
				}
			} else {
				$this->template->setParam('thing', 'comentarios');
				$this->template->addTemplate('Ajax' . DS . 'Nothing');
			}
		}
		
	}

?>