<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/PP_ACT/autenticacion.php";

requiere_login();

permitir_si_es_prestamista();
?>

<!DOCTYPE html> 
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Computadoras</title>
    <link rel="icon" href="images\logo-pc.jpg">
    <link rel="stylesheet" href="main.css">
    <script src="main.js" defer></script>
    <style>
        .btn {
            padding: 8px;
            background-color: #4CAF50;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 5px;
            cursor: pointer;
            margin: 3px;
        }
        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo-container">
            <img src="images/Logotipo.png" alt="Logo PC" class="logo">
        </div>
        <nav>
        <a class="btn" href="cerrar_sesion.php">Cerrar sesion</a>
    </nav>
    </header>
    <main>
        <div class="cards-container">
            <div class="card" onclick="window.location.href='manage.php'">
                <img src="images/admin.png" alt="Administrar Computadoras">
                <div class="card-content">
                    <h3>Administrar Computadoras</h3>
                </div>
            </div>
            <div class="card" onclick="window.location.href='reserve.php'">
                <img src="images/disponibilidad.png" alt="Reserva">
                <div class="card-content">
                    <h3>Reservar</h3>
                </div>
            </div>
            <div class="card" onclick="window.location.href='ver_reservas.php'">
                <img src="images/admin.png" alt="Administrar Reservas">
                <div class="card-content">
                    <h3>Administrar Reservas</h3>
                </div>
            </div>
            <div class="card" onclick="window.location.href='manage_users.php'">
                <img src="images/admin.png" alt="Administrar Reservas">
                <div class="card-content">
                    <h3>Administrar Usuarios</h3>
                </div>
            </div>
        </div>
    
        <div id="contentArea">
        </div>
    </main>
</body>
</html>
