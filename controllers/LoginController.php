<?php 
namespace Controllers;
use MVC\Router;
use Model\Usuario;
use Classes\Email;

class LoginController{
    public static function login(Router $router){
        $alertas= [];
        $usuario= new Usuario; 

        if($_SERVER['REQUEST_METHOD']=== 'POST'){
            $auth= new Usuario($_POST);
            $usuario= Usuario::where("email", $auth->email);
            if($usuario){
                if($usuario->comprobarPasswordAndVerificado($auth->password)){
                    $_SESSION['id'] = $usuario->id;
                    $_SESSION['nombre'] =$usuario->nombre . " " . $usuario->apellido;
                    $_SESSION['email'] = $usuario->email;
                    $_SESSION['login']= true;

                    if($usuario->admin === "1"){
                        $_SESSION['admin']=  $usuario->admin ?? null;
                        header('Location: /admin');
                    }else{
                        header('Location: /cita');
                    }
                }
            }else{
                Usuario::setAlerta('error', 'El email no está registrado');
            }
        }

        $alertas= Usuario::getAlertas();

        $router->render('auth/login', [
            'alertas' => $alertas,
            'usuario' => $usuario
        ]);
    }

    public static function logout(){
        $_SESSION= [];
        header('Location: /');
    }

    public static function crearCuenta(Router $router){
        $usuario= new Usuario;
        $alertas= [];

        if($_SERVER['REQUEST_METHOD']==='POST'){
            $usuario->sincronizar($_POST);
            $alertas= $usuario->validarNuevoUsuario();

            if(empty($alertas)){
                $resultado=$usuario->existeUsuario();

                if($resultado->num_rows){
                    $alertas= $usuario::getAlertas();
                }else{
                    $usuario->hashearPassword();

                    $usuario->generarToken();

                    $email= New Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->enviarConfirmacion();

                    $resultado= $usuario->guardar();

                    if($resultado){
                        header('Location: /mensaje');
                    }                  
                }
            }
        }
        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    
    public static function olvide(Router $router){
        $alertas= [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth= new Usuario($_POST);
            $alertas= $auth->validarEmail();

            if(empty($alertas)){
                $usuario= Usuario::where('email', $auth->email);
                if($usuario && $usuario->confirmado === '1' ){
                    $usuario->generarToken();
                    $usuario->guardar();
                    $email= new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();
                    Usuario::setAlerta('exito', 'Hemos enviado las instrucciones a tu mail');
                }else{
                    Usuario::setAlerta('error', 'El usuario no está registrado o no está confirmado');
                }
            }
        }

        $alertas= Usuario::getAlertas();

        $router->render('auth/olvide', [
            'alertas'=> $alertas
        ]);
    }

    public static function recuperar(Router $router){
        $alertas=[];
        $error= false;
        $token= s($_GET['token']);

        $usuario= Usuario::where('token', $token);
        if(empty($usuario)){
            Usuario::setAlerta('error', 'Token inválido');
            $error= true;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $password= new Usuario($_POST);
            $alertas= $password->validarPassword();

            if(empty($alertas)){
                $usuario->password= $password->password;
                $usuario->hashearPassword();
                $resultado= $usuario->guardar();
                if($resultado){
                    Usuario::setAlerta('exito', 'La contraseña fue modificada exitosamente');
                }
            }
        }

        $alertas= Usuario::getAlertas();
        $router->render('auth\recuperar', [
            'alertas'=> $alertas,
            'error'=> $error
        ]);
    }


    public static function mensaje(Router $router){
        $router->render('auth/mensaje', []);
    }

    public static function confirmar(Router $router){
        $alertas= [];
        $token= s($_GET['token']);
        $usuario= Usuario::where('token', $token);

        if(empty($usuario)){
            Usuario::setAlerta('error', 'Token no válido');
        }else{
            $usuario->confirmado= "1";
            $usuario->token= '';
            $usuario->guardar();
            $usuario::setAlerta('exito', 'Cuenta confirmada');
        }

        $alertas= Usuario::getAlertas();
        $router->render('auth/confirmar', [
            'alertas'=> $alertas
        ]);
    }



}