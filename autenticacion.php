<?php

session_start();

function usuario_esta_logueado(): bool
{
    return isset($_SESSION['username']);
}

function tiene_rol(string $rol): bool
{
    return $_SESSION['rol'] == $rol;
}

function permitir_si_es_prestamista(): void
{
    if (!tiene_rol("prestamista")) {
        header("Location: profesor.php"); 
        exit();
    }
}

function requiere_login(): void
{
    if (!usuario_esta_logueado()) {
        header("Location: login.php"); 
        exit();
    }
}

function usuario_actual()
{
    if (usuario_esta_logueado()) {
        return $_SESSION['username'];
    }
    return null;
}

function cerrar_sesion(): void
{
    if (usuario_esta_logueado()) {
        unset($_SESSION['username'], $_SESSION['user_id']);
        session_destroy();
        header("Location: login.php"); 
        exit();
    }
}