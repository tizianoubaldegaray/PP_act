// Mejoras en la búsqueda y carga dinámica

function searchComputers() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const contentArea = document.getElementById('contentArea');
    
    if (searchTerm === 'administrar') {
        loadContent('admin');
    } else if (searchTerm === 'reservar') {
        loadContent('reserve');
    } else if (searchTerm === 'disponibilidad') {
        loadContent('availability');
    } else {
        contentArea.innerHTML = `<h2>No se encontraron resultados para "${searchTerm}"</h2>`;
    }
}

function openLoginModal() {
    console.log('Abriendo modal de inicio de sesión...');
}

function toggleDropdown() {
    const dropdownContent = document.getElementById("dropdownContent");
    dropdownContent.style.display = dropdownContent.style.display === "block" ? "none" : "block";
}

function loadContent(type) {
    const contentArea = document.getElementById('contentArea');
    
    switch(type) {
        case 'student':
            contentArea.innerHTML = '<h2>Contenido para Alumnos</h2>';
            break;
        case 'teacher':
            contentArea.innerHTML = '<h2>Contenido para Docentes</h2>';
            break;
        case 'admin':
            contentArea.innerHTML = '<h2>Contenido para Administradores</h2>';
            break;
        default:
            contentArea.innerHTML = '<h2>Seleccione una opción válida</h2>';
    }
}
