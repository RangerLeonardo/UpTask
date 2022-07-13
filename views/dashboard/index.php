<?php include_once __DIR__ . "/header-dashboard.php"; ?>


<?php if (count($proyectos) === 0) { ?>

    <p class="no-proyectos">Aún no has creado un proyecto</p>
    <a href="/crear-proyecto">Crea tu Primer Proyecto Aquí</a>

<?php } else { ?>

    <ul class="listado-proyectos">

        <?php foreach ($proyectos as $proyecto) { ?>
            <a href=" /proyecto?id=<?php echo $proyecto->url; ?>"">
                <li class="proyectos">

                    <?php echo $proyecto->proyecto ?>
          
                </li>
            </a>



        <?php } ?>



    </ul>

<?php } ?>



<?php include_once __DIR__ . "/footer-dashboard.php"; ?>