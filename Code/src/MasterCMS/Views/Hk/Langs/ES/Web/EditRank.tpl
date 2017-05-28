<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-6 col-md-12">
				<div class="card">
	                <div class="card-header" data-background-color="purple">
	                    <h4 class="title">Editar el rango {@rank_name}</h4></h4>
	                    <p class="category">Edita todos los detalles de el rango {@rank_name} a continuaci&oacute;n:</p>
	                </div>
	                <div class="card-content table-responsive">
	                	<div id="forerror"></div>
	                    <form action="" method="POST" id="editRankFormulary">
				                <div class="form-group label-floating">
				                    <label for="name" class="control-label">Nombre de rango</label>
				                    <input type="text" class="form-control" id="name" name="name" autocomplete="off" maxlength="50" value="{@rank_name}">
				                    <span class="help-block">Escriba el nombre de el rango, ejemplo: <strong>Administrador</strong></span>
				                </div>
				                <div class="form-group">
					                <label class="col-md-2 control-label">Visibilidad</label>
					                  <div class="radio radio-primary">
					                    <label>
					                      <input type="radio" name="visibility" id="visibility" value="yes"<?php if ($rank_fuse_hide_staff == 0) { echo " checked"; } ?>><span class="circle"></span><span class="check"></span>
					                      Visible
					                    </label>
					                  </div>
					                  <div class="radio radio-primary">
					                    <label>
					                      <input type="radio" name="visibility" id="visibility2" value="no"><span class="circle" <?php if ($rank_fuse_hide_staff == 1) { echo " checked"; } ?>></span><span class="check"></span>
					                      Oculto
					                    </label>
					                  </div>
					              </div>
				                <div class="form-group label-floating">
				                    <select name="type" id="type" class="form-control">
				                    	<option value="0" disabled="">Tipo de rango</option>
				                    	<?php if (in_array($this->users->get('rank'), $this->hotel->getMaster('medium'))) { ?>
				                    	<option value="nothing">Ninguno</option>
				                    	<option value="min"<?php if ($this->hotel->getMasterType($rank_id) == 'min') { echo " selected"; } ?>>Minimo</option>
				                    	<option value="medium"<?php if ($this->hotel->getMasterType($rank_id) == 'medium') { echo " selected"; } ?>>Medio</option>
				                    	<?php } ?>
				                    	<?php if (in_array($this->users->get('rank'), $this->hotel->getMaster('max'))) { ?>
				                    	<option value="nothing">Ninguno</option>
				                    	<option value="min"<?php if ($this->hotel->getMasterType($rank_id) == 'min') { echo " selected"; } ?>>Minimo</option>
				                    	<option value="medium"<?php if ($this->hotel->getMasterType($rank_id) == 'medium') { echo " selected"; } ?>>Medio</option>
				                    	<option value="max"<?php if ($this->hotel->getMasterType($rank_id) == 'max') { echo " selected"; } ?>>Maximo</option>
				                    	<?php } ?>
				                    </select>
				                    <span class="help-block">Seleccione el tipo de rango, ejemplo: <strong>Minimo</strong></span>
				                </div>
				                <div class="form-group label-floating">
				                    <label for="badge" class="control-label">Placa</label>
				                    <input type="text" class="form-control" id="badge" name="badge" autocomplete="off" maxlength="20" value="{@rank_badge}">
				                    <span class="help-block">Escriba el nombre de la placa para el rango, ejemplo: <strong>{@rank_badge}</strong></span>
				                </div>
				                <div class="form-group label-floating">
				                    <label for="color" class="control-label">Color</label>
				                    <input type="color" class="form-control" id="color" name="color" autocomplete="off" value="{@rank_color}">
				                    <span class="help-block">Seleccione un color para el rango, ejemplo: <strong>{@rank_color}</strong></span>
				                </div>
				                <button class="btn btn-primary btn-block" type="submit" id="editRank"><i class="fa fa-paper-plane"></i> Editar Rango</button>
				            </form>	
						</div>
	                </div>
	            </div>

	            <div class="col-lg-6 col-md-12">
	                    <div class="card">
	                        <div class="card-header" data-background-color="purple">
	                            <h4 class="title">Lista de Rangos</h4>
	                            <p class="category">Los rangos oficiales de {@name} son:</p>
	                        </div>
	                        <div class="card-content table-responsive" style="max-height: 300px; overflow-y: auto;">
	                            <div style="max-height: 250px; overflow-y: auto;">
		                        	<table class="table table-hover">
										<thead class="text-success">
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
	</div>
</div>
<script type="text/javascript" src="{@hk_cdn}/js/forms/dashboardRanks.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		<?php if (in_array($this->users->get('rank'), $this->hotel->getMaster('max'))) { ?>
		editRankForm();
		<?php } ?>
		updateRanks();
		setInterval(updateRanks, 5000);
	});
</script>