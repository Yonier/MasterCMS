<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-6 col-md-12">
				<div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title">Crear noticia</h4>
                        <p class="category">Agrega una nueva noticia a la lista de noticias de {@name} completando el siguiente formulario:</p>
                    </div>
                    <div class="card-content table-responsive">
                    <div id="forerror"></div>
                        <form action="" method="POST" id="submitNewFormulary">
							<div class="form-group label-floating">
			                    <label for="title" class="control-label">Titulo</label>
			                    <input type="text" class="form-control" id="title" name="title" autocomplete="off" maxlength="255">
			                    <span class="help-block">Escriba un titulo para la noticia, ejemplo: <strong>Bienvenido a {@name}</strong></span>
			                </div>
			                <div class="form-group label-floating">
			                    <label for="short_story" class="control-label">Historia corta</label>
			                    <input type="text" class="form-control" id="short_story" name="short_story" autocomplete="off">
			                    <span class="help-block">Escriba una historia corta para la noticia, ejemplo: <strong>Gracias por registrarse dentro de el hotel</strong></span>
			                </div>
			                <textarea class="tinytext" name="long_story">
			                	<p>Contenido de la nueva noticia para {@name}</p>
			                </textarea>
			                <div class="form-group label-floating">
			                    <label for="image" class="control-label">Imagen</label>
			                    <input type="text" class="form-control" id="image" name="image" autocomplete="off" maxlength="255">
			                    <span class="help-block">Escriba el URL de imagen para la noticia, ejemplo: <strong>http://ejemplo.com/imagen.png</strong></span>
		                	</div>
			                <div class="form-group label-floating">
			                    <select class="form-control" name="actived_comments" id="actived_comments">
			                    	<option value="0" disabled="" selected="">Comentarios</option>
			                    	<option value="active">Activado</option>
			                    	<option value="desactive">Desactivado</option>
			                    </select>
			                    <span class="help-block">Seleccione la actividad de comentarios, ejemplo: <strong>Activado</strong></span>
			                </div>
			                <button class="btn btn-primary btn-block" type="submit" id="submitNew"><i class="fa fa-paper-plane"></i> Agregar noticia</button>
			            </form>	
                    </div>
                </div>
			</div>

		<div class="col-lg-6 col-md-12">
						<div class="card">
	                        <div class="card-header" data-background-color="purple">
	                            <h4 class="title">Lista de noticias</h4>
	                            <p class="category">A continuaci&oacute;n podra ver la lista de todas las noticias en {@name}:</p>
	                        </div>
	                        <div class="card-content table-responsive">
		                        <div style="max-height: 300px; overflow-y: auto;">
		                        	<table class="table table-hover">
										<thead class="text-primary">
	                                        <th>ID</th>
	                                    	<th>Titulo</th>
	                                    	<th>Autor</th>
	                                    	<th>Fecha</th>
	                                    	<th>Acciones</th>
	                                    </thead>
		                                <tbody id="newsContainer">
		                                	
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
<script type="text/javascript" src="{@hk_cdn}/js/forms/dashboardNews.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		<?php if (in_array($this->users->get('rank'), $this->hotel->getMaster('all'))) { ?>
		submitNewForm();
		updateNews();
		<?php } ?>
		setInterval(updateNews, 5000);
	});
</script>