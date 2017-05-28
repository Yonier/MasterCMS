<main id="lg">
    <div class="container">
        <div class="row gutter-3">
            <div class="col-lg-4">
                <h3>{@user_username}</h3>
                <div class="Box">
                    <div id="homeBox"><div id="homeAvatar" style="background:  url({@habbo_img}{@look}&gesture=sml&size=l)"> </div></div>
                    <div id="homeFooter">
                        <p><strong>Nombre de Usuario: </strong> {@user_username}</p>
                        <p><strong>Misión: </strong> {@user_motto}</p>
                    </div>
                </div>
                <div class="Box">
                    <div class="boxTitle">Fotos más recientes</div>
                    <div class="boxContent boxScroll" style="height: 18.7rem;padding: 1rem;">
                        <ul id="homePhotos">
                            <li style="background: url('320x320');"> </li>
                        </ul>                        
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="Box">
                    <div class="boxTitle">Perfil de {@user_username}</div>
                    <div class="boxContent">
                        <p>Bienvenido a mi perfil {@username}, aquí podrás ver mi información básica en el hotel.</p>
                    </div>
                </div>
                <div class="Box">
                    <div class="boxTitle">Placas</div>
                    <div class="boxContent">
                        <ul id="badgeContainer">
                            <?php

                                $badges_Query = $this->con->query("SELECT badge_id FROM user_badges WHERE user_id = '{$user_id}' LIMIT 20");

                                if ($this->con->num_rows($badges_Query) == 0) {

                                    echo '<p>{@user_username} aún no tiene placas</p>';

                                }
                                else{

                                    while ($badge = mysqli_fetch_assoc($badges_Query)) {

                            ?>
                                <li style="background: url({@badges_cdn}/<?php echo $badge['badge_id']; ?>.gif)"> </li>
                            <?php  }  }  ?>
                        </ul>
                    </div>
                </div>
                <div class="Box">
                    <div class="boxTitle">Mis habitaciones</div>
                    <div class="boxContent boxScroll" style="height: 15rem;">
                        <ul id="hotRooms">
                            <?php

                                $room_query = $this->con->query("SELECT * FROM rooms WHERE owner = '{$user_id}' OR owner = '{$user_username}' ORDER BY id DESC");

                                if ($this->con->num_rows($room_query) == 0) {

                                    echo '<p class="text-center" style="margin-top: 5rem;">{@user_username} aún no tiene habitaciones.</p>';

                                } else {

                                while($room = mysqli_fetch_assoc($room_query)) {

                                    $owner_query = $this->con->query("SELECT * FROM users WHERE id = '{$room['owner']}' OR username = '{$room['owner']}' ORDER BY users_now DESC");
                                    $owner = mysqli_fetch_assoc($owner_query);

                            ?>
                                    <li>
                                        <div class="<?php if($room['users_now'] == 0){ echo 'hrImage'; } elseif($room['users_now'] <= 5){ echo 'hrImage_2'; } elseif($room['users_now'] <= 15){ echo 'hrImage_3'; } elseif($room['users_now'] <= 35){ echo 'hrImage_4'; } elseif($room['users_now'] <= 100){ echo 'hrImage_5'; } ?>"> </div>
                                        <div class="hrInfo">
                                            <p><?php echo $this->protection->filter($room['caption']); ?></p>
                                        </div>
                                        <div class="hrUsers"><?php echo $room['users_now']; ?>/<?php echo $room['users_max']; ?> Usuarios Dentro</div>
                                    </li>
                            <?php  }  }  ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>