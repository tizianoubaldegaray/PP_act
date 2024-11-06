<?php
include $_SERVER['DOCUMENT_ROOT'] . "/PP_ACT/conexion.php";
include $_SERVER['DOCUMENT_ROOT'] . "/PP_ACT/autenticacion.php";
date_default_timezone_set('America/Argentina/Buenos_Aires');

if (session_status() === PHP_SESSION_NONE) { 
    session_start(); 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reserva_id = $_REQUEST['reserva_id'];
    $sql = "UPDATE reserva
            SET confirmacion = 'confirmada'
            WHERE reserva_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $reserva_id);
    $stmt->execute();
}

header("Location: ver_reservas.php");