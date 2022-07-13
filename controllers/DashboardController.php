<?php
namespace Controllers;

use Model\Proyecto;
use Model\Usuario;
use MVC\Router;

class DashboardController{

    public static function index(Router $router){
        session_start();
        isAuth();
        
        $id=$_SESSION["id"];
        $proyectos=Proyecto::belongsTo("propietarioId",$id);
        
        $router->render("dashboard/index",[
            "titulo"=>"Proyectos",
            "proyectos" => $proyectos

        ]);
    }

    public static function crear_proyecto(Router $router){
        session_start();
        isAuth();
        $alertas=[];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $proyecto = new Proyecto($_POST);
            
            // validación
            $alertas = $proyecto->validarProyecto();


            if(empty($alertas)) {
                // Generar una URL única 
                $hash = md5(uniqid());
                $proyecto->url = $hash;

               // Almacenar el creador del proyecto
               $proyecto->propietarioId = $_SESSION['id'];

               // Guardar el Proyecto
               $proyecto->guardar();

                 // Redireccionar
                 header('Location: /proyecto?id=' .$proyecto->url);
                }
        }

        $router->render('dashboard/crear-proyecto', [
            'alertas' => $alertas,
            'titulo' => 'Crear Proyecto'
        ]);
    }

    public static function proyecto(Router $router){
        session_start();
        isAuth();
        
        $token=$_GET["id"];

        if(!$token) header("Location: /dashboard");
        //revisar que el proyecto sea de la persona que lo creó
        $proyecto= Proyecto::where("url",$token);
        if($proyecto->propietarioId !== $_SESSION["id"]){
            header("Location: /dashboard");
        }

        $router->render("dashboard/proyecto",[
            "titulo"=>$proyecto->proyecto

        ]);
    }




    public static function perfil(Router $router){
        session_start();
        isAuth();
        $alertas=[];
        $usuario=Usuario::find($_SESSION["id"]);

        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validar_perfil();

            if(empty($alertas)){
                $existeUsuario= Usuario::where("email", $usuario->email);

                if($existeUsuario && $existeUsuario->id !==$usuario->id){
                    //Alerta de que pone un correo igual
                    Usuario::setAlerta("error","Correo ya registrado");
                    $alertas = $usuario->getAlertas();


                }
                else{
                //guardar los cambios del usuario
                $usuario->guardar();

                Usuario::setAlerta("exito","Cambios Hechos Correctamente");
                $alertas = $usuario->getAlertas();

                //asignar el nombre nuevo a la barra
                $_SESSION["nombre"] = $usuario->nombre;
                }


            }


        }

        $router->render("dashboard/perfil",[
            "titulo"=>"Perfil",
            "usuario" => $usuario,
            "alertas" => $alertas
        ]);
    }


    public static function cambiar_password(Router $router){
        session_start();
        isAuth();
        $alertas=[];

        if($_SERVER["REQUEST_METHOD"]==="POST"){
            $usuario = Usuario::find($_SESSION["id"]);

            //sincronizar con los datos del usuario para que se puedan guardar los cambios que hemos hecho
            $usuario->sincronizar($_POST);

            $alertas= $usuario->nuevo_password();

            if(empty($alertas)){
                $resultado =  $usuario->comprobar_password();
                if($resultado){
                    //si el password coincide con el de la base de datos lo cambiamos
                    $usuario->password=$usuario->password_nuevo;
                    //eliminar propiedades no necesarias para que no hagan espacio
                    unset($usuario->password_actual);
                    unset($usuario->password_nuevo);

                    //hashear el nuevo password
                    $usuario->hashPassword();

                    //guardamos la contraseña nueva, aunque realmente revisa todos los datos, los actualiza y guarda
                    $resultado = $usuario->guardar();

                    if($resultado){
                        Usuario::setAlerta("exito", "Contraseña Nueva Guardada Correctamente");
                        $alertas = $usuario->getAlertas();
                    }
                    

                }else{
                    //si no coincide le mandamos una alerta
                    Usuario::setAlerta("error", "Password Incorrecto");
                    $alertas = $usuario->getAlertas();
                }
            }
        }


        $router->render("dashboard/cambiar-password",[
            "titulo" => "Cambiar Contraseña",
            "alertas" => $alertas
        ]);
    }

}