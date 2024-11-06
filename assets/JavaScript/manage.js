document.addEventListener("DOMContentLoaded", function() {
    const tableBody = document.getElementById("tableBody");
    const registros = [
        ...Array.from({ length: 30 }, (_, i) => `A-${(i + 1).toString().padStart(2, '0')}`),
        ...Array.from({ length: 30 }, (_, i) => `B-${(i + 1).toString().padStart(2, '0')}`)
    ];
    const divisiones = [];

    // Añadir divisiones
    for (let año = 1; año <= 2; año++) {
        for (let division = 1; division <= 12; division++) {
            divisiones.push(`${año}° ${division}°`);
        }
    }
    for (let año = 3; año <= 6; año++) {
        for (let division = 1; division <= 6; division++) {
            divisiones.push(`${año}° ${division}°`);
        }
    }

    // Función para alternar colores de disponibilidad
    function toggleAvailability(circle) {
        const currentStatus = circle.getAttribute("data-status");

        if (currentStatus === "red") {
            circle.style.backgroundColor = "yellow";
            circle.setAttribute("data-status", "yellow");
        } else if (currentStatus === "yellow") {
            circle.style.backgroundColor = "green";
            circle.setAttribute("data-status", "green");
        } else {
            circle.style.backgroundColor = "red";
            circle.setAttribute("data-status", "red");
        }
    }

    // Función para agregar una fila
    function agregarFila(registro, disponibilidad = "", estado = "En uso", comentarios = "Comentario", Eliminar) {
        const row = document.createElement('tr');

        // Columna 1: Registro
        const registroCell = document.createElement('td');
        registroCell.textContent = registro;
        row.appendChild(registroCell);

        // Columna 2: Disponibilidad con círculo de colores
        const disponibilidadCell = document.createElement('td');
        const disponibilidadCircle = document.createElement('div');
        disponibilidadCircle.classList.add('availability-circle');
        disponibilidadCircle.setAttribute("data-status", "red"); // Estado inicial
        disponibilidadCircle.style.backgroundColor = "red";
        disponibilidadCircle.addEventListener('click', function() {
            toggleAvailability(disponibilidadCircle);
        });
    
        disponibilidadCell.appendChild(disponibilidadCircle);
        row.appendChild(disponibilidadCell);
        
        // Columna 4: Comentarios
        const comentariosCell = document.createElement('td');
        const comentarioInput = document.createElement('textarea');
        comentarioInput.rows = 2;
        comentarioInput.cols = 20;
        comentarioInput.value = comentarios;
        comentariosCell.appendChild(comentarioInput);
        row.appendChild(comentariosCell);
        
        // Columna 5: Botón de eliminar
        const eliminarCell = document.createElement('td');
        eliminarCell.style.display = 'flex';
        eliminarCell.style.alignItems = 'center';
        eliminarCell.style.justifyContent = 'center';

        const eliminarBtn = document.createElement('button');
        eliminarBtn.textContent = '✖';
        eliminarBtn.style.backgroundColor = '#D32F2F';
        eliminarBtn.style.color = 'black';
        eliminarBtn.style.border = 'none';
        eliminarBtn.style.padding = '5px 10px';
        eliminarBtn.style.borderRadius = '50%';
        eliminarBtn.style.cursor = 'pointer';

        // Evento click para eliminar la fila con confirmación
        eliminarBtn.addEventListener('click', function() {
            const confirmacion = confirm('¿Estás seguro de que deseas eliminar esta computadora?');
            if (confirmacion) {
                row.remove();
            }
        });

        eliminarCell.appendChild(eliminarBtn);
        row.appendChild(eliminarCell);

        tableBody.appendChild(row);
    }

    // Añadir las filas iniciales
    registros.forEach((registro, index) => {
        agregarFila(registro, "", divisiones[index % divisiones.length], "");
    });

    // Botón para agregar nuevas computadoras
    const addComputerBtn = document.getElementById("addComputerBtn");
    let nextLetter = 'C';

    addComputerBtn.addEventListener('click', function() {
        const currentCount = tableBody.rows.length;
        const nextNum = (currentCount % 30) + 1;
        const nextRegistro = `${nextLetter}-${nextNum.toString().padStart(2, '0')}`;
        
        agregarFila(nextRegistro);

        if (nextNum === 30) {
            nextLetter = String.fromCharCode(nextLetter.charCodeAt(0) + 1);
        }
    });
});

