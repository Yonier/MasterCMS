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

	use MasterCMS\Controllers\formsController as principalController;

	use MasterCMS\Config\Config;
	use MasterCMS\Models\Template;
	use MasterCMS\Models\Protection;
	use MasterCMS\Models\Users;
	use MasterCMS\Models\Sessions;
	use MasterCMS\Config\Connection;
	use MasterCMS\Models\Redirections;
	use MasterCMS\Models\Facebook;
	use MasterCMS\Models\Hotel;
	use MasterCMS\Models\Mails;
	use MasterCMS\Views\WebViews\Darker\Langs\ES\Texts\Main as Text;

	class formsController extends principalController {

		private $template;
		private $config;
		private $protection;
		private $users;
		private $sessions;
		private $con;
		private $redirections;
		private $facebook;
		private $hotel;
		private $text;

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
			$this->text = new Text;
		}

		public function php($type, $add = false, $add2 = false)
		{
			parent::php($type, $add, $add2);
			if ($this->users->getSession()) {
				if ($type == 'comment') {
					$new_id = $this->protection->filter($this->sessions->get('session', 'new_id'));
					$comment = $this->protection->filter($_POST['comment']);
					$time = time();
					$error_start = $this->text->texts['cont']['error_start'];
					$error_end = $this->text->texts['cont']['error_end'];
					$queryLast = $this->con->query("SELECT * FROM news_comments WHERE new_id = '{$new_id}' ORDER BY id DESC");
					$selectLast = mysqli_fetch_assoc($queryLast);
					if (empty($comment)) {
						$error = "No dejes espacios en blanco";
					} elseif (empty($new_id)) {
						$error = "Debes elejir una noticia";
					} else if ($selectLast['user_id'] == $this->users->get('id')) {
						$error = "Debes esperar a que alguien comente para comentar de nuevo";
					} else {
						$comment = $this->protection->urlFilter($comment);
						$query = $this->con->query("INSERT INTO news_comments (user_id, new_id, comment, timestamp) VALUES ('{$this->users->get('id')}', '{$new_id}', '{$comment}', '{$time}')");
						if ($query) {
							$error_start = $this->text->texts['cont']['success_start'];
							$error = "Comentado realizado con exito";
							$error_start = $this->text->texts['cont']['success_start'];
						} else {
							$error = "Hubo un error en la base de datos";
						}
					}
					echo $error_start . $error . $error_end;
				}
			}
		}
	}

?>