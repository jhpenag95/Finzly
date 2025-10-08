let datosCompletosPago = [];
let paginaActualPago = 1;
let registrosPorPaginaPago = 5; // Valor por defecto
let mostrarTodosPago = false; // Controla si se muestran todos los registros en una sola página

$(document).ready(function () {
    // Inicializar la tabla al cargar la página
    // Configurar el event listener del selector desde el inicio
    $('#registros-select_pago').on('change', function () {
        const valor = $(this).val();

        if (valor === 'all') {
            mostrarTodosPago = true;
            registrosPorPaginaPago = datosCompletosPago.length || 1; // Garantiza una única página incluso si aún no hay datos
        } else {
            mostrarTodosPago = false;
            registrosPorPaginaPago = parseInt(valor);
        }

        paginaActualPago = 1; // Volver a la primera página
        renderizarPagina_pago(paginaActualPago);
        crearControlesPaginacion_pago();
    });

    // Consultar pagos al cargar la página
    consultarListadoPagos();
});


// Función para consultar el listado de pagos
function consultarListadoPagos() {
    $('#loading-spinner_pago').show();
    $('#pagos-table').hide();

    // Realizar la solicitud AJAX para obtener el listado de pagos
    $.ajax({
        url: '/pagos/obtener',
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            // console.log(response);
            $('#loading-spinner_pago').hide();
            $('#pagos-table').show();

            if (response.pagos.length > 0) {
                datosCompletosPago = response.pagos;

                // Actualizar la opción "Todos" con el total real de registros
                $('#registros-select_pago option[value="all"]').text(`Todos (${datosCompletosPago.length})`);

                // Si actualmente está seleccionada la opción "Todos", sincronizar registrosPorPagina
                if ($('#registros-select_pago').val() === 'all' || mostrarTodosPago) {
                    mostrarTodosPago = true;
                    registrosPorPaginaPago = datosCompletosPago.length || 1;
                }

                paginaActualPago = 1; // Volver a la primera página
                renderizarPagina_pago(paginaActualPago);
                crearControlesPaginacion_pago();

            } else {
                $('#pagos-tbody').html(`
                    <tr>
                        <td colspan="4" class="text-center">No hay datos disponibles</td>
                    </tr>
                `);
                $('#pagination-controls_pago').hide();
            }
        },
        error: function (xhr, status, error) {
            $('#loading-spinner_pago').hide();
            $('#pagos-table').hide();
            $('#saldos-tbody').html(`
                <tr>
                    <td colspan="4" class="text-center">Error al cargar los pagos. Por favor, intenta de nuevo.</td>
                </tr>
            `);
            $('#pagination-controls_pago').hide();
        }
    });
}

