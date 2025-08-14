<?php include_once __DIR__  . '/../templates/barra.php'; ?>

<h2>Buscar Citas</h2>

<div class="busqueda">
    <form action="" class="formulario">
        <div class="campo">
            <label for="fecha" >Fecha</label>
            <input 
            type="date"
            id="fecha"
            name="fecha"
            value="<?php echo $fecha ?>"
            >
        </div>
    </form>
</div>

<?php  
if(count($citas) ===0){
    echo "<h3>No hay citas en la fecha indicada</h3>";
}
?>

<div class="citas-admin">
    <ul class="citas">
        <?php 
        $idActual=0;
        $total=0;
        foreach($citas as $key=>$cita) { 
            if($idActual != $cita->id){ ?>
            <li>
                <p>ID: <span> <?php echo $cita->id ?> </span></p>
                <p>Hora: <span><?php echo $cita->hora ?></span></p>
                <p>Cliente: <span><?php echo $cita->cliente ?></span></p>
                <p>Teléfono: <span><?php echo $cita->telefono ?></span></p>
                <p>Email: <span><?php echo $cita->email ?></span></p>
                <h3>Servicios</h3>
            </li>
            <?php }?> 
            <p class="servicio"><?php echo $cita->servicio ?></p>
            <?php if($cita->servicio){ ?>
                <p class="servicio">Precio: <?php echo $cita->precio ?></p>
            <?php } ?>
            <?php 
            $idActual= $cita->id;  
            $total += $cita->precio; 
            if(esUltimo($idActual, $citas[$key +1]->id ?? null)){ ?>
            <p class="total"><span>Total: </span><?php echo $total ?> </p>
            <form action="/api/eliminar" method="POST">
                <input type="hidden" name="id" value="<?php echo $cita->id ?>">
                <input type="submit" class="boton-eliminar" value="Eliminar">
            </form>
            <?php }} ?>
    </ul>
</div>

<?php 
     $script = "<script src='build/js/buscador.js'></script>
     ";
?>

