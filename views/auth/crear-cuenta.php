<h1 class="nombre-pagina">Regístrate</h1>
<p class="descripcion-pagina">Llena el siguiente el formulario para crear una cuenta</p>

<?php 
    include_once __DIR__ . "/../templates/alertas.php";
?>

<form class="formulario" method="POST" action="/crear-cuenta">
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input
            type="text"
            id="nombre"
            placeholder="Tu Nombre"
            name="nombre"
            value= "<?php echo ($usuario->nombre);?>" 
        /> 
    </div>
    <div class="campo">
        <label for="apellido">Apellido</label>
        <input
            type="text"
            id="apellido"
            placeholder="Tu Apellido"
            name="apellido"
            value= "<?php echo ($usuario->apellido);?>" 
        />
    </div>
    <div class="campo">
        <label for="telefono">Teléfono</label>
        <input
            type="tel"
            id="telefono"
            placeholder="Tu Teléfono"
            name="telefono"
            value= "<?php echo ($usuario->telefono);?>" 
        />
    </div>

    <div class="campo">
        <label for="email">Email</label>
        <input
            type="email"
            id="email"
            placeholder="Tu Email"
            name="email"
            value= "<?php echo ($usuario->email);?>" 
        />
    </div>

    <div class="campo">
        <label for="password">Password</label>
        <input 
            type="password"
            id="password"
            placeholder="Tu Password"
            name="password"
        />
    </div>

    <input type="submit" class="boton" value="Regístrate">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia sesión</a>
    <a href="/olvide">¿Olvidaste tu password?</a>
</div>