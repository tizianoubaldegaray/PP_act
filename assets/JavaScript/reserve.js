document.getElementById("reservationForm").addEventListener("submit", function (event) {
    event.preventDefault();

    const computerCount = parseInt(document.getElementById("computerCount").value, 10);
    const startTimeInput = document.getElementById("startTime").value;
    const endTimeInput = document.getElementById("endTime").value;
    const reservationMessage = document.getElementById("reservationMessage");

    const startTime = parseTime(startTimeInput);
    const endTime = parseTime(endTimeInput);

    // Rangos permitidos de tiempo
    const morningStart = parseTime("08:00");
    const morningEnd = parseTime("12:10");
    const afternoonStart = parseTime("13:30");
    const afternoonEnd = parseTime("17:55");

    // Validar que las horas de inicio y fin estén dentro de los rangos permitidos
    if (!isWithinAllowedTime(startTime, morningStart, morningEnd, afternoonStart, afternoonEnd)) {
        reservationMessage.textContent = "La hora de inicio debe estar entre 08:00-12:10 o 13:30-17:55.";
        return;
    }

    if (!isWithinAllowedTime(endTime, morningStart, morningEnd, afternoonStart, afternoonEnd)) {
        reservationMessage.textContent = "La hora de fin debe estar entre 08:00-12:10 o 13:30-17:55.";
        return;
    }

    // Validar que la hora de fin sea posterior a la hora de inicio
    if (endTime <= startTime) {
        reservationMessage.textContent = "La hora de fin debe ser posterior a la hora de inicio.";
        return;
    }

    // Validar que la hora de fin no exceda el rango permitido según el inicio (mañana o tarde)
    if ((startTime >= morningStart && startTime <= morningEnd && endTime > morningEnd) ||
        (startTime >= afternoonStart && startTime <= afternoonEnd && endTime > afternoonEnd)) {
        reservationMessage.textContent = "La hora de fin excede el horario permitido para el período seleccionado.";
        return;
    }

    // Confirmación de reserva
    reservationMessage.textContent = `Reserva confirmada para ${computerCount} computadoras desde ${formatTime(startTime)} hasta ${formatTime(endTime)}.`;
});

// Función para convertir un string de tiempo a un objeto Date
function parseTime(timeString) {
    const [hours, minutes] = timeString.split(":").map(Number);
    const time = new Date();
    time.setHours(hours, minutes, 0, 0);
    return time;
}

// Verificar si la hora está dentro de los rangos permitidos
function isWithinAllowedTime(time, morningStart, morningEnd, afternoonStart, afternoonEnd) {
    const isInMorning = time >= morningStart && time <= morningEnd;
    const isInAfternoon = time >= afternoonStart && time <= afternoonEnd;
    return isInMorning || isInAfternoon;
}

// Función para formatear el tiempo en formato HH:MM
function formatTime(date) {
    return date.toTimeString().slice(0, 5);
}
