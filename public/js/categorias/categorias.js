// Funciones para modal de editar categoría - setea los datos en el modal
function openModal(categoryId) {
    // Primero obtener los datos de la categoría
    $.ajax({
        url: '/categorias/obtener',
        type: 'GET',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                // Buscar la categoría específica
                const categoria = response.data.find(cat => cat.id_categoria == categoryId);
                if (categoria) {
                    // Llenar los campos del modal de edición
                    $('#category-name-input').val(categoria.nombre_cat);
                    $('#category-color-input').val(categoria.color_cat);
                    $('#category-icon').val(categoria.icono_cat);
                    $('#selected-icon-preview').attr('class', `fas ${categoria.icono_cat}`);
                    
                    // Remover eventos anteriores y asignar el nuevo con el ID correcto
                    $('#save-category').off('click').on('click', function(e) {
                        e.preventDefault();
                        saveCategory(categoryId);
                    });
                    
                    // Mostrar el modal
                    var modal = $("#category-modal");
                    modal.addClass("show");
                } else {
                    showAlert.error('Error', 'No se pudo encontrar la categoría.');
                }
            } else {
                showAlert.error('Error', 'No se pudo cargar los datos de la categoría.');
            }
        },
        error: function () {
            showAlert.error('Error', 'No se pudo cargar los datos de la categoría.');
        }
    });
}

function closeModal(e) {
    if (e) e.preventDefault();
    var modal = $("#category-modal");
    modal.removeClass("show");
}

function showIconsGrid() {
    $('#icons-grid').css('display', 'grid');
}

// Funciones para modal de crear categoría
function openCreateModal() {
    var modal = $("#create-category-modal");
    // Limpiar formulario
    $('#create-category-name-input').val('');
    $('#create-category-color-input').val('#3498db');
    $('#create-category-icon').val('fa-bolt');
    $('#create-selected-icon-preview').attr('class', 'fas fa-bolt');
    $('#create-icons-grid').css('display', 'none');
    // Mostrar modal
    modal.addClass("show");
}

function closeCreateModal(e) {
    if (e) e.preventDefault();
    var modal = $("#create-category-modal");
    modal.removeClass("show");
}

function showCreateIconsGrid() {
    $('#create-icons-grid').css('display', 'grid');
}

// Agregar eventos a las opciones de íconos
$(document).ready(() => {
    obtenerCategorias();

    // Event listeners para selección de íconos en modal de CREAR categoría
    $(document).on('click', '#create-icons-grid .icon-option', function (e) {
        e.preventDefault();
        const selectedIcon = $(this).data('icon');

        // Actualizar el ícono preview
        $('#create-selected-icon-preview').attr('class', `fas ${selectedIcon}`);

        // Actualizar el valor del input hidden
        $('#create-category-icon').val(selectedIcon);

        // Ocultar la grilla de íconos
        $('#create-icons-grid').css('display', 'none');
    });

    // Event listeners para selección de íconos en modal de EDITAR categoría
    $(document).on('click', '#icons-grid .icon-option', function (e) {
        e.preventDefault();
        const selectedIcon = $(this).data('icon');

        // Actualizar el ícono preview
        $('#selected-icon-preview').attr('class', `fas ${selectedIcon}`);

        // Actualizar el valor del input hidden
        $('#category-icon').val(selectedIcon);

        // Ocultar la grilla de íconos
        $('#icons-grid').css('display', 'none');
    });

    // Evento para el botón de crear categoría
    $('#create-save-category').on('click', function (e) {
        e.preventDefault();

        // Obtener valores del formulario
        var name = $('#create-category-name-input').val().trim();
        var color = $('#create-category-color-input').val();
        var icon = $('#create-category-icon').val();

        if (!name) {
            showAlert.error('Error', 'Por favor, ingresa un nombre para la categoría.');
            $('#create-category-name-input').css('border-color', 'var(--border-color-required)');
            return;
        }

        if (!color) {
            showAlert.error('Error', 'Por favor, selecciona un color para la categoría.');
            return;
        }

        if (!icon) {
            showAlert.error('Error', 'Por favor, selecciona un ícono para la categoría.');
            return;
        }


        var datos = {
            nombre_categoria: name,
            color_categoria: color,
            icono_categoria: icon,
        };

        $.ajax({
            url: '/categorias/registrar',
            type: 'POST',
            data: datos,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    showAlert.success('Success', 'Categoría creada exitosamente.');
                    obtenerCategorias(); // Actualizar la lista de categorías
                    closeCreateModal();
                } else {
                    showAlert.error('Error', 'No se pudo crear la categoría.');
                }
            },
            error: function () {
                showAlert.error('Error', 'No se pudo crear la categoría.');
            }
        });

        // Cerrar modal después de crear
        closeCreateModal();

    });
});

