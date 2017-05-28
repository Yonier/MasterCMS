<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title">Agregar baneo</h4>
                        <p class="category">Agrega un nuevo baneo a la lista de baneados de {@name} completando el siguiente formulario:</p>
                    </div>
                    <div class="card-content table-responsive">
                    <div id="forerror"></div>
                        <form action="" method="POST" id="submitBanFormulary">
                            <div class="form-group label-floating">
                                <label for="username" class="control-label">Usuario</label>
                                <input type="text" class="form-control" id="username" name="username" autocomplete="off" maxlength="30">
                                <span class="help-block">Escriba el nombre de usuario a banear, ejemplo: <strong>Juan</strong></span>
                            </div>
                            <div class="form-group label-floating">
                                <label for="reason" class="control-label">Raz&oacute;n</label>
                                <input type="text" class="form-control" id="reason" name="reason" autocomplete="off" maxlength="255">
                                <span class="help-block">Escriba el la raz&oacute;n a banear, ejemplo: <strong>Por SPAM</strong></span>
                            </div>
                            <div class="form-group label-floating">
                                <select class="form-control" name="type" id="type">
                                    <option value="0" disabled selected>Seleccione un tipo de baneo</option>
                                    <option value="user">Usuario</option>
                                    <option value="ip">IP</option>
                                </select>
                                <span class="help-block">Seleccione el tipo de baneo, ejemplo: <strong>Usuario</strong></span>
                            </div>
                            <div class="form-group label-floating">
                                <select class="form-control" name="expire" id="expire">
                                    <option value="0" disabled selected>Seleccione un tiempo de expiraci&oacute;n</option>
                                    <option value="<?php echo time() * 99999999; ?>">Por vida</option>
                                    <option value="3600">1 hora</option>
                                    <option value="86400">24 horas</option>
                                    <option value="259200">2 d&iacute;as</option>
                                    <option value="259200">3 d&iacute;as</option>
                                    <option value="345600">4 d&iacute;as</option>
                                    <option value="432000">5 d&iacute;as</option>
                                    <option value="518400">6 d&iacute;as</option>
                                    <option value="604800">1 semana</option>
                                    <option value="1209600">2 semanas</option>
                                    <option value="1814400">3 semanas</option>
                                    <option value="2592000">1 mes</option>
                                    <option value="31104000">1 a&ntilde;o</option>
                                </select>
                                <span class="help-block">Seleccione el tiempo a banear, ejemplo: <strong>1 hora</strong></span>
                            </div>
                            <button class="btn btn-primary btn-block" type="submit" id="submitBan"><i class="fa fa-paper-plane"></i> Agregar baneo</button>
                        </form> 
                    </div>
                </div>
            </div>

        <div class="col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card-header" data-background-color="purple">
                                <h4 class="title">Lista de baneos</h4>
                                <p class="category">A continuaci&oacute;n podra ver la lista de todos los usuarios baneados en {@name}:</p>
                            </div>
                            <div class="card-content table-responsive">
                                <div style="max-height: 300px; overflow-y: auto;">
                                    <table class="table table-hover">
                                        <thead class="text-primary">
                                            <th>ID</th>
                                            <th>Valor</th>
                                            <th>Razon</th>
                                            <th>Tipo</th>
                                            <th>Staff</th>
                                            <th>Fecha</th>
                                            <th>Expiraci&oacute;n</th>
                                            <th>Acciones</th>
                                        </thead>
                                        <tbody id="bansContainer">
                                            
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
<script type="text/javascript" src="{@hk_cdn}/js/forms/dashboardBans.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        submitNewForm();
        updateBans();
        setInterval(function(){
            updateBans();
        }, 3000);
    });
</script>