<?php
namespace Controllers;

use MVC\Router;
use Model\Usuario;
use Classes\Email;

class CitaController{
    public static function cita(Router $router) {
        isAuth();

        $router->render('cita/index',[
            'nombre'=> $_SESSION['nombre'],
            'id'=> $_SESSION['id']
        ]);
    }
}