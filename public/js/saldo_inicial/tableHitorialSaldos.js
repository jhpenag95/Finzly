// Variables globales para la paginación del historial
let datosCompletosHistorial = [];
let paginaActualHistorial = 1;
let registrosPorPaginaHistorial = 5; // Valor predeterminado
let mostrarTodosHistorial = false;

$(document).ready(function () {
    // Inicializar la tabla al cargar la página
    // Configurar el event listener del selector desde el inicio
    $('#registros-select_historial').on('change', function () {
        const valor = $(this).val();

        if (valor === 'all') {
            mostrarTodosHistorial = true;
            registrosPorPaginaHistorial = datosCompletosHistorial.length || 1; // Garantiza una única página incluso si aún no hay datos
        } else {
            mostrarTodosHistorial = false;
            registrosPorPaginaHistorial = parseInt(valor);
        }

        paginaActualHistorial = 1; // Volver a la primera página
        renderizarPagina_historial(paginaActualHistorial);
        crearControlesPaginacion_historial();
    });
});

//verRegistros relacionados a un saldo inicial -  tabla history
function verRegistro_historial(id) {
    $('#id_concepto_historial').val(id);
    $.ajax({
        url: '/saldo_inicial_historico/historial/buscar/' + id,
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {

            // Limpiar el contenido actual de la tabla
            $('#historial-tbody').empty();
            $('#loading-spinner_historial').hide();
            $('#verHistorialModal').show();


            if (response.historial.length > 0) {
                datosCompletosHistorial = response.historial;

                // Actualizar la opción "Todos" con el total real de registros
                $('#registros-select_historial option[value="all"]').text(`Todos (${datosCompletosHistorial.length})`);

                // Si actualmente está seleccionada la opción "Todos", sincronizar registrosPorPagina
                if ($('#registros-select_historial').val() === 'all' || mostrarTodosHistorial) {
                    mostrarTodosHistorial = true;
                    registrosPorPaginaHistorial = datosCompletosHistorial.length || 1;
                }

                paginaActualHistorial = 1; // Volver a la primera página
                renderizarPagina_historial(paginaActualHistorial);
                crearControlesPaginacion_historial();

            } else {
                $('#historial-tbody').html(`    
                    <tr>
                        <td colspan="4" class="text-center">No hay datos disponibles</td>
                    </tr>
                `);
                $('#pagination-controls').hide();
            }
        },
        error: function (xhr, status, error) {
            $('#loading-spinner_historial').hide();
            $('#historial-table').hide();
            $('#historial-tbody').html(`
                <tr>
                    <td colspan="4" class="text-center">Error al cargar el historial. Por favor, intenta de nuevo.</td>
                </tr>
            `);
            $('#pagination-controls').hide();
        }
    });

}

