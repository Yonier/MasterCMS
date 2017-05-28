<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-6 col-md-12">
				<div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title">Editar usuario {@users_username}</h4>
                        <p class="category">Edita el perfil de {@users_username}, completando el siguiente formulario:</p>
                    </div>
                    <div class="card-content table-responsive">
                    <div id="forerror"></div>
                        <form action="" method="POST" id="editUserFormulary">
							<div class="form-group label-floating">
			                    <label for="username" class="control-label"<?php if ($this->hotel->getMasterType() == 'min') { echo " disabled"; } ?>>Nombre de usuario</label>
			                    <input type="text" class="form-control" id="username" name="username" autocomplete="off" maxlength="15" value="{@users_username}">
			                    <span class="help-block">Escriba un nombre de usuario, ejemplo: <strong>Juan</strong></span>
			                </div>
			                <?php if ($this->hotel->getMasterType() == 'max' && in_array($this->users->get('username'), $this->hotel->getSuperUsers())) { ?>
			                <div class="form-group label-floating">
			                    <label for="password" class="control-label">Contrase&ntilde;a</label>
			                    <input type="password" class="form-control" id="password" name="password" autocomplete="off" maxlength="30">
			                    <span class="help-block">Escriba una contrase&ntilde;a, ejemplo: <strong>******</strong></span>
			                </div>
			                <?php } ?>
			                <div class="form-group label-floating">
			                    <label for="mail" class="control-label"<?php if ($this->hotel->getMasterType() == 'min') { echo " disabled"; } ?>>Correo electronico</label>
			                    <input type="email" class="form-control" id="mail" name="mail" autocomplete="off" value="{@users_mail}">
			                    <span class="help-block">Escriba un correo electronico, ejemplo: <strong>example@mail.com</strong></span>
			                </div>
			                <div class="form-group label-floating">
			                    <label for="motto" class="control-label">Misi&oacute;n</label>
			                    <input type="text" class="form-control" id="motto" name="motto" autocomplete="off" maxlength="50" value="{@users_motto}">
			                    <span class="help-block">Escriba una misi&oacute;n pra el usuario, ejemplo: <strong>Nuevo en {@name}</strong></span>
			                </div>
			                <div class="form-group label-floating">
			                    <label for="rank" class="control-label">Rango</label>
			                    <input type="text" class="form-control" id="rank" name="rank" autocomplete="off" maxlength="255" value="{@users_rank_name}" disabled>
			                </div>
			                <div class="form-group label-floating">
			                    <label for="credits" class="control-label">Cr&eacute;ditos</label>
			                    <input type="number" class="form-control" id="credits" name="credits" autocomplete="off" maxlength="255" value="{@users_credits}">
			                    <span class="help-block">Escriba cr&eacute;ditos para el usuario, ejemplo: <strong>100</strong></span>
			                </div>
			                <div class="form-group label-floating">
			                    <label for="duckets" class="control-label">Duckets</label>
			                    <input type="number" class="form-control" id="duckets" name="duckets" autocomplete="off" maxlength="255" value="{@users_activity_points}">
			                    <span class="help-block">Escriba duckets para el usuario, ejemplo: <strong>100</strong></span>
			                </div>
			                <div class="form-group label-floating">
			                    <label for="diamonds" class="control-label">Diamantes</label>
			                    <input type="number" class="form-control" id="diamonds" name="diamonds" autocomplete="off" maxlength="255" value="{@users_vip_points}">
			                    <span class="help-block">Escriba diamantes para el usuario, ejemplo: <strong>100</strong></span>
			                </div>
			                <div class="form-group label-floating">
			                    <label for="motto" class="control-label">Genero</label>
			                    <div class="form-control" disabled>
			                    	<?php if ($users_gender == 'M') { echo "Masculino"; } else { echo "Femenino"; } ?>
			                    </div>
			                </div>
			                <div class="form-group label-floating">
			                    <label for="motto" class="control-label">Estado</label>
			                    <div class="form-control" disabled>
			                    	<img src="{@hk_cdn}/img/{@users_status}.gif" style="width: 50px; height: 16px;">
			                    </div>
			                </div>
			                <div class="form-group label-floating">
			                    <label for="ip_reg" class="control-label">IP de registro</label>
			                    <input type="text" class="form-control" id="ip_reg" name="ip_reg" autocomplete="off" maxlength="255" value="{@users_ip_reg}" disabled>
			                </div>
			                <div class="form-group label-floating">
			                    <label for="motto" class="control-label">Pais</label>
			                    <div class="form-control" disabled>
			                    	<img src="{@hk_cdn}/img/flags/{@users_country_reg}.png" style="width: 24px; height: 24px;">
			                    </div>
			                </div>
			                <div class="form-group label-floating">
			                    <label for="ip_last" class="control-label">IP de ultima sesi&oacute;n</label>
			                    <input type="text" class="form-control" id="ip_last" name="ip_last" autocomplete="off" maxlength="255" value="{@users_ip_last}" disabled>
			                </div>
			                <div class="form-group label-floating">
			                    <label for="motto" class="control-label">Pais</label>
			                    <div class="form-control" disabled>
			                    	<img src="{@hk_cdn}/img/flags/{@users_country}.png" style="width: 24px; height: 24px;">
			                    </div>
			                </div>
			                <button class="btn btn-primary btn-block" type="submit" id="editUser"><i class="fa fa-paper-plane"></i> Editar usuario</button>
			            </form>	
                    </div>
                </div>
			</div>
			<div class="col-lg-6 col-md-12">
                <div class="card card-nav-tabs">
	                <div class="card-header" data-background-color="purple">
	                    <div class="nav-tabs-navigation">
	                        <div class="nav-tabs-wrapper">
	                            <span class="nav-tabs-title">Acciones:</span>
	                            <ul class="nav nav-tabs" data-tabs="tabs">
	                                <li class="active">
	                                    <a href="#editUser" data-toggle="tab">
	                                        <i class="material-icons">build</i>
	                                        Editar usuario
	                                    <div class="ripple-container"></div></a>
	                                </li>
	                            </ul>
	                        </div>
	                    </div>
	                </div>
	                <div class="card-content">
	                    <div class="tab-content">
	                        <div class="active tab-pane" id="editUser">
	                            <h4>Editar usuario</h4>
	                            <form action="" method="POST" id="editUserSearchFormulary">
		                            <div class="form-group label-floating">
					                    <label for="usernameEdit" class="control-label">Nombre de usuario</label>
					                    <input type="search" class="form-control" id="usernameEdit" name="username" autocomplete="off">
					                    <span class="help-block">Escribe un nombre de usuario, ejemplo: <strong>Juan</strong></span>
					                </div>
					                <button class="btn btn-raised btn-primary btn-block" type="submit" id="editUserSearch"><i class="fa fa-paper-plane"></i> Buscar</button>
					            </form>
								<h5>Resultados</h5>
				                <div id="listUsers">Aun no has realizado una busqueda</div>
	                        </div>
	                    </div>
	                </div>
                </div>
            </div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="{@hk_cdn}/js/forms/dashboardUsers.js"></script>
<script type="text/javascript">
	editUserForm();
	editUserSearchForm();
</script>