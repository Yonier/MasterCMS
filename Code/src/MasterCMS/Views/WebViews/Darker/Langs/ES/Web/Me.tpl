<main id="lg">
    <div class="container-fluid">
        <div class="row gutter-10">
            <div class="col-lg-12">
            	<h3>Mi personaje</h3>
            	<div class="Box">
            		<div class="boxContent meBox">
	            		<div id="me_c-1">
		            		<div id="meAvatar" style="background-image:url({@habbo_img}{@look}&gesture=sml&size=l);"> </div>
		            		<div id="meData">
		            			<h6>{@username}</h6>
		            			<p>{@motto}</p>
		            			<p>Ultima conexión: {@last_used}</p>
		            		</div>
	            		</div>
	            		<div id="me_c-2">
	            			<div class="meCounter"><div class="meIcon" id="diamond"> </div><span id="diamond_T">{@diamonds}</span></div>
	            			<div class="meCounter"><div class="meIcon" id="credit"> </div><span id="credit_T">{@credits}</span></div>
	            			<div class="meCounter"><div class="meIcon" id="ducket"> </div><span id="ducket_T">{@duckets}</span></div>
	            		</div>
	            		<div id="me_c-1">
	            			<a href="{@client_url}" class="btn btn-success btn-lg btn-radius float-right">Entrar al Hotel</a>
	            		</div>
            		</div>
            	</div>
            </div>
            <?php 

                $news_query = $this->con->query("SELECT * FROM news ORDER BY id DESC LIMIT 12");
                $news_num = $this->con->num_rows($news_query);

                if ($news_num == 0) {

            ?>

		            <div class="col-lg-12">            	
		                <div class="Box">
		                    <div class="boxTitle">¡Oh, bobba! no existe ningúna noticia</div>
		                    <div class="boxContent">
		                        <center>
		                            <img src="{@cdn}/Images/404.png" alt="Error 404">
		                            <p><div style="text-transform: uppercase;">Vuelve en otra ocasión, probablemente hayan noticias.</div></p>
		                        </center>
		                    </div>
		                </div>
		            </div>
		    <?php

		  		}
		  		else{

		    ?>

	            <div class="col-lg-6">
	            	<h3>Noticias</h3>
					<div id="nSlider">
	                    <ul>
			<?php 

	                $news_query = $this->con->query("SELECT * FROM news ORDER BY id DESC LIMIT 12");
	                $news_num = $this->con->num_rows($news_query);



						while ($news_select = mysqli_fetch_assoc($news_query)) {

			?>                            
	                        <li>
	                            <div class="nSliderIMG" style="background:url('<?php echo $news_select['image']; ?>') center;">
	                                <div class="nSliderTitle"><?php echo $news_select['title']; ?></div>
	                                <div class="nSliderDesc"><?php echo $news_select['shortstory']; ?></div>
	                                <div class="nSliderFoot">
	                                    <button class="btn btn-success btn-lg"><a href="{@url}/web/news/<?php echo $news_select['id']; ?>">Ir a la Noticia</a></button>                                    
	                                </div>
	                            </div>
	                        </li>
	        <?php } ?>
	                    </ul>
	                </div>
	            </div>
	            <div class="col-lg-6">
	            	<h3>Últimas Noticias</h3>
	            	<div class="Box">
	            		<ul id="lastNews">
						  	<?php 

						  		$news_query = $this->con->query("SELECT * FROM news ORDER BY id DESC LIMIT 3");
								$news_num = $this->con->num_rows($news_query);

								while ($news_select = mysqli_fetch_assoc($news_query)) {

							?>
	            			<li>
	            				<div class="lastImage" style="background: url('<?php echo $news_select['image']; ?>') center;"> </div>
	            				<div class="lastDetails">
	            					<h5><?php echo $news_select['title']; ?></h5>
	            					<p><?php echo $news_select['shortstory']; ?></p>
	            					<span class="float-right"><a href="{@url}/web/news/<?php echo $news_select['id']; ?>">Leer más</a></span>
	            				</div>
	            			</li>
	            			<?php } ?>
	            		</ul>
	            	</div>
	            </div>
	       	<?php

	            }

	        ?>            
            <div class="col-lg-7">
                <div class="Box">
                    <div class="boxTitle">Referidos</div>
                    <div class="boxContent">
			    	<?php 

		            	$query_refers = $this->con->query("SELECT * FROM user_refers WHERE user_id = '{$this->users->get('id')}'");
		            	$select_refers = mysqli_fetch_assoc($query_refers);
		            	$count_refers = $this->con->num_rows($query_refers);

		            	$query_awards = $this->con->query("SELECT * FROM refers_awards WHERE refers_amount >= '{$count_refers}' LIMIT 1");
		            	$select_awards = mysqli_fetch_assoc($query_awards);
		            	$num_all_awards = $this->con->num_rows("SELECT * FROM refers_awards");

		            	$user_awards = $this->con->query("SELECT * FROM user_awards WHERE user_id = '{$this->users->get('id')}' AND award_type = 'refers' AND award_id = '{$select_awards['id']}' ORDER BY id DESC LIMIT 1");
		            	$select_user_awards = mysqli_fetch_assoc($user_awards);
		            	$query = $this->con->query("SELECT * FROM users_refer_limit WHERE user_id = '{$this->users->get('id')}' LIMIT 1");
		            	$limit_select = mysqli_fetch_assoc($query);

		            ?>
		            <label for="refers_link" class="control-label" id="tlll"><h3>Copia el enlace</h3></label>
	                <input type="text" class="form-control" id="refers_link" value="{@url}/web/register/{@id}" readonly="">
					<button class="formButton btn btn-success btn-lg btn-radius" id="ref_B" data-done="Enlace copiado" style="margin-bottom: 1rem;">Copiar Enlace</button>
					<p>Actualmente cuentas con <strong><?php echo $count_refers; ?></strong> referidos<br>

		            <!-- <?php if ($select_awards['refers_amount'] != $count_refers && $select_user_awards['status'] == 'reclamed' && $limit_select['ref_limit'] != $count_refers && $select_user_awards['status'] == 'declimed') { ?>

				    <p>Mediante el sistema de referidos usted podra obtener premios dentro de el hotel, tales como: <strong>Creditos</strong>, <strong>Diamantes</strong>, <strong>Rangos</strong>, <strong>Placas</strong>, <strong>Rares</strong> &amp; etc&eacute;tera.<br>Copia el siguiente enlace y pásaselo a tus amigos</p>

					<?php } ?>

						<?php if ($select_awards['refers_amount'] == $count_refers && $select_user_awards['status'] != 'reclamed' && $limit_select['ref_limit'] == $count_refers && $select_user_awards['status'] != 'declimed') { ?>

						<form method="POST" id="refersFormulary" style="display: inline-block; margin: 0;">
							<button class="btn btn-primary btn-raised" type="submit" id="reclame_award" style="display: inline-block; margin: 5px 0;"><i class="fa fa-star"></i> Reclamar premio</button>
						</form>

						<form method="POST" id="refersdecFormulary" style="display: inline-block; margin: 0;">
							<button class="btn btn-danger btn-raised" type="submit" id="decline_award" style="display: inline-block; margin: 5px 0;"><i class="fa fa-times"></i> Declinar</button>
						</form>

						<?php } else { ?>

						<label for="refers_link" class="control-label" id="tlll"><h3>Copia el enlace</h3></label>
		                <input type="text" class="form-control" id="refers_link" value="{@url}/web/register/{@id}" readonly="">
						<button class="formButton btn btn-success btn-lg btn-radius" id="ref_B" data-done="Enlace copiado" style="margin-bottom: 1rem;">Copiar Enlace</button>
						
						<?php } ?>	 -->
										
						<!--
						
			            <?php if ($num_all_awards == 0) { ?>

			            <p><i>Actualmente no hay premios disponibles por referidos</i></p>

						<?php } elseif ($select_awards['refers_amount'] == $count_refers && $select_user_awards['status'] != 'reclamed' && $limit_select['ref_limit'] == $count_refers && $select_user_awards['status'] != 'declimed') { ?>

						<p><i>Ya has logrado los <strong><?php echo $count_refers; ?></strong> referidos, reclama tu nuevo premio &amp; sigue avanzando!</i></p>
						
						<?php } else { ?>
						
						<?php if ($select_awards['refers_amount'] != 0) { ?>

						<p>Actualmente cuentas con <strong><?php echo $count_refers; ?></strong> referidos<br>
						<i>Te hacen falta <strong><?php echo $select_awards['refers_amount'] - $count_refers; ?></strong> referidos para obtener tu siguiente premio</i></p>
			
						<?php } else { ?>

						<p>Actualmente cuentas con <strong><?php echo $count_refers; ?></strong> referidos<br>
						<i>Ya has reclamado tu premio, ahora toca seguir avanzando para m&aacute;s premios!</i></p>

						<?php } ?>

						<?php } ?>

						<p><br><a href="#" class="text-left" data-toggle="modal" data-target="#awardsModal" data-dismiss="modal"><i>Lista de premios &raquo;</i></a></p>
                    	-->
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="Box">
                    <div class="boxTitle">Facebook</div>
                    <div class="boxContent" style="height: 19rem;">
                        <div class="fb-page" data-href="http://www.facebook.com/{@facebook}" data-tabs="timeline" data-width="1000000px" data-height="268" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><div class="fb-xfbml-parse-ignore"></div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php if ($this->facebook->getSession() && $this->users->get('facebook_completed') == 0) { ?>

	<div class="modal fade" id="fbModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Cambiar nombre de usuario</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>A&uacute;n no haz configurado tu nombre de usuario, &iquest;qué esperas para hacerlo?</p>
					<form action="" method="POST" id="fbnameFormulary">
						<input type="text" class="form-control" id="username" name="username" autocomplete="off" maxlength="15" placeholder="Nombre de usuario">
						<i>Escribe un nombre de usuario, ejemplo: <strong><?php echo $this->facebook->getUser('first_name') . rand(0,9) . rand(0,9) . rand(0,9); ?></strong></i>
						<hr>
						<input type="submit" class="btn btn-success btn-lg btn-radius" id="fbname" value="Guardar">
					</form>
				</div>
			</div>
		</div>
	</div>

<?php } ?>