function renderizarPagina_historial(pagina) {
    const inicio = (pagina - 1) * registrosPorPaginaHistorial;
    const fin = inicio + registrosPorPaginaHistorial;
    const datosPagina = datosCompletosHistorial.slice(inicio, fin);

    // Limpiar el tbody
    $('#historial-tbody').empty();

    // Agregar filas de la página actual
    datosPagina.forEach(function (item) {
        let fila = `
            <tr style="text-align: center;">
                <td>${item.concepto}</td>   
                <td>$ ${parseFloat(item.monto).toLocaleString('es-CL', { minimumFractionDigits: 2 })}</td>
                <td>$ ${parseFloat(item.monto_anterior).toLocaleString('es-CL', { minimumFractionDigits: 2 })}</td>
                <td>${item.descripcion}</td>
                <td>${formatearFecha(item.fecha_registro)}</td>
                <td>${item.tipo_movimiento}</td>
                <td class="concepto-acciones">
                    <div class="action-buttons">
                        <button class="btn-action btn-delete" title="Eliminar concepto" onclick="eliminarHistorial('${item.id_movimiento}')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
        $('#historial-tbody').append(fila);
    });
    paginaActualHistorial = pagina;
    actualizarControlesPaginacion_historial();
}

function crearControlesPaginacion_historial() {
    const totalPaginas = Math.ceil(datosCompletosHistorial.length / registrosPorPaginaHistorial);

    // Siempre mostrar los controles cuando hay datos
    if (datosCompletosHistorial.length > 0) {
        $('#pagination-controls_historial').show();
        actualizarControlesPaginacion_historial();
    } else {
        $('#pagination-controls_historial').hide();
    }
}

function actualizarControlesPaginacion_historial() {
    const totalPaginas = mostrarTodosHistorial ? 1 : Math.ceil(datosCompletosHistorial.length / registrosPorPaginaHistorial); // Calcular total de páginas basado en la visibilidad     

    let paginacionHTML = ''; // Inicializar HTML de paginación

    paginacionHTML += '<div class="pagination-buttons">';

    // Solo mostrar botones de navegación si hay más de una página
    if (totalPaginas > 1) {
        // Botón Anterior
        paginacionHTML += `
            <button class="page-btn" id="btn-anterior" ${paginaActualHistorial === 1 ? 'disabled' : ''}>
                ‹ Anterior
            </button>
        `;

        // Números de página
        for (let i = 1; i <= totalPaginas; i++) {
            // Mostrar solo páginas cercanas a la actual (máximo 5 botones)
            if (i === 1 || i === totalPaginas || (i >= paginaActualHistorial - 1 && i <= paginaActualHistorial + 1)) {
                paginacionHTML += `
                    <button class="page-btn ${i === paginaActualHistorial ? 'active' : ''}" data-page="${i}">
                        ${i}
                    </button>
                `;
            } else if (i === paginaActualHistorial - 2 || i === paginaActualHistorial + 2) {
                paginacionHTML += `<span class="page-dots">...</span>`;
            }
        }

        // Botón Siguiente
        paginacionHTML += `
            <button class="page-btn" id="btn-siguiente" ${paginaActualHistorial === totalPaginas ? 'disabled' : ''}>
                Siguiente ›
            </button>
        `;
    }

    paginacionHTML += '</div>'; // Cerrar pagination-buttons


    // Información de registros
    let inicio, fin;
    if (datosCompletosHistorial.length === 0) {
        inicio = 0;
        fin = 0;
    } else if (mostrarTodosHistorial) {
        inicio = 1;
        fin = datosCompletosHistorial.length;
    } else {
        inicio = (paginaActualHistorial - 1) * registrosPorPaginaHistorial + 1;
        fin = Math.min(paginaActualHistorial * registrosPorPaginaHistorial, datosCompletosHistorial.length);
    }
    paginacionHTML += `
        <span class="page-info_historial">
            Mostrando ${inicio}-${fin} de ${datosCompletosHistorial.length} registros
        </span>
    `;

    $('#pagination-controls_historial').html(paginacionHTML);


    // Event listeners para los botones de página
    $('.page-btn[data-page]').on('click', function () {
        const pagina = parseInt($(this).data('page'));
        renderizarPagina_historial(pagina);
    });

    $('#btn-anterior_historial').on('click', function () {
        if (paginaActualHistorial > 1) {
            renderizarPagina_historial(paginaActualHistorial - 1);
        }
    });

    $('#btn-siguiente_historial').on('click', function () {
        const totalPaginas = Math.ceil(datosCompletosHistorial.length / registrosPorPaginaHistorial);
        if (paginaActualHistorial < totalPaginas) {
            renderizarPagina_historial(paginaActualHistorial + 1);
        }
    });
}

function closeModal_historial() {
    $('#verHistorialModal').hide();
}

// Función para eliminar un historial de saldo inicial
function eliminarHistorial(id) {
    var modal = $("#confirmDeleteModal");
    modal.css("display", "flex");

    var id_movimiento = $('#id_concepto_historial').val();

    // Remover cualquier evento anterior y asignar el nuevo
    $('#confirmDelete').off('click').on('click', function () {
        confirmarDeleteHistorial(id, id_movimiento);
    });

}

confirmarDeleteHistorial = function (id, id_movimiento) {

    var modal = $("#confirmDeleteModal");
    modal.css("display", "none");

    // Enviar solicitud al servidor para eliminar el historial
    $.ajax({
        url: '/saldo_inicial_historico/historial/eliminar/' + id,
        type: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                // Mostrar mensaje de éxito
                showAlert.success(
                    'Eliminación Exitosa',
                    'El historial ha sido eliminado correctamente.',
                    {
                        duration: 4000,
                        animation: 'slide'
                    }
                );

                verRegistro_historial(id_movimiento);

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

