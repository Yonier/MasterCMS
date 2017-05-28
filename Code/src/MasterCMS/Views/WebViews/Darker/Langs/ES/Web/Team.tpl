<main id="lg">
    <div class="container-fluid">
        <div class="row gutter-10">
            <div class="col-lg-8">
                <?php

                    foreach ($this->hotel->getMaster('max', true) as $key => $value) {

                        $queryRank = $this->con->query("SELECT * FROM ranks WHERE id = '{$value}'");
                        $queryUser = $this->con->query("SELECT * FROM users WHERE rank = '{$value}'");

                        if ($this->con->num_rows($queryUser) == 0) {

                            $selectRank = mysqli_fetch_assoc($queryRank);

                            if (!$selectRank['fuse_hide_staff']) {

                ?>
                                <h3><?php echo $selectRank['name']; ?> <div class="colorRank float-right" style="background-color: <?php echo $selectRank['color']; ?>;"> </div></h3>
                                <div class="Box">
                                    <div class="boxContent">
                                        <div class="comboPlate">
                                            <div class="comboUser">
                                                <div class="comboAvatar"><div class="comboImage float-left"> </div></div>
                                                <span>
                                                    <h4>No hay usuarios con éste rango</h4>
                                                </span>                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                <?php

                            }
                        }
                        else {

                            $selectRank = mysqli_fetch_assoc($queryRank);                    

                            if (!$selectRank['fuse_hide_staff']) {

                ?>

                            <h3><?php echo $selectRank['name']; ?> <div class="colorRank float-right" style="background-color: <?php echo $selectRank['color']; ?>;"> </div></h3>
                            <div class="Box">
                                <div class="boxContent">
                                <div class="comboPlate">

                <?php

                                while ($select = mysqli_fetch_assoc($queryUser)) {

                                    if (!$select['staff_occult']) {

                                    $staff_online = $this->con->num_rows("SELECT * FROM users_online WHERE user_id = '{$select['id']}'");

                ?>
                        
                            <div class="comboUser">
                                <a href="{@url}/web/profile/<?php echo $select['id']; ?>"><div class="comboAvatar <?php if ($select['online'] == 1) { echo 'comboOnline'; } ?>"><div class="comboBadge" style="background: url('{@badges_cdn}/<?php echo $selectRank['badge']; ?>.gif');"> </div><div class="comboImage float-left" style="background: url('{@habbo_img}<?php echo $select['look']; ?>&gesture=sml&size=b');"> </div></div></a>
                                <span>
                                    <h6><?php echo $select['username']; ?></h6>
                                    <p><?php echo $select['motto']; ?></p>
                                    <p><?php if(!$select['work']) { echo 'No tengo tarea'; } else { echo $select['work']; } ?></p>
                                </span>                                
                            </div>
                            
                <?php

                                    }
                                }

                ?>

                        </div>
                    </div>
                </div>

                <?php

                            }
                        }
                    }

                    foreach ($this->hotel->getMaster('medium', true) as $key => $value) {

                        $queryRank = $this->con->query("SELECT * FROM ranks WHERE id = '{$value}'");
                        $queryUser = $this->con->query("SELECT * FROM users WHERE rank = '{$value}'");

                        if ($this->con->num_rows($queryUser) == 0) {

                            $selectRank = mysqli_fetch_assoc($queryRank);

                            if (!$selectRank['fuse_hide_staff']) {

                ?>
                                <h3><?php echo $selectRank['name']; ?> <div class="colorRank float-right" style="background-color: <?php echo $selectRank['color']; ?>;"> </div></h3>
                                <div class="Box">
                                    <div class="boxContent">
                                        <div class="comboPlate">
                                            <div class="comboUser">
                                                <div class="comboAvatar"><div class="comboImage float-left"> </div></div>
                                                <span>
                                                    <h4>No hay usuarios con éste rango</h4>
                                                </span>                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                <?php

                            }
                        }
                        else {

                            $selectRank = mysqli_fetch_assoc($queryRank);                    

                            if (!$selectRank['fuse_hide_staff']) {

                ?>

                            <h3><?php echo $selectRank['name']; ?> <div class="colorRank float-right" style="background-color: <?php echo $selectRank['color']; ?>;"> </div></h3>
                            <div class="Box">
                                <div class="boxContent">
                                <div class="comboPlate">

                <?php

                                while ($select = mysqli_fetch_assoc($queryUser)) {

                                    if (!$select['staff_occult']) {

                                    $staff_online = $this->con->num_rows("SELECT * FROM users_online WHERE user_id = '{$select['id']}'");

                ?>
                        
                            <div class="comboUser">
                                <a href="{@url}/web/profile/<?php echo $select['id']; ?>"><div class="comboAvatar <?php if ($select['online'] == 1) { echo 'comboOnline'; } ?>"><div class="comboBadge" style="background: url('{@badges_cdn}/<?php echo $selectRank['badge']; ?>.gif');"> </div><div class="comboImage float-left" style="background: url('{@habbo_img}<?php echo $select['look']; ?>&gesture=sml&size=b');"> </div></div></a>
                                <span>
                                    <h6><?php echo $select['username']; ?></h6>
                                    <p><?php echo $select['motto']; ?></p>
                                    <p><?php if(!$select['work']) { echo 'No tengo tarea'; } else { echo $select['work']; } ?></p>
                                </span>                                
                            </div>
                            
                <?php

                                    }
                                }

                ?>

                        </div>
                    </div>
                </div>

                <?php

                            }
                        }
                    }

                ?>

            </div>
            <div class="col-lg-4">
                <div class="Box">
                    <div class="boxTitle">Información</div>
                    <div class="boxContent">
                        Los {@name}s que están en esta página, son parte del equipo de {@name} hotel,
                        <img src="{@cdn}/Images/avatarimage.png" align="right"> se aseguran de que la vida cotidiana en el hotel funcione sin problemas. Además se encargan de la información, eventos y entre muchas cosas más del hotel, así el aburrimiento desaparece, si tienes alguna duda o pregunta, ¡Habla con uno de éstos {@name}s!
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>