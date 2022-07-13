<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController{
    public static function login(Router $router){
        $alertas=[];



        if($_SERVER["REQUEST_METHOD"]==="POST"){
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarLogin();

            if (empty($alertas)){
                //Verificar que el usuario exista
                
                $usuario = Usuario::where("email",$usuario->email);
                unset($usuario->password2);

                if(!$usuario || !$usuario->confirmado){
                    Usuario::setAlerta("error", "El usuario no existe o No ha confirmado cuenta");
                }
                else{
                    //el usuario sí existe 
                    if(password_verify($_POST["password"],$usuario->password)){
                        //iniciar la sesión del usuario
                        session_start();
                        $_SESSION["id"] = $usuario->id;
                        $_SESSION["nombre"] = $usuario->nombre;
                        $_SESSION["email"] = $usuario->email;
                        $_SESSION["login"] = true;

                        header("Location: /dashboard");

                    }else{
                        Usuario::setAlerta("error", "Contraseña Incorrecta");
                    }
                }

            }


        }

        $alertas=Usuario::getAlertas();
        //render a la vista
        $router->render("auth/login",[
            "titulo" => "Iniciar Sesión",
            "alertas" => $alertas
        ]);

    }

    //cerrar sesion
    public static function logout(){
        session_start();
        $_SESSION=[];
        header("Location: /");
    }

    public static function crearCuenta(Router $router){

        $alertas=[];

        $usuario = new Usuario();

        if($_SERVER["REQUEST_METHOD"]==="POST"){
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();
            $existeUsuario = Usuario::where("email",$usuario->email);

            if(empty($alertas)){
                if($existeUsuario){
                    Usuario::setAlerta("error","El Usuario Ya Está Registrado");
                    $alertas = Usuario::getAlertas();
                }
                else{
                    //hashear el password
                    $usuario->hashPassWord();

                    //eliminar password2 del objeto Usuario
                    unset($usuario->password2);

                    //generar el token
                    $usuario->crearToken();

                    //crear un nuevo usuario
                    $resultado = $usuario->guardar();
                    
                    //enviar email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);

                    $email->enviarConfirmacion();

                    if($resultado){
                        header("Location: /mensaje");
                    }
                }
            }


        }

                //render a la vista
                $router->render("auth/crear",[
                    "titulo" => "Crear Cuenta",
                    "usuario" => $usuario,
                    "alertas" => $alertas
                ]);
        
    }

    
    public static function olvide(Router $router){
        $alertas=[];
        if($_SERVER["REQUEST_METHOD"]==="POST"){
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarEmail();
            if(empty($alertas)){
                //buscar al usuario
                $usuario = Usuario::where("email", $usuario->email);
                if($usuario && $usuario->confirmado){
                    //generar un nuevo token
                    $usuario->crearToken();
                    unset($usuario->password2);
                    //actualizar el usuario
                    $usuario->guardar();
                    //enviar el email
                    $email=new Email ($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();
                    
                    //imprimir la alerta
                    Usuario::setAlerta("exito","Te hemos enviado un email con las instrucciones");
                }
                else{
                    Usuario::setAlerta("error","El usuario no existe o No está confirmado");

                }
            }
        }
        $alertas=Usuario::getAlertas();
        $router->render("auth/olvide",[
            "titulo" => "Recuperar Contraseña",
            "alertas" => $alertas
        ]);
    }

    public static function restablecer_contraseña(Router $router){

        $token=s($_GET["token"]);
        $mostrar=true;

        if(!$token) header("Location: /");

        //identificar el usuario con este token
        $usuario = Usuario::where("token",$token);

        if(empty($usuario)){
            Usuario::setAlerta("error","Token no Valido");
            $mostrar=false;
        }

        if($_SERVER["REQUEST_METHOD"]==="POST"){
            //añadir el password del usuario que va a cambiar
            $usuario->sincronizar($_POST);
            unset($usuario->password2);
            //validar el password
            $alertas = $usuario->validarPassword();

            if(empty($alertas)){
            //hashear password
                $usuario->hashPassword();
            //eliminar token
                $usuario->token=null;
            //guardar el usuario en la BD
            $resultado=$usuario->guardar();
            //redireccionarlo al login
                if($resultado){
                    header("Location: /");
                }
            }

        }
        $alertas=Usuario::getAlertas();
        $router->render("auth/restablecer-contraseña",[
            "titulo" => "Restablecer Contraseña",
            "alertas" => $alertas,
            "mostrar" => $mostrar
        ]);
    }

    public static function mensaje_Confirmar(Router $router){
        $router->render("auth/mensaje",[
            "titulo" => "Confirmar Cuenta",
        ]);
    }

    public static function confirmar_Cuenta(Router $router){

        $token = s($_GET["token"]);

        if(!$token) header("Location: /");

        //Encontrar al usuario con este token
        $usuario = Usuario::where("token", $token);

        if(empty($usuario)){
            //modificaron el token
            Usuario::setAlerta("error","Token No Valido");
        }
        else{
            //confirmamos la cuenta
            $usuario->confirmado=1;
            $usuario->token = null;
            unset($usuario->password2);

            //guardar en la base de datos
            $usuario->guardar();

            Usuario::setAlerta("exito","Cuenta Creada Correctamente");
        }

        $alertas = Usuario::getAlertas();

        $router->render("auth/confirmado",[
            "titulo" => "Cuenta Confirmada",
            "alertas" => $alertas
        ]);
    }



}