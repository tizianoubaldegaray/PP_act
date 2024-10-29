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

    // Función para agregar una fila
    function agregarFila(registro, disponibilidad = "Disponible", estado = "En uso" , comentarios = "tiene el culo roto" , Eliminar ) {
        const row = document.createElement('tr');

        // Columna 1: Registro
        const registroCell = document.createElement('td');
        registroCell.textContent = registro;
        row.appendChild(registroCell);

        // Columna 2: Disponibilidad
        const disponibilidadCell = document.createElement('td');
        disponibilidadCell.textContent = disponibilidad;
        row.appendChild(disponibilidadCell);

        // Columna 3: Estado
        const estadoCell = document.createElement('td');
        estadoCell.textContent = estado;
        row.appendChild(estadoCell);
        
        // Columna 4: Comentarios
        const comentariosCell = document.createElement('td');
        const comentarioInput = document.createElement('textarea'); // Creamos un textarea
        comentarioInput.rows = 2; // Definimos el tamaño del textarea
        comentarioInput.cols = 20;
        comentarioInput.value = comentarios; // Insertamos el comentario por defecto (si hay)
        comentariosCell.appendChild(comentarioInput); // Lo añadimos a la celda
        row.appendChild(comentariosCell);
        
        // Columna 5: Botón de eliminar
        const eliminarCell = document.createElement('td');
        eliminarCell.style.display = 'flex'; // Fijamos el ancho de la celda
        eliminarCell.style.alignItems = 'center'; // Centrar verticalmente
        eliminarCell.style.justifyContent = 'center'; // Centrar horizontalmente

        const eliminarBtn = document.createElement('button');
        eliminarBtn.textContent = '✖'; // Cruz negra como texto
        eliminarBtn.style.backgroundColor = '#D32F2F'; // Rojo más oscuro
        eliminarBtn.style.color = 'black'; // Cruz negra
        eliminarBtn.style.border = 'none'; // Sin borde
        eliminarBtn.style.padding = '5px 10px'; // Tamaño más pequeño
        eliminarBtn.style.borderRadius = '50%'; // Hacer el botón redondeado
        eliminarBtn.style.cursor = 'pointer'; // Cambiar el cursor al pasar sobre el botón
        eliminarBtn.style.alignItems = 'center'; // Centrar verticalment
        eliminarBtn.style.justifyContent = 'center'; // Centrar horizontalmente
        eliminarBtn.style.width = 'flex'; // Fijamos el ancho de la celda


        // Evento click para eliminar la fila con confirmación
        eliminarBtn.addEventListener('click', function() {
            const confirmacion = confirm('¿Estás seguro de que deseas eliminar esta computadora?');
            if (confirmacion) {
                row.remove(); // Eliminar la fila si se confirma
            }
        });

        eliminarCell.appendChild(eliminarBtn);
        row.appendChild(eliminarCell);


        tableBody.appendChild(row);
    }

    // Añadir las filas iniciales
    registros.forEach((registro, index) => {
        agregarFila(registro, "Disponible", divisiones[index % divisiones.length], "En uso");
    });

    // Botón para agregar nuevas computadoras
    const addComputerBtn = document.getElementById("addComputerBtn");
    let nextLetter = 'C';  // Comienza con la letra C

    addComputerBtn.addEventListener('click', function() {
        const currentCount = tableBody.rows.length;
        const nextNum = (currentCount % 30) + 1;
        const nextRegistro = `${nextLetter}-${nextNum.toString().padStart(2, '0')}`;
        
        // Agregar nueva fila
        agregarFila(nextRegistro);

        // Cambiar la letra si se completan 30 registros (de A-01 a E-30)
        if (nextNum === 30) {
            nextLetter = String.fromCharCode(nextLetter.charCodeAt(0) + 1);  // Cambia a la siguiente letra (D, E, etc.)
        }
    });
});
