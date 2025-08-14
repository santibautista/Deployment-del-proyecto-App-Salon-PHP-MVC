<?php include_once __DIR__  . '/../templates/barra.php';
include_once __DIR__ . "/../templates/alertas.php";
?>

<div class="contenido-centrado">
    <h2>Actualizar servicio</h2>
</div>

<form method="POST" class="formulario">
    <div class="campo">
        <label for="nombre">Nombre: </label>
        <input type="text" name="nombre" value="<?php echo $servicio->nombre ?>">
    </div>
    <div class="campo">
        <label for="precio">Precio: </label>
        <input type="number" name="precio" value="<?php echo $servicio->precio ?>">
    </div>    
    <input type="submit" value="Guardar cambios" class="boton">
</div>