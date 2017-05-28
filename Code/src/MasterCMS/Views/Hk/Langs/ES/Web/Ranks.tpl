<div class="content">
	<div class="container-fluid">
		<div class="row">
		<div class="col-lg-6 col-md-12">
			<div class="card card-nav-tabs">
				<div class="card-header" data-background-color="purple">
					<div class="nav-tabs-navigation">
						<div class="nav-tabs-wrapper">
							<span class="nav-tabs-title">Tareas:</span>
							<ul class="nav nav-tabs" data-tabs="tabs">
								<?php if (in_array($this->users->get('rank'), $this->hotel->getMaster('medium+'))) { ?>
								<li class="active">
									<a href="#giveRank" data-toggle="tab">
										<i class="material-icons">card_giftcard</i>
										Dar rangos
									<div class="ripple-container"></div></a>
								</li>
								<?php } if (in_array($this->users->get('rank'), $this->hotel->getMaster('max'))) { ?>
								<li>
									<a href="#addRank" data-toggle="tab">
										<i class="material-icons">add</i>
										Agregar rangos
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
						<div class="active tab-pane" id="giveRank">
							<form action="" method="POST" id="addUserFormulary">
								<div class="form-group label-floating">
				                    <label for="username" class="control-label">Nombre de usuario</label>
				                    <input type="text" class="form-control" id="username" name="username" autocomplete="off" maxlength="25" required="">
				                    <span class="help-block">Escriba el nombre de usuario de la persona la cual le dara rango, ejemplo: <strong>Juan</strong></span>
				                </div>
				                <div class="form-group label-floating">
				                    <select class="form-control" id="rank" name="rank" required="">
				                    	<option selected="" disabled="" value="0">Seleccione un rango</option>
				                    	<?php 	
				                    		if (in_array($this->users->get('rank'), $this->hotel->getMaster('max'))) {
				                    			$query = $this->con->query("SELECT * FROM ranks ORDER BY id DESC");
				                    			if ($this->con->num_rows($query) == 0) {
				                    				echo "<option value=\"0\" disabled>No hay rangos disponibles</option>";
				                    			}
				                    			while ($select = mysqli_fetch_assoc($query)) {
			                    					if (in_array($select['id'], $this->hotel->getMaster('medium-')) || in_array($select['id'], $this->hotel->getMaster('max')) && $this->users->get('rank') > $select['id'] || !in_array($select['id'], $this->hotel->getMaster('all'))) {
				                    					if ($select['id'] != $this->users->get('rank')) {
				                    						$type = $this->hotel->getMasterType($select['id']);
				                    						if ($type == 'min') {
				                    							$type = 'Minimo';
				                    						} else if ($type == 'medium') {
				                    							$type = 'Medio';
				                    						} else if ($type == 'max') {
				                    							$type = 'Maximo';
				                    						} else {
				                    							$type = 'Ninguno';
				                    						}
				                    						if (!empty($select['name'])) {
					                    						echo "<option value=\"{$select['id']}\">{$select['name']} - {$type}</option>";
					                    					} else {
					                    						echo "<option value=\"{$select['id']}\">Sin nombre - {$type}</option>";
					                    					}
				                    					}
				                    				}
				                    			}
				                    		} else {
				                    			if (in_array($this->users->get('rank'), $this->hotel->getMaster('medium'))) {
				                    				$masterEnd = $this->hotel->getMaster('medium-');
					                    			$end = end($masterEnd);
					                    			$query = $this->con->query("SELECT * FROM ranks WHERE id < '{$end}' ORDER BY id DESC");

					                    			if ($this->con->num_rows($query) == 0) {
					                    				echo "<option value=\"0\" disabled>No hay rangos disponibles</option>";
					                    			}

					                    			while ($select = mysqli_fetch_assoc($query)) {
				                    					if (in_array($select['id'], $this->hotel->getMaster('medium-')) || in_array($select['id'], $this->hotel->getMaster('max')) && $this->users->get('rank') > $select['id'] || !in_array($select['id'], $this->hotel->getMaster('all'))) {
					                    					if ($select['id'] != $this->users->get('rank')) {
					                    						$type = $this->hotel->getMasterType($select['id']);
					                    						if ($type == 'min') {
					                    							$type = 'Minimo';
					                    						} else if ($type == 'medium') {
					                    							$type = 'Medio';
					                    						} else if ($type == 'max') {
					                    							$type = 'Maximo';
					                    						} else {
					                    							$type = 'Ninguno';
					                    						}
					                    						if (!empty($select['name'])) {
						                    						echo "<option value=\"{$select['id']}\">{$select['name']} - {$type}</option>";
						                    					} else {
						                    						echo "<option value=\"{$select['id']}\">Sin nombre - {$type}</option>";
						                    					}
					                    					}
					                    				}
					                    			}
				                    			}
				                    		}

				                    	?>
				                    </select>
				                    <span class="help-block">Seleccione el rango que quiere dar, ejemplo: <strong>Administrador</strong></span>
				                </div>
				                <div class="form-group label-floating">
				                    <label for="work" class="control-label">Tarea de el Staff</label>
				                    <input type="text" class="form-control" id="work" name="work" required="">
				                    <span class="help-block">Escriba la tarea de el nuevo integrante Staff, ejemplo: <strong>Encargado de publicidad</strong></span>
				                </div>
				                <div class="form-group">
					                <label class="col-md-2 control-label">Tipo</label>
					                  <div class="radio radio-primary">
					                    <label>
					                      <input type="radio" name="type" id="type" value="0" checked=""><span class="circle"></span><span class="check"></span>
					                      Visible
					                    </label>
					                  </div>

					                  <div class="radio radio-primary">
					                    <label>
					                      <input type="radio" name="type" id="type2" value="1"><span class="circle"></span><span class="check"></span>
					                      Oculto
					                    </label>
					                  </div>
					              </div>
				                <div class="form-group label-floating">
				                    <label for="pin" class="control-label">C&oacute;digo de seguridad para Housekeeping (opcional)</label>
				                    <input type="password" class="form-control" id="pin" name="pin" autocomplete="off" maxlength="30">
				                    <span class="help-block">Dejelo en <b>blanco</b> para dejar que el staff personalize su c&oacute;digo de seguridad</span>
				                </div>
				                <div class="form-group label-floating">
				                    <label for="pin" class="control-label">C&oacute;digo de seguridad para juego (opcional)</label>
				                    <input type="password" class="form-control" id="pin" name="pin" autocomplete="off" maxlength="30">
				                    <span class="help-block">Dejelo en <b>blanco</b> para dejar que el staff personalize su c&oacute;digo de seguridad</span>
				                </div>
				                <button class="btn btn-primary btn-block" type="submit" id="submitUserRank"><i class="fa fa-paper-plane"></i> Dar Rango</button>
				            </form>	
						</div>
						<?php if (in_array($this->users->get('rank'), $this->hotel->getMaster('max'))) { ?>
						<div class="tab-pane" id="addRank">
							<form action="" method="POST" id="addRankFormulary">
								<div class="form-group label-floating">
				                    <label for="id" class="control-label">ID (opcional)</label>
				                    <input type="number" class="form-control" id="id" name="id" autocomplete="off" maxlength="11">
				                    <span class="help-block">Escriba un n&uacute;mero de identificaci&oacute;n para el rango, ejemplo: <strong><?php

				                    	$query = $this->con->query("SELECT * FROM ranks ORDER BY id DESC");
				                    	$select = mysqli_fetch_assoc($query);

				                    	if (!$this->con->num_rows($query)) {
				                    		$select['id'] = 1;
				                    	}

				                    	echo $select['id'] + 1;

				                    ?></strong></span>
				                </div>
				                <div class="form-group label-floating">
				                    <label for="name" class="control-label">Nombre de rango</label>
				                    <input type="text" class="form-control" id="name" name="name" autocomplete="off" maxlength="50">
				                    <span class="help-block">Escriba el nombre de el rango, ejemplo: <strong>Administrador</strong></span>
				                </div>
				                <div class="form-group">
					                <label class="col-md-2 control-label">Visibilidad</label>
					                  <div class="radio radio-primary">
					                    <label>
					                      <input type="radio" name="visibility" id="visibility" value="yes" checked=""><span class="circle"></span><span class="check"></span>
					                      Visible
					                    </label>
					                  </div>
					                  <div class="radio radio-primary">
					                    <label>
					                      <input type="radio" name="visibility" id="visibility2" value="no"><span class="circle"></span><span class="check"></span>
					                      Oculto
					                    </label>
					                  </div>
					              </div>
				                <div class="form-group label-floating">
				                    <select name="type" id="type" class="form-control">
				                    	<option value="0" selected="" disabled="">Tipo de rango</option>
				                    	<?php if (in_array($this->users->get('rank'), $this->hotel->getMaster('medium'))) { ?>
				                    	<option value="nothing">Ninguno</option>
				                    	<option value="min">Minimo</option>
				                    	<option value="medium">Medio</option>
				                    	<?php } ?>
				                    	<?php if (in_array($this->users->get('rank'), $this->hotel->getMaster('max'))) { ?>
				                    	<option value="nothing">Ninguno</option>
				                    	<option value="min">Minimo</option>
				                    	<option value="medium">Medio</option>
				                    	<option value="max">Maximo</option>
				                    	<?php } ?>
				                    </select>
				                    <span class="help-block">Seleccione el tipo de rango, ejemplo: <strong>Minimo</strong></span>
				                </div>
				                <div class="form-group label-floating">
				                    <label for="badge" class="control-label">Placa</label>
				                    <input type="text" class="form-control" id="badge" name="badge" autocomplete="off" maxlength="20">
				                    <span class="help-block">Escriba el nombre de la placa para el rango, ejemplo: <strong>ADM</strong></span>
				                </div>
				                <div class="form-group label-floating">
				                    <label for="color" class="control-label">Color</label>
				                    <input type="color" class="form-control" id="color" name="color" autocomplete="off" value="#FFFFFF">
				                    <span class="help-block">Seleccione un color para el rango, ejemplo: <strong>#FFFFFF</strong></span>
				                </div>
				                <button class="btn btn-primary btn-block" type="submit" id="submitRank"><i class="fa fa-paper-plane"></i> Agregar Rango</button>
				            </form>	
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-6 col-md-12">
						<div class="card">
	                        <div class="card-header" data-background-color="purple">
	                            <h4 class="title">Lista de Staffs</h4>
	                            <p class="category">Los miembros actuales del equipo administrativo de {@name} son:</p>
	                        </div>
	                        <div class="card-content table-responsive">
		                        <div style="max-height: 300px; overflow-y: auto;">
		                        	<table class="table table-hover">
										<thead class="text-primary">
	                                        <th>ID</th>
	                                    	<th>Usuario</th>
	                                    	<th>Rango</th>
	                                    	<th>Tipo</th>
	                                    	<th>Pais</th>
	                                    	<th>Estado</th>
	                                    	<th>IP</th>
	                                    	<th>Acciones</th>
	                                    </thead>
		                                <tbody id="usersContainer">
		                                	
		                                </tbody>
		                            </table>
		                            <div id="loader_live1" style="margin-top: 5px;"></div>
		                        </div>
	                        </div>
	                    </div>

	                    <div class="card">
	                        <div class="card-header" data-background-color="purple">
	                            <h4 class="title">Lista de Rangos</h4>
	                            <p class="category">Los rangos oficiales de {@name} son:</p>
	                        </div>
	                        <div class="card-content table-responsive" style="max-height: 300px; overflow-y: auto;">
	                            <div style="max-height: 250px; overflow-y: auto;">
		                        	<table class="table table-hover">
										<thead class="text-primary">
	                                        <th>ID</th>
	                                    	<th>Nombre</th>
	                                    	<th>Tipo</th>
	                                    	<th>Color</th>
	                                    	<th>Placa</th>
	                                    	<th>Visibilidad</th>
	                                    	<th>Acciones</th>
	                                    </thead>
		                                <tbody id="ranksContainer">
		                                	
		                                </tbody>
		                            </table>
		                            <div id="loader_live" style="margin-top: 5px;"></div>
		                        </div>
	                        </div>
	                    </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="{@hk_cdn}/js/forms/dashboardRanks.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		addUserForm();
		<?php if (in_array($this->users->get('rank'), $this->hotel->getMaster('max'))) { ?>
		addRankForm();
		<?php } ?>
		updateUsers();
		updateRanks();
		setInterval(updateUsers, 5000);
		setInterval(updateRanks, 5000);
	});
</script>