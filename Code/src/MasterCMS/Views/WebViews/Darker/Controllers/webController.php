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

	use MasterCMS\Controllers\webController as principalController;

	use MasterCMS\Config\{Config, Connection};
	use MasterCMS\Models\{Template, Protection, Users, Sessions, Redirections, Facebook, Hotel, Mails};

	class webController extends principalController {

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
			// Heredar el constructor de el Controlador padre.
			// Inherit the constructor of the parent Controller.
			parent::__construct();

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
			$this->template->setParam('credits', number_format(9999999));
            $this->template->setParam('duckets', number_format(9999999));
            $this->template->setParam('diamonds', number_format($this->users->get('diamonds')));
		}

		public function colaborators()
		{
			if (in_array($this->users->get('rank'), $this->hotel->getMaster('max'))) {
				$this->template->setParam('title', 'Colaboradores');
				$this->template->addTemplate('Template' . DS . 'Header');
				$this->template->addTemplate();
				$this->template->addTemplate('Template' . DS . 'Footer');
			} else {
				parent::error404();
			}
		}

		public function team()
		{
			if (in_array($this->users->get('rank'), $this->hotel->getMaster('max'))) {
				parent::team();
			} else {
				parent::error404();
			}
		}

		public function client($room = false)
		{
			define('ADS', true);
			parent::client($room);
		}
		
	}

?>