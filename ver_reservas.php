<?php
include $_SERVER['DOCUMENT_ROOT'] . "/PP_ACT/conexion.php";
date_default_timezone_set('America/Argentina/Buenos_Aires');
require_once $_SERVER['DOCUMENT_ROOT'] . "/PP_ACT/autenticacion.php";

requiere_login();
// permitir_si_es_prestamista();

if (session_status() === PHP_SESSION_NONE) { 
    session_start(); 
}

// Consulta para obtener los datos de la tabla Computadoras
$sql = "SELECT reserva_id, Registro_Inicio, Registro_Fin, nro_comp, curso, tipo_usuario, nombre_y_apellido , confirmacion FROM Reserva";
$result = $conexion->query($sql);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Computadoras</title>
    <link rel="stylesheet" href="manage.css">
    <style>
        button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .availability-circle {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: inline-block;
        }
        
        .estado-rojo {
            background-color: red;
        }

        .estado-amarillo {
            background-color: yellow;
        }

        .estado-verde {
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
        .btn-confirmar {
            padding: 20px;
            background-color: #4CAF50;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        a {
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
        .boton_acciones{
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
            margin: 3px;
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
        <a href="index.php">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" width="24px" viewBox="0 -960 960 960" style="min-height: 24px; min-width: 24px;">
                <path fill="#FFFFFF" d="m313-440 224 224-57 56-320-320 320-320 57 56-224 224h487v80H313Z"/>
            </svg>
    </a>

        <h1>Ver Reservas</h1>
        <div class="table-container">
            <table id="computerTable">
                <thead>
                    <tr>
                        <th>Registro inicio</th>
                        <th>Registro fin</th>
                        <th>Nro de computadora</th>
                        <th>Curso</th>
                        <th>Tipo de usuario</th>
                        <th>Nombre y Apellido</th>
                        <th>Estado</th>
                        <th>Confirmación</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Mostrar los datos en la tabla
                    if ($result && $result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>
                                    {$row['Registro_Inicio']}
                                    </td>
                                      <td>
                                    {$row['Registro_Fin']}
                                    </td>
                                    <td>
                                    {$row['nro_comp']}
                                    </td>
                                    <td>
                                    {$row['curso']}
                                    </td>
                                    <td>
                                    {$row['tipo_usuario']}
                                    </td>
                                    <td>
                                    {$row['nombre_y_apellido']}
                                    </td>
                                    <td>
                                    {$row['confirmacion']}
                                    </td>
                                    <td>
                                    <form method='POST' action='confirmar_reserva.php'>
                                        <input type='hidden' name='reserva_id' value='{$row['reserva_id']}'>
                                        <div class='centrado'>
                                        <button class='boton_acciones'>confirmar</button>
                                        </div>
                                    </form>
                                    <form method='POST' action='rechazar_reserva.php'>
                                        <input type='hidden' name='reserva_id' value='{$row['reserva_id']}'>
                                        <div class='centrado'>
                                        <button class='boton_acciones'>rechazar</button>
                                        </div>
                                    </form>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No hay reservas registradas.</td></tr>";
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
