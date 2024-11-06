<?php
include $_SERVER['DOCUMENT_ROOT'] . "/PP_ACT/conexion.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/PP_ACT/autenticacion.php";

requiere_login();

// Inicializamos la variable mensaje para usar más tarde
$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $computerCount = intval($_POST["computerCount"]);
    $startTimeInput = $_POST["startTime"];
    $endTimeInput = $_POST["endTime"];
    $userType = $_POST["userType"];
    $fullname = $_POST["nombre_y_apellido"];
    $course = intval($_POST["course"]); // Asegúrate de que sea un número entero

    // Función para convertir una cadena de tiempo en un objeto DateTime
    function parseTime($timeString) {
        return DateTime::createFromFormat("H:i", $timeString);
    }

    // Rangos permitidos de tiempo
    $morningStart = parseTime("08:00");
    $morningEnd = parseTime("12:10");
    $afternoonStart = parseTime("13:30");
    $afternoonEnd = parseTime("17:55");

    // Convertir los horarios de inicio y fin en objetos DateTime
    $startTime = parseTime($startTimeInput);
    $endTime = parseTime($endTimeInput);

    // Función para verificar si la hora está dentro de los rangos permitidos
    function isWithinAllowedTime($time, $morningStart, $morningEnd, $afternoonStart, $afternoonEnd) {
        return ($time >= $morningStart && $time <= $morningEnd) || ($time >= $afternoonStart && $time <= $afternoonEnd);
    }

    // Validar horarios
    if (!isWithinAllowedTime($startTime, $morningStart, $morningEnd, $afternoonStart, $afternoonEnd)) {
        $mensaje = "La hora de inicio debe estar entre 08:00-12:10 o 13:30-17:55.";
    } elseif (!isWithinAllowedTime($endTime, $morningStart, $morningEnd, $afternoonStart, $afternoonEnd)) {
        $mensaje = "La hora de fin debe estar entre 08:00-12:10 o 13:30-17:55.";
    } elseif ($endTime <= $startTime) {
        $mensaje = "La hora de fin debe ser posterior a la hora de inicio.";
    } elseif (($startTime >= $morningStart && $startTime <= $morningEnd && $endTime > $morningEnd) ||
              ($startTime >= $afternoonStart && $startTime <= $afternoonEnd && $endTime > $afternoonEnd)) {
        $mensaje = "La hora de fin excede el horario permitido para el período seleccionado.";
    } else {
        // Aquí puedes guardar los datos en la base de datos
        $sqlInsert = "INSERT INTO reserva (Registro_Inicio, Registro_Fin, nro_comp, curso, tipo_usuario, nombre_y_apellido) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sqlInsert);

        // Comprueba si la preparación de la consulta fue exitosa
        if ($stmt === false) {
            $mensaje = "Error en la preparación de la consulta: " . $conexion->error;
        } else {
            // Asigna un número de computadora (nro_comp).
            $nroComp = $computerCount; // Asignamos el número de computadoras solicitadas.

            // Vincula los parámetros
            $stmt->bind_param("ssisss", $startTimeInput, $endTimeInput, $nroComp, $course, $userType, $fullname);

            // Ejecuta la consulta y verifica si se realizó correctamente
            if ($stmt->execute()) {
                $mensaje = "Reserva confirmada para $computerCount computadoras desde $startTimeInput hasta $endTimeInput.";
            } else {
                $mensaje = "Error al realizar la reserva: " . $stmt->error; // Muestra el error de la consulta
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserva de Computadoras</title>
    <link rel="stylesheet" href="reserve.css">
    <style>
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
        button:hover {
            background-color: #45a049;
        }

        .mensaje {
            font-size: 1.2em;
            margin-top: 20px;
        }

        /* Estilo para hacer la caja de texto más grande */
        input[type="text"], input[type="number"], select, input[type="time"] {
            font-size: 1.2em; /* Ajusta este tamaño según sea necesario */
            width: 100%; /* Ancho completo */
            padding: 10px; /* Espaciado interno */
            margin-bottom: 15px; /* Espaciado inferior */
        }
    </style>
</head>
<body>
    <main>
        <h1>        <a href="index.php">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" width="24px" viewBox="0 -960 960 960" style="min-height: 24px; min-width: 24px;">
                <path fill="#FFFFFF" d="m313-440 224 224-57 56-320-320 320-320 57 56-224 224h487v80H313Z"/>
            </svg>
    </a>    Reserva de Computadoras</h1>
        <section>
            <form id="reservationForm" method="POST" action="reserve.php">
                <label for="computerCount">Número de computadoras:</label>
                <input type="number" id="computerCount" name="computerCount" min="1" required>

                <label for="startTime">Horario de inicio:</label>
                <input type="time" id="startTime" name="startTime" required>

                <label for="endTime">Horario de fin:</label>
                <input type="time" id="endTime" name="endTime" required>

                <label for="userType">Tipo de usuario:</label>
                <select id="userType" name="userType" required>
                    <option value="">Seleccione...</option>
                    <option value="alumno">Alumno</option>
                    <option value="profesor">Profesor</option>
                </select>
                <label for="nombre_y_apellido">Nombre y Apellido</label>
                <input type="text"  name="nombre_y_apellido" required> <!-- Cambiado a tipo number -->

                <label for="course">Curso:</label>
                <input type="number" id="course" name="course" required> <!-- Cambiado a tipo number -->
                <button type="submit">Reservar</button>
            </form>

            <?php if (!empty($mensaje)): ?>
                <p class="mensaje" style="color: <?= strpos($mensaje, 'Error') !== false ? 'red' : 'green'; ?>;">
                    <?= $mensaje; ?>
                </p>
            <?php endif; ?>

        </section>
    </main>
</body>
</html>
