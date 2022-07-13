<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\DashboardController;
use Controllers\LoginController;
use Controllers\ProyectoController;
use Controllers\TareaController;
use MVC\Router;
$router = new Router();

//login
$router->get("/",[LoginController::class,"login"]);
$router->post("/",[LoginController::class,"login"]);
$router->get("/logout",[LoginController::class,"logout"]);

//crear cuenta
$router->get("/crear",[LoginController::class,"crearCuenta"]);
$router->post("/crear",[LoginController::class,"crearCuenta"]);

//para cuando olvida el password y quiere recuperarlo
$router->get("/olvide",[LoginController::class,"olvide"]);
$router->post("/olvide",[LoginController::class,"olvide"]);

//Añadir la nueva contraseña para una cuenta olvidada
$router->get("/restablecer-contraseña",[LoginController::class,"restablecer_contraseña"]);
$router->post("/restablecer-contraseña",[LoginController::class,"restablecer_contraseña"]);

//confirmar la cuenta
$router->get("/mensaje",[LoginController::class,"mensaje_Confirmar"]);
$router->get("/confirmado",[LoginController::class,"confirmar_Cuenta"]);

//zona de proyectos-después de iniciar sesión
$router->get("/dashboard",[DashboardController::class,"index"]);
$router->get("/crear-proyecto",[DashboardController::class,"crear_proyecto"]);
$router->post("/crear-proyecto",[DashboardController::class,"crear_proyecto"]);
$router->get("/proyecto",[DashboardController::class,"proyecto"]);
$router->get("/perfil",[DashboardController::class,"perfil"]);
$router->post("/perfil",[DashboardController::class,"perfil"]);
$router->get("/cambiar-password",[DashboardController::class,"cambiar_password"]);
$router->post("/cambiar-password",[DashboardController::class,"cambiar_password"]);


//API para las tareas
$router->get("/api/tareas",[TareaController::class,"index"]);
$router->post("/api/tarea",[TareaController::class,"crear"]);
$router->post("/api/tarea/actualizar",[TareaController::class,"actualizar"]);
$router->post("/api/tarea/eliminar",[TareaController::class,"eliminar"]);






// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();