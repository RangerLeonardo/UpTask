<?php include_once __DIR__ . "/header-dashboard.php"; ?>


    <div class="contedor-sm">
        <div class="contenedor derecha">
        <div class="contenedor-nueva-tarea">
            <button type="button" class="agregar-tarea" id="agregar-tarea">&#43; Nueva Tarea</button>
        </div>
        <div class="contenedor-nueva-tarea">
            <button type="button" class="eliminar-proyecto" id="eliminar-proyecto">Eliminar Proyecto</button>
        </div>
        </div>

        <div id="filtros" class="filtros">
            <div class="filtros-inputs">
                <h2>Filtros:</h2>
                    <div class="campo">
                        <label for="todas">Todas</label>
                        <input 
                        type="radio"
                        id="todas"
                        name="filtros"
                        value=""
                        checked>
                    </div>
                    <div class="campo">
                        <label for="completadas">Completadas</label>
                        <input 
                        type="radio"
                        id="completadas"
                        name="filtros"
                        value="1">
                    </div>
                    <div class="campo">
                        <label for="pendientes">Pendientes</label>
                        <input 
                        type="radio"
                        id="pendientes"
                        name="filtros"
                        value="0">
                    </div>
            </div>
        </div>
        <ul id="listado-tareas" class="lista-tareas">
        </ul>
    </div>



<?php include_once __DIR__ . "/footer-dashboard.php"; ?>

<?php

$script .='
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/build/js/tareas.js"></script>
<script src="/build/js/eliminar.js"></script>
';
?>