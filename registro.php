<?php

include $_SERVER['DOCUMENT_ROOT'] . "/PP_ACT/conexion.php";
date_default_timezone_set('America/Argentina/Buenos_Aires');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario_nombre = $_REQUEST["usuario_nombre"];
    $usuario_apellido = $_REQUEST["usuario_apellido"];
    $usuario_usuario = $_REQUEST["usuario_usuario"];
    $usuario_dni = $_REQUEST["usuario_dni"];
    $usuario_contrasena = password_hash($_REQUEST["usuario_contrasena"], PASSWORD_DEFAULT);
    $cuenta_estado = false;

    
    if (!empty($usuario_nombre) && !empty($usuario_apellido) && !empty($usuario_usuario) && !empty($usuario_dni) && !empty($usuario_contrasena)) {
        
        $consulta = $conexion->prepare("INSERT INTO Usuario (usuario_DNI, Usuario_Nombre, Usuario_Apellido, Usuario_Usuario, Usuario_Contrasena, Cuenta_Estado) VALUES (?, ?, ?, ?, ?, ?)");
        $consulta->bind_param("ssssss", $usuario_dni, $usuario_nombre, $usuario_apellido, $usuario_usuario, $usuario_contrasena, $cuenta_estado);

        if ($consulta->execute()) {
            echo '<h3 class="Ok">Has registrado correctamente</h3>';
        } else {
            echo '<h3 class="Bad">Ocurrió un error al registrar</h3>';
        }

        $consulta->close();
    } else {
        echo '<h3 class="Bad">Completa todos los campos</h3>';
    }
    
    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="styles.css"> <!-- Asegúrate de crear un archivo CSS para estilos -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .container {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            background: white;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
        }

        input[type="text"], input[type="password"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .mensaje {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
<form method="POST" action="registro.php">
<div class="container">
        <h2>Registro</h2>

        <?php if (!empty($mensaje)): ?>
            <p class="mensaje"><?php echo $mensaje; ?></p>
        <?php endif; ?>
                        <input type="number" name="usuario_dni" placeholder="DNI" required>
                        <input type="text" name="usuario_nombre" placeholder="Nombre" required>
                        <input type="text" name="usuario_apellido" placeholder="Apellido" required>
                        <input type="text" name="usuario_usuario" placeholder="Usuario" required>
                        <input type="password" name="usuario_contrasena" placeholder="Contraseña" required>
                        <!-- <input type="password" name="confirmar_contrasena" placeholder="Confirmar Contraseña" required> -->
                        <button type="submit" name="register">Registrarse</button>
                        <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a></p>
                </form>
        </div>
</body>
</html>