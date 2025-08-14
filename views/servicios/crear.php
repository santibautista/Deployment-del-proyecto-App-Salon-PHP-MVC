<?php include_once __DIR__  . '/../templates/barra.php';
include_once __DIR__ . "/../templates/alertas.php";
?>

<div class="contenido-centrado">
    <h2>Nuevo servicio</h2>
    <p class="no-margin">Complete todos los campos</p>
</div>

<form method="POST" class="formulario">
    <div class="campo">
        <label for="nombre">Nombre: </label>
        <input type="text" name="nombre" >">
    </div>
    <div class="campo">
        <label for="precio">Precio: </label>
        <input type="number" name="precio">
    </div>    
    <input type="submit" value="Guardar" class="boton">
</div>