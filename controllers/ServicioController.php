<?php 
namespace Controllers;

use Model\Servicio;
use MVC\Router;

class ServicioController{
    public static function index(Router $router){
        isAdmin();
        $servicios= Servicio::all();
        
        $router->render('servicios/index', [
            'nombre'=> $_SESSION['nombre'], 
            'servicios'=> $servicios
        ]);
    }

    public  static function crear(Router $router){
        isAdmin();
        $servicio= new Servicio;
        $alertas=[];

        if($_SERVER['REQUEST_METHOD']=== 'POST'){
            $servicio->sincronizar($_POST);
            $alertas= $servicio->validarServicio();

            if(empty($alertas)){
                $servicio->guardar();
                header('Location: /servicios');
            }
        }
        
        $router->render('servicios/crear', [
            'servicio'=> $servicio,
            'nombre'=> $_SESSION['nombre'],
            'alertas'=> $alertas
        ]);
    }


    public  static function actualizar(Router $router){
        isAdmin();
        if(!is_numeric($_GET['id'])) return;

        $servicio= Servicio::find($_GET['id']);
        $alertas=[];

        if($_SERVER['REQUEST_METHOD']=== 'POST'){
            $servicio->sincronizar($_POST);
            $alertas= $servicio->validarServicio();

            if(empty($alertas)){
                $servicio->guardar();
                header('Location: /servicios');
            }
        }
        
        $router->render('servicios/actualizar', [
            'servicio'=> $servicio,
            'nombre'=> $_SESSION['nombre'],
            'alertas'=> $alertas
        ]);
    }

    public  static function eliminar(){
        isAdmin();
        if($_SERVER['REQUEST_METHOD']=== 'POST'){
            $servicio= Servicio::find($_POST['id']);
            $servicio->eliminar();

            header('Location: /servicios');
        }
    }
}