// Función para renderizar una página de pagos
function renderizarPagina_pago(pagina) {
    const inicio = (pagina - 1) * registrosPorPaginaPago;
    const fin = inicio + registrosPorPaginaPago;
    const datosPagina = datosCompletosPago.slice(inicio, fin);

    // Limpiar el tbody
    $('#pagos-tbody').empty();

    // Agregar filas de la página actual
    datosPagina.forEach(function (item) {
        let fila = `
            <tr style="text-align: center;">
                <td class="cont-pago">
                    <span class="textnamepago" style="display:block;margin-bottom:6px;">${item.nombre_pg}</span>
                    <span class="textserv">${item.nombre_cat}</span>
                </td>
                <td>
                    <span style="color: #2f487c;">
                        $${parseFloat(item.monto_pg).toLocaleString('es-CL', { minimumFractionDigits: 2 })}
                    </span>
                </td>
                <td>${formatearFecha(item.fecha_pg)}</td>
                <td><span style="padding: 4px 8px; border-radius: 12px; background-color: #e6f7ff; color: #1890ff; font-size: 10px;">${item.repetcion_pg}</span></td>
                <td>${item.nombre_mp}</td>
                <td>${getStatusBadge(item.nombre_sp)}</td>
                <td class="pago-acciones">
                    <div class="action-buttons">
                        <button class="btn-action btn-complete" title="Marcar como completado" onclick="completarpago('${item.id_pagos}')">
                            <i class="fas fa-check" style="color: #fff;"></i>
                        </button>
                        <button class="btn-action btn-edit" title="Editar pago" onclick="editarpago('${item.id_pagos}')">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-action btn-delete" title="Eliminar pago" onclick="eliminarpago('${item.id_pagos}')">
                                <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
        $('#pagos-tbody').append(fila);
    });
    paginaActualPago = pagina;
    actualizarControlesPaginacion_pago();
}

// Función para crear los controles de paginación
function crearControlesPaginacion_pago() {
    const totalPaginas = Math.ceil(datosCompletosPago.length / registrosPorPaginaPago);

    // Siempre mostrar los controles cuando hay datos
    if (datosCompletosPago.length > 0) {
        $('#pagination-controls_pago').show();
        actualizarControlesPaginacion_pago();
    } else {
        $('#pagination-controls_pago').hide();
    }
}

// Función para actualizar los controles de paginación
function actualizarControlesPaginacion_pago() {
    const totalPaginas = mostrarTodosPago ? 1 : Math.ceil(datosCompletosPago.length / registrosPorPaginaPago); // Calcular total de páginas basado en la visibilidad        

    let paginacionHTML = ''; // Inicializar HTML de paginación

    paginacionHTML += '<div class="pagination-buttons">';

    // Solo mostrar botones de navegación si hay más de una página
    if (totalPaginas > 1) {
        // Botón Anterior
        paginacionHTML += `
            <button class="page-btn_pago" id="btn-anterior_pago" ${paginaActualPago === 1 ? 'disabled' : ''}>
                ‹ Anterior
            </button>
        `;

        // Números de página
        for (let i = 1; i <= totalPaginas; i++) {
            // Mostrar solo páginas cercanas a la actual (máximo 5 botones)
            if (i === 1 || i === totalPaginas || (i >= paginaActualmetodopago - 1 && i <= paginaActualmetodopago + 1)) {
                paginacionHTML += `
                    <button class="page-btn_pago page-number ${i === paginaActualPago ? 'active' : ''}" data-page="${i}">
                        ${i}
                    </button>
                `;
            } else if (i === paginaActualPago - 2 || i === paginaActualPago + 2) {
                paginacionHTML += `<span class="page-dots_pago">...</span>`;
            }
        }

        // Botón Siguiente
        paginacionHTML += `
            <button class="page-btn_pago" id="btn-siguiente_pago" ${paginaActualPago === totalPaginas ? 'disabled' : ''}>
                Siguiente ›
            </button>
        `;
    }

    paginacionHTML += '</div>'; // Cerrar pagination-buttons


    // Información de registros
    let inicio, fin;
    if (datosCompletosPago.length === 0) {
        inicio = 0;
        fin = 0;
    } else if (mostrarTodosPago) {
        inicio = 1;
        fin = datosCompletosPago.length;
    } else {
        inicio = (paginaActualPago - 1) * registrosPorPaginaPago + 1;
        fin = Math.min(paginaActualPago * registrosPorPaginaPago, datosCompletosPago.length);
    }
    paginacionHTML += `
        <span class="page-info_pago">
            Mostrando ${inicio}-${fin} de ${datosCompletosPago.length} registros
        </span>
    `;

    $('#pagination-controls_pago').html(paginacionHTML);


    // Event listeners para los botones de página
    $('#pagination-controls_pago .page-btn_pago[data-page]').on('click', function () {
        const pagina = parseInt($(this).data('page'));
        renderizarPagina_pago(pagina);
    });

    // Event listener para el botón Anterior
    $('#btn-anterior_pago').on('click', function () {
        if (paginaActualPago > 1) {
            renderizarPagina_pago(paginaActualPago - 1);
        }
    });

    // Event listener para el botón Siguiente
    $('#btn-siguiente_pago').on('click', function () {
        const totalPaginas = Math.ceil(datosCompletosPago.length / registrosPorPaginaPago);
        if (paginaActualPago < totalPaginas) {
            renderizarPagina_pago(paginaActualPago + 1);
        }
    });
}


// Función para eliminar un pago de saldo inicial
function eliminarpago(id) {
    var modal = $("#confirmDeleteModal");
    modal.css("display", "flex");

    // Remover cualquier evento anterior y asignar el nuevo
    $('#confirmDelete').off('click').on('click', function () {
        confirmarDeletepago(id);
    });

}

// Función para editar un pago
function editarpago(id) {
    // Ocultar el modal de confirmación de eliminación
    $('.addEditpago').css('display', 'flex').addClass('show');

    // Obtener los datos del pago por ID y mostrarlos en el modal
    $.ajax({
        url: '/pagos/consulta/' + id,
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                // Llenar el formulario con los datos del pago
                $('#editarPago_nombre').val(response.pago.nombre_pag);
                $('#editarEstatus_pago').val(response.pago.estatus_pag === 'Activo' ? 'Activo' : 'Inactivo');
                // Guardar el ID del pago en el formulario para usarlo en la actualización
                $('#editarPago_id').val(id);
            } else {
                // Mostrar mensaje de error
                showAlert.error(
                    'Error',
                    'Hubo un error al obtener los datos del pago',
                    {
                        duration: 4000,
                        animation: 'slide'
                    }
                );
            }
        }
    });
}

// Función para actualizar un pago
function actualizarpago() {

    // Obtener el ID del pago del formulario
    let id = $('#editarPago_id').val().trim();
    let nombre = $('#editarPago_nombre').val().trim();
    let estatus = $('#editarEstatus_pago').val().trim();

    console.log("nombre:", nombre);
    console.log("estatus:", estatus);

    if (nombre === '' || estatus === '') {
        if (nombre === '') $('#editarPago_nombre').css('border-color', 'var(--border-color-required)');
        if (estatus === '') $('#editarEstatus_pago').css('border-color', 'var(--border-color-required)');

        showAlert.error('Error', 'Por favor, complete todos los campos.', {
            duration: 4000,
            animation: 'slide'
        });
        return;
    }

    $("#confirmEditModal").css("display", "flex");
    $('#confirmEditBtn').off('click').on('click', function () {
        confirmarEditpago(id);
    });
}


//cambiar el color si el campo es llenado
$('#editarPago_nombre, #editarEstatus_pago').on('input change', function () {
    if ($(this).val() !== '') {
        $(this).css('border-color', 'var(--border-color-valid)');
    }
});

// Cerrar el modal de edición
function closeModalEdit() {
    $('.addEditpago').hide();
    $('#editarPago_nombre').css('border-color', 'var(--border-color)');
    $('#editarEstatus_pago').css('border-color', 'var(--border-color)');
}



// Función para confirmar la eliminación de un pago
function confirmarDeletepago(id) {

    var modal = $("#confirmDeleteModal");
    modal.css("display", "none");

    // Enviar solicitud al servidor para eliminar el pago
    $.ajax({
        url: '/pagos/eliminar/' + id,
        type: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                // Mostrar mensaje de éxito
                showAlert.success(
                    'Eliminación Exitosa',
                    'El metodopago ha sido eliminado correctamente.',
                    {
                        duration: 4000,
                        animation: 'slide'
                    }
                );

                // Recargar la tabla con el listado actualizado
                consultarListadopagos();
            } else {
                // Mostrar mensaje de error
                showAlert.error(
                    'Error',
                    'Hubo un error al eliminar el registro',
                    {
                        duration: 4000,
                        animation: 'slide'
                    }
                );
            }
        }
    });
}

// Función para confirmar la actualización de un pago
function confirmarEditpago(id) {
    var modal = $("#confirmEditModal");
    modal.css("display", "none");

    // Obtener los datos del formulario
    var pago = $('#editarPago_nombre').val();
    var estatus = $('#editarEstatus_pago').val();

    // Enviar solicitud al servidor para actualizar el pago
    $.ajax({
        url: '/pagos/editar/' + id,
        type: 'PUT',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            pago: pago,
            estatus: estatus
        },
        success: function (response) {
            if (response.success) {
                // Mostrar mensaje de éxito
                showAlert.success(
                    'Actualización Exitosa',
                    'El pago ha sido actualizado correctamente.',
                    {
                        duration: 4000,
                        animation: 'slide'
                    }
                );
                // Cerrar el modal de confirmación
                closeModalEdit();
                // Recargar la tabla con el listado actualizado
                consultarListadopagos();
            } else {
                // Mostrar mensaje de error
                showAlert.error(
                    'Error',
                    'Hubo un error al actualizar el registro',
                    {
                        duration: 4000,
                        animation: 'slide'
                    }
                );
            }
        }
    });
}

