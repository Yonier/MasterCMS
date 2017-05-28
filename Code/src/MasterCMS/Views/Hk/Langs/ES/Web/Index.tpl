<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-3 col-md-6 col-sm-6">
				<div class="card card-stats">
					<div class="card-header" data-background-color="orange">
						<i class="material-icons">people</i>
					</div>
					<div class="card-content">
						<p class="category">Usuarios registrados</p>
						<h3 class="title">{@users_registered}</h3>
					</div>
					<div class="card-footer">
						<div class="stats">
							<i class="material-icons">account_box</i> Trae m&aacute;s amigos a <b>{@name}</b>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-6 col-sm-6">
				<div class="card card-stats">
					<div class="card-header" data-background-color="green">
						<i class="material-icons">home</i>
					</div>
					<div class="card-content">
						<p class="category">Habitaciones creadas</p>
						<h3 class="title">{@created_rooms}</h3>
					</div>
					<div class="card-footer">
						<div class="stats">
							<i class="material-icons">people</i> 
							Con <b>{@room_users}</b> usuarios dentro
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-6 col-sm-6">
				<div class="card card-stats">
					<div class="card-header" data-background-color="red">
						<i class="material-icons">info_outline</i>
					</div>
					<div class="card-content">
						<p class="category">Usuarios baneados</p>
						<h3 class="title">{@baned_users}</h3>
					</div>
					<div class="card-footer">
						<div class="stats">
							<i class="material-icons">local_offer</i> <b>{@expired_bans}</b> han expirado
						</div>
					</div>
				</div>
			</div>

			<div class="col-lg-3 col-md-6 col-sm-6">
				<div class="card card-stats">
					<div class="card-header" data-background-color="blue">
						<i class="material-icons">new_releases</i>
					</div>
					<div class="card-content">
						<p class="category">Noticias registradas</p>
						<h3 class="title">{@created_news}</h3>
					</div>
					<div class="card-footer">
						<div class="stats">
							<i class="material-icons">update</i> <a href="{@url}/web/news">Ver noticias</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
		<div class="col-lg-6 col-md-12">
			<div class="card card-nav-tabs">
				<div class="card-header" data-background-color="purple">
					<div class="nav-tabs-navigation">
						<div class="nav-tabs-wrapper">
							<span class="nav-tabs-title">Tareas:</span>
							<ul class="nav nav-tabs" data-tabs="tabs">
								<li class="active">
									<a href="#messages" data-toggle="tab">
										<i class="material-icons">forum</i>
										Mensajes Staff
									<div class="ripple-container"></div></a>
								</li>
								<?php if (in_array($this->users->get('rank'), $this->hotel->getMaster('medium+'))) { ?>
								<li>
									<a href="#addMessage" data-toggle="tab">
										<i class="material-icons">add</i>
										Agregar Mensaje
									<div class="ripple-container"></div></a>
								</li>
								<?php } ?>
							</ul>
						</div>
					</div>
				</div>
				
				<div class="card-content">
					<div class="tab-content">
					<div id="forerror"></div>
						<div class="tab-pane active table-responsive" id="messages" style="max-height: 300px; overflow-y: auto;">
							<table class="table">
								<tbody id="messagesContainer">
									
								</tbody>
							</table>
							<div id="loader_live"></div>
						</div>
						<?php if (in_array($this->users->get('rank'), $this->hotel->getMaster('medium+'))) { ?>
						<div class="tab-pane" id="addMessage">
							<form action="" method="POST" id="addMessageFormulary">
				                <textarea name="message" class="tinytext" cols="30" rows="10">
				                	<p>Contenido de el mensaje para administradores de {@name}</p>
				                </textarea>
				                <button class="btn btn-raised btn-primary btn-block" type="submit" id="submitmessage"><i class="fa fa-paper-plane"></i> Enviar</button>
				            </form>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-6 col-md-12">
						<div class="card">
	                        <div class="card-header" data-background-color="green">
	                            <h4 class="title">Informaci&oacute;n de sesi&oacute;n</h4>
	                            <p class="category">Tus informaciones de session son:</p>
	                        </div>
	                        <div class="card-content table-responsive">
	                            <table class="table table-hover">
	                                <tbody>
	                                	<tr>
	                                    	<td><strong>Usuario:</strong></td>
	                                    	<td>{@user_username}</td>
	                                    </tr>
	                                    <tr>
	                                    	<td><strong>Rango:</strong></td>
	                                    	<td>{@rank} - {@user_rank}</td>
	                                    </tr>
	                                    <tr>
	                                    	<td><strong>Ultima sesi&oacute;n:</strong></td>
	                                    	<td>{@last_used}</td>
	                                    </tr>
	                                    <tr>
	                                    	<td><strong>IP:</strong></td>
	                                    	<td>{@ip}</td>
	                                    </tr>
	                                    <tr>
	                                    	<td><strong>Pais:</strong></td>
	                                    	<td><img src="{@hk_cdn}/img/flags/{@country_code_ip}.png" style="width: auto;"></td>
	                                    </tr>
	                                    <tr>
	                                    	<td><strong>IP de ultimo acceso:</strong></td>
	                                    	<td>{@last_ip}</td>
	                                    </tr>
	                                    <tr>
	                                    	<td><strong>Pais de ultimo acceso:</strong></td>
	                                    	<td><img src="{@hk_cdn}/img/flags/{@country_code_last}.png" style="width: auto;"></td>
	                                    </tr>
	                                </tbody>
	                            </table>
	                        </div>
	                    </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="{@hk_cdn}/js/forms/dashboardMessages.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
	    addMessageForm();    
	    updateMessages();
	    setInterval(updateMessages, 5000);
	});
</script>