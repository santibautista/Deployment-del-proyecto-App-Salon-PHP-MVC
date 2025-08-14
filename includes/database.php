<?php

$db = mysqli_connect(
    $_ENV['DB_HOST'], 
    $_ENV['DB_USER'], 
    $_ENV['DB_PASS'],
    $_ENV['DB_NAME']
    );


if (!$db) {
    error_log("Error de conexión a MySQL: " . mysqli_connect_error());
    exit;
}
