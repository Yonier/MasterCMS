<div class="content">
	<div class="container-fluid">
		<div class="row">
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
	                                <?php if (in_array($this->users->get('rank'), $this->hotel->getMaster('max'))) { ?>
	                                <li>
	                                    <a href="#syncAcco" data-toggle="tab">
	                                        <i class="material-icons">sync</i>
	                                        Sincronizar
	                                    <div class="ripple-container"></div></a>
	                                </li>
	                                <?php } ?>
	                                <?php if (in_array($this->users->get('rank'), $this->hotel->getMaster('medium+'))) { ?>
	                                <li>
	                                    <a href="#deleteUser" data-toggle="tab">
	                                        <i class="material-icons">delete</i>
	                                        Eliminar usuario
	                                    <div class="ripple-container"></div></a>
	                                </li>
	                                <?php } ?>
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
	                        <?php if (in_array($this->users->get('rank'), $this->hotel->getMaster('medium+'))) { ?>
	                        <div class="tab-pane" id="deleteUser">
	                            <h4>Eliminar usuario</h4>
	                            <div id="forerror"></div>
	                            <form action="" method="POST" id="deleteUserFormulary">
		                            <div class="form-group label-floating">
					                    <label for="usernameDelete" class="control-label">Nombre de usuario</label>
					                    <input type="search" class="form-control" id="usernameDelete" name="username" autocomplete="off">
					                    <span class="help-block">Escribe un nombre de usuario, ejemplo: <strong>Juan</strong></span>
					                </div>
					                <div class="checkbox">
                                      <label>
                                        <input type="checkbox" name="consequence" value="1"> Acepto las consecuencias de eliminar un usuario
                                      </label>
                                    </div>
					                <button class="btn btn-raised btn-primary btn-block" type="submit" id="deleteUser"><i class="fa fa-paper-plane"></i> Eliminar</button>
					            </form>
	                        </div>
	                        <?php } ?>
							<?php if (in_array($this->users->get('rank'), $this->hotel->getMaster('max'))) { ?>
	                        <div class="tab-pane" id="syncAcco">
	                            <h4>Sincronizar con cuentas</h4>
	                            <div id="forerror2"></div>
	                            <form action="" method="POST" id="syncAccountFormulary">
		                            <div class="form-group label-floating">
					                    <label for="usernameSync" class="control-label">Nombre de usuario</label>
					                    <input type="search" class="form-control" id="usernameSync" name="username" autocomplete="off">
					                    <span class="help-block">Escribe un nombre de usuario, ejemplo: <strong>Juan</strong></span>
					                </div>
					                <button class="btn btn-raised btn-primary btn-block" type="submit" id="syncAccount"><i class="fa fa-paper-plane"></i> Sincronizar</button>
					            </form>
	                        </div>
	                        <?php } ?>
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
	$(document).ready(function() {
		editUserSearchForm();
		syncAccountForm();
		deleteUserForm();
	});
</script>