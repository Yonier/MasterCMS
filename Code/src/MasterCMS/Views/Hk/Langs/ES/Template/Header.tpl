<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="{@hk_cdn}/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="{@master_cdn}/img/master.png" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title><?php echo $title; ?> - Housekeeping {@name}</title>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <link href="{@hk_cdn}/css/bootstrap.min.css" rel="stylesheet" />
    <link href="{@hk_cdn}/css/material-dashboard.css" rel="stylesheet"/>
    <link href="{@hk_cdn}/css/demo.css" rel="stylesheet" />
    <link rel="stylesheet" href="{@hk_cdn}/css/font-awesome.css">
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>
    <script type="text/javascript" src="{@hk_cdn}/js/library/jquery.js"></script>
    <script type="text/javascript" src="{@hk_cdn}/js/library/jquery-ui.js"></script>
    <script type="text/javascript" src="{@hk_cdn}/tinymce/js/tinymce/tinymce.min.js"></script>
    <script src="{@hk_cdn}/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="{@hk_cdn}/js/material.min.js" type="text/javascript"></script>
	<script src="{@hk_cdn}/js/chartist.min.js"></script>
	<script src="{@hk_cdn}/js/bootstrap-notify.js"></script>
	<script src="{@hk_cdn}/js/material-dashboard.js"></script>
	<script src="{@hk_cdn}/js/demo.js"></script>
    <script>
    	$(document).ready(function() {
    		tinymce.init({
			  selector: '.tinytext',
			  menubar: false,
			  plugins: [
			    'advlist autolink lists link image charmap print preview anchor',
			    'searchreplace visualblocks code fullscreen',
			    'insertdatetime media table contextmenu paste code'
			  ],
			  toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image'
			});
    	});
    </script>
</head>

<body>
<noscript>
    <div id="nojs">
        <div class="container">
            <div class="row">
                <div class="col-md-12" id="nojs-cont">
                    <div id="nojs-title"><i class="fa fa-exclamation-circle"></i>&nbsp;Activa Javascript</div>
                    <div id="nojs-description">Para poner continuar y disfrutar de todas las funciones completas de <b>{@name}</b> debe habilitar el Javascript dentro de el sitio web, valla a la <b>configuraci&oacute;n</b> de su navegador y active el Javascript dentro de los sitios web para poder utilizar {@name}, tambien si su navegador es demaciado antiguo, actualizelo para evitar fallas en el sitio web.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style type="text/css">
        #nojs {
            background: #3f51b5;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            z-index: 100000;
            color: #FFF;
        }

        #nojs-title {
            font-size: 30px;
            text-transform: uppercase;
            text-shadow: 1px 1px rgba(0,0,0,0.4);
            margin-top: 15%;
            padding: 10px 15px;
            background: #F44336;
            border-top-left-radius: 4px;
            border-top-right-radius: 4px;
        }

        #nojs-cont {
            font-size: 18px;
        }

        #nojs-description {
            background: rgba(0, 0, 0, 0.5);
            padding: 10px 15px;
        }

        @media screen and (max-width: 900px) {
            #nojs-title {
                font-size: 30px;
            }

            #nojs-cont {
                font-size: 18px;
            }
        }
    </style>    
