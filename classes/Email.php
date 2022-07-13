<?php

namespace Classes;
use PHPMailer\PHPMailer\PHPMailer;

class Email{
    protected $email;
    protected $nombre;
    protected $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion()
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '5e2ac4a829e15f';
        $mail->Password = 'c60c24cce88d31';

        $mail->setFrom("cuentas@uptask.com");
        $mail->addAddress("cuentas@uptask.com", "UpTask.com");
        $mail->Subject = "Confirma tu Cuenta en UpTask";

        //código html que será generado en el correo
        $mail->isHTML(TRUE);
        $mail->CharSet = "UTF-8";

        $contenido = "<html>";
        $contenido = "<p><strong>Hola " . $this->nombre . "</strong> has creado tu cuenta en UpTask, sólo debes confirmarla presionando el siguiente enlace</p>";
        $contenido .= "<p>Presiona aquí para confirmar tu cuenta: <a href='http://localhost:3000/confirmado?token=" . $this->token . "'>Confirmar Cuenta</a></p>";
        $contenido .= "<p>Si tú no solicitaste esta cuenta, ignora el mensaje, gracias</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        //Enviar el email
        $mail->send();
    }

    public function enviarInstrucciones(){
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.mailtrap.io';
    $mail->SMTPAuth = true;
    $mail->Port = 2525;
    $mail->Username = '5e2ac4a829e15f';
    $mail->Password = 'c60c24cce88d31';

    $mail->setFrom("cuentas@uptask.com");
    $mail->addAddress("cuentas@uptask.com", "UpTask.com");
    $mail->Subject = "Cambia tu Contraseña en UpTask";

    //código html que será generado en el correo
    $mail->isHTML(TRUE);
    $mail->CharSet = "UTF-8";

    $contenido = "<html>";
    $contenido = "<p><strong>Hola " . $this->nombre . "</strong> parece que has olvidado tu contraseña , sigue el siguiente enlace para restablecerla</p>";
    $contenido .= "<p>Presiona aquí para confirmar tu cuenta: <a href='http://localhost:3000/restablecer-contraseña?token=" . $this->token . "'>Restablecer Contraseña</a></p>";
    $contenido .= "<p>Si tú no solicitaste este cambio, ignora el mensaje, gracias</p>";
    $contenido .= "</html>";

    $mail->Body = $contenido;

    //Enviar el email
    $mail->send();
}
}
