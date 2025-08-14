<?php

namespace Classes;
use PHPMailer\PHPMailer\PHPMailer;

class Email{
    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token){
        $this->email=$email;
        $this->nombre=$nombre;
        $this->token=$token;
    }

    public function enviarConfirmacion(){
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('santibautista19@gmail.com', 'AppSalon.com');
        $mail->Subject= 'Confirma tu cuenta';
        $mail->isHTML(TRUE);
        $mail->CharSet='UTF-8';
        $contenido= "<html>";
        $contenido .= "<p><strong>Hola ". $this->nombre . "</strong> Has creado tu cuenta en AppSalon, solo debes confirmarla presionando en el siguiente enlace</p>";
        $contenido .= "<p>Presiona aquí: <a href='". $_ENV['APP_URL'] . "/confirmar?token=" . $this->token . "'>Confirmar 
        Cuenta</a> </p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;
        $mail->send();
    }

    public function enviarInstrucciones(){
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('santibautista19@gmail.com', 'AppSalon.com');
        $mail->Subject= 'Restablece tu contraseña';
        $mail->isHTML(TRUE);
        $mail->CharSet='UTF-8';
        $contenido= "<html>";
        $contenido .= "<p><strong>Hola ". $this->nombre . "</strong> restablece tu contraseña presionando en el siguiente enlace</p>";
        $contenido .= "<p>Presiona aquí: <a href='". $_ENV['APP_URL'] . "/recuperar?token=" . $this->token . "'> Cambiar contraseña</a> </p>";
        $contenido .= "<p>Si tu no solicitaste esto, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;
        $mail->send();
    }
}