</noscript>
	<div class="wrapper">

	    <div class="sidebar" data-color="purple" data-image="{@hk_cdn}/img/sidebar-1.jpg">
			<div class="logo">
				<a href="{@url}/hk" class="simple-text">
					<?php if ($hk) { ?>
						HOUSEKEEPING
					<?php } else if ($client) { ?>
						CLIENT
					<?php } ?>
				</a>
			</div>
			
			<?php if ($client) { ?>
			<div class="sidebar-wrapper" style="overflow-x: hidden;">
	            <ul class="nav">
					<li>
	                    <a href="{@url}/hk">
	                        <i class="material-icons">dashboard</i>
	                        <p>Entrar a el HK</p>
	                    </a>
	                </li>
	                <li>
	                    <a href="{@url}">
	                        <i class="material-icons">label outline</i>
	                        <p>Salir</p>
	                    </a>
	                </li>
	            </ul>
	    	</div>
			<?php } else if ($hk) { ?>
				<?php if ($this->sessions->get('session', 'pin')) { ?>
			    	<div class="sidebar-wrapper" style="overflow-x: hidden;">
			            <ul class="nav">
			                <li<?php if ($this->request->getController() == 'hk' && $this->request->getMethod() == 'index') { echo ' class="active"'; } ?>>
			                    <a href="{@url}/hk">
			                        <i class="material-icons">dashboard</i>
			                        <p>Panel</p>
			                    </a>
			                </li>
			                <li class="nav-divider"></li>
			                <!-- WEB -->
			                <li<?php if ($this->request->getController() == 'hk' && $this->request->getMethod() == 'web') { echo ' class="active"'; } ?> style="width: 150%;">
								<a style="border-radius: 0;">
									<i class="material-icons">web</i>
			                        <p>Administraci&oacute;n Web</p>
								</a>
							</li>
							<li<?php if ($this->request->getController() == 'hk' && $this->request->getMethod() == 'web' && $this->request->getArgument()[0] == 'ranks') { echo ' class="active"'; } ?>>
			                    <a href="{@url}/hk/web/ranks">
			                        <i class="material-icons">people</i>
			                        <p>Rangos</p>
			                    </a>
			                </li>
			                <li<?php if ($this->request->getController() == 'hk' && $this->request->getMethod() == 'web' && $this->request->getArgument()[0] == 'bans') { echo ' class="active"'; } ?>>
			                    <a href="{@url}/hk/web/bans">
			                        <i class="material-icons">remove_circle_outline</i>
			                        <p>Baneos</p>
			                    </a>
			                </li>
			                <li<?php if ($this->request->getController() == 'hk' && $this->request->getMethod() == 'web' && $this->request->getArgument()[0] == 'news') { echo ' class="active"'; } ?>>
			                    <a href="{@url}/hk/web/news">
			                        <i class="material-icons">new_releases</i>
			                        <p>Noticias</p>
			                    </a>
			                </li>
			                <li<?php if ($this->request->getController() == 'hk' && $this->request->getMethod() == 'web' && $this->request->getArgument()[0] == 'users') { echo ' class="active"'; } ?>>
			                    <a href="{@url}/hk/web/users">
			                        <i class="material-icons">account_circle</i>
			                        <p>Usuarios</p>
			                    </a>
			                </li>
		            		<?php if ($this->hotel->getMasterType() == 'max') { ?>
		            		<li<?php if ($this->request->getController() == 'hk' && $this->request->getMethod() == 'web' && $this->request->getArgument()[0] == 'cms') { echo ' class="active"'; } ?>>
			                    <a href="{@url}/hk/web/cms">
			                        <i class="material-icons">extension</i>
			                        <p>Ajustes del CMS</p>
			                    </a>
			                </li>
		            		<?php } ?>
		            		<?php if ($this->hotel->getMasterType() == 'max' && in_array($this->users->get('username'), $this->hotel->getSuperUsers())) { ?>
		            		<li<?php if ($this->request->getController() == 'hk' && $this->request->getMethod() == 'web' && $this->request->getArgument()[0] == 'main') { echo ' class="active"'; } ?>>
			                    <a href="{@url}/hk/web/main">
			                        <i class="material-icons">code</i>
			                        <p>MasterCMS Settings</p>
			                    </a>
			                </li>
		            		<?php } ?>
		            		<?php if ($this->hotel->getMasterType() == 'max') { ?>
		            		<li<?php if ($this->request->getController() == 'hk' && $this->request->getMethod() == 'web' && $this->request->getArgument()[0] == 'logs') { echo ' class="active"'; } ?>>
			                    <a href="{@url}/hk/web/logs">
			                        <i class="material-icons">clear_all</i>
			                        <p>Logs</p>
			                    </a>
			                </li>
		            		<?php } ?>
			                <li class="nav-divider"></li>
			                <!-- GAME -->
			                <li<?php if ($this->request->getController() == 'hk' && $this->request->getMethod() == 'game') { echo ' class="active"'; } ?> style="width: 150%;">
								<a style="border-radius: 0;">
									<i class="material-icons">build</i>
			                        <p>Administraci&oacute;n del Juego</p>
								</a>
							</li>
							<?php if (in_array($this->users->get('rank'), $this->hotel->getMaster('medium+'))) { ?>
							<li<?php if ($this->request->getController() == 'hk' && $this->request->getMethod() == 'game' && $this->request->getArgument()[0] == 'badges') { echo ' class="active"'; } ?>>
			                    <a href="{@url}/hk/game/badges">
			                        <i class="material-icons">stars</i>
			                        <p>Placas</p>
			                    </a>
			                </li>
			                <li<?php if ($this->request->getController() == 'hk' && $this->request->getMethod() == 'game' && $this->request->getArgument()[0] == 'mpu') { echo ' class="active"'; } ?>>
			                    <a href="{@url}/hk/game/mpu">
			                        <i class="material-icons">announcement</i>
			                        <p>MPUS</p>
			                    </a>
			                </li>
			                <?php } ?>
			                <?php if (in_array($this->users->get('rank'), $this->hotel->getMaster('max'))) { ?>
							<li<?php if ($this->request->getController() == 'hk' && $this->request->getMethod() == 'game' && $this->request->getArgument()[0] == 'logs') { echo ' class="active"'; } ?>>
			                    <a href="{@url}/hk/game/logs">
			                        <i class="material-icons">clear_all</i>
			                        <p>Logs</p>
			                    </a>
			                </li>
			                <?php } ?>
			                <li class="nav-divider"></li>
							<li>
			                    <a href="{@url}/web/client">
			                        <i class="material-icons">videogame_asset</i>
			                        <p>Entrar a el hotel</p>
			                    </a>
			                </li>
			                <li>
			                    <a href="{@url}/hk/logout">
			                        <i class="material-icons">label outline</i>
			                        <p>Salir</p>
			                    </a>
			                </li>
			            </ul>
			    	</div>
			    	<?php } else { ?>
			    	<div class="sidebar-wrapper" style="overflow-x: hidden;">
			            <ul class="nav">
			                <li<?php if ($this->request->getController() == 'hk' && $this->request->getMethod() == 'index') { echo ' class="active"'; } ?>>
			                    <a href="{@url}/hk">
			                        <i class="material-icons">dashboard</i>
			                        <p>Panel</p>
			                    </a>
			                </li>
			                <li class="nav-divider"></li>
							<li>
			                    <a href="{@url}/web/client">
			                        <i class="material-icons">videogame_asset</i>
			                        <p>Entrar a el hotel</p>
			                    </a>
			                </li>
			                <li>
			                    <a href="{@url}">
			                        <i class="material-icons">label outline</i>
			                        <p>Salir</p>
			                    </a>
			                </li>
			            </ul>
			    	</div>
		    	<?php } ?>
			<?php } ?>
	    </div>

	    <div class="main-panel">
			<nav class="navbar navbar-transparent navbar-absolute">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="#">{@name}</a>
					</div>
					<div class="collapse navbar-collapse">
						<!-- <ul class="nav navbar-nav navbar-right">
							<li>
								<a href="#pablo" class="dropdown-toggle" data-toggle="dropdown">
									<i class="material-icons">dashboard</i>
									<p class="hidden-lg hidden-md">Dashboard</p>
								</a>
							</li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="material-icons">notifications</i>
									<span class="notification">5</span>
									<p class="hidden-lg hidden-md">Notifications</p>
								</a>
								<ul class="dropdown-menu">
									<li><a href="#">Mike John responded to your email</a></li>
									<li><a href="#">You have 5 new tasks</a></li>
									<li><a href="#">You're now friend with Andrew</a></li>
									<li><a href="#">Another Notification</a></li>
									<li><a href="#">Another One</a></li>
								</ul>
							</li>
							<li>
								<a href="#pablo" class="dropdown-toggle" data-toggle="dropdown">
	 							   <i class="material-icons">person</i>
	 							   <p class="hidden-lg hidden-md">Profile</p>
		 						</a>
							</li>
						</ul> -->

						<!-- <form class="navbar-form navbar-right" role="search">
							<div class="form-group  is-empty">
								<input type="text" class="form-control" placeholder="Search">
								<span class="material-input"></span>
							</div>
							<button type="submit" class="btn btn-white btn-round btn-just-icon">
								<i class="material-icons">search</i><div class="ripple-container"></div>
							</button>
						</form> -->
					</div>
				</div>
			</nav>
