<?php
namespace Controllers;

use Model\Servicio;
use Model\Cita;
use Model\CitaServicio;

class ApiController{
    public static function index(){
        isauth();
        header('Content-Type: application/json'); 
        $servicios = Servicio::all();
        echo json_encode($servicios);
    } 

    public static function guardar(){
        isauth();
        $cita= new Cita($_POST);
        $resultado= $cita->guardar();
        
        $id= $resultado['id'];
        $idServicios= explode(',', $_POST['servicios']);
         
        foreach($idServicios as $idServicio){
            $args= [
                'citaId' => $id,
                'servicioId' => $idServicio 
            ];
            $citaServicio= new CitaServicio($args);
            $citaServicio->guardar();
        }

        echo json_encode($resultado);
    }

    public static function eliminar(){
        isauth();
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $id= $_POST['id'];
            $cita= Cita::find($id);
            $cita->eliminar();
            header('Location: '. $_SERVER['HTTP_REFERER']);
        }
    }
        

}