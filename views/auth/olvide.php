<div class="contenedor olvide">

<?php include_once __DIR__. "/../templates/nombre-sitio.php"?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Recuperar Contraseña</p>

        <?php include_once __DIR__."/../templates/alertas.php"?>


        <form action="/olvide" class="formulario" method="POST">
            <div class="campo">
                <label for="email">Email</label>
                <input 
                type="email"
                id="email"
                placeholder="Correo Electronico"
                name="email"
                />
            </div>



            <input type="submit" class="boton" value="Recuperar Contraseña">

        </form>

        <div class="acciones">
            <a href="/crear">¿Aún no tienes una cuenta? Crea una</a>
            <a href="/">¿Ya tienes cuenta? Inicia Sesión</a>
        </div>


    </div>


</div>