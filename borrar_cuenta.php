<?php
include $_SERVER['DOCUMENT_ROOT'] . "/PP_ACT/conexion.php";
include $_SERVER['DOCUMENT_ROOT'] . "/PP_ACT/autenticacion.php";
date_default_timezone_set('America/Argentina/Buenos_Aires');

if (session_status() === PHP_SESSION_NONE) { 
    session_start(); 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dni = $_REQUEST['dni'];

    $sql = "DELETE FROM usuario WHERE Usuario_DNI = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $dni);
    $stmt->execute();
}

header("Location: manage_users.php");