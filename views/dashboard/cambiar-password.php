<?php include_once __DIR__."/header-dashboard.php";?>

    <div class="contenedor-sm">
        <?php include_once __DIR__."/../templates/alertas.php"?>

        <a href="/perfil" class="cambiar-pass">Volver a Perfil</a>


        <form class="formulario" method="POST" action="/cambiar-password">
            <div class="campo">
                <label for="password">Contraseña Actual</label>
                <input 
                type="password"
                name="password_actual"
                placeholder="Contraseña Actual"
                />
            </div>

            <div class="campo">
                <label for="password">Password Nuevo</label>
                <input 
                type="password"
                name="password_nuevo"
                placeholder="Contraseña Nueva"
                />
            </div>

            <input type="submit" value="Guardar Cambios">

        </form>
    </div>





<?php include_once __DIR__."/footer-dashboard.php";?>