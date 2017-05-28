<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-6 col-md-12">
				<div class="card card-nav-tabs">
                    <div class="card-header" data-background-color="purple">
                    <div class="nav-tabs-navigation">
                        <div class="nav-tabs-wrapper">
                            <span class="nav-tabs-title">Subir:</span>
                            <ul class="nav nav-tabs" data-tabs="tabs">
                                <li class="active">
                                    <a href="#uploadTmp" data-toggle="tab">
                                        <i class="material-icons">attach_file</i>
                                        Placa
                                    <div class="ripple-container"></div></a>
                                </li>
                                <?php if ($this->hotel->getMasterType() == 'max' && in_array($this->users->get('username'), $this->hotel->getSuperUsers())) { ?>
                                <li>
                                    <a href="#uploadStl" data-toggle="tab">
                                        <i class="material-icons">insert_drive_file</i>
                                        Placas ZIP
                                    <div class="ripple-container"></div></a>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
                    <div class="card-content">
                        <div class="tab-content">
                            <div class="active tab-pane" id="uploadTmp">
                            <h4>Subir Placa</h4>
                                <div id="forerror"></div>
                                <form action="" method="POST" id="uploadBadgeFormulary">
                                    <div class="form-group label-floating">
                                        <label for="name" class="control-label">C&oacute;digo de placa</label>
                                        <input type="text" class="form-control" id="name" name="name" autocomplete="off" maxlength="30">
                                        <span class="help-block">Escribe un nuevo c&oacute;digo de placa, ejemplo: <strong>EDP</strong></span>
                                    </div>
                                    <div class="form-group label-floating">
                                        <label for="title" class="control-label">Titulo para la placa</label>
                                        <input type="text" class="form-control" id="title" name="title" autocomplete="off">
                                        <span class="help-block">Escribe un nuevo titulo para la placa, ejemplo: <strong>Encargado de publicidad</strong></span>
                                    </div>
                                    <div class="form-group label-floating">
                                        <label for="description" class="control-label">Descripcion para la placa</label>
                                        <input type="text" class="form-control" id="description" name="description" autocomplete="off">
                                        <span class="help-block">Escribe una nueva descripcion para la placa, ejemplo: <strong>Placa de encargado de publicidad</strong></span>
                                    </div>
                                    <div class="form-group">
                                      <input type="file" name="badge" id="inputFile4">
                                      <div class="input-group" style="width: 90%;display: inline-block;">
                                        <input type="text" readonly="" class="form-control" placeholder="Seleccione un archivo unicamente en formato GIF">
                                      </div>
                                      <span class="input-group-btn input-group-sm" style="width: 5%;display: inline-block;">
                                        <button type="button" class="btn btn-fab btn-fab-mini">
                                          <i class="material-icons">attach_file</i>
                                        </button>
                                      </span>
                                    </div>
                                    <button class="btn btn-success btn-block" type="submit" id="uploadBadge"><i class="fa fa-paper-plane"></i> Subir Placa</button>
                                </form>
                            </div>
                            <?php if ($this->hotel->getMasterType() == 'max' && in_array($this->users->get('username'), $this->hotel->getSuperUsers())) { ?>
                            <div class="tab-pane" id="uploadStl">
                            <h4>Subir Placas ZIP</h4>
                                <div id="forerror2"></div>
                                <form action="" method="POST" id="uploadBadgeZIPFormulary">
                                    <div class="form-group">
                                      <input type="file" name="badges" id="inputFile4">
                                      <div class="input-group" style="width: 90%;display: inline-block;">
                                        <input type="text" readonly="" class="form-control" placeholder="Seleccione un archivo unicamente en formato ZIP">
                                      </div>
                                      <span class="input-group-btn input-group-sm" style="width: 5%;display: inline-block;">
                                        <button type="button" class="btn btn-fab btn-fab-mini">
                                          <i class="material-icons">attach_file</i>
                                        </button>
                                      </span>
                                    </div>
                                    <button class="btn btn-success btn-block" type="submit" id="uploadBadgeZIP"><i class="fa fa-paper-plane"></i> Subir Placas</button>
                                </form>
                            </div>
                            <?php } ?>
                        </div>
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
                                    <a href="#sbmitBadgeInfo" data-toggle="tab">
                                        <i class="material-icons">build</i>
                                        Cambiar info
                                    <div class="ripple-container"></div></a>
                                </li>
                                <li>
                                    <a href="#delteBadge" data-toggle="tab">
                                        <i class="material-icons">delete_forever</i>
                                        Eliminar placa
                                    <div class="ripple-container"></div></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                    <div class="card-content">
                        <div class="tab-content">
                            <div class="active tab-pane" id="sbmitBadgeInfo">
                            <h4>Cambiar informaci&oacute;n de placas</h4>
                                <div id="forerror3"></div>
                                <form action="" method="POST" id="submitBadgeInfoFormulary">
                                    <div class="form-group label-floating">
                                        <label for="name" class="control-label">C&oacute;digo de placa</label>
                                        <input type="text" class="form-control" id="name" name="name" autocomplete="off" maxlength="30">
                                        <span class="help-block">Escribe un c&oacute;digo de placa, ejemplo: <strong>EDP</strong></span>
                                    </div>
                                    <div class="form-group label-floating">
                                        <label for="title" class="control-label">Titulo para la placa</label>
                                        <input type="text" class="form-control" id="title" name="title" autocomplete="off">
                                        <span class="help-block">Escribe un nuevo titulo para la placa, ejemplo: <strong>Encargado de publicidad</strong></span>
                                    </div>
                                    <div class="form-group label-floating">
                                        <label for="description" class="control-label">Descripcion para la placa</label>
                                        <input type="text" class="form-control" id="description" name="description" autocomplete="off">
                                        <span class="help-block">Escribe una nueva descripcion para la placa, ejemplo: <strong>Placa de encargado de publicidad</strong></span>
                                    </div>
                                    <button class="btn btn-success btn-block" type="submit" id="submitBadgeInfo"><i class="fa fa-paper-plane"></i> Cambiar informaci&oacute;n</button>
                                </form>
                            </div>
                            <div class="tab-pane" id="delteBadge">
                            <h4>Eliminar placa</h4>
                                <div id="forerror4"></div>
                                <form action="" method="POST" id="deleteBadgeFormulary">
                                    <div class="form-group label-floating">
                                        <label for="name" class="control-label">C&oacute;digo de placa</label>
                                        <input type="text" class="form-control" id="name" name="name" autocomplete="off">
                                        <span class="help-block">Escribe un c&oacute;digo de placa, ejemplo: <strong>EDP</strong></span>
                                    </div>
                                    <button class="btn btn-success btn-block" type="submit" id="deleteBadge"><i class="fa fa-paper-plane"></i> Eliminar Placa</button>
                                </form>
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
<script type="text/javascript" src="{@hk_cdn}/js/forms/dashboardBadges.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        uploadBadgeForm();
        uploadBadgeZIPForm();
        submitBadgeInfoForm();
        deleteBadgeForm();
    });
</script>