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
                                    <a href="#uloadMPU" data-toggle="tab">
                                        <i class="material-icons">attach_file</i>
                                        MPU
                                    <div class="ripple-container"></div></a>
                                </li>
                                <?php if ($this->hotel->getMasterType() == 'max' && in_array($this->users->get('username'), $this->hotel->getSuperUsers())) { ?>
                                <li>
                                    <a href="#uplodMPUZIP" data-toggle="tab">
                                        <i class="material-icons">insert_drive_file</i>
                                        MPU ZIP
                                    <div class="ripple-container"></div></a>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
                    <div class="card-content">
                        <div class="tab-content">
                            <p>Los MPU se subiran a <b>{@mpus_cdn}/</b></p>
                            <div class="active tab-pane" id="uloadMPU">
                            <h4>Subir MPU</h4>
                                <div id="forerror"></div>
                                <form action="" method="POST" id="uploadMPUFormulary">
                                    <div class="form-group label-floating">
                                        <label for="name" class="control-label">Nombre para el MPU</label>
                                        <input type="text" class="form-control" id="name" name="name" autocomplete="off">
                                        <span class="help-block">Escribe el nombre para el MPU, ejemplo: <strong>mastercms</strong></span>
                                    </div>
                                    <div class="form-group">
                                      <input type="file" name="mpu" id="inputFile4">
                                      <div class="input-group" style="width: 90%;display: inline-block;">
                                        <input type="text" readonly="" class="form-control" placeholder="Seleccione un archivo">
                                      </div>
                                      <span class="input-group-btn input-group-sm" style="width: 5%;display: inline-block;">
                                        <button type="button" class="btn btn-fab btn-fab-mini">
                                          <i class="material-icons">attach_file</i>
                                        </button>
                                      </span>
                                    </div>
                                    <button class="btn btn-success btn-block" type="submit" id="uploadMPU"><i class="fa fa-paper-plane"></i> Subir MPU</button>
                                </form>
                            </div>
                            <?php if ($this->hotel->getMasterType() == 'max' && in_array($this->users->get('username'), $this->hotel->getSuperUsers())) { ?>
                            <div class="tab-pane" id="uplodMPUZIP">
                            <h4>Subir MPU ZIP</h4>
                                <div id="forerror2"></div>
                                <form action="" method="POST" id="uploadMPUZIPFormulary">
                                    <div class="form-group">
                                      <input type="file" name="mpus" id="inputFile4">
                                      <div class="input-group" style="width: 90%;display: inline-block;">
                                        <input type="text" readonly="" class="form-control" placeholder="Seleccione un archivo unicamente en formato ZIP">
                                      </div>
                                      <span class="input-group-btn input-group-sm" style="width: 5%;display: inline-block;">
                                        <button type="button" class="btn btn-fab btn-fab-mini">
                                          <i class="material-icons">attach_file</i>
                                        </button>
                                      </span>
                                    </div>
                                    <button class="btn btn-success btn-block" type="submit" id="uploadMPUZIP"><i class="fa fa-paper-plane"></i> Subir Placas</button>
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
                                    <a href="#delteMPU" data-toggle="tab">
                                        <i class="material-icons">delete_forever</i>
                                        Eliminar MPU
                                    <div class="ripple-container"></div></a>
                                </li>
                                <li>
                                    <a href="#lstMPU" data-toggle="tab">
                                        <i class="material-icons">list</i>
                                        Lista de MPUS
                                    <div class="ripple-container"></div></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                    <div class="card-content">
                        <div class="tab-content">
                            <div class="tab-pane active" id="delteMPU">
                            <h4>Eliminar MPU</h4>
                                <div id="forerror3"></div>
                                <form action="" method="POST" id="deleteMPUFormulary">
                                    <div class="form-group label-floating">
                                        <label for="name" class="control-label">Nombre del MPU</label>
                                        <input type="text" class="form-control" id="name" name="name" autocomplete="off">
                                        <span class="help-block">Escribe el nombre del MPU, ejemplo: <strong>mastercms.jpg</strong></span>
                                    </div>
                                    <button class="btn btn-success btn-block" type="submit" id="deleteMPU"><i class="fa fa-paper-plane"></i> Eliminar MPU</button>
                                </form>
                            </div>
                            <div class="tab-pane" id="lstMPU">
                            <h4>Lista de MPUS</h4>
                                <div class="table-responsive">
                                    <div style="max-height: 500px; overflow-y: auto;">
                                        <table class="table table-hover">
                                            <thead class="text-primary">
                                                <th>Nombre</th>
                                                <th>Ver</th>
                                            </thead>
                                            <tbody id="mpusContainer">
                                                
                                            </tbody>
                                        </table>
                                        <div id="loader_live1" style="margin-top: 5px;"></div>
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
</div>
<script type="text/javascript" src="{@hk_cdn}/js/forms/dashboardMPU.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        uploadMPUForm();
        uploadMPUZIPForm();
        deleteMPUForm();
        updateMPUS();
    });
</script>