// Validar nombre de categoría en crear
function validateCreateCategoryName() {
    $('#create-category-name-input').css('border-color', 'var(--border-color-valid)');
}

// Validar color de categoría en crear
function validateCreateCategoryColor() {
    $('#create-category-color-input').css('border-color', 'var(--border-color-valid)');
}

// Obtener el liustado de categorías
function obtenerCategorias() {
    $.ajax({
        url: '/categorias/obtener',
        type: 'GET',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                // Llenar la lista de categorías
                $('.categories-list').empty();
                if (response.data.length > 0) {
                    response.data.forEach(categoria => {
                        $('.categories-list').append(`
                            <div class="category-item">
                                <div class="category-color" style="background-color: ${categoria.color_cat}"></div>
                                <div class="category-name">${categoria.nombre_cat}</div>
                                <div class="category-icon">
                                    <i class="fas ${categoria.icono_cat}"></i>
                                </div>
                                <div class="category-actions">
                                    <button type="button" class="edit-category" onclick="openModal('${categoria.id_categoria}')">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="delete-category" onclick="confirmDeleteCategory('${categoria.id_categoria}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        `);
                    });
                } else {
                    $('.categories-list').append(`
                        <div class="category-item">
                            <div class="no-categories">
                                <p>No hay categorías registradas. Agrega tu primera categoría usando el botón de abajo.</p>
                            </div>
                        </div>
                    `);
                }
            } else {
                showAlert.error('Error', 'No se pudo consultar las categorias.');
            }
        },
        error: function () {
            showAlert.error('Error', 'No se pudo consultar las categorias.');
        }
    });
}

// Guardar cambios en categoría - Editar
function saveCategory(categoryId) {
    var name = $('#category-name-input').val();
    var color = $('#category-color-input').val();
    var icon = $('#category-icon').val();

    if (!name) {
        showAlert.error('Error', 'Por favor, ingresa un nombre para la categoría.');
        return;
    }

    if (!color) {
        showAlert.error('Error', 'Por favor, ingresa un color para la categoría.');
        return;
    }

    if (!icon) {
        showAlert.error('Error', 'Por favor, ingresa un icono para la categoría.');
        return;
    }

    var data = {
        id_categoria: categoryId,
        nombre_cat: name,
        color_cat: color,
        icono_cat: icon,
    };

    $.ajax({
        url: `/categorias/editar`,
        type: 'POST',
        data: data,
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                showAlert.success('Success', 'Categoría guardada exitosamente.');
                obtenerCategorias(); // Actualizar la lista de categorías
                closeModal(); // Cerrar el modal después de guardar
            } else {
                showAlert.error('Error', 'No se pudo guardar la categoría.');
            }
        },
        error: function () {
            showAlert.error('Error', 'No se pudo guardar la categoría.');
        }
    });
}

// muestra el mal de condirmación para eliminar registro
function confirmDeleteCategory(categoryId) {
    var modal = $("#confirmDeleteModal");
    modal.css("display", "flex");

    // Remover cualquier evento anterior y asignar el nuevo
    $('#confirmDelete').off('click').on('click', function () {
        confirmDelete(categoryId);
    });
}

function closeDeleteModal() {
    var modal = $("#confirmDeleteModal");
    modal.css("display", "none");
}

// Eliminar categoría
function confirmDelete(categoryId) {
    var modal = $("#confirmDeleteModal");

    modal.css("display", "none");

    var data = {
        id_categoria: categoryId,
    };


    $.ajax({
        url: `/categorias/eliminar`,
        type: 'DELETE',
        data: data,
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                showAlert.success('Success', 'Categoría eliminada exitosamente.');
                obtenerCategorias(); // Actualizar la lista de categorías
            } else {
                showAlert.error('Error', 'No se pudo eliminar la categoría.');
            }
        },
        error: function () {
            showAlert.error('Error', 'No se pudo eliminar la categoría.');
        }
    });
}


