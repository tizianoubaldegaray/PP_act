<?php
$server = "localhost";
$user = "root";
$pass = "";
$db = "proyecto prestamo";

// Crear la conexión
$conexion = new mysqli($server, $user, $pass, $db);

// Verificar si hay errores en la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Opcional: Configurar el juego de caracteres a UTF-8
$conexion->set_charset("utf8");
?>
