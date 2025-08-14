<div class="barra">
    <p class="nombre">Hola <?php echo $nombre?> </p>
    <a class="button" href="/logout">Cerrar Sesión</a>
</div>

<?php if(isset($_SESSION['admin'])){ ?>
    <h1 class="nombre-pagina">Panel de administración</h1>
    <div class="barra-servicios">
        <a class="boton" href="/admin">Ver Citas</a>
        <a class="boton" href="/servicios">Ver Servicios</a>
        <a class="boton" href="/servicios/crear">Nuevo Servicio</a>
    </div>
<?php } ?>

