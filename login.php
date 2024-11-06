<?php
include $_SERVER['DOCUMENT_ROOT'] . "/PP_ACT/conexion.php";
include $_SERVER['DOCUMENT_ROOT'] . "/PP_ACT/autenticacion.php";
date_default_timezone_set('America/Argentina/Buenos_Aires');

if (session_status() === PHP_SESSION_NONE) { 
    session_start(); 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $usuario = $_REQUEST['usuario'];
        $contrasena = $_REQUEST['contrasena'];

        if (login($conexion, $usuario, $contrasena)) {
            header("Location: prestamista.php"); 
            exit();
        } else {
            echo "<h2>Datos erroneos</h2>";
        }
}

function buscar_usuario($conexion, string $usuario)
{
    $sql = "SELECT Usuario_DNI, Usuario_Usuario, Usuario_Contrasena, Usuario_Rol, Cuenta_Estado
            FROM usuario
            WHERE Usuario_Usuario = ?";

    $statement = $conexion->prepare($sql);
    $statement->bind_param("s", $usuario);
    $statement->execute();

    $resultado = $statement->get_result();

    return $resultado->fetch_assoc();
}

function login($conexion, string $usuario, string $contrasena): bool
{
    $usuario = buscar_usuario($conexion, $usuario);

    if (!$usuario['Cuenta_Estado']) {
        return false;
    }

    if ($usuario && password_verify($contrasena, $usuario['Usuario_Contrasena'])) {

        session_regenerate_id();

        $_SESSION['username'] = $usuario['Usuario_Usuario'];
        $_SESSION['user_id']  = $usuario['Usuario_DNI'];
        $_SESSION['rol'] = $usuario['Usuario_Rol'];

        return true;
    }

    return false;
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión y Registro</title>
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
    <div class="container">
        <h2>Iniciar sesion</h2>

        <?php if (!empty($mensaje)): ?>
            <p class="mensaje"><?php echo $mensaje; ?></p>
        <?php endif; ?>

        <form method="POST" action="login.php">
                <input type="text" name="usuario" placeholder="Usuario" required>
                <input type="password" name="contrasena" placeholder="Contraseña" required>
                <button type="submit" name="login">Iniciar Sesión</button>
                <p>¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a></p>
        </form>
    </div>

    <script>
</body>
</html>

