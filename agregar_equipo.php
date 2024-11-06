<?php
include $_SERVER['DOCUMENT_ROOT'] . "/PP_ACT/conexion.php";
include $_SERVER['DOCUMENT_ROOT'] . "/PP_ACT/autenticacion.php";
date_default_timezone_set('America/Argentina/Buenos_Aires');

if (session_status() === PHP_SESSION_NONE) { 
    session_start(); 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $registro = $_REQUEST['Comp_Registro'];
    $nuevoEstado = $_POST['Comp_Estado'];
    $nuevoComentario = $_POST['Comp_Comentario'];


    $sql = "INSERT INTO computadoras (Comp_Registro, Comp_Estado, Comp_Comentario) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sss", $registro , $nuevoEstado , $nuevoComentario);
    $stmt->execute();
}

header("Location: manage.php");