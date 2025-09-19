// Funciones para modal de editar categoría
function openModal(e = null) {
    if (e) e.preventDefault();
    document.getElementById('category-modal').style.display = 'flex';
}

function closeModal(e = null) {
    if (e) e.preventDefault();
    document.getElementById('category-modal').style.display = 'none';
}

function showIconsGrid() {
    document.getElementById('icons-grid').style.display = 'grid';
}

// Funciones para modal de crear categoría
function openCreateModal(e = null) {
    if (e) e.preventDefault();
    // Limpiar formulario
    document.getElementById('create-category-name-input').value = '';
    document.getElementById('create-category-color-input').value = '#3498db';
    document.getElementById('create-category-icon').value = 'fa-bolt';
    document.getElementById('create-selected-icon-preview').className = 'fas fa-bolt';
    document.getElementById('create-icons-grid').style.display = 'none';
    // Mostrar modal
    document.getElementById('create-category-modal').style.display = 'flex';
}

function closeCreateModal(e = null) {
    if (e) e.preventDefault();
    document.getElementById('create-category-modal').style.display = 'none';
}

function showCreateIconsGrid() {
    document.getElementById('create-icons-grid').style.display = 'grid';
}

// Agregar eventos a las opciones de íconos
document.addEventListener("DOMContentLoaded", () => {
    // Eventos para modal de editar
    const iconOptions = document.querySelectorAll("#icons-grid .icon-option");
    const selectedPreview = document.getElementById("selected-icon-preview");
    const hiddenInput = document.getElementById("category-icon");
    const grid = document.getElementById("icons-grid");

    iconOptions.forEach(option => {
        option.addEventListener("click", () => {
            // Obtener el nombre del ícono seleccionado
            const icon = option.getAttribute("data-icon");

            // Actualizar preview
            if (selectedPreview) {
                selectedPreview.className = "fas " + icon;
            }

            // Actualizar el input hidden
            if (hiddenInput) {
                hiddenInput.value = icon;
            }

            // Ocultar la grilla después de seleccionar
            if (grid) {
                grid.style.display = "none";
            }
        });
    });

    // Eventos para modal de crear
    const createIconOptions = document.querySelectorAll("#create-icons-grid .icon-option");
    const createSelectedPreview = document.getElementById("create-selected-icon-preview");
    const createHiddenInput = document.getElementById("create-category-icon");
    const createGrid = document.getElementById("create-icons-grid");

    createIconOptions.forEach(option => {
        option.addEventListener("click", () => {
            // Obtener el nombre del ícono seleccionado
            const icon = option.getAttribute("data-icon");

            // Actualizar preview
            if (createSelectedPreview) {
                createSelectedPreview.className = "fas " + icon;
            }

            // Actualizar el input hidden
            if (createHiddenInput) {
                createHiddenInput.value = icon;
            }

            // Ocultar la grilla después de seleccionar
            if (createGrid) {
                createGrid.style.display = "none";
            }
        });
    });

    // Evento para el botón de crear categoría
    const createSaveBtn = document.getElementById("create-save-category");
    if (createSaveBtn) {
        createSaveBtn.addEventListener("click", (e) => {
            e.preventDefault();
            
            // Obtener valores del formulario
            const name = document.getElementById("create-category-name-input").value.trim();
            const color = document.getElementById("create-category-color-input").value;
            const icon = document.getElementById("create-category-icon").value;
            
            // Validar que el nombre no esté vacío
            if (!name) {
                alert("Por favor, ingresa un nombre para la categoría.");
                return;
            }
            
            // Aquí puedes agregar la lógica para guardar la categoría
            console.log("Nueva categoría:", { name, color, icon });
            
            // Cerrar modal después de crear
            closeCreateModal();
            
            // Mostrar mensaje de éxito (opcional)
            alert("Categoría creada exitosamente!");
        });
    }
});