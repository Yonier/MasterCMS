<main id="lg">
    <div class="container-fluid">
        <div class="row gutter-10">
            <div class="col-lg-12">
                <div id="warBanner">
                    <i class="fa fa-exclamation-triangle fa-5x float-left" aria-hidden="true"></i>
                    <p><b>¡No compartas tu información privada con nadie!</b><br/>Nunca se sabe que está tramando el que esta detrás de la pantalla de su equipo.<br>Si algo extraño le sucede a su cuenta, informele de inmediato a un usuario del equipo staff, hacemos todo lo posible para que pueda disfrutar en el hotel una estancia segura.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="Box">
                    <ul id="leftMenu_C">
                        <li class="navButton lf_Selected" data-target="#contGeneral">
                            <i class="fa fa-cog fa-2x float-left" aria-hidden="true"></i>
                            <h3>Ajustes Generales</h3>
                            <span>Información básica de su usuario...</span>
                        </li>
                        <?php if (!$this->users->get('facebook_account')) { ?>
                            <li class="navButton" data-target="#contMail">
                                <i class="fa fa-envelope fa-2x float-left" aria-hidden="true"></i>
                                <h3>Correo electrónico</h3>
                                <span>Cambiar su correo electrónico...</span>
                            </li>
                            <li class="navButton" data-target="#contPassword">
                                <i class="fa fa-unlock-alt fa-2x float-left" aria-hidden="true"></i>
                                <h3>Contraseña</h3>
                                <span>Cambiar su contraseña...</span>
                            </li>
                        <?php } ?>
                        <li class="navButton" data-target="#contAccount">
                            <i class="fa fa-times fa-2x float-left" aria-hidden="true"></i>
                            <h3>Eliminar cuenta</h3>
                            <span>Eliminar su cuenta...</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="Box boxCont" id="contGeneral">
                    <div class="boxTitle">Ajustes Generales <i class="fa fa-cog fa-2x float-right" style="font-size:1.5rem" aria-hidden="true"></i></div>
                    <div class="boxContent">
                        <form method="POST" action="" id="generalFormulary">
                            <!-- <label for="mottoUpdate">Misión:</label>
                            <p>Mensaje representado en el hotel abajo de su avatar.</p>
                            <input type="text" name="motto">
                            <br /><br /> -->
                            <label for="letters">Color de letra:</label>
                            <p>Elije el color de las letras de tu chat.</p>
                            <select name="chat_color" id="letters">
                                <option value="0"<?php if ($this->users->get('chat_color') == 0) { echo ' selected'; } ?>>Ninguno</option>
                                <option value="blue"<?php if ($this->users->get('chat_color') == '@blue@') { echo ' selected'; } ?>>Azul</option>
                                <option value="green"<?php if ($this->users->get('chat_color') == '@green@') { echo ' selected'; } ?>>Verde</option>
                                <option value="red"<?php if ($this->users->get('chat_color') == '@red@') { echo ' selected'; } ?>>Rojo</option>
                                <option value="cyan"<?php if ($this->users->get('chat_color') == '@cyan@') { echo ' selected'; } ?>>Cyan</option>
                                <option value="purple"<?php if ($this->users->get('chat_color') == '@purple@') { echo ' selected'; } ?>>Lila</option>
                            </select>
                            <hr>
                            <label>Solicitudes de amistad</label>
                            <p>¿Los otros {@name}s pueden enviarte solicitudes de amigo?</p>
                            <div id="radioFR" class="buttonSet">
                                <input type="radio" id="radioFR1" name="allowfr" value="0"<?php if (!$this->users->get('block_newfriends')) { echo ' checked'; } ?>><label for="radioFR1">Sí</label>
                                <input type="radio" id="radioFR3" name="allowfr" value="1"<?php if ($this->users->get('block_newfriends')) { echo ' checked'; } ?>><label for="radioFR3">No</label>
                            </div>
                            <hr>
                            <label>Tradear</label>
                            <p>¿Los otros {@name}s pueden tradear contigo?</p>
                            <div id="radioTR" class="buttonSet">
                                <input type="radio" id="radioTR1" name="allowtr" value="0"<?php if (!$this->users->get('block_trade')) { echo ' checked'; } ?>><label for="radioTR1">Sí</label>
                                <input type="radio" id="radioTR3" name="allowtr" value="1"<?php if ($this->users->get('block_trade')) { echo ' checked'; } ?>><label for="radioTR3">No</label>
                            </div>
                            <hr>
                            <label>Perfiles privados</label>
                            <p>¿Los otros {@name}s pueden ver tu perfil?</p>
                            <div id="radioPR" class="buttonSet">
                                <input type="radio" id="radioPR1" name="allowpr" value="0"<?php if (!$this->users->get('block_view_profile')) { echo ' checked'; } ?>><label for="radioPR1">Sí</label>
                                <input type="radio" id="radioPR3" name="allowpr" value="1"<?php if ($this->users->get('block_view_profile')) { echo ' checked'; } ?>><label for="radioPR3">No</label>
                            </div>
                            <hr>
                            <label>Chat antigüo</label>
                            <p>¿Prefieres el chat antiguo de {@name}?</p>
                            <div id="radioVE" class="buttonSet">
                                <input type="radio" id="radioVE1" name="oldchat" value="1"<?php if ($this->users->get('prefer_old_chat')) { echo ' checked'; } ?>><label for="radioVE1">Sí</label>
                                <input type="radio" id="radioVE3" name="oldchat" value="0"<?php if (!$this->users->get('prefer_old_chat')) { echo ' checked'; } ?>><label for="radioVE3">No</label>
                            </div>
                            <hr>
                            <label>Ignorar invitaciones por consola</label>
                            <p>¿Quieres recibir invitaciones por consola?</p>
                            <div id="radioOS" class="buttonSet">
                                <input type="radio" id="radioOS1" name="invitations" value="1"<?php if ($this->users->get('ignoreRoomInvitations')) { echo ' checked'; } ?>><label for="radioOS1">Sí</label>
                                <input type="radio" id="radioOS3" name="invitations" value="0"<?php if (!$this->users->get('ignoreRoomInvitations')) { echo ' checked'; } ?>><label for="radioOS3">No</label>
                            </div>
                            <hr>
                            <label>Enfocar usuario</label>
                            <p>¿Quieres enfocar los usuarios dentro del hotel?</p>
                            <div id="radioEN" class="buttonSet">
                                <input type="radio" id="radioEN1" name="focus" value="0"<?php if (!$this->users->get('dontfocususers')) { echo ' checked'; } ?>><label for="radioEN1">Sí</label>
                                <input type="radio" id="radioEN3" name="focus" value="1"<?php if ($this->users->get('dontfocususers')) { echo ' checked'; } ?>><label for="radioEN3">No</label>
                            </div>
                            <hr>
                            <input type="submit" class="btn btn-success btn-radius" value="Guardar" name="general" id="generalButton">
                        </form>
                    </div>
                </div>
                <?php if (!$this->users->get('facebook_account')) { ?>
                <div class="Box boxCont" id="contMail" style="display:none;">
                    <div class="boxTitle">Correo electrónico <i class="fa fa-envelope fa-2x float-right" style="font-size:1.5rem" aria-hidden="true"></i></div>
                    <div class="boxContent">
                        <form method="POST" action="" id="mailFormulary">
                            <label for="oldMail">Correo electrónico antigüo:</label>
                            <p>Por favor, introduzca su correo electronico antigüo para poder verificar su cuenta.</p>
                            <input type="mail" id="oldMail" name="oldmail">
                            <hr>
                            <label for="newMail">Nueva dirección de correo electrónico:</label>
                            <p>Introduce tu nueva dirección de correo electrónico.</p>
                            <input type="mail" id="newMail" name="newmail">
                            <hr>
                            <label for="newMailRepeat">Repíte el correo electrónico:</label>
                            <p>Introduce tu nueva dirección de correo electrónico de nuevo para evitar errores de escritura.</p>
                            <input type="mail" id="newMailRepeat" name="rnewmail">
                            <hr>
                            <input type="submit" class="btn btn-success btn-radius" value="Guardar" name="mail" id="mailButton">
                        </form>
                    </div>
                </div>
                <div class="Box boxCont" id="contPassword" style="display:none;">
                    <div class="boxTitle">Contraseña <i class="fa fa-unlock-alt fa-2x float-right" style="font-size:1.5rem" aria-hidden="true"></i></div>
                    <div class="boxContent">
                        <form method="POST" action="" id="passwordFormulary">
                            <label for="oldPassword">Contraseña antigüa:</label>
                            <p>Esto es necesario para verificar que usted es el propietario de la cuenta.</p>
                            <input type="password" id="oldPassword" name="oldpassword">
                            <hr>
                            <label for="newPassword">Contraseña nueva:</label>
                            <p>Su nueva contraseña debe contener por lo menos - carácteres.</p>
                            <input type="password" id="newPassword" name="newpassword">
                            <label for="newPasswordRepeat">Repíte tu contraseña nueva:</label>
                            <p>Para evitar errores de escritura.</p>
                            <input type="password" id="newPasswordRepeat" name="rnewpassword">
                            <hr>
                            <input type="submit" class="btn btn-success btn-radius" value="Guardar" name="password" id="passwordButton">
                        </form>
                    </div>
                </div>
                <?php } ?>
                <div class="Box boxCont" id="contAccount" style="display:none;">
                    <div class="boxTitle">Eliminar Cuenta <i class="fa fa-times fa-2x float-right" style="font-size:1.5rem" aria-hidden="true"></i></div>
                    <div class="boxContent">
                        <form method="POST" action="" id="deleteFormulary">
                            <h3>¿Estás seguro que quieres eliminar tu cuenta?<br></h3>
                            <p><i>Si la eliminas perderás todo dentro de el hotel.</i></p>
                            <div class="togglebutton">
                                <label class="agb">
                                <input type="checkbox" name="accept" value="1"><span class="toggle"></span> Acepto las consecuencias de eliminar mi cuenta
                                </label>
                            </div>
                            <hr>
                            <input type="submit" class="btn btn-danger btn-radius" value="Eliminar cuenta" name="delete" id="deleteButton">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>