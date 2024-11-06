<?php
include $_SERVER['DOCUMENT_ROOT'] . "/PP_ACT/conexion.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/PP_ACT/autenticacion.php";

requiere_login();

$sql = "SELECT Usuario_DNI, Usuario_Nombre, Usuario_Apellido, Usuario_Usuario, Cuenta_Estado FROM Usuario";
$result = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Usuarios</title>
    <link rel="stylesheet" href="manage.css">
    <style>
        .btn {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            padding: 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .btn-confirmar {
            padding: 20px;
            background-color: #4CAF50;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .availability-circle {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: inline-block;
        }

        .estado-no-disponible {
            background-color: red;
        }

        .estado-en-mantenimiento {
            background-color: yellow;
        }

        .estado-disponible {
            background-color: green;
        }

        /* Estilo para hacer la caja de texto más grande */
        .comentario-texto {
            font-size: 1.2em; /* Ajusta este tamaño según sea necesario */
            width: 100%; /* Ancho completo */
            height: 60px; /* Altura aumentada */
            padding: 10px; /* Espaciado interno */
        }

        /* Estilo para el select de estado */
        .estado-select {
            font-size: 1.2em; /* Ajusta el tamaño de la fuente */
            padding: 5px; /* Espaciado interno */
        }
        .acciones_boton{
            padding: 20px;
            width: 80px;
            height: 30px;
            background-color: #4CAF50;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 5px;
            cursor: pointer;
        }
        .centrado {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body>
    <section class="admin-section">
        <a class="btn" href="index.php">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" width="24px" viewBox="0 -960 960 960" style="min-height: 24px; min-width: 24px;">
                <path fill="#FFFFFF" d="m313-440 224 224-57 56-320-320 320-320 57 56-224 224h487v80H313Z"/>
            </svg>
    </a>

        <h1>Administración de Usuarios</h1>
        <div class="table-container">
            <table id="computerTable">
                <thead>
                    <tr>
                        <th>DNI</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Usuario</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Mostrar los datos en la tabla
                    if ($result && $result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $acciones;

                            if ($row['Cuenta_Estado']) {
                                $acciones = "
                                    <form method='POST' action='borrar_cuenta.php'  >
                                        <input type='hidden' name='dni' value='{$row['Usuario_DNI']}'>
                                        <button class='acciones_boton'>Borrar cuenta</button>
                                    </form>
                                ";
                            }
                            else {
                                $acciones = "
                                    <form method='POST' action='activar_cuenta_prestamista.php'>
                                        <input type='hidden' name='dni' value='{$row['Usuario_DNI']}'>
                                        <button class='acciones_boton'>Activar cuenta como prestamista</button>
                                    </form>
                                    <form method='POST' action='activar_cuenta_profesor.php'>
                                        <input type='hidden' name='dni' value='{$row['Usuario_DNI']}'>
                                        <button class='acciones_boton'>Activar cuenta como profesor</button>
                                    </form>
                                    <form method='POST' action='borrar_cuenta.php'>
                                        <input type='hidden' name='dni' value='{$row['Usuario_DNI']}'>
                                        <button class='acciones_boton'>Rechazar</button>
                                    </form>
                                ";
                            }

                            echo "<tr>
                                    <td>{$row['Usuario_DNI']}</td>
                                    <td>
                                       {$row['Usuario_Nombre']}
                                    </td>
                                    <td>
                                    {$row['Usuario_Apellido']}
                                    </td>
                                    <td>
                                    {$row['Usuario_Usuario']}
                                    </td>
                                    <td>
                                    <div class='centrado'>
                                    {$acciones}
                                    </div>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No hay usuarios registrados</td></tr>";
                    }

                    // Cerrar la conexión
                    $conexion->close();
                    ?>
                </tbody>
            </table>
        </div>
    </section>
</body>
</html>
