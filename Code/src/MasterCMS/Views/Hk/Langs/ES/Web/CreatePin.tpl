<?php if ($hk) { ?>
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6 col-centered">
				<div class="panel panel-default">
				  <div class="panel-body">
				    <h4>Crear c&oacute;digo de seguridad</h4>
					<p>Para terminar con el procedimiento de integraci&oacute;n al equipo administrativo de <b>{@name}</b> escriba su nuevo c&oacute;digo de seguridad</p>
					<div id="forerror"></div>
					<form action="" method="POST" id="pinFormulary">
		                <div class="form-group label-floating">
		                    <label for="pin" class="control-label">Nuevo c&oacute;digo de seguridad</label>
		                    <input type="password" class="form-control" id="pin" name="pin" autocomplete="off" maxlength="30">
		                    <span class="help-block">Escribe un nuevo c&oacute;digo de seguridad, ejemplo: <strong>******</strong></span>
		                </div>
		                <div class="form-group label-floating">
		                    <label for="rpin" class="control-label">Repetir c&oacute;digo de seguridad</label>
		                    <input type="password" class="form-control" id="rpin" name="rpin" autocomplete="off" maxlength="30">
		                    <span class="help-block">Repita su nuevo c&oacute;digo de seguridad, ejemplo: <strong>******</strong></span>
		                </div>
		                <button class="btn btn-raised btn-primary btn-block" type="submit" id="submitpin"><i class="fa fa-paper-plane"></i> Guardar</button>
		            </form>		    
				  </div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="{@hk_cdn}/js/forms/createPin.js"></script>
<?php } ?>
<?php if ($client) { ?>
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6 col-centered">
				<div class="panel panel-default">
				  <div class="panel-body">
				    <h4>Crear c&oacute;digo de seguridad</h4>
					<p>Para terminar con el procedimiento de integraci&oacute;n al equipo administrativo de <b>{@name}</b> escriba su nuevo c&oacute;digo de seguridad</p>
					<div id="forerror"></div>
					<form action="" method="POST" id="pinFormulary">
		                <div class="form-group label-floating">
		                    <label for="pin" class="control-label">Nuevo c&oacute;digo de seguridad</label>
		                    <input type="password" class="form-control" id="pin" name="pin" autocomplete="off" maxlength="30">
		                    <span class="help-block">Escribe un nuevo c&oacute;digo de seguridad, ejemplo: <strong>******</strong></span>
		                </div>
		                <div class="form-group label-floating">
		                    <label for="rpin" class="control-label">Repetir c&oacute;digo de seguridad</label>
		                    <input type="password" class="form-control" id="rpin" name="rpin" autocomplete="off" maxlength="30">
		                    <span class="help-block">Repita su nuevo c&oacute;digo de seguridad, ejemplo: <strong>******</strong></span>
		                </div>
		                <button class="btn btn-raised btn-primary btn-block" type="submit" id="submitpin"><i class="fa fa-paper-plane"></i> Guardar</button>
		            </form>		    
				  </div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="{@hk_cdn}/js/forms/createPinClient.js"></script>
<?php } ?>