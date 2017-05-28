<!--

    # Name: Template for iBoom (Responsive);
    # Version: 2.0;
    # Author: Yonier Espinosa (HabboAdictos1);

    # MasterCMS by Denzel Code (LxBlack)
    # PostData: Todo el que copie todo o parte de este software, debe dar créditos a su autor (Denzel Code);
    
-->
<!DOCTYPE html>
<html lang="es-ES">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="&#xA1;Visita el hotel virtual m&#xE1;s grande del mundo GRATIS! Conoce a gente nueva y haz muchos amigos, chatea con otros, crea tu avatar, dise&#xF1;a salas y mucho m&#xE1;s...">
    <meta name="Keywords" content="{@name}, {@name} Hotel, {@url},  {@name}, {@title}, {@name} - {@title}, nillus, ragezone, retro, keep it real, private server, free, credits, habbo hotel , virtual, world, social network, free, community, avatar, chat, online, teen, roleplaying, join, social, groups, forums, safe, play, games, online, friends, teens, rares, rare furni, collecting, create, collect, connect, furni, furniture, pets , room design, sharing, expression, badges, hangout, music, celebrity, celebrity visits, celebrities, mmo, mmorpg, massively multiplayer, BlockerCMS, BlockerCMS private, BlockCMS, BlockerCMS, v1, v2, v3, v4, v5, v6, {@name}, {@name} Hotel, {@name} Latino, {@name}-Hotel, Furnis gratis, Creditos gratis, gratis, chat, jugar, jugar, hablum, habbo artico, habbo hablum, habbo gratis, todo gratis, furnis gratis habbo, habbo holo, créditos gratis, habbolandia, habbopvp, habbo pvp, habbolatino, habbo latino, habboparaiso, habbo paraiso, habbo kekos, habbokekos, habbomundo, habbocorp, habboci, habbostorm, habbo fantasy, habbo fenix, habbo mundo, habbo lan, habbo hablum, habbo apk, habbo alfa, hkeko.com, hkeko.com, haddoz ,juego gratis de rol, juego de rol, rol, minecraft server, hlatinos, hlatinos.com, hlatinos.es, masterCMS, mastercms, master hotel, master private version, MasterCMS, Habbo, Habbo Hotel, Habbo Latino, Habbo-Hotel, Furnis gratis, Creditos gratis, gratis, chat, jugar, jugar, hartico, habbo artico, habbo hartico, habbo gratis, todo gratis, furnis gratis habbo, habbo holo, créditos gratis, habbolandia, habbopvp, habbo pvp, habbolatino, habbo latino, habboparaiso, habbo paraiso, habbo kekos, habbokekos, habbomundo, habbocorp, habboci, habbostorm, habbo fantasy, habbo fenix, habbo mundo, habbo lan, habbo hartico, habbo apk, habbo alfa, hartico.nl, hartico.us, habboartico.com, Habbo, Habbo Hotel, Habbo Latino, ,Habbo-Hotel, Habbo Club, HC gratis, Furnis gratis, Creditos gratis, gratis, chat, jugar, jugar Habbo, habbo hotel lu, habbo lu, habbolatino, habbo.lu, habbohotel.lu, yonier, habboadictos1, denzel code, lxblack, <?php echo $title; ?>">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="robots" content="index,follow,all">
    <meta name="author" content="{@theme_author}">
    <link rel="icon" type="image/png" href="{@master_cdn}/img/master.png" />
    <meta property="og:type" content="website">
    <meta property="og:title" content="{@name} tu diversión asegurada">
    <meta property="og:url" content="{@url}">
    <meta name="description" content="&#xA1;Visita el hotel virtual m&#xE1;s grande del mundo GRATIS! Conoce a gente nueva y haz muchos amigos, chatea con otros, crea tu avatar, dise&#xF1;a salas y mucho m&#xE1;s...">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{@name}">
    <meta property="og:title" content="{@name}">
    <meta property="og:description" content="&#xA1;Visita el hotel virtual m&#xE1;s grande del mundo GRATIS! Conoce a gente nueva y haz muchos amigos, chatea con otros, crea tu avatar, dise&#xF1;a salas y mucho m&#xE1;s...">
    <meta property="og:url" content="{@url}" habbo-head-url="content">
    <meta property="og:image" content="{@cdn}/Images/imgfbtwit.png">
    <meta property="og:image:height" content="628">
    <meta property="og:image:width" content="1200">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{@name}">
    <meta name="twitter:description" content="&#xA1;Visita el hotel virtual m&#xE1;s grande del mundo GRATIS! Conoce a gente nueva y haz muchos amigos, chatea con otros, crea tu avatar, dise&#xF1;a salas y mucho m&#xE1;s...">
    <meta name="twitter:image" content="{@cdn}/Images/imgfbtwit.png">
    <meta name="twitter:site" content="@{@twitter}">
    <meta itemprop="name" content="{@name}">
    <meta itemprop="description" content="&#xA1;Visita el hotel virtual m&#xE1;s grande del mundo GRATIS! Conoce a gente nueva y haz muchos amigos, chatea con otros, crea tu avatar, dise&#xF1;a salas y mucho m&#xE1;s...">
    <meta itemprop="image" content="{@cdn}/Images/imgfbtwit.png">
	<title>{@name} :: <?php echo $title; ?></title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="{@cdn}/CSS/bootstrap.min.css">
	<link rel="stylesheet" href="{@cdn}/CSS/jquery-ui.min.css">
	<link rel="stylesheet" href="{@cdn}/CSS/unslider.css">	
	<link rel="stylesheet" href="{@cdn}/CSS/alertify.min.css">
	<link rel="stylesheet" href="{@cdn}/CSS/General.css">
