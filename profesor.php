<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/PP_ACT/autenticacion.php";

requiere_login();
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
            <div class="card" onclick="window.location.href='reserve.php'">
                <img src="images/disponibilidad.png" alt="Reserva">
                <div class="card-content">
                    <h3>Reservar</h3>
                </div>
            </div>
        </div>
    
        <div id="contentArea">
        </div>
    </main>
</body>
</html>
