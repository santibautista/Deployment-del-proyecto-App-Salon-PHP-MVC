<?php

namespace Model;
use Model\ActiveRecord;

class Usuario extends ActiveRecord{
    protected static $tabla= 'usuarios';
    protected static $columnasDB= [ 'id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password; 
    public $telefono; 
    public $admin;
    public $confirmado;
    public $token;

    public function __construct( $args= [] ){
        $this->id= $args['id'] ?? null;
        $this->nombre= $args['nombre'] ?? '';
        $this->apellido= $args['apellido'] ?? '';
        $this->email= $args['email'] ?? '';
        $this->password= $args['password'] ?? '';
        $this->telefono= $args['telefono'] ?? '';
        $this->admin= $args['admin'] ?? '0';
        $this->confirmado= $args['confirmado'] ?? '0';
        $this->token= $args['token'] ?? '';
    }

    public function validarNuevoUsuario(){
        if(!$this->nombre){
            self::$alertas['error'][]= 'El nombre es obligatorio';
        }
        if(!$this->apellido){
            self::$alertas['error'][]= 'El apellido es obligatorio';
        }
        if(!$this->email){
            self::$alertas['error'][]= 'El email es obligatorio';
        }
        if(!$this->password){
            self::$alertas['error'][]= 'La contraseña es obligatoria';
        }
        if(strlen($this->password) < 6){
            self::$alertas['error'][]= 'La contraseña debe tener al menos 6 caracteres';
        }
        if(!$this->telefono || (strlen($this->telefono) !== 10) ){
            self::$alertas['error'][]= 'El telefono es obligatorio y debe tener 10 caracteres';
        }

        return self::$alertas;
    }


    public function existeUsuario(){
        $query= "SELECT * FROM ". self::$tabla . " WHERE email= '" . $this->email . "' LIMIT 1";
        $resultado= self::$db->query($query);

        if($resultado->num_rows){
        self::$alertas['error'][]= 'El usuario ya existe';
        }

        return $resultado;
    }

    public function validarEmail() {
        if(!$this->email) {
            self::$alertas['error'][] = 'El email es Obligatorio';
        }
        return self::$alertas;
    }

    public function validarPassword() {
        if(!$this->password) {
            self::$alertas['error'][] = 'El Password es obligatorio';
        }
        if(strlen($this->password) < 6) {
            self::$alertas['error'][] = 'El Password debe tener al menos 6 caracteres';
        }

         return self::$alertas;
    }

    public function hashearPassword(){
        $this->password= password_hash($this->password, PASSWORD_BCRYPT);
    }
    
    public function generarToken(){
        $this->token=uniqid();
    }

    public function comprobarPasswordAndVerificado($password){
        $resultado= password_verify($password, $this->password);

        if(!$resultado || !$this->confirmado){
            $this::setAlerta('error', 'La contraseña es incorrecta o el usuario no ha sido confirmado');
        }else{
            return true;
        }
    }

}