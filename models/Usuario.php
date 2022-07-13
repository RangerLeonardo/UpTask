<?php
namespace Model;

class Usuario extends ActiveRecord{
    protected static $tabla= "usuarios";
    protected static $columnasDB=["id","nombre", "email","password","token", "confirmado"];

    public function __construct($args =[]){

        $this->id = $args["id"] ?? null;
        $this->nombre = $args["nombre"] ?? "";
        $this->email = $args["email"] ?? "";
        $this->password = $args["password"] ?? "";
        $this->password2 = $args["password2"] ?? "";
        $this->password_actual = $args["password_actual"] ?? "";
        $this->password_nuevo = $args["password_nuevo"] ?? "";
        $this->token = $args["token"] ?? "";
        $this->confirmado = $args["confirmado"] ?? 0;
    }

    //validar el login del usuario
    public function validarLogin(){
        if(!$this->email){
            self::$alertas["error"][] = "El Correo es Obligatorio";
        }
        
        if (!filter_var($this->email,FILTER_VALIDATE_EMAIL)){
            self::$alertas["error"][] = "Email NO Valido";
            
        }
        if(!$this->password){
            self::$alertas["error"][] = "La Contraseña es obligatoria";
        }

        return self::$alertas;
    }

    


    //validación de creación de cuentas
    public function validarNuevaCuenta(){
        if(!$this->nombre){
            self::$alertas["error"][] = "El Nombre es Obligatorio";
        }
        if(!$this->email){
            self::$alertas["error"][] = "El Correo es Obligatorio";
        }
        if(!$this->password){
            self::$alertas["error"][] = "La Contraseña es obligatoria";
        }
        if(strlen(!$this->password) > 6){
            self::$alertas["error"][] = "La Contraseña debe ser Mayor a 6 Caracteres";
        }
        if($this->password !== $this->password2){
            self::$alertas["error"][] = "Las Contraseñas son Diferentes";

        }
        return self::$alertas;
    }
    //valida el email en olvide
    public function validarEmail(){
        if(!$this->email){
            self::$alertas["error"][] = "El Email es Obligatorio";
        }
        if (!filter_var($this->email,FILTER_VALIDATE_EMAIL)){
            self::$alertas["error"][] = "Email NO Valido";
            
        }

        return self::$alertas;

    }

    public function validar_perfil(){
        if(!$this->nombre){
            self::$alertas["error"][] = "El nombre no puede quedar en blanco";
        }
        if (!filter_var($this->email,FILTER_VALIDATE_EMAIL)){
            self::$alertas["error"][] = "Email NO Valido";
        }

        return self::$alertas;
    }

    public function nuevo_password() : array{
        if(!$this->password_actual){
            self::$alertas["error"][] = "La Contraseña Actual es obligatoria";
        }
        if(!$this->password_nuevo){
            self::$alertas["error"][] = "La Contraseña Nueva es obligatoria";
        }
        if(strlen($this->password_nuevo ) < 6){
            self::$alertas["error"][] = "La Contraseña debe ser Mayor a 6 Caracteres";
        }
        return self::$alertas;
    }

    //comprobar la contraseña
    public function comprobar_password() : bool{
        return password_verify($this->password_actual,$this->password);

    }



    //hashear password
    public function hashPassWord() : void{
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    //generar el token
    public function crearToken() : void{
        $this->token = uniqid();

    }

    //validar el password nuevo a cambiar
    public function validarPassword(){
        if(!$this->password){
            self::$alertas["error"][] = "La Contraseña es obligatoria";
        }
        if(strlen($this->password) < 6){
            self::$alertas["error"][] = "La Contraseña debe ser Mayor a 6 Caracteres";
        }
        return self::$alertas;
    }



}