<div id="awardsModal" class="modal fade" tabindex="-1" style="display: none;">
<div class="modal-dialog">
<div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 class="modal-title"><i class="fa fa-list"></i> Lista de premios</h3>
        <div id="forerror" style="display: none;"></div>
      </div>
      <div class="modal-body">
		
		<div class="row">
			<?php 

				$query_refers = $this->con->query("SELECT * FROM user_refers WHERE user_id = '{$this->users->get('id')}'");
	        	$select_refers = mysqli_fetch_assoc($query_refers);
	        	$count_refers = $this->con->num_rows($query_refers);
				$award_query = $this->con->query("SELECT * FROM refers_awards ORDER BY refers_amount LIMIT 12");
				$award_num = $this->con->num_rows($award_query);

				while ($award_select = mysqli_fetch_assoc($award_query)) {
				$query_awrd = $this->con->query("SELECT * FROM user_awards WHERE user_id = '{$this->users->get('id')}' AND award_type = 'refers' AND award_id = '{$award_select['id']}'");
				$select_awrd = mysqli_fetch_assoc($query_awrd);

				if ($select_awrd['status'] == 'reclamed') {
					$status = 'Reclamado';
				} elseif ($select_awrd['status'] == 'declimed') {
					$status = 'Declinado';
				} else {
					$status = 'Pendiente';
				}

				if ($award_select['award_type'] == 'credits') {
					$award = 'CREDITOS';
					$include = 'Gana <b>creditos</b> gratuitamente con referidos!';
					$image = 'http://i.imgur.com/qw2sIUW.png';
				} elseif ($award_select['award_type'] == 'diamonds') {
					$award = 'DIAMANTES';
					$include = 'Gana <b>diamantes</b> gratuitamente con referidos!';
					$image = 'http://i.imgur.com/Z40o1LD.png';
				} elseif ($award_select['award_type'] == 'duckets') {
					$award = 'DUCKETS';
					$include = 'Gana <b>duckets</b> gratuitamente con referidos!';
					$image = 'http://i.imgur.com/o9IUE3a.png';
				} elseif ($award_select['award_type'] == 'badges') {
					$award = 'PLACA';
					$include = 'Gana <b>placas</b> gratuitamente con referidos!';
					$image = 'http://i.imgur.com/upKCV3z.png';
				} elseif ($award_select['award_type'] == 'rares') {
					$award = 'RARE';
					$include = 'Gana <b>rares</b> gratuitamente con referidos!';
					$image = 'http://i.imgur.com/LUpzZKG.png';
				} elseif ($award_select['award_type'] == 'economy') {
					$award = '¡PREMIAZO!';
					$include = 'Gana <b>creditos</b>, <b>duckets</b>, <b>diamantes</b>, <b>estrellas</b> gratuitamente con referidos!';
					$image = 'http://i.imgur.com/8qG7EC3.png';
				} elseif ($award_select['award_type'] == 'ranks') {
					$award = '¡RANGO!';
					$include = 'Gana <b>rango</b> gratuitamente con referidos!';
					$image = 'http://i.imgur.com/8eRHDcg.png';
				} elseif ($award_select['award_type'] == 'gotw') {
					$award = 'ESTRELLAS';
					$include = 'Gana <b>estrellas</b> gratuitamente con referidos!';
					$image = 'http://i.imgur.com/rLYRIlx.png';
				} else {
					$award = 'CREDITOS';
					$include = 'Gana <b>creditos</b> gratuitamente con referidos!';
					$image = 'http://i.imgur.com/qw2sIUW.png';
				}

			?>
			
			<div class="col-md-12">
				<table class="tablapremio">
					<tr>
						<td><img src="<?php echo $image; ?>" class="img-responsive"/></td>
						<td>
							<strong><?php echo $award; ?></strong><br>
							<p><?php echo $include; ?><br>
							<?php if ($award_select['award_type'] != 'ranks') { ?>

							<strong>Cantidad</strong>: <?php echo $award_select['value']; ?><br>

							<?php 

							} else { 

								$query = $this->con->query("SELECT * FROM ranks WHERE id = '{$award_select['value']}'");
								$rank_select = mysqli_fetch_assoc($query);
								$rank = $rank_select['name'];

							?>

							<strong>Rango</strong>: <?php echo $rank; ?><br>

							<?php } ?>

							<?php if ($select_awrd['status'] != 'reclamed' || $select_awrd['status'] != 'declimed') { ?>

							<?php if ($count_refers != $award_select['refers_amount']) { ?>

							<b>Requerimiento</b>: <?php echo ($award_select['refers_amount'] - $count_refers); ?> referidos<br>

							<?php } elseif ($count_refers > $award_select['refers_amount']) { ?>

							<b>Ya has pasado de este premio</b>

							<?php } else { ?>

							<b>Tienes los suficientes referidos para reclamarlo</b>

							<?php } ?>

							<?php } ?>

							<strong>Estado</strong>: <?php echo $status; ?><br>
							<?php echo $award_desc; ?></p>
						</td>
					</tr>
				</table>
			</div>

			<?php } ?>

		</div>

      </div>

  	</div>
  </div>
</div>