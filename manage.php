<?php
include $_SERVER['DOCUMENT_ROOT'] . "/PP_ACT/conexion.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/PP_ACT/autenticacion.php";

requiere_login();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $registro = $_POST['registro'];
    $nuevoEstado = $_POST['estado'];
    $nuevoComentario = $_POST['comentario'];

    $sqlUpdate = "UPDATE Computadoras SET Comp_Estado = ?, Comp_Comentario = ? WHERE Comp_Registro = ?";
    $stmt = $conexion->prepare($sqlUpdate);
    $stmt->bind_param("sss", $nuevoEstado, $nuevoComentario, $registro);
    $stmt->execute();
}

$sql = "SELECT Comp_Registro, Comp_Estado, Comp_Comentario FROM Computadoras ORDER BY Comp_Registro";
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
        .boton_bebe {
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
        .boton_x {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            padding: 20px;
            font-size: 16px;
            background-color:red;
            color: white;
            border: none;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .boton_rectangulo{  
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
    <a href="index.php" class='boton_bebe'>
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" width="24px" viewBox="0 -960 960 960" style="min-height: 24px; min-width: 24px;">
                <path fill="#FFFFFF" d="m313-440 224 224-57 56-320-320 320-320 57 56-224 224h487v80H313Z"/>
            </svg>
    </a>
    <section class="admin-section"> 
        <h1>Agregar nueva computadora</h1>
        <table id="computerTable">
                <thead>
                    <tr>
                     <th>Registro</th>
                     <th>Estado</th>
                     <th>Comentario</th> 
                     <th>Agregar</th>  
                    </tr>
</thead>
        <tr>
        <form method="POST" action="agregar_equipo.php">
            <td>
            <input type="text" id="Comp_Registro" name="Comp_Registro" required>
            </td>
            <td>
            <select id="Comp_Estado" name="Comp_Estado" required>
                <option value="disponible">Disponible</option>
                <option value="en mantenimiento">En mantenimiento</option>
                <option value="no disponible">No disponible</option>
            </select>
            </td>
            <td>
            <input type="text" id="Comp_Comentario" name="Comp_Comentario">
            </td>
            <td>
            <div class='centrado'>
            <button type="submit" class="boton_rectangulo">Agregar Equipo</button>
    </div>
            </td>
        </form>
        </tr> 
</table>  

        <!-- Tabla de administración de computadoras -->
        <h1>Administración de Computadoras</h1>
        <div class="table-container">
            <table id="computerTable">
                <thead>
                    <tr>
                        <th>Registro</th>
                        <th>Estado</th>
                        <th>Comentarios</th>
                        <th>Confirmar</th>
                        <th>Borrar Equipo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Mostrar los datos en la tabla
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $estadoClass = ($row['Comp_Estado'] === 'no disponible') ? 'estado-no-disponible' :
                                           (($row['Comp_Estado'] === 'en mantenimiento') ? 'estado-en-mantenimiento' : 'estado-disponible');

                            echo "<tr>
                                    <td>{$row['Comp_Registro']}</td>
                                    <td>
                                        <form method='POST'>
                                            <input type='hidden' name='registro' value='{$row['Comp_Registro']}'>
                                            <select name='estado' class='estado-select'>
                                                <option value='no disponible' " . ($row['Comp_Estado'] === 'no disponible' ? 'selected' : '') . ">No disponible</option>
                                                <option value='en mantenimiento' " . ($row['Comp_Estado'] === 'en mantenimiento' ? 'selected' : '') . ">En mantenimiento</option>
                                                <option value='disponible' " . ($row['Comp_Estado'] === 'disponible' ? 'selected' : '') . ">Disponible</option>
                                            </select>
                                    </td>
                                    <td>
                                        <input type='text' name='comentario' value='{$row['Comp_Comentario']}' class='comentario-texto'>
                                    </td>
                                    <td>
                                    <div class='centrado'>
                                        <button class='boton_rectangulo' type='submit' name='actualizar_equipo'>Actualizar</button>
                                        </form>
                                        </div>
                                    </td>
                                    <td>
                                    <div class='centrado'>
                                        <form method='POST' action='borrar_equipo.php'>
                                            <input type='hidden' name='Comp_Registro' value='{$row['Comp_Registro']}'>
                                            <button class='boton_x'>X</button>
                                        </form>
                                        </div>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No hay computadoras registradas.</td></tr>";
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
