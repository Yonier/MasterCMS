<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-6 col-md-12">
				<div class="card card-nav-tabs">
                    <div class="card-header" data-background-color="purple">
                    <div class="nav-tabs-navigation">
                        <div class="nav-tabs-wrapper">
                            <span class="nav-tabs-title">Opciones:</span>
                            <ul class="nav nav-tabs" data-tabs="tabs">
                                <li class="active">
                                    <a href="#maintenanceC" data-toggle="tab">
                                        <i class="material-icons">query_builder</i>
                                        Mantenimiento
                                    <div class="ripple-container"></div></a>
                                </li>
                                <li>
                                    <a href="#otherOpt" data-toggle="tab">
                                        <i class="material-icons">build</i>
                                        Otras Opciones
                                    <div class="ripple-container"></div></a>
                                </li>
                                <li>
                                    <a href="#restartC" data-toggle="tab">
                                        <i class="material-icons">autorenew</i>
                                        Restaurar
                                    <div class="ripple-container"></div></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                    <div class="card-content">
                        <div class="tab-content">
                            <div class="active tab-pane" id="maintenanceC">
                            <h4>Mantenimiento</h4>
                                <div id="forerror"></div>
                                <form action="" method="POST" id="maintenanceFormulary">
                                    <textarea class="tinytext" name="description">
                                        <?php echo $maintenance_description; ?>
                                    </textarea>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Estado</label>
                                          <div class="radio radio-primary">
                                            <label>
                                              <input type="radio" name="status" id="type" value="0" checked=""><span class="circle"></span><span class="check"></span>
                                              Desactivado
                                            </label>
                                          </div>

                                          <div class="radio radio-primary">
                                            <label>
                                              <input type="radio" name="status" id="type2" value="1"><span class="circle"></span><span class="check"></span>
                                              Activado
                                            </label>
                                          </div>
                                      </div>
                                    <button class="btn btn-primary btn-block" type="submit" id="maintenance"><i class="fa fa-paper-plane"></i> Guardar</button>
                                </form>
                            </div>
                            <div class="tab-pane" id="otherOpt">
                            <h4>Otras opciones</h4>
                                <div id="forerror2"></div>
                                <form action="" method="POST" id="otherOptionsFormulary">
                                    <div class="form-group label-floating">
                                        <label for="logo" class="control-label">Logo</label>
                                        <input type="text" class="form-control" id="logo" name="logo" autocomplete="off" maxlength="255" value="{@logo}">
                                        <span class="help-block">Escriba el URL de enlace del logo, ejemplo: <strong>http://ejemplo.com/logo.gif</strong></span>
                                    </div>
                                    <div class="form-group label-floating">
                                        <label for="habbo_img" class="control-label">Habbo Imaging</label>
                                        <input type="text" class="form-control" id="habbo_img" name="habbo_img" autocomplete="off" maxlength="255" value="{@habbo_img}">
                                        <span class="help-block">Escriba el URL del Habbo Imaging, ejemplo: <strong>http://www.habbo.es/habbo-imaging/avatarimage?figure=</strong></span>
                                    </div>
                                    <div class="form-group label-floating">
                                        <label for="radio" class="control-label">Radio</label>
                                        <input type="text" class="form-control" id="radio" name="radio" autocomplete="off" maxlength="255" value="{@radio}">
                                        <span class="help-block">Escriba el URL de enlace de la radio, ejemplo: <strong>http://ejemplo.com/radio.mp3</strong></span>
                                    </div>
                                    <?php if ($this->hotel->getMasterType() == 'max' && in_array($this->users->get('username'), $this->hotel->getSuperUsers())) { ?>
                                    <div class="form-group label-floating">
                                        <label for="super_users" class="control-label">Super Staffs</label>
                                        <input type="text" class="form-control" id="super_users" name="super_users" autocomplete="off" maxlength="255" value="{@super_users}">
                                        <span class="help-block">Escriba lista de staff con max rank que tendran acceso total a hk, ejemplo: <strong>LxBlack, Yonier</strong></span>
                                    </div>
                                    <?php } ?>
                                    <div class="form-group label-floating">
                                        <label for="min_ranks" class="control-label">Rangos minimos</label>
                                        <input type="text" class="form-control" id="min_ranks" name="min_ranks" autocomplete="off" maxlength="255" value="<?php echo $this->hotel->getConfig('min_rank'); ?>">
                                        <span class="help-block">Escriba lista de rangos minimos separados por coma, ejemplo: <strong>2, 3, 4</strong></span>
                                    </div>
                                    <div class="form-group label-floating">
                                        <label for="medium_ranks" class="control-label">Rangos medios</label>
                                        <input type="text" class="form-control" id="medium_ranks" name="medium_ranks" autocomplete="off" maxlength="255" value="<?php echo $this->hotel->getConfig('medium_rank'); ?>">
                                        <span class="help-block">Escriba lista de rangos minimos separados por coma, ejemplo: <strong>5, 6, 7</strong></span>
                                    </div>
                                    <div class="form-group label-floating">
                                        <label for="max_ranks" class="control-label">Rangos maximos</label>
                                        <input type="text" class="form-control" id="max_ranks" name="max_ranks" autocomplete="off" maxlength="255" value="<?php echo $this->hotel->getConfig('max_rank'); ?>">
                                        <span class="help-block">Escriba lista de rangos minimos separados por coma, ejemplo: <strong>8, 9, 10</strong></span>
                                    </div>
                                    <div class="form-group label-floating">
                                        <label for="facebook" class="control-label">Facebook</label>
                                        <input type="text" class="form-control" id="facebook" name="facebook" autocomplete="off" maxlength="255" value="{@facebook}">
                                        <span class="help-block">Escriba el facebook de {@name}, ejemplo: <strong>Habbo</strong></span>
                                    </div>
                                    <div class="form-group label-floating">
                                        <label for="twitter" class="control-label">Twitter</label>
                                        <input type="text" class="form-control" id="twitter" name="twitter" autocomplete="off" maxlength="255" value="{@twitter}">
                                        <span class="help-block">Escriba el twitter de {@name}, ejemplo: <strong>Habbo</strong></span>
                                    </div>
                                    <div class="form-group label-floating">
                                        <label for="instagram" class="control-label">Instagram</label>
                                        <input type="text" class="form-control" id="instagram" name="instagram" autocomplete="off" maxlength="255" value="{@instagram}">
                                        <span class="help-block">Escriba el instagram de {@name}, ejemplo: <strong>Habbo</strong></span>
                                    </div>
                                    <button class="btn btn-primary btn-block" type="submit" id="otherOptions"><i class="fa fa-paper-plane"></i> Guardar Cambios</button>
                                </form>
                            </div>
                            <div class="tab-pane" id="restartC">
                            <h4>Restaurar</h4>
                                <div id="forerror3"></div>
                                <form action="" method="POST" id="restartFormulary">
                                    <div class="checkbox">
                                      <label>
                                        <input type="checkbox" name="conditions" value="1"> Acepto las consecuencias de restaurar MasterCMS
                                      </label>
                                    </div>
                                    <button class="btn btn-primary btn-block" type="submit" id="restart"><i class="fa fa-paper-plane"></i> Restaurar al modo fabrica</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
            <div class="col-md-12 col-lg-6">
                <div class="card">
                    <div class="card-header" data-background-color="red">
                        <h4 class="title">Advertencias / Consejos</h4>
                        <p class="category">A continuaci&oacute;n le dejamos una lista de advertencias/consejos que deberas tomar en cuenta antes de modificar esta secci&oacute;n:</p>
                    </div>
                    <div class="card-content">
                        <ul>
                            <li>Si no sabe lo que hace, no mueva nada de lo que hay aqui dentro.</li>
                            <li>Recuerda que si mueves los min/medium/max rank, puede que te haga logout.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>
</div>
</div>
<script type="text/javascript" src="{@hk_cdn}/js/forms/dashboardCMS.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        maintenanceForm();
        otherOptionsForm();
        restartForm();
    });
</script>