</head>
<body>
	<div id="error"></div>
	<div id="forerror"></div>
	<section id="Head">
		<header <?php if (!$this->users->getSession()) { echo 'id="noLogged"'; } else { echo 'id="Logged"'; } ?>>			
			<div class="container">
				<a href="/"><img src="<?php echo $logo; ?>" alt="" id="logo"></a>
				<?php if ($this->users->getSession()) { ?><div id="quickSection" class="hidden-sm-down"><?php if ($this->users->getSession() && in_array($this->users->get('rank'), $this->hotel->getMaster('all'))) { ?><a href="{@url}/hk">HouseKeeping</a> / <?php } ?><a href="{@url}/web/logout">Cerrar sesión</a></div><?php } ?>
				<button id="btn-menu" class="hidden-lg-up" data-toggle="collapse" data-target="#menu-list" aria-expanded="false"><i class="fa fa-bars" aria-hidden="true"></i></button>
				<span>
					<?php if (!$this->users->getSession()) { ?>
					<?php if ($this->hotel->getConfig('maintenance')) { ?>
						<h1>Mantenimiento</h1>
						<p>Volveremos en breve...</p>
					<?php } elseif ($this->request->getMethod() == 'register' && $this->request->getController() == 'web') { ?>
						<h1>Crea tu personaje</h1>
						<p>Sé ahora parte de la <strong>COMUNIDAD</strong></p>
					<?php } else { ?>
						<h1>Mundo conectado</h1>
						<p>En este momento hay <strong>{@onlines}</strong> {@name}s conectados</p>
					<?php }  } else { ?>
						<?php if ($this->request->getMethod() == 'profile' || $this->request->getMethod() == 'settings' || $this->request->getMethod() == 'community' || $this->request->getMethod() == 'top' || $this->request->getMethod() == 'team' || $this->request->getMethod() == 'colaborators' || $this->request->getMethod() == 'news' && $this->request->getController() == 'web') { ?><a href="{@url}/web/client" class="float-right hidden-sm-down"><div class="btn btn-success btn-lg btn-radius">Entrar al Hotel</div></a><?php } ?>
						<p><strong>{@onlines}</strong> {@name}s conectado(s)</p>
					<?php } ?>
				</span>
			</div>
		</header>
		<nav class="collapse" id="menu-list">
			<div class="container">
				<ul id="menu-left">
					<li><a href="/"><div id="menu-avatar" style="background-image:url({@habbo_img}{@look}&gesture=sml)"></div>{@username}</a></li>
				</ul>
				<ul id="menu-right">					
					<li class="active"><a href="/"><i class="fa fa-home" aria-hidden="true"></i>Inicio</a></li>
					<li><a href="{@url}/web/community"><i class="fa fa-users icon" aria-hidden="true"></i>Comunidad</a></li>
					<?php if ($this->users->getSession() && in_array($this->users->get('rank'), $this->hotel->getMaster('max'))) { ?><li><a href="{@url}/web/team"><i class="fa fa-star" aria-hidden="true"></i>Equipo</a></li><?php } ?>
					<li><a href="{@url}/web/news"><i class="fa fa-newspaper-o icon" aria-hidden="true"></i>Noticias</a></li>
					<?php if (!$this->users->getSession()) { ?><li><a href="{@url}/web/register"><i class="fa fa-user-plus" aria-hidden="true"></i>Regístrarme</a></li><?php } ?>					
					<?php if ($this->users->getSession() && in_array($this->users->get('rank'), $this->hotel->getMaster('all'))) { ?><li><a href="{@url}/hk" class="hidden-lg-up"><i class="fa fa-lock" aria-hidden="true"></i>HouseKeeping</a></li><?php } ?>
					<?php if ($this->users->getSession()) { ?><li><a href="{@url}/web/logout" class="hidden-lg-up"><i class="fa fa-power-off" aria-hidden="true"></i>Cerrar sesión</a></li><?php } ?>
				</ul>
			</div>
		</nav>
	</section>
	<div class="parse">
		<?php if ($this->users->getSession()) { ?>
		    <?php if ($this->request->getMethod() == 'team' || $this->request->getMethod() == 'colaborators' && $this->request->getController() == 'web'){ ?>
			<nav id="sub-menu">
				<div class="container">
					<ul>
						<li <?php if ($this->request->getMethod() == 'team' && $this->request->getController() == 'web') { echo 'id="selected"'; } ?>><a href="{@url}/web/team">Staff</a></li>
						<li <?php if ($this->request->getMethod() == 'colaborators' && $this->request->getController() == 'web') { echo 'id="selected"'; } ?>><a href="{@url}/web/colaborators">Colaboradores</a></li>
					</ul>
				</div>
			</nav>
			<?php } ?>
		    <?php if ($this->request->getMethod() == 'index' || $this->request->getMethod() == 'profile' || $this->request->getMethod() == 'settings' && $this->request->getController() == 'web'){ ?>
			<nav id="sub-menu">
				<div class="container">
					<ul>
						<li <?php if ($this->request->getMethod() == 'index' && $this->request->getController() == 'web') { echo 'id="selected"'; } ?>><a href="/">Inicio</a></li>
						<li <?php if ($this->request->getMethod() == 'profile' && $this->request->getController() == 'web') { echo 'id="selected"'; } ?>><a href="{@url}/web/profile">Mi Perfil</a></li>
						<li <?php if ($this->request->getMethod() == 'settings' && $this->request->getController() == 'web') { echo 'id="selected"'; } ?>><a href="{@url}/web/settings">Configuración</a></li>
					</ul>
				</div>
			</nav>
			<?php } ?>
			<?php if ($this->request->getMethod() == 'community' || $this->request->getMethod() == 'top' && $this->request->getController() == 'web'){ ?>
			<nav id="sub-menu">
				<div class="container">
					<ul>
						<li <?php if ($this->request->getMethod() == 'community' && $this->request->getController() == 'web') { echo 'id="selected"'; } ?>><a href="{@url}/web/community"">Comunidad</a></li>
						<li <?php if ($this->request->getMethod() == 'top' && $this->request->getController() == 'web') { echo 'id="selected"'; } ?>><a href="{@url}/web/top">Top {@name}s</a></li>
					</ul>
				</div>
			</nav>
		<?php } } ?>
		<section id="Ads">
			<div class="container">
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
				<!-- {@name} -->
				<ins class="adsbygoogle"
				     style="display:block"
				     data-ad-client="ca-pub-3358130948395009"
				     data-ad-slot="8447323170"
				     data-ad-format="auto"></ins>
				<script>
				(adsbygoogle = window.adsbygoogle || []).push({});
				</script>
			</div>
		</section>
	</div>
	