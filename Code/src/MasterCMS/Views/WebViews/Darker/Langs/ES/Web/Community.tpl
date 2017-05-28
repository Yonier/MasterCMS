<main id="lg">
    <div class="container-fluid">
        <div class="row gutter-10">
            <div class="col-lg-6">

                <?php

                    $news_query = $this->con->query("SELECT * FROM news ORDER BY id DESC LIMIT 12");
                    $news_num = $this->con->num_rows($news_query);

                    if ($news_num == 0) {

                ?>

                        <div class="Box">
                            <div class="boxTitle">¡Oh, bobba! no existe ningúna noticia</div>
                            <div class="boxContent">
                                <center>
                                    <img src="{@cdn}/Images/404.png" alt="Error 404">
                                    <p><div style="text-transform: uppercase;">Vuelve en otra ocasión, probablemente hayan noticias.</div></p>
                                </center>
                            </div>
                        </div>

                <?php

                    }
                    else{

                ?>

                <div id="nSlider">
                    <ul>
                        <?php

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

                <?php } ?>                

            </div>
            <div class="col-lg-6">
                <div class="Box">
                    <div class="boxTitle">Salas Populares</div>
                    <div class="boxContent boxScroll" style="height: 13.5rem;">
                        <ul id="hotRooms">
                            <?php

                                $room_query = $this->con->query('SELECT * FROM rooms HAVING users_now > 0 ORDER BY users_now DESC LIMIT 10');

                                if ($this->con->num_rows($room_query) == 0) {

                                    echo '<p class="text-center" style="margin-top: 5rem;">No hay salas disponibles en éste momento.</p>';

                                }
                                else{

                                while($room = mysqli_fetch_assoc($room_query)){

                                    $owner_query = $this->con->query('SELECT * FROM users WHERE id = "'. $room['owner'] .'" ');
                                    $owner = mysqli_fetch_assoc($owner_query);

                            ?>
                            <li>
                                <div class="hrImage <?php if($room['users_now'] <= 5){ echo 'hrImage_2'; } elseif($room['users_now'] <= 15){ echo 'hrImage_3'; } elseif($room['users_now'] <= 35){ echo 'hrImage_4'; } elseif($room['users_now'] <= 100){ echo 'hrImage_5'; } ?>"> </div>
                                <div class="hrInfo">
                                    <p><?php echo $this->protection->filter($room['caption']); ?></p>
                                    <span>Sala creada por <?php echo $owner['username']; ?></span>
                                </div>
                                <div class="hrUsers"><?php echo $room['users_now']; ?>/<?php echo $room['users_max']; ?> Usuarios Dentro</div>
                            </li>
                            <?php } } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="Box">
                    <div class="boxTitle">Facebook</div>
                    <div class="boxContent" style="height: 19rem;">
                        <div class="fb-page" data-href="http://www.facebook.com/{@facebook}" data-tabs="timeline" data-width="1000000px" data-height="268" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><div class="fb-xfbml-parse-ignore"></div></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="Box">
                    <div class="boxTitle">Usuario al Azar</div>
                    <div class="boxContent" style="height: 19rem;">

                        <?php

                            $rand_user = $this->con->query("SELECT username, look FROM users ORDER BY RAND() LIMIT 1");
                            $user = mysqli_fetch_assoc($rand_user);

                        ?>

                        <h5 class="text-center"><b><?php echo $this->con->num_rows("SELECT * FROM users"); ?></b> {@name}s Registrados</h5>
                        <h6 class="text-center" style="margin-bottom: .1rem;">¡Hola soy <b><?php echo $user['username']; ?></b>!</h6>
                        <div class="iconPacket"></div>
                        <div id="avatarPlate"><div id="avatarImage" style="background: url('{@habbo_img}<?php echo $user['look'];?>&amp;gesture=sml&amp;size=l&amp;direction=4&amp;head_direction=3&amp;') no-repeat;background-position-x: -0.5rem;"> </div></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="Box">
                    <div class="boxTitle">Últimas actualizaciones</div>
                    <div class="boxContent boxScroll" style="height: 19rem;">
                        <ul id="lastUpdates">
                            <?php

                                $row = $this->con->query("SELECT * FROM hotel_updates ORDER BY id DESC");
                                
                                while($u = mysqli_fetch_assoc($row)){

                                    if (date('H', $u['timestamp']) >= 12) {
                                        $hour = date('H:i', $u['timestamp']) . ' PM';
                                    } else {
                                        $hour = date('H:i', $u['timestamp']) . ' AM';
                                    }

                            ?>
                            <li>
                                <b><?php echo date('d/m/Y', $u['timestamp']); ?> a las <?php echo $hour; ?></b>
                                <p><?php echo $u['description'];?></p>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>