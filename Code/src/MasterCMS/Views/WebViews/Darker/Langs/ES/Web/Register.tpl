<main>
    <div class="boxContent">
        <form method="post" id="registerFormulary">
            <section id="registerBox">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="username">Nombre de usuario</label>
                            <input type="text" name="username" id="username">
                            <p>Sé creativo, ¡No podrás cambiar tu nombre después!</p>
                            <label for="password">Contraseña</label>
                            <input type="password" name="password" id="password">
                            <p>¡Recuerda no compartir tu contraseña con nadie!</p>
                            <label for="rpassword">Repíta su contraseña:</label>
                            <input type="password" name="rpassword" id="rpassword">
                            <p>Repíte tu contraseña para asegurarnos que la has escrito bien</p>
                            <div class="clear"></div>
                            <label for="mail">Correo electrónico</label>
                            <input type="email" name="mail" id="mail">
                            <p>Su dirección de correo electrónico es muy importante en caso de que olvides tu contraseña</p>
                        </div>
                        <div class="col-lg-6">
                            <label for="rmail">Repíta su correo electrónico</label>
                            <input type="email" name="rmail" id="rmail">
                            <p>Repíte tu correo electrónico para evitar errores</p>
                            <label for="gender">Tu género</label>
                            <select name="gender" id="gender">
                                <option value="0" disabled="" selected>Género</option>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                            </select>
                            <p>Selecciona tu sexo</p>                            
                            <label for="agb" class="agb">
                                <input type="checkbox" name="terms" value="1" id="agb"> Acepto los <a href="{@url}/web/terms" target="_blank">Términos y condiciones</a>
                            </label>
                            <button type="submit" class="btn btn-success btn-lg" id="register">Regístrarme</button>
                            <button class="btn btn-primary btn-lg"><a href="{@fbLoginUrl}">Regístrarme con Facebook</a></button>                            
                            <button class="btn btn-danger btn-lg"><a href="/">Cancelar</a></button>
                        </div>
                    </div>
                </div>
            </section>
        </form>
    </div